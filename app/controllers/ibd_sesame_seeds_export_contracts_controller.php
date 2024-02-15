<?php

require "Utility.php";

class IbdSesameSeedsExportContractsController extends AppController {

	var $name = 'IbdSesameSeedsExportContracts';
	var $doc_no=9;
		var $model= 'IbdSesameSeedsExportContract';
	var $table_name = 'Ibd_Sesame_Seeds_Export_Contracts';

	function index() {
	}
	

	function search() {
	}
	function search_local() {
   		$this->loadModel('CurrencyType');
		$po=$this->IbdSesameSeedsExportContract->find("list",array('fields'=>array('IbdSesameSeedsExportContract.contract_registration_no')));
	

		$currencies=$this->CurrencyType->find("list");
		$curr=array();
        foreach($currencies as $c){
        $curr[$c]=$c;
		}

		$pos=array();
        foreach($po as $p){
        	$pos[$p]=$p;
		}

		$this->set('po',$pos);
		$this->set('currencies',$currencies);
	}
	
	function list_data($id = null) {
		$start = (isset($_REQUEST['start'])) ? $_REQUEST['start'] : 0;
		$limit = (isset($_REQUEST['limit'])) ? $_REQUEST['limit'] : 5;
        $conditions = (isset($_REQUEST['conditions'])) ? $_REQUEST['conditions'] : '';

        eval("\$conditions = array( " . $conditions . " );");
		
		$this->set('ibd_sesame_seeds_export_contracts', $this->IbdSesameSeedsExportContract->find('all', array('conditions' => $conditions, 'limit' => $limit, 'offset' => $start)));
		$this->set('results', $this->IbdSesameSeedsExportContract->find('count', array('conditions' => $conditions)));
	}

	function view($id = null) {
		if (!$id) {
			$this->Session->setFlash(__('Invalid ibd sesame seeds export contract', true));
			$this->redirect(array('action' => 'index'));
		}
		$this->IbdSesameSeedsExportContract->recursive = 2;
		$this->set('ibdSesameSeedsExportContract', $this->IbdSesameSeedsExportContract->read(null, $id));
	}

	function add($id = null) {

		$year="2019";//date('Y');
		$dt=date('Y-m-d');
		if (!empty($this->data)) {
			$this->IbdSesameSeedsExportContract->create();
			$this->autoRender = false;

				$this->data['IbdSesameSeedsExportContract']['contract_registration_no']=$this->get_next_no($year,$this->doc_no);
				$this->data['IbdSesameSeedsExportContract']['cr_by']=$this->Session->read('Auth.User.username');
			if ($this->IbdSesameSeedsExportContract->save($this->data)) {
				$this->update_next_no($year,$this->doc_no);

			

					Utility::Log($this->data['IbdSesameSeedsExportContract']['contract_registration_no'],$this->Session->read('Auth.User.username'),'ADD',$dt);

				$this->Session->setFlash(__('The ibd sesame seeds export contract has been saved', true), '');
				$this->render('/elements/success');
			} else {
				$this->Session->setFlash(__('The ibd sesame seeds export contract could not be saved. Please, try again.', true), '');
				$this->render('/elements/failure');
			}
		}

        $payment_terms = $this->IbdSesameSeedsExportContract->PaymentTerm->find('list');
		$currency_types = $this->IbdSesameSeedsExportContract->CurrencyType->find('list');

		  $permit_no=$this->get_next_no($year,$this->doc_no);
		  $this->set('contract_no',$permit_no);
		  $this->set(compact('payment_terms', 'currency_types'));


	}

	function edit($id = null, $parent_id = null) {
		$dt=date('Y-m-d');
		if (!$id && empty($this->data)) {
			$this->Session->setFlash(__('Invalid ibd sesame seeds export contract', true), '');
			$this->redirect(array('action' => 'index'));
		}
		if (!empty($this->data)) {
			$this->autoRender = false;
				$this->data['IbdSesameSeedsExportContract']['edit_by']=$this->Session->read('Auth.User.username');
			if ($this->IbdSesameSeedsExportContract->save($this->data)) {

				Utility::Log($this->data['IbdSesameSeedsExportContract']['contract_registration_no'],$this->Session->read('Auth.User.username'),'EDIT',$dt);

				$this->Session->setFlash(__('The ibd sesame seeds export contract has been saved', true), '');
				$this->render('/elements/success');
			} else {
				$this->Session->setFlash(__('The ibd sesame seeds export contract could not be saved. Please, try again.', true), '');
				$this->render('/elements/failure');
			}
		}
		$this->set('ibd_sesame_seeds_export_contract', $this->IbdSesameSeedsExportContract->read(null, $id));
		
			
	}

	function delete($id = null) {
		$this->autoRender = false;
		if (!$id) {
			$this->Session->setFlash(__('Invalid id for ibd sesame seeds export contract', true), '');
			$this->render('/elements/failure');
		}
		if (stripos($id, '_') !== false) {
            $ids = explode('_', $id);
            try{
                foreach ($ids as $i) {
                    $this->IbdSesameSeedsExportContract->delete($i);
                }
				$this->Session->setFlash(__('Ibd sesame seeds export contract deleted', true), '');
				$this->render('/elements/success');
            }
            catch (Exception $e){
				$this->Session->setFlash(__('Ibd sesame seeds export contract was not deleted', true), '');
				$this->render('/elements/failure');
            }
        } else {
            if ($this->IbdSesameSeedsExportContract->delete($id)) {
				$this->Session->setFlash(__('Ibd sesame seeds export contract deleted', true), '');
				$this->render('/elements/success');
			} else {
				$this->Session->setFlash(__('Ibd sesame seeds export contract was not deleted', true), '');
				$this->render('/elements/failure');
			}
        }
	}

	function get_next_no($year,$id){
		$year="2019";//date("Y");
		$this->LoadModel('IbdNextNo');
		$cmd="SELECT next_no from ibd_next_nos WHERE year=$year and doc_id=$id";
		$no=$this->IbdNextNo->query($cmd);

		date_default_timezone_set("Africa/Addis_Ababa");  
	
		return 'ABB/TRS/'.'SS'.str_pad(($no[0]['ibd_next_nos']['next_no']),5,'0',STR_PAD_LEFT).'/'.$year;
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
     $json_like_string=$this->IbdSesameSeedsExportContract->find('all');

    }

		 $_SESSION["export_data"]=$json_like_string;//$_POST['o'];
	     //var_dump($_POST['o']);die();

	}
}
?>