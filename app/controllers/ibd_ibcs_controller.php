<?php


require "Utility.php";

class IbdIbcsController extends AppController {

	var $name = 'IbdIbcs';
	var $model = 'IbdIbc';
	var $table_name = 'ibd_ibcs';
	
	function index() {
	}
	

	function search() {
	}

	function search_local() {
   		$this->loadModel('CurrencyType');
   		$this->loadModel('IbdBank');
		$po=$this->IbdIbc->find("list",array('fields'=>array('IbdIbc.PURCHASE_ORDER_NO')));
		$ibc=$this->IbdIbc->find("list",array('fields'=>array('IbdIbc.IBC_REFERENCE')));
		

		$currencies=$this->CurrencyType->find("list");
		$curr=array();
        foreach($currencies as $c){
        $curr[$c]=$c;
		}

		$banks=$this->IbdBank->find("list");
  	    $bb=array();
        foreach($banks as $c){
        $bb[$c]=$c;
		}

		


		$pos=array();
        foreach($po as $p){
        	$pos[$p]=$p;
		}

		$ibcs=array();
        foreach($ibc as $p){
        	$ibcs[$p]=$p;
		}

		$this->set('po',$pos);
		$this->set('ibcs',$ibcs);
		$this->set('currencies',$currencies);
		$this->set('bank',$bb);
	}

	
	function list_data($id = null) {
		$start = (isset($_REQUEST['start'])) ? $_REQUEST['start'] : 0;
		$limit = (isset($_REQUEST['limit'])) ? $_REQUEST['limit'] : 5;
        $conditions = (isset($_REQUEST['conditions'])) ? $_REQUEST['conditions'] : '';

        eval("\$conditions = array( " . $conditions . " );");
		
		$this->set('ibd_ibcs', $this->IbdIbc->find('all', array('conditions' => $conditions, 'limit' => $limit, 'offset' => $start)));
		$this->set('results', $this->IbdIbc->find('count', array('conditions' => $conditions)));
	}

	function view($id = null) {
		if (!$id) {
			$this->Session->setFlash(__('Invalid ibd ibc', true));
			$this->redirect(array('action' => 'index'));
		}
		$this->IbdIbc->recursive = 2;
		$this->set('ibd_ibcs', $this->IbdIbc->read(null, $id));
	}

	function add($id = null) {
		$this->loadModel('CurrencyType');
		$this->loadModel('IbdPurchaseOrder');
		$this->loadModel('IbdBank');
		$year=date('Y');
		$dt=date('Y-m-d');
		if (!empty($this->data)) {
			$this->IbdIbc->create();
			$this->autoRender = false;
            //$this->data['REM_FCY_AMOUNT']=100;
           // $this->data['REM_CAD_PAYABLE_IN_BIRR']=1000;
           // var_dump($this->data);die();
   				$this->data['IbdIbc']['IBC_REFERENCE']=$this->get_next_no($year,6);
   				$this->data['IbdIbc']['cr_by']=$this->Session->read('Auth.User.username');
   				$full_ibc=isset($this->data['IbdIbc']['full_ibc'])?true:false;
   				$this->data['IbdIbc']['po_updated']=$full_ibc;

   				//var_dump($this->data);
			if ($this->IbdIbc->save($this->data)) {
				

				
				
				Utility::Log($this->data['IbdIbc']['IBC_REFERENCE'],$this->Session->read('Auth.User.username'),'ADD',$dt);

				if($full_ibc){


                $idd=$this->IbdIbc->getLastInsertID();
                $po_no=$this->data['IbdIbc']['PURCHASE_ORDER_NO'];
                $p=$this->IbdPurchaseOrder->query("SELECT * FROM ibd_purchase_orders where PURCHASE_ORDER_NO='$po_no'");
    			

                $current_settelment_fcy=$this->data['IbdIbc']['SETT_FCY'];
				$current_settelment_birr=$this->data['IbdIbc']['SETT_Amount'];
                $percent=$this->data['IbdIbc']['percent'];
                $rate=$p[0]['ibd_purchase_orders']['RATE'];
               // $current_settelment_birr= $current_settelment_fcy * $rate;
			   $current_settelment_birr=floatval($current_settelment_birr);
                $current_settelment_birr=round($current_settelment_birr,4);

                $fcy_rem=$p[0]['ibd_purchase_orders']['REM_FCY_AMOUNT'];
                $birr_rem=$p[0]['ibd_purchase_orders']['REM_CAD_PAYABLE_IN_BIRR'];
                $fcy=$p[0]['ibd_purchase_orders']['FCY_AMOUNT'];
                $IMPORTER_NAME=$p[0]['ibd_purchase_orders']['NAME_OF_IMPORTER'];
                 $currency=$p[0]['ibd_purchase_orders']['currency_id'];


                $current_remaining_fcy=$fcy_rem-$current_settelment_fcy;
                //$current_settelment_birr=($current_settelment_birr*$percent)/100;
               // $current_remaining_birr= ($rate*$current_remaining_fcy);
                
                $current_remaining_birr= $birr_rem-$current_settelment_birr;
				$current_remaining_birr=round($current_remaining_birr,4);

                $cmd="UPDATE ibd_ibcs SET NAME_OF_IMPORTER='$IMPORTER_NAME', SETT_amount=$current_settelment_birr, REM_FCY_AMOUNT=$current_remaining_fcy,REM_CAD_PAYABLE_IN_BIRR=$current_remaining_birr,currency_id='$currency' where id=$idd";


                $this->IbdIbc->query($cmd);


                  
                $cmd1="UPDATE ibd_purchase_orders set REM_FCY_AMOUNT=$current_remaining_fcy,REM_CAD_PAYABLE_IN_BIRR=$current_remaining_birr where PURCHASE_ORDER_NO='$po_no'";

              
                if($current_remaining_fcy>=0 && $current_remaining_birr>=0){
                 $this->IbdPurchaseOrder->query($cmd1);

                   $this->update_next_no($year,6);
                 $this->Session->setFlash(__('The ibd ibc has been saved', true), '');
				 $this->render('/elements/success');

                   }else{

                   	$cmd="DELETE FROM ibd_ibcs WHERE id=$idd";
                    $this->IbdIbc->query($cmd);
                // var_dump($current_remaining_birr);  var_dump($birr_rem);   var_dump($current_settelment_birr);die();
				    $this->Session->setFlash(__('Insufficient Balance', true), '');
				    $this->render('/elements/failure');

                   }



}else{
$this->update_next_no($year,6);
 $this->Session->setFlash(__('The ibd ibc has been saved', true), '');
				 $this->render('/elements/success');
				}
				
				
			} else {
				$this->Session->setFlash(__('The ibd ibc could not be saved. Please, try again.', true), '');
				$this->render('/elements/failure');
			}
		}

		$currency=$this->CurrencyType->find("list");
		$banks=$this->IbdBank->find("list");
		$po=$this->IbdPurchaseOrder->find("list",array('fields' => array('IbdPurchaseOrder.PURCHASE_ORDER_NO')));
		//$po=$this->IbdPurchaseOrder->query("SELECT PURCHASE_ORDER_NO FROM ibd_purchase_orders order by id desc");


		
		$curr=array();
        foreach($currency as $c){
        $curr[$c]=$c;
		}

		$bank=array();
        foreach($banks as $b){
        $bank[$b]=$b;
		}

		$pos=array();
        foreach($po as $p){
        	$pos[$p]=$p;
		}
     
		$permit=$this->get_next_no($year,6);
 //$permit="TRS/IBC/000/2019";
		//var_dump($curr);var_dump($pos);die();
		$this->set('currencies',$curr);
		$this->set('purchase',$pos);
		$this->set('ibc_no',$permit);
		$this->set('banks',$bank);
	}

	function edit($id = null, $parent_id = null) {
		$this->loadModel('CurrencyType');
			$dt=date('Y-m-d');
		if (!$id && empty($this->data)) {
			$this->Session->setFlash(__('Invalid ibd ibc', true), '');
			$this->redirect(array('action' => 'index'));
		}
		if (!empty($this->data)) {
			$this->autoRender = false;
				$this->data['IbdIbc']['edit_by']=$this->Session->read('Auth.User.username');
			if ($this->IbdIbc->save($this->data)) {
				Utility::Log($this->data['IbdIbc']['IBC_REFERENCE'],$this->Session->read('Auth.User.username'),'EDIT',$dt);
				$this->Session->setFlash(__('The ibd ibc has been saved', true), '');
				$this->render('/elements/success');
			} else {
				$this->Session->setFlash(__('The ibd ibc could not be saved. Please, try again.', true), '');
				$this->render('/elements/failure');
			}
		}

		$currency=$this->CurrencyType->find("list");
		$curr=array();
        foreach($currency as $c){
        $curr[$c]=$c;
		}


		$this->set('ibd_ibc', $this->IbdIbc->read(null, $id));
		$this->set('currencies',$curr);
		
			
	}

	function delete($id = null) {
		$this->autoRender = false;
		if (!$id) {
			$this->Session->setFlash(__('Invalid id for ibd ibc', true), '');
			$this->render('/elements/failure');
		}
		if (stripos($id, '_') !== false) {
            $ids = explode('_', $id);
            try{
                foreach ($ids as $i) {
                    $this->IbdIbc->delete($i);
                }
				$this->Session->setFlash(__('Ibd ibc deleted', true), '');
				$this->render('/elements/success');
            }
            catch (Exception $e){
				$this->Session->setFlash(__('Ibd ibc was not deleted', true), '');
				$this->render('/elements/failure');
            }
        } else {
            if ($this->IbdIbc->delete($id)) {
				$this->Session->setFlash(__('Ibd ibc deleted', true), '');
				$this->render('/elements/success');
			} else {
				$this->Session->setFlash(__('Ibd ibc was not deleted', true), '');
				$this->render('/elements/failure');
			}
        }
	}
	function get_next_no($year,$id){
		$year=date("Y");
		$this->LoadModel('IbdNextNo');
		$cmd="SELECT next_no from ibd_next_nos WHERE year=$year and doc_id=$id";
		$no=$this->IbdNextNo->query($cmd);

		date_default_timezone_set("Africa/Addis_Ababa");  
	

		return 'TRS/IBC/'.str_pad(($no[0]['ibd_next_nos']['next_no']),3,'0',STR_PAD_LEFT).'/'.$year;
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
            $json_like_string=$this->IbdIbc->find('all');
        }
 
		 $_SESSION["export_data"]=$json_like_string;//$_POST['o'];
	     //var_dump($_POST['o']);die();

	}

	function update_po($ibc_no=null){
		$this->loadModel('IbdBank');
		$this->loadModel('IbdPurchaseOrder');

		$ibc_no=str_replace("<", "/", $ibc_no);

		if (!empty($this->data)) {

		$this->autoRender = false;
		$ibc_no=$this->data['IbdIbc']['IBC_REFERENCE'];
		$ibc=$this->IbdIbc->find('all',array('conditions'=>array('IbdIbc.IBC_REFERENCE'=>$ibc_no)));
		
		$po=$ibc[0]['IbdIbc']['PURCHASE_ORDER_NO'];
		$fcy=$ibc[0]['IbdIbc']['SETT_FCY'];
		$birr=$ibc[0]['IbdIbc']['SETT_Amount'];

		 $cmd="UPDATE ibd_purchase_orders set REM_FCY_AMOUNT=REM_FCY_AMOUNT-$fcy,REM_CAD_PAYABLE_IN_BIRR=REM_CAD_PAYABLE_IN_BIRR-$birr where PURCHASE_ORDER_NO='$po'";


		$val= $this->IbdIbc->query($cmd);

		if($val){
			$PERMIT_NO=$this->data['IbdIbc']['PERMIT_NO'];
			$REMITTING_BANK=$this->data['IbdIbc']['REMITTING_BANK'];
			$REIBURSING_BANK=$this->data['IbdIbc']['REIBURSING_BANK'];
			$FCY_APPROVAL_INITIAL_NO=$this->data['IbdIbc']['FCY_APPROVAL_INITIAL_NO'];
			$cmd="UPDATE ibd_ibcs SET po_updated=1,PERMIT_NO='$PERMIT_NO',REMITTING_BANK='$REMITTING_BANK',REIBURSING_BANK='$REIBURSING_BANK',FCY_APPROVAL_INITIAL_NO='$FCY_APPROVAL_INITIAL_NO' WHERE  IBC_REFERENCE='$ibc_no'";
			 $this->IbdIbc->query($cmd);
		  	$this->Session->setFlash(__('The ibd ibc has been saved', true), '');
			$this->render('/elements/success');
		}
	}

	$banks=$this->IbdBank->find("list");
	$po=$this->IbdPurchaseOrder->find("list",array('fields' => array('IbdPurchaseOrder.PURCHASE_ORDER_NO')));


	$ibcs=$this->IbdIbc->find('all',array('conditions'=>array('IbdIbc.IBC_REFERENCE'=>$ibc_no)));
	//var_dump($ibcs);die();

	$pos=array();
        foreach($po as $p){
        	$pos[$p]=$p;
		}


	$bank=array();
        foreach($banks as $b){
        $bank[$b]=$b;
		}

	$this->set('banks',$bank);
	$this->set('purchase',$pos);
	$this->set('ibc_no',$ibc_no);
	$this->set('ibcs',$ibcs);


}

}
?>