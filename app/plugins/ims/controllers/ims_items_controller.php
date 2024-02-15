<?php

class ImsItemsController extends ImsAppController {

    var $name = 'ImsItems';
	var $cat_ids = array();
	
	function beforeFilter() {
		parent::beforeFilter(); 
		$this->Auth->allow('index');
		$this->Auth->deny('add','edit');
		
		$user = $this->Session->read();
		$groups =$user['Auth']['Group'];
		foreach($groups as $group){
			if($group['name'] == 'Stock Record Officer')
			{
				$this->Auth->allow('add','edit');
			}
		}
	}
	
    function index() {
        //$item_categories = $this->ImsItem->ImsItemCategory->find('all');
        $item_categories = $this->ImsItem->ImsItemCategory->generatetreelist(null, null, null, '---');
		
		$this->loadModel('ImsStore');
		$stores = $this->ImsStore->find('all');
		
        $this->set(compact('item_categories','stores'));
    }
	
	function index_1() {
        //$item_categories = $this->ImsItem->ImsItemCategory->find('all');
        $item_categories = $this->ImsItem->ImsItemCategory->generatetreelist(null, null, null, '---');
		
		$this->loadModel('ImsStore');
		$stores = $this->ImsStore->find('all');
		
        $this->set(compact('item_categories','stores'));
    }

    function index2($id = null) {
        $this->set('parent_id', $id);
    }

    function search() {
        
    }

    function list_data($id = null) {
        $start = (isset($_REQUEST['start'])) ? $_REQUEST['start'] : 0;
        $limit = (isset($_REQUEST['limit'])) ? $_REQUEST['limit'] : 5;
		
        $ims_item_category_id = (isset($_REQUEST['ims_item_category_id'])) ? $_REQUEST['ims_item_category_id'] : -1;
        if ($id)
            $ims_item_category_id = ($id) ? $id : -1;
        $conditions = (isset($_REQUEST['conditions'])) ? $_REQUEST['conditions'] : isset($_REQUEST['query']) ? $_REQUEST['query'] : '';
        
        eval("\$conditions = array( " . $conditions . " );");
		//pr($conditions);
		if(isset($conditions[0]))
		
			$ims_item_category_id = $conditions[0];
			
        if ($ims_item_category_id != -1) {
			$this->cat_ids[] = $ims_item_category_id;
			
			$cat = $this->ImsItem->ImsItemCategory->read(null, $ims_item_category_id);
			$this->getChildCatIds($cat);
			
            $conditions['ims_item_category_id'] = count($this->cat_ids) > 1? $this->cat_ids: $ims_item_category_id;
        }
		$this->ImsItem->recursive = 0;
        $this->set('items', $this->ImsItem->find('all', array('conditions' => $conditions, 'order' => 'ims_item_category_id', 'limit' => $limit, 'offset' => $start)));
        $this->set('results', $this->ImsItem->find('count', array('conditions' => $conditions)));
    }
	
	function getChildCatIds($cat) {
		if(count($cat['ChildImsItemCategory']) > 0) {
			foreach($cat['ChildImsItemCategory'] as $child) {
				$this->cat_ids[] = $child['id'];
				$this->getChildCatIds($this->ImsItem->ImsItemCategory->read(null, $child['id']));
			}
		}
	}
    
    function view($id = null) {
        if (!$id) {
            $this->Session->setFlash(__('Invalid item', true));
            $this->redirect(array('action' => 'index'));
        }
        $this->ImsItem->recursive = 2;
        $this->set('item', $this->ImsItem->read(null, $id));
    }

    function add($id = null) {
        if (!empty($this->data)) {
            $this->ImsItem->create();
            $this->autoRender = false;
            if ($this->ImsItem->save($this->data)) {
                $this->Session->setFlash(__('The item has been saved', true), '');
                $this->render('/elements/success');
            } else {
                $this->Session->setFlash(__('The item could not be saved. Please, try again.', true), '');
                $this->render('/elements/failure');
            }
        }
        if ($id)
            $this->set('parent_id', $id);
        $item_categories = $this->ImsItem->ImsItemCategory->generatetreelist(null, null, null, '---');
        $this->set(compact('item_categories'));
    }

    function edit($id = null, $parent_id = null) {
        if (!$id && empty($this->data)) {
            $this->Session->setFlash(__('Invalid item', true), '');
            $this->redirect(array('action' => 'index'));
        }
        if (!empty($this->data)) {		
            $this->autoRender = false;
            if ($this->ImsItem->save($this->data)) {
                $this->Session->setFlash(__('The item has been saved', true), '');
                $this->render('/elements/success');
            } else {
                $this->Session->setFlash(__('The item could not be saved. Please, try again.', true), '');
                $this->render('/elements/failure');
            }
        }
        $this->set('item', $this->ImsItem->read(null, $id));

        if ($parent_id) {
            $this->set('parent_id', $parent_id);
        }

        $item_categories = $this->ImsItem->ImsItemCategory->generatetreelist(null, null, null, '---');
        $this->set(compact('item_categories'));
    }

    function delete($id = null) {
        $this->autoRender = false;
		$this->loadModel('ImsCard');
		$this->loadModel('ImsPurchaseOrderItem');
        if (!$id) {
            $this->Session->setFlash(__('Invalid id for item', true), '');
            $this->render('/elements/failure');
        }
        if (stripos($id, '_') !== false) {
            $ids = explode('_', $id);
            try {
				$msg = '';
                foreach ($ids as $i) {	
					$conditions['ImsCard.ims_item_id'] = $i;
					$conditions1['ImsPurchaseOrderItem.ims_item_id'] = $i;
					if($this->ImsItem->ImsCard->find('count', array('conditions' => $conditions)) == 0 and 
						$this->ImsItem->ImsPurchaseOrderItem->find('count', array('conditions' => $conditions1)) == 0){  
							$this->ImsItem->delete($i);
					} else {
						$item = $this->ImsItem->read(null,$i);
						$msg .= $item['ImsItem']['name'] . ',';
					}
                }
				if($msg == '') {
					$this->Session->setFlash(__('Items deleted', true), '');
					$this->render('/elements/success4');
				} else
					$this->Session->setFlash('since they have PO Item(s) / Card(s), Following items were not deleted: ' . $msg, '');
					$this->render('/elements/failure3');
				}
            catch (Exception $e) {
                $this->Session->setFlash(__('Item was not deleted', true) . ': ' . $e->getMessage(), '');
                $this->render('/elements/failure');
            }
        } else {
			$conditions['ImsCard.ims_item_id'] = $id;
			$conditions1['ImsPurchaseOrderItem.ims_item_id'] = $id;
			if($this->ImsItem->ImsCard->find('count', array('conditions' => $conditions)) == 0 and 
				$this->ImsItem->ImsPurchaseOrderItem->find('count', array('conditions' => $conditions1)) == 0){
				if ($this->ImsItem->delete($id)) {
					$this->Session->setFlash(__('Item deleted', true), '');
					$this->render('/elements/success4');
				} else {
					$this->Session->setFlash(__('Item was not deleted', true), '');
					$this->render('/elements/failure');
				}
			}
			else{
				$this->Session->setFlash(__('Item was not deleted because it has PO Item(s) / Card(s) ', true), '');
				$this->render('/elements/failure3');
			}
        }
    }

}

?>