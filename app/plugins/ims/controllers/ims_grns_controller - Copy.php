<?php

class ImsGrnsController extends ImsAppController {

    var $name = 'ImsGrns';

    function index() {
        $suppliers = $this->ImsGrn->ImsSupplier->find('all');
        $this->set(compact('suppliers'));
    }

    function index2($id = null) {
        $this->set('parent_id', $id);
    }
    
    function index_1() {

    }

    function search() {
        
    }

    function list_data($id = null) {
        $start = (isset($_REQUEST['start'])) ? $_REQUEST['start'] : 0;
        $limit = (isset($_REQUEST['limit'])) ? $_REQUEST['limit'] : 40;
        $purchase_order_id = (isset($_REQUEST['ims_purchase_order_id'])) ? $_REQUEST['ims_purchase_order_id'] : -1;
        if ($id)
            $purchase_order_id = ($id) ? $id : -1;
        $conditions = (isset($_REQUEST['conditions'])) ? $_REQUEST['conditions'] : '';

        eval("\$conditions = array( " . $conditions . " );");
        if ($purchase_order_id != -1) {
            $conditions['ImsGrn.ims_purchase_order_id'] = $purchase_order_id;
        }

        $this->set('grns', $this->ImsGrn->find('all', array('conditions' => $conditions, 'limit' => $limit, 'offset' => $start)));
        $this->set('results', $this->ImsGrn->find('count', array('conditions' => $conditions)));
    }
    
    function list_data_1($id = null) {
        $start = (isset($_REQUEST['start'])) ? $_REQUEST['start'] : 0;
        $limit = (isset($_REQUEST['limit'])) ? $_REQUEST['limit'] : 40;
        $purchase_order_id = (isset($_REQUEST['ims_purchase_order_id'])) ? $_REQUEST['ims_purchase_order_id'] : -1;
        if ($id)
            $purchase_order_id = ($id) ? $id : -1;
        $conditions = (isset($_REQUEST['conditions'])) ? $_REQUEST['conditions'] : '';

        eval("\$conditions = array( " . $conditions . " );");
        if ($purchase_order_id != -1) {
            $conditions['ImsPurchaseOrder.ims_purchase_order_id'] = $purchase_order_id;
        }
		$conditions1=array('ImsGrn.created_by <>' => $this->Session->read('Auth.User.id'),'ImsGrn.status <>' => 'created');        
        $this->ImsGrn->recursive = 2;
        $this->set('grns', $this->ImsGrn->find('all', array('conditions' => array($conditions,$conditions1), 'limit' => $limit, 'offset' => $start)));
        $this->set('results', $this->ImsGrn->find('count', array('conditions' => $conditions)));
    }

    function list_data2($id) {
        $this->loadModel('ImsPurchaseOrderItem');

        //'id','item','ordered_quantity','purchased_quantity','ordered_unit_price','purchased_unit_price'
        $grn = $this->ImsGrn->read(null, $id);
        $conditions = array('ImsPurchaseOrderItem.ims_purchase_order_id' => $grn['ImsGrn']['ims_purchase_order_id']);

        $pois = $this->ImsPurchaseOrderItem->find('all', array('conditions' => $conditions));
        $i = 0;

        foreach ($pois as $poi) {
            $qnt = 0;
            if (!empty($poi['ImsGrnItem']))
                foreach ($poi['ImsGrnItem'] as $grni)
                    $qnt = $qnt + $grni['quantity'];

            $pois[$i]['ImsPurchaseOrderItem']['ImsGrnItem']['ims_grn_id'] = $id;
            $pois[$i]['ImsPurchaseOrderItem']['ordered_quantity'] = $pois[$i]['ImsPurchaseOrderItem']['ordered_quantity'] - $qnt;

            if ($pois[$i]['ImsPurchaseOrderItem']['ordered_quantity'] <= 0) {
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
        $this->ImsGrn->recursive = 2;
        $this->set('grn', $this->ImsGrn->read(null, $id));
    }

    function add($id = null) {
        if (!empty($this->data)) {
            $this->data['ImsGrn']['status'] = 'created';
            $this->data['ImsGrn']['created_by'] = $this->Session->read('Auth.User.id');
            $this->ImsGrn->create();
            $this->autoRender = false;
            if ($this->ImsGrn->save($this->data)) {
                $this->Session->setFlash(__('The GRN has been saved', true) . '::' . $this->ImsGrn->id, '');
                $this->render('/elements/success_grn');
            } else {
                $this->Session->setFlash(__('The GRN could not be saved. Please, try again.', true), '');
                $this->render('/elements/failure');
            }
        }
        if ($id)
            $this->set('parent_id', $id);
		$this->ImsGrn->ImsPurchaseOrder->recursive = 3;
        $conditions = array('ImsPurchaseOrder.approved' => 1, 'ImsPurchaseOrder.completed' => 0);
        $suppliers = $this->ImsGrn->ImsSupplier->find('list');
		
        $purchase_orders = $this->ImsGrn->ImsPurchaseOrder->find('all', array('conditions' => $conditions));

        $this->set(compact('suppliers', 'purchase_orders'));
		
		$count = 0;
		$value = $this->ImsGrn->find('first',array('conditions' => array('ImsGrn.name LIKE' => date("Ymd").'%'),'order'=>'ImsGrn.name DESC'));
		if($value != null){
			$value = explode('/',$value['ImsGrn']['name']);		
			$count = $value[1];
		}         

        $this->set('count', $count);
    }
    
    function print_grn($id = null){
        $this->layout = 'print_layout';
        
        if (!$id) {
            $this->autoRender = false;
            $this->Session->setFlash(__('Invalid id for grn', true), '');
            $this->render('/elements/failure');
        }
        $this->ImsGrn->recursive = 3;
        $this->set('grn', $this->ImsGrn->read(null, $id));
    }
    
    function post($id = null) {
        $this->autoRender = false;
        if (!$id) {
            $this->Session->setFlash(__('Invalid id for grn', true), '');
            $this->render('/elements/failure');
        }
        $grn = array('ImsGrn' => array('id' => $id, 'status' => 'posted'));
        if ($this->ImsGrn->save($grn)) {
            $this->Session->setFlash(__('grn posted for approval', true), '');
            $this->render('/elements/success');
        } else {
            $this->Session->setFlash(__('grn was not posted for approval', true), '');
            $this->render('/elements/failure');
        }
    }

    function approve($id = null) {
        $this->autoRender = false;
        $this->data['ImsGrn']['id'] = $id;
        $this->data['ImsGrn']['status'] = 'approved';
        $this->data['ImsGrn']['approved_by'] = $this->Session->read('Auth.User.id');
        $this->loadModel('GroupsUser');
        $conditionsg['GroupsUser.group_id'] = '29';
        $conditionsg['GroupsUser.user_id'] = $this->Session->read('Auth.User.id');
        $perm = $this->GroupsUser->find('count', array('conditions' => $conditionsg));
       
        //if ($perm > 0) {
            if ($this->ImsGrn->save($this->data)) {
				$this->loadModel('ImsCard');
				$grn = $this->ImsGrn->read(null,$id);
				foreach($grn['ImsGrnItem'] as $grnitems){
					$conditions['ImsCard.ims_grn_item_id'] = $grnitems['id'];
					$card=$this->ImsCard->find('first', array('conditions' => $conditions));
					
					$this->ImsCard->read(null,$card['ImsCard']['id']);
                    $this->ImsCard->set('status', 'A');
                    $this->ImsCard->save();
				}
                echo 'The GRN has been approved';
                //$this->Session->setFlash(__('The GRN has been approved', true), '');
                //$this->render('/elements/success');
            } else {
                echo 'The grn could not be approved. Please, try again.';
                //$this->Session->setFlash(__('The grn could not be approved. Please, try again.', true), '');
                //$this->render('/elements/failure');
            }
        /*} else {
            echo 'You dont have the required privilage to approve this GRN.';
            //$this->Session->setFlash(__('You dont have the required privilage to approve this GRN.', true), '');
            //$this->render('/elements/failure'); 
        }*/
    }

    function add_grn_items($id = null) {
        $this->set('grn_id', $id);

        if (isset($_POST)) {
            $this->loadModel('ImsGrnItem');
            $this->loadModel('ImsPurchaseOrderItem');
            $this->loadModel('ImsCard');
            $this->loadModel('ImsPurchaseOrder');

            // for each of the items
            $pq;

            foreach ($_POST as $key => $value) {
                $tmpost = explode('^', $key);
                //$poi = '';
                if ($tmpost[1] == 'id') {
                    $poi = $value;
                    $poi = str_replace('"', '', $poi);
                } elseif ($tmpost[1] == 'ims_grn_id') {
                    $grn_id = $value;
                    $grn_id = str_replace('"', '', $grn_id);
                } elseif ($tmpost[1] == 'purchased_quantity') {
                    // this is if we are dealing with the quantity item
                    $po_item = $this->ImsPurchaseOrderItem->read(null, $poi);
                    $pq = $value;

                    // If not, create the GrnItem and the Card
                    $this->ImsGrnItem->create();

                    $this->data['ImsGrnItem']['ims_purchase_order_item_id'] = $poi;
                    $this->data['ImsGrnItem']['ims_grn_id'] = $grn_id;
                    $this->data['ImsGrnItem']['quantity'] = $value;
                    $this->ImsGrnItem->save($this->data);
                    $lastid = $this->ImsGrnItem->getLastInsertId();
					
					$balance = 0;
					$conditionsB = array('ImsCard.ims_item_id' => $po_item['ImsPurchaseOrderItem']['ims_item_id']);
					$cardB = $this->ImsCard->find('first', array('conditions' =>$conditionsB,'order'=>'ImsCard.id DESC'));
					if($cardB != null){
						$balance = $cardB['ImsCard']['balance'] + $value;
					}
					else{
						$balance = $value;
					}
					
                    $this->ImsCard->create();
                    $card = array('ImsCard' => array());
                    
                    $card['ImsCard']['ims_grn_item_id'] = $lastid;
                    $card['ImsCard']['ims_item_id'] = $po_item['ImsPurchaseOrderItem']['ims_item_id'];
                    $card['ImsCard']['in_quantity'] = $value;
                    $card['ImsCard']['out_quantity'] = 0;
                    $card['ImsCard']['balance'] = $balance;
                    $card['ImsCard']['in_unit_price'] = 0;
                    $card['ImsCard']['out_unit_price'] = 0;

                    $this->ImsCard->save($card);
                } elseif ($tmpost[1] == 'purchased_unit_price') {

                    // this is if we are dealing with the unit price item
                    $po_item = $this->ImsPurchaseOrderItem->read(null, $poi);

                    $this->ImsGrnItem->updateAll(array("unit_price" => $value), array('ImsGrnItem.ims_purchase_order_item_id' => $poi, 'ImsGrnItem.ims_grn_id' => $grn_id));
                    $this->ImsCard->updateAll(array("in_unit_price" => $value), array('ImsCard.ims_item_id' => $po_item['ImsPurchaseOrderItem']['ims_item_id'], 'ImsCard.ims_grn_item_id' => $lastid));

                    $this->ImsPurchaseOrderItem->read(null, $po_item['ImsPurchaseOrderItem']);
                    $this->ImsPurchaseOrderItem->set('purchased_quantity', $pq + $po_item['ImsPurchaseOrderItem']['purchased_quantity']);
                    $this->ImsPurchaseOrderItem->save();
                }
            }
            $grn = $this->ImsGrn->read(null, $id);
            $conditions = array('ImsPurchaseOrderItem.ims_purchase_order_id' => $grn['ImsGrn']['ims_purchase_order_id']);
            $pois = $this->ImsPurchaseOrderItem->find('all', array('conditions' => $conditions));
            $found = 0;

            foreach ($pois as $poi) {
                if ($poi['ImsPurchaseOrderItem']['purchased_quantity'] < $poi['ImsPurchaseOrderItem']['ordered_quantity']) {
                    $found = 1;
                    break;
                }
                $found = 2;
            }
            if ($found == 2) {
                $this->ImsPurchaseOrder->read(null, $grn['ImsGrn']['ims_purchase_order_id']);
                $this->ImsPurchaseOrder->set('completed', 1);
                $this->ImsPurchaseOrder->save();
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
            if ($this->ImsGrn->save($this->data)) {
                $this->Session->setFlash(__('The GRN has been saved', true), '');
                $this->render('/elements/success');
            } else {
                $this->Session->setFlash(__('The grn could not be saved. Please, try again.', true), '');
                $this->render('/elements/failure');
            }
        }
        $this->set('grn', $this->ImsGrn->read(null, $id));

        if ($parent_id) {
            $this->set('parent_id', $parent_id);
        }

        $suppliers = $this->ImsGrn->ImsSupplier->find('list');
        $purchase_orders = $this->ImsGrn->ImsPurchaseOrder->find('list');
        $this->set(compact('suppliers', 'purchase_orders'));
    }

    function delete($id = null) {
        $this->autoRender = false;
		$this->loadModel('ImsGrnItem');
        if (!$id) {
            $this->Session->setFlash(__('Invalid id for grn', true), '');
            $this->render('/elements/failure');
        }
        if (stripos($id, '_') !== false) {
            $ids = explode('_', $id);
            try {
				$msg = '';
                foreach ($ids as $i) {	
					$conditions['ImsGrnItem.ims_grn_id'] = $i;
					if($this->ImsGrn->ImsGrnItem->find('count', array('conditions' => $conditions)) == 0){  
							$this->ImsGrn->delete($i);
					} else {
						$grn = $this->ImsGrn->read(null,$i);
						$msg .= $grn['ImsGrn']['name'] . ',';
					}
                }
				if($msg == '') {
					$this->Session->setFlash(__('GRNs deleted', true), '');
					$this->render('/elements/success4');
				} else
					$this->Session->setFlash('since they have GRN Item(s),Following GRNs were not deleted: ' . $msg, '');
					$this->render('/elements/failure3');
				}
            catch (Exception $e) {
                $this->Session->setFlash(__('GRNs was not deleted', true) . ': ' . $e->getMessage(), '');
                $this->render('/elements/failure');
            }
        } else {
			$conditions['ImsGrnItem.ims_grn_id'] = $id;
			if($this->ImsGrn->ImsGrnItem->find('count', array('conditions' => $conditions)) == 0){
				if ($this->ImsGrn->delete($id)) {
					$this->Session->setFlash(__('Grn deleted', true), '');
					$this->render('/elements/success4');
				} else {
					$this->Session->setFlash(__('Grn was not deleted', true), '');
					$this->render('/elements/failure');
				}
			}
			else{
				$this->Session->setFlash(__('GRN was not deleted because it has GRN Item(s)', true), '');
				$this->render('/elements/failure3');
			}
        }
    }

}

?>