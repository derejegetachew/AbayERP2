<?php
class ImsSirvsController extends ImsAppController {

	var $name = 'ImsSirvs';
	
	function index() {
 
		$this->ImsSirv->ImsRequisition->recursive = -1;
		$ims_requisitions = $this->ImsSirv->ImsRequisition->find('all',array('conditions'=>array('ImsRequisition.status'=>'completed')));
   // $ims_requisitions = $this->ImsSirv->ImsRequisition->query("select * from ims_requisitions where status='completed'");
   
   // foreach($ims_requisitions as $r){
   //  var_dump($r);die();
   // }
    
		$this->set(compact('ims_requisitions'));
		
		$user = $this->Session->read();	
		$this->set('groups',$user['Auth']['Group']);
	}
	
	function index_1() {
		$user = $this->Session->read();	
		$this->set('groups',$user['Auth']['Group']);
		//////////////////////////////////////////
		$this->loadModel('Employee');
		$emp = $this->Employee->find('first',array('conditions'=>array('Employee.user_id'=>$user['Auth']['User']['id'])));
		$emp_details = $this->Employee->EmployeeDetail->find('first',array('conditions'=>array('EmployeeDetail.employee_id'=>$emp['Employee']['id']),'order'=>'EmployeeDetail.start_date DESC'));
		//////////////////////////////////////////
		$conditions = array('ImsRequisition.branch_id' => $emp_details['EmployeeDetail']['branch_id'],'ImsRequisition.status' => 'completed');		
		$requisitions = $this->ImsSirv->ImsRequisition->find('all',array('conditions' =>$conditions,'order'=>'ImsRequisition.name DESC'));
		
		$this->set(compact('requisitions'));
	}
	
	function index_2() {
		$this->ImsSirv->ImsRequisition->recursive = -1;
		$conditions = array('ImsRequisition.status' => 'completed');		
		$requisitions = $this->ImsSirv->ImsRequisition->find('all',array('conditions' =>$conditions,'order'=>'ImsRequisition.name DESC'));
		
		$this->set(compact('requisitions'));
	}
	
	function index2($id = null) {
		$this->set('parent_id', $id);
	}

	function search() {
	}
	
	function list_data($id = null) {
    $param='';
		$start = (isset($_REQUEST['start'])) ? $_REQUEST['start'] : 0;
		$limit = (isset($_REQUEST['limit'])) ? $_REQUEST['limit'] : 5;
		$imsrequisition_id = (isset($_REQUEST['imsrequisition_id'])) ? $_REQUEST['imsrequisition_id'] : -1;
		if($id)
			$imsrequisition_id = ($id) ? $id : -1;
        $conditions = (isset($_REQUEST['conditions'])) ? $_REQUEST['conditions'] : isset($_REQUEST['query']) ? $_REQUEST['query'] : '';
		
        eval("\$conditions = array( " . $conditions . " );");
		if ($imsrequisition_id != -1) {
            $conditions['ImsSirv.ims_requisition_id'] = $imsrequisition_id;
            $param=" and ims_requisition_id=".$imsrequisition_id;
        }		
		$this->ImsSirv->recursive = -1;
   
   if(isset($conditions["ImsSirv.name LIKE"])){
     //var_dump($conditions["ImsSirv.name LIKE"]);die();
     $param =$param . " and s.name like '". $conditions["ImsSirv.name LIKE"] . "'";
    }
    
   
  
   
   $cmd="SELECT s.id,
         s.name,r.name as request,s.created,s.modified,s.ims_requisition_id,s.status,b.name as branch
        FROM ims_sirvs s join ims_requisitions r
        on r.id=s.ims_requisition_id join branches b
               on b.id=r.branch_id  where 1=1     ". $param ." 
                limit ".$limit."
                offset ".$start." ";
                
                // var_dump($cmd);die();
        
   $ImsSirv=$this->ImsSirv->query($cmd);
   
   //foreach($ImsSirv as $s){
  //  var_dump($s);die();
  // };
   
		$this->set('ims_sirvs', $ImsSirv
      // $this->ImsSirv->find('all', array('conditions' => $conditions, 'limit' => $limit, 'offset' => $start, 'order'=>'ImsSirv.name DESC'))
    );
		$this->set('results', //count($ImsSirv)
    
     $this->ImsSirv->find('count', array('conditions' => $conditions))
    );
   
	}
	
	function list_data1($id = null) {
		$start = (isset($_REQUEST['start'])) ? $_REQUEST['start'] : 0;
		$limit = (isset($_REQUEST['limit'])) ? $_REQUEST['limit'] : 5;
		$imsrequisition_id = (isset($_REQUEST['imsrequisition_id'])) ? $_REQUEST['imsrequisition_id'] : -1;
		if($id)
			$imsrequisition_id = ($id) ? $id : -1;
        $conditions = (isset($_REQUEST['conditions'])) ? $_REQUEST['conditions'] : isset($_REQUEST['query']) ? $_REQUEST['query'] : '';
		
        eval("\$conditions = array( " . $conditions . " );");
		
		$this->ImsSirv->ImsRequisition->recursive = -1;
		$user = $this->Session->read();
		//////////////////////////////////////////
		$this->loadModel('Employee');
		$this->Employee->recursive = -1;
		$emp = $this->Employee->find('first',array('conditions'=>array('Employee.user_id'=>$user['Auth']['User']['id'])));
		$this->Employee->EmployeeDetail->recursive = -1;
		$emp_details = $this->Employee->EmployeeDetail->find('first',array('conditions'=>array('EmployeeDetail.employee_id'=>$emp['Employee']['id']),'order'=>'EmployeeDetail.start_date DESC'));
		
		//////////////////////////////////////////
		
		$conditionsr = array('ImsRequisition.branch_id' => $emp_details['EmployeeDetail']['branch_id'],'ImsRequisition.status' => 'completed');		
		$requisitions = $this->ImsSirv->ImsRequisition->find('all',array('conditions' =>$conditionsr));
		
		$reqarray = array();
		foreach($requisitions as $requisition){
			$reqarray[] = $requisition['ImsRequisition']['id'];
		}
		
		if ($imsrequisition_id != -1) {
            $conditions['ImsSirv.ims_requisition_id'] = $imsrequisition_id;
        }
		else if($imsrequisition_id == -1){			
			$conditions['ImsSirv.ims_requisition_id'] = $reqarray;
		}
		$this->ImsSirv->recursive = -1;
		$this->set('ims_sirvs', $this->ImsSirv->find('all', array('conditions' => $conditions,'order'=>'ImsSirv.name DESC', 'limit' => $limit, 'offset' => $start)));
		$this->set('results', $this->ImsSirv->find('count', array('conditions' => $conditions)));
	}
	
	function list_data2($id = null) {
		$start = (isset($_REQUEST['start'])) ? $_REQUEST['start'] : 0;
		$limit = (isset($_REQUEST['limit'])) ? $_REQUEST['limit'] : 5;
		$imsrequisition_id = (isset($_REQUEST['imsrequisition_id'])) ? $_REQUEST['imsrequisition_id'] : -1;
		if($id)
			$imsrequisition_id = ($id) ? $id : -1;
        $conditions = (isset($_REQUEST['conditions'])) ? $_REQUEST['conditions'] : isset($_REQUEST['query']) ? $_REQUEST['query'] : '';
		
        eval("\$conditions = array( " . $conditions . " );");
		
		$this->ImsSirv->ImsRequisition->recursive = -1;
		$conditionsr = array('ImsRequisition.status' => 'completed');		
		$requisitions = $this->ImsSirv->ImsRequisition->find('all',array('conditions' =>$conditionsr));
		
		$reqarray = array();
		foreach($requisitions as $requisition){
			$reqarray[] = $requisition['ImsRequisition']['id'];
		}
		
		$reqarray[] = 0;
		
		if ($imsrequisition_id != -1) {
            $conditions['ImsSirv.ims_requisition_id'] = $imsrequisition_id;
        }
		else if($imsrequisition_id == -1){			
			$conditions['ImsSirv.ims_requisition_id'] = $reqarray;
		}
		
		$this->set('ims_sirvs', $this->ImsSirv->find('all', array('conditions' => $conditions,'order'=>'ImsSirv.name DESC', 'limit' => $limit, 'offset' => $start)));
		$this->set('results', $this->ImsSirv->find('count', array('conditions' => $conditions)));
	}

	function view($id = null) {
		if (!$id) {
			$this->Session->setFlash(__('Invalid ims sirv', true));
			$this->redirect(array('action' => 'index'));
		}
		$this->ImsSirv->recursive = 2;
		$this->set('imsSirv', $this->ImsSirv->read(null, $id));
	}

	function add($id = null) {
		if (!empty($this->data)) {
			$this->ImsSirv->create();
			$this->autoRender = false;
			if ($this->ImsSirv->save($this->data)) {
				$this->Session->setFlash(__('The ims sirv has been saved', true), '');
				$this->render('/elements/success');
			} else {
				$this->Session->setFlash(__('The ims sirv could not be saved. Please, try again.', true), '');
				$this->render('/elements/failure');
			}
		}
		if($id)
			$this->set('parent_id', $id);
		$ims_requisitions = $this->ImsSirv->ImsRequisition->find('list');
		$this->set(compact('ims_requisitions'));
	}

	function edit($id = null, $parent_id = null) {
		if (!$id && empty($this->data)) {
			$this->Session->setFlash(__('Invalid ims sirv', true), '');
			$this->redirect(array('action' => 'index'));
		}
		if (!empty($this->data)) {
			$this->autoRender = false;
			if ($this->ImsSirv->save($this->data)) {
				$this->Session->setFlash(__('The ims sirv has been saved', true), '');
				$this->render('/elements/success');
			} else {
				$this->Session->setFlash(__('The ims sirv could not be saved. Please, try again.', true), '');
				$this->render('/elements/failure');
			}
		}
		$this->set('ims_sirv', $this->ImsSirv->read(null, $id));
		
		if($parent_id) {
			$this->set('parent_id', $parent_id);
		}
			
		$ims_requisitions = $this->ImsSirv->ImsRequisition->find('list');
		$this->set(compact('ims_requisitions'));
	}

	function delete($id = null) {
		$this->autoRender = false;
		if (!$id) {
			$this->Session->setFlash(__('Invalid id for ims sirv', true), '');
			$this->render('/elements/failure');
		}
		if (stripos($id, '_') !== false) {
            $ids = explode('_', $id);
            try{
                foreach ($ids as $i) {
                    $this->ImsSirv->delete($i);
                }
				$this->Session->setFlash(__('Ims sirv deleted', true), '');
				$this->render('/elements/success');
            }
            catch (Exception $e){
				$this->Session->setFlash(__('Ims sirv was not deleted', true), '');
				$this->render('/elements/failure');
            }
        } else {
            if ($this->ImsSirv->delete($id)) {
				$this->Session->setFlash(__('Ims sirv deleted', true), '');
				$this->render('/elements/success');
			} else {
				$this->Session->setFlash(__('Ims sirv was not deleted', true), '');
				$this->render('/elements/failure');
			}
        }
	}
	
	function add_grn_items($id = null){
	
		if (isset($_POST) and $_POST != null) {
			global $value;
			$id;
		    $item_code;
			$measurement;
			$quantity;
			$unit_price;
			$remark;
			
			$this->loadModel('ImsGrn');           
			
			$this->ImsGrn->create();
			date_default_timezone_set("Africa/Addis_Ababa");
			$count = 0;
			$value = $this->ImsGrn->find('first',array('conditions' => array('ImsGrn.name LIKE' => date("Ymd").'%'),'order'=>'ImsGrn.name DESC'));
			if($value != null){
				$value = explode('/',$value['ImsGrn']['name']);		
				$count = $value[1];
			}			
			$this->data['ImsGrn']['name'] = date("Ymd").'/'.str_pad(($count + 1), 3,'0',STR_PAD_LEFT);
			$this->data['ImsGrn']['status'] = 'approved';
			$user = $this->Session->read();
			$this->data['ImsGrn']['created_by'] = $user['Auth']['User']['id'];
			$this->data['ImsGrn']['approved_by'] = $user['Auth']['User']['id'];
			$this->ImsGrn->save($this->data);
			$lastid = $this->ImsGrn->getLastInsertId();
			
			foreach ($_POST as $key => $value) {			
				$tmpost = explode('^', $key);
				if($tmpost[1] == 'id')
				{
					$id = $value;
					$id = explode('"',$id);
				}
				else if($tmpost[1] == 'code')
				{
					$item_code = $value;
					$item_code = explode('"',$item_code);
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
					
					if($remark[0] != ""){		
						$remark = $remark[0];
					}
					else 
					$remark = $remark[1];
					
					$this->create_GRN($id[1],$item_code[1],$measurement[1],$quantity[1],$unit_price[1],$remark,$lastid);					
				}				
			}
			if($value == true){
				$this->Session->setFlash(__('SIRV Adjusted Successfully', true), '');
				$this->render('/elements/success');
			}
			else{
				$this->Session->setFlash(__('Unable to Adjust SIRV', true), '');
				$this->render('/elements/failure');
			}
		}
	}
	
	function create_GRN($id,$item_code,$measurement,$quantity,$unit_price,$remark,$lastid){
		global $value;
		
		$this->loadModel('ImsGrnItem');
		$this->loadModel('ImsCard');
		$this->loadModel('ImsItem');
		$this->loadModel('ImsStoresItem');
		
		$item = $this->ImsItem->find('first', array('conditions' => array('ImsItem.description' => $item_code)));
			
		$this->ImsGrnItem->create();
		$this->data['ImsGrnItem']['ims_grn_id'] = $lastid;
		$this->data['ImsGrnItem']['quantity'] = $quantity;
		$this->data['ImsGrnItem']['unit_price'] = $unit_price;
		$this->ImsGrnItem->save($this->data);
		$lastidGrnItem = $this->ImsGrnItem->getLastInsertId();
		
		$balance = 0;
		$conditionsB = array('ImsCard.ims_item_id' => $item['ImsItem']['id']);
		$cardB = $this->ImsCard->find('first', array('conditions' =>$conditionsB,'order'=>'ImsCard.id DESC'));
		if($cardB != null){
			$balance = $cardB['ImsCard']['balance'] + $quantity;
		}
		else{
			$balance = $quantity;
		}
		
		$conditionsstore = array('ImsCard.ims_sirv_item_id' => $id,'ImsCard.ims_grn_item_id' => 0);
		$cardstore = $this->ImsCard->find('first', array('conditions' =>$conditionsstore));
		
		$this->ImsCard->create();
		$card = array('ImsCard' => array());
		
		$card['ImsCard']['ims_grn_item_id'] = $lastidGrnItem;
		$card['ImsCard']['ims_sirv_item_id'] = $id;
		$card['ImsCard']['ims_item_id'] = $item['ImsItem']['id'];
		$card['ImsCard']['in_quantity'] = $quantity;
		$card['ImsCard']['out_quantity'] = 0;
		$card['ImsCard']['balance'] = $balance;
		$card['ImsCard']['in_unit_price'] = $unit_price;
		$card['ImsCard']['out_unit_price'] = 0;
		if($quantity > 0){
			$card['ImsCard']['status'] = 'A';
		}
		$card['ImsCard']['ims_store_id'] = $cardstore['ImsCard']['ims_store_id'];

		if($this->ImsCard->save($card))
		{	
			if($value != false){
				$value = true;
			}
			
			$conditions_store = array('ImsStoresItem.ims_item_id' => $item['ImsItem']['id'],'ImsStoresItem.ims_store_id' => $cardstore['ImsCard']['ims_store_id']);
			$storesitem = $this->ImsStoresItem->find('first', array('conditions' =>$conditions_store));
			//update store item balance							
			$this->ImsStoresItem->id = $storesitem['ImsStoresItem']['id'];
			$this->ImsStoresItem->saveField('balance', $storesitem['ImsStoresItem']['balance'] + $quantity);
		}
		else{
			$value = false;			
		}
	}
	
	function add_sirv_items($id = null){
		
		$this->loadModel('ImsRequisition');
		$requisition = $this->ImsRequisition->read(null, $id);
		if($requisition['ImsRequisition']['status'] == 'completed'){
			$this->Session->setFlash(__('SIRV already completed. please refresh the page', true), '');
			$this->render('/elements/failure');
		}
		else if($requisition['ImsRequisition']['status'] != 'completed'){
			global $items;
			global $serials;
			
			 $item_code;
			 $description;
			 $measurement;
			 $quantity;
			 $remark;
			 $serial;
			 
			 if (isset($_POST)) {
			 
				$this->ImsSirv->create();
				date_default_timezone_set("Africa/Addis_Ababa");
				$count = $this->ImsSirv->find('count',array('conditions' => array('ImsSirv.name LIKE' => date("Ymd").'%')));
				$this->data['ImsSirv']['name'] = date("Ymd").'/'.str_pad(($count + 1), 3,'0',STR_PAD_LEFT);
				$this->data['ImsSirv']['ims_requisition_id'] = $id;
				$this->data['ImsSirv']['status'] = 'completed';
				$this->ImsSirv->save($this->data);
				$lastid = $this->ImsSirv->getLastInsertId();
				
				
				$this->ImsRequisition->id = $id;
				$this->ImsRequisition->saveField('status', 'completed');
				
				$budget_year_id = $requisition['ImsRequisition']['budget_year_id'];
				$branch_id = $requisition['ImsRequisition']['branch_id'];
				$store_id = $requisition['ImsRequisition']['ims_store_id'];
				
				foreach ($_POST as $key => $value) {
					$tmpost = explode('^', $key);
					if($tmpost[1] == 'code')
					{
						$item_code = $value;					
					}
					else if($tmpost[1] == 'measurement')
					{
						$measurement = $value;
					}
					else if($tmpost[1] == 'quantity')
					{
						$quantity = $value;
					}
					else if($tmpost[1] == 'remark')
					{
						$remark = $value;						
					}
					else if($tmpost[1] == 'serial')
					{
						$serial = $value;
						//if($quantity > 0){
							$this->create_SIRV($item_code,$measurement,$quantity,$remark,$lastid,$budget_year_id,$branch_id,$store_id,$serial);	
						//}
					}
				}
				$this->loadModel('ImsSirvItem');
				$sirvitems = $this->ImsSirvItem->find('count', array('conditions' => array('ImsSirvItem.ims_sirv_id' => $lastid)));
				if($sirvitems == 0)
				{
					$this->ImsSirv->delete($lastid);
					$this->ImsRequisition->id = $id;
					$this->ImsRequisition->saveField('status', 'received');			
					$this->Session->setFlash(__('unable to complete SIRV because <br /> Balance is 0 for all items', true), '');
					$this->render('/elements/success');
				}
				else if($sirvitems > 0)
				{
					if ($items == null and $serials == null)
					{
						$this->Session->setFlash(__('SIRV completed Successfully', true), '');
						$this->render('/elements/success');
					}
					if ($items != null)
					{
						$this->Session->setFlash(__('SIRV completed <br /> Balance is 0 for '.$items, true), '');
						$this->render('/elements/success');
					}
					if ($serials != null)
					{
						$this->Session->setFlash(__('SIRV completed <br /> but not for the following item '.$serials, true), '');
						$this->render('/elements/failure');
					}
				}			
			 }
		}
	}	
	
	function create_SIRV($item_code,$measurement,$quantity,$remark,$lastid,$budget_year_id,$branch_id,$store_id,$serial)
	{
		global $items;
		global $serials;
		
		$code = explode('"', $item_code);
		$msr = explode('"', $measurement);
		$qnt = explode('"', $quantity);
		$rmk = explode('"', $remark);
		$srl = explode('"', $serial);
		
		//requested quantity
		//$qtt varibale is used to give tags for each items
		if($qnt[0] != ""){		
			$rq = $rrq =$qtt= $qnt[0];
		}

		else 
		$rq = $rrq =$qtt= $qnt[1];
		
		//read item last balance
		$this->loadModel('ImsCard');
		$this->loadModel('ImsItem');
		$this->loadModel('ImsStoresItem');
		$this->loadModel('ImsSirvItem');
		$this->loadModel('ImsTag');
		$this->loadModel('Branch');
		
		$item = $this->ImsItem->find('first', array('conditions' => array('ImsItem.description' => $code[1])));
		// print_r($item);
		
		if($item['ImsItem']['ims_item_category_id'] == 30 and $srl[1] == "")
		{
			$serials = $serials . $item['ImsItem']['name'].', ';
		}

		else 
		{
			$conditions = array('ImsCard.ims_item_id' => $item['ImsItem']['id']);
			$card = $this->ImsCard->find('first', array('conditions' =>$conditions,'order'=>'ImsCard.id DESC'));
			$tb = $lb = $card['ImsCard']['balance'];
			
			///////////  check store balance   /////////////////////////////////
			$conditions_store = array('ImsStoresItem.ims_item_id' => $item['ImsItem']['id'],'ImsStoresItem.ims_store_id' => $store_id);
			$storesitem = $this->ImsStoresItem->find('first', array('conditions' =>$conditions_store));
			
			if($storesitem['ImsStoresItem']['balance'] != null and $storesitem['ImsStoresItem']['balance'] > 0)
			{
				if($rq > $storesitem['ImsStoresItem']['balance']){
					$rq = $storesitem['ImsStoresItem']['balance'];
					$rrq = $rq;
				}
			
			
				//read the last n incoming items which are not in 'D' states in descending order of their created
				$value = array("NOT"=>array('ImsCard.status'=>array('D','')));
				$conditions_item = array('ImsCard.ims_item_id' => $item['ImsItem']['id'],'ImsCard.in_quantity !=' => 0,$value);
				$in_items = $this->ImsCard->find('all', array('conditions' =>$conditions_item,'order'=>'ImsCard.id DESC'));
				
				if(empty($in_items)){
					$items = $items . $item['ImsItem']['name'].', ';
				}
				else if(!empty($in_items))
				{
					foreach($in_items as $in_item)
					{
						
						if($in_item['ImsCard']['in_quantity'] < $lb)
						{
						
							//there is at least one record above
							$lb = $lb - $in_item['ImsCard']['in_quantity'];
							if($lb < $rq)
							 {	
								if($rrq > $tb)
								{
									$rrq = $tb;
								}
								$q = $rrq - $lb;
								if($q > $tb)
								{
									$q = $tb;
								}
								$balance = $tb - $q;
								if($balance < 0)
								{
									$balance = 0;
								}
								$rrq = $rrq - $q;
								
								//make record of sirv item
								
								$this->ImsSirvItem->create();
								$this->data['ImsSirvItem']['ims_sirv_id'] = $lastid;
								$this->data['ImsSirvItem']['ims_item_id'] = $in_item['ImsCard']['ims_item_id'];
								$this->data['ImsSirvItem']['measurement'] = $msr[1];
								$this->data['ImsSirvItem']['quantity'] = $q;
								$this->data['ImsSirvItem']['unit_price'] = $in_item['ImsCard']['in_unit_price'];
								$this->data['ImsSirvItem']['remark'] = $rmk[1];
								$this->data['ImsSirvItem']['serial'] = $srl[1];
								$this->data['ImsSirvItem']['grn_date'] = $in_item['ImsCard']['created'];
								$this->ImsSirvItem->save($this->data);
								$lastid_sirv = $this->ImsSirvItem->getLastInsertId();
								
												
								//make record of card						
								$this->ImsCard->create();
								$this->data['ImsCard']['ims_item_id'] = $in_item['ImsCard']['ims_item_id'];
								$this->data['ImsCard']['ims_sirv_item_id'] = $lastid_sirv;
								$this->data['ImsCard']['out_quantity'] = $q;
								$this->data['ImsCard']['out_unit_price'] = $in_item['ImsCard']['in_unit_price'];
								$this->data['ImsCard']['balance'] = $balance;
								$this->data['ImsCard']['ims_store_id'] = $store_id;
								$this->ImsCard->save($this->data);
								
								//update the incoming item status
								$tb = $tb - $q;					
								if($tb > 0)
								{
									$this->ImsCard->id = $in_item['ImsCard']['id'];
									$this->ImsCard->saveField('status', 'S');								
								}
								else if($tb <= 0)
								{						
									$this->ImsCard->id = $in_item['ImsCard']['id'];
									$this->ImsCard->saveField('status', 'D');
								}
								
								//update budget
								$this->loadModel('ImsBudget');
								$conditions_budget = array('ImsBudget.budget_year_id' => $budget_year_id, 'ImsBudget.branch_id' => $branch_id);
								$budget = $this->ImsBudget->find('first', array('conditions' =>$conditions_budget));
								if(count($budget) > 0)
								{
									$this->loadModel('ImsBudgetItem');
									$conditions_budget_items = array('ImsBudgetItem.ims_budget_id' => $budget['ImsBudget']['id'], 'ImsBudgetItem.ims_item_id' => $in_item['ImsCard']['ims_item_id']);
									$budget_item = $this->ImsBudgetItem->find('first', array('conditions' =>$conditions_budget_items));
									if(count($budget_item) > 0)
									{
										$this->ImsBudgetItem->id = $budget_item['ImsBudgetItem']['id'];
										$this->ImsBudgetItem->saveField('used', $q + $budget_item['ImsBudgetItem']['used']);
									}
								}
								
								//update store item balance							
								$this->ImsStoresItem->id = $storesitem['ImsStoresItem']['id'];
								$this->ImsStoresItem->saveField('balance', $storesitem['ImsStoresItem']['balance'] - $q);
								
								
								//make record of tag
								if (!empty($item) && isset($item['ImsItem']['tag_code'])) {
									$branch = $this->Branch->read(null, $branch_id);
								
									// Insert multiple tags if the issued quantity is more than one.
									for ($t = 0; $t < $qtt; $t++) {
										$tag = "AB/" . $branch['Branch']['tag_code'] . "-" . $item['ImsItem']['tag_code'] . "-";
										$conditions_tag = array('ImsTag.code LIKE' => $tag . "%");
										$tag_result = $this->ImsTag->find('first', array('conditions' => $conditions_tag, 'order' => array('ImsTag.code DESC')));
								
										if (!empty($tag_result)) {
											$tag_value = end(explode('-', $tag_result['ImsTag']['code']));
											$tag_value = preg_replace('/[\n\r]/', '', $tag_value);
											$tag_value = preg_replace('/\s+/', '', $tag_value);
											$tag_value = $tag_value + 1;
											$tag = $tag . sprintf("%03d", $tag_value);
										} else {
											$tag = $tag . "001";
										}
								
										$this->ImsTag->create();
										$this->data['ImsTag']['ims_sirv_item_id'] = $lastid_sirv;
										$this->data['ImsTag']['code'] = $tag;
										$this->ImsTag->save($this->data);
									}
								}
						







                                                   
                                                   
							}
						}else {			
							$q = $rrq;
							if($q > $tb){
								$q = $tb;
							}
							$balance = $tb - $q;
							if($balance < 0){
								$balance = 0;
							}
							$rrq = $rrq - $q;
							//make record of sirv item
							
							$this->ImsSirvItem->create();
							$this->data2['ImsSirvItem']['ims_sirv_id'] = $lastid;
							$this->data2['ImsSirvItem']['ims_item_id'] = $in_item['ImsCard']['ims_item_id'];
							$this->data2['ImsSirvItem']['measurement'] = $msr[1];
							$this->data2['ImsSirvItem']['quantity'] = $q;
							$this->data2['ImsSirvItem']['unit_price'] = $in_item['ImsCard']['in_unit_price'];
							$this->data2['ImsSirvItem']['remark'] = $rmk[1];
							$this->data2['ImsSirvItem']['serial'] = $srl[1];
							$this->data2['ImsSirvItem']['grn_date'] = $in_item['ImsCard']['created'];
							$this->ImsSirvItem->save($this->data2);
							$lastid_sirv = $this->ImsSirvItem->getLastInsertId();					
							
							
							//make record of card					
							$this->ImsCard->create();
							$this->data['ImsCard']['ims_item_id'] = $in_item['ImsCard']['ims_item_id'];
							$this->data['ImsCard']['ims_sirv_item_id'] = $lastid_sirv;
							$this->data['ImsCard']['out_quantity'] = $q;
							$this->data['ImsCard']['out_unit_price'] = $in_item['ImsCard']['in_unit_price'];
							$this->data['ImsCard']['balance'] = $balance;
							$this->data['ImsCard']['ims_store_id'] = $store_id;
							$this->ImsCard->save($this->data);
							
							//update the incoming item status
							$lb = $lb - $q;
							if($lb > 0){
								$this->ImsCard->id = $in_item['ImsCard']['id'];
								$this->ImsCard->saveField('status', 'S');
							}else if($lb <= 0){
								$this->ImsCard->id = $in_item['ImsCard']['id'];
								$this->ImsCard->saveField('status', 'D');
							}						
							
							//update budget
							$this->loadModel('ImsBudget');
							$conditions_budget = array('ImsBudget.budget_year_id' => $budget_year_id, 'ImsBudget.branch_id' => $branch_id);
							$budget = $this->ImsBudget->find('first', array('conditions' =>$conditions_budget));
							if(count($budget) > 0){
								$this->loadModel('ImsBudgetItem');
								$conditions_budget_items = array('ImsBudgetItem.ims_budget_id' => $budget['ImsBudget']['id'], 'ImsBudgetItem.ims_item_id' => $in_item['ImsCard']['ims_item_id']);
								$budget_item = $this->ImsBudgetItem->find('first', array('conditions' =>$conditions_budget_items));
								if(count($budget_item) > 0){
									$this->ImsBudgetItem->id = $budget_item['ImsBudgetItem']['id'];
									$this->ImsBudgetItem->saveField('used', $q + $budget_item['ImsBudgetItem']['used']);
								}
							}
							
							//update store item balance							
							$this->ImsStoresItem->id = $storesitem['ImsStoresItem']['id'];
							$this->ImsStoresItem->saveField('balance', $storesitem['ImsStoresItem']['balance'] - $q);
							
							
							//make record of tag
							if($item['ImsItem']['tag_code'] != null)
							{
								$branch = $this->Branch->read(null,$branch_id);
								// modified code to create tag
								for ($t = 0; $t < $qtt; $t++) {

								$tag = "AB/" . $branch['Branch']['tag_code'] . "-" . $item['ImsItem']['tag_code'] . "-";
								$conditions_tag = array('ImsTag.code LIKE' => $tag."%");
								$tag_result = $this->ImsTag->find('first', array('conditions' =>$conditions_tag, 'order'=>array('ImsTag.code DESC')));
								if(!empty($tag_result))
								{
									$tag_value = end(explode('-',$tag_result['ImsTag']['code']));
									$tag_value = preg_replace('/[\n\r]/','',$tag_value);
									$tag_value = preg_replace('/\s+/','',$tag_value);
									$tag_value = $tag_value + 1;
									$tag =  $tag . sprintf("%03d", $tag_value);
								}
								else $tag = $tag . "001";
								
								$this->ImsTag->create();
								$this->data['ImsTag']['ims_sirv_item_id'] = $lastid_sirv;
								$this->data['ImsTag']['code'] = $tag;
								
								$this->ImsTag->save($this->data);

							}
							}
						}
					}
				}


			}



		}





	}

	
	function getbranch(){
		$id = $this->params['branchid'];
		$this->loadModel('Branch');
		$branch = $this->Branch->read(null,$id);
		return $branch['Branch']['name']; 
	}
	
	function getrequisition(){
		$id = $this->params['requisitionid'];
		$this->loadModel('ImsRequisition');
		$requisition = $this->ImsRequisition->read(null,$id);
		return $requisition['ImsRequisition']['name']; 
	}
	
	function print_sirv($id = null){
        $this->layout = 'print_layout';
        
        if (!$id) {
            $this->autoRender = false;
            $this->Session->setFlash(__('Invalid id for sirv', true), '');
            $this->render('/elements/failure');
        }
        
        $this->ImsSirv->recursive = 3;
        //var_dump($this->ImsSirv->read(null, $id));die;
        $this->set('sirv', $this->ImsSirv->read(null, $id));
    }
	
	function print_sirv1($id = null){
        $this->layout = 'print_layout';
        
        if (!$id) {
            $this->autoRender = false;
            $this->Session->setFlash(__('Invalid id for sirv', true), '');
            $this->render('/elements/failure');
        }
        $this->ImsSirv->recursive = 1;
		$sirv = $this->ImsSirv->read(null, $id);
        $this->set('sirv', $sirv);
		
		$sirvArray = array();
		$this->loadModel('ImsCard');
		$this->ImsCard->recursive = -1; 
		foreach($sirv['ImsSirvItem'] as $sirv_item) {
			$conditions = array('ImsCard.ims_sirv_item_id' => $sirv_item['id'],'ImsCard.ims_grn_item_id !=' => 0);
			$card = $this->ImsCard->find('all', array('conditions' =>$conditions));
			if($card != null)
			{
				$sirvArray[] = $sirv_item;
			}
		}
		
		$this->set('sirvArray', $sirvArray);
    }
	
	function getitem()
	{
		$id = $this->params['itemid'];
		$this->loadModel('ImsItem');
		$this->ImsItem->recursive =-1;
		$item = $this->ImsItem->read(null,$id);
		return $item['ImsItem']; 
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
	
	function getgrn($id =null)
	{
		$id = $this->params['sirvitemid'];
		$this->loadModel('ImsCard');
		$this->ImsCard->recursive = 1;			
		$conditions =array('ImsCard.ims_sirv_item_id' => $id, 'ImsCard.in_quantity !=' => 0);  						 
		$card = $this->ImsCard->find('first', array('conditions' => $conditions));
		return $card['ImsCard']; 
	}
	
	function getUser(){
		$userid = $this->params['userid'];	
		$this->loadModel('User');
		$conditions = array('User.id' => $userid);
		$this->User->recursive = 0;
		$user = $this->User->find('first',array('conditions' => $conditions));	
		return $user;
	}
	
	function getbranchname(){
	
		$id = $this->params['requisitionid'];
		$this->loadModel('ImsRequisition');
		$this->ImsRequisition->recursive = 0;
		$requisition = $this->ImsRequisition->read(null,$id);
		return $requisition['Branch']['name']; 	
		
	}
}
?>