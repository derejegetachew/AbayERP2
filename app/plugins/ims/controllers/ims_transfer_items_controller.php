<?php
class ImsTransferItemsController extends AppController {

	var $name = 'ImsTransferItems';
	
	function index() {
		$ims_transfers = $this->ImsTransferItem->ImsTransfer->find('all');
		$this->set(compact('ims_transfers'));
	}
	
	function index2($id = null) {
		$this->set('parent_id', $id);
	}
	
	function index_3($id = null) {
		$this->set('transfer_id', $id);
		$count = 0;
		$this->loadModel('ImsTransfer');	
		////   My added code  start ////
		$conditions = array('ImsTransferItem.ims_transfer_id' => $id);
		$transferItems = $this->ImsTransferItem->find('first', array('conditions' => $conditions));
		$user=$transferItems['ImsTransfer'];
		///// end of my code//////////
		$value = $this->ImsTransfer->find('first',array('conditions' => array('ImsTransfer.name LIKE' => date("Ymd").'%'),'order'=>'ImsTransfer.name DESC'));
		if($value != null){
			$value = explode('/',$value['ImsTransfer']['name']);		
			$count = $value[1];
		}
		$this->set('count',$count);
		$this->loadModel('Branch');	
		$this->Branch->recursive = -1;		
		$branches = $this->Branch->find('all');
		$this->set('branches',$branches);
		$this->loadModel('User');
		$this->loadModel('People');
		/// start other code  @melkamu //
		$User_conditions = array('User.id' => $user['to_user']);
		$user_data= $this->User->find('first',array('conditions' => $User_conditions)); 
		$people_conditions = array('People.id' => $user_data['User']['person_id']);
		$from_user= $this->People->find('first',array('conditions' => $people_conditions)); 
		$this->set('from_user',$from_user['People']);
		$User_branch_conditions = array('Branch.id' => $user['from_branch']);
		$from_branch= $this->Branch->find('first', array('conditions' => $User_branch_conditions));
		$this->set('from_branch',$from_branch['Branch']);
       // end of code //
		$employees = $this->People->find('all',array('order' => 'People.first_name ASC')); 		
	    $this->set(compact('employees'));
	}

	function search() {
	}
	
	function list_data($id = null) {
		$start = (isset($_REQUEST['start'])) ? $_REQUEST['start'] : 0;
		$limit = (isset($_REQUEST['limit'])) ? $_REQUEST['limit'] : 5;
		$imstransfer_id = (isset($_REQUEST['ims_transfer_id'])) ? $_REQUEST['ims_transfer_id'] : -1;
		if($id)
			$imstransfer_id = ($id) ? $id : -1;
        $conditions = (isset($_REQUEST['conditions'])) ? $_REQUEST['conditions'] : '';

        eval("\$conditions = array( " . $conditions . " );");
		if ($imstransfer_id != -1) {
            $conditions['ImsTransferItem.ims_transfer_id'] = $imstransfer_id;
        }
		
		$this->set('ims_transfer_items', $this->ImsTransferItem->find('all', array('conditions' => $conditions, 'limit' => $limit, 'offset' => $start)));
		$this->set('results', $this->ImsTransferItem->find('count', array('conditions' => $conditions)));
	}

	function view($id = null) {
		if (!$id) {
			$this->Session->setFlash(__('Invalid ims transfer item', true));
			$this->redirect(array('action' => 'index'));
		}
		$this->ImsTransferItem->recursive = 2;
		$this->set('imsTransferItem', $this->ImsTransferItem->read(null, $id));
	}

	function add($id = null) {
		if (!empty($this->data)) {
			$this->ImsTransferItem->create();
			$this->autoRender = false;
			if ($this->ImsTransferItem->save($this->data)) {
				$this->Session->setFlash(__('The ims transfer item has been saved', true), '');
				$this->render('/elements/success');
			} else {
				$this->Session->setFlash(__('The ims transfer item could not be saved. Please, try again.', true), '');
				$this->render('/elements/failure');
			}
		}
		if($id)
			$this->set('parent_id', $id);
		$ims_transfers = $this->ImsTransferItem->ImsTransfer->find('list');
		$ims_items = $this->ImsTransferItem->ImsItem->find('list');
		$this->set(compact('ims_transfers', 'ims_items'));
	}

	function edit($id = null, $parent_id = null) {
		if (!$id && empty($this->data)) {
			$this->Session->setFlash(__('Invalid ims transfer item', true), '');
			$this->redirect(array('action' => 'index'));
		}
		if (!empty($this->data)) {
			$this->autoRender = false;
			if ($this->ImsTransferItem->save($this->data)) {
				$this->Session->setFlash(__('The ims transfer item has been saved', true), '');
				$this->render('/elements/success');
			} else {
				$this->Session->setFlash(__('The ims transfer item could not be saved. Please, try again.', true), '');
				$this->render('/elements/failure');
			}
		}
		$this->set('ims__transfer__item', $this->ImsTransferItem->read(null, $id));
		
		if($parent_id) {
			$this->set('parent_id', $parent_id);
		}
			
		$ims_transfers = $this->ImsTransferItem->ImsTransfer->find('list');
		$ims_items = $this->ImsTransferItem->ImsItem->find('list');
		$this->set(compact('ims_transfers', 'ims_items'));
	}

	function delete($id = null) {
		$this->autoRender = false;
		if (!$id) {
			$this->Session->setFlash(__('Invalid id for ims transfer item', true), '');
			$this->render('/elements/failure');
		}
		if (stripos($id, '_') !== false) {
            $ids = explode('_', $id);
            try{
                foreach ($ids as $i) {
                    $this->ImsTransferItem->delete($i);
                }
				$this->Session->setFlash(__('Ims transfer item deleted', true), '');
				$this->render('/elements/success');
            }
            catch (Exception $e){
				$this->Session->setFlash(__('Ims transfer item was not deleted', true), '');
				$this->render('/elements/failure');
            }
        } else {
            if ($this->ImsTransferItem->delete($id)) {
				$this->Session->setFlash(__('Ims transfer item deleted', true), '');
				$this->render('/elements/success');
			} else {
				$this->Session->setFlash(__('Ims transfer item was not deleted', true), '');
				$this->render('/elements/failure');
			}
        }
	}
	
	function list_transfer_items_data2($transfer_id){		
		$conditions = array('ImsTransferItem.ims_transfer_id' => $transfer_id);
		$transferItems = $this->ImsTransferItem->find('all', array('conditions' => $conditions));
		$user=$transferItems[0]['ImsTransfer'];
		
		$items = array();
		$count = 0;
		$total = 0;
		$this->ImsTransferItem->recursive = -1;
		foreach ($transferItems as $transferItem){	
			if($transferItem['ImsItem']['fixed_asset'] == 1){
				$conditionsTransfer = array('ImsTransferItem.transfer_id' => $transfer_id, 'ImsTransferItem.ims_item_id' => $transferItem['ImsItem']['id']);
				$transferItems2 = $this->ImsTransferItem->find('all', array('conditions' => $conditionsTransfer));
				foreach($transferItems2 as $transferItem2){
					$total = $total + $transferItem2['ImsTransferItem']['quantity'];
				}
				if($total < $transferItem['ImsTransferItem']['quantity']){
						$remaining = $transferItem['ImsTransferItem']['quantity'] - $total;
						$transferItem['ImsTransferItem']['quantity'] = $remaining;
						$items[$count] = $transferItem;
						$count++;
					
				}
			}
		}

		$this->set('ims_Transfer_Items', $items);
		$this->set('ims_Transfer_user', $user);
		$this->set('results', $this->ImsTransferItem->find('count', array('conditions' => $conditions)));
	}
}
?>