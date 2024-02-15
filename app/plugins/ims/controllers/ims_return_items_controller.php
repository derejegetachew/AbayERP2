<?php
class ImsReturnItemsController extends AppController {

	var $name = 'ImsReturnItems';
	
	function index() {
		$ims_returns = $this->ImsReturnItem->ImsReturn->find('all');
		$this->set(compact('ims_returns'));
	}
	
	function index2($id = null) {
		$this->set('parent_id', $id);
	}

	function search() {
	}
	
	function list_data($id = null) {
		$start = (isset($_REQUEST['start'])) ? $_REQUEST['start'] : 0;
		$limit = (isset($_REQUEST['limit'])) ? $_REQUEST['limit'] : 5;
		$imsreturn_id = (isset($_REQUEST['imsreturn_id'])) ? $_REQUEST['imsreturn_id'] : -1;
		if($id)
			$imsreturn_id = ($id) ? $id : -1;
        $conditions = (isset($_REQUEST['conditions'])) ? $_REQUEST['conditions'] : '';

        eval("\$conditions = array( " . $conditions . " );");
		if ($imsreturn_id != -1) {
            $conditions['ImsReturnItem.ims_return_id'] = $imsreturn_id;
        }
		
		$this->set('ims_return_items', $this->ImsReturnItem->find('all', array('conditions' => $conditions, 'limit' => $limit, 'offset' => $start)));
		$this->set('results', $this->ImsReturnItem->find('count', array('conditions' => $conditions)));
	}

	function view($id = null) {
		if (!$id) {
			$this->Session->setFlash(__('Invalid ims return item', true));
			$this->redirect(array('action' => 'index'));
		}
		$this->ImsReturnItem->recursive = 2;
		$this->set('imsReturnItem', $this->ImsReturnItem->read(null, $id));
	}

	function add($id = null) {
		if (!empty($this->data)) {
			$this->ImsReturnItem->create();
			$this->autoRender = false;
			if ($this->ImsReturnItem->save($this->data)) {
				$this->Session->setFlash(__('The ims return item has been saved', true), '');
				$this->render('/elements/success');
			} else {
				$this->Session->setFlash(__('The ims return item could not be saved. Please, try again.', true), '');
				$this->render('/elements/failure');
			}
		}
		if($id)
			$this->set('parent_id', $id);
		$ims_returns = $this->ImsReturnItem->ImsReturn->find('list');
		$ims_sirv_items = $this->ImsReturnItem->ImsSirvItem->find('list');
		$this->set(compact('ims_returns', 'ims_sirv_items'));
	}

	function edit($id = null, $parent_id = null) {
		if (!$id && empty($this->data)) {
			$this->Session->setFlash(__('Invalid ims return item', true), '');
			$this->redirect(array('action' => 'index'));
		}
		if (!empty($this->data)) {
			$this->autoRender = false;
			if ($this->ImsReturnItem->save($this->data)) {
				$this->Session->setFlash(__('The ims return item has been saved', true), '');
				$this->render('/elements/success');
			} else {
				$this->Session->setFlash(__('The ims return item could not be saved. Please, try again.', true), '');
				$this->render('/elements/failure');
			}
		}
		$this->set('ims__return__item', $this->ImsReturnItem->read(null, $id));
		
		if($parent_id) {
			$this->set('parent_id', $parent_id);
		}
			
		$ims_returns = $this->ImsReturnItem->ImsReturn->find('list');
		$ims_sirv_items = $this->ImsReturnItem->ImsSirvItem->find('list');
		$this->set(compact('ims_returns', 'ims_sirv_items'));
	}

	function delete($id = null) {
		$this->autoRender = false;
		if (!$id) {
			$this->Session->setFlash(__('Invalid id for ims return item', true), '');
			$this->render('/elements/failure');
		}
		if (stripos($id, '_') !== false) {
            $ids = explode('_', $id);
            try{
                foreach ($ids as $i) {
                    $this->ImsReturnItem->delete($i);
                }
				$this->Session->setFlash(__('Ims return item deleted', true), '');
				$this->render('/elements/success');
            }
            catch (Exception $e){
				$this->Session->setFlash(__('Ims return item was not deleted', true), '');
				$this->render('/elements/failure');
            }
        } else {
            if ($this->ImsReturnItem->delete($id)) {
				$this->Session->setFlash(__('Ims return item deleted', true), '');
				$this->render('/elements/success');
			} else {
				$this->Session->setFlash(__('Ims return item was not deleted', true), '');
				$this->render('/elements/failure');
			}
        }
	}
	
	function getSIRV(){
		$sirvitemid = $this->params['sirvitemid'];	
		$this->loadModel('ImsSirvItem');
		$conditions = array('ImsSirvItem.id' => $sirvitemid);
		$this->ImsSirvItem->recursive = 0;
		$sirv = $this->ImsSirvItem->find('first',array('conditions' => $conditions));
		return $sirv;
	}
}
?>