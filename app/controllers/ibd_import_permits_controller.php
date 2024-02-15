<?php

require "Utility.php";

class IbdImportPermitsController extends AppController {

	var $name = 'IbdImportPermits';
	var $model = 'IbdImportPermit';
	var $table_name = 'ibd_import_permits';
	
	function index() {
	}
	

	function search() {
	}

	function search_local() {
   		$this->loadModel('CurrencyType');
		$po=$this->IbdImportPermit->find("list",array('fields'=>array('IbdImportPermit.IMPORT_PERMIT_NO')));
		$fcy_account=$this->IbdImportPermit->query('select distinct FROM_THEIR_FCY_ACCOUNT from ibd_import_permits');

		$currencies=$this->CurrencyType->find("list");
		$curr=array();
        foreach($currencies as $c){
        $curr[$c]=$c;
		}

		$acct=array();
        foreach($fcy_account as $c){
        $acct[$c['ibd_import_permits']['FROM_THEIR_FCY_ACCOUNT']]=$c['ibd_import_permits']['FROM_THEIR_FCY_ACCOUNT'];
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
		
		$this->set('ibd_import_permits', $this->IbdImportPermit->find('all', array('conditions' => $conditions, 'limit' => $limit, 'offset' => $start)));
		$this->set('results', $this->IbdImportPermit->find('count', array('conditions' => $conditions)));
	}

	function view($id = null) {
		if (!$id) {
			$this->Session->setFlash(__('Invalid ibd import permit', true));
			$this->redirect(array('action' => 'index'));
		}
		$this->IbdImportPermit->recursive = 2;
		$this->set('ibdImportPermit', $this->IbdImportPermit->read(null, $id));
	}

	function add($id = null) {
		$this->loadModel('CurrencyType');
		$this->loadModel('PaymentTerm');
		$this->loadModel('PaymentTerm');
		$year=date('Y');
			$dt=date('Y-m-d');
		if (!empty($this->data)) {
			$this->IbdImportPermit->create();
			$this->autoRender = false;
			$this->data['IbdImportPermit']['IMPORT_PERMIT_NO']=$this->get_next_no($year,2);
			$this->data['IbdImportPermit']['cr_by']=$this->Session->read('Auth.User.username');
			if ($this->IbdImportPermit->save($this->data)) {
				$this->update_next_no($year,2);

			
				
				Utility::Log($this->data['IbdImportPermit']['IMPORT_PERMIT_NO'],$this->Session->read('Auth.User.username'),'ADD',$dt);
				$this->Session->setFlash(__('The ibd import permit has been saved', true), '');
				$this->render('/elements/success');
			} else {
				$this->Session->setFlash(__('The ibd import permit could not be saved. Please, try again.', true), '');
				$this->render('/elements/failure');
			}
		}

		
		$currency=$this->CurrencyType->find("list");
		$curr=array();
        foreach($currency as $c){
        $curr[$c]=$c;
		}

		$payment_terms=$this->PaymentTerm->find("list");
		$pay=array();
        foreach($payment_terms as $c){
        $pay[$c]=$c;
		}
		
		$permit=$this->get_next_no($year,2);

		$this->set('payment_terms',$pay);
		$this->set('currencies',$curr);
		$this->set('permit',$permit);
	}

	function edit($id = null, $parent_id = null) {
		$this->loadModel('CurrencyType');
		$this->loadModel('PaymentTerm');
		$dt=date('Y-m-d');
		if (!$id && empty($this->data)) {
			$this->Session->setFlash(__('Invalid ibd import permit', true), '');
			$this->redirect(array('action' => 'index'));
		}
		if (!empty($this->data)) {
			$this->autoRender = false;
			$this->data['IbdImportPermit']['edit_by']=$this->Session->read('Auth.User.username');
			if ($this->IbdImportPermit->save($this->data)) {
				Utility::Log($this->data['IbdImportPermit']['IMPORT_PERMIT_NO'],$this->Session->read('Auth.User.username'),'EDIT',$dt);
				$this->Session->setFlash(__('The ibd import permit has been saved', true), '');
				$this->render('/elements/success');
			} else {
				$this->Session->setFlash(__('The ibd import permit could not be saved. Please, try again.', true), '');
				$this->render('/elements/failure');
			}
		}
		$this->set('ibd_import_permit', $this->IbdImportPermit->read(null, $id));
		
		$currency=$this->CurrencyType->find("list");
		$curr=array();
        foreach($currency as $c){
        $curr[$c]=$c;
		}

		$payment_terms=$this->PaymentTerm->find("list");
		$pay=array();
        foreach($payment_terms as $c){
        $pay[$c]=$c;
		}
		
		$permit=$this->get_next_no(2019,2);

		$this->set('payment_terms',$pay);
		$this->set('currencies',$curr);
	}

	function delete($id = null) {
		$this->autoRender = false;
		if (!$id) {
			$this->Session->setFlash(__('Invalid id for ibd import permit', true), '');
			$this->render('/elements/failure');
		}
		if (stripos($id, '_') !== false) {
            $ids = explode('_', $id);
            try{
                foreach ($ids as $i) {
                    $this->IbdImportPermit->delete($i);
                }
				$this->Session->setFlash(__('Ibd import permit deleted', true), '');
				$this->render('/elements/success');
            }
            catch (Exception $e){
				$this->Session->setFlash(__('Ibd import permit was not deleted', true), '');
				$this->render('/elements/failure');
            }
        } else {
            if ($this->IbdImportPermit->delete($id)) {
				$this->Session->setFlash(__('Ibd import permit deleted', true), '');
				$this->render('/elements/success');
			} else {
				$this->Session->setFlash(__('Ibd import permit was not deleted', true), '');
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
	

		return 'ABBTRS01'.''.str_pad(($no[0]['ibd_next_nos']['next_no']), 5,'0',STR_PAD_LEFT).''.$year;
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

	function export_old($ob=null){

		$this->autoRender = false;
		$json_like_string=$_GET['ob'];
		$json=json_decode($json_like_string);
		$result_array=array();
		
		try{
			header("Content-Type: text/csv;charset=utf-8");
			header('Content-disposition: attachment; filename=Performance.csv');
			
			$output=fopen("php://output", "w");
			  // if plan is for all months.
           $values=$this->getTableColumns($this->table_name);
          
			fputcsv($output, $values);
             foreach ($json as $item => $j){
                 $arr=(array)$j;
                foreach ($values as $k => $v) {
                	if(isset($arr[$v])){
                	if($arr[$v]!=null)
                		$result_array[]=$arr[$v];
                	else
                		$result_array[]="";
                   }else{
                   	$result_array[]="";
                   }
                }
             	
		    fputcsv($output, $result_array);
			   $result_array=array();
			 }
			
			fclose($output);
			exit();

		}catch(Exception $e){

		}
		
	}

function getTableColumns($tableName=null){
   $values= array();
   $cmd=" select COLUMN_NAME from information_schema.COLUMNS WHERE TABLE_SCHEMA='hr' AND TABLE_NAME='$tableName';";
   $result=$this->IbdImportPermit->query($cmd);
   
   foreach ($result as $key => $value) {
   $values[]=$value['COLUMNS']['COLUMN_NAME'];
   }
   return $values;
}

function set_data(){
		 $this->autoRender = false;
		

		   if($_POST['sent']=='false'){
		 	$_SESSION["sent_data"]="OK";
     	 $json_like_string=$_POST['o'];
     	$json_like_string=json_decode($json_like_string);
     	}else{
     		$_SESSION["sent_data"]="NO";
     $json_like_string=$this->IbdImportPermit->find('all');

    }

		 $_SESSION["export_data"]=$json_like_string;//$_POST['o'];
	     //var_dump($_POST['o']);die();


	}
	  
}
?>