<?php
class FmsRequisitionsController extends AppController {

	var $name = 'FmsRequisitions';
	
	function index() {
		$this->FmsRequisition->Branch->recursive = -1;
		$branches = $this->FmsRequisition->Branch->find('all');
		$this->set(compact('branches'));
	}
	
	function index_request() {
		$this->FmsRequisition->Branch->recursive = -1;
		$branches = $this->FmsRequisition->Branch->find('all');
		$this->set(compact('branches'));
	}
	
	function index_approve() {
		$this->FmsRequisition->Branch->recursive = -1;
		$branches = $this->FmsRequisition->Branch->find('all');
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
            $conditions['FmsRequisition.branch_id'] = $branch_id;
        }
		$conditions['FmsRequisition.status <>'] = 'created';
		$this->FmsRequisition->recursive = 2;
		$this->set('fms_requisitions', $this->FmsRequisition->find('all', array('conditions' => $conditions, 'limit' => $limit, 'offset' => $start)));
		$this->set('results', $this->FmsRequisition->find('count', array('conditions' => $conditions)));
	}
	
	function list_data_request($id = null) {
		$start = (isset($_REQUEST['start'])) ? $_REQUEST['start'] : 0;
		$limit = (isset($_REQUEST['limit'])) ? $_REQUEST['limit'] : 5;
		$branch_id = (isset($_REQUEST['branch_id'])) ? $_REQUEST['branch_id'] : -1;
		if($id)
			$branch_id = ($id) ? $id : -1;
        $conditions = (isset($_REQUEST['conditions'])) ? $_REQUEST['conditions'] : '';

        eval("\$conditions = array( " . $conditions . " );");
		if ($branch_id != -1) {
            $conditions['FmsRequisition.branch_id'] = $branch_id;
        }
		$user = $this->Session->read();
		$conditions['FmsRequisition.requested_by'] = $user['Auth']['User']['id'];
		$this->FmsRequisition->recursive = 2;
		$this->set('fms_requisitions', $this->FmsRequisition->find('all', array('conditions' => $conditions, 'limit' => $limit, 'offset' => $start)));
		$this->set('results', $this->FmsRequisition->find('count', array('conditions' => $conditions)));
	}
	
	function list_data_approve($id = null) {
		$start = (isset($_REQUEST['start'])) ? $_REQUEST['start'] : 0;
		$limit = (isset($_REQUEST['limit'])) ? $_REQUEST['limit'] : 5;
		$branch_id = (isset($_REQUEST['branch_id'])) ? $_REQUEST['branch_id'] : -1;
		if($id)
			$branch_id = ($id) ? $id : -1;
        $conditions = (isset($_REQUEST['conditions'])) ? $_REQUEST['conditions'] : '';

        eval("\$conditions = array( " . $conditions . " );");
		if ($branch_id != -1) {
            $conditions['FmsRequisition.branch_id'] = $branch_id;
        }
		$conditions['FmsRequisition.requested_by <>'] = $user['Auth']['User']['id'];
		$conditions['FmsRequisition.status'] = 'approved';
		
		$user = $this->Session->read();
		$this->loadModel('Employee');
		$emp = $this->Employee->find('first',array('conditions'=>array('Employee.user_id'=>$user['Auth']['User']['id'])));		
		$employees = $this->requestAction(array('controller' => 'holidays', 'action' => 'supervised'), array('pass' => array('emp_id'=>$emp['Employee']['id'])));
			
		$users=array();
		foreach($employees as $employee){
			$emp = $this->Employee->read(null,$employee);
			$users[] = $emp['Employee']['user_id'];
		}
		$empcond=array("OR "=>array("FmsRequisition.requested_by" => $users));
		$conditions = array_merge($empcond , $conditions);
		
		$this->FmsRequisition->recursive = 2;
		$this->set('fms_requisitions', $this->FmsRequisition->find('all', array('conditions' => $conditions, 'limit' => $limit, 'offset' => $start)));
		$this->set('results', $this->FmsRequisition->find('count', array('conditions' => $conditions)));
	}

	function view($id = null) {
		if (!$id) {
			$this->Session->setFlash(__('Invalid fleet requisition', true));
			$this->redirect(array('action' => 'index'));
		}
		$this->FmsRequisition->recursive = 2;
		$this->set('fmsRequisition', $this->FmsRequisition->read(null, $id));
	}

	function add($id = null) {
		if (!empty($this->data)) {
			$this->FmsRequisition->create();
			$this->autoRender = false;
			
			$user = $this->Session->read();
			$this->data['FmsRequisition']['requested_by'] = $user['Auth']['User']['id'];
			
			$this->loadModel('Employee');
			$emp = $this->Employee->find('first',array('conditions'=>array('Employee.user_id'=>$user['Auth']['User']['id'])));
			$emp_details = $this->Employee->EmployeeDetail->find('first',array('conditions'=>array('EmployeeDetail.employee_id'=>$emp['Employee']['id']),'order'=>'EmployeeDetail.start_date DESC'));
			$this->data['FmsRequisition']['branch_id'] = $emp_details['EmployeeDetail']['branch_id'];
			
			$this->data['FmsRequisition']['status'] = 'created';
			
			if ($this->FmsRequisition->save($this->data)) {
				$this->Session->setFlash(__('The fleet requisition has been saved', true), '');
				$this->render('/elements/success');
			} else {
				$this->Session->setFlash(__('The fleet requisition could not be saved. Please, try again.', true), '');
				$this->render('/elements/failure');
			}
		}
		if($id)
			$this->set('parent_id', $id);
		$branches = $this->FmsRequisition->Branch->find('list');
		$fms_vehicles = $this->FmsRequisition->FmsVehicle->find('list');
		$this->set(compact('branches', 'fms_vehicles'));
		
		$count = 0;
		$value = $this->FmsRequisition->find('first',array('conditions' => array('FmsRequisition.name LIKE' => date("Ymd").'%'),'order'=>'FmsRequisition.name DESC'));
		if($value != null){
			$value = explode('/',$value['FmsRequisition']['name']);		
			$count = $value[1];
		}		       
        $this->set('count',$count);
	}

	function edit($id = null, $parent_id = null) {
		if (!$id && empty($this->data)) {
			$this->Session->setFlash(__('Invalid fms requisition', true), '');
			$this->redirect(array('action' => 'index'));
		}
		if (!empty($this->data)) {
			$this->autoRender = false;
			if ($this->FmsRequisition->save($this->data)) {
				$this->Session->setFlash(__('The fleet requisition has been saved', true), '');
				$this->render('/elements/success');
			} else {
				$this->Session->setFlash(__('The fleet requisition could not be saved. Please, try again.', true), '');
				$this->render('/elements/failure');
			}
		}
		$this->set('fms_requisition', $this->FmsRequisition->read(null, $id));
		
		if($parent_id) {
			$this->set('parent_id', $parent_id);
		}
			
		$branches = $this->FmsRequisition->Branch->find('list');
		$fms_vehicles = $this->FmsRequisition->FmsVehicle->find('list');
		$this->set(compact('branches', 'fms_vehicles'));
	}
	
	function assign($id = null, $parent_id = null) {
		if (!$id && empty($this->data)) {
			$this->Session->setFlash(__('Invalid fms requisition', true), '');
			$this->redirect(array('action' => 'index'));
		}
		if (!empty($this->data)) {
			$this->autoRender = false;
			
			$user = $this->Session->read();
			$this->data['FmsRequisition']['status'] = 'assigned';
			$this->data['FmsRequisition']['transport_clerk'] = $user['Auth']['User']['id'];
			
			if ($this->FmsRequisition->save($this->data)) {
				$this->Session->setFlash(__('The fleet requisition has been assigned', true), '');
				$this->render('/elements/success');
			} else {
				$this->Session->setFlash(__('The fleet requisition could not be saved. Please, try again.', true), '');
				$this->render('/elements/failure');
			}
		}
		$this->set('fms_requisition', $this->FmsRequisition->read(null, $id));
		
		if($parent_id) {
			$this->set('parent_id', $parent_id);
		}
			
		$branches = $this->FmsRequisition->Branch->find('list');
		$fms_vehicles = $this->FmsRequisition->FmsVehicle->find('all');
		$this->set(compact('branches', 'fms_vehicles'));
	}

	function delete($id = null) {
		$this->autoRender = false;
		if (!$id) {
			$this->Session->setFlash(__('Invalid id for fms requisition', true), '');
			$this->render('/elements/failure');
		}
		if (stripos($id, '_') !== false) {
            $ids = explode('_', $id);
            try{
                foreach ($ids as $i) {
                    $this->FmsRequisition->delete($i);
                }
				$this->Session->setFlash(__('Fms requisition deleted', true), '');
				$this->render('/elements/success');
            }
            catch (Exception $e){
				$this->Session->setFlash(__('Fms requisition was not deleted', true), '');
				$this->render('/elements/failure');
            }
        } else {
            if ($this->FmsRequisition->delete($id)) {
				$this->Session->setFlash(__('Fms requisition deleted', true), '');
				$this->render('/elements/success');
			} else {
				$this->Session->setFlash(__('Fms requisition was not deleted', true), '');
				$this->render('/elements/failure');
			}
        }
	}
	
	function approve($id = null) {
        $this->autoRender = false;
        if (!$id) {
            $this->Session->setFlash(__('Invalid id for requisition', true), '');
            $this->render('/elements/failure');
        }
		$user = $this->Session->read();
		$this->FmsRequisition->read(null, $id);
		$this->FmsRequisition->set('status', 'approved');
		$this->FmsRequisition->set('approved_by', $user['Auth']['User']['id']);
		
        if ($this->FmsRequisition->save()) {
            $this->Session->setFlash(__('Requisition successfully approved', true), '');
            $this->render('/elements/success');
        } else {
            $this->Session->setFlash(__('Requisition was not successfully approved', true), '');
            $this->render('/elements/failure');
        }
    }
	
	function reject($id = null) {
        $this->autoRender = false;
        if (!$id) {
            $this->Session->setFlash(__('Invalid id for requisition', true), '');
            $this->render('/elements/failure');
        }
		$user = $this->Session->read();
		$this->FmsRequisition->read(null, $id);
		$this->FmsRequisition->set('status', 'rejected');
		$this->FmsRequisition->set('approved_by', $user['Auth']['User']['id']);
		
        if ($this->FmsRequisition->save()) {
            $this->Session->setFlash(__('Requisition successfully rejected', true), '');
            $this->render('/elements/success');
        } else {
            $this->Session->setFlash(__('Requisition was not successfully rejected', true), '');
            $this->render('/elements/failure');
        }
    }
}
?>