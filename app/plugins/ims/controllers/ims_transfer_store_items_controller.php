<?php
class ImsTransferStoreItemsController extends AppController {

	var $name = 'ImsTransferStoreItems';
	
	function index() {
	}
	

	function search() {
	}
	
	function list_data($id = null) {
		$start = (isset($_REQUEST['start'])) ? $_REQUEST['start'] : 0;
		$limit = (isset($_REQUEST['limit'])) ? $_REQUEST['limit'] : 5;
        $conditions = (isset($_REQUEST['conditions'])) ? $_REQUEST['conditions'] : '';

        eval("\$conditions = array( " . $conditions . " );");		
		
		$user = $this->Session->read();
		if($user['Auth']['User']['username'] != 'admin'){
			$this->loadModel('ImsStore');
			$store = $this->ImsStore->find('first',array('conditions'=>array('or' => array(
																						  'ImsStore.store_keeper_one' => $user['Auth']['User']['id'],
																						  'ImsStore.store_keeper_two' => $user['Auth']['User']['id'],
																						  'ImsStore.store_keeper_three' => $user['Auth']['User']['id'],
																						  'ImsStore.store_keeper_four' => $user['Auth']['User']['id'],
                                              'ImsStore.store_keeper_five' => $user['Auth']['User']['id'],
																						  'ImsStore.store_keeper_six' => $user['Auth']['User']['id']
																						)
																					)));
			
			if($conditions == null){
				$cond[0]['ImsTransferStoreItem.from_store_keeper'] = $user['Auth']['User']['id'];
				
				$cond[1]['ImsTransferStoreItem.status'] = 'posted';
				$cond[1]['ImsTransferStoreItem.to_store'] = $store['ImsStore']['id'];
				
				$cond[2]['ImsTransferStoreItem.status'] = 'accepted';
				$cond[2]['ImsTransferStoreItem.to_store_keeper'] = $user['Auth']['User']['id'];
				
				$cond[3]['ImsTransferStoreItem.status'] = 'accepted';
				$cond[3]['ImsTransferStoreItem.from_store'] = $store['ImsStore']['id'];
				
				$conditions = array("OR" => $cond);
			}
			else if(!empty($conditions)){
				
			}
		}
		
		$this->ImsTransferStoreItem->recursive = 0;
		$this->set('ims_transfer_store_items', $this->ImsTransferStoreItem->find('all', array('conditions' => $conditions, 'limit' => $limit, 'offset' => $start)));
		$this->set('results', $this->ImsTransferStoreItem->find('count', array('conditions' => $conditions)));
	}

	function view($id = null) {
		if (!$id) {
			$this->Session->setFlash(__('Invalid ims transfer store item', true));
			$this->redirect(array('action' => 'index'));
		}
		$this->ImsTransferStoreItem->recursive = 2;
		$this->set('imsTransferStoreItem', $this->ImsTransferStoreItem->read(null, $id));
	}

	function add($id = null) {
		if (!empty($this->data)) {
			
			// Strip out carriage returns
            $content = ereg_replace("\r",'',$this->data['ImsTransferStoreItem']['remark']);
            // Handle paragraphs
            $content = ereg_replace("\n\n",'<br /><br />',$content);
            // Handle line breaks
            $content = ereg_replace("\n",'<br />',$content);
            // Handle apostrophes
            $content = ereg_replace("'",'&#8217;',$content);
			$this->data['ImsTransferStoreItem']['remark'] = $content;
			
			$this->data['ImsTransferStoreItem']['status'] = "created";
		
			$this->ImsTransferStoreItem->create();
			$this->autoRender = false;
			if ($this->ImsTransferStoreItem->save($this->data)) {
				$this->Session->setFlash(__('transfer store item has been saved', true) . '::' . $this->ImsTransferStoreItem->id, '');
				$this->render('/elements/success_sti');
			} else {
				$this->Session->setFlash(__('transfer store item could not be saved. Please, try again.', true), '');
				$this->render('/elements/failure');
			}
		}
		
		$count = 0;
		$value = $this->ImsTransferStoreItem->find('first',array('conditions' => array('ImsTransferStoreItem.name LIKE' => date("Ymd").'%'),'order'=>'ImsTransferStoreItem.name DESC'));
		if($value != null){
			$value = explode('/',$value['ImsTransferStoreItem']['name']);		
			$count = $value[1];
		}		       
        $this->set('count',$count);
		
		$this->loadModel('ImsStore');
		$this->ImsStore->recursive = 2;
		$stores = $this->ImsStore->find('all');
		$this->set('stores',$stores);
		
		$user = $this->Session->read();
		$userid = $user['Auth']['User']['id'];
		foreach($stores as $store){	
   
			if($store['ImsStore']['store_keeper_one'] == $userid){
				$this->set('store',$store);
				$this->set('storeKeeper',$store['StoreKeeperOne']);
				break;
			}
			else if($store['ImsStore']['store_keeper_two'] == $userid){
				$this->set('store',$store);
				$this->set('storeKeeper',$store['StoreKeeperTwo']);
				break;
			}
			else if($store['ImsStore']['store_keeper_three'] == $userid){
				$this->set('store',$store);
				$this->set('storeKeeper',$store['StoreKeeperThree']);
				break;
			}
			else if($store['ImsStore']['store_keeper_four'] == $userid){
				$this->set('store',$store);
				$this->set('storeKeeper',$store['StoreKeeperFour']);
				break;
			}
      else if($store['ImsStore']['store_keeper_five'] == $userid){
				$this->set('store',$store);
				$this->set('storeKeeper',$store['StoreKeeperFive']);
				break;
			}
			else if($store['ImsStore']['store_keeper_six'] == $userid){
				$this->set('store',$store);
				$this->set('storeKeeper',$store['StoreKeeperSix']);
				break;
			}
		}
	}

	function edit($id = null, $parent_id = null) {
		if (!$id && empty($this->data)) {
			$this->Session->setFlash(__('Invalid ims transfer store item', true), '');
			$this->redirect(array('action' => 'index'));
		}
		if (!empty($this->data)) {
			
			// Strip out carriage returns
            $content = ereg_replace("\r",'',$this->data['ImsTransferStoreItem']['remark']);
            // Handle paragraphs
            $content = ereg_replace("\n\n",'<br /><br />',$content);
            // Handle line breaks
            $content = ereg_replace("\n",'<br />',$content);
            // Handle apostrophes
            $content = ereg_replace("'",'&#8217;',$content);
			$this->data['ImsTransferStoreItem']['remark'] = $content;
			
			$this->autoRender = false;
			if ($this->ImsTransferStoreItem->save($this->data)) {
				$this->Session->setFlash(__('The ims transfer store item has been saved', true), '');
				$this->render('/elements/success');
			} else {
				$this->Session->setFlash(__('The ims transfer store item could not be saved. Please, try again.', true), '');
				$this->render('/elements/failure');
			}
		}
		$this->ImsTransferStoreItem->recursive = 2;
		$this->set('ims_transfer_store_item', $this->ImsTransferStoreItem->read(null, $id));	
		
		$this->loadModel('ImsStore');
		$this->ImsStore->recursive = 2;
		$stores = $this->ImsStore->find('all');
		$this->set('stores',$stores);		
	}

	function delete($id = null) {
		$this->autoRender = false;
		if (!$id) {
			$this->Session->setFlash(__('Invalid id for transfer store item', true), '');
			$this->render('/elements/failure');
		}
		if (stripos($id, '_') !== false) {
            $ids = explode('_', $id);
            try{
				$msg = '';
                foreach ($ids as $i) {
					$conditions['ImsTransferStoreItemDetail.ims_transfer_store_item_id'] = $i;
					if($this->ImsTransferStoreItem->ImsTransferStoreItemDetail->find('count', array('conditions' => $conditions)) == 0){ 
						$this->ImsTransferStoreItem->delete($i);
					}
					else {
						$sti = $this->ImsTransferStoreItem->read(null,$i);
						$msg .= $sti['ImsTransferStoreItem']['name'] . ',';
					}
                }
				if($msg == '') {
					$this->Session->setFlash(__('Ims transfer store item deleted', true), '');
					$this->render('/elements/success4');
				}else
					$this->Session->setFlash('since they have transfer store Item(s),Following Store Transfer were not deleted: ' . $msg, '');
					$this->render('/elements/failure3');
            }
            catch (Exception $e){
				$this->Session->setFlash(__('Ims transfer store item was not deleted', true), '');
				$this->render('/elements/failure');
            }
        } else {
			$conditions['ImsTransferStoreItemDetail.ims_transfer_store_item_id'] = $id;
			if($this->ImsTransferStoreItem->ImsTransferStoreItemDetail->find('count', array('conditions' => $conditions)) == 0){ 
				if ($this->ImsTransferStoreItem->delete($id)) {
					$this->Session->setFlash(__('Ims transfer store item deleted', true), '');
					$this->render('/elements/success4');
				} else {
					$this->Session->setFlash(__('Ims transfer store item was not deleted', true), '');
					$this->render('/elements/failure');
				}
			}
			else{
				$this->Session->setFlash(__('Store Transfer Item was not deleted because it has Item(s)', true), '');
				$this->render('/elements/failure3');
			}
        }
	}
	
	function post($id = null) {
        $this->autoRender = false;
        if (!$id) {
            $this->Session->setFlash(__('Invalid id for transfer store item', true), '');
            $this->render('/elements/failure');
        }
        $transferstoreitem = array('ImsTransferStoreItem' => array('id' => $id, 'status' => 'posted'));
        if ($this->ImsTransferStoreItem->save($transferstoreitem)) {
            $this->Session->setFlash(__('transfer store item posted for approval', true), '');
            $this->render('/elements/success');
        } else {
            $this->Session->setFlash(__('transfer store item was not posted for approval', true), '');
            $this->render('/elements/failure');
        }
    }
	
	function accept($id = null) {
        $this->autoRender = false;
        if (!$id) {
            $this->Session->setFlash(__('Invalid id for transfer store item', true), '');
            $this->render('/elements/failure');
        }
		$transferitem = $this->ImsTransferStoreItem->read(null, $id);
		$this->loadModel('ImsStoresItem');
		$this->loadModel('ImsTransferStoreItemDetail');
		$quantity = 0;
		$check = false;
		foreach($transferitem['ImsTransferStoreItemDetail'] as $itemdetail){
			////////////////////////           take from the giving store     //////////////////////////////////////////////////
			$conditions_store = array('ImsStoresItem.ims_item_id' => $itemdetail['ims_item_id'],'ImsStoresItem.ims_store_id' => $transferitem['ImsTransferStoreItem']['from_store']);
			$storesitem = $this->ImsStoresItem->find('first', array('conditions' =>$conditions_store));
			if($storesitem != null){
				$check = true;
			}
			if($storesitem['ImsStoresItem']['balance'] != null and $storesitem['ImsStoresItem']['balance'] > 0){
				if($itemdetail['quantity'] > $storesitem['ImsStoresItem']['balance']){
					//update store item balance							
					$this->ImsStoresItem->id = $storesitem['ImsStoresItem']['id'];
					$this->ImsStoresItem->saveField('balance', 0);					
					$quantity = $storesitem['ImsStoresItem']['balance'];
				}
				else if($itemdetail['quantity'] <= $storesitem['ImsStoresItem']['balance']){
					//update store item balance							
					$this->ImsStoresItem->id = $storesitem['ImsStoresItem']['id'];
					$balance = $storesitem['ImsStoresItem']['balance'] - $itemdetail['quantity'];
					$this->ImsStoresItem->saveField('balance', $balance);
					$quantity = $itemdetail['quantity'];
				}			
				
			}
			
			////////////////////////           add to the receiving store     //////////////////////////////////////////////////
			if($quantity != 0){
				$this->ImsTransferStoreItemDetail->id = $itemdetail['id'];				
				$this->ImsTransferStoreItemDetail->saveField('issued', $quantity);
				
				$conditions_store1 = array('ImsStoresItem.ims_item_id' => $itemdetail['ims_item_id'],'ImsStoresItem.ims_store_id' => $transferitem['ImsTransferStoreItem']['to_store']);
				$storesitem1 = $this->ImsStoresItem->find('first', array('conditions' =>$conditions_store1));
				if($storesitem1 != null){
					//update store item balance							
					$this->ImsStoresItem->id = $storesitem1['ImsStoresItem']['id'];
					$this->ImsStoresItem->saveField('balance', $storesitem1['ImsStoresItem']['balance'] + $quantity);
					$quantity =0;
				}
				else if($storesitem1 == null){
					//create store item 
					$this->ImsStoresItem->create();
					$this->data['ImsStoresItem']['ims_store_id'] = $transferitem['ImsTransferStoreItem']['to_store'];
					$this->data['ImsStoresItem']['ims_item_id'] = $itemdetail['ims_item_id'];
					$this->data['ImsStoresItem']['balance'] = $quantity;
					$this->ImsStoresItem->save($this->data);
					$quantity=0;
				}
			}
		}
		
		if($check == true){
			$user = $this->Session->read();		
			$transferstoreitem = array('ImsTransferStoreItem' => array('id' => $id, 'to_store_keeper' => $user['Auth']['User']['id'],'status' => 'accepted'));
			if ($this->ImsTransferStoreItem->save($transferstoreitem)) {
				$this->Session->setFlash(__('transfer store item successfully accepted', true), '');
				$this->render('/elements/success2');
			} else {
				$this->Session->setFlash(__('transfer store item was not successfully accepted', true), '');
				$this->render('/elements/failure2');
			}
		}
		else {
				$this->Session->setFlash(__('transfer store item was not successfully accepted', true), '');
				$this->render('/elements/failure2');
			}
    }
	
	function print_transfer($id = null){
        $this->layout = 'print_layout';
        
        if (!$id) {
            $this->autoRender = false;
            $this->Session->setFlash(__('Invalid id for transfer', true), '');
            $this->render('/elements/failure');
        }
        $this->ImsTransferStoreItem->recursive = 2;
        $this->set('transfer', $this->ImsTransferStoreItem->read(null, $id));
    }
	
	function getUser(){
		$userid = $this->params['userid'];	
		$this->loadModel('User');
		$conditions = array('User.id' => $userid);
		$this->User->recursive = 0;
		$user = $this->User->find('first',array('conditions' => $conditions));	
		return $user;
	}
}
?>