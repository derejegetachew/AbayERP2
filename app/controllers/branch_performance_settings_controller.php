<?php
class BranchPerformanceSettingsController extends AppController {

	var $name = 'BranchPerformanceSettings';
	
	function index() {
		$positions = $this->BranchPerformanceSetting->Position->find('all');
		$this->set(compact('positions'));
	}
	
	function index2($id = null) {
		$this->set('parent_id', $id);
	}

	function search() {

	}
	
	function list_data($id = null) {
		$start = (isset($_REQUEST['start'])) ? $_REQUEST['start'] : 0;
		$limit = (isset($_REQUEST['limit'])) ? $_REQUEST['limit'] : 5;
		$position_id = (isset($_REQUEST['position_id'])) ? $_REQUEST['position_id'] : -1;
		if($id)
			$position_id = ($id) ? $id : -1;
        $conditions = (isset($_REQUEST['conditions'])) ? $_REQUEST['conditions'] : '';

        eval("\$conditions = array( " . $conditions . " );");
		if ($position_id != -1) {
            $conditions['BranchPerformanceSetting.position_id'] = $position_id;
        }
        
        $positions = $this->get_positions();
		
		$this->set('branchPerformanceSettings', $this->BranchPerformanceSetting->find('all', array('conditions' => $conditions, 'limit' => $limit, 'offset' => $start)));
		$this->set('results', $this->BranchPerformanceSetting->find('count', array('conditions' => $conditions)));
   $this->set(compact('positions'));
	}

	function view($id = null) {
		if (!$id) {
			$this->Session->setFlash(__('Invalid branch performance setting', true));
			$this->redirect(array('action' => 'index'));
		}
		$this->BranchPerformanceSetting->recursive = 2;
		$this->set('branchPerformanceSetting', $this->BranchPerformanceSetting->read(null, $id));
	}

	function add2($id = null){
		if (!empty($this->data)) {
			$original_data = $this->data;
		
			$this_weight = $original_data['BranchPerformanceSetting']['weight'];
			$position = $original_data['BranchPerformanceSetting']['position_id'];
			$goal = str_replace("'", "`", $original_data['BranchPerformanceSetting']['goal']);
			$measure = str_replace("'", "`", $original_data['BranchPerformanceSetting']['measure']);
			$target = str_replace("'", "`", $original_data['BranchPerformanceSetting']['target']);

			$original_data['BranchPerformanceSetting']['goal'] = $goal;
			$original_data['BranchPerformanceSetting']['measure'] = $measure;
			$original_data['BranchPerformanceSetting']['target'] = $target;

//---------------------------------------------check for duplicate----------------------------------------------------------------
			$goal_row = $this->BranchPerformanceSetting->query("select * from branch_performance_settings 
			where position_id = ".$position."
			and goal = '".$goal."' and measure = '".$measure."' and target = '".$target."' ");
//---------------------------------------------end of check for duplicates--------------------------------------------------------

//--------------------------------------check if the pointers are numeric-----------------------------------------------------------
$pointers_numeric = false;
if(is_numeric($original_data['BranchPerformanceSetting']['five_pointer_min']) && is_numeric($original_data['BranchPerformanceSetting']['five_pointer_max_included'])
	&& is_numeric($original_data['BranchPerformanceSetting']['four_pointer_min']) && is_numeric($original_data['BranchPerformanceSetting']['four_pointer_max_included'])
	&& is_numeric($original_data['BranchPerformanceSetting']['three_pointer_min']) && is_numeric($original_data['BranchPerformanceSetting']['three_pointer_max_included'])
	&& is_numeric($original_data['BranchPerformanceSetting']['two_pointer_min']) && is_numeric($original_data['BranchPerformanceSetting']['two_pointer_max_included'])
	&& is_numeric($original_data['BranchPerformanceSetting']['one_pointer_min']) && is_numeric($original_data['BranchPerformanceSetting']['one_pointer_max_included'])
){
	$pointers_numeric = true;
} 
//-----------------------------------end of check if the pointers are numeric-------------------------------------------------------

			$this->Session->setFlash(__('The branch performance setting has been saved', true), '');
			$this->render('/elements/success');
		}
		
						if($id)
			$this->set('parent_id', $id);
		$positions = $this->BranchPerformanceSetting->Position->find('list');
		$this->set(compact('positions'));
	}

	function get_positions(){
		
		$this->loadModel('Position');
		
		//-----------------------------------------find the branches of that district-----------------------------------------------
		$positions_array = array();
		$positions_row = $this->Position->query("select * from positions  ");
		foreach($positions_row as $item){
			$positions_array[$item['positions']['id']] = $item['positions']['name']." (".$item['positions']['id'].")";
		}
		//--------------------------------------------end of the branches of that district-------------------------------------------

		return $positions_array;


	}

	function add($id = null) {
		if (!empty($this->data)) {
			$original_data = $this->data;
		
			$this_weight = $original_data['BranchPerformanceSetting']['weight'];
			$position = $original_data['BranchPerformanceSetting']['position_id'];
			$goal = str_replace("'", "`", $original_data['BranchPerformanceSetting']['goal']);
			$measure = str_replace("'", "`", $original_data['BranchPerformanceSetting']['measure']);
			$target = str_replace("'", "`", $original_data['BranchPerformanceSetting']['target']);

			$original_data['BranchPerformanceSetting']['goal'] = $goal;
			$original_data['BranchPerformanceSetting']['measure'] = $measure;
			$original_data['BranchPerformanceSetting']['target'] = $target;
			$original_data['BranchPerformanceSetting']['is_active'] = 1;

//---------------------------------------------check for duplicate------------------------------------------------------------------
			$goal_row = $this->BranchPerformanceSetting->query("select * from branch_performance_settings 
			where position_id = ".$position." and goal = '".$goal."' and measure = '".$measure."' 
			and target = '".$target."'  ");
//---------------------------------------------end of check for duplicates----------------------------------------------------------
//--------------------------------------check if the pointers are numeric-----------------------------------------------------------
		$pointers_numeric = false;

    if(is_numeric($original_data['BranchPerformanceSetting']['five_pointer_min']) && is_numeric($original_data['BranchPerformanceSetting']['five_pointer_max_included'])
		&& is_numeric($original_data['BranchPerformanceSetting']['four_pointer_min']) && is_numeric($original_data['BranchPerformanceSetting']['four_pointer_max_included'])
		&& is_numeric($original_data['BranchPerformanceSetting']['three_pointer_min']) && is_numeric($original_data['BranchPerformanceSetting']['three_pointer_max_included'])
		&& is_numeric($original_data['BranchPerformanceSetting']['two_pointer_min']) && is_numeric($original_data['BranchPerformanceSetting']['two_pointer_max_included'])
		&& is_numeric($original_data['BranchPerformanceSetting']['one_pointer_min']) && is_numeric($original_data['BranchPerformanceSetting']['one_pointer_max_included'])
	){
		$pointers_numeric = true;
	} 
//-----------------------------------end of check if the pointers are numeric-------------------------------------------------------


		if(is_numeric($this_weight)){
//-------------------------------------------------find weight sum-----------------------------------------------------------------------
			
			$total_weight = $this_weight;
			$weight_row = $this->BranchPerformanceSetting->query("select sum(weight) as sum_weight from branch_performance_settings
			where position_id = ".$position." ");
			$sum_weight = $weight_row[0][0]['sum_weight'];
			if($sum_weight != null) {
				$total_weight +=  $sum_weight;
			}
			else {
				$total_weight = $this_weight;
			}

//---------------------------------------------end of find weight sum--------------------------------------------------------------------
		if($pointers_numeric){
			if(count($goal_row) == 0){
				if($total_weight <= 100){
					$this->BranchPerformanceSetting->create();
					$this->autoRender = false;
				//	if ($this->BranchPerformanceSetting->save($this->data)) {
					if ($this->BranchPerformanceSetting->save($original_data)) {
						$this->Session->setFlash(__('The branch performance setting has been saved', true), '');
						$this->render('/elements/success');
					} else {
						$this->Session->setFlash(__('The branch performance setting could not be saved. Please, try again.', true), '');
						$this->render('/elements/failure');
					}
				}
	
				else {

					$this->Session->setFlash(__('Weight cannot exceed 100!', true), '');
					$this->render('/elements/failure3');
				}
				
			   }
		
		
			   else {
				$this->Session->setFlash(__('the plan already exists!', true), '');
				$this->render('/elements/failure3');
			   }
		
		
			}
			else {
				$this->Session->setFlash(__('The ratings must be numeric!', true), '');
				$this->render('/elements/failure3');
			}
		}	
			else {
			$this->Session->setFlash(__('Weight must be numeric!', true), '');
			$this->render('/elements/failure3');
		}
           

			
		}
		if($id)
			$this->set('parent_id', $id);
			$positions = $this->get_positions();
		//$positions = $this->BranchPerformanceSetting->Position->find('list');
		$this->set(compact('positions'));
	}

	function edit($id = null, $parent_id = null) {
		if (!$id && empty($this->data)) {
			$this->Session->setFlash(__('Invalid branch performance setting', true), '');
			$this->redirect(array('action' => 'index'));
		}
		if (!empty($this->data)) {

			$original_data = $this->data;
			$id = $original_data['BranchPerformanceSetting']['id'];
			$this_weight = $original_data['BranchPerformanceSetting']['weight'];
			$position = $original_data['BranchPerformanceSetting']['position_id'];
			$goal = str_replace("'", "`", $original_data['BranchPerformanceSetting']['goal']);
			$measure = str_replace("'", "`", $original_data['BranchPerformanceSetting']['measure']);
			$target = str_replace("'", "`", $original_data['BranchPerformanceSetting']['target']);

			$original_data['BranchPerformanceSetting']['goal'] = $goal;
			$original_data['BranchPerformanceSetting']['measure'] = $measure;
			$original_data['BranchPerformanceSetting']['target'] = $target;
		//	$original_data['BranchPerformanceSetting']['is_active'] = 1;

		//---------------------------------------------check for duplicate------------------------------------------------------------------
			$goal_row = $this->BranchPerformanceSetting->query("select * from branch_performance_settings 
			where position_id = ".$position." and goal = '".$goal."' and measure = '".$measure."' 
			and target = '".$target."' and id != ".$id);
		//---------------------------------------------end of check for duplicates----------------------------------------------------------

		//--------------------------------------check if the pointers are numeric-----------------------------------------------------------
				$pointers_numeric = false;

			if(is_numeric($original_data['BranchPerformanceSetting']['five_pointer_min']) && is_numeric($original_data['BranchPerformanceSetting']['five_pointer_max_included'])
				&& is_numeric($original_data['BranchPerformanceSetting']['four_pointer_min']) && is_numeric($original_data['BranchPerformanceSetting']['four_pointer_max_included'])
				&& is_numeric($original_data['BranchPerformanceSetting']['three_pointer_min']) && is_numeric($original_data['BranchPerformanceSetting']['three_pointer_max_included'])
				&& is_numeric($original_data['BranchPerformanceSetting']['two_pointer_min']) && is_numeric($original_data['BranchPerformanceSetting']['two_pointer_max_included'])
				&& is_numeric($original_data['BranchPerformanceSetting']['one_pointer_min']) && is_numeric($original_data['BranchPerformanceSetting']['one_pointer_max_included'])
			){
				$pointers_numeric = true;
			} 
		//-----------------------------------end of check if the pointers are numeric-------------------------------------------------------

		if(is_numeric($this_weight)){
//-------------------------------------------------find weight sum-----------------------------------------------------------------------
			
			$total_weight = $this_weight;
			$weight_row = $this->BranchPerformanceSetting->query("select sum(weight) as sum_weight from branch_performance_settings
			where position_id = ".$position." and id != ". $id);
			$sum_weight = $weight_row[0][0]['sum_weight'];
			if($sum_weight != null) {
				$total_weight +=  $sum_weight;
			}
			else {
				$total_weight = $this_weight;
			}

//---------------------------------------------end of find weight sum--------------------------------------------------------------------

				if($pointers_numeric) {
					if(count($goal_row) == 0){
						if($total_weight <= 100){
							$this->autoRender = false;
							if ($this->BranchPerformanceSetting->save($this->data)) {
								$this->Session->setFlash(__('The branch performance setting has been saved', true), '');
								$this->render('/elements/success');
							} else {
								$this->Session->setFlash(__('The branch performance setting could not be saved. Please, try again.', true), '');
								$this->render('/elements/failure');
							}
						}else{
							$this->Session->setFlash(__('Weight cannot exceed 100!', true), '');
							$this->render('/elements/failure3');
						}
						
					}else{
						$this->Session->setFlash(__('the plan already exists!', true), '');
						$this->render('/elements/failure3');
					}
					
				}
				else {
					$this->Session->setFlash(__('The ratings must be numeric!', true), '');
					$this->render('/elements/failure3');
				}

			

		 } else {
			$this->Session->setFlash(__('Weight must be numeric!', true), '');
			$this->render('/elements/failure3');
		}

			
		}
		$this->set('branch_performance_setting', $this->BranchPerformanceSetting->read(null, $id));
		
		if($parent_id) {
			$this->set('parent_id', $parent_id);
		}
			$positions = $this->get_positions();
		//$positions = $this->BranchPerformanceSetting->Position->find('list');
		$this->set(compact('positions'));

	}
	function edit2($id = null, $parent_id = null) {
		if (!$id && empty($this->data)) {
			$this->Session->setFlash(__('Invalid branch performance setting', true), '');
			$this->redirect(array('action' => 'index'));
		}
		if (!empty($this->data)) {
			$original_data = $this->data;
			$id = $original_data['BranchPerformanceSetting']['id'];
			$this_weight = $original_data['BranchPerformanceSetting']['weight'];
			$position = $original_data['BranchPerformanceSetting']['position_id'];
			$goal = str_replace("'", "`", $original_data['BranchPerformanceSetting']['goal']);
			$measure = str_replace("'", "`", $original_data['BranchPerformanceSetting']['measure']);
			$target = str_replace("'", "`", $original_data['BranchPerformanceSetting']['target']);

			$original_data['BranchPerformanceSetting']['goal'] = $goal;
			$original_data['BranchPerformanceSetting']['measure'] = $measure;
			$original_data['BranchPerformanceSetting']['target'] = $target;
		//	$original_data['BranchPerformanceSetting']['is_active'] = 1;

			$this->Session->setFlash(__('The branch performance setting has been saved', true), '');
			$this->render('/elements/success');

			
		}

		$this->set('branch_performance_setting', $this->BranchPerformanceSetting->read(null, $id));
		
		if($parent_id) {
			$this->set('parent_id', $parent_id);
		}
			
		$positions = $this->BranchPerformanceSetting->Position->find('list');
		$this->set(compact('positions'));

	}

	function delete($id = null) {
		$this->autoRender = false;
		if (!$id) {
			$this->Session->setFlash(__('Invalid id for branch performance setting', true), '');
			$this->render('/elements/failure');
		}
		if (stripos($id, '_') !== false) {
            $ids = explode('_', $id);
            try{
                foreach ($ids as $i) {
                    $this->BranchPerformanceSetting->delete($i);
                }
				$this->Session->setFlash(__('Branch performance setting deleted', true), '');
				$this->render('/elements/success');
            }
            catch (Exception $e){
				$this->Session->setFlash(__('Branch performance setting was not deleted', true), '');
				$this->render('/elements/failure');
            }
        } else {
            if ($this->BranchPerformanceSetting->delete($id)) {
				$this->Session->setFlash(__('Branch performance setting deleted', true), '');
				$this->render('/elements/success');
			} else {
				$this->Session->setFlash(__('Branch performance setting was not deleted', true), '');
				$this->render('/elements/failure');
			}
        }
	}
}
?>