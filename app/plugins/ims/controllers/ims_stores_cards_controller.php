<?php
class ImsStoresCardsController extends AppController {

	var $name = 'ImsStoresCards';
	
	function index() {
		$ims_stores = $this->ImsStoresCard->ImsStore->find('all');
		$this->set(compact('ims_stores'));
	}
	
	function index2($id = null) {
		$this->set('parent_id', $id);
	}

	function search() {
	}
	
	function list_data($id = null) {
		$start = (isset($_REQUEST['start'])) ? $_REQUEST['start'] : 0;
		$limit = (isset($_REQUEST['limit'])) ? $_REQUEST['limit'] : 5;
		$imsstore_id = (isset($_REQUEST['imsstore_id'])) ? $_REQUEST['imsstore_id'] : -1;
		if($id)
			$imsstore_id = ($id) ? $id : -1;
        $conditions = (isset($_REQUEST['conditions'])) ? $_REQUEST['conditions'] : '';

        eval("\$conditions = array( " . $conditions . " );");
		if ($imsstore_id != -1) {
            $conditions['ImsStoresCard.imsstore_id'] = $imsstore_id;
        }
		
		$this->set('imsStoresCards', $this->ImsStoresCard->find('all', array('conditions' => $conditions, 'limit' => $limit, 'offset' => $start)));
		$this->set('results', $this->ImsStoresCard->find('count', array('conditions' => $conditions)));
	}

	function view($id = null) {
		if (!$id) {
			$this->Session->setFlash(__('Invalid ims stores card', true));
			$this->redirect(array('action' => 'index'));
		}
		$this->ImsStoresCard->recursive = 2;
		$this->set('imsStoresCard', $this->ImsStoresCard->read(null, $id));
	}

	function add($id = null) {
		if (!empty($this->data)) {
			$this->ImsStoresCard->create();
			$this->autoRender = false;
			if ($this->ImsStoresCard->save($this->data)) {
				$this->Session->setFlash(__('The ims stores card has been saved', true), '');
				$this->render('/elements/success');
			} else {
				$this->Session->setFlash(__('The ims stores card could not be saved. Please, try again.', true), '');
				$this->render('/elements/failure');
			}
		}
		if($id)
			$this->set('parent_id', $id);
		$ims_stores = $this->ImsStoresCard->ImsStore->find('list');
		$ims_requisitions = $this->ImsStoresCard->ImsRequisition->find('list');
		$ims_cards = $this->ImsStoresCard->ImsCard->find('list');
		$this->set(compact('ims_stores', 'ims_requisitions', 'ims_cards'));
	}

	function edit($id = null, $parent_id = null) {
		if (!$id && empty($this->data)) {
			$this->Session->setFlash(__('Invalid ims stores card', true), '');
			$this->redirect(array('action' => 'index'));
		}
		if (!empty($this->data)) {
			$this->autoRender = false;
			if ($this->ImsStoresCard->save($this->data)) {
				$this->Session->setFlash(__('The ims stores card has been saved', true), '');
				$this->render('/elements/success');
			} else {
				$this->Session->setFlash(__('The ims stores card could not be saved. Please, try again.', true), '');
				$this->render('/elements/failure');
			}
		}
		$this->set('ims__stores__card', $this->ImsStoresCard->read(null, $id));
		
		if($parent_id) {
			$this->set('parent_id', $parent_id);
		}
			
		$ims_stores = $this->ImsStoresCard->ImsStore->find('list');
		$ims_requisitions = $this->ImsStoresCard->ImsRequisition->find('list');
		$ims_cards = $this->ImsStoresCard->ImsCard->find('list');
		$this->set(compact('ims_stores', 'ims_requisitions', 'ims_cards'));
	}

	function delete($id = null) {
		$this->autoRender = false;
		if (!$id) {
			$this->Session->setFlash(__('Invalid id for ims stores card', true), '');
			$this->render('/elements/failure');
		}
		if (stripos($id, '_') !== false) {
            $ids = explode('_', $id);
            try{
                foreach ($ids as $i) {
                    $this->ImsStoresCard->delete($i);
                }
				$this->Session->setFlash(__('Ims stores card deleted', true), '');
				$this->render('/elements/success');
            }
            catch (Exception $e){
				$this->Session->setFlash(__('Ims stores card was not deleted', true), '');
				$this->render('/elements/failure');
            }
        } else {
            if ($this->ImsStoresCard->delete($id)) {
				$this->Session->setFlash(__('Ims stores card deleted', true), '');
				$this->render('/elements/success');
			} else {
				$this->Session->setFlash(__('Ims stores card was not deleted', true), '');
				$this->render('/elements/failure');
			}
        }
	}
}
?>