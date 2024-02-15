<?php
class FrwfmEventsController extends AppController {

	var $name = 'FrwfmEvents';
	
	function index() {
		$frwfm_applications = $this->FrwfmEvent->FrwfmApplication->find('all');
		$this->set(compact('frwfm_applications'));
	}
	
	function index2($id = null) {
		$this->set('parent_id', $id);
	}

	function search() {
	}
	
	function list_data($id = null) {
		$start = (isset($_REQUEST['start'])) ? $_REQUEST['start'] : 0;
		$limit = (isset($_REQUEST['limit'])) ? $_REQUEST['limit'] : 10;
		$frwfmapplication_id = (isset($_REQUEST['frwfmapplication_id'])) ? $_REQUEST['frwfmapplication_id'] : -1;
		if($id)
			$frwfmapplication_id = ($id) ? $id : -1;
        $conditions = (isset($_REQUEST['conditions'])) ? $_REQUEST['conditions'] : '';

        eval("\$conditions = array( " . $conditions . " );");
		if ($frwfmapplication_id != -1) {
            $conditions['FrwfmEvent.frwfm_application_id'] = $frwfmapplication_id;
        }
		$this->FrwfmEvent->recursive=2;
		$this->set('frwfm_events', $this->FrwfmEvent->find('all', array('conditions' => $conditions, 'limit' => $limit, 'offset' => $start)));
		$this->set('results', $this->FrwfmEvent->find('count', array('conditions' => $conditions)));
	}

	function view($id = null) {
		if (!$id) {
			$this->Session->setFlash(__('Invalid frwfm event', true));
			$this->redirect(array('action' => 'index'));
		}
		$this->FrwfmEvent->recursive = 2;
		$this->set('frwfmEvent', $this->FrwfmEvent->read(null, $id));
	}

	function add($id = null) {
		if (!empty($this->data)) {
			$this->FrwfmEvent->create();
			$this->autoRender = false;
			if ($this->FrwfmEvent->save($this->data)) {
				$this->Session->setFlash(__('The frwfm event has been saved', true), '');
				$this->render('/elements/success');
			} else {
				$this->Session->setFlash(__('The frwfm event could not be saved. Please, try again.', true), '');
				$this->render('/elements/failure');
			}
		}
		if($id)
			$this->set('parent_id', $id);
		$frwfm_applications = $this->FrwfmEvent->FrwfmApplication->find('list');
		$users = $this->FrwfmEvent->User->find('list');
		$this->set(compact('frwfm_applications', 'users'));
	}

	function edit($id = null, $parent_id = null) {
		if (!$id && empty($this->data)) {
			$this->Session->setFlash(__('Invalid frwfm event', true), '');
			$this->redirect(array('action' => 'index'));
		}
		if (!empty($this->data)) {
			$this->autoRender = false;
			if ($this->FrwfmEvent->save($this->data)) {
				$this->Session->setFlash(__('The frwfm event has been saved', true), '');
				$this->render('/elements/success');
			} else {
				$this->Session->setFlash(__('The frwfm event could not be saved. Please, try again.', true), '');
				$this->render('/elements/failure');
			}
		}
		$this->set('frwfm__event', $this->FrwfmEvent->read(null, $id));
		
		if($parent_id) {
			$this->set('parent_id', $parent_id);
		}
			
		$frwfm_applications = $this->FrwfmEvent->FrwfmApplication->find('list');
		$users = $this->FrwfmEvent->User->find('list');
		$this->set(compact('frwfm_applications', 'users'));
	}

	function delete($id = null) {
		$this->autoRender = false;
		if (!$id) {
			$this->Session->setFlash(__('Invalid id for frwfm event', true), '');
			$this->render('/elements/failure');
		}
		if (stripos($id, '_') !== false) {
            $ids = explode('_', $id);
            try{
                foreach ($ids as $i) {
                    $this->FrwfmEvent->delete($i);
                }
				$this->Session->setFlash(__('Frwfm event deleted', true), '');
				$this->render('/elements/success');
            }
            catch (Exception $e){
				$this->Session->setFlash(__('Frwfm event was not deleted', true), '');
				$this->render('/elements/failure');
            }
        } else {
            if ($this->FrwfmEvent->delete($id)) {
				$this->Session->setFlash(__('Frwfm event deleted', true), '');
				$this->render('/elements/success');
			} else {
				$this->Session->setFlash(__('Frwfm event was not deleted', true), '');
				$this->render('/elements/failure');
			}
        }
	}
}
?>