<?php
class ImsTransferStoreItemDetailsController extends AppController {

	var $name = 'ImsTransferStoreItemDetails';
	
	function index() {
		$ims_transfer_store_items = $this->ImsTransferStoreItemDetail->ImsTransferStoreItem->find('all');
		$this->set(compact('ims_transfer_store_items'));
	}
	
	function index2($id = null) {
		$this->set('parent_id', $id);
	}

	function search() {
	}
	
	function list_data($id = null) {
		$start = (isset($_REQUEST['start'])) ? $_REQUEST['start'] : 0;
		$limit = (isset($_REQUEST['limit'])) ? $_REQUEST['limit'] : 5;
		$imstransferstoreitem_id = (isset($_REQUEST['imstransferstoreitem_id'])) ? $_REQUEST['imstransferstoreitem_id'] : -1;
		if($id)
			$imstransferstoreitem_id = ($id) ? $id : -1;
        $conditions = (isset($_REQUEST['conditions'])) ? $_REQUEST['conditions'] : '';

        eval("\$conditions = array( " . $conditions . " );");
		if ($imstransferstoreitem_id != -1) {
            $conditions['ImsTransferStoreItemDetail.ims_transfer_store_item_id'] = $imstransferstoreitem_id;
        }
		
		$this->set('ims_transfer_store_item_details', $this->ImsTransferStoreItemDetail->find('all', array('conditions' => $conditions, 'limit' => $limit, 'offset' => $start)));
		$this->set('results', $this->ImsTransferStoreItemDetail->find('count', array('conditions' => $conditions)));
	}

	function view($id = null) {
		if (!$id) {
			$this->Session->setFlash(__('Invalid ims transfer store item detail', true));
			$this->redirect(array('action' => 'index'));
		}
		$this->ImsTransferStoreItemDetail->recursive = 2;
		$this->set('imsTransferStoreItemDetail', $this->ImsTransferStoreItemDetail->read(null, $id));
	}

	function add($id = null) {
		if (!empty($this->data)) {
			$this->ImsTransferStoreItemDetail->create();
			$this->autoRender = false;
			if ($this->ImsTransferStoreItemDetail->save($this->data)) {
				$this->Session->setFlash(__('The ims transfer store item detail has been saved', true), '');
				$this->render('/elements/success');
			} else {
				$this->Session->setFlash(__('The ims transfer store item detail could not be saved. Please, try again.', true), '');
				$this->render('/elements/failure');
			}
		}
		if($id)
			$this->set('parent_id', $id);
		$ims_transfer_store_items = $this->ImsTransferStoreItemDetail->ImsTransferStoreItem->find('list');
		
		$array[] = null;
		$array2[] = null;
		$this->ImsTransferStoreItemDetail->ImsItem->recursive = -1;
		$items = $this->ImsTransferStoreItemDetail->ImsItem->find('all');
		foreach($items as $item){			
			$array[] = $item['ImsItem'];			
		}
		
		$this->ImsTransferStoreItemDetail->recursive = 0;
		$conditions = array('ImsTransferStoreItem.id' => $id);
		$tranferitems =$this->ImsTransferStoreItemDetail->find('all',array('conditions' => $conditions));
		if(!empty($tranferitems)){
			foreach($tranferitems as $tranferitem){
				$array2[] = $tranferitem['ImsItem'];				
			}
		}
		$results = array_diff(array_map('serialize',$array),array_map('serialize',$array2));
		$results = array_map('unserialize',$results);
		$this->set(compact('ims_transfer_store_items', 'results'));
	}

	function edit($id = null, $parent_id = null) {
		if (!$id && empty($this->data)) {
			$this->Session->setFlash(__('Invalid ims transfer store item detail', true), '');
			$this->redirect(array('action' => 'index'));
		}
		if (!empty($this->data)) {
			$this->autoRender = false;
			if ($this->ImsTransferStoreItemDetail->save($this->data)) {
				$this->Session->setFlash(__('The ims transfer store item detail has been saved', true), '');
				$this->render('/elements/success');
			} else {
				$this->Session->setFlash(__('The ims transfer store item detail could not be saved. Please, try again.', true), '');
				$this->render('/elements/failure');
			}
		}
		$this->set('ims_transfer_store_item_detail', $this->ImsTransferStoreItemDetail->read(null, $id));
		
		if($parent_id) {
			$this->set('parent_id', $parent_id);
		}
			
		$ims_transfer_store_items = $this->ImsTransferStoreItemDetail->ImsTransferStoreItem->find('list');
		
		$array = array();
		$array2 = array();
		$this->ImsTransferStoreItemDetail->ImsItem->recursive = -1;
		$items = $this->ImsTransferStoreItemDetail->ImsItem->find('all');
		foreach($items as $item){			
			$array[] = $item['ImsItem'];			
		}
		
		$this->ImsTransferStoreItemDetail->recursive = 0;
		$conditions = array('ImsTransferStoreItem.id' => $parent_id, 'ImsTransferStoreItemDetail.id !=' => $id);
		$transferitems =$this->ImsTransferStoreItemDetail->find('all',array('conditions' => $conditions));
		if(!empty($transferitems)){
			foreach($transferitems as $transferitem){
				$array2[] = $transferitem['ImsItem'];				
			}
		}
		$results = array_diff(array_map('serialize',$array),array_map('serialize',$array2));
		$results = array_map('unserialize',$results);
		
		$this->set(compact('ims_transfer_store_items', 'results'));
	}

	function delete($id = null) {
		$this->autoRender = false;
		if (!$id) {
			$this->Session->setFlash(__('Invalid id for ims transfer store item detail', true), '');
			$this->render('/elements/failure');
		}
		if (stripos($id, '_') !== false) {
            $ids = explode('_', $id);
            try{
                foreach ($ids as $i) {
                    $this->ImsTransferStoreItemDetail->delete($i);
                }
				$this->Session->setFlash(__('Ims transfer store item detail deleted', true), '');
				$this->render('/elements/success');
            }
            catch (Exception $e){
				$this->Session->setFlash(__('Ims transfer store item detail was not deleted', true), '');
				$this->render('/elements/failure');
            }
        } else {
            if ($this->ImsTransferStoreItemDetail->delete($id)) {
				$this->Session->setFlash(__('Ims transfer store item detail deleted', true), '');
				$this->render('/elements/success');
			} else {
				$this->Session->setFlash(__('Ims transfer store item detail was not deleted', true), '');
				$this->render('/elements/failure');
			}
        }
	}
}
?>