<?php
class StoresController extends AppController {

	var $name = 'Stores';
	
	function index() {
	}
	

	function search() {
	}
	
	function list_data($id = null) {
		$start = (isset($_REQUEST['start'])) ? $_REQUEST['start'] : 0;
		$limit = (isset($_REQUEST['limit'])) ? $_REQUEST['limit'] : 5;
        $conditions = (isset($_REQUEST['conditions'])) ? $_REQUEST['conditions'] : '';

        eval("\$conditions = array( " . $conditions . " );");
		
		$this->set('stores', $this->Store->find('all', array('conditions' => $conditions, 'limit' => $limit, 'offset' => $start)));
		$this->set('results', $this->Store->find('count', array('conditions' => $conditions)));
	}

	function view($id = null) {
		if (!$id) {
			$this->Session->setFlash(__('Invalid store', true));
			$this->redirect(array('action' => 'index'));
		}
		$this->Store->recursive = 2;
		$this->set('store', $this->Store->read(null, $id));
	}

	function add($id = null) {
		if (!empty($this->data)) {
			$this->Store->create();
			$this->autoRender = false;
			if ($this->Store->save($this->data)) {
				$this->Session->setFlash(__('The store has been saved', true), '');
				$this->render('/elements/success');
			} else {
				$this->Session->setFlash(__('The store could not be saved. Please, try again.', true), '');
				$this->render('/elements/failure');
			}
		}
		$grn_items = $this->Store->GrnItem->find('list');
		$this->set(compact('grn_items'));
	}

	function edit($id = null, $parent_id = null) {
		if (!$id && empty($this->data)) {
			$this->Session->setFlash(__('Invalid store', true), '');
			$this->redirect(array('action' => 'index'));
		}
		if (!empty($this->data)) {
			$this->autoRender = false;
			if ($this->Store->save($this->data)) {
				$this->Session->setFlash(__('The store has been saved', true), '');
				$this->render('/elements/success');
			} else {
				$this->Session->setFlash(__('The store could not be saved. Please, try again.', true), '');
				$this->render('/elements/failure');
			}
		}
		$this->set('store', $this->Store->read(null, $id));
		
			
		$grn_items = $this->Store->GrnItem->find('list');
		$this->set(compact('grn_items'));
	}

	function delete($id = null) {
		$this->autoRender = false;
		if (!$id) {
			$this->Session->setFlash(__('Invalid id for store', true), '');
			$this->render('/elements/failure');
		}
		if (stripos($id, '_') !== false) {
            $ids = explode('_', $id);
            try{
                foreach ($ids as $i) {
                    $this->Store->delete($i);
                }
				$this->Session->setFlash(__('Store deleted', true), '');
				$this->render('/elements/success');
            }
            catch (Exception $e){
				$this->Session->setFlash(__('Store was not deleted', true), '');
				$this->render('/elements/failure');
            }
        } else {
            if ($this->Store->delete($id)) {
				$this->Session->setFlash(__('Store deleted', true), '');
				$this->render('/elements/success');
			} else {
				$this->Session->setFlash(__('Store was not deleted', true), '');
				$this->render('/elements/failure');
			}
        }
	}
}
?>