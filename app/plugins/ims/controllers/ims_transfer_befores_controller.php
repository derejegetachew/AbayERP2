<?php
class ImsTransferBeforesController extends ImsAppController {

	var $name = 'ImsTransferBefores';
	
	function index() {
		$this->ImsTransferBefore->ImsSirvBefore->recursive = -1;
		$ims_sirv_befores = $this->ImsTransferBefore->ImsSirvBefore->find('all');
		$this->set(compact('ims_sirv_befores'));
	}
	
	function index2($id = null) {
		$this->set('parent_id', $id);
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
            $conditions['ImsTransferBefore.ims_sirv_before_id'] = $imssirvbefore_id;
        }
		$this->ImsTransferBefore->contain(array('TransfferingUser'));
		$this->set('ims_transfer_befores', $this->ImsTransferBefore->find('all', array('conditions' => $conditions, 'limit' => $limit, 'offset' => $start)));
		$this->set('results', $this->ImsTransferBefore->find('count', array('conditions' => $conditions)));
	}

	function view($id = null) {
		if (!$id) {
			$this->Session->setFlash(__('Invalid ims transfer before', true));
			$this->redirect(array('action' => 'index'));
		}
		$this->ImsTransferBefore->recursive = 2;
		$this->set('imsTransferBefore', $this->ImsTransferBefore->read(null, $id));
	}

	function add($id = null) {
		if (!empty($this->data)) {
			$this->ImsTransferBefore->create();
			$this->autoRender = false;
			if ($this->ImsTransferBefore->save($this->data)) {
				$this->Session->setFlash(__('The ims transfer before has been saved', true), '');
				$this->render('/elements/success');
			} else {
				$this->Session->setFlash(__('The ims transfer before could not be saved. Please, try again.', true), '');
				$this->render('/elements/failure');
			}
		}
		if($id)
			$this->set('parent_id', $id);
		$ims_sirv_befores = $this->ImsTransferBefore->ImsSirvBefore->find('list');
		$this->set(compact('ims_sirv_befores'));
	}

	function edit($id = null, $parent_id = null) {
		if (!$id && empty($this->data)) {
			$this->Session->setFlash(__('Invalid ims transfer before', true), '');
			$this->redirect(array('action' => 'index'));
		}
		if (!empty($this->data)) {
			$this->autoRender = false;
			if ($this->ImsTransferBefore->save($this->data)) {
				$this->Session->setFlash(__('The ims transfer before has been saved', true), '');
				$this->render('/elements/success');
			} else {
				$this->Session->setFlash(__('The ims transfer before could not be saved. Please, try again.', true), '');
				$this->render('/elements/failure');
			}
		}
		$this->set('ims__transfer__before', $this->ImsTransferBefore->read(null, $id));
		
		if($parent_id) {
			$this->set('parent_id', $parent_id);
		}
			
		$ims_sirv_befores = $this->ImsTransferBefore->ImsSirvBefore->find('list');
		$this->set(compact('ims_sirv_befores'));
	}

	function delete($id = null) {
		$this->autoRender = false;
		if (!$id) {
			$this->Session->setFlash(__('Invalid id for ims transfer before', true), '');
			$this->render('/elements/failure');
		}
		$this->loadModel('ImsTransferItemBefore');
		if (stripos($id, '_') !== false) {
            $ids = explode('_', $id);
            try{
                foreach ($ids as $i) {
				$conditionsImsTransferItemBefore =array('ImsTransferItemBefore.ims_transfer_before_id' => $i);
				$ImsTransferItemBefore = $this->ImsTransferItemBefore->find('first', array('conditions' => $conditionsImsTransferItemBefore));
				$this->ImsTransferBefore->delete($i);
				$this->ImsTransferItemBefore->delete($ImsTransferItemBefore['ImsTransferItemBefore']['id']);
                    }
				$this->Session->setFlash(__('Ims transfer before deleted', true), '');
				$this->render('/elements/success');
            }
            catch (Exception $e){
				$this->Session->setFlash(__('Ims transfer before was not deleted', true), '');
				$this->render('/elements/failure');
            }
        } else {
			    $conditionsImsTransferItemBefore =array('ImsTransferItemBefore.ims_transfer_before_id' => $id);
				$ImsTransferItemBefore = $this->ImsTransferItemBefore->find('first', array('conditions' => $conditionsImsTransferItemBefore));
				if ($this->ImsTransferBefore->delete($id)) {
				$this->ImsTransferItemBefore->delete($ImsTransferItemBefore['ImsTransferItemBefore']['id']);
				$this->Session->setFlash(__('Ims transfer before deleted', true), '');
				$this->render('/elements/success');
			} else {
				$this->Session->setFlash(__('Ims transfer before was not deleted', true), '');
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
			
			// $this->loadModel('User');
			// $this->User->recursive =-1;
			// add my code @melkamu //
			$this->loadModel('User');
			$this->User->recursive =-1;
			$this->loadModel('employee');
			$this->User->recursive =-1;
			$this->loadModel('employee_detail');
			$this->User->recursive =-1;

			// from user  branch 
			$conditionsFromUser =array('User.person_id' => $from_user);
			$fromuser = $this->User->find('first', array('conditions' => $conditionsFromUser));
			$conditionsFromEmployee =array('user_id' => $fromuser['User']['id']);
			$fromemployee = $this->employee->find('first', array('conditions' => $conditionsFromEmployee));
			$fromEmployeeDetailCount=count($fromemployee['EmployeeDetail'])-1;
			$fromBranchId=$fromemployee['EmployeeDetail'][$fromEmployeeDetailCount]['branch_id'];

			// to user  branch 
			$conditionsToUser =array('User.person_id' => $to_user);
			$touser = $this->User->find('first', array('conditions' => $conditionsToUser));
			$conditionsToEmployee =array('user_id' => $touser['User']['id']);
			$employee = $this->employee->find('first', array('conditions' => $conditionsToEmployee));
			$detailCount=count($employee['EmployeeDetail'])-1;
			$tobranchId=$employee['EmployeeDetail'][$detailCount]['branch_id'];

			
			//ende//
			
			// $conditionsFromUser =array('User.person_id' => $from_user);
			// $fromuser = $this->User->find('first', array('conditions' => $conditionsFromUser));
			
			// $conditionsToUser =array('User.person_id' => $to_user);
			// $touser = $this->User->find('first', array('conditions' => $conditionsToUser));
			
			$this->ImsTransferBefore->create();
			$this->data['ImsTransferBefore']['name'] = $number.'/'.$number2;
			$this->data['ImsTransferBefore']['ims_sirv_before_id'] = $id;
			$this->data['ImsTransferBefore']['from_user'] = $fromuser['User']['id'];
			$this->data['ImsTransferBefore']['to_user'] = $touser['User']['id'];
			// $this->data['ImsTransferBefore']['from_branch'] = $from_branch;
			// $this->data['ImsTransferBefore']['to_branch'] = $to_branch;
             //modified game//
			$this->data['ImsTransferBefore']['from_branch'] = $fromBranchId;
		    $this->data['ImsTransferBefore']['to_branch'] = $tobranchId;
			//end//
			if($this->ImsTransferBefore->save($this->data)){
				$transferId = $this->ImsTransferBefore->getLastInsertId();
				$this->loadModel('ImsItem'); 
				$this->loadModel('ImsSirvItemBefore'); 
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
						$imsSirvItemBeforeId = $value;
						$imsSirvItemBeforeId = explode('"',$imsSirvItemBeforeId);
						$this->ImsSirvItemBefore->recursive =-1;			
						$conditionsSirvItemBefore =array('ImsSirvItemBefore.id' => $imsSirvItemBeforeId[1]);
						$sirvItemBefore = $this->ImsSirvItemBefore->find('first', array('conditions' => $conditionsSirvItemBefore));
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
						$this->create_transfer($transferId,$sirvItemBefore['ImsSirvItemBefore']['id'],$item['ImsItem']['id'],$measurement[1],$quantity[1],$unit_price[1],$tag[1]);

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
	
	function create_transfer($transferId,$sirvItemBeforeId,$itemId,$measurement,$quantity,$unit_price,$tag){
		global $value;
		
		$this->loadModel('Ims.ImsTransferItemBefore');	
		
		$this->ImsTransferItemBefore->create();
		$data1 = array('ImsTransferItemBefore' => array());
		
		$data1['ImsTransferItemBefore']['ims_transfer_before_id'] = $transferId;
		$data1['ImsTransferItemBefore']['ims_sirv_item_before_id'] = $sirvItemBeforeId;	
		$data1['ImsTransferItemBefore']['ims_item_id'] = $itemId;
		$data1['ImsTransferItemBefore']['measurement'] = $measurement;
		$data1['ImsTransferItemBefore']['quantity'] = $quantity;
		$data1['ImsTransferItemBefore']['unit_price'] = $unit_price;
		$data1['ImsTransferItemBefore']['tag'] = $tag;
		
		if($this->ImsTransferItemBefore->save($data1))
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
	
	function print_transfer_before($id = null){
        $this->layout = 'print_layout';
        
        if (!$id) {
            $this->autoRender = false;
            $this->Session->setFlash(__('Invalid id for transfer before', true), '');
            $this->render('/elements/failure');
        }
        $this->ImsTransferBefore->recursive = 1;
        $this->set('transferBefore', $this->ImsTransferBefore->read(null, $id));
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