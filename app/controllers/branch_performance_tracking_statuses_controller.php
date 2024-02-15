<?php
class BranchPerformanceTrackingsController extends AppController {

	var $name = 'BranchPerformanceTrackings';
	function get_emp_names() {
		//---------------------------------------get $emps-------------------------------------------------------------
		$this->loadModel('Employee');
		$this->loadModel('User');
		$this->loadModel('Person');
		$emps = array();
	
		$emp_rows= $this->Employee->query('select * from employees where status = "active" ');
		
		
		for($i = 0 ; $i < count($emp_rows) ; $i++){
	  $e_id =  $emp_rows[$i]['employees']['id'];
			 $emp_id = $emp_rows[$i]['employees']['card'];
			 
			 $user_id = $emp_rows[$i]['employees']['user_id'];
			 $user_row = $this->User->query('select * from users where id = '. $user_id);
			 if(count($user_row) > 0){
				$person_id = $user_row[0]['users']['person_id'];
				
				$person_row = $this->Person->query('select * from people where id = '. $person_id);
				$full_name = $person_row[0]['people']['first_name'].' '.$person_row[0]['people']['middle_name'].' '.$person_row[0]['people']['last_name'];
				$emps[$e_id] = $full_name.' - '.$emp_id;
			}
			
		}
	//--------------------------------------end of get $emps---------------------------------------------------------
			 return $emps;
		
		 }

		 function get_emp_ids() {
			//---------------------------------------get $emps-------------------------------------------------------------
			$this->loadModel('Employee');
			
			$emps = array();
		
			$emp_rows= $this->Employee->query('select * from employees where status = "active" ');
			
			
			for($i = 0 ; $i < count($emp_rows) ; $i++){ 

				 $emp_id = $emp_rows[$i]['employees']['id'];
					$emps[$i] = $emp_id;

			  }
		//--------------------------------------end of get $emps---------------------------------------------------------
				 return $emps;
			
			 }

function get_emp_names_few() {  // one levels
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
			
					
			}
	//  print_r($emps);
					 return $emps;
				
	  }

			function get_emp_ids_few() { // one level
				$this_user = $this->Session->read();
				$this_user_id = $this_user['Auth']['User']['id'];
				
				$this->loadModel('Employee');
				$this->loadModel('Supervisor');
						
				$emps = array();
				// $this_user_id = 3135;
				 $subordinate_ids = array();
				$this_id = 0;
				 $this_id_row = $this->Employee->query('select * from employees where status = "active" and user_id = '.$this_user_id);
				 if(count($this_id_row) > 0){
				  $this_id = $this_id_row[0]['employees']['id'];
				}
					$sub_id_row1 = $this->Supervisor->query('select * from supervisors where sup_emp_id = '.$this_id);
						foreach($sub_id_row1 as $item){
					 $emp_id_row = $this->Employee->query('select * from employees where id = '. $item['supervisors']['emp_id']. ' and status = "active"');
				   $emp_id = $emp_id_row[0]['employees']['card'];
												   
					 $emps[$i] = $emp_id;
							
					}
	
							 return $emps;
					
					
				}
	   
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
				function get_emp_ids_few2() { // two level
					$this_user = $this->Session->read();
					$this_user_id = $this_user['Auth']['User']['id'];
					
					$this->loadModel('Employee');
					$this->loadModel('Supervisor');
							
					$emps = array();
					// $this_user_id = 3135;
					 $subordinate_ids = array();
					$this_id = 0;
					 $this_id_row = $this->Employee->query('select * from employees where status = "active" and user_id = '.$this_user_id);
					 if(count($this_id_row) > 0){
					  $this_id = $this_id_row[0]['employees']['id'];
					}
						$sub_id_row1 = $this->Supervisor->query('select * from supervisors where sup_emp_id = '.$this_id);
							foreach($sub_id_row1 as $item){
						 $emp_id_row = $this->Employee->query('select * from employees where id = '. $item['supervisors']['emp_id']. ' and status = "active"');
					   if(count($emp_id_row) > 0){
						$emp_id = $emp_id_row[0]['employees']['card'];
													   
						$emps[$emp_id_row[0]['employees']['id']] = $emp_id;
						$sub_id_row2 = $this->Supervisor->query('select * from supervisors where sup_emp_id = '.$item['supervisors']['emp_id']);
						foreach($sub_id_row2 as $item2){
						   $emp_id_row2 = $this->Employee->query('select * from employees where id = '. $item2['supervisors']['emp_id']. ' and status = "active"');
						  if(count($emp_id_row2) > 0){
							$emp_id2 = $emp_id_row2[0]['employees']['card'];
														 
							$emps[$emp_id_row2[0]['employees']['id']] = $emp_id2;
						  }
						   
						   
								  
						  }
					   }
							 
						}
		
								 return $emps;	
						
					}

 function get_subordinates2() { // two level
	$this_user = $this->Session->read();
	$this_user_id = $this_user['Auth']['User']['id'];
	
	$this->loadModel('Employee');
	$this->loadModel('Supervisor');
			
	$emps = array();
	// $this_user_id = 3135;
	 $subordinate_ids = array();
	$this_id = 0;
	 $this_id_row = $this->Employee->query('select * from employees where status = "active" and user_id = '.$this_user_id);
	 if(count($this_id_row) > 0){
	  $this_id = $this_id_row[0]['employees']['id'];
	}
		$sub_id_row1 = $this->Supervisor->query('select * from supervisors where sup_emp_id = '.$this_id);
			foreach($sub_id_row1 as $item){
		 $emp_id_row = $this->Employee->query('select * from employees where id = '. $item['supervisors']['emp_id']. ' and status = "active"');
	 //  $emp_id = $emp_id_row[0]['employees']['card'];
									   
	//	 $emps[$emp_id_row[0]['employees']['id']] = $emp_id;
	if(count($emp_id_row) > 0){
		array_push($subordinate_ids, $emp_id_row[0]['employees']['id']);

		$sub_id_row2 = $this->Supervisor->query('select * from supervisors where sup_emp_id = '.$item['supervisors']['emp_id']);
		foreach($sub_id_row2 as $item2){
		   $emp_id_row2 = $this->Employee->query('select * from employees where id = '. $item2['supervisors']['emp_id']. ' and status = "active"');
		// $emp_id2 = $emp_id_row2[0]['employees']['card'];
										 
	   //	$emps[$emp_id_row2[0]['employees']['id']] = $emp_id2;
	   if(count($emp_id_row2) > 0){
		   array_push($subordinate_ids, $emp_id_row2[0]['employees']['id']);
	   }
	   
					  
		  }
	}
		
		}

				 return $subordinate_ids;
		
		
	}

	   
	 function get_subordinates() { // one level
		$this_user = $this->Session->read();
		$this_user_id = $this_user['Auth']['User']['id'];
		
		$this->loadModel('Employee');
		$this->loadModel('Supervisor');
				
		$emps = array();
		// $this_user_id = 3135;
		 $subordinate_ids = array();
		$this_id = 0;
		 $this_id_row = $this->Employee->query('select * from employees where status = "active" and user_id = '.$this_user_id);
		 if(count($this_id_row) > 0){
		  $this_id = $this_id_row[0]['employees']['id'];
		}
			$sub_id_row1 = $this->Supervisor->query('select * from supervisors where sup_emp_id = '.$this_id);
				foreach($sub_id_row1 as $item){
			 $emp_id_row = $this->Employee->query('select * from employees where id = '. $item['supervisors']['emp_id']. ' and status = "active"');
		 //  $emp_id = $emp_id_row[0]['employees']['card'];
										   
		//	 $emps[$emp_id_row[0]['employees']['id']] = $emp_id;
		if(count($emp_id_row) > 0){
			array_push($subordinate_ids, $emp_id_row[0]['employees']['id']);
		}
		

				 
			}

					 return $subordinate_ids;	
			
		}

		function get_all_settings(){

			$settings_array = array();
			$this->loadModel('BranchPerformanceSetting');
			$this->loadModel('Position');
			$settings_row = $this->BranchPerformanceSetting->query('select * from branch_performance_settings ');
			foreach($settings_row as $item){
			
			//------------------get position name for the setting--------------------------------------------------------------
			$position_name = '';
			$position_row = $this->Position->query('select * from positions where id = '.$item['branch_performance_settings']['position_id'].'');
			if(count($position_row) > 0){
			   $position_name = $position_row[0]['positions']['name'];	
			}

			//------------------end of get position name for the setting-------------------------------------------------------
			$goal = $item['branch_performance_settings']['goal'];
			$measure = $item['branch_performance_settings']['measure'];
			$target = $item['branch_performance_settings']['target'];
			$weight = $item['branch_performance_settings']['weight'];

			$settings_array[$item['branch_performance_settings']['id']]  = $position_name." | ".$goal." | ".$measure." | ".$target." | ".$weight."%" ;
			
		}
		//$settings_array[9] = "hello|hello";

		return $settings_array;

		} 
		function list_goals($id = null){
			$this->autoRender = false;
	
			$emp_id = $id;
				//-------------------------find the settings that are relevant to the employee by position------------------------
							//$branch_performance_settings = array();
							//$this->loadModel('Position');
							$this->loadModel('EmployeeDetail');
							$this->loadModel('Position');
							$this->loadModel('BranchPerformanceSetting');
							$position_id_row = $this->EmployeeDetail->query('select * from employee_details 
									where employee_id = '. $emp_id .' order by start_date desc');
							$position_id = $position_id_row[0]["employee_details"]["position_id"];
			//------------------get position name for the setting--------------------------------------------------------------
							$position_name = '';
							$position_row = $this->Position->query('select * from positions where id = '.$position_id.'');
							if(count($position_row) > 0){
							$position_name = $position_row[0]['positions']['name'];	
							}

			//------------------end of get position name for the setting-------------------------------------------------------
	
							$setting_row = $this->BranchPerformanceSetting->query('select * from branch_performance_settings 
							where position_id = '. $position_id .' ');

							$count = 0;
							$str_goals = "" ;

							foreach($setting_row as $item){

								$count++;
								$goal_id = $item['branch_performance_settings']['id'];
								$goal = $item['branch_performance_settings']['goal'];
								$measure = $item['branch_performance_settings']['measure'];
								$target = $item['branch_performance_settings']['target'];
								$weight = $item['branch_performance_settings']['weight'];

								if($count == count($setting_row)){
									$str_goals .= $goal_id.','.$position_name . " | ".$goal." | ".$measure. " | ".$target. " | ". $weight. "%";
								}
								else {

									$str_goals .= $goal_id.','.$position_name . " | ".$goal." | ".$measure. " | ".$target. " | ". $weight. "%".',';
									
								}

							}

							echo $str_goals;


		}
	
	
	function index() {

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
		 or name like "%Branch Manager%"  or name like "%Customer Service Manager%"  ');

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
	
	function index2($id = null) {
		$this->set('parent_id', $id);
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
            $conditions['BranchPerformanceTracking.employee_id'] = $employee_id;
        }

		$emps = $this->get_emp_names_few();
		$br_performance_settings = $this->get_all_settings();
		
		$this->set('branchPerformanceTrackings', $this->BranchPerformanceTracking->find('all', array('conditions' => $conditions, 'limit' => $limit, 'offset' => $start)));
		$this->set('results', $this->BranchPerformanceTracking->find('count', array('conditions' => $conditions)));
		$this->set('emps', $emps);
		$this->set('br_performance_settings', $br_performance_settings);


	}

	function view($id = null) {
		if (!$id) {
			$this->Session->setFlash(__('Invalid branch performance tracking', true));
			$this->redirect(array('action' => 'index'));
		}
		$this->BranchPerformanceTracking->recursive = 2;
		$this->set('branchPerformanceTracking', $this->BranchPerformanceTracking->read(null, $id));
		$all_settings = $this->get_all_settings();
		$this->set(compact('all_settings'));
		$emps = $this->get_emp_names_few();
		
			$this->set(compact('emps'));
	}
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
		array_push($q_year, $q);
		array_push($q_year, $budget_year_id);
		return $q_year;

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
		where employee_id = -1 order by start_date ' );
}

return $position_id_for_quarter_row;

}

	function getDateForDatabase($date){
		$timestamp = strtotime($date);
		$date_formated = date('Y-m-d H:i:s' , $timestamp);
		return $date_formated;
	}

	

	function add($id = null) {
		
		if (!empty($this->data)) {

			$this->loadModel('BranchPerformanceTrackingStatus');

				$original_data = $this->data;
				
				$emp_id = $original_data['BranchPerformanceTracking']['employee_id'];
				$goal = $original_data['BranchPerformanceTracking']['goal'];
				$date = $original_data['BranchPerformanceTracking']['date'];
				$value = $original_data['BranchPerformanceTracking']['value'];

				

				$arr = explode('/',$date);
				if(strlen($arr[1]) == 1){
					$arr[1] = '0'.$arr[1];
				}
				if(strlen($arr[0]) == 1){
					$arr[0] = '0'.$arr[0];
				}
				$date_str = $arr[2].'-'.$arr[1].'-'.$arr[0].' 00:00:00';
				$newDate = $this->getDateForDatabase($date_str);

				$q_year = $this->get_quarter_year($newDate);
				$budget_year_id = $q_year[1];
				$quarter = $q_year[0];
				//-------------------------------------------------------find status----------------------------------------------------
				$result_status = 1;
				$status_row = $this->BranchPerformanceTrackingStatus->query('select * from branch_performance_tracking_statuses where employee_id = '.$emp_id.' and budget_year_id = '.$budget_year_id.' and quarter = '.$quarter.'');
				if(count($status_row) > 0){
					$result_status = $status_row[0]['branch_performance_tracking_statuses']['result_status'];
				}
				//------------------------------------------------------end of finding status--------------------------------------------

				if($result_status < 2 && $budget_year_id !== 0){
					//----------------------------check if duplicate--------------------------------------------------
					$goal_row = $this->BranchPerformanceTracking->query('select * from branch_performance_trackings where employee_id = '.$emp_id.' and goal = '.$goal.' and date = "'.$newDate.'"');
					if(count($goal_row) == 0){
					if(is_numeric($value)){
						$this->BranchPerformanceTracking->create();
						$this->autoRender = false;
						if ($this->BranchPerformanceTracking->save($this->data)) {

							$this->Session->setFlash(__('The branch performance tracking has been saved', true), '');
							$this->render('/elements/success');
						} else {
							$this->Session->setFlash(__('The branch performance tracking could not be saved. Please, try again.', true), '');
							$this->render('/elements/failure');
						}
					} else {
						$this->Session->setFlash(__('Value must be numeric !', true), '');
						$this->render('/elements/failure3');
					}
						
					}
					else {
						$this->Session->setFlash(__('Duplicate branch performance tracking !', true), '');
						$this->render('/elements/failure3');
					}
					//---------------------------end of check if duplicate---------------------------------------------
									}

									else {
										$this->Session->setFlash(__('The status is either closed for adding or it is out of range!', true), '');
										$this->render('/elements/failure3');
									}
									
				

			
		}
		if($id)
			$this->set('parent_id', $id);
			$emps = $this->get_emp_names_few();
		// $employees = $this->BranchPerformanceTracking->Employee->find('list');
		//	$this->set(compact('employees'));
			$this->set(compact('emps'));

	}

	

	function edit($id = null, $parent_id = null) {
		if (!$id && empty($this->data)) {
			$this->Session->setFlash(__('Invalid branch performance tracking', true), '');
			$this->redirect(array('action' => 'index'));
		}
		if (!empty($this->data)) {
			$this->loadModel('BranchPerformanceTrackingStatus');
			$original_data = $this->data;
			$id = $original_data['BranchPerformanceTracking']['id'];
			$value = $original_data['BranchPerformanceTracking']['value'];
			$this->autoRender = false;

			$select_row = $this->BranchPerformanceTracking->query('select * from branch_performance_trackings where id = '.$id);
			$emp_id = $select_row[0]['branch_performance_trackings']['employee_id'];
			$date = $select_row[0]['branch_performance_trackings']['date'];
			$q_year = $this->get_quarter_year($date);

			$budget_year_id = $q_year[1];
			$quarter = $q_year[0];
			//-------------------------------------------------------find status----------------------------------------------------
			$result_status = 1;
			$status_row = $this->BranchPerformanceTrackingStatus->query('select * from branch_performance_tracking_statuses where employee_id = '.$emp_id.' and budget_year_id = '.$budget_year_id.' and quarter = '.$quarter.'');
			if(count($status_row) > 0){
				$result_status = $status_row[0]['branch_performance_tracking_statuses']['result_status'];
			}
			//------------------------------------------------------end of finding status--------------------------------------------

			if($result_status < 2 && $budget_year_id !== 0){
				if(is_numeric($value)){
					//---------------------------------only update the value--------------------------------------------------------------
						$value_row = $this->BranchPerformanceTracking->query('update branch_performance_trackings set value = '.$value.' 
						where id = '.$id);
					
					//--------------------------------end of only update the value------------------------------------------------------------
						$this->Session->setFlash(__('The branch performance tracking has been saved', true), '');
						 $this->render('/elements/success');
		
				} else {
		
							$this->Session->setFlash(__('Value must be numeric !', true), '');
							$this->render('/elements/failure3');
		
					}
			}
			else {
				$this->Session->setFlash(__('The status is either closed for adding or it is out of range!', true), '');
										$this->render('/elements/failure3');
			}
			

			
			 	
			//-----------------------------------just update the value------------------------------
			// if ($this->BranchPerformanceTracking->save($this->data)) {
			// 	$this->Session->setFlash(__('The branch performance tracking has been saved', true), '');
			// 	$this->render('/elements/success');
			// } else {
			// 	$this->Session->setFlash(__('The branch performance tracking could not be saved. Please, try again.', true), '');
			// 	$this->render('/elements/failure');
			// }
		}
		$this->set('branch_performance_tracking', $this->BranchPerformanceTracking->read(null, $id));
		
		if($parent_id) {
			$this->set('parent_id', $parent_id);
		}
			
	//	$employees = $this->BranchPerformanceTracking->Employee->find('list');
	//	$this->set(compact('employees'));

			$emps = $this->get_emp_names_few();
			$all_settings = $this->get_all_settings();
			$this->set(compact('emps', 'all_settings'));

	}

	function delete($id = null) {
		$this->autoRender = false;
		if (!$id) {
			$this->Session->setFlash(__('Invalid id for branch performance tracking', true), '');
			$this->render('/elements/failure');
		}
		if (stripos($id, '_') !== false) {
            $ids = explode('_', $id);
            try{
                foreach ($ids as $i) {
                    $this->BranchPerformanceTracking->delete($i);
                }
				$this->Session->setFlash(__('Branch performance tracking deleted', true), '');
				$this->render('/elements/success');
            }
            catch (Exception $e){
				$this->Session->setFlash(__('Branch performance tracking was not deleted', true), '');
				$this->render('/elements/failure');
            }
        } else {
            if ($this->BranchPerformanceTracking->delete($id)) {
				$this->Session->setFlash(__('Branch performance tracking deleted', true), '');
				$this->render('/elements/success');
			} else {
				$this->Session->setFlash(__('Branch performance tracking was not deleted', true), '');
				$this->render('/elements/failure');
			}
        }
	}
}
?>