<?php
class PayrollEmployeesController extends AppController {

	var $name = 'PayrollEmployees';
	
	function index() {
		$payrolls = $this->PayrollEmployee->Payroll->find('all');
		$this->set(compact('payrolls'));
	}
	
	function index2($id = null) {
		$this->set('parent_id', $id);
	}

	function search() {
	}
	
	function list_data($id = null) {
		$start = (isset($_REQUEST['start'])) ? $_REQUEST['start'] : 0;
		$limit = (isset($_REQUEST['limit'])) ? $_REQUEST['limit'] : 5;
		$employee_id = (isset($_REQUEST['employee_id'])) ? $_REQUEST['employee_id'] : -1;
                
		if($id)
			$employee_id = ($id) ? $id : -1;
                
        $conditions = (isset($_REQUEST['conditions'])) ? $_REQUEST['conditions'] : '';

        eval("\$conditions = array( " . $conditions . " );");
	if ($employee_id != -1) {
            $conditions['PayrollEmployee.employee_id'] = $employee_id;
        }
		$this->PayrollEmployee->recursive = 3;
		$this->set('payroll_employees', $this->PayrollEmployee->find('all', array('conditions' => $conditions, 'limit' => $limit, 'offset' => $start)));
		$this->set('results', $this->PayrollEmployee->find('count', array('conditions' => $conditions)));
	}

	function view($id = null) {
		if (!$id) {
			$this->Session->setFlash(__('Invalid payroll employee', true));
			$this->redirect(array('action' => 'index'));
		}
		$this->PayrollEmployee->recursive = 2;
		$this->set('payrollEmployee', $this->PayrollEmployee->read(null, $id));
	}

	function add($id = null) {
		if (!empty($this->data)) {
			$this->PayrollEmployee->create();
			$this->autoRender = false;
			if ($this->PayrollEmployee->save($this->data)) {
				$this->Session->setFlash(__('The payroll employee has been saved', true), '');
				$this->render('/elements/success');
			} else {
				$this->Session->setFlash(__('The payroll employee could not be saved. Please, try again.', true), '');
				$this->render('/elements/failure');
			}
		}
		if($id)
			$this->set('parent_id', $id);
		$payrolls = $this->PayrollEmployee->Payroll->find('list');
		$employees = $this->PayrollEmployee->Employee->find('list');
		$this->set(compact('payrolls', 'employees'));
	}

	function add2($id = null) {
		if (!empty($this->data)) {
			$this->PayrollEmployee->create();
			$this->autoRender = false;
			if ($this->PayrollEmployee->save($this->data)) {
				$this->Session->setFlash(__('The payroll employee has been saved', true), '');
				$this->render('/elements/success');
			} else {
				$this->Session->setFlash(__('The payroll employee could not be saved. Please, try again.', true), '');
				$this->render('/elements/failure');
			}
		}
		if($id)
			$this->set('parent_id', $id);
		$payrolls = $this->PayrollEmployee->Payroll->find('list');
		$employees = $this->PayrollEmployee->Employee->find('list');
		$this->set(compact('payrolls', 'employees'));
	}
	
	function edit($id = null, $parent_id = null) {
		if (!$id && empty($this->data)) {
			$this->Session->setFlash(__('Invalid payroll employee', true), '');
			$this->redirect(array('action' => 'index'));
		}
		if (!empty($this->data)) {
			$this->autoRender = false;
			if ($this->PayrollEmployee->save($this->data)) {
				$this->Session->setFlash(__('The payroll employee has been saved', true), '');
				$this->render('/elements/success');
			} else {
				$this->Session->setFlash(__('The payroll employee could not be saved. Please, try again.', true), '');
				$this->render('/elements/failure');
			}
		}
		$this->set('payroll_employee', $this->PayrollEmployee->read(null, $id));
		
		if($parent_id) {
			$this->set('parent_id', $parent_id);
		}
			
		$payrolls = $this->PayrollEmployee->Payroll->find('list');
		$employees = $this->PayrollEmployee->Employee->find('list');
		$this->set(compact('payrolls', 'employees'));
	}

       function deactivate($id = null, $parent_id = null) {
		if (!$id && empty($this->data)) {
			$this->Session->setFlash(__('Invalid payroll employee', true), '');
			$this->redirect(array('action' => 'index'));
		}
		if (!empty($this->data)) {
			$this->autoRender = false;
			if ($this->PayrollEmployee->save($this->data)) {
				$this->Session->setFlash(__('The payroll employee has been saved', true), '');
				$this->render('/elements/success');
			} else {
				$this->Session->setFlash(__('The payroll employee could not be saved. Please, try again.', true), '');
				$this->render('/elements/failure');
			}
		}
		$this->set('payroll_employee', $this->PayrollEmployee->read(null, $id));
		
		if($parent_id) {
			$this->set('parent_id', $parent_id);
		}
			
		$payrolls = $this->PayrollEmployee->Payroll->find('list');
		$employees = $this->PayrollEmployee->Employee->find('list');
		$this->set(compact('payrolls', 'employees'));
	}
        
	function delete($id = null) {
		$this->autoRender = false;
		if (!$id) {
			$this->Session->setFlash(__('Invalid id for payroll employee', true), '');
			$this->render('/elements/failure');
		}
		if (stripos($id, '_') !== false) {
            $ids = explode('_', $id);
            try{
                foreach ($ids as $i) {
                    $this->PayrollEmployee->delete($i);
                }
				$this->Session->setFlash(__('Payroll employee deleted', true), '');
				$this->render('/elements/success');
            }
            catch (Exception $e){
				$this->Session->setFlash(__('Payroll employee was not deleted', true), '');
				$this->render('/elements/failure');
            }
        } else {
            if ($this->PayrollEmployee->delete($id)) {
				$this->Session->setFlash(__('Payroll employee deleted', true), '');
				$this->render('/elements/success');
			} else {
				$this->Session->setFlash(__('Payroll employee was not deleted', true), '');
				$this->render('/elements/failure');
			}
        }
	}
}
?>