<?php
class BranchEvaluationCriteriasController extends AppController {

	var $name = 'BranchEvaluationCriterias';
	
	function index() {
	}
	

	function search() {
	}
	
	function list_data($id = null) {
		$start = (isset($_REQUEST['start'])) ? $_REQUEST['start'] : 0;
		$limit = (isset($_REQUEST['limit'])) ? $_REQUEST['limit'] : 5;
        $conditions = (isset($_REQUEST['conditions'])) ? $_REQUEST['conditions'] : '';

        eval("\$conditions = array( " . $conditions . " );");
		
		$this->set('branchEvaluationCriterias', $this->BranchEvaluationCriteria->find('all', array('conditions' => $conditions, 'limit' => $limit, 'offset' => $start)));
		$this->set('results', $this->BranchEvaluationCriteria->find('count', array('conditions' => $conditions)));
	}

	function view($id = null) {
		if (!$id) {
			$this->Session->setFlash(__('Invalid branch evaluation criteria', true));
			$this->redirect(array('action' => 'index'));
		}
		$this->BranchEvaluationCriteria->recursive = 2;
		$this->set('branchEvaluationCriteria', $this->BranchEvaluationCriteria->read(null, $id));
	}

	function add($id = null) {
		if (!empty($this->data)) {
			$original_data = $this->data;
			
			$goal = trim(str_replace("'", "`", $original_data['BranchEvaluationCriteria']['goal']));
			
			$measure = trim(str_replace("'", "`", $original_data['BranchEvaluationCriteria']['measure']));
			
			$target = trim(str_replace("'", "`", $original_data['BranchEvaluationCriteria']['target']));
			$weight = $original_data['BranchEvaluationCriteria']['weight'];

			$original_data['BranchEvaluationCriteria']['goal'] = $goal;
			$original_data['BranchEvaluationCriteria']['measure'] = $measure;
			$original_data['BranchEvaluationCriteria']['target'] = $target;

			//---------------------------------------------check for duplicate------------------------------------------------------------------
				$goal_row = $this->BranchEvaluationCriteria->query("select * from branch_evaluation_criterias 
				where  goal = '".$goal."' and measure = '".$measure."' 
				and target = '".$target."' and weight = ".$weight);
			//---------------------------------------------end of check for duplicates----------------------------------------------------------

				if(count($goal_row) == 0){
						if(is_numeric($weight)){
							$this->BranchEvaluationCriteria->create();
							$this->autoRender = false;
						//	if ($this->BranchEvaluationCriteria->save($this->data)) {
							if ($this->BranchEvaluationCriteria->save($original_data)) {
								$this->Session->setFlash(__('The branch evaluation criteria has been saved', true), '');
								$this->render('/elements/success');
							} else {
								$this->Session->setFlash(__('The branch evaluation criteria could not be saved. Please, try again.', true), '');
								$this->render('/elements/failure');
							}

						} else {
							$this->Session->setFlash(__('The weight must be numeric!', true), '');
							$this->render('/elements/failure3');
						}
				}
				else {
							$this->Session->setFlash(__('Duplicate branch evaluation criteria !', true), '');
							$this->render('/elements/failure3');

				}

			
		}
	}

	function edit($id = null, $parent_id = null) {
		if (!$id && empty($this->data)) {
			$this->Session->setFlash(__('Invalid branch evaluation criteria', true), '');
			$this->redirect(array('action' => 'index'));
		}
		if (!empty($this->data)) {

			$original_data = $this->data;

			$id = $original_data['BranchEvaluationCriteria']['id'];

			$goal = trim(str_replace("'", "`", $original_data['BranchEvaluationCriteria']['goal']));
			
			$measure = trim(str_replace("'", "`", $original_data['BranchEvaluationCriteria']['measure']));
			
			$target = trim(str_replace("'", "`", $original_data['BranchEvaluationCriteria']['target']));
			$weight = $original_data['BranchEvaluationCriteria']['weight'];

			$original_data['BranchEvaluationCriteria']['goal'] = $goal;
			$original_data['BranchEvaluationCriteria']['measure'] = $measure;
			$original_data['BranchEvaluationCriteria']['target'] = $target;

			//--------------------------------------check if it is found in the details table---------------------------------------
			$this->loadModel('BranchPerformanceDetail');
			$detail_row = $this->BranchPerformanceDetail->query("select * from branch_performance_details 
			where  branch_evaluation_criteria_id = ".$id);
			//---------------------------------------end of check if it is found in the details table-------------------------------

			//---------------------------------------------check for duplicate------------------------------------------------------------------
				$goal_row = $this->BranchEvaluationCriteria->query("select * from branch_evaluation_criterias 
				where  goal = '".$goal."' and measure = '".$measure."' 
				and target = '".$target."' and weight = ".$weight." and id != ".$id);
			//---------------------------------------------end of check for duplicates----------------------------------------------------------
		if(count($goal_row) == 0){
			if(count($detail_row) == 0){
				if(is_numeric($weight)){
					$this->autoRender = false;
					if ($this->BranchEvaluationCriteria->save($this->data)) {
						$this->Session->setFlash(__('The branch evaluation criteria has been saved', true), '');
						$this->render('/elements/success');
					} else {
						$this->Session->setFlash(__('The branch evaluation criteria could not be saved. Please, try again.', true), '');
						$this->render('/elements/failure');
					}
					} else{
						$this->Session->setFlash(__('The weight must be numeric!', true), '');
						$this->render('/elements/failure3');
					}
				} else {
					$this->Session->setFlash(__('The criteria is in use in another table !', true), '');
					$this->render('/elements/failure3');
				}
			} else {
				$this->Session->setFlash(__('Duplicate branch evaluation criteria !', true), '');
				$this->render('/elements/failure3');
			}

		} 
		
			$this->set('branch_evaluation_criteria', $this->BranchEvaluationCriteria->read(null, $id));
			
	}

	function delete($id = null) {
		$this->autoRender = false;
		if (!$id) {
			$this->Session->setFlash(__('Invalid id for branch evaluation criteria', true), '');
			$this->render('/elements/failure');
		}
		if (stripos($id, '_') !== false) {
            $ids = explode('_', $id);
            try{
                foreach ($ids as $i) {
                    $this->BranchEvaluationCriteria->delete($i);
                }
				$this->Session->setFlash(__('Branch evaluation criteria deleted', true), '');
				$this->render('/elements/success');
            }
            catch (Exception $e){
				$this->Session->setFlash(__('Branch evaluation criteria was not deleted', true), '');
				$this->render('/elements/failure');
            }
        } else {
            if ($this->BranchEvaluationCriteria->delete($id)) {
				$this->Session->setFlash(__('Branch evaluation criteria deleted', true), '');
				$this->render('/elements/success');
			} else {
				$this->Session->setFlash(__('Branch evaluation criteria was not deleted', true), '');
				$this->render('/elements/failure');
			}
        }
	}
}
?>