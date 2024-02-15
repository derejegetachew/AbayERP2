<?php

class ImsCardsController extends ImsAppController {

    var $name = 'ImsCards';

    function index() {
        $items = $this->ImsCard->ImsItem->find('all');
        $this->set(compact('items'));
    }

    function index2($id = null) {
        $this->set('parent_id', $id);
    }

    function index_stock_card($id = null) {
        $this->set('parent_id', $id);
		
		$item = $this->ImsCard->ImsItem->find('first', array(
        'conditions' => array('ImsItem.id' => $id)
        ));
		
		$this->set('item',$item['ImsItem']['name']);	
    }

    function index_bin_card($id = null) {
        $this->set('parent_id', $id);
		
		//$total_balance = $this->ImsCard->find('all', array(
		  //'fields' => array(
			//'SUM(ImsCard.balance) AS total_balance'
		  //),
		  //'conditions' => array('ImsCard.ims_item_id' => $id)
		//));
		
		$total_balance = $this->ImsCard->find('first', array(
        'conditions' => array('ImsCard.ims_item_id' => $id),'order' => 'ImsCard.created DESC'));
		
		//	pr($total_balance);
		$this->set('total_balance', $total_balance['ImsCard']['balance']);
		
		$item = $this->ImsCard->ImsItem->find('first', array(
        'conditions' => array('ImsItem.id' => $id)
        ));
		
		$this->set('item',$item['ImsItem']['name']);		
    }
	
	function index_ending_balance($id = null) {
      
    }
	
	function index_sirv_by_branch($id = null) {
	    $this->loadModel('Branch');
	    $branches = $this->Branch->find('all');
	  
		$this->loadModel('ImsItemCategory'); 
		$this->ImsItemCategory->recursive =-1;			
		$conditions =array('ImsItemCategory.parent_id' => 1);  			
		$itemcategory = $this->ImsItemCategory->find('all', array('conditions' => $conditions));
		
	    $this->set(compact('branches','itemcategory'));
    }
	
	function index_sirv_grn_by_category($id = null) { 
		$this->loadModel('ImsItemCategory'); 
		$this->ImsItemCategory->recursive =-1;			
		$conditions =array('ImsItemCategory.parent_id' => 1);  			
		$itemcategory = $this->ImsItemCategory->find('all', array('conditions' => $conditions));
		
	    $this->set('itemcategory',$itemcategory);
    }
	
	function index_balance_by_category($id = null) { 
		$this->loadModel('ImsItemCategory'); 
		$this->ImsItemCategory->recursive =-1;			
		$conditions =array('ImsItemCategory.parent_id' => 1);  			
		$itemcategory = $this->ImsItemCategory->find('all', array('conditions' => $conditions));
		
	    $this->set('itemcategory',$itemcategory);
    }
	
	function index_min_max_by_category($id = null) { 
		$this->loadModel('ImsItemCategory'); 
		$this->ImsItemCategory->recursive =-1;			
		$conditions =array('ImsItemCategory.parent_id' => 1);  			
		$itemcategory = $this->ImsItemCategory->find('all', array('conditions' => $conditions));
		
	    $this->set('itemcategory',$itemcategory);
    }

    function search() {
        
    }

    function list_data($id = null) {
        $start = (isset($_REQUEST['start'])) ? $_REQUEST['start'] : 0;
        $limit = (isset($_REQUEST['limit'])) ? $_REQUEST['limit'] : 5;
        $item_id = (isset($_REQUEST['item_id'])) ? $_REQUEST['item_id'] : -1;
        if ($id)
            $item_id = ($id) ? $id : -1;
        $conditions = (isset($_REQUEST['conditions'])) ? $_REQUEST['conditions'] : '';

        eval("\$conditions = array( " . $conditions . " );");
        if ($item_id != -1) {
            $conditions['ImsCard.ims_item_id'] = $item_id;
        }

        $this->set('cards', $this->ImsCard->find('all', array('conditions' => $conditions, 'limit' => $limit, 'offset' => $start, 'order' => 'ImsCard.created ASC')));
        $this->set('results', $this->ImsCard->find('count', array('conditions' => $conditions)));
    }

    function list_data_stock_cards($id = null) {
        $start = (isset($_REQUEST['start'])) ? $_REQUEST['start'] : 0;
        $limit = (isset($_REQUEST['limit'])) ? $_REQUEST['limit'] : 20;
        $item_id = (isset($_REQUEST['item_id'])) ? $_REQUEST['item_id'] : -1;
        if ($id)
            $item_id = ($id) ? $id : -1;
        $conditions = (isset($_REQUEST['conditions'])) ? $_REQUEST['conditions'] : '';

        eval("\$conditions = array( " . $conditions . " );");
        if ($item_id != -1) {
            $cond[0]['ImsCard.ims_item_id'] = $item_id;
			$cond[0]['ImsCard.ims_grn_item_id'] = 0;
			
			$cond[1]['ImsCard.status !='] = '';
			$cond[1]['ImsCard.ims_grn_item_id !='] = 0;
			$cond[1]['ImsCard.ims_item_id'] = $item_id;
			
			$conditions = array("OR" => $cond);
        }
		$this->ImsCard->recursive = 2;
		$cards = $this->ImsCard->find('all', array('conditions' => $conditions, 'limit' => $limit, 'offset' => $start, 'order' => 'ImsCard.id ASC'));
		$mcards = array();
		$last_sum = 0;
		$sums = array();
		$cur_page = 1;
		if($this->Session->check('sums')) {
			$sums = $this->Session->read('sums');
			$cur_page = ($start + $limit) / $limit;
			$last_sum = isset($sums[$cur_page - 1])? $sums[$cur_page - 1]: 0;
		}
		
		$balance = $last_sum;
		$count = 0;
		foreach($cards as $card) {
			$total_price = '';
			if($card['ImsCard']['in_quantity'] != 0){
				$total_price = number_format($card['ImsCard']['in_quantity'] * $card['ImsCard']['in_unit_price'] , 4 , '.' , ',' ); 
			} else {
				$total_price = number_format($card['ImsCard']['out_quantity'] * $card['ImsCard']['out_unit_price'] , 4 , '.' , ',' );
			}
			// balance in birr
			$balance_in_birr = '';
			if($card['ImsCard']['in_quantity'] != 0){			
				$balance = $balance + ($cards[$count]['ImsCard']['in_quantity'] * $cards[$count]['ImsCard']['in_unit_price']);				
				$balance_in_birr = number_format($balance, 4 , '.' , ',');				
				$count++;
			} else {
				$balance = $balance - ($cards[$count]['ImsCard']['out_quantity'] * $cards[$count]['ImsCard']['out_unit_price']);
				$balance_in_birr = number_format($balance, 4 , '.' , ',');		
				$count++;
			}
			// end of balance in birr
			
			//purchase order
			$purchase_order_id = '';
			if($card['ImsCard']['ims_grn_item_id'] != 0){
				if($card['ImsGrnItem']['ImsGrn']['ims_purchase_order_id'] == 0){
					$purchase_order_id = '<font color=red>Adjustment</font>'; 
				}
			}
			//end of purchase order
			//grn sirv
			$grn_sirv = '';
			if($card['ImsCard']['ims_grn_item_id'] != 0 and $card['ImsCard']['ims_sirv_item_id'] != 0){
				$grn_sirv = '<font color=red>'.$card['ImsSirvItem']['ImsSirv']['name'].'</font>';
			}
			else if($card['ImsCard']['ims_grn_item_id'] != 0){
			  $grn_sirv = $card['ImsGrnItem']['ImsGrn']['name'];
			}
			else {
				$grn_sirv = $card['ImsSirvItem']['ImsSirv']['name'];
			}
			//end of grn sirv
			$mcards[] = array(
				'ImsCard' => array(
					'id' => $card['ImsCard']['id'],
					'item' => $card['ImsItem']['name'] . ' - ' . $card['ImsItem']['description'],
					'grn_sirv_no' => $grn_sirv,
					'in_quantity' => $card['ImsCard']['in_quantity'] != 0? $card['ImsCard']['in_quantity']: '',
					'out_quantity' => $card['ImsCard']['out_quantity'] != 0? $card['ImsCard']['out_quantity']: '',
					'unit_price' => $card['ImsCard']['in_unit_price'] != 0.00? $card['ImsCard']['in_unit_price']:$card['ImsCard']['out_unit_price'],
					'balance' => $card['ImsCard']['balance'],					
					'total_price' => $total_price,
					'out_unit_price' => $card['ImsCard']['out_unit_price'],
					'balance_in_birr' => $balance_in_birr,
					'created' => $card['ImsCard']['created'],
					'modified' => $card['ImsCard']['modified'],
					'purchase_order_id' => $purchase_order_id
				)
			);
		}
		$sums[$cur_page] = $balance;
		$this->Session->write('sums', $sums);
		
        $this->set('cards', $mcards);
		$this->set('results', $this->ImsCard->find('count', array('conditions' => $conditions)));
    }

    function list_data_bin_cards($id = null) {
        $start = (isset($_REQUEST['start'])) ? $_REQUEST['start'] : 0;
        $limit = (isset($_REQUEST['limit'])) ? $_REQUEST['limit'] : 20;
        $item_id = (isset($_REQUEST['item_id'])) ? $_REQUEST['item_id'] : -1;
        if ($id)
            $item_id = ($id) ? $id : -1;
        $conditions = (isset($_REQUEST['conditions'])) ? $_REQUEST['conditions'] : '';

        eval("\$conditions = array( " . $conditions . " );");
        if ($item_id != -1) {
            $cond[0]['ImsCard.ims_item_id'] = $item_id;
			$cond[0]['ImsCard.ims_grn_item_id'] = 0;
			
			$cond[1]['ImsCard.status !='] = '';
			$cond[1]['ImsCard.ims_grn_item_id !='] = 0;
			$cond[1]['ImsCard.ims_item_id'] = $item_id;
			
			$conditions = array("OR" => $cond);
        }
		$this->ImsCard->recursive = 2;
        $cards = $this->ImsCard->find('all', array('conditions' => $conditions, 'limit' => $limit, 'offset' => $start));

        $this->set('cards', $cards);
        $this->set('results', $this->ImsCard->find('count', array('conditions' => $conditions)));
    }

    function view($id = null) {
        if (!$id) {
            $this->Session->setFlash(__('Invalid card', true));
            $this->redirect(array('action' => 'index'));
        }
        $this->ImsCard->recursive = 2;
        $this->set('card', $this->ImsCard->read(null, $id));
    }

    function add($id = null) {
        if (!empty($this->data)) {
            $this->ImsCard->create();
            $this->autoRender = false;
            if ($this->ImsCard->save($this->data)) {
                $this->Session->setFlash(__('The card has been saved', true), '');
                $this->render('/elements/success');
            } else {
                $this->Session->setFlash(__('The card could not be saved. Please, try again.', true), '');
                $this->render('/elements/failure');
            }
        }
        if ($id)
            $this->set('parent_id', $id);
        $items = $this->ImsCard->ImsItem->find('list');
        $grns = $this->ImsCard->ImsGrn->find('list');
        $this->set(compact('items', 'grns'));
    }
	
	function display($id = null) {
		$this->layout = 'ajax';
        if (!empty($this->data)) {
			$fromdate=$this->data['ImsCard']['from'];
			$todate =$this->data['ImsCard']['to'];
			$date1 = str_replace('-', '/', $todate);
			$tomorrow = date('Y-m-d',strtotime($date1 . "+1 days"));
			$date2 = str_replace('-', '/', $fromdate);
			$yesterday = date('Y-m-d',strtotime($date2 . "+1 days"));			

			$this->loadModel('ImsItemCategory'); 
			$this->ImsItemCategory->recursive =-1;
			
			$conditions =array('ImsItemCategory.parent_id' => 1);  
						 
			$itemcategory = $this->ImsItemCategory->find('all', array('conditions' => $conditions));
			
			$result = array();
			for($j=0;$j<count($itemcategory );$j++){
						$itemcategory [$j]['child'] = $this->getChild($itemcategory [$j]['ImsItemCategory']['id']);			
					$itemcategory [$j]['child'][] = $itemcategory[$j];
						
	/////////////////////  CARD  ///////////////////////////////////////////////////////////////////////////////////////////////////
				$previousMonthEndingBalanceTotalCost = 0;
				$currentMonthGRNTotalCost = 0;
				$currentMonthSIRVTotalCost = 0;				
				
				foreach ($itemcategory [$j]['child'] as $child)
				{
					$this->loadModel('ImsItem');
					$conditionsItem =array('ImsItem.ims_item_category_id' => $child['ImsItemCategory']['id']);
					$items = $this->ImsItem->find('all', array('conditions' => $conditionsItem));
					foreach ($items as $item)
					{
						$conditions =array('ImsCard.created <' => $yesterday,'ImsCard.ims_item_id' => $item['ImsItem']['id']);
						$previousMonthEndingBalance = $this->ImsCard->find('all', array('conditions' => $conditions,'order' => 'ImsCard.created ASC'));
						
						$totalprice =0;
						for($i =0; $i<count($previousMonthEndingBalance); $i++){
							if($previousMonthEndingBalance[$i]['ImsCard']['ims_grn_item_id'] != 0){								
								$totalprice = $totalprice + ($previousMonthEndingBalance[$i]['ImsCard']['in_quantity'] * $previousMonthEndingBalance[$i]['ImsCard']['in_unit_price']);
							}
							else if($cards[$i]['ImsCard']['ims_grn_item_id'] == 0){	
								$totalprice = $totalprice - ($previousMonthEndingBalance[$i]['ImsCard']['out_quantity'] * $previousMonthEndingBalance[$i]['ImsCard']['out_unit_price']);
							}
						}						
						
						$previousMonthEndingBalanceTotalCost = $previousMonthEndingBalanceTotalCost + $totalprice;
						
						$conditionsGRN =array('ImsCard.created >=' => $fromdate,'ImsCard.created <' => $tomorrow,'ImsCard.ims_item_id' => $item['ImsItem']['id'],
						'ImsCard.ims_grn_item_id !=' => 0);
						$currentMonthGRN = $this->ImsCard->find('all', array('conditions' => $conditionsGRN));
							foreach($currentMonthGRN as $cMGRN){
								$GRNcost = $cMGRN['ImsCard']['in_quantity'] * $cMGRN['ImsCard']['in_unit_price'];
								$currentMonthGRNTotalCost = $currentMonthGRNTotalCost + $GRNcost;
							}							
						
						$conditionsSIRV =array('ImsCard.created >=' => $fromdate,'ImsCard.created <' => $tomorrow,'ImsCard.ims_item_id' => $item['ImsItem']['id'],
						'ImsCard.ims_grn_item_id' => 0);
						$currentMonthSIRV = $this->ImsCard->find('all', array('conditions' => $conditionsSIRV));
						foreach($currentMonthSIRV as $cMSIRV){
							$SIRVcost = $cMSIRV['ImsCard']['out_quantity'] * $cMSIRV['ImsCard']['out_unit_price'];
							$currentMonthSIRVTotalCost = $currentMonthSIRVTotalCost + $SIRVcost;
						}
					}						
				}	
   /////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
				$result[0][$j+1] = $itemcategory [$j]['ImsItemCategory']['name'];
				$result[1][$j+1] = $previousMonthEndingBalanceTotalCost;
				$result[2][$j+1] = $currentMonthGRNTotalCost;
				$result[3][$j+1] = $currentMonthSIRVTotalCost;
				$result[4][$j+1] = $previousMonthEndingBalanceTotalCost + $currentMonthGRNTotalCost - $currentMonthSIRVTotalCost;
			}
				$date1 = str_replace('-', '/', $fromdate);
				$yesterday = date('Y-m-d',strtotime($date1 . "-1 days"));
				$this->set('date',$yesterday);
				$this->set('from',$fromdate);
				$this->set('to',$todate);
				$this->set('result',$result);
        }			
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

    function edit($id = null, $parent_id = null) {
        if (!$id && empty($this->data)) {
            $this->Session->setFlash(__('Invalid card', true), '');
            $this->redirect(array('action' => 'index'));
        }
        if (!empty($this->data)) {
            $this->autoRender = false;
            if ($this->ImsCard->save($this->data)) {
                $this->Session->setFlash(__('The card has been saved', true), '');
                $this->render('/elements/success');
            } else {
                $this->Session->setFlash(__('The card could not be saved. Please, try again.', true), '');
                $this->render('/elements/failure');
            }
        }
        $this->set('card', $this->ImsCard->read(null, $id));

        if ($parent_id) {
            $this->set('parent_id', $parent_id);
        }

        $items = $this->ImsCard->ImsItem->find('list');
        $grns = $this->ImsCard->ImsGrn->find('list');
        $this->set(compact('items', 'grns'));
    }

    function delete($id = null) {
        $this->autoRender = false;
        if (!$id) {
            $this->Session->setFlash(__('Invalid id for card', true), '');
            $this->render('/elements/failure');
        }
        if (stripos($id, '_') !== false) {
            $ids = explode('_', $id);
            try {
                foreach ($ids as $i) {
                    $this->ImsCard->delete($i);
                }
                $this->Session->setFlash(__('Card deleted', true), '');
                $this->render('/elements/success');
            } catch (Exception $e) {
                $this->Session->setFlash(__('Card was not deleted', true), '');
                $this->render('/elements/failure');
            }
        } else {
            if ($this->ImsCard->delete($id)) {
                $this->Session->setFlash(__('Card deleted', true), '');
                $this->render('/elements/success');
            } else {
                $this->Session->setFlash(__('Card was not deleted', true), '');
                $this->render('/elements/failure');
            }
        }
    }
	
	function getSupplier(){
		$grnitemid = $this->params['grnitemid'];
		
		$this->loadModel('ImsGrnItem');
		$conditions = array('ImsGrnItem.id' => $grnitemid);
		$this->ImsGrnItem->recursive = 2;
		$grnitem = $this->ImsGrnItem->find('first',array('conditions' => $conditions));
		
		return $grnitem;
	}
	
	function getUser(){
		$sirvitemid = $this->params['sirvitemid'];
		
		$this->loadModel('ImsSirvItem');
		$conditions = array('ImsSirvItem.id' => $sirvitemid);
		$this->ImsGrnItem->recursive = 2;
		$sirvitem = $this->ImsSirvItem->find('first',array('conditions' => $conditions));
		
		$this->loadModel('ImsRequisition');
		$conditions = array('ImsRequisition.id' => $sirvitem['ImsSirv']['ims_requisition_id']);
		$this->ImsRequisition->recursive = 2;
		$requisition = $this->ImsRequisition->find('first',array('conditions' => $conditions));
		
		$this->loadModel('User');
		$conditions = array('User.id' => $requisition['ImsRequisition']['requested_by']);
		$this->User->recursive = 2;
		$user = $this->User->find('first',array('conditions' => $conditions));		
		return $user;
	}
	
	function sirv_by_branch($id = null) {
		$this->layout = 'ajax';		
		
        if (!empty($this->data)) {
            $fromdate=$this->data['ImsCard']['from'];
			$todate =$this->data['ImsCard']['to'];
			$date1 = str_replace('-', '/', $todate);
			$tomorrow = date('Y-m-d',strtotime($date1 . "+1 days"));			
			
			$this->loadModel('ImsItemCategory'); 
			$this->ImsItemCategory->recursive =-1;			
			$conditions =array('ImsItemCategory.id' => $this->data['ImsCard']['category']);  						 
			$itemcategory = $this->ImsItemCategory->find('all', array('conditions' => $conditions));
			
			$this->loadModel('ImsSirv');
			$this->ImsSirv->recursive = 1;	
			$conditionssirv =array('ImsSirv.created >=' => $fromdate,'ImsSirv.created <' => $tomorrow);
			$sirvs = $this->ImsSirv->find('all', array('conditions' => $conditionssirv));
			
			$this->loadModel('Branch');	
			$this->Branch->recursive =-1;
			$branches = $this->Branch->find('all',array('order' => 'Branch.name ASC'));	
			
			$result = array();
			$count = 0;
			$branchName = '';
			$datevalue = '';
			$sirvnumber = '';
			for($j=0;$j<count($itemcategory );$j++){
						$itemcategory [$j]['child'] = $this->getChild($itemcategory [$j]['ImsItemCategory']['id']);			
					$itemcategory [$j]['child'][] = $itemcategory[$j];
						
	/////////////////////  SIRV  ///////////////////////////////////////////////////////////////////////////////////////////////////
			foreach($branches as $branch){
				for($i=0;$i<count($sirvs);$i++)
				{
					if($branch['Branch']['id'] ==$sirvs[$i]['ImsRequisition']['branch_id'])
					{
						foreach ($itemcategory [$j]['child'] as $child)
						{
							$this->loadModel('ImsItem');
							$conditionsItem =array('ImsItem.ims_item_category_id' => $child['ImsItemCategory']['id']);
							$items = $this->ImsItem->find('all', array('conditions' => $conditionsItem));
							
							foreach($sirvs[$i]['ImsSirvItem'] as $sirvItem){
								foreach ($items as $item)
								{			
									if($item['ImsItem']['id'] == $sirvItem['ims_item_id']){								
										$this->loadModel('ImsRequisition');
										$this->ImsRequisition->recursive =2;
										$conditions =array('ImsRequisition.id' => $sirvs[$i]['ImsRequisition']['id']);
										$requisition = $this->ImsRequisition->find('first', array('conditions' => $conditions));
										pr($requisition);
										if($item['ImsItem']['booked'] == 1){
											if($branch['Branch']['name'] != $branchName)
											{
												$result[$count][0] = $branch['Branch']['name'];
												$branchName = $branch['Branch']['name'];
											}											
											if($sirvs[$i]['ImsSirv']['created'] != $datevalue)
											{
												$result[$count][1] = $sirvs[$i]['ImsSirv']['created'];
												$datevalue = $sirvs[$i]['ImsSirv']['created'];
											}
											if($sirvs[$i]['ImsSirv']['name'] != $sirvnumber)
											{
												$result[$count][2] = $sirvs[$i]['ImsSirv']['name'];
												$sirvnumber = $sirvs[$i]['ImsSirv']['name'];
											}
											$result[$count][3] = $item['ImsItem']['description'];
											$result[$count][4] = $item['ImsItem']['name'];
											$result[$count][5] = $sirvItem['quantity'];
											$result[$count][6] = $sirvItem['unit_price'];
											$result[$count][7] = number_format($sirvItem['quantity'] * $sirvItem['unit_price'],2,'.',',');
											$result[$count][8] = $sirvs[$i]['ImsSirv']['status'];											
											$result[$count][9] = $requisition['RequestedUser']['Person']['first_name'].' '.$requisition['RequestedUser']['Person']['middle_name'].' '.$requisition['RequestedUser']['Person']['last_name'];
											$count++;
										}								
									}
								}						
							}						
						}
					}
				
				}			
			}	
   /////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////				
			}
				$this->set('result',$result);
				$this->set('itemCategory',$itemcategory[0]['ImsItemCategory']['name']);	
        }		
    }
	
	function sirv_grn_by_category($id = null) {
		$this->layout = 'ajax';		
		
        if (!empty($this->data)) {
            $fromdate=$this->data['ImsCard']['from'];
			$todate =$this->data['ImsCard']['to'];
			$date1 = str_replace('-', '/', $todate);
			$tomorrow = date('Y-m-d',strtotime($date1 . "+1 days"));
			
			$this->loadModel('ImsItemCategory'); 
			$this->ImsItemCategory->recursive =-1;			
			$conditions =array('ImsItemCategory.id' => $this->data['ImsCard']['category']);  						 
			$itemcategory = $this->ImsItemCategory->find('all', array('conditions' => $conditions));
			
			$this->loadModel('ImsSirv');
			$this->ImsSirv->recursive = 1;	
			$conditionssirv =array('ImsSirv.created >=' => $fromdate,'ImsSirv.created <' => $tomorrow);
			$sirvs = $this->ImsSirv->find('all', array('conditions' => $conditionssirv));			
			
			$this->loadModel('ImsGrn');
			$this->ImsGrn->recursive =3;	
			$conditions =array('ImsGrn.created >=' => $fromdate,'ImsGrn.created <' => $tomorrow,'ImsGrn.status' => 'approved');
			$grns = $this->ImsGrn->find('all', array('conditions' => $conditions));
		
			$resultSIRV = array();
			$resultGRN = array();
			$this->loadModel('Branch');	
			$this->Branch->recursive =-1;
			$branches = $this->Branch->find('all',array('order' => 'Branch.name ASC'));			
			
			for($j=0;$j<count($itemcategory );$j++){
						$itemcategory [$j]['child'] = $this->getChild($itemcategory [$j]['ImsItemCategory']['id']);			
					$itemcategory [$j]['child'][] = $itemcategory[$j];
						
	/////////////////////  SIRV  ///////////////////////////////////////////////////////////////////////////////////////////////////	
				$countsirv=0;
				$countsirvHeadOffice=0;
				$countbranchsirv =0;
				$countbranchsirvHeadOffice =0;
				$HeadOfficeOverAllCost =0;
				$BranchOverAllCost =0;
				$totalgrn = 0;
				foreach($branches as $branch){
					if($branch['Branch']['branch_category_id'] == 1)
					{
						$totalpricebranch =0;
						for($i=0;$i<count($sirvs);$i++)
						{	
							if($branch['Branch']['id'] ==$sirvs[$i]['ImsRequisition']['branch_id']){
								$totalprice =0;
								foreach ($itemcategory [$j]['child'] as $child)
								{	
									$this->loadModel('ImsItem');
									$conditionsItem =array('ImsItem.ims_item_category_id' => $child['ImsItemCategory']['id']);
									$items = $this->ImsItem->find('all', array('conditions' => $conditionsItem));
									foreach($sirvs[$i]['ImsSirvItem'] as $sirvItem){
										foreach($items as $item){								
											if($item['ImsItem']['id'] == $sirvItem['ims_item_id']){
												if($item['ImsItem']['booked'] == 0){
													$price = $sirvItem['quantity'] * $sirvItem['unit_price'];
													$totalprice = $totalprice + $price;	
												}
											}
										}
									}						
								}
								
								$this->Branch->recursive =-1;
								$conditionsBranch =array('Branch.id' => $sirvs[$i]['ImsRequisition']['branch_id']);
								$branch = $this->Branch->find('first', array('conditions' => $conditionsBranch));
								
								$myvalue = $sirvs[$i]['ImsSirv']['created'];
								$datetime = new DateTime($myvalue);
								$date = $datetime->format('Y-m-d');
								
								if($totalprice != 0){
									$resultSIRV[$countsirv][0] = $date;
									$resultSIRV[$countsirv][1] = $sirvs[$i]['ImsSirv']['name'];
									$resultSIRV[$countsirv][2] = $branch['Branch']['name'];
									$resultSIRV[$countsirv][3] = number_format($totalprice,4,'.',',');
									$countsirv++;
									$countbranchsirv = $countsirv; 
									$totalpricebranch = $totalpricebranch + $totalprice;
								}
							}
						}
						if($totalpricebranch != 0 && $countsirv > ($countbranchsirv -1)){
							$resultSIRV[$countsirv][0] = '';
							$resultSIRV[$countsirv][1] = '';
							$resultSIRV[$countsirv][2] = 'Grand Total';
							$resultSIRV[$countsirv][3] = number_format($totalpricebranch,2,'.',',');
							$countsirv++;
							$countbranchsirv = $countsirv;
							$BranchOverAllCost = $BranchOverAllCost + $totalpricebranch;
						}
					}
					else if($branch['Branch']['branch_category_id'] == 2)
					{
						$totalpriceheadoffice =0;
						for($i=0;$i<count($sirvs);$i++)
						{	
							if($branch['Branch']['id'] ==$sirvs[$i]['ImsRequisition']['branch_id']){
								$totalprice =0;
								foreach ($itemcategory [$j]['child'] as $child)
								{	
									$this->loadModel('ImsItem');
									$conditionsItem =array('ImsItem.ims_item_category_id' => $child['ImsItemCategory']['id']);
									$items = $this->ImsItem->find('all', array('conditions' => $conditionsItem));
									foreach($sirvs[$i]['ImsSirvItem'] as $sirvItem){
										foreach($items as $item){								
											if($item['ImsItem']['id'] == $sirvItem['ims_item_id']){
												if($item['ImsItem']['booked'] == 0){
													$price = $sirvItem['quantity'] * $sirvItem['unit_price'];
													$totalprice = $totalprice + $price;
												}
											}
										}
									}						
								}
								
								$this->Branch->recursive =-1;
								$conditionsBranch =array('Branch.id' => $sirvs[$i]['ImsRequisition']['branch_id']);
								$branch = $this->Branch->find('first', array('conditions' => $conditionsBranch));
								
								$myvalue = $sirvs[$i]['ImsSirv']['created'];
								$datetime = new DateTime($myvalue);
								$date = $datetime->format('Y-m-d');
								
								if($totalprice != 0){
									$resultSIRVHeadOffice[$countsirvHeadOffice][0] = $date;
									$resultSIRVHeadOffice[$countsirvHeadOffice][1] = $sirvs[$i]['ImsSirv']['name'];
									$resultSIRVHeadOffice[$countsirvHeadOffice][2] = $branch['Branch']['name'];
									$resultSIRVHeadOffice[$countsirvHeadOffice][3] = number_format($totalprice,4,'.',',');
									$countsirvHeadOffice++;
									$countbranchsirvHeadOffice = $countsirvHeadOffice; 
									$totalpriceheadoffice = $totalpriceheadoffice + $totalprice;
								}
							}
						}
						if($totalpriceheadoffice != 0 && $countsirvHeadOffice > ($countbranchsirvHeadOffice -1)){
							$resultSIRVHeadOffice[$countsirvHeadOffice][0] = '';
							$resultSIRVHeadOffice[$countsirvHeadOffice][1] = '';
							$resultSIRVHeadOffice[$countsirvHeadOffice][2] = 'Grand Total';
							$resultSIRVHeadOffice[$countsirvHeadOffice][3] = number_format($totalpriceheadoffice,2,'.',',');
							$countsirvHeadOffice++;
							$countbranchsirvHeadOffice = $countsirvHeadOffice; 							
							$HeadOfficeOverAllCost = $HeadOfficeOverAllCost + $totalpriceheadoffice;
						}
					}
				}				
   /////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////			

	/////////////////////  GRN  ///////////////////////////////////////////////////////////////////////////////////////////////////	
				$countgrn=0;
				$adjustment;
				for($i=0;$i<count($grns);$i++)
				{						
					$totalprice =0;					
					if($grns[$i]['ImsGrn']['ims_supplier_id'] != 0){
						$adjustment='';
						foreach($grns[$i]['ImsGrnItem'] as $grnItem){
							foreach ($itemcategory [$j]['child'] as $child)
							{
								$this->loadModel('ImsItem');
								$conditionsItem =array('ImsItem.ims_item_category_id' => $child['ImsItemCategory']['id']);
								$items = $this->ImsItem->find('all', array('conditions' => $conditionsItem));
														
								foreach($items as $item){								
									if($item['ImsItem']['id'] == $grnItem['ImsPurchaseOrderItem']['ims_item_id']){
									$price = $grnItem['quantity'] * $grnItem['unit_price'];
										$totalprice = $totalprice + $price;
									}
								}
							}						
						}
					}
					else if($grns[$i]['ImsGrn']['ims_supplier_id'] == 0){
						$adjustment = 'Adjustment';
						foreach($grns[$i]['ImsGrnItem'] as $grnItem){
							$this->loadModel('ImsCard');
							$this->ImsCard->recursive =-1;
							$conditionsCard =array('ImsCard.ims_grn_item_id' => $grnItem['id']);
							$card = $this->ImsCard->find('first', array('conditions' => $conditionsCard));
							foreach ($itemcategory [$j]['child'] as $child)
							{
								$this->loadModel('ImsItem');
								$conditionsItem =array('ImsItem.ims_item_category_id' => $child['ImsItemCategory']['id']);
								$items = $this->ImsItem->find('all', array('conditions' => $conditionsItem));
														
								foreach($items as $item){	
									if($item['ImsItem']['id'] == $card['ImsCard']['ims_item_id']){
									$price = $grnItem['quantity'] * $grnItem['unit_price'];
										$totalprice = $totalprice + $price;
									}
								}
							}						
						}
					}
					$myvalue = $grns[$i]['ImsGrn']['created'];
					$datetime = new DateTime($myvalue);
					$date = $datetime->format('Y-m-d');
					
					if($totalprice != 0){
						$resultGRN[$countgrn][0] = $date;
						$resultGRN[$countgrn][1] = $grns[$i]['ImsGrn']['name'];
						$resultGRN[$countgrn][2] = number_format($totalprice,2,'.',',');
						$resultGRN[$countgrn][3] = $adjustment;
						$countgrn++;
						$totalgrn = $totalgrn + $totalprice;
					}					
				}
				$resultGRN[$countgrn][0] = '';
				$resultGRN[$countgrn][1] = 'Total Cost';
				$resultGRN[$countgrn][2] = number_format($totalgrn,2,'.',',');
				$resultGRN[$countgrn][3] = '';
   /////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////

			$resultSIRVHeadOffice[$countsirvHeadOffice][0] = '';
			$resultSIRVHeadOffice[$countsirvHeadOffice][1] = '';
			$resultSIRVHeadOffice[$countsirvHeadOffice][2] = 'Over All Total';
			$resultSIRVHeadOffice[$countsirvHeadOffice][3] = number_format($HeadOfficeOverAllCost,2,'.',',');
			
			$resultSIRV[$countsirv][0] = '';
			$resultSIRV[$countsirv][1] = '';
			$resultSIRV[$countsirv][2] = 'Over All Total';
			$resultSIRV[$countsirv][3] = number_format($BranchOverAllCost,2,'.',',');
			}	
				$this->set('resultSIRV',$resultSIRV);
				$this->set('resultSIRVHeadOffice',$resultSIRVHeadOffice);
				$this->set('resultGRN',$resultGRN);
				$this->set('itemCategory',$itemcategory[0]['ImsItemCategory']['name']);
        }		
    }	
		
	function balance_by_category($id = null) {
		$this->layout = 'ajax';
        if (!empty($this->data)) {
            $date=$this->data['ImsCard']['date'];
			$date1 = str_replace('-', '/', $date);
			$tomorrow = date('Y-m-d',strtotime($date1 . "+1 days"));
			
			$this->loadModel('ImsItemCategory'); 
			$this->ImsItemCategory->recursive =-1;			
			$conditions =array('ImsItemCategory.id' => $this->data['ImsCard']['category']); 						 
			$itemcategory = $this->ImsItemCategory->find('all', array('conditions' => $conditions));
			
			$result = array();
			$totalprice = 0;
			$price =0;
			$balance =0;
			$grandTotalPrice =0;
			$meas = null;
			$count = 0;
			for($j=0;$j<count($itemcategory );$j++){
						$itemcategory [$j]['child'] = $this->getChild($itemcategory [$j]['ImsItemCategory']['id']);			
					$itemcategory [$j]['child'][] = $itemcategory[$j];
						
	/////////////////////  CARD  ///////////////////////////////////////////////////////////////////////////////////////////////////				
				
				foreach ($itemcategory [$j]['child'] as $child)
				{
					$this->loadModel('ImsItem');
					$conditionsItem =array('ImsItem.ims_item_category_id' => $child['ImsItemCategory']['id']);
					$items = $this->ImsItem->find('all', array('conditions' => $conditionsItem,'order' => 'ImsItem.description ASC'));
					foreach ($items as $item)
					{	
			
						$this->ImsCard->recursive =2;
						$conditions =array('ImsCard.created <' => $tomorrow,'ImsCard.ims_item_id' => $item['ImsItem']['id']);
						$cards = $this->ImsCard->find('all', array('conditions' => $conditions,'order' => 'ImsCard.created ASC'));						
						
						for($i =0; $i<count($cards); $i++){
							if($cards[$i]['ImsCard']['ims_grn_item_id'] != 0){
								if($cards[$i]['ImsCard']['balance'] !=0){
									$price = $cards[$i]['ImsCard']['in_unit_price'];
								}
								$meas = $cards[$i]['ImsGrnItem']['ImsPurchaseOrderItem']['measurement'];
								$totalprice = $totalprice + ($cards[$i]['ImsCard']['in_quantity'] * $cards[$i]['ImsCard']['in_unit_price']);
							}
							else if($cards[$i]['ImsCard']['ims_grn_item_id'] == 0){
								if($cards[$i]['ImsCard']['balance'] !=0){
									$price = $cards[$i]['ImsCard']['out_unit_price'];
								}
								$meas = $cards[$i]['ImsSirvItem']['measurement'];
								$totalprice = $totalprice - ($cards[$i]['ImsCard']['out_quantity'] * $cards[$i]['ImsCard']['out_unit_price']);
							}
							$balance = $cards[$i]['ImsCard']['balance'];
						}
						if($balance == 0){
							$price =0;
						}
						$result[$count][0] = $count+1;
						$result[$count][1] = $item['ImsItem']['description'];
						$result[$count][2] = $item['ImsItem']['name'];
						$result[$count][3] = $meas;
						$result[$count][4] = $balance;
						$result[$count][5] = $price;
						$result[$count][6] = number_format($totalprice,4,'.',',');
						
						$grandTotalPrice += $totalprice;
						$count++;
						$meas = null;
						$price =0;
						$totalprice =0;
						$balance = 0;
					}						
				}	
   /////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
				
			}
				$this->set('result',$result);
				$this->set('itemCategory',$itemcategory[0]['ImsItemCategory']['name']);
				$this->set('grandTotalPrice',number_format($grandTotalPrice,4,'.',','));
        }			
    }
	
	function min_max_by_category($id = null) {
		$this->layout = 'ajax';
        if (!empty($this->data)) {
            $minmax=$this->data['ImsCard']['minmax'];	

			$this->loadModel('ImsItemCategory'); 
			$this->ImsItemCategory->recursive =-1;			
			$conditions =array('ImsItemCategory.id' => $this->data['ImsCard']['category']); 						 
			$itemcategory = $this->ImsItemCategory->find('all', array('conditions' => $conditions));
			
			$result = array();
			$count = 0;
			for($j=0;$j<count($itemcategory );$j++){
						$itemcategory [$j]['child'] = $this->getChild($itemcategory [$j]['ImsItemCategory']['id']);			
					$itemcategory [$j]['child'][] = $itemcategory[$j];
						
	/////////////////////  CARD  ///////////////////////////////////////////////////////////////////////////////////////////////////				
				
				foreach ($itemcategory [$j]['child'] as $child)
				{
					$this->loadModel('ImsItem');
					$conditionsItem =array('ImsItem.ims_item_category_id' => $child['ImsItemCategory']['id']);
					$items = $this->ImsItem->find('all', array('conditions' => $conditionsItem));					
					foreach ($items as $item)
					{	
						$this->ImsCard->recursive =2;
						$conditions =array('ImsCard.ims_item_id' => $item['ImsItem']['id']);
						$card = $this->ImsCard->find('first', array('conditions' => $conditions,'order' => 'ImsCard.id DESC'));												
						if($minmax == 'Min'){
							if($card['ImsCard']['balance'] <= $item['ImsItem']['min_level']){
								$result[$count][0] = $count+1;
								$result[$count][1] = $item['ImsItem']['description'];
								$result[$count][2] = $item['ImsItem']['name'];
								$result[$count][3] = $item['ImsItem']['min_level'];
								$result[$count][4] = $card['ImsCard']['balance'];
								$count++;
							}
						}
						else if($minmax == 'Max'){
							if($card['ImsCard']['balance'] >= $item['ImsItem']['max_level']){
								$result[$count][0] = $count+1;
								$result[$count][1] = $item['ImsItem']['description'];
								$result[$count][2] = $item['ImsItem']['name'];
								$result[$count][3] = $item['ImsItem']['max_level'];
								$result[$count][4] = $card['ImsCard']['balance'];
								$count++;
							}
						}						
					}						
				}	
   /////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
				
			}
				$this->set('result',$result);
				$this->set('itemCategory',$itemcategory[0]['ImsItemCategory']['name']);
        }			
    }
}

?>