<?php
class LanguagesController extends AppController {

	var $name = 'Languages';
	
	function index() {
		$employees = $this->Language->Employee->find('all');
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
            $conditions['Language.employee_id'] = $employee_id;
        }
		
		$this->set('languages', $this->Language->find('all', array('conditions' => $conditions, 'limit' => $limit, 'offset' => $start)));
		$this->set('results', $this->Language->find('count', array('conditions' => $conditions)));
	}
	function list_language($id = null) {
		$start = (isset($_REQUEST['start'])) ? $_REQUEST['start'] : 0;
		$limit = (isset($_REQUEST['limit'])) ? $_REQUEST['limit'] : 5;
		$employee_id = (isset($_REQUEST['employee_id'])) ? $_REQUEST['employee_id'] : -1;
		if($id)
			$employee_id = ($id) ? $id : -1;
        $conditions = (isset($_REQUEST['conditions'])) ? $_REQUEST['conditions'] : '';

        eval("\$conditions = array( " . $conditions . " );");
		if ($employee_id != -1) {
            $conditions['Language.employee_id'] = $employee_id;
        }
		
		$this->set('languages', $this->Language->find('all', array('conditions' => $conditions, 'limit' => $limit, 'offset' => $start,'group' => 'name')));
		$this->set('results', $this->Language->find('count', array('conditions' => $conditions)));
	}
	function view($id = null) {
		if (!$id) {
			$this->Session->setFlash(__('Invalid language', true));
			$this->redirect(array('action' => 'index'));
		}
		$this->Language->recursive = 2;
		$this->set('language', $this->Language->read(null, $id));
	}

	function add($id = null) {
		if (!empty($this->data)) {
			$this->Language->create();
			$this->autoRender = false;
			if ($this->Language->save($this->data)) {
				$this->Session->setFlash(__('The language has been saved', true), '');
				$this->render('/elements/success');
			} else {
				$this->Session->setFlash(__('The language could not be saved. Please, try again.', true), '');
				$this->render('/elements/failure');
			}
		}
		if($id)
			$this->set('parent_id', $id);
		$employees = $this->Language->Employee->find('list');
		$this->set(compact('employees'));
	}

	function edit($id = null, $parent_id = null) {
		if (!$id && empty($this->data)) {
			$this->Session->setFlash(__('Invalid language', true), '');
			$this->redirect(array('action' => 'index'));
		}
		if (!empty($this->data)) {
			$this->autoRender = false;
			if ($this->Language->save($this->data)) {
				$this->Session->setFlash(__('The language has been saved', true), '');
				$this->render('/elements/success');
			} else {
				$this->Session->setFlash(__('The language could not be saved. Please, try again.', true), '');
				$this->render('/elements/failure');
			}
		}
		$this->set('language', $this->Language->read(null, $id));
		
		if($parent_id) {
			$this->set('parent_id', $parent_id);
		}
			
		$employees = $this->Language->Employee->find('list');
		$this->set(compact('employees'));
	}

	function delete($id = null) {
		$this->autoRender = false;
		if (!$id) {
			$this->Session->setFlash(__('Invalid id for language', true), '');
			$this->render('/elements/failure');
		}
		if (stripos($id, '_') !== false) {
            $ids = explode('_', $id);
            try{
                foreach ($ids as $i) {
                    $this->Language->delete($i);
                }
				$this->Session->setFlash(__('Language deleted', true), '');
				$this->render('/elements/success');
            }
            catch (Exception $e){
				$this->Session->setFlash(__('Language was not deleted', true), '');
				$this->render('/elements/failure');
            }
        } else {
            if ($this->Language->delete($id)) {
				$this->Session->setFlash(__('Language deleted', true), '');
				$this->render('/elements/success');
			} else {
				$this->Session->setFlash(__('Language was not deleted', true), '');
				$this->render('/elements/failure');
			}
        }
	}
}
?>