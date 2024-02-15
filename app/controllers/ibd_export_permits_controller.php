<?php

require "Utility.php";
class IbdExportPermitsController extends AppController {

	var $name = 'IbdExportPermits';
	var $model = 'IbdExportPermit';
	var $table_name = 'ibd_export_permits';


	
	function index() {
	}
	

	function search() {
	}

	function search_local() {
   		$this->loadModel('CurrencyType');
   		$this->loadModel('IbdBank');
		$po=$this->IbdExportPermit->find("list",array('fields'=>array('IbdExportPermit.EXPORT_PERMIT_NO')));
		$ibc=$this->IbdExportPermit->find("list",array('fields'=>array('IbdExportPermit.LC_REF_NO')));
		

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
		
		$this->set('ibd_export_permits', $this->IbdExportPermit->find('all', array('conditions' => $conditions, 'limit' => $limit, 'offset' => $start)));
		$this->set('results', $this->IbdExportPermit->find('count', array('conditions' => $conditions)));
	}

	function view($id = null) {
		if (!$id) {
			$this->Session->setFlash(__('Invalid ibd export permit', true));
			$this->redirect(array('action' => 'index'));
		}
		$this->IbdExportPermit->recursive = 2;
		$this->set('ibdExportPermit', $this->IbdExportPermit->read(null, $id));
	}

	function add($id = null) {
		$this->loadModel('CurrencyType');
		$this->loadModel('PaymentTerm');
		$this->loadModel('IbdOutstandingExportLc');
		$year=date('Y');
		$dt=date('Y-m-d');
		if (!empty($this->data)) {
			$this->IbdExportPermit->create();
			$this->autoRender = false;

			$this->data['IbdExportPermit']['EXPORT_PERMIT_NO']=$this->get_next_no($year,3);
			$this->data['IbdExportPermit']['cr_by']=$this->Session->read('Auth.User.username');
			if ($this->IbdExportPermit->save($this->data)) {
				$this->update_next_no($year,3);

				

				Utility::Log($this->data['IbdExportPermit']['EXPORT_PERMIT_NO'],$this->Session->read('Auth.User.username'),'ADD',$dt);

				$this->Session->setFlash(__('The ibd export permit has been saved', true), '');
				$this->render('/elements/success');
			} else {
				$this->Session->setFlash(__('The ibd export permit could not be saved. Please, try again.', true), '');
				$this->render('/elements/failure');
			}
		}


		$lcs=$this->IbdOutstandingExportLc->find('list',array('fields'=>array('IbdOutstandingExportLc.our_ref_no')));

        array_unshift($lcs,'Not Applicable');
		

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
		
		$permit=$this->get_next_no($year,3);

		$this->set('payment_terms',$pay);
		$this->set('currencies',$curr);
		$this->set('permit',$permit);
		$this->set('lcs',$lcs);

	}

	function edit($id = null, $parent_id = null) {
		$this->loadModel('CurrencyType');
		$this->loadModel('PaymentTerm');
		$dt=date('Y-m-d');
		if (!$id && empty($this->data)) {
			$this->Session->setFlash(__('Invalid ibd export permit', true), '');
			$this->redirect(array('action' => 'index'));
		}
		if (!empty($this->data)) {
			$this->autoRender = false;
			$this->data['IbdExportPermit']['edit_by']=$this->Session->read('Auth.User.username');
			if ($this->IbdExportPermit->save($this->data)) {

				Utility::Log($this->data['IbdExportPermit']['EXPORT_PERMIT_NO'],$this->Session->read('Auth.User.username'),'EDIT',$dt);

				$this->Session->setFlash(__('The ibd export permit has been saved', true), '');
				$this->render('/elements/success');
			} else {
				$this->Session->setFlash(__('The ibd export permit could not be saved. Please, try again.', true), '');
				$this->render('/elements/failure');
			}
		}
		$this->set('ibd_export_permit', $this->IbdExportPermit->read(null, $id));
		
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


		$this->set('payment_terms',$pay);
		$this->set('currencies',$curr);

	}

	function delete($id = null) {
		$this->autoRender = false;
		if (!$id) {
			$this->Session->setFlash(__('Invalid id for ibd export permit', true), '');
			$this->render('/elements/failure');
		}
		if (stripos($id, '_') !== false) {
            $ids = explode('_', $id);
            try{
                foreach ($ids as $i) {
                    $this->IbdExportPermit->delete($i);
                }
				$this->Session->setFlash(__('Ibd export permit deleted', true), '');
				$this->render('/elements/success');
            }
            catch (Exception $e){
				$this->Session->setFlash(__('Ibd export permit was not deleted', true), '');
				$this->render('/elements/failure');
            }
        } else {
            if ($this->IbdExportPermit->delete($id)) {
				$this->Session->setFlash(__('Ibd export permit deleted', true), '');
				$this->render('/elements/success');
			} else {
				$this->Session->setFlash(__('Ibd export permit was not deleted', true), '');
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
	
		return 'ABBTRS02'.''.str_pad(($no[0]['ibd_next_nos']['next_no']), 5,'0',STR_PAD_LEFT).''.$year;
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
        $json_like_string=$this->IbdExportPermit->find('all');

       }
 
		 $_SESSION["export_data"]=$json_like_string;//$_POST['o'];
	     //var_dump($_POST['o']);die();

	}
}
?>