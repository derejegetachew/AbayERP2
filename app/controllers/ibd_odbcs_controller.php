<?php

require "Utility.php";

class IbdOdbcsController extends AppController {

	var $name = 'IbdOdbcs';
	var $doc_no=13;
	var $model= 'IbdOdbc';
	var $table_name = 'ibd_odbcs';

	function index() {
		  $this->IbdOdbc->recursive = 1;
		$payment_terms = $this->IbdOdbc->PaymentTerm->find('all');
		$this->set(compact('payment_terms'));
	}
	
	function index2($id = null) {
		$this->set('parent_id', $id);
	}

	function search() {
	}

		function search_local() {
   		$this->loadModel('CurrencyType');
		$po=$this->IbdOdbc->find("list",array('fields'=>array('IbdOdbc.Doc_Ref')));
		$Permit_No=$this->IbdOdbc->find("list",array('fields'=>array('IbdOdbc.Permit_No')));
		$NBE_Permit_no=$this->IbdOdbc->find("list",array('fields'=>array('IbdOdbc.NBE_Permit_no')));
	

		$currencies=$this->CurrencyType->find("list");
		$curr=array();
        foreach($currencies as $c){
        $curr[$c]=$c;
		}

		$pos=array();
        foreach($po as $p){
        	$pos[$p]=$p;
		}

		$Permit_Nos=array();
        foreach($Permit_No as $p){
        	$Permit_Nos[$p]=$p;
		}

		$NBE_Permit_nos=array();
        foreach($NBE_Permit_no as $p){
        	$NBE_Permit_nos[$p]=$p;
		}

		$this->set('po',$pos);
		$this->set('currencies',$currencies);
		$this->set('Permit_Nos',$Permit_Nos);
		$this->set('NBE_Permit_nos',$NBE_Permit_nos);
	}
	
	function list_data($id = null) {
		 $this->IbdOdbc->recursive = 0;
		$start = (isset($_REQUEST['start'])) ? $_REQUEST['start'] : 0;
		$limit = (isset($_REQUEST['limit'])) ? $_REQUEST['limit'] : 5;
		$paymentterm_id = (isset($_REQUEST['paymentterm_id'])) ? $_REQUEST['paymentterm_id'] : -1;
		if($id)
			$paymentterm_id = ($id) ? $id : -1;
        $conditions = (isset($_REQUEST['conditions'])) ? $_REQUEST['conditions'] : '';

        eval("\$conditions = array( " . $conditions . " );");
		if ($paymentterm_id != -1) {
            $conditions['IbdOdbc.paymentterm_id'] = $paymentterm_id;
        }
		
		$this->set('ibd_odbcs', $this->IbdOdbc->find('all', array('conditions' => $conditions, 'limit' => $limit, 'offset' => $start)));
		$this->set('results', $this->IbdOdbc->find('count', array('conditions' => $conditions)));
	}

	function view($id = null) {
		if (!$id) {
			$this->Session->setFlash(__('Invalid ibd odbc', true));
			$this->redirect(array('action' => 'index'));
		}
		$this->IbdOdbc->recursive = 2;
		$this->set('ibdOdbc', $this->IbdOdbc->read(null, $id));
	}

	function add($id = null) {
		$this->loadModel('IbdExportPermit');
		$year=date('Y');
		$dt=date('Y-m-d');
		if (!empty($this->data)) {
			$this->IbdOdbc->create();
			$this->autoRender = false;

			$this->data['IbdOdbc']['Doc_Ref']=$this->get_next_no($year,$this->doc_no);
			$this->data['IbdOdbc']['cr_by']=$this->Session->read('Auth.User.username');
			if ($this->IbdOdbc->save($this->data)) {
				$this->update_next_no($year,$this->doc_no);

				

				Utility::Log($this->data['IbdOdbc']['Doc_Ref'],$this->Session->read('Auth.User.username'),'ADD',$dt);

				$this->Session->setFlash(__('The ibd odbc has been saved', true), '');
				$this->render('/elements/success');
			} else {
				$this->Session->setFlash(__('The ibd odbc could not be saved. Please, try again.', true), '');
				$this->render('/elements/failure');
			}
		}
		if($id)
			$this->set('parent_id', $id);
		$payment_terms = $this->IbdOdbc->PaymentTerm->find('list');
		$currency_types = $this->IbdOdbc->CurrencyType->find('list');
		
		

		$permit=$this->IbdExportPermit->find('list',array('fields'=>array('IbdExportPermit.EXPORT_PERMIT_NO')));
		array_unshift($permit,'Not Applicable');
        $permit_no=$this->get_next_no($year,$this->doc_no);
		$this->set(compact('payment_terms', 'currency_types','permit_no'));
		$this->set('permit',$permit);
	}

	function edit($id = null, $parent_id = null) {
		$dt=date('Y-m-d');
		if (!$id && empty($this->data)) {
			$this->Session->setFlash(__('Invalid ibd odbc', true), '');
			$this->redirect(array('action' => 'index'));
		}
		if (!empty($this->data)) {
			$this->autoRender = false;
				$this->data['IbdOdbc']['edit_by']=$this->Session->read('Auth.User.username');
			if ($this->IbdOdbc->save($this->data)) {

				Utility::Log($this->data['IbdOdbc']['Doc_Ref'],$this->Session->read('Auth.User.username'),'EDIT',$dt);

				$this->Session->setFlash(__('The ibd odbc has been saved', true), '');
				$this->render('/elements/success');
			} else {
				$this->Session->setFlash(__('The ibd odbc could not be saved. Please, try again.', true), '');
				$this->render('/elements/failure');
			}
		}
		$this->set('ibd__odbc', $this->IbdOdbc->read(null, $id));
		
		if($parent_id) {
			$this->set('parent_id', $parent_id);
		}
			
		$payment_terms = $this->IbdOdbc->PaymentTerm->find('list');
		$currency_types = $this->IbdOdbc->CurrencyType->find('list');
		$this->set(compact('payment_terms', 'currency_types'));
	}

	function delete($id = null) {
		$this->autoRender = false;
		if (!$id) {
			$this->Session->setFlash(__('Invalid id for ibd odbc', true), '');
			$this->render('/elements/failure');
		}
		if (stripos($id, '_') !== false) {
            $ids = explode('_', $id);
            try{
                foreach ($ids as $i) {
                    $this->IbdOdbc->delete($i);
                }
				$this->Session->setFlash(__('Ibd odbc deleted', true), '');
				$this->render('/elements/success');
            }
            catch (Exception $e){
				$this->Session->setFlash(__('Ibd odbc was not deleted', true), '');
				$this->render('/elements/failure');
            }
        } else {
            if ($this->IbdOdbc->delete($id)) {
				$this->Session->setFlash(__('Ibd odbc deleted', true), '');
				$this->render('/elements/success');
			} else {
				$this->Session->setFlash(__('Ibd odbc was not deleted', true), '');
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
	
		return 'ABB/ODBC/'.str_pad(($no[0]['ibd_next_nos']['next_no']),3,'0',STR_PAD_LEFT).'/'.$year;
	}

		function update_next_no($year,$id){
		$this->LoadModel('IbdNextNo');
		$cmd="UPDATE  ibd_next_nos SET next_no=1+next_no WHERE year=$year and doc_id=$id";
		$no=$this->IbdNextNo->query($cmd);

	}
	function update_lc_remaining($permit_no=NULL,$qty=NULL){
		try{
			$cmd=" UPDATE ibd_outstanding_export_lcs SET  outstanding_remaining_lc_fcy=outstanding_remaining_lc_fcy-$qty   WHERE OUR_REF_NO=(SELECT LC_REF_NO FROM ibd_export_permits WHERE EXPORT_PERMIT_NO='$permit_no');";
			$this->IbdOdbp->query($cmd);

		}catch(Exception $e){}
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
     $json_like_string=$this->IbdOdbc->find('all');

    }

		 $_SESSION["export_data"]=$json_like_string;
	     

	}

}
?>