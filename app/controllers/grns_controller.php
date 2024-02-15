<?php

class GrnsController extends AppController {

    var $name = 'Grns';

    function index() {
        $suppliers = $this->Grn->Supplier->find('all');
        $this->set(compact('suppliers'));
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
            $conditions['Grn.purchase_order_id'] = $purchase_order_id;
        }

        $this->set('grns', $this->Grn->find('all', array('conditions' => $conditions, 'limit' => $limit, 'offset' => $start)));
        $this->set('results', $this->Grn->find('count', array('conditions' => $conditions)));
    }

    function list_data2($id) {
        $this->loadModel('PurchaseOrderItem');

        //'id','item','ordered_quantity','purchased_quantity','ordered_unit_price','purchased_unit_price'
        $grn = $this->Grn->read(null, $id);
        $conditions = array('PurchaseOrderItem.purchase_order_id' => $grn['Grn']['purchase_order_id']);

        $pois = $this->PurchaseOrderItem->find('all', array('conditions' => $conditions));
        $i = 0;

        foreach ($pois as $poi) {
            $qnt = 0;
            if (!empty($poi['GrnItem']))
                foreach ($poi['GrnItem'] as $grni)
                    $qnt = $qnt + $grni['quantity'];

            $pois[$i]['PurchaseOrderItem']['grn_id'] = $id;
            $pois[$i]['PurchaseOrderItem']['ordered_quantity'] = $pois[$i]['PurchaseOrderItem']['ordered_quantity'] - $qnt;

            if ($pois[$i]['PurchaseOrderItem']['ordered_quantity'] <= 0) {
                array_splice($pois, $i, 1);
                $i--;
            }
            $i++;
        }

        $this->set('purchase_order_items', $pois);

        $this->set('results', count($pois));
    }

    function view($id = null) {
        if (!$id) {
            $this->Session->setFlash(__('Invalid grn', true));
            $this->redirect(array('action' => 'index'));
        }
        $this->Grn->recursive = 2;
        $this->set('grn', $this->Grn->read(null, $id));
    }

    function add($id = null) {
        if (!empty($this->data)) {
            $this->data['Grn']['status'] = 'created';
            $this->data['Grn']['created_by'] = $this->Session->read('Auth.User.id');
            $this->Grn->create();
            $this->autoRender = false;
            if ($this->Grn->save($this->data)) {
                $this->Session->setFlash(__('The GRN has been saved', true) . '::' . $this->Grn->id, '');
                $this->render('/elements/success_grn');
            } else {
                $this->Session->setFlash(__('The GRN could not be saved. Please, try again.', true), '');
                $this->render('/elements/failure');
            }
        }
        if ($id)
            $this->set('parent_id', $id);
        $suppliers = $this->Grn->Supplier->find('list');
        $purchase_orders = $this->Grn->PurchaseOrder->find('list');
        $this->set(compact('suppliers', 'purchase_orders'));
    }

    function approve($id = null) {
        $this->autoRender = false;
        $this->data['Grn']['id'] = $id;
        $this->data['Grn']['status'] = 'approved';
        $this->data['Grn']['approved_by'] = $this->Session->read('Auth.User.id');
        $this->loadModel('GroupsUser');
        $conditionsg['GroupsUser.group_id'] = '29';
        $conditionsg['GroupsUser.user_id'] = $this->Session->read('Auth.User.id');
        $perm = $this->GroupsUser->find('count', array('conditions' => $conditionsg));
        if ($perm > 0) {
            if ($this->Grn->save($this->data)) {
                echo 'The GRN has been approved';
                //$this->Session->setFlash(__('The GRN has been approved', true), '');
                //$this->render('/elements/success');
            } else {
                echo 'The grn could not be approved. Please, try again.';
                //$this->Session->setFlash(__('The grn could not be approved. Please, try again.', true), '');
                //$this->render('/elements/failure');
            }
        } else {
            echo 'You dont have the required privilage to approve this GRN.';
            //$this->Session->setFlash(__('You dont have the required privilage to approve this GRN.', true), '');
            //$this->render('/elements/failure'); 
        }
    }

    function add_grn_items($id = null) {
        $this->set('grn_id', $id);
        
        if (isset($_POST)) {
            $this->loadModel('GrnItem');
            $this->loadModel('PurchaseOrderItem');
            $this->loadModel('Card');
            
            // for each of the items
            foreach ($_POST as $key => $value) {
                $tmpost = explode('^', $key);
                $poi = '';
                if ($tmpost[1] == 'id') {
                    $poi = $value;
                    $poi = str_replace('"', '', $poi);
                } elseif ($tmpost[1] == 'grn_id') {
                    $grn_id = $value;
                    $grn_id = str_replace('"', '', $grn_id);
                } elseif ($tmpost[1] == 'purchased_quantity') {
                    // this is if we are dealing with the quantity item
                    $po_item = $this->PurchaseOrderItem->read(null, $poi);
                    
                    $conditions['GrnItem.purchase_order_item_id'] = $poi;
                    $conditions['GrnItem.grn_id'] = $grn_id;
                    // if the GRN item and its Card is already registered
                    //   update the records 
                    if ($this->GrnItem->find('count', array('conditions' => $conditions)) > 0) {
                        $this->GrnItem->updateAll(array("quantity" => $value), array('GrnItem.purchase_order_item_id' => $poi, 'GrnItem.grn_id' => $grn_id));
                        $this->Card->updateAll(array("in_quantity" => $value), array('Card.item_id' => $po_item['PurchaseOrderItem']['item_id'], 'Card.grn_id' => $grn_id));
                    } else {
                        // If not, create the GrnItem and the Card
                        $this->GrnItem->create();
                        $this->data['GrnItem']['purchase_order_item_id'] = $poi;
                        $this->data['GrnItem']['grn_id'] = $grn_id;
                        $this->data['GrnItem']['quantity'] = $value;
                        $this->GrnItem->save($this->data);

                        $this->Card->create();
                        $card = array('Card' => array());
                        $card['Card']['grn_id'] = $grn_id;
                        $card['Card']['status'] = 'A';
                        $card['Card']['item_id'] = $po_item['PurchaseOrderItem']['item_id'];
                        $card['Card']['in_quantity'] = $value;
                        $card['Card']['out_quantity'] = 0;
                        $card['Card']['in_unit_price'] = 0;
                        $card['Card']['out_unit_price'] = 0;

                        $this->Card->save($card);
                    }
                } elseif ($tmpost[1] == 'purchased_unit_price') {
                    // this is if we are dealing with the unit price item
                    $po_item = $this->PurchaseOrderItem->read(null, $poi);
                    $conditions['GrnItem.purchase_order_item_id'] = $poi;
                    $conditions['GrnItem.grn_id'] = $grn_id;
                    if ($this->GrnItem->find('count', array('conditions' => $conditions)) > 0) {
                        $this->GrnItem->updateAll(array("unit_price" => $value), array('GrnItem.purchase_order_item_id' => $poi, 'GrnItem.grn_id' => $grn_id));
                        $this->Card->updateAll(array("in_unit_price" => $value), array('Card.item_id' => $po_item['PurchaseOrderItem']['item_id'], 'Card.grn_id' => $grn_id));
                    } else {
                        $this->GrnItem->create();
                        $this->data['GrnItem']['purchase_order_item_id'] = $poi;
                        $this->data['GrnItem']['grn_id'] = $grn_id;
                        $this->data['GrnItem']['unit_price'] = $value;
                        $this->GrnItem->save($this->data);

                        $this->Card->create();
                        $card = array('Card' => array());
                        $card['Card']['grn_id'] = $grn_id;
                        $card['Card']['status'] = 'A';
                        $card['Card']['item_id'] = $po_item['PurchaseOrderItem']['item_id'];
                        $card['Card']['in_unit_price'] = $value;
                        $card['Card']['out_quantity'] = 0;
                        $card['Card']['out_unit_price'] = 0;

                        $this->Card->save($card);
                    }
                }
            }
        }
    }

    function edit($id = null, $parent_id = null) {
        if (!$id && empty($this->data)) {
            $this->Session->setFlash(__('Invalid grn', true), '');
            $this->redirect(array('action' => 'index'));
        }
        if (!empty($this->data)) {
            $this->autoRender = false;
            if ($this->Grn->save($this->data)) {
                $this->Session->setFlash(__('The GRN has been saved', true), '');
                $this->render('/elements/success');
            } else {
                $this->Session->setFlash(__('The grn could not be saved. Please, try again.', true), '');
                $this->render('/elements/failure');
            }
        }
        $this->set('grn', $this->Grn->read(null, $id));

        if ($parent_id) {
            $this->set('parent_id', $parent_id);
        }

        $suppliers = $this->Grn->Supplier->find('list');
        $purchase_orders = $this->Grn->PurchaseOrder->find('list');
        $this->set(compact('suppliers', 'purchase_orders'));
    }

    function delete($id = null) {
        $this->autoRender = false;
        if (!$id) {
            $this->Session->setFlash(__('Invalid id for grn', true), '');
            $this->render('/elements/failure');
        }
        if (stripos($id, '_') !== false) {
            $ids = explode('_', $id);
            try {
                foreach ($ids as $i) {
                    $this->Grn->delete($i);
                }
                $this->Session->setFlash(__('Grn deleted', true), '');
                $this->render('/elements/success');
            } catch (Exception $e) {
                $this->Session->setFlash(__('Grn was not deleted', true), '');
                $this->render('/elements/failure');
            }
        } else {
            if ($this->Grn->delete($id)) {
                $this->Session->setFlash(__('Grn deleted', true), '');
                $this->render('/elements/success');
            } else {
                $this->Session->setFlash(__('Grn was not deleted', true), '');
                $this->render('/elements/failure');
            }
        }
    }

}

?>