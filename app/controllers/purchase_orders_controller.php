<?php

class PurchaseOrdersController extends AppController {

    var $name = 'PurchaseOrders';

    function index() {
        $users = $this->PurchaseOrder->User->find('all');
        $this->set(compact('users'));
    }
    
    function index_1() {
        $users = $this->PurchaseOrder->User->find('all');
        $this->set(compact('users'));
    }

    function index2($id = null) {
        $this->set('parent_id', $id);
    }

    function search() {
        
    }

    function list_data($id = null) {
        $start = (isset($_REQUEST['start'])) ? $_REQUEST['start'] : 0;
        $limit = (isset($_REQUEST['limit'])) ? $_REQUEST['limit'] : 40;
        $user_id = (isset($_REQUEST['user_id'])) ? $_REQUEST['user_id'] : -1;
        if ($id)
            $user_id = ($id) ? $id : -1;
        $conditions = (isset($_REQUEST['conditions'])) ? $_REQUEST['conditions'] : '';

        eval("\$conditions = array( " . $conditions . " );");
        if ($user_id != -1) {
            $conditions['PurchaseOrder.user_id'] = $user_id;
        }
        $this->PurchaseOrder->recursive = 2;
        $this->set('purchase_orders', $this->PurchaseOrder->find('all', array('conditions' => $conditions, 'limit' => $limit, 'offset' => $start)));
        $this->set('results', $this->PurchaseOrder->find('count', array('conditions' => $conditions)));
    }
    
    function list_data_1($id = null) {
        $start = (isset($_REQUEST['start'])) ? $_REQUEST['start'] : 0;
        $limit = (isset($_REQUEST['limit'])) ? $_REQUEST['limit'] : 40;
        $user_id = (isset($_REQUEST['user_id'])) ? $_REQUEST['user_id'] : -1;
        if ($id)
            $user_id = ($id) ? $id : -1;
        $conditions = (isset($_REQUEST['conditions'])) ? $_REQUEST['conditions'] : '';

        eval("\$conditions = array( " . $conditions . " );");
        if ($user_id != -1) {
            $conditions['PurchaseOrder.user_id'] = $user_id;
        }
        $conditions['PurchaseOrder.posted'] = true;
        $this->PurchaseOrder->recursive = 2;
        $this->set('purchase_orders', $this->PurchaseOrder->find('all', array('conditions' => $conditions, 'limit' => $limit, 'offset' => $start)));
        $this->set('results', $this->PurchaseOrder->find('count', array('conditions' => $conditions)));
    }

    function view($id = null) {
        if (!$id) {
            $this->Session->setFlash(__('Invalid purchase order', true));
            $this->redirect(array('action' => 'index'));
        }
        $this->PurchaseOrder->recursive = 2;
        $this->set('purchase_order', $this->PurchaseOrder->read(null, $id));
    }

    function add($id = null) {
        if (!empty($this->data)) {
            $this->PurchaseOrder->create();
            $this->data['PurchaseOrder']['posted'] = false;
            $this->data['PurchaseOrder']['approved'] = false;
            $this->data['PurchaseOrder']['user_id'] = $this->Session->read('Auth.User.id');
            
            $this->autoRender = false;
            if ($this->PurchaseOrder->save($this->data)) {
                $this->Session->setFlash(__('The purchase order has been saved', true), '');
                $this->render('/elements/success');
            } else {
                $this->Session->setFlash(__('The purchase order could not be saved. Please, try again.', true), '');
                $this->render('/elements/failure');
            }
        }
        if ($id)
            $this->set('parent_id', $id);
        $users = $this->PurchaseOrder->User->find('list');
        $this->set(compact('users'));
    }
    
    function print_po($id = null){
        $this->layout = 'print_layout';
        
        if (!$id) {
            $this->autoRender = false;
            $this->Session->setFlash(__('Invalid id for purchase order', true), '');
            $this->render('/elements/failure');
        }
        $this->PurchaseOrder->recursive = 2;
        $this->set('purchase_order', $this->PurchaseOrder->read(null, $id));
    }
    
    function post($id = null) {
        $this->autoRender = false;
        if (!$id) {
            $this->Session->setFlash(__('Invalid id for purchase order', true), '');
            $this->render('/elements/failure');
        }
        $purchase_order = array('PurchaseOrder' => array('id' => $id, 'posted' => true));
        if ($this->PurchaseOrder->save($purchase_order)) {
            $this->Session->setFlash(__('Purchase Order posted for approval', true), '');
            $this->render('/elements/success');
        } else {
            $this->Session->setFlash(__('Purchase Order was not posted for approval', true), '');
            $this->render('/elements/failure');
        }
    }
    
    function approve($id = null) {
        $this->autoRender = false;
        if (!$id) {
            $this->Session->setFlash(__('Invalid id for purchase order', true), '');
            $this->render('/elements/failure');
        }
        $purchase_order = array('PurchaseOrder' => array('id' => $id, 'approved' => true));
        if ($this->PurchaseOrder->save($purchase_order)) {
            $this->Session->setFlash(__('Purchase Order successfully approved', true), '');
            $this->render('/elements/success');
        } else {
            $this->Session->setFlash(__('Purchase Order was not successfully approved', true), '');
            $this->render('/elements/failure');
        }
    }
    
    function reject($id = null) {
        $this->autoRender = false;
        if (!$id) {
            $this->Session->setFlash(__('Invalid id for purchase order', true), '');
            $this->render('/elements/failure');
        }
        $purchase_order = array('PurchaseOrder' => array('id' => $id, 'rejected' => true));
        if ($this->PurchaseOrder->save($purchase_order)) {
            $this->Session->setFlash(__('Purchase Order successfully rejected', true), '');
            $this->render('/elements/success');
        } else {
            $this->Session->setFlash(__('Purchase Order was not successfully rejected', true), '');
            $this->render('/elements/failure');
        }
    }

    function edit($id = null, $parent_id = null) {
        if (!$id && empty($this->data)) {
            $this->Session->setFlash(__('Invalid purchase order', true), '');
            $this->redirect(array('action' => 'index'));
        }
        if (!empty($this->data)) {
            $this->autoRender = false;
            if ($this->PurchaseOrder->save($this->data)) {
                $this->Session->setFlash(__('The purchase order has been saved', true), '');
                $this->render('/elements/success');
            } else {
                $this->Session->setFlash(__('The purchase order could not be saved. Please, try again.', true), '');
                $this->render('/elements/failure');
            }
        }
        $this->set('purchase_order', $this->PurchaseOrder->read(null, $id));

        if ($parent_id) {
            $this->set('parent_id', $parent_id);
        }

        $users = $this->PurchaseOrder->User->find('list');
        $this->set(compact('users'));
    }

    function delete($id = null) {
        $this->autoRender = false;
        if (!$id) {
            $this->Session->setFlash(__('Invalid id for purchase order', true), '');
            $this->render('/elements/failure');
        }
        if (stripos($id, '_') !== false) {
            $ids = explode('_', $id);
            try {
                foreach ($ids as $i) {
                    $this->PurchaseOrder->delete($i);
                }
                $this->Session->setFlash(__('Purchase order deleted', true), '');
                $this->render('/elements/success');
            } catch (Exception $e) {
                $this->Session->setFlash(__('Purchase order was not deleted', true), '');
                $this->render('/elements/failure');
            }
        } else {
            if ($this->PurchaseOrder->delete($id)) {
                $this->Session->setFlash(__('Purchase order deleted', true), '');
                $this->render('/elements/success');
            } else {
                $this->Session->setFlash(__('Purchase order was not deleted', true), '');
                $this->render('/elements/failure');
            }
        }
    }

}

?>