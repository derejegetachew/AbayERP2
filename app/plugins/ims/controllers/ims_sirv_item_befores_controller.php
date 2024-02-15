<?php
class ImsSirvItemBeforesController extends AppController {

	var $name = 'ImsSirvItemBefores';
	
	function index() {
		$ims_sirv_befores = $this->ImsSirvItemBefore->ImsSirvBefore->find('all');
		$this->set(compact('ims_sirv_befores'));
	}
	
	function index2($id = null) {
		$this->set('parent_id', $id);
	}
	
	function index_6($id = null) {
		$this->set('sirv_id', $id);
	}
	
	function index_7($id = null) {
		$this->set('sirv_id', $id);
		
		$count = 0;
		$this->loadModel('ImsTransferBefore');	
		$value = $this->ImsTransferBefore->find('first',array('conditions' => array('ImsTransferBefore.name LIKE' => date("Ymd").'%'),'order'=>'ImsTransferBefore.name DESC'));
		if($value != null){
			$value = explode('/',$value['ImsTransferBefore']['name']);		
			$count = $value[1];
		}
		$this->set('count',$count);
		//my added code @melkamu//
		$this->loadModel('ImsSirvBefore');
		$this->ImsSirvBefore->recursive =1;
		$conditions = array('ImsSirvBefore.id' => $id);
		$ims_sirvs = $this->ImsSirvBefore->find('first',array('conditions' => $conditions));
        $from_branch=$ims_sirvs['Branch'];
		$this->set('from_branch', $from_branch);

		//end of code//
		$this->loadModel('Branch');	
		$this->Branch->recursive = -1;		
		$branches = $this->Branch->find('all');
		$this->set('branches', $branches);
		
		$this->loadModel('People');
	    $employees = $this->People->find('all',array('order' => 'People.first_name ASC')); 		
		
	    $this->set(compact('employees'));
	}
	
	function index_8($id = null) {
		$this->set('sirv_id', $id);
		
		$count = 0;
		$this->loadModel('ImsReturn');	
		$value = $this->ImsReturn->find('first',array('conditions' => array('ImsReturn.name LIKE' => date("Ymd").'%'),'order'=>'ImsReturn.name DESC'));
		if($value != null){
			$value = explode('/',$value['ImsReturn']['name']);		
			$count = $value[1];
		}
		$this->set('count',$count);
		
		$this->loadModel('Branch');	
		$this->Branch->recursive = -1;		
		$branches = $this->Branch->find('all');
		$this->set('branches', $branches);
		
		$this->loadModel('People');
	    $employees = $this->People->find('all',array('order' => 'People.first_name ASC')); 		
		
	    $this->set(compact('employees'));
	}
	
	function list_sirv_items_data1($sirv_id){	
		$conditions = array('ImsSirvItemBefore.ims_sirv_before_id' => $sirv_id);		
		$this->set('ims_Sirv_Items', $this->ImsSirvItemBefore->find('all', array('conditions' => $conditions)));
		$this->set('results', $this->ImsSirvItemBefore->find('count', array('conditions' => $conditions)));
	}
	
	function list_sirv_items_data2($sirv_before_id){		
		$conditions = array('ImsSirvItemBefore.ims_sirv_before_id' => $sirv_before_id);
		$sirvItems = $this->ImsSirvItemBefore->find('all', array('conditions' => $conditions));
		$items = array();		
		$this->loadModel('ImsTransferItemBefore');
		$this->ImsTransferItemBefore->recursive = -1;
		foreach ($sirvItems as $sirvItem){			
			if($sirvItem['ImsItem']['fixed_asset'] == 1){			
				$conditionsTransfer = array('ImsTransferItemBefore.ims_sirv_item_before_id' => $sirvItem['ImsSirvItemBefore']['id']);
				$transferItems = $this->ImsTransferItemBefore->find('all', array('conditions' => $conditionsTransfer));
				if(empty($transferItems)){
					$items[] = $sirvItem;
				}				
			}
		}
		$this->set('ims_Sirv_Items', $items);
		$this->set('results', $this->ImsSirvItemBefore->find('count', array('conditions' => $conditions)));
	}
	
	function list_sirv_items_data3($sirv_before_id){		
		$conditions = array('ImsSirvItemBefore.ims_sirv_before_id' => $sirv_before_id);
		$sirvItems = $this->ImsSirvItemBefore->find('all', array('conditions' => $conditions));
		$items = array();
		$count = 0;
		$this->loadModel('ImsTransferItemBefore');
		$this->loadModel('ImsReturnItem');
		$this->ImsTransferItemBefore->recursive = -1;
		foreach ($sirvItems as $sirvItem){			
			if($sirvItem['ImsItem']['fixed_asset'] == 1){	
			
					$conditionsReturn = array('ImsReturnItem.ims_sirv_item_before_id' => $sirvItem['ImsSirvItemBefore']['id']);
					$returnItems = $this->ImsReturnItem->find('all', array('conditions' => $conditionsReturn));
					
					if(empty($returnItems)){					
						$conditionsTransfer = array('ImsTransferItemBefore.ims_sirv_item_before_id' => $sirvItem['ImsSirvItemBefore']['id']);
						$transferItems = $this->ImsTransferItemBefore->find('all', array('conditions' => $conditionsTransfer));
						
						if(empty($transferItems)){
							$items[$count] = $sirvItem;
							$count++;
						}
						else if(!empty($transferItems)){
							$total = 0;
							foreach($transferItems as $transferItem){
								$total += $transferItem['ImsTransferItemBefore']['quantity'];							
							}
							if($total < $sirvItem['ImsSirvItemBefore']['quantity']){
								$left = $sirvItem['ImsSirvItemBefore']['quantity'] - $total;
								$items[$count] = $sirvItem;
								$items[$count]['ImsSirvItemBefore']['quantity'] = $left;
								$count++;
							}
						}
					}
			}
		}
		$this->set('ims_Sirv_Items', $items);
		$this->set('results', $this->ImsSirvItemBefore->find('count', array('conditions' => $conditions)));
	}

	function search() {
	}
	
	function list_data($id = null) {
		$start = (isset($_REQUEST['start'])) ? $_REQUEST['start'] : 0;
		$limit = (isset($_REQUEST['limit'])) ? $_REQUEST['limit'] : 5;
		$imssirvbefore_id = (isset($_REQUEST['imssirvbefore_id'])) ? $_REQUEST['imssirvbefore_id'] : -1;
		if($id)
			$imssirvbefore_id = ($id) ? $id : -1;
        $conditions = (isset($_REQUEST['conditions'])) ? $_REQUEST['conditions'] : '';

        eval("\$conditions = array( " . $conditions . " );");
		if ($imssirvbefore_id != -1) {
            $conditions['ImsSirvItemBefore.ims_sirv_before_id'] = $imssirvbefore_id;
        }
		
		$this->set('ims_sirv_item_befores', $this->ImsSirvItemBefore->find('all', array('conditions' => $conditions, 'limit' => $limit, 'offset' => $start)));
		$this->set('results', $this->ImsSirvItemBefore->find('count', array('conditions' => $conditions)));
	}

	function view($id = null) {
		if (!$id) {
			$this->Session->setFlash(__('Invalid ims sirv item before', true));
			$this->redirect(array('action' => 'index'));
		}
		$this->ImsSirvItemBefore->recursive = 2;
		$this->set('imsSirvItemBefore', $this->ImsSirvItemBefore->read(null, $id));
	}

	function add($id = null) {
		if (!empty($this->data)) {
			$this->ImsSirvItemBefore->create();
			$this->autoRender = false;
			if ($this->ImsSirvItemBefore->save($this->data)) {
				$this->Session->setFlash(__('The ims sirv item before has been saved', true), '');
				$this->render('/elements/success');
			} else {
				$this->Session->setFlash(__('The ims sirv item before could not be saved. Please, try again.', true), '');
				$this->render('/elements/failure');
			}
		}
		if($id)
			$this->set('parent_id', $id);
		$ims_sirv_befores = $this->ImsSirvItemBefore->ImsSirvBefore->find('list');
		$this->ImsSirvItemBefore->ImsItem->recursive = -1;
		$ims_items = $this->ImsSirvItemBefore->ImsItem->find('all');
		$this->set(compact('ims_sirv_befores', 'ims_items'));
	}

	function edit($id = null, $parent_id = null) {
		if (!$id && empty($this->data)) {
			$this->Session->setFlash(__('Invalid ims sirv item before', true), '');
			$this->redirect(array('action' => 'index'));
		}
		if (!empty($this->data)) {
			$this->autoRender = false;
			if ($this->ImsSirvItemBefore->save($this->data)) {
				$this->Session->setFlash(__('The ims sirv item before has been saved', true), '');
				$this->render('/elements/success');
			} else {
				$this->Session->setFlash(__('The ims sirv item before could not be saved. Please, try again.', true), '');
				$this->render('/elements/failure');
			}
		}
		$this->set('ims_sirv_item_before', $this->ImsSirvItemBefore->read(null, $id));
		pr($this->ImsSirvItemBefore->read(null, $id));
		if($parent_id) {
			$this->set('parent_id', $parent_id);
		}
			
		$ims_sirv_befores = $this->ImsSirvItemBefore->ImsSirvBefore->find('list');
		$this->ImsSirvItemBefore->ImsItem->recursive = -1;
		$ims_items = $this->ImsSirvItemBefore->ImsItem->find('all');
		$this->set(compact('ims_sirv_befores', 'ims_items'));
	}

	function delete($id = null) {
		$this->autoRender = false;
		if (!$id) {
			$this->Session->setFlash(__('Invalid id for ims sirv item before', true), '');
			$this->render('/elements/failure');
		}
		if (stripos($id, '_') !== false) {
            $ids = explode('_', $id);
            try{
                foreach ($ids as $i) {
                    $this->ImsSirvItemBefore->delete($i);
                }
				$this->Session->setFlash(__('Ims sirv item before deleted', true), '');
				$this->render('/elements/success');
            }
            catch (Exception $e){
				$this->Session->setFlash(__('Ims sirv item before was not deleted', true), '');
				$this->render('/elements/failure');
            }
        } else {
            if ($this->ImsSirvItemBefore->delete($id)) {
				$this->Session->setFlash(__('Ims sirv item before deleted', true), '');
				$this->render('/elements/success');
			} else {
				$this->Session->setFlash(__('Ims sirv item before was not deleted', true), '');
				$this->render('/elements/failure');
			}
        }
	}
}
?>