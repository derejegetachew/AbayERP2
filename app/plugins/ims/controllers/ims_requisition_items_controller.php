<?php
class ImsRequisitionItemsController extends AppController {

	var $name = 'ImsRequisitionItems';
	
	function index() {
		$ims_requisitions = $this->ImsRequisitionItem->ImsRequisition->find('all');
		$this->set(compact('ims_requisitions'));
	}
	
	function index2($id = null) {
		$this->set('parent_id', $id);
	}

	function search() {
	}
	
	function list_data($id = null) {
		$start = (isset($_REQUEST['start'])) ? $_REQUEST['start'] : 0;
		$limit = (isset($_REQUEST['limit'])) ? $_REQUEST['limit'] : 20;
		$imsrequisition_id = (isset($_REQUEST['imsrequisition_id'])) ? $_REQUEST['imsrequisition_id'] : -1;
		
		if($id)
			$imsrequisition_id = ($id) ? $id : -1;
        $conditions = (isset($_REQUEST['conditions'])) ? $_REQUEST['conditions'] : '';

        eval("\$conditions = array( " . $conditions . " );");
		if ($imsrequisition_id != -1) {
            $conditions['ImsRequisitionItem.ims_requisition_id'] = $imsrequisition_id;
        }
		
		$this->set('ims_requisition_items', $this->ImsRequisitionItem->find('all', array('conditions' => $conditions, 'limit' => $limit, 'offset' => $start)));
		$this->set('results', $this->ImsRequisitionItem->find('count', array('conditions' => $conditions)));
	}

	function view($id = null) {
		if (!$id) {
			$this->Session->setFlash(__('Invalid requisition item', true));
			$this->redirect(array('action' => 'index'));
		}
		$this->ImsRequisitionItem->recursive = 2;
		$this->set('imsRequisitionItem', $this->ImsRequisitionItem->read(null, $id));
	}

	function add($id = null) {
		if (!empty($this->data)) {
			/*
			$requisition = $this->ImsRequisitionItem->ImsRequisition->read(null,$this->data['ImsRequisitionItem']['ims_requisition_id']);
			
			$this->loadModel('ImsBudget');
			$conditions = array('ImsBudget.budget_year_id' => $requisition['ImsRequisition']['budget_year_id'],'ImsBudget.branch_id' => $requisition['ImsRequisition']['branch_id']);
			$budget = $this->ImsBudget->find('first',array('conditions' => $conditions));
			if(!empty($budget)) {
				$this->loadModel('ImsBudgetItem');
				$conditions = array('ImsBudgetItem.ims_budget_id' => $budget['ImsBudget']['id']);
				$budgetitems = $this->ImsBudgetItem->find('all',array('conditions' => $conditions));
				
				foreach($budgetitems as $budgetitem){
					if($budgetitem['ImsBudgetItem']['ims_item_id'] == $this->data['ImsRequisitionItem']['ims_item_id'] and ($budgetitem['ImsBudgetItem']['quantity'] - $budgetitem['ImsBudgetItem']['used']) >= $this->data['ImsRequisitionItem']['quantity']){
						$this->ImsRequisitionItem->create();
						$this->autoRender = false;
						if ($this->ImsRequisitionItem->save($this->data)) {
							$this->Session->setFlash(__('The requisition item has been saved', true), '');
							$this->render('/elements/success');
						} else {
							$this->Session->setFlash(__('The requisition item could not be saved. Please, try again.', true), '');
							$this->render('/elements/failure');
						}
						break;
					}else if($budgetitem['ImsBudgetItem']['ims_item_id'] == $itemid and ($budgetitem['ImsBudgetItem']['quantity'] - $budgetitem['ImsBudgetItem']['used']) < $quantity){
						$left = $budgetitem['ImsBudgetItem']['quantity'] - $budgetitem['ImsBudgetItem']['used'];
						$this->Session->setFlash(__('Out of Budget, make it '.$left, true), '');
						$this->render('/elements/failure3');
						break;
					}			
				}
				$this->Session->setFlash(__('No Budget', true), '');
				$this->render('/elements/failure3');
			}		
			else{
				$this->Session->setFlash(__('No Budget', true), '');
				$this->render('/elements/failure3');
			}
			*/
			
			$this->ImsRequisitionItem->create();
			$this->autoRender = false;
			if ($this->ImsRequisitionItem->save($this->data)) {
				$this->Session->setFlash(__('The requisition item has been saved', true), '');
				$this->render('/elements/success');
			} else {
				$this->Session->setFlash(__('The requisition item could not be saved. Please, try again.', true), '');
				$this->render('/elements/failure');
			}
		}
		if($id)
			$this->set('parent_id', $id);			
		//$ims_requisitions = $this->ImsRequisitionItem->ImsRequisition->find('list');
		
		$array[] = null;
		$array2[] = null;
		$this->ImsRequisitionItem->ImsItem->recursive = 0;
		$items = $this->ImsRequisitionItem->ImsItem->find('all');
		foreach($items as $item){			
			$array[] = $item['ImsItem'];			
		}
		
		$this->ImsRequisitionItem->recursive = 0;
		$conditions = array('ImsRequisition.id' => $id);
		$requisitionitems =$this->ImsRequisitionItem->find('all',array('conditions' => $conditions));
		if(!empty($requisitionitems)){
			foreach($requisitionitems as $requisitionitem){
				$array2[] = $requisitionitem['ImsItem'];				
			}
		}
		$results = array_diff(array_map('serialize',$array),array_map('serialize',$array2));
		$results = array_map('unserialize',$results);
		
		//$this->set(compact('ims_requisitions', 'results'));
		$this->set(compact('results'));
	}

	function edit($id = null, $parent_id = null) {
		if (!$id && empty($this->data)) {
			$this->Session->setFlash(__('Invalid requisition item', true), '');
			$this->redirect(array('action' => 'index'));
		}
		if (!empty($this->data)) {
			$this->autoRender = false;
			if ($this->ImsRequisitionItem->save($this->data)) {
				$this->Session->setFlash(__('The requisition item has been saved', true), '');
				$this->render('/elements/success');
			} else {
				$this->Session->setFlash(__('The requisition item could not be saved. Please, try again.', true), '');
				$this->render('/elements/failure');
			}
		}
		$this->set('ims_requisition_item', $this->ImsRequisitionItem->read(null, $id));
		
		if($parent_id) {
			$this->set('parent_id', $parent_id);
		}
			
		$ims_requisitions = $this->ImsRequisitionItem->ImsRequisition->find('list');
		
		$array = array();
		$array2 = array();
		$items = $this->ImsRequisitionItem->ImsItem->find('all');
		foreach($items as $item){			
			$array[] = $item['ImsItem'];			
		}
		
		$this->ImsRequisitionItem->recursive = 0;
		$conditions = array('ImsRequisition.id' => $parent_id, 'ImsRequisitionItem.id !=' => $id);
		$requisitionitems =$this->ImsRequisitionItem->find('all',array('conditions' => $conditions));
		if(!empty($requisitionitems)){
			foreach($requisitionitems as $requisitionitem){
				$array2[] = $requisitionitem['ImsItem'];				
			}
		}
		$results = array_diff(array_map('serialize',$array),array_map('serialize',$array2));
		$results = array_map('unserialize',$results);
		
		$this->set(compact('ims_requisitions', 'results'));
	}

	function delete($id = null) {
		$this->autoRender = false;
		if (!$id) {
			$this->Session->setFlash(__('Invalid id for requisition item', true), '');
			$this->render('/elements/failure');
		}
		if (stripos($id, '_') !== false) {
            $ids = explode('_', $id);
            try{
                foreach ($ids as $i) {
                    $this->ImsRequisitionItem->delete($i);
                }
				$this->Session->setFlash(__('requisition item deleted', true), '');
				$this->render('/elements/success');
            }
            catch (Exception $e){
				$this->Session->setFlash(__('requisition item was not deleted', true), '');
				$this->render('/elements/failure');
            }
        } else {
            if ($this->ImsRequisitionItem->delete($id)) {
				$this->Session->setFlash(__('requisition item deleted', true), '');
				$this->render('/elements/success');
			} else {
				$this->Session->setFlash(__('requisition item was not deleted', true), '');
				$this->render('/elements/failure');
			}
        }
	}
	
	function budget(){	
		$itemid = $this->params['itemid'];
		$branchid = $this->params['branchid'];
		$budgetyearid = $this->params['budgetyearid'];
		$quantity = $this->params['quantity'];
		
		$this->loadModel('ImsBudget');
		$conditions = array('ImsBudget.budget_year_id' => $budgetyearid,'ImsBudget.branch_id' => $branchid);
		$budget = $this->ImsBudget->find('first',array('conditions' => $conditions));
	
		$this->loadModel('ImsBudgetItem');
		$conditions = array('ImsBudgetItem.ims_budget_id' => $budget['ImsBudget']['id']);
		$budgetitems = $this->ImsBudgetItem->find('all',array('conditions' => $conditions));
		
		foreach($budgetitems as $budgetitem){
			if($budgetitem['ImsBudgetItem']['ims_item_id'] == $itemid and ($budgetitem['ImsBudgetItem']['quantity'] - $budgetitem['ImsBudgetItem']['used']) >= $quantity){
				return 'Within Budget';
				break;
			}else if($budgetitem['ImsBudgetItem']['ims_item_id'] == $itemid and ($budgetitem['ImsBudgetItem']['quantity'] - $budgetitem['ImsBudgetItem']['used']) < $quantity){
				return 'Out of Budget';
				break;
			}			
		}
		return 'No Budget';
	}
}
?>