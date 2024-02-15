<?php
class HoPerformancePlansController extends AppController {

	var $name = 'HoPerformancePlans';
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
	
	function get_emp_names_few() {  // two levels
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
           
           	function get_emp_names_by_emp_id($e_id){
            $this->loadModel('Employee');
						$this->loadModel('User');
						$this->loadModel('Person');
						$emps = array();
						$user_id_row = $this->Employee->query('select * from employees where id = '. $e_id. '  ');
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
					function get_emp_ids_few2() { // one level
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
           function get_subordinates2222222222(){  // two levels
	$user = $this->Session->read();
		$user_id = $user['Auth']['User']['id'];
		$this->loadModel('Employee');
		$this->loadModel('Supervisor');
		// $user_id = 3135;
  // $user_id = 1225;
  //   $user_id = 468;
		 $subordinate_ids = array();
		$emp_id = 0;
		 $emp_id_row = $this->Employee->query('select * from employees where status = "active" and user_id = '.$user_id);
		 if(count($emp_id_row) > 0){
		  $emp_id = $emp_id_row[0]['employees']['id'];
		}
			$sub_id_row1 = $this->Employee->query('select * from supervisors where sup_emp_id = '.$emp_id);
				foreach($sub_id_row1 as $item){
					array_push($subordinate_ids, $item['supervisors']['emp_id']);
					$sub_id_row2 = $this->Employee->query('select * from supervisors where sup_emp_id = '.$item['supervisors']['emp_id']);
					foreach($sub_id_row2 as $item2){
						array_push($subordinate_ids, $item2['supervisors']['emp_id']);
					}
			}

		return $subordinate_ids;

	 }
	 function get_subordinates2() { // one level
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
	 function get_subordinates1111111111111() {  // one level
			$user = $this->Session->read();
			$user_id = $user['Auth']['User']['id'];
			$this->loadModel('Employee');
			$this->loadModel('Supervisor');
			// $user_id = 3135;
			 $subordinate_ids = array();
			$emp_id = 0;
			 $emp_id_row = $this->Employee->query('select * from employees where status = "active" and user_id = '.$user_id);
			 if(count($emp_id_row) > 0){
			  $emp_id = $emp_id_row[0]['employees']['id'];
			}
				$sub_id_row1 = $this->Employee->query('select * from supervisors where sup_emp_id = '.$emp_id);
					foreach($sub_id_row1 as $item){
						array_push($subordinate_ids, $item['supervisors']['emp_id']);
						
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
		if(count($emp_detail_row) > 0){
			$branch_id = $emp_detail_row[0]["employee_details"]["branch_id"];

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

		//$budget_years = $this->HoPerformancePlan->BudgetYear->find('all');
		$budget_years = $this->get_budget_years();
		$this->set(compact('budget_years', 'branch_type'));

	}
 
 function index_recalculate() {  //this is for HR
 
		// $user = $this->Session->read();
		// $user_id = $user['Auth']['User']['id'];
		// $this->loadModel('Employee');
		// $this->loadModel('EmployeeDetail');
		// $this->loadModel('Branch');
		
		// // $user_id = 3135;
		
		// $emp_id = 0;
		// $emp_id_row = $this->Employee->query('select * from employees where status = "active" and user_id = '.$user_id);
		// if(count($emp_id_row) > 0){
		// 	$emp_id = $emp_id_row[0]["employees"]["id"];
		// }

		// $emp_detail_row = $this->EmployeeDetail->query('select * from employee_details where employee_id = '.$emp_id.' order by start_date desc');
		// $branch_id = 0;
		// if(count($emp_detail_row) > 0){
		// 	$branch_id = $emp_detail_row[0]["employee_details"]["branch_id"];

		// }

		// $branch_category = "";
		// $branch_type = "";
		// $branch_type_row = $this->Branch->query('select * from branches where id = '.$branch_id.' ');
		// if(count($branch_type_row) > 0){
		// 	$branch_category = $branch_type_row[0]["branches"]["branch_category_id"];
		// }
		
		// if($branch_category == 2){
		// 	$branch_type = "ho";
		// }
		// else {
		// 	$branch_type = "branch";
		// }

		//$budget_years = $this->HoPerformancePlan->BudgetYear->find('all');
		//$budget_years = $this->get_budget_years();
	//	$this->set(compact('budget_years', 'branch_type'));
		$budget_years = $this->get_budget_years();
		$this->set(compact('budget_years' ));

	}
	
	function index2($id = null) {
		$this->set('parent_id', $id);
	}

	function search() {
	}
	function test($e_id , $budget_year_id,  $from_date , $to_date , $position, $branch,   $q){


		$budget_year_id = 14;
		$q = 2;
		$branch = 62;
		$position = 

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
	$total_row = $this->BranchPerformanceTracking->query('select sum(value) as sum_value from branch_performance_trackings where goal = '.$item["BranchPerformanceSetting"]["id"].'
	 and date between "'.$quarter_start_date.'" and "'.$quarter_end_date.'"');
	if($total_row[0][0]['sum_value'] != null){
		$sum_value = $total_row[0][0]['sum_value'];
	}
	
	if($sum_value > $item["five_pointer_min"]  && $sum_value <= $item["five_pointer_max_included"]){
		$technical_sum_total += 5 * $item["weight"];
	}
	if($sum_value > $item["four_pointer_min"]  && $sum_value <= $item["four_pointer_max_included"]){
		$technical_sum_total += 4 * $item["weight"];
	}
	if($sum_value > $item["three_pointer_min"]  && $sum_value <= $item["three_pointer_max_included"]){
		$technical_sum_total += 3 * $item["weight"];
	}
	if($sum_value > $item["two_pointer_min"]  && $sum_value <= $item["two_pointer_max_included"]){
		$technical_sum_total += 2 * $item["weight"];
	}
	if($sum_value > $item["one_pointer_min"]  && $sum_value <= $item["one_pointer_max_included"]){
		$technical_sum_total += 1 * $item["weight"];
	}
 }

 if ($position == 93 || $position == 122 || $position == 71){
   $technical_result = 0.85*($branch_result) + 0.15*($technical_sum_total);
 }
 else if ($position == 673 || $position == 793 ){
	$technical_result = 0.75*($branch_result) + 0.25*($technical_sum_total);
 }
 else {
	$technical_result = 0.6*($branch_result) + 0.4*($technical_sum_total);
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
		employee_id = '.  $e_id. ' and budget_year_id = '.$budget_year_id. '  ');
	

		if($behavioural_total_row[0][0]['sum_rating'] != null){
			$behavioural_total = $behavioural_total_row[0][0]['sum_rating'];
		}

	  }


	 $result_array["behavioural"] = $behavioural_total;

	print_r($result_array);

	 

	 }
  
	 function list_data($id = null) {
		//--------------------------------find the user id and emp id-----------------------------------------------
	//	$subordinate_ids = $this->get_subordinates2();
   $subordinate_ids = $this->get_subordinates();
   // $this->emp_names = $this->get_emp_names();
		 
		//------------------------------end of finding the user id and emp id-----------------------------------------------

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
			$conditions['HoPerformancePlan.budget_year_id'] = $year_filter;
			$conditions['HoPerformancePlan.quarter'] = $quarter_filter;
        }
		$conditions['HoPerformancePlan.employee_id'] = $subordinate_ids;
		// $emps = $this->get_emp_names();
    // $emps = $this->emp_names;
	//	 $emps = $this->get_emp_names_few();
   $emps = $this->get_emp_names_few2();

  // print_r($emps);
  // $hoPerformancePlans = $this->HoPerformancePlan->find('all', array('conditions' => $conditions, 'limit' => $limit, 'offset' => $start));
  // print_r($hoPerformancePlans);

		$this->set('hoPerformancePlans', $this->HoPerformancePlan->find('all', array('conditions' => $conditions, 'limit' => $limit, 'offset' => $start)));
		$this->set('results', $this->HoPerformancePlan->find('count', array('conditions' => $conditions)));
		$this->set('emps', $emps);

	}
 function list_data_recalculate($id = null) {
		//--------------------------------find the user id and emp id-----------------------------------------------
		//$subordinate_ids = $this->get_subordinates2();
   // $this->emp_names = $this->get_emp_names();
		 
		//------------------------------end of finding the user id and emp id-----------------------------------------------

		$start = (isset($_REQUEST['start'])) ? $_REQUEST['start'] : 0;
		$limit = (isset($_REQUEST['limit'])) ? $_REQUEST['limit'] : 5;
		$employee_id = (isset($_REQUEST['employee_id'])) ? $_REQUEST['employee_id'] : -1;
		if($id)
			$employee_id = ($id) ? $id : -1;
        $conditions = (isset($_REQUEST['conditions'])) ? $_REQUEST['conditions'] : '';

        eval("\$conditions = array( " . $conditions . " );");
		if ($employee_id != -1) {
			//$budget_year_ids = $this->get_budget_year_ids();
			//$year_quater_filter = explode(" ", $budget_year_ids[$budgetyear_id]);
			//$year_filter = $year_quater_filter[0]  * 1;
			//$quarter_filter = $year_quater_filter[1] * 1;
            //$conditions['HoPerformancePlan.budget_year_id'] = $budgetyear_id;
			//$conditions['HoPerformancePlan.budget_year_id'] = $year_filter;
			//$conditions['HoPerformancePlan.quarter'] = $quarter_filter;
			$conditions['HoPerformancePlan.employee_id'] = $employee_id;
        }
		else{
			$conditions['HoPerformancePlan.employee_id'] = -1;
		}
		//$conditions['HoPerformancePlan.employee_id'] = $subordinate_ids;
		// $emps = $this->get_emp_names();
    // $emps = $this->emp_names;
	//	 $emps = $this->get_emp_names_few();
 //echo $employee_id;
   $emps = $this->get_emp_names_by_emp_id($employee_id);

  // print_r($emps);
  // $hoPerformancePlans = $this->HoPerformancePlan->find('all', array('conditions' => $conditions, 'limit' => $limit, 'offset' => $start));
  // print_r($hoPerformancePlans);

		$this->set('hoPerformancePlans', $this->HoPerformancePlan->find('all', array('conditions' => $conditions, 'limit' => $limit, 'offset' => $start)));
		$this->set('results', $this->HoPerformancePlan->find('count', array('conditions' => $conditions)));
		$this->set('emps', $emps);

	}
	function list_data2($id = null) {
		//--------------------------------find the user id and emp id-----------------------------------------------
		$subordinate_ids = $this->get_subordinates2();
   // $this->emp_names = $this->get_emp_names();
		 
		//------------------------------end of finding the user id and emp id-----------------------------------------------

		$start = (isset($_REQUEST['start'])) ? $_REQUEST['start'] : 0;
		$limit = (isset($_REQUEST['limit'])) ? $_REQUEST['limit'] : 5;
		$budgetyear_id = (isset($_REQUEST['budgetyear_id'])) ? $_REQUEST['budgetyear_id'] : -1;
		if($id)
			$budgetyear_id = ($id) ? $id : -1;
        $conditions = (isset($_REQUEST['conditions'])) ? $_REQUEST['conditions'] : '';

        eval("\$conditions = array( " . $conditions . " );");
		if ($budgetyear_id != -1) {
            $conditions['HoPerformancePlan.budget_year_id'] = $budgetyear_id;
        }
		 $conditions['HoPerformancePlan.employee_id'] = $subordinate_ids;
		// $emps = $this->get_emp_names();
    // $emps = $this->emp_names;
	//	 $emps = $this->get_emp_names_few();
   		$emps = $this->get_emp_names_few2();

		$this->set('hoPerformancePlans', $this->HoPerformancePlan->find('all', array('conditions' => $conditions, 'limit' => $limit, 'offset' => $start)));
		$this->set('results', $this->HoPerformancePlan->find('count', array('conditions' => $conditions)));
		$this->set('emps', $emps);

	}

	function view($id = null) {
		if (!$id) {
			$this->Session->setFlash(__('Invalid ho performance plan', true));
			$this->redirect(array('action' => 'index'));
		}
		$this->HoPerformancePlan->recursive = 2;
		$this->set('hoPerformancePlan', $this->HoPerformancePlan->read(null, $id));
	}

	function add($id = null) {
		if (!empty($this->data)) {
			$original_data = $this->data ;
			$employee_id = $original_data['HoPerformancePlan']['employee_id'];
			$budget_year_id = $original_data['HoPerformancePlan']['budget_year_id'];
			$quarter = $original_data['HoPerformancePlan']['quarter'];
			$original_data['HoPerformancePlan']['plan_status'] = 2;
			
			$conditions = array('HoPerformancePlan.employee_id' => $employee_id,'HoPerformancePlan.budget_year_id' => $budget_year_id,'HoPerformancePlan.quarter' => $quarter );
			$hoPerformancePlan = $this->HoPerformancePlan->find('all', array('conditions' => $conditions )); 
			if(count($hoPerformancePlan) == 0){
				$this->HoPerformancePlan->create();
				$this->autoRender = false;
			//	if ($this->HoPerformancePlan->save($this->data)) {
				if ($this->HoPerformancePlan->save($original_data)) {
					$this->Session->setFlash(__('The ho performance plan has been saved', true), '');
					$this->render('/elements/success');
				} else {
					 $this->Session->setFlash(__('The ho performance plan could not be saved. Please, try again.', true), '');
					 $this->render('/elements/failure');
				}
			}
			else {
				
						$this->Session->setFlash(__('The ho performance has already been inserted.', true), '');
						$this->render('/elements/failure3');
			}
	
		}
  // $emps = $this->emp_names;
	// $emps = $this->get_emp_names();
	//	$emps = $this->get_emp_names_few();
 $emps = $this->get_emp_names_few();
		if($id)
			$this->set('parent_id', $id);
		$budget_years = $this->HoPerformancePlan->BudgetYear->find('list');
		
		$this->set(compact('budget_years', 'employees', 'emps'));
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
					}
                	$position_row2 = $this->EmployeeDetail->query('select * from employee_details where employee_id = '. $sup_emp_id.' order by start_date desc');
                 $sup_grade_id = -1;
			if(count($position_row2) > 0){
			$sup_grade_id = $position_row2[0]['employee_details']['grade_id'];
			}
			
			$sup_grade = -1;
      	$sup_grade_row = $this->Grade->query('select * from grades where id = '. $sup_grade_id.' ');
			if(count($sup_grade_row) > 0){
				$sup_grade = $sup_grade_row[0]['grades']['grade_num'];
			}  

				if($sup_grade >= 14){
					  $sup_id = $sup_emp_id;
					  }
					  else{
      $sup_id_row2 = $this->Supervisor->query('select * from supervisors where emp_id = '.$sup_emp_id);
						if(count($sup_id_row2) > 0){
							$sup_id = $sup_id_row2[0]['supervisors']['sup_emp_id'];
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

	function emp_level222222222222222222($emp_id){
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

	function edit($id = null, $parent_id = null) {
		if (!$id && empty($this->data)) {
			$this->Session->setFlash(__('Invalid ho performance plan', true), '');
			$this->redirect(array('action' => 'index'));
		}
		
		//$own_percent = null;
		if (!empty($this->data)) {

		
			$this->autoRender = false;
			$original_data = $this->data;
			$id = $original_data['HoPerformancePlan']['id'];
			$quarter = $original_data['HoPerformancePlan']['quarter'];
			$budget_year_id = $original_data['HoPerformancePlan']['budget_year_id'];
			$emp_id = $original_data['HoPerformancePlan']['employee_id'];
			$plan_status = $original_data['HoPerformancePlan']['plan_status'];
            $grade_array = array(11,12,13,16,17,18,19);
			//$emp_level = $this->emp_level($emp_id);
			$sup_id = $this->get_sup_id($emp_id);
			//---------------------get grade id---------------------------------------------------------------------
				$this->loadModel('EmployeeDetail');
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
			
	
			//---------------end of find supervisor id (director id)-----------------------------------------

			$this->loadModel('HoPerformanceDetail');

//---------------------------------------------common for all quarters------------------------------------------------
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
//---------------find self technical percent---------------------------------------------------------------------------
$self_technical_percent_100 = $this->HoPerformanceDetail->find('first', 
array (
	'fields' => array('sum(HoPerformanceDetail.final_score) as total_sum'),
	'conditions' => array(
	'HoPerformanceDetail.ho_performance_plan_id' => $id
) 

));

$total_self_technical_sum = round($self_technical_percent_100[0]['total_sum'] * $multiplication_ratio , 2);
$original_data['HoPerformancePlan']['self_technical_percent'] = $total_self_technical_sum;
//---------------end of find self technical percent---------------------------------------------------------------------------
//---------------find supervisor technical percent-----------------------------------------------------------------------------
$sup_technical_percent = 0;
//if(!in_array($grade_id, $grade_array)){
//	if($emp_level < 3){
	if($sup_id != -1){
	$sup_technical_percent_row = array();
	$sup_technical_percent_row = $this->HoPerformancePlan->find('first', array('conditions' => array('HoPerformancePlan.employee_id' => $sup_id , 'HoPerformancePlan.budget_year_id' => $budget_year_id ,'HoPerformancePlan.quarter' => $quarter )));	
//	$sup_both_technical_percent = 0;
	if(count($sup_technical_percent_row) > 0){

		$sup_technical_percent = $sup_technical_percent_row['HoPerformancePlan']['self_technical_percent'];
		//$sup_own_spvr_percent = $sup_own_spvr_percent_row[0]['own_spvr_percent'];
	} else {
		$sup_technical_percent = 0;
	}	
    $original_data['HoPerformancePlan']['spvr_technical_percent'] = $sup_technical_percent; 
}
	
//-----------------end of find supervisor technical percent------------------------------------
//-------------------------find both technical percent------------------------------------
//if(!in_array($grade_id, $grade_array)){
//if($emp_level < 3){
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
else { // above director
	$both_technical_percent = $total_self_technical_sum;
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
	$original_data['HoPerformancePlan']['behavioural_percent'] = (($competence_total/100)/0.2) * 0.5 ;
//	-----------------------------find the first quarter result-----------------------------------------------------------
//	$quarter_one_row = $this->HoPerformancePlan->find('first', array('conditions' => array('HoPerformancePlan.employee_id' => $emp_id , 'HoPerformancePlan.budget_year_id' => $budget_year_id ,'HoPerformancePlan.quarter' => 1 )));	
	$quarter_one_row =  $this->HoPerformancePlan->query('select * from ho_performance_plans where employee_id = '.$emp_id.' and budget_year_id = '.$budget_year_id.' and quarter = 1');
	if(count($quarter_one_row) > 0){
		// $quarter_one_both_technical_percent = $quarter_one_row['HoPerformancePlan']['both_technical_percent'];
		$quarter_one_both_technical_percent = $quarter_one_row[0]['ho_performance_plans']['both_technical_percent'];
		$semiannual_technical = ($both_technical_percent + $quarter_one_both_technical_percent) / 2;
	//	$semiannual_average = ($semiannual_technical) * 0.9;
	} else {
		$quarter_one_both_technical_percent = 0;
		$semiannual_technical = $both_technical_percent;
//-----------------------------------------first check if quarter 1 is ho or branch-----------------------------------

//----------------------------------------end of check if quarter 1 is ho or branch-----------------------------------
	
	//	$semiannual_average = ($both_technical_percent) * 0.9;
	}
	$original_data['HoPerformancePlan']['semiannual_technical'] = $semiannual_technical * 0.9 ;
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
	//$quarter_three_row = $this->HoPerformancePlan->find('first', array('conditions' => array('HoPerformancePlan.employee_id' => $emp_id , 'HoPerformancePlan.budget_year_id' => $budget_year_id ,'HoPerformancePlan.quarter' => 3 )));	
	$quarter_three_row =  $this->HoPerformancePlan->query('select * from ho_performance_plans where employee_id = '.$emp_id.' and budget_year_id = '.$budget_year_id.' and quarter = 3');
	if(count($quarter_three_row) > 0){
		//$quarter_three_both_technical_percent = $quarter_three_row['HoPerformancePlan']['both_technical_percent'];
		$quarter_three_both_technical_percent = $quarter_three_row[0]['ho_performance_plans']['both_technical_percent'];
		$semiannual_technical = ($both_technical_percent + $quarter_three_both_technical_percent) / 2;
	//	$semiannual_average = ($semiannual_technical) * 0.9;
	} else {
		$quarter_three_both_technical_percent = 0;
		$semiannual_technical = $both_technical_percent;
	//	$semiannual_average = ($both_technical_percent) * 0.9;
	//-----------------------------------------first check if quarter 3 is ho or branch-----------------------------------

//----------------------------------------end of check if quarter 3 is ho or branch-----------------------------------
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

				if($plan_status <= 2 && $general_status == "open"){  //if is agreed don't do anything
				//if ($this->HoPerformancePlan->save($this->data)) {
					if ($this->HoPerformancePlan->save($original_data)) {
						$this->Session->setFlash(__('The ho performance plan has been saved', true), '');
						$this->render('/elements/success');
					} else {
						$this->Session->setFlash(__('The ho performance plan could not be saved. Please, try again.', true), '');
						$this->render('/elements/failure');
					}
				}
				else {
					$this->Session->setFlash(__('The plan is closed for editing.', true), '');
					$this->render('/elements/failure3');
				}
	
		}

		$this->set('ho_performance_plan', $this->HoPerformancePlan->read(null, $id));
		
		if($parent_id) {
			$this->set('parent_id', $parent_id);
		}
			
		$budget_years = $this->HoPerformancePlan->BudgetYear->find('list');
		$employees = $this->HoPerformancePlan->Employee->find('list');
	//	 $emps = $this->get_emp_names();
     $emps = $this->get_emp_names_few2();
		// $emps = $this->get_emp_names_few();
		
	
		$this->set(compact('budget_years', 'employees', 'emps'));
		//$this->set(compact('budget_years', 'employees'));

	}
	

	function change_status($id = null, $parent_id = null) {
		if (!$id && empty($this->data)) {
			$this->Session->setFlash(__('Invalid ho performance plan', true), '');
			$this->redirect(array('action' => 'index'));
		}
		if (!empty($this->data)) {
			$original_data = $this->data;
			$id = $original_data['HoPerformancePlan']['id'];
			$plan_status = $original_data['HoPerformancePlan']['plan_status'];
			$result_status = $original_data['HoPerformancePlan']['result_status'];

			$emp_id_row = $this->HoPerformancePlan->query('select * from ho_performance_plans where id = '.$id);
			$emp_id = $emp_id_row[0]['ho_performance_plans']['employee_id'];
      //------------------------------------find this user emp id--------------------------------------------
          $this_user = $this->Session->read();
			    $this_user_id = $this_user['Auth']['User']['id'];
			    $this->loadModel('Employee');
          $emp_rows= $this->Employee->query('select * from employees where user_id = '.$this_user_id);
          $this_emp_id = $emp_rows[0]['employees']['id'];
          
                                           
      
      //----------------------------------end of find this user emp id------------------------------------------
      
				//------------------------------------find first supervisor id---------------------------------------
			$this->loadModel('Supervisor');
			$first_sup_id = 0;
			
			$first_sup_id_row = $this->Supervisor->query('select * from supervisors where emp_id = '.$emp_id.' order by id desc');
			$first_sup_id = $first_sup_id_row[0]['supervisors']['sup_emp_id'];
	
	//----------------------------------end of find first supervisor id------------------------------------
	//------------------------------------find second supervisor id---------------------------------------
		$second_sup_id = 0;
								
	  $second_sup_id_row = $this->Supervisor->query('select * from supervisors where emp_id = '.$first_sup_id.' order by id desc');
	  $second_sup_id = $second_sup_id_row[0]['supervisors']['sup_emp_id'];
	
	//----------------------------------end of find second supervisor id------------------------------------

			//--------------------------find whether weight is 100 or not--------------------------------------
			$total_weight = 0;
			$this->loadModel('HoPerformanceDetail');
			$weight_row = $this->HoPerformanceDetail->query('select sum(weight) as sum_weight from ho_performance_details where ho_performance_plan_id = '.$id );
			$sum_weight = $weight_row[0][0]['sum_weight'];
				if($sum_weight != null) {
					$total_weight += $sum_weight;
				}
				else {
					$total_weight = 0;
				}
				//---------------------------end of finding whether weight is 100 or not----------------------------
			if($total_weight > 0) {  //make changes
				$this->autoRender = false;

    
		if($total_weight <= 100){
		//-------------here i have to validate if the spv is authorized to change the status-------------------------------------------
   
			if($this_emp_id == $second_sup_id){
				$update_status = $this->HoPerformancePlan->query('update ho_performance_plans set plan_status = '.$plan_status.', result_status = '.$result_status.' where id = '.$id );
					
				$this->Session->setFlash(__('The status has been changed successfully', true), '');
				$this->render('/elements/success');
			}else{
				$this->Session->setFlash(__('Sorry! You are not authorized to change the status.', true), '');
						$this->render('/elements/failure3');
			}
		
		}
		else {
			$this->Session->setFlash(__('data entry is not complete.', true), '');
			$this->render('/elements/failure3');
		}
	  
	
			}
			else { // do nothing
 				$this->Session->setFlash(__('The status cannot be applied.', true), '');
			 	$this->render('/elements/failure3');
			}		
			
		}
		
		$this->set('ho_performance_plan', $this->HoPerformancePlan->read(null, $id));
		
	}
 
 	function agree_technical_br($id = null, $parent_id = null){
  
		if (!$id && empty($this->data)) {
			$this->Session->setFlash(__('Invalid ho performance plan', true), '');
			$this->redirect(array('action' => 'index'));
		}
		if (!empty($this->data)) {
			$original_data = $this->data;
			// $id = $original_data['HoPerformancePlan']['id'];
			$this->loadModel('BranchPerformanceTrackingStatus');

			$id = $original_data['HoPerformancePlan']['id'];
			$br_plan_id_array = explode("-",$id);
			 $e_id = $br_plan_id_array[0];
			 $budget_year_id = $br_plan_id_array[1];
			 $quarter = $br_plan_id_array[2];

			$result_status = $original_data['HoPerformancePlan']['result_status'];
			$comment = $original_data['HoPerformancePlan']['comment'];

			//-----------------------------------------------------find previous statuses--------------------------------------------------------
			$prev_result_status = 1000;
				$current_status_row = $this->BranchPerformanceTrackingStatus->query('select * from branch_performance_tracking_statuses where 
				employee_id = '.$e_id.' and budget_year_id = '.$budget_year_id.' and quarter = '.$quarter);
				if(count($current_status_row) > 0){
					$prev_result_status = $current_status_row[0]['branch_performance_tracking_statuses']['result_status'];
				}

				
			//------------------------------------------------end of find previous statuses------------------------------------------------------
			if($prev_result_status < 2){
				$update_status = $this->BranchPerformanceTrackingStatus->query('update branch_performance_tracking_statuses set  result_status = '.$result_status.', comment = "'.$comment.'"
				where employee_id = '.$e_id.' and budget_year_id = '.$budget_year_id.' and quarter = '.$quarter );
	
				$this->Session->setFlash(__('The status has been changed successfully', true), '');
							 $this->render('/elements/success');
			}
			else {
				$this->Session->setFlash(__('The status is either closed for changing or is empty. Please contact HR department.', true), '');
				$this->render('/elements/failure3');
			}	

		}
		// echo $id;
		 $br_plan_id_array = explode("-",$id);

		 $e_id = $br_plan_id_array[0];
		 $budget_year_id = $br_plan_id_array[1];
		 $quarter = $br_plan_id_array[2];

		 $this->loadModel('BranchPerformanceTrackingStatus');

		// $this->set('ho_performance_plan', $this->HoPerformancePlan->read(null, $id));

		$this->set('ho_performance_plan', $this->BranchPerformanceTrackingStatus->find('first', 
		array('conditions' => array('BranchPerformanceTrackingStatus.employee_id' => $e_id, 
		'BranchPerformanceTrackingStatus.budget_year_id' => $budget_year_id,
		'BranchPerformanceTrackingStatus.quarter' => $quarter,

	))));


	$this->set('br_plan_id', $id);

	}

	function agree_technical($id = null, $parent_id = null){
		if (!$id && empty($this->data)) {
			$this->Session->setFlash(__('Invalid ho performance plan', true), '');
			$this->redirect(array('action' => 'index'));
		}
		if (!empty($this->data)) {
			$original_data = $this->data;
			$id = $original_data['HoPerformancePlan']['id'];
			$plan_status = $original_data['HoPerformancePlan']['plan_status'];
			$result_status = $original_data['HoPerformancePlan']['result_status'];
			$comment = $original_data['HoPerformancePlan']['comment'];

			$emp_id_row = $this->HoPerformancePlan->query('select * from ho_performance_plans where id = '.$id);
			$emp_id = $emp_id_row[0]['ho_performance_plans']['employee_id'];

			//-----------------------------------------find the current statuses-------------------------------------------------
			$prev_result_status = 1000;
			$current_statuses_row = $this->HoPerformancePlan->query('select * from ho_performance_plans where id = '.$id );
			if(count($current_statuses_row) > 0){
				$prev_plan_status = $current_statuses_row[0]['ho_performance_plans']['plan_status'];
				$prev_result_status = $current_statuses_row[0]['ho_performance_plans']['result_status'];
			}
			
			//--------------------------------------end of finding the current statuses-------------------------------------------

			//------------------------------------find first supervisor id---------------------------------------
			// $first_sup_id = 0;
			
			// 		$this->loadModel('Supervisor');
					
			// 		$first_sup_id_row = array();
			// 		$first_sup_id_row = $this->Supervisor->find('first', array('conditions' => array('Supervisor.emp_id' => $emp_id)));
			// 		if(count($first_sup_id_row) > 0){
			// 			$first_sup_id = $first_sup_id_row['Supervisor']['sup_emp_id'];
			// 		}
			// 		else {
			// 			$first_sup_id = 0;
			// 		}

			//----------------------------------end of find first supervisor id------------------------------------
			//--------------------------find whether weight is 100 or not--------------------------------------
			if($prev_result_status < 2){
				$total_weight = 0;
				$this->loadModel('HoPerformanceDetail');
				$weight_row = $this->HoPerformanceDetail->query('select sum(weight) as sum_weight from ho_performance_details where ho_performance_plan_id = '.$id );
				$sum_weight = $weight_row[0][0]['sum_weight'];
					if($sum_weight != null) {
						$total_weight += $sum_weight;
					}
					else {
						$total_weight = 0;
					}
			//---------------------------end of finding whether weight is 100 or not----------------------------
			if($total_weight > 0) {  //make changes
				$this->autoRender = false;

				if($total_weight <= 100){
		
					if($result_status <= 1){
						$update_status = $this->HoPerformancePlan->query('update ho_performance_plans set plan_status = '.$plan_status.', result_status = '.$result_status.', comment = "'.$comment.'" where id = '.$id );
						$this->Session->setFlash(__('The status has been changed successfully', true), '');
						$this->render('/elements/success');
					}	
					
					if($plan_status <= 2 && $result_status > 1){
						$this->Session->setFlash(__('You must agree to the plan before responding to the result.', true), '');
						$this->render('/elements/failure3');
					}
           
           if($plan_status > 2 && $result_status > 1){
						$update_status = $this->HoPerformancePlan->query('update ho_performance_plans set plan_status = '.$plan_status.', result_status = '.$result_status.', comment = "'.$comment.'" where id = '.$id );
						$this->Session->setFlash(__('The status has been changed successfully', true), '');
						$this->render('/elements/success');
					}
						
					
				}
				else {
					$this->Session->setFlash(__('data entry is not complete.', true), '');
					$this->render('/elements/failure3');
				}
	
			}
			else { // do nothing
 				$this->Session->setFlash(__('The status cannot be applied.', true), '');
			 	$this->render('/elements/failure3');
			}
			}
			else {
				$this->Session->setFlash(__('The status is either closed for change or is empty. Please contact HR department.', true), '');
				$this->render('/elements/failure3');
			}
				

			
		}
		$this->set('ho_performance_plan', $this->HoPerformancePlan->read(null, $id));
	}

	function agree_behavioural_branch($id = null, $parent_id = null) {

		$this->loadModel('CompetenceResult');
		
		if (!$id && empty($this->data)) {
			$this->Session->setFlash(__('Invalid ho performance plan', true), '');
			$this->redirect(array('action' => 'index'));
		}
		if (!empty($this->data)) {
			$original_data = $this->data;
			$id = $original_data['CompetenceResult']['id'];
			$result_status = $original_data['CompetenceResult']['result_status'];
			$comment = $original_data['CompetenceResult']['comment'];
			$emp_id_row = $this->CompetenceResult->query('select * from competence_results where id = '.$id);

			$prev_result_status = 1000;

			if(count($emp_id_row) > 0){
				$emp_id = $emp_id_row[0]['competence_results']['employee_id'];
				$budget_year_id = $emp_id_row[0]['competence_results']['budget_year_id'];
				$quarter = $emp_id_row[0]['competence_results']['quarter'];
	
				//---------------------------------------------find the current status----------------------------------------------
				
				$current_status_row = $this->CompetenceResult->query('select * from competence_results where employee_id = '. $emp_id.' 
				and budget_year_id = '.$budget_year_id.' and quarter = '.$quarter);
				if(count($current_status_row) > 0){
					$prev_result_status = $current_status_row[0]['competence_results']['result_status'];
				}
				//--------------------------------------------end of finding the current status--------------------------------------
			}
			
			//------------------------------------find first supervisor id---------------------------------------
			// $first_sup_id = 0;
			
			// 		$this->loadModel('Supervisor');
					
			// 		$first_sup_id_row = array();
			// 		$first_sup_id_row = $this->Supervisor->find('first', array('conditions' => array('Supervisor.emp_id' => $emp_id)));
			// 		if(count($first_sup_id_row) > 0){
			// 			$first_sup_id = $first_sup_id_row['Supervisor']['sup_emp_id'];
			// 		}
			// 		else {
			// 			$first_sup_id = 0;
			// 		}

			//----------------------------------end of find first supervisor id------------------------------------
			//-------------------------------------get grade first----------------------------------------------------
			if($prev_result_status < 2){
				$this->loadModel('EmployeeDetail');
				
				$grade_row = $this->EmployeeDetail->query('select * from employee_details where employee_id = '. $emp_id.' order by start_date desc');
						$grade_id = $grade_row[0]['employee_details']['grade_id'];
					//------------------------------------end of get grade first----------------------------------------------
				//----------------------------------check whether weight is 10------------------------------------------
						$this->loadModel('CompetenceSetting');
						$weight_row = $this->CompetenceSetting->query('select sum(weight) as sum_weight from competence_settings where grade_id = '.$grade_id );
						$sum_weight = $weight_row[0][0]['sum_weight'];
				//----------------------------------end of check whether weight is 10------------------------------------------
				//----------------------------------check whether count is equal to the setting--------------------------------
						$result_count_row = $this->CompetenceResult->query('select count(competence_id) as count_result from competence_results
						where employee_id = '.$emp_id.' and budget_year_id = '.$budget_year_id.' and quarter = '.$quarter );
						$result_count = $result_count_row[0][0]['count_result'];
		
						$setting_count_row = $this->CompetenceSetting->query('select count(competence_id) as count_setting from competence_settings where grade_id = '.$grade_id );
						$setting_count = $setting_count_row[0][0]['count_setting'];
				//----------------------------------check whether count is equal to the setting--------------------------------
				if($sum_weight == 10){
					if($result_count == $setting_count){
		
		
						$update_status = $this->CompetenceResult->query('update competence_results set  result_status = '.$result_status.', comment = "'.$comment.'" 
						where employee_id = '.$emp_id.' and quarter = '.$quarter.' and budget_year_id = '.$budget_year_id );
		
						$this->Session->setFlash(__('The status has been changed successfully', true), '');
						$this->render('/elements/success');
		
					}
					else {
						$this->Session->setFlash(__('The behavioural data is not complete.', true), '');
						 $this->render('/elements/failure3');
					}
		
				 }
				 else {
						 $this->Session->setFlash(__('The setting is not complete.', true), '');
						 $this->render('/elements/failure3');
				 }
			} else {
				$this->Session->setFlash(__('The status is either closed for change or is empty. Please contact HR department', true), '');
				$this->render('/elements/failure3');
			}
						
		}
		
		$this->set('competence_result', $this->CompetenceResult->read(null, $id)); // only the last competence result is enough
		
	}

	function agree_behavioural($id = null, $parent_id = null) {

		$this->loadModel('CompetenceResult');
		
		if (!$id && empty($this->data)) {
			$this->Session->setFlash(__('Invalid ho performance plan', true), '');
			$this->redirect(array('action' => 'index'));
		}
		if (!empty($this->data)) {
			$original_data = $this->data;
			$id = $original_data['CompetenceResult']['id'];
			$result_status = $original_data['CompetenceResult']['result_status'];
			$comment = $original_data['CompetenceResult']['comment'];
			$emp_id_row = $this->CompetenceResult->query('select * from competence_results where id = '.$id);

			$prev_result_status = 1000;

			if(count($emp_id_row) > 0){
				$emp_id = $emp_id_row[0]['competence_results']['employee_id'];
				$budget_year_id = $emp_id_row[0]['competence_results']['budget_year_id'];
				$quarter = $emp_id_row[0]['competence_results']['quarter'];
	
				//---------------------------------------------find the current status----------------------------------------------
				
				$current_status_row = $this->CompetenceResult->query('select * from competence_results where employee_id = '. $emp_id.' 
				and budget_year_id = '.$budget_year_id.' and quarter = '.$quarter);
				if(count($current_status_row) > 0){
					$prev_result_status = $current_status_row[0]['competence_results']['result_status'];
				}
				//--------------------------------------------end of finding the current status--------------------------------------
			}
			
			//------------------------------------find first supervisor id---------------------------------------
			// $first_sup_id = 0;
			
			// 		$this->loadModel('Supervisor');
					
			// 		$first_sup_id_row = array();
			// 		$first_sup_id_row = $this->Supervisor->find('first', array('conditions' => array('Supervisor.emp_id' => $emp_id)));
			// 		if(count($first_sup_id_row) > 0){
			// 			$first_sup_id = $first_sup_id_row['Supervisor']['sup_emp_id'];
			// 		}
			// 		else {
			// 			$first_sup_id = 0;
			// 		}

			//----------------------------------end of find first supervisor id------------------------------------
			//-------------------------------------get grade first----------------------------------------------------
			if($prev_result_status < 2){
				$this->loadModel('EmployeeDetail');
				
				$grade_row = $this->EmployeeDetail->query('select * from employee_details where employee_id = '. $emp_id.' order by start_date desc');
						$grade_id = $grade_row[0]['employee_details']['grade_id'];
					//------------------------------------end of get grade first----------------------------------------------
				//----------------------------------check whether weight is 10------------------------------------------
						$this->loadModel('CompetenceSetting');
						$weight_row = $this->CompetenceSetting->query('select sum(weight) as sum_weight from competence_settings where grade_id = '.$grade_id );
						$sum_weight = $weight_row[0][0]['sum_weight'];
				//----------------------------------end of check whether weight is 10------------------------------------------
				//----------------------------------check whether count is equal to the setting--------------------------------
						$result_count_row = $this->CompetenceResult->query('select count(competence_id) as count_result from competence_results
						where employee_id = '.$emp_id.' and budget_year_id = '.$budget_year_id.' and quarter = '.$quarter );
						$result_count = $result_count_row[0][0]['count_result'];
		
						$setting_count_row = $this->CompetenceSetting->query('select count(competence_id) as count_setting from competence_settings where grade_id = '.$grade_id );
						$setting_count = $setting_count_row[0][0]['count_setting'];
				//----------------------------------check whether count is equal to the setting--------------------------------
				if($sum_weight == 10){
					if($result_count == $setting_count){
		
		
						$update_status = $this->CompetenceResult->query('update competence_results set  result_status = '.$result_status.', comment = "'.$comment.'" 
						where employee_id = '.$emp_id.' and quarter = '.$quarter.' and budget_year_id = '.$budget_year_id );
		
						$this->Session->setFlash(__('The status has been changed successfully', true), '');
						$this->render('/elements/success');
		
					}
					else {
						$this->Session->setFlash(__('The behavioural data is not complete.', true), '');
						 $this->render('/elements/failure3');
					}
		
				 }
				 else {
						 $this->Session->setFlash(__('The setting is not complete.', true), '');
						 $this->render('/elements/failure3');
				 }
			} else {
				$this->Session->setFlash(__('The status is either closed for change or is empty. Please contact HR department', true), '');
				$this->render('/elements/failure3');
			}
						
		}
		
		$this->set('competence_result', $this->CompetenceResult->read(null, $id)); // only the last competence result is enough
		
	}
	

	function agree_behavioural2222222222($id = null, $parent_id = null) {

		$this->loadModel('CompetenceResult');
		
		if (!$id && empty($this->data)) {
			$this->Session->setFlash(__('Invalid ho performance plan', true), '');
			$this->redirect(array('action' => 'index'));
		}
		if (!empty($this->data)) {
			$original_data = $this->data;
			$id = $original_data['CompetenceResult']['id'];
			$result_status = $original_data['CompetenceResult']['result_status'];
			$comment = $original_data['CompetenceResult']['comment'];
			$emp_id_row = $this->CompetenceResult->query('select * from competence_results where id = '.$id);
			$emp_id = $emp_id_row[0]['competence_results']['employee_id'];
			$budget_year_id = $emp_id_row[0]['competence_results']['budget_year_id'];
			$quarter = $emp_id_row[0]['competence_results']['quarter'];

			//---------------------------------------------find the current status----------------------------------------------
			$prev_result_status = 1000;
			$current_status_row = $this->CompetenceResult->query('select * from competence_results where employee_id = '. $emp_id.' 
			and budget_year_id = '.$budget_year_id.' and quarter = '.$quarter);
			if(count($current_status_row) > 0){
				$prev_result_status = $current_status_row[0]['competence_results']['result_status'];
			}
			//--------------------------------------------end of finding the current status--------------------------------------
			//------------------------------------find first supervisor id---------------------------------------
			// $first_sup_id = 0;
			
			// 		$this->loadModel('Supervisor');
					
			// 		$first_sup_id_row = array();
			// 		$first_sup_id_row = $this->Supervisor->find('first', array('conditions' => array('Supervisor.emp_id' => $emp_id)));
			// 		if(count($first_sup_id_row) > 0){
			// 			$first_sup_id = $first_sup_id_row['Supervisor']['sup_emp_id'];
			// 		}
			// 		else {
			// 			$first_sup_id = 0;
			// 		}

			//----------------------------------end of find first supervisor id------------------------------------
			//-------------------------------------get grade first----------------------------------------------------
			if($prev_result_status < 2){
				$this->loadModel('EmployeeDetail');
				
				$grade_row = $this->EmployeeDetail->query('select * from employee_details where employee_id = '. $emp_id.' order by start_date desc');
						$grade_id = $grade_row[0]['employee_details']['grade_id'];
					//------------------------------------end of get grade first----------------------------------------------
				//----------------------------------check whether weight is 10------------------------------------------
						$this->loadModel('CompetenceSetting');
						$weight_row = $this->CompetenceSetting->query('select sum(weight) as sum_weight from competence_settings where grade_id = '.$grade_id );
						$sum_weight = $weight_row[0][0]['sum_weight'];
				//----------------------------------end of check whether weight is 10------------------------------------------
				//----------------------------------check whether count is equal to the setting--------------------------------
						$result_count_row = $this->CompetenceResult->query('select count(competence_id) as count_result from competence_results
						where employee_id = '.$emp_id.' and budget_year_id = '.$budget_year_id.' and quarter = '.$quarter );
						$result_count = $result_count_row[0][0]['count_result'];
		
						$setting_count_row = $this->CompetenceSetting->query('select count(competence_id) as count_setting from competence_settings where grade_id = '.$grade_id );
						$setting_count = $setting_count_row[0][0]['count_setting'];
				//----------------------------------check whether count is equal to the setting--------------------------------
				if($sum_weight == 10){
					if($result_count == $setting_count){
		
		
						$update_status = $this->CompetenceResult->query('update competence_results set  result_status = '.$result_status.', comment = "'.$comment.'" 
						where employee_id = '.$emp_id.' and quarter = '.$quarter.' and budget_year_id = '.$budget_year_id );
		
						$this->Session->setFlash(__('The status has been changed successfully', true), '');
						$this->render('/elements/success');
		
					}
					else {
						$this->Session->setFlash(__('The behavioural data is not complete.', true), '');
						 $this->render('/elements/failure3');
					}
		
				 }
				 else {
						 $this->Session->setFlash(__('The setting is not complete.', true), '');
						 $this->render('/elements/failure3');
				 }
			} else {
				$this->Session->setFlash(__('The status is either closed for change or is empty. Please contact HR department', true), '');
				$this->render('/elements/failure3');
			}
						
		}
		
		$this->set('competence_result', $this->CompetenceResult->read(null, $id)); // only the last competence result is enough
		
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
			

			if($direction == 1 || $direction == 6 || $direction == 8){ // incremental or sdt(standard delivery time)
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

	function recalculate($id = null) {
		
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
		// $emp_level = $this->emp_level($emp_id);
		$sup_id = $this->get_sup_id($emp_id);
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
//if($emp_level < 3){
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
	//-----------------------------------------first check if quarter 1 is ho or branch-----------------------------------
// 	$this->loadModel('BudgetYear');
// 	$conditions3 = array('BudgetYear.id' => $budget_year_id );
// 	$hoBudgetYear = $this->BudgetYear->find('first', array('conditions' => $conditions3));	

// 	$this->loadModel('Branch');
// $this->loadModel('Position');
// 		$from_date = $hoBudgetYear['BudgetYear']['from_date'];
// 		$to_date = $hoBudgetYear['BudgetYear']['to_date'];
//     	$branch_id_for_quarter_row1 = $this->get_each_quarter_position($emp_id, $from_date, $to_date , 1 );
// 		if(count($branch_id_for_quarter_row1) > 0){
// 			$position_q1 = $branch_id_for_quarter_row1[0]['employee_details']['position_id'];
// 			$branch_q1 = $branch_id_for_quarter_row1[0]['employee_details']['branch_id'];
// 			$branch_type_row1 =  $this->Branch->query('select * from branches 
// 	        where id = '. $branch_q1 .' ');
//   	        $branch_type1 = $branch_type_row1[0]['branches']['branch_category_id'];
// 			if($branch_type1 == 1){  // means he/she was in branch
// 				$result_array3= $this->find_branch_result($emp_id , $budget_year_id,  $from_date , $to_date , $position_q1, $branch_q1, 1);
// 				// $one_row['quarter1'] = $result_array1['technical'];
// 				$quarter_one_both_technical_percent = $result_array3['technical'];
// 				$semiannual_technical = ($both_technical_percent + $quarter_one_both_technical_percent) / 2;
				
// 			}
// 			else { // means he/she has been in or not head office but doesn't have any record
				
// 				$quarter_one_both_technical_percent = 0;
// 				$semiannual_technical = $both_technical_percent;
				
// 			}

// 		} else { // means he/she wasn't in branch
// 			$quarter_one_both_technical_percent = 0;
// 			$semiannual_technical = $both_technical_percent;
// 		}
		
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
//	$semiannual_average = ($both_technical_percent) * 0.9;
	//-----------------------------------------first check if quarter 3 is ho or branch-----------------------------------
// 	$this->loadModel('BudgetYear');
// 	$conditions3 = array('BudgetYear.id' => $budget_year_id );
// 	$hoBudgetYear = $this->BudgetYear->find('first', array('conditions' => $conditions3));	

// 	$this->loadModel('Branch');
// $this->loadModel('Position');
// 		$from_date = $hoBudgetYear['BudgetYear']['from_date'];
// 		$to_date = $hoBudgetYear['BudgetYear']['to_date'];
//     	$branch_id_for_quarter_row3 = $this->get_each_quarter_position($emp_id, $from_date, $to_date , 3 );
// 		if(count($branch_id_for_quarter_row3) > 0){
// 			$position_q3 = $branch_id_for_quarter_row3[0]['employee_details']['position_id'];
// 			$branch_q3 = $branch_id_for_quarter_row3[0]['employee_details']['branch_id'];
// 			$branch_type_row3 =  $this->Branch->query('select * from branches 
// 	        where id = '. $branch_q3 .' ');
//   	        $branch_type3 = $branch_type_row3[0]['branches']['branch_category_id'];
// 			if($branch_type3 == 1){  // means he/she was in branch
// 				$result_array3= $this->find_branch_result($emp_id , $budget_year_id,  $from_date , $to_date , $position_q3, $branch_q3, 3);
// 				// $one_row['quarter1'] = $result_array1['technical'];
// 				$quarter_three_both_technical_percent = $result_array3['technical'];
// 				$semiannual_technical = ($both_technical_percent + $quarter_three_both_technical_percent) / 2;
				
// 			}
// 			else { // means he/she has been in or not head office but doesn't have any record
				
// 				$quarter_three_both_technical_percent = 0;
// 				$semiannual_technical = $both_technical_percent;
				
// 			}

// 		} else { // means he/she wasn't in branch
// 			$quarter_three_both_technical_percent = 0;
// 			$semiannual_technical = $both_technical_percent;
// 		}
		
//----------------------------------------end of check if quarter 3 is ho or branch-----------------------------------
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
			where employee_id = -1 order by start_date' );
	}

	return $position_id_for_quarter_row;

	}

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
			employee_id = '.  $e_id. ' and budget_year_id = '.$budget_year_id. ' and quarter =  '.$q);
		

			if($behavioural_total_row[0][0]['sum_rating'] != null){
				$behavioural_total = $behavioural_total_row[0][0]['sum_rating'];
			}

		  }


		 $result_array["behavioural"] = $behavioural_total;



		 return $result_array;

		 
		 }



		 
	function ho_my_performance_report() {
		$this_user = $this->Session->read();
		$this_user_id = $this_user['Auth']['User']['id'];
		$this->loadModel('Employee');
		// $this_user_id = 3135;
		// $this_user_id = 1225;
		 $subordinate_ids = array();
		 $this_id = 0;
		 $this_id_row = $this->Employee->query('select * from employees where user_id = '.$this_user_id);
		 if(count($this_id_row) > 0){
		  $this_id = $this_id_row[0]['employees']['id'];
        $emp_id = $this_id_row[0]['employees']['card'];
		}
		// $emp_id = 3915 ;
		$e_id = $this_id;
		$full_name = '' ;
		$position_name = '' ;

		// get position
		
		$this->loadModel('EmployeeDetail');
		$this->loadModel('Position');
		$position_id_row = $this->EmployeeDetail->query('select * from employee_details 
				where employee_id = '. $e_id .' order by start_date desc');
		$position_id = $position_id_row[0]['employee_details']['position_id'];
		$branch_id = $position_id_row[0]['employee_details']['branch_id'];
		$position_name_row = $this->Position->query('select * from positions
		where id = '. $position_id .' ');
		$position_name = $position_name_row[0]['positions']['name'];
		// end of get positions
		// get employee_name
		
		$this->loadModel('User');
		$this->loadModel('Person');
		// $emps = array();
		 
		  $emp_row = $this->Employee->query('select * from employees where id = '.$e_id.'');
		  
		  $user_id = $emp_row[0]['employees']['user_id'];
		  $user_row = $this->User->query('select * from users where id = '. $user_id);
		 if(count($user_row) > 0){
			$person_id = $user_row[0]['users']['person_id'];
			$person_row = $this->Person->query('select * from people where id = '. $person_id);
			$full_name = $person_row[0]['people']['first_name'].' '.$person_row[0]['people']['middle_name'].' '.$person_row[0]['people']['last_name'];
		 }
		
		// end of get employee_name

		// get department/district

		$this->loadModel('Branch');
		$branch_row = $this->Employee->query('select * from branches where id = '.$branch_id.'');
		$dept_name = $branch_row[0]['branches']['name'];

		// end of get department/district
		// get the budget years applicable for the employee-----------------------------------------------------
		  $hired_date_row =  $this->EmployeeDetail->query('select * from employee_details 
		  where employee_id = '. $e_id .' order by start_date');
		  $hired_date = $hired_date_row[0]['employee_details']['start_date'];
		  $this->loadModel('BudgetYear');
		  $first_budget_year_row =  $this->BudgetYear->query('select * from budget_years 
		  where from_date <= "'. $hired_date .'" and to_date >= "'.$hired_date.'"');
		  
		  $first_budget_year_id = $first_budget_year_row[0]['budget_years']['id'];
		  $report_table = array();
		  $one_row = array();
		  $budget_years = array();
		  $all_budget_years_row = $this->BudgetYear->query('select * from budget_years 
		  where id >= '.$first_budget_year_id);

		
	foreach($all_budget_years_row as $item){
	//--now decide the position and branch he/she worked in each quarter---------------------------------------------------------
	       $from_date = $item["budget_years"]["from_date"];
		   $to_date = $item["budget_years"]["to_date"];
		   

	//-----start with the first quarter---------------------------------------------------------------------------------------
	$position_id_for_quarter1_row = $this->get_each_quarter_position($e_id, $from_date, $to_date , 1 );
	$position_id_for_quarter2_row = $this->get_each_quarter_position($e_id, $from_date, $to_date , 2 );
	$position_id_for_quarter3_row = $this->get_each_quarter_position($e_id, $from_date, $to_date , 3 );
	$position_id_for_quarter4_row = $this->get_each_quarter_position($e_id, $from_date, $to_date , 4 );


	//----------------------start of preparing the report table ----------------------------------
	$one_row['budget_year'] = 0;
	$conditions3 = array('BudgetYear.id' => $item["budget_years"]['id'] );
				$hoPlan3 = $this->BudgetYear->find('first', array('conditions' => $conditions3));
				$one_row['budget_year']  = $hoPlan3['BudgetYear']['name'];
				$one_row['quarter1'] = 0;
				$one_row['quarter2'] = 0;
				$one_row['semi_annual_technical_1'] = 0; // this is 
				$one_row['behavioural_1'] = 0;
				$one_row['semi_annual_result_1'] = 0; // this is 
				$one_row['quarter3'] = 0;
				$one_row['quarter4'] = 0;
				$one_row['semi_annual_technical_2'] = 0;
				$one_row['behavioural_2'] = 0;
				$one_row['semi_annual_result_2'] = 0; // this is 
				
				$one_row['annual_average'] = 0;

//------------------------------start for the first quarter----------------------------------------------------------

if(count($position_id_for_quarter1_row) > 0){
	$position_q1 = $position_id_for_quarter1_row[0]["employee_details"]["position_id"];
	$branch_q1 = $position_id_for_quarter1_row[0]["employee_details"]["branch_id"];

 $branch_type_row1 =  $this->Branch->query('select * from branches 
   where id = '. $branch_q1 .' ');
 $branch_type1 = $branch_type_row1[0]['branches']['branch_category_id'];
 if($branch_type1 == 1){ //means it is branch 
	$result_array1= $this->find_branch_result($e_id , $item["budget_years"]['id'],  $from_date , $to_date , $position_q1, $branch_q1, 1);
	$one_row['quarter1'] = $result_array1['technical'];
	
 }
 else { //means it is not branch
	
	 $hoPlan1 = $this->HoPerformancePlan->query('select * from ho_performance_plans 
 where employee_id = '. $e_id .' and budget_year_id = '.$item["budget_years"]['id'].' and quarter = 1');
 if(count($hoPlan1) > 0){
	$one_row['quarter1'] = $hoPlan1[0]['ho_performance_plans']['both_technical_percent'];
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
	$branch_type2 = $branch_type_row2[0]['branches']['branch_category_id'];
	if($branch_type2 == 1){ //means it is branch
		$result_array2 = $this->find_branch_result($e_id , $item["budget_years"]['id'],  $from_date , $to_date , $position_q2,$branch_q2, 2);
	$one_row['quarter2'] = $result_array2['technical'];
	if($one_row['quarter1'] == 0){
		$one_row['semi_annual_technical_1'] = ($one_row['quarter2']) * 0.9;
	}
	else{
		$one_row['semi_annual_technical_1'] = (($one_row['quarter1'] + $one_row['quarter2'])/2) * 0.9;
	}
	
	$one_row['behavioural_1'] = ($result_array2['behavioural'] / 20) * 0.5;
	$one_row['semi_annual_result_1'] = $one_row['semi_annual_technical_1'] + $one_row['behavioural_1'];

	
	}
	else { //means it is not branch
	 $hoPlan2 = $this->HoPerformancePlan->query('select * from ho_performance_plans 
	where employee_id = '. $e_id .' and budget_year_id = '.$item["budget_years"]['id'].' and quarter = 2');

	if(count($hoPlan2) > 0){
		$one_row['quarter2'] =  $hoPlan2[0]['ho_performance_plans']['both_technical_percent'];
		//$one_row['semi_annual_technical_1'] = $hoPlan2[0]['ho_performance_plans']['semiannual_technical'];
		if($one_row['quarter1'] == 0){
			$one_row['semi_annual_technical_1'] = ($one_row['quarter2']) * 0.9;
		}
		else{
			$one_row['semi_annual_technical_1'] = (($one_row['quarter1'] + $one_row['quarter2'])/2) * 0.9;
		}
		
		$one_row['behavioural_1'] = $hoPlan2[0]['ho_performance_plans']['behavioural_percent'];
		//$one_row['semi_annual_result_1'] = $hoPlan2[0]['ho_performance_plans']['semiannual_average'];
		$one_row['semi_annual_result_1'] = $one_row['semi_annual_technical_1'] + $one_row['behavioural_1'];
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
	$branch_type3 = $branch_type_row3[0]['branches']['branch_category_id'];
	if($branch_type3 == 1){ //means it is branch
		$result_array3= $this->find_branch_result($e_id , $item["budget_years"]['id'],  $from_date , $to_date , $position_q3, $branch_q3, 3);
		$one_row['quarter3'] = $result_array3['technical'];
  
	}
	else { //means it is not branch
	 $hoPlan3 = $this->HoPerformancePlan->query('select * from ho_performance_plans 
	where employee_id = '. $e_id .' and budget_year_id = '.$item["budget_years"]['id'].' and quarter = 3');
	if(count($hoPlan3) > 0){
		$one_row['quarter3'] = $hoPlan3[0]['ho_performance_plans']['both_technical_percent'];
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
	$branch_type4 = $branch_type_row4[0]['branches']['branch_category_id'];
	if($branch_type4 == 1){ //means it is branch
		$result_array4 = $this->find_branch_result($e_id , $item["budget_years"]['id'],  $from_date , $to_date , $position_q4,$branch_q4, 4);
	$one_row['quarter4'] = $result_array4['technical'];
	if($one_row['quarter3'] == 0){
		$one_row['semi_annual_technical_2'] = ($one_row['quarter4']) * 0.9;
	}else{
		$one_row['semi_annual_technical_2'] = (($one_row['quarter3'] + $one_row['quarter4'])/2) * 0.9;
	}
	
	$one_row['behavioural_2'] = ($result_array4['behavioural']/20) * 0.5;
	$one_row['semi_annual_result_2'] = $one_row['semi_annual_technical_2'] + $one_row['behavioural_2'];
	}
	else { //means it is not branch
	 $hoPlan4 = $this->HoPerformancePlan->query('select * from ho_performance_plans 
	where employee_id = '. $e_id .' and budget_year_id = '.$item["budget_years"]['id'].' and quarter = 4');
	if(count($hoPlan4) > 0){
		$one_row['quarter4'] =  $hoPlan4[0]['ho_performance_plans']['both_technical_percent'];
		// $one_row['semi_annual_technical_2'] = $hoPlan4[0]['ho_performance_plans']['semiannual_technical'];
		if($one_row['quarter3'] == 0){
			$one_row['semi_annual_technical_2'] = ($one_row['quarter4'] ) * 0.9;
		}
		else{
			$one_row['semi_annual_technical_2'] = (($one_row['quarter3'] + $one_row['quarter4'])/2) * 0.9;
		}
		
		$one_row['behavioural_2'] = $hoPlan4[0]['ho_performance_plans']['behavioural_percent'];
		//$one_row['semi_annual_result_2'] = $hoPlan4[0]['ho_performance_plans']['semiannual_average'];
		$one_row['semi_annual_result_2'] = $one_row['semi_annual_technical_2'] + $one_row['behavioural_2'];
	}

	}
}

//-------------------------------end of for the fourth quarter---------------------------------------------------------	   
//---------------------find yearly average---------------------------------------------------------
if($one_row['semi_annual_result_1'] > 0 && $one_row['semi_annual_result_2'] > 0){
	$one_row['annual_average'] = ($one_row['semi_annual_result_1'] + $one_row['semi_annual_result_2']) / 2 ;
}
//--------------------now add each row to the table---------------------------------------------

array_push($report_table, $one_row);

		  }


		// end of get the budget years applicable for the employee----------------------------------------------

	
		$this->set(compact ( 'emp_id' , 'position_name' ,'full_name', 'dept_name', 'report_table' ));
		
	}

		function ho_my_performance_history_list ($id = null) {  // first just show the list of plan periods
   
			$this_user = $this->Session->read();
				$this_user_id = $this_user['Auth']['User']['id'];
				$this->loadModel('Employee');
				// $this_user_id = 3135;
				// $this_user_id = 1225;
				 $subordinate_ids = array();
				 $idd = 0;
				 $this_id_row = $this->Employee->query('select * from employees where user_id = '.$this_user_id);
				 if(count($this_id_row) > 0){
				  $idd = $this_id_row[0]['employees']['id'];
				
				}
				
			//	$idd = 3915;
			//	$idd = 3487;

			$this->loadModel('Branch');
			$this->loadModel('EmployeeDetail');
		
			// get the budget years applicable for the employee-----------------------------------------------------
			$e_id = $idd;
			$hired_date_row =  $this->EmployeeDetail->query('select * from employee_details 
			where employee_id = '. $e_id .' order by start_date');
			$hired_date = $hired_date_row[0]['employee_details']['start_date'];
			$this->loadModel('BudgetYear');
			$first_budget_year_row =  $this->BudgetYear->query('select * from budget_years 
			where from_date <= "'. $hired_date .'" and to_date >= "'.$hired_date.'"');
			
			$first_budget_year_id = $first_budget_year_row[0]['budget_years']['id'];
			$report_table = array();
			$one_row = array();
			$budget_years = array();
			$all_budget_years_row = $this->BudgetYear->query('select * from budget_years 
			where id >= '.$first_budget_year_id);
			//----------------end of get the applicable years--------------------------------------------------------------
  	  //----------------------start of preparing the array ----------------------------------
      $ho_plan_ids = array();
			foreach($all_budget_years_row as $item){
      
				$from_date = $item["budget_years"]["from_date"];
				$to_date = $item["budget_years"]["to_date"];
		
		//-----start with the first quarter---------------------------------------------------------------------------------------
			$branch_id_for_quarter1_row = $this->get_each_quarter_position($e_id, $from_date, $to_date , 1 );
			$branch_id_for_quarter2_row = $this->get_each_quarter_position($e_id, $from_date, $to_date , 2 );
			$branch_id_for_quarter3_row = $this->get_each_quarter_position($e_id, $from_date, $to_date , 3 );
			$branch_id_for_quarter4_row = $this->get_each_quarter_position($e_id, $from_date, $to_date , 4 );
		
		
	
		
		
		//------------------------------start for the first quarter----------------------------------------------------------
		
		 if(count($branch_id_for_quarter1_row) > 0){
			
		$branch_q1 = $branch_id_for_quarter1_row[0]["employee_details"]["branch_id"];
		
		 $branch_type_row1 =  $this->Branch->query('select * from branches 
		   where id = '. $branch_q1 .' ');
		 $branch_type1 = $branch_type_row1[0]['branches']['branch_category_id'];
		 if($branch_type1 == 1){ //means it is branch
			// don't do anything
			
		 }
		 else { //means it is not branch so find the plan
			
			 $hoPlan1 = $this->HoPerformancePlan->query('select * from ho_performance_plans 
		 where employee_id = '. $e_id .' and budget_year_id = '.$item["budget_years"]['id'].' and quarter = 1');
		 if(count($hoPlan1) > 0){
		   
		   array_push($ho_plan_ids, $hoPlan1[0]['ho_performance_plans']['id']);
		 }
		
		 }
		 }
					   
		//-------------------------------end of for the first quarter---------------------------------------------------------
		//------------------------------start for the second quarter----------------------------------------------------------

if(count($branch_id_for_quarter2_row) > 0){
	
	$branch_q2 = $branch_id_for_quarter2_row[0]["employee_details"]["branch_id"];

 $branch_type_row2 =  $this->Branch->query('select * from branches 
   where id = '. $branch_q2 .' ');
 $branch_type2 = $branch_type_row2[0]['branches']['branch_category_id'];
 if($branch_type2 == 1){ //means it is branch
	// don't do anything
	
 }
 else { //means it is not branch so find the plan
	
	 $hoPlan2 = $this->HoPerformancePlan->query('select * from ho_performance_plans 
 where employee_id = '. $e_id .' and budget_year_id = '.$item["budget_years"]['id'].' and quarter = 2');
 if(count($hoPlan2) > 0){
 
	array_push($ho_plan_ids, $hoPlan2[0]['ho_performance_plans']['id']);
 
 }

 }
}
               
//-------------------------------end of for the second quarter---------------------------------------------------------
//------------------------------start for the third quarter----------------------------------------------------------

if(count($branch_id_for_quarter3_row) > 0){
	
	$branch_q3 = $branch_id_for_quarter3_row[0]["employee_details"]["branch_id"];

 $branch_type_row3 =  $this->Branch->query('select * from branches 
   where id = '. $branch_q3 .' ');
 $branch_type3 = $branch_type_row3[0]['branches']['branch_category_id'];
 if($branch_type3 == 1){ //means it is branch
	// don't do anything
	
 }
 else { //means it is not branch so find the plan

	 $hoPlan3 = $this->HoPerformancePlan->query('select * from ho_performance_plans 
 where employee_id = '. $e_id .' and budget_year_id = '.$item["budget_years"]['id'].' and quarter = 3');
 if(count($hoPlan3) > 0){
	array_push($ho_plan_ids, $hoPlan3[0]['ho_performance_plans']['id']);
 }

 }
}
               
//-------------------------------end of for the third quarter---------------------------------------------------------
//------------------------------start for the four quarter----------------------------------------------------------

if(count($branch_id_for_quarter4_row) > 0){
	
	$branch_q4 = $branch_id_for_quarter4_row[0]["employee_details"]["branch_id"];

 $branch_type_row4 =  $this->Branch->query('select * from branches 
   where id = '. $branch_q4 .' ');
 $branch_type4 = $branch_type_row4[0]['branches']['branch_category_id'];
 if($branch_type4 == 1){ //means it is branch
	// don't do anything
	
 }
 else { //means it is not branch so find the plan
	
	 $hoPlan4 = $this->HoPerformancePlan->query('select * from ho_performance_plans 
 where employee_id = '. $e_id .' and budget_year_id = '.$item["budget_years"]['id'].' and quarter = 4');
 if(count($hoPlan4) > 0){
	array_push($ho_plan_ids, $hoPlan4[0]['ho_performance_plans']['id']);
 }

 }

}
               
//-------------------------------end of for the four quarter---------------------------------------------------------
	}
 //echo count($ho_plan_ids);
	
				$start = (isset($_REQUEST['start'])) ? $_REQUEST['start'] : 0;
				$limit = (isset($_REQUEST['limit'])) ? $_REQUEST['limit'] : 5;
				
				$budgetyear_id = (isset($_REQUEST['budgetyear_id'])) ? $_REQUEST['budgetyear_id'] : -1;
				if($id)
					$budgetyear_id = ($id) ? $id : -1;
					$conditions = (isset($_REQUEST['conditions'])) ? $_REQUEST['conditions'] : '';
		
				eval("\$conditions = array( " . $conditions . " );");
				if ($budgetyear_id != -1) {
					$conditions['HoPerformancePlan.budget_year_id'] = $budgetyear_id;
				}
			//	$conditions['HoPerformancePlan.employee_id'] = $idd;
      
			 $conditions['HoPerformancePlan.id'] = $ho_plan_ids;
				// $conditions['HoPerformancePlan.plan_status'] = 2;
				//$emps = $this->get_emp_names();
		   //------------------------------------get emp name--------------------------------------------------------------------
				   // get employee_name
				
				  $this->loadModel('User');
				  $this->loadModel('Person');
				// $emps = array();
				 $full_name = '';
				  $emp_row = $this->Employee->query('select * from employees where id = '.$idd.'');
				  
				  $user_id = $emp_row[0]['employees']['user_id'];
				  $user_row = $this->User->query('select * from users where id = '. $user_id);
				 if(count($user_row) > 0){
					$person_id = $user_row[0]['users']['person_id'];
					$person_row = $this->Person->query('select * from people where id = '. $person_id);
					$full_name = $person_row[0]['people']['first_name'].' '.$person_row[0]['people']['middle_name'].' '.$person_row[0]['people']['last_name'];
				 }
				
				// end of get employee_name
		   //-------------------------------------end of get emp name--------------------------------------------------------------
			//	print_r($this->HoPerformancePlan->find('all', array('conditions' => $conditions, 'limit' => $limit, 'offset' => $start)));
				$this->set('hoPerformancePlans', $this->HoPerformancePlan->find('all', array('conditions' => $conditions, 'limit' => $limit, 'offset' => $start)));
				$this->set('results', $this->HoPerformancePlan->find('count', array('conditions' => $conditions)));
				$this->set('full_name', $full_name);
		
			}

	function br_my_performance_history_list($id = null){

		$this_user = $this->Session->read();
		$this_user_id = $this_user['Auth']['User']['id'];
		$this->loadModel('Employee');
		// $this_user_id = 3135;
		// $this_user_id = 1225;
		 $subordinate_ids = array();
		 $idd = 0;
		 $this_id_row = $this->Employee->query('select * from employees where user_id = '.$this_user_id);
		 if(count($this_id_row) > 0){
		  $idd = $this_id_row[0]['employees']['id'];
		
		}
		
	//	$idd = 3915;
	//	$idd = 3487;

	$this->loadModel('Branch');
	$this->loadModel('EmployeeDetail');

	// get the budget years applicable for the employee-----------------------------------------------------
	$e_id = $idd;
	$hired_date_row =  $this->EmployeeDetail->query('select * from employee_details 
	where employee_id = '. $e_id .' order by start_date');
	$hired_date = $hired_date_row[0]['employee_details']['start_date'];
	$this->loadModel('BudgetYear');
	$first_budget_year_row =  $this->BudgetYear->query('select * from budget_years 
	where from_date <= "'. $hired_date .'" and to_date >= "'.$hired_date.'"');
	
	$first_budget_year_id = $first_budget_year_row[0]['budget_years']['id'];
	// $report_table = array();
	// $one_row = array();
	// $budget_years = array();
	$all_budget_years_row = $this->BudgetYear->query('select * from budget_years 
	where id >= '.$first_budget_year_id);
	//----------------end of get the applicable years--------------------------------------------------------------
	$br_rows = array();

	foreach($all_budget_years_row as $item){
		$from_date = $item["budget_years"]["from_date"];
		$to_date = $item["budget_years"]["to_date"];

//-----start with the first quarter---------------------------------------------------------------------------------------
	$branch_id_for_quarter1_row = $this->get_each_quarter_position($e_id, $from_date, $to_date , 1 );
	$branch_id_for_quarter2_row = $this->get_each_quarter_position($e_id, $from_date, $to_date , 2 );
	$branch_id_for_quarter3_row = $this->get_each_quarter_position($e_id, $from_date, $to_date , 3 );
	$branch_id_for_quarter4_row = $this->get_each_quarter_position($e_id, $from_date, $to_date , 4 );


//----------------------start of preparing the array ----------------------------------
//$ho_plan_ids = array();


//------------------------------start for the first quarter----------------------------------------------------------

 if(count($branch_id_for_quarter1_row) > 0){
	
$branch_q1 = $branch_id_for_quarter1_row[0]["employee_details"]["branch_id"];

 $branch_type_row1 =  $this->Branch->query('select * from branches 
   where id = '. $branch_q1 .' ');
 $branch_type1 = $branch_type_row1[0]['branches']['branch_category_id'];
 // echo $branch_type1.'<br>';
 if($branch_type1 == 1){ //means it is branch
	
	$plan = array();
	$plan["employee_id"] = $e_id;
	$plan["budget_year_id"] =  $item["budget_years"]["id"];
	$plan["budget_year"] = $item["budget_years"]["name"];
	$plan["quarter"] = 1;
	//$plan[""]
	array_push($br_rows, $plan);
 }
 else { //means it is not branch 
	
// do nothing

 }
 }
			   
//-------------------------------end of for the first quarter---------------------------------------------------------
//------------------------------start for the second quarter----------------------------------------------------------

if(count($branch_id_for_quarter2_row) > 0){

$branch_q2 = $branch_id_for_quarter2_row[0]["employee_details"]["branch_id"];

$branch_type_row2 =  $this->Branch->query('select * from branches 
where id = '. $branch_q2 .' ');
$branch_type2 = $branch_type_row2[0]['branches']['branch_category_id'];
if($branch_type2 == 1){ //means it is branch
	$plan = array();
	$plan["employee_id"] = $e_id;
	$plan["budget_year_id"] =  $item["budget_years"]["id"];
	$plan["budget_year"] = $item["budget_years"]["name"];
	$plan["quarter"] = 2;
	//$plan[""]
	array_push($br_rows, $plan);

}
else { //means it is not branch so find the plan

// do nothing
}
}
	   
//-------------------------------end of for the second quarter---------------------------------------------------------
//------------------------------start for the third quarter----------------------------------------------------------

if(count($branch_id_for_quarter3_row) > 0){

$branch_q3 = $branch_id_for_quarter3_row[0]["employee_details"]["branch_id"];

$branch_type_row3 =  $this->Branch->query('select * from branches 
where id = '. $branch_q3 .' ');
$branch_type3 = $branch_type_row3[0]['branches']['branch_category_id'];
if($branch_type3 == 1){ //means it is branch
	$plan = array();
	$plan["employee_id"] = $e_id;
	$plan["budget_year_id"] =  $item["budget_years"]["id"];
	$plan["budget_year"] = $item["budget_years"]["name"];
	$plan["quarter"] = 3;
	//$plan[""]
	array_push($br_rows, $plan);

}
else { //means it is not branch so find the plan

// do nothing
}
}
	   
//-------------------------------end of for the third quarter---------------------------------------------------------
//------------------------------start for the four quarter----------------------------------------------------------

if(count($branch_id_for_quarter4_row) > 0){

$branch_q4 = $branch_id_for_quarter4_row[0]["employee_details"]["branch_id"];

$branch_type_row4 =  $this->Branch->query('select * from branches 
where id = '. $branch_q4 .' ');
$branch_type4 = $branch_type_row4[0]['branches']['branch_category_id'];
if($branch_type4 == 1){ //means it is branch
	$plan = array();
	$plan["employee_id"] = $e_id;
	$plan["budget_year_id"] =  $item["budget_years"]["id"];
	$plan["budget_year"] = $item["budget_years"]["name"];
	$plan["quarter"] = 4;
	//$plan[""]
	array_push($br_rows, $plan);

}
else { //means it is not branch so find the plan

// do nothing

}

}
	   
//-------------------------------end of for the four quarter---------------------------------------------------------
}

		// $start = (isset($_REQUEST['start'])) ? $_REQUEST['start'] : 0;
		// $limit = (isset($_REQUEST['limit'])) ? $_REQUEST['limit'] : 5;
		
		// $budgetyear_id = (isset($_REQUEST['budgetyear_id'])) ? $_REQUEST['budgetyear_id'] : -1;
		// if($id)
		// 	$budgetyear_id = ($id) ? $id : -1;
		// 	$conditions = (isset($_REQUEST['conditions'])) ? $_REQUEST['conditions'] : '';

		// eval("\$conditions = array( " . $conditions . " );");
		// if ($budgetyear_id != -1) {
		// 	$conditions['HoPerformancePlan.budget_year_id'] = $budgetyear_id;
		// }
	//	$conditions['HoPerformancePlan.employee_id'] = $idd;
	// $conditions['HoPerformancePlan.id'] = $ho_plan_ids;
		// $conditions['HoPerformancePlan.plan_status'] = 2;
		//$emps = $this->get_emp_names();
   //------------------------------------get emp name--------------------------------------------------------------------
		   // get employee_name
		
		  $this->loadModel('User');
		  $this->loadModel('Person');
		// $emps = array();
		 $full_name = '';
		  $emp_row = $this->Employee->query('select * from employees where id = '.$idd.'');
		  
		  $user_id = $emp_row[0]['employees']['user_id'];
		  $user_row = $this->User->query('select * from users where id = '. $user_id);
		 if(count($user_row) > 0){
			$person_id = $user_row[0]['users']['person_id'];
			$person_row = $this->Person->query('select * from people where id = '. $person_id);
			$full_name = $person_row[0]['people']['first_name'].' '.$person_row[0]['people']['middle_name'].' '.$person_row[0]['people']['last_name'];
		 }
		
		// end of get employee_name
   //-------------------------------------end of get emp name--------------------------------------------------------------
	//	print_r($this->HoPerformancePlan->find('all', array('conditions' => $conditions, 'limit' => $limit, 'offset' => $start)));
	//	$this->set('hoPerformancePlans', $this->HoPerformancePlan->find('all', array('conditions' => $conditions, 'limit' => $limit, 'offset' => $start)));
		$this->set('brPerformancePlans' , $br_rows);
	// $this->set('results', $this->HoPerformancePlan->find('count', array('conditions' => $conditions)));
		$this->set('results', count($br_rows));
		$this->set('full_name', $full_name);
	//	print_r($br_rows);
	// print_r($all_budget_years_row);
//	echo count($br_rows); 
	}

	function ho_my_performance_history_list3 ($id = null) {  // first just show the list of plan periods
   
    $this_user = $this->Session->read();
		$this_user_id = $this_user['Auth']['User']['id'];
		$this->loadModel('Employee');
		// $this_user_id = 3135;
		// $this_user_id = 1225;
		 $subordinate_ids = array();
		 $idd = 0;
		 $this_id_row = $this->Employee->query('select * from employees where user_id = '.$this_user_id);
		 if(count($this_id_row) > 0){
		  $idd = $this_id_row[0]['employees']['id'];
        
		}
		
	//	$idd = 3915;
	//	$idd = 3487;

		$start = (isset($_REQUEST['start'])) ? $_REQUEST['start'] : 0;
		$limit = (isset($_REQUEST['limit'])) ? $_REQUEST['limit'] : 5;
		
		$budgetyear_id = (isset($_REQUEST['budgetyear_id'])) ? $_REQUEST['budgetyear_id'] : -1;
		if($id)
			$budgetyear_id = ($id) ? $id : -1;
        	$conditions = (isset($_REQUEST['conditions'])) ? $_REQUEST['conditions'] : '';

        eval("\$conditions = array( " . $conditions . " );");
		if ($budgetyear_id != -1) {
            $conditions['HoPerformancePlan.budget_year_id'] = $budgetyear_id;
        }
		$conditions['HoPerformancePlan.employee_id'] = $idd;
		// $conditions['HoPerformancePlan.plan_status'] = 2;
		//$emps = $this->get_emp_names();
   //------------------------------------get emp name--------------------------------------------------------------------
   		// get employee_name
		
		  $this->loadModel('User');
		  $this->loadModel('Person');
		// $emps = array();
		 $full_name = '';
		  $emp_row = $this->Employee->query('select * from employees where id = '.$idd.'');
		  
		  $user_id = $emp_row[0]['employees']['user_id'];
		  $user_row = $this->User->query('select * from users where id = '. $user_id);
		 if(count($user_row) > 0){
			$person_id = $user_row[0]['users']['person_id'];
			$person_row = $this->Person->query('select * from people where id = '. $person_id);
			$full_name = $person_row[0]['people']['first_name'].' '.$person_row[0]['people']['middle_name'].' '.$person_row[0]['people']['last_name'];
		 }
		
		// end of get employee_name
   //-------------------------------------end of get emp name--------------------------------------------------------------
	//	print_r($this->HoPerformancePlan->find('all', array('conditions' => $conditions, 'limit' => $limit, 'offset' => $start)));
		$this->set('hoPerformancePlans', $this->HoPerformancePlan->find('all', array('conditions' => $conditions, 'limit' => $limit, 'offset' => $start)));
		$this->set('results', $this->HoPerformancePlan->find('count', array('conditions' => $conditions)));
		$this->set('full_name', $full_name);

	}

	function ho_my_performance_history_index() {
		$budget_years = $this->HoPerformancePlan->BudgetYear->find('all');
		$this->set(compact('budget_years'));
	}
	function br_my_performance_history_index(){
		$budget_years = $this->HoPerformancePlan->BudgetYear->find('all');
		$this->set(compact('budget_years'));
	}

	function ho_my_objectives_report($ho_plan_id = null) {  //means the technical and training

	//	$emp_id = 3915 ;
		$full_name = '' ;
		$position_name = '' ;
		$dept_name = '';
		$appraisal_period = '';
		$immediate_supervisor_name = 'no name';
		$score_summary = 0;
		$summarized_score = 0;
		$training1 = '';
		$training2 = '';
		$training3 = '';
		$actual_total_weight = 0;
//		$emps = $this->get_emp_names();
// find quarter, budget_year, emp_id ------------------------------------------------------------------------------------
$ho_plan_row = $this->HoPerformancePlan->query('select * from ho_performance_plans where id = '.$ho_plan_id.'');
$quarter = $ho_plan_row[0]['ho_performance_plans']['quarter'];
$summarized_score = $ho_plan_row[0]['ho_performance_plans']['both_technical_percent'];
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
 $e_id = $ho_plan_row[0]['ho_performance_plans']['employee_id'];
 $budget_year_id = $ho_plan_row[0]['ho_performance_plans']['budget_year_id'];
 $quarter = $ho_plan_row[0]['ho_performance_plans']['quarter'];
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
	$position_id_row = $this->EmployeeDetail->query('select * from employee_details 
			where employee_id = '. $e_id .' order by start_date desc');
	$position_id = $position_id_row[0]['employee_details']['position_id'];
	$branch_id = $position_id_row[0]['employee_details']['branch_id'];
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
$this->loadModel('HoPerformanceDetail');	

		$objective_table = array();
		$obj_one_row = array();
	    

		$hoPlanObj = $this->HoPerformanceDetail->query('select * from ho_performance_details 
			where ho_performance_plan_id = '. $ho_plan_id .' ');

		 for($j = 0; $j < count($hoPlanObj) ; $j++){
			$actual_total_weight +=  $hoPlanObj[$j]['ho_performance_details']['weight'];

			$obj_one_row['objective'] = $hoPlanObj[$j]['ho_performance_details']['objective'];
			$obj_one_row['perspective'] = $hoPlanObj[$j]['ho_performance_details']['perspective'];
			$obj_one_row['kpis'] = $hoPlanObj[$j]['ho_performance_details']['plan_description'];
			$obj_one_row['measure'] = $hoPlanObj[$j]['ho_performance_details']['measure'];
			$obj_one_row['weight'] = $hoPlanObj[$j]['ho_performance_details']['weight'];
			$obj_one_row['plan'] = $hoPlanObj[$j]['ho_performance_details']['plan_in_number'];
			$obj_one_row['actual'] = $hoPlanObj[$j]['ho_performance_details']['actual_result'];
			$obj_one_row['accomplishment'] = $hoPlanObj[$j]['ho_performance_details']['accomplishment'];
			$obj_one_row['total_score'] = $hoPlanObj[$j]['ho_performance_details']['total_score'];
			$obj_one_row['final_score'] = $hoPlanObj[$j]['ho_performance_details']['final_score'];
			$score_summary += $hoPlanObj[$j]['ho_performance_details']['final_score'];
			array_push($objective_table, $obj_one_row);

		 }
		 //-----------------find supervisor id-------------------------------------------------------------------------------
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
		'appraisal_period' ,'training1', 'training2', 'training3', 'score_summary','summarized_score','actual_total_weight', 'ho_plan_id' ));
		
	}

	function br_my_objectives_report($br_plan_id = null) {  //means the technical and training
		
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
		$total_weight += $item['branch_performance_settings']['weight'];
		$each_total_goal = 0;
		$each_total_rating = 0;
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
      
      'e_id','budget_year_id','quarter', 'total_weight' ));
			
		}

 function br_my_sum_objectives_report($br_plan_id = null) {  //means the technical and training
		
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
			$total_weight += $item['branch_performance_settings']['weight'];
			$each_total_goal = 0;
			$each_total_rating = 0;
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
					$score_summary_aggregate = round(0.75*($branch_result) + 0.25*($score_summary * 100 / $total_weight) ,2 );
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
		//	echo $br_plan_id;
		       // $br_plan_id = str_replace('-','&', $br_plan_id);
			  // $br_plan_id = "hello";
			//   $e_id = $br_plan_id_array[0];
			//   $budget_year_id = $br_plan_id_array[1];
			//   $quarter = $br_plan_id_array[2];
		
			
				$this->set(compact ('objective_table', 'emp_id' , 'position_name' ,'full_name', 'dept_name', 'immediate_supervisor_name',
				'appraisal_period' ,'training1', 'training2', 'training3', 'score_summary','score_summary_aggregate','branch_result', 
				'e_id','budget_year_id','quarter','total_weight' ));
				
			}

	function ho_my_behavioural_report($ho_plan_id = null) {  //means the technical and training

	//	$emp_id = 3915 ;
		$full_name = '' ;
		$position_name = '' ;
		$dept_name = '';
		$appraisal_period = '';
		$immediate_supervisor_name = 'no name';
		$rating_summary = 0;
		$total_rating = 0;
		$quarter = 1;
		$data_exists = 0; //boolean
		$competence_result_id = -1;
		
//		$emps = $this->get_emp_names();
// find quarter, budget_year, emp_id ------------------------------------------------------------------------------------
$ho_plan_row = $this->HoPerformancePlan->query('select * from ho_performance_plans where id = '.$ho_plan_id.'');
$quarter = $ho_plan_row[0]['ho_performance_plans']['quarter'];
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
 $e_id = $ho_plan_row[0]['ho_performance_plans']['employee_id'];
 $budget_year_id = $ho_plan_row[0]['ho_performance_plans']['budget_year_id'];
 $quarter = $ho_plan_row[0]['ho_performance_plans']['quarter'];
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
	$position_id_row = $this->EmployeeDetail->query('select * from employee_details 
			where employee_id = '. $e_id .' order by start_date desc');
	$position_id = $position_id_row[0]['employee_details']['position_id'];
	$branch_id = $position_id_row[0]['employee_details']['branch_id'];
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
$this->loadModel('CompetenceResult');	
$this->loadModel('Competences');
$this->loadModel('CompetenceSetting');
$this->loadModel('EmployeeDetail');

 
 
 

		$behavioural_table = array();
		$bh_one_row = array();
	    

		$hoPlanBh = $this->CompetenceResult->query('select * from competence_results 
			where budget_year_id = '. $budget_year_id .' and quarter = '.$quarter.' and employee_id = '.$e_id);

		 for($j = 0; $j < count($hoPlanBh) ; $j++){
			$data_exists = 1;
			$competence_result_id = $hoPlanBh[$j]['competence_results']['id'];
			$competence_id = $hoPlanBh[$j]['competence_results']['competence_id'];

			$competence_name_row = $this->Competences->query('select * from competences 
			where id = '. $competence_id );

			$bh_one_row['competency'] = $competence_name_row[0]['competences']['name'];
			$bh_one_row['competency_definition'] = $competence_name_row[0]['competences']['definition'];

			$grade_row = $this->EmployeeDetail->query('select * from employee_details where employee_id = '. $e_id. ' order by start_date desc');
			$grade_id = $grade_row[0]['employee_details']['grade_id'];

			$competence_setting_row = $this->CompetenceSetting->query('select * from competence_settings 
			where competence_id = '. $competence_id.' and grade_id = '.$grade_id );

			$bh_one_row['expected_proficiency_level'] = $competence_setting_row[0]['competence_settings']['expected_competence'];
			$bh_one_row['weight'] = $competence_setting_row[0]['competence_settings']['weight'];
			$bh_one_row['actual_proficiency'] = $hoPlanBh[$j]['competence_results']['actual_competence'];
			$bh_one_row['score'] = $hoPlanBh[$j]['competence_results']['score'];
			$bh_one_row['rating'] = $hoPlanBh[$j]['competence_results']['rating'];
			
			$rating_summary += $hoPlanBh[$j]['competence_results']['rating'];   // this is out of 0.2 change it to 0.5

			array_push($behavioural_table, $bh_one_row);

		 }

		 $total_rating = ($rating_summary/20)*0.5;
		 //-----------------find supervisor id-------------------------------------------------------------------------------
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
	
    //-------------------halt halt halt halt halt halt halt-----------------------------------------------------------
	
	
		$this->set(compact ('behavioural_table', 'emp_id' , 'position_name' ,'full_name', 'dept_name', 'immediate_supervisor_name',
		'quarter', 'data_exists','appraisal_period' , 'total_rating', 'ho_plan_id', 'competence_result_id' ));
		
	}
	
	function br_my_behavioural_report($br_plan_id = null) {  //means the technical and training

		$br_plan_id_array = explode("-",$br_plan_id);

		$e_id = $br_plan_id_array[0];
		$budget_year_id = $br_plan_id_array[1];
		$quarter = $br_plan_id_array[2];

		//	$emp_id = 3915 ;
			$full_name = '' ;
			$position_name = '' ;
			$dept_name = '';
			$appraisal_period = '';
			$immediate_supervisor_name = 'no name';
			$rating_summary = 0;
			$total_rating = 0;
			// $quarter = 1;
			$data_exists = 0; //boolean
			$competence_result_id = -1;
			
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
	//  $e_id = $ho_plan_row[0]['ho_performance_plans']['employee_id'];
	//  $budget_year_id = $ho_plan_row[0]['ho_performance_plans']['budget_year_id'];
	//  $quarter = $ho_plan_row[0]['ho_performance_plans']['quarter'];

    

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
		$position_id_row = $this->EmployeeDetail->query('select * from employee_details 
				where employee_id = '. $e_id .' order by start_date desc');
		$position_id = $position_id_row[0]['employee_details']['position_id'];
		$branch_id = $position_id_row[0]['employee_details']['branch_id'];
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
	$this->loadModel('CompetenceResult');	
	$this->loadModel('Competences');
	$this->loadModel('CompetenceSetting');
	$this->loadModel('EmployeeDetail');
	
	 
	 
	 
	
			$behavioural_table = array();
			$bh_one_row = array();
			
	
			$hoPlanBh = $this->CompetenceResult->query('select * from competence_results 
				where budget_year_id = '. $budget_year_id .' and quarter = '.$quarter.' and employee_id = '.$e_id);
	
			 for($j = 0; $j < count($hoPlanBh) ; $j++){
				$data_exists = 1;
				$competence_result_id = $hoPlanBh[$j]['competence_results']['id'];
				$competence_id = $hoPlanBh[$j]['competence_results']['competence_id'];
	
				$competence_name_row = $this->Competences->query('select * from competences 
				where id = '. $competence_id );
	
				$bh_one_row['competency'] = $competence_name_row[0]['competences']['name'];
				$bh_one_row['competency_definition'] = $competence_name_row[0]['competences']['definition'];
	
				$grade_row = $this->EmployeeDetail->query('select * from employee_details where employee_id = '. $e_id. ' order by start_date desc');
				$grade_id = $grade_row[0]['employee_details']['grade_id'];
	
				$competence_setting_row = $this->CompetenceSetting->query('select * from competence_settings 
				where competence_id = '. $competence_id.' and grade_id = '.$grade_id );
	
				$bh_one_row['expected_proficiency_level'] = $competence_setting_row[0]['competence_settings']['expected_competence'];
				$bh_one_row['weight'] = $competence_setting_row[0]['competence_settings']['weight'];
				$bh_one_row['actual_proficiency'] = $hoPlanBh[$j]['competence_results']['actual_competence'];
				$bh_one_row['score'] = $hoPlanBh[$j]['competence_results']['score'];
				$bh_one_row['rating'] = $hoPlanBh[$j]['competence_results']['rating'];
				
				$rating_summary += $hoPlanBh[$j]['competence_results']['rating'];   // this is out of 0.2 change it to 0.5
	
				array_push($behavioural_table, $bh_one_row);
	
			 }
	
			 $total_rating = ($rating_summary/20)*0.5;
			 //-----------------find supervisor id-------------------------------------------------------------------------------
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
		
		//-------------------halt halt halt halt halt halt halt-----------------------------------------------------------
		
		
			$this->set(compact ('behavioural_table', 'emp_id' , 'position_name' ,'full_name', 'dept_name', 'immediate_supervisor_name',
			'quarter', 'data_exists','appraisal_period' , 'total_rating', 'ho_plan_id', 'competence_result_id' ));
			
		}

	function delete($id = null) {
		$this->autoRender = false;
		if (!$id) {
			$this->Session->setFlash(__('Invalid id for ho performance plan', true), '');
			$this->render('/elements/failure');
		}
		if (stripos($id, '_') !== false) {
            $ids = explode('_', $id);
            try{
				$count = 0;
                foreach ($ids as $i) {
					$plan_status = 1;
					$budget_year_id = 0;
					$quarter = 0;
					$plan_status_row = array();
					$plan_status_row = $this->HoPerformancePlan->find('first', array('conditions' => array('HoPerformancePlan.id' => $i)));
					if(count($plan_status_row) > 0){
					   $plan_status = $plan_status_row['HoPerformancePlan']['plan_status'];
					   $budget_year_id = $plan_status_row['HoPerformancePlan']['budget_year_id'];
					   $quarter = $plan_status_row['HoPerformancePlan']['quarter'];
					}
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
				if($count == 0){  //if all of them are not agreed
					foreach ($ids as $i) {
						$this->HoPerformancePlan->delete($i);
					}
					
					$this->Session->setFlash(__('Ho performance plan deleted', true), '');
					$this->render('/elements/success');
				}
				else {
					$this->Session->setFlash(__('The plan is closed for deleting.', true), '');
					$this->render('/elements/failure');
				}
				
            }
            catch (Exception $e){
				$this->Session->setFlash(__('Ho performance plan was not deleted', true), '');
				$this->render('/elements/failure');
            }
        } else {
		 $plan_status = 1;
		 $plan_status_row = array();
		 $plan_status_row = $this->HoPerformancePlan->find('first', array('conditions' => array('HoPerformancePlan.id' => $id)));
		 $budget_year_id = 0;
		 $quarter = 0;
		 if(count($plan_status_row) > 0){
			$plan_status = $plan_status_row['HoPerformancePlan']['plan_status'];
			$budget_year_id = $plan_status_row['HoPerformancePlan']['budget_year_id'];
			$quarter = $plan_status_row['HoPerformancePlan']['quarter'];
		 }
		 	   //--------------------------------------------------check if the general status is open--------------------------------------------------
$this->loadModel('PerformanceStatus');
$general_status = "open";
$general_status_row =  $this->PerformanceStatus->query('select * from performance_statuses where  budget_year_id = '.$budget_year_id.' and quarter = '. $quarter);
if(count($general_status_row) > 0){
	$general_status = $general_status_row[0]['performance_statuses']['status'];
}
//--------------------------------------------------end of check if the general status is open----------------------------------------------
		 if($plan_status <= 2 && $general_status == "open"){
			if ($this->HoPerformancePlan->delete($id)) {
				$this->Session->setFlash(__('Ho performance plan deleted', true), '');
				$this->render('/elements/success');
			} else {
				$this->Session->setFlash(__('Ho performance plan was not deleted', true), '');
				$this->render('/elements/failure');
			}
		 }
		 else {
			    $this->Session->setFlash(__('The plan is closed for deleting.', true), '');
		 		$this->render('/elements/failure');
		 }
            
        }
	}
}
?>