<?php
class ImsTransfersController extends AppController {

	var $name = 'ImsTransfers';
	
	function index() {
		$this->ImsTransfer->ImsSirv->recursive = -1;
		$ims_sirvs = $this->ImsTransfer->ImsSirv->find('all');
		$this->set(compact('ims_sirvs'));
		
		$user = $this->Session->read();	
		$this->set('groups',$user['Auth']['Group']);
	}
	
	function index2($id = null) {
		$this->set('parent_id', $id);
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
            $conditions['ImsTransfer.ims_sirv_id'] = $imssirv_id;
        }
		//$this->ImsTransfer->contain(array('TransfferingUser'));
		$this->set('ims_transfers', $this->ImsTransfer->find('all', array('conditions' => $conditions, 'limit' => $limit, 'offset' => $start)));
		$this->set('results', $this->ImsTransfer->find('count', array('conditions' => $conditions)));
	}

	function view($id = null) {
		if (!$id) {
			$this->Session->setFlash(__('Invalid ims transfer', true));
			$this->redirect(array('action' => 'index'));
		}
		$this->ImsTransfer->recursive = 2;
		$this->set('imsTransfer', $this->ImsTransfer->read(null, $id));
	}

	function add($id = null) {
		if (!empty($this->data)) {
			$this->ImsTransfer->create();
			$this->autoRender = false;
			if ($this->ImsTransfer->save($this->data)) {
				$this->Session->setFlash(__('The ims transfer has been saved', true), '');
				$this->render('/elements/success');
			} else {
				$this->Session->setFlash(__('The ims transfer could not be saved. Please, try again.', true), '');
				$this->render('/elements/failure');
			}
		}
		if($id)
			$this->set('parent_id', $id);
		$ims_sirvs = $this->ImsTransfer->ImsSirv->find('list');
		$this->set(compact('ims_sirvs'));
	}

	function edit($id = null, $parent_id = null) {
		if (!$id && empty($this->data)) {
			$this->Session->setFlash(__('Invalid ims transfer', true), '');
			$this->redirect(array('action' => 'index'));
		}
		if (!empty($this->data)) {
			$this->autoRender = false;
			if ($this->ImsTransfer->save($this->data)) {
				$this->Session->setFlash(__('The ims transfer has been saved', true), '');
				$this->render('/elements/success');
			} else {
				$this->Session->setFlash(__('The ims transfer could not be saved. Please, try again.', true), '');
				$this->render('/elements/failure');
			}
		}
		$this->set('ims__transfer', $this->ImsTransfer->read(null, $id));
		
		if($parent_id) {
			$this->set('parent_id', $parent_id);
		}
			
		$ims_sirvs = $this->ImsTransfer->ImsSirv->find('list');
		$this->set(compact('ims_sirvs'));
	}

	function delete($id = null) {
		$this->autoRender = false;
		if (!$id) {
			$this->Session->setFlash(__('Invalid id for ims transfer', true), '');
			$this->render('/elements/failure');
		}
		if (stripos($id, '_') !== false) {
            $ids = explode('_', $id);
            try{
                foreach ($ids as $i) {
                    $this->ImsTransfer->delete($i);
                }
				$this->Session->setFlash(__('Ims transfer deleted', true), '');
				$this->render('/elements/success');
            }
            catch (Exception $e){
				$this->Session->setFlash(__('Ims transfer was not deleted', true), '');
				$this->render('/elements/failure');
            }
        } else {
            if ($this->ImsTransfer->delete($id)) {
				$this->Session->setFlash(__('Ims transfer deleted', true), '');
				$this->render('/elements/success');
			} else {
				$this->Session->setFlash(__('Ims transfer was not deleted', true), '');
				$this->render('/elements/failure');
			}
        }
	}
	
	function add_transfer($id = null,$from_branch,$to_branch,$from_user,$to_user,$number,$number2){
		if (isset($_POST) and $_POST != null) {
			global $value;
			$sirvItemid;		    
			$code;
			$measurement;
			$quantity;
			$unit_price;
			$remark;	

			$this->loadModel('User');
			$this->User->recursive =-1;
			$this->loadModel('employee');
			$this->User->recursive =-1;
			$this->loadModel('employee_detail');
			$this->User->recursive =-1;
			
			// start add my code from these @melkamu//
			$conditionsToUser =array('User.person_id' => $to_user);
			$touser = $this->User->find('first', array('conditions' => $conditionsToUser));
			$conditionsToEmployee =array('user_id' => $touser['User']['id']);
			$employee = $this->employee->find('first', array('conditions' => $conditionsToEmployee));
			$detailCount=count($employee['EmployeeDetail'])-1;
			$tobranchId=$employee['EmployeeDetail'][$detailCount]['branch_id'];

			// end my code adding //


			$conditionsFromUser =array('User.person_id' => $from_user);
			$fromuser = $this->User->find('first', array('conditions' => $conditionsFromUser));
			
			// $conditionsToUser =array('User.person_id' => $to_user);
			// $touser = $this->User->find('first', array('conditions' => $conditionsToUser));
			
			$this->ImsTransfer->create();
			$this->data['ImsTransfer']['name'] = $number.'/'.$number2;
			$this->data['ImsTransfer']['ims_sirv_id'] = $id;
			$this->data['ImsTransfer']['from_user'] = $fromuser['User']['id'];
			$this->data['ImsTransfer']['to_user'] = $touser['User']['id'];
			$this->data['ImsTransfer']['from_branch'] = $from_branch;
			//$this->data['ImsTransfer']['to_branch'] = $to_branch;
			$this->data['ImsTransfer']['to_branch'] = $tobranchId;
			if($this->ImsTransfer->save($this->data)){
				$transferId = $this->ImsTransfer->getLastInsertId();
				$this->loadModel('ImsItem'); 
				$this->loadModel('ImsCard'); 
				foreach ($_POST as $key => $value) {			
					$tmpost = explode('^', $key);
					if($tmpost[1] == 'code')
					{				
						$itemcode = $value;
						$itemcode = explode('"',$itemcode);
						$this->ImsItem->recursive =-1;			
						$conditionsItem =array('ImsItem.description' => $itemcode[1]);
						$item = $this->ImsItem->find('first', array('conditions' => $conditionsItem));
					}
					else if($tmpost[1] == 'id')
					{
						$imsSirvItemId = $value;
						$imsSirvItemId = explode('"',$imsSirvItemId);
						$this->ImsCard->recursive =-1;			
						$conditionsCard =array('ImsCard.ims_sirv_item_id' => $imsSirvItemId[1]);
						$card = $this->ImsCard->find('first', array('conditions' => $conditionsCard));
					}	
					else if($tmpost[1] == 'measurement')
					{
						$measurement = $value;
						$measurement = explode('"',$measurement);
					}	
					else if($tmpost[1] == 'quantity')
					{
						$quantity = $value;
						$quantity = explode('"',$quantity);
						
						if(count($quantity) == 1){
							$quantity = $quantity[0];
						}
						else $quantity = $quantity[1];
					}					
					else if($tmpost[1] == 'unit_price')
					{
						$unit_price = $value;
						$unit_price = explode('"',$unit_price);
					}
					else if($tmpost[1] == 'remark')
					{
						$remark = $value;
						$remark = explode('"',$remark);
					}
					else if($tmpost[1] == 'tag')
					{	
						$tag = $value;
						$tag = explode('"',$tag);
						$this->create_transfer($transferId,$card['ImsCard']['id'],$item['ImsItem']['id'],$measurement[1],$quantity,$unit_price[1],$tag[1]);

					}	
								
				}
			}
			if($value == true){
				$this->Session->setFlash(__('Transfer created Successfully', true), '');
				$this->render('/elements/success');
			}
			else{
				$this->Session->setFlash(__('Unable to create Transfer', true), '');
				$this->render('/elements/failure');
			}
		}
	}
	
	function add_transfer2($id = null,$from_branch,$to_branch,$from_user,$to_user,$number,$number2){
		if (isset($_POST) and $_POST != null) {
			global $value;
			$code;
			$measurement;
			$quantity;
			$unit_price;
			$remark;			
			
			$this->loadModel('User');
			$this->User->recursive =-1;
			$this->loadModel('employee');
			$this->User->recursive =-1;
			$this->loadModel('employee_detail');
			$this->User->recursive =-1;

		

			$conditionsFromUser =array('User.person_id' => $from_user);
			$fromuser = $this->User->find('first', array('conditions' => $conditionsFromUser));
			
			//$conditionsToUser =array('User.person_id' => $to_user);
			//$touser = $this->User->find('first', array('conditions' => $conditionsToUser));


			// start add my code from these @melkamu//
			$conditionsToUser =array('User.person_id' => $to_user);
			$touser = $this->User->find('first', array('conditions' => $conditionsToUser));
			$conditionsToEmployee =array('user_id' => $touser['User']['id']);
			$employee = $this->employee->find('first', array('conditions' => $conditionsToEmployee));
			$detailCount=count($employee['EmployeeDetail'])-1;
			$tobranchId=$employee['EmployeeDetail'][$detailCount]['branch_id'];

			// end my code adding //
			
			$transfer = $this->ImsTransfer->read(null, $id);
			
			$this->ImsTransfer->create();
			$this->data['ImsTransfer']['name'] = $number.'/'.$number2;
			$this->data['ImsTransfer']['ims_sirv_id'] = $transfer['ImsTransfer']['ims_sirv_id'];
			$this->data['ImsTransfer']['from_user'] = $fromuser['User']['id'];
			$this->data['ImsTransfer']['to_user'] = $touser['User']['id'];
			$this->data['ImsTransfer']['from_branch'] = $from_branch;
			//$this->data['ImsTransfer']['to_branch'] = $to_branch;
			$this->data['ImsTransfer']['to_branch'] =  $tobranchId;
			if($this->ImsTransfer->save($this->data)){
				$transferId = $this->ImsTransfer->getLastInsertId();
				$this->loadModel('ImsItem'); 
				$this->loadModel('ImsCard'); 
				foreach ($_POST as $key => $value) {			
					$tmpost = explode('^', $key);
					if($tmpost[1] == 'code')
					{				
						$itemcode = $value;
						$itemcode = explode('"',$itemcode);
						$this->ImsItem->recursive =-1;			
						$conditionsItem =array('ImsItem.description' => $itemcode[1]);
						$item = $this->ImsItem->find('first', array('conditions' => $conditionsItem));
					}
					else if($tmpost[1] == 'id')
					{
						$imsTransferItemId = $value;
						$imsTransferItemId = explode('"',$imsTransferItemId);
						$transfer_item = $this->ImsTransfer->ImsTransferItem->read(null, $imsTransferItemId[1]);
					}	
					else if($tmpost[1] == 'measurement')
					{
						$measurement = $value;
						$measurement = explode('"',$measurement);
					}	
					else if($tmpost[1] == 'quantity')
					{
						$quantity = $value;
						$quantity = explode('"',$quantity);
						
						if(count($quantity) == 1){
							$quantity = $quantity[0];
						}
						else $quantity = $quantity[1];
					}					
					else if($tmpost[1] == 'unit_price')
					{
						$unit_price = $value;
						$unit_price = explode('"',$unit_price);
					}
					else if($tmpost[1] == 'remark')
					{
						$remark = $value;
						$remark = explode('"',$remark);
					}
					else if($tmpost[1] == 'tag')
					{	
						$tag = $value;
						$tag = explode('"',$tag);
						$this->create_transfer2($transferId,$transfer_item['ImsTransferItem']['ims_card_id'],$item['ImsItem']['id'],$measurement[1],$quantity,$unit_price[1],$tag[1],$id);

					}	
								
				}
			}
			if($value == true){
				$this->Session->setFlash(__('Transfer created Successfully', true), '');
				$this->render('/elements/success');
			}
			else{
				$this->Session->setFlash(__('Unable to create Transfer', true), '');
				$this->render('/elements/failure');
			}
		}
	}
	
	function create_transfer($transferId,$cardId,$itemId,$measurement,$quantity,$unit_price,$tag){
		global $value;
		
		$this->loadModel('ImsTransferItem');	
		
		$this->ImsTransferItem->create();
		$this->data['ImsTransferItem']['ims_transfer_id'] = $transferId;
		$this->data['ImsTransferItem']['ims_card_id'] = $cardId;	
		$this->data['ImsTransferItem']['ims_item_id'] = $itemId;
		$this->data['ImsTransferItem']['measurement'] = $measurement;
		$this->data['ImsTransferItem']['quantity'] = $quantity;
		$this->data['ImsTransferItem']['unit_price'] = $unit_price;
		$this->data['ImsTransferItem']['tag'] = $tag;
		
		if($this->ImsTransferItem->save($this->data))
		{
			if($value != false){
				$value = true;
			}
		}		
		else{
			$value = false;			
		}
	}
	
	function create_transfer2($transferId,$cardId,$itemId,$measurement,$quantity,$unit_price,$tag,$id){
		global $value;
		
		$this->loadModel('ImsTransferItem');	
		
		$this->ImsTransferItem->create();
		$this->data['ImsTransferItem']['ims_transfer_id'] = $transferId;
		$this->data['ImsTransferItem']['ims_card_id'] = $cardId;	
		$this->data['ImsTransferItem']['ims_item_id'] = $itemId;
		$this->data['ImsTransferItem']['measurement'] = $measurement;
		$this->data['ImsTransferItem']['quantity'] = $quantity;
		$this->data['ImsTransferItem']['unit_price'] = $unit_price;
		$this->data['ImsTransferItem']['tag'] = $tag;
		$this->data['ImsTransferItem']['transfer_id'] = $id;
		
		if($this->ImsTransferItem->save($this->data))
		{
			if($value != false){
				$value = true;
			}
		}		
		else{
			$value = false;			
		}
	}
	
	function getUser(){
		$userid = $this->params['userid'];	
		$this->loadModel('User');
		$conditions = array('User.id' => $userid);
		$this->User->recursive = 0;
		$user = $this->User->find('first',array('conditions' => $conditions));	
		return $user;
	}
	
	function print_transfer($id = null){
        $this->layout = 'print_layout';
        
        if (!$id) {
            $this->autoRender = false;
            $this->Session->setFlash(__('Invalid id for transfer', true), '');
            $this->render('/elements/failure');
        }
        $this->ImsTransfer->recursive = 1;
        $this->set('transfer', $this->ImsTransfer->read(null, $id));
    }
	
	function getcategories()
	{		
		$this->loadModel('ImsItemCategory'); 
		$this->ImsItemCategory->recursive =-1;			
		$conditions =array('ImsItemCategory.parent_id' => 1);
		$itemcategory = $this->ImsItemCategory->find('all', array('conditions' => $conditions));
		
		for($j=0;$j<count($itemcategory );$j++){
			$itemcategory [$j]['child'] = $this->getChild($itemcategory [$j]['ImsItemCategory']['id']);			
			$itemcategory [$j]['child'][] = $itemcategory[$j];
		}
		return $itemcategory; 
	}
	
	function getChild($parentId=null){
		$this->loadModel('ImsItemCategory'); 
		$conditions =array('ImsItemCategory.parent_id' =>$parentId);
		$this->ImsItemCategory->recursive = -1;
		$children = $this->ImsItemCategory->find('all', array('conditions' => $conditions));
		if(!empty($children)){
			for($i=0;$i<count($children);$i++){				
				$children[$i]['child'] = $this->getChild($children[$i]['ImsItemCategory']['id']);
			}
			return $children;
		}
	}
	
	function getitem()
	{
		$id = $this->params['itemid'];
		$this->loadModel('ImsItem');
		$item = $this->ImsItem->read(null,$id);
		return $item['ImsItem']; 
	}
}
?>