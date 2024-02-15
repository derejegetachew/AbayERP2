<?php
class CompetenceLevelsController extends AppController {

	var $name = 'CompetenceLevels';
	
	function index() {
	}
	

	function search() {
	}
	
	function list_data($id = null) {
		$start = (isset($_REQUEST['start'])) ? $_REQUEST['start'] : 0;
		$limit = (isset($_REQUEST['limit'])) ? $_REQUEST['limit'] : 5;
        $conditions = (isset($_REQUEST['conditions'])) ? $_REQUEST['conditions'] : '';

        eval("\$conditions = array( " . $conditions . " );");
		
		$this->set('competenceLevels', $this->CompetenceLevel->find('all', array('conditions' => $conditions, 'limit' => $limit, 'offset' => $start)));
		$this->set('results', $this->CompetenceLevel->find('count', array('conditions' => $conditions)));
	}

	function view($id = null) {
		if (!$id) {
			$this->Session->setFlash(__('Invalid competence level', true));
			$this->redirect(array('action' => 'index'));
		}
		$this->CompetenceLevel->recursive = 2;
		$this->set('competenceLevel', $this->CompetenceLevel->read(null, $id));
	}

	function add($id = null) {
		if (!empty($this->data)) {
			$original_data = $this->data;
			
		//	$level_name = $original_data['CompetenceLevel']['name'];
			$level_name = str_replace("'", "`", $original_data['CompetenceLevel']['name']);
      $level_name = str_replace('"', "`", $level_name);
      $level_name = str_replace(',', " ", $level_name);
			$original_data['CompetenceLevel']['name'] = $level_name;
			$levels_row = $this->CompetenceLevel->query("select * from competence_levels where name = '".$level_name."'");
			
			
			if(count($levels_row) == 0) {
				$this->CompetenceLevel->create();
				$this->autoRender = false;
			//	if ($this->CompetenceLevel->save($this->data)) {
				if ($this->CompetenceLevel->save($original_data)) {
					$this->Session->setFlash(__('The competence level has been saved', true), '');
					$this->render('/elements/success');
				} else {
					$this->Session->setFlash(__('The competence level could not be saved. Please, try again.', true), '');
					$this->render('/elements/failure');
				}

			 } else {

				$this->Session->setFlash(__('The level has already been saved.', true), '');
				$this->render('/elements/failure3');
			 }
			
		}
	}

	function edit($id = null, $parent_id = null) {
		if (!$id && empty($this->data)) {
			$this->Session->setFlash(__('Invalid competence level', true), '');
			$this->redirect(array('action' => 'index'));
		}
		if (!empty($this->data)) {
			$original_data = $this->data;
			$level_id = $original_data['CompetenceLevel']['id'];
			//$level_name = $original_data['CompetenceLevel']['name'];
			$level_name = str_replace("'", "`", $original_data['CompetenceLevel']['name']);
      $level_name = str_replace('"', "`", $level_name);
      $level_name = str_replace(',', " ", $level_name);
			$original_data['CompetenceLevel']['name'] = $level_name;
			$levels_row = $this->CompetenceLevel->query("select * from competence_levels where id != ".$level_id." and name = '".$level_name."'");
			
			if(count($levels_row) == 0) {
				$this->autoRender = false;
				//if ($this->CompetenceLevel->save($this->data)) {
				if ($this->CompetenceLevel->save($original_data)) {
					$this->Session->setFlash(__('The competence level has been saved', true), '');
					$this->render('/elements/success');
				} else {
					$this->Session->setFlash(__('The competence level could not be saved. Please, try again.', true), '');
					$this->render('/elements/failure');
				}
			} else {
				$this->Session->setFlash(__('The level has already been saved.', true), '');
				$this->render('/elements/failure3');

			}
			
		}
		$this->set('competence_level', $this->CompetenceLevel->read(null, $id));
		
			
	}

	function delete($id = null) {
		$this->autoRender = false;
		if (!$id) {
			$this->Session->setFlash(__('Invalid id for competence level', true), '');
			$this->render('/elements/failure');
		}
		if (stripos($id, '_') !== false) {
            $ids = explode('_', $id);
            try{
                foreach ($ids as $i) {
                    $this->CompetenceLevel->delete($i);
                }
				$this->Session->setFlash(__('Competence level deleted', true), '');
				$this->render('/elements/success');
            }
            catch (Exception $e){
				$this->Session->setFlash(__('Competence level was not deleted', true), '');
				$this->render('/elements/failure');
            }
        } else {
            if ($this->CompetenceLevel->delete($id)) {
				$this->Session->setFlash(__('Competence level deleted', true), '');
				$this->render('/elements/success');
			} else {
				$this->Session->setFlash(__('Competence level was not deleted', true), '');
				$this->render('/elements/failure');
			}
        }
	}
 
 	//---------------------------------------------------for vacancy------------------------------------------------------
	function get_quarter_year($date){
		$this->loadModel('BudgetYear');
		$year_only = date('Y', strtotime($date));
		$q = 1;
		$budget_year_id = 0;
		$q_year = array();
		if(strtotime($date) >= strtotime($year_only."-07-01") && strtotime($date) < strtotime($year_only."-10-01")){
			$q = 1;
			$budget_year_row =  $this->BudgetYear->query('select * from budget_years 
			where from_date = "'. $year_only."-07-01" .'" ');
			if(count($budget_year_row) > 0){
				$budget_year_id = $budget_year_row[0]['budget_years']['id'];
			}
			

		}
		else if(strtotime($date) >= strtotime($year_only."-10-01") && strtotime($date) < strtotime((1+$year_only)."-01-01")){
			$q = 2;
			$budget_year_row =  $this->BudgetYear->query('select * from budget_years 
			where from_date = "'. $year_only."-07-01" .'" ');
			if(count($budget_year_row) > 0){
				$budget_year_id = $budget_year_row[0]['budget_years']['id'];
			}
			
		}
		else if(strtotime($date) >= strtotime($year_only."-01-01") && strtotime($date) < strtotime($year_only."-04-01")){
			$q = 3;
			$budget_year_row =  $this->BudgetYear->query('select * from budget_years 
			where from_date = "'. ($year_only-1)."-07-01" .'" ');
			if(count($budget_year_row) > 0){
			$budget_year_id = $budget_year_row[0]['budget_years']['id'];
			}
		}
		else if(strtotime($date) >= strtotime($year_only."-04-01") && strtotime($date) < strtotime($year_only."-07-01")){
			$q = 4;
			$budget_year_row =  $this->BudgetYear->query('select * from budget_years 
			where from_date = "'. ($year_only-1)."-07-01" .'" ');
			if(count($budget_year_row) > 0){
			$budget_year_id = $budget_year_row[0]['budget_years']['id'];
			}
		}


		$prev_budget_year_id = 0;

		if($q == 1 || $q == 2){   //---------------go to the previous year------------------------------------
           $prev_budget_year_row =  $this->BudgetYear->query('select * from budget_years where order_by < (select order_by from budget_years where id = '.$budget_year_id.') order by order_by desc limit 1');
		   $prev_budget_year_id = $prev_budget_year_row[0]['budget_years']['id'];
		}
		if($q == 3 || $q == 4){   //---------------------go to current year-----------------------------------------------
          $prev_budget_year_id = $budget_year_id;
		}


		array_push($q_year, $q);  //quarter is the quarter of vacancy application date
		array_push($q_year, $prev_budget_year_id);
		return $q_year;

	}


	// $arr = explode('/',$date);
	// if(strlen($arr[1]) == 1){
	// 	$arr[1] = '0'.$arr[1];
	// }
	// if(strlen($arr[0]) == 1){
	// 	$arr[0] = '0'.$arr[0];
	// }
	// $date_str = $arr[2].'-'.$arr[1].'-'.$arr[0].' 00:06:00';
	// $newDate = $this->getDateForDatabase($date_str);

	// $q_year = $this->get_quarter_year($newDate);
	function find_branch_result($e_id , $budget_year_id,  $from_date , $to_date , $position, $branch,   $q){
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

	  //	$this->loadModel('Position');
		  // $position_name_row = $this->BranchPerformancePlan->query('select * from positions
		  // where id = '. $position .' ');
		  // $position_name = $position_name_row[0]['positions']['name'];

		  //managers A(93), B(122), C(71)
		  //assistants A(673), B(793)

	  $result_array = array();
	  $technical_sum_total = 0;
 $total_weight = 0;
	  $technical_result = 0;
	  $branch_result = 0;
	  $this->loadModel('BranchPerformancePlan');
	  $br_plan_row = $this->BranchPerformancePlan->query('select * from branch_performance_plans
	  where branch_id = '. $branch .' and budget_year_id = '.$budget_year_id.' and quarter = '.$q);

	  if(count($br_plan_row) > 0){ //means if branch plan is found
		  $branch_result = $br_plan_row[0]['branch_performance_plans']['result'];
		  $this->loadModel('BranchPerformanceSetting');
	  $this->loadModel('BranchPerformanceTracking');
	  $brSetting = $this->BranchPerformanceSetting->query('select * from branch_performance_settings 
	  where position_id = '. $position .' ');
	
	 foreach($brSetting as $item){
	  $sum_value = 0;
	  $total_row = $this->BranchPerformanceTracking->query('select sum(value) as sum_value from branch_performance_trackings where goal = '.$item["branch_performance_settings"]["id"].'
	   and date between "'.$quarter_start_date.'" and "'.$quarter_end_date.'" and employee_id = '.$e_id);
	  if($total_row[0][0]['sum_value'] != null){
		  $sum_value = $total_row[0][0]['sum_value'];
	  }
 $total_weight += $item["branch_performance_settings"]["weight"];
	  
	  if($sum_value > $item["branch_performance_settings"]["five_pointer_min"]  && $sum_value <= $item["branch_performance_settings"]["five_pointer_max_included"]){
		  $technical_sum_total += 5 * $item["branch_performance_settings"]["weight"]/100;
	  }
	  if($sum_value > $item["branch_performance_settings"]["four_pointer_min"]  && $sum_value <= $item["branch_performance_settings"]["four_pointer_max_included"]){
		  $technical_sum_total += 4 * $item["branch_performance_settings"]["weight"]/100;
	  }
	  if($sum_value > $item["branch_performance_settings"]["three_pointer_min"]  && $sum_value <= $item["branch_performance_settings"]["three_pointer_max_included"]){
		  $technical_sum_total += 3 * $item["branch_performance_settings"]["weight"]/100;
	  }
	  if($sum_value > $item["branch_performance_settings"]["two_pointer_min"]  && $sum_value <= $item["branch_performance_settings"]["two_pointer_max_included"]){
		  $technical_sum_total += 2 * $item["branch_performance_settings"]["weight"]/100;
	  }
	  if($sum_value > $item["branch_performance_settings"]["one_pointer_min"]  && $sum_value <= $item["branch_performance_settings"]["one_pointer_max_included"]){
		  $technical_sum_total += 1 * $item["branch_performance_settings"]["weight"]/100;
	  }
   }
 
 $technical_sum_weighted = (100/$total_weight) * $technical_sum_total;

   if ($position == 93 || $position == 122 || $position == 71){
	 $technical_result = 0.85*($branch_result) + 0.15*($technical_sum_weighted);
   }
   else if ($position == 673 || $position == 793 ){
	  $technical_result = 0.75*($branch_result) + 0.25*($technical_sum_weighted);
   }
   else {
	  $technical_result = 0.6*($branch_result) + 0.4*($technical_sum_weighted);
   }

	  }
	  else {
// do nothing so that it remains zero
	  }
	   
  
	   $result_array["technical"] = $technical_result;
	   $behavioural_total = 0;

		if($q == 2 || $q == 4) {

		  $this->loadModel('CompetenceResult');
		  
		  $behavioural_total_row = $this->CompetenceResult->query('select sum(rating) as sum_rating from competence_results where 
		  employee_id = '.  $e_id. ' and budget_year_id = '.$budget_year_id. '  and quarter = '.$q);
	  

		  if($behavioural_total_row[0][0]['sum_rating'] != null){
			  $behavioural_total = $behavioural_total_row[0][0]['sum_rating'];
		  }

		}


	   $result_array["behavioural"] = $behavioural_total;



	   return $result_array;

   
   }
	function get_each_quarter_position($e_id, $from_date, $to_date, $q){

		$this->loadModel('EmployeeDetail');

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
		where employee_id = -1 order by start_date' );
}

return $position_id_for_quarter_row;

}

//function vacancy_report(){
	function vacancy_report($e_id, $date_applied){ //this is a report one row for one year for each employee
		//$e_id = 871 ;
		//$date_applied = "2022-05-24 10:00:00";
		$budget_year_search = 0;
		$q_year = $this->get_quarter_year($date_applied);
		$budget_year_id = $q_year[1];
		$q = $q_year[0];
		
		//$budget_year_search = 14;
		$this->loadModel('BudgetYear');
		// $this->layout = 'ajax';	
	
		$report_table = array();

		$one_row = array();

	    $budget_years = array();

		$this->loadModel('BranchPerformanceTrackingStatus');
		$this->loadModel('CompetenceResult');

	$this->loadModel('EmployeeDetail');
	//$emp_ids = $this->get_emp_ids();
	
	//array_push($emp_ids, 4638);

		//$e_id = $emp_id;
//-----------------------------------first find the year hired-------------------------------------------------------------
		
		  
		//

		//--------------------------------------------------------find the emp name and permanent data-----------------------------
		$this->loadModel('Employee');
		$this->loadModel('User');
		$this->loadModel('Person');
		$this->loadModel('Branch');
        $this->loadModel('Position');
		$this->loadModel('HoPerformancePlan');

		
		//-----------------------------------------------------end of finding the emp name and permanent data------------------------

		

//-----------------------------------------------------find position and branch for each quarter------------------------------------------------------

//--now decide the position and branch he/she worked in each quarter---------------------------------------------------------
		   $budget_yr_row= $this->BudgetYear->query('select * from budget_years where id = '.$budget_year_id);
	       $from_date = $budget_yr_row[0]["budget_years"]["from_date"];
		   $to_date = $budget_yr_row[0]["budget_years"]["to_date"];
		   

	//-----start with the first quarter---------------------------------------------------------------------------------------
	$position_id_for_quarter1_row = $this->get_each_quarter_position($e_id, $from_date, $to_date , 1 );
	$position_id_for_quarter2_row = $this->get_each_quarter_position($e_id, $from_date, $to_date , 2 );
	$position_id_for_quarter3_row = $this->get_each_quarter_position($e_id, $from_date, $to_date , 3 );
	$position_id_for_quarter4_row = $this->get_each_quarter_position($e_id, $from_date, $to_date , 4 );


			if(count($position_id_for_quarter4_row) > 0){
				$position_q4 = $position_id_for_quarter4_row[0]["employee_details"]["position_id"];
				$branch_q4 = $position_id_for_quarter4_row[0]["employee_details"]["branch_id"];
			} else {
				$position_q4 = 0;
				$branch_q4 = 0;
			}
	
	$branch_district_row = $this->Branch->query('select * from branches where id = '.$branch_q4);
	if(count($branch_district_row) > 0){
		$branch_district = $branch_district_row[0]['branches']['region'];
	}
	else{
		$branch_district = "";
	}
	

//---------------------------------------------end find q4 position and branch for each quarter------------------------------------------------------	
				
				//$one_row['branch'] = $branch_q4;
			
				$this->loadModel('BudgetYear');
				
				$one_row['q1'] = 0;
				$one_row['q2'] = 0;
				$one_row['semiannual_technical1'] = 0;
				$one_row['behavioural1'] = 0;
				$one_row['semiannual_average1'] = 0;
				$one_row['q3'] = 0;
				$one_row['q4'] = 0;
				$one_row['semiannual_technical2'] = 0;
				$one_row['behavioural2'] = 0;
				$one_row['semiannual_average2'] = 0;
				$one_row['annual'] = 0;
				
				$one_row['q1_technical_agreement_plan'] = "-";
				$one_row['q1_technical_agreement_result'] = "-";
				
				$one_row['q2_technical_agreement_plan'] = "-";
				$one_row['q2_technical_agreement_result'] = "-";
				
				$one_row['q2_behavioural_agreement_result'] = "-";
				
				$one_row['q3_technical_agreement_plan'] = "-";
				$one_row['q3_technical_agreement_result'] = "-";
				
				$one_row['q4_technical_agreement_plan'] = "-";
				$one_row['q4_technical_agreement_result'] = "-";
				
				$one_row['q4_behavioural_agreement_result'] = "-";
			

//------------------------------start for the first quarter----------------------------------------------------------

if(count($position_id_for_quarter1_row) > 0){
	$position_q1 = $position_id_for_quarter1_row[0]["employee_details"]["position_id"];
	$branch_q1 = $position_id_for_quarter1_row[0]["employee_details"]["branch_id"];

 $branch_type_row1 =  $this->Branch->query('select * from branches 
   where id = '. $branch_q1 .' ');
   if(count($branch_type_row1) > 0){
	$branch_type1 = $branch_type_row1[0]['branches']['branch_category_id'];
	if($branch_type1 == 1){ //means it is branch 
	   $result_array1= $this->find_branch_result($e_id , $budget_year_id,  $from_date , $to_date , $position_q1, $branch_q1, 1);
	   $one_row['q1']  = $result_array1['technical'];

	   //------------------------------------------agreement started---------------------------------------------------------------
	   $agreement_status_row = $this->BranchPerformanceTrackingStatus->query('select * from branch_performance_tracking_statuses 
	where employee_id = '. $e_id .' and budget_year_id = '.$budget_year_id.' and quarter = 1');

	if(count($agreement_status_row) > 0){
		
		$one_row['q1_technical_agreement_plan'] = "branch tracking";
		if($agreement_status_row[0]['branch_performance_tracking_statuses']['result_status'] == 1){
			$one_row['q1_technical_agreement_result'] = "Pending agreement";
		}
		else if($agreement_status_row[0]['branch_performance_tracking_statuses']['result_status'] == 2){
			$one_row['q1_technical_agreement_result'] = "Agreed";
		}
		else if($agreement_status_row[0]['branch_performance_tracking_statuses']['result_status'] == 3){
			$one_row['q1_technical_agreement_result'] = "Agreed with reservation";
		}
		
		
	}
	 //------------------------------------------agreement ended---------------------------------------------------------------

	}
	else { //means it is not branch
	   
		$hoPlan1 = $this->HoPerformancePlan->query('select * from ho_performance_plans 
	where employee_id = '. $e_id .' and budget_year_id = '.$budget_year_id.' and quarter = 1');
	if(count($hoPlan1) > 0){
	   $one_row['q1'] = $hoPlan1[0]['ho_performance_plans']['both_technical_percent'];
	   //$one_row['q1_technical_agreement_plan'] = $hoPlan1[0]['ho_performance_plans']['plan_status'];
	   //----------------------------------------start of agreement--------------------------------------------------------------
	   if($hoPlan1[0]['ho_performance_plans']['plan_status'] == 2){
		    $one_row['q1_technical_agreement_plan'] == "Pending agreement";
	   }
	   else if($hoPlan1[0]['ho_performance_plans']['plan_status'] == 3){
		$one_row['q1_technical_agreement_plan'] == "Agreed";
   		}
	  else if($hoPlan1[0]['ho_performance_plans']['plan_status'] == 4){
			$one_row['q1_technical_agreement_plan'] == "Agreed with reservation";
		 }
	 if($hoPlan1[0]['ho_performance_plans']['result_status'] == 1){
		    $one_row['q1_technical_agreement_result'] == "Pending agreement";
	   }
	   else if($hoPlan1[0]['ho_performance_plans']['result_status'] == 2){
		$one_row['q1_technical_agreement_result'] == "Agreed";
   		}
	  else if($hoPlan1[0]['ho_performance_plans']['result_status'] == 3){
			$one_row['q1_technical_agreement_result'] == "Agreed with reservation";
		 }
		
	//----------------------------------------end of agreement--------------------------------------------------------------
	}
	
	}
   }
 
}
               
//-------------------------------end of for the first quarter---------------------------------------------------------
//------------------------------start for the second quarter----------------------------------------------------------
if(count($position_id_for_quarter2_row) > 0){
	$position_q2 = $position_id_for_quarter2_row[0]["employee_details"]["position_id"];
	$branch_q2 = $position_id_for_quarter2_row[0]["employee_details"]["branch_id"];
	
	$branch_type_row2 =  $this->Branch->query('select * from branches 
	where id = '. $branch_q2 .' ');
	if(count($branch_type_row2) > 0){
	$branch_type2 = $branch_type_row2[0]['branches']['branch_category_id'];
	if($branch_type2 == 1){ //means it is branch
		$result_array2 = $this->find_branch_result($e_id , $budget_year_id,  $from_date , $to_date , $position_q2,$branch_q2, 2);
	$one_row['q2'] = $result_array2['technical'];
   if($one_row['q1'] == 0){
   $one_row['semiannual_technical1'] = ( $one_row['q2']) * 0.9;
   }else{
   $one_row['semiannual_technical1'] = (($one_row['q1'] + $one_row['q2'])/2) * 0.9;
   }
	
	$one_row['behavioural1'] = ($result_array2['behavioural'] / 20) * 0.5;
	$one_row['semiannual_average1'] = $one_row['semiannual_technical1'] + $one_row['behavioural1'];
//---------------------------------------------------------the agreements---------------------------------------------------------
$agreement_status_row = $this->BranchPerformanceTrackingStatus->query('select * from branch_performance_tracking_statuses 
where employee_id = '. $e_id .' and budget_year_id = '.$budget_year_id.' and quarter = 2');

if(count($agreement_status_row) > 0){
	
	$one_row['q2_technical_agreement_plan'] = "branch tracking";
	if($agreement_status_row[0]['branch_performance_tracking_statuses']['result_status'] == 1){
		$one_row['q2_technical_agreement_result'] = "Pending agreement";
	}
	else if($agreement_status_row[0]['branch_performance_tracking_statuses']['result_status'] == 2){
		$one_row['q2_technical_agreement_result'] = "Agreed";
	}
	else if($agreement_status_row[0]['branch_performance_tracking_statuses']['result_status'] == 3){
		$one_row['q2_technical_agreement_result'] = "Agreed with reservation";
	}
	
	//---------------------------------------------------find the behavioural agreements--------------------------------------------
	$behavioural_row = $this->CompetenceResult->query('select * from competence_results 
	where employee_id = '. $e_id .' and budget_year_id = '.$budget_year_id.' and quarter = 2');
	if(count($behavioural_row) > 0){
		if($behavioural_row[0]['competence_results']['result_status'] == 1){
		    $one_row['q2_behavioural_agreement_result'] == "Pending agreement";
	   }
	   else if($behavioural_row[0]['competence_results']['result_status'] == 2){
		$one_row['q2_behavioural_agreement_result'] == "Agreed";
   		}
	  else if($behavioural_row[0]['competence_results']['result_status'] == 3){
			$one_row['q2_behavioural_agreement_result'] == "Agreed with reservation";
		 }
		
	}
	//---------------------------------------------------end of finding the behavioural agreements----------------------------------
	
}
//-------------------------------------------------------end the agreements-------------------------------------------------------
	
	}
	else { //means it is not branch
	 $hoPlan2 = $this->HoPerformancePlan->query('select * from ho_performance_plans 
	where employee_id = '. $e_id .' and budget_year_id = '.$budget_year_id.' and quarter = 2');

	if(count($hoPlan2) > 0){
		$one_row['q2'] =  $hoPlan2[0]['ho_performance_plans']['both_technical_percent'];
		//$one_row['semi_annual_technical_1'] = $hoPlan2[0]['ho_performance_plans']['semiannual_technical'];
    if($one_row['q1'] == 0){
    $one_row['semiannual_technical1'] = ( $one_row['q2']) * 0.9;
    }
    else{
    $one_row['semiannual_technical1'] = (($one_row['q1'] + $one_row['q2'])/2) * 0.9;
    }
		
		$one_row['behavioural1'] = $hoPlan2[0]['ho_performance_plans']['behavioural_percent'];
		//$one_row['semi_annual_result_1'] = $hoPlan2[0]['ho_performance_plans']['semiannual_average'];
		$one_row['semiannual_average1'] = $one_row['semiannual_technical1'] + $one_row['behavioural1'];
//-------------------------------------------------the agreements----------------------------------------------------------
		if($hoPlan2[0]['ho_performance_plans']['plan_status'] == 2){
		    $one_row['q2_technical_agreement_plan'] == "Pending agreement";
	   }
	   else if($hoPlan2[0]['ho_performance_plans']['plan_status'] == 3){
		$one_row['q2_technical_agreement_plan'] == "Agreed";
   		}
	  else if($hoPlan2[0]['ho_performance_plans']['plan_status'] == 4){
			$one_row['q2_technical_agreement_plan'] == "Agreed with reservation";
		 }
	 if($hoPlan2[0]['ho_performance_plans']['result_status'] == 1){
		    $one_row['q2_technical_agreement_result'] == "Pending agreement";
	   }
	   else if($hoPlan2[0]['ho_performance_plans']['result_status'] == 2){
		$one_row['q2_technical_agreement_result'] == "Agreed";
   		}
	  else if($hoPlan2[0]['ho_performance_plans']['result_status'] == 3){
			$one_row['q2_technical_agreement_result'] == "Agreed with reservation";
		 }
	

	//---------------------------------------------------find the behavioural agreements--------------------------------------------
	$behavioural_row = $this->CompetenceResult->query('select * from competence_results 
	where employee_id = '. $e_id .' and budget_year_id = '.$budget_year_id.' and quarter = 2');
	if(count($behavioural_row) > 0){
		if($behavioural_row[0]['competence_results']['result_status'] == 1){
		    $one_row['q2_behavioural_agreement_result'] == "Pending agreement";
	   }
	   else if($behavioural_row[0]['competence_results']['result_status'] == 2){
		$one_row['q2_behavioural_agreement_result'] == "Agreed";
   		}
	  else if($behavioural_row[0]['competence_results']['result_status'] == 3){
			$one_row['q2_behavioural_agreement_result'] == "Agreed with reservation";
		 }
		
	}
	//---------------------------------------------------end of finding the behavioural agreements----------------------------------
//------------------------------------------------------end of the agreements-------------------------------------------------
	}
	
	
	}
}
}
//-------------------------------end of for the second quarter---------------------------------------------------------	
//------------------------------start for the third quarter----------------------------------------------------------
if(count($position_id_for_quarter3_row) > 0){
	$position_q3= $position_id_for_quarter3_row[0]["employee_details"]["position_id"];
	$branch_q3 = $position_id_for_quarter3_row[0]["employee_details"]["branch_id"];
	
	$branch_type_row3 =  $this->Branch->query('select * from branches 
	where id = '. $branch_q3 .' ');
	if(count($branch_type_row3) > 0){
	$branch_type3 = $branch_type_row3[0]['branches']['branch_category_id'];
	if($branch_type3 == 1){ //means it is branch
		$result_array3= $this->find_branch_result($e_id , $budget_year_id,  $from_date , $to_date , $position_q3, $branch_q3, 3);
		$one_row['q3'] = $result_array3['technical'];

		//------------------------------------------agreement started---------------------------------------------------------------
		$agreement_status_row = $this->BranchPerformanceTrackingStatus->query('select * from branch_performance_tracking_statuses 
		where employee_id = '. $e_id .' and budget_year_id = '.$budget_year_id.' and quarter = 3');
	
		if(count($agreement_status_row) > 0){
			
			$one_row['q3_technical_agreement_plan'] = "branch tracking";
			if($agreement_status_row[0]['branch_performance_tracking_statuses']['result_status'] == 1){
				$one_row['q3_technical_agreement_result'] = "Pending agreement";
			}
			else if($agreement_status_row[0]['branch_performance_tracking_statuses']['result_status'] == 2){
				$one_row['q3_technical_agreement_result'] = "Agreed";
			}
			else if($agreement_status_row[0]['branch_performance_tracking_statuses']['result_status'] == 3){
				$one_row['q3_technical_agreement_result'] = "Agreed with reservation";
			}
		
			
		}
		 //------------------------------------------agreement ended---------------------------------------------------------------
	}
	else { //means it is not branch
	 $hoPlan3 = $this->HoPerformancePlan->query('select * from ho_performance_plans 
	where employee_id = '. $e_id .' and budget_year_id = '.$budget_year_id.' and quarter = 3');
	if(count($hoPlan3) > 0){
		$one_row['q3'] = $hoPlan3[0]['ho_performance_plans']['both_technical_percent'];

		//----------------------------------------start of agreement--------------------------------------------------------------
		if($hoPlan3[0]['ho_performance_plans']['plan_status'] == 2){
		    $one_row['q3_technical_agreement_plan'] == "Pending agreement";
	   }
	   else if($hoPlan3[0]['ho_performance_plans']['plan_status'] == 3){
		$one_row['q3_technical_agreement_plan'] == "Agreed";
   		}
	  else if($hoPlan3[0]['ho_performance_plans']['plan_status'] == 4){
			$one_row['q3_technical_agreement_plan'] == "Agreed with reservation";
		 }
	 if($hoPlan3[0]['ho_performance_plans']['result_status'] == 1){
		    $one_row['q3_technical_agreement_result'] == "Pending agreement";
	   }
	   else if($hoPlan3[0]['ho_performance_plans']['result_status'] == 2){
		$one_row['q3_technical_agreement_result'] == "Agreed";
   		}
	  else if($hoPlan3[0]['ho_performance_plans']['result_status'] == 3){
			$one_row['q3_technical_agreement_result'] == "Agreed with reservation";
		 }
		
	//----------------------------------------end of agreement--------------------------------------------------------------
	}
	
	
	}
}
}

//-------------------------------end of for the third quarter---------------------------------------------------------
//------------------------------start for the fourth quarter----------------------------------------------------------
if(count($position_id_for_quarter4_row) > 0){
	$position_q4 = $position_id_for_quarter4_row[0]["employee_details"]["position_id"];
	$branch_q4 = $position_id_for_quarter4_row[0]["employee_details"]["branch_id"];
	
	$branch_type_row4 =  $this->Branch->query('select * from branches 
	where id = '. $branch_q4 .' ');
	if(count($branch_type_row4) > 0){
	$branch_type4 = $branch_type_row4[0]['branches']['branch_category_id'];
	if($branch_type4 == 1){ //means it is branch
		$result_array4 = $this->find_branch_result($e_id , $budget_year_id,  $from_date , $to_date , $position_q4, $branch_q4, 4);
	$one_row['q4'] = $result_array4['technical'];
   if($one_row['q3'] == 0){
   $one_row['semiannual_technical2'] = ($one_row['q4']) * 0.9;
   }
   else {
   $one_row['semiannual_technical2'] = (($one_row['q3'] + $one_row['q4'])/2) * 0.9;
   }
	
	$one_row['behavioural2'] = ($result_array4['behavioural']/20) * 0.5;
	$one_row['semiannual_average2'] = $one_row['semiannual_technical2'] + $one_row['behavioural2'];

	//---------------------------------------------------------the agreements---------------------------------------------------------
$agreement_status_row = $this->BranchPerformanceTrackingStatus->query('select * from branch_performance_tracking_statuses 
where employee_id = '. $e_id .' and budget_year_id = '.$budget_year_id.' and quarter = 4');

if(count($agreement_status_row) > 0){
	
	$one_row['q4_technical_agreement_plan'] = "branch tracking";
	if($agreement_status_row[0]['branch_performance_tracking_statuses']['result_status'] == 1){
		$one_row['q4_technical_agreement_result'] = "Pending agreement";
	}
	else if($agreement_status_row[0]['branch_performance_tracking_statuses']['result_status'] == 2){
		$one_row['q4_technical_agreement_result'] = "Agreed";
	}
	else if($agreement_status_row[0]['branch_performance_tracking_statuses']['result_status'] == 3){
		$one_row['q4_technical_agreement_result'] = "Agreed with reservation";
	}
	
	//---------------------------------------------------find the behavioural agreements--------------------------------------------
	$behavioural_row = $this->CompetenceResult->query('select * from competence_results 
	where employee_id = '. $e_id .' and budget_year_id = '.$budget_year_id.' and quarter = 4');
	if(count($behavioural_row) > 0){
		if($behavioural_row[0]['competence_results']['result_status'] == 1){
		    $one_row['q4_behavioural_agreement_result'] == "Pending agreement";
	   }
	   else if($behavioural_row[0]['competence_results']['result_status'] == 2){
		$one_row['q4_behavioural_agreement_result'] == "Agreed";
   		}
	  else if($behavioural_row[0]['competence_results']['result_status'] == 3){
			$one_row['q4_behavioural_agreement_result'] == "Agreed with reservation";
		 }
		$one_row['q4_behavioural_comment'] = $behavioural_row[0]['competence_results']['comment'];
	}
	//---------------------------------------------------end of finding the behavioural agreements----------------------------------
	
}
//-------------------------------------------------------end the agreements-------------------------------------------------------

	}
	else { //means it is not branch
	 $hoPlan4 = $this->HoPerformancePlan->query('select * from ho_performance_plans 
	where employee_id = '. $e_id .' and budget_year_id = '.$budget_year_id.' and quarter = 4');
	if(count($hoPlan4) > 0){
		$one_row['q4'] =  $hoPlan4[0]['ho_performance_plans']['both_technical_percent'];
		// $one_row['semi_annual_technical_2'] = $hoPlan4[0]['ho_performance_plans']['semiannual_technical'];
     
		if($one_row['q3'] == 0){
   $one_row['semiannual_technical2'] = ($one_row['q4']) * 0.9;
   }
   else{
   $one_row['semiannual_technical2'] = (($one_row['q3'] + $one_row['q4'])/2) * 0.9;
   }
   
		$one_row['behavioural2'] = $hoPlan4[0]['ho_performance_plans']['behavioural_percent'];
		//$one_row['semi_annual_result_2'] = $hoPlan4[0]['ho_performance_plans']['semiannual_average'];
		$one_row['semiannual_average2'] = $one_row['semiannual_technical2'] + $one_row['behavioural2'];
	//-------------------------------------------------the agreements----------------------------------------------------------
		if($hoPlan4[0]['ho_performance_plans']['plan_status'] == 2){
		    $one_row['q4_technical_agreement_plan'] == "Pending agreement";
	   }
	   else if($hoPlan4[0]['ho_performance_plans']['plan_status'] == 3){
		$one_row['q4_technical_agreement_plan'] == "Agreed";
   		}
	  else if($hoPlan4[0]['ho_performance_plans']['plan_status'] == 4){
			$one_row['q4_technical_agreement_plan'] == "Agreed with reservation";
		 }
	 if($hoPlan4[0]['ho_performance_plans']['result_status'] == 1){
		    $one_row['q4_technical_agreement_result'] == "Pending agreement";
	   }
	   else if($hoPlan4[0]['ho_performance_plans']['result_status'] == 2){
		$one_row['q4_technical_agreement_result'] == "Agreed";
   		}
	  else if($hoPlan4[0]['ho_performance_plans']['result_status'] == 3){
			$one_row['q4_technical_agreement_result'] == "Agreed with reservation";
		 }
		

	//---------------------------------------------------find the behavioural agreements--------------------------------------------
	$behavioural_row = $this->CompetenceResult->query('select * from competence_results 
	where employee_id = '. $e_id .' and budget_year_id = '.$budget_year_id.' and quarter = 4');
	if(count($behavioural_row) > 0){
		if($behavioural_row[0]['competence_results']['result_status'] == 1){
		    $one_row['q4_behavioural_agreement_result'] == "Pending agreement";
	   }
	   else if($behavioural_row[0]['competence_results']['result_status'] == 2){
		$one_row['q4_behavioural_agreement_result'] == "Agreed";
   		}
	  else if($behavioural_row[0]['competence_results']['result_status'] == 3){
			$one_row['q4_behavioural_agreement_result'] == "Agreed with reservation";
		 }
		
	}
	//---------------------------------------------------end of finding the behavioural agreements----------------------------------
//------------------------------------------------------end of the agreements-------------------------------------------------

		
	}

	}
}
}

//-------------------------------end of for the fourth quarter---------------------------------------------------------	
//---------------------find yearly average---------------------------------------------------------
if($one_row['semiannual_average1'] > 0 && $one_row['semiannual_average2'] > 0){
	$one_row['annual'] = ($one_row['semiannual_average1'] + $one_row['semiannual_average2']) / 2 ;
}
//---------------------end of find yearly average---------------------------------------------------------

//------------------------------------------------------start from here---------------------------------------
	$result_semi_annual = 0;
	$is_all_agreed = true;
if($q == 1 || $q == 2){ //it is obviously previous years 3rd and 4th
// return $one_row['semiannual_average2'] ;
echo $one_row['semiannual_average2'];
if($one_row['q4_behavioural_agreement_result'] == 'Agreed' && $one_row['q4_technical_agreement_result'] == 'Agreed' && $one_row['q3_technical_agreement_result'] == 'Agreed'){
	
	return	$one_row['semiannual_average1'];
 } else {
	return 0;
 }
  
}
else { //it is obviously this years 1st and 2nd
	//return $one_row['semiannual_average1'] ;
	if($one_row['q2_behavioural_agreement_result'] == 'Agreed' && $one_row['q2_technical_agreement_result'] == 'Agreed' && $one_row['q1_technical_agreement_result'] == 'Agreed'){
      
	   return	$one_row['semiannual_average1'];
	} else {
		return 0;
	}

}
//echo $q;

	//		array_push($report_table, $one_row);
		
	//$this->set(compact ('report_table',  'output_type' ));

	}
 
}
?>