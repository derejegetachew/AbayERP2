<?php
class ImsRequisitionsController extends ImsAppController {

	var $name = 'ImsRequisitions';
	
	function index() {
		$budget_years = $this->ImsRequisition->BudgetYear->find('all');
		$this->set(compact('budget_years'));
		
		$user = $this->Session->read();	
		$this->set('username',$user['Auth']['User']['username']);
		$this->set('groups',$user['Auth']['Group']);		
		
	}
	
	function index_1() {
 
    $this->ImsRequisition->BudgetYear->recursive=-1;
		$budget_years = $this->ImsRequisition->BudgetYear->find('all');
		//var_dump($budget_years);die();
		$this->set(compact('budget_years'));
	}
	
	function index_2() {
		$budget_years = $this->ImsRequisition->BudgetYear->find('all');
		$this->set(compact('budget_years'));
	}
	
	function index2($id = null) {
		$this->set('parent_id', $id);
	}

	function search() {
	}
	
	function list_data($id = null) {
		$start = (isset($_REQUEST['start'])) ? $_REQUEST['start'] : 0;
		$limit = (isset($_REQUEST['limit'])) ? $_REQUEST['limit'] : 40;
		$budgetyear_id = (isset($_REQUEST['budgetyear_id'])) ? $_REQUEST['budgetyear_id'] : -1;
		if($id)
			$budgetyear_id = ($id) ? $id : -1;
        $conditions = (isset($_REQUEST['conditions'])) ? $_REQUEST['conditions'] : isset($_REQUEST['query']) ? $_REQUEST['query'] : '';

        eval("\$conditions = array( " . $conditions . " );");
		if ($budgetyear_id != -1) {
            $conditions['ImsRequisition.budget_year_id'] = $budgetyear_id;
        }
				
		$user = $this->Session->read();	
		$groups = $user['Auth']['Group'];
		
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
		
		foreach($groups as $group){
			if($group['name'] == 'Stock Record Officer' or $group['name'] == 'Stock Supervisor' or $group['name'] == 'Administrators'){
				$conditions['ImsRequisition.status'] = array('received','accepted','approved','SIRV created');
			}
			else if($group['name'] == 'Store Keeper'){
				if($conditions == null){
				
					$cond[1]['ImsRequisition.status'] = array('received','accepted','SIRV created');
					$cond[1]['ImsRequisition.ims_store_id'] = $store['ImsStore']['id'];			
					
					$cond[2]['ImsRequisition.status'] = array('approved');
					$conditions = array("OR" => $cond);
				}
				
				else if(!empty($conditions)){
					$conditions['ImsRequisition.status'] = array('received');
					$conditions['ImsRequisition.ims_store_id'] = $store['ImsStore']['id'];
				}
				
			
				//$conditions['ImsRequisition.status'] = array('accepted','SIRV created','approved');
				//$conditions['ImsRequisition.ims_store_id'] = $store['ImsStore']['id'];
			}
		}
		$this->ImsRequisition->recursive = 1;
		$test=$this->set('ims_requisitions', $this->ImsRequisition->find('all', array('conditions' => $conditions, 'limit' => $limit, 'offset' => $start)));		
		$this->set('results', $this->ImsRequisition->find('count', array('conditions' => $conditions)));
	}
	
	function list_data_1($id = null) {
		$start = (isset($_REQUEST['start'])) ? $_REQUEST['start'] : 0;
		$limit = (isset($_REQUEST['limit'])) ? $_REQUEST['limit'] : 5;
		$budgetyear_id = (isset($_REQUEST['budgetyear_id'])) ? $_REQUEST['budgetyear_id'] : -1;
		if($id)
			$budgetyear_id = ($id) ? $id : -1;			
        $conditions = (isset($_REQUEST['conditions'])) ? $_REQUEST['conditions'] : '';

        eval("\$conditions = array( " . $conditions . " );");
		$user = $this->Session->read();		
		if ($budgetyear_id != -1) {
			
            $conditions =array('ImsRequisition.budget_year_id' => $budgetyear_id);
        }
		$conditions['ImsRequisition.requested_by'] = $user['Auth']['User']['id'];
		$this->ImsRequisition->recursive = 0;
		$test=$this->set('ims_requisitions', $this->ImsRequisition->find('all', array('conditions' => $conditions, 'limit' => $limit, 'offset' => $start)));		
		$this->set('results', $this->ImsRequisition->find('count', array('conditions' => $conditions)));
	}
	
	function list_data_2($id = null) {
		$start = (isset($_REQUEST['start'])) ? $_REQUEST['start'] : 0;
		$limit = (isset($_REQUEST['limit'])) ? $_REQUEST['limit'] : 5;
		$budgetyear_id = (isset($_REQUEST['budgetyear_id'])) ? $_REQUEST['budgetyear_id'] : -1;
		if($id)
			$budgetyear_id = ($id) ? $id : -1;			
        $conditions = (isset($_REQUEST['conditions'])) ? $_REQUEST['conditions'] : '';

        eval("\$conditions = array( " . $conditions . " );");
		$user = $this->Session->read();		
		if ($budgetyear_id != -1) {
			
            $conditions =array('ImsRequisition.budget_year_id' => $budgetyear_id);
        }
		$conditions['ImsRequisition.requested_by <>'] = $user['Auth']['User']['id'];
		$conditions['ImsRequisition.status'] = 'posted';
		
		$user = $this->Session->read();
		$this->loadModel('Employee');
		$emp = $this->Employee->find('first',array('conditions'=>array('Employee.user_id'=>$user['Auth']['User']['id'])));		
		$employees = $this->requestAction(array('controller' => 'holidays', 'action' => 'supervised'), array('pass' => array('emp_id'=>$emp['Employee']['id'])));
			
		$users=array();
		foreach($employees as $employee){
			$emp = $this->Employee->read(null,$employee);
			$users[] = $emp['Employee']['user_id'];
		}
		$empcond=array("OR "=>array("ImsRequisition.requested_by" => $users));
		$conditions = array_merge($empcond , $conditions);
		
		$this->ImsRequisition->recursive = 1;
		$test=$this->set('ims_requisitions', $this->ImsRequisition->find('all', array('conditions' => $conditions, 'limit' => $limit, 'offset' => $start)));		
		$this->set('results', $this->ImsRequisition->find('count', array('conditions' => $conditions)));
	}

	function view($id = null) {
		if (!$id) {
			$this->Session->setFlash(__('Invalid requisition', true));
			$this->redirect(array('action' => 'index'));
		}
		$this->ImsRequisition->recursive = 2;
		$this->set('imsRequisition', $this->ImsRequisition->read(null, $id));
	}
	
	function delegate($id = null) {
		if (!$id) {
			$this->Session->setFlash(__('Invalid requisition', true));
			//$this->redirect(array('action' => 'index'));
		}		
		$this->ImsRequisition->recursive = -1;
		$this->set('imsRequisition', $this->ImsRequisition->read(null, $id));
		
		$this->loadModel('People');
		$this->loadModel('User');
		$this->loadModel('Employee');
		$this->People->recursive = -1;
		$this->User->recursive = -1;
		$this->Employee->recursive = -1;
		$employees = array();
	    $peoples = $this->People->find('all',array('order' => 'People.first_name ASC')); 		
		foreach($peoples as $people){			
			//$user = $this->User->find('first',array('conditions'=>array('User.person_id'=>$people['People']['id']))); 		
			
		//	$employee = $this->Employee->find('first',array('conditions'=>array('Employee.user_id'=>$user['User']['id'],'Employee.status'=>'active'))); 
		//	if(!empty($employee)){
				$employees[] = $people;
		//	}
		}
	    $this->set(compact('employees'));
	}

	function add($id = null) {
		if (!empty($this->data)) {
			// Strip out carriage returns
            $content = ereg_replace("\r",'',$this->data['ImsRequisition']['purpose']);
            // Handle paragraphs
            $content = ereg_replace("\n\n",'<br /><br />',$content);
            // Handle line breaks
            $content = ereg_replace("\n",'<br />',$content);
            // Handle apostrophes
            $content = ereg_replace("'",'&#8217;',$content);
			$this->data['ImsRequisition']['purpose'] = $content;
			
			$this->ImsRequisition->create();
			$this->autoRender = false;
			
			$budget_year;
			$date = new DateTime("now");		
			$this->ImsRequisition->BudgetYear->recursive = 0;
			$budget_years = $this->ImsRequisition->BudgetYear->find('all');
			foreach($budget_years as $budget_year){			
				if(!empty($budget_year))
				{
					if(new DateTime($budget_year['BudgetYear']['to_date'])>($date))
					{
						$budget_year =$budget_year['BudgetYear'];
						$this->data['ImsRequisition']['budget_year_id'] = $budget_year['id'];
					}
				}
			}
			
			$user = $this->Session->read();
			$this->data['ImsRequisition']['requested_by'] = $user['Auth']['User']['id'];
			
			$this->loadModel('Employee');
			$emp = $this->Employee->find('first',array('conditions'=>array('Employee.user_id'=>$user['Auth']['User']['id'])));
			$emp_details = $this->Employee->EmployeeDetail->find('first',array('conditions'=>array('EmployeeDetail.employee_id'=>$emp['Employee']['id']),'order'=>'EmployeeDetail.start_date DESC'));
			$this->data['ImsRequisition']['branch_id'] = $emp_details['EmployeeDetail']['branch_id'];
			
			$this->data['ImsRequisition']['status'] = 'created';

			
			if ($this->ImsRequisition->save($this->data)) {
				$this->Session->setFlash(__('The requisition has been saved', true) . '::' . $this->ImsRequisition->id, '');
				$this->render('/elements/success_po');
			} else {
				$this->Session->setFlash(__('The requisition could not be saved. Please, try again.', true), '');
				$this->render('/elements/failure');
			}
		}
		if($id)
			$this->set('parent_id', $id);
		$budget_years = $this->ImsRequisition->BudgetYear->find('list');
		$branches = $this->ImsRequisition->Branch->find('list');
		$this->set(compact('budget_years', 'branches'));
		
		$count = 0;
		$value = $this->ImsRequisition->find('first',array('conditions' => array('ImsRequisition.name LIKE' => date("Ymd").'%'),'order'=>'ImsRequisition.name DESC'));
		if($value != null){
			$value = explode('/',$value['ImsRequisition']['name']);		
			$count = $value[1];
		}		       
        $this->set('count',$count);
	}
	
	function add_manual_requisitions($id = null) {
		if (!empty($this->data)) {
			$this->ImsRequisition->create();
			$this->autoRender = false;
			
			$budget_year;
			$date = new DateTime("now");		
			$this->ImsRequisition->BudgetYear->recursive = 0;
			$budget_years = $this->ImsRequisition->BudgetYear->find('all');
			foreach($budget_years as $budget_year){			
				if(!empty($budget_year))
				{
					if(new DateTime($budget_year['BudgetYear']['to_date'])>($date))
					{
						$budget_year =$budget_year['BudgetYear'];
						$this->data['ImsRequisition']['budget_year_id'] = $budget_year['id'];
					}
				}
			}
			
			$user = $this->Session->read();
			$this->data['ImsRequisition']['requested_by'] = $user['Auth']['User']['id'];
			$this->data['ImsRequisition']['approved_rejected_by'] = $user['Auth']['User']['id'];
			
			$this->data['ImsRequisition']['status'] = 'approved';
			
			// Strip out carriage returns
            $content = ereg_replace("\r",'',$this->data['ImsRequisition']['purpose']);
            // Handle paragraphs
            $content = ereg_replace("\n\n",'<br /><br />',$content);
            // Handle line breaks
            $content = ereg_replace("\n",'<br />',$content);
            // Handle apostrophes
            $content = ereg_replace("'",'&#8217;',$content);
			$this->data['ImsRequisition']['purpose'] = $content;
			
			if ($this->ImsRequisition->save($this->data)) {
				$this->Session->setFlash(__('The requisition has been saved', true) . '::' . $this->ImsRequisition->id, '');
				$this->render('/elements/success_po');
			} else {
				$this->Session->setFlash(__('The requisition could not be saved. Please, try again.', true), '');
				$this->render('/elements/failure');
			}
		}
		if($id)
			$this->set('parent_id', $id);
		$budget_years = $this->ImsRequisition->BudgetYear->find('list');
		$this->ImsRequisition->Branch->recursive = 0;
		$branches = $this->ImsRequisition->Branch->find('all');
		$this->set(compact('budget_years', 'branches'));
	}

	function edit($id = null, $parent_id = null) {
		if (!$id && empty($this->data)) {
			$this->Session->setFlash(__('Invalid ims requisition', true), '');
			$this->redirect(array('action' => 'index'));
		}
		if (!empty($this->data)) {
			
			// Strip out carriage returns
            $content = ereg_replace("\r",'',$this->data['ImsRequisition']['purpose']);
            // Handle paragraphs
            $content = ereg_replace("\n\n",'<br /><br />',$content);
            // Handle line breaks
            $content = ereg_replace("\n",'<br />',$content);
            // Handle apostrophes
            $content = ereg_replace("'",'&#8217;',$content);
			$this->data['ImsRequisition']['purpose'] = $content;
			
			$this->autoRender = false;
			if ($this->ImsRequisition->save($this->data)) {
				$this->Session->setFlash(__('The ims requisition has been saved', true), '');
				$this->render('/elements/success');
			} else {
				$this->Session->setFlash(__('The ims requisition could not be saved. Please, try again.', true), '');
				$this->render('/elements/failure');
			}
		}
		$this->set('ims_requisition', $this->ImsRequisition->read(null, $id));
		
		if($parent_id) {
			$this->set('parent_id', $parent_id);
		}
			
		$budget_years = $this->ImsRequisition->BudgetYear->find('list');
		$branches = $this->ImsRequisition->Branch->find('list');
		$this->set(compact('budget_years', 'branches'));
	}
	
	function edit_manual_requisitions($id = null, $parent_id = null) {
		if (!$id && empty($this->data)) {
			$this->Session->setFlash(__('Invalid requisition', true), '');
			$this->redirect(array('action' => 'index'));
		}
		if (!empty($this->data)) {
			$this->autoRender = false;
			if ($this->ImsRequisition->save($this->data)) {
				$this->Session->setFlash(__('The ims requisition has been saved', true), '');
				$this->render('/elements/success');
			} else {
				$this->Session->setFlash(__('The ims requisition could not be saved. Please, try again.', true), '');
				$this->render('/elements/failure');
			}
		}
		$this->set('ims_requisition', $this->ImsRequisition->read(null, $id));
		
		if($parent_id) {
			$this->set('parent_id', $parent_id);
		}
			
		$budget_years = $this->ImsRequisition->BudgetYear->find('list');
		$branches = $this->ImsRequisition->Branch->find('all');
		$this->set(compact('budget_years', 'branches'));
	}

	function delete($id = null) {
		$this->autoRender = false;
		if (!$id) {
			$this->Session->setFlash(__('Invalid id for ims requisition', true), '');
			$this->render('/elements/failure');
		}
		if (stripos($id, '_') !== false) {
            $ids = explode('_', $id);
            try{
                foreach ($ids as $i) {
					$req = $this->ImsRequisition->read(null,$i);
					if($req['ImsRequisition']['status'] == 'created'){
						$this->ImsRequisition->delete($i);
					}
                }
				$this->Session->setFlash(__('Ims requisition deleted', true), '');
				$this->render('/elements/success');
            }
            catch (Exception $e){
				$this->Session->setFlash(__('Ims requisition was not deleted', true), '');
				$this->render('/elements/failure');
            }
        } else {
			$req = $this->ImsRequisition->read(null,$id);
			if($req['ImsRequisition']['status'] == 'created'){	
				if ($this->ImsRequisition->delete($id)) {
					$this->Session->setFlash(__('Ims requisition deleted', true), '');
					$this->render('/elements/success');
				} else {
					$this->Session->setFlash(__('Ims requisition was not deleted', true), '');
					$this->render('/elements/failure');
				}
			}
        }
	}
	
	function delete_manual_requisitions($id = null) {
		$this->autoRender = false;
		if (!$id) {
			$this->Session->setFlash(__('Invalid id for requisition', true), '');
			$this->render('/elements/failure');
		}
		if (stripos($id, '_') !== false) {
            $ids = explode('_', $id);
            try{
                foreach ($ids as $i) {
                    $this->ImsRequisition->delete($i);
                }
				$this->Session->setFlash(__('requisition deleted', true), '');
				$this->render('/elements/success');
            }
            catch (Exception $e){
				$this->Session->setFlash(__('requisition was not deleted', true), '');
				$this->render('/elements/failure');
            }
        } else {
            if ($this->ImsRequisition->delete($id)) {
				$this->Session->setFlash(__('requisition deleted', true), '');
				$this->render('/elements/success');
			} else {
				$this->Session->setFlash(__('requisition was not deleted', true), '');
				$this->render('/elements/failure');
			}
        }
	}
	
	function post($id = null) {
        $this->autoRender = false;
        if (!$id) {
            $this->Session->setFlash(__('Invalid id for requisition', true), '');
            $this->render('/elements/failure');
        }
        $requisition = array('ImsRequisition' => array('id' => $id, 'status' => 'posted'));
        if ($this->ImsRequisition->save($requisition)) {
            $this->Session->setFlash(__('requisition posted for approval', true), '');
            $this->render('/elements/success');
        } else {
            $this->Session->setFlash(__('requisition was not posted for approval', true), '');
            $this->render('/elements/failure');
        }
    }
	
	function approve($id = null) {
        $this->autoRender = false;
        if (!$id) {
            $this->Session->setFlash(__('Invalid id for requisition', true), '');
            $this->render('/elements/failure');
        }
		$user = $this->Session->read();		
        $requisition = array('ImsRequisition' => array('id' => $id, 'action_dt'=>date("Y-m-d H-i-s") , 'approved_rejected_by' => $user['Auth']['User']['id'],'status' => 'approved'));
        if ($this->ImsRequisition->save($requisition)) {
            $this->Session->setFlash(__('Requisition successfully approved', true), '');
            $this->render('/elements/success');
        } else {
            $this->Session->setFlash(__('Requisition was not successfully approved', true), '');
            $this->render('/elements/failure');
        }
    }
	
	function reject($id = null) {
        $this->autoRender = false;
        if (!$id) {
            $this->Session->setFlash(__('Invalid id for requisition', true), '');
            $this->render('/elements/failure');
        }
		$user = $this->Session->read();	
        $requisition = array('ImsRequisition' => array('id' => $id, 'approved_rejected_by' => $user['Auth']['User']['id'],'status' => 'rejected'));
        if ($this->ImsRequisition->save($requisition)) {
            $this->Session->setFlash(__('Requisition successfully rejected', true), '');
            $this->render('/elements/success');
        } else {
            $this->Session->setFlash(__('Requisition was not successfully rejected', true), '');
            $this->render('/elements/failure');
        }
    }
	
	function create_sirv_items($id = null,$storeId){
		global $items;
		$result = null;
		$item_code;
		$item_name;
		$quantity;
		$measurement;
		$requisitionItem;
		 
		 if (isset($_POST)) {			
			$this->ImsRequisition->id = $id;
			$requisition = $this->ImsRequisition->read(null, $id);
			if($requisition['ImsRequisition']['requested_by'] == $requisition['ImsRequisition']['approved_rejected_by']){
				$this->ImsRequisition->updateAll(
				array('ImsRequisition.status' => '"accepted"','ImsRequisition.sirv_created_by' => $this->Session->read('Auth.User.id')),
				array('ImsRequisition.id' => $id)
				);
			}
			else{
				$this->ImsRequisition->updateAll(
				array('ImsRequisition.status' => '"SIRV created"','ImsRequisition.sirv_created_by' => $this->Session->read('Auth.User.id')),
				array('ImsRequisition.id' => $id)
				);
				
				$this->loadModel('ImsDelegate');
				$conditionsdelegate['ImsDelegate.ims_requisition_id'] = $requisition['ImsRequisition']['id'];
				$delegate = $this->ImsDelegate->find('first', array('conditions' => $conditionsdelegate));
				if(!empty($delegate)){
					$this->ImsDelegate->id = $delegate['ImsDelegate']['id'];
					$this->ImsDelegate->delete();
				}
			}
			
			$this->loadModel('ImsItem');
			$this->loadModel('ImsRequisitionItem');
			foreach ($_POST as $key => $value) {
				$count=0;
				$tmpost = explode('^', $key);
				if($tmpost[1] == 'description')
				{
					$item_name = explode('"', $value);
					if($item_name[0] == ""){	
						$item_name = $item_name[1];
					}
					else $item_name = $item_name[0];
					$item_name = ereg_replace('&amp;','&',$item_name);
					
					$item = $this->ImsItem->find('first', array('conditions' => array('ImsItem.name' => $item_name)));
					$conditions = array('ImsRequisitionItem.ims_item_id' => $item['ImsItem']['id'],'ImsRequisitionItem.ims_requisition_id' => $id);
					$requisitionItem = $this->ImsRequisitionItem->find('first', array('conditions' =>$conditions));
				}
				else if($tmpost[1] == 'code')
				{					
					$item_code = explode('"', $value);
					if($item_code[0] == ""){	
						$item_code = $item_code[1];
					}
					else $item_code = $item_code[0];
					
					$itemid = $this->ImsItem->find('first', array('conditions' => array('ImsItem.description' => $item_code)));
					$this->ImsRequisitionItem->id = $requisitionItem['ImsRequisitionItem']['id'];					
					if($this->ImsRequisitionItem->saveField('ims_item_id', $itemid['ImsItem']['id'])){
						if($result != false || $result == null){
							$result = true;
						}
					}
					else {
						$result = false;
					}
				}				
				else if($tmpost[1] == 'measurement')
				{
					$measurement = explode('"', $value);
					if($measurement[0] == ""){	
						$measurement = $measurement[1];
					}
					else $measurement = $measurement[0];
					
					$this->ImsRequisitionItem->id = $requisitionItem['ImsRequisitionItem']['id'];					
					if($this->ImsRequisitionItem->saveField('measurement', $measurement)){
						if($result != false || $result == null){
							$result = true;
						}
					}
					else {
						$result = false;
					}
				}
				else if($tmpost[1] == 'issued')
				{
					$issued = explode('"', $value);
					if($issued[0] == ""){	
						$issued = $issued[1];
					}
					else $issued = $issued[0];
					
					$this->ImsRequisitionItem->id = $requisitionItem['ImsRequisitionItem']['id'];					
					if($this->ImsRequisitionItem->saveField('issued', $issued)){
						if($result != false || $result == null){
							$result = true;
						}
					}
					else {
						$result = false;
					}
				}				
			}
			if($result == true){
				$this->loadModel('ImsStoresCard');
				$this->data['ImsStoresCard']['ims_store_id'] = $storeId;
				$this->data['ImsStoresCard']['ims_requisition_id'] = $id;
				$this->ImsStoresCard->save($this->data);
				
				$this->ImsRequisition->id = $id;
				$this->ImsRequisition->saveField('ims_store_id', $storeId);
				
				if($requisition['ImsRequisition']['requested_by'] != $requisition['ImsRequisition']['approved_rejected_by']){
					$this->loadModel('Employee');
					$this->Employee->recursive = -1;
					$conditionsEmp = array('Employee.user_id' => $requisition['ImsRequisition']['requested_by']);
					$employee = $this->Employee->find('first', array('conditions' =>$conditionsEmp));
					$sup_tel=$employee['Employee']['telephone'];
					$message=urlencode('SIRV created for your items request. Please accept it on Abay ERP Requisition form');
					file_get_contents('http://10.1.85.10/sms_manager/send_erp.php?redirect='.urlencode($_SERVER["REDIRECT_URL"]).'&to='.$sup_tel.'&msg='.$message);
				}
				
				$this->Session->setFlash(__('SIRV created Successfully', true), '');
				$this->render('/elements/success');
			}
			else {
				$this->Session->setFlash(__('SIRV not created', false), '');
				$this->render('/elements/failure');
			}	
		 }
		 else{
			$this->Session->setFlash(__('SIRV not created', false), '');
			$this->render('/elements/failure');
		 }
	}

	function accept_sirv_items($id = null){
		
		 if (isset($_POST)) {			
			$this->ImsRequisition->id = $id;
			if($this->ImsRequisition->saveField('status', 'accepted')){	
				$this->Session->setFlash(__('SIRV accepted Successfully', true), '');
				$this->render('/elements/success');
			}
			else {
				$this->Session->setFlash(__('SIRV not accepted', false), '');
				$this->render('/elements/failure');
			}	
		 }
		 else{
			$this->Session->setFlash(__('SIRV not accepted', false), '');
			$this->render('/elements/failure');
		 }
	}
	
	function receive_sirv_items($id = null){
		
		 if (isset($_POST)) {			
			$this->ImsRequisition->id = $id;
			if($this->ImsRequisition->saveField('status', 'received')){
				$requisition = $this->ImsRequisition->read(null,$id);
				$this->loadModel('ImsStore');
				$store = $this->ImsStore->read(null,$requisition['ImsRequisition']['ims_store_id']);
				$this->loadModel('Employee'); 
				$this->Employee->recursive =-1;	
				if($store['ImsStore']['store_keeper_one'] != null){							
					$conditions =array('Employee.user_id' => $store['ImsStore']['store_keeper_one']);  			
					$employee = $this->Employee->find('all', array('conditions' => $conditions));
					$message=urlencode($requisition['ImsRequisition']['name'].' requisition is received');
				//	file_get_contents('http://10.1.85.10/sms_manager/send_erp.php?redirect='.urlencode($_SERVER["REDIRECT_URL"]).'&to='.$employee[0]['Employee']['telephone'].'&msg='.$message);
				}
				if($store['ImsStore']['store_keeper_two'] != null){						
					$conditions =array('Employee.user_id' => $store['ImsStore']['store_keeper_two']);  			
					$employee = $this->Employee->find('all', array('conditions' => $conditions));
					$message=urlencode($requisition['ImsRequisition']['name'].' requisition is received');
				//	file_get_contents('http://10.1.85.10/sms_manager/send_erp.php?redirect='.urlencode($_SERVER["REDIRECT_URL"]).'&to='.$employee[0]['Employee']['telephone'].'&msg='.$message);
				}
				if($store['ImsStore']['store_keeper_three'] != null){						
					$conditions =array('Employee.user_id' => $store['ImsStore']['store_keeper_three']);  			
					$employee = $this->Employee->find('all', array('conditions' => $conditions));
					$message=urlencode($requisition['ImsRequisition']['name'].' requisition is received');
				//	file_get_contents('http://10.1.85.10/sms_manager/send_erp.php?redirect='.urlencode($_SERVER["REDIRECT_URL"]).'&to='.$employee[0]['Employee']['telephone'].'&msg='.$message);
				}
				if($store['ImsStore']['store_keeper_four'] != null){						
					$conditions =array('Employee.user_id' => $store['ImsStore']['store_keeper_four']);  			
					$employee = $this->Employee->find('all', array('conditions' => $conditions));
					$message=urlencode($requisition['ImsRequisition']['name'].' requisition is received');
				//	file_get_contents('http://10.1.85.10/sms_manager/send_erp.php?redirect='.urlencode($_SERVER["REDIRECT_URL"]).'&to='.$employee[0]['Employee']['telephone'].'&msg='.$message);
				}
				$this->Session->setFlash(__('SIRV received Successfully', true), '');
				$this->render('/elements/success');
			}
			else {
				$this->Session->setFlash(__('SIRV not received', false), '');
				$this->render('/elements/failure');
			}	
		 }
		 else{
			$this->Session->setFlash(__('SIRV not received', false), '');
			$this->render('/elements/failure');
		 }
	}
	
	function deny_sirv_items($id = null){
		
		 if (isset($_POST)) {			
			$this->ImsRequisition->id = $id;
			if($this->ImsRequisition->saveField('status', 'denied')){	
				$this->Session->setFlash(__('SIRV denied Successfully', true), '');
				$this->render('/elements/success');
			}
			else {
				$this->Session->setFlash(__('SIRV not denied', false), '');
				$this->render('/elements/failure');
			}	
		 }
		 else{
			$this->Session->setFlash(__('SIRV not denied', false), '');
			$this->render('/elements/failure');
		 }
	}
	
	function print_sirv($id = null){
        $this->layout = 'print_layout';
        
        if (!$id) {
            $this->autoRender = false;
            $this->Session->setFlash(__('Invalid id for sirv', true), '');
            $this->render('/elements/failure');
        }
        $this->ImsRequisition->recursive = 2;
        $this->set('sirv', $this->ImsRequisition->read(null, $id));
    }
	
	function getbranch(){
		$id = $this->params['branchid'];
		$this->loadModel('Branch');
		$branch = $this->Branch->read(null,$id);
		return $branch['Branch']['name']; 
	}
	
	function getitem()
	{
		$id = $this->params['itemid'];
		$this->loadModel('ImsItem');
		$item = $this->ImsItem->read(null,$id);
		return $item['ImsItem']; 
	}
	
	function getUser(){
		$userid = $this->params['userid'];	
		$this->loadModel('User');
		$conditions = array('User.id' => $userid);
		$this->User->recursive = 0;
		$user = $this->User->find('first',array('conditions' => $conditions));	
		return $user;
	}
	
	function getEmployee(){
		$userid = $this->params['userid'];	
		$this->loadModel('Employee');
		$conditions = array('Employee.user_id' => $userid);
		$this->Employee->recursive = -1;
		$user = $this->Employee->find('first',array('conditions' => $conditions));	
		return $user;
	}
	
	function index_request_progress($id = null) {
	    
    }
	
	function request_progress($id = null) {
	    $this->layout = 'ajax';		
		
        if (!empty($this->data)) {
            $status = $this->data['ImsRequisition']['status'];			
			
			$this->ImsRequisition->recursive = 0;			
			$conditionsreq =array('ImsRequisition.status' => $status);  						 
			$requisitions = $this->ImsRequisition->find('all', array('conditions' => $conditionsreq));
			
			$result = array();
			$count = 0;
			
			for($j=0; $j<count($requisitions ); $j++){ 
				$result[$j][0] = ++$count;
				$result[$j][1] = $requisitions[$j]['ImsRequisition']['name'];
				$result[$j][2] = $requisitions[$j]['Branch']['name'];
				$result[$j][3] = date("F j, Y", strtotime($requisitions[$j]['ImsRequisition']['created']));
				$result[$j][4] = date("F j, Y", strtotime($requisitions[$j]['ImsRequisition']['modified']));
				$date2 = date_create(date());
				$date1 = date_create($requisitions[$j]['ImsRequisition']['modified']);
				$difference = date_diff($date1,$date2);
				$result[$j][5] = $difference->format("%a");
			}
						
			$this->set('result',$result);
        }	
    }
}
?>