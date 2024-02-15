<?php
class TerminationsController extends AppController {

	var $name = 'Terminations';
	
	function index() {
		$employees = $this->Termination->Employee->find('all');
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
            $conditions['Termination.employee_id'] = $employee_id;
        }
		
		$this->set('terminations', $this->Termination->find('all', array('conditions' => $conditions, 'limit' => $limit, 'offset' => $start)));
		$this->set('results', $this->Termination->find('count', array('conditions' => $conditions)));
	}

	function view($id = null) {
		if (!$id) {
			$this->Session->setFlash(__('Invalid termination', true));
			$this->redirect(array('action' => 'index'));
		}
		$this->Termination->recursive = 2;
		$this->set('termination', $this->Termination->read(null, $id));
	}

	function add($id = null) {
            
		if (!empty($this->data)) {
                    $num = $this->Termination->find('count', array('conditions' => array('employee_id' => $this->data['Termination']['employee_id'])));
                    if ($num <= 0) {
			$this->Termination->create();
			$this->autoRender = false;
			if ($this->Termination->save($this->data)) {
                            $this->data['Employee']['status']='deactivated';
                            $this->data['Employee']['id']=$this->data['Termination']['employee_id'];
                            $this->Termination->Employee->save($this->data);
							  $this->loadModel('Employee');
        $this->Employee->recursive = 1;
        $emp = $this->Employee->findById($this->data['Employee']['id']);
		$this->array_sort_by_column($emp['EmployeeDetail'], "start_date", SORT_ASC);
		   if(count($emp['EmployeeDetail'])>0)
$cntempd=count($emp['EmployeeDetail'])-1;
else
$cntempd=count($emp['EmployeeDetail']);
               $last=$emp['EmployeeDetail'][$cntempd];
			   $this->data['EmployeeDetail']['id']=$last['id'];
			   			   $this->data['EmployeeDetail']['end_date']=$this->data['Termination']['date'];
			   $this->loadModel('EmployeeDetail');
			   $this->EmployeeDetail->save($this->data);
				$this->Session->setFlash(__('The termination has been saved', true), '');
				$this->render('/elements/success');
			} else {
				$this->Session->setFlash(__('The termination could not be saved. Please, try again.', true), '');
				$this->render('/elements/failure');
			}
                    }else {
				$this->Session->setFlash(__('Employee Already Terminated.', true), '');
				$this->render('/elements/failure');
			}
		}
                    if ($id) {
                        $num = $this->Termination->find('count', array('conditions' => array('employee_id' => $id)));
                        if ($num > 0) {
                            $this->autoRender = false;
                            //$this->Session->setFlash(__('Emloyee Already Terminated', true), '');
                            //$this->render('/elements/failure');
                            echo 'terminated';
                        }
                    }
		if($id)
			$this->set('parent_id', $id);
		$employees = $this->Termination->Employee->find('list');
		$this->set(compact('employees'));
	}

	function edit($id = null, $parent_id = null) {
		if (!$id && empty($this->data)) {
			$this->Session->setFlash(__('Invalid termination', true), '');
			$this->redirect(array('action' => 'index'));
		}
		if (!empty($this->data)) {
			$this->autoRender = false;
			if ($this->Termination->save($this->data)) {
				$this->Session->setFlash(__('The termination has been saved', true), '');
				$this->render('/elements/success');
			} else {
				$this->Session->setFlash(__('The termination could not be saved. Please, try again.', true), '');
				$this->render('/elements/failure');
			}
		}
		$this->set('termination', $this->Termination->read(null, $id));
		
		if($parent_id) {
			$this->set('parent_id', $parent_id);
		}
			
		$employees = $this->Termination->Employee->find('list');
		$this->set(compact('employees'));
	}

	function delete($id = null) {
		$this->autoRender = false;
		if (!$id) {
			$this->Session->setFlash(__('Invalid id for termination', true), '');
			$this->render('/elements/failure');
		}
		if (stripos($id, '_') !== false) {
            $ids = explode('_', $id);
            try{
                foreach ($ids as $i) {
                    $this->Termination->delete($i);
                }
				$this->Session->setFlash(__('Termination deleted', true), '');
				$this->render('/elements/success');
            }
            catch (Exception $e){
				$this->Session->setFlash(__('Termination was not deleted', true), '');
				$this->render('/elements/failure');
            }
        } else {
            if ($this->Termination->delete($id)) {
				$this->Session->setFlash(__('Termination deleted', true), '');
				$this->render('/elements/success');
			} else {
				$this->Session->setFlash(__('Termination was not deleted', true), '');
				$this->render('/elements/failure');
			}
        }
	}
}
?>