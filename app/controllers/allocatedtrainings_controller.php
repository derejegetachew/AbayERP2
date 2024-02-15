<?php
class AllocatedtrainingsController extends AppController {

	var $name = 'Allocatedtrainings';

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
				
					$user_id_row = $this->Employee->query('select * from employees where id = '. $e_id . ' and status = "active" ');
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
						 $emp_id_row = $this->Employee->query('select * from employees where id = '. $item['supervisors']['emp_id']);
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
                   
                   function test(){
                   echo "hello";
                   }
	
	function index() {
		$budget_years = $this->Allocatedtraining->BudgetYear->find('all');
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
            $conditions['Allocatedtraining.budgetyear_id'] = $budgetyear_id;
        }

		$subordinate_ids = $this->get_subordinates();
		$conditions['Allocatedtraining.employee_id'] = $subordinate_ids;
		// $emps = array();
		// $emps[1] = 'abdi';
		// $emps = $this->get_emp_names();  // we need all emps for this case
		 $emps = $this->get_emp_names_few2();

		$this->loadModel('Training');
		$trainings = array();
		$trainings = $this->Training->find('all');
		
		$training_list = array();
		foreach($trainings as $item){
		 	
			$training_list[$item["Training"]["id"]] = $item["Training"]["name"];
			
		}
		
		$this->set('allocatedtrainings', $this->Allocatedtraining->find('all', array('conditions' => $conditions, 'limit' => $limit, 'offset' =>       $start)));
		$this->set('results', $this->Allocatedtraining->find('count', array('conditions' => $conditions)));
		$this->set('training_list', $training_list);
		$this->set('emps', $emps);

	}

	function view($id = null) {
		if (!$id) {
			$this->Session->setFlash(__('Invalid allocatedtraining', true));
			$this->redirect(array('action' => 'index'));
		}
		$this->Allocatedtraining->recursive = 2;
		$this->set('allocatedtraining', $this->Allocatedtraining->read(null, $id));
	}

	function add($id = null) {
		if (!empty($this->data)) {
			$original_data = $this->data ;
			$employee_id = $original_data['Allocatedtraining']['employee_id'];
			$budget_year_id = $original_data['Allocatedtraining']['budget_year_id'];
			$quarter = $original_data['Allocatedtraining']['quarter'];
			$training1 = $original_data['Allocatedtraining']['training1'];
			$training2 = $original_data['Allocatedtraining']['training2'];
			$training3 = $original_data['Allocatedtraining']['training3'];
			

			//--------------------------check if duplicate trainings-------------------------------------------------------------------
            // if(($training1 == $training2) || ($training1 == $training3) || 
			// ($training2 == $training3) ){
			if(($training1 != 0 && $training1 == $training2) || ($training1 != 0 && $training1 == $training3) || ($training2 != 0 && $training2 == $training3)){
				$this->Session->setFlash(__('duplicate training found.', true), '');
				$this->render('/elements/failure3');

			}else{

			$conditions = array('Allocatedtraining.employee_id' => $employee_id,'Allocatedtraining.budget_year_id' => $budget_year_id,'Allocatedtraining.quarter' => $quarter );
			$allocatedTraining = $this->Allocatedtraining->find('all', array('conditions' => $conditions )); 


			if(count($allocatedTraining) == 0){
				

			$conditions2 = array('Allocatedtraining.employee_id' => $employee_id,'Allocatedtraining.budget_year_id' => $budget_year_id, 'Allocatedtraining.quarter !=' => $quarter,
				'or' => array('Allocatedtraining.training1' => $training1, 'Allocatedtraining.training2' => $training1, 'Allocatedtraining.training3' => $training1)
			);
			$conditions3 = array('Allocatedtraining.employee_id' => $employee_id,'Allocatedtraining.budget_year_id' => $budget_year_id, 'Allocatedtraining.quarter !=' => $quarter,
				'or' => array('Allocatedtraining.training1' => $training2, 'Allocatedtraining.training2' => $training2, 'Allocatedtraining.training3' => $training2 )
			);
			$conditions4 = array('Allocatedtraining.employee_id' => $employee_id,'Allocatedtraining.budget_year_id' => $budget_year_id, 'Allocatedtraining.quarter !=' => $quarter,
				'or' => array('Allocatedtraining.training1' => $training3, 'Allocatedtraining.training2' => $training3, 'Allocatedtraining.training3' => $training3)
			);
			

			 $allocatedTraining2 = $this->Allocatedtraining->find('all', array('conditions' => $conditions2 )); 
			 $allocatedTraining3 = $this->Allocatedtraining->find('all', array('conditions' => $conditions3 )); 
			 $allocatedTraining4 = $this->Allocatedtraining->find('all', array('conditions' => $conditions4 ));
			 if($training1 == 0){
                $count2 = 0;
			 } 
			 else{
				$count2 = count($allocatedTraining2);
			 }
			 if($training2 == 0){
                $count3 = 0;
			 } 
			 else{
				$count3 = count($allocatedTraining3);
			 }
			 if($training3 == 0){
                $count4 = 0;
			 } 
			 else{
				$count4 = count($allocatedTraining4);
			 }
			

			 if($count2 == 0 && $count3 == 0 && $count4 == 0 ){
				$this->Allocatedtraining->create();
				$this->autoRender = false;
				if ($this->Allocatedtraining->save($this->data)) {
					$this->Session->setFlash(__('The allocated training has been saved', true), '');
					$this->render('/elements/success');
				} else {
					$this->Session->setFlash(__('The allocated training could not be saved. Please, try again.', true), '');
					$this->render('/elements/failure');
				}
			}
			else {

				$this->Session->setFlash(__('There is an already allocated training.', true), '');
				$this->render('/elements/failure3');

			}

			 }else{
				$this->Session->setFlash(__('The training has already been inserted.', true), '');
				$this->render('/elements/failure3');
			}

			}
			
			//------------------------end of checking if duplicate trainings-----------------------------------------------------------

			
	
		}
		if($id)
		$this->set('parent_id', $id);
		$budget_years = $this->Allocatedtraining->BudgetYear->find('list');
		$employees = $this->Allocatedtraining->Employee->find('list');
		$this->loadModel('Training');
		$trainings = array();
		$trainings = $this->Training->find('all');
		
		$training_list = array();
		$training_list[0] = "-- blank --";
		foreach($trainings as $item){
		 	
			$training_list[$item["Training"]["id"]] = $item["Training"]["name"];
			
		}
	//	$emps = $this->get_emp_names();
		 $emps = $this->get_emp_names_few();
		$this->set(compact('budget_years', 'employees', 'training_list', 'emps'));

	}

	function edit($id = null, $parent_id = null) {
		if (!$id && empty($this->data)) {
			$this->Session->setFlash(__('Invalid allocatedtraining', true), '');
			$this->redirect(array('action' => 'index'));
		}
		if (!empty($this->data)) {
			$original_data = $this->data ;
			$id = $original_data['Allocatedtraining']['id'];
			$employee_id = $original_data['Allocatedtraining']['employee_id'];
			$budget_year_id = $original_data['Allocatedtraining']['budget_year_id'];
			$quarter = $original_data['Allocatedtraining']['quarter'];
			$training1 = $original_data['Allocatedtraining']['training1'];
			$training2 = $original_data['Allocatedtraining']['training2'];
			$training3 = $original_data['Allocatedtraining']['training3'];

			if(($training1 != 0 && $training1 == $training2) || ($training1 != 0 && $training1 == $training3) || ($training2 != 0 && $training2 == $training3)){
				$this->Session->setFlash(__('duplicate training found.', true), '');
				$this->render('/elements/failure3');
			}else{
				//---------------------------------------find the agreement status------------------------------------------------
				$plan_status = 1;
				$this->loadModel('HoPerformancePlan');
				$plan_status_row = $this->HoPerformancePlan->query("select * from ho_performance_plans where  employee_id = ".$employee_id." and budget_year_id = ".$budget_year_id." and quarter = ".$quarter." ");
				   if(count($plan_status_row)){
					$plan_status = $plan_status_row[0]['ho_performance_plans']['plan_status'];
				}
				
		//--------------------------------------end of find the agreement status-------------------------------------------
	
				$trainings_row = $this->Allocatedtraining->query("select * from allocatedtrainings where id != ".$id." and employee_id = ".$employee_id." and budget_year_id = ".$budget_year_id." and quarter = ".$quarter." ");
	
				if(count($trainings_row) == 0) {
	//----------------------------------------------- the 3 quarter filter ---------------------------------------------------------------
				$conditions2 = array('Allocatedtraining.employee_id' => $employee_id,'Allocatedtraining.budget_year_id' => $budget_year_id, 'Allocatedtraining.id !=' => $id,
					'or' => array('Allocatedtraining.training1' => $training1, 'Allocatedtraining.training2' => $training1, 'Allocatedtraining.training3' => $training1  )
				);
				$conditions3 = array('Allocatedtraining.employee_id' => $employee_id,'Allocatedtraining.budget_year_id' => $budget_year_id, 'Allocatedtraining.id !=' => $id,
					'or' => array('Allocatedtraining.training1' => $training2, 'Allocatedtraining.training2' => $training2, 'Allocatedtraining.training3' => $training2)
				);
				$conditions4 = array('Allocatedtraining.employee_id' => $employee_id,'Allocatedtraining.budget_year_id' => $budget_year_id, 'Allocatedtraining.id !=' => $id,
					'or' => array('Allocatedtraining.training1' => $training3, 'Allocatedtraining.training2' => $training3, 'Allocatedtraining.training3' => $training3)
				);
				
				$allocatedTraining2 = $this->Allocatedtraining->find('all', array('conditions' => $conditions2 )); 
				$allocatedTraining3 = $this->Allocatedtraining->find('all', array('conditions' => $conditions3 )); 
				$allocatedTraining4 = $this->Allocatedtraining->find('all', array('conditions' => $conditions4 )); 

				if($training1 == 0){
					$count2 = 0;
				 } 
				 else {
					$count2 = count($allocatedTraining2);
				 }
				 if($training2 == 0){
					$count3 = 0;
				 } 
				 else{
					$count3 = count($allocatedTraining3);
				 }
				 if($training3 == 0){
					$count4 = 0;
				 } 
				 else{
					$count4 = count($allocatedTraining4);
				 }

				
				
	
	//---------------------------------------------- end of the 4 quarter filtering ------------------------------------------------------
			if($count2 == 0 && $count3 == 0 && $count4 == 0 ){  
				$this->autoRender = false;
				if($plan_status <= 2){
					if ($this->Allocatedtraining->save($this->data)) {
						$this->Session->setFlash(__('The allocatedtraining has been saved', true), '');
						$this->render('/elements/success');
					} else {
						$this->Session->setFlash(__('The allocatedtraining could not be saved. Please, try again.', true), '');
						$this->render('/elements/failure');
					}
				}
				else {
					$this->Session->setFlash(__('The plan is closed for editing.', true), '');
						$this->render('/elements/failure3');
				}
				
				} else {
						$this->Session->setFlash(__('The training has already been allocated.', true), '');
						$this->render('/elements/failure3');
	
				}
				
				} else {
					$this->Session->setFlash(__('The training has already been inserted.', true), '');
					$this->render('/elements/failure3');
				}
	

			}
	
			
		}
		$this->set('allocatedtraining', $this->Allocatedtraining->read(null, $id));
		
		if($parent_id) {
			$this->set('parent_id', $parent_id);
		}
			
		$this->loadModel('Training');
		$trainings = array();
		$trainings = $this->Training->find('all');
		
		$training_list = array();
		$training_list[0] = "-- blank --";
		foreach($trainings as $item){
		 	
			$training_list[$item["Training"]["id"]] = $item["Training"]["name"];
			
		}
		// $emps = $this->get_emp_names();
		 $emps = $this->get_emp_names_few2();
		$budget_years = $this->Allocatedtraining->BudgetYear->find('list');
		$employees = $this->Allocatedtraining->Employee->find('list');
		$this->set(compact('budget_years', 'employees', 'training_list', 'emps'));
	}

	function index_report($id = null) {	
			
	    
		$budget_years = $this->Allocatedtraining->BudgetYear->find('list');
		$employees = $this->Allocatedtraining->Employee->find('list');
		$this->set(compact('budget_years', 'employees'));
    }

	function report() {
		$budget_year_search = 0;
		if (!empty($this->data)) {

			$search_data = $this->data ;
			$budget_year_search = $search_data['Allocatedtraining']['budget_year_id'];
			$output_type = $search_data['Allocatedtraining']['output_type'];
			//$budget_year_search = count($search_data);	
		}
		else {
			$budget_year_search = 0; // means all years
			$output_type = 'HTML';
		}

		$this->layout = 'ajax';	
		$this->loadModel('HoPerformancePlan');	



		$emp_ids = array();
		$report_table = array();
		$one_row = array();
	    $budget_years = array();
		
       
		$emp_names = $this->get_emp_names();
		 $emp_ids = $this->get_emp_ids();

		 for($j = 0; $j < count($emp_ids); $j ++){

			if($budget_year_search == 0){  // means all budget years
				$training_row = $this->Allocatedtraining->query('select * from allocatedtrainings 
				where employee_id = '. $emp_ids[$j] .' ');
			}
			else {
				$training_row = $this->Allocatedtraining->query('select * from allocatedtrainings 
				where employee_id = '. $emp_ids[$j] .' and budget_year_id = '.$budget_year_search.'');
			}

			foreach($training_row as $item){ // incase a person has been here for more than one year
				// if(!in_array( $item['ho_performance_plans']['budget_year_id'] , $budget_years)){ 
				// 	array_push($budget_years, $item['ho_performance_plans']['budget_year_id']);
				// }
				$one_row['employee_id'] = $emp_ids[$j];
				$one_row['employee_name'] = $emp_names[$emp_ids[$j]];
				$this->loadModel('BudgetYear');
				$conditions3 = array('BudgetYear.id' => $item['allocatedtrainings']['budget_year_id'] );
				$budget_year_row = $this->BudgetYear->find('first', array('conditions' => $conditions3));
				$one_row['budget_year']  = $budget_year_row['BudgetYear']['name'];
				if($item['allocatedtrainings']['quarter'] == 1 ){
					$one_row['quarter'] = "I";
				}
				if($item['allocatedtrainings']['quarter'] == 2 ){
					$one_row['quarter'] = "II";
				}
				if($item['allocatedtrainings']['quarter'] == 3 ){
					$one_row['quarter'] = "III";
				}
				if($item['allocatedtrainings']['quarter'] == 4 ){
					$one_row['quarter'] = "IV";
				}

				$this->loadModel('Training');
				$training1_row = $this->Training->query('select * from trainings where id = '. $item['allocatedtrainings']['training1']);
				$one_row['training1'] = $training1_row[0]['trainings']['name'];
				$training2_row = $this->Training->query('select * from trainings where id = '. $item['allocatedtrainings']['training2']);
				$one_row['training2'] = $training2_row[0]['trainings']['name'];
				$training3_row = $this->Training->query('select * from trainings where id = '. $item['allocatedtrainings']['training3']);
				$one_row['training3'] = $training3_row[0]['trainings']['name'];
				
				array_push($report_table, $one_row);

			}
			// enter the last one to the table
			
		 }
		
		 $this->set(compact ('report_table',  'output_type' ));
	
	}

	function delete($id = null) {
		$this->autoRender = false;
		if (!$id) {
			$this->Session->setFlash(__('Invalid id for allocatedtraining', true), '');
			$this->render('/elements/failure');
		}
		if (stripos($id, '_') !== false) {
            $ids = explode('_', $id);
            try{
				$count = 0;
				foreach ($ids as $i) {
            //---------------------------------------find the agreement status------------------------------------------------
					$training_row = $this->Allocatedtraining->query("select * from allocated_trainings where  id = ".$i." ");
					$employee_id = $plan_status_row[0]['allocated_trainings']['employee_id'];
					$budget_year_id = $plan_status_row[0]['allocated_trainings']['budget_year_id'];
					$quarter = $plan_status_row[0]['allocated_trainings']['quarter'];
					$plan_status = 1;
					$this->loadModel('HoPerformancePlan');
					$plan_status_row = $this->HoPerformancePlan->query("select * from ho_performance_plans where  employee_id = ".$employee_id." and budget_year_id = ".$budget_year_id." and quarter = ".$quarter." ");
					if(count($plan_status_row)){
						$plan_status = $plan_status_row[0]['ho_performance_plans']['plan_status'];
					}
					if($plan_status > 2){
							$count++;
					}
	//--------------------------------------end of find the agreement status-------------------------------------------
                }
				if($count == 0){
					foreach ($ids as $i) {
						$this->Allocatedtraining->delete($i);
					}
					$this->Session->setFlash(__('Allocatedtraining deleted', true), '');
					$this->render('/elements/success');
				}
				else {
					$this->Session->setFlash(__('one or more plan is closed for deleting.', true), '');
					$this->render('/elements/failure');
				}

               
            }
            catch (Exception $e){
				$this->Session->setFlash(__('Allocatedtraining was not deleted', true), '');
				$this->render('/elements/failure');
            }
        } else {
		//---------------------------------------find the agreement status------------------------------------------------
		$training_row = $this->Allocatedtraining->query("select * from allocated_trainings where  id = ".$id." ");
		$employee_id = $plan_status_row[0]['allocated_trainings']['employee_id'];
		$budget_year_id = $plan_status_row[0]['allocated_trainings']['budget_year_id'];
		$quarter = $plan_status_row[0]['allocated_trainings']['quarter'];
		$plan_status = 1;
			$this->loadModel('HoPerformancePlan');
			$plan_status_row = $this->HoPerformancePlan->query("select * from ho_performance_plans where  employee_id = ".$employee_id." and budget_year_id = ".$budget_year_id." and quarter = ".$quarter." ");
		   	if(count($plan_status_row)){
				$plan_status = $plan_status_row[0]['ho_performance_plans']['plan_status'];
			}
			
	//--------------------------------------end of find the agreement status-------------------------------------------
           if($plan_status <= 2){
			if ($this->Allocatedtraining->delete($id)) {
				$this->Session->setFlash(__('Allocatedtraining deleted', true), '');
				$this->render('/elements/success');
			} else {
				$this->Session->setFlash(__('Allocatedtraining was not deleted', true), '');
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