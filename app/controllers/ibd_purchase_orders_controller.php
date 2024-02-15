<?php

require "Utility.php";
class IbdPurchaseOrdersController extends AppController {

	var $name = 'IbdPurchaseOrders';
	var $model= 'IbdPurchaseOrder';
	var $table_name = 'ibd_purchase_orders';
	
	function index() {
	}
	

	function search() {
	}

	function search_local() {
   		$this->loadModel('CurrencyType');
		$po=$this->IbdPurchaseOrder->find("list",array('fields'=>array('IbdPurchaseOrder.PURCHASE_ORDER_NO')));
		$fcy_account=$this->IbdPurchaseOrder->query('select distinct FROM_THEIR_FCY_ACCOUNT from ibd_purchase_orders');

		$currencies=$this->CurrencyType->find("list");
		$curr=array();
        foreach($currencies as $c){
        $curr[$c]=$c;
		}

		$acct=array();
        foreach($fcy_account as $c){
        $acct[$c['ibd_purchase_orders']['FROM_THEIR_FCY_ACCOUNT']]=$c['ibd_purchase_orders']['FROM_THEIR_FCY_ACCOUNT'];
		}


		$pos=array();
        foreach($po as $p){
        	$pos[$p]=$p;
		}

		$this->set('po',$pos);
		$this->set('currencies',$currencies);
		$this->set('fcy_account',$acct);
	}
	
	function list_data($id = null) {
		$start = (isset($_REQUEST['start'])) ? $_REQUEST['start'] : 0;
		$limit = (isset($_REQUEST['limit'])) ? $_REQUEST['limit'] : 5;
        $conditions = (isset($_REQUEST['conditions'])) ? $_REQUEST['conditions'] : '';

        eval("\$conditions = array( " . $conditions . " );");
		
		$this->set('ibd_purchase_orders', $this->IbdPurchaseOrder->find('all', array('conditions' => $conditions, 'limit' => $limit, 'offset' => $start)));
		$this->set('results', $this->IbdPurchaseOrder->find('count', array('conditions' => $conditions)));
	}

	function view($id = null) {
		if (!$id) {
			$this->Session->setFlash(__('Invalid ibd purchase order', true));
			$this->redirect(array('action' => 'index'));
		}
		$this->IbdPurchaseOrder->recursive = 2;
		$this->set('ibdPurchaseOrder', $this->IbdPurchaseOrder->read(null, $id));
	}

	function add($id = null) {
		$this->loadModel('CurrencyType');
		$year=date('Y');
		$dt=date('Y-m-d');
		if (!empty($this->data)) {
			$this->IbdPurchaseOrder->create();
			$this->autoRender = false;
          
			$this->data['IbdPurchaseOrder']['PURCHASE_ORDER_NO']=$this->get_next_no($year,4);
			$this->data['IbdPurchaseOrder']['cr_by']=$this->Session->read('Auth.User.username');
			$this->data['IbdPurchaseOrder']['CAD_PAYABLE_IN_BIRR']=round($this->data['IbdPurchaseOrder']['CAD_PAYABLE_IN_BIRR'],4);
			$this->data['IbdPurchaseOrder']['REM_CAD_PAYABLE_IN_BIRR']=round($this->data['IbdPurchaseOrder']['REM_CAD_PAYABLE_IN_BIRR'],4);
			if ($this->IbdPurchaseOrder->save($this->data)) {
				$this->update_next_no($year,4);


				Utility::Log($this->data['IbdPurchaseOrder']['PURCHASE_ORDER_NO'],$this->Session->read('Auth.User.username'),'ADD',$dt);
				$this->Session->setFlash(__('The ibd purchase order has been saved', true), '');
				$this->render('/elements/success');
			} else {
				$this->Session->setFlash(__('The ibd purchase order could not be saved. Please, try again.', true), '');
				$this->render('/elements/failure');
			}
		}

		$currencies=$this->CurrencyType->find("list");
		$curr=array();
        foreach($currencies as $c){
        $curr[$c]=$c;
		}
		
		$po=$this->get_next_no($year,4);
		$this->set('currencies',$currencies);
		$this->set('po',$po);
	}


	function add_c($id = null){

		try{
        $this->loadModel('CurrencyType');
        $this->loadModel('IbdSettelment');
		if(!empty($this->data)){

			


			

			$dt=date('Y-m-d');
			$refno=$this->data['IbdPurchaseOrder']['PURCHASE_ORDER_NO'];
			$FCY_AMOUNT=$this->data['IbdPurchaseOrder']['SETT_FCY'];
			$p=$this->IbdPurchaseOrder->query("SELECT * FROM ibd_purchase_orders where PURCHASE_ORDER_NO='$refno'");

			$rate=$p[0]['ibd_purchase_orders']['RATE'];
                        if($rate==null){$rate=0;}


			 $fcy_rem=$p[0]['ibd_purchase_orders']['REM_FCY_AMOUNT'];
                $birr_rem=$p[0]['ibd_purchase_orders']['REM_CAD_PAYABLE_IN_BIRR'];

		 $birr=$FCY_AMOUNT*$rate;

                          
			$birr=round($birr,4);
$query="INSERT INTO ibd_settelments (reference,`date`,fcy_amount,rate,lcy_amount) values('$refno','$dt',$FCY_AMOUNT,$rate,$birr)";
//var_dump($query);die();

			if($this->IbdSettelment->query($query)){

				$last=$this->IbdSettelment->query("select last_insert_id() as id");
				$idd=$last[0][0]['id'];
                



				 $cmd1="UPDATE ibd_purchase_orders set REM_FCY_AMOUNT=REM_FCY_AMOUNT-$FCY_AMOUNT,REM_CAD_PAYABLE_IN_BIRR=REM_CAD_PAYABLE_IN_BIRR-$birr where PURCHASE_ORDER_NO='$refno'";

              //&& $birr_rem>=$birr
                if( $fcy_rem>=$FCY_AMOUNT ){
                 $this->IbdPurchaseOrder->query($cmd1);

                 Utility::Log($refno,$this->Session->read('Auth.User.username'),'CANCELLATION',$dt);

                 $this->Session->setFlash(__('Cancellation is saved', true), '');
				 $this->render('/elements/success');

                   }else{

                   	$cmd="DELETE FROM ibd_settelments WHERE id=$idd";
                    $this->IbdPurchaseOrder->query($cmd);
                
				    $this->Session->setFlash(__('Insufficient Balance', true), '');
				    $this->render('/elements/success');

                   }





			}else{
				$this->Session->setFlash(__('Cancellation failed.', true), '');
				$this->render('/elements/failure');
			}


		

		}

	
        
         $id=str_replace("<","/",$id);

        $po=$this->IbdPurchaseOrder->find("list",array('fields' => array('IbdPurchaseOrder.PURCHASE_ORDER_NO'),'conditions'=>array('AND'=> array('IbdPurchaseOrder.REM_FCY_AMOUNT>0',"IbdPurchaseOrder.PURCHASE_ORDER_NO"=>"$id"))));
		$pos=array();
        foreach($po as $p){
        	$pos[$p]=$p;
		}
		$this->set('purchase',$pos);

		}catch(Exception $e){
			$this->Session->setFlash(__('Cancellation failed with enternal error', true), '');
				$this->render('/elements/failure');
		}
	}

	function edit($id = null, $parent_id = null) {
		$this->loadModel('CurrencyType');
		$dt=date('Y-m-d');
		if (!$id && empty($this->data)) {
			$this->Session->setFlash(__('Invalid ibd purchase order', true), '');
			$this->redirect(array('action' => 'index'));
		}
		if (!empty($this->data)) {
			$this->autoRender = false;

			$this->data['IbdPurchaseOrder']['edit_by']=$this->Session->read('Auth.User.username');
			if ($this->IbdPurchaseOrder->save($this->data)) {
				Utility::Log($this->data['IbdPurchaseOrder']['PURCHASE_ORDER_NO'],$this->Session->read('Auth.User.username'),'EDIT',$dt);
				$this->Session->setFlash(__('The ibd purchase order has been saved', true), '');
				$this->render('/elements/success');
			} else {
				$this->Session->setFlash(__('The ibd purchase order could not be saved. Please, try again.', true), '');
				$this->render('/elements/failure');
			}
		}
		$this->set('ibd_purchase_order', $this->IbdPurchaseOrder->read(null, $id));


		$currencies=$this->CurrencyType->find("list");
		$curr=array();
        foreach($currencies as $c){
        $curr[$c]=$c;
		}

		$this->set('currencies',$currencies);
		
			
	}

	function delete($id = null) {
		$this->autoRender = false;
		if (!$id) {
			$this->Session->setFlash(__('Invalid id for ibd purchase order', true), '');
			$this->render('/elements/failure');
		}
		if (stripos($id, '_') !== false) {
            $ids = explode('_', $id);
            try{
                foreach ($ids as $i) {
                    $this->IbdPurchaseOrder->delete($i);
                }
				$this->Session->setFlash(__('Ibd purchase order deleted', true), '');
				$this->render('/elements/success');
            }
            catch (Exception $e){
				$this->Session->setFlash(__('Ibd purchase order was not deleted', true), '');
				$this->render('/elements/failure');
            }
        } else {
            if ($this->IbdPurchaseOrder->delete($id)) {
				$this->Session->setFlash(__('Ibd purchase order deleted', true), '');
				$this->render('/elements/success');
			} else {
				$this->Session->setFlash(__('Ibd purchase order was not deleted', true), '');
				$this->render('/elements/failure');
			}
        }
	}

	function addsettelment($id = null) {
		
		if (!empty($this->data)){
			$this->IbdPurchaseOrder->create();
			$this->autoRender = false;
			if ($this->IbdPurchaseOrder->save($this->data)) {
				$this->Session->setFlash(__('The ibd purchase order has been saved', true), '');
				$this->render('/elements/success');
			}else{
				$this->Session->setFlash(__('The ibd purchase order could not be saved. Please, try again.', true), '');
				$this->render('/elements/failure');
			}
		}
		if($id) {
		$this->set('parent_id', $id);
		}

	}

	function get_next_no($year,$id){
		$year=date("Y");
		$this->LoadModel('IbdNextNo');
		$cmd="SELECT next_no from ibd_next_nos WHERE year=$year and doc_id=$id";
		$no=$this->IbdNextNo->query($cmd);

		date_default_timezone_set("Africa/Addis_Ababa");  
	
		return 'TRS/PO/'.str_pad(($no[0]['ibd_next_nos']['next_no']), 3,'0',STR_PAD_LEFT).'/'.$year;
	}
	function update_next_no($year,$id){
		$this->LoadModel('IbdNextNo');
		$cmd="UPDATE  ibd_next_nos SET next_no=1+next_no WHERE year=$year and doc_id=$id";
		$no=$this->IbdNextNo->query($cmd);

	}

	function export(){
     $this->autoRender = false;

     
     $json_like_string=$_SESSION["export_data"];
    
	
	  //$json=json_decode($json_like_string);

     if($_SESSION["sent_data"]=="OK"){
     	 Utility::export($json_like_string,$this->table_name,null);
     	}else{
     		 Utility::export($json_like_string,$this->table_name,$this->model);
     	}

     
	}
		
	function set_data(){
		 $this->autoRender = false;
		
		

		 if($_POST['sent']=='false'){
		 	$_SESSION["sent_data"]="OK";
     	 $json_like_string=$_POST['o'];
     	$json_like_string=json_decode($json_like_string);
     	}else{
     		$_SESSION["sent_data"]="NO";
     $json_like_string=$this->IbdPurchaseOrder->find('all');

    }

		 $_SESSION["export_data"]=$json_like_string;//$_POST['o'];
	    // var_dump($_POST['o']);die();
	}

	function get_po_importer($reference=null){
		 $this->autoRender = false;
	$reference=str_replace("(","/", $reference);
      $cmd="SELECT *  FROM  ibd_purchase_orders WHERE PURCHASE_ORDER_NO='$reference'";
      $result=$this->IbdPurchaseOrder->query($cmd);
    
      echo json_encode($result);
	}

}
?>