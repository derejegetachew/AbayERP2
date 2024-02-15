<?php
class ImsGrnItemsController extends ImsAppController {

	var $name = 'ImsGrnItems';
	
	function index() {
		$grns = $this->ImsGrnItem->ImsGrn->find('all');
		$this->set(compact('grns'));
	}
	
	function index2($id = null) {
		$this->set('parent_id', $id);
	}
	
	function index_3($id = null) {
		$this->set('grn_id', $id);
	}

	function search() {
	}
	
	function list_data($id = null) {
		$start = (isset($_REQUEST['start'])) ? $_REQUEST['start'] : 0;
		$limit = (isset($_REQUEST['limit'])) ? $_REQUEST['limit'] : 40;
		$grn_id = (isset($_REQUEST['grn_id'])) ? $_REQUEST['grn_id'] : -1;
		if($id)
			$grn_id = ($id) ? $id : -1;
        $conditions = (isset($_REQUEST['conditions'])) ? $_REQUEST['conditions'] : '';

        eval("\$conditions = array( " . $conditions . " );");
		if ($grn_id != -1) {
            $conditions['ImsGrnItem.ims_grn_id'] = $grn_id;
        }
		
		$this->ImsGrnItem->recursive = 2;
		$gis = $this->ImsGrnItem->find('all', array('conditions' => $conditions, 'limit' => $limit, 'offset' => $start));
		//pr($gis);
		$this->set('grn_items', $gis);
		$this->set('results', $this->ImsGrnItem->find('count', array('conditions' => $conditions)));
	}

	function view($id = null) {
		if (!$id) {
			$this->Session->setFlash(__('Invalid grn item', true));
			$this->redirect(array('action' => 'index'));
		}
		$this->ImsGrnItem->recursive = 2;
		$this->set('grnItem', $this->ImsGrnItem->read(null, $id));
	}

	function add($id = null) {
		if (!empty($this->data)) {
			$this->ImsGrnItem->create();
			$this->autoRender = false;
			if ($this->ImsGrnItem->save($this->data)) {
				$this->Session->setFlash(__('The grn item has been saved', true), '');
				$this->render('/elements/success');
			} else {
				$this->Session->setFlash(__('The grn item could not be saved. Please, try again.', true), '');
				$this->render('/elements/failure');
			}
		}
		if($id)
			$this->set('parent_id', $id);
		$grns = $this->ImsGrnItem->ImsGrn->find('list');
		$purchase_order_items = $this->ImsGrnItem->ImsPurchaseOrderItem->find('list');
		$stores = $this->ImsGrnItem->ImsStore->find('list');
		$this->set(compact('grns', 'purchase_order_items', 'stores'));
	}

	function edit($id = null, $parent_id = null) {
		if (!$id && empty($this->data)) {
			$this->Session->setFlash(__('Invalid grn item', true), '');
			$this->redirect(array('action' => 'index'));
		}
		if (!empty($this->data)) {
			$this->autoRender = false;
			if ($this->ImsGrnItem->save($this->data)) {
				$this->Session->setFlash(__('The grn item has been saved', true), '');
				$this->render('/elements/success');
			} else {
				$this->Session->setFlash(__('The grn item could not be saved. Please, try again.', true), '');
				$this->render('/elements/failure');
			}
		}
		$this->set('grn_item', $this->ImsGrnItem->read(null, $id));
		
		if($parent_id) {
			$this->set('parent_id', $parent_id);
		}
			
		$grns = $this->ImsGrnItem->ImsGrn->find('list');
		$purchase_order_items = $this->ImsGrnItem->ImsPurchaseOrderItem->find('list');
		$stores = $this->ImsGrnItem->ImsStore->find('list');
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
                    $this->ImsGrnItem->delete($i);
					////////// delete also from the card //////////////////////
					$this->loadModel('ImsCard');
					$this->ImsCard->recursive = -1;
					$conditionsB = array('ImsCard.ims_grn_item_id' => $i);
					$card = $this->ImsCard->find('first', array('conditions' =>$conditionsB));
					$this->ImsCard->delete($card['ImsCard']['id']);
                }
				$this->Session->setFlash(__('Grn item deleted', true), '');
				$this->render('/elements/success');
            }
            catch (Exception $e){
				$this->Session->setFlash(__('Grn item was not deleted', true), '');
				$this->render('/elements/failure');
            }
        } else {
            if ($this->ImsGrnItem->delete($id)) {
			
				////////// delete also from the card //////////////////////
					$this->loadModel('ImsCard');
					$this->ImsCard->recursive = -1;
					$conditionsB = array('ImsCard.ims_grn_item_id' => $id);
					$card = $this->ImsCard->find('first', array('conditions' =>$conditionsB));
					$this->ImsCard->delete($card['ImsCard']['id']);
					
				$this->Session->setFlash(__('Grn item deleted', true), '');
				$this->render('/elements/success');
			} else {
				$this->Session->setFlash(__('Grn item was not deleted', true), '');
				$this->render('/elements/failure');
			}
        }
	}
	
	function list_grn_items_data1($grn_id){
		$this->ImsGrnItem->recursive = 2;
		$this->loadModel('ImsCard');
		$conditions = array('ImsGrnItem.ims_grn_id' => $grn_id);
		$grnItems = $this->ImsGrnItem->find('all', array('conditions' => $conditions));
		$grnitemArray = array();
		foreach($grnItems as $grnItem){
			$conditionsC = array('ImsCard.ims_grn_item_id' => $grnItem['ImsGrnItem']['id']);
			$cards = $this->ImsCard->find('all', array('conditions' => $conditionsC));
			if(count($cards) == 1 and $cards[0]['ImsCard']['status'] == 'A'){
				$grnitemArray[] = $grnItem;				
			}
		}		
		$this->set('ims_Grn_Items', $grnitemArray);
		$this->set('results', $this->ImsGrnItem->find('count', array('conditions' => $conditions)));
	}
}
?>