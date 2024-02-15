<?php
class ImsBudgetItemsController extends ImsAppController {

	var $name = 'ImsBudgetItems';
	
	function index() {
		$ims_budgets = $this->ImsBudgetItem->ImsBudget->find('all');
		$this->set(compact('ims_budgets'));
	}
	
	function index2($id = null) {
		$this->set('parent_id', $id);
		print_r($id);
	}

	function search() {
	}
	
	function list_data($id = null) {
		$start = (isset($_REQUEST['start'])) ? $_REQUEST['start'] : 0;
		$limit = (isset($_REQUEST['limit'])) ? $_REQUEST['limit'] : 5;
		$imsbudget_id = (isset($_REQUEST['ims_budget_id'])) ? $_REQUEST['ims_budget_id'] : -1;
		if($id)
			$imsbudget_id = ($id) ? $id : -1;
        $conditions = (isset($_REQUEST['conditions'])) ? $_REQUEST['conditions'] : '';

        eval("\$conditions = array( " . $conditions . " );");
		if ($imsbudget_id != -1) {
            $conditions['ImsBudgetItem.ims_budget_id'] = $imsbudget_id;
        }		
		
		$this->set('ims_budget_items', $this->ImsBudgetItem->find('all', array('conditions' => $conditions, 'limit' => $limit, 'offset' => $start)));
		$this->set('results', $this->ImsBudgetItem->find('count', array('conditions' => $conditions)));
	}

	function view($id = null) {
		if (!$id) {
			$this->Session->setFlash(__('Invalid ims budget item', true));
			$this->redirect(array('action' => 'index'));
		}
		$this->ImsBudgetItem->recursive = 2;
		$this->set('imsBudgetItem', $this->ImsBudgetItem->read(null, $id));
	}

	function add($id = null) {
		if (!empty($this->data)) {
			$this->ImsBudgetItem->create();
			$this->autoRender = false;
			if ($this->ImsBudgetItem->save($this->data)) {
				$this->Session->setFlash(__('The budget item has been saved', true), '');
				$this->render('/elements/success');
			} else {
				$this->Session->setFlash(__('The budget item could not be saved. Please, try again.', true), '');
				$this->render('/elements/failure');
			}
		}
		if($id)
			$this->set('parent_id', $id);
		$ims_budgets = $this->ImsBudgetItem->ImsBudget->recursive = -1;
		$ims_budgets = $this->ImsBudgetItem->ImsBudget->find('list');
		
		$array[] = null;
		$array2[] = null;
		$this->ImsBudgetItem->ImsItem->recursive = -1;
		$items = $this->ImsBudgetItem->ImsItem->find('all');
		foreach($items as $item){			
			$array[] = $item['ImsItem'];			
		}
		
		$this->ImsBudgetItem->recursive = 0;
		$conditions = array('ImsBudget.id' => $id);
		$budgetitems =$this->ImsBudgetItem->find('all',array('conditions' => $conditions));
		if(!empty($budgetitems)){
			foreach($budgetitems as $budgetitem){
				$array2[] = $budgetitem['ImsItem'];				
			}
		}
		$results = array_diff(array_map('serialize',$array),array_map('serialize',$array2));
		$results = array_map('unserialize',$results);
		
		$this->set(compact('ims_budgets', 'results'));
	}

	function edit($id = null, $parent_id = null) {
		if (!$id && empty($this->data)) {
			$this->Session->setFlash(__('Invalid budget item', true), '');
			$this->redirect(array('action' => 'index'));
		}
		if (!empty($this->data)) {
			$this->autoRender = false;
			if ($this->ImsBudgetItem->save($this->data)) {
				$this->Session->setFlash(__('The budget item has been saved', true), '');
				$this->render('/elements/success');
			} else {
				$this->Session->setFlash(__('The budget item could not be saved. Please, try again.', true), '');
				$this->render('/elements/failure');
			}
		}
		$this->set('ims_budget_item', $this->ImsBudgetItem->read(null, $id));
		
		if($parent_id) {
			$this->set('parent_id', $parent_id);
		}
			
		$ims_budgets = $this->ImsBudgetItem->ImsBudget->find('list');
		
		$array[] = null;
		$array2[] = null;
		$items = $this->ImsBudgetItem->ImsItem->find('all');
		foreach($items as $item){			
			$array[] = $item['ImsItem'];			
		}
		
		$this->ImsBudgetItem->recursive = 0;
		$conditions = array('ImsBudget.id' => $parent_id, 'ImsBudgetItem.id !=' => $id);
		$budgetitems =$this->ImsBudgetItem->find('all',array('conditions' => $conditions));
		if(!empty($budgetitems)){
			foreach($budgetitems as $budgetitem){
				$array2[] = $budgetitem['ImsItem'];				
			}
		}
		$results = array_diff(array_map('serialize',$array),array_map('serialize',$array2));
		$results = array_map('unserialize',$results);
		
		$this->set(compact('ims_budgets', 'results'));
	}

	function delete($id = null) {
		$this->autoRender = false;
		if (!$id) {
			$this->Session->setFlash(__('Invalid id for budget item', true), '');
			$this->render('/elements/failure');
		}
		if (stripos($id, '_') !== false) {
            $ids = explode('_', $id);
            try{
                foreach ($ids as $i) {
                    $this->ImsBudgetItem->delete($i);
                }
				$this->Session->setFlash(__('budget item deleted', true), '');
				$this->render('/elements/success');
            }
            catch (Exception $e){
				$this->Session->setFlash(__('budget item was not deleted', true), '');
				$this->render('/elements/failure');
            }
        } else {
            if ($this->ImsBudgetItem->delete($id)) {
				$this->Session->setFlash(__('budget item deleted', true), '');
				$this->render('/elements/success');
			} else {
				$this->Session->setFlash(__('budget item was not deleted', true), '');
				$this->render('/elements/failure');
			}
        }
	}
	
	function GetItemCategory()
	{
		$categoryid = $this->params['categoryid'];
		$this->loadModel('ImsItemCategory');
		$conditions = array('ImsItemCategory.id' => $categoryid);
		$category = $this->ImsItemCategory->find('first',array('conditions' => $conditions));
		return $category['ImsItemCategory']['name'];
	}
}
?>