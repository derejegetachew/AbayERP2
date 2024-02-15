<?php
class ImsDisposalsController extends AppController {

	var $name = 'ImsDisposals';
	
	function index() {
		$ims_stores = $this->ImsDisposal->ImsStore->find('all');
		$user = $this->Session->read('Auth.User.id');
		$this->set(compact('ims_stores','user'));
	}
	
	function index_1() {
    $this->ImsDisposal->ImsStore->recursive=-1;
		$ims_stores = $this->ImsDisposal->ImsStore->find('all');
		$user = $this->Session->read('Auth.User.id');
		$this->set(compact('ims_stores','user'));
	}
	
	function index2($id = null) {
		$this->set('parent_id', $id);
	}

	function search() {
	}
	
	function list_data($id = null) {
		$start = (isset($_REQUEST['start'])) ? $_REQUEST['start'] : 0;
		$limit = (isset($_REQUEST['limit'])) ? $_REQUEST['limit'] : 5;
		$imsstore_id = (isset($_REQUEST['imsstore_id'])) ? $_REQUEST['imsstore_id'] : -1;
		if($id)
			$imsstore_id = ($id) ? $id : -1;
        $conditions = (isset($_REQUEST['conditions'])) ? $_REQUEST['conditions'] : '';

        eval("\$conditions = array( " . $conditions . " );");
		if ($imsstore_id != -1) {
            $conditions['ImsDisposal.ims_store_id'] = $imsstore_id;
        }
		
		$this->ImsDisposal->recursive = 2;
		$this->set('ims_disposals', $this->ImsDisposal->find('all', array('conditions' => $conditions, 'limit' => $limit, 'offset' => $start)));
		$this->set('results', $this->ImsDisposal->find('count', array('conditions' => $conditions)));
	}
	
	function list_data_1($id = null) {
		$start = (isset($_REQUEST['start'])) ? $_REQUEST['start'] : 0;
		$limit = (isset($_REQUEST['limit'])) ? $_REQUEST['limit'] : 5;
		$imsstore_id = (isset($_REQUEST['imsstore_id'])) ? $_REQUEST['imsstore_id'] : -1;
		if($id)
			$imsstore_id = ($id) ? $id : -1;
        $conditions = (isset($_REQUEST['conditions'])) ? $_REQUEST['conditions'] : '';

        eval("\$conditions = array( " . $conditions . " );");
		if ($imsstore_id != -1) {
            $conditions['ImsDisposal.ims_store_id'] = $imsstore_id;
        }
		 $conditions['ImsDisposal.status !='] = 'created';
		
   $param="1=1";
   if(isset($_REQUEST['conditions'])){
     $param=  explode("=>",$_REQUEST['conditions']);
     $param= "d.name like " . $param[1];
   }
    
    //var_dump($param);die();
   
		$this->ImsDisposal->recursive = 1;
   
    $cmd="select d.id,d.name,s.name as store,CONCAT(p.first_name,' ',p.middle_name) as created_by,  
          CONCAT(pp.first_name,' ',pp.middle_name) as approved_by,d.created,d.modified,d.status 
          from ims_disposals d left join ims_stores s
          on d.ims_store_id=s.id left join users u
          on u.id=d.created_by left join users uu
          on uu.id=d.approved_by left join people p
          on u.person_id=p.id LEFT join people pp
          on pp.id=uu.person_id where 1=1 and ".$param."
          order by d.id desc  limit ".$limit."  offset ".$start." ";
    
    //OLD
    //$ims_disposals=$this->ImsDisposal->find('all', array('conditions' => $conditions, 'limit' => $limit, 'offset' => $start));
    
    //New query
    $ims_disposals=$this->ImsDisposal->query($cmd);
    //var_dump($ims_disposals);die();
		$this->set('ims_disposals',$ims_disposals);
   
    
		$this->set('results', $this->ImsDisposal->find('count', array('conditions' => $conditions)));
	
  }

	function view($id = null) {
		if (!$id) {
			$this->Session->setFlash(__('Invalid ims disposal', true));
			$this->redirect(array('action' => 'index'));
		}
		$this->ImsDisposal->recursive = 2;
		$this->set('imsDisposal', $this->ImsDisposal->read(null, $id));
	}

	function add($id = null) {
		if (!empty($this->data)) {
			$this->ImsDisposal->create();
			
			$this->data['ImsDisposal']['status'] = 'created';
			$this->data['ImsDisposal']['created_by'] = $this->Session->read('Auth.User.id');
			
			$this->autoRender = false;
			if ($this->ImsDisposal->save($this->data)) {
				$this->Session->setFlash(__('The disposal has been saved', true). '::' . $this->ImsDisposal->id, '');
				$this->render('/elements/success_po');
			} else {
				$this->Session->setFlash(__('The disposal could not be saved. Please, try again.', true), '');
				$this->render('/elements/failure');
			}
		}
		if($id)
			$this->set('parent_id', $id);
		$ims_stores = $this->ImsDisposal->ImsStore->find('all');
		$this->set(compact('ims_stores'));
		
		$count = 0;
		$value = $this->ImsDisposal->find('first',array('conditions' => array('ImsDisposal.name LIKE' => date("Ymd").'%'),'order'=>'ImsDisposal.name DESC'));
		if($value != null){
			$value = explode('/',$value['ImsDisposal']['name']);		
			$count = $value[1];
		}       
       
        $this->set('count',$count);
	}

	function edit($id = null, $parent_id = null) {
		if (!$id && empty($this->data)) {
			$this->Session->setFlash(__('Invalid disposal', true), '');
			$this->redirect(array('action' => 'index'));
		}
		if (!empty($this->data)) {
			$this->autoRender = false;
			if ($this->ImsDisposal->save($this->data)) {
				$this->Session->setFlash(__('The disposal has been saved', true), '');
				$this->render('/elements/success');
			} else {
				$this->Session->setFlash(__('The disposal could not be saved. Please, try again.', true), '');
				$this->render('/elements/failure');
			}
		}
		$this->set('ims_disposal', $this->ImsDisposal->read(null, $id));
		
		if($parent_id) {
			$this->set('parent_id', $parent_id);
		}
			
		$ims_stores = $this->ImsDisposal->ImsStore->find('list');
		$this->set(compact('ims_stores'));
	}

	function delete($id = null) {
		$this->autoRender = false;
		if (!$id) {
			$this->Session->setFlash(__('Invalid id for ims disposal', true), '');
			$this->render('/elements/failure');
		}
		if (stripos($id, '_') !== false) {
            $ids = explode('_', $id);
            try{
                foreach ($ids as $i) {
                    $this->ImsDisposal->delete($i);
                }
				$this->Session->setFlash(__('disposal deleted', true), '');
				$this->render('/elements/success');
            }
            catch (Exception $e){
				$this->Session->setFlash(__('disposal was not deleted', true), '');
				$this->render('/elements/failure');
            }
        } else {
            if ($this->ImsDisposal->delete($id)) {
				$this->Session->setFlash(__('disposal deleted', true), '');
				$this->render('/elements/success');
			} else {
				$this->Session->setFlash(__('disposal was not deleted', true), '');
				$this->render('/elements/failure');
			}
        }
	}
	
	function post($id = null) {
        $this->autoRender = false;
        if (!$id) {
            $this->Session->setFlash(__('Invalid id for disposal', true), '');
            $this->render('/elements/failure');
        }
        $disposal = array('ImsDisposal' => array('id' => $id, 'status' => 'posted'));
        if ($this->ImsDisposal->save($disposal)) {
            $this->Session->setFlash(__('disposal posted for approval', true), '');
            $this->render('/elements/success');
        } else {
            $this->Session->setFlash(__('disposal was not posted for approval', true), '');
            $this->render('/elements/failure');
        }
    }
	
	function approve($id = null) {
        $this->autoRender = false;
        if (!$id) {
            $this->Session->setFlash(__('Invalid id for disposal', true), '');
            $this->render('/elements/failure');
        }
		$user = $this->Session->read();		
        $disposal = array('ImsDisposal' => array('id' => $id, 'approved_by' => $user['Auth']['User']['id'],'status' => 'approved'));
        if ($this->ImsDisposal->save($disposal)) {
			
			$this->loadModel('ImsCard');
			$this->ImsDisposal->recursive = 2;
			$dsp = $this->ImsDisposal->read(null,$id);
			$this->loadModel('ImsStoresItem');
			foreach($dsp['ImsDisposalItem'] as $dspitems){				
				$balance = 0;
				$balancec = 0;
				$conditionsstoreitems['ImsStoresItem.ims_store_id'] = $dsp['ImsDisposal']['ims_store_id'];
				$conditionsstoreitems['ImsStoresItem.ims_item_id'] = $dspitems['ims_item_id'];
				$storeitem=$this->ImsStoresItem->find('first', array('conditions' => $conditionsstoreitems));
				if($storeitem == null){
					
				}
				else if($storeitem != null ){
					if($storeitem['ImsStoresItem']['balance'] > 0){
						if($storeitem['ImsStoresItem']['balance'] >= $dspitems['quantity']){
							$balance = $storeitem['ImsStoresItem']['balance'] - $dspitems['quantity'];
							$balancec = $dspitems['quantity'];
						}
						else {
							$balance = 0;
							$balancec = $storeitem['ImsStoresItem']['balance'];
						}
						
						$conditionsB = array('ImsCard.ims_item_id' => $dspitems['ims_item_id']);
						$cardB = $this->ImsCard->find('first', array('conditions' =>$conditionsB,'order'=>'ImsCard.id DESC'));
						$tb = $lb = $cardB['ImsCard']['balance'];
						$rq = $rrq = $balancec;
						
						if($cardB != null){
							if($cardB['ImsCard']['balance'] >= $balancec){
								//read the last n incoming items which are not in 'D' states in descending order of their created
								$value = array("NOT"=>array('ImsCard.status'=>array('D','')));
								$conditions_item = array('ImsCard.ims_item_id' => $dspitems['ims_item_id'],'ImsCard.in_quantity !=' => 0,$value);
								$in_items = $this->ImsCard->find('all', array('conditions' =>$conditions_item,'order'=>'ImsCard.id DESC'));
								
								if(!empty($in_items)){
									foreach($in_items as $in_item){
							
										if($in_item['ImsCard']['in_quantity'] < $lb){
										
											//there is at least one record above
											$lb = $lb - $in_item['ImsCard']['in_quantity'];
											if($lb < $rq) {	
												if($rrq > $tb){
													$rrq = $tb;
												}
												$q = $rrq - $lb;
												if($q > $tb){
													$q = $tb;
												}
												$balance = $tb - $q;
												if($balance < 0){
													$balance = 0;
												}
												$rrq = $rrq - $q;
																
												//make record of card						
												$this->ImsCard->create();
												$this->data['ImsCard']['ims_item_id'] = $dspitems['ims_item_id'];
												$this->data['ImsCard']['ims_disposal_item_id'] = $dspitems['id'];
												$this->data['ImsCard']['disp_quantity'] = $q;
												$this->data['ImsCard']['disp_unit_price'] = $in_item['ImsCard']['in_unit_price'];
												$this->data['ImsCard']['balance'] = $balance;
												$this->data['ImsCard']['ims_store_id'] = $dsp['ImsDisposal']['ims_store_id'];
												$this->ImsCard->save($this->data);
												
												//update the incoming item status
												$tb = $tb - $q;					
												if($tb > 0){
													$this->ImsCard->id = $in_item['ImsCard']['id'];
													$this->ImsCard->saveField('status', 'S');								
												}else if($tb <= 0){						
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
												$this->ImsStoresItem->id = $storeitem['ImsStoresItem']['id'];
												$this->ImsStoresItem->saveField('balance', $storeitem['ImsStoresItem']['balance'] - $q);
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
											
											//make record of card					
											$this->ImsCard->create();
											$this->data['ImsCard']['ims_item_id'] = $dspitems['ims_item_id'];
											$this->data['ImsCard']['ims_disposal_item_id'] = $dspitems['id'];
											$this->data['ImsCard']['disp_quantity'] = $q;
											$this->data['ImsCard']['disp_unit_price'] = $in_item['ImsCard']['in_unit_price'];
											$this->data['ImsCard']['balance'] = $balance;
											$this->data['ImsCard']['ims_store_id'] = $dsp['ImsDisposal']['ims_store_id'];
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
											
											//update store item balance							
											$this->ImsStoresItem->id = $storeitem['ImsStoresItem']['id'];
											$this->ImsStoresItem->saveField('balance', $storeitem['ImsStoresItem']['balance'] - $q);
										}
									}
								}							
							}
						}
					}
				}
			}
			
            $this->Session->setFlash(__('Disposal successfully approved', true), '');
            $this->render('/elements/success');
        } else {
            $this->Session->setFlash(__('Disposal was not successfully approved', true), '');
            $this->render('/elements/failure');
        }
    }
	
	function reject($id = null) {
        $this->autoRender = false;
        if (!$id) {
            $this->Session->setFlash(__('Invalid id for disposal', true), '');
            $this->render('/elements/failure');
        }
		$user = $this->Session->read();	
        $disposal = array('ImsDisposal' => array('id' => $id, 'approved_by' => $user['Auth']['User']['id'],'status' => 'rejected'));
        if ($this->ImsDisposal->save($disposal)) {
			pr($disposal);
            $this->Session->setFlash(__('disposal successfully rejected', true), '');
            $this->render('/elements/success');
        } else {
            $this->Session->setFlash(__('disposal was not successfully rejected', true), '');
            $this->render('/elements/failure');
        }
    }
}
?>