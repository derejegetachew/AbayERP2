<?php
class HolidaysController extends AppController {

	var $name = 'Holidays';
	
	function index() {
		$employees = $this->Holiday->Employee->find('all');
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
            $conditions['Holiday.employee_id'] = $employee_id;
        }
		
		$this->set('holidays', $this->Holiday->find('all', array('conditions' => $conditions, 'limit' => $limit, 'offset' => $start)));
		$this->set('results', $this->Holiday->find('count', array('conditions' => $conditions)));
	}

	function view($id = null) {
		if (!$id) {
			$this->Session->setFlash(__('Invalid holiday', true));
			$this->redirect(array('action' => 'index'));
		}
		$this->Holiday->recursive = 2;
		$this->set('holiday', $this->Holiday->read(null, $id));
	}

	function add($id = null) {
		if (!empty($this->data)) {
			$this->Holiday->create();
			$this->autoRender = false;
			if ($this->Holiday->save($this->data)) {
				$this->Session->setFlash(__('The holiday has been saved', true), '');
				$this->render('/elements/success');
			} else {
				$this->Session->setFlash(__('The holiday could not be saved. Please, try again.', true), '');
				$this->render('/elements/failure');
			}
		}
		if($id)
		$this->set('parent_id', $id);
		$employees = $this->Holiday->Employee->find('list');
		$this->set(compact('employees'));
                $this->loadModel('Employee');    
           // $this->Employee->recursive = -3;
            $this->set('employee', $this->Employee->findByuser_id($this->Session->read('Auth.User.id'))); 
                
                                }

	function edit($id = null, $parent_id = null) {
		if (!$id && empty($this->data)) {
			$this->Session->setFlash(__('Invalid holiday', true), '');
			$this->redirect(array('action' => 'index'));
		}
		if (!empty($this->data)) {
			$this->autoRender = false;
			if ($this->Holiday->save($this->data)) {
				$this->Session->setFlash(__('The holiday has been saved', true), '');
				$this->render('/elements/success');
			} else {
				$this->Session->setFlash(__('The holiday could not be saved. Please, try again.', true), '');
				$this->render('/elements/failure');
			}
		}
		$this->set('holiday', $this->Holiday->read(null, $id));
		
		if($parent_id) {
			$this->set('parent_id', $parent_id);
		}
			
		$employees = $this->Holiday->Employee->find('list');
		$this->set(compact('employees'));
	}

	function delete($id = null) {
		$this->autoRender = false;
		if (!$id) {
			$this->Session->setFlash(__('Invalid id for holiday', true), '');
			$this->render('/elements/failure');
		}
		if (stripos($id, '_') !== false) {
            $ids = explode('_', $id);
            try{
                foreach ($ids as $i) {
                    $this->Holiday->delete($i);
                }
				$this->Session->setFlash(__('Holiday deleted', true), '');
				$this->render('/elements/success');
            }
            catch (Exception $e){
				$this->Session->setFlash(__('Holiday was not deleted', true), '');
				$this->render('/elements/failure');
            }
        } else {
            if ($this->Holiday->delete($id)) {
				$this->Session->setFlash(__('Holiday deleted', true), '');
				$this->render('/elements/success');
			} else {
				$this->Session->setFlash(__('Holiday was not deleted', true), '');
				$this->render('/elements/failure');
			}
        }
	}
}
?>