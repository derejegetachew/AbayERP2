<?php
class GrnItemsController extends AppController {

	var $name = 'GrnItems';
	
	function index() {
		$grns = $this->GrnItem->Grn->find('all');
		$this->set(compact('grns'));
	}
	
	function index2($id = null) {
		$this->set('parent_id', $id);
	}

	function search() {
	}
	
	function list_data($id = null) {
		$start = (isset($_REQUEST['start'])) ? $_REQUEST['start'] : 0;
		$limit = (isset($_REQUEST['limit'])) ? $_REQUEST['limit'] : 5;
		$grn_id = (isset($_REQUEST['grn_id'])) ? $_REQUEST['grn_id'] : -1;
		if($id)
			$grn_id = ($id) ? $id : -1;
        $conditions = (isset($_REQUEST['conditions'])) ? $_REQUEST['conditions'] : '';

        eval("\$conditions = array( " . $conditions . " );");
		if ($grn_id != -1) {
            $conditions['GrnItem.grn_id'] = $grn_id;
        }
		$this->GrnItem->recursive = 2;
		$this->set('grn_items', $this->GrnItem->find('all', array('conditions' => $conditions, 'limit' => $limit, 'offset' => $start)));
		$this->set('results', $this->GrnItem->find('count', array('conditions' => $conditions)));
	}

	function view($id = null) {
		if (!$id) {
			$this->Session->setFlash(__('Invalid grn item', true));
			$this->redirect(array('action' => 'index'));
		}
		$this->GrnItem->recursive = 2;
		$this->set('grnItem', $this->GrnItem->read(null, $id));
	}

	function add($id = null) {
		if (!empty($this->data)) {
			$this->GrnItem->create();
			$this->autoRender = false;
			if ($this->GrnItem->save($this->data)) {
				$this->Session->setFlash(__('The grn item has been saved', true), '');
				$this->render('/elements/success');
			} else {
				$this->Session->setFlash(__('The grn item could not be saved. Please, try again.', true), '');
				$this->render('/elements/failure');
			}
		}
		if($id)
			$this->set('parent_id', $id);
		$grns = $this->GrnItem->Grn->find('list');
		$purchase_order_items = $this->GrnItem->PurchaseOrderItem->find('list');
		$stores = $this->GrnItem->Store->find('list');
		$this->set(compact('grns', 'purchase_order_items', 'stores'));
	}

	function edit($id = null, $parent_id = null) {
		if (!$id && empty($this->data)) {
			$this->Session->setFlash(__('Invalid grn item', true), '');
			$this->redirect(array('action' => 'index'));
		}
		if (!empty($this->data)) {
			$this->autoRender = false;
			if ($this->GrnItem->save($this->data)) {
				$this->Session->setFlash(__('The grn item has been saved', true), '');
				$this->render('/elements/success');
			} else {
				$this->Session->setFlash(__('The grn item could not be saved. Please, try again.', true), '');
				$this->render('/elements/failure');
			}
		}
		$this->set('grn_item', $this->GrnItem->read(null, $id));
		
		if($parent_id) {
			$this->set('parent_id', $parent_id);
		}
			
		$grns = $this->GrnItem->Grn->find('list');
		$purchase_order_items = $this->GrnItem->PurchaseOrderItem->find('list');
		$stores = $this->GrnItem->Store->find('list');
		$this->set(compact('grns', 'purchase_order_items', 'stores'));
	}

	function delete($id = null) {
		$this->autoRender = false;
		if (!$id) {
			$this->Session->setFlash(__('Invalid id for grn item', true), '');
			$this->render('/elements/failure');
		}
		if (stripos($id, '_') !== false) {
            $ids = explode('_', $id);
            try{
                foreach ($ids as $i) {
                    $this->GrnItem->delete($i);
                }
				$this->Session->setFlash(__('Grn item deleted', true), '');
				$this->render('/elements/success');
            }
            catch (Exception $e){
				$this->Session->setFlash(__('Grn item was not deleted', true), '');
				$this->render('/elements/failure');
            }
        } else {
            if ($this->GrnItem->delete($id)) {
				$this->Session->setFlash(__('Grn item deleted', true), '');
				$this->render('/elements/success');
			} else {
				$this->Session->setFlash(__('Grn item was not deleted', true), '');
				$this->render('/elements/failure');
			}
        }
	}
}
?>