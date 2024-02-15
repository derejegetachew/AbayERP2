<?php
class BranchPerformancePlansController extends AppController {

	var $name = 'BranchPerformancePlans';

	function get_emp_names_few2() {  // two levels
		$this_user = $this->Session->read();
$this_user_id = $this_user['Auth']['User']['id'];
$this->loadModel('Employee');
$this->loadModel('Supervisor');

		$this->loadModel('User');
		$this->loadModel('Person');
		$emps = array();
//	 $this_user_id = 3135;
//	$this_user_id = 1225;
//   $this_user_id = 468;
 $subordinate_ids = array();
$this_id = 0;
 $this_id_row = $this->Employee->query('select * from employees where status = "active" and user_id = '.$this_user_id);
 if(count($this_id_row) > 0){
  $this_id = $this_id_row[0]['employees']['id'];
}
	$sub_id_row1 = $this->Supervisor->query('select * from supervisors where sup_emp_id = '.$this_id);
	if(count($sub_id_row1) > 0){
		foreach($sub_id_row1 as $item){
			$e_id = $item['supervisors']['emp_id'];
		  
			  $user_id_row = $this->Employee->query('select * from employees where id = '. $e_id. ' and status = "active" ');
			  if(count($user_id_row) > 0){
				$user_id = $user_id_row[0]['employees']['user_id'];
				$emp_id = $user_id_row[0]['employees']['card'];
					  $user_row = $this->User->query('select * from users where id = '. $user_id);
  
					  if(count($user_row) > 0){
						  $person_id = $user_row[0]['users']['person_id'];
						  
						  $person_row = $this->Person->query('select * from people where id = '. $person_id);
						  $full_name = $person_row[0]['people']['first_name'].' '.$person_row[0]['people']['middle_name'].' '.$person_row[0]['people']['last_name'];
						  $emps[$e_id] = $full_name.' - '.$emp_id;
			   
					  }
			  }
			

			  $sub_id_row2 = $this->Supervisor->query('select * from supervisors where sup_emp_id = '.$e_id);
			  if(count($sub_id_row2) > 0){
				foreach($sub_id_row2 as $item2){
					$e_id2 = $item2['supervisors']['emp_id'];
				  
					  $user_id_row2 = $this->Employee->query('select * from employees where id = '. $e_id2. ' and status = "active" ');
					if(count($user_id_row2) > 0){
						$user_id2 = $user_id_row2[0]['employees']['user_id'];
						$emp_id2 = $user_id_row2[0]['employees']['card'];
								$user_row2 = $this->User->query('select * from users where id = '. $user_id2);
			
								if(count($user_row2) > 0){
									$person_id2 = $user_row2[0]['users']['person_id'];
									
									$person_row2 = $this->Person->query('select * from people where id = '. $person_id2);
									$full_name2 = $person_row2[0]['people']['first_name'].' '.$person_row2[0]['people']['middle_name'].' '.$person_row2[0]['people']['last_name'];
									$emps[$e_id2] = $full_name2.' - '.$emp_id2;
						 
								}
					}
					  
		
				  }
			  }
			  
				  
		  }
	}
		
//  print_r($emps);
			 return $emps;
		
}
	function get_few_branches(){
		$user = $this->Session->read();
		$user_id = $user['Auth']['User']['id'];
		$this->loadModel('Employee');
		$this->loadModel('EmployeeDetail');
		$this->loadModel('Branch');
		
		// $user_id = 3135;
		
		$emp_id = 0;
		$emp_id_row = $this->Employee->query('select * from employees where status = "active" and user_id = '.$user_id);
		if(count($emp_id_row) > 0){
			$emp_id = $emp_id_row[0]["employees"]["id"];
		}

		$emp_detail_row = $this->EmployeeDetail->query('select * from employee_details where employee_id = '.$emp_id.' order by start_date desc');
		$branch_id = 0;
	//	$position_id = 0;
		if(count($emp_detail_row) > 0){
			$branch_id = $emp_detail_row[0]["employee_details"]["branch_id"];
		//	$position_id = $emp_detail_row[0]["employee_details"]["position_id"];

		}

		//-------------------------------------then get the district name-----------------------------------------------
		$district_name = "";
		$district_row = $this->Branch->query('select * from branches where id = '.$branch_id.' ');
		$district_name = $district_row[0]['branches']['name'];
		//------------------------------------end of get the district name---------------------------------------------------------
		//-----------------------------------------find the branches of that district-----------------------------------------------
		$branches_array = array();
		$branches_row = $this->Branch->query("select * from branches where region = '".$district_name."' and fc_code != '000' ");
		foreach($branches_row as $item){
			$branches_array[$item['branches']['id']] = $item['branches']['name'];
		}
		//--------------------------------------------end of the branches of that district-------------------------------------------

		return $branches_array;


	}

	function get_budget_year_ids(){
		$budget_year_array = array();
		$this->loadModel('BudgetYear');
		$ind = 1;
		$budget_years_row = $this->BudgetYear->query('select * from budget_years ');
			foreach($budget_years_row as $item){
				for($i = 1; $i <= 4; $i++){
					
					$budget_year_array[$ind] = $item['budget_years']['id']." ".$i ;
					$ind ++;
					//array_push($budget_year_array, $item."-".$q );
				}
			}
			return $budget_year_array;
	}

	function get_budget_years(){
		$budget_year_array = array();
		$this->loadModel('BudgetYear');
		$ind = 1;
		$budget_years_row = $this->BudgetYear->query('select * from budget_years ');
			foreach($budget_years_row as $item){
				for($i = 1; $i <= 4; $i++){
					$q = "";
					if($i == 1){
						$q = "I";
					}
					if($i == 2){
						$q = "II";
					}
					if($i == 3){
						$q = "III";
					}
					if($i == 4){
						$q = "IV";
					}
					$budget_year_array[$ind] = $item['budget_years']['name']." - ".$q ;
					$ind ++;
					//array_push($budget_year_array, $item."-".$q );
				}
			}
			return $budget_year_array;
	}
	
	function index() {
		// $branches = $this->BranchPerformancePlan->Branch->find('all');
		// $this->set(compact('branches'));
		$user = $this->Session->read();
		$user_id = $user['Auth']['User']['id'];
		$this->loadModel('Employee');
		$this->loadModel('EmployeeDetail');
		$this->loadModel('Branch');
		
		// $user_id = 3135;
		
		$emp_id = 0;
		$emp_id_row = $this->Employee->query('select * from employees where status = "active" and user_id = '.$user_id);
		if(count($emp_id_row) > 0){
			$emp_id = $emp_id_row[0]["employees"]["id"];
		}

		$emp_detail_row = $this->EmployeeDetail->query('select * from employee_details where employee_id = '.$emp_id.' order by start_date desc');
		$branch_id = 0;
		$position_id = 0;
		if(count($emp_detail_row) > 0){
			$branch_id = $emp_detail_row[0]["employee_details"]["branch_id"];
			$position_id = $emp_detail_row[0]["employee_details"]["position_id"];
		}
		$branch_category = "";
		$branch_type = "";
		$branch_type_row = $this->Branch->query('select * from branches where id = '.$branch_id.' ');
		if(count($branch_type_row) > 0){
			$branch_category = $branch_type_row[0]["branches"]["branch_category_id"];
		}
		
		if($branch_category == 2){
			$branch_type = "ho";
		}
		else {
			$branch_type = "branch";
		}

		//-------------------------------------------we have to identify  district managers-----------------------
		// $district_branch_managers = array();
		$is_district_mgr = 0;
		$this->loadModel('Position');
		$position_row = $this->Position->query('select * from positions where (name like "%District%" or id = 906)  and is_managerial = 1
		  ');

		foreach($position_row as $item){
				if($position_id == $item['positions']['id']){
					$is_district_mgr = 1;
					break;
				}
		}

		//------------------------------------end of identify branch managers and district managers----------------------------------
		$budget_years = $this->get_budget_years();
		//$this->set(compact('budget_years', 'branch_type'));
		$this->set(compact('branch_type', 'is_district_mgr', 'budget_years'));

		
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
			$budget_year_ids = $this->get_budget_year_ids();
			$year_quater_filter = explode(" ", $budget_year_ids[$budgetyear_id]);
			$year_filter = $year_quater_filter[0]  * 1;
			$quarter_filter = $year_quater_filter[1] * 1;
            //$conditions['HoPerformancePlan.budget_year_id'] = $budgetyear_id;
			$conditions['BranchPerformancePlan.budget_year_id'] = $year_filter;
			$conditions['BranchPerformancePlan.quarter'] = $quarter_filter;
        }
	
			$branch_id_array = array();
			foreach($this->get_few_branches() as $key => $val){
				array_push($branch_id_array, $key);
			}
	
		
			$conditions['BranchPerformancePlan.branch_id'] = $branch_id_array;
			
			$this->set('branchPerformancePlans', $this->BranchPerformancePlan->find('all', array('conditions' => $conditions, 'limit' => $limit, 'offset' => $start)));
			$this->set('results', $this->BranchPerformancePlan->find('count', array('conditions' => $conditions)));
		}
	function list_data2($id = null) {
		$start = (isset($_REQUEST['start'])) ? $_REQUEST['start'] : 0;
		$limit = (isset($_REQUEST['limit'])) ? $_REQUEST['limit'] : 5;
		$branch_id = (isset($_REQUEST['branch_id'])) ? $_REQUEST['branch_id'] : -1;
		if($id)
			$branch_id = ($id) ? $id : -1;
        $conditions = (isset($_REQUEST['conditions'])) ? $_REQUEST['conditions'] : '';

        eval("\$conditions = array( " . $conditions . " );");

		$branch_id_array = array();
		foreach($this->get_few_branches() as $key => $val){
			array_push($branch_id_array, $key);
		}

		if ($branch_id != -1) {
           // $conditions['BranchPerformancePlan.branch_id'] = $branch_id;
		   // $conditions['BranchPerformancePlan.branch_id'] = $branch_id_array;
		  // $conditions['BranchPerformancePlan.branch_id'] = 150;
        }
		$conditions['BranchPerformancePlan.branch_id'] = $branch_id_array;
		
		$this->set('branchPerformancePlans', $this->BranchPerformancePlan->find('all', array('conditions' => $conditions, 'limit' => $limit, 'offset' => $start)));
		$this->set('results', $this->BranchPerformancePlan->find('count', array('conditions' => $conditions)));
	}

	function view($id = null) {
		if (!$id) {
			$this->Session->setFlash(__('Invalid branch performance plan', true));
			$this->redirect(array('action' => 'index'));
		}
		$this->BranchPerformancePlan->recursive = 2;
		$this->set('branchPerformancePlan', $this->BranchPerformancePlan->read(null, $id));
	}

	function add($id = null) {
		if (!empty($this->data)) {

			$original_data = $this->data ;
			$branch_id = $original_data['BranchPerformancePlan']['branch_id'];
			$budget_year_id = $original_data['BranchPerformancePlan']['budget_year_id'];
			$quarter = $original_data['BranchPerformancePlan']['quarter'];
			$original_data['BranchPerformancePlan']['plan_status'] = 2;
			$original_data['BranchPerformancePlan']['result_status'] = 1;
//--------------------------------------------------check duplicates-------------------------------------------------
			$conditions = array('BranchPerformancePlan.branch_id' => $branch_id,'BranchPerformancePlan.budget_year_id' => $budget_year_id,'BranchPerformancePlan.quarter' => $quarter );
			$brPerformancePlan = $this->BranchPerformancePlan->find('all', array('conditions' => $conditions )); 
//-----------------------------------------------end of check duplicates---------------------------------------------	
		if(count($brPerformancePlan) == 0){	
			$this->BranchPerformancePlan->create();
			$this->autoRender = false;
			if ($this->BranchPerformancePlan->save($this->data)) {
				$this->Session->setFlash(__('The branch performance plan has been saved', true), '');
				$this->render('/elements/success');
			} else {
				$this->Session->setFlash(__('The branch performance plan could not be saved. Please, try again.', true), '');
				$this->render('/elements/failure');
			}
		} else {
			$this->Session->setFlash(__('The branch performance has already been inserted.', true), '');
			$this->render('/elements/failure3');
		}
		
			
		}
		if($id)
			$this->set('parent_id', $id);
	//	$branches = $this->BranchPerformancePlan->Branch->find('list');
	    $branches = $this->get_few_branches();
		$budget_years = $this->BranchPerformancePlan->BudgetYear->find('list');
		$this->set(compact('branches', 'budget_years'));
	}

	function edit($id = null, $parent_id = null) {
		if (!$id && empty($this->data)) {
			$this->Session->setFlash(__('Invalid branch performance plan', true), '');
			$this->redirect(array('action' => 'index'));
		}
		if (!empty($this->data)) {
			$original_data = $this->data ;
			$id = $original_data['BranchPerformancePlan']['id'];
			$branch_id = $original_data['BranchPerformancePlan']['branch_id'];
			$budget_year_id = $original_data['BranchPerformancePlan']['budget_year_id'];
			$quarter = $original_data['BranchPerformancePlan']['quarter'];
			$plan_status = $original_data['BranchPerformancePlan']['plan_status'];

			//---------------------------------------------check for duplicate------------------------------------------------------------------
			$plan_row = $this->BranchPerformancePlan->query("select * from branch_performance_plans 
			where branch_id = ".$branch_id." and budget_year_id = ".$budget_year_id." and quarter = ".$quarter." 
			and id != ".$id);
		//---------------------------------------------end of check for duplicates----------------------------------------------------------
	 	   //--------------------------------------------------check if the general status is open--------------------------------------------------
			$this->loadModel('PerformanceStatus');
			$general_status = "open";
			$general_status_row =  $this->PerformanceStatus->query('select * from performance_statuses where  budget_year_id = '.$budget_year_id.' and quarter = '. $quarter);
			if(count($general_status_row) > 0){
				$general_status = $general_status_row[0]['performance_statuses']['status'];
			}
			//--------------------------------------------------end of check if the general status is open----------------------------------------------

			if($plan_status <= 2 && $general_status == "open"){  // means pending agreement
                if(count($plan_row) == 0){
					$this->autoRender = false;
					if ($this->BranchPerformancePlan->save($this->data)) {
						$this->Session->setFlash(__('The branch performance plan has been saved', true), '');
						$this->render('/elements/success');
					} else {
						$this->Session->setFlash(__('The branch performance plan could not be saved. Please, try again.', true), '');
						$this->render('/elements/failure');
					}
				}
				else {
					$this->Session->setFlash(__('The plan exists!', true), '');
					$this->render('/elements/failure3');
				}
				
			}
			else {
				$this->Session->setFlash(__('The plan is not available for edit !', true), '');
				$this->render('/elements/failure3');
			}

			
		}
		$this->set('branch_performance_plan', $this->BranchPerformancePlan->read(null, $id));
		
		if($parent_id) {
			$this->set('parent_id', $parent_id);
		}
			
		//$branches = $this->BranchPerformancePlan->Branch->find('list');
		$branches = $this->get_few_branches();
		$budget_years = $this->BranchPerformancePlan->BudgetYear->find('list');
		$this->set(compact('branches', 'budget_years'));

	}

	function delete($id = null) {
		$this->autoRender = false;
		if (!$id) {
			$this->Session->setFlash(__('Invalid id for branch performance plan', true), '');
			$this->render('/elements/failure');
		}
		if (stripos($id, '_') !== false) {
            $ids = explode('_', $id);
            try{
				$count_plans = 0;
				foreach ($ids as $i) {
			//---------------------------------------------check for duplicate------------------------------------------------------------------
				$plan_row = $this->BranchPerformancePlan->query("select * from branch_performance_plans 
				where id = ".$i);
				$plan_status = $plan_row[0]['branch_performance_plans']['plan_status'];
				$budget_year_id = $plan_row[0]['branch_performance_plans']['budget_year_id'];
				$quarter = $plan_row[0]['branch_performance_plans']['quarter'];
				  //--------------------------------------------------check if the general status is open--------------------------------------------------
$this->loadModel('PerformanceStatus');
$general_status = "open";
$general_status_row =  $this->PerformanceStatus->query('select * from performance_statuses where  budget_year_id = '.$budget_year_id.' and quarter = '. $quarter);
if(count($general_status_row) > 0){
	$general_status = $general_status_row[0]['performance_statuses']['status'];
}
//--------------------------------------------------end of check if the general status is open----------------------------------------------
				if($plan_status > 2 || $general_status == "closed"){
					$count_plans++;
				}
			//---------------------------------------------end of check for duplicates----------------------------------------------------------
				}
				if($count_plans == 0){
					foreach ($ids as $i) {
						$this->BranchPerformancePlan->delete($i);
	
					}
					$this->Session->setFlash(__('Branch performance plan deleted', true), '');
					$this->render('/elements/success');
				}
				else{
					$this->Session->setFlash(__('The plans are not available for delete !', true), '');
					$this->render('/elements/failure3');
				}
              
				
            }
            catch (Exception $e){
				$this->Session->setFlash(__('Branch performance plan was not deleted', true), '');
				$this->render('/elements/failure');
            }
        } else {
			//---------------------------------------------check for duplicate------------------------------------------------------------------
				$plan_row = $this->BranchPerformancePlan->query("select * from branch_performance_plans 
				where id = ".$id);
				$plan_status = $plan_row[0]['branch_performance_plans']['plan_status'];
				$budget_year_id = $plan_row[0]['branch_performance_plans']['budget_year_id'];
				$quarter = $plan_row[0]['branch_performance_plans']['quarter'];
				  //--------------------------------------------------check if the general status is open--------------------------------------------------
$this->loadModel('PerformanceStatus');
$general_status = "open";
$general_status_row =  $this->PerformanceStatus->query('select * from performance_statuses where  budget_year_id = '.$budget_year_id.' and quarter = '. $quarter);
if(count($general_status_row) > 0){
	$general_status = $general_status_row[0]['performance_statuses']['status'];
}
//--------------------------------------------------end of check if the general status is open----------------------------------------------
			//---------------------------------------------end of check for duplicates----------------------------------------------------------
            if($plan_status <= 2 && $general_status == "open"){
				if ($this->BranchPerformancePlan->delete($id)) {
					$this->Session->setFlash(__('Branch performance plan deleted', true), '');
					$this->render('/elements/success');
				} else {
					$this->Session->setFlash(__('Branch performance plan was not deleted', true), '');
					$this->render('/elements/failure');
				}
			}else{
				$this->Session->setFlash(__('The plan is not available for delete !', true), '');
				$this->render('/elements/failure3');

			}
			
        }
	}

	function change_status_br($id = null, $parent_id = null) {
		if (!$id && empty($this->data)) {
			$this->Session->setFlash(__('Invalid br performance plan', true), '');
			$this->redirect(array('action' => 'index'));
		}
		if (!empty($this->data)) {
			
			$original_data = $this->data;
			// $id = $original_data['HoPerformancePlan']['id'];
			$this->loadModel('BranchPerformanceTrackingStatus');

				$id = $original_data['BranchPerformancePlan']['id'];
				$br_plan_id_array = explode("-",$id);
			 $e_id = $br_plan_id_array[0];
			 $budget_year_id = $br_plan_id_array[1];
			 $quarter = $br_plan_id_array[2];

			$result_status = $original_data['BranchPerformancePlan']['result_status'];
			$comment = $original_data['BranchPerformancePlan']['comment'];
      
      $select_status = $this->BranchPerformanceTrackingStatus->query('select * from branch_performance_tracking_statuses where employee_id = '.$e_id. 
			' and budget_year_id = '.$budget_year_id.' and quarter = '.$quarter);

			if(count($select_status) > 0){
      		$update_status = $this->BranchPerformanceTrackingStatus->query('update branch_performance_tracking_statuses set  result_status = '.$result_status.' 
			where  employee_id = '.$e_id.' and budget_year_id = '.$budget_year_id.' and quarter = '.$quarter);
      }
      else{
      $insert_status = $this->BranchPerformanceTrackingStatus->query('insert into branch_performance_tracking_statuses(employee_id, budget_year_id, quarter, result_status)   
				 values('.$e_id.' , '.$budget_year_id.' , '.$quarter.', '.$result_status.') '
				);
      
      }
   
	
					
				$this->Session->setFlash(__('The status has been changed successfully', true), '');
				$this->render('/elements/success');
				
		}

		$br_plan_id_array = explode("-",$id);
        
		$e_id = $br_plan_id_array[0];
		$budget_year_id = $br_plan_id_array[1];
		$quarter = $br_plan_id_array[2];

		$this->loadModel('BranchPerformanceTrackingStatus');

	   // $this->set('ho_performance_plan', $this->HoPerformancePlan->read(null, $id));

	   $this->set('branch_performance_plan', $this->BranchPerformanceTrackingStatus->find('first', 
	   array('conditions' => array('BranchPerformanceTrackingStatus.employee_id' => $e_id, 
	   'BranchPerformanceTrackingStatus.budget_year_id' => $budget_year_id,
	   'BranchPerformanceTrackingStatus.quarter' => $quarter,

   ))));


  	 $this->set('br_plan_id', $id);
		
	//	$this->set('branch_performance_plan', $this->BranchPerformancePlan->read(null, $id));
		
	}


	function change_status($id = null, $parent_id = null) {
		if (!$id && empty($this->data)) {
			$this->Session->setFlash(__('Invalid br performance plan', true), '');
			$this->redirect(array('action' => 'index'));
		}
		if (!empty($this->data)) {
			$original_data = $this->data;
			$id = $original_data['BranchPerformancePlan']['id'];
			$plan_status = $original_data['BranchPerformancePlan']['plan_status'];
			$result_status = $original_data['BranchPerformancePlan']['result_status'];
			$total_weight = 0;


		//	if($total_weight > 0) {  //make changes
				$this->autoRender = false;

    
	
		//-------------here i have to validate if the spv is authorized to change the status-------------------------------------------
   
				$update_status = $this->BranchPerformancePlan->query('update branch_performance_plans set plan_status = '.$plan_status.', result_status = '.$result_status.' where id = '.$id );
					
				$this->Session->setFlash(__('The status has been changed successfully', true), '');
				$this->render('/elements/success');
			
		
			// }
			// else { // do nothing
 			// 	$this->Session->setFlash(__('The status cannot be applied.', true), '');
			//  	$this->render('/elements/failure3');
			// }		
			
		}
		
		$this->set('branch_performance_plan', $this->BranchPerformancePlan->read(null, $id));
		
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

	function recalculate($id = null) {
		
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
	function br_my_branch_performance_report() {
		$this_user = $this->Session->read();
		$this_user_id = $this_user['Auth']['User']['id'];
		$this->loadModel('Employee');
		
		// $this_user_id = 1225;
		
	
	
		 $this_id = 0;
		 $this_id_row = $this->Employee->query('select * from employees where user_id = '.$this_user_id);
		 if(count($this_id_row) > 0){
			$this_id = $this_id_row[0]['employees']['id'];
			$emp_id = $this_id_row[0]['employees']['card'];
		}
		// $emp_id = 3915 ;
		$e_id = $this_id;
		$branch_name = '' ;
		
	
		// get position
		
		$this->loadModel('EmployeeDetail');
		$this->loadModel('Position');
		$position_id_row = $this->EmployeeDetail->query('select * from employee_details 
				where employee_id = '. $e_id .' order by start_date desc');
		$position_id = $position_id_row[0]['employee_details']['position_id'];
		$branch_id = $position_id_row[0]['employee_details']['branch_id'];
		$position_name_row = $this->Position->query('select * from positions
		where id = '. $position_id .' ');
		
		// end of get positions
		// get employee_name
		
		//-------------------------------------------we have to identify branch managers and district managers-----------------------
			// $district_branch_managers = array();
			$is_branch_mgr = 0;
			
			$position_row = $this->Position->query('select * from positions where name like "%Branch Manager%"  and is_managerial = 1
			  ');
	
			foreach($position_row as $item){
					if($position_id == $item['positions']['id']){
						$is_branch_mgr = 1;
						break;
					}
			}
	
		//------------------------------------end of identify branch managers and district managers----------------------------------
		//-----------------------------------find out the branch details-------------------------------------------------------------
		$this->loadModel('Branch');
		$branch_row = $this->Employee->query('select * from branches where id = '.$branch_id.'');
		$branch_name = $branch_row[0]['branches']['name'];
		$region = $branch_row[0]['branches']['region'];
		//-------------------------------------end of finding the branch details------------------------------------------------------
		
			$report_table = array();
		  $budget_years = array();
		  $all_budget_years_row = $this->BudgetYear->query('select * from budget_years 
		  order by order_by');
	
		
	foreach($all_budget_years_row as $item){
	
	//-----start with the first quarter---------------------------------------------------------------------------------------
	
	
	
	//----------------------start of preparing the report table ----------------------------------
	$one_row['budget_year'] = 0;
	$conditions3 = array('BudgetYear.id' => $item["budget_years"]['id'] );
				$hoPlan3 = $this->BudgetYear->find('first', array('conditions' => $conditions3));
				$one_row['budget_year']  = $hoPlan3['BudgetYear']['name'];
				$one_row['quarter1'] = 0;
				$one_row['quarter2'] = 0;
				$one_row['quarter3'] = 0;
				$one_row['quarter4'] = 0;
				$one_row['annual_average'] = 0;
	
	//------------------------------start for the first quarter----------------------------------------------------------
	
	
	$brPlan1 = $this->BranchPerformancePlan->query('select * from branch_performance_plans 
	where branch_id = '. $branch_id .' and budget_year_id = '.$item["budget_years"]['id'].' and quarter = 1');
	if(count($brPlan1) > 0){
	$one_row['quarter1'] = $brPlan1[0]['branch_performance_plans']['result'];
	}
	
	$brPlan2 = $this->BranchPerformancePlan->query('select * from branch_performance_plans 
	where branch_id = '. $branch_id .' and budget_year_id = '.$item["budget_years"]['id'].' and quarter = 2');
	if(count($brPlan2) > 0){
	$one_row['quarter2'] = $brPlan2[0]['branch_performance_plans']['result'];
	}
	
	$brPlan3 = $this->BranchPerformancePlan->query('select * from branch_performance_plans 
	where branch_id = '. $branch_id .' and budget_year_id = '.$item["budget_years"]['id'].' and quarter = 3');
	if(count($brPlan3) > 0){
	$one_row['quarter3'] = $brPlan3[0]['branch_performance_plans']['result'];
	}
	
	$brPlan4 = $this->BranchPerformancePlan->query('select * from branch_performance_plans 
	where branch_id = '. $branch_id .' and budget_year_id = '.$item["budget_years"]['id'].' and quarter = 4');
	if(count($brPlan4) > 0){
	$one_row['quarter4'] = $brPlan4[0]['branch_performance_plans']['result'];
	}
			   
	//-------------------------------end of for the first quarter---------------------------------------------------------	
	
	
	
	array_push($report_table, $one_row);
	
		  }
	
	
		// end of get the budget years applicable for the employee----------------------------------------------
	
	
		$this->set(compact ( 'branch_id' , 'branch_name' ,'region', 'report_table', 'is_branch_mgr' ));
		

	}

	function br_my_branch_performance_history_list ($id = null) {  // first just show the list of plan periods
		$this_user = $this->Session->read();
		$this_user_id = $this_user['Auth']['User']['id'];
		$this->loadModel('Employee');
		
		// $this_user_id = 1225;
		
	
	
		 $this_id = 0;
		 $this_id_row = $this->Employee->query('select * from employees where user_id = '.$this_user_id);
		 if(count($this_id_row) > 0){
			$this_id = $this_id_row[0]['employees']['id'];
			$emp_id = $this_id_row[0]['employees']['card'];
		}
		// $emp_id = 3915 ;
		$e_id = $this_id;
		$branch_name = '' ;
		
	
		// get position
		
		$this->loadModel('EmployeeDetail');
		$this->loadModel('Position');
		$position_id_row = $this->EmployeeDetail->query('select * from employee_details 
				where employee_id = '. $e_id .' order by start_date desc');
		$position_id = $position_id_row[0]['employee_details']['position_id'];
		$branch_id = $position_id_row[0]['employee_details']['branch_id'];

		$br_plan_ids = array();
	
	//------------------------------start for the first quarter----------------------------------------------------------
	
	//means it is not branch so find the plan
		
	$brPlan = $this->BranchPerformancePlan->query('select * from branch_performance_plans 
	 where branch_id = '. $branch_id .' ');
	 foreach($brPlan as $item){
		array_push($br_plan_ids, $item['branch_performance_plans']['id']);
	//	echo "there is";  
	 }
	   
	

			$start = (isset($_REQUEST['start'])) ? $_REQUEST['start'] : 0;
			$limit = (isset($_REQUEST['limit'])) ? $_REQUEST['limit'] : 5;
			
			$budgetyear_id = (isset($_REQUEST['budgetyear_id'])) ? $_REQUEST['budgetyear_id'] : -1;
			if($id)
				$budgetyear_id = ($id) ? $id : -1;
				$conditions = (isset($_REQUEST['conditions'])) ? $_REQUEST['conditions'] : '';
	
			eval("\$conditions = array( " . $conditions . " );");
			if ($budgetyear_id != -1) {
				$conditions['BranchPerformancePlan.budget_year_id'] = $budgetyear_id;
			}
		//	$conditions['HoPerformancePlan.employee_id'] = $idd;
  
		 $conditions['BranchPerformancePlan.id'] = $br_plan_ids;
			// $conditions['HoPerformancePlan.plan_status'] = 2;
			//$emps = $this->get_emp_names();
	   //------------------------------------get emp name--------------------------------------------------------------------
			   // get employee_name
			
			// $emps = array();
			//-----------------------------------find out the branch details-------------------------------------------------------------
		$this->loadModel('Branch');
		$branch_row = $this->Branch->query('select * from branches where id = '.$branch_id.'');
		$branch_name = $branch_row[0]['branches']['name'];

		
	
		//-------------------------------------end of finding the branch details------------------------------------------------------
			
			// end of get employee_name
	   //-------------------------------------end of get emp name--------------------------------------------------------------
		//	print_r($this->HoPerformancePlan->find('all', array('conditions' => $conditions, 'limit' => $limit, 'offset' => $start)));
			$this->set('brPerformancePlans', $this->BranchPerformancePlan->find('all', array('conditions' => $conditions, 'limit' => $limit, 'offset' => $start)));
			$this->set('results', $this->BranchPerformancePlan->find('count', array('conditions' => $conditions)));
			$this->set('branch_name', $branch_name);
	
		}

	
	function br_my_branch_performance_history_index(){
		$budget_years = $this->BranchPerformancePlan->BudgetYear->find('all');
		$this->set(compact('budget_years'));
	}

	function br_my_branch_objectives_report($br_plan_id = null) {  //means the technical and training
		
			$appraisal_period = '';
		
			$score_summary = 0;
		
			$actual_total_weight = 0;
	//		$emps = $this->get_emp_names();
	// find quarter, budget_year, emp_id ------------------------------------------------------------------------------------
	$br_plan_row = $this->BranchPerformancePlan->query('select * from branch_performance_plans where id = '.$br_plan_id.'');
	$quarter = $br_plan_row[0]['branch_performance_plans']['quarter'];
	$qrtr = '';
	if($quarter == 1){
		$qrtr = "I";
	}
	if($quarter == 2){
		$qrtr = "II";
	}
	if($quarter == 3){
		$qrtr = "III";
	}
	if($quarter == 4){
		$qrtr = "IV";
	}
	 $branch_id = $br_plan_row[0]['branch_performance_plans']['branch_id'];
	 $budget_year_id = $br_plan_row[0]['branch_performance_plans']['budget_year_id'];
	 $quarter = $br_plan_row[0]['branch_performance_plans']['quarter'];
			 $this->loadModel('BudgetYear');
			 $conditions3 = array('BudgetYear.id' => $budget_year_id );
			 $brBudgetYear = $this->BudgetYear->find('first', array('conditions' => $conditions3));
			 $budget_year  = $brBudgetYear['BudgetYear']['name'];
			 $appraisal_period = $budget_year." [quarter ".$qrtr. "]";		
	
	// end of find quarter, budget_year, emp_id-----------------------------------------------------------------
	

	// get department/district-------------------------------------------------------------------------------------------------------
	
	$this->loadModel('Branch');
	$branch_row = $this->Branch->query('select * from branches where id = '.$branch_id.'');
	$branch_name = $branch_row[0]['branches']['name'];
	$region = $branch_row[0]['branches']['region'];
	$branch_manager_name = $branch_row[0]['branches']['branch_manager_name'];

	
	// end of get department/district------------------------------------------------------------------------------------------------
	$this->loadModel('BranchPerformanceDetail');	
	$this->loadModel('BranchEvaluationCriteria');
	
			$objective_table = array();
			$obj_one_row = array();
			
	
			$brPlanObj = $this->BranchPerformanceDetail->query('select * from branch_performance_details 
				where branch_performance_plan_id = '. $br_plan_id .' ');
	
			 for($j = 0; $j < count($brPlanObj) ; $j++){
				
				$evaluation_id = $brPlanObj[$j]['branch_performance_details']['branch_evaluation_criteria_id'];

				$evaluation_row = $this->BranchEvaluationCriteria->query('select * from branch_evaluation_criterias
				where id = '. $evaluation_id .' ');
				

				$actual_total_weight +=  $evaluation_row[0]['branch_evaluation_criterias']['weight'];
	
				$obj_one_row['objective'] = $evaluation_row[0]['branch_evaluation_criterias']['goal'];
				
				$obj_one_row['target'] = $evaluation_row[0]['branch_evaluation_criterias']['target'];
				$obj_one_row['measure'] = $evaluation_row[0]['branch_evaluation_criterias']['measure'];
				$obj_one_row['weight'] =  $evaluation_row[0]['branch_evaluation_criterias']['weight'];
				$obj_one_row['plan'] = $brPlanObj[$j]['branch_performance_details']['plan_in_number'];
				$obj_one_row['actual'] = $brPlanObj[$j]['branch_performance_details']['actual_result'];
				$obj_one_row['accomplishment'] = $brPlanObj[$j]['branch_performance_details']['accomplishment'];
				$obj_one_row['rating'] = $brPlanObj[$j]['branch_performance_details']['rating'];
				$obj_one_row['final_result'] = $brPlanObj[$j]['branch_performance_details']['final_result'];
				$score_summary += $brPlanObj[$j]['branch_performance_details']['final_result'];
				array_push($objective_table, $obj_one_row);
	
			 }
			 
	
	
		//-------------------halt halt halt halt halt halt halt-----------------------------------------------------------
		
		
			$this->set(compact ('objective_table', 'branch_id' , 'branch_name' ,'region', 'branch_manager_name',  
			'appraisal_period' , 'score_summary','actual_total_weight', 'br_plan_id' ));
			
		}

		function agree_technical($id = null, $parent_id = null){
			if (!$id && empty($this->data)) {
				$this->Session->setFlash(__('Invalid br performance plan', true), '');
				$this->redirect(array('action' => 'index'));
			}
			if (!empty($this->data)) {
				$original_data = $this->data;
				$id = $original_data['BranchPerformancePlan']['id'];
				$plan_status = $original_data['BranchPerformancePlan']['plan_status'];
				$result_status = $original_data['BranchPerformancePlan']['result_status'];
				$comment = trim(str_replace("'", "`", $original_data['BranchPerformancePlan']['comment']));

					
					$this->autoRender = false;

			//--------------------------------------------find the previous status---------------------------------------------
			$prev_result_status = 1000;
			
			$current_status_row = $this->BranchPerformancePlan->query('select * from branch_performance_plans where id = '.$id );
			if(count($current_status_row) > 0){
				
				$prev_result_status = $current_status_row[0]['branch_performance_plans']['result_status'];
			}
			//----------------------------------------end of finding the previous status---------------------------------------
	        if($prev_result_status < 2){
				if($result_status <= 1){  //staight away
					$update_status = $this->BranchPerformancePlan->query('update branch_performance_plans set plan_status = '.$plan_status.', result_status = '.$result_status.', comment = "'.$comment.'" where id = '.$id );
					$this->Session->setFlash(__('The status has been changed successfully', true), '');
					$this->render('/elements/success');
				}	
				
				if($plan_status <= 2 && $result_status > 1){
					$this->Session->setFlash(__('You must agree to the plan before responding to the result.', true), '');
					$this->render('/elements/failure3');
				}

				if($plan_status > 2 && $result_status > 1){
					$update_status = $this->BranchPerformancePlan->query('update branch_performance_plans set plan_status = '.$plan_status.', result_status = '.$result_status.', comment = "'.$comment.'" where id = '.$id );
					$this->Session->setFlash(__('The status has been changed successfully', true), '');
					$this->render('/elements/success');
				}
			}
			else {
				$this->Session->setFlash(__('The status is either closed for change or is empty. Please contact HR department', true), '');
				$this->render('/elements/failure3');
			}
						
													
			}

			$this->set('branch_performance_plan', $this->BranchPerformancePlan->read(null, $id));

		}

		function get_each_quarter_position($e_id, $from_date, $to_date, $q){
			$year_only_from = date('Y', strtotime($from_date));
			   $year_only_to = date('Y', strtotime($to_date));
	
				if($q == 1){
					$quarter_start_date = $year_only_from."-07-01";
					$quarter_end_date = $year_only_from."-09-30";
				}
				if($q == 2){
					$quarter_start_date = $year_only_from."-10-01";
					$quarter_end_date = $year_only_from."-12-31";
				}
				if($q == 3){
					$quarter_start_date = $year_only_to."-01-01";
					$quarter_end_date = $year_only_to."-03-31";
				}
				if($q == 4){
					$quarter_start_date = $year_only_to."-04-01";
					$quarter_end_date = $year_only_to."-06-30";
				}
	$position_id_for_quarter_row = array();
				$check_q_row =  $this->EmployeeDetail->query('select * from employee_details 
		where employee_id = '. $e_id .' and start_date <= "'. $quarter_end_date .'" order by start_date');
		if(count($check_q_row) > 0){  // this means the emp has worked in this quarter so now decide where he worked
			//-------------------are there any emp detail entries during this quarter---------------------------------------------
			$transition_date_row =  $this->EmployeeDetail->query('select * from employee_details 
			where employee_id = '. $e_id .' and start_date > "'. $quarter_start_date .'" and start_date < "'.$quarter_end_date.'" order by start_date');
			//------------------end of are there any emp detail entries during this quarter---------------------------------------
			
			if(count($transition_date_row) > 0){ // means there have been transitions(in this case we have to decide where)----------------------------------------------
			  $max_date_worked = 0; //
			  $max_worked_id = 0;
			  $initial_date = $quarter_start_date;
			  foreach($transition_date_row as $index => $value){  //subtract quarter start date from the transition date
		
			
					if($index == (count($transition_date_row)-1)){ //common case if it is zero
						$num_days1 = strtotime($value['employee_details']['start_date']) - strtotime($initial_date);
						$num_days2 = strtotime($quarter_end_date) - strtotime($value['employee_details']['start_date']) ;
						if($num_days1 >= $max_date_worked || $num_days2 >= $max_date_worked){
							if($num_days1 > $num_days2){
	
								$position_id_for_quarter_row = $this->EmployeeDetail->query('select * from employee_details 
								where employee_id = '. $e_id .' and start_date < "'. $value['employee_details']['start_date'].'" order by start_date desc' );
							
							}
							else {
								$position_id_for_quarter_row = $this->EmployeeDetail->query('select * from employee_details 
								where employee_id = '. $e_id .' and start_date <= "'. $value['employee_details']['start_date'].'" order by start_date desc' );
							}
						}
						
					} else {//
						$num_days = strtotime($value['employee_details']['start_date']) - strtotime($initial_date);
						if($num_days >= $max_date_worked){
							$position_id_for_quarter_row = $this->EmployeeDetail->query('select * from employee_details 
						where employee_id = '. $e_id .' and start_date < "'. $value['employee_details']['start_date'].'" order by start_date desc' );
						   $max_date_worked = $num_days;
						   
						}
	
						$initial_date = $value['employee_details']['start_date'];
					}
									  
			  }
			}
			else { // there has been no transitions
				$position_id_for_quarter_row = $this->EmployeeDetail->query('select * from employee_details 
				where employee_id = '. $e_id .' and start_date <= "'. $quarter_start_date.'" order by start_date desc' );
			}
	
		}
		else { //means everything is zero for this quarter b/se the emp hasn't be hired yet
			//----------------------------- the emp hasn't been hired just return an empty array--------------------------------------------------------
				$position_id_for_quarter_row = $this->EmployeeDetail->query('select * from employee_details 
				where employee_id = -1 order by start_date ' );
		}
	
		return $position_id_for_quarter_row;
	
		}

		function br_emp_report_index(){
$user = $this->Session->read();
			$user_id = $user['Auth']['User']['id'];
			$this->loadModel('Employee');
			$this->loadModel('EmployeeDetail');
			$this->loadModel('Branch');
			
			// $user_id = 3135;
			
			$emp_id = 0;
			$emp_id_row = $this->Employee->query('select * from employees where status = "active" and user_id = '.$user_id);
			if(count($emp_id_row) > 0){
				$emp_id = $emp_id_row[0]["employees"]["id"];
			}
	
			$emp_detail_row = $this->EmployeeDetail->query('select * from employee_details where employee_id = '.$emp_id.' order by start_date desc');
			$branch_id = 0;
			$position_id = 0;
			if(count($emp_detail_row) > 0){
				$branch_id = $emp_detail_row[0]["employee_details"]["branch_id"];
				$position_id = $emp_detail_row[0]["employee_details"]["position_id"];
			}
	
			$branch_category = "";
			$branch_type = "";
			$branch_type_row = $this->Branch->query('select * from branches where id = '.$branch_id.' ');
			if(count($branch_type_row) > 0){
				$branch_category = $branch_type_row[0]["branches"]["branch_category_id"];
			}
			
			if($branch_category == 2){
				$branch_type = "ho";
			}
			else {
				$branch_type = "branch";
			}
	
			//-------------------------------------------we have to identify branch managers and district managers-----------------------
			// $district_branch_managers = array();
			$is_district_branch_mgr = 0;
			$this->loadModel('Position');
			$position_row = $this->Position->query('select * from positions where (name like "%District%"  and is_managerial = 1)
			 or name like "%Branch Manager%"   ');
	
			foreach($position_row as $item){
					if($position_id == $item['positions']['id']){
						$is_district_branch_mgr = 1;
						break;
					}
			}
	
			//------------------------------------end of identify branch managers and district managers----------------------------------
	
			$this->set(compact('branch_type', 'is_district_branch_mgr'));
	
			// $budget_years = $this->HoPerformancePlan->BudgetYear->find('all');
			// $this->set(compact('budget_years', 'branch_type'));
	
			//$employees = $this->BranchPerformanceTracking->Employee->find('all');
			//$this->set(compact('employees'));
		}

		// function report_emp_br(){
		// 	//$budget_year_search = 0;

							
		// 						//$budget_year_search = 0;
		// 				if (!empty($this->data)) {
							
		// 					$this->Session->setFlash(__('The competence category has been saved', true), '');
		// 					$this->render('/elements/success');
		// 				return $this->redirect(
		// 					array('controller' => 'ho_performance_plans', 'action' => 'index')
		// 				);

		// 		}

		// 		$this->loadModel('BudgetYear');
		// 		$budget_years = $this->BudgetYear->find('list');
		// 		$emps = $this->get_emp_names_few2();
		// 		//$employees = $this->HoPerformancePlan->Employee->find('list');
		// 		$this->set(compact('budget_years', 'emps'));
		
		// }

		function emp_report(){
			//$budget_year_search = 0;
			if (!empty($this->data)) {
				
						 $this->Session->setFlash(__('The competence category has been saved', true), '');
						 $this->render('/elements/success');
						return $this->redirect(
							array('controller' => 'ho_performance_plans', 'action' => 'index')
						);
			
			}
			
			$this->loadModel('BudgetYear');
			$budget_years = $this->BudgetYear->find('list');
			$emps = $this->get_emp_names_few2();
			//$employees = $this->HoPerformancePlan->Employee->find('list');
			$this->set(compact('budget_years', 'emps'));
		
		}

		function br_emp_tracking_report($br_plan_id = null) {  //means the technical and training
		
			$br_plan_id_array = explode("-",$br_plan_id);
	
			$e_id = $br_plan_id_array[0];
			$budget_year_id = $br_plan_id_array[1];
			$quarter = $br_plan_id_array[2];

//-----------------------------------branch performance trackings-------------------------------------------------------------
	$this->loadModel('BranchPerformanceTrackingStatus');
	$tracking_status_row = $this->BranchPerformanceTrackingStatus->query('select * from branch_performance_tracking_statuses 
	where employee_id = '. $e_id .' and budget_year_id = '.$budget_year_id.' and quarter = '.$quarter);
	if(count($tracking_status_row) == 0){
		$tracking_status_insert = $this->BranchPerformanceTrackingStatus->query('insert into branch_performance_tracking_statuses
		(employee_id, budget_year_id, quarter, result_status) values('.$e_id.','.$budget_year_id.','.$quarter.' , 1)');
		
	}
//----------------------------------end of branch performance trackings---------------------------------------------------------
	
			//	$emp_id = 3915 ;
				$full_name = '' ;
				$position_name = '' ;
				$dept_name = '';
				$appraisal_period = '';
				$immediate_supervisor_name = 'no name';
				$score_summary = 0;
				$total_weight = 0;
        $score_summary_aggregate = 0;
        $branch_result = 0;
				$training1 = '';
				$training2 = '';
				$training3 = '';
		//		$emps = $this->get_emp_names();
		// find quarter, budget_year, emp_id ------------------------------------------------------------------------------------
		// $ho_plan_row = $this->HoPerformancePlan->query('select * from ho_performance_plans where id = '.$ho_plan_id.'');
		// $quarter = $ho_plan_row[0]['ho_performance_plans']['quarter'];
		$qrtr = '';
		if($quarter == 1){
			$qrtr = "I";
		}
		if($quarter == 2){
			$qrtr = "II";
		}
		if($quarter == 3){
			$qrtr = "III";
		}
		if($quarter == 4){
			$qrtr = "IV";
		}
		// $e_id = $ho_plan_row[0]['ho_performance_plans']['employee_id'];
		// $budget_year_id = $ho_plan_row[0]['ho_performance_plans']['budget_year_id'];
		// $quarter = $ho_plan_row[0]['ho_performance_plans']['quarter'];
				 $this->loadModel('BudgetYear');
				 $conditions3 = array('BudgetYear.id' => $budget_year_id );
				 $hoBudgetYear = $this->BudgetYear->find('first', array('conditions' => $conditions3));
				 $budget_year  = $hoBudgetYear['BudgetYear']['name'];
				 $appraisal_period = $budget_year." [quarter ".$qrtr. "]";		
		
		// end of find quarter, budget_year, emp_id-----------------------------------------------------------------
		// get position------------------------------------------------------------------------------------------------------------
		$this->loadModel('Employee');
			$this->loadModel('EmployeeDetail');
			$this->loadModel('Position');
			$from_date = $hoBudgetYear['BudgetYear']['from_date'];
			$to_date = $hoBudgetYear['BudgetYear']['to_date'];
	
			$year_only_from = date('Y', strtotime($from_date));
			$year_only_to = date('Y', strtotime($to_date));
			$q = $quarter;
	
				if($q == 1){
					$quarter_start_date = $year_only_from."-07-01";
					$quarter_end_date = $year_only_from."-09-30";
				}
				if($q == 2){
					$quarter_start_date = $year_only_from."-10-01";
					$quarter_end_date = $year_only_from."-12-31";
				}
				if($q == 3){
					$quarter_start_date = $year_only_to."-01-01";
					$quarter_end_date = $year_only_to."-03-31";
				}
				if($q == 4){
					$quarter_start_date = $year_only_to."-04-01";
					$quarter_end_date = $year_only_to."-06-30";
				}
	
	
		$branch_id_for_quarter_row = $this->get_each_quarter_position($e_id, $from_date, $to_date , $quarter );
		$position_id = $branch_id_for_quarter_row[0]['employee_details']['position_id'];
		$branch_id = $branch_id_for_quarter_row[0]['employee_details']['branch_id'];
			
			// $position_id_row = $this->EmployeeDetail->query('select * from employee_details 
			// 		where employee_id = '. $e_id .' ');
			// $position_id = $position_id_row[0]['employee_details']['position_id'];
		//	$branch_id = $position_id_row[0]['employee_details']['branch_id'];
			$position_name_row = $this->Position->query('select * from positions
			where id = '. $position_id .' ');
			$position_name = $position_name_row[0]['positions']['name'];
		// end of get position--------------------------------------------------------------------------------------------------------	
		// get employee_name-----------------------------------------------------------------------------------------------------------
				
			$this->loadModel('User');
			$this->loadModel('Person');
			
			 
			  $emp_row = $this->Employee->query('select * from employees where id = '.$e_id.'');
			  $emp_id = $emp_row[0]['employees']['card'];
			  $user_id = $emp_row[0]['employees']['user_id'];
			  $user_row = $this->User->query('select * from users where id = '. $user_id);
			 if(count($user_row) > 0){
				$person_id = $user_row[0]['users']['person_id'];
				$person_row = $this->Person->query('select * from people where id = '. $person_id);
				$full_name = $person_row[0]['people']['first_name'].' '.$person_row[0]['people']['middle_name'].' '.$person_row[0]['people']['last_name'];
			 }
			
		// end of get employee_name	---------------------------------------------------------------------------------------------------------
		// get department/district-------------------------------------------------------------------------------------------------------
		
		$this->loadModel('Branch');
		$branch_row = $this->Employee->query('select * from branches where id = '.$branch_id.'');
		$dept_name = $branch_row[0]['branches']['name'];
		
		// end of get department/district------------------------------------------------------------------------------------------------
		$objective_table = array();
		$obj_one_row = array();
		//------------------------------------get the trackings--------------------------------------------------------------------------
		$this->loadModel('BranchPerformanceSetting');
		$this->loadModel('BranchPerformanceTracking');
	
		
		$score_summary = 0; // out of five
	
		$branch_setting_row = $this->BranchPerformanceSetting->query('select * from branch_performance_settings where position_id = '. $position_id);
		foreach($branch_setting_row as $item){
			$each_total_goal = 0;
			$each_total_rating = 0;
			$total_weight += $item['branch_performance_settings']['weight'];
			$branch_tracking_row = $this->BranchPerformanceTracking->query('select * from branch_performance_trackings where employee_id = '. $e_id .' and goal = '.$item['branch_performance_settings']['id'].' and date between "'.$quarter_start_date.'" and "'.$quarter_end_date.'"');
			foreach($branch_tracking_row as $item2){
				$obj_one_row['objective'] = $item['branch_performance_settings']['goal'];
				$obj_one_row['target'] = $item['branch_performance_settings']['target'];
				$obj_one_row['measure'] = $item['branch_performance_settings']['measure'];
				$obj_one_row['weight'] = $item['branch_performance_settings']['weight'];
				$obj_one_row['date'] = $item2['branch_performance_trackings']['date'];
				$obj_one_row['value'] = $item2['branch_performance_trackings']['value'];
				array_push($objective_table, $obj_one_row);
				$each_total_goal += $item2['branch_performance_trackings']['value'];
			}
			if($each_total_goal > $item["branch_performance_settings"]["five_pointer_min"]  && $each_total_goal <= $item["branch_performance_settings"]["five_pointer_max_included"]){
				$each_total_rating = 5 * $item["branch_performance_settings"]["weight"]/100;
			}
			if($each_total_goal > $item["branch_performance_settings"]["four_pointer_min"]  && $each_total_goal <= $item["branch_performance_settings"]["four_pointer_max_included"]){
				$each_total_rating = 4 * $item["branch_performance_settings"]["weight"]/100;
			}
			if($each_total_goal > $item["branch_performance_settings"]["three_pointer_min"]  && $each_total_goal <= $item["branch_performance_settings"]["three_pointer_max_included"]){
				$each_total_rating = 3 * $item["branch_performance_settings"]["weight"]/100;
			}
			if($each_total_goal > $item["branch_performance_settings"]["two_pointer_min"]  && $each_total_goal <= $item["branch_performance_settings"]["two_pointer_max_included"]){
				$each_total_rating = 2 * $item["branch_performance_settings"]["weight"]/100;
			}
			if($each_total_goal > $item["branch_performance_settings"]["one_pointer_min"]  && $each_total_goal <= $item["branch_performance_settings"]["one_pointer_max_included"]){
				$each_total_rating = 1 * $item["branch_performance_settings"]["weight"]/100;
			}
	
			$score_summary += $each_total_rating;
	
		}
	
	$this->loadModel('BranchPerformancePlan');
			$br_plan_row = $this->BranchPerformancePlan->query('select * from branch_performance_plans
			where branch_id = '. $branch_id .' and budget_year_id = '.$budget_year_id.' and quarter = '.$quarter);

			if(count($br_plan_row) > 0){ //means if branch plan is found
				$branch_result = $br_plan_row[0]['branch_performance_plans']['result'];

			}

			if($total_weight > 0){
				if ($position_id == 93 || $position_id == 122 || $position_id == 71){
					$score_summary_aggregate = round(0.85*($branch_result) + 0.15*($score_summary * 100 / $total_weight), 2);
				}
				else if ($position_id == 673 || $position_id == 793 ){
					$score_summary_aggregate = round(0.75*($branch_result) + 0.25*($score_summary * 100 / $total_weight) , 2);
				}
				else {
					$score_summary_aggregate = round (0.6*($branch_result) + 0.4*($score_summary * 100 / $total_weight) , 2);
				}
			}

			
	
	
		//------------------------------------end of getting the trackings---------------------------------------------------------------
	//	$this->loadModel('HoPerformanceDetail');	
		
				
				
		
				// $hoPlanObj = $this->HoPerformanceDetail->query('select * from ho_performance_details 
				// 	where ho_performance_plan_id = '. $ho_plan_id .' ');
		
				//  for($j = 0; $j < count($hoPlanObj) ; $j++){
				// 	$obj_one_row['objective'] = $hoPlanObj[$j]['ho_performance_details']['objective'];
				// 	$obj_one_row['kpis'] = $hoPlanObj[$j]['ho_performance_details']['perspective'];
				// 	$obj_one_row['measure'] = $hoPlanObj[$j]['ho_performance_details']['measure'];
				// 	$obj_one_row['weight'] = $hoPlanObj[$j]['ho_performance_details']['weight'];
				// 	$obj_one_row['plan'] = $hoPlanObj[$j]['ho_performance_details']['plan_in_number'];
				// 	$obj_one_row['actual'] = $hoPlanObj[$j]['ho_performance_details']['actual_result'];
				// 	$obj_one_row['accomplishment'] = $hoPlanObj[$j]['ho_performance_details']['accomplishment'];
				// 	$obj_one_row['total_score'] = $hoPlanObj[$j]['ho_performance_details']['total_score'];
				// 	$obj_one_row['final_score'] = $hoPlanObj[$j]['ho_performance_details']['final_score'];
				// 	$score_summary += $hoPlanObj[$j]['ho_performance_details']['final_score'];
				// 	array_push($objective_table, $obj_one_row);
		
				//  }
	//------------------------------------find supervisor id-------------------------------------------------------------------------------
				 $this->loadModel('Supervisor');
				 $sup_id = -1;
				 $sup_id_row = array();
				 $sup_id_row = $this->Supervisor->find('first', array('conditions' => array('Supervisor.emp_id' => $e_id)));
				 if(count($sup_id_row) > 0){
					 $sup_id = $sup_id_row['Supervisor']['sup_emp_id'];
				 }
				 else {
					 $sup_id = -1;
				 }
		
				if($sup_id != -1){
					
				//	$immediate_supervisor_name = $emps[$sup_id];
		   //---------------------------------------find supervisor name---------------------------------------------------
		   $sup_name_row = $this->Employee->query('select * from employees where id = '.$sup_id.'');
			  
			  $sup_user_id = $sup_name_row[0]['employees']['user_id'];
			  $sup_user_row = $this->User->query('select * from users where id = '. $sup_user_id);
			 if(count($sup_user_row) > 0){
				$sup_person_id = $sup_user_row[0]['users']['person_id'];
				$sup_person_row = $this->Person->query('select * from people where id = '. $sup_person_id);
				$immediate_supervisor_name = $sup_person_row[0]['people']['first_name'].' '.$sup_person_row[0]['people']['middle_name'].' '.$sup_person_row[0]['people']['last_name'];
			 }
		   //----------------------------------------end of finding immediate supervisor name-----------------------------
				}
		
			//---------------end of find supervisor id----------------------------------------------------------------------------	
			//------------------------------------------end of find immediate supervisor------------------------------------------
			//------------------------------------------find the trainings--------------------------------------------------------
				$this->loadModel('Allocatedtraining');
				$this->loadModel('Training');
		
				$hoTraining = $this->Allocatedtraining->query('select * from allocatedtrainings 
				where budget_year_id = '. $budget_year_id .' and employee_id = '.$e_id. ' and quarter = '.$quarter);
				if(count($hoTraining) > 0){
					$training_row1 = $this->Training->find('first', array('conditions' => array('Training.id' => $hoTraining[0]['allocatedtrainings']['training1'])));
					$training1 = $training_row1['Training']['name'];
					$training_row2 = $this->Training->find('first', array('conditions' => array('Training.id' => $hoTraining[0]['allocatedtrainings']['training2'])));
					$training2 = $training_row2['Training']['name'];
					$training_row3 = $this->Training->find('first', array('conditions' => array('Training.id' => $hoTraining[0]['allocatedtrainings']['training3'])));
					$training3 = $training_row3['Training']['name'];
					
				}
		
			//-----------------------------------------end of find the trainings--------------------------------------------------
			//-------------------halt halt halt halt halt halt halt-----------------------------------------------------------
			
			
				$this->set(compact ('objective_table', 'emp_id' , 'position_name' ,'full_name', 'dept_name', 'immediate_supervisor_name',
				'appraisal_period' ,'training1', 'training2', 'training3', 'score_summary','score_summary_aggregate','branch_result', 'br_plan_id',
				'e_id','budget_year_id','quarter' , 'total_weight'));
				
			}
	
	  function br_emp_technical_report($br_plan_id = null) {  //means the technical and training
			
				$br_plan_id_array = explode("-",$br_plan_id);
		
				$e_id = $br_plan_id_array[0];
				$budget_year_id = $br_plan_id_array[1];
				$quarter = $br_plan_id_array[2];

				//-----------------------------------branch performance trackings-------------------------------------------------------------
	$this->loadModel('BranchPerformanceTrackingStatus');
	$tracking_status_row = $this->BranchPerformanceTrackingStatus->query('select * from branch_performance_tracking_statuses 
	where employee_id = '. $e_id .' and budget_year_id = '.$budget_year_id.' and quarter = '.$quarter);
	if(count($tracking_status_row) == 0){
		$tracking_status_insert = $this->BranchPerformanceTrackingStatus->query('insert into branch_performance_tracking_statuses
		(employee_id, budget_year_id, quarter, result_status) values('.$e_id.','.$budget_year_id.','.$quarter.' , 1)');
		
	}
//----------------------------------end of branch performance trackings---------------------------------------------------------
		
				//	$emp_id = 3915 ;
					$full_name = '' ;
					$position_name = '' ;
					$dept_name = '';
					$appraisal_period = '';
					$immediate_supervisor_name = 'no name';
					$total_weight = 0;
					$score_summary = 0;
           			$score_summary_aggregate = 0;
           			$branch_result = 0;
					$training1 = '';
					$training2 = '';
					$training3 = '';
			//		$emps = $this->get_emp_names();
			// find quarter, budget_year, emp_id ------------------------------------------------------------------------------------
			// $ho_plan_row = $this->HoPerformancePlan->query('select * from ho_performance_plans where id = '.$ho_plan_id.'');
			// $quarter = $ho_plan_row[0]['ho_performance_plans']['quarter'];
			$qrtr = '';
			if($quarter == 1){
				$qrtr = "I";
			}
			if($quarter == 2){
				$qrtr = "II";
			}
			if($quarter == 3){
				$qrtr = "III";
			}
			if($quarter == 4){
				$qrtr = "IV";
			}
			// $e_id = $ho_plan_row[0]['ho_performance_plans']['employee_id'];
			// $budget_year_id = $ho_plan_row[0]['ho_performance_plans']['budget_year_id'];
			// $quarter = $ho_plan_row[0]['ho_performance_plans']['quarter'];
					 $this->loadModel('BudgetYear');
					 $conditions3 = array('BudgetYear.id' => $budget_year_id );
					 $hoBudgetYear = $this->BudgetYear->find('first', array('conditions' => $conditions3));
					 $budget_year  = $hoBudgetYear['BudgetYear']['name'];
					 $appraisal_period = $budget_year." [quarter ".$qrtr. "]";		
			
			// end of find quarter, budget_year, emp_id-----------------------------------------------------------------
			// get position------------------------------------------------------------------------------------------------------------
				$this->loadModel('Employee');
				$this->loadModel('EmployeeDetail');
				$this->loadModel('Position');
				$from_date = $hoBudgetYear['BudgetYear']['from_date'];
				$to_date = $hoBudgetYear['BudgetYear']['to_date'];
		
				$year_only_from = date('Y', strtotime($from_date));
				$year_only_to = date('Y', strtotime($to_date));
				$q = $quarter;
		
					if($q == 1){
						$quarter_start_date = $year_only_from."-07-01";
						$quarter_end_date = $year_only_from."-09-30";
					}
					if($q == 2){
						$quarter_start_date = $year_only_from."-10-01";
						$quarter_end_date = $year_only_from."-12-31";
					}
					if($q == 3){
						$quarter_start_date = $year_only_to."-01-01";
						$quarter_end_date = $year_only_to."-03-31";
					}
					if($q == 4){
						$quarter_start_date = $year_only_to."-04-01";
						$quarter_end_date = $year_only_to."-06-30";
					}
		
		
			$branch_id_for_quarter_row = $this->get_each_quarter_position($e_id, $from_date, $to_date , $quarter );
			$position_id = $branch_id_for_quarter_row[0]['employee_details']['position_id'];
			$branch_id = $branch_id_for_quarter_row[0]['employee_details']['branch_id'];
				
				// $position_id_row = $this->EmployeeDetail->query('select * from employee_details 
				// 		where employee_id = '. $e_id .' ');
				// $position_id = $position_id_row[0]['employee_details']['position_id'];
			//	$branch_id = $position_id_row[0]['employee_details']['branch_id'];
				$position_name_row = $this->Position->query('select * from positions
				where id = '. $position_id .' ');
				$position_name = $position_name_row[0]['positions']['name'];
			// end of get position--------------------------------------------------------------------------------------------------------	
			// get employee_name-----------------------------------------------------------------------------------------------------------
					
				$this->loadModel('User');
				$this->loadModel('Person');
				
				 
				  $emp_row = $this->Employee->query('select * from employees where id = '.$e_id.'');
				  $emp_id = $emp_row[0]['employees']['card'];
				  $user_id = $emp_row[0]['employees']['user_id'];
				  $user_row = $this->User->query('select * from users where id = '. $user_id);
				 if(count($user_row) > 0){
					$person_id = $user_row[0]['users']['person_id'];
					$person_row = $this->Person->query('select * from people where id = '. $person_id);
					$full_name = $person_row[0]['people']['first_name'].' '.$person_row[0]['people']['middle_name'].' '.$person_row[0]['people']['last_name'];
				 }
				
			// end of get employee_name	---------------------------------------------------------------------------------------------------------
			// get department/district-------------------------------------------------------------------------------------------------------
			
			$this->loadModel('Branch');
			$branch_row = $this->Employee->query('select * from branches where id = '.$branch_id.'');
			$dept_name = $branch_row[0]['branches']['name'];
			
			// end of get department/district------------------------------------------------------------------------------------------------
			$objective_table = array();
			$obj_one_row = array();
			//------------------------------------get the trackings--------------------------------------------------------------------------
			$this->loadModel('BranchPerformanceSetting');
			$this->loadModel('BranchPerformanceTracking');
		
			
			$score_summary = 0; // out of five
		
			$branch_setting_row = $this->BranchPerformanceSetting->query('select * from branch_performance_settings where position_id = '. $position_id);
			foreach($branch_setting_row as $item){
				$each_total_goal = 0;
				$each_total_rating = 0;
				$total_weight += $item['branch_performance_settings']['weight'];

					$obj_one_row['objective'] = $item['branch_performance_settings']['goal'];
					$obj_one_row['target'] = $item['branch_performance_settings']['target'];
					$obj_one_row['measure'] = $item['branch_performance_settings']['measure'];
					$obj_one_row['weight'] = $item['branch_performance_settings']['weight'];
				$total_value_for_each = 0;
				$branch_tracking_row = $this->BranchPerformanceTracking->query('select * from branch_performance_trackings where employee_id = '. $e_id .' and goal = '.$item['branch_performance_settings']['id'].' and date between "'.$quarter_start_date.'" and "'.$quarter_end_date.'"');
				foreach($branch_tracking_row as $item2){
					
				//	$obj_one_row['value'] = $item2['branch_performance_trackings']['value'];
				
					$each_total_goal += $item2['branch_performance_trackings']['value'];
					$total_value_for_each += $item2['branch_performance_trackings']['value'];
				}
				if($each_total_goal > $item["branch_performance_settings"]["five_pointer_min"]  && $each_total_goal <= $item["branch_performance_settings"]["five_pointer_max_included"]){
					$each_total_rating = 5 * $item["branch_performance_settings"]["weight"]/100;
				}
				if($each_total_goal > $item["branch_performance_settings"]["four_pointer_min"]  && $each_total_goal <= $item["branch_performance_settings"]["four_pointer_max_included"]){
					$each_total_rating = 4 * $item["branch_performance_settings"]["weight"]/100;
				}
				if($each_total_goal > $item["branch_performance_settings"]["three_pointer_min"]  && $each_total_goal <= $item["branch_performance_settings"]["three_pointer_max_included"]){
					$each_total_rating = 3 * $item["branch_performance_settings"]["weight"]/100;
				}
				if($each_total_goal > $item["branch_performance_settings"]["two_pointer_min"]  && $each_total_goal <= $item["branch_performance_settings"]["two_pointer_max_included"]){
					$each_total_rating = 2 * $item["branch_performance_settings"]["weight"]/100;
				}
				if($each_total_goal > $item["branch_performance_settings"]["one_pointer_min"]  && $each_total_goal <= $item["branch_performance_settings"]["one_pointer_max_included"]){
					$each_total_rating = 1 * $item["branch_performance_settings"]["weight"]/100;
				}
	
				$obj_one_row['total_value'] = $total_value_for_each;
				$obj_one_row['rating'] = round($each_total_rating, 2);
				array_push($objective_table, $obj_one_row);
				$score_summary += $each_total_rating;
		
			}
		
      		$this->loadModel('BranchPerformancePlan');
      			$br_plan_row = $this->BranchPerformancePlan->query('select * from branch_performance_plans
      			where branch_id = '. $branch_id .' and budget_year_id = '.$budget_year_id.' and quarter = '.$quarter);
      
      			if(count($br_plan_row) > 0){ //means if branch plan is found
      				$branch_result = $br_plan_row[0]['branch_performance_plans']['result'];
      
      			}

				if($total_weight > 0){
					if ($position_id == 93 || $position_id == 122 || $position_id == 71){
						$score_summary_aggregate = round(0.85*($branch_result) + 0.15*($score_summary * 100 / $total_weight), 2);
					}
					else if ($position_id == 673 || $position_id == 793 ){
						$score_summary_aggregate = round(0.75*($branch_result) + 0.25*($score_summary * 100 / $total_weight), 2);
					}
					else {
						$score_summary_aggregate = round(0.6*($branch_result) + 0.4*($score_summary * 100 / $total_weight), 2);
					}
				}
      
      			
		
		
			//------------------------------------end of getting the trackings---------------------------------------------------------------
		//	$this->loadModel('HoPerformanceDetail');	
			
					
					
			
					// $hoPlanObj = $this->HoPerformanceDetail->query('select * from ho_performance_details 
					// 	where ho_performance_plan_id = '. $ho_plan_id .' ');
			
					//  for($j = 0; $j < count($hoPlanObj) ; $j++){
					// 	$obj_one_row['objective'] = $hoPlanObj[$j]['ho_performance_details']['objective'];
					// 	$obj_one_row['kpis'] = $hoPlanObj[$j]['ho_performance_details']['perspective'];
					// 	$obj_one_row['measure'] = $hoPlanObj[$j]['ho_performance_details']['measure'];
					// 	$obj_one_row['weight'] = $hoPlanObj[$j]['ho_performance_details']['weight'];
					// 	$obj_one_row['plan'] = $hoPlanObj[$j]['ho_performance_details']['plan_in_number'];
					// 	$obj_one_row['actual'] = $hoPlanObj[$j]['ho_performance_details']['actual_result'];
					// 	$obj_one_row['accomplishment'] = $hoPlanObj[$j]['ho_performance_details']['accomplishment'];
					// 	$obj_one_row['total_score'] = $hoPlanObj[$j]['ho_performance_details']['total_score'];
					// 	$obj_one_row['final_score'] = $hoPlanObj[$j]['ho_performance_details']['final_score'];
					// 	$score_summary += $hoPlanObj[$j]['ho_performance_details']['final_score'];
					// 	array_push($objective_table, $obj_one_row);
			
					//  }
		//------------------------------------find supervisor id-------------------------------------------------------------------------------
					 $this->loadModel('Supervisor');
					 $sup_id = -1;
					 $sup_id_row = array();
					 $sup_id_row = $this->Supervisor->find('first', array('conditions' => array('Supervisor.emp_id' => $e_id)));
					 if(count($sup_id_row) > 0){
						 $sup_id = $sup_id_row['Supervisor']['sup_emp_id'];
					 }
					 else {
						 $sup_id = -1;
					 }
			
					if($sup_id != -1){
						
					//	$immediate_supervisor_name = $emps[$sup_id];
			   //---------------------------------------find supervisor name---------------------------------------------------
			   $sup_name_row = $this->Employee->query('select * from employees where id = '.$sup_id.'');
				  
				  $sup_user_id = $sup_name_row[0]['employees']['user_id'];
				  $sup_user_row = $this->User->query('select * from users where id = '. $sup_user_id);
				 if(count($sup_user_row) > 0){
					$sup_person_id = $sup_user_row[0]['users']['person_id'];
					$sup_person_row = $this->Person->query('select * from people where id = '. $sup_person_id);
					$immediate_supervisor_name = $sup_person_row[0]['people']['first_name'].' '.$sup_person_row[0]['people']['middle_name'].' '.$sup_person_row[0]['people']['last_name'];
				 }
			   //----------------------------------------end of finding immediate supervisor name-----------------------------
					}
			
				//---------------end of find supervisor id----------------------------------------------------------------------------	
				//------------------------------------------end of find immediate supervisor------------------------------------------
				//------------------------------------------find the trainings--------------------------------------------------------
					$this->loadModel('Allocatedtraining');
					$this->loadModel('Training');
			
					$hoTraining = $this->Allocatedtraining->query('select * from allocatedtrainings 
					where budget_year_id = '. $budget_year_id .' and employee_id = '.$e_id. ' and quarter = '.$quarter);
					if(count($hoTraining) > 0){
						$training_row1 = $this->Training->find('first', array('conditions' => array('Training.id' => $hoTraining[0]['allocatedtrainings']['training1'])));
						$training1 = $training_row1['Training']['name'];
						$training_row2 = $this->Training->find('first', array('conditions' => array('Training.id' => $hoTraining[0]['allocatedtrainings']['training2'])));
						$training2 = $training_row2['Training']['name'];
						$training_row3 = $this->Training->find('first', array('conditions' => array('Training.id' => $hoTraining[0]['allocatedtrainings']['training3'])));
						$training3 = $training_row3['Training']['name'];
						
					}
			
				//-----------------------------------------end of find the trainings--------------------------------------------------
				//-------------------halt halt halt halt halt halt halt-----------------------------------------------------------
				
				
					$this->set(compact ('objective_table', 'emp_id' , 'position_name' ,'full_name', 'dept_name', 'immediate_supervisor_name',
					'appraisal_period' ,'training1', 'training2', 'training3', 'score_summary','score_summary_aggregate','branch_result', 'br_plan_id',
					 'e_id','budget_year_id','quarter', 'total_weight'));
					
				}

}


?>