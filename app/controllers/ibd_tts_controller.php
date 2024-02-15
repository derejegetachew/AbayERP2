<?php

require "Utility.php";
class IbdTtsController extends AppController {

	var $name = 'IbdTts';
	var $model= 'IbdTt';
	var $table_name = 'ibd_tts';
	
	function index() {
	}
	

	function search() {
	}

	function search_local() {
   		$this->loadModel('CurrencyType');
		$po=$this->IbdTt->find("list",array('fields'=>array('IbdTt.TT_REFERENCE')));
		$fcy_account=$this->IbdTt->query('select distinct FROM_THEIR_FCY_ACCOUNT from Ibd_Tts');

		$currencies=$this->CurrencyType->find("list");
		$curr=array();
        foreach($currencies as $c){
        $curr[$c]=$c;
		}

		$acct=array();
        foreach($fcy_account as $c){
        $acct[$c['Ibd_Tts']['FROM_THEIR_FCY_ACCOUNT']]=$c['Ibd_Tts']['FROM_THEIR_FCY_ACCOUNT'];
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
		
		$this->set('ibd_tts', $this->IbdTt->find('all', array('conditions' => $conditions, 'limit' => $limit, 'offset' => $start)));
		$this->set('results', $this->IbdTt->find('count', array('conditions' => $conditions)));
	}

	function view($id = null) {
		if (!$id) {
			$this->Session->setFlash(__('Invalid ibd tt', true));
			$this->redirect(array('action' => 'index'));
		}
		$this->IbdTt->recursive = 2;
		$this->set('ibdTt', $this->IbdTt->read(null, $id));
	}

	function add($id = null) {
		$this->loadModel('CurrencyType');
		$year=date('Y');
		$dt=date('Y-m-d');
		if (!empty($this->data)) {
			$this->IbdTt->create();
			$this->autoRender = false;
			$this->data['IbdTt']['TT_REFERENCE']=$this->get_next_no($year,7);
				$this->data['IbdTt']['cr_by']=$this->Session->read('Auth.User.username');
			if ($this->IbdTt->save($this->data)) {
				$this->update_next_no($year,7);

			

				Utility::Log($this->data['IbdTt']['TT_REFERENCE'],$this->Session->read('Auth.User.username'),'ADD',$dt);
				$this->Session->setFlash(__('The ibd tt has been saved', true), '');
				$this->render('/elements/success');
			} else {
				$this->Session->setFlash(__('The ibd tt could not be saved. Please, try again.', true), '');
				$this->render('/elements/failure');
			}
		}

	   $REIBURSING=$this->IbdTt->IbdBank->find('list');


		$currency=$this->CurrencyType->find("list");
		$curr=array();
        foreach($currency as $c){
        $curr[$c]=$c;
		}

		$permit=$this->get_next_no($year,7);

		$this->set('tt_no',$permit);
		$this->set('currencies',$curr);
		$this->set('REIBURSING',$REIBURSING);
	}

	function edit($id = null, $parent_id = null) {
	$this->loadModel('CurrencyType');
		$dt=date('Y-m-d');
		if (!$id && empty($this->data)) {
			$this->Session->setFlash(__('Invalid ibd tt', true), '');
			$this->redirect(array('action' => 'index'));
		}
		if (!empty($this->data)) {
			$this->autoRender = false;
			$this->data['IbdTt']['edit_by']=$this->Session->read('Auth.User.username');
			if ($this->IbdTt->save($this->data)) {
					Utility::Log($this->data['IbdTt']['TT_REFERENCE'],$this->Session->read('Auth.User.username'),'EDIT',$dt);
				$this->Session->setFlash(__('The ibd tt has been saved', true), '');
				$this->render('/elements/success');
			} else {
				$this->Session->setFlash(__('The ibd tt could not be saved. Please, try again.', true), '');
				$this->render('/elements/failure');
			}
		}
		$this->set('ibd_tt', $this->IbdTt->read(null, $id));
		
		
		$REIBURSING=$this->IbdTt->IbdBank->find('list');


		$currency=$this->CurrencyType->find("list");
		$curr=array();
        foreach($currency as $c){
        $curr[$c]=$c;
		}
		
		$this->set('currencies',$curr);
		$this->set('REIBURSING',$REIBURSING);
			
	}

	function delete($id = null) {
		$this->autoRender = false;
		if (!$id) {
			$this->Session->setFlash(__('Invalid id for ibd tt', true), '');
			$this->render('/elements/failure');
		}
		if (stripos($id, '_') !== false) {
            $ids = explode('_', $id);
            try{
                foreach ($ids as $i) {
                    $this->IbdTt->delete($i);
                }
				$this->Session->setFlash(__('Ibd tt deleted', true), '');
				$this->render('/elements/success');
            }
            catch (Exception $e){
				$this->Session->setFlash(__('Ibd tt was not deleted', true), '');
				$this->render('/elements/failure');
            }
        } else {
            if ($this->IbdTt->delete($id)) {
				$this->Session->setFlash(__('Ibd tt deleted', true), '');
				$this->render('/elements/success');
			} else {
				$this->Session->setFlash(__('Ibd tt was not deleted', true), '');
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
	

		return 'TRS/TT/'.str_pad(($no[0]['ibd_next_nos']['next_no']),3,'0',STR_PAD_LEFT).'/'.$year;
	}
	function update_next_no($year,$id){
		$this->LoadModel('IbdNextNo');
		$cmd="UPDATE  ibd_next_nos SET next_no=1+next_no WHERE year=$year and doc_id=$id";
		$no=$this->IbdNextNo->query($cmd);

	}
	function  get_permit($val=null){
     $this->autoRender = false;
		switch($val){
			case 'INVISBLE':
			   $this->get_permit_no('IbdInvisiblePermit','ibd_invisible_permits','PERMIT_NO');
			break;
			case 'VISIBLE':
				$this->get_permit_no('ibdImportPermit','ibd_import_permits','IMPORT_PERMIT_NO');
			break;
			
		}
	}

	function get_permit_no($controller=null,$table_name=null,$column=null){
      $this->loadModel($controller);
      $cmd="SELECT $column as name FROM $table_name as tbl";
      $result=$this->$controller->query($cmd);
    
      	
      echo json_encode($result);
	}

	function get_permit_detail($permit_no=null,$val=null){
		$this->autoRender = false;
		 $permit_no=str_replace("(", "/", $permit_no);
         //var_dump($permit_no);
         ///var_dump($val);

         switch($val){
			case 'VISIBLE': // VISIBLE
				$this->get_permit_detail_info('ibdImportPermit','ibd_import_permits','IMPORT_PERMIT_NO',$permit_no);
			break;
			case 'INVISBLE': // INVISIBLE
				 $this->get_permit_detail_info('IbdInvisiblePermit','ibd_invisible_permits','PERMIT_NO',$permit_no);
			break;
		}

         //die();
	}

	function get_permit_detail_info($controller=null,$table_name=null,$column=null,$permit=null){
      $this->loadModel($controller);
      $cmd="SELECT *  FROM $table_name as tbl WHERE  $column='$permit'";
      $result=$this->$controller->query($cmd);
    
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
     $json_like_string=$this->IbdTt->find('all');

    }

		 $_SESSION["export_data"]=$json_like_string;//$_POST['o'];
	     //var_dump($_POST['o']);die();

	}
}
?>