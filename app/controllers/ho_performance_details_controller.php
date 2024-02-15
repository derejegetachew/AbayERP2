<?php
class HoPerformanceDetailsController extends AppController {

	var $name = 'HoPerformanceDetails';

	function get_emp_names() {
		//---------------------------------------get $emps-------------------------------------------------------------
		$this->loadModel('Employee');
		$this->loadModel('User');
		$this->loadModel('Person');
		$emps = array();
	
		$emp_rows= $this->Employee->query('select * from employees where status = "active" ');
		
		
		for($i = 0 ; $i < count($emp_rows) ; $i++){ 
			 $emp_id = $emp_rows[$i]['employees']['id'];
			 
			 $user_id = $emp_rows[$i]['employees']['user_id'];
			 $user_row = $this->User->query('select * from users where status = "active" and id = '. $user_id);
			 if(count($user_row) > 0){
				$person_id = $user_row[0]['users']['person_id'];
				
				$person_row = $this->Person->query('select * from people where id = '. $person_id);
				$full_name = $person_row[0]['people']['first_name'].' '.$person_row[0]['people']['middle_name'].' '.$person_row[0]['people']['last_name'];
				$emps[$emp_id] = $full_name.' - '.$emp_id;
			}
			
		}
	//--------------------------------------end of get $emps---------------------------------------------------------
			 return $emps;
		
		 }

		 function get_sup_id($emp_id){
			$sup_id = -1;
			$this->loadModel('Supervisor');
			$this->loadModel('Employee');
			$this->loadModel('EmployeeDetail');
			$this->loadModel('Position');
			$this->loadModel('Branch');
			$this->loadModel('Grade');
	
			//------------------------------------------------------find the position of the emp------------------------------------------
			$position_id = -1;
			$branch_id = -1;
			$grade_id = -1;
	
				$position_row = $this->EmployeeDetail->query('select * from employee_details where employee_id = '. $emp_id.' order by start_date desc');
				if(count($position_row) > 0){
					$position_id = $position_row[0]['employee_details']['position_id'];
					$branch_id = $position_row[0]['employee_details']['branch_id'];
					$grade_id = $position_row[0]['employee_details']['grade_id'];
				}
				$grade = -1;
	
				$grade_row = $this->Grade->query('select * from grades where id = '. $grade_id.' ');
				if(count($grade_row) > 0){
					$grade = $grade_row[0]['grades']['grade_num'];
				}
				
			
		
			//-----------------------------------------------------end of finding the position of the emp---------------------------------
			$sup_emp_id = -1;
				if($grade >= 14){ // means directors and above
	
				}
				else {
					$sup_id_row = $this->Supervisor->query('select * from supervisors where emp_id = '.$emp_id);
					if(count($sup_id_row) > 0){
						$sup_emp_id = $sup_id_row[0]['supervisors']['sup_emp_id'];
						$position_row2 = $this->EmployeeDetail->query('select * from employee_details where employee_id = '. $sup_emp_id.' order by start_date desc');
					$sup_branch_id = -1;
						if(count($position_row2) > 0){
							$sup_branch_id = $position_row2[0]['employee_details']['branch_id'];
					 }
						
						if($sup_branch_id != $branch_id){
							$sup_id = $sup_emp_id;
						} else {
							$sup_id_row2 = $this->Supervisor->query('select * from supervisors where emp_id = '.$sup_emp_id);
							if(count($sup_id_row2) > 0){
								$sup_id = $sup_id_row2[0]['supervisors']['sup_emp_id'];
							}
							
	
						}
	
					}
	
				}
	
				return $sup_id;
	
		}
      
function emp_level($emp_id){
		$emp_level = 1;
		$this->loadModel('Supervisor');
		$this->loadModel('Employee');
		$this->loadModel('EmployeeDetail');
		$this->loadModel('Position');
		$this->loadModel('Branch');

		//------------------------------------------------------find the position of the emp------------------------------------------
		$position_row = $this->EmployeeDetail->query('select * from employee_details where employee_id = '. $emp_id.' order by start_date desc');
		$position_id = $position_row[0]['employee_details']['position_id'];
		$branch_id = $position_row[0]['employee_details']['branch_id'];
		
		$position_name_row = $this->Position->query('select * from positions where id = '. $position_id.' ');
		$position_name = strtolower($position_name_row[0]['positions']['name']);
		$branch_name_row = $this->Branch->query('select * from branches where id = '. $branch_id.' ');
		$branch_name = strtolower($branch_name_row[0]['branches']['name']);

		//-----------------------------------------------------end of finding the position of the emp---------------------------------
	
   if(strpos($position_name, "manager - it security") !==  false){
			$emp_level = 3;
		}
		else if(strpos($position_name, "it security officer") !== false){
			$emp_level = 2;
		}
		else if(strpos($position_name, "management assistant") !== false){
			$emp_level = 3;
		}
		else if(strpos($position_name, "ethics officer") !== false){
			$emp_level = 3;
		}
	
		else if(strpos($position_name, "executive assistant") !== false){
			$emp_level = 3;
		}
	
		else if((strpos($branch_name, "construction") !== false) && (strpos($position_name, "manager") !== false)){
			$emp_level = 3;
		}
		else if((strpos($branch_name, "construction") !== false) && (strpos($position_name, "manager") == false)){
			$emp_level = 2;
		}
   else if($position_id == 780){
			$emp_level = 3;
		}
//----------------------------------------------the general start here-----------------------------------------------------------------
else {
	$is_sub1_active = 0;
	$is_sub2_active = 0;
	$sub1_id_row = array();

//	$quarter_three_row =  $this->HoPerformancePlan->query('select * from ho_performance_plans where employee_id = '.$emp_id.' and budget_year_id = '.$budget_year_id.' and quarter = 3');
	$sub1_id_row = $this->Supervisor->query('select * from supervisors where sup_emp_id = '.$emp_id);

	if(count($sub1_id_row) > 0){
		
		foreach($sub1_id_row as $emp_item1){
			$sub1_id = $emp_item1['supervisors']['emp_id'];
			$sub1_active_row = $this->Employee->query('select * from employees where id = '.$sub1_id.' and status = "active" ');
			if(count($sub1_active_row) > 0){

				$is_sub1_active = 1;
				$sub2_id_row = $this->Supervisor->query('select * from supervisors where sup_emp_id = '.$sub1_id);
				foreach($sub2_id_row as $emp_item2){
					$sub2_id = $emp_item2['supervisors']['emp_id'];
					$sub2_active_row = $this->Employee->query('select * from employees where id = '.$sub2_id.' and status = "active" ');
					if(count($sub2_active_row) > 0){
						$is_sub2_active = 1;
					}
				}

			}
		}
		
	}
	else {
		$emp_level = 1;
	}

	if($is_sub1_active > 0){
			if($is_sub2_active > 0){
				$emp_level = 3;
			} else {
				$emp_level = 2;
			}

	}
	else {
		$emp_level  = 1;
	}
}
		
   
    return $emp_level;

	}

		 function emp_level2222222222($emp_id){
			//----------------if officer 1, if manager 2, if director 3-----------------------------------------------------
			$emp_level = 1;
			$this->loadModel('Supervisor');
				//$sup_id = -1;
				$sub_id_row = array();
				$sub_id_row = $this->Supervisor->find('first', array('conditions' => array('Supervisor.sup_emp_id' => $emp_id)));
				if(count($sub_id_row) > 0){
					$sub_id = $sub_id_row['Supervisor']['emp_id'];
					$sub_id_row2 = array();
					$sub_id_row2 = $this->Supervisor->find('first', array('conditions' => array('Supervisor.sup_emp_id' => $sub_id)));
					if(count($sub_id_row2) > 0){
						$emp_level = 3;
					}
					else {
						$emp_level = 2;
					}
		
				}
				else {
				//	$sup_id = -1;
					$emp_level = 1;
				}
		
			  return $emp_level;
		
			}

			
	
		function redo_details($ho_performance_plan_id){
			$this->autoRender = false;
			$this->loadModel('HoPerformanceDetail');
			//	$original_data = $this->data;
	//---------------------------------------find all details in each plan id------------------------------------------------------------
			$detail_row = $this->HoPerformanceDetail->query('select * from ho_performance_details where ho_performance_plan_id = '. $ho_performance_plan_id.' ');
			foreach($detail_row as $item){
				$original_data = array();
				$original_data = $this->HoPerformanceDetail->find('first', array('conditions' => array('HoPerformanceDetail.id' => $item['ho_performance_details']['id'])));
				$actual_result = $original_data['HoPerformanceDetail']['actual_result'];
				$plan_in_number = $original_data['HoPerformanceDetail']['plan_in_number'];
				$direction = $original_data['HoPerformanceDetail']['direction'];
			//	if($actual_result > 0){
				
	
				if($direction == 1 || $direction == 6 || $direction == 8){ // incremental or sdt(standard delivery time) and rate
					$five_pointer_min_included = 125;
					$five_pointer_max = 1000000000000;
					$four_pointer_min_included = 110;
					$four_pointer_max = 125;
					$three_pointer_min_included = 100;
					$three_pointer_max = 110;
					$two_pointer_min_included = 60;
					$two_pointer_max = 100;
					$one_pointer_min_included = 0;
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
				else if($direction == 7){ // means npl
					$five_pointer_min_included = 0;
					$five_pointer_max = 3.0000000000001;
					$four_pointer_min_included = 3.0000000000001;
					$four_pointer_max = 3.500000000001;
					$three_pointer_min_included = 3.500000000001;
					$three_pointer_max = 4.0000000000001;
					$two_pointer_min_included = 4.000000000001;
					$two_pointer_max = 4.500000000001;
					$one_pointer_min_included = 4.500000000001;
					$one_pointer_max = 1000000000000;
				}
				
				if($direction == 1 || $direction == 2){
					if($plan_in_number == 0){
						$plan_in_number = 0.0000001;
					}
					$accomplishment = round((100 * ($actual_result / $plan_in_number)),2);
				}
				else if($direction == 3 || $direction == 4 || $direction == 5 || $direction == 7 ){
					$accomplishment = $actual_result;
				}
				else if($direction == 6 || $direction == 8){
					if($actual_result == 0){
						$actual_result = 0.0000001;
					}
					$accomplishment = round((100 * ( $plan_in_number / $actual_result )),2);
				}
				
				$weight = $original_data['HoPerformanceDetail']['weight'];
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
	
					$original_data['HoPerformanceDetail']['accomplishment'] = $accomplishment;
					$original_data['HoPerformanceDetail']['total_score'] = $total_score;
					$original_data['HoPerformanceDetail']['final_score'] = $final_score;
		//	}
	
		//if ($this->HoPerformancePlan->save($this->data)) {
			if ($this->HoPerformanceDetail->save($original_data)) {
				// $this->Session->setFlash(__('The ho performance plan has been saved', true), '');
				// $this->render('/elements/success');
			} else {
				// $this->Session->setFlash(__('The ho performance plan could not be saved. Please, try again.', true), '');
				// $this->render('/elements/failure');
			}
			}
			
		//	$grade_id = $grade_row[0]['employee_details']['grade_id'];
	//------------------------------------end of find all details in each plan id--------------------------------------------------------
		
	
		}	
	
		function recalculate_plan($id) {
			
			$this->autoRender = false;
			$this->loadModel('HoPerformancePlan');
			$plan_status_row = $this->HoPerformancePlan->query("select * from ho_performance_plans where id = ".$id."  ");
			
			$plan_status = $plan_status_row[0]['ho_performance_plans']['plan_status'];	
			$result_status = $plan_status_row[0]['ho_performance_plans']['result_status'];
			if($result_status < 2){
				$this->redo_details($id);
			}
		
			//	$original_data = $this->data;
			$original_data = array();
			$original_data = $this->HoPerformancePlan->find('first', array('conditions' => array('HoPerformancePlan.id' => $id)));
			$id = $original_data['HoPerformancePlan']['id'];
			$quarter = $original_data['HoPerformancePlan']['quarter'];
			$budget_year_id = $original_data['HoPerformancePlan']['budget_year_id'];
			$emp_id = $original_data['HoPerformancePlan']['employee_id'];
			$grade_array = array(11,12,13,16,17,18,19);
		//	$emp_level = $this->emp_level($emp_id);
		    $sup_id = $this->sup_emp_id($emp_id);
			//---------------------get grade id---------------------------------------------------------------------
				$this->loadModel('EmployeeDetail');
			//	$grade_row = $this->EmployeeDetail->query('select * from employee_details where employee_id = '. $emp_id);
			  $grade_row = $this->EmployeeDetail->query('select * from employee_details where employee_id = '. $emp_id.' order by start_date desc');
			$grade_id = $grade_row[0]['employee_details']['grade_id'];
	
			//---------------------end of get grade id-------------------------------------------------------------
			
	
			//-----------------find supervisor id (find director id)-------------------------------------------
			// $this->loadModel('Supervisor');
			// $sup_id = -1;
			// if($emp_level == 1){
			// 	$sup_id_row = array();
			// 	$sup_id_row = $this->Supervisor->find('first', array('conditions' => array('Supervisor.emp_id' => $emp_id)));
			// 	if(count($sup_id_row) > 0){
			// 		$sup_id1 = $sup_id_row['Supervisor']['sup_emp_id'];
			// 		$sup_id_row2 = array();
			// 		$sup_id_row2 = $this->Supervisor->find('first', array('conditions' => array('Supervisor.emp_id' => $sup_id1)));
			// 		if(count($sup_id_row2) > 0){
			// 			$sup_id = $sup_id_row2['Supervisor']['sup_emp_id'];
			// 		}
	
			// 	}
			// 	else {
			// 		$sup_id = -1;
			// 	}
			// }
			// if($emp_level == 2){
				
			// 	$sup_id_row = array();
			// 	$sup_id_row = $this->Supervisor->find('first', array('conditions' => array('Supervisor.emp_id' => $emp_id)));
			// 	if(count($sup_id_row) > 0){
			// 		$sup_id = $sup_id_row['Supervisor']['sup_emp_id'];
			// 	}
			// 	else {
			// 		$sup_id = -1;
			// 	}
			// }
			
	
	//---------------end of find supervisor id (director id)----------------------------------------------------------------
	//----------------------------------------check if weight sum is 100-----------------------------------------------------
	$multiplication_ratio = 1;
	$weight_sum_row = $this->HoPerformanceDetail->find('first', 
	array(
	'fields' => array('sum(HoPerformanceDetail.weight) as weight_sum'),
	'conditions' => array(
	'HoPerformanceDetail.ho_performance_plan_id' => $id
	) 
	
	));
	$weight_sum = $weight_sum_row[0]['weight_sum'];
	if($weight_sum != 100){
		$multiplication_ratio = round( (100/$weight_sum), 2);
	}
	//---------------------------------------end of check if weight sum is 100-------------------------------------------------
	
			$this->loadModel('HoPerformanceDetail');
	
	//---------------------------------------------common for all quarters------------------------------------------------
	//---------------find self technical percent---------------------------------------------------------------------------
	
	$self_technical_percent_100 = $this->HoPerformanceDetail->find('first', 
	array(
	'fields' => array('sum(HoPerformanceDetail.final_score) as total_sum'),
	'conditions' => array(
	'HoPerformanceDetail.ho_performance_plan_id' => $id
	) 
	
	));
	
	$total_self_technical_sum = round(($self_technical_percent_100[0]['total_sum'] * $multiplication_ratio), 2) ;
	$original_data['HoPerformancePlan']['self_technical_percent'] = $total_self_technical_sum;
	//---------------end of find self technical percent---------------------------------------------------------------------------
	//---------------find supervisor technical percent-----------------------------------------------------------------------------
	$sup_technical_percent = 0;
	if(!in_array($grade_id, $grade_array)){
		
		$sup_technical_percent_row = array();
		$sup_technical_percent_row = $this->HoPerformancePlan->find('first', array('conditions' => array('HoPerformancePlan.employee_id' => $sup_id , 'HoPerformancePlan.budget_year_id' => $budget_year_id ,'HoPerformancePlan.quarter' => $quarter )));	
		//	$sup_both_technical_percent = 0;
		if(count($sup_technical_percent_row) > 0){
		
			$sup_technical_percent = $sup_technical_percent_row['HoPerformancePlan']['self_technical_percent'];
			//$sup_own_spvr_percent = $sup_own_spvr_percent_row[0]['own_spvr_percent'];
		} else {
			$sup_technical_percent = 0;
		}
	} 
		
	//$original_data['HoPerformancePlan']['spvr_technical_percent'] = $sup_technical_percent; 
	//-----------------end of find supervisor technical percent------------------------------------
	//-------------------------find both technical percent------------------------------------
	//if(!in_array($grade_id, $grade_array)){
	// if($emp_level < 3){
		if($sup_id != -1){
		if($sup_technical_percent > 0){
			$original_data['HoPerformancePlan']['spvr_technical_percent'] = $sup_technical_percent;
			$both_technical_percent = $total_self_technical_sum/2 + $sup_technical_percent/2 ;
			}
			else {
			$original_data['HoPerformancePlan']['spvr_technical_percent'] = 0;
			$both_technical_percent = $total_self_technical_sum/2 + $sup_technical_percent/2;
			}
	}
	else {
		$both_technical_percent = $total_self_technical_sum ;
	}
	
	$original_data['HoPerformancePlan']['both_technical_percent'] = $both_technical_percent;
	//------------------------end of find both technical percent-------------------------------
	//--------------------------------------end of common for all quarters-------------------------------------------------
	if($quarter == 1){
	
	$original_data['HoPerformancePlan']['semiannual_technical'] = 0;
	$original_data['HoPerformancePlan']['behavioural_percent'] = 0;
	$original_data['HoPerformancePlan']['semiannual_average'] = 0;
	
	}
	
	if($quarter == 2){
	$this->loadModel('CompetenceResult');
	$competence_total = 0;	    
	$competence_total_row = $this->CompetenceResult->find('first', 
	array(
		'fields' => array('sum(CompetenceResult.rating) as competence_sum'),
		'conditions' => array(
		'CompetenceResult.employee_id' => $emp_id,
		'CompetenceResult.budget_year_id' => $budget_year_id,
		'CompetenceResult.quarter' => $quarter,
	) 
	
	));
	$competence_total = $competence_total_row[0]['competence_sum'];
	//echo $competence_total;
	$original_data['HoPerformancePlan']['behavioural_percent'] = (($competence_total/100)/0.2) * 0.5 ;
	//	-----------------------------find the first quarter result-----------------------------------------------------------
	//$quarter_one_row = $this->HoPerformancePlan->find('first', array('conditions' => array('HoPerformancePlan.employee_id' => $emp_id , 'HoPerformancePlan.budget_year_id' => $budget_year_id ,'HoPerformancePlan.quarter' => 1 )));	
	$quarter_one_row =  $this->HoPerformancePlan->query('select * from ho_performance_plans where employee_id = '.$emp_id.' and budget_year_id = '.$budget_year_id.' and quarter = 1');
	if(count($quarter_one_row) > 0){
		//$quarter_one_both_technical_percent = $quarter_one_row['HoPerformancePlan']['both_technical_percent'];
		$quarter_one_both_technical_percent = $quarter_one_row[0]['ho_performance_plans']['both_technical_percent'];
		$semiannual_technical = ($both_technical_percent + $quarter_one_both_technical_percent) / 2;
	//	$semiannual_average = ($semiannual_technical) * 0.9;
	} else {
		$quarter_one_both_technical_percent = 0;
		$semiannual_technical = $both_technical_percent;
	//	$semiannual_average = ($both_technical_percent) * 0.9;
	
	//----------------------------------------end of check if quarter 1 is ho or branch-----------------------------------
	}
	$original_data['HoPerformancePlan']['semiannual_technical'] = $semiannual_technical * 0.9;
	$original_data['HoPerformancePlan']['semiannual_average'] = $semiannual_technical * 0.9 + ((($competence_total/100)/0.2) * 0.5) ;
	
	//-----------------------------end of find the first quarter result----------------------------------------------------
	}
	
	if($quarter == 3){
	// $original_data['HoPerformancePlan']['behavioural_percent'] = 0;
	// $original_data['HoPerformancePlan']['average'] = $own_spvr_percent;
	
	$original_data['HoPerformancePlan']['semiannual_technical'] = 0;
	$original_data['HoPerformancePlan']['behavioural_percent'] = 0;
	$original_data['HoPerformancePlan']['semiannual_average'] = 0;
	}
	
	if($quarter == 4){
	$this->loadModel('CompetenceResult');
	$competence_total = 0;	    
	$competence_total_row = $this->CompetenceResult->find('first', 
	array(
		'fields' => array('sum(CompetenceResult.rating) as competence_sum'),
		'conditions' => array(
		'CompetenceResult.employee_id' => $emp_id,
		'CompetenceResult.budget_year_id' => $budget_year_id,
		'CompetenceResult.quarter' => $quarter,
	) 
	
	));
	$competence_total = $competence_total_row[0]['competence_sum'];
	$original_data['HoPerformancePlan']['behavioural_percent'] = (($competence_total/100)/0.2) * 0.5 ;
	//	-----------------------------find the first quarter result-----------------------------------------------------------
	// $quarter_three_row = $this->HoPerformancePlan->find('first', array('conditions' => array('HoPerformancePlan.employee_id' => $emp_id , 'HoPerformancePlan.budget_year_id' => $budget_year_id ,'HoPerformancePlan.quarter' => 3 )));	
	$quarter_three_row =  $this->HoPerformancePlan->query('select * from ho_performance_plans where employee_id = '.$emp_id.' and budget_year_id = '.$budget_year_id.' and quarter = 3');
	if(count($quarter_three_row) > 0){
		// $quarter_three_both_technical_percent = $quarter_three_row['HoPerformancePlan']['both_technical_percent'];
		$quarter_three_both_technical_percent = $quarter_three_row[0]['ho_performance_plans']['both_technical_percent'];
		$semiannual_technical = ($both_technical_percent + $quarter_three_both_technical_percent) / 2;
	//	$semiannual_average = ($semiannual_technical) * 0.9;
	} else {
		$quarter_three_both_technical_percent = 0;
		$semiannual_technical = $both_technical_percent;
	
	}
	
	$original_data['HoPerformancePlan']['semiannual_technical'] = $semiannual_technical * 0.9 ;
	$original_data['HoPerformancePlan']['semiannual_average'] = $semiannual_technical * 0.9 + ((($competence_total/100)/0.2) * 0.5) ;
	}
	//--------------------------------------------------check if the general status is open--------------------------------------------------
$this->loadModel('PerformanceStatus');
$general_status = "open";
$general_status_row =  $this->PerformanceStatus->query('select * from performance_statuses where  budget_year_id = '.$budget_year_id.' and quarter = '. $quarter);
if(count($general_status_row) > 0){
	$general_status = $general_status_row[0]['performance_statuses']['status'];
}
//--------------------------------------------------end of check if the general status is open----------------------------------------------		
	
	if($result_status < 2 && $general_status == "open"){
			//if ($this->HoPerformancePlan->save($this->data)) {
		if ($this->HoPerformancePlan->save($original_data)) {
			// $this->Session->setFlash(__('The ho performance plan has been saved', true), '');
			// $this->render('/elements/success');
		} else {
			// $this->Session->setFlash(__('The ho performance plan could not be saved. Please, try again.', true), '');
			// $this->render('/elements/failure');
		}
	}
				
			
		}

	function index() {
		$ho_performance_plans = $this->HoPerformanceDetail->HoPerformancePlan->find('all');
		$emps = $this->get_emp_names();
		$this->set(compact('ho_performance_plans', 'emps'));
	}
	
	function index2($id = null) {
		$this->set('parent_id', $id);
	}

	function search() {
	}
	
	function list_data($id = null) {
		$start = (isset($_REQUEST['start'])) ? $_REQUEST['start'] : 0;
		$limit = (isset($_REQUEST['limit'])) ? $_REQUEST['limit'] : 5;
		$hoperformanceplan_id = (isset($_REQUEST['hoperformanceplan_id'])) ? $_REQUEST['hoperformanceplan_id'] : -1;
		if($id)
			$hoperformanceplan_id = ($id) ? $id : -1;
        $conditions = (isset($_REQUEST['conditions'])) ? $_REQUEST['conditions'] : '';

        eval("\$conditions = array( " . $conditions . " );");
		if ($hoperformanceplan_id != -1) {
            $conditions['HoPerformanceDetail.ho_performance_plan_id'] = $hoperformanceplan_id;
        }
		
		$this->set('hoPerformanceDetails', $this->HoPerformanceDetail->find('all', array('conditions' => $conditions, 'limit' => $limit, 'offset' => $start)));
		$this->set('results', $this->HoPerformanceDetail->find('count', array('conditions' => $conditions)));
	}

	function view($id = null) {
		if (!$id) {
			$this->Session->setFlash(__('Invalid ho performance detail', true));
			$this->redirect(array('action' => 'index'));
		}
		$this->HoPerformanceDetail->recursive = 2;
		$this->set('hoPerformanceDetail', $this->HoPerformanceDetail->read(null, $id));
	}


	function add($id = null) {
		if (!empty($this->data)) {

			$original_data = $this->data;
			$plan_id = $original_data['HoPerformanceDetail']['ho_performance_plan_id'];
			$this_weight = $original_data['HoPerformanceDetail']['weight'];
			$goal = str_replace("'", "`", $original_data['HoPerformanceDetail']['objective']);
      $goal = str_replace('"', "`", $goal);
      $goal = str_replace(',', " ", $goal);
			$perspective = str_replace("'", "`", $original_data['HoPerformanceDetail']['perspective']);
      $perspective = str_replace('"', "`", $perspective);
      $perspective = str_replace(',', " ", $perspective);
			$plan_description = str_replace("'", "`", $original_data['HoPerformanceDetail']['plan_description']);
      $plan_description = str_replace('"', "`", $plan_description);
      $plan_description = str_replace(',', " ", $plan_description);
			$measure = str_replace("'", "`", $original_data['HoPerformanceDetail']['measure']);
      $measure = str_replace('"', "`", $measure);
      $measure = str_replace(',', " ", $measure);
			$direction = $original_data['HoPerformanceDetail']['direction'];
			$plan_in_num = $original_data['HoPerformanceDetail']['plan_in_number'];
			$original_data['HoPerformanceDetail']['actual_result']  = 0;
			$original_data['HoPerformanceDetail']['accomplishment']  = 0;
			$original_data['HoPerformanceDetail']['total_score']  = 0;
			$original_data['HoPerformanceDetail']['final_score']  = 0;

			$original_data['HoPerformanceDetail']['objective'] = $goal;
			$original_data['HoPerformanceDetail']['perspective'] = $perspective;
			$original_data['HoPerformanceDetail']['plan_description'] = $plan_description;
		  $original_data['HoPerformanceDetail']['measure'] = $measure;
        //----------------------------------find the status of the plan---------------------------------------------------
        $this->loadModel('HoPerformancePlan');
			$plan_status_row = $this->HoPerformancePlan->query("select * from ho_performance_plans where id = ".$plan_id."  ");
			
			$plan_status = $plan_status_row[0]['ho_performance_plans']['plan_status'];	
			$result_status = $plan_status_row[0]['ho_performance_plans']['result_status'];
			$budget_year_id = $plan_status_row[0]['ho_performance_plans']['budget_year_id'];	
			$quarter = $plan_status_row[0]['ho_performance_plans']['quarter'];
			//--------------------------------end of finding the status of the plan-------------------------------------------

			//----find total weight-------------------------------------------
			$total_weight = $this_weight;
			$weight_row = $this->HoPerformanceDetail->query('select sum(weight) as sum_weight from ho_performance_details where ho_performance_plan_id = '.$plan_id.'');
			$sum_weight = $weight_row[0][0]['sum_weight'];
			if($sum_weight != null) {
				$total_weight +=  $sum_weight;
			}
			else {
				$total_weight = $this_weight;
			}
			

			//----end of find total weight-------------------------------------------
	//		if($total_weight <= 100){
				//------------------update the status of the plan------------------------------------------------
		
		if($total_weight == 100){
			$status_row = $this->HoPerformancePlan->query('update ho_performance_plans set plan_status = 2 where id = '.$plan_id ); //done
		}
		else{
			$status_row = $this->HoPerformancePlan->query('update ho_performance_plans set plan_status = 2 where id = '.$plan_id ); //incomplete
		}

//------------------end of update the status of the plan------------------------------------------------
		//------------check whether goal/objective exists----------------------------------------------------------------
            $goal_row = $this->HoPerformanceDetail->query("select * from ho_performance_details where plan_description = '".$plan_description."' and ho_performance_plan_id = ".$plan_id."");
		//-------------------end check whether goal/objective exists-----------------------------------------------------------
			if(count($goal_row) == 0){
				$this->HoPerformanceDetail->create();
				$this->autoRender = false;
	
					if($plan_in_num == 0 && $direction == 1){
						$this->Session->setFlash(__('Plan cannot be zero!', true), '');
						$this->render('/elements/failure3');

					} else {

//--------------------------------------------------check if the general status is open--------------------------------------------------
$this->loadModel('PerformanceStatus');
$general_status = "open";
$general_status_row =  $this->PerformanceStatus->query('select * from performance_statuses where  budget_year_id = '.$budget_year_id.' and quarter = '. $quarter);
if(count($general_status_row) > 0){
	$general_status = $general_status_row[0]['performance_statuses']['status'];
}
//--------------------------------------------------end of check if the general status is open----------------------------------------------
            if($plan_status <= 2){
            //	if ($this->HoPerformanceDetail->save($this->data)) {
						if ($this->HoPerformanceDetail->save($original_data)) {
							$this->Session->setFlash(__('The ho performance detail has been saved', true), '');
							$this->render('/elements/success');
						} else {
							$this->Session->setFlash(__('The ho performance detail could not be saved. Please, try again.', true), '');
							$this->render('/elements/failure');
						}
            }
            else{
            	$this->Session->setFlash(__('The plan is closed to adding !', true), '');
			      	$this->render('/elements/failure3');
            }
					
					}
			
			}
			else {
				$this->Session->setFlash(__('the plan already exists!', true), '');
				$this->render('/elements/failure3');
			}	

		//	}
		//	else {
		//		$this->Session->setFlash(__('the plan exceeded 100 percent!.', true), '');
		//		$this->render('/elements/failure3');
		//	}

			
		}
		if($id)
			$this->set('parent_id', $id);
		$ho_performance_plans = $this->HoPerformanceDetail->HoPerformancePlan->find('list');
		$this->set(compact('ho_performance_plans'));

	}

	
	function test(){
	//	$weight_row = $this->HoPerformanceDetail->query('select sum(weight) as total_weight from ho_performance_details  where id != 12 and ho_performance_plan_id = 4');
			//$total_weight = $weight_row[0]['total_weight'];
	//		print_r($weight_row);
	}

	function hello(){

	}

	function edit($id = null, $parent_id = null) {

		if (!$id && empty($this->data)) {
			$this->Session->setFlash(__('Invalid ho performance detail', true), '');
			$this->redirect(array('action' => 'index'));
		}
		if (!empty($this->data)) {
			$this->loadModel('HoPerformancePlan');
			$this->autoRender = false;
			$original_data = $this->data;
			$actual_result = $original_data['HoPerformanceDetail']['actual_result'];
			$direction = $original_data['HoPerformanceDetail']['direction'];
			
			$plan_in_num = $original_data['HoPerformanceDetail']['plan_in_number'];
			$this_weight = $original_data['HoPerformanceDetail']['weight']; 
      $weight = $original_data['HoPerformanceDetail']['weight'];
			$plan_id = $original_data['HoPerformanceDetail']['ho_performance_plan_id'];
			$idd = $original_data['HoPerformanceDetail']['id'];
			$goal = str_replace("'", "`", $original_data['HoPerformanceDetail']['objective']);
      $goal = str_replace('"', "`", $goal);
      $goal = str_replace(',', " ", $goal);
			$perspective = str_replace("'", "`", $original_data['HoPerformanceDetail']['perspective']);
      $perspective = str_replace('"', "`", $perspective);
      $perspective = str_replace(',', " ", $perspective);
			$plan_description = str_replace("'", "`", $original_data['HoPerformanceDetail']['plan_description']);
      $plan_description = str_replace('"', "`", $plan_description);
      $plan_description = str_replace(',', " ", $plan_description);
			$measure = str_replace("'", "`", $original_data['HoPerformanceDetail']['measure']);
      $measure = str_replace('"', "`", $measure);
      $measure = str_replace(',', " ", $measure);
			$original_data['HoPerformanceDetail']['objective'] = $goal;
			$original_data['HoPerformanceDetail']['perspective'] = $perspective;
			$original_data['HoPerformanceDetail']['plan_description'] = $plan_description;
			$original_data['HoPerformanceDetail']['measure'] = $measure;
			//----------------------------------find the status of the plan---------------------------------------------------
			$plan_status_row = $this->HoPerformancePlan->query("select * from ho_performance_plans where id = ".$plan_id."  ");
			
			$plan_status = $plan_status_row[0]['ho_performance_plans']['plan_status'];	
			$result_status = $plan_status_row[0]['ho_performance_plans']['result_status'];
			$budget_year_id = $plan_status_row[0]['ho_performance_plans']['budget_year_id'];	
			$quarter = $plan_status_row[0]['ho_performance_plans']['quarter'];
			//--------------------------------end of finding the status of the plan-------------------------------------------
			if($direction == 1 || $direction == 6 || $direction == 8){ // incremental or sdt(standard delivery time) , rate
				$five_pointer_min_included = 125;
				$five_pointer_max = 1000000000000;
				$four_pointer_min_included = 110;
				$four_pointer_max = 125;
				$three_pointer_min_included = 100;
				$three_pointer_max = 110;
				$two_pointer_min_included = 60;
				$two_pointer_max = 100;
				$one_pointer_min_included = 0;
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
			else if($direction == 7){ // means npl
				$five_pointer_min_included = 0;
				$five_pointer_max = 3.0000000000001;
				$four_pointer_min_included = 3.0000000000001;
				$four_pointer_max = 3.500000000001;
				$three_pointer_min_included = 3.500000000001;
				$three_pointer_max = 4.0000000000001;
				$two_pointer_min_included = 4.000000000001;
				$two_pointer_max = 4.500000000001;
				$one_pointer_min_included = 4.500000000001;
				$one_pointer_max = 1000000000000;
			}

			//--------------------------------------------------check if the general status is open--------------------------------------------------
$this->loadModel('PerformanceStatus');
$general_status = "open";
$general_status_row =  $this->PerformanceStatus->query('select * from performance_statuses where  budget_year_id = '.$budget_year_id.' and quarter = '. $quarter);
if(count($general_status_row) > 0){
	$general_status = $general_status_row[0]['performance_statuses']['status'];
}
//--------------------------------------------------end of check if the general status is open----------------------------------------------
			if($plan_status <= 2 && $general_status == "open"){  //you can edit all you want
									//------------check whether goal/objective exists----------------------------------------------------------------
									$goal_row = $this->HoPerformanceDetail->query("select * from ho_performance_details where plan_description = '".$plan_description."' and ho_performance_plan_id = ".$plan_id." and id != ".$idd);
									//-------------------end check whether goal/objective exists-----------------------------------------------------------
									if(count($goal_row) == 0){
								//----find total weight-------------------------------------------
								$total_weight = $this_weight;
								//	$this->loadModel('HoPerformanceDetail');


								$weight_row = $this->HoPerformanceDetail->query('select sum(weight) as sum_weight from ho_performance_details where ho_performance_plan_id = '.$plan_id.' and id != '.$idd.'');
								$sum_weight = $weight_row[0][0]['sum_weight'];
								if($sum_weight != null){
									$total_weight += $sum_weight;
								}
								else {
									$total_weight = $this_weight;
								}


								//----end of find total weight-------------------------------------------

						//			if($total_weight <= 100){
								//------------------update the status of the plan------------------------------------------------

										if($total_weight == 100){
											$status_row = $this->HoPerformancePlan->query('update ho_performance_plans set plan_status = 2 where id = '.$plan_id ); //done
										}
										else{  // now even if it isn't 100 % just make it pending agreement
											$status_row = $this->HoPerformancePlan->query('update ho_performance_plans set plan_status = 2 where id = '.$plan_id ); //incomplete
										}

								//------------------end of update the status of the plan------------------------------------------------
								
								if($plan_in_num == 0 && $direction == 1){
									$this->Session->setFlash(__('Plan in number cannot be empty for this!', true), '');
									$this->render('/elements/failure3');
								}else{
								//	if($actual_result > 0){	
										$plan_in_number = $original_data['HoPerformanceDetail']['plan_in_number'];
										
										//$accomplishment = round((100 * ($actual_result / $plan_in_number)), 2);
										if($direction == 1 || $direction == 2){
											if($plan_in_number == 0){
												$plan_in_number = 0.00000001;
											}
											$accomplishment = round((100 * ($actual_result / $plan_in_number)),2);
										}
										else if($direction == 3 || $direction == 4 || $direction == 5 || $direction == 7){
											$accomplishment = $actual_result;
										}
										else if($direction == 6 || $direction == 8){
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

										

											$final_score = round(($total_score * $weight / 100), 2);

											$original_data['HoPerformanceDetail']['accomplishment'] = $accomplishment;
											$original_data['HoPerformanceDetail']['total_score'] = $total_score;
											$original_data['HoPerformanceDetail']['final_score'] = $final_score;

									//}

									
										//	if ($this->HoPerformancePlan->save($this->data)) {
											if($this->HoPerformanceDetail->save($original_data)) {

												$this->recalculate_plan($plan_id) ;

												$this->Session->setFlash(__('The ho performance detail has been saved', true), '');
												$this->render('/elements/success');
											} else {
												$this->Session->setFlash(__('The ho performance detail could not be saved. Please, try again.', true), '');
												$this->render('/elements/failure');
											}
									}
												
											
					//			}
						//		else {
          //
				  //					$this->Session->setFlash(__('the plan exceeded 100 percent !.', true), '');
				  //					$this->render('/elements/failure3');

					//			}
									}
									else {
										$this->Session->setFlash(__('Duplicate entry !.', true), '');
										$this->render('/elements/failure3');
									}
			} else { //edit is dependent on result_status in this case (plan is agreed only result is entered)
				if($result_status <= 1 && $general_status == "open"){
				//	if($actual_result > 0){

										
						$plan_in_number = $original_data['HoPerformanceDetail']['plan_in_number'];
						
					//	$accomplishment = round((100 * ($actual_result / $plan_in_number)), 2);

						if($direction == 1 || $direction == 2){
							if($plan_in_number == 0){
								$plan_in_number = 0.0000001;
							}
							$accomplishment = round((100 * ($actual_result / $plan_in_number)),2);
						}
						else if($direction == 3 || $direction == 4 || $direction == 5 || $direction == 7){
							$accomplishment = $actual_result;
						}
						else if($direction == 6 || $direction == 8){
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

							$final_score = round(($total_score * $weight / 100), 2);
				// only update the calculated fields
					 $update_calculations = $this->HoPerformanceDetail->query('update ho_performance_details set actual_result = '.$actual_result.',
					 accomplishment = '.$accomplishment.', total_score = '.$total_score.' , final_score = '.$final_score.' where id = '.$idd );
					 
					 $this->Session->setFlash(__('The ho performance detail has been saved', true), '');
					 $this->render('/elements/success');
				//	}
				}
				else {

					$this->Session->setFlash(__('This is closed for editing ! Please contact HR department.', true), '');
					$this->render('/elements/failure3');

				}

			}
	
		}
		$this->set('ho_performance_detail', $this->HoPerformanceDetail->read(null, $id));
		
		if($parent_id) {
			$this->set('parent_id', $parent_id);
		}
	$ho_performance_plans = $this->HoPerformanceDetail->HoPerformancePlan->find('list');
	$this->set(compact('ho_performance_plans'));
		
	}

	function recalculate($id = null) {
		
		$this->autoRender = false;
		$this->loadModel('HoPerformancePlan');
		//	$original_data = $this->data;
		$original_data = array();
		$original_data = $this->HoPerformanceDetail->find('first', array('conditions' => array('HoPerformanceDetail.id' => $id)));
		$plan_id = $original_data['HoPerformanceDetail']['ho_performance_plan_id'];
		$actual_result = $original_data['HoPerformanceDetail']['actual_result'];
		$plan_in_number = $original_data['HoPerformanceDetail']['plan_in_number'];
		$direction = $original_data['HoPerformanceDetail']['direction'];

		//	if($actual_result > 0){

			if($direction == 1 || $direction == 6 || $direction == 8){ // incremental or sdt(standard delivery time) , rate
				$five_pointer_min_included = 125;
				$five_pointer_max = 1000000000000;
				$four_pointer_min_included = 110;
				$four_pointer_max = 125;
				$three_pointer_min_included = 100;
				$three_pointer_max = 110;
				$two_pointer_min_included = 60;
				$two_pointer_max = 100;
				$one_pointer_min_included = 0;
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
			else if($direction == 7){ // means npl
				$five_pointer_min_included = 0;
				$five_pointer_max = 3.0000000000001;
				$four_pointer_min_included = 3.0000000000001;
				$four_pointer_max = 3.500000000001;
				$three_pointer_min_included = 3.500000000001;
				$three_pointer_max = 4.0000000000001;
				$two_pointer_min_included = 4.000000000001;
				$two_pointer_max = 4.500000000001;
				$one_pointer_min_included = 4.500000000001;
				$one_pointer_max = 1000000000000;
			}
				
				// $accomplishment = round((100 * ($actual_result / $plan_in_number)),2);
				if($direction == 1 || $direction == 2){
					if($plan_in_number == 0){
						$plan_in_number = 0.0000001;
					}
					$accomplishment = round((100 * ($actual_result / $plan_in_number)),2);
				}
				else if($direction == 3 || $direction == 4 || $direction == 5 || $direction == 7){
					$accomplishment = $actual_result;
				}
				else if($direction == 6 || $direction == 8){
					if($actual_result == 0){
						$actual_result = 0.0000001;
					}
					$accomplishment = round((100 * ( $plan_in_number / $actual_result )),2);
				}

				$weight = $original_data['HoPerformanceDetail']['weight'];
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
					$original_data['HoPerformanceDetail']['accomplishment'] = $accomplishment;
					$original_data['HoPerformanceDetail']['total_score'] = $total_score;
					$original_data['HoPerformanceDetail']['final_score'] = $final_score;
		//	}

		//----------------------------------find the status of the plan---------------------------------------------------
		$plan_status_row = $this->HoPerformancePlan->query("select * from ho_performance_plans where id = ".$plan_id."  ");
			
		$plan_status = $plan_status_row[0]['ho_performance_plans']['plan_status'];	
		$result_status = $plan_status_row[0]['ho_performance_plans']['result_status'];
		$budget_year_id = $plan_status_row[0]['ho_performance_plans']['budget_year_id'];	
		$quarter = $plan_status_row[0]['ho_performance_plans']['quarter'];
		//--------------------------------end of finding the status of the plan-------------------------------------------
		//--------------------------------------------------check if the general status is open--------------------------------------------------
$this->loadModel('PerformanceStatus');
$general_status = "open";
$general_status_row =  $this->PerformanceStatus->query('select * from performance_statuses where  budget_year_id = '.$budget_year_id.' and quarter = '. $quarter);
if(count($general_status_row) > 0){
	$general_status = $general_status_row[0]['performance_statuses']['status'];
}
//--------------------------------------------------end of check if the general status is open----------------------------------------------
		
		if($result_status < 2 && $general_status == "open"){
			//if ($this->HoPerformancePlan->save($this->data)) {
				if ($this->HoPerformanceDetail->save($original_data)) {
					// $this->Session->setFlash(__('The ho performance plan has been saved', true), '');
					// $this->render('/elements/success');
				} else {
					// $this->Session->setFlash(__('The ho performance plan could not be saved. Please, try again.', true), '');
					// $this->render('/elements/failure');
				}
		}

			

	}

	

	function delete($id = null) {
		$this->loadModel('HoPerformancePlan');
		$this->autoRender = false;
		if (!$id) {
			$this->Session->setFlash(__('Invalid id for ho performance detail', true), '');
			$this->render('/elements/failure');
		}
		if (stripos($id, '_') !== false) {
            $ids = explode('_', $id);
            try {
				$count = 0;
				foreach ($ids as $i) {
					$plan_row = $this->HoPerformanceDetail->query("select * from ho_performance_details where id = ".$i."  ");			
					$plan_id = $plan_row[0]['ho_performance_details']['ho_performance_plan_id'];
					$plan_status_row = $this->HoPerformancePlan->query("select * from ho_performance_plans where id = ".$plan_id."  ");			
					$plan_status = $plan_status_row[0]['ho_performance_plans']['plan_status'];
					$budget_year_id = $plan_status_row[0]['ho_performance_plans']['budget_year_id'];
					$quarter = $plan_status_row[0]['ho_performance_plans']['quarter'];
						//--------------------------------------------------check if the general status is open--------------------------------------------------
$this->loadModel('PerformanceStatus');
$general_status = "open";
$general_status_row =  $this->PerformanceStatus->query('select * from performance_statuses where  budget_year_id = '.$budget_year_id.' and quarter = '. $quarter);
if(count($general_status_row) > 0){
$general_status = $general_status_row[0]['performance_statuses']['status'];
}
//--------------------------------------------------end of check if the general status is open----------------------------------------------
		
					if($plan_status > 2 || $general_status == "closed"){
							$count++;
					}

				}
				if($count == 0){
					foreach ($ids as $i) {
						$this->HoPerformanceDetail->delete($i);
						
						// //--------------------------------change status to incomplete--------------------------------------------
						$plan_row = $this->HoPerformanceDetail->query('select * from ho_performance_details where id = '.$i.'');
						$plan_id = $plan_row[0]['ho_performance_details']['ho_performance_plan_id'];
						$status_row = $this->HoPerformancePlan->query('update ho_performance_plan set status = 2 where id = '.$plan_id );
						$this->recalculate_plan($plan_id);
						// //--------------------------------end of change status to incomplete--------------------------------------------
						}
		
						$this->Session->setFlash(__('Ho performance detail deleted', true), '');
						$this->render('/elements/success');
				}
				else {
					$this->Session->setFlash(__('the plan is closed for deleting !.', true), '');
					$this->render('/elements/failure');
				}
               
            }
            catch (Exception $e){
				$this->Session->setFlash(__('Ho performance detail was not deleted', true), '');
				$this->render('/elements/failure');
            }
        } else {

			$plan_row = $this->HoPerformanceDetail->query("select * from ho_performance_details where id = ".$id."  ");			
			$plan_id = $plan_row[0]['ho_performance_details']['ho_performance_plan_id'];
			$plan_status_row = $this->HoPerformancePlan->query("select * from ho_performance_plans where id = ".$plan_id."  ");			
			$plan_status = $plan_status_row[0]['ho_performance_plans']['plan_status'];
			$budget_year_id = $plan_status_row[0]['ho_performance_plans']['budget_year_id'];
			$quarter = $plan_status_row[0]['ho_performance_plans']['quarter'];
			
			//--------------------------------------------------check if the general status is open--------------------------------------------------
$this->loadModel('PerformanceStatus');
$general_status = "open";
$general_status_row =  $this->PerformanceStatus->query('select * from performance_statuses where  budget_year_id = '.$budget_year_id.' and quarter = '. $quarter);
if(count($general_status_row) > 0){
$general_status = $general_status_row[0]['performance_statuses']['status'];
}
//--------------------------------------------------end of check if the general status is open----------------------------------------------

			if($plan_status <= 2 && $general_status == "open"){
				if ($this->HoPerformanceDetail->delete($id)) {
					// //--------------------------------change status to incomplete--------------------------------------------
								$plan_row = $this->HoPerformanceDetail->query('select * from ho_performance_details where id = '.$id.'');
								$plan_id = $plan_row[0]['ho_performance_details']['ho_performance_plan_id'];
								$status_row = $this->HoPerformancePlan->query('update ho_performance_plan set status = 2 where id = '.$plan_id );
								$this->recalculate_plan($plan_id);
								// //--------------------------------end of change status to incomplete--------------------------------------------
								$this->Session->setFlash(__('Ho performance detail deleted', true), '');
								$this->render('/elements/success');
							} else {
								$this->Session->setFlash(__('Ho performance detail was not deleted', true), '');
								$this->render('/elements/failure');
							}
			}
			else {
				$this->Session->setFlash(__('the plan is closed for deleting !.', true), '');
				$this->render('/elements/failure');
			}
			
			

        
        }
	}
 
 function copy_previous_details( $id = null, $parent_id = null ){
		//$this->loadModel('HoPerformancePlan');
		
		
		if (!$id && empty($this->data)) {
			$this->Session->setFlash(__('Invalid ho performance detail', true), '');
			$this->redirect(array('action' => 'index'));
		}
		if (!empty($this->data)) {
			$original_data = $this->data;
			$id = $original_data['HoPerformanceDetail']['id'];
			

			$this->autoRender = false;
			$this->loadModel('HoPerformancePlan');

			
			$plan_status_row = $this->HoPerformancePlan->query("select * from ho_performance_plans where id = ".$id."  ");
			
			$plan_status = $plan_status_row[0]['ho_performance_plans']['plan_status'];	
			$result_status = $plan_status_row[0]['ho_performance_plans']['result_status'];

			if($result_status < 2){
//----------------------------------------find the emp id----------------------------------------------------------
$plan_row = $this->HoPerformancePlan->query("select * from ho_performance_plans where id = ".$id." ");
$emp_id = $plan_row[0]['ho_performance_plans']['employee_id'];
//----------------------------------------end find the emp id----------------------------------------------------------

//----------------------------------------find the position of the emp--------------------------------------------------
$this->loadModel('EmployeeDetail');
$emp_detail_row = $this->EmployeeDetail->query("select * from employee_details where employee_id = ".$emp_id." order by start_date desc");
$position_id = $emp_detail_row[0]['employee_details']['position_id'];

//----------------------------------------end of find the position of the emp--------------------------------------------
//----------------------------------------find all details for that position---------------------------------------------

$found_plan_id = 0;
$found_plan_row = $this->HoPerformancePlan->query("select * from ho_performance_plans where id < ".$id." order by id desc");
foreach($found_plan_row as $item){
	$found_emp_id = $item['ho_performance_plans']['employee_id'];
	$found_emp_detail_row = $this->EmployeeDetail->query("select * from employee_details where employee_id = ".$found_emp_id." order by start_date desc");
	$found_position_id = $found_emp_detail_row[0]['employee_details']['position_id'];
	if($found_position_id == $position_id){
		$found_detail_row = $this->HoPerformanceDetail->query("select * from ho_performance_details where ho_performance_plan_id = ".$item['ho_performance_plans']['id']." ");
	if(count($found_detail_row) > 0){
		$found_plan_id = $item['ho_performance_plans']['id'];
		break;
	}
	
	}

}
//------------------------------------------end of find all details for that position---------------------------------------
if($found_plan_id > 0){
			//---------------------------------------------first delete everything --------------------------------------------------
			$del_delete_row = $this->HoPerformanceDetail->query("delete from ho_performance_details where ho_performance_plan_id = ".$id." ");
			//------------------------------------------end of first delete everything-------------------------------------------------
			//---------------------------------------------------find the details and save them----------------------------------------------

			$saved_details_row = $this->HoPerformanceDetail->query("select * from ho_performance_details where ho_performance_plan_id = ".$found_plan_id." ");
			foreach($saved_details_row as $detail){
				$perspective = $detail['ho_performance_details']['perspective'];
				$objective = $detail['ho_performance_details']['objective'];
				$plan_description = $detail['ho_performance_details']['plan_description'];
				$plan_in_number= $detail['ho_performance_details']['plan_in_number'];
				$actual_result = 0;
				$measure = $detail['ho_performance_details']['measure'];
				$weight = $detail['ho_performance_details']['weight'];
				$accomplishment = 0;
				$total_score = 0;
				$final_score = 0;
				$direction = $detail['ho_performance_details']['direction'];
				$save_detail_row = $this->HoPerformanceDetail->query("insert into ho_performance_details 
				(perspective, objective, plan_description, plan_in_number, actual_result, measure, weight, accomplishment, total_score, final_score, direction, ho_performance_plan_id)
				values ('".$perspective."', '".$objective."', '".$plan_description."','".$plan_in_number."',".$actual_result.",'".$measure."', 
				".$weight.",".$accomplishment.",".$total_score.",".$final_score.",".$direction.", ".$id.") ");
				
			}
			//--------------------------------------------------end of find the details and save them--------------------------------------------
			$this->recalculate_plan($id);
			$this->Session->setFlash(__('Ho performance detail saved', true), '');
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

function copy_previous_details_person( $id = null, $parent_id = null ){
	//$this->loadModel('HoPerformancePlan');
	
	
	if (!$id && empty($this->data)) {
		$this->Session->setFlash(__('Invalid ho performance detail', true), '');
		$this->redirect(array('action' => 'index'));
	}
	if (!empty($this->data)) {
		$original_data = $this->data;
		$id = $original_data['HoPerformanceDetail']['id'];
		

		$this->autoRender = false;
		$this->loadModel('HoPerformancePlan');

		
		$plan_status_row = $this->HoPerformancePlan->query("select * from ho_performance_plans where id = ".$id."  ");
		
		$plan_status = $plan_status_row[0]['ho_performance_plans']['plan_status'];	
		$result_status = $plan_status_row[0]['ho_performance_plans']['result_status'];

		if($result_status < 2){
//----------------------------------------find the emp id----------------------------------------------------------
$plan_row = $this->HoPerformancePlan->query("select * from ho_performance_plans where id = ".$id." ");
$emp_id = $plan_row[0]['ho_performance_plans']['employee_id'];
//----------------------------------------end find the emp id----------------------------------------------------------

//----------------------------------------find all details for that position---------------------------------------------

$found_plan_id = 0;
$found_plan_row = $this->HoPerformancePlan->query("select * from ho_performance_plans where id < ".$id." and employee_id = ".$emp_id." order by id desc");
foreach($found_plan_row as $item){
	$found_plan_id = $found_plan_row[0]['ho_performance_plans']['id'];

}
//------------------------------------------end of find all details for that position---------------------------------------
if($found_plan_id > 0){
		//---------------------------------------------first delete everything --------------------------------------------------
		$del_delete_row = $this->HoPerformanceDetail->query("delete from ho_performance_details where ho_performance_plan_id = ".$id." ");
		//------------------------------------------end of first delete everything-------------------------------------------------
		//---------------------------------------------------find the details and save them----------------------------------------------

		$saved_details_row = $this->HoPerformanceDetail->query("select * from ho_performance_details where ho_performance_plan_id = ".$found_plan_id." ");
		foreach($saved_details_row as $detail){
			$perspective = $detail['ho_performance_details']['perspective'];
			$objective = $detail['ho_performance_details']['objective'];
			$plan_description = $detail['ho_performance_details']['plan_description'];
			$plan_in_number= $detail['ho_performance_details']['plan_in_number'];
			$actual_result = 0;
			$measure = $detail['ho_performance_details']['measure'];
			$weight = $detail['ho_performance_details']['weight'];
			$accomplishment = 0;
			$total_score = 0;
			$final_score = 0;
			$direction = $detail['ho_performance_details']['direction'];
			$save_detail_row = $this->HoPerformanceDetail->query("insert into ho_performance_details 
			(perspective, objective, plan_description, plan_in_number, actual_result, measure, weight, accomplishment, total_score, final_score, direction, ho_performance_plan_id)
			values ('".$perspective."', '".$objective."', '".$plan_description."','".$plan_in_number."',".$actual_result.",'".$measure."', 
			".$weight.",".$accomplishment.",".$total_score.",".$final_score.",".$direction.", ".$id.") ");
			
		}
		//--------------------------------------------------end of find the details and save them--------------------------------------------
		$this->recalculate_plan($id);
		$this->Session->setFlash(__('Ho performance detail saved', true), '');
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