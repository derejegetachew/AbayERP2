<?php
class ImsBudgetsController extends ImsAppController {

	var $name = 'ImsBudgets';
	
	function index() {
		$budget_years = $this->ImsBudget->BudgetYear->find('all');
		$this->set(compact('budget_years'));
	}
	
	function index2($id = null) {
		$this->set('parent_id', $id);
	}

	function search() {
	}
	
	function list_data($id = null) {
		$start = (isset($_REQUEST['start'])) ? $_REQUEST['start'] : 0;
		$limit = (isset($_REQUEST['limit'])) ? $_REQUEST['limit'] : 5;
		$budgetyear_id = (isset($_REQUEST['budget_year_id'])) ? $_REQUEST['budget_year_id'] : -1;
		if($id)
			$budgetyear_id = ($id) ? $id : -1;
        $conditions = (isset($_REQUEST['conditions'])) ? $_REQUEST['conditions'] : '';

        eval("\$conditions = array( " . $conditions . " );");
		if ($budgetyear_id != -1) {
            $conditions['ImsBudget.budget_year_id'] = $budgetyear_id;
        }		
		
		$this->set('ims_budgets', $this->ImsBudget->find('all', array('conditions' => $conditions, 'limit' => $limit, 'offset' => $start)));
		$this->set('results', $this->ImsBudget->find('count', array('conditions' => $conditions)));
	}

	function view($id = null) {
		if (!$id) {
			$this->Session->setFlash(__('Invalid budget', true));
			$this->redirect(array('action' => 'index'));
		}
		$this->ImsBudget->recursive = 2;
		$this->set('imsBudget', $this->ImsBudget->read(null, $id));
	}

	function add($id = null) {
		if (!empty($this->data)) {			
				$this->ImsBudget->create();
				$this->autoRender = false;
				if ($this->ImsBudget->save($this->data)) {
					$this->Session->setFlash(__('The budget has been saved', true) . '::' . $this->ImsBudget->id, '');
					$this->render('/elements/success_po');
				} else {
					$this->Session->setFlash(__('The budget could not be saved. Please, try again.', true), '');
					$this->render('/elements/failure');
				}
		}
		if($id)
			$this->set('parent_id', $id);
		
		$budget_year;
		$date = new DateTime("now");		
		$this->ImsBudget->BudgetYear->recursive = 0;
		$budget_years = $this->ImsBudget->BudgetYear->find('all');
		foreach($budget_years as $budget_year){			
			if(!empty($budget_year))
			{
				if(new DateTime($budget_year['BudgetYear']['to_date'])>($date))
				{
					$budget_year =$budget_year['BudgetYear'];
				}
			}
		}
		$array[] = null;
		$array2[] = null;
		$this->ImsBudget->recursive = 0;
		$conditions = array('ImsBudget.budget_year_id' =>$budget_year['id']);
		$budgets =$this->ImsBudget->find('all',array('conditions' => $conditions));
		if(!empty($budgets)){
			foreach($budgets as $budget){
				$array[] = $budget['Branch'];				
			}
		}
		$this->ImsBudget->Branch->recursive = -1;
		$branches = $this->ImsBudget->Branch->find('all');
		foreach($branches as $branch){			
			$array2[] = $branch['Branch'];			
		}
		$results = array_diff(array_map('serialize',$array2),array_map('serialize',$array));
		$results = array_map('unserialize',$results);
		$this->set(compact('budget_year', 'results'));
	}

	function edit($id = null, $parent_id = null) {
		if (!$id && empty($this->data)) {
			$this->Session->setFlash(__('Invalid budget', true), '');
			$this->redirect(array('action' => 'index'));
		}
		if (!empty($this->data)) {
			$this->autoRender = false;
			if ($this->ImsBudget->save($this->data)) {
				$this->Session->setFlash(__('The budget has been saved', true), '');
				$this->render('/elements/success');
			} else {
				$this->Session->setFlash(__('The budget could not be saved. Please, try again.', true), '');
				$this->render('/elements/failure');
			}
		}
		$this->set('ims_budget', $this->ImsBudget->read(null, $id));
		
		if($parent_id) {
			$this->set('parent_id', $parent_id);
		}
			
		$budget_year;
		$date = new DateTime("now");		
		$this->ImsBudget->BudgetYear->recursive = 0;
		$budget_years = $this->ImsBudget->BudgetYear->find('all');
		foreach($budget_years as $budget_year){			
			if(!empty($budget_year))
			{
				if(new DateTime($budget_year['BudgetYear']['to_date'])>($date))
				{
					$budget_year =$budget_year['BudgetYear'];
				}
			}
		}
		$array[] = null;
		$array2[] = null;
		$this->ImsBudget->recursive = 0;
		$conditions = array('ImsBudget.budget_year_id' =>$budget_year['id'], 'ImsBudget.id !=' => $id);
		$budgets =$this->ImsBudget->find('all',array('conditions' => $conditions));
		if(!empty($budgets)){
			foreach($budgets as $budget){
				$array[] = $budget['Branch'];				
			}
		}
		$this->ImsBudget->Branch->recursive = -1;
		$branches = $this->ImsBudget->Branch->find('all');
		foreach($branches as $branch){			
			$array2[] = $branch['Branch'];			
		}
		$results = array_diff(array_map('serialize',$array2),array_map('serialize',$array));
		$results = array_map('unserialize',$results);
		$this->set(compact('budget_year', 'results'));
	}

	function delete($id = null) {
		$this->autoRender = false;
		if (!$id) {
			$this->Session->setFlash(__('Invalid id for budget', true), '');
			$this->render('/elements/failure');
		}
		if (stripos($id, '_') !== false) {
            $ids = explode('_', $id);
            try{
                foreach ($ids as $i) {
                    $this->ImsBudget->delete($i);
                }
				$this->Session->setFlash(__('budget deleted', true), '');
				$this->render('/elements/success');
            }
            catch (Exception $e){
				$this->Session->setFlash(__('budget was not deleted', true), '');
				$this->render('/elements/failure');
            }
        } else {
            if ($this->ImsBudget->delete($id)) {
				$this->Session->setFlash(__('budget deleted', true), '');
				$this->render('/elements/success');
			} else {
				$this->Session->setFlash(__('budget was not deleted', true), '');
				$this->render('/elements/failure');
			}
        }
	}
	
	 function add_budget_items($id = null) {
        $this->set('budget_id', $id);
	}
}
?>