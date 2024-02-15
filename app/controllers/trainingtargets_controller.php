<?php
class TrainingtargetsController extends AppController {

	var $name = 'Trainingtargets';
	
	function index() {
	}
	

	function search() {
	}
	
	function list_data($id = null) {
		$start = (isset($_REQUEST['start'])) ? $_REQUEST['start'] : 0;
		$limit = (isset($_REQUEST['limit'])) ? $_REQUEST['limit'] : 5;
        $conditions = (isset($_REQUEST['conditions'])) ? $_REQUEST['conditions'] : '';

        eval("\$conditions = array( " . $conditions . " );");
		
		$this->set('trainingtargets', $this->Trainingtarget->find('all', array('conditions' => $conditions, 'limit' => $limit, 'offset' => $start)));
		$this->set('results', $this->Trainingtarget->find('count', array('conditions' => $conditions)));
	}

	function view($id = null) {
		if (!$id) {
			$this->Session->setFlash(__('Invalid trainingtarget', true));
			$this->redirect(array('action' => 'index'));
		}
		$this->Trainingtarget->recursive = 2;
		$this->set('trainingtarget', $this->Trainingtarget->read(null, $id));
	}

	function add($id = null) {
		if (!empty($this->data)) {
			$this->Trainingtarget->create();
			$this->autoRender = false;
			if ($this->Trainingtarget->save($this->data)) {
				$this->Session->setFlash(__('The trainingtarget has been saved', true), '');
				$this->render('/elements/success');
			} else {
				$this->Session->setFlash(__('The trainingtarget could not be saved. Please, try again.', true), '');
				$this->render('/elements/failure');
			}
		}
	}

	function edit($id = null, $parent_id = null) {
		if (!$id && empty($this->data)) {
			$this->Session->setFlash(__('Invalid trainingtarget', true), '');
			$this->redirect(array('action' => 'index'));
		}
		if (!empty($this->data)) {
			$this->autoRender = false;
			if ($this->Trainingtarget->save($this->data)) {
				$this->Session->setFlash(__('The trainingtarget has been saved', true), '');
				$this->render('/elements/success');
			} else {
				$this->Session->setFlash(__('The trainingtarget could not be saved. Please, try again.', true), '');
				$this->render('/elements/failure');
			}
		}
		$this->set('trainingtarget', $this->Trainingtarget->read(null, $id));
		
			
	}

	function delete($id = null) {
		$this->autoRender = false;
		if (!$id) {
			$this->Session->setFlash(__('Invalid id for trainingtarget', true), '');
			$this->render('/elements/failure');
		}
		if (stripos($id, '_') !== false) {
            $ids = explode('_', $id);
            try{
                foreach ($ids as $i) {
                    $this->Trainingtarget->delete($i);
                }
				$this->Session->setFlash(__('Trainingtarget deleted', true), '');
				$this->render('/elements/success');
            }
            catch (Exception $e){
				$this->Session->setFlash(__('Trainingtarget was not deleted', true), '');
				$this->render('/elements/failure');
            }
        } else {
            if ($this->Trainingtarget->delete($id)) {
				$this->Session->setFlash(__('Trainingtarget deleted', true), '');
				$this->render('/elements/success');
			} else {
				$this->Session->setFlash(__('Trainingtarget was not deleted', true), '');
				$this->render('/elements/failure');
			}
        }
	}
}
?>