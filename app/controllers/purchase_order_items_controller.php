<?php

class PurchaseOrderItemsController extends AppController {

    var $name = 'PurchaseOrderItems';

    function index() {
        $purchase_orders = $this->PurchaseOrderItem->PurchaseOrder->find('all');
        $this->set(compact('purchase_orders'));
    }

    function index2($id = null) {
        $this->set('parent_id', $id);
    }

    function search() {
        
    }

    function list_data($id = null) {
        $start = (isset($_REQUEST['start'])) ? $_REQUEST['start'] : 0;
        $limit = (isset($_REQUEST['limit'])) ? $_REQUEST['limit'] : 5;
        $purchase_order_id = (isset($_REQUEST['purchase_order_id'])) ? $_REQUEST['purchase_order_id'] : -1;
        if ($id)
            $purchase_order_id = ($id) ? $id : -1;
        $conditions = (isset($_REQUEST['conditions'])) ? $_REQUEST['conditions'] : '';

        eval("\$conditions = array( " . $conditions . " );");
        if ($purchase_order_id != -1) {
            $conditions['PurchaseOrderItem.purchase_order_id'] = $purchase_order_id;
        }

        $this->set('purchase_order_items', $this->PurchaseOrderItem->find('all', array('conditions' => $conditions, 'limit' => $limit, 'offset' => $start)));
        $this->set('results', $this->PurchaseOrderItem->find('count', array('conditions' => $conditions)));
    }

    function view($id = null) {
        if (!$id) {
            $this->Session->setFlash(__('Invalid purchase order item', true));
            $this->redirect(array('action' => 'index'));
        }
        $this->PurchaseOrderItem->recursive = 2;
        $this->set('purchase_order_item', $this->PurchaseOrderItem->read(null, $id));
    }

    function add($id = null) {
        if (!empty($this->data)) {
            $this->PurchaseOrderItem->create();
            $this->autoRender = false;
            $this->loadModel('Item');
            $itemObj = new Item();
            if ($this->PurchaseOrderItem->save($this->data)) {
                $poi = $this->PurchaseOrderItem->read(null, $this->PurchaseOrderItem->id);
                $ordered_quantity = $poi['PurchaseOrderItem']['ordered_quantity'];
                $max_level = $poi['Item']['max_level'];
                $available = $itemObj->getAvailableBalance($poi['PurchaseOrderItem']['item_id']);
                $msg = '';
                if($max_level <= ($available + $ordered_quantity)){
                    $msg .= 'The item is passing its maximum level of ' . $max_level . 
                            ' and already ' . $available . 
                            ' is available.  ' . 
                            'Please make sure you are ordering the appropriate item with appropriate quantity.';
                }
                $this->Session->setFlash(__('The purchase order item has been saved', true) . '. ' . $msg, '');
                $this->set('flag', ($msg == ''? 'ext-mb-info': 'ext-mb-warning'));
                $this->render('/elements/success3');
            } else {
                $this->Session->setFlash(__('The purchase order item could not be saved. Please, try again.', true), '');
                $this->render('/elements/failure');
            }
        }
        if ($id)
            $this->set('parent_id', $id);
        $purchase_orders = $this->PurchaseOrderItem->PurchaseOrder->find('list');
        $items = $this->PurchaseOrderItem->Item->find('list');
        $this->set(compact('purchase_orders', 'items'));
    }

    function edit($id = null, $parent_id = null) {
        if (!$id && empty($this->data)) {
            $this->Session->setFlash(__('Invalid purchase order item', true), '');
            $this->redirect(array('action' => 'index'));
        }
        if (!empty($this->data)) {
            $this->autoRender = false;
            if ($this->PurchaseOrderItem->save($this->data)) {
                $this->Session->setFlash(__('The purchase order item has been saved', true), '');
                $this->render('/elements/success');
            } else {
                $this->Session->setFlash(__('The purchase order item could not be saved. Please, try again.', true), '');
                $this->render('/elements/failure');
            }
        }
        $this->set('purchase_order_item', $this->PurchaseOrderItem->read(null, $id));

        if ($parent_id) {
            $this->set('parent_id', $parent_id);
        }

        $purchase_orders = $this->PurchaseOrderItem->PurchaseOrder->find('list');
        $items = $this->PurchaseOrderItem->Item->find('list');
        $this->set(compact('purchase_orders', 'items'));
    }

    function delete($id = null) {
        $this->autoRender = false;
        if (!$id) {
            $this->Session->setFlash(__('Invalid id for purchase order item', true), '');
            $this->render('/elements/failure');
        }
        if (stripos($id, '_') !== false) {
            $ids = explode('_', $id);
            try {
                foreach ($ids as $i) {
                    $this->PurchaseOrderItem->delete($i);
                }
                $this->Session->setFlash(__('Purchase order item deleted', true), '');
                $this->render('/elements/success');
            } catch (Exception $e) {
                $this->Session->setFlash(__('Purchase order item was not deleted', true), '');
                $this->render('/elements/failure');
            }
        } else {
            if ($this->PurchaseOrderItem->delete($id)) {
                $this->Session->setFlash(__('Purchase order item deleted', true), '');
                $this->render('/elements/success');
            } else {
                $this->Session->setFlash(__('Purchase order item was not deleted', true), '');
                $this->render('/elements/failure');
            }
        }
    }
}

?>