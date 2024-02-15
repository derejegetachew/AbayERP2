<?php
class ConfirmationsController extends AppController {

	var $name = 'Confirmations';
	
	function index() {
		$this->Confirmation->User->recursive = -1;
		$users = $this->Confirmation->User->find('all');
		$this->set(compact('users'));
	}
	
	function index2($id = null) {
		$this->set('parent_id', $id);
	}

	function search() {
	}
	
	function list_data($id = null) {
		$start = (isset($_REQUEST['start'])) ? $_REQUEST['start'] : 0;
		$limit = (isset($_REQUEST['limit'])) ? $_REQUEST['limit'] : 5;
		$user_id = (isset($_REQUEST['user_id'])) ? $_REQUEST['user_id'] : -1;
		if($id)
			$user_id = ($id) ? $id : -1;
        $conditions = (isset($_REQUEST['conditions'])) ? $_REQUEST['conditions'] : '';

        eval("\$conditions = array( " . $conditions . " );");
		if ($user_id != -1) {
            $conditions['Confirmation.user_id'] = $user_id;
        }
		$this->Confirmation->recursive=2;
		$this->set('confirmations', $this->Confirmation->find('all', array('conditions' => $conditions, 'limit' => $limit, 'offset' => $start)));
		$this->set('results', $this->Confirmation->find('count', array('conditions' => $conditions)));
	}

	function view($id = null) {
		if (!$id) {
			$this->Session->setFlash(__('Invalid confirmation', true));
			$this->redirect(array('action' => 'index'));
		}
		$this->Confirmation->recursive = 2;
		$this->set('confirmation', $this->Confirmation->read(null, $id));
	}

	function add($id = null) {
		if (!empty($this->data)) {
			$this->Confirmation->create();
			$this->autoRender = false;
			if ($this->Confirmation->save($this->data)) {
				$this->Session->setFlash(__('The confirmation has been saved', true), '');
				$this->render('/elements/success');
			} else {
				$this->Session->setFlash(__('The confirmation could not be saved. Please, try again.', true), '');
				$this->render('/elements/failure');
			}
		}
		if($id)
			$this->set('parent_id', $id);
		$users = $this->Confirmation->User->find('list');
		$this->set(compact('users'));
	}

	function edit($id = null, $parent_id = null) {
		if (!$id && empty($this->data)) {
			$this->Session->setFlash(__('Invalid confirmation', true), '');
			$this->redirect(array('action' => 'index'));
		}
		if (!empty($this->data)) {
			$this->autoRender = false;
			if ($this->Confirmation->save($this->data)) {
				$this->Session->setFlash(__('The confirmation has been saved', true), '');
				$this->render('/elements/success');
			} else {
				$this->Session->setFlash(__('The confirmation could not be saved. Please, try again.', true), '');
				$this->render('/elements/failure');
			}
		}
		$this->set('confirmation', $this->Confirmation->read(null, $id));
		
		if($parent_id) {
			$this->set('parent_id', $parent_id);
		}
			
		$users = $this->Confirmation->User->find('list');
		$this->set(compact('users'));
	}

	function delete($id = null) {
		$this->autoRender = false;
		if (!$id) {
			$this->Session->setFlash(__('Invalid id for confirmation', true), '');
			$this->render('/elements/failure');
		}
		if (stripos($id, '_') !== false) {
            $ids = explode('_', $id);
            try{
                foreach ($ids as $i) {
                    $this->Confirmation->delete($i);
                }
				$this->Session->setFlash(__('Confirmation deleted', true), '');
				$this->render('/elements/success');
            }
            catch (Exception $e){
				$this->Session->setFlash(__('Confirmation was not deleted', true), '');
				$this->render('/elements/failure');
            }
        } else {
            if ($this->Confirmation->delete($id)) {
				$this->Session->setFlash(__('Confirmation deleted', true), '');
				$this->render('/elements/success');
			} else {
				$this->Session->setFlash(__('Confirmation was not deleted', true), '');
				$this->render('/elements/failure');
			}
        }
	}
}
?>