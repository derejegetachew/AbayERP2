<?php

class ImsPurchaseOrderItemsController extends ImsAppController {

    var $name = 'ImsPurchaseOrderItems';

    function index() {
        $purchase_orders = $this->ImsPurchaseOrderItem->ImsPurchaseOrder->find('all');
        $this->set(compact('purchase_orders'));
    }

    function index2($id = null) {
        $this->set('parent_id', $id);
        
        $po = $this->ImsPurchaseOrderItem->ImsPurchaseOrder->read(null, $id);
        $this->set('posted',$po['ImsPurchaseOrder']['posted']);       
        
        $conditions = array('ImsPurchaseOrderItem.ims_purchase_order_id' => $id);
        $purchase_order_items = $this->ImsPurchaseOrderItem->find('all',array('conditions' => $conditions));
        $grand_total_price=0;
        foreach($purchase_order_items as $purchase_order_item){
          $grand_total_price += ($purchase_order_item['ImsPurchaseOrderItem']['unit_price'] *$purchase_order_item['ImsPurchaseOrderItem']['ordered_quantity']);          
        }
        $this->set('grand_total_price',$grand_total_price);
    }

    function search() {
        
    }

    function list_data($id = null) {
        $start = (isset($_REQUEST['start'])) ? $_REQUEST['start'] : 0;
        $limit = (isset($_REQUEST['limit'])) ? $_REQUEST['limit'] : 40;
        $purchase_order_id = (isset($_REQUEST['purchase_order_id'])) ? $_REQUEST['purchase_order_id'] : -1;
        if ($id)
            $purchase_order_id = ($id) ? $id : -1;
        $conditions = (isset($_REQUEST['conditions'])) ? $_REQUEST['conditions'] : isset($_REQUEST['query']) ? $_REQUEST['query'] :'';

        eval("\$conditions = array( " . $conditions . " );");
        if ($purchase_order_id != -1) {
            $conditions['ims_purchase_order_id'] = $purchase_order_id;
        }

        $this->set('purchase_order_items', $this->ImsPurchaseOrderItem->find('all', array('conditions' => $conditions, 'limit' => $limit, 'offset' => $start)));
        $this->set('results', $this->ImsPurchaseOrderItem->find('count', array('conditions' => $conditions)));
    }

    function view($id = null) {
        if (!$id) {
            $this->Session->setFlash(__('Invalid purchase order item', true));
            $this->redirect(array('action' => 'index'));
        }
        $this->ImsPurchaseOrderItem->recursive = 2;
        $this->set('purchase_order_item', $this->ImsPurchaseOrderItem->read(null, $id));
    }

    function add($id = null) {

        if (!empty($this->data)) {
		
			// Strip out carriage returns
            $content = ereg_replace("\r",'',$this->data['ImsPurchaseOrderItem']['remark']);
            // Handle paragraphs
            $content = ereg_replace("\n\n",'<br /><br />',$content);
            // Handle line breaks
            $content = ereg_replace("\n",'<br />',$content);
            // Handle apostrophes
            $content = ereg_replace("'",'[APOSTROPHE]',$content);
			// double quotes
            $content = ereg_replace('"','&quot;',$content);
			// slash
            $content = ereg_replace("/",'&#47;',$content);
			$this->data['ImsPurchaseOrderItem']['remark'] = $content;
		
            $this->ImsPurchaseOrderItem->create();
            $this->autoRender = false;
            $this->loadModel('ImsItem');
            $itemObj = new ImsItem();
            if ($this->ImsPurchaseOrderItem->save($this->data)) {
                $poi = $this->ImsPurchaseOrderItem->read(null, $this->ImsPurchaseOrderItem->id);
                $ordered_quantity = $poi['ImsPurchaseOrderItem']['ordered_quantity'];
                $max_level = $poi['ImsItem']['max_level'];
                $available = $itemObj->getAvailableBalance($poi['ImsPurchaseOrderItem']['ims_item_id']);
                $msg = '';
                if ($max_level <= ($available + $ordered_quantity)) {
                    $msg .= 'The item is passing its maximum level of ' . $max_level .
                            ' and already ' . $available .
                            ' is available.  ' .
                            'Please make sure you are ordering the appropriate item with appropriate quantity.';
                }
                $this->Session->setFlash(__('The purchase order item has been saved', true) . '. ' . $msg, '');
                $this->set('flag', ($msg == '' ? 'ext-mb-info' : 'ext-mb-warning'));
                $this->render('/elements/success3');
            } else {
                $this->Session->setFlash(__('The purchase order item could not be saved. Please, try again.', true), '');
                $this->render('/elements/failure');
            }
        }
        if ($id)
            $this->set('parent_id', $id);
        $purchase_orders = $this->ImsPurchaseOrderItem->ImsPurchaseOrder->find('list');
		
		
        $array[] = null;
		$array2[] = null;
		$this->ImsPurchaseOrderItem->ImsItem->recursive = -1;
		$items = $this->ImsPurchaseOrderItem->ImsItem->find('all');
		foreach($items as $item){			
			$array[] = $item['ImsItem'];			
		}
		
		$this->ImsPurchaseOrderItem->recursive = 0;
		$conditions = array('ImsPurchaseOrder.id' => $id);
		$purchaseOrderitems =$this->ImsPurchaseOrderItem->find('all',array('conditions' => $conditions));
		if(!empty($purchaseOrderitems)){
			foreach($purchaseOrderitems as $purchaseOrderitem){
				$array2[] = $purchaseOrderitem['ImsItem'];				
			}
		}
		$results = array_diff(array_map('serialize',$array),array_map('serialize',$array2));
		$results = array_map('unserialize',$results);
		
        $this->set(compact('purchase_orders', 'results'));
    }

    function edit($id = null, $parent_id = null) {
        if (!$id && empty($this->data)) {
            $this->Session->setFlash(__('Invalid purchase order item', true), '');
            $this->redirect(array('action' => 'index'));
        }
        if (!empty($this->data)) {
            $this->autoRender = false;
			
			// Strip out carriage returns
            $content = ereg_replace("\r",'',$this->data['ImsPurchaseOrderItem']['remark']);
            // Handle paragraphs
            $content = ereg_replace("\n\n",'<br /><br />',$content);
            // Handle line breaks
            $content = ereg_replace("\n",'<br />',$content);
            // Handle apostrophes
            $content = ereg_replace("'",'[APOSTROPHE]',$content);
			// double quotes
            $content = ereg_replace('"','&quot;',$content);
			// slash
            $content = ereg_replace("/",'&#47;',$content);
			$this->data['ImsPurchaseOrderItem']['remark'] = $content;
			
            if ($this->ImsPurchaseOrderItem->save($this->data)) {
                $this->Session->setFlash(__('The purchase order item has been saved', true), '');
                $this->render('/elements/success');
            } else {
                $this->Session->setFlash(__('The purchase order item could not be saved. Please, try again.', true), '');
                $this->render('/elements/failure');
            }
        }
        $this->set('purchase_order_item', $this->ImsPurchaseOrderItem->read(null, $id));
		
        if ($parent_id) {
            $this->set('parent_id', $parent_id);
        }

        $purchase_orders = $this->ImsPurchaseOrderItem->ImsPurchaseOrder->find('list');
        $items = $this->ImsPurchaseOrderItem->ImsItem->find('list');
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
                    $this->ImsPurchaseOrderItem->delete($i);
                }
                $this->Session->setFlash(__('Purchase order item deleted', true), '');
                $this->render('/elements/success');
            } catch (Exception $e) {
                $this->Session->setFlash(__('Purchase order item was not deleted', true), '');
                $this->render('/elements/failure');
            }
        } else {
            if ($this->ImsPurchaseOrderItem->delete($id)) {
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