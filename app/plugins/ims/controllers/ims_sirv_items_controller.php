<?php
class ImsSirvItemsController extends ImsAppController {

	var $name = 'ImsSirvItems';
	
	function index() {
                        
    //$this->ImsSirvItem->ImsSirv->recursive=1;
		$ims_sirvs = $this->ImsSirvItem->ImsSirv->find('all');
		$this->set(compact('ims_sirvs'));
	}
	
	function index2($id = null) {
		$this->set('parent_id', $id);
	}
	
	function index_2($id = null) {
		$this->set('requisition_id', $id);
	}
	
	function index_3($id = null) {
		$this->set('requisition_id', $id);
		
		$this->loadModel('ImsRequisitionItem');	
		$this->ImsRequisitionItem->ImsItem->recursive = 0;
		$array[] = null;
		$array2[] = null;
		$items = $this->ImsRequisitionItem->ImsItem->find('all');
		foreach($items as $item){			
			$array[] = $item['ImsItem'];			
		}
		
		$this->ImsRequisitionItem->recursive = 0;
		$conditions = array('ImsRequisitionItem.ims_requisition_id' => $id);
		$requisitionitems =$this->ImsRequisitionItem->find('all',array('conditions' => $conditions));
		if(!empty($requisitionitems)){
			foreach($requisitionitems as $requisitionitem){
				$array2[] = $requisitionitem['ImsItem'];				
			}
		}
		$results = array_diff(array_map('serialize',$array),array_map('serialize',$array2));
		$results = array_map('unserialize',$results);
		
		$this->set('results', $results);
		
		$this->loadModel('ImsStore');	
   $this->ImsStore->recursive=-1;
		$stores = $this->ImsStore->find('all');
		$this->set('stores', $stores);
	}
	
	function index_4($id = null) {
		$this->set('requisition_id', $id);
	}
	
	function index_5($id = null) {
		$this->set('sirv_id', $id);
	}
	
	function index_6($id = null) {
		$this->set('sirv_id', $id);
	}
	
	function index_7($id = null) {
		$this->set('sirv_id', $id);
		$count = 0;
		$this->loadModel('ImsTransfer');	
		$value = $this->ImsTransfer->find('first',array('conditions' => array('ImsTransfer.name LIKE' => date("Ymd").'%'),'order'=>'ImsTransfer.name DESC'));
		if($value != null){
			$value = explode('/',$value['ImsTransfer']['name']);		
			$count = $value[1];
		}
		$this->set('count',$count);
		$this->loadModel('Branch');	
		$this->Branch->recursive = -1;	

         // my code start here  @melkamu //;
		$this->loadModel('User');
		$this->loadModel('People');
	    $this->loadModel('ImsSirv');
		$this->ImsSirv->recursive =1;	
		 $conditions = array('ImsSirv.id' => $id);
		 $ims_sirvs = $this->ImsSirv->find('first',array('conditions' => $conditions));
		 $requested_by= $ims_sirvs['ImsRequisition']['requested_by'];
		 $requested_branch= $ims_sirvs['ImsRequisition']['branch_id'];
		
		 $User_conditions = array('User.id' => $requested_by);
		 $user_data= $this->User->find('first',array('conditions' => $User_conditions)); 
		$people_conditions = array('People.id' => $user_data['User']['person_id']);
		$from_user= $this->People->find('first',array('conditions' => $people_conditions)); 
		$this->set('from_user',$from_user['People']);
		
		$User_branch_conditions = array('Branch.id' => $requested_branch);
		$from_branch= $this->Branch->find('first', array('conditions' => $User_branch_conditions));
		$this->set('from_branch',$from_branch['Branch']);
		
		 // End //

		
		
			
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

	function search() {
	}
	
	function list_data($id = null) {
		$start = (isset($_REQUEST['start'])) ? $_REQUEST['start'] : 0;
		$limit = (isset($_REQUEST['limit'])) ? $_REQUEST['limit'] : 5;
		$imssirv_id = (isset($_REQUEST['imssirv_id'])) ? $_REQUEST['imssirv_id'] : -1;
		if($id)
			$imssirv_id = ($id) ? $id : -1;
        $conditions = (isset($_REQUEST['conditions'])) ? $_REQUEST['conditions'] : '';

        eval("\$conditions = array( " . $conditions . " );");
		if ($imssirv_id != -1) {
            $conditions['ImsSirvItem.ims_sirv_id'] = $imssirv_id;
        }
		
		$this->set('ims_sirv_items', $this->ImsSirvItem->find('all', array('conditions' => $conditions, 'limit' => $limit, 'offset' => $start)));
		$this->set('results', $this->ImsSirvItem->find('count', array('conditions' => $conditions)));
	}
	
	function list_requisition_items_data($requisition_id){
 
		$ims_store_id = (isset($_REQUEST['ims_store_id'])) ? $_REQUEST['ims_store_id'] : -1;		
		$this->loadModel('ImsRequisitionItem');	
		$this->ImsRequisitionItem->recursive = -1;		
		$conditions = array('ImsRequisitionItem.ims_requisition_id' => $requisition_id);
    
   // commented for performance purpose.
	//	$requisitionItems = $this->ImsRequisitionItem->find('all', array('conditions' => $conditions));	
  
   	
	  $cmd="select 
          i.name,i.description,ri.measurement,ri.quantity,ri.issued,ri.remark,
          (select balance from ims_cards where ims_item_id=i.id order by id desc limit 1) as balance,
          IFNULL((select getreserved(ri.ims_item_id)),0) as reserved,
          IFNULL((select balance from ims_stores_items where ims_item_id=ri.ims_item_id and ims_store_id=".$ims_store_id ."),0) as 'store_balance',
         IFNULL( ( select getreservedstore(ri.ims_item_id,".$ims_store_id.") ),0)as 'store_reserved'
          from ims_requisitions r join  ims_requisition_items ri
          on r.id=ri.ims_requisition_id join ims_items i
          on ri.ims_item_id=i.id 
          where r.id=".$requisition_id ."  ";
    
    
    $requisitionItems = $this->ImsSirvItem->query($cmd);	
    
   // var_dump($requisitionItems);die();
   
		$this->set('ims_Requisition_Items', $requisitionItems);
   
		$this->set('results', $this->ImsRequisitionItem->find('count', array('conditions' => $conditions)));
		
   
		$this->loadModel('ImsStore');	
    $this->ImsStore->recursive=-1;
		$stores = $this->ImsStore->find('all');
		$this->set('stores', $stores);
		$this->set('ims_store_id', $ims_store_id);
   
	}
	
	function getreserved(){
		$reserved = 0;
		$id = $this->params['itemid'];
		$this->loadModel('ImsRequisition');
		$this->ImsRequisition->recursive = -1;
		$conditionsr = array('ImsRequisition.status' => array('SIRV created','accepted'));
		$requisitions = $this->ImsRequisition->find('all', array('conditions' => $conditionsr));
		
		$this->loadModel('ImsRequisitionItem');
		$this->ImsRequisitionItem->recursive = -1;
		
		foreach($requisitions as $requisition){			
			$conditions = array('ImsRequisitionItem.ims_requisition_id' => $requisition['ImsRequisition']['id'],'ImsRequisitionItem.ims_item_id' =>$id);
			$requisitionItems = $this->ImsRequisitionItem->find('all', array('conditions' => $conditions));
			
			foreach($requisitionItems as $requisitionItem){
				$reserved = $reserved + $requisitionItem['ImsRequisitionItem']['issued'];
			}
		}
		return $reserved;
	}
	
	function getreservedstore(){
		$reserved = 0;
		$id = $this->params['itemid'];
		$storeid = $this->params['storeid'];
		$this->loadModel('ImsRequisition');
		$this->ImsRequisition->recursive = -1;
		$conditionsr = array('ImsRequisition.status' => array('SIRV created','accepted'),'ImsRequisition.ims_store_id' => $storeid);
		$requisitions = $this->ImsRequisition->find('all', array('conditions' => $conditionsr));
		
		$this->loadModel('ImsRequisitionItem');
		$this->ImsRequisitionItem->recursive = -1;
		
		foreach($requisitions as $requisition){			
			$conditions = array('ImsRequisitionItem.ims_requisition_id' => $requisition['ImsRequisition']['id'],'ImsRequisitionItem.ims_item_id' =>$id);
			$requisitionItems = $this->ImsRequisitionItem->find('all', array('conditions' => $conditions));
			
			foreach($requisitionItems as $requisitionItem){
				$reserved = $reserved + $requisitionItem['ImsRequisitionItem']['issued'];
			}
		}
		return $reserved;
	}
	
	function list_requisition_items_data1($requisition_id){
		$this->loadModel('ImsRequisitionItem');		
		$conditions = array('ImsRequisitionItem.ims_requisition_id' => $requisition_id,'ImsRequisitionItem.issued !=' => 0);
		$this->set('ims_Requisition_Items', $this->ImsRequisitionItem->find('all', array('conditions' => $conditions)));
		$this->set('results', $this->ImsRequisitionItem->find('count', array('conditions' => $conditions)));
	}
	
	function list_sirv_items_data1($sirv_id){		
		$conditions = array('ImsSirvItem.ims_sirv_id' => $sirv_id);
		$sirvItems = $this->ImsSirvItem->find('all', array('conditions' => $conditions));
		$items = array();
		foreach ($sirvItems as $sirvItem){			
			if($sirvItem['ImsItem']['fixed_asset'] == 1){
				$items[] = $sirvItem;
			}
		}
		$this->set('ims_Sirv_Items',$items );
		$this->set('results', $this->ImsSirvItem->find('count', array('conditions' => $conditions)));
	}
	
	function list_sirv_items_data_adjust($sirv_id){		
		$conditions = array('ImsSirvItem.ims_sirv_id' => $sirv_id);
		$sirvItems = $this->ImsSirvItem->find('all', array('conditions' => $conditions));
		
		$sirvArray = array();
		$this->loadModel('ImsCard');
		$this->ImsCard->recursive = -1; 
		for($i = 0; $i < count($sirvItems); $i++) { 
			$conditionsCard = array('ImsCard.ims_sirv_item_id' => $sirvItems[$i]['ImsSirvItem']['id'],'ImsCard.ims_grn_item_id !=' => 0);
			$card = $this->ImsCard->find('all', array('conditions' =>$conditionsCard));
			
			if($card != null)
			{
				unset($sirvItems[$i]);
			}
		}
		
		
		$this->set('ims_Sirv_Items',$sirvItems );
		$this->set('results', $this->ImsSirvItem->find('count', array('conditions' => $conditions)));
	}
	
/** @melkamu modified for return transfer Item */
function list_sirv_items_data2($sirv_id){		
	$conditions = array('ImsSirvItem.ims_sirv_id' => $sirv_id);
	$sirvItems = $this->ImsSirvItem->find('all', array('conditions' => $conditions));
	$items = array();
	$count = 0;
	$this->loadModel('ImsCard');
	$this->ImsCard->recursive = -1;
	$this->loadModel('ImsTransferItem');
	$this->ImsTransferItem->recursive = -1;
	$this->loadModel('ImsReturnItem');
	$this->ImsReturnItem->recursive = 1;
	
	foreach ($sirvItems as $sirvItem){		
		if($sirvItem['ImsItem']['fixed_asset'] == 1){
			$conditionsReturnItem = array('ImsReturnItem.ims_sirv_item_id' => $sirvItem['ImsSirvItem']['id'],);
			$ReturnItem = $this->ImsReturnItem->find('all', array('conditions' => $conditionsReturnItem));
			$return=0;
			for ($i=0; $i< sizeof($ReturnItem); $i++){

				if($ReturnItem[$i]['ImsReturn']['status']!="rejected" ){
					$return +=$ReturnItem[$i]['ImsReturnItem']['quantity'];
				}
				
			}
			$sirvItem['ImsSirvItem']['return']=$return;
			$conditionsCard = array('ImsCard.ims_sirv_item_id' => $sirvItem['ImsSirvItem']['id'], 'ImsCard.in_quantity >' => 0);
			$card = $this->ImsCard->find('all', array('conditions' => $conditionsCard));
			
			if(empty($card)){ 
				$conditionsCard = array('ImsCard.ims_sirv_item_id' => $sirvItem['ImsSirvItem']['id'], 'ImsCard.out_quantity >' => 0);
				$card = $this->ImsCard->find('first', array('conditions' => $conditionsCard));
				$conditionsTransfer = array('ImsTransferItem.ims_card_id' => $card['ImsCard']['id']);
				$transferItems = $this->ImsTransferItem->find('all', array('conditions' => $conditionsTransfer));
				$sirvItem['ImsSirvItem']['transfer']=0;
				$sirvItem['ImsSirvItem']['total']=$sirvItem['ImsSirvItem']['quantity'];
				if(empty($transferItems)){
					$items[$count] = $sirvItem;
					//$count++;
				}
				else if(!empty($transferItems)){
					$total = 0;
					foreach($transferItems as $transferItem){
						$total += $transferItem['ImsTransferItem']['quantity'];							
						}
					$sirvItem['ImsSirvItem']['transfer']=$total;
					if($total <= $sirvItem['ImsSirvItem']['quantity']){
						$left = $sirvItem['ImsSirvItem']['quantity'] - $total;
						$items[$count] = $sirvItem;
						$items[$count]['ImsSirvItem']['quantity'] = $left;

						//$count++;
					}
				}
				$quntity=$items[$count]['ImsSirvItem']['quantity'];

				if ($quntity < $return){
					$items[$count]['ImsSirvItem']['quantity']=0;
					
				}
				else{
					$items[$count]['ImsSirvItem']['quantity']=$quntity-$return;
				}
				$count++;
			  }
		}
	}

	$this->set('ims_Sirv_Items', $items);
	$this->set('results', $this->ImsSirvItem->find('count', array('conditions' => $conditions)));
}
/** end of function list_sirv_items_data2 */
	
	function list_sirv_items_data($requisition_id){
		$this->loadModel('ImsRequisitionItem');		
		$conditions = array('ImsRequisitionItem.ims_requisition_id' => $requisition_id,'ImsRequisitionItem.issued !=' => 0);
		$this->set('ims_Requisition_Items', $this->ImsRequisitionItem->find('all', array('conditions' => $conditions)));
		$this->set('results', $this->ImsRequisitionItem->find('count', array('conditions' => $conditions)));
	}

	function view($id = null) {
		if (!$id) {
			$this->Session->setFlash(__('Invalid ims sirv item', true));
			$this->redirect(array('action' => 'index'));
		}
		$this->ImsSirvItem->recursive = 2;
		$this->set('imsSirvItem', $this->ImsSirvItem->read(null, $id));
	}

	function add($id = null) {
		if (!empty($this->data)) {
			$this->ImsSirvItem->create();
			$this->autoRender = false;
			if ($this->ImsSirvItem->save($this->data)) {
				$this->Session->setFlash(__('The ims sirv item has been saved', true), '');
				$this->render('/elements/success');
			} else {
				$this->Session->setFlash(__('The ims sirv item could not be saved. Please, try again.', true), '');
				$this->render('/elements/failure');
			}
		}
		if($id)
			$this->set('parent_id', $id);
		$ims_sirvs = $this->ImsSirvItem->ImsSirv->find('list');
		$ims_items = $this->ImsSirvItem->ImsItem->find('list');
		$this->set(compact('ims_sirvs', 'ims_items'));
	}

	function edit($id = null, $parent_id = null) {
		if (!$id && empty($this->data)) {
			$this->Session->setFlash(__('Invalid ims sirv item', true), '');
			$this->redirect(array('action' => 'index'));
		}
		if (!empty($this->data)) {
			$this->autoRender = false;
			if ($this->ImsSirvItem->save($this->data)) {
				$this->Session->setFlash(__('The ims sirv item has been saved', true), '');
				$this->render('/elements/success');
			} else {
				$this->Session->setFlash(__('The ims sirv item could not be saved. Please, try again.', true), '');
				$this->render('/elements/failure');
			}
		}
		$this->set('ims__sirv__item', $this->ImsSirvItem->read(null, $id));
		
		if($parent_id) {
			$this->set('parent_id', $parent_id);
		}
			
		$ims_sirvs = $this->ImsSirvItem->ImsSirv->find('list');
		$ims_items = $this->ImsSirvItem->ImsItem->find('list');
		$this->set(compact('ims_sirvs', 'ims_items'));
	}

	function delete($id = null) {
		$this->autoRender = false;
		if (!$id) {
			$this->Session->setFlash(__('Invalid id for ims sirv item', true), '');
			$this->render('/elements/failure');
		}
		if (stripos($id, '_') !== false) {
            $ids = explode('_', $id);
            try{
                foreach ($ids as $i) {
                    $this->ImsSirvItem->delete($i);
                }
				$this->Session->setFlash(__('Ims sirv item deleted', true), '');
				$this->render('/elements/success');
            }
            catch (Exception $e){
				$this->Session->setFlash(__('Ims sirv item was not deleted', true), '');
				$this->render('/elements/failure');
            }
        } else {
            if ($this->ImsSirvItem->delete($id)) {
				$this->Session->setFlash(__('Ims sirv item deleted', true), '');
				$this->render('/elements/success');
			} else {
				$this->Session->setFlash(__('Ims sirv item was not deleted', true), '');
				$this->render('/elements/failure');
			}
        }
	}
	
}
?>