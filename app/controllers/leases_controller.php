<?php
class LeasesController extends AppController {

	var $name = 'Leases';
	
	function index() {
	}
	

	function search() {
	}
	
	function list_data($id = null) {
		$start = (isset($_REQUEST['start'])) ? $_REQUEST['start'] : 0;
		$limit = (isset($_REQUEST['limit'])) ? $_REQUEST['limit'] : 5;
        $conditions = (isset($_REQUEST['conditions'])) ? $_REQUEST['conditions'] : '';

        eval("\$conditions = array( " . $conditions . " );");
		
		$this->set('leases', $this->Lease->find('all', array('conditions' => $conditions, 'limit' => $limit, 'offset' => $start)));
		$this->set('results', $this->Lease->find('count', array('conditions' => $conditions)));
	}

	function view($id = null) {
		if (!$id) {
			$this->Session->setFlash(__('Invalid lease', true));
			$this->redirect(array('action' => 'index'));
		}
		$this->Lease->recursive = 2;
		$this->set('lease', $this->Lease->read(null, $id));
	}

	function add($id = null) {
		if (!empty($this->data)) {
			$this->Lease->create();
			$this->autoRender = false;
			if ($this->Lease->save($this->data)) {
				$this->Session->setFlash(__('The lease has been saved', true), '');
				$this->render('/elements/success');
			} else {
				$this->Session->setFlash(__('The lease could not be saved. Please, try again.', true), '');
				$this->render('/elements/failure');
			}
		}
	}

	function edit($id = null, $parent_id = null) {
		if (!$id && empty($this->data)) {
			$this->Session->setFlash(__('Invalid lease', true), '');
			$this->redirect(array('action' => 'index'));
		}
		if (!empty($this->data)) {
			$this->autoRender = false;
			if ($this->Lease->save($this->data)) {
				$this->Session->setFlash(__('The lease has been saved', true), '');
				$this->render('/elements/success');
			} else {
				$this->Session->setFlash(__('The lease could not be saved. Please, try again.', true), '');
				$this->render('/elements/failure');
			}
		}
		$this->set('lease', $this->Lease->read(null, $id));
		
			
	}

	function delete($id = null) {
		$this->autoRender = false;
		if (!$id) {
			$this->Session->setFlash(__('Invalid id for lease', true), '');
			$this->render('/elements/failure');
		}
		if (stripos($id, '_') !== false) {
            $ids = explode('_', $id);
            try{
                foreach ($ids as $i) {
                    $this->Lease->delete($i);
                }
				$this->Session->setFlash(__('Lease deleted', true), '');
				$this->render('/elements/success');
            }
            catch (Exception $e){
				$this->Session->setFlash(__('Lease was not deleted', true), '');
				$this->render('/elements/failure');
            }
        } else {
            if ($this->Lease->delete($id)) {
				$this->Session->setFlash(__('Lease deleted', true), '');
				$this->render('/elements/success');
			} else {
				$this->Session->setFlash(__('Lease was not deleted', true), '');
				$this->render('/elements/failure');
			}
        }
	}
}
?>