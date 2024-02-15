<?php
class ImsStoresItemsController extends AppController {

	var $name = 'ImsStoresItems';
	
	function index() {
		$ims_stores = $this->ImsStoresItem->ImsStore->find('all');
		$this->set(compact('ims_stores'));
	}
	
	function index2($id = null) {
		$this->set('parent_id', $id);
	}

	function search() {
	}
	
	function list_data($id = null) {
		$start = (isset($_REQUEST['start'])) ? $_REQUEST['start'] : 0;
		$limit = (isset($_REQUEST['limit'])) ? $_REQUEST['limit'] : 5;
		$imsstore_id = (isset($_REQUEST['imsstore_id'])) ? $_REQUEST['imsstore_id'] : -1;
		if($id)
			$imsstore_id = ($id) ? $id : -1;
        $conditions = (isset($_REQUEST['conditions'])) ? $_REQUEST['conditions'] : '';

        eval("\$conditions = array( " . $conditions . " );");
		if ($imsstore_id != -1) {
            $conditions['ImsStoresItem.imsstore_id'] = $imsstore_id;
        }
		
		$this->set('imsStoresItems', $this->ImsStoresItem->find('all', array('conditions' => $conditions, 'limit' => $limit, 'offset' => $start)));
		$this->set('results', $this->ImsStoresItem->find('count', array('conditions' => $conditions)));
	}

	function view($id = null) {
		if (!$id) {
			$this->Session->setFlash(__('Invalid ims stores item', true));
			$this->redirect(array('action' => 'index'));
		}
		$this->ImsStoresItem->recursive = 2;
		$this->set('imsStoresItem', $this->ImsStoresItem->read(null, $id));
	}

	function add($id = null) {
		if (!empty($this->data)) {
			$this->ImsStoresItem->create();
			$this->autoRender = false;
			if ($this->ImsStoresItem->save($this->data)) {
				$this->Session->setFlash(__('The ims stores item has been saved', true), '');
				$this->render('/elements/success');
			} else {
				$this->Session->setFlash(__('The ims stores item could not be saved. Please, try again.', true), '');
				$this->render('/elements/failure');
			}
		}
		if($id)
			$this->set('parent_id', $id);
		$ims_stores = $this->ImsStoresItem->ImsStore->find('list');
		$ims_items = $this->ImsStoresItem->ImsItem->find('list');
		$this->set(compact('ims_stores', 'ims_items'));
	}

	function edit($id = null, $parent_id = null) {
		if (!$id && empty($this->data)) {
			$this->Session->setFlash(__('Invalid ims stores item', true), '');
			$this->redirect(array('action' => 'index'));
		}
		if (!empty($this->data)) {
			$this->autoRender = false;
			if ($this->ImsStoresItem->save($this->data)) {
				$this->Session->setFlash(__('The ims stores item has been saved', true), '');
				$this->render('/elements/success');
			} else {
				$this->Session->setFlash(__('The ims stores item could not be saved. Please, try again.', true), '');
				$this->render('/elements/failure');
			}
		}
		$this->set('ims__stores__item', $this->ImsStoresItem->read(null, $id));
		
		if($parent_id) {
			$this->set('parent_id', $parent_id);
		}
			
		$ims_stores = $this->ImsStoresItem->ImsStore->find('list');
		$ims_items = $this->ImsStoresItem->ImsItem->find('list');
		$this->set(compact('ims_stores', 'ims_items'));
	}

	function delete($id = null) {
		$this->autoRender = false;
		if (!$id) {
			$this->Session->setFlash(__('Invalid id for ims stores item', true), '');
			$this->render('/elements/failure');
		}
		if (stripos($id, '_') !== false) {
            $ids = explode('_', $id);
            try{
                foreach ($ids as $i) {
                    $this->ImsStoresItem->delete($i);
                }
				$this->Session->setFlash(__('Ims stores item deleted', true), '');
				$this->render('/elements/success');
            }
            catch (Exception $e){
				$this->Session->setFlash(__('Ims stores item was not deleted', true), '');
				$this->render('/elements/failure');
            }
        } else {
            if ($this->ImsStoresItem->delete($id)) {
				$this->Session->setFlash(__('Ims stores item deleted', true), '');
				$this->render('/elements/success');
			} else {
				$this->Session->setFlash(__('Ims stores item was not deleted', true), '');
				$this->render('/elements/failure');
			}
        }
	}
}
?>