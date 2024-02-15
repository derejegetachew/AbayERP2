<?php
class SpItemsController extends AppController {

	var $name = 'SpItems';
	
	function index() {
		//$sp_item_groups = $this->SpItem->SpItemGroup->generatetreelist(null, null, null, '-- ');
		//$this->set(compact('sp_item_groups'));
	}
	
	function index2($id = null) {
		$this->set('parent_id', $id);
	}

	function search() {
	}
	
	function list_data($id = null) {
		$start = (isset($_REQUEST['start'])) ? $_REQUEST['start'] : 0;
		$limit = (isset($_REQUEST['limit'])) ? $_REQUEST['limit'] : 5;
		$spitemgroup_id = (isset($_REQUEST['spitemgroup_id'])) ? $_REQUEST['spitemgroup_id'] : -1;
		if($id)
			$spitemgroup_id = ($id) ? $id : -1;
        $conditions = (isset($_REQUEST['conditions'])) ? $_REQUEST['conditions'] : '';

        eval("\$conditions = array( " . $conditions . " );");
		if ($spitemgroup_id != -1) {
            $conditions['SpItem.sp_item_group_id'] = $spitemgroup_id;
        }
		
		$this->set('sp_items', $this->SpItem->find('all', array('conditions' => $conditions, 'limit' => $limit, 'offset' => $start)));
		$this->set('results', $this->SpItem->find('count', array('conditions' => $conditions)));
	}

	function view($id = null) {
		if (!$id) {
			$this->Session->setFlash(__('Invalid sp item', true));
			$this->redirect(array('action' => 'index'));
		}
		$this->SpItem->recursive = 2;
		$this->set('spItem', $this->SpItem->read(null, $id));
	}

	function add($id = null) {
		if (!empty($this->data)) {
			$this->SpItem->create();
			$this->autoRender = false;
			if ($this->SpItem->save($this->data)) {
				$this->Session->setFlash(__('The sp item has been saved', true), '');
				$this->render('/elements/success');
			} else {
				$this->Session->setFlash(__('The sp item could not be saved. Please, try again.', true), '');
				$this->render('/elements/failure');
			}
		}
		if($id)
			$this->set('parent_id', $id);
		//$sp_item_groups = $this->SpItem->SpItemGroup->find('list');
		$sp_item_groups = $this->SpItem->SpItemGroup->generatetreelist(null, null, null, '-- ');
        $this->set(compact('sp_item_groups'));
	}

	function edit($id = null, $parent_id = null) {
		if (!$id && empty($this->data)) {
			$this->Session->setFlash(__('Invalid sp item', true), '');
			$this->redirect(array('action' => 'index'));
		}
		if (!empty($this->data)) {
			//var_dump($this->data);die();
			$this->autoRender = false;
			if ($this->SpItem->save($this->data)) {
				$this->Session->setFlash(__('The sp item has been saved', true), '');
				$this->render('/elements/success');
			} else {
				$this->Session->setFlash(__('The sp item could not be saved. Please, try again.', true), '');
				$this->render('/elements/failure');
			}
		}
		$this->set('sp_item', $this->SpItem->read(null, $id));
		
		if($parent_id) {
			$this->set('parent_id', $parent_id);
		}
			
		$sp_item_groups = $this->SpItem->SpItemGroup->generatetreelist(null, null, null, '-- ');
		$this->set(compact('sp_item_groups'));
	}

	function delete($id = null) {
		$this->autoRender = false;
		if (!$id) {
			$this->Session->setFlash(__('Invalid id for sp item', true), '');
			$this->render('/elements/failure');
		}
		if (stripos($id, '_') !== false) {
            $ids = explode('_', $id);
            try{
                foreach ($ids as $i) {
                    $this->SpItem->delete($i);
                }
				$this->Session->setFlash(__('Sp item deleted', true), '');
				$this->render('/elements/success');
            }
            catch (Exception $e){
				$this->Session->setFlash(__('Sp item was not deleted', true), '');
				$this->render('/elements/failure');
            }
        } else {
            if ($this->SpItem->delete($id)) {
				$this->Session->setFlash(__('Sp item deleted', true), '');
				$this->render('/elements/success');
			} else {
				$this->Session->setFlash(__('Sp item was not deleted', true), '');
				$this->render('/elements/failure');
			}
        }
	}
}
?>