<?php
class ImsStoresController extends ImsAppController {

	var $name = 'ImsStores';
	
	function index() {
	}
	

	function search() {
	}
	
	function list_data($id = null) {
		$start = (isset($_REQUEST['start'])) ? $_REQUEST['start'] : 0;
		$limit = (isset($_REQUEST['limit'])) ? $_REQUEST['limit'] : 5;
        $conditions = (isset($_REQUEST['conditions'])) ? $_REQUEST['conditions'] : '';

        eval("\$conditions = array( " . $conditions . " );");
		
		$this->ImsStore->recursive = 2;
		$this->set('stores', $this->ImsStore->find('all', array('conditions' => $conditions, 'limit' => $limit, 'offset' => $start)));
		$this->set('results', $this->ImsStore->find('count', array('conditions' => $conditions)));
	}

	function view($id = null) {
		if (!$id) {
			$this->Session->setFlash(__('Invalid store', true));
			$this->redirect(array('action' => 'index'));
		}
		$this->ImsStore->recursive = 2;
		$this->set('store', $this->ImsStore->read(null, $id));
	}

	function add($id = null) {
		if (!empty($this->data)) {
			$this->ImsStore->create();
			$this->autoRender = false;
			if ($this->ImsStore->save($this->data)) {
				$this->Session->setFlash(__('The store has been saved', true), '');
				$this->render('/elements/success');
			} else {
				$this->Session->setFlash(__('The store could not be saved. Please, try again.', true), '');
				$this->render('/elements/failure');
			}
		}
		$grn_items = $this->ImsStore->ImsGrnItem->find('list');
		$this->set(compact('grn_items'));
	}

	function edit($id = null, $parent_id = null) {
		if (!$id && empty($this->data)) {
			$this->Session->setFlash(__('Invalid store', true), '');
			$this->redirect(array('action' => 'index'));
		}
		if (!empty($this->data)) {
			$this->autoRender = false;
			if ($this->ImsStore->save($this->data)) {
				$this->Session->setFlash(__('The store has been saved', true), '');
				$this->render('/elements/success');
			} else {
				$this->Session->setFlash(__('The store could not be saved. Please, try again.', true), '');
				$this->render('/elements/failure');
			}
		}
		$this->ImsStore->recursive = 2;
		$this->set('store', $this->ImsStore->read(null, $id));
		
			
		$grn_items = $this->ImsStore->ImsGrnItem->find('list');
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
                    $this->ImsStore->delete($i);
                }
				$this->Session->setFlash(__('Store deleted', true), '');
				$this->render('/elements/success');
            }
            catch (Exception $e){
				$this->Session->setFlash(__('Store was not deleted', true), '');
				$this->render('/elements/failure');
            }
        } else {
            if ($this->ImsStore->delete($id)) {
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