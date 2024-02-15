<?php
class ImsReturnsController extends AppController {

	var $name = 'ImsReturns';
	
	function index() {
	}
	
	function index2() {
	}
	

	function search() {
	}
	
	function list_data($id = null) {
		$start = (isset($_REQUEST['start'])) ? $_REQUEST['start'] : 0;
		$limit = (isset($_REQUEST['limit'])) ? $_REQUEST['limit'] : 5;
        $conditions = (isset($_REQUEST['conditions'])) ? $_REQUEST['conditions'] : '';

        eval("\$conditions = array( " . $conditions . " );");
        
    $order= array('ImsReturn.id desc'); 
    
   // var_dump($conditions);die();
    if(isset($conditions) && count($conditions)>0){
    $param= " where r.name like '". str_replace("=>"," ",$conditions["ImsReturn.name LIKE"]) . "'";
    }else{
     $param= "where 1=1 ";
    }
  // var_dump($param);die();
      
    $cmd="select  r.id,r.name,r.status,r.created,r.modified,
                        (select distinct  CONCAT(p.first_name,' ',CONCAT(p.middle_name,' ',p.last_name)) from users u join people p on p.id=u.person_id where u.id=r.received_by) as 'received_by',
                        (select distinct CONCAT(p.first_name,' ',CONCAT(p.middle_name,' ',p.last_name)) from users u join people p on p.id=u.person_id where u.id=r.approved_rejected_by) as 'approved_by',
                          (select DISTINCT CONCAT(p.first_name,' ',CONCAT(p.middle_name,' ',p.last_name)) from users u join people p on p.id=u.person_id where u.id=r.returned_by) as 'returned_by',
                        (select name from  branches b where b.id=r.returned_from) as 'returned_from'
                        from ims_returns r     
                        ".$param."
                      order by r.id desc 
                      limit ".$limit." offset ".$start.";";
    
		
		//$this->set('ims_returns', $this->ImsReturn->find('all', array('conditions' => $conditions, 'limit' => $limit, 'offset' => $start,'order'=>$order)));
   $ims_r= $this->ImsReturn->query($cmd);
  // var_dump($conditions);die();
		$this->set('ims_returns',$ims_r );
		$count=$this->ImsReturn->find('count', array('conditions' => $conditions));
   //var_dump($count);die();
    $this->set('results', $count);
	}
	
	function list_data2($id = null) {
		$start = (isset($_REQUEST['start'])) ? $_REQUEST['start'] : 0;
		$limit = (isset($_REQUEST['limit'])) ? $_REQUEST['limit'] : 5;
        $conditions = (isset($_REQUEST['conditions'])) ? $_REQUEST['conditions'] : '';

        eval("\$conditions = array( " . $conditions . " );");
       
       
    $param="1=1";
   if(isset($_REQUEST['conditions'])){
     $param=  explode("=>",$_REQUEST['conditions']);
     $param= "d.name like " . $param[1];
   }
    
    $cmd=" select d.id,d.name,CONCAT(p.first_name,' ',p.middle_name) as received_by,  
    CONCAT(pp.first_name,' ',pp.middle_name) as approved_by,
    CONCAT(ppp.first_name,' ',ppp.middle_name)  as returned_by,
    bb.name as returned_from,
    d.created,d.modified,d.status 
    from ims_returns d  left join users u
    on u.id=d.received_by left join users uu
    on uu.id=d.approved_rejected_by left join users uuu
    on uuu.id=d.returned_by left join  people p
    on u.person_id=p.id LEFT join people pp
    on pp.id=uu.person_id  left join branches bb
    on d.returned_from=bb.id left join people ppp
    on uuu.person_id=ppp.id where 1=1 and ".$param."
    order by d.id desc limit ".$limit."  offset ".$start."  "; 
       
    // OLD   
		//$ims_returns=$this->ImsReturn->find('all', array('conditions' => $conditions, 'limit' => $limit, 'offset' => $start))
   
   
   // NEW
    $ims_returns=$this->ImsReturn->query($cmd);
    
    //var_dump($ims_returns);die();
   
		$this->set('ims_returns', $ims_returns);
		$this->set('results', $this->ImsReturn->find('count', array('conditions' => array())));
	}

	function view($id = null) {
		if (!$id) {
			$this->Session->setFlash(__('Invalid ims return', true));
			$this->redirect(array('action' => 'index'));
		}
		$this->ImsReturn->recursive = 2;
		$this->set('imsReturn', $this->ImsReturn->read(null, $id));
	}

	function add($id = null) {
		if (!empty($this->data)) {
			$this->ImsReturn->create();
			$this->autoRender = false;
			$this->data['ImsReturn']['status'] = 'Created';
			if ($this->ImsReturn->save($this->data)) {
				$this->Session->setFlash(__('The ims return has been saved', true), '');
				$this->render('/elements/success');
			} else {
				$this->Session->setFlash(__('The ims return could not be saved. Please, try again.', true), '');
				$this->render('/elements/failure');
			}
		}
	}

	function edit($id = null, $parent_id = null) {
		if (!$id && empty($this->data)) {
			$this->Session->setFlash(__('Invalid ims return', true), '');
			$this->redirect(array('action' => 'index'));
		}
		if (!empty($this->data)) {
			$this->autoRender = false;
			if ($this->ImsReturn->save($this->data)) {
				$this->Session->setFlash(__('The ims return has been saved', true), '');
				$this->render('/elements/success');
			} else {
				$this->Session->setFlash(__('The ims return could not be saved. Please, try again.', true), '');
				$this->render('/elements/failure');
			}
		}
		$this->set('ims__return', $this->ImsReturn->read(null, $id));
		
			
	}

	function delete($id = null) {
		$this->autoRender = false;
		if (!$id) {
			$this->Session->setFlash(__('Invalid id for ims return', true), '');
			$this->render('/elements/failure');
		}
		if (stripos($id, '_') !== false) {
            $ids = explode('_', $id);
            try{
                foreach ($ids as $i) {
                    $this->ImsReturn->delete($i);
                }
				$this->Session->setFlash(__('Ims return deleted', true), '');
				$this->render('/elements/success');
            }
            catch (Exception $e){
				$this->Session->setFlash(__('Ims return was not deleted', true), '');
				$this->render('/elements/failure');
            }
        } else {
            if ($this->ImsReturn->delete($id)) {
				$this->Session->setFlash(__('Ims return deleted', true), '');
				$this->render('/elements/success');
			} else {
				$this->Session->setFlash(__('Ims return was not deleted', true), '');
				$this->render('/elements/failure');
			}
        }
	}
	
	
/** @melkamu function to delete transfer and return  new function */
function add_return_transfer($id=null,$from_branch,$from_user,$number,$number2){
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
	    $this->loadModel('ImsSirvItem');
	    $this->ImsSirvItem->recursive = 1;
	    $this->loadModel('ImsCard');
		$this->ImsCard->recursive = -1;
		$this->loadModel('ImsTransferItem');
		$this->ImsTransferItem->recursive = -1;
	    $conditions = array('ImsSirvItem.ims_sirv_id' =>$id);
		$sirvItems = $this->ImsSirvItem->find('all', array('conditions' => $conditions));
		foreach ($sirvItems as $sirvItem){
			if($sirvItem['ImsItem']['fixed_asset'] == 1){		
					$conditionsCard = array('ImsCard.ims_sirv_item_id' => $sirvItem['ImsSirvItem']['id'], 'ImsCard.out_quantity >' => 0);
					$card = $this->ImsCard->find('first', array('conditions' => $conditionsCard));
					$conditionsTransfer = array('ImsTransferItem.ims_card_id' => $card['ImsCard']['id']);
					$transferItems = $this->ImsTransferItem->find('all', array('conditions' => $conditionsTransfer));
					  if(!empty($transferItems)){
						$total = 0;
						foreach($transferItems as $transferItem){
					     $this->ImsTransferItem->delete($transferItem['ImsTransferItem']['id']);						
						    }
					       }
				}
			}
		$conditionsUser =array('User.person_id' => $from_user);
		$user = $this->User->find('first', array('conditions' => $conditionsUser));
		$this->ImsReturn->create();
		$this->data['ImsReturn']['name'] = $number.'/'.$number2;
		$this->data['ImsReturn']['returned_by'] = $user['User']['id'];
		$this->data['ImsReturn']['received_by'] = $this->Session->read('Auth.User.id');
		$this->data['ImsReturn']['returned_from'] = $from_branch;
		$this->data['ImsReturn']['status'] = 'created';
		if($this->ImsReturn->save($this->data)){
			$returnId = $this->ImsReturn->getLastInsertId();
			$this->loadModel('ImsItem'); 
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
				}	
				else if($tmpost[1] == 'measurement')
				{
					$measurement = $value;
					$measurement = explode('"',$measurement);
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
					

				}	
				else if($tmpost[1] == 'transfer')
				{
					$quantity = $value;
					$quantity = explode('"',$quantity);
					$this->create_return($returnId,$imsSirvItemId[1],$item['ImsItem']['id'],$measurement[1],$quantity[1],$unit_price[1],$tag[1]);
				}			
			}
		}
		if($value == true){
			$this->Session->setFlash(__('Return created Successfully', true), '');
			$this->render('/elements/success');
		}
		else{
			$this->Session->setFlash(__('Unable to create Return', true), '');
			$this->render('/elements/failure');
		}
	}	
}

	function add_return($id = null,$from_branch,$from_user,$number,$number2){
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
			$conditionsUser =array('User.person_id' => $from_user);
			$user = $this->User->find('first', array('conditions' => $conditionsUser));
			
			$this->ImsReturn->create();
			$this->data['ImsReturn']['name'] = $number.'/'.$number2;
			$this->data['ImsReturn']['returned_by'] = $user['User']['id'];
			$this->data['ImsReturn']['received_by'] = $this->Session->read('Auth.User.id');
			$this->data['ImsReturn']['returned_from'] = $from_branch;
			$this->data['ImsReturn']['status'] = 'created';
			
			if($this->ImsReturn->save($this->data)){
				$returnId = $this->ImsReturn->getLastInsertId();
				$this->loadModel('ImsItem'); 
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
						$this->create_return($returnId,$imsSirvItemId[1],$item['ImsItem']['id'],$measurement[1],$quantity[1],$unit_price[1],$tag[1]);

					}	
								
				}
			}
			if($value == true){
				$this->Session->setFlash(__('Return created Successfully', true), '');
				$this->render('/elements/success');
			}
			else{
				$this->Session->setFlash(__('Unable to create Return', true), '');
				$this->render('/elements/failure');
			}
		}	
	}
	
	function create_return($returnId,$sirvItemId,$itemId,$measurement,$quantity,$unit_price,$tag){
		global $value;
		
		$this->loadModel('ImsReturnItem');	
		
		$this->ImsReturnItem->create();
		$this->data['ImsReturnItem']['ims_return_id'] = $returnId;
		$this->data['ImsReturnItem']['ims_sirv_item_id'] = $sirvItemId;	
		$this->data['ImsReturnItem']['ims_item_id'] = $itemId;
		$this->data['ImsReturnItem']['measurement'] = $measurement;
		$this->data['ImsReturnItem']['quantity'] = $quantity;
		$this->data['ImsReturnItem']['unit_price'] = $unit_price;
		$this->data['ImsReturnItem']['tag'] = $tag;
		
		if($this->ImsReturnItem->save($this->data))
		{
			if($value != false){
				$value = true;
			}
		}		
		else{
			$value = false;			
		}
	}
	
	function add_return_before($id = null,$from_branch,$from_user,$number,$number2){
		if (isset($_POST) and $_POST != null) {
			global $value;
			$sirvItemBeforeid;		    
			$code;
			$measurement;
			$quantity;
			$unit_price;
			$remark;			
			
			$this->loadModel('User');
			$this->User->recursive =-1;
			$conditionsUser =array('User.person_id' => $from_user);
			$user = $this->User->find('first', array('conditions' => $conditionsUser));
			
			$this->ImsReturn->create();
			$this->data['ImsReturn']['name'] = $number.'/'.$number2;
			$this->data['ImsReturn']['returned_by'] = $user['User']['id'];
			$this->data['ImsReturn']['received_by'] = $this->Session->read('Auth.User.id');
			$this->data['ImsReturn']['returned_from'] = $from_branch;
			$this->data['ImsReturn']['status'] = 'created';
			
			if($this->ImsReturn->save($this->data)){
				$returnId = $this->ImsReturn->getLastInsertId();
				$this->loadModel('ImsItem'); 
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
						$sirvItemBeforeid = $value;
						$sirvItemBeforeid = explode('"',$sirvItemBeforeid);						
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
						$this->create_return_before($returnId,$sirvItemBeforeid[1],$item['ImsItem']['id'],$measurement[1],$quantity[1],$unit_price[1],$tag[1]);

					}	
								
				}
			}
			if($value == true){
				$this->Session->setFlash(__('Return created Successfully', true), '');
				$this->render('/elements/success');
			}
			else{
				$this->Session->setFlash(__('Unable to create Return', true), '');
				$this->render('/elements/failure');
			}
		}	
	}
	
	function create_return_before($returnId,$sirvItemBeforeid,$itemId,$measurement,$quantity,$unit_price,$tag){
		global $value;
		
		$this->loadModel('ImsReturnItem');	
		
		$this->ImsReturnItem->create();
		$this->data['ImsReturnItem']['ims_return_id'] = $returnId;
		$this->data['ImsReturnItem']['ims_sirv_item_before_id'] = $sirvItemBeforeid;	
		$this->data['ImsReturnItem']['ims_item_id'] = $itemId;
		$this->data['ImsReturnItem']['measurement'] = $measurement;
		$this->data['ImsReturnItem']['quantity'] = $quantity;
		$this->data['ImsReturnItem']['unit_price'] = $unit_price;
		$this->data['ImsReturnItem']['tag'] = $tag;
		
		if($this->ImsReturnItem->save($this->data))
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
	
	function print_return($id = null){
        $this->layout = 'print_layout';
        
        if (!$id) {
            $this->autoRender = false;
            $this->Session->setFlash(__('Invalid id for return', true), '');
            $this->render('/elements/failure');
        }
        $this->ImsReturn->recursive = 1;
        $this->set('return', $this->ImsReturn->read(null, $id));
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
	
	function getsirv()
	{
		$id = $this->params['sirvitemid'];
		$this->loadModel('ImsSirvItem');
		$this->ImsSirvItem->recursive =0;
		$sirvitem = $this->ImsSirvItem->read(null,$id);
		return $sirvitem['ImsSirv']; 
	}
	
	function approve($id = null) {
        $this->autoRender = false;
        if (!$id) {
            $this->Session->setFlash(__('Invalid id for return', true), '');
            $this->render('/elements/failure');
        }
		$user = $this->Session->read();		
        $return = array('ImsReturn' => array('id' => $id, 'approved_rejected_by' => $user['Auth']['User']['id'],'status' => 'approved'));
        if ($this->ImsReturn->save($return)) {
            $this->Session->setFlash(__('Return successfully approved', true), '');
            $this->render('/elements/success');
        } else {
            $this->Session->setFlash(__('Return was not successfully approved', true), '');
            $this->render('/elements/failure');
        }
    }
	
	function reject($id = null) {
        $this->autoRender = false;
        if (!$id) {
            $this->Session->setFlash(__('Invalid id for return', true), '');
            $this->render('/elements/failure');
        }
		$user = $this->Session->read();	
        $return = array('ImsReturn' => array('id' => $id, 'approved_rejected_by' => $user['Auth']['User']['id'],'status' => 'rejected'));
        if ($this->ImsReturn->save($return)) {
            $this->Session->setFlash(__('Return successfully rejected', true), '');
            $this->render('/elements/success');
        } else {
            $this->Session->setFlash(__('Return was not successfully rejected', true), '');
            $this->render('/elements/failure');
        }
    }
	
	function dispose($id = null) {
        $this->autoRender = false;
        if (!$id) {
            $this->Session->setFlash(__('Invalid id for return', true), '');
            $this->render('/elements/failure');
        }
		$user = $this->Session->read();	
        $return = array('ImsReturn' => array('id' => $id, 'disposed_by' => $user['Auth']['User']['id'],'status' => 'pending disposal'));
        if ($this->ImsReturn->save($return)) {
            $this->Session->setFlash(__('Returned item successfully disposed', true), '');
            $this->render('/elements/success');
        } else {
            $this->Session->setFlash(__('Returned item was not successfully disposed', true), '');
            $this->render('/elements/failure');
        }
    }
	
	function approve_disposal($id = null) {
        $this->autoRender = false;
        if (!$id) {
            $this->Session->setFlash(__('Invalid id for return', true), '');
            $this->render('/elements/failure');
        }
		$user = $this->Session->read();	
        $return = array('ImsReturn' => array('id' => $id, 'disposal_approved_by' => $user['Auth']['User']['id'],'status' => 'disposed'));
        if ($this->ImsReturn->save($return)) {
            $this->Session->setFlash(__('Returned item disposal successfully approved', true), '');
            $this->render('/elements/success');
        } else {
            $this->Session->setFlash(__('Returned item disposal was not successfully approved', true), '');
            $this->render('/elements/failure');
        }
    }
}
?>