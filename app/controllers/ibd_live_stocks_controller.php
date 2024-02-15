<?php

require "Utility.php";
class IbdLiveStocksController extends AppController {

	var $name = 'IbdLiveStocks';
	var $doc_no=12;
		var $model= 'IbdLiveStock';
	var $table_name = 'ibd_live_stocks';
	
	function index() {
	}
	

	function search() {
	}
		function search_local() {
   		$this->loadModel('CurrencyType');
		$po=$this->IbdLiveStock->find("list",array('fields'=>array('IbdLiveStock.contract_registration_no')));
	

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
		
		$this->set('ibd_live_stocks', $this->IbdLiveStock->find('all', array('conditions' => $conditions, 'limit' => $limit, 'offset' => $start)));
		$this->set('results', $this->IbdLiveStock->find('count', array('conditions' => $conditions)));
	}

	function view($id = null) {
		if (!$id) {
			$this->Session->setFlash(__('Invalid ibd live stock', true));
			$this->redirect(array('action' => 'index'));
		}
		$this->IbdLiveStock->recursive = 2;
		$this->set('ibdLiveStock', $this->IbdLiveStock->read(null, $id));
	}

	function add($id = null) {
			$year=date('Y');
			$dt=date('Y-m-d');
		if (!empty($this->data)) {
			$this->IbdLiveStock->create();
			$this->autoRender = false;

			$this->data['IbdLiveStock']['contract_registration_no']=$this->get_next_no($year,$this->doc_no);
			$this->data['IbdLiveStock']['cr_by']=$this->Session->read('Auth.User.username');
			if ($this->IbdLiveStock->save($this->data)) {
				$this->update_next_no($year,$this->doc_no);

				

				Utility::Log($this->data['IbdLiveStock']['contract_registration_no'],$this->Session->read('Auth.User.username'),'ADD',$dt);

				$this->Session->setFlash(__('The ibd live stock has been saved', true), '');
				$this->render('/elements/success');
			} else {
				$this->Session->setFlash(__('The ibd live stock could not be saved. Please, try again.', true), '');
				$this->render('/elements/failure');
			}
		}

		 $payment_terms = $this->IbdLiveStock->PaymentTerm->find('list');
		 $currency_types = $this->IbdLiveStock->CurrencyType->find('list');

		  $permit_no=$this->get_next_no($year,$this->doc_no);
		  $this->set('contract_no',$permit_no);
		  $this->set(compact('payment_terms', 'currency_types'));
	}

	function edit($id = null, $parent_id = null) {
		$dt=date('Y-m-d');
		if (!$id && empty($this->data)) {
			$this->Session->setFlash(__('Invalid ibd live stock', true), '');
			$this->redirect(array('action' => 'index'));
		}
		if (!empty($this->data)) {
			$this->autoRender = false;
			$this->data['IbdLiveStock']['edit_by']=$this->Session->read('Auth.User.username');
			if ($this->IbdLiveStock->save($this->data)) {

				Utility::Log($this->data['IbdLiveStock']['contract_registration_no'],$this->Session->read('Auth.User.username'),'EDIT',$dt);

				$this->Session->setFlash(__('The ibd live stock has been saved', true), '');
				$this->render('/elements/success');
			} else {
				$this->Session->setFlash(__('The ibd live stock could not be saved. Please, try again.', true), '');
				$this->render('/elements/failure');
			}
		}
		$this->set('ibd_live_stock', $this->IbdLiveStock->read(null, $id));
		
			
	}

	function delete($id = null) {
		$this->autoRender = false;
		if (!$id) {
			$this->Session->setFlash(__('Invalid id for ibd live stock', true), '');
			$this->render('/elements/failure');
		}
		if (stripos($id, '_') !== false) {
            $ids = explode('_', $id);
            try{
                foreach ($ids as $i) {
                    $this->IbdLiveStock->delete($i);
                }
				$this->Session->setFlash(__('Ibd live stock deleted', true), '');
				$this->render('/elements/success');
            }
            catch (Exception $e){
				$this->Session->setFlash(__('Ibd live stock was not deleted', true), '');
				$this->render('/elements/failure');
            }
        } else {
            if ($this->IbdLiveStock->delete($id)) {
				$this->Session->setFlash(__('Ibd live stock deleted', true), '');
				$this->render('/elements/success');
			} else {
				$this->Session->setFlash(__('Ibd live stock was not deleted', true), '');
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
	
		return 'ABB/TRS/'.'LV'.str_pad(($no[0]['ibd_next_nos']['next_no']),5,'0',STR_PAD_LEFT).'/'.date("Y");
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
     $json_like_string=$this->IbdLiveStock->find('all');

    }

		 $_SESSION["export_data"]=$json_like_string;
	     

	}
}
?>