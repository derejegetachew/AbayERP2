<?php
class BranchPerformanceDetailsController extends AppController {

	var $name = 'BranchPerformanceDetails';

	function get_all_criterias(){

		$criterias_array = array();
		$this->loadModel('BranchEvaluationCriteria');

		$criterias_row = $this->BranchEvaluationCriteria->query('select * from branch_evaluation_criterias ');
		foreach($criterias_row as $item){
		
		
		$goal = $item['branch_evaluation_criterias']['goal'];
		$measure = $item['branch_evaluation_criterias']['measure'];
		$target = $item['branch_evaluation_criterias']['target'];
		$weight = $item['branch_evaluation_criterias']['weight'];

		$criterias_array[$item['branch_evaluation_criterias']['id']]  = $goal." | ".$measure." | ".$target." | ".$weight."%" ;
		
	}
 

	return $criterias_array;

	}
 
 	function get_all_criterias_few(){

		$criterias_array = array();
		$this->loadModel('BranchEvaluationCriteria');

		$criterias_row = $this->BranchEvaluationCriteria->query('select * from branch_evaluation_criterias where STATUS = 1 ');
		foreach($criterias_row as $item){
		
		
		$goal = $item['branch_evaluation_criterias']['goal'];
		$measure = $item['branch_evaluation_criterias']['measure'];
		$target = $item['branch_evaluation_criterias']['target'];
		$weight = $item['branch_evaluation_criterias']['weight'];

		$criterias_array[$item['branch_evaluation_criterias']['id']]  = $goal." | ".$measure." | ".$target." | ".$weight."%" ;
		
	}
 

	return $criterias_array;

	}
  
  
	
	function index() {
		$branch_evaluation_criterias = $this->BranchPerformanceDetail->BranchEvaluationCriteria->find('all');
		$this->set(compact('branch_evaluation_criterias'));
	}
	
	function index2($id = null) {
		$this->set('parent_id', $id);
	}

	function search() {
	}
	
	function list_data($id = null) {
		$start = (isset($_REQUEST['start'])) ? $_REQUEST['start'] : 0;
		$limit = (isset($_REQUEST['limit'])) ? $_REQUEST['limit'] : 5;
		$branchperformanceplan_id = (isset($_REQUEST['branchperformanceplan_id'])) ? $_REQUEST['branchperformanceplan_id'] : -1;
		if($id)
			$branchperformanceplan_id = ($id) ? $id : -1;
        $conditions = (isset($_REQUEST['conditions'])) ? $_REQUEST['conditions'] : '';

        eval("\$conditions = array( " . $conditions . " );");
		if ($branchperformanceplan_id != -1) {
            $conditions['BranchPerformanceDetail.branch_performance_plan_id'] = $branchperformanceplan_id;
        }
		
		$this->set('branchPerformanceDetails', $this->BranchPerformanceDetail->find('all', array('conditions' => $conditions, 'limit' => $limit, 'offset' => $start)));
		$this->set('results', $this->BranchPerformanceDetail->find('count', array('conditions' => $conditions)));

		
		$this->set('all_criterias', $this->get_all_criterias());

	}

	function view($id = null) {
		if (!$id) {
			$this->Session->setFlash(__('Invalid branch performance detail', true));
			$this->redirect(array('action' => 'index'));
		}
		$this->BranchPerformanceDetail->recursive = 2;
		$this->set('branchPerformanceDetail', $this->BranchPerformanceDetail->read(null, $id));
		$this->set('all_criterias', $this->get_all_criterias());
	}

	function add($id = null) {
		if (!empty($this->data)) {
			$original_data = $this->data;
			$plan_id = $original_data['BranchPerformanceDetail']['branch_performance_plan_id'];
		
			$evaluation_criteria_id = $original_data['BranchPerformanceDetail']['branch_evaluation_criteria_id'];
			
			$plan_in_num = $original_data['BranchPerformanceDetail']['plan_in_number'];
	//-------------------------------find the criteria details -------------------------------------------------------
			$this->loadModel('BranchEvaluationCriteria');
			$criteria_row = $this->BranchEvaluationCriteria->query('select * from branch_evaluation_criterias where id = '.$evaluation_criteria_id.'');
			$this_weight = $criteria_row[0]['branch_evaluation_criterias']['weight'];
	//-----------------------------end of find the criteria details -----------------------------------------------------
	//-------------------------------find status ------------------------------------------------------------------------
	$this->loadModel('BranchPerformancePlan');
	$plan_status_row = $this->BranchPerformancePlan->query('select * from branch_performance_plans where id = '.$plan_id.'');
	$plan_status = $plan_status_row[0]['branch_performance_plans']['plan_status'];
	$budget_year_id = $plan_status_row[0]['branch_performance_plans']['budget_year_id'];
	$quarter = $plan_status_row[0]['branch_performance_plans']['quarter'];
//-----------------------------end of find the criteria details ----------------------------------------------------------
//----------------------------------------------find total weight----------------------------------------------------------
		$total_weight = $this_weight;
		$sum_weight = 0;
		$weight_row = $this->BranchPerformanceDetail->query('select * from branch_performance_details where branch_performance_plan_id = '.$plan_id.'');
		foreach($weight_row as $item){
			$evaluation_id = $item['branch_performance_details']['branch_evaluation_criteria_id'];
			$evaluation_row = $this->BranchEvaluationCriteria->query('select * from branch_evaluation_criterias where id = '.$evaluation_id.'');
			$other_weight = $evaluation_row[0]['branch_evaluation_criterias']['weight'];
			$sum_weight += $other_weight;
		}
		
		if($sum_weight != null) {
			$total_weight +=  $sum_weight;
		}
		else {
			$total_weight = $this_weight;
		}


//--------------------------------------------end of find total weight---------------------------------------------------------
//----------------------------------------------------------check duplicate----------------------------------------------------
$duplicate_row = $this->BranchPerformanceDetail->query("select * from branch_performance_details where branch_evaluation_criteria_id = ".$evaluation_criteria_id." and branch_performance_plan_id = ".$plan_id."");

//-----------------------------------------------------end of check duplicate--------------------------------------------------
		if($total_weight <= 100){
			if(is_numeric($plan_in_num)){
				if(count($duplicate_row) == 0){
  //--------------------------------------------------check if the general status is open--------------------------------------------------
  $this->loadModel('PerformanceStatus');
  $general_status = "open";
  $general_status_row =  $this->PerformanceStatus->query('select * from performance_statuses where  budget_year_id = '.$budget_year_id.' and quarter = '. $quarter);
  if(count($general_status_row) > 0){
	  $general_status = $general_status_row[0]['performance_statuses']['status'];
  }
  //--------------------------------------------------end of check if the general status is open----------------------------------------------

					if($plan_status <= 2 && $general_status == "open"){
						$this->BranchPerformanceDetail->create();
						$this->autoRender = false;
						if ($this->BranchPerformanceDetail->save($this->data)) {

							$this->recalculate_plan($plan_id);

							$this->Session->setFlash(__('The branch performance detail has been saved', true), '');
							$this->render('/elements/success');
						} else {
							$this->Session->setFlash(__('The branch performance detail could not be saved. Please, try again.', true), '');
							$this->render('/elements/failure');
						}
					}
					else {
						$this->Session->setFlash(__('Plan is not open of adding!', true), '');
							$this->render('/elements/failure3');
					}
					
	
				}
				else {
					$this->Session->setFlash(__('Duplicate entry!', true), '');
							$this->render('/elements/failure3');
				}
	
			   }
			   else{
				$this->Session->setFlash(__('Plan must be numeric!', true), '');
							$this->render('/elements/failure3');
			   }

		} else {
			$this->Session->setFlash(__('Total weight cannot exceed 100% !', true), '');
						$this->render('/elements/failure3');
		}
           


			
		}
		if($id)
			$this->set('parent_id', $id);
		$branch_evaluation_criterias = $this->get_all_criterias_few();
		$branch_performance_plans = $this->BranchPerformanceDetail->BranchPerformancePlan->find('list');
		$this->set(compact('branch_evaluation_criterias', 'branch_performance_plans'));
	}

	function edit($id = null, $parent_id = null) {
		if (!$id && empty($this->data)) {
			$this->Session->setFlash(__('Invalid branch performance detail', true), '');
			$this->redirect(array('action' => 'index'));
		}
		if (!empty($this->data)) {
			$this->loadModel('BranchPerformancePlan');
			
			$original_data = $this->data;
			$actual_result = $original_data['BranchPerformanceDetail']['actual_result'];
			$evaluation_criteria_id = $original_data['BranchPerformanceDetail']['branch_evaluation_criteria_id'];
			//$direction = $original_data['BranchPerformanceDetail']['direction'];
			
			$plan_in_number = $original_data['BranchPerformanceDetail']['plan_in_number'];
			// $this_weight = $original_data['BranchPerformanceDetail']['weight']; 
      		// $weight = $original_data['HoPerformanceDetail']['weight'];
			$plan_id = $original_data['BranchPerformanceDetail']['branch_performance_plan_id'];
			$id = $original_data['BranchPerformanceDetail']['id'];
			//----------------------------------find the status of the plan---------------------------------------------------
			$plan_status_row = $this->BranchPerformancePlan->query("select * from branch_performance_plans where id = ".$plan_id."  ");
			
			$plan_status = $plan_status_row[0]['branch_performance_plans']['plan_status'];	
			$result_status = $plan_status_row[0]['branch_performance_plans']['result_status'];
			$budget_year_id = $plan_status_row[0]['branch_performance_plans']['budget_year_id'];
			$quarter = $plan_status_row[0]['branch_performance_plans']['quarter'];
			//--------------------------------end of finding the status of the plan-------------------------------------------
			//------------check duplicate----------------------------------------------------------------
			$goal_row = $this->BranchPerformanceDetail->query("select * from branch_performance_details where branch_evaluation_criteria_id = ".$evaluation_criteria_id." and branch_performance_plan_id = ".$plan_id." and id != ".$id);
			//-------------------end check duplicate-----------------------------------------------------------
			//-------------------------------find the criteria details -------------------------------------------------------
				$this->loadModel('BranchEvaluationCriteria');
				$criteria_row = $this->BranchEvaluationCriteria->query('select * from branch_evaluation_criterias where id = '.$evaluation_criteria_id.'');
				$this_weight = $criteria_row[0]['branch_evaluation_criterias']['weight'];
				$direction = $criteria_row[0]['branch_evaluation_criterias']['direction'];
		//-----------------------------end of find the criteria details -----------------------------------------------------
		//----------------------------------------------find total weight----------------------------------------------------------
		$total_weight = $this_weight;
		$sum_weight = 0;
		$weight_row = $this->BranchPerformanceDetail->query('select * from branch_performance_details where branch_performance_plan_id = '.$plan_id.' and id != '.$id);
		foreach($weight_row as $item){
			$evaluation_id = $item['branch_performance_details']['branch_evaluation_criteria_id'];
			$evaluation_row = $this->BranchEvaluationCriteria->query('select * from branch_evaluation_criterias where id = '.$evaluation_id.'');
			$other_weight = $evaluation_row[0]['branch_evaluation_criterias']['weight'];
			$sum_weight += $other_weight;
		}
		
		if($sum_weight != null) {
			$total_weight +=  $sum_weight;
		}
		else {
			$total_weight = $this_weight;
		}


//--------------------------------------------end of find total weight---------------------------------------------------------
//--------------------------------------rules---------------------------------------------------------------------
			if($direction == 1 || $direction == 6){ // incremental or sdt(standard delivery time)
				$five_pointer_min_included = 125;
				$five_pointer_max = 1000000000000;
				$four_pointer_min_included = 110;
				$four_pointer_max = 125;
				$three_pointer_min_included = 100;
				$three_pointer_max = 110;
				$two_pointer_min_included = 60;
				$two_pointer_max = 100;
				$one_pointer_min_included = -100000000000;
				$one_pointer_max = 60;

			}

			else if($direction == 2){
				$five_pointer_min_included = 0;
				$five_pointer_max = 60;
				$four_pointer_min_included = 60;
				$four_pointer_max = 100;
				$three_pointer_min_included = 100;
				$three_pointer_max = 110;
				$two_pointer_min_included = 110;
				$two_pointer_max = 125;
				$one_pointer_min_included = 125;
				$one_pointer_max = 1000000000000;

			}
			else if($direction == 3 || $direction == 4 || $direction == 5){ // means error, no of complain, delay direction
				$five_pointer_min_included = 0;
				$five_pointer_max = 1;
				$four_pointer_min_included = 1;
				$four_pointer_max = 2;
				$three_pointer_min_included = 2;
				$three_pointer_max = 3;
				$two_pointer_min_included = 3;
				$two_pointer_max = 4;
				$one_pointer_min_included = 4;
				$one_pointer_max = 1000000000000;
			}
//--------------------------------end of rules-------------------------------------------------------------------------
//----------------------------------------find total score--------------------------------------------------------------
				if($direction == 1 || $direction == 2){
					if($plan_in_number == 0){
						$plan_in_number = 0.00000001;
					}
					$accomplishment = round((100 * ($actual_result / $plan_in_number)),2);
				}
				else if($direction == 3 || $direction == 4 || $direction == 5){
					$accomplishment = $actual_result;
				}
				else if($direction == 6){
					if($actual_result == 0){
						$actual_result = 0.0000001;
					}
					$accomplishment = round((100 * ( $plan_in_number / $actual_result )),2);
				}

				$total_score = 0;
				$final_score = 0;
				//------------------find the total score now-----------------------------------
				if($accomplishment >= $one_pointer_min_included && $accomplishment < $one_pointer_max){
				$total_score = 1;
				}
				if($accomplishment >= $two_pointer_min_included && $accomplishment < $two_pointer_max){
				$total_score = 2;
				}
				if($accomplishment >= $three_pointer_min_included && $accomplishment < $three_pointer_max){
				$total_score = 3;
				}
				if($accomplishment >= $four_pointer_min_included && $accomplishment < $four_pointer_max){
				$total_score = 4;
				}
				if($accomplishment >= $five_pointer_min_included && $accomplishment < $five_pointer_max){
				$total_score = 5;
				}
//-----------------end of find the total score now------------------------------------



	$final_score = round(($total_score * $this_weight / 100), 2);

	$original_data['BranchPerformanceDetail']['accomplishment'] = $accomplishment;
	$original_data['BranchPerformanceDetail']['rating'] = $total_score;
	$original_data['BranchPerformanceDetail']['final_result'] = $final_score;
//--------------------------------------end of find total score---------------------------------------------------------------
if(is_numeric($plan_in_number)){

	  //--------------------------------------------------check if the general status is open--------------------------------------------------
$this->loadModel('PerformanceStatus');
$general_status = "open";
$general_status_row =  $this->PerformanceStatus->query('select * from performance_statuses where  budget_year_id = '.$budget_year_id.' and quarter = '. $quarter);
if(count($general_status_row) > 0){
	$general_status = $general_status_row[0]['performance_statuses']['status'];
}
//--------------------------------------------------end of check if the general status is open----------------------------------------------
	if($plan_status <= 2 && $general_status == "open"){
		if($total_weight <= 100){
			if(count($goal_row) == 0){
				$this->autoRender = false;
			//	if ($this->BranchPerformanceDetail->save($this->data)) {
				if ($this->BranchPerformanceDetail->save($original_data)) {
					$this->recalculate_plan($plan_id);
					$this->Session->setFlash(__('The branch performance detail has been saved', true), '');
					$this->render('/elements/success');
				} else {
					$this->Session->setFlash(__('The branch performance detail could not be saved. Please, try again.', true), '');
					$this->render('/elements/failure');
				}
	
			}
			else{
				$this->Session->setFlash(__('Duplicate entry !', true), '');
				$this->render('/elements/failure3');
			}
	
		}
		else {
			$this->Session->setFlash(__('Total weight cannot exceed 100% !', true), '');
			$this->render('/elements/failure3');
		}
	
	}
	else { // means plan has been agreed
		if($result_status <= 1){
			$update_calculations = $this->BranchPerformanceDetail->query('update branch_performance_details set actual_result = '.$actual_result.',
			accomplishment = '.$accomplishment.', rating = '.$total_score.' , final_result = '.$final_score.' where id = '.$id );
			
			$this->Session->setFlash(__('The ho performance detail has been saved', true), '');
			$this->render('/elements/success');
		}
		else {
			$this->Session->setFlash(__('The plan is not open for edit !', true), '');
			$this->render('/elements/failure3');
		}
	
	}
}
else {
	$this->Session->setFlash(__('Plan must be numeric !', true), '');
			$this->render('/elements/failure3');
}
		
		}
		$this->set('branch_performance_detail', $this->BranchPerformanceDetail->read(null, $id));
		
		if($parent_id) {
			$this->set('parent_id', $parent_id);
		}
			
		$branch_evaluation_criterias = $this->get_all_criterias_few();
		$branch_performance_plans = $this->BranchPerformanceDetail->BranchPerformancePlan->find('list');
		$this->set(compact('branch_evaluation_criterias', 'branch_performance_plans'));
	}

	function recalculate($id = null) {  //we don't need to include plan status in here because it is branch
		
		$this->autoRender = false;
		$this->loadModel('BranchPerformancePlan');
		//	$original_data = $this->data;
		$original_data = array();
		$original_data = $this->BranchPerformanceDetail->find('first', array('conditions' => array('BranchPerformanceDetail.id' => $id)));
		$actual_result = $original_data['BranchPerformanceDetail']['actual_result'];
		$plan_in_number = $original_data['BranchPerformanceDetail']['plan_in_number'];
		$evaluation_criteria_id = $original_data['BranchPerformanceDetail']['branch_evaluation_criteria_id'];
	//	$direction = $original_data['BranchPerformanceDetail']['direction'];

	//-------------------------------find the criteria details -------------------------------------------------------
	$this->loadModel('BranchEvaluationCriteria');
	$criteria_row = $this->BranchEvaluationCriteria->query('select * from branch_evaluation_criterias where id = '.$evaluation_criteria_id.'');
	$weight = $criteria_row[0]['branch_evaluation_criterias']['weight'];
	$direction = $criteria_row[0]['branch_evaluation_criterias']['direction'];
//-----------------------------end of find the criteria details -----------------------------------------------------

		//	if($actual_result > 0){

				if($direction == 1 || $direction == 6){ // incremental or sdt(standard delivery time)
					$five_pointer_min_included = 125;
					$five_pointer_max = 1000000000000;
					$four_pointer_min_included = 110;
					$four_pointer_max = 125;
					$three_pointer_min_included = 100;
					$three_pointer_max = 110;
					$two_pointer_min_included = 60;
					$two_pointer_max = 100;
					$one_pointer_min_included = -100000000000;
					$one_pointer_max = 60;
	
				}
	
				else if($direction == 2){
					$five_pointer_min_included = 0;
					$five_pointer_max = 60;
					$four_pointer_min_included = 60;
					$four_pointer_max = 100;
					$three_pointer_min_included = 100;
					$three_pointer_max = 110;
					$two_pointer_min_included = 110;
					$two_pointer_max = 125;
					$one_pointer_min_included = 125;
					$one_pointer_max = 1000000000000;
	
				}
				else if($direction == 3 || $direction == 4 || $direction == 5){ // means error, no of complain, delay direction
					$five_pointer_min_included = 0;
					$five_pointer_max = 0;
					$four_pointer_min_included = 1;
					$four_pointer_max = 1;
					$three_pointer_min_included = 2;
					$three_pointer_max = 2;
					$two_pointer_min_included = 3;
					$two_pointer_max = 3;
					$one_pointer_min_included = 4;
					$one_pointer_max = 1000000000000;
				}
				
				// $accomplishment = round((100 * ($actual_result / $plan_in_number)),2);
				if($direction == 1 || $direction == 2){
					if($plan_in_number == 0){
						$plan_in_number = 0.0000001;
					}
					$accomplishment = round((100 * ($actual_result / $plan_in_number)),2);
				}
				else if($direction == 3 || $direction == 4 || $direction == 5){
					$accomplishment = $actual_result;
				}
				else if($direction == 6){
					if($actual_result == 0){
						$actual_result = 0.0000001;
					}
					$accomplishment = round((100 * ( $plan_in_number / $actual_result )),2);
				}

		//		$weight = $original_data['HoPerformanceDetail']['weight'];
				$total_score = 0;
				$final_score = 0;

			
	
				//------------------find the total score now-----------------------------------
					if($accomplishment >= $one_pointer_min_included && $accomplishment < $one_pointer_max){
						$total_score = 1;
					}
					if($accomplishment >= $two_pointer_min_included && $accomplishment < $two_pointer_max){
						$total_score = 2;
					}
					if($accomplishment >= $three_pointer_min_included && $accomplishment < $three_pointer_max){
						$total_score = 3;
					}
					if($accomplishment >= $four_pointer_min_included && $accomplishment < $four_pointer_max){
						$total_score = 4;
					}
					if($accomplishment >= $five_pointer_min_included && $accomplishment < $five_pointer_max){
						$total_score = 5;
					}
				//-----------------end of find the total score now------------------------------------
	
					$final_score = round(($total_score * $weight / 100),2);
					//$accomplishment = 100;
					$original_data['BranchPerformanceDetail']['accomplishment'] = $accomplishment;
					$original_data['BranchPerformanceDetail']['rating'] = $total_score;
					$original_data['BranchPerformanceDetail']['final_result'] = $final_score;
		//	}
		

			//if ($this->HoPerformancePlan->save($this->data)) {
			if ($this->BranchPerformanceDetail->save($original_data)) {
				// $this->Session->setFlash(__('The ho performance plan has been saved', true), '');
				// $this->render('/elements/success');
			} else {
				// $this->Session->setFlash(__('The ho performance plan could not be saved. Please, try again.', true), '');
				// $this->render('/elements/failure');
			}

	}

	function redo_details($branch_performance_plan_id){
		$this->autoRender = false;
		$this->loadModel('BranchPerformanceDetail');
		
//---------------------------------------find all details in each plan id------------------------------------------------------------
		


$detail_row = $this->BranchPerformanceDetail->query('select * from branch_performance_details where branch_performance_plan_id = '. $branch_performance_plan_id.' ');
		foreach($detail_row as $item){
			$original_data = array();
			 $original_data = $this->BranchPerformanceDetail->find('first', array('conditions' => array('BranchPerformanceDetail.id' => $item['branch_performance_details']['id'])));
			// $original_data = $this->BranchPerformanceDetail->find('first', array('conditions' => array('BranchPerformanceDetail.id' => 6)));
			 $actual_result = $original_data['BranchPerformanceDetail']['actual_result'];
			$plan_in_number = $original_data['BranchPerformanceDetail']['plan_in_number'];
			$evaluation_criteria_id = $original_data['BranchPerformanceDetail']['branch_evaluation_criteria_id'];
			//-------------------------------find the criteria details -------------------------------------------------------
				$this->loadModel('BranchEvaluationCriteria');
				$criteria_row = $this->BranchEvaluationCriteria->query('select * from branch_evaluation_criterias where id = '. $evaluation_criteria_id .' ');
				$weight = $criteria_row[0]['branch_evaluation_criterias']['weight'];
				$direction = $criteria_row[0]['branch_evaluation_criterias']['direction'];
//-----------------------------end of find the criteria details -----------------------------------------------------
if($direction == 1 || $direction == 6){ // incremental or sdt(standard delivery time)
	$five_pointer_min_included = 125;
	$five_pointer_max = 1000000000000;
	$four_pointer_min_included = 110;
	$four_pointer_max = 125;
	$three_pointer_min_included = 100;
	$three_pointer_max = 110;
	$two_pointer_min_included = 60;
	$two_pointer_max = 100;
	$one_pointer_min_included = -1000000000000;
	$one_pointer_max = 60;

}

else if($direction == 2){
	$five_pointer_min_included = 0;
	$five_pointer_max = 60;
	$four_pointer_min_included = 60;
	$four_pointer_max = 100;
	$three_pointer_min_included = 100;
	$three_pointer_max = 110;
	$two_pointer_min_included = 110;
	$two_pointer_max = 125;
	$one_pointer_min_included = 125;
	$one_pointer_max = 1000000000000;

}
else if($direction == 3 || $direction == 4 || $direction == 5){ // means error, no of complain, delay direction
	$five_pointer_min_included = 0;
	$five_pointer_max = 0;
	$four_pointer_min_included = 1;
	$four_pointer_max = 1;
	$three_pointer_min_included = 2;
	$three_pointer_max = 2;
	$two_pointer_min_included = 3;
	$two_pointer_max = 3;
	$one_pointer_min_included = 4;
	$one_pointer_max = 1000000000000;
}
if($direction == 1 || $direction == 2){
	if($plan_in_number == 0){
		$actual_result = 0.0000001;
	}
	$accomplishment = round((100 * ($actual_result / $plan_in_number)),2);
}
else if($direction == 3 || $direction == 4 || $direction == 5){
	$accomplishment = $actual_result;
}
else if($direction == 6){
	if($actual_result == 0){
		$actual_result = 0.0000001;
	}
	$accomplishment = round((100 * ( $plan_in_number / $actual_result )),2);
}

//$weight = $weight;
$total_score = 0;
$final_score = 0;

//------------------find the total score now-----------------------------------
	if($accomplishment >= $one_pointer_min_included && $accomplishment < $one_pointer_max){
		$total_score = 1;
	}
	if($accomplishment >= $two_pointer_min_included && $accomplishment < $two_pointer_max){
		$total_score = 2;
	}
	if($accomplishment >= $three_pointer_min_included && $accomplishment < $three_pointer_max){
		$total_score = 3;
	}
	if($accomplishment >= $four_pointer_min_included && $accomplishment < $four_pointer_max){
		$total_score = 4;
	}
	if($accomplishment >= $five_pointer_min_included && $accomplishment < $five_pointer_max){
		$total_score = 5;
	}
//-----------------end of find the total score now------------------------------------

	$final_score = round(($total_score * $weight / 100),2);

	$original_data['BranchPerformanceDetail']['accomplishment'] = $accomplishment;
	$original_data['BranchPerformanceDetail']['rating'] = $total_score;
	$original_data['BranchPerformanceDetail']['final_result'] = $final_score;
//	}

//if ($this->HoPerformancePlan->save($this->data)) {
//if ($this->BranchPerformanceDetail->save($original_data)) {
// $this->Session->setFlash(__('The ho performance plan has been saved', true), '');
// $this->render('/elements/success');
//} else {
// $this->Session->setFlash(__('The ho performance plan could not be saved. Please, try again.', true), '');
// $this->render('/elements/failure');
//}

$update_row = $this->BranchPerformanceDetail->query('update  branch_performance_details set 
accomplishment = '.$accomplishment.', rating = '.$total_score.', final_result = '.$final_score.'
 where id = '.$item['branch_performance_details']['id']);


		}

		
		
		
	
//	$grade_id = $grade_row[0]['employee_details']['grade_id'];
//------------------------------------end of find all details in each plan id--------------------------------------------------------

	}

	function recalculate_plan($id = null) {
		
		$this->autoRender = false;
		$this->loadModel('BranchPerformancePlan');
		$this->loadModel('BranchPerformanceDetail');
		$this->loadModel('BranchEvaluationCriteria');
		
		 $this->redo_details($id);
		
		$original_data = array();
		
		$original_data = $this->BranchPerformancePlan->find('first', array('conditions' => array('BranchPerformancePlan.id' => $id)));
		$plan_id = $original_data['BranchPerformancePlan']['id'];
		$quarter = $original_data['BranchPerformancePlan']['quarter'];
		$budget_year_id = $original_data['BranchPerformancePlan']['budget_year_id'];
		$branch_id = $original_data['BranchPerformancePlan']['branch_id'];
		$plan_status = $original_data['BranchPerformancePlan']['plan_status'];
		  //--------------------------------------------------check if the general status is open--------------------------------------------------
			$this->loadModel('PerformanceStatus');
			$general_status = "open";
			$general_status_row =  $this->PerformanceStatus->query('select * from performance_statuses where  budget_year_id = '.$budget_year_id.' and quarter = '. $quarter);
			if(count($general_status_row) > 0){
				$general_status = $general_status_row[0]['performance_statuses']['status'];
			}
			//--------------------------------------------------end of check if the general status is open----------------------------------------------

		if($plan_status <= 2 && $general_status == "open"){
			$multiplication_ratio = 1;
			$total_weight = 0;
			$sum_weight = 0;
			$weight_row = $this->BranchPerformanceDetail->query('select * from branch_performance_details where branch_performance_plan_id = '.$plan_id.' ');
			foreach($weight_row as $item){
				$evaluation_id = $item['branch_performance_details']['branch_evaluation_criteria_id'];
				$evaluation_row = $this->BranchEvaluationCriteria->query('select * from branch_evaluation_criterias where id = '.$evaluation_id.'');
				$other_weight = $evaluation_row[0]['branch_evaluation_criterias']['weight'];
				$sum_weight += $other_weight;
			}
	
			if($sum_weight != null) {
				$total_weight +=  $sum_weight;
			}
			else {
				//$total_weight = $this_weight;
			}
	
			if($total_weight != 100 && $total_weight > 0){
				$multiplication_ratio = round( (100/$total_weight), 2);
			}
	
	
	//---------------------------------------end of check if weight sum is 100-------------------------------------------------
	
	$quarter_result_row = $this->BranchPerformanceDetail->find('first', 
	array(
	'fields' => array('sum(BranchPerformanceDetail.final_result) as total_sum'),
	'conditions' => array(
	'BranchPerformanceDetail.branch_performance_plan_id' => $id
	) 
	
	));
	
	$quarter_result = round(($quarter_result_row[0]['total_sum'] * $multiplication_ratio), 2) ;
	$original_data['BranchPerformancePlan']['result'] = $quarter_result;
	
	
			
	
	
				//if ($this->HoPerformancePlan->save($this->data)) {
				if ($this->BranchPerformancePlan->save($original_data)) {
					// $this->Session->setFlash(__('The ho performance plan has been saved', true), '');
					// $this->render('/elements/success');
				} else {
					// $this->Session->setFlash(__('The ho performance plan could not be saved. Please, try again.', true), '');
					// $this->render('/elements/failure');
				}
		}
		

		
	}

	function delete($id = null) {
		$this->loadModel('BranchPerformancePlan');
		$this->autoRender = false;
		if (!$id) {
			$this->Session->setFlash(__('Invalid id for branch performance detail', true), '');
			$this->render('/elements/failure');
		}
		if (stripos($id, '_') !== false) {
            $ids = explode('_', $id);
            try{
				$count_status = 0;
				foreach ($ids as $i) {
                  //  $this->BranchPerformanceDetail->delete($i);
				  $plan_row = $this->BranchPerformanceDetail->query("select * from branch_performance_details where id = ".$i."  ");			
			$plan_id = $plan_row[0]['branch_performance_details']['branch_performance_plan_id'];
			$plan_status_row = $this->BranchPerformancePlan->query("select * from branch_performance_plans where id = ".$plan_id."  ");			
			$plan_status = $plan_status_row[0]['branch_performance_plans']['plan_status'];
			$budget_year_id = $plan_status_row[0]['branch_performance_plans']['budget_year_id'];
			$quarter = $plan_status_row[0]['branch_performance_plans']['quarter'];
			  //--------------------------------------------------check if the general status is open--------------------------------------------------
$this->loadModel('PerformanceStatus');
$general_status = "open";
$general_status_row =  $this->PerformanceStatus->query('select * from performance_statuses where  budget_year_id = '.$budget_year_id.' and quarter = '. $quarter);
if(count($general_status_row) > 0){
	$general_status = $general_status_row[0]['performance_statuses']['status'];
}
//--------------------------------------------------end of check if the general status is open----------------------------------------------
			if($plan_status > 2 || $general_status == "closed"){
				$count_status ++;
			}
                }
				if($count_status == 0){
					foreach ($ids as $i) {

						$this->BranchPerformanceDetail->delete($i);
					}
					$this->Session->setFlash(__('Branch performance detail deleted', true), '');
					$this->render('/elements/success');
				}
				else{
					$this->Session->setFlash(__('The plans are not open for delete !', true), '');
				$this->render('/elements/failure3');
				}
               
            }
            catch (Exception $e){
				$this->Session->setFlash(__('Branch performance detail was not deleted', true), '');
				$this->render('/elements/failure');
            }
        } else {
			$plan_row = $this->BranchPerformanceDetail->query("select * from branch_performance_details where id = ".$id."  ");			
			$plan_id = $plan_row[0]['branch_performance_details']['branch_performance_plan_id'];
			$plan_status_row = $this->BranchPerformancePlan->query("select * from branch_performance_plans where id = ".$plan_id."  ");			
			$plan_status = $plan_status_row[0]['branch_performance_plans']['plan_status'];
			$budget_year_id = $plan_status_row[0]['branch_performance_plans']['budget_year_id'];
			$quarter = $plan_status_row[0]['branch_performance_plans']['quarter'];
			  //--------------------------------------------------check if the general status is open--------------------------------------------------
$this->loadModel('PerformanceStatus');
$general_status = "open";
$general_status_row =  $this->PerformanceStatus->query('select * from performance_statuses where  budget_year_id = '.$budget_year_id.' and quarter = '. $quarter);
if(count($general_status_row) > 0){
	$general_status = $general_status_row[0]['performance_statuses']['status'];
}
//--------------------------------------------------end of check if the general status is open----------------------------------------------

			if($plan_status <= 2 && $general_status == "open"){
				if ($this->BranchPerformanceDetail->delete($id)) {
					$this->Session->setFlash(__('Branch performance detail deleted', true), '');
					$this->render('/elements/success');
				} else {
					$this->Session->setFlash(__('Branch performance detail was not deleted', true), '');
					$this->render('/elements/failure');
				}
			} else {
				$this->Session->setFlash(__('The plan is not open for delete !', true), '');
				$this->render('/elements/failure3');
			}
            
        }
	}


	function copy_previous_details_branch( $id = null, $parent_id = null ){
		//$this->loadModel('HoPerformancePlan');
		
		
		if (!$id && empty($this->data)) {
			$this->Session->setFlash(__('Invalid br performance detail', true), '');
			$this->redirect(array('action' => 'index'));
		}
		if (!empty($this->data)) {
			$original_data = $this->data;
			$id = $original_data['BranchPerformanceDetail']['id'];
			
	
			$this->autoRender = false;
			$this->loadModel('BranchPerformancePlan');
	
			
			$plan_status_row = $this->BranchPerformancePlan->query("select * from branch_performance_plans where id = ".$id."  ");
			
			$plan_status = $plan_status_row[0]['branch_performance_plans']['plan_status'];	
			$result_status = $plan_status_row[0]['branch_performance_plans']['result_status'];
	
			if($result_status < 2){
	//----------------------------------------find the emp id----------------------------------------------------------
	$plan_row = $this->BranchPerformancePlan->query("select * from branch_performance_plans where id = ".$id." ");
	$branch_id = $plan_row[0]['branch_performance_plans']['branch_id'];
	//----------------------------------------end find the emp id----------------------------------------------------------
	
	//----------------------------------------find all details for that position---------------------------------------------
	
	$found_plan_id = 0;
	$found_plan_row = $this->BranchPerformancePlan->query("select * from branch_performance_plans where id < ".$id." and branch_id = ".$branch_id." order by id desc");
	foreach($found_plan_row as $item){
		$found_plan_id = $found_plan_row[0]['branch_performance_plans']['id'];
	
	}
	//------------------------------------------end of find all details for that position---------------------------------------
	if($found_plan_id > 0){
			//---------------------------------------------first delete everything --------------------------------------------------
			$del_delete_row = $this->BranchPerformanceDetail->query("delete from branch_performance_details where branch_performance_plan_id = ".$id." ");
			//------------------------------------------end of first delete everything-------------------------------------------------
			//---------------------------------------------------find the details and save them----------------------------------------------
	
			$saved_details_row = $this->BranchPerformanceDetail->query("select * from branch_performance_details where branch_performance_plan_id = ".$found_plan_id." ");
			foreach($saved_details_row as $detail){
				$branch_evaluation_criteria_id = $detail['branch_performance_details']['branch_evaluation_criteria_id'];
				
				$plan_in_number= $detail['branch_performance_details']['plan_in_number'];
				$actual_result = 0;
				
				$accomplishment = 0;
				$rating = 0;
				$final_result = 0;
				
				$save_detail_row = $this->BranchPerformanceDetail->query("insert into branch_performance_details 
				(branch_evaluation_criteria_id ,  plan_in_number, actual_result,  accomplishment, rating, final_result, branch_performance_plan_id)
				values ('".$branch_evaluation_criteria_id."', ".$plan_in_number.", ".$actual_result.",".$accomplishment."
				,".$rating.",".$final_result.", ".$id.") ");
				
			}
			//--------------------------------------------------end of find the details and save them--------------------------------------------
			$this->recalculate_plan($id);
			$this->Session->setFlash(__('Br performance detail saved', true), '');
			$this->render('/elements/success');
	
		}
		else {
			$this->Session->setFlash(__('There are no previous details available !.', true), '');
		$this->render('/elements/failure3');
	
		}
			} else {
	
				$this->Session->setFlash(__('The plan is closed for copying !.', true), '');
				$this->render('/elements/failure3');
	
			}
		
		}
	
		if($parent_id) {
			$this->set('parent_id', $parent_id);
		}
	
	}

}
?>