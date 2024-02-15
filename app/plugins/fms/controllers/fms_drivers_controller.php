<?php
class FmsDriversController extends AppController {

	var $name = 'FmsDrivers';
	
	function index() {
		//$people = $this->FmsDriver->Person->find('all');
		//$this->set(compact('people'));
	}
	
	function index2($id = null) {
		$this->set('parent_id', $id);
	}

	function search() {
	}
	
	function list_data($id = null) {
		$start = (isset($_REQUEST['start'])) ? $_REQUEST['start'] : 0;
		$limit = (isset($_REQUEST['limit'])) ? $_REQUEST['limit'] : 5;
		$person_id = (isset($_REQUEST['person_id'])) ? $_REQUEST['person_id'] : -1;
		if($id)
			$person_id = ($id) ? $id : -1;
        $conditions = (isset($_REQUEST['conditions'])) ? $_REQUEST['conditions'] : '';

        eval("\$conditions = array( " . $conditions . " );");
		if ($person_id != -1) {
            $conditions['FmsDriver.person_id'] = $person_id;
        }
		$this->FmsDriver->recursive = 2;
		$this->set('fms_drivers', $this->FmsDriver->find('all', array('conditions' => $conditions, 'limit' => $limit, 'offset' => $start)));
		$this->set('results', $this->FmsDriver->find('count', array('conditions' => $conditions)));
	}

	function view($id = null) {
		if (!$id) {
			$this->Session->setFlash(__('Invalid fms driver', true));
			$this->redirect(array('action' => 'index'));
		}
		$this->FmsDriver->recursive = 2;
		$this->set('fmsDriver', $this->FmsDriver->read(null, $id));
	}

	function add($id = null) {
		if (!empty($this->data)) {
			$this->FmsDriver->create();
			$this->autoRender = false;
			$user = $this->Session->read();
			$this->data['FmsDriver']['created_by'] = $user['Auth']['User']['id'];
			if ($this->FmsDriver->save($this->data)) {
				$this->Session->setFlash(__('The driver has been saved', true), '');
				$this->render('/elements/success');
			} else {
				$this->Session->setFlash(__('The driver could not be saved. Please, try again.', true), '');
				$this->render('/elements/failure');
			}
		}
		if($id)
			$this->set('parent_id', $id);
		$this->FmsDriver->Person->recursive = -1;
		$people = $this->FmsDriver->Person->find('all');
		$this->set(compact('people'));
	}

	function edit($id = null, $parent_id = null) {
		if (!$id && empty($this->data)) {
			$this->Session->setFlash(__('Invalid fms driver', true), '');
			$this->redirect(array('action' => 'index'));
		}
		if (!empty($this->data)) {
			$this->autoRender = false;
			if ($this->FmsDriver->save($this->data)) {
				$this->Session->setFlash(__('The fms driver has been saved', true), '');
				$this->render('/elements/success');
			} else {
				$this->Session->setFlash(__('The fms driver could not be saved. Please, try again.', true), '');
				$this->render('/elements/failure');
			}
		}
		$this->set('fms__driver', $this->FmsDriver->read(null, $id));
		
		if($parent_id) {
			$this->set('parent_id', $parent_id);
		}
			
		$people = $this->FmsDriver->Person->find('list');
		$this->set(compact('people'));
	}

	function delete($id = null) {
		$this->autoRender = false;
		if (!$id) {
			$this->Session->setFlash(__('Invalid id for fms driver', true), '');
			$this->render('/elements/failure');
		}
		if (stripos($id, '_') !== false) {
            $ids = explode('_', $id);
            try{
                foreach ($ids as $i) {
                    $this->FmsDriver->delete($i);
                }
				$this->Session->setFlash(__('Fms driver deleted', true), '');
				$this->render('/elements/success');
            }
            catch (Exception $e){
				$this->Session->setFlash(__('Fms driver was not deleted', true), '');
				$this->render('/elements/failure');
            }
        } else {
            if ($this->FmsDriver->delete($id)) {
				$this->Session->setFlash(__('Fms driver deleted', true), '');
				$this->render('/elements/success');
			} else {
				$this->Session->setFlash(__('Fms driver was not deleted', true), '');
				$this->render('/elements/failure');
			}
        }
	}
}
?>