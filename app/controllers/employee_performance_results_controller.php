<?php
class EmployeePerformanceResultsController extends AppController {

	var $name = 'EmployeePerformanceResults';
	
	function index() {
		$employees = $this->EmployeePerformanceResult->Employee->find('all');
		$this->set(compact('employees'));
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
            $conditions['EmployeePerformanceResult.employee_id'] = $employee_id;
        }
		
		$this->set('employeePerformanceResults', $this->EmployeePerformanceResult->find('all', array('conditions' => $conditions, 'limit' => $limit, 'offset' => $start)));
		$this->set('results', $this->EmployeePerformanceResult->find('count', array('conditions' => $conditions)));
	}

	function view($id = null) {
		if (!$id) {
			$this->Session->setFlash(__('Invalid employee performance result', true));
			$this->redirect(array('action' => 'index'));
		}
		$this->EmployeePerformanceResult->recursive = 2;
		$this->set('employeePerformanceResult', $this->EmployeePerformanceResult->read(null, $id));
	}

	function add($id = null) {
		if (!empty($this->data)) {
			$this->EmployeePerformanceResult->create();
			$this->autoRender = false;
			if ($this->EmployeePerformanceResult->save($this->data)) {
				$this->Session->setFlash(__('The employee performance result has been saved', true), '');
				$this->render('/elements/success');
			} else {
				$this->Session->setFlash(__('The employee performance result could not be saved. Please, try again.', true), '');
				$this->render('/elements/failure');
			}
		}
		if($id)
			$this->set('parent_id', $id);
		$employees = $this->EmployeePerformanceResult->Employee->find('list');
		$employee_performances = $this->EmployeePerformanceResult->EmployeePerformance->find('list');
		$performance_lists = $this->EmployeePerformanceResult->PerformanceList->find('list');
		$performance_list_choices = $this->EmployeePerformanceResult->PerformanceListChoice->find('list');
		$this->set(compact('employees', 'employee_performances', 'performance_lists', 'performance_list_choices'));
	}

	function edit($id = null, $parent_id = null) {
		if (!$id && empty($this->data)) {
			$this->Session->setFlash(__('Invalid employee performance result', true), '');
			$this->redirect(array('action' => 'index'));
		}
		if (!empty($this->data)) {
			$this->autoRender = false;
			if ($this->EmployeePerformanceResult->save($this->data)) {
				$this->Session->setFlash(__('The employee performance result has been saved', true), '');
				$this->render('/elements/success');
			} else {
				$this->Session->setFlash(__('The employee performance result could not be saved. Please, try again.', true), '');
				$this->render('/elements/failure');
			}
		}
		$this->set('employee__performance__result', $this->EmployeePerformanceResult->read(null, $id));
		
		if($parent_id) {
			$this->set('parent_id', $parent_id);
		}
			
		$employees = $this->EmployeePerformanceResult->Employee->find('list');
		$employee_performances = $this->EmployeePerformanceResult->EmployeePerformance->find('list');
		$performance_lists = $this->EmployeePerformanceResult->PerformanceList->find('list');
		$performance_list_choices = $this->EmployeePerformanceResult->PerformanceListChoice->find('list');
		$this->set(compact('employees', 'employee_performances', 'performance_lists', 'performance_list_choices'));
	}

	function delete($id = null) {
		$this->autoRender = false;
		if (!$id) {
			$this->Session->setFlash(__('Invalid id for employee performance result', true), '');
			$this->render('/elements/failure');
		}
		if (stripos($id, '_') !== false) {
            $ids = explode('_', $id);
            try{
                foreach ($ids as $i) {
                    $this->EmployeePerformanceResult->delete($i);
                }
				$this->Session->setFlash(__('Employee performance result deleted', true), '');
				$this->render('/elements/success');
            }
            catch (Exception $e){
				$this->Session->setFlash(__('Employee performance result was not deleted', true), '');
				$this->render('/elements/failure');
            }
        } else {
            if ($this->EmployeePerformanceResult->delete($id)) {
				$this->Session->setFlash(__('Employee performance result deleted', true), '');
				$this->render('/elements/success');
			} else {
				$this->Session->setFlash(__('Employee performance result was not deleted', true), '');
				$this->render('/elements/failure');
			}
        }
	}
}
?>