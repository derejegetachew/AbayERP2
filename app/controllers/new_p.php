<?php
class PerformanceExcelReportsController extends AppController {

	var $name = 'PerformanceExcelReports';
	
	function index() {
		$budget_years = $this->PerformanceExcelReport->BudgetYear->find('all');
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
		$budgetyear_id = (isset($_REQUEST['budgetyear_id'])) ? $_REQUEST['budgetyear_id'] : -1;
		if($id)
			$budgetyear_id = ($id) ? $id : -1;
        $conditions = (isset($_REQUEST['conditions'])) ? $_REQUEST['conditions'] : '';

        eval("\$conditions = array( " . $conditions . " );");
		if ($budgetyear_id != -1) {
            $conditions['PerformanceExcelReport.budgetyear_id'] = $budgetyear_id;
        }
		
		$this->set('performanceExcelReports', $this->PerformanceExcelReport->find('all', array('conditions' => $conditions, 'limit' => $limit, 'offset' => $start)));
		$this->set('results', $this->PerformanceExcelReport->find('count', array('conditions' => $conditions)));
	}

	function view($id = null) {
		if (!$id) {
			$this->Session->setFlash(__('Invalid performance excel report', true));
			$this->redirect(array('action' => 'index'));
		}
		$this->PerformanceExcelReport->recursive = 2;
		$this->set('performanceExcelReport', $this->PerformanceExcelReport->read(null, $id));
	}

	function add($id = null) {
		if (!empty($this->data)) {
			$this->PerformanceExcelReport->create();
			$this->autoRender = false;
			if ($this->PerformanceExcelReport->save($this->data)) {
				$this->Session->setFlash(__('The performance excel report has been saved', true), '');
				$this->render('/elements/success');
			} else {
				$this->Session->setFlash(__('The performance excel report could not be saved. Please, try again.', true), '');
				$this->render('/elements/failure');
			}
		}
		if($id)
			$this->set('parent_id', $id);
		$budget_years = $this->PerformanceExcelReport->BudgetYear->find('list');
		$employees = $this->PerformanceExcelReport->Employee->find('list');
		$this->set(compact('budget_years', 'employees'));
	}

	function edit($id = null, $parent_id = null) {
		if (!$id && empty($this->data)) {
			$this->Session->setFlash(__('Invalid performance excel report', true), '');
			$this->redirect(array('action' => 'index'));
		}
		if (!empty($this->data)) {
			$this->autoRender = false;
			if ($this->PerformanceExcelReport->save($this->data)) {
				$this->Session->setFlash(__('The performance excel report has been saved', true), '');
				$this->render('/elements/success');
			} else {
				$this->Session->setFlash(__('The performance excel report could not be saved. Please, try again.', true), '');
				$this->render('/elements/failure');
			}
		}
		$this->set('performance__excel__report', $this->PerformanceExcelReport->read(null, $id));
		
		if($parent_id) {
			$this->set('parent_id', $parent_id);
		}
			
		$budget_years = $this->PerformanceExcelReport->BudgetYear->find('list');
		$employees = $this->PerformanceExcelReport->Employee->find('list');
		$this->set(compact('budget_years', 'employees'));
	}

	function delete($id = null) {
		$this->autoRender = false;
		if (!$id) {
			$this->Session->setFlash(__('Invalid id for performance excel report', true), '');
			$this->render('/elements/failure');
		}
		if (stripos($id, '_') !== false) {
            $ids = explode('_', $id);
            try{
                foreach ($ids as $i) {
                    $this->PerformanceExcelReport->delete($i);
                }
				$this->Session->setFlash(__('Performance excel report deleted', true), '');
				$this->render('/elements/success');
            }
            catch (Exception $e){
				$this->Session->setFlash(__('Performance excel report was not deleted', true), '');
				$this->render('/elements/failure');
            }
        } else {
            if ($this->PerformanceExcelReport->delete($id)) {
				$this->Session->setFlash(__('Performance excel report deleted', true), '');
				$this->render('/elements/success');
			} else {
				$this->Session->setFlash(__('Performance excel report was not deleted', true), '');
				$this->render('/elements/failure');
			}
        }
	}
}
?>
