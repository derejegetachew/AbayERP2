<?php
class PerformanceResultsController extends AppController {

	var $name = 'PerformanceResults';
	
	function index() {
		
		$employees = $this->PerformanceResult->Employee->find('all');
		$this->set(compact('employees'));
	}
	
	function index2($id = null) {
		$this->set('parent_id', $id);
		/*$loopbu=$this->PerformanceResult->BudgetYear->find('all');
		$conditions['PerformanceResult.employee_id']=$id;
		foreach($loopbu as $loopb){
			$conditions['PerformanceResult.budget_year_id']=$loopb['BudgetYear']['id'];
			$fnd=$this->PerformanceResult->find('count', array('conditions' => $conditions));
			if($fnd==0){
				$this->data['PerformanceResult']['budget_year_id']=$loopb['BudgetYear']['id'];
				$this->data['PerformanceResult']['employee_id']=$id;
				$this->data['PerformanceResult']['first']=0;
				$this->data['PerformanceResult']['second']=0;
				$this->data['PerformanceResult']['average']=0;
				$this->PerformanceResult->create();
				$this->PerformanceResult->save($this->data);
				
			}
		}*/
			$conditions['PerformanceResult.employee_id']=$id;
			$conditions['PerformanceResult.budget_year_id']=15;
			$fnd=$this->PerformanceResult->find('count', array('conditions' => $conditions));
			if($fnd==0){
				$this->data['PerformanceResult']['budget_year_id']=15;
				$this->data['PerformanceResult']['employee_id']=$id;
				$this->PerformanceResult->create();
				$this->PerformanceResult->save($this->data);
			}
		
	}

	function search() {
	}
	
	function list_data($id = null) {
		$start = (isset($_REQUEST['start'])) ? $_REQUEST['start'] : 0;
		$limit = (isset($_REQUEST['limit'])) ? $_REQUEST['limit'] : 5;
		$employee_id = (isset($_REQUEST['employee_id'])) ? $_REQUEST['employee_id'] : -1;
		if($id)
			$employee_id = ($id) ? $id : -1;
        $conditions = (isset($_REQUEST['conditions'])) ? $_REQUEST['conditions'] : '';

        eval("\$conditions = array( " . $conditions . " );");
		if ($employee_id != -1) {
            $conditions['PerformanceResult.employee_id'] = $employee_id;
        }
		
		$this->set('performance_results', $this->PerformanceResult->find('all', array('conditions' => $conditions, 'limit' => $limit, 'offset' => $start)));
		$this->set('results', $this->PerformanceResult->find('count', array('conditions' => $conditions)));
	}

	function view($id = null) {
		if (!$id) {
			$this->Session->setFlash(__('Invalid performance result', true));
			$this->redirect(array('action' => 'index'));
		}
		$this->PerformanceResult->recursive = 2;
		$this->set('performanceResult', $this->PerformanceResult->read(null, $id));
	}

	function add($id = null) {
		if (!empty($this->data)) {
			$this->PerformanceResult->create();
			$this->autoRender = false;
			if ($this->PerformanceResult->save($this->data)) {
				$this->Session->setFlash(__('The performance result has been saved', true), '');
				$this->render('/elements/success');
			} else {
				$this->Session->setFlash(__('The performance result could not be saved. Please, try again.', true), '');
				$this->render('/elements/failure');
			}
		}
		if($id)
			$this->set('parent_id', $id);
		$employees = $this->PerformanceResult->Employee->find('list');
		$budget_years = $this->PerformanceResult->BudgetYear->find('list');
		$employees = $this->PerformanceResult->Employee->find('list');
		$this->set(compact('employees', 'budget_years', 'employees'));
	}

	function edit($id = null, $parent_id = null) {
		if (!$id && empty($this->data)) {
			$this->Session->setFlash(__('Invalid performance result', true), '');
			$this->redirect(array('action' => 'index'));
		}
		if (!empty($this->data)) {
			$this->autoRender = false;
			$i=0;
			if(!empty($this->data['PerformanceResult']['first']))
			$i++;
			if(!empty($this->data['PerformanceResult']['second']))
			$i++;
			if(!empty($this->data['PerformanceResult']['third']))
			$i++;
			if(!empty($this->data['PerformanceResult']['fourth']))
			$i++;
			if($i>0)
			$this->data['PerformanceResult']['average']=($this->data['PerformanceResult']['first']+$this->data['PerformanceResult']['second']+$this->data['PerformanceResult']['third']+$this->data['PerformanceResult']['fourth'])/$i;
			else
			$this->data['PerformanceResult']['average']=null;
			if ($this->PerformanceResult->save($this->data)) {
				$this->Session->setFlash(__('The performance result has been saved', true), '');
				$this->render('/elements/success');
			} else {
				$this->Session->setFlash(__('The performance result could not be saved. Please, try again.', true), '');
				$this->render('/elements/failure');
			}
		}
		$this->set('performance_result', $this->PerformanceResult->read(null, $id));
		
		if($parent_id) {
			$this->set('parent_id', $parent_id);
		}
			
		$employees = $this->PerformanceResult->Employee->find('list');
		$budget_years = $this->PerformanceResult->BudgetYear->find('list');
		$employees = $this->PerformanceResult->Employee->find('list');
		$this->set(compact('employees', 'budget_years', 'employees'));
	}

	function delete($id = null) {
		$this->autoRender = false;
		if (!$id) {
			$this->Session->setFlash(__('Invalid id for performance result', true), '');
			$this->render('/elements/failure');
		}
		if (stripos($id, '_') !== false) {
            $ids = explode('_', $id);
            try{
                foreach ($ids as $i) {
                    $this->PerformanceResult->delete($i);
                }
				$this->Session->setFlash(__('Performance result deleted', true), '');
				$this->render('/elements/success');
            }
            catch (Exception $e){
				$this->Session->setFlash(__('Performance result was not deleted', true), '');
				$this->render('/elements/failure');
            }
        } else {
            if ($this->PerformanceResult->delete($id)) {
				$this->Session->setFlash(__('Performance result deleted', true), '');
				$this->render('/elements/success');
			} else {
				$this->Session->setFlash(__('Performance result was not deleted', true), '');
				$this->render('/elements/failure');
			}
        }
	}
}
?>