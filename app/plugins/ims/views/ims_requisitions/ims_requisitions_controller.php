<?php
class ImsRequisitionsController extends AppController {

	var $name = 'ImsRequisitions';
	
	function index() {
		$budget_years = $this->ImsRequisition->BudgetYear->find('all');
		$this->set(compact('budget_years'));
	}
	
	function index_1() {
		$budget_years = $this->ImsRequisition->BudgetYear->find('all');
		$this->set(compact('budget_years'));
	}
	
	function index_2() {
		$budget_years = $this->ImsRequisition->BudgetYear->find('all');
		$this->set(compact('budget_years'));
	}
	
	function index2($id = null) {
		$this->set('parent_id', $id);
	}

	function search() {
	}
	
	function list_data($id = null) {
		$start = (isset($_REQUEST['start'])) ? $_REQUEST['start'] : 0;
		$limit = (isset($_REQUEST['limit'])) ? $_REQUEST['limit'] : 5;
		$budgetyear_id = (isset($_REQUEST['budgetyear_id'])) ? $_REQUEST['budgetyear_id'] : -1;
		if($id)
			$budgetyear_id = ($id) ? $id : -1;
        $conditions = (isset($_REQUEST['conditions'])) ? $_REQUEST['conditions'] : '';

        eval("\$conditions = array( " . $conditions . " );");
		if ($budgetyear_id != -1) {
            $conditions['ImsRequisition.budget_year_id'] = $budgetyear_id;
        }
		
		$conditions['ImsRequisition.status'] = 'approved';
		$this->ImsRequisition->recursive = 2;
		$test=$this->set('ims_requisitions', $this->ImsRequisition->find('all', array('conditions' => $conditions, 'limit' => $limit, 'offset' => $start)));		
		$this->set('results', $this->ImsRequisition->find('count', array('conditions' => $conditions)));
	}
	
	function list_data_1($id = null) {
		$start = (isset($_REQUEST['start'])) ? $_REQUEST['start'] : 0;
		$limit = (isset($_REQUEST['limit'])) ? $_REQUEST['limit'] : 5;
		$budgetyear_id = (isset($_REQUEST['budgetyear_id'])) ? $_REQUEST['budgetyear_id'] : -1;
		if($id)
			$budgetyear_id = ($id) ? $id : -1;			
        $conditions = (isset($_REQUEST['conditions'])) ? $_REQUEST['conditions'] : '';

        eval("\$conditions = array( " . $conditions . " );");
		$user = $this->Session->read();		
		if ($budgetyear_id != -1) {
			
            $conditions =array('ImsRequisition.budget_year_id' => $budgetyear_id);
        }
		$conditions['ImsRequisition.requested_by'] = $user['Auth']['User']['id'];
		$this->ImsRequisition->recursive = 2;
		$test=$this->set('ims_requisitions', $this->ImsRequisition->find('all', array('conditions' => $conditions, 'limit' => $limit, 'offset' => $start)));		
		$this->set('results', $this->ImsRequisition->find('count', array('conditions' => $conditions)));
	}
	
	function list_data_2($id = null) {
		$start = (isset($_REQUEST['start'])) ? $_REQUEST['start'] : 0;
		$limit = (isset($_REQUEST['limit'])) ? $_REQUEST['limit'] : 5;
		$budgetyear_id = (isset($_REQUEST['budgetyear_id'])) ? $_REQUEST['budgetyear_id'] : -1;
		if($id)
			$budgetyear_id = ($id) ? $id : -1;			
        $conditions = (isset($_REQUEST['conditions'])) ? $_REQUEST['conditions'] : '';

        eval("\$conditions = array( " . $conditions . " );");
		$user = $this->Session->read();		
		if ($budgetyear_id != -1) {
			
            $conditions =array('ImsRequisition.budget_year_id' => $budgetyear_id);
        }
		$conditions['ImsRequisition.requested_by <>'] = $user['Auth']['User']['id'];
		$conditions['ImsRequisition.status <>'] = 'created';
		
		$user = $this->Session->read();
		$this->loadModel('Employee');
		$emp = $this->Employee->find('first',array('conditions'=>array('Employee.user_id'=>$user['Auth']['User']['id'])));		
		$employees = $this->requestAction(array('controller' => 'holidays', 'action' => 'supervised'), array('pass' => array('emp_id'=>$emp['Employee']['id'])));
			
		$users=array();
		foreach($employees as $employee){
			$emp = $this->Employee->read(null,$employee);
			$users[] = $emp['Employee']['user_id'];
		}
		$empcond=array("OR "=>array("ImsRequisition.requested_by" => $users));
		$conditions = array_merge($empcond , $conditions);
		
		$this->ImsRequisition->recursive = 2;
		$test=$this->set('ims_requisitions', $this->ImsRequisition->find('all', array('conditions' => $conditions, 'limit' => $limit, 'offset' => $start)));		
		$this->set('results', $this->ImsRequisition->find('count', array('conditions' => $conditions)));
	}

	function view($id = null) {
		if (!$id) {
			$this->Session->setFlash(__('Invalid requisition', true));
			$this->redirect(array('action' => 'index'));
		}
		$this->ImsRequisition->recursive = 2;
		$this->set('imsRequisition', $this->ImsRequisition->read(null, $id));
	}

	function add($id = null) {
		if (!empty($this->data)) {
			$this->ImsRequisition->create();
			$this->autoRender = false;
			
			$budget_year;
			$date = new DateTime("now");		
			$this->ImsRequisition->BudgetYear->recursive = 0;
			$budget_years = $this->ImsRequisition->BudgetYear->find('all');
			foreach($budget_years as $budget_year){			
				if(!empty($budget_year))
				{
					if(new DateTime($budget_year['BudgetYear']['to_date'])>($date))
					{
						$budget_year =$budget_year['BudgetYear'];
						$this->data['ImsRequisition']['budget_year_id'] = $budget_year['id'];
					}
				}
			}
			
			$user = $this->Session->read();
			$this->data['ImsRequisition']['requested_by'] = $user['Auth']['User']['id'];
			
			$this->loadModel('Employee');
			$emp = $this->Employee->find('first',array('conditions'=>array('Employee.user_id'=>$user['Auth']['User']['id'])));
			$emp_details = $this->Employee->EmployeeDetail->find('first',array('conditions'=>array('EmployeeDetail.employee_id'=>$emp['Employee']['id']),'order'=>'EmployeeDetail.start_date DESC'));
			$this->data['ImsRequisition']['branch_id'] = $emp_details['EmployeeDetail']['branch_id'];
			
			$this->data['ImsRequisition']['status'] = 'created';
			
			if ($this->ImsRequisition->save($this->data)) {
				$this->Session->setFlash(__('The requisition has been saved', true) . '::' . $this->ImsRequisition->id, '');
				$this->render('/elements/success_po');
			} else {
				$this->Session->setFlash(__('The requisition could not be saved. Please, try again.', true), '');
				$this->render('/elements/failure');
			}
		}
		if($id)
			$this->set('parent_id', $id);
		$budget_years = $this->ImsRequisition->BudgetYear->find('list');
		$branches = $this->ImsRequisition->Branch->find('list');
		$this->set(compact('budget_years', 'branches'));
		
		$count = $this->ImsRequisition->find('count',array('conditions' => array('ImsRequisition.name LIKE' => date("Ymd").'%')));       
        $this->set('count',$count);
	}
	
	function add_manual_requisitions($id = null) {
		if (!empty($this->data)) {
			$this->ImsRequisition->create();
			$this->autoRender = false;
			
			$budget_year;
			$date = new DateTime("now");		
			$this->ImsRequisition->BudgetYear->recursive = 0;
			$budget_years = $this->ImsRequisition->BudgetYear->find('all');
			foreach($budget_years as $budget_year){			
				if(!empty($budget_year))
				{
					if(new DateTime($budget_year['BudgetYear']['to_date'])>($date))
					{
						$budget_year =$budget_year['BudgetYear'];
						$this->data['ImsRequisition']['budget_year_id'] = $budget_year['id'];
					}
				}
			}
			
			$user = $this->Session->read();
			$this->data['ImsRequisition']['requested_by'] = $user['Auth']['User']['id'];
			$this->data['ImsRequisition']['approved_rejected_by'] = $user['Auth']['User']['id'];
			
			$this->data['ImsRequisition']['status'] = 'approved';
			
			if ($this->ImsRequisition->save($this->data)) {
				$this->Session->setFlash(__('The requisition has been saved', true) . '::' . $this->ImsRequisition->id, '');
				$this->render('/elements/success_po');
			} else {
				$this->Session->setFlash(__('The requisition could not be saved. Please, try again.', true), '');
				$this->render('/elements/failure');
			}
		}
		if($id)
			$this->set('parent_id', $id);
		$budget_years = $this->ImsRequisition->BudgetYear->find('list');
		$branches = $this->ImsRequisition->Branch->find('all');
		$this->set(compact('budget_years', 'branches'));
	}

	function edit($id = null, $parent_id = null) {
		if (!$id && empty($this->data)) {
			$this->Session->setFlash(__('Invalid ims requisition', true), '');
			$this->redirect(array('action' => 'index'));
		}
		if (!empty($this->data)) {
			$this->autoRender = false;
			if ($this->ImsRequisition->save($this->data)) {
				$this->Session->setFlash(__('The ims requisition has been saved', true), '');
				$this->render('/elements/success');
			} else {
				$this->Session->setFlash(__('The ims requisition could not be saved. Please, try again.', true), '');
				$this->render('/elements/failure');
			}
		}
		$this->set('ims_requisition', $this->ImsRequisition->read(null, $id));
		
		if($parent_id) {
			$this->set('parent_id', $parent_id);
		}
			
		$budget_years = $this->ImsRequisition->BudgetYear->find('list');
		$branches = $this->ImsRequisition->Branch->find('list');
		$this->set(compact('budget_years', 'branches'));
	}
	
	function edit_manual_requisitions($id = null, $parent_id = null) {
		if (!$id && empty($this->data)) {
			$this->Session->setFlash(__('Invalid requisition', true), '');
			$this->redirect(array('action' => 'index'));
		}
		if (!empty($this->data)) {
			$this->autoRender = false;
			if ($this->ImsRequisition->save($this->data)) {
				$this->Session->setFlash(__('The ims requisition has been saved', true), '');
				$this->render('/elements/success');
			} else {
				$this->Session->setFlash(__('The ims requisition could not be saved. Please, try again.', true), '');
				$this->render('/elements/failure');
			}
		}
		$this->set('ims_requisition', $this->ImsRequisition->read(null, $id));
		
		if($parent_id) {
			$this->set('parent_id', $parent_id);
		}
			
		$budget_years = $this->ImsRequisition->BudgetYear->find('list');
		$branches = $this->ImsRequisition->Branch->find('all');
		$this->set(compact('budget_years', 'branches'));
	}

	function delete($id = null) {
		$this->autoRender = false;
		if (!$id) {
			$this->Session->setFlash(__('Invalid id for ims requisition', true), '');
			$this->render('/elements/failure');
		}
		if (stripos($id, '_') !== false) {
            $ids = explode('_', $id);
            try{
                foreach ($ids as $i) {
                    $this->ImsRequisition->delete($i);
                }
				$this->Session->setFlash(__('Ims requisition deleted', true), '');
				$this->render('/elements/success');
            }
            catch (Exception $e){
				$this->Session->setFlash(__('Ims requisition was not deleted', true), '');
				$this->render('/elements/failure');
            }
        } else {
            if ($this->ImsRequisition->delete($id)) {
				$this->Session->setFlash(__('Ims requisition deleted', true), '');
				$this->render('/elements/success');
			} else {
				$this->Session->setFlash(__('Ims requisition was not deleted', true), '');
				$this->render('/elements/failure');
			}
        }
	}
	
	function post($id = null) {
        $this->autoRender = false;
        if (!$id) {
            $this->Session->setFlash(__('Invalid id for requisition', true), '');
            $this->render('/elements/failure');
        }
        $requisition = array('ImsRequisition' => array('id' => $id, 'status' => 'posted'));
        if ($this->ImsRequisition->save($requisition)) {
            $this->Session->setFlash(__('requisition posted for approval', true), '');
            $this->render('/elements/success');
        } else {
            $this->Session->setFlash(__('requisition was not posted for approval', true), '');
            $this->render('/elements/failure');
        }
    }
	
	function approve($id = null) {
        $this->autoRender = false;
        if (!$id) {
            $this->Session->setFlash(__('Invalid id for requisition', true), '');
            $this->render('/elements/failure');
        }
		$user = $this->Session->read();		
        $requisition = array('ImsRequisition' => array('id' => $id, 'approved_rejected_by' => $user['Auth']['User']['id'],'status' => 'approved'));
        if ($this->ImsRequisition->save($requisition)) {
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
        $requisition = array('ImsRequisition' => array('id' => $id, 'approved_rejected_by' => $user['Auth']['User']['id'],'status' => 'rejected'));
        if ($this->ImsRequisition->save($requisition)) {
            $this->Session->setFlash(__('Requisition successfully rejected', true), '');
            $this->render('/elements/success');
        } else {
            $this->Session->setFlash(__('Requisition was not successfully rejected', true), '');
            $this->render('/elements/failure');
        }
    }
}
?>