<?php
class ImsDelegatesController extends AppController {

	var $name = 'ImsDelegates';
	
	function index() {
		$ims_requisitions = $this->ImsDelegate->ImsRequisition->find('all');
		$this->set(compact('ims_requisitions'));
	}
	
	function index2($id = null) {
		$this->set('parent_id', $id);
	}

	function search() {
	}
	
	function list_data($id = null) {
		$start = (isset($_REQUEST['start'])) ? $_REQUEST['start'] : 0;
		$limit = (isset($_REQUEST['limit'])) ? $_REQUEST['limit'] : 5;
		$imsrequisition_id = (isset($_REQUEST['imsrequisition_id'])) ? $_REQUEST['imsrequisition_id'] : -1;
		if($id)
			$imsrequisition_id = ($id) ? $id : -1;
        $conditions = (isset($_REQUEST['conditions'])) ? $_REQUEST['conditions'] : '';

        eval("\$conditions = array( " . $conditions . " );");
		if ($imsrequisition_id != -1) {
            $conditions['ImsDelegate.imsrequisition_id'] = $imsrequisition_id;
        }
		
		$this->set('imsDelegates', $this->ImsDelegate->find('all', array('conditions' => $conditions, 'limit' => $limit, 'offset' => $start)));
		$this->set('results', $this->ImsDelegate->find('count', array('conditions' => $conditions)));
	}

	function view($id = null) {
		if (!$id) {
			$this->Session->setFlash(__('Invalid ims delegate', true));
			$this->redirect(array('action' => 'index'));
		}
		$this->ImsDelegate->recursive = 2;
		$this->set('imsDelegate', $this->ImsDelegate->read(null, $id));
	}

	function add($id = null) {
		if (!empty($this->data)) {			
			$this->ImsDelegate->create();
			$this->autoRender = false;
			
			if(empty($this->data['ImsDelegate']['user_id']) && empty($this->data['ImsDelegate']['name'])){
				$this->Session->setFlash(__('please add your delegate who is able to receive the items on behalf of you', true), '');
				$this->render('/elements/failure');
			}
			else if(!empty($this->data['ImsDelegate']['user_id']) || !empty($this->data['ImsDelegate']['name']))
			{
				if(!empty($this->data['ImsDelegate']['user_id'])){
					$this->loadModel('User');
					$this->User->recursive =-1;			
					$conditionsUser =array('User.person_id' => $this->data['ImsDelegate']['user_id']);
					$user = $this->User->find('first', array('conditions' => $conditionsUser));
					$this->data['ImsDelegate']['user_id'] = $user['User']['id'];
				}
				
				if ($this->ImsDelegate->save($this->data)) {
					$this->loadModel('ImsRequisition');
					$this->ImsRequisition->id = $this->data['ImsDelegate']['ims_requisition_id'];
					if($this->ImsRequisition->saveField('status', 'accepted')){	
						$this->Session->setFlash(__('delegate has been saved and SIRV accepted Successfully', true), '');
						$this->render('/elements/success');
					}
					else {
						$this->Session->setFlash(__('delegate has been saved but SIRV not accepted', false), '');
						$this->render('/elements/failure');
					}				
					
				} else {
					$this->Session->setFlash(__('delegate could not be saved and SIRV not accepted. Please, try again.', true), '');
					$this->render('/elements/failure');
				}
			}
		}
		if($id)
			$this->set('parent_id', $id);
		$ims_requisitions = $this->ImsDelegate->ImsRequisition->find('list');
		$users = $this->ImsDelegate->User->find('list');
		$this->set(compact('ims_requisitions', 'users'));
	}

	function edit($id = null, $parent_id = null) {
		if (!$id && empty($this->data)) {
			$this->Session->setFlash(__('Invalid ims delegate', true), '');
			$this->redirect(array('action' => 'index'));
		}
		if (!empty($this->data)) {
			$this->autoRender = false;
			if ($this->ImsDelegate->save($this->data)) {
				$this->Session->setFlash(__('The ims delegate has been saved', true), '');
				$this->render('/elements/success');
			} else {
				$this->Session->setFlash(__('The ims delegate could not be saved. Please, try again.', true), '');
				$this->render('/elements/failure');
			}
		}
		$this->set('ims__delegate', $this->ImsDelegate->read(null, $id));
		
		if($parent_id) {
			$this->set('parent_id', $parent_id);
		}
			
		$ims_requisitions = $this->ImsDelegate->ImsRequisition->find('list');
		$users = $this->ImsDelegate->User->find('list');
		$this->set(compact('ims_requisitions', 'users'));
	}

	function delete($id = null) {
		$this->autoRender = false;
		if (!$id) {
			$this->Session->setFlash(__('Invalid id for ims delegate', true), '');
			$this->render('/elements/failure');
		}
		if (stripos($id, '_') !== false) {
            $ids = explode('_', $id);
            try{
                foreach ($ids as $i) {
                    $this->ImsDelegate->delete($i);
                }
				$this->Session->setFlash(__('Ims delegate deleted', true), '');
				$this->render('/elements/success');
            }
            catch (Exception $e){
				$this->Session->setFlash(__('Ims delegate was not deleted', true), '');
				$this->render('/elements/failure');
            }
        } else {
            if ($this->ImsDelegate->delete($id)) {
				$this->Session->setFlash(__('Ims delegate deleted', true), '');
				$this->render('/elements/success');
			} else {
				$this->Session->setFlash(__('Ims delegate was not deleted', true), '');
				$this->render('/elements/failure');
			}
        }
	}
	
	
}
?>