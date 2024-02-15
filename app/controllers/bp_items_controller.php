<?php
class BpItemsController extends AppController {

	var $name = 'BpItems';
	
	function index() {

	}
	

	function search() {
	}
	
	function list_data($id = null) {
		$start = (isset($_REQUEST['start'])) ? $_REQUEST['start'] : 0;
		$limit = (isset($_REQUEST['limit'])) ? $_REQUEST['limit'] : 5;
        $conditions = (isset($_REQUEST['conditions'])) ? $_REQUEST['conditions'] : '';

        eval("\$conditions = array( " . $conditions . " );");
		
		$this->set('bp_items', $this->BpItem->find('all', array('conditions' => $conditions, 'limit' => $limit, 'offset' => $start)));
		$this->set('results', $this->BpItem->find('count', array('conditions' => $conditions)));
	}

	function view($id = null) {
		if (!$id) {
			$this->Session->setFlash(__('Invalid bp item', true));
			$this->redirect(array('action' => 'index'));
		}
		$this->BpItem->recursive = 2;
		$this->set('bpItem', $this->BpItem->read(null, $id));
	}

	function add($id = null) {
		if (!empty($this->data)) {
			$this->BpItem->create();
			$this->autoRender = false;
			if ($this->BpItem->save($this->data)) {
				$this->Session->setFlash(__('The bp item has been saved', true), '');
				$this->render('/elements/success');
			} else {
				$this->Session->setFlash(__('The bp item could not be saved. Please, try again.', true), '');
				$this->render('/elements/failure');
			}
		}
	}

	function edit($id = null, $parent_id = null) {
		if (!$id && empty($this->data)) {
			$this->Session->setFlash(__('Invalid bp item', true), '');
			$this->redirect(array('action' => 'index'));
		}
		if (!empty($this->data)) {
			$this->autoRender = false;
			if ($this->BpItem->save($this->data)) {
				$this->Session->setFlash(__('The bp item has been saved', true), '');
				$this->render('/elements/success');
			} else {
				$this->Session->setFlash(__('The bp item could not be saved. Please, try again.', true), '');
				$this->render('/elements/failure');
			}
			
			
		}
		$this->set('bp_item', $this->BpItem->read(null, $id));
		
			
	}

	function delete($id = null) {
		$this->autoRender = false;
		if (!$id) {
			$this->Session->setFlash(__('Invalid id for bp item', true), '');
			$this->render('/elements/failure');
		}
		if (stripos($id, '_') !== false) {
            $ids = explode('_', $id);
            try{
                foreach ($ids as $i) {
                    $this->BpItem->delete($i);
                }
				$this->Session->setFlash(__('Bp item deleted', true), '');
				$this->render('/elements/success');
            }
            catch (Exception $e){
				$this->Session->setFlash(__('Bp item was not deleted', true), '');
				$this->render('/elements/failure');
            }
        } else {
            if ($this->BpItem->delete($id)) {
				$this->Session->setFlash(__('Bp item deleted', true), '');
				$this->render('/elements/success');
			} else {
				$this->Session->setFlash(__('Bp item was not deleted', true), '');
				$this->render('/elements/failure');
			}
        }
	}
}
?>