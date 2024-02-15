<?php

require "Utility.php";

class IbdOutstandingExportLcsController extends AppController {

	var $name = 'IbdOutstandingExportLcs';
	var $model= 'IbdOutstandingExportLc';
	var $table_name = 'ibd_outstanding_export_lcs';
	
	function index() {
	}
	

	function search() {
	}

	function search_local() {
   		$this->loadModel('CurrencyType');
		$po=$this->IbdOutstandingExportLc->find("list",array('fields'=>array('IbdOutstandingExportLc.our_ref_no')));
	

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
		
		$this->set('ibd_outstanding_export_lcs', $this->IbdOutstandingExportLc->find('all', array('conditions' => $conditions, 'limit' => $limit, 'offset' => $start)));
		$this->set('results', $this->IbdOutstandingExportLc->find('count', array('conditions' => $conditions)));
	}

	function view($id = null) {
		if (!$id) {
			$this->Session->setFlash(__('Invalid ibd outstanding export lc', true));
			$this->redirect(array('action' => 'index'));
		}
		$this->IbdOutstandingExportLc->recursive = 2;
		$this->set('ibdOutstandingExportLc', $this->IbdOutstandingExportLc->read(null, $id));
	}

	function add($id = null) {
		$this->loadModel('CurrencyType');
		$year=date('Y');
		$dt=date('Y-m-d');
		if (!empty($this->data)) {
			$this->IbdOutstandingExportLc->create();
			$this->autoRender = false;

			$this->data['IbdOutstandingExportLc']['our_ref_no']=$this->get_next_no($year,8);
			$this->data['IbdOutstandingExportLc']['cr_by']=$this->Session->read('Auth.User.username');
			if ($this->IbdOutstandingExportLc->save($this->data)) {
				$this->update_next_no($year,8);

				$permit=$this->get_next_no($year,8);
				

				Utility::Log($this->data['IbdOutstandingExportLc']['our_ref_no'],$this->Session->read('Auth.User.username'),'ADD',$dt);

                
				
				$this->Session->setFlash(__('The ibd outstanding export lc has been saved', true), '');
				$this->render('/elements/success');
			} else {
				$this->Session->setFlash(__('The ibd outstanding export lc could not be saved. Please, try again.', true), '');
				$this->render('/elements/failure');
			}
		}

		$permit=$this->get_next_no($year,8);


		$currency=$this->CurrencyType->find("list");
		$curr=array();
        foreach($currency as $c){
        $curr[$c]=$c;
		}

		$this->set('currencies',$curr);
		$this->set('refno',$permit);
	}

	function edit($id = null, $parent_id = null) {
		$dt=date('Y-m-d');
		if (!$id && empty($this->data)) {
			$this->Session->setFlash(__('Invalid ibd outstanding export lc', true), '');
			$this->redirect(array('action' => 'index'));
		}
		if (!empty($this->data)) {
			$this->autoRender = false;
			$this->data['IbdOutstandingExportLc']['edit_by']=$this->Session->read('Auth.User.username');
			if ($this->IbdOutstandingExportLc->save($this->data)) {

				Utility::Log($this->data['IbdOutstandingExportLc']['our_ref_no'],$this->Session->read('Auth.User.username'),'EDIT',$dt);
				$this->Session->setFlash(__('The ibd outstanding export lc has been saved', true), '');
				$this->render('/elements/success');
			} else {
				$this->Session->setFlash(__('The ibd outstanding export lc could not be saved. Please, try again.', true), '');
				$this->render('/elements/failure');
			}
		}
		$this->set('ibd__outstanding__export__lc', $this->IbdOutstandingExportLc->read(null, $id));
		
			
	}

	function delete($id = null) {
		$this->autoRender = false;
		if (!$id) {
			$this->Session->setFlash(__('Invalid id for ibd outstanding export lc', true), '');
			$this->render('/elements/failure');
		}
		if (stripos($id, '_') !== false) {
            $ids = explode('_', $id);
            try{
                foreach ($ids as $i) {
                    $this->IbdOutstandingExportLc->delete($i);
                }
				$this->Session->setFlash(__('Ibd outstanding export lc deleted', true), '');
				$this->render('/elements/success');
            }
            catch (Exception $e){
				$this->Session->setFlash(__('Ibd outstanding export lc was not deleted', true), '');
				$this->render('/elements/failure');
            }
        } else {
            if ($this->IbdOutstandingExportLc->delete($id)) {
				$this->Session->setFlash(__('Ibd outstanding export lc deleted', true), '');
				$this->render('/elements/success');
			} else {
				$this->Session->setFlash(__('Ibd outstanding export lc was not deleted', true), '');
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
	
		return 'TRS/EXP/LC/'.str_pad(($no[0]['ibd_next_nos']['next_no']),3,'0',STR_PAD_LEFT).'/'.$year;
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
     $json_like_string=$this->IbdOutstandingExportLc->find('all');

    }

		 $_SESSION["export_data"]=$json_like_string;
	     

	}

}
?>