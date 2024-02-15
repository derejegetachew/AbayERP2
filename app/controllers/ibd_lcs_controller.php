<?php

include_once("Utility.php");
class IbdLcsController extends AppController {

	var $name = 'IbdLcs';
	var $model = 'IbdLc';
	var $table_name = 'ibd_lcs';
	
	function index() {
		$currency_types = $this->IbdLc->CurrencyType->find('all');
		$this->set(compact('currency_types'));
	}
	
	function index2($id = null) {
		$this->set('parent_id', $id);
	}

	function search() {
	}

	function search_local() {
   		$this->loadModel('CurrencyType');
   		$this->loadModel('IbdBank');
		$po=$this->IbdLc->find("list",array('fields'=>array('IbdLc.LC_REF_NO')));
		$permit=$this->IbdLc->find("list",array('fields'=>array('IbdLc.PERMIT_NO')));
		

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

		$permis=array();
        foreach($permit as $p){
        	$permis[$p]=$p;
		}

		$this->set('po',$pos);
		$this->set('permits',$permis);
		$this->set('currencies',$currencies);
		$this->set('bank',$bb);
	}
	
	function list_data($id = null) {
		$start = (isset($_REQUEST['start'])) ? $_REQUEST['start'] : 0;
		$limit = (isset($_REQUEST['limit'])) ? $_REQUEST['limit'] : 5;
		$currencytype_id = (isset($_REQUEST['currencytype_id'])) ? $_REQUEST['currencytype_id'] : -1;
		if($id)
			$currencytype_id = ($id) ? $id : -1;
        $conditions = (isset($_REQUEST['conditions'])) ? $_REQUEST['conditions'] : '';

        eval("\$conditions = array( " . $conditions . " );");
		if ($currencytype_id != -1) {
            $conditions['IbdLc.currencytype_id'] = $currencytype_id;
        }
		
		$this->set('ibd_lcs', $this->IbdLc->find('all', array('conditions' => $conditions, 'limit' => $limit, 'offset' => $start)));
		$this->set('results', $this->IbdLc->find('count', array('conditions' => $conditions)));
	}

	function view($id = null) {
		if (!$id) {
			$this->Session->setFlash(__('Invalid ibd lc', true));
			$this->redirect(array('action' => 'index'));
		}
		$this->IbdLc->recursive = 2;
		$this->set('ibdLc', $this->IbdLc->read(null, $id));
	}

	function add($id = null) {
		$this->LoadModel('IbdImportPermit');
		$this->loadModel('IbdBank');
		$year=date('Y');
		$dt=date('Y-m-d');
		if (!empty($this->data)) {
			$this->IbdLc->create();
			$this->autoRender = false;
			$this->data['IbdLc']['LC_REF_NO']=$this->get_next_no($year,5);
			$this->data['IbdLc']['cr_by']=$this->Session->read('Auth.User.username');
			if ($this->IbdLc->save($this->data)) {
				$this->update_next_no($year,5);

			

				Utility::Log($this->data['IbdLc']['LC_REF_NO'],$this->Session->read('Auth.User.username'),'ADD',$dt);
				$this->Session->setFlash(__('The ibd lc has been saved', true), '');
				$this->render('/elements/success');
			} else {
				$this->Session->setFlash(__('The ibd lc could not be saved. Please, try again.', true), '');
				$this->render('/elements/failure');
			}
		}
		if($id)
			$this->set('parent_id', $id);
		$currency_types = $this->IbdLc->CurrencyType->find('list');
		$this->set(compact('currency_types'));

		$ps=$this->IbdImportPermit->query("SELECT IMPORT_PERMIT_NO FROM ibd_import_permits");
		$banks=$this->IbdBank->find("list");

		$pe= array();
		$str="";
         $i=false;
		foreach ($ps as $k => $v) {
           if($i){
           	$str.=',';
           }

			$str.='[\''. $v['ibd_import_permits']['IMPORT_PERMIT_NO'].'\']';
			//var_dump();
			//die();
			$i=true;
		}


		$bank=array();
        foreach($banks as $b){
        $bank[$b]=$b;
		}
           
		$permit=$this->get_next_no($year,5);

		$this->set('lc_no',$permit);
		$this->set('permits',$str);
		$this->set('banks',$bank);

	}

	function add_c($id = null){

		  $this->loadModel('CurrencyType');
		    $this->loadModel('IbdSettelment');
		if(!empty($this->data)){

			$dt=date('Y-m-d');
			$refno=$this->data['IbdLc']['LC_REF_NO'];
			$FCY_AMOUNT=$this->data['IbdLc']['SETT_FCY'];
			$p=$this->IbdLc->query("SELECT * FROM ibd_lcs where LC_REF_NO='$refno'");
			$rate=$p[0]['ibd_lcs']['OPENING_RATE'];

			 $fcy_rem=$p[0]['ibd_lcs']['OUT_FCY_AMOUNT'];
                $birr_rem=$p[0]['ibd_lcs']['OUT_BIRR_VALUE'];
                 $margin=$p[0]['ibd_lcs']['OUT_Margin_Amt'];

			$birr=$FCY_AMOUNT*$rate;
			$birr=round($birr,4);

			if($this->IbdSettelment->query("INSERT INTO ibd_settelments (reference,`date`,fcy_amount,rate,lcy_amount,ibc_no,margin_amount) VALUES('$refno','$dt',$FCY_AMOUNT,$rate,$birr,'Cancellation',$margin)")){

				$last=$this->IbdSettelment->query("select last_insert_id() as id");
				
				$idd=$last[0][0]['id'];




				 $cmd1="UPDATE ibd_lcs set OUT_FCY_AMOUNT=OUT_FCY_AMOUNT-$FCY_AMOUNT,OUT_BIRR_VALUE=OUT_BIRR_VALUE-$birr,OUT_Margin_Amt=0 where LC_REF_NO='$refno'";

              
                if( $fcy_rem>=$FCY_AMOUNT && $birr_rem>=$birr){
                 $this->IbdLc->query($cmd1);

                 Utility::Log($refno,$this->Session->read('Auth.User.username'),'CANCELLATION',$dt);

                 $this->Session->setFlash(__('Cancellation is saved', true), '');
				 $this->render('/elements/success');

                   }else{

                   	$cmd="DELETE FROM ibd_settelments WHERE id=$idd";
                    $this->IbdIbc->query($cmd);
                  
				    $this->Session->setFlash(__('Insufficient Balance', true), '');
				    $this->render('/elements/success');

                   }





			}else{
				$this->Session->setFlash(__('Cancellation failed.', true), '');
				$this->render('/elements/failure');
			}

		}

	
        
         $id=str_replace("<","/",$id);

        $po=$this->IbdLc->find("list",array('fields' => array('IbdLc.LC_REF_NO'),'conditions'=>array('AND'=> array('IbdLc.OUT_FCY_AMOUNT>0',"IbdLc.LC_REF_NO"=>"$id"))));
		$pos=array();
        foreach($po as $p){
        	$pos[$p]=$p;
		}
		$this->set('purchase',$pos);
	}

	function edit($id = null, $parent_id = null) {
	$this->loadModel('IbdBank');
	$dt=date('Y-m-d');
		if (!$id && empty($this->data)) {
			$this->Session->setFlash(__('Invalid ibd lc', true), '');
			$this->redirect(array('action' => 'index'));
		}
		if (!empty($this->data)) {
			$this->autoRender = false;
			$this->data['IbdLc']['edit_by']=$this->Session->read('Auth.User.username');
			if ($this->IbdLc->save($this->data)) {
				Utility::Log($this->data['IbdLc']['LC_REF_NO'],$this->Session->read('Auth.User.username'),'EDIT',$dt);
				$this->Session->setFlash(__('The ibd lc has been saved', true), '');
				$this->render('/elements/success');
			} else {
				$this->Session->setFlash(__('The ibd lc could not be saved. Please, try again.', true), '');
				$this->render('/elements/failure');
			}
		}
		$this->set('ibd_lc', $this->IbdLc->read(null, $id));
		$banks=$this->IbdBank->find("list");
		
		if($parent_id) {
			$this->set('parent_id', $parent_id);
		}
		
		$bank=array();
        foreach($banks as $b){
        $bank[$b]=$b;
		}
			
		$currency_types = $this->IbdLc->CurrencyType->find('list');
		$this->set(compact('currency_types'));
		$this->set('banks',$bank);
	}

	function delete($id = null) {
		$this->autoRender = false;
		if (!$id) {
			$this->Session->setFlash(__('Invalid id for ibd lc', true), '');
			$this->render('/elements/failure');
		}
		if (stripos($id, '_') !== false) {
            $ids = explode('_', $id);
            try{
                foreach ($ids as $i) {
                    $this->IbdLc->delete($i);
                }
				$this->Session->setFlash(__('Ibd lc deleted', true), '');
				$this->render('/elements/success');
            }
            catch (Exception $e){
				$this->Session->setFlash(__('Ibd lc was not deleted', true), '');
				$this->render('/elements/failure');
            }
        } else {
            if ($this->IbdLc->delete($id)) {
				$this->Session->setFlash(__('Ibd lc deleted', true), '');
				$this->render('/elements/success');
			} else {
				$this->Session->setFlash(__('Ibd lc was not deleted', true), '');
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
	

		return 'TRS/LC/'.str_pad(($no[0]['ibd_next_nos']['next_no']), 3,'0',STR_PAD_LEFT).'/'.$year;
	}
	function update_next_no($year,$id){
		$this->LoadModel('IbdNextNo');
		$cmd="UPDATE  ibd_next_nos SET next_no=1+next_no WHERE year=$year and doc_id=$id";
		$no=$this->IbdNextNo->query($cmd);

	}
	function get_permit_detail($permit=null){

		$this->autoRender = false;
		$this->LoadModel('IbdImportPermit');
		$permit=str_replace("(", "/", $permit);
		 $cmd="SELECT *  FROM ibd_import_permits as tbl WHERE  IMPORT_PERMIT_NO='$permit'";
      $result=$this->IbdImportPermit->query($cmd);
    
      echo json_encode($result);
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
     $json_like_string=$this->IbdLc->find('all');

    }

		 $_SESSION["export_data"]=$json_like_string;//$_POST['o'];
	     //var_dump($_POST['o']);die();
	}

	function get_lc_detail($reference=null){
		 $this->autoRender = false;
	$reference=str_replace("(","/", $reference);
      $cmd="SELECT *  FROM  ibd_lcs WHERE LC_REF_NO='$reference'";
      $result=$this->IbdLc->query($cmd);
    
      echo json_encode($result);
	}


}
?>