<?php
class PerformanceStatusesController extends AppController {

	var $name = 'PerformanceStatuses';
	
	function index() {
		$budget_years = $this->PerformanceStatus->BudgetYear->find('all');
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
            $conditions['PerformanceStatus.budgetyear_id'] = $budgetyear_id;
        }
		
		$this->set('performanceStatuses', $this->PerformanceStatus->find('all', array('conditions' => $conditions, 'limit' => $limit, 'offset' => $start)));
		$this->set('results', $this->PerformanceStatus->find('count', array('conditions' => $conditions)));
	}

	function view($id = null) {
		if (!$id) {
			$this->Session->setFlash(__('Invalid performance status', true));
			$this->redirect(array('action' => 'index'));
		}
		$this->PerformanceStatus->recursive = 2;
		$this->set('performanceStatus', $this->PerformanceStatus->read(null, $id));
	}

	function add2($id = null) {
		if (!empty($this->data)) {
			
			$this->autoRender = false;
			$original_data = $this->data;
				
				//$budget_year_id = $original_data['PerformanceStatus']['budget_year_id'];
				//$quarter = $original_data['PerformanceStatus']['quarter'];
				// $date = $original_data['BranchPerformanceTracking']['date'];
				// $value = $original_data['BranchPerformanceTracking']['value'];
				//echo $quarter;
				// echo "hello";
				$this->Session->setFlash(__('The performance status has been saved', true), '');
				$this->render('/elements/success');
			
		}
		if($id)
			$this->set('parent_id', $id);
		$budget_years = $this->PerformanceStatus->BudgetYear->find('list');
		$this->set(compact('budget_years'));
	}

	function add($id = null) {
		if (!empty($this->data)) {
			
			$this->autoRender = false;
			$original_data = $this->data;
				
				$budget_year_id = $original_data['PerformanceStatus']['budget_year_id'];
				$quarter = $original_data['PerformanceStatus']['quarter'];
				// $date = $original_data['BranchPerformanceTracking']['date'];
				// $value = $original_data['BranchPerformanceTracking']['value'];
//-----------------------------------------check duplicate------------------------------------------------------------------
				$duplicate_row = $this->PerformanceStatus->query('select * from performance_statuses where budget_year_id = '.$budget_year_id.' and quarter = '.$quarter.' ');
//-----------------------------------------end of check duplicate------------------------------------------------------------------
				if(count($duplicate_row) == 0){
					$this->PerformanceStatus->create();
					if ($this->PerformanceStatus->save($this->data)) {
				
						$this->Session->setFlash(__('The performance status has been saved', true), '');
						$this->render('/elements/success');
					} else {
						$this->Session->setFlash(__('The performance status could not be saved. Please, try again.', true), '');
						$this->render('/elements/failure');
					}
				  }

				  else {

					$this->Session->setFlash(__('Duplicate entry !', true), '');
						$this->render('/elements/failure3');

				  }

			
		}
		if($id)
			$this->set('parent_id', $id);
		$budget_years = $this->PerformanceStatus->BudgetYear->find('list');
		$this->set(compact('budget_years'));
	}

	function edit($id = null, $parent_id = null) {
		if (!$id && empty($this->data)) {
			$this->Session->setFlash(__('Invalid performance status', true), '');
			$this->redirect(array('action' => 'index'));
		}

		if (!empty($this->data)) {
		//	$original_data = $this->data;

		//	$id = $original_data['PerformanceStatus']['id'];
		//	$budget_year_id = $original_data['PerformanceStatus']['budget_year_id'];
		//	$quarter = $original_data['PerformanceStatus']['quarter'];
			// $date = $original_data['BranchPerformanceTracking']['date'];
			// $value = $original_data['BranchPerformanceTracking']['value'];
//-----------------------------------------check duplicate------------------------------------------------------------------
	//		$duplicate_row = $this->PerformanceStatus->query('select * from performance_statuses where budget_year_id = '.$budget_year_id.' and quarter = '.$quarter.' where id != '.$id);
//-----------------------------------------end of check duplicate------------------------------------------------------------------

			//	if(count($duplicate_row)){
					$this->autoRender = false;
					if ($this->PerformanceStatus->save($this->data)) {
						$this->Session->setFlash(__('The performance status has been saved', true), '');
						$this->render('/elements/success');
					} else {
						$this->Session->setFlash(__('The performance status could not be saved. Please, try again.', true), '');
						$this->render('/elements/failure');
					}
			//	}
				// else {
				// 	$this->Session->setFlash(__('Duplicate entry !', true), '');
				// 	$this->render('/elements/failure3');
				// }
			
		}
		$this->set('performance_status', $this->PerformanceStatus->read(null, $id));
		
		if($parent_id) {
			$this->set('parent_id', $parent_id);
		}
			
		$budget_years = $this->PerformanceStatus->BudgetYear->find('list');
		$this->set(compact('budget_years'));
	}

	function delete($id = null) {
		$this->autoRender = false;
		if (!$id) {
			$this->Session->setFlash(__('Invalid id for performance status', true), '');
			$this->render('/elements/failure');
		}
		if (stripos($id, '_') !== false) {
            $ids = explode('_', $id);
            try{
                foreach ($ids as $i) {
                    $this->PerformanceStatus->delete($i);
                }
				$this->Session->setFlash(__('Performance status deleted', true), '');
				$this->render('/elements/success');
            }
            catch (Exception $e){
				$this->Session->setFlash(__('Performance status was not deleted', true), '');
				$this->render('/elements/failure');
            }
        } else {
            if ($this->PerformanceStatus->delete($id)) {
				$this->Session->setFlash(__('Performance status deleted', true), '');
				$this->render('/elements/success');
			} else {
				$this->Session->setFlash(__('Performance status was not deleted', true), '');
				$this->render('/elements/failure');
			}
        }
	}
}
?>