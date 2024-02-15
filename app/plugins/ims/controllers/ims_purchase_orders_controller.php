<?php

class ImsPurchaseOrdersController extends ImsAppController {

    var $name = 'ImsPurchaseOrders';

    function index() {
		$this->ImsPurchaseOrder->User->recursive = 0;
		$this->ImsPurchaseOrder->ImsSupplier->recursive = -1;
        $users = $this->ImsPurchaseOrder->User->find('all');
		$suppliers = $this->ImsPurchaseOrder->ImsSupplier->find('all');
        $this->set(compact('users','suppliers'));
    }
    
    function index_1() {
		$this->ImsPurchaseOrder->User->recursive = 0;
		$this->ImsPurchaseOrder->ImsSupplier->recursive = -1;
        $users = $this->ImsPurchaseOrder->User->find('all');
		$suppliers = $this->ImsPurchaseOrder->ImsSupplier->find('all');
        $this->set(compact('users','suppliers'));
    }

    function index2($id = null) {
        $this->set('parent_id', $id);
    }
	
	function index_uncompletedpo(){
		
	}
	
	function index_supplierPO(){
		$this->ImsPurchaseOrder->ImsSupplier->recursive = -1;
		$suppliers = $this->ImsPurchaseOrder->ImsSupplier->find('all');
        $this->set(compact('suppliers'));
	}

    function search() {
        
    }

    function list_data($id = null) {
        $start = (isset($_REQUEST['start'])) ? $_REQUEST['start'] : 0;
        $limit = (isset($_REQUEST['limit'])) ? $_REQUEST['limit'] : 40;
        $user_id = (isset($_REQUEST['user_id'])) ? $_REQUEST['user_id'] : -1;
		$supplier_id = (isset($_REQUEST['supplier_id'])) ? $_REQUEST['supplier_id'] : -1;
        if ($id){
            $user_id = ($id) ? $id : -1;
			$supplier_id = ($id) ? $id : -1;
			}
        $conditions = (isset($_REQUEST['conditions'])) ? $_REQUEST['conditions'] : '';

        eval("\$conditions = array( " . $conditions . " );");
        if ($user_id != -1) {
            $conditions['ImsPurchaseOrder.user_id'] = $user_id;
        }
		if ($supplier_id != -1) {
            $conditions['ImsPurchaseOrder.ims_supplier_id'] = $supplier_id;
        }
        $this->ImsPurchaseOrder->recursive = 2;
        $this->set('purchase_orders', $this->ImsPurchaseOrder->find('all', array('conditions' => $conditions, 'limit' => $limit, 'offset' => $start, 'order'=>'ImsPurchaseOrder.name DESC')));
        $this->set('results', $this->ImsPurchaseOrder->find('count', array('conditions' => $conditions)));
    }
	
	function list_data_combo($id = null) {
        
        $this->ImsPurchaseOrder->recursive = 2;
		$this->ImsPurchaseOrder->unbindModel(array('belongsTo' => array('User','ApprovedUser', 'ImsSupplier'),'hasMany' => array('ImsGrn')));
		$name = (isset($_REQUEST['name'])) ? $_REQUEST['name'] : '';	
		$condition = array('ImsPurchaseOrder.name LIKE' => $name . '%', 'ImsPurchaseOrder.approved' => 1, 'ImsPurchaseOrder.completed' => 0);
        $this->set('purchase_orders', $this->ImsPurchaseOrder->find('all', array('conditions' => $condition)));
        $this->set('results', $this->ImsPurchaseOrder->find('count', array('conditions' => $condition)));
    }
    
    function list_data_1($id = null) {
        $start = (isset($_REQUEST['start'])) ? $_REQUEST['start'] : 0;
        $limit = (isset($_REQUEST['limit'])) ? $_REQUEST['limit'] : 40;
        $user_id = (isset($_REQUEST['user_id'])) ? $_REQUEST['user_id'] : -1;
		$supplier_id = (isset($_REQUEST['supplier_id'])) ? $_REQUEST['supplier_id'] : -1;

        if ($id){
            $user_id = ($id) ? $id : -1;
			$supplier_id = ($id) ? $id : -1;
		}
        $conditions = (isset($_REQUEST['conditions'])) ? $_REQUEST['conditions'] : '';

        eval("\$conditions = array( " . $conditions . " );");
        $conditions['ImsPurchaseOrder.user_id <>'] = $this->Session->read('Auth.User.id');
		
		if ($user_id != -1) {
            $conditions['ImsPurchaseOrder.user_id'] = $user_id;
        }
		if ($supplier_id != -1) {
            $conditions['ImsPurchaseOrder.ims_supplier_id'] = $supplier_id;
        }
        
        $conditions['ImsPurchaseOrder.posted'] = true;
        $this->ImsPurchaseOrder->recursive = 2;
        $this->set('purchase_orders', $this->ImsPurchaseOrder->find('all', array('conditions' => $conditions, 'limit' => $limit, 'offset' => $start, 'order'=>'ImsPurchaseOrder.name DESC')));
        $this->set('results', $this->ImsPurchaseOrder->find('count', array('conditions' => $conditions)));
    }

    function view($id = null) {
        if (!$id) {
            $this->Session->setFlash(__('Invalid purchase order', true));
            $this->redirect(array('action' => 'index'));
        }
        $this->ImsPurchaseOrder->recursive = 2;
        $this->set('purchase_order', $this->ImsPurchaseOrder->read(null, $id));
    }

    function add($id = null) {
        if (!empty($this->data)) {
            $this->ImsPurchaseOrder->create();
            $this->data['ImsPurchaseOrder']['posted'] = false;
            $this->data['ImsPurchaseOrder']['approved'] = false;
            $this->data['ImsPurchaseOrder']['completed']=false;
            $this->data['ImsPurchaseOrder']['user_id'] = $this->Session->read('Auth.User.id');
            
            $this->autoRender = false;
            if ($this->ImsPurchaseOrder->save($this->data)) {
               
                $this->Session->setFlash(__('The purchase order has been saved', true) . '::' . $this->ImsPurchaseOrder->id, '');
                $this->render('/elements/success_po');
            } else {
                $this->Session->setFlash(__('The purchase order could not be saved. Please, try again.', true), '');
                $this->render('/elements/failure');
            }
        }
        if ($id)
            $this->set('parent_id', $id);
        $users = $this->ImsPurchaseOrder->User->find('list');
		$suppliers = $this->ImsPurchaseOrder->ImsSupplier->find('all');
        $this->set(compact('suppliers','users'));
        
		$count = 0;
		$value = $this->ImsPurchaseOrder->find('first',array('conditions' => array('ImsPurchaseOrder.name LIKE' => date("Ymd").'%'),'order'=>'ImsPurchaseOrder.name DESC'));
		if($value != null){
			$value = explode('/',$value['ImsPurchaseOrder']['name']);		
			$count = $value[1];
		}       
       
        $this->set('count',$count);
    }
    
    function print_po($id = null){
        $this->layout = 'print_layout';
        
        if (!$id) {
            $this->autoRender = false;
            $this->Session->setFlash(__('Invalid id for purchase order', true), '');
            $this->render('/elements/failure');
        }
        $this->ImsPurchaseOrder->recursive = 2;
        $this->set('purchase_order', $this->ImsPurchaseOrder->read(null, $id));
    }
    
    function post($id = null) {
        $this->autoRender = false;
        if (!$id) {
            $this->Session->setFlash(__('Invalid id for purchase order', true), '');
            $this->render('/elements/failure');
        }
        $purchase_order = array('ImsPurchaseOrder' => array('id' => $id, 'posted' => true));
        if ($this->ImsPurchaseOrder->save($purchase_order)) {
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
		$user = $this->Session->read();	
        $purchase_order = array('ImsPurchaseOrder' => array('id' => $id, 'approved_by' => $user['Auth']['User']['id'], 'approved' => true));
        if ($this->ImsPurchaseOrder->save($purchase_order)) {
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
        $purchase_order = array('ImsPurchaseOrder' => array('id' => $id, 'rejected' => true));
        if ($this->ImsPurchaseOrder->save($purchase_order)) {
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
            if ($this->ImsPurchaseOrder->save($this->data)) {
                $this->Session->setFlash(__('The purchase order has been saved', true), '');
                $this->render('/elements/success');
            } else {
                $this->Session->setFlash(__('The purchase order could not be saved. Please, try again.', true), '');
                $this->render('/elements/failure');
            }
        }
        $this->set('purchase_order', $this->ImsPurchaseOrder->read(null, $id));

        if ($parent_id) {
            $this->set('parent_id', $parent_id);
        }

        $users = $this->ImsPurchaseOrder->User->find('list');
		$suppliers = $this->ImsPurchaseOrder->ImsSupplier->find('list');
        $this->set(compact('suppliers','users'));
    }

    function delete($id = null) {
        $this->autoRender = false;
		$this->loadModel('ImsGrn');
		$this->loadModel('ImsPurchaseOrderItem');
        if (!$id) {
            $this->Session->setFlash(__('Invalid id for purchase order', true), '');
            $this->render('/elements/failure');
        }
        if (stripos($id, '_') !== false) {
            $ids = explode('_', $id);
            try {
				$msg = '';
                foreach ($ids as $i) {	
					$conditions['ImsGrn.ims_purchase_order_id'] = $i;
					$conditions1['ImsPurchaseOrderItem.ims_purchase_order_id'] = $i;
					if($this->ImsPurchaseOrder->ImsGrn->find('count', array('conditions' => $conditions)) == 0 and 
						$this->ImsPurchaseOrder->ImsPurchaseOrderItem->find('count', array('conditions' => $conditions1)) == 0){  
							$this->ImsPurchaseOrder->delete($i);
					} else {
						$po = $this->ImsPurchaseOrder->read(null,$i);
						$msg .= $po['ImsPurchaseOrder']['name'] . ',';
					}
                }
				if($msg == '') {
					$this->Session->setFlash(__('PO deleted', true), '');
					$this->render('/elements/success4');
				} else
					$this->Session->setFlash('since they have PO Item(s) / GRN(s), Following POs were not deleted: ' . $msg, '');
					$this->render('/elements/failure3');
				}
            catch (Exception $e) {
                $this->Session->setFlash(__('PO was not deleted', true) . ': ' . $e->getMessage(), '');
                $this->render('/elements/failure');
            }
        } else {
			$conditions['ImsGrn.ims_purchase_order_id'] = $id;
			$conditions1['ImsPurchaseOrderItem.ims_purchase_order_id'] = $id;
			if($this->ImsPurchaseOrder->ImsGrn->find('count', array('conditions' => $conditions)) == 0 and 
				$this->ImsPurchaseOrder->ImsPurchaseOrderItem->find('count', array('conditions' => $conditions1)) == 0){
				if ($this->ImsPurchaseOrder->delete($id)) {
					$this->Session->setFlash(__('Purchase order deleted', true), '');
					$this->render('/elements/success4');
				} else {
					$this->Session->setFlash(__('Purchase order was not deleted', true), '');
					$this->render('/elements/failure');
				}
			}
			else{
				$this->Session->setFlash(__('PO was not deleted because it has PO Item(s) / GRN(s) ', true), '');
				$this->render('/elements/failure3');
			}
        }
    }
	
	function uncompleted_po() {
		$this->layout = 'ajax';		
		
        if (!empty($this->data)) {
			$this->ImsPurchaseOrder->recursive =2;			
			$conditionspo =array('ImsPurchaseOrder.completed' => 0,'ImsPurchaseOrder.approved' => 1);  						 
			$purchaseorders = $this->ImsPurchaseOrder->find('all', array('conditions' => $conditionspo));
			
			$result = array();
			$count = 0;
			$poarray = array();
			$poname = '';
			
			for($j=0;$j<count($purchaseorders);$j++){						
						
	/////////////////////  po item  ///////////////////////////////////////////////////////////////////////////////////////////////////
				if($poname = '' or $poname != $purchaseorders[$j]['ImsPurchaseOrder']['name']){
					$result[$count][0] = $purchaseorders[$j]['ImsPurchaseOrder']['name'];
					$result[$count][1] = $purchaseorders[$j]['ImsSupplier']['name'];
					$poname = $purchaseorders[$j]['ImsPurchaseOrder']['name'];
				}
				$countpoitem = 0;
				foreach($purchaseorders[$j]['ImsPurchaseOrderItem'] as $poitems)
				{
					if($poitems['ordered_quantity'] != $poitems['purchased_quantity']){
													
						$result[$count][2] = $poitems['ImsItem']['description'];
						$result[$count][3] = $poitems['ImsItem']['name'];
						$result[$count][4] = $poitems['ordered_quantity'];
						$result[$count][5] = $poitems['purchased_quantity'];
						$result[$count][6] = $poitems['ordered_quantity'] - $poitems['purchased_quantity'];
						$count++;
						$countpoitem++;
						
					}
				}
				$poarray[$purchaseorders[$j]['ImsPurchaseOrder']['name']] = $countpoitem;
				
   /////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////				
			}			
			
			$this->set('result',$result);
			$this->set('poarray',$poarray);	
        }	
	}
	
	function supplier_po() {
		$this->layout = 'ajax';		
		
        if (!empty($this->data)) {
			$this->ImsPurchaseOrder->recursive =2;			
			$conditionspo =array('ImsPurchaseOrder.approved' => 1,'ImsPurchaseOrder.ims_supplier_id' => $this->data['ImsPurchaseOrder']['ims_supplier_id']);  						 
			$purchaseorders = $this->ImsPurchaseOrder->find('all', array('conditions' => $conditionspo));
			
			$result = array();
			$count = 0;
			$poarray = array();
			$poname = '';
			$grandTotal = 0;
			
			for($j=0;$j<count($purchaseorders);$j++){						
						
	/////////////////////  po item  ///////////////////////////////////////////////////////////////////////////////////////////////////
				if($poname = '' or $poname != $purchaseorders[$j]['ImsPurchaseOrder']['name']){
					$result[$count][0] = $purchaseorders[$j]['ImsPurchaseOrder']['name'];
					$poname = $purchaseorders[$j]['ImsPurchaseOrder']['name'];
				}
				$countpoitem = 0;
				foreach($purchaseorders[$j]['ImsPurchaseOrderItem'] as $poitems)
				{
					if($poitems['purchased_quantity'] > 0){
													
						$result[$count][1] = $poitems['ImsItem']['description'];
						$result[$count][2] = $poitems['ImsItem']['name'];
						$result[$count][3] = $poitems['ordered_quantity'];
						$result[$count][4] = $poitems['purchased_quantity'];
						$result[$count][5] = $poitems['ordered_quantity'] - $poitems['purchased_quantity'];
						$result[$count][6] = $poitems['ImsGrnItem'][0]['unit_price'];
						$sum = $poitems['purchased_quantity'] * $poitems['ImsGrnItem'][0]['unit_price'];
						$result[$count][7] = number_format($sum);
						$grandTotal = $grandTotal + $sum;						
						$count++;
						$countpoitem++;
						
					}
				}
				$poarray[$purchaseorders[$j]['ImsPurchaseOrder']['name']] = $countpoitem;
				
   /////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////				
			}			
			$grandTotal = number_format($grandTotal);
			$this->set('result',$result);
			$this->set('poarray',$poarray);	
			$this->set('supplier',$purchaseorders[0]['ImsSupplier']['name']);
			$this->set('grandTotal',$grandTotal);
        }	
	}

}

?>