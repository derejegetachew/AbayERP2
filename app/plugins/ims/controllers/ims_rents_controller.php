<?php
class ImsRentsController extends AppController {

	var $name = 'ImsRents';
	
	function beforeFilter()
	{
		parent::beforeFilter();
		$this->Auth->allow('rent_alert');
	}
	
	function index() {
		$this->ImsRent->Branch->recursive = -1;
		$branches = $this->ImsRent->Branch->find('all');
		$this->set(compact('branches'));
	}
	
	function index2($id = null) {
		$this->set('parent_id', $id);
	}

	function search() {
	}
	
	function list_data($id = null) {
		$start = (isset($_REQUEST['start'])) ? $_REQUEST['start'] : 0;
		$limit = (isset($_REQUEST['limit'])) ? $_REQUEST['limit'] : 5;
		$branch_id = (isset($_REQUEST['branch_id'])) ? $_REQUEST['branch_id'] : -1;
		if($id)
			$branch_id = ($id) ? $id : -1;
        $conditions = (isset($_REQUEST['conditions'])) ? $_REQUEST['conditions'] : '';

        eval("\$conditions = array( " . $conditions . " );");
		if ($branch_id != -1) {
            $conditions['ImsRent.branch_id'] = $branch_id;
        }
		
   $rent_data=$this->ImsRent->find('all', array('conditions' => $conditions, 'limit' => $limit, 'offset' => $start));
		$this->set('ims_rents',$rent_data );
		$this->set('results', $this->ImsRent->find('count', array('conditions' => $conditions)));
	}

	function view($id = null) {
		if (!$id) {
			$this->Session->setFlash(__('Invalid ims rent', true));
			$this->redirect(array('action' => 'index'));
		}
		$this->ImsRent->recursive = 2;
		$this->set('imsRent', $this->ImsRent->read(null, $id));
	}

	function add($id = null) {
		if (!empty($this->data)) {
			$this->ImsRent->create();
			$this->autoRender = false;
			
			$user = $this->Session->read();
			$this->data['ImsRent']['created_by'] = $user['Auth']['User']['id'];
			
			if ($this->ImsRent->save($this->data)) {
				$this->Session->setFlash(__('The rent has been saved', true), '');
				$this->render('/elements/success');
			} else {
				$this->Session->setFlash(__('The rent could not be saved. Please, try again.', true), '');
				$this->render('/elements/failure');
			}
		}
		if($id)
			$this->set('parent_id', $id);
		$this->ImsRent->Branch->recursive = -1;
		$branches = $this->ImsRent->Branch->find('all');
		$this->set(compact('branches'));
	}

	function edit($id = null, $parent_id = null) {
		if (!$id && empty($this->data)) {
			$this->Session->setFlash(__('Invalid ims rent', true), '');
			$this->redirect(array('action' => 'index'));
		}
		if (!empty($this->data)) {
			$this->autoRender = false;
			if ($this->ImsRent->save($this->data)) {
				$this->Session->setFlash(__('The rent has been saved', true), '');
				$this->render('/elements/success');
			} else {
				$this->Session->setFlash(__('The rent could not be saved. Please, try again.', true), '');
				$this->render('/elements/failure');
			}
		}
		$this->set('ims_rent', $this->ImsRent->read(null, $id));
		
		if($parent_id) {
			$this->set('parent_id', $parent_id);
		}
		$this->ImsRent->Branch->recursive = -1;	
		$branches = $this->ImsRent->Branch->find('all');
		$this->set(compact('branches'));
	}

	function delete($id = null) {
		$this->autoRender = false;
		if (!$id) {
			$this->Session->setFlash(__('Invalid id for rent', true), '');
			$this->render('/elements/failure');
		}
		if (stripos($id, '_') !== false) {
            $ids = explode('_', $id);
            try{
                foreach ($ids as $i) {
                    $this->ImsRent->delete($i);
                }
				$this->Session->setFlash(__('rent deleted', true), '');
				$this->render('/elements/success');
            }
            catch (Exception $e){
				$this->Session->setFlash(__('rent was not deleted', true), '');
				$this->render('/elements/failure');
            }
        } else {
            if ($this->ImsRent->delete($id)) {
				$this->Session->setFlash(__('rent deleted', true), '');
				$this->render('/elements/success');
			} else {
				$this->Session->setFlash(__('rent was not deleted', true), '');
				$this->render('/elements/failure');
			}
        }
	}
	
	function getUser(){
		$userid = $this->params['userid'];	
		$this->loadModel('User');
		$conditions = array('User.id' => $userid);
		$this->User->recursive = 0;
		$user = $this->User->find('first',array('conditions' => $conditions));	
		return $user;
	}
	
	function rent_alert() {		
		$this->autoRender = false;
		
		$date = date("Y-m-d");
		$expire_date_contract = date('Y-m-d',strtotime($date . "+90 days"));
		$expire_date_contract1 = date('Y-m-d',strtotime($date . "+89 days"));
		$expire_date_prepaid = date('Y-m-d',strtotime($date . "+30 days"));
		$expire_date_prepaid1 = date('Y-m-d',strtotime($date . "+29 days"));
		
		$conditions =array('ImsRent.contract_end_date <' => $expire_date_contract, 'ImsRent.contract_end_date >' => $expire_date_contract1);
		$rents = $this->ImsRent->find('all', array('conditions' => $conditions));
		//pr($rents);exit;
		foreach($rents as $rent){			
			$end_date = new DateTime($rent['ImsRent']['contract_end_date']);
			$message = urlencode($rent['Branch']['name']. ' house rent contract will end on ' .date_format($end_date, "F j, Y"));
			$mob_num = '0911364831';
			file_get_contents('http://10.1.85.10/sms_manager/send.php?to='.$mob_num.'&msg='.$message);
			$mob_num = '0910534077';
			file_get_contents('http://10.1.85.10/sms_manager/send.php?to='.$mob_num.'&msg='.$message);
			$mob_num = '0929040411';
			file_get_contents('http://10.1.85.10/sms_manager/send.php?to='.$mob_num.'&msg='.$message);
			
		}
		
		$conditions_prepaid =array('ImsRent.prepayed_end_date <' => $expire_date_prepaid, 'ImsRent.prepayed_end_date >' => $expire_date_prepaid1);
		$rents_prepaid = $this->ImsRent->find('all', array('conditions' => $conditions_prepaid));
		
		foreach($rents_prepaid as $rent_prepaid){
			$end_date = new DateTime($rent_prepaid['ImsRent']['prepayed_end_date']);
			$message = urlencode($rent_prepaid['Branch']['name']. ' house rent Prepaid amount will end on ' .date_format($end_date, "F j, Y"));
			$mob_num = '0911364831';
			file_get_contents('http://10.1.85.10/sms_manager/send.php?to='.$mob_num.'&msg='.$message);
			$mob_num = '0910534077';
			file_get_contents('http://10.1.85.10/sms_manager/send.php?to='.$mob_num.'&msg='.$message);
			$mob_num = '0929040411';
			file_get_contents('http://10.1.85.10/sms_manager/send.php?to='.$mob_num.'&msg='.$message);		
			
		}
		$date1 = date('d-m-Y');
        echo $date1;		
    }
}
?>