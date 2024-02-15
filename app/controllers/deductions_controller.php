<?php
class DeductionsController extends AppController {

	var $name = 'Deductions';
	
	function index() {
		$grades = $this->Deduction->Grade->find('all');
		$this->set(compact('grades'));
	}
	
	function index2($id = null) {
		$this->set('parent_id', $id);
	}
        function index22($id = null) {
		$this->set('parent_id', $id);
	}
	function search() {
	}
	
	function list_data($id = null) {
		$start = (isset($_REQUEST['start'])) ? $_REQUEST['start'] : 0;
		$limit = (isset($_REQUEST['limit'])) ? $_REQUEST['limit'] : 5;
		$grade_id = (isset($_REQUEST['grade_id'])) ? $_REQUEST['grade_id'] : -1;
		if($id)
			$grade_id = ($id) ? $id : -1;
        $conditions = (isset($_REQUEST['conditions'])) ? $_REQUEST['conditions'] : '';

        eval("\$conditions = array( " . $conditions . " );");
		if ($grade_id != -1) {
            $conditions['Deduction.grade_id'] = $grade_id;
        }
         $conditions['Deduction.payroll_id'] = $this->Session->read('Auth.User.payroll_id');
		$conditions['Deduction.status'] = 'active';
		$this->set('deductions', $this->Deduction->find('all', array('conditions' => $conditions, 'limit' => $limit, 'offset' => $start)));
		$this->set('results', $this->Deduction->find('count', array('conditions' => $conditions)));
	}
	function list_data2($id = null) {
		$start = (isset($_REQUEST['start'])) ? $_REQUEST['start'] : 0;
		$limit = (isset($_REQUEST['limit'])) ? $_REQUEST['limit'] : 5;
			$employee_id = (isset($_REQUEST['employee_id'])) ? $_REQUEST['employee_id'] : -1;
		if($id)
			$employee_id = ($id) ? $id : -1;
        $conditions = (isset($_REQUEST['conditions'])) ? $_REQUEST['conditions'] : '';

        eval("\$conditions = array( " . $conditions . " );");
		if ($employee_id != -1) {
            $conditions['Deduction.employee_id'] = $employee_id;
        }
         $conditions['Deduction.payroll_id'] = $this->Session->read('Auth.User.payroll_id');
		$conditions['Deduction.status'] = 'active';
		$this->set('deductions', $this->Deduction->find('all', array('conditions' => $conditions, 'limit' => $limit, 'offset' => $start)));
		$this->set('results', $this->Deduction->find('count', array('conditions' => $conditions)));
	}
	function view($id = null) {
		if (!$id) {
			$this->Session->setFlash(__('Invalid deduction', true));
			$this->redirect(array('action' => 'index'));
		}
		$this->Deduction->recursive = 2;
		$this->set('deduction', $this->Deduction->read(null, $id));
	}

	function add($id = null) {
		if (!empty($this->data)) {
			$this->Deduction->create();
			$this->autoRender = false;
			if ($this->Deduction->save($this->data)) {
				$this->Session->setFlash(__('The deduction has been saved', true), '');
				$this->render('/elements/success');
			} else {
				$this->Session->setFlash(__('The deduction could not be saved. Please, try again.', true), '');
				$this->render('/elements/failure');
			}
		}
		if($id)
			$this->set('parent_id', $id);
		$grades = $this->Deduction->Grade->find('list');
                $payrolls = $this->Deduction->Payroll->find('list');
		$this->set(compact('grades','payrolls'));
	}
	function add2($id = null) {
		if (!empty($this->data)) {
			$this->Deduction->create();
			$this->autoRender = false;
			if ($this->Deduction->save($this->data)) {
				$this->Session->setFlash(__('The deduction has been saved', true), '');
				$this->render('/elements/success');
			} else {
				$this->Session->setFlash(__('The deduction could not be saved. Please, try again.', true), '');
				$this->render('/elements/failure');
			}
		}
		if($id)
			$this->set('parent_id', $id);
		$employees = $this->Deduction->Employee->find('list');
                $payrolls = $this->Deduction->Payroll->find('list');
		$this->set(compact('grades','payrolls'));
	}
	function edit($id = null, $parent_id = null) {
		if (!$id && empty($this->data)) {
			$this->Session->setFlash(__('Invalid deduction', true), '');
			$this->redirect(array('action' => 'index'));
		}
		if (!empty($this->data)) {
			$this->autoRender = false;
			if ($this->Deduction->save($this->data)) {
				$this->Session->setFlash(__('The deduction has been saved', true), '');
				$this->render('/elements/success');
			} else {
				$this->Session->setFlash(__('The deduction could not be saved. Please, try again.', true), '');
				$this->render('/elements/failure');
			}
		}
		$this->set('deduction', $this->Deduction->read(null, $id));
		
		if($parent_id) {
			$this->set('parent_id', $parent_id);
		}
			
		$grades = $this->Deduction->Grade->find('list');
		$this->set(compact('grades'));
	}
	function remove($id = null) {
                 $this->autoRender = false;
		if (!$id) {
			$this->Session->setFlash(__('Invalid benefit', true), '');
			$this->redirect(array('action' => 'index'));
		}
		
                        $this->data['Deduction']['status']='removed';
                        $this->data['Deduction']['id']=$id;
			if ($this->Deduction->save($this->data)) {
				$this->Session->setFlash(__('The benefit has been removed', true), '');
				$this->render('/elements/success');
			} else {
				$this->Session->setFlash(__('The benefit could not be removed. Please, try again.', true), '');
				$this->render('/elements/failure');
			}

	}
	function delete($id = null) {
		$this->autoRender = false;
		if (!$id) {
			$this->Session->setFlash(__('Invalid id for deduction', true), '');
			$this->render('/elements/failure');
		}
		if (stripos($id, '_') !== false) {
            $ids = explode('_', $id);
            try{
                foreach ($ids as $i) {
                    $this->Deduction->delete($i);
                }
				$this->Session->setFlash(__('Deduction deleted', true), '');
				$this->render('/elements/success');
            }
            catch (Exception $e){
				$this->Session->setFlash(__('Deduction was not deleted', true), '');
				$this->render('/elements/failure');
            }
        } else {
            if ($this->Deduction->delete($id)) {
				$this->Session->setFlash(__('Deduction deleted', true), '');
				$this->render('/elements/success');
			} else {
				$this->Session->setFlash(__('Deduction was not deleted', true), '');
				$this->render('/elements/failure');
			}
        }
	}
}
?>