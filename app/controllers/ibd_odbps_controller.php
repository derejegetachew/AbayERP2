<?php

require "Utility.php";

class IbdOdbpsController extends AppController {

	var $name = 'IbdOdbps';
	var $doc_no=1;
	var $model= 'IbdOdbp';
	var $table_name = 'ibd_odbps';
	
	function index() {
		$this->IbdOdbp->recursive=0;
		
		$ibd_odbps = $this->IbdOdbp->find('all');
		$this->set(compact('ibd_odbps'));
	}
	

	function search() {
	}

	function search_local() {
   		$this->loadModel('CurrencyType');
		$po=$this->IbdOdbp->find("list",array('fields'=>array('IbdOdbp.ref_no')));
		$permit_no=$this->IbdOdbp->find("list",array('fields'=>array('IbdOdbp.permit_no')));
		$NBE_Ref_no=$this->IbdOdbp->find("list",array('fields'=>array('IbdOdbp.NBE_Ref_no')));
	

		$currencies=$this->CurrencyType->find("list");
		$curr=array();
        foreach($currencies as $c){
        $curr[$c]=$c;
		}

		$pos=array();
        foreach($po as $p){
        	$pos[$p]=$p;
		}

		$permit_nos=array();
        foreach($permit_no as $p){
        	$permit_nos[$p]=$p;
		}

		$NBE_Ref_nos=array();
        foreach($NBE_Ref_no as $p){
        	$NBE_Ref_nos[$p]=$p;
		}

		$this->set('po',$pos);
		$this->set('currencies',$currencies);
		$this->set('permit_nos',$permit_nos);
		$this->set('NBE_Ref_nos',$NBE_Ref_nos);
	}
	
	function list_data($id = null) {
		$start = (isset($_REQUEST['start'])) ? $_REQUEST['start'] : 0;
		$limit = (isset($_REQUEST['limit'])) ? $_REQUEST['limit'] : 5;
        $conditions = (isset($_REQUEST['conditions'])) ? $_REQUEST['conditions'] : '';

        eval("\$conditions = array( " . $conditions . " );");
		
		$this->set('ibd_odbps', $this->IbdOdbp->find('all', array('conditions' => $conditions, 'limit' => $limit, 'offset' => $start)));
		$this->set('results', $this->IbdOdbp->find('count', array('conditions' => $conditions)));
	}

	function view($id = null) {
		if (!$id) {
			$this->Session->setFlash(__('Invalid ibd odbp', true));
			$this->redirect(array('action' => 'index'));
		}
		$this->IbdOdbp->recursive = 2;
		$this->set('ibdOdbp', $this->IbdOdbp->read(null, $id));
	}

	function add($id = null) {
		$this->loadModel('CurrencyType');
		$this->loadModel('PaymentTerm');
		$this->loadModel('IbdExportPermit');
		$permit=$this->data['IbdOdbp']['permit_no'];
		$qty=$this->data['IbdOdbp']['fct'];
			$year=date('Y');
			$dt=date('Y-m-d');

		if (!empty($this->data)) {
			$this->IbdOdbp->create();
			$this->autoRender = false;

			$this->data['IbdOdbp']['ref_no']=$this->get_next_no($year,$this->doc_no);
			$this->data['IbdOdbp']['cr_by']=$this->Session->read('Auth.User.username');
			if ($this->IbdOdbp->save($this->data)) {
				$this->update_next_no($year,$this->doc_no);

			

				Utility::Log($this->data['IbdOdbp']['ref_no'],$this->Session->read('Auth.User.username'),'ADD',$dt);

				$this->update_lc_remaining($permit,$qty);
				$this->Session->setFlash(__('The ibd odbp has been saved', true), '');
				$this->render('/elements/success');
			} else {
				$this->Session->setFlash(__('The ibd odbp could not be saved. Please, try again.', true), '');
				$this->render('/elements/failure');
			}
		}

		$permit_nos=$this->IbdExportPermit->find('list', array('fields'=>array('IbdExportPermit.EXPORT_PERMIT_NO') ));

		$currency=$this->CurrencyType->find("list");
		$curr=array();
        foreach($currency as $c){
        $curr[$c]=$c;
		}

       $permit=$this->get_next_no($year,$this->doc_no);

		$payment_terms=$this->PaymentTerm->find("list");
		$pay=array();
        foreach($payment_terms as $c){
        $pay[$c]=$c;
		}
array_unshift($permit_nos,'Not Applicable');
		$this->set('currencies',$curr);
		$this->set('payment_terms',$pay);
		$this->set('refno',$permit);
		$this->set('permits',$permit_nos);
	}

	function edit($id = null, $parent_id = null) {
		$dt=date('Y-m-d');
		$this->loadModel('CurrencyType');
		$this->loadModel('PaymentTerm');
		if (!$id && empty($this->data)) {
			$this->Session->setFlash(__('Invalid ibd odbp', true), '');
			$this->redirect(array('action' => 'index'));
		}
		if (!empty($this->data)) {
			$this->autoRender = false;
			$this->data['IbdOdbp']['edit_by']=$this->Session->read('Auth.User.username');
			if ($this->IbdOdbp->save($this->data)) {
				Utility::Log($this->data['IbdOdbp']['ref_no'],$this->Session->read('Auth.User.username'),'EDIT',$dt);
				$this->Session->setFlash(__('The ibd odbp has been saved', true), '');
				$this->render('/elements/success');
			} else {
				$this->Session->setFlash(__('The ibd odbp could not be saved. Please, try again.', true), '');
				$this->render('/elements/failure');
			}
		}
		$this->set('ibd_odbp', $this->IbdOdbp->read(null, $id));
		
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

		$this->set('currencies',$curr);
		$this->set('payment_terms',$pay);
			
	}

	function delete($id = null) {
		$this->autoRender = false;
		if (!$id) {
			$this->Session->setFlash(__('Invalid id for ibd odbp', true), '');
			$this->render('/elements/failure');
		}
		if (stripos($id, '_') !== false) {
            $ids = explode('_', $id);
            try{
                foreach ($ids as $i) {
                    $this->IbdOdbp->delete($i);
                }
				$this->Session->setFlash(__('Ibd odbp deleted', true), '');
				$this->render('/elements/success');
            }
            catch (Exception $e){
				$this->Session->setFlash(__('Ibd odbp was not deleted', true), '');
				$this->render('/elements/failure');
            }
        } else {
            if ($this->IbdOdbp->delete($id)) {
				$this->Session->setFlash(__('Ibd odbp deleted', true), '');
				$this->render('/elements/success');
			} else {
				$this->Session->setFlash(__('Ibd odbp was not deleted', true), '');
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
	

		return 'ABB/ODBP/'.str_pad(($no[0]['ibd_next_nos']['next_no']),3,'0',STR_PAD_LEFT).'/'.$year;
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
     $json_like_string=$this->IbdOdbp->find('all');

    }

		 $_SESSION["export_data"]=$json_like_string;
	     

	}
}
?>