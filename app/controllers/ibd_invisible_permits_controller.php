<?php

require "Utility.php";
class IbdInvisiblePermitsController extends AppController {

	var $name = 'IbdInvisiblePermits';
	var $model = 'IbdInvisiblePermit';
	var $table_name = 'ibd_invisible_permits';
	
	function index() {
		$currency_types = $this->IbdInvisiblePermit->CurrencyType->find('all');
		$this->set(compact('currency_types'));
	}
	
	function index2($id = null) {
		$this->set('parent_id', $id);
	}

	function search() {
	}

	function search_local() {
   		$this->loadModel('CurrencyType');
		$po=$this->IbdInvisiblePermit->find("list",array('fields'=>array('IbdInvisiblePermit.PERMIT_NO')));
		$fcy_account=$this->IbdInvisiblePermit->query('select distinct FROM_THEIR_LCY_ACCOUNT from Ibd_Invisible_Permits');

		$currencies=$this->CurrencyType->find("list");
		$curr=array();
        foreach($currencies as $c){
        $curr[$c]=$c;
		}

		$acct=array();
        foreach($fcy_account as $c){
        $acct[$c['Ibd_Invisible_Permits']['FROM_THEIR_LCY_ACCOUNT']]=$c['Ibd_Invisible_Permits']['FROM_THEIR_LCY_ACCOUNT'];
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
		$currencytype_id = (isset($_REQUEST['currencytype_id'])) ? $_REQUEST['currencytype_id'] : -1;
		if($id)
			$currencytype_id = ($id) ? $id : -1;
        $conditions = (isset($_REQUEST['conditions'])) ? $_REQUEST['conditions'] : '';

        eval("\$conditions = array( " . $conditions . " );");
		if ($currencytype_id != -1) {
            $conditions['IbdInvisiblePermit.currencytype_id'] = $currencytype_id;
        }
		
		$this->set('ibd_invisible_permits', $this->IbdInvisiblePermit->find('all', array('conditions' => $conditions, 'limit' => $limit, 'offset' => $start)));
		$this->set('results', $this->IbdInvisiblePermit->find('count', array('conditions' => $conditions)));
	}

	function view($id = null) {
		if (!$id) {
			$this->Session->setFlash(__('Invalid ibd invisible permit', true));
			$this->redirect(array('action' => 'index'));
		}
		$this->IbdInvisiblePermit->recursive = 2;
		$this->set('ibdInvisiblePermit', $this->IbdInvisiblePermit->read(null, $id));
	}

	function add($id = null) {
		$year=date('Y');
		$dt=date('Y-m-d');
		if (!empty($this->data)) {
			$this->IbdInvisiblePermit->create();
			$this->data['IbdInvisiblePermit']['PERMIT_NO']= $this->get_next_no($year,10);
			$this->data['IbdInvisiblePermit']['cr_by']=$this->Session->read('Auth.User.username');
			$this->autoRender = false;
			if ($this->IbdInvisiblePermit->save($this->data)) {
				$this->update_next_no($year,10);

				

				Utility::Log($this->data['IbdInvisiblePermit']['PERMIT_NO'],$this->Session->read('Auth.User.username'),'ADD',$dt);
				$this->Session->setFlash(__('The ibd lc has been saved', true), '');
				$this->Session->setFlash(__('The ibd invisible permit has been saved', true), '');
				$this->render('/elements/success');
			} else {
				$this->Session->setFlash(__('The ibd invisible permit could not be saved. Please, try again.', true), '');
				$this->render('/elements/failure');
			}
		}
		if($id)
			$this->set('parent_id', $id);
		$currencies = $this->IbdInvisiblePermit->CurrencyType->find('list');
		$this->set(compact('currencies'));

		$permit=$this->get_next_no($year,10);

		$this->set('ref_no',$permit);


	}

	function edit($id = null, $parent_id = null) {
			$dt=date('Y-m-d');
		if (!$id && empty($this->data)) {
			$this->Session->setFlash(__('Invalid ibd invisible permit', true), '');
			$this->redirect(array('action' => 'index'));
		}
		if (!empty($this->data)) {
			$this->autoRender = false;
				$this->data['IbdInvisiblePermit']['edit_by']=$this->Session->read('Auth.User.username');
			if ($this->IbdInvisiblePermit->save($this->data)) {
				Utility::Log($this->data['IbdInvisiblePermit']['PERMIT_NO'],$this->Session->read('Auth.User.username'),'EDIT',$dt);
				$this->Session->setFlash(__('The ibd lc has been saved', true), '');
				$this->Session->setFlash(__('The ibd invisible permit has been saved', true), '');
				$this->render('/elements/success');
			} else {
				$this->Session->setFlash(__('The ibd invisible permit could not be saved. Please, try again.', true), '');
				$this->render('/elements/failure');
			}
		}
		$this->set('ibd_invisible_permit', $this->IbdInvisiblePermit->read(null, $id));
		
		if($parent_id) {
			$this->set('parent_id', $parent_id);
		}
			
		$currencies = $this->IbdInvisiblePermit->CurrencyType->find('list');
		$this->set(compact('currencies'));
	}

	function delete($id = null) {
		$this->autoRender = false;
		if (!$id) {
			$this->Session->setFlash(__('Invalid id for ibd invisible permit', true), '');
			$this->render('/elements/failure');
		}
		if (stripos($id, '_') !== false) {
            $ids = explode('_', $id);
            try{
                foreach ($ids as $i) {
                    $this->IbdInvisiblePermit->delete($i);
                }
				$this->Session->setFlash(__('Ibd invisible permit deleted', true), '');
				$this->render('/elements/success');
            }
            catch (Exception $e){
				$this->Session->setFlash(__('Ibd invisible permit was not deleted', true), '');
				$this->render('/elements/failure');
            }
        } else {
            if ($this->IbdInvisiblePermit->delete($id)) {
				$this->Session->setFlash(__('Ibd invisible permit deleted', true), '');
				$this->render('/elements/success');
			} else {
				$this->Session->setFlash(__('Ibd invisible permit was not deleted', true), '');
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
	

		return 'ABBTRS03'.''.str_pad(($no[0]['ibd_next_nos']['next_no']), 5,'0',STR_PAD_LEFT).''.$year;
	}
	function update_next_no($year,$id){
		$this->LoadModel('IbdNextNo');
		$cmd="UPDATE  ibd_next_nos SET next_no=1+next_no WHERE year=$year and doc_id=$id";
		$no=$this->IbdNextNo->query($cmd);

	}

	function export($obb=null){
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
     $json_like_string=$this->IbdInvisiblePermit->find('all');

    }

		 $_SESSION["export_data"]=$json_like_string;//$_POST['o'];
	     //var_dump($_POST['o']);die();
	}

}
?>