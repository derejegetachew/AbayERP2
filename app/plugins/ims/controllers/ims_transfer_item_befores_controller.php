<?php
class ImsTransferItemBeforesController extends AppController {

	var $name = 'ImsTransferItemBefores';
	
	function index() {
		$ims_transfer_befores = $this->ImsTransferItemBefore->ImsTransferBefore->find('all');
		$this->set(compact('ims_transfer_befores'));
	}
	
	function index2($id = null) {
		$this->set('parent_id', $id);
	}

	function search() {
	}
	
	function list_data($id = null) {
		$start = (isset($_REQUEST['start'])) ? $_REQUEST['start'] : 0;
		$limit = (isset($_REQUEST['limit'])) ? $_REQUEST['limit'] : 5;
		$imstransferbefore_id = (isset($_REQUEST['imstransferbefore_id'])) ? $_REQUEST['imstransferbefore_id'] : -1;
		if($id)
			$imstransferbefore_id = ($id) ? $id : -1;
        $conditions = (isset($_REQUEST['conditions'])) ? $_REQUEST['conditions'] : '';

        eval("\$conditions = array( " . $conditions . " );");
		if ($imstransferbefore_id != -1) {
            $conditions['ImsTransferItemBefore.ims_transfer_before_id'] = $imstransferbefore_id;
        }
		
		$this->set('ims_transfer_item_befores', $this->ImsTransferItemBefore->find('all', array('conditions' => $conditions, 'limit' => $limit, 'offset' => $start)));
		$this->set('results', $this->ImsTransferItemBefore->find('count', array('conditions' => $conditions)));
	}

	function view($id = null) {
		if (!$id) {
			$this->Session->setFlash(__('Invalid ims transfer item before', true));
			$this->redirect(array('action' => 'index'));
		}
		$this->ImsTransferItemBefore->recursive = 2;
		$this->set('imsTransferItemBefore', $this->ImsTransferItemBefore->read(null, $id));
	}

	function add($id = null) {
		if (!empty($this->data)) {
			$this->ImsTransferItemBefore->create();
			$this->autoRender = false;
			if ($this->ImsTransferItemBefore->save($this->data)) {
				$this->Session->setFlash(__('The ims transfer item before has been saved', true), '');
				$this->render('/elements/success');
			} else {
				$this->Session->setFlash(__('The ims transfer item before could not be saved. Please, try again.', true), '');
				$this->render('/elements/failure');
			}
		}
		if($id)
			$this->set('parent_id', $id);
		$ims_transfer_befores = $this->ImsTransferItemBefore->ImsTransferBefore->find('list');
		$ims_sirv_item_befores = $this->ImsTransferItemBefore->ImsSirvItemBefore->find('list');
		$ims_items = $this->ImsTransferItemBefore->ImsItem->find('list');
		$this->set(compact('ims_transfer_befores', 'ims_sirv_item_befores', 'ims_items'));
	}

	function edit($id = null, $parent_id = null) {
		if (!$id && empty($this->data)) {
			$this->Session->setFlash(__('Invalid ims transfer item before', true), '');
			$this->redirect(array('action' => 'index'));
		}
		if (!empty($this->data)) {
			$this->autoRender = false;
			if ($this->ImsTransferItemBefore->save($this->data)) {
				$this->Session->setFlash(__('The ims transfer item before has been saved', true), '');
				$this->render('/elements/success');
			} else {
				$this->Session->setFlash(__('The ims transfer item before could not be saved. Please, try again.', true), '');
				$this->render('/elements/failure');
			}
		}
		$this->set('ims__transfer__item__before', $this->ImsTransferItemBefore->read(null, $id));
		
		if($parent_id) {
			$this->set('parent_id', $parent_id);
		}
			
		$ims_transfer_befores = $this->ImsTransferItemBefore->ImsTransferBefore->find('list');
		$ims_sirv_item_befores = $this->ImsTransferItemBefore->ImsSirvItemBefore->find('list');
		$ims_items = $this->ImsTransferItemBefore->ImsItem->find('list');
		$this->set(compact('ims_transfer_befores', 'ims_sirv_item_befores', 'ims_items'));
	}

	function delete($id = null) {
		$this->autoRender = false;
		if (!$id) {
			$this->Session->setFlash(__('Invalid id for ims transfer item before', true), '');
			$this->render('/elements/failure');
		}
		if (stripos($id, '_') !== false) {
            $ids = explode('_', $id);
            try{
                foreach ($ids as $i) {
                    $this->ImsTransferItemBefore->delete($i);
                }
				$this->Session->setFlash(__('Ims transfer item before deleted', true), '');
				$this->render('/elements/success');
            }
            catch (Exception $e){
				$this->Session->setFlash(__('Ims transfer item before was not deleted', true), '');
				$this->render('/elements/failure');
            }
        } else {
            if ($this->ImsTransferItemBefore->delete($id)) {
				$this->Session->setFlash(__('Ims transfer item before deleted', true), '');
				$this->render('/elements/success');
			} else {
				$this->Session->setFlash(__('Ims transfer item before was not deleted', true), '');
				$this->render('/elements/failure');
			}
        }
	}
}
?>