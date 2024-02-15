<?php
class ImsDisposalItemsController extends AppController {

	var $name = 'ImsDisposalItems';
	
	function index() {
		$ims_disposals = $this->ImsDisposalItem->ImsDisposal->find('all');
		$this->set(compact('ims_disposals'));
	}
	
	function index2($id = null) {
		$this->set('parent_id', $id);
	}

	function search() {
	}
	
	function list_data($id = null) {
		$start = (isset($_REQUEST['start'])) ? $_REQUEST['start'] : 0;
		$limit = (isset($_REQUEST['limit'])) ? $_REQUEST['limit'] : 5;
		$imsdisposal_id = (isset($_REQUEST['ims_disposal_id'])) ? $_REQUEST['imsdisposal_id'] : -1;
		if($id)
			$imsdisposal_id = ($id) ? $id : -1;
        $conditions = (isset($_REQUEST['conditions'])) ? $_REQUEST['conditions'] : '';

        eval("\$conditions = array( " . $conditions . " );");
		if ($imsdisposal_id != -1) {
            $conditions['ImsDisposalItem.ims_disposal_id'] = $imsdisposal_id;
        }
		
		$this->set('ims_disposal_items', $this->ImsDisposalItem->find('all', array('conditions' => $conditions, 'limit' => $limit, 'offset' => $start)));
		$this->set('results', $this->ImsDisposalItem->find('count', array('conditions' => $conditions)));
	}

	function view($id = null) {
		if (!$id) {
			$this->Session->setFlash(__('Invalid disposal item', true));
			$this->redirect(array('action' => 'index'));
		}
		$this->ImsDisposalItem->recursive = 2;
		$this->set('imsDisposalItem', $this->ImsDisposalItem->read(null, $id));
	}

	function add($id = null) {
		if (!empty($this->data)) {
			$this->ImsDisposalItem->create();
			$this->autoRender = false;
			if ($this->ImsDisposalItem->save($this->data)) {
				$this->Session->setFlash(__('The disposal item has been saved', true), '');
				$this->render('/elements/success');
			} else {
				$this->Session->setFlash(__('The disposal item could not be saved. Please, try again.', true), '');
				$this->render('/elements/failure');
			}
		}
		if($id)
			$this->set('parent_id', $id);
		$ims_disposals = $this->ImsDisposalItem->ImsDisposal->find('list');
		
		$array[] = null;
		$array2[] = null;
		$this->ImsDisposalItem->ImsItem->recursive = 0;
		$items = $this->ImsDisposalItem->ImsItem->find('all');
		foreach($items as $item){			
			$array[] = $item['ImsItem'];			
		}
		
		$this->ImsDisposalItem->recursive = 0;
		$conditions = array('ImsDisposal.id' => $id);
		$disposalitems =$this->ImsDisposalItem->find('all',array('conditions' => $conditions));
		if(!empty($disposalitems)){
			foreach($disposalitems as $disposalitem){
				$array2[] = $disposalitem['ImsItem'];				
			}
		}
		$results = array_diff(array_map('serialize',$array),array_map('serialize',$array2));
		$results = array_map('unserialize',$results);
		
		$this->set(compact('ims_disposals', 'results'));
	}

	function edit($id = null, $parent_id = null) {
		if (!$id && empty($this->data)) {
			$this->Session->setFlash(__('Invalid disposal item', true), '');
			$this->redirect(array('action' => 'index'));
		}
		if (!empty($this->data)) {
			$this->autoRender = false;
			if ($this->ImsDisposalItem->save($this->data)) {
				$this->Session->setFlash(__('The disposal item has been saved', true), '');
				$this->render('/elements/success');
			} else {
				$this->Session->setFlash(__('The disposal item could not be saved. Please, try again.', true), '');
				$this->render('/elements/failure');
			}
		}
		$this->set('ims_disposal_item', $this->ImsDisposalItem->read(null, $id));
		
		if($parent_id) {
			$this->set('parent_id', $parent_id);
		}
			
		$ims_disposals = $this->ImsDisposalItem->ImsDisposal->find('list');
		
		$array[] = null;
		$array2[] = null;
		$this->ImsDisposalItem->ImsItem->recursive = 0;
		$ims_items = $this->ImsDisposalItem->ImsItem->find('all');
		foreach($ims_items as $item){			
			$array[] = $item['ImsItem'];			
		}
		
		$this->ImsDisposalItem->recursive = 0;
		$conditions = array('ImsDisposal.id' => $parent_id, 'ImsDisposalItem.id !=' => $id);
		$disposalitems =$this->ImsDisposalItem->find('all',array('conditions' => $conditions));
		if(!empty($disposalitems)){
			foreach($disposalitems as $disposalitem){
				$array2[] = $disposalitem['ImsItem'];				
			}
		}
		$results = array_diff(array_map('serialize',$array),array_map('serialize',$array2));
		$results = array_map('unserialize',$results);
		
		$this->set(compact('ims_disposals', 'results'));
	}

	function delete($id = null) {
		$this->autoRender = false;
		if (!$id) {
			$this->Session->setFlash(__('Invalid id for disposal item', true), '');
			$this->render('/elements/failure');
		}
		if (stripos($id, '_') !== false) {
            $ids = explode('_', $id);
            try{
                foreach ($ids as $i) {
                    $this->ImsDisposalItem->delete($i);
                }
				$this->Session->setFlash(__('disposal item deleted', true), '');
				$this->render('/elements/success');
            }
            catch (Exception $e){
				$this->Session->setFlash(__('disposal item was not deleted', true), '');
				$this->render('/elements/failure');
            }
        } else {
            if ($this->ImsDisposalItem->delete($id)) {
				$this->Session->setFlash(__('disposal item deleted', true), '');
				$this->render('/elements/success');
			} else {
				$this->Session->setFlash(__('disposal item was not deleted', true), '');
				$this->render('/elements/failure');
			}
        }
	}
}
?>