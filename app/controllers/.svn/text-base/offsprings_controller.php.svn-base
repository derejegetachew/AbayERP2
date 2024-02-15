<?php
class OffspringsController extends AppController {

	var $name = 'Offsprings';
	
	function index() {
		$employees = $this->Offspring->Employee->find('all');
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
            $conditions['Offspring.employee_id'] = $employee_id;
        }
		
		$this->set('offsprings', $this->Offspring->find('all', array('conditions' => $conditions, 'limit' => $limit, 'offset' => $start)));
		$this->set('results', $this->Offspring->find('count', array('conditions' => $conditions)));
	}

	function view($id = null) {
		if (!$id) {
			$this->Session->setFlash(__('Invalid offspring', true));
			$this->redirect(array('action' => 'index'));
		}
		$this->Offspring->recursive = 2;
		$this->set('offspring', $this->Offspring->read(null, $id));
	}

	function add($id = null) {
		if (!empty($this->data)) {
			$this->Offspring->create();
			$this->autoRender = false;
			if ($this->Offspring->save($this->data)) {
				$this->Session->setFlash(__('The offspring has been saved', true), '');
				$this->render('/elements/success');
			} else {
				$this->Session->setFlash(__('The offspring could not be saved. Please, try again.', true), '');
				$this->render('/elements/failure');
			}
		}
		if($id)
			$this->set('parent_id', $id);
		$employees = $this->Offspring->Employee->find('list');
		$this->set(compact('employees'));
	}

	function edit($id = null, $parent_id = null) {
		/*if (!$id && empty($this->data)) {
			$this->Session->setFlash(__('Invalid offspring', true), '');
			$this->redirect(array('action' => 'index'));
		}*/
		if (!empty($this->data)) {
			$this->autoRender = false;
			if ($this->Offspring->save($this->data)) {
				$this->Session->setFlash(__('The offspring has been saved', true), '');
				$this->render('/elements/success');
			} else {
				$this->Session->setFlash(__('The offspring could not be saved. Please, try again.', true), '');
				$this->render('/elements/failure');
			}
		}
		$this->set('offspring', $this->Offspring->read(null, $id));
		
		if($parent_id) {
			$this->set('parent_id', $parent_id);
		}
			
		$employees = $this->Offspring->Employee->find('list');
		$this->set(compact('employees'));
	}

	function delete($id = null) {
		$this->autoRender = false;
		if (!$id) {
			$this->Session->setFlash(__('Invalid id for offspring', true), '');
			$this->render('/elements/failure');
		}
		if (stripos($id, '_') !== false) {
            $ids = explode('_', $id);
            try{
                foreach ($ids as $i) {
                    $this->Offspring->delete($i);
                }
				$this->Session->setFlash(__('Offspring deleted', true), '');
				$this->render('/elements/success');
            }
            catch (Exception $e){
				$this->Session->setFlash(__('Offspring was not deleted', true), '');
				$this->render('/elements/failure');
            }
        } else {
            if ($this->Offspring->delete($id)) {
				$this->Session->setFlash(__('Offspring deleted', true), '');
				$this->render('/elements/success');
			} else {
				$this->Session->setFlash(__('Offspring was not deleted', true), '');
				$this->render('/elements/failure');
			}
        }
	}
}
?>