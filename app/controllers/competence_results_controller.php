<?php
class CompetenceResultsController extends AppController {

	var $name = 'CompetenceResults';
 
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
	
					 $emp_id = $emp_rows[$i]['employees']['card'];
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

						 return $emps;
					
		  }
				function get_emp_ids_few() { // one level
					$this_user = $this->Session->read();
					$this_user_id = $this_user['Auth']['User']['id'];
					
					$this->loadModel('Employee');
							
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
						 $emp_id_row = $this->Employee->query('select * from employees where id = '. $item['supervisors']['emp_id']. ' and status = "active" ');
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
    
	 function get_subordinates() { // one level
		$this_user = $this->Session->read();
		$this_user_id = $this_user['Auth']['User']['id'];
		// $this_user_id = 1177;
		
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
		function get_all_budget_years(){
			$budget_year_array = array();
			$this->loadModel('BudgetYear');
			$budget_years_row = $this->BudgetYear->query('select * from budget_years ');
			foreach($budget_years_row as $item){
				$budget_year_array[$item['budget_years']['id']] = $item['budget_years']['name'];

			}
			return $budget_year_array;


		}
	
	function index() {
		// $budget_years = $this->CompetenceResult->BudgetYear->find('all');
		$budget_years = $this->get_budget_years();
		$this->set(compact('budget_years'));
	}
	
	function index2($id = null) {
		$this->set('parent_id', $id);
	}

	function search() {
	}

	function test(){
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
			 // $conditions['CompetenceResult.budgetyear_id'] = $budgetyear_id;
			 $budget_year_ids = $this->get_budget_year_ids();
			 $year_quater_filter = explode(" ", $budget_year_ids[$budgetyear_id]);
			 $year_filter = $year_quater_filter[0]  * 1;
			 $quarter_filter = $year_quater_filter[1] * 1;
		   
			 $conditions['CompetenceResult.budget_year_id'] = $year_filter;
			 $conditions['CompetenceResult.quarter'] = $quarter_filter;
		 }
	 $conditions['CompetenceResult.employee_id'] = $subordinate_ids;
	 //	$emps = $this->get_emp_names();
		  $emps = $this->get_emp_names_few2();
 //------------------------------------get expected competencies -------------------------------------------------------------		
		 // $expected_competences = array();
		// $competenceResult = $this->CompetenceResult->find('all', array('conditions' => $conditions, 'limit' => $limit, 'offset' => $offset));
		//   $competenceResult = $this->CompetenceResult->find('all', array('conditions' => $conditions, 
		//   'fields' => array('CompetenceResult.employee_id', 'CompetenceResult.budget_year_id' , 'CompetenceResult.quarter'),
		//   'group' => array('CompetenceResult.employee_id', 'CompetenceResult.budget_year_id' , 'CompetenceResult.quarter'),
		//   'limit' => $limit, 
		//   'offset' => $start
		//   ));
		$competenceResult = $this->CompetenceResult->find('all', array('conditions' => $conditions, 
		'fields' => array('CompetenceResult.employee_id', 'CompetenceResult.budget_year_id' , 'CompetenceResult.quarter','sum(CompetenceResult.result_status) as sum_status', 'count(CompetenceResult.result_status) as count_status'),
		'group' => array('CompetenceResult.employee_id', 'CompetenceResult.budget_year_id' , 'CompetenceResult.quarter'),
		'limit' => $limit, 
		'offset' => $start
		));

		//  print_r($competenceResult);
		//  print_r($emps);

		//   $count = $this->CompetenceResult->find('count', array('conditions' => $conditions ,
		//   'fields' => array('COUNT(*)'),
		//   'group' => array('CompetenceResult.employee_id', 'CompetenceResult.budget_year_id' , 'CompetenceResult.quarter'),
		//   'limit' => $limit, 
		//   'offset' => $start
		// ));

	//	echo $count;
	//echo sizeof($competenceResult);
	print_r($competenceResult);
		 
		 // $this->loadModel('CompetenceSetting');
		 // for($i = 0 ; $i < count($competenceResult) ; $i++){
 
		 //    $row_id = $competenceResult[$i]['CompetenceResult']['id'];
		 //    $emp_id = $competenceResult[$i]['CompetenceResult']['employee_id'];
		 //    $competence_id = $competenceResult[$i]['CompetenceResult']['competence_id'];
 
		 //  $this->loadModel('EmployeeDetail');
		 //  $emp_row = $this->EmployeeDetail->query('select * from employee_details where employee_id = '.  $emp_id. ' order by start_date desc');
		 //  $grade_id = $emp_row[0]['employee_details']['grade_id'];
		 
		 //  $this->loadModel('CompetenceSetting');
		 //  $setting_row = $this->CompetenceSetting->query('select * from competence_settings where grade_id = '. $grade_id .' and competence_id = '.$competence_id.'');
		 //  $expected_competences[$row_id] = $setting_row[0]['competence_settings']['expected_competence'];
 //---------------------------end of finding expected competences----------------------------------------------------------
		 
	 //	 }
	 //, 'group' => array(`CompetenceResult`.`employee_id`, `CompetenceResult`.`budget_year_id`, `CompetenceResult`.`quarter`),
		//print_r($competenceResult);
		 
		//  $this->set('competenceResults', $competenceResult);
		//  $this->set('results', $this->CompetenceResult->find('count', array('conditions' => $conditions, 
		//  'fields' => array('Competence_Result.employee_id', 'Competence_Result.budget_year_id' , 'Competence_Result.quarter'),
		//  'group' => array('Competence_Result.employee_id', 'Competence_Result.budget_year_id' , 'Competence_Result.quarter'),
		//  'limit' => $limit, 
		//  'offset' => $start)));
		//  $this->set('emps', $emps);
	 //	$this->set('expected_competences', $expected_competences);
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
            // $conditions['CompetenceResult.budgetyear_id'] = $budgetyear_id;
			$budget_year_ids = $this->get_budget_year_ids();
			$year_quater_filter = explode(" ", $budget_year_ids[$budgetyear_id]);
			$year_filter = $year_quater_filter[0]  * 1;
			$quarter_filter = $year_quater_filter[1] * 1;
          
			$conditions['CompetenceResult.budget_year_id'] = $year_filter;
			$conditions['CompetenceResult.quarter'] = $quarter_filter;
        }
    $conditions['CompetenceResult.employee_id'] = $subordinate_ids;
	//	$emps = $this->get_emp_names();
		 $emps = $this->get_emp_names_few2();
//------------------------------------get expected competencies -------------------------------------------------------------		
		// $expected_competences = array();
		$competenceResult = $this->CompetenceResult->find('all', array('conditions' => $conditions, 
		'fields' => array('CompetenceResult.employee_id', 'CompetenceResult.budget_year_id' , 'CompetenceResult.quarter','sum(CompetenceResult.result_status) as sum_status', 'count(CompetenceResult.result_status) as count_status'),
		'group' => array('CompetenceResult.employee_id', 'CompetenceResult.budget_year_id' , 'CompetenceResult.quarter'),
		'limit' => $limit, 
		'offset' => $start
		));
		
		// $this->loadModel('CompetenceSetting');
		// for($i = 0 ; $i < count($competenceResult) ; $i++){

		//    $row_id = $competenceResult[$i]['CompetenceResult']['id'];
		//    $emp_id = $competenceResult[$i]['CompetenceResult']['employee_id'];
		//    $competence_id = $competenceResult[$i]['CompetenceResult']['competence_id'];

		//  $this->loadModel('EmployeeDetail');
		//  $emp_row = $this->EmployeeDetail->query('select * from employee_details where employee_id = '.  $emp_id. ' order by start_date desc');
		//  $grade_id = $emp_row[0]['employee_details']['grade_id'];
		
		//  $this->loadModel('CompetenceSetting');
		//  $setting_row = $this->CompetenceSetting->query('select * from competence_settings where grade_id = '. $grade_id .' and competence_id = '.$competence_id.'');
		//  $expected_competences[$row_id] = $setting_row[0]['competence_settings']['expected_competence'];
//---------------------------end of finding expected competences----------------------------------------------------------
		
	//	 }
	//, 'group' => array(`CompetenceResult`.`employee_id`, `CompetenceResult`.`budget_year_id`, `CompetenceResult`.`quarter`),
	   //print_r($competenceResult);
		
		$this->set('competenceResults', $competenceResult);
		// $this->set('results', $this->CompetenceResult->find('count', array('conditions' => $conditions, 
		// 'fields' => array('CompetenceResult.employee_id', 'CompetenceResult.budget_year_id' , 'CompetenceResult.quarter'),
		// 'group' => array('CompetenceResult.employee_id', 'CompetenceResult.budget_year_id' , 'CompetenceResult.quarter'),
		// 'limit' => $limit, 
		// 'offset' => $start
		// )));
		$this->set('results', sizeof($competenceResult));
		$this->set('emps', $emps);
		$this->set('all_budget_years' ,  $this->get_all_budget_years());
	//	$this->set('expected_competences', $expected_competences);

	}

	function list_competences($id = null) {
		$this->autoRender = false;
		

		$emp_id = $id;

						//-------------------------find the settings that are relevant to the employee by position------------------------
						//$branch_performance_settings = array();
						//$this->loadModel('Position');
						$this->loadModel('EmployeeDetail');
						$this->loadModel('CompetenceSetting');
						$grade_id_row = $this->EmployeeDetail->query('select * from employee_details 
								where employee_id = '. $emp_id .' order by start_date desc');
								$grade_id = $grade_id_row[0]["employee_details"]["grade_id"];

						$setting_row = $this->CompetenceSetting->query('select * from competence_settings 
						where grade_id = '. $grade_id .' ');

						$count = 0;
						$str_competences = "" ;
						foreach($setting_row as $item){
							$count++;
							$competence_id = $item["competence_settings"]["competence_id"];
							$this->loadModel('Competence');
							$competence_row = $this->Competence->query('select * from competences
							where id = '. $competence_id .' ');
							$competence_name = $competence_row[0]['competences']['name'];
							

							if($count == count($setting_row)){
								$str_competences .= $competence_id.','.$competence_name;
							}
							else {
								$str_competences .= $competence_id.','.$competence_name.',';
								
							}

							
						}
						
			
							
						//-------------------------end of find the settings that are relevant to the employee by position------------------------
		

		
		echo $str_competences;

		
	}

	function view($id = null) {
		if (!$id) {
			$this->Session->setFlash(__('Invalid competence result', true));
			$this->redirect(array('action' => 'index'));
		}
		$this->CompetenceResult->recursive = 2;
		$this->set('competenceResult', $this->CompetenceResult->read(null, $id));
	}

	function add($id = null) {
		if (!empty($this->data)) {
			$original_data = $this->data ;
			$employee_id = $original_data['CompetenceResult']['employee_id'];
			$budget_year_id = $original_data['CompetenceResult']['budget_year_id'];
			$quarter = $original_data['CompetenceResult']['quarter'];
			//$competence_id = $original_data['CompetenceResult']['competence_id'];
			
    

			$conditions = array('CompetenceResult.employee_id' => $employee_id,'CompetenceResult.budget_year_id' => $budget_year_id,'CompetenceResult.quarter' => $quarter);
			$competenceResult = $this->CompetenceResult->find('all', array('conditions' => $conditions )); 
			if(count($competenceResult) == 0) {
				//------------------------------check if the competence matches the settings-------------------------------------
			    //--------------------get the grade of the employee-------------------------------------------------------
				$this->loadModel('EmployeeDetail');
				// $emp_row = $this->EmployeeDetail->query('select * from employee_details where employee_id = '. $employee_id);
         $emp_row = $this->EmployeeDetail->query('select * from employee_details where employee_id = '. $employee_id.' order by start_date desc');         
				 $grade_id = $emp_row[0]['employee_details']['grade_id'];
				
				 $this->loadModel('CompetenceSetting');
				 $setting_row = $this->CompetenceSetting->query('select * from competence_settings where grade_id = '. $grade_id .' ');
				 
				//----------------------------end of checking if the competence matches the settings------------------------------
				if(count($setting_row) > 0 ){
					$this->CompetenceResult->create();
					$this->autoRender = false;
					//$worked = 0;
					foreach($setting_row as $item){
				//		$original_data['CompetenceResult']['competence_id'] = $item['competence_settings']['competence_id'];
					//	if ($this->CompetenceResult->save($this->data)) {
				//		if ($this->CompetenceResult->save($original_data)) {	
				//		} else {
				//			$this->Session->setFlash(__('The competence result could not be saved. Please, try again.', true), '');
				//			$this->render('/elements/failure');
				//		}
        $insert_row = $this->CompetenceResult->query('insert into competence_results(budget_year_id, quarter, employee_id, 
					competence_id, actual_competence, score, rating, result_status, comment)
					values ('.$budget_year_id.','.$quarter.','.$employee_id.','.$item['competence_settings']['competence_id'].',
					1,0,0,1,"")
					');
					}
					$this->Session->setFlash(__('The competence result has been saved', true), '');
							$this->render('/elements/success');
					
				}else{
					$this->Session->setFlash(__('The competence is invalid for this employee.', true), '');
					$this->render('/elements/failure3');	
				}
				
			}
			else {

				$this->Session->setFlash(__('The competence result has already been inserted.', true), '');
				$this->render('/elements/failure3');
			}
			
		}
		if($id)
			$this->set('parent_id', $id);

			$this->loadModel('CompetenceLevel');
		//$this->CompetenceLevel->recursive=1;
		//$this->User->recursive=0;
	//	$emps = $this->get_emp_names();
		$emps = $this->get_emp_names_few();
		$competence_levels = $this->CompetenceLevel->find('list');
		$budget_years = $this->CompetenceResult->BudgetYear->find('list');
		$employees = $this->CompetenceResult->Employee->find('list');
		$competences = $this->CompetenceResult->Competence->find('list');
		$this->set(compact('budget_years', 'employees', 'competences' , 'competence_levels', 'emps'));
	}

	function edit2($id = null, $parent_id = null) {
		if (!$id && empty($this->data)) {
			$this->Session->setFlash(__('Invalid competence result', true), '');
			$this->redirect(array('action' => 'index'));
		}
		
		if (!empty($this->data)) {
			$this->autoRender = false;
			
			
		}
		else {
			//-----------------------------------------------------find the expected competence-----------------------------
		   $result_row = $this->CompetenceResult->query('select * from competence_results where id = '.  $id);
		   $emp_id = $result_row[0]['competence_results']['employee_id'];
		   $competence_id = $result_row[0]['competence_results']['competence_id'];
		   $this->loadModel('EmployeeDetail');
		   $emp_row = $this->EmployeeDetail->query('select * from employee_details where employee_id = '.  $emp_id. ' order by start_date desc');
		   $grade_id = $emp_row[0]['employee_details']['grade_id'];
	   
		   $this->loadModel('CompetenceSetting');
		   $setting_row = $this->CompetenceSetting->query('select * from competence_settings where grade_id = '. $grade_id .' and competence_id = '.$competence_id.'');
		   $expected_competence = $setting_row[0]['competence_settings']['expected_competence'];
		//----------------------------------------------------end of finding the expected competence----------------------
		}
		
		$this->set('competence_result', $this->CompetenceResult->read(null, $id));
		
		if($parent_id) {
			$this->set('parent_id', $parent_id);
		}

		
		// $emps = $this->get_emp_names();
		 $emps = $this->get_emp_names_few2();
		
		$this->loadModel('CompetenceLevel');
		
		$competence_levels = $this->CompetenceLevel->find('list');
		$budget_years = $this->CompetenceResult->BudgetYear->find('list');
		$employees = $this->CompetenceResult->Employee->find('list');
		$competences = $this->CompetenceResult->Competence->find('list');
		$this->set(compact('budget_years', 'employees', 'competences', 'competence_levels', 'expected_competence', 'emps'));

	}

	function edit($id = null, $parent_id = null) {
		if (!$id && empty($this->data)) {
			$this->Session->setFlash(__('Invalid competence result', true), '');
			$this->redirect(array('action' => 'index'));
		}
		
		if (!empty($this->data)) {
			$this->autoRender = false;
			$original_data = $this->data;

			$id = $original_data['CompetenceResult']['id'];
			
			$aggregate_id = explode("$", $id);
			$employee_id = $aggregate_id[0] * 1;
			$budget_year_id = $aggregate_id[1] * 1;
			$quarter = $aggregate_id[2] * 1;
			$no_competence = 0;
			$this->loadModel('EmployeeDetail');
			$this->loadModel('CompetenceSetting');

			//----------------------------------find the status of the plan---------------------------------------------------
			$result_status_row = $this->CompetenceResult->query('select * from competence_results where employee_id = '.  $employee_id . ' and budget_year_id = '.$budget_year_id. ' and quarter = '.$quarter);
			
			$result_status = $result_status_row[0]['competence_results']['result_status'];	
			
			//--------------------------------end of finding the status of the plan-------------------------------------------
			//--------------------------------------------------check if the general status is open--------------------------------------------------
			$this->loadModel('PerformanceStatus');
			$general_status = "open";
			$general_status_row =  $this->PerformanceStatus->query('select * from performance_statuses where  budget_year_id = '.$budget_year_id.' and quarter = '. $quarter);
			if(count($general_status_row) > 0){
				$general_status = $general_status_row[0]['performance_statuses']['status'];
			}
			//--------------------------------------------------end of check if the general status is open----------------------------------------------

			//now try to save all of the competence results---------------------------------------
			$result_row = $this->CompetenceResult->query('select * from competence_results where employee_id = '.  $employee_id . ' and budget_year_id = '.$budget_year_id. ' and quarter = '.$quarter);
			foreach($result_row as $item){
				$this_id = $item['competence_results']['id'];
				$this_new_actual_competence = $original_data['CompetenceResult']['competence_'.$no_competence];
				$this_competence_id = $item['competence_results']['competence_id'];
			 $emp_row = $this->EmployeeDetail->query('select * from employee_details where employee_id = '.  $item['competence_results']['employee_id']. ' order by start_date desc');
			 $grade_id = $emp_row[0]['employee_details']['grade_id'];
					  $setting_row = $this->CompetenceSetting->query('select * from competence_settings where grade_id = '. $grade_id .' and competence_id = '.$item['competence_results']['competence_id'].'');
					  $expected_competence = $setting_row[0]['competence_settings']['expected_competence'];
					  $competence_array[$item['competence_results']['competence_id']] = $expected_competence;

					  $setting_row = $this->CompetenceSetting->query('select * from competence_settings where grade_id = '. $grade_id .' and competence_id = '.$this_competence_id.'');
				 
					  //----------------------------end of checking if the competence matches the settings------------------------------
					  $this_new_score = 0;
					  $this_new_rating = 0;
					  if(count($setting_row) > 0 ){ 
					  //-----------------------------------------------------find the expected competence-----------------------------
						  $expected_competence = $setting_row[0]['competence_settings']['expected_competence'];
						  $weight = $setting_row[0]['competence_settings']['weight'];
						 if($this_new_actual_competence >= $expected_competence){
							$this_new_score = 2;
						 } else {
							$this_new_score = 1;
						 }
						 
						 $this_new_rating = $this_new_score * $weight;
						 //----------------------------now update the values------------------------------------
						 if($result_status == 1 && $general_status == "open"){
							$this->CompetenceResult->query('update competence_results set actual_competence = '.$this_new_actual_competence.'
							 , score = '.$this_new_score. ' , rating = '.$this_new_rating
							);
						 }
						 //---------------------------end of update the values-------------------------------------

						}
		$no_competence++ ;
			}
			//--------------------------------------------find the corresponding ho plan if any---------------------------------------
			$this->loadModel('HoPerformancePlan');
			$ho_plan_row = $this->HoPerformancePlan->query("select * from ho_performance_plans where employee_id = ".$employee_id."
			 and  budget_year_id = ".$budget_year_id." and quarter = ".$quarter);
			//----------------------------------------------end of finding corresponding ho plan if any------------------------------
			if($result_status == 1 && $general_status == "open"){
				if(count($ho_plan_row) > 0){
					$this->recalculate_plan($ho_plan_row[0]['ho_performance_plans']['id']);
				}
				$this->Session->setFlash(__('The competence result has been saved', true), '');
				$this->render('/elements/success');
			}
			else  {
				$this->Session->setFlash(__('the result is closed for editing.', true), '');
				$this->render('/elements/failure3');

			}

			
		}
		else {
			//-----------------------------------------------------find the expected competence-----------------------------
		// echo $id;
		  
		  // $emp_id = $result_row[0]['competence_results']['employee_id'];
		  // $competence_id = $result_row[0]['competence_results']['competence_id'];
		  // $this->loadModel('EmployeeDetail');
		  // $emp_row = $this->EmployeeDetail->query('select * from employee_details where employee_id = '.  $emp_id. ' order by start_date desc');
		  // $grade_id = $emp_row[0]['employee_details']['grade_id'];
	   
		  // $this->loadModel('CompetenceSetting');
		  // $setting_row = $this->CompetenceSetting->query('select * from competence_settings where grade_id = '. $grade_id .' and competence_id = '.$competence_id.'');
		  // $expected_competence = $setting_row[0]['competence_settings']['expected_competence'];
		//----------------------------------------------------end of finding the expected competence----------------------
		}
	//	$this->set('competence_result', $this->CompetenceResult->read(null, $id));
	$aggregate_id = explode("$", $id);
	$employee_id = $aggregate_id[0] * 1;
	$budget_year_id = $aggregate_id[1] * 1;
	$quarter = $aggregate_id[2] * 1;

	$competence_array = array();
	$this->loadModel('EmployeeDetail');
	$this->loadModel('CompetenceSetting');

	$result_row = $this->CompetenceResult->query('select * from competence_results where employee_id = '.  $employee_id . ' and budget_year_id = '.$budget_year_id. ' and quarter = '.$quarter);
	foreach($result_row as $item){
	 $emp_row = $this->EmployeeDetail->query('select * from employee_details where employee_id = '.  $item['competence_results']['employee_id']. ' order by start_date desc');
	 $grade_id = $emp_row[0]['employee_details']['grade_id'];
			  $setting_row = $this->CompetenceSetting->query('select * from competence_settings where grade_id = '. $grade_id .' and competence_id = '.$item['competence_results']['competence_id'].'');
				$expected_competence = $setting_row[0]['competence_settings']['expected_competence'];
			 $competence_array[$item['competence_results']['competence_id']] = $expected_competence;

	}

		 $competence_array_size = sizeof($competence_array);
		 $this->set('competence_result', $result_row);
		 $this->set('competence_array_size', $competence_array_size);
		 $this->set('competence_array', $competence_array);
		// $this->set('triple_ids' , $id);
		
		if($parent_id) {
			$this->set('parent_id', $parent_id);
		}

		
		// $emps = $this->get_emp_names();
		 $emps = $this->get_emp_names_few2();
		
		$this->loadModel('CompetenceLevel');
		
		$competence_levels = $this->CompetenceLevel->find('list');
		//$budget_years = $this->CompetenceResult->BudgetYear->find('list');
		$budget_years = $this->get_all_budget_years();
		$employees = $this->CompetenceResult->Employee->find('list');
		$competences = $this->CompetenceResult->Competence->find('list');
		$this->set(compact('budget_years', 'employees', 'competences', 'competence_levels',  'emps'));

	}


	function recalculate($id = null) {
	

			$this->autoRender = false;
			$this->loadModel('CompetenceResult');
			$original_data = array();
			$original_data = $this->CompetenceResult->find('first', array('conditions' => array('CompetenceResult.id' => $id)));
			//$original_data = $this->data;
			$actual_competence = $original_data['CompetenceResult']['actual_competence'];
			$emp_id = $original_data['CompetenceResult']['employee_id'];
			$competence_id = $original_data['CompetenceResult']['competence_id'];

			//----------------------------------find the status of the plan---------------------------------------------------
			$result_status_row = $this->CompetenceResult->query("select * from competence_results where id = ".$id."  ");
			
			$result_status = $result_status_row[0]['competence_results']['result_status'];	
			$budget_year_id = $result_status_row[0]['competence_results']['budget_year_id'];	
			$quarter = $result_status_row[0]['competence_results']['quarter'];	
			
			//--------------------------------end of finding the status of the plan-------------------------------------------
			//--------------------------------------------------check if the general status is open--------------------------------------------------
			$this->loadModel('PerformanceStatus');
			$general_status = "open";
			$general_status_row =  $this->PerformanceStatus->query('select * from performance_statuses where  budget_year_id = '.$budget_year_id.' and quarter = '. $quarter);
			if(count($general_status_row) > 0){
				$general_status = $general_status_row[0]['performance_statuses']['status'];
			}
		//--------------------------------------------------end of check if the general status is open----------------------------------------------

			$this->loadModel('EmployeeDetail');
			$grade_id_row = array();
			$grade_id_row = $this->EmployeeDetail->query('select * from employee_details where employee_id = '.  $emp_id. ' order by start_date desc');
			$grade_id = $grade_id_row[0]['employee_details']['grade_id'];

			 $this->loadModel('CompetenceSetting');
			 $expected_competence_row = $this->CompetenceSetting->find('first', array('conditions' => array('CompetenceSetting.grade_id' => $grade_id , 'CompetenceSetting.competence_id' => $competence_id )));
			 $expected_competence = $expected_competence_row['CompetenceSetting']['expected_competence'];
			 $weight = $expected_competence_row['CompetenceSetting']['weight'];
			if($actual_competence >= $expected_competence){
				$score = 2;
			}else{
				$score = 1;
			}
		
			$rating = $score * $weight;
			$original_data['CompetenceResult']['score'] = $score;
			$original_data['CompetenceResult']['rating'] = $rating;


			if($result_status < 2 && $general_status == "open"){
				//	if ($this->CompetenceResult->save($this->data)) {
					if ($this->CompetenceResult->save($original_data)) {
						// $this->Session->setFlash(__('The competence result has been saved', true), '');
						// $this->render('/elements/success');
					} else {
						// $this->Session->setFlash(__('The competence result could not be saved. Please, try again.', true), '');
						// $this->render('/elements/failure');
					}
					// $this->Session->setFlash(__('The competence result has been saved', true), '');
					// $this->render('/elements/success');
			}
		
		
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

	function emp_level222222222222($emp_id){
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
			
			if($direction == 1 || $direction == 2){
				if($plan_in_number == 0){
					$plan_in_number = 0.000000001;
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

	function recalculate_plan($id = null) {
		
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

	function change_status2($id = null, $parent_id = null){

	}

	function change_status($id = null, $parent_id = null) {
		if (!$id && empty($this->data)) {
			$this->Session->setFlash(__('Invalid competence result', true), '');
			$this->redirect(array('action' => 'index'));
		}
		if (!empty($this->data)) {
			$original_data = $this->data;
			$id = $original_data['CompetenceResult']['id'];
			
			$result_status = $original_data['CompetenceResult']['result_status'];

			$emp_id_row = $this->CompetenceResult->query('select * from competence_results where id = '.$id);
			$emp_id = $emp_id_row[0]['competence_results']['employee_id'];
			$budget_year_id = $emp_id_row[0]['competence_results']['employee_id'];
			$quarter = $emp_id_row[0]['competence_results']['quarter'];
       //------------------------------------find this user emp id--------------------------------------------
          $this_user = $this->Session->read();
			    $this_user_id = $this_user['Auth']['User']['id'];
			    $this->loadModel('Employee');
          $emp_rows= $this->Employee->query('select * from employees where user_id = '.$this_user_id);
          $this_emp_id = $emp_rows[0]['employees']['id'];
          
                                           
      
      //----------------------------------end of find this user emp id------------------------------------------
			//------------------------------------find first supervisor id---------------------------------------
			$first_sup_id = 0;
			
					$this->loadModel('Supervisor');
					
					$first_sup_id_row = array();
					$first_sup_id_row = $this->Supervisor->find('first', array('conditions' => array('Supervisor.emp_id' => $emp_id)));
					if(count($first_sup_id_row) > 0){
						$first_sup_id = $first_sup_id_row['Supervisor']['sup_emp_id'];
					}
					else {
						$first_sup_id = 0;
					}

			//----------------------------------end of find first supervisor id------------------------------------
			//------------------------------------find second supervisor id---------------------------------------
			$second_sup_id = 0;
			
					$this->loadModel('Supervisor');
					
					$second_sup_id_row = array();
					$second_sup_id_row = $this->Supervisor->find('first', array('conditions' => array('Supervisor.emp_id' => $first_sup_id)));
					if(count($second_sup_id_row) > 0){
						$second_sup_id = $second_sup_id_row['Supervisor']['sup_emp_id'];
					}
					else {
						$second_sup_id = 0;
					}

			//----------------------------------end of find second supervisor id------------------------------------
			//-------------------------------------get grade first----------------------------------------------------
				$this->loadModel('EmployeeDetail');
				$grade_row = $this->EmployeeDetail->query('select * from employee_details where employee_id = '. $emp_id . ' order by start_date desc');
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
				//-------------here i have to validate if the spv is authorized to change the status-------------------------------------------
				if($this_emp_id == $second_sup_id){
					$update_status = $this->CompetenceResult->query('update competence_results set result_status = '.$result_status.' where 
					employee_id = '.$emp_id.' and budget_year_id = '.$budget_year_id.' and quarter = '.$quarter );
						
					$this->Session->setFlash(__('The status has been changed successfully', true), '');
					$this->render('/elements/success');
				}
				else {
					$this->Session->setFlash(__('Sorry! You are not authorized to change the status.', true), '');
						$this->render('/elements/failure3');
				}
				
			}
			else {
				$this->Session->setFlash(__('data count is not complete.', true), '');
			    $this->render('/elements/failure3');
			}
		}
		else {
			$this->Session->setFlash(__('data entry is not complete.', true), '');
			$this->render('/elements/failure3');
		}	
			
		}
		
		$this->set('competence_result', $this->CompetenceResult->read(null, $id));
		
	}

	function delete2($id = null) {
		$this->autoRender = false;
		if (!$id) {
			$this->Session->setFlash(__('Invalid id for competence result', true), '');
			$this->render('/elements/failure');
		}
		if (stripos($id, '_') !== false) {
            $ids = explode('_', $id);
            try{
				$count = 0;
				foreach ($ids as $i) {
                    //----------------------------------find the status of the plan---------------------------------------------------
						$result_status_row = $this->CompetenceResult->query("select * from competence_results where id = ".$i."  ");
						
						$result_status = $plan_status_row[0]['competence_results']['result_status'];	
						$budget_year_id = $plan_status_row[0]['competence_results']['budget_year_id'];
						$quarter = $plan_status_row[0]['competence_results']['quarter'];
						
						//--------------------------------end of finding the status of the plan-------------------------------------------
					//--------------------------------------------------check if the general status is open--------------------------------------------------
					$this->loadModel('PerformanceStatus');
					$general_status = "open";
					$general_status_row =  $this->PerformanceStatus->query('select * from performance_statuses where  budget_year_id = '.$budget_year_id.' and quarter = '. $quarter);
					if(count($general_status_row) > 0){
						$general_status = $general_status_row[0]['performance_statuses']['status'];
					}
				//--------------------------------------------------end of check if the general status is open----------------------------------------------
						if($result_status > 1 || $general_status == "closed"){
						$count++;
					}
                }
				if($count == 0){
					foreach ($ids as $i) {
						$this->CompetenceResult->delete($i);
					}
					$this->Session->setFlash(__('Competence result deleted', true), '');
					$this->render('/elements/success');
				}
				else {
					$this->Session->setFlash(__('The plan is closed for deleting.', true), '');
					$this->render('/elements/failure');
				}
                
            }
            catch (Exception $e){
				$this->Session->setFlash(__('Competence result was not deleted', true), '');
				$this->render('/elements/failure');
            }
        } else {
			//----------------------------------find the status of the plan---------------------------------------------------
			$result_status_row = $this->CompetenceResult->query("select * from competence_results where id = ".$id."  ");
			
			$result_status = $result_status_row[0]['competence_results']['result_status'];	
			$budget_year_id = $result_status_row[0]['competence_results']['budget_year_id'];
			$quarter = $result_status_row[0]['competence_results']['quarter'];
			
			//--------------------------------end of finding the status of the plan-------------------------------------------
				//--------------------------------------------------check if the general status is open--------------------------------------------------
				$this->loadModel('PerformanceStatus');
				$general_status = "open";
				$general_status_row =  $this->PerformanceStatus->query('select * from performance_statuses where  budget_year_id = '.$budget_year_id.' and quarter = '. $quarter);
				if(count($general_status_row) > 0){
					$general_status = $general_status_row[0]['performance_statuses']['status'];
				}
			//--------------------------------------------------end of check if the general status is open----------------------------------------------
			if($result_status == 1 && $general_status == "open"){
				if ($this->CompetenceResult->delete($id)) {
					$this->Session->setFlash(__('Competence result deleted', true), '');
					$this->render('/elements/success');
				} else {
					$this->Session->setFlash(__('Competence result was not deleted', true), '');
					$this->render('/elements/failure');
				}
			}
			else {
				$this->Session->setFlash(__('The plan is closed to deleting.', true), '');
				$this->render('/elements/failure');
			}
            
        }
	}

	function delete($id = null) {
		$this->autoRender = false;
		if (!$id) {
			$this->Session->setFlash(__('Invalid id for competence result', true), '');
			$this->render('/elements/failure');
		}
		if (stripos($id, '_') !== false) {
            $ids = explode('_', $id);
            try {
				$count = 0;
				foreach ($ids as $i) {
					$aggregate_id = explode("$", $i);
					$employee_id = $aggregate_id[0] * 1;
					$budget_year_id = $aggregate_id[1] * 1;
					$quarter = $aggregate_id[2] * 1;

					
					$result_row = $this->CompetenceResult->query('select * from competence_results where employee_id = '.  $employee_id . ' and budget_year_id = '.$budget_year_id. ' and quarter = '.$quarter);
					$result_status = $result_row[0]['competence_results']['result_status'];
					//--------------------------------------------------check if the general status is open--------------------------------------------------
					$this->loadModel('PerformanceStatus');
					$general_status = "open";
					$general_status_row =  $this->PerformanceStatus->query('select * from performance_statuses where  budget_year_id = '.$budget_year_id.' and quarter = '. $quarter);
					if(count($general_status_row) > 0){
						$general_status = $general_status_row[0]['performance_statuses']['status'];
					}
				//--------------------------------------------------end of check if the general status is open----------------------------------------------
				if($result_status > 1 || $general_status == "closed"){
					$count++;
				}

                }
				if($count == 0){
					foreach ($ids as $i) {
						$aggregate_id = explode("$", $i);
						$employee_id = $aggregate_id[0] * 1;
						$budget_year_id = $aggregate_id[1] * 1;
						$quarter = $aggregate_id[2] * 1;
						$this->CompetenceResult->query('delete from competence_results where employee_id = '.$employee_id.' and budget_year_id = '.$budget_year_id. ' and quarter = '.$quarter);

					//	$this->CompetenceResult->delete($i);
					}
					$this->Session->setFlash(__('Competence result deleted', true), '');
					$this->render('/elements/success');
				}
				else {
					$this->Session->setFlash(__('The plan is closed for deleting.', true), '');
					$this->render('/elements/failure');
				}
                
            }
            catch (Exception $e){
				$this->Session->setFlash(__('Competence result was not deleted', true), '');
				$this->render('/elements/failure');
            }
        } else {
			//----------------------------------find the status of the plan---------------------------------------------------
			$aggregate_id = explode("$", $id);
						$employee_id = $aggregate_id[0] * 1;
						$budget_year_id = $aggregate_id[1] * 1;
						$quarter = $aggregate_id[2] * 1;
			$result_row = $this->CompetenceResult->query('select * from competence_results where employee_id = '.  $employee_id . ' and budget_year_id = '.$budget_year_id. ' and quarter = '.$quarter);
			
			$result_status = $result_row[0]['competence_results']['result_status'];	
			
			
			//--------------------------------end of finding the status of the plan-------------------------------------------
			//--------------------------------------------------check if the general status is open--------------------------------------------------
				$this->loadModel('PerformanceStatus');
				$general_status = "open";
				$general_status_row =  $this->PerformanceStatus->query('select * from performance_statuses where  budget_year_id = '.$budget_year_id.' and quarter = '. $quarter);
				if(count($general_status_row) > 0){
					$general_status = $general_status_row[0]['performance_statuses']['status'];
				}
			//--------------------------------------------------end of check if the general status is open----------------------------------------------
			if($result_status == 1 && $general_status == "open"){
				// if ($this->CompetenceResult->delete($id)) {
				// 	$this->Session->setFlash(__('Competence result deleted', true), '');
				// 	$this->render('/elements/success');
				// } else {
				// 	$this->Session->setFlash(__('Competence result was not deleted', true), '');
				// 	$this->render('/elements/failure');
				// }
				$this->CompetenceResult->query('delete from competence_results where employee_id = '.$employee_id.' and budget_year_id = '.$budget_year_id. ' and quarter = '.$quarter);

			}
			else {
				$this->Session->setFlash(__('The plan is closed to deleting.', true), '');
				$this->render('/elements/failure');
			}
            
        }
	}
}
?>