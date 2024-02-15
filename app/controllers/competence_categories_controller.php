<?php
class CompetenceCategoriesController extends AppController {

	var $name = 'CompetenceCategories';

	function test(){

		$data = "2746-14-4";

		$full_name = '' ;
		$position_name = '' ;
		$dept_name = '';
		$appraisal_period = '';
		$immediate_supervisor_name = 'no name';
		$score_summary = 0;
		$training1 = '';
		$training2 = '';
		$training3 = '';
//		$emps = $this->get_emp_names();
// find quarter, budget_year, emp_id ------------------------------------------------------------------------------------
		 
$data_arr = explode("-", $data);
$e_id = $data_arr[0];
$budget_year_id = $data_arr[1];
$this->loadModel('BudgetYear');
$conditions3 = array('BudgetYear.id' => $budget_year_id );
$hoBudgetYear = $this->BudgetYear->find('first', array('conditions' => $conditions3));
$budget_year  = $hoBudgetYear['BudgetYear']['name'];
$quarter = $data_arr[2];
//find out if it is branch or not--------------------------------------------------------------------------
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


//----end of find out if it is branch or not----------------------------------------------------------------

echo $branch_id;

// if($branch_id != 1){ // means it is branch so redirect
//    $plan_id = $e_id."-".$budget_year_id."-".$quarter; 
//   return $this->redirect(array("controller" => "competenceCategories", 
//  "action" =>  "br_ind_objectives_report",
//  "plan_id" => $plan_id
// ));
// }

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



$appraisal_period = $budget_year." [quarter ".$qrtr. "]";	

// end of find quarter, budget_year, emp_id-----------------------------------------------------------------
// find ho_plan_id----------------------------------------------------------------------------------------------------------
$ho_plan_id = 0;
$this->loadModel('HoPerformancePlan');
$performance_plan_row = $this->HoPerformancePlan->query('select * from ho_performance_plans
			where employee_id = '. $e_id .' and budget_year_id = '. $budget_year_id.' and quarter = '.$quarter);
	if(count($performance_plan_row) > 0){
		$ho_plan_id = $performance_plan_row[0]['ho_performance_plans']['id'];
	}


//-------end of find ho plan id------------------------------------------------------------------------------------------------
// get position------------------------------------------------------------------------------------------------------------
	$this->loadModel('Employee');
	$this->loadModel('EmployeeDetail');
	$this->loadModel('Position');
	$position_id_row = $this->EmployeeDetail->query('select * from employee_details 
			where employee_id = '. $e_id .' order by start_date ');
	$position_id = $position_id_row[0]['employee_details']['position_id'];
	$branch_id = $position_id_row[0]['employee_details']['branch_id'];
	$position_name_row = $this->Position->query('select * from positions
	where id = '. $position_id .' ');
	$position_name = $position_name_row[0]['positions']['name'];
// end of get position--------------------------------------------------------------------------------------------------------	
// get employee_name-----------------------------------------------------------------------------------------------------------
		
	$this->loadModel('User');
	$this->loadModel('Person');
	
	 
	  $emp_row = $this->Employee->query('select * from employees where id = '.$e_id.' and status = "active" ');
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
			$obj_one_row['objective'] = $hoPlanObj[$j]['ho_performance_details']['objective'];
			$obj_one_row['kpis'] = $hoPlanObj[$j]['ho_performance_details']['perspective'];
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
   $sup_name_row = $this->Employee->query('select * from employees where id = '.$sup_id.' and status = "active"');
	  
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
		'appraisal_period' ,'training1', 'training2', 'training3', 'score_summary' ));
	}
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
	function get_branch_names() {
		//---------------------------------------get $emps-------------------------------------------------------------
		$this->loadModel('Branch');
		
		$branches = array();
	
		$branch_rows= $this->Branch->query('select * from branches ');
		
		
		for($i = 0 ; $i < count($branch_rows) ; $i++){
	  		
			 $branches[$branch_rows[$i]['branches']['id']] = $branch_rows[$i]['branches']['name']."-".$branch_rows[$i]['branches']['id'];
			
		}
	//--------------------------------------end of get $emps---------------------------------------------------------
			 return $branches;
		
	}
	function get_branch_names_excel() {
		//---------------------------------------get $emps-------------------------------------------------------------
		$this->loadModel('Branch');
		
		$branches = array();
		$branches['-3'] = "All";
		$branches['-2'] = "Head Office";

	
		$branch_rows= $this->Branch->query('select * from branches where branch_category_id = 1 and id != 0');
		
		
		for($i = 0 ; $i < count($branch_rows) ; $i++){
	  		
			 $branches[$branch_rows[$i]['branches']['id']] = $branch_rows[$i]['branches']['name']."-".$branch_rows[$i]['branches']['id'];
			
		}
	//--------------------------------------end of get $emps---------------------------------------------------------
			 return $branches;
		
	}
	function get_emp_ids() {
		//---------------------------------------get $emps-------------------------------------------------------------
		$this->loadModel('Employee');
		
		$emps = array();
	
		$emp_rows= $this->Employee->query('select * from employees where status = "active"');
		
		
		for($i = 0 ; $i < count($emp_rows) ; $i++){ 

			 $emp_id = $emp_rows[$i]['employees']['id'];
				$emps[$i] = $emp_id;

		  }
	//--------------------------------------end of get $emps---------------------------------------------------------
			 return $emps;
		
		 }
		 function get_emp_ids_excel($branch_type, $continue) {
			//---------------------------------------get $emps-------------------------------------------------------------
			
			$this->loadModel('Employee');
			$this->loadModel('EmployeeDetail');
			$this->loadModel('Branch');

		//	$branch_type = 64;
   $last_emp_id = 0;
   $this->loadModel('PerformanceExcelReport');
   if($continue == 'yes'){ //find the last emp_id
    
    $last_row = $this->PerformanceExcelReport->query('select * from  performance_excel_reports limit 1 order by id desc ');
    if(count($last_row) > 0){
       $last_emp_id = $last_row[0]['performance_excel_reports']['employee_id'];
    }
    
   } else { //truncate table
    $this->PerformanceExcelReport->query('truncate table performance_excel_reports  ');
   }
			
			$emps = array();
			if($branch_type == -3){ //all
				$emp_rows= $this->Employee->query('select e.id from employees e where status = "active" and e.id >= '.$last_emp_id);
			}
	//		else if($branch_type == -2){ //head office
	//			$emp_rows= $this->Employee->query('select e.id from employees e inner join employee_details ed 
	//			on e.id = ed.employee_id inner join branches b
	//			on ed.branch_id = b.id
	//			where ed.end_date = "0000-00-00" and e.status = "active" and b.branch_category_id = 2
	//			');
	//		}
	//		else { // single branch
	//			$emp_rows= $this->Employee->query('select e.id from employees e inner join employee_details ed 
	//			on e.id = ed.employee_id 
	//			where ed.branch_id = '.$branch_type.' and ed.end_date = "0000-00-00" and e.status = "active"
	//			');
	//		}

		//	print_r($emp_rows);
		
			for($i = 0 ; $i < count($emp_rows) ; $i++){ 
	
				
				 $emp_id = $emp_rows[$i]['e']['id'];
					$emps[$i] = $emp_id;
	
			  }
		//--------------------------------------end of get $emps---------------------------------------------------------
				 return $emps;
			
			 }
		 function get_branch_ids() {
			//---------------------------------------get $emps-------------------------------------------------------------
			$this->loadModel('Branch');
			
			$branches = array();
		
			$branch_rows= $this->Branch->query('select * from branches where branch_category_id = 1  ');
			
			
			for($i = 0 ; $i < count($branch_rows) ; $i++){ 
	
				 $branch_id = $branch_rows[$i]['branches']['id'];
					$branches[$i] = $branch_id;
	
			  }
		//--------------------------------------end of get $emps---------------------------------------------------------
				 return $branches;
			
			 }
	
	function index() {
	}
	

	function search() {
	}
	
	function list_data($id = null) {
		$start = (isset($_REQUEST['start'])) ? $_REQUEST['start'] : 0;
		$limit = (isset($_REQUEST['limit'])) ? $_REQUEST['limit'] : 5;
        $conditions = (isset($_REQUEST['conditions'])) ? $_REQUEST['conditions'] : '';

        eval("\$conditions = array( " . $conditions . " );");
		
		$this->set('competenceCategories', $this->CompetenceCategory->find('all', array('conditions' => $conditions, 'limit' => $limit, 'offset' => $start)));
		$this->set('results', $this->CompetenceCategory->find('count', array('conditions' => $conditions)));
	}

	function view($id = null) {
		if (!$id) {
			$this->Session->setFlash(__('Invalid competence category', true));
			$this->redirect(array('action' => 'index'));
		}
		$this->CompetenceCategory->recursive = 2;
		$this->set('competenceCategory', $this->CompetenceCategory->read(null, $id));
	}

	function add($id = null) {
		if (!empty($this->data)) {
			$original_data = $this->data;
			$category_name = str_replace("'", "`", $original_data['CompetenceCategory']['name']);
      $category_name = str_replace('"', "`", $category_name);
      $category_name = str_replace(',', " ", $category_name);
			$original_data['CompetenceCategory']['name'] = $category_name;
			$categories_row = $this->CompetenceCategory->query("select * from competence_categories where  name = '".$category_name."'");
			
			if(count($categories_row) == 0) { 
				$this->CompetenceCategory->create();
				$this->autoRender = false;
			//	if ($this->CompetenceCategory->save($this->data)) {
				if ($this->CompetenceCategory->save($original_data)) {
					$this->Session->setFlash(__('The competence category has been saved', true), '');
					$this->render('/elements/success');
				} else {
					$this->Session->setFlash(__('The competence category could not be saved. Please, try again.', true), '');
					$this->render('/elements/failure');
				}
			}
			else {
				$this->Session->setFlash(__('The category has already been saved.', true), '');
				$this->render('/elements/failure3');
			}

			
		}
	}

	function edit($id = null, $parent_id = null) {
		if (!$id && empty($this->data)) {
			$this->Session->setFlash(__('Invalid competence category', true), '');
			$this->redirect(array('action' => 'index'));
		}
		if (!empty($this->data)) {
			$original_data = $this->data;
			$category_id = $original_data['CompetenceCategory']['id'];
			$category_name = str_replace("'", "`", $original_data['CompetenceCategory']['name']);
      $category_name = str_replace('"', "`", $category_name);
      $category_name = str_replace(',', " ", $category_name);
			$original_data['CompetenceCategory']['name'] = $category_name;
			$categories_row = $this->CompetenceCategory->query("select * from competence_categories where id != ".$category_id." and name = '".$category_name."'");
			
			if(count($categories_row) == 0) {
				$this->autoRender = false;
				if ($this->CompetenceCategory->save($this->data)) {
					$this->Session->setFlash(__('The competence category has been saved', true), '');
					$this->render('/elements/success');
				} else {
					$this->Session->setFlash(__('The competence category could not be saved. Please, try again.', true), '');
					$this->render('/elements/failure');
				}

			 }else{

				$this->Session->setFlash(__('The category has already been saved.', true), '');
				$this->render('/elements/failure3');
			}

			
		}
		$this->set('competence_category', $this->CompetenceCategory->read(null, $id));
		
			
	}

	function delete($id = null) {
		$this->autoRender = false;
		if (!$id) {
			$this->Session->setFlash(__('Invalid id for competence category', true), '');
			$this->render('/elements/failure');
		}
		if (stripos($id, '_') !== false) {
            $ids = explode('_', $id);
            try{
                foreach ($ids as $i) {
                    $this->CompetenceCategory->delete($i);
                }
				$this->Session->setFlash(__('Competence category deleted', true), '');
				$this->render('/elements/success');
            }
            catch (Exception $e){
				$this->Session->setFlash(__('Competence category was not deleted', true), '');
				$this->render('/elements/failure');
            }
        } else {
            if ($this->CompetenceCategory->delete($id)) {
				$this->Session->setFlash(__('Competence category deleted', true), '');
				$this->render('/elements/success');
			} else {
				$this->Session->setFlash(__('Competence category was not deleted', true), '');
				$this->render('/elements/failure');
			}
        }
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

		function br_objectives_report($data = null){
			
			$branch_name = '' ;
			$dept_name = '';
			$appraisal_period = '';
			$immediate_supervisor_name = 'no name';
			$score_summary = 0;
			$actual_total_weight = 0;
		
			
	//		$emps = $this->get_emp_names();
	// find quarter, budget_year, emp_id ------------------------------------------------------------------------------------
			 
	$data_arr = explode("-", $data);
	$br_id = $data_arr[0];
	$budget_year_id = $data_arr[1];
	$this->loadModel('BudgetYear');
	$conditions3 = array('BudgetYear.id' => $budget_year_id );
	$hoBudgetYear = $this->BudgetYear->find('first', array('conditions' => $conditions3));
	$budget_year  = $hoBudgetYear['BudgetYear']['name'];
	$quarter = $data_arr[2];
	//find out if it is branch or not--------------------------------------------------------------------------
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

	$appraisal_period = $budget_year." [quarter ".$qrtr. "]";	
	
	// end of find appraisal period-----------------------------------------------------------------
	// get department/district-------------------------------------------------------------------------------------------------------
	
	$this->loadModel('Branch');
	$branch_row = $this->Branch->query('select * from branches where id = '.$br_id.'');

	$dept_name = $branch_row[0]['branches']['name'];
   $district_name = $branch_row[0]['branches']['district_name'];
	$branch_mgr_name = $branch_row[0]['branches']['branch_manager_name'];
	
	// end of get department/district------------------------------------------------------------------------------------------------

			// find ho_plan_id----------------------------------------------------------------------------------------------------------
	$br_plan_id = 0;
	$this->loadModel('BranchPerformancePlan');
	$performance_plan_row = $this->BranchPerformancePlan->query('select * from branch_performance_plans
				where branch_id = '. $br_id .' and budget_year_id = '. $budget_year_id.' and quarter = '.$quarter);
		if(count($performance_plan_row) > 0){
			$br_plan_id = $performance_plan_row[0]['branch_performance_plans']['id'];
		}
	

	//-------end of find ho plan id------------------------------------------------------------------------------------------------		
	$this->loadModel('BranchPerformanceDetail');
	$this->loadModel('BranchEvaluationCriteria');
	$objective_table = array();
			$obj_one_row = array();

			$brPlanObj = $this->BranchPerformanceDetail->query('select * from branch_performance_details 
				where branch_performance_plan_id = '. $br_plan_id .' ');
	
			 for($j = 0; $j < count($brPlanObj) ; $j++){
				$criteria_row = $this->BranchEvaluationCriteria->query('select * from branch_evaluation_criterias
				where id = '. $brPlanObj[$j]['branch_performance_details']['branch_evaluation_criteria_id'] .'' );

				$actual_total_weight += $criteria_row[0]['branch_evaluation_criterias']['weight'];

				$obj_one_row['objective'] = $criteria_row[0]['branch_evaluation_criterias']['goal'];
				
				$obj_one_row['measure'] = $criteria_row[0]['branch_evaluation_criterias']['measure'];
				$obj_one_row['target'] = $criteria_row[0]['branch_evaluation_criterias']['target'];
				$obj_one_row['weight'] = $criteria_row[0]['branch_evaluation_criterias']['weight'];
				$obj_one_row['direction'] = $criteria_row[0]['branch_evaluation_criterias']['direction'];

				$obj_one_row['plan'] = $brPlanObj[$j]['branch_performance_details']['plan_in_number'];
				$obj_one_row['actual'] = $brPlanObj[$j]['branch_performance_details']['actual_result'];
				$obj_one_row['accomplishment'] = $brPlanObj[$j]['branch_performance_details']['accomplishment'];
				$obj_one_row['rating'] = $brPlanObj[$j]['branch_performance_details']['rating'];
				$obj_one_row['final_result'] = $brPlanObj[$j]['branch_performance_details']['final_result'];

				


				$score_summary += $brPlanObj[$j]['branch_performance_details']['final_result'];
				array_push($objective_table, $obj_one_row);
	
			 }

			 	 //-----------------find supervisor id-------------------------------------------------------------------------------


				 $immediate_supervisor_name = $branch_mgr_name;
			  
		 
			 //---------------end of find supervisor id----------------------------------------------------------------------------	
			 //------------------------------------------end of find immediate supervisor------------------------------------------

			 $this->set(compact ('objective_table', 'br_id' , 'dept_name','district_name', 'immediate_supervisor_name',
			'appraisal_period' , 'score_summary', 'actual_total_weight', 'br_id', 'budget_year_id', 'quarter' ));


	}

	function change_status_branch_hr($id = null, $parent_id = null) {
		if (!$id && empty($this->data)) {
			$this->Session->setFlash(__('Invalid br performance plan', true), '');
			$this->redirect(array('action' => 'index'));
		}
		if (!empty($this->data)) {
			
			$original_data = $this->data;
			// $id = $original_data['HoPerformancePlan']['id'];
			$this->loadModel('BranchPerformancePlan');
			

				$id = $original_data['CompetenceCategory']['id'];
				$br_plan_id_array = explode("-",$id);
			 $br_id = $br_plan_id_array[0];
			 
			 $budget_year_id = $br_plan_id_array[1];
			 $quarter = $br_plan_id_array[2];
			 
			$plan_status = $original_data['CompetenceCategory']['plan_status'];
			$result_status = $original_data['CompetenceCategory']['result_status'];
			$comment = $original_data['CompetenceCategory']['comment'];

			$select_status = $this->BranchPerformancePlan->query('select * from branch_performance_plans where branch_id = '.$br_id. 
			' and budget_year_id = '.$budget_year_id.' and quarter = '.$quarter);

			if($plan_status > 2){
				if(count($select_status) > 0){
					$update_status = $this->BranchPerformancePlan->query('update branch_performance_plans set  result_status = '.$result_status.' 
					 , plan_status = '.$plan_status.' where  branch_id = '.$br_id.' and budget_year_id = '.$budget_year_id.' and quarter = '.$quarter);
							
						$this->Session->setFlash(__('The status has been changed successfully', true), '');
						$this->render('/elements/success');
				}
				else {
	
					$this->Session->setFlash(__('No data found!.', true), '');
					$this->render('/elements/failure3');
				}
			}
			else{
				if($result_status < 2){
					if(count($select_status) > 0){
						$update_status = $this->BranchPerformancePlan->query('update branch_performance_plans set  result_status = '.$result_status.' 
						 , plan_status = '.$plan_status.' where  branch_id = '.$br_id.' and budget_year_id = '.$budget_year_id.' and quarter = '.$quarter);
								
							$this->Session->setFlash(__('The status has been changed successfully', true), '');
							$this->render('/elements/success');
					}
					else {
		
						$this->Session->setFlash(__('No data found!.', true), '');
						$this->render('/elements/failure3');
					}
				}
				else{
					$this->Session->setFlash(__('Invalid input!.', true), '');
					$this->render('/elements/failure3');
				}
			}

			
   	
				
		}

		$br_plan_id_array = explode("-",$id);
        
		$br_id = $br_plan_id_array[0];
		$budget_year_id = $br_plan_id_array[1];
		$quarter = $br_plan_id_array[2];

		$this->loadModel('BranchPerformancePlan');
		

	   // $this->set('ho_performance_plan', $this->HoPerformancePlan->read(null, $id));

	   $this->set('competence_category', $this->BranchPerformancePlan->find('first', 
	   array('conditions' => array('BranchPerformancePlan.branch_id' => $br_id, 
	   'BranchPerformancePlan.budget_year_id' => $budget_year_id,
	   'BranchPerformancePlan.quarter' => $quarter,

   ))));


  	 $this->set('br_plan_id', $id);
		
	//	$this->set('branch_performance_plan', $this->BranchPerformancePlan->read(null, $id));
		
	}

	function change_status_br_hr($id = null, $parent_id = null) {
		if (!$id && empty($this->data)) {
			$this->Session->setFlash(__('Invalid br performance plan', true), '');
			$this->redirect(array('action' => 'index'));
		}
		if (!empty($this->data)) {
			
			$original_data = $this->data;
			// $id = $original_data['HoPerformancePlan']['id'];
			$this->loadModel('BranchPerformanceTrackingStatus');
			

				$id = $original_data['CompetenceCategory']['id'];
				$br_plan_id_array = explode("-",$id);
			 $e_id = $br_plan_id_array[0];
			 
			 $budget_year_id = $br_plan_id_array[1];
			 $quarter = $br_plan_id_array[2];
			 

			$result_status = $original_data['CompetenceCategory']['result_status'];
			$comment = $original_data['CompetenceCategory']['comment'];

			$select_status = $this->BranchPerformanceTrackingStatus->query('select * from branch_performance_tracking_statuses where employee_id = '.$e_id. 
			' and budget_year_id = '.$budget_year_id.' and quarter = '.$quarter);

			if(count($select_status) > 0){
				$update_status = $this->BranchPerformanceTrackingStatus->query('update branch_performance_tracking_statuses set  result_status = '.$result_status.' 
				where  employee_id = '.$e_id.' and budget_year_id = '.$budget_year_id.' and quarter = '.$quarter);
						
					$this->Session->setFlash(__('The status has been changed successfully', true), '');
					$this->render('/elements/success');
			}
			else {

			//	$this->Session->setFlash(__('No data found!.', true), '');
			//	$this->render('/elements/failure3');
        
        $insert_status = $this->BranchPerformanceTrackingStatus->query('insert into branch_performance_tracking_statuses(employee_id, budget_year_id, quarter, result_status)   
				 values('.$e_id.' , '.$budget_year_id.' , '.$quarter.', '.$result_status.') '
				);

				//$this->Session->setFlash(__('No data found!.', true), '');
				//$this->render('/elements/failure3');
				$this->Session->setFlash(__('The status has been changed successfully', true), '');
					$this->render('/elements/success');
			}
   
			
				
		}

		$br_plan_id_array = explode("-",$id);
        
		$e_id = $br_plan_id_array[0];
		$budget_year_id = $br_plan_id_array[1];
		$quarter = $br_plan_id_array[2];

		$this->loadModel('BranchPerformanceTrackingStatus');
		

	   // $this->set('ho_performance_plan', $this->HoPerformancePlan->read(null, $id));

	   $this->set('competence_category', $this->BranchPerformanceTrackingStatus->find('first', 
	   array('conditions' => array('BranchPerformanceTrackingStatus.employee_id' => $e_id, 
	   'BranchPerformanceTrackingStatus.budget_year_id' => $budget_year_id,
	   'BranchPerformanceTrackingStatus.quarter' => $quarter,

   ))));


  	 $this->set('br_plan_id', $id);
		
	//	$this->set('branch_performance_plan', $this->BranchPerformancePlan->read(null, $id));
		
	}

	function change_status_ho_hr($id = null, $parent_id = null) {
		if (!$id && empty($this->data)) {
			$this->Session->setFlash(__('Invalid br performance plan', true), '');
			$this->redirect(array('action' => 'index'));
		}
		if (!empty($this->data)) {
			
			$original_data = $this->data;
			// $id = $original_data['HoPerformancePlan']['id'];
			$this->loadModel('HoPerformancePlan');
			

				$id = $original_data['CompetenceCategory']['id'];
				$br_plan_id_array = explode("-",$id);
			 $e_id = $br_plan_id_array[0];
			 
			 $budget_year_id = $br_plan_id_array[1];
			 $quarter = $br_plan_id_array[2];
			 
			$plan_status = $original_data['CompetenceCategory']['plan_status'];
			$result_status = $original_data['CompetenceCategory']['result_status'];
			$comment = $original_data['CompetenceCategory']['comment'];

			$select_status = $this->HoPerformancePlan->query('select * from ho_performance_plans where employee_id = '.$e_id. 
			' and budget_year_id = '.$budget_year_id.' and quarter = '.$quarter);
			if(count($select_status)){
				if($plan_status > 2){
					$update_status = $this->HoPerformancePlan->query('update ho_performance_plans set  plan_status = '.$plan_status.' , result_status = '.$result_status.' 
					where  employee_id = '.$e_id.' and budget_year_id = '.$budget_year_id.' and quarter = '.$quarter);
							
						$this->Session->setFlash(__('The status has been changed successfully', true), '');
						$this->render('/elements/success');
				}
				else {
					if($result_status < 2){
						$update_status = $this->HoPerformancePlan->query('update ho_performance_plans set  plan_status = '.$plan_status.' , result_status = '.$result_status.' 
					where  employee_id = '.$e_id.' and budget_year_id = '.$budget_year_id.' and quarter = '.$quarter);
							
						$this->Session->setFlash(__('The status has been changed successfully', true), '');
						$this->render('/elements/success');
	
					}
					else {
	
						$this->Session->setFlash(__('Invalid status.', true), '');
						$this->render('/elements/failure3');
	
					}
	
				}
			}
			else{
				$this->Session->setFlash(__('No data found!.', true), '');
				$this->render('/elements/failure3');
			}

			
   
			
				
		}

		$br_plan_id_array = explode("-",$id);
        
		$e_id = $br_plan_id_array[0];
		$budget_year_id = $br_plan_id_array[1];
		$quarter = $br_plan_id_array[2];

		$this->loadModel('HoPerformancePlan');

	   // $this->set('ho_performance_plan', $this->HoPerformancePlan->read(null, $id));

	   $this->set('competence_category', $this->HoPerformancePlan->find('first', 
	   array('conditions' => array('HoPerformancePlan.employee_id' => $e_id, 
	   'HoPerformancePlan.budget_year_id' => $budget_year_id,
	   'HoPerformancePlan.quarter' => $quarter,

   ))));


  	 $this->set('br_plan_id', $id);
		
	//	$this->set('branch_performance_plan', $this->BranchPerformancePlan->read(null, $id));
		
	}

	function change_status_bh_hr($id = null, $parent_id = null) {

		$this->loadModel('CompetenceResult');

		if (!$id && empty($this->data)) {
			$this->Session->setFlash(__('Invalid br performance plan', true), '');
			$this->redirect(array('action' => 'index'));
		}
		if (!empty($this->data)) {
			
			$original_data = $this->data;
			// $id = $original_data['HoPerformancePlan']['id'];
		//	$this->loadModel('BranchPerformanceTrackingStatus');			

			 $id = $original_data['CompetenceCategory']['id'];
			 $br_plan_id_array = explode("-",$id);
			 $e_id = $br_plan_id_array[0];
			 
			 $budget_year_id = $br_plan_id_array[1];
			 $quarter = $br_plan_id_array[2];
			 

			$result_status = $original_data['CompetenceCategory']['result_status'];
			$comment = $original_data['CompetenceCategory']['comment'];

			$select_status = $this->CompetenceResult->query('select * from competence_results where employee_id = '.$e_id. 
			' and budget_year_id = '.$budget_year_id.' and quarter = '.$quarter);

			if(count($select_status) > 0){
				$update_status = $this->CompetenceResult->query('update competence_results set  result_status = '.$result_status.' 
				where  employee_id = '.$e_id.' and budget_year_id = '.$budget_year_id.' and quarter = '.$quarter);
						
					$this->Session->setFlash(__('The status has been changed successfully', true), '');
					$this->render('/elements/success');
			}
			else {

				$this->Session->setFlash(__('No data found!.', true), '');
				$this->render('/elements/failure3');
			}
   
				
		}

		$br_plan_id_array = explode("-",$id);
        
		$e_id = $br_plan_id_array[0];
		$budget_year_id = $br_plan_id_array[1];
		$quarter = $br_plan_id_array[2];

		// $this->loadModel('BranchPerformanceTrackingStatus');
		

	   // $this->set('ho_performance_plan', $this->HoPerformancePlan->read(null, $id));

	   $this->set('competence_category', $this->CompetenceResult->find('first', 
	   array('conditions' => array('CompetenceResult.employee_id' => $e_id, 
	   'CompetenceResult.budget_year_id' => $budget_year_id,
	   'CompetenceResult.quarter' => $quarter,

   ))));


  	 $this->set('br_plan_id', $id);
		
	//	$this->set('branch_performance_plan', $this->BranchPerformancePlan->read(null, $id));
		
	}

		function ho_ind_objectives_report($data = null){  //here we have to decide where in that quarter(branch or head office)
			//	$emp_id = 3915 ;
			$full_name = '' ;
			$position_name = '' ;
			$dept_name = '';
			$appraisal_period = '';
			$immediate_supervisor_name = 'no name';
			$score_summary = 0;
			$score_summary_aggregate = 0;
			$branch_result = 0;
			$supervisor_score = 0;
			$aggregate_score = 0; // including both self and supervisor
			$total_weight = 0;
			$is_branch = 0;
			$training1 = '';
			$training2 = '';
			$training3 = '';
	//		$emps = $this->get_emp_names();


	// find quarter, budget_year, emp_id ------------------------------------------------------------------------------------
			 
	$data_arr = explode("-", $data);
	$e_id = $data_arr[0];
	$budget_year_id = $data_arr[1];
	$this->loadModel('BudgetYear');
	$conditions3 = array('BudgetYear.id' => $budget_year_id );
	$hoBudgetYear = $this->BudgetYear->find('first', array('conditions' => $conditions3));
	$budget_year  = $hoBudgetYear['BudgetYear']['name'];
	$quarter = $data_arr[2];
	//find out if it is branch or not--------------------------------------------------------------------------
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

		$position_id = 0;
		$branch_id = 0;
		
	$branch_id_for_quarter_row = $this->get_each_quarter_position($e_id, $from_date, $to_date , $quarter );
	if(count($branch_id_for_quarter_row)){
		$position_id = $branch_id_for_quarter_row[0]['employee_details']['position_id'];
		$branch_id = $branch_id_for_quarter_row[0]['employee_details']['branch_id'];
	}
	
	$this->loadModel('Branch');

	$branch_type_row =  $this->Branch->query('select * from branches 
	where id = '. $branch_id .' ');
  	$branch_type = $branch_type_row[0]['branches']['branch_category_id'];


	//----end of find out if it is branch or not----------------------------------------------------------------


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

	

	$appraisal_period = $budget_year." [quarter ".$qrtr. "]";	
	
	// end of find quarter, budget_year, emp_id-----------------------------------------------------------------
	
	// get position------------------------------------------------------------------------------------------------------------
		$this->loadModel('Employee');
		$this->loadModel('EmployeeDetail');
		$this->loadModel('Position');
	//	$position_id_row = $this->EmployeeDetail->query('select * from employee_details 
	//			where employee_id = '. $e_id .' ');
	//	$position_id = $position_id_row[0]['employee_details']['position_id'];
	//	$branch_id = $position_id_row[0]['employee_details']['branch_id'];
	$position_name = "";
		$position_name_row = $this->Position->query('select * from positions
		where id = '. $position_id .' ');
		if(count($position_name_row) > 0){
			$position_name = $position_name_row[0]['positions']['name'];
		}
		
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
	$branch_row = $this->Branch->query('select * from branches where id = '.$branch_id.'');
	$dept_name = $branch_row[0]['branches']['name'];
	
	// end of get department/district------------------------------------------------------------------------------------------------
	$this->loadModel('HoPerformanceDetail');	
	
			$objective_table = array();
			$obj_one_row = array();

	//--------------------------------------this is where we decide  which way to go (HO or branch)-----------------------------
	if($branch_type == 1){  //----------means it is branch-----------------------------------------------------------------------

		$this->loadModel('BranchPerformanceTrackingStatus');
	$performance_plan_row = $this->BranchPerformanceTrackingStatus->query('select * from branch_performance_tracking_statuses
				where employee_id = '. $e_id .' and budget_year_id = '. $budget_year_id.' and quarter = '.$quarter);
				$result_status = "Pending agreement";
				$comment = "";
		if(count($performance_plan_row) > 0){
		//	$ho_plan_id = $performance_plan_row[0]['branch_performance_tracking_statuses']['id'];
      	//	$plan_status = $performance_plan_row[0]['branch_performance_tracking_statuses']['plan_status'];
			$result_status = $performance_plan_row[0]['branch_performance_tracking_statuses']['result_status'];
			$comment = $performance_plan_row[0]['branch_performance_tracking_statuses']['comment'];

			if($result_status == 1){
				$result_status = "Pending agreement";
			}
			if($result_status == 2){
				$result_status = "Agreed";
			}
			if($result_status == 3){
				$result_status = "Agreed with reservation";
			}
		}
			//------------------------------------get the trackings--------------------------------------------------------------------------
	$is_branch = 1;
	$this->loadModel('BranchPerformanceSetting');
	$this->loadModel('BranchPerformanceTracking');
 
	$branch_setting_row = $this->BranchPerformanceSetting->query('select * from branch_performance_settings where position_id = '. $position_id);
	foreach($branch_setting_row as $item){
		$each_total_goal = 0;
		$each_total_rating = 0;
			$obj_one_row['objective'] = $item['branch_performance_settings']['goal'];
			$obj_one_row['target'] = $item['branch_performance_settings']['target'];
			$obj_one_row['measure'] = $item['branch_performance_settings']['measure'];
			$obj_one_row['weight'] = $item['branch_performance_settings']['weight'];
			$total_weight += $item['branch_performance_settings']['weight'];
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
		$obj_one_row['result_status'] = $result_status;
		$obj_one_row['comment'] = $comment;
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
		$score_summary_aggregate = round(0.75*($branch_result) + 0.25*($score_summary * 100 / $total_weight) , 2);
	  }
	  else {
		$score_summary_aggregate = round(0.6*($branch_result) + 0.4*($score_summary * 100 / $total_weight) , 2);
	  }
   }
	



	// $branch_setting_row = $this->BranchPerformanceSetting->query('select * from branch_performance_settings where position_id = '. $position_id);
	// foreach($branch_setting_row as $item){
	// 	$each_total_goal = 0;
	// 	$each_total_rating = 0;
	// 		$obj_one_row['objective'] = $item['branch_performance_settings']['goal'];
	// 		$obj_one_row['target'] = $item['branch_performance_settings']['target'];
	// 		$obj_one_row['measure'] = $item['branch_performance_settings']['measure'];
	// 		$obj_one_row['weight'] = $item['branch_performance_settings']['weight'];
	// 		$obj_one_row['date'] = $quarter_start_date. "-" . $quarter_end_date;
			
	// 		array_push($objective_table, $obj_one_row);
			

	// 		//just the none applicable once because they belong to head office-----------------------
			
	// 			$obj_one_row['kpis'] = "";
	// 			$obj_one_row['plan'] = "";
	// 			$obj_one_row['actual'] = "";
	// 			$obj_one_row['accomplishment'] = "";
	// 			$obj_one_row['total_score'] = "";
	// 			$obj_one_row['final_score'] = "";
	// 			$obj_one_row['supervisor_result'] = "";
	// 			$obj_one_row['aggregate_score'] = "";

	// 			  //----------------------------because they apply to head office only-----------------------------------
	// 			  $obj_one_row['plan_status'] = 1;
	// 			  $obj_one_row['result_status'] = 1;
	// 			  $obj_one_row['comment'] = " ";
	// 	  //----------------------------end because they apply to head office only-----------------------------------
	// 	$branch_tracking_row = $this->BranchPerformanceTracking->query('select * from branch_performance_trackings where employee_id = '. $e_id .' and goal = '.$item['branch_performance_settings']['id'].' and date between "'.$quarter_start_date.'" and "'.$quarter_end_date.'"');
	// 	foreach($branch_tracking_row as $item2){
	// 		// $obj_one_row['date'] = $item2['branch_performance_trackings']['date'];
			
	// 		$each_total_goal += $item2['branch_performance_trackings']['value'];

	// 	}

	// 	$obj_one_row['value'] = $each_total_goal;

	// 	if($each_total_goal > $item["branch_performance_settings"]["five_pointer_min"]  && $each_total_goal <= $item["branch_performance_settings"]["five_pointer_max_included"]){
	// 		$each_total_rating = 5 * $item["branch_performance_settings"]["weight"];
	// 	}
	// 	if($each_total_goal > $item["branch_performance_settings"]["four_pointer_min"]  && $each_total_goal <= $item["branch_performance_settings"]["four_pointer_max_included"]){
	// 		$each_total_rating = 4 * $item["branch_performance_settings"]["weight"];
	// 	}
	// 	if($each_total_goal > $item["branch_performance_settings"]["three_pointer_min"]  && $each_total_goal <= $item["branch_performance_settings"]["three_pointer_max_included"]){
	// 		$each_total_rating = 3 * $item["branch_performance_settings"]["weight"];
	// 	}
	// 	if($each_total_goal > $item["branch_performance_settings"]["two_pointer_min"]  && $each_total_goal <= $item["branch_performance_settings"]["two_pointer_max_included"]){
	// 		$each_total_rating = 2 * $item["branch_performance_settings"]["weight"];
	// 	}
	// 	if($each_total_goal > $item["branch_performance_settings"]["one_pointer_min"]  && $each_total_goal <= $item["branch_performance_settings"]["one_pointer_max_included"]){
	// 		$each_total_rating = 1 * $item["branch_performance_settings"]["weight"];
	// 	}

    //     $score_summary += $each_total_rating;

	// }




	//------------------------------------end of getting the trackings---------------------------------------------------------------

	} else { // means it is not branch
		$is_branch = 0;
			// find ho_plan_id----------------------------------------------------------------------------------------------------------
      
      $plan_status = "";
	$result_status = "";
	$comment = "";
	$ho_plan_id = 0;
 
	$this->loadModel('HoPerformancePlan');
	$performance_plan_row = $this->HoPerformancePlan->query('select * from ho_performance_plans
				where employee_id = '. $e_id .' and budget_year_id = '. $budget_year_id.' and quarter = '.$quarter);
		if(count($performance_plan_row) > 0){
			$ho_plan_id = $performance_plan_row[0]['ho_performance_plans']['id'];
      $plan_status = $performance_plan_row[0]['ho_performance_plans']['plan_status'];
			$result_status = $performance_plan_row[0]['ho_performance_plans']['result_status'];
			$comment = $performance_plan_row[0]['ho_performance_plans']['comment'];
			$obj_one_row['supervisor_result'] = $performance_plan_row[0]['ho_performance_plans']['spvr_technical_percent'];
			$obj_one_row['aggregate_score'] = $performance_plan_row[0]['ho_performance_plans']['both_technical_percent'];

			if($plan_status == 2){
				$plan_status = "Pending agreement";
			}
			if($plan_status == 3){
				$plan_status = "Agreed";
			}
			if($plan_status == 4){
				$plan_status = "Agreed with reservation";
			}
			if($result_status == 1){
				$result_status = "Pending agreement";
			}
			if($result_status == 2){
				$result_status = "Agreed";
			}
			if($result_status == 3){
				$result_status = "Agreed with reservation";
			}
		}
	

	//-------end of find ho plan id------------------------------------------------------------------------------------------------		
	
			$hoPlanObj = $this->HoPerformanceDetail->query('select * from ho_performance_details 
				where ho_performance_plan_id = '. $ho_plan_id .' ');
	
			 for($j = 0; $j < count($hoPlanObj) ; $j++){
				$obj_one_row['perspective'] = $hoPlanObj[$j]['ho_performance_details']['perspective'];
				$obj_one_row['objective'] = $hoPlanObj[$j]['ho_performance_details']['objective'];
				$obj_one_row['kpis'] = $hoPlanObj[$j]['ho_performance_details']['plan_description'];
				$obj_one_row['measure'] = $hoPlanObj[$j]['ho_performance_details']['measure'];
				$obj_one_row['weight'] = $hoPlanObj[$j]['ho_performance_details']['weight'];
				$obj_one_row['plan'] = $hoPlanObj[$j]['ho_performance_details']['plan_in_number'];
				$obj_one_row['actual'] = $hoPlanObj[$j]['ho_performance_details']['actual_result'];
				$obj_one_row['accomplishment'] = $hoPlanObj[$j]['ho_performance_details']['accomplishment'];
				$obj_one_row['total_score'] = $hoPlanObj[$j]['ho_performance_details']['total_score'];
				$obj_one_row['final_score'] = $hoPlanObj[$j]['ho_performance_details']['final_score'];

				$total_weight += $hoPlanObj[$j]['ho_performance_details']['weight'];

				$obj_one_row['date'] = "";
				$obj_one_row['target'] = "";
				$obj_one_row['value'] = "";
        
        //----------------------------because they apply to head office only-----------------------------------
       		    $obj_one_row['plan_status'] = $plan_status;
				$obj_one_row['result_status'] = $result_status;
				$obj_one_row['comment'] = $comment;
        //----------------------------end because they apply to head office only-----------------------------------

				$score_summary += $hoPlanObj[$j]['ho_performance_details']['final_score'];
				array_push($objective_table, $obj_one_row);
	
			 }

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
		
			$br_plan_id = $data;
			$this->set(compact ('objective_table', 'emp_id' , 'position_name' ,'full_name', 'dept_name', 'immediate_supervisor_name',
			'appraisal_period' ,'training1', 'training2', 'training3', 'score_summary','score_summary_aggregate','branch_result','total_weight', 'is_branch', 'br_plan_id',
		'budget_year_id','e_id','quarter' ));
	}
 
 	function ho_ind_objectives_report_excel($data = null){
		
		$output_type = 'EXCEL';
	
	//$budget_year_search = 14;
	
	$this->layout = 'ajax';	
		//here we have to decide where in that quarter(branch or head office)
		//	$emp_id = 3915 ;
		$full_name = '' ;
		$position_name = '' ;
		$dept_name = '';
		$appraisal_period = '';
		$immediate_supervisor_name = 'no name';
		$score_summary = 0;
		$score_summary_aggregate = 0;
		$branch_result = 0;
		$supervisor_score = 0;
		$aggregate_score = 0; // including both self and supervisor
		$total_weight = 0;
		$is_branch = 0;
		$training1 = '';
		$training2 = '';
		$training3 = '';
//		$emps = $this->get_emp_names();


// find quarter, budget_year, emp_id ------------------------------------------------------------------------------------
		 
$data_arr = explode("-", $data);
$e_id = $data_arr[0];
$budget_year_id = $data_arr[1];
$this->loadModel('BudgetYear');
$conditions3 = array('BudgetYear.id' => $budget_year_id );
$hoBudgetYear = $this->BudgetYear->find('first', array('conditions' => $conditions3));
$budget_year  = $hoBudgetYear['BudgetYear']['name'];
$quarter = $data_arr[2];
//find out if it is branch or not--------------------------------------------------------------------------
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

	$position_id = 0;
	$branch_id = 0;
	
$branch_id_for_quarter_row = $this->get_each_quarter_position($e_id, $from_date, $to_date , $quarter );
if(count($branch_id_for_quarter_row)){
	$position_id = $branch_id_for_quarter_row[0]['employee_details']['position_id'];
	$branch_id = $branch_id_for_quarter_row[0]['employee_details']['branch_id'];
}

$this->loadModel('Branch');

$branch_type_row =  $this->Branch->query('select * from branches 
where id = '. $branch_id .' ');
  $branch_type = $branch_type_row[0]['branches']['branch_category_id'];


//----end of find out if it is branch or not----------------------------------------------------------------


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



$appraisal_period = $budget_year." [quarter ".$qrtr. "]";	

// end of find quarter, budget_year, emp_id-----------------------------------------------------------------

// get position------------------------------------------------------------------------------------------------------------
	$this->loadModel('Employee');
	$this->loadModel('EmployeeDetail');
	$this->loadModel('Position');
//	$position_id_row = $this->EmployeeDetail->query('select * from employee_details 
//			where employee_id = '. $e_id .' ');
//	$position_id = $position_id_row[0]['employee_details']['position_id'];
//	$branch_id = $position_id_row[0]['employee_details']['branch_id'];
$position_name = "";
	$position_name_row = $this->Position->query('select * from positions
	where id = '. $position_id .' ');
	if(count($position_name_row) > 0){
		$position_name = $position_name_row[0]['positions']['name'];
	}
	
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
$branch_row = $this->Branch->query('select * from branches where id = '.$branch_id.'');
$dept_name = $branch_row[0]['branches']['name'];

// end of get department/district------------------------------------------------------------------------------------------------
$this->loadModel('HoPerformanceDetail');	

		$objective_table = array();
		$obj_one_row = array();

//--------------------------------------this is where we decide  which way to go (HO or branch)-----------------------------
if($branch_type == 1){  //----------means it is branch-----------------------------------------------------------------------

	$this->loadModel('BranchPerformanceTrackingStatus');
$performance_plan_row = $this->BranchPerformanceTrackingStatus->query('select * from branch_performance_tracking_statuses
			where employee_id = '. $e_id .' and budget_year_id = '. $budget_year_id.' and quarter = '.$quarter);
			$result_status = "Pending agreement";
			$comment = "";
	if(count($performance_plan_row) > 0){
	//	$ho_plan_id = $performance_plan_row[0]['branch_performance_tracking_statuses']['id'];
	  //	$plan_status = $performance_plan_row[0]['branch_performance_tracking_statuses']['plan_status'];
		$result_status = $performance_plan_row[0]['branch_performance_tracking_statuses']['result_status'];
		$comment = $performance_plan_row[0]['branch_performance_tracking_statuses']['comment'];

		if($result_status == 1){
			$result_status = "Pending agreement";
		}
		if($result_status == 2){
			$result_status = "Agreed";
		}
		if($result_status == 3){
			$result_status = "Agreed with reservation";
		}
	}
		//------------------------------------get the trackings--------------------------------------------------------------------------
$is_branch = 1;
$this->loadModel('BranchPerformanceSetting');
$this->loadModel('BranchPerformanceTracking');

$branch_setting_row = $this->BranchPerformanceSetting->query('select * from branch_performance_settings where position_id = '. $position_id);
foreach($branch_setting_row as $item){
	$each_total_goal = 0;
	$each_total_rating = 0;
		$obj_one_row['objective'] = $item['branch_performance_settings']['goal'];
		$obj_one_row['target'] = $item['branch_performance_settings']['target'];
		$obj_one_row['measure'] = $item['branch_performance_settings']['measure'];
		$obj_one_row['weight'] = $item['branch_performance_settings']['weight'];
		$total_weight += $item['branch_performance_settings']['weight'];
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
	$obj_one_row['result_status'] = $result_status;
	$obj_one_row['comment'] = $comment;
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
	$score_summary_aggregate = round(0.75*($branch_result) + 0.25*($score_summary * 100 / $total_weight) , 2);
  }
  else {
	$score_summary_aggregate = round(0.6*($branch_result) + 0.4*($score_summary * 100 / $total_weight) , 2);
  }
}




// $branch_setting_row = $this->BranchPerformanceSetting->query('select * from branch_performance_settings where position_id = '. $position_id);
// foreach($branch_setting_row as $item){
// 	$each_total_goal = 0;
// 	$each_total_rating = 0;
// 		$obj_one_row['objective'] = $item['branch_performance_settings']['goal'];
// 		$obj_one_row['target'] = $item['branch_performance_settings']['target'];
// 		$obj_one_row['measure'] = $item['branch_performance_settings']['measure'];
// 		$obj_one_row['weight'] = $item['branch_performance_settings']['weight'];
// 		$obj_one_row['date'] = $quarter_start_date. "-" . $quarter_end_date;
		
// 		array_push($objective_table, $obj_one_row);
		

// 		//just the none applicable once because they belong to head office-----------------------
		
// 			$obj_one_row['kpis'] = "";
// 			$obj_one_row['plan'] = "";
// 			$obj_one_row['actual'] = "";
// 			$obj_one_row['accomplishment'] = "";
// 			$obj_one_row['total_score'] = "";
// 			$obj_one_row['final_score'] = "";
// 			$obj_one_row['supervisor_result'] = "";
// 			$obj_one_row['aggregate_score'] = "";

// 			  //----------------------------because they apply to head office only-----------------------------------
// 			  $obj_one_row['plan_status'] = 1;
// 			  $obj_one_row['result_status'] = 1;
// 			  $obj_one_row['comment'] = " ";
// 	  //----------------------------end because they apply to head office only-----------------------------------
// 	$branch_tracking_row = $this->BranchPerformanceTracking->query('select * from branch_performance_trackings where employee_id = '. $e_id .' and goal = '.$item['branch_performance_settings']['id'].' and date between "'.$quarter_start_date.'" and "'.$quarter_end_date.'"');
// 	foreach($branch_tracking_row as $item2){
// 		// $obj_one_row['date'] = $item2['branch_performance_trackings']['date'];
		
// 		$each_total_goal += $item2['branch_performance_trackings']['value'];

// 	}

// 	$obj_one_row['value'] = $each_total_goal;

// 	if($each_total_goal > $item["branch_performance_settings"]["five_pointer_min"]  && $each_total_goal <= $item["branch_performance_settings"]["five_pointer_max_included"]){
// 		$each_total_rating = 5 * $item["branch_performance_settings"]["weight"];
// 	}
// 	if($each_total_goal > $item["branch_performance_settings"]["four_pointer_min"]  && $each_total_goal <= $item["branch_performance_settings"]["four_pointer_max_included"]){
// 		$each_total_rating = 4 * $item["branch_performance_settings"]["weight"];
// 	}
// 	if($each_total_goal > $item["branch_performance_settings"]["three_pointer_min"]  && $each_total_goal <= $item["branch_performance_settings"]["three_pointer_max_included"]){
// 		$each_total_rating = 3 * $item["branch_performance_settings"]["weight"];
// 	}
// 	if($each_total_goal > $item["branch_performance_settings"]["two_pointer_min"]  && $each_total_goal <= $item["branch_performance_settings"]["two_pointer_max_included"]){
// 		$each_total_rating = 2 * $item["branch_performance_settings"]["weight"];
// 	}
// 	if($each_total_goal > $item["branch_performance_settings"]["one_pointer_min"]  && $each_total_goal <= $item["branch_performance_settings"]["one_pointer_max_included"]){
// 		$each_total_rating = 1 * $item["branch_performance_settings"]["weight"];
// 	}

//     $score_summary += $each_total_rating;

// }




//------------------------------------end of getting the trackings---------------------------------------------------------------

} else { // means it is not branch
	$is_branch = 0;
		// find ho_plan_id----------------------------------------------------------------------------------------------------------
  
  $plan_status = "";
$result_status = "";
$comment = "";
$ho_plan_id = 0;

$this->loadModel('HoPerformancePlan');
$performance_plan_row = $this->HoPerformancePlan->query('select * from ho_performance_plans
			where employee_id = '. $e_id .' and budget_year_id = '. $budget_year_id.' and quarter = '.$quarter);
	if(count($performance_plan_row) > 0){
		$ho_plan_id = $performance_plan_row[0]['ho_performance_plans']['id'];
  $plan_status = $performance_plan_row[0]['ho_performance_plans']['plan_status'];
		$result_status = $performance_plan_row[0]['ho_performance_plans']['result_status'];
		$comment = $performance_plan_row[0]['ho_performance_plans']['comment'];
		$obj_one_row['supervisor_result'] = $performance_plan_row[0]['ho_performance_plans']['spvr_technical_percent'];
		$obj_one_row['aggregate_score'] = $performance_plan_row[0]['ho_performance_plans']['both_technical_percent'];

		if($plan_status == 2){
			$plan_status = "Pending agreement";
		}
		if($plan_status == 3){
			$plan_status = "Agreed";
		}
		if($plan_status == 4){
			$plan_status = "Agreed with reservation";
		}
		if($result_status == 1){
			$result_status = "Pending agreement";
		}
		if($result_status == 2){
			$result_status = "Agreed";
		}
		if($result_status == 3){
			$result_status = "Agreed with reservation";
		}
	}


//-------end of find ho plan id------------------------------------------------------------------------------------------------		

		$hoPlanObj = $this->HoPerformanceDetail->query('select * from ho_performance_details 
			where ho_performance_plan_id = '. $ho_plan_id .' ');

		 for($j = 0; $j < count($hoPlanObj) ; $j++){
			$obj_one_row['perspective'] = $hoPlanObj[$j]['ho_performance_details']['perspective'];
			$obj_one_row['objective'] = $hoPlanObj[$j]['ho_performance_details']['objective'];
			$obj_one_row['kpis'] = $hoPlanObj[$j]['ho_performance_details']['plan_description'];
			$obj_one_row['measure'] = $hoPlanObj[$j]['ho_performance_details']['measure'];
			$obj_one_row['weight'] = $hoPlanObj[$j]['ho_performance_details']['weight'];
			$obj_one_row['plan'] = $hoPlanObj[$j]['ho_performance_details']['plan_in_number'];
			$obj_one_row['actual'] = $hoPlanObj[$j]['ho_performance_details']['actual_result'];
			$obj_one_row['accomplishment'] = $hoPlanObj[$j]['ho_performance_details']['accomplishment'];
			$obj_one_row['total_score'] = $hoPlanObj[$j]['ho_performance_details']['total_score'];
			$obj_one_row['final_score'] = $hoPlanObj[$j]['ho_performance_details']['final_score'];

			$total_weight += $hoPlanObj[$j]['ho_performance_details']['weight'];

			$obj_one_row['date'] = "";
			$obj_one_row['target'] = "";
			$obj_one_row['value'] = "";
	
	//----------------------------because they apply to head office only-----------------------------------
			   $obj_one_row['plan_status'] = $plan_status;
			$obj_one_row['result_status'] = $result_status;
			$obj_one_row['comment'] = $comment;
	//----------------------------end because they apply to head office only-----------------------------------

			$score_summary += $hoPlanObj[$j]['ho_performance_details']['final_score'];
			array_push($objective_table, $obj_one_row);

		 }

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
	
		$br_plan_id = $data;
		$this->set(compact ('objective_table', 'emp_id' , 'position_name' ,'full_name', 'dept_name', 'immediate_supervisor_name',
		'appraisal_period' ,'training1', 'training2', 'training3', 'score_summary','score_summary_aggregate','branch_result','total_weight', 'is_branch', 'br_plan_id',
	'budget_year_id','e_id','quarter' , 'output_type' ));
}

function ho_ind_tracking_report($br_plan_id){

		$br_plan_id_array = explode("-",$br_plan_id);

		$e_id = $br_plan_id_array[0];
		$budget_year_id = $br_plan_id_array[1];
		$quarter = $br_plan_id_array[2];

		//	$emp_id = 3915 ;
		$total_weight = 0;
			$full_name = '' ;
			$position_name = '' ;
			$dept_name = '';
			$appraisal_period = '';
			$immediate_supervisor_name = 'no name';
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

	$this->loadModel('BranchPerformanceTrackingStatus');
	$performance_plan_row = $this->BranchPerformanceTrackingStatus->query('select * from branch_performance_tracking_statuses
				where employee_id = '. $e_id .' and budget_year_id = '. $budget_year_id.' and quarter = '.$quarter);
				$result_status = "Pending agreement";
				$comment = "";
		if(count($performance_plan_row) > 0){
		//	$ho_plan_id = $performance_plan_row[0]['branch_performance_tracking_statuses']['id'];
      	//	$plan_status = $performance_plan_row[0]['branch_performance_tracking_statuses']['plan_status'];
			$result_status = $performance_plan_row[0]['branch_performance_tracking_statuses']['result_status'];
			$comment = $performance_plan_row[0]['branch_performance_tracking_statuses']['comment'];

			if($result_status == 1){
				$result_status = "Pending agreement";
			}
			if($result_status == 2){
				$result_status = "Agreed";
			}
			if($result_status == 3){
				$result_status = "Agreed with reservation";
			}
		}
	
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
			$each_total_rating = round( 5 * $item["branch_performance_settings"]["weight"]/100 , 2);
		}
		if($each_total_goal > $item["branch_performance_settings"]["four_pointer_min"]  && $each_total_goal <= $item["branch_performance_settings"]["four_pointer_max_included"]){
			$each_total_rating = round( 4 * $item["branch_performance_settings"]["weight"]/100 , 2);
		}
		if($each_total_goal > $item["branch_performance_settings"]["three_pointer_min"]  && $each_total_goal <= $item["branch_performance_settings"]["three_pointer_max_included"]){
			$each_total_rating = round( 3 * $item["branch_performance_settings"]["weight"]/100 , 2);
		}
		if($each_total_goal > $item["branch_performance_settings"]["two_pointer_min"]  && $each_total_goal <= $item["branch_performance_settings"]["two_pointer_max_included"]){
			$each_total_rating = round(2 * $item["branch_performance_settings"]["weight"]/100 , 2);
		}
		if($each_total_goal > $item["branch_performance_settings"]["one_pointer_min"]  && $each_total_goal <= $item["branch_performance_settings"]["one_pointer_max_included"]){
			$each_total_rating = round(1 * $item["branch_performance_settings"]["weight"]/100 , 2);
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
					$score_summary_aggregate = round (0.85*($branch_result) + 0.15*($score_summary * 100 / $total_weight), 2);
				}
				else if ($position_id == 673 || $position_id == 793 ){
					$score_summary_aggregate = round(0.75*($branch_result) + 0.25*($score_summary * 100 / $total_weight) , 2);
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
			'appraisal_period' ,'training1', 'training2', 'training3', 'score_summary', 'score_summary_aggregate','branch_result' , 'br_plan_id','result_status','comment' , 
			'total_weight', 'e_id', 'budget_year_id', 'quarter' )) ;
	}
 
 function ho_ind_tracking_report_excel($br_plan_id){
 
 $output_type = 'EXCEL';
	
	//$budget_year_search = 14;
	
	$this->layout = 'ajax';	

		$br_plan_id_array = explode("-",$br_plan_id);

		$e_id = $br_plan_id_array[0];
		$budget_year_id = $br_plan_id_array[1];
		$quarter = $br_plan_id_array[2];

		//	$emp_id = 3915 ;
		$total_weight = 0;
			$full_name = '' ;
			$position_name = '' ;
			$dept_name = '';
			$appraisal_period = '';
			$immediate_supervisor_name = 'no name';
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

	$this->loadModel('BranchPerformanceTrackingStatus');
	$performance_plan_row = $this->BranchPerformanceTrackingStatus->query('select * from branch_performance_tracking_statuses
				where employee_id = '. $e_id .' and budget_year_id = '. $budget_year_id.' and quarter = '.$quarter);
				$result_status = "Pending agreement";
				$comment = "";
		if(count($performance_plan_row) > 0){
		//	$ho_plan_id = $performance_plan_row[0]['branch_performance_tracking_statuses']['id'];
      	//	$plan_status = $performance_plan_row[0]['branch_performance_tracking_statuses']['plan_status'];
			$result_status = $performance_plan_row[0]['branch_performance_tracking_statuses']['result_status'];
			$comment = $performance_plan_row[0]['branch_performance_tracking_statuses']['comment'];

			if($result_status == 1){
				$result_status = "Pending agreement";
			}
			if($result_status == 2){
				$result_status = "Agreed";
			}
			if($result_status == 3){
				$result_status = "Agreed with reservation";
			}
		}
	
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
			$each_total_rating = round( 5 * $item["branch_performance_settings"]["weight"]/100 , 2);
		}
		if($each_total_goal > $item["branch_performance_settings"]["four_pointer_min"]  && $each_total_goal <= $item["branch_performance_settings"]["four_pointer_max_included"]){
			$each_total_rating = round( 4 * $item["branch_performance_settings"]["weight"]/100 , 2);
		}
		if($each_total_goal > $item["branch_performance_settings"]["three_pointer_min"]  && $each_total_goal <= $item["branch_performance_settings"]["three_pointer_max_included"]){
			$each_total_rating = round( 3 * $item["branch_performance_settings"]["weight"]/100 , 2);
		}
		if($each_total_goal > $item["branch_performance_settings"]["two_pointer_min"]  && $each_total_goal <= $item["branch_performance_settings"]["two_pointer_max_included"]){
			$each_total_rating = round(2 * $item["branch_performance_settings"]["weight"]/100 , 2);
		}
		if($each_total_goal > $item["branch_performance_settings"]["one_pointer_min"]  && $each_total_goal <= $item["branch_performance_settings"]["one_pointer_max_included"]){
			$each_total_rating = round(1 * $item["branch_performance_settings"]["weight"]/100 , 2);
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
					$score_summary_aggregate = round (0.85*($branch_result) + 0.15*($score_summary * 100 / $total_weight), 2);
				}
				else if ($position_id == 673 || $position_id == 793 ){
					$score_summary_aggregate = round(0.75*($branch_result) + 0.25*($score_summary * 100 / $total_weight) , 2);
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
			'appraisal_period' ,'training1', 'training2', 'training3', 'score_summary', 'score_summary_aggregate','branch_result' , 'br_plan_id','result_status','comment' , 
			'total_weight', 'e_id', 'budget_year_id', 'quarter', 'output_type' )) ;
	}


// 	function ho_ind_tech_report2($br_plan_id = null) {  //means the technical and training
		
// 		$br_plan_id_array = explode("-",$br_plan_id);

// 		$e_id = $br_plan_id_array[0];
// 		$budget_year_id = $br_plan_id_array[1];
// 		$quarter = $br_plan_id_array[2];

// 		//	$emp_id = 3915 ;
// 			$full_name = '' ;
// 			$position_name = '' ;
// 			$dept_name = '';
// 			$appraisal_period = '';
// 			$immediate_supervisor_name = 'no name';
// 			$score_summary = 0;
// 			$training1 = '';
// 			$training2 = '';
// 			$training3 = '';
// 	//		$emps = $this->get_emp_names();
// 	// find quarter, budget_year, emp_id ------------------------------------------------------------------------------------
// 	// $ho_plan_row = $this->HoPerformancePlan->query('select * from ho_performance_plans where id = '.$ho_plan_id.'');
// 	// $quarter = $ho_plan_row[0]['ho_performance_plans']['quarter'];
// 	$qrtr = '';
// 	if($quarter == 1){
// 		$qrtr = "I";
// 	}
// 	if($quarter == 2){
// 		$qrtr = "II";
// 	}
// 	if($quarter == 3){
// 		$qrtr = "III";
// 	}
// 	if($quarter == 4){
// 		$qrtr = "IV";
// 	}
// 	// $e_id = $ho_plan_row[0]['ho_performance_plans']['employee_id'];
// 	// $budget_year_id = $ho_plan_row[0]['ho_performance_plans']['budget_year_id'];
// 	// $quarter = $ho_plan_row[0]['ho_performance_plans']['quarter'];
// 			 $this->loadModel('BudgetYear');
// 			 $conditions3 = array('BudgetYear.id' => $budget_year_id );
// 			 $hoBudgetYear = $this->BudgetYear->find('first', array('conditions' => $conditions3));
// 			 $budget_year  = $hoBudgetYear['BudgetYear']['name'];
// 			 $appraisal_period = $budget_year." [quarter ".$qrtr. "]";		
	
// 	// end of find quarter, budget_year, emp_id-----------------------------------------------------------------
// 	// get position------------------------------------------------------------------------------------------------------------
// 	$this->loadModel('Employee');
// 		$this->loadModel('EmployeeDetail');
// 		$this->loadModel('Position');
// 		$from_date = $hoBudgetYear['BudgetYear']['from_date'];
// 		$to_date = $hoBudgetYear['BudgetYear']['to_date'];

// 		$year_only_from = date('Y', strtotime($from_date));
// 		$year_only_to = date('Y', strtotime($to_date));
// 		$q = $quarter;

// 			if($q == 1){
// 				$quarter_start_date = $year_only_from."-07-01";
// 				$quarter_end_date = $year_only_from."-09-30";
// 			}
// 			if($q == 2){
// 				$quarter_start_date = $year_only_from."-10-01";
// 				$quarter_end_date = $year_only_from."-12-31";
// 			}
// 			if($q == 3){
// 				$quarter_start_date = $year_only_to."-01-01";
// 				$quarter_end_date = $year_only_to."-03-31";
// 			}
// 			if($q == 4){
// 				$quarter_start_date = $year_only_to."-04-01";
// 				$quarter_end_date = $year_only_to."-06-30";
// 			}


// 	$branch_id_for_quarter_row = $this->get_each_quarter_position($e_id, $from_date, $to_date , $quarter );
// 	$position_id = $branch_id_for_quarter_row[0]['employee_details']['position_id'];
// 	$branch_id = $branch_id_for_quarter_row[0]['employee_details']['branch_id'];
		
// 		// $position_id_row = $this->EmployeeDetail->query('select * from employee_details 
// 		// 		where employee_id = '. $e_id .' ');
// 		// $position_id = $position_id_row[0]['employee_details']['position_id'];
// 	//	$branch_id = $position_id_row[0]['employee_details']['branch_id'];
// 		$position_name_row = $this->Position->query('select * from positions
// 		where id = '. $position_id .' ');
// 		$position_name = $position_name_row[0]['positions']['name'];
// 	// end of get position--------------------------------------------------------------------------------------------------------	
// 	// get employee_name-----------------------------------------------------------------------------------------------------------
			
// 		$this->loadModel('User');
// 		$this->loadModel('Person');
		
		 
// 		  $emp_row = $this->Employee->query('select * from employees where id = '.$e_id.'');
// 		  $emp_id = $emp_row[0]['employees']['card'];
// 		  $user_id = $emp_row[0]['employees']['user_id'];
// 		  $user_row = $this->User->query('select * from users where id = '. $user_id);
// 		 if(count($user_row) > 0){
// 			$person_id = $user_row[0]['users']['person_id'];
// 			$person_row = $this->Person->query('select * from people where id = '. $person_id);
// 			$full_name = $person_row[0]['people']['first_name'].' '.$person_row[0]['people']['middle_name'].' '.$person_row[0]['people']['last_name'];
// 		 }
		
// 	// end of get employee_name	---------------------------------------------------------------------------------------------------------
// 	// get department/district-------------------------------------------------------------------------------------------------------
	
// 	$this->loadModel('Branch');
// 	$branch_row = $this->Employee->query('select * from branches where id = '.$branch_id.'');
// 	$dept_name = $branch_row[0]['branches']['name'];
	
// 	// end of get department/district------------------------------------------------------------------------------------------------
// 	$objective_table = array();
// 	$obj_one_row = array();
// 	//------------------------------------get the trackings--------------------------------------------------------------------------
// 	$this->loadModel('BranchPerformanceSetting');
// 	$this->loadModel('BranchPerformanceTracking');

	
// 	$score_summary = 0; // out of five

// 	$branch_setting_row = $this->BranchPerformanceSetting->query('select * from branch_performance_settings where position_id = '. $position_id);
// 	foreach($branch_setting_row as $item){
// 		$each_total_goal = 0;
// 		$each_total_rating = 0;
// 			$obj_one_row['objective'] = $item['branch_performance_settings']['goal'];
// 			$obj_one_row['target'] = $item['branch_performance_settings']['target'];
// 			$obj_one_row['measure'] = $item['branch_performance_settings']['measure'];
// 			$obj_one_row['weight'] = $item['branch_performance_settings']['weight'];
// 		$total_value_for_each = 0;
// 		$branch_tracking_row = $this->BranchPerformanceTracking->query('select * from branch_performance_trackings where employee_id = '. $e_id .' and goal = '.$item['branch_performance_settings']['id'].' and date between "'.$quarter_start_date.'" and "'.$quarter_end_date.'"');
// 		foreach($branch_tracking_row as $item2){
			
// 		//	$obj_one_row['value'] = $item2['branch_performance_trackings']['value'];
		
// 			//$each_total_goal += $item2['branch_performance_trackings']['value'];
// 			$total_value_for_each += $item2['branch_performance_trackings']['value'];
// 		}
// 		if($each_total_goal > $item["branch_performance_settings"]["five_pointer_min"]  && $each_total_goal <= $item["branch_performance_settings"]["five_pointer_max_included"]){
// 			$each_total_rating = 5 * $item["branch_performance_settings"]["weight"];
// 		}
// 		if($each_total_goal > $item["branch_performance_settings"]["four_pointer_min"]  && $each_total_goal <= $item["branch_performance_settings"]["four_pointer_max_included"]){
// 			$each_total_rating = 4 * $item["branch_performance_settings"]["weight"];
// 		}
// 		if($each_total_goal > $item["branch_performance_settings"]["three_pointer_min"]  && $each_total_goal <= $item["branch_performance_settings"]["three_pointer_max_included"]){
// 			$each_total_rating = 3 * $item["branch_performance_settings"]["weight"];
// 		}
// 		if($each_total_goal > $item["branch_performance_settings"]["two_pointer_min"]  && $each_total_goal <= $item["branch_performance_settings"]["two_pointer_max_included"]){
// 			$each_total_rating = 2 * $item["branch_performance_settings"]["weight"];
// 		}
// 		if($each_total_goal > $item["branch_performance_settings"]["one_pointer_min"]  && $each_total_goal <= $item["branch_performance_settings"]["one_pointer_max_included"]){
// 			$each_total_rating = 1 * $item["branch_performance_settings"]["weight"];
// 		}

// 		$obj_one_row['total_value'] = $total_value_for_each;
// 		$obj_one_row['rating'] = round($each_total_rating, 2);
// 		array_push($objective_table, $obj_one_row);
// 		$score_summary += $each_total_rating;

// 	}




// 	//------------------------------------end of getting the trackings---------------------------------------------------------------
// //	$this->loadModel('HoPerformanceDetail');	
	
			
			
	
// 			// $hoPlanObj = $this->HoPerformanceDetail->query('select * from ho_performance_details 
// 			// 	where ho_performance_plan_id = '. $ho_plan_id .' ');
	
// 			//  for($j = 0; $j < count($hoPlanObj) ; $j++){
// 			// 	$obj_one_row['objective'] = $hoPlanObj[$j]['ho_performance_details']['objective'];
// 			// 	$obj_one_row['kpis'] = $hoPlanObj[$j]['ho_performance_details']['perspective'];
// 			// 	$obj_one_row['measure'] = $hoPlanObj[$j]['ho_performance_details']['measure'];
// 			// 	$obj_one_row['weight'] = $hoPlanObj[$j]['ho_performance_details']['weight'];
// 			// 	$obj_one_row['plan'] = $hoPlanObj[$j]['ho_performance_details']['plan_in_number'];
// 			// 	$obj_one_row['actual'] = $hoPlanObj[$j]['ho_performance_details']['actual_result'];
// 			// 	$obj_one_row['accomplishment'] = $hoPlanObj[$j]['ho_performance_details']['accomplishment'];
// 			// 	$obj_one_row['total_score'] = $hoPlanObj[$j]['ho_performance_details']['total_score'];
// 			// 	$obj_one_row['final_score'] = $hoPlanObj[$j]['ho_performance_details']['final_score'];
// 			// 	$score_summary += $hoPlanObj[$j]['ho_performance_details']['final_score'];
// 			// 	array_push($objective_table, $obj_one_row);
	
// 			//  }
// //------------------------------------find supervisor id-------------------------------------------------------------------------------
// 			 $this->loadModel('Supervisor');
// 			 $sup_id = -1;
// 			 $sup_id_row = array();
// 			 $sup_id_row = $this->Supervisor->find('first', array('conditions' => array('Supervisor.emp_id' => $e_id)));
// 			 if(count($sup_id_row) > 0){
// 				 $sup_id = $sup_id_row['Supervisor']['sup_emp_id'];
// 			 }
// 			 else {
// 				 $sup_id = -1;
// 			 }
	
// 			if($sup_id != -1){
				
// 			//	$immediate_supervisor_name = $emps[$sup_id];
// 	   //---------------------------------------find supervisor name---------------------------------------------------
// 	   $sup_name_row = $this->Employee->query('select * from employees where id = '.$sup_id.'');
		  
// 		  $sup_user_id = $sup_name_row[0]['employees']['user_id'];
// 		  $sup_user_row = $this->User->query('select * from users where id = '. $sup_user_id);
// 		 if(count($sup_user_row) > 0){
// 			$sup_person_id = $sup_user_row[0]['users']['person_id'];
// 			$sup_person_row = $this->Person->query('select * from people where id = '. $sup_person_id);
// 			$immediate_supervisor_name = $sup_person_row[0]['people']['first_name'].' '.$sup_person_row[0]['people']['middle_name'].' '.$sup_person_row[0]['people']['last_name'];
// 		 }
// 	   //----------------------------------------end of finding immediate supervisor name-----------------------------
// 			}
	
// 		//---------------end of find supervisor id----------------------------------------------------------------------------	
// 		//------------------------------------------end of find immediate supervisor------------------------------------------
// 		//------------------------------------------find the trainings--------------------------------------------------------
// 			$this->loadModel('Allocatedtraining');
// 			$this->loadModel('Training');
	
// 			$hoTraining = $this->Allocatedtraining->query('select * from allocatedtrainings 
// 			where budget_year_id = '. $budget_year_id .' and employee_id = '.$e_id. ' and quarter = '.$quarter);
// 			if(count($hoTraining) > 0){
// 				$training_row1 = $this->Training->find('first', array('conditions' => array('Training.id' => $hoTraining[0]['allocatedtrainings']['training1'])));
// 				$training1 = $training_row1['Training']['name'];
// 				$training_row2 = $this->Training->find('first', array('conditions' => array('Training.id' => $hoTraining[0]['allocatedtrainings']['training2'])));
// 				$training2 = $training_row2['Training']['name'];
// 				$training_row3 = $this->Training->find('first', array('conditions' => array('Training.id' => $hoTraining[0]['allocatedtrainings']['training3'])));
// 				$training3 = $training_row3['Training']['name'];
				
// 			}
	
// 		//-----------------------------------------end of find the trainings--------------------------------------------------
// 		//-------------------halt halt halt halt halt halt halt-----------------------------------------------------------
		
		
// 			$this->set(compact ('objective_table', 'emp_id' , 'position_name' ,'full_name', 'dept_name', 'immediate_supervisor_name',
// 			'appraisal_period' ,'training1', 'training2', 'training3', 'score_summary', 'br_plan_id' ));
			
// 		}



	function ho_ind_behavioural_report($data = null) {  //means the technical and training

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
			$competence_result_id = 1;
			
	//		$emps = $this->get_emp_names();
	// find quarter, budget_year, emp_id ------------------------------------------------------------------------------------
	
			 
	$data_arr = explode("-", $data);
	$e_id = $data_arr[0];
	$budget_year_id = $data_arr[1];
	$this->loadModel('BudgetYear');
	$conditions3 = array('BudgetYear.id' => $budget_year_id );
	$hoBudgetYear = $this->BudgetYear->find('first', array('conditions' => $conditions3));
	$budget_year  = $hoBudgetYear['BudgetYear']['name'];
	$quarter = $data_arr[2];
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
	$appraisal_period = $budget_year." [quarter ".$qrtr. "]";	
	
	// end of find quarter, budget_year, emp_id-----------------------------------------------------------------
	
	// get position------------------------------------------------------------------------------------------------------------
		$this->loadModel('Employee');
		$this->loadModel('EmployeeDetail');
		$this->loadModel('Position');
		$position_id_row = $this->EmployeeDetail->query('select * from employee_details 
				where employee_id = '. $e_id .' order by start_date desc ');
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
			'quarter', 'data_exists','appraisal_period' , 'total_rating','e_id','budget_year_id', 'quarter' ));
			
		}
   
   	function ho_ind_behavioural_report_excel($data = null) {  //means the technical and training
    
    	$output_type = 'EXCEL';   
	
	    //$budget_year_search = 14;
	
	    $this->layout = 'ajax';	

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
			$competence_result_id = 1;
			
	//		$emps = $this->get_emp_names();
	// find quarter, budget_year, emp_id ------------------------------------------------------------------------------------
	
			 
	$data_arr = explode("-", $data);
	$e_id = $data_arr[0];
	$budget_year_id = $data_arr[1];
	$this->loadModel('BudgetYear');
	$conditions3 = array('BudgetYear.id' => $budget_year_id );
	$hoBudgetYear = $this->BudgetYear->find('first', array('conditions' => $conditions3));
	$budget_year  = $hoBudgetYear['BudgetYear']['name'];
	$quarter = $data_arr[2];
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
	$appraisal_period = $budget_year." [quarter ".$qrtr. "]";	
	
	// end of find quarter, budget_year, emp_id-----------------------------------------------------------------
	
	// get position------------------------------------------------------------------------------------------------------------
		$this->loadModel('Employee');
		$this->loadModel('EmployeeDetail');
		$this->loadModel('Position');
		$position_id_row = $this->EmployeeDetail->query('select * from employee_details 
				where employee_id = '. $e_id .' order by start_date desc ');
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
			'quarter', 'data_exists','appraisal_period' , 'total_rating','e_id','budget_year_id', 'quarter' , 'output_type' ));
			
		}

	function report_index() {

	}
	function br_report_index(){

	}
	function report(){
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
		//$emps = $this->get_emp_names();
		//$employees = $this->HoPerformancePlan->Employee->find('list');
	//	$this->set(compact('budget_years', 'emps'));
 	$this->set(compact('budget_years'));
	
	}

	function report_br(){
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
		$branches = $this->get_branch_names();
		//$employees = $this->HoPerformancePlan->Employee->find('list');
		$this->set(compact('budget_years', 'branches'));
	
	}

	function index_all_report($id = null) {	
			
	    $this->loadModel('BudgetYear');
		$budget_years = $this->BudgetYear->find('list');
   //------------------------now find the number of active employees--------------------------------
    $this->loadModel('Employee');
    $active_emp_row = $this->Employee->query('select count(*) as count_active from employees where status = "Active"');
    $count_active = $active_emp_row[0][0]['count_active'];
    
    //----------------------------now find the number of employees processed for------------------------
    $this->loadModel('PerformanceExcelReport');
    $processed_row = $this->PerformanceExcelReport->query('select count(*) as count_processed from performance_excel_reports ');
    $count_processed = $processed_row[0][0]['count_processed'];
    
    //----------------------------get last report issue date------------------------
    $date_row = $this->PerformanceExcelReport->query('select *  from performance_excel_reports limit 1');
    $last_issue_date = "";
    if(count($date_row) > 0){
      $last_issue_date = $date_row[0]['performance_excel_reports']['report_time'];
    }
    
		//$branches = $this->get_branch_names_excel();
		//$employees = $this->HoPerformancePlan->Employee->find('list');
		$this->set(compact('budget_years', 'branches', 'count_active', 'count_processed', 'last_issue_date'));
   
    }

	function index_br_report($id = null) {	
			
	    $this->loadModel('BudgetYear');
		$budget_years = $this->BudgetYear->find('list');
		//$employees = $this->HoPerformancePlan->Employee->find('list');
		$this->set(compact('budget_years'));

    }
	function br_report(){ //this is a report one row for one year for each employee
		$budget_year_search = 0;

		if (!empty($this->data)) {
			$search_data = $this->data ;
			$budget_year_search = $search_data['CompetenceCategory']['budget_year_id'];
			$output_type = $search_data['CompetenceCategory']['output_type'];
			//$budget_year_search = count($search_data);	
			$output_type = 'EXCEL';
		}
		else {
			$budget_year_search = 0; // means all years
			$output_type = 'HTML';
		}
		//$budget_year_search = 14;

		$this->layout = 'ajax';	
	
		$report_table = array();

		$one_row = array();

	    $budget_years = array();

	$branch_ids = $this->get_branch_ids();
	//array_push($emp_ids, 4638);
	$this->loadModel('BudgetYear');
	for($j = 0; $j < count($branch_ids); $j ++){

		$branch_id = $branch_ids[$j];
//-----------------------------------first find the year hired-------------------------------------------------------------
		  $budget_years = array();

		//--------------------------------------------------------find the emp name and permanent data-----------------------------

		$this->loadModel('Branch');
		$this->loadModel('BranchPerformancePlan');
		$this->loadModel('BranchEvaluationCriteria');
		$this->loadModel('BranchPerformanceDetail');

		$branch_name = "";
		$branch_district = "";

		//----------------------------------------------find elligible budget years------------------------------------------------
		// if($budget_year_search == 0){
		// 	$brPlan = $this->BranchPerformancePlan->query('select * from branch_performance_plans 
		// 	where branch_id = '. $branch_id .' ');
			
		// } else {
		// 	$brPlan = $this->BranchPerformancePlan->query('select * from branch_performance_plans 
		// 	where branch_id = '. $branch_id .' and budget_year_id = '.$budget_year_search);
		// }
		
	//foreach($brPlan as $item){
		//array_push($budget_years, $item['branch_performance_plans']['budget_year_id']);
		 
	//}
			array_push($budget_years, $budget_year_search);  //because one year is selected all the time for now
		//----------------------------------------end of finding elligible budget years--------------------------------------------
		//-----------------------------------------------------get branch profile------------------------
		$branch_district_row = $this->Branch->query('select * from branches where id = '.$branch_id);
		$branch_name = $branch_district_row[0]['branches']['name'];
		$branch_district = $branch_district_row[0]['branches']['region'];
		//--------------------------------------------------end of get branch profile------------------------

		for($x = 0; $x < count($budget_years) ; $x++){ 
          
			
				$one_row['branch'] = $branch_name;
				$one_row['branch_district'] = $branch_district;
				$one_row['budget_year'] = 0;
				$this->loadModel('BudgetYear');
				$conditions3 = array('BudgetYear.id' => $budget_years[$x] );
				$budgetYear3 = $this->BudgetYear->find('first', array('conditions' => $conditions3));
				$one_row['budget_year']  = $budgetYear3['BudgetYear']['name'];

				$one_row['q1'] = 0;
				$one_row['q2'] = 0;
				
				
				$one_row['semiannual_average1'] = 0;
				$one_row['q3'] = 0;
				$one_row['q4'] = 0;
				
			
				$one_row['semiannual_average2'] = 0;
				$one_row['annual'] = 0;

				$one_row['q1_plan_status'] = "-";
				$one_row['q1_result_status'] = "-";
				$one_row['q1_comment'] = "";
				$one_row['q2_plan_status'] = "-";
				$one_row['q2_result_status'] = "-";
				$one_row['q2_comment'] = "";
				$one_row['q3_plan_status'] = "-";
				$one_row['q3_result_status'] = "-";
				$one_row['q3_comment'] = "";
				$one_row['q4_plan_status'] = "-";
				$one_row['q4_result_status'] = "-";
				$one_row['q4_comment'] = "";
        
        

//---------------------------------------------find the plans for the year----------------------------------------------------
$brPlan2 = $this->BranchPerformancePlan->query('select * from branch_performance_plans 
	where branch_id = '. $branch_id .' and budget_year_id = '.$budget_years[$x]);
 
	foreach($brPlan2 as $item2){
	//	array_push($budget_years, $item2['branch_performance_plans']['budget_year_id']);
        $plan_id = $item2['branch_performance_plans']['id'] ;
		$actual_total_weight = 0;
		$details_row = $this->BranchPerformanceDetail->query('select * from branch_performance_details 
		where branch_performance_plan_id = '.$plan_id );

		foreach($details_row as $detail){
			$evaluation_id = $detail['branch_performance_details']['branch_evaluation_criteria_id'];
			$evaluation_row = $this->BranchEvaluationCriteria->query('select * from branch_evaluation_criterias 
			where id = '.$evaluation_id );
			$actual_total_weight += $evaluation_row[0]['branch_evaluation_criterias']['weight'];

		}

		$quarter = $item2['branch_performance_plans']['quarter'] ;
		//-----------------------------------------------start of agreement------------------------------------------
		$plan_status = "";
		$result_status = "";
		$comment = "";
		if($item2['branch_performance_plans']['plan_status'] == 2){
			$plan_status = "Pending agreement";
		}
		else if($item2['branch_performance_plans']['plan_status'] == 3){
			$plan_status = "Agreed";
		}
		else if($item2['branch_performance_plans']['plan_status'] == 4){
			$plan_status = "Agreed with reservation";
		}
		if($item2['branch_performance_plans']['result_status'] == 1){
			$result_status = "Pending agreement";
		}
		else if($item2['branch_performance_plans']['result_status'] == 2){
			$result_status = "Agreed";
		}
		else if($item2['branch_performance_plans']['result_status'] == 3){
			$result_status = "Agreed with reservation";
		}
		$comment = $item2['branch_performance_plans']['comment'] ;
//-----------------------------------------------end of agreement------------------------------------------
		if($quarter == 1){
   
			if($actual_total_weight > 0){
				$one_row['q1'] = round($item2['branch_performance_plans']['result'] * 100/$actual_total_weight , 2)  ;
			}
			else{
				$one_row['q1'] = 0;
			}
			$one_row['q1_plan_status'] = $plan_status ;
			$one_row['q1_result_status'] = $result_status ;
			$one_row['q1_comment'] = $comment ;
		}
		if($quarter == 2){
			if($actual_total_weight > 0){
				$one_row['q2'] = round($item2['branch_performance_plans']['result'] * 100/$actual_total_weight , 2)  ;
			}
			else{
				$one_row['q2'] = 0;
			}
			if($one_row['q1'] > 0){
				$one_row['semiannual_average1'] = ($one_row['q1'] + $one_row['q2']) / 2;
			}
			else {
				$one_row['semiannual_average1'] = $one_row['q2'] ; 
			}
			$one_row['q2_plan_status'] = $plan_status ;
			$one_row['q2_result_status'] = $result_status ;
			$one_row['q2_comment'] = $comment ;
			
		}
		if($quarter == 3){
   
			if($actual_total_weight > 0){
				$one_row['q3'] = round($item2['branch_performance_plans']['result'] * 100/$actual_total_weight , 2)  ;
			}
			else{
				$one_row['q3'] = 0;
			}
			$one_row['q3_plan_status'] = $plan_status ;
			$one_row['q3_result_status'] = $result_status ;
			$one_row['q3_comment'] = $comment ;
		}
		if($quarter == 4){
			if($actual_total_weight > 0){
				$one_row['q4'] = round($item2['branch_performance_plans']['result'] * 100/$actual_total_weight , 2)  ;
			}
			else{
				$one_row['q4'] = 0;
			}
			if($one_row['q3'] > 0){
				$one_row['semiannual_average2'] = ($one_row['q3'] + $one_row['q4']) / 2;
			}
			else {
				$one_row['semiannual_average2'] = $one_row['q4'] ; 
			}
			$one_row['q4_plan_status'] = $plan_status ;
			$one_row['q4_result_status'] = $result_status ;
			$one_row['q4_comment'] = $comment ;
			
		}
		if ($one_row['semiannual_average1'] > 0 && $one_row['semiannual_average2'] > 0){
			$one_row['annual']  = ($one_row['semiannual_average1'] + $one_row['semiannual_average2']) / 2 ;
		}
		else if($one_row['semiannual_average1'] > 0 && $one_row['semiannual_average2'] == 0){
			$one_row['annual']  = $one_row['semiannual_average1']  ;
		}
		else if($one_row['semiannual_average1'] == 0 && $one_row['semiannual_average2'] > 0){
			$one_row['annual']  = $one_row['semiannual_average2']  ;
		}
		

	}
//--------------------------------------------end of find the plans for the year---------------------------------------------

		

				array_push($report_table, $one_row);
		}

	}

	$this->set(compact ('report_table',  'output_type' ));

	}

	function write_report_to_database( $one_row){
		$this->loadModel('PerformanceExcelReport');

		//check if employee_id exists----------------do not insert--------------------------------------------------

		$emp_rows= $this->PerformanceExcelReport->query('select * from performance_excel_reports where employee_id = '.$one_row['emp_id']);
			
			
			if( count($emp_rows) == 0){

				$insert_report = $this->PerformanceExcelReport->query('insert into performance_excel_reports(
					employee_id, budget_year_id, card_number, first_name, middle_name, last_name, sex, date_of_employment,
					status, last_position, branch, branch_district, budget_year, q1, q2, q1q290, behavioural1, semi_annual_one,
					q3, q4, q3q490, behavioural2, semi_annual_two, annual, q1_training1, q1_training2, q1_training3 ,
					q2_training1, q2_training2, q2_training3 , q3_training1, q3_training2, q3_training3 , q4_training1, 
					q4_training2, q4_training3 , q1_technical_plan_status, q1_technical_result_status , q1_technical_comment,
					q2_technical_plan_status, q2_technical_result_status , q2_technical_comment, q2_behavioural_result_status,
					q2_behavioural_comment, q3_technical_plan_status, q3_technical_result_status , q3_technical_comment,
					q4_technical_plan_status, q4_technical_result_status , q4_technical_comment, q4_behavioural_result_status,
					q4_behavioural_comment, report_time
		
				)
				values (
					'.$one_row['emp_id'].', '.$one_row['budget_year_id'].',"'.$one_row['employee_id'].'", "'.$one_row['first_name'].'",
					"'.$one_row['middle_name'].'","'.$one_row['last_name'].'","'.$one_row['sex'].'","'.$one_row['date_of_employment'].'",
					"'.$one_row['status'].'", "'.$one_row['last_position'].'" ,"'.$one_row['branch'].'" , "'.$one_row['branch_district'].'",
					"'.$one_row['budget_year'].'", "'.$one_row['q1'].'", "'.$one_row['q2'].'","'.$one_row['semiannual_technical1'].'",
					"'.$one_row['behavioural1'].'","'.$one_row['semiannual_average1'] .'","'.$one_row['q3'].'","'.$one_row['q4'].'",
					"'.$one_row['semiannual_technical2'].'", "'.$one_row['behavioural2'].'","'.$one_row['semiannual_average2'].'",
					"'.$one_row['annual'].'","'.$one_row['q1_training1'].'","'.$one_row['q1_training2'].'","'.$one_row['q1_training3'].'",
					"'.$one_row['q2_training1'].'","'.$one_row['q2_training2'].'","'.$one_row['q2_training3'].'","'.$one_row['q3_training1'].'",
					"'.$one_row['q3_training2'].'","'.$one_row['q3_training3'].'","'.$one_row['q4_training1'].'","'.$one_row['q4_training2'].'",
					"'.$one_row['q4_training3'].'","'.$one_row['q1_technical_agreement_plan'].'","'.$one_row['q1_technical_agreement_result'].'",
					"'.$one_row['q1_technical_comment'].'","'.$one_row['q2_technical_agreement_plan'].'","'.$one_row['q2_technical_agreement_result'].'",
					"'.$one_row['q2_technical_comment'].'","'.$one_row['q2_behavioural_agreement_result'].'","'.$one_row['q2_behavioural_comment'].'",
					"'.$one_row['q3_technical_agreement_plan'].'","'.$one_row['q3_technical_agreement_result'].'","'.$one_row['q3_technical_comment'].'",
					"'.$one_row['q4_technical_agreement_plan'].'","'.$one_row['q4_technical_agreement_result'].'","'.$one_row['q4_technical_comment'].'",
					"'.$one_row['q4_behavioural_agreement_result'].'","'.$one_row['q4_behavioural_comment'].'","'.date("Y/m/d").'"
		
				)' );

			}
      else {
				$update_report = $this->PerformanceExcelReport->query('update performance_excel_reports set 
				budget_year_id = '.$one_row['budget_year_id'].' , card_number = "'.$one_row['employee_id'].'",
				first_name = "'.$one_row['first_name'].'" , middle_name = "'. $one_row['middle_name'] . '" ,
				last_name = "'. $one_row['last_name'] . '" , sex = "'. $one_row['sex'] . '" ,
				date_of_employment = "'. $one_row['date_of_employment'] . '",  status = "'. $one_row['status']. '",
				last_position = "'. $one_row['last_position'] . '" , branch = "'. $one_row['branch'] .'",
				branch_district = "'.$one_row['branch_district'] . '" , budget_year = "'.$one_row['budget_year'].'",
				q1 = "'.$one_row['q1'].'", q2 = "'.$one_row['q2'].'" , q1q290 = "'.$one_row['semiannual_technical1'].'",
				behavioural1 = "'.$one_row['behavioural1']. '", semi_annual_one = "'.$one_row['semiannual_average1'].'",
				q3 = "'.$one_row['q3'].'" , q4 = "'.$one_row['q4'].'" , q3q490 = "'.$one_row['semiannual_technical2'].'",
				behavioural2 = "'.$one_row['behavioural2'].'", semi_annual_two = "'.$one_row['semiannual_average2'].'",
				 annual = "'.$one_row['annual']. '", q1_training1 = "'.$one_row['q1_training1'].'", 
				 q1_training2 = "'.$one_row['q1_training2'].'", q1_training3 = "'.$one_row['q1_training3'].'",
				 q2_training1 = "'.$one_row['q2_training1'].'", q2_training2 = "'.$one_row['q2_training2'].'",
				 q2_training3 = "'.$one_row['q2_training3'].'", q3_training1 = "'.$one_row['q3_training1'].'",
				 q3_training2 = "'.$one_row['q3_training2'].'", q3_training3 = "'.$one_row['q3_training3'].'",
				 q4_training1 = "'.$one_row['q4_training1'].'", q4_training2 = "'.$one_row['q4_training2'].'",
				 q4_training3 = "'.$one_row['q4_training3'].'", q1_technical_plan_status = "'.$one_row['q1_technical_agreement_plan'].'",
				 q1_technical_result_status = "'.$one_row['q1_technical_agreement_result'].'" ,q1_technical_comment = "'.$one_row['q1_technical_comment'].'",
				 q2_technical_plan_status = "'.$one_row['q2_technical_agreement_plan'].'", q2_technical_result_status = "'.$one_row['q2_technical_agreement_result'].'",
				 q2_technical_comment = "'.$one_row['q2_technical_comment'].'", q2_behavioural_result_status = "'.$one_row['q2_behavioural_agreement_result'].'",
				 
				 q2_behavioural_comment = "'.$one_row['q2_behavioural_comment'].'" , q3_technical_plan_status = "'.$one_row['q3_technical_agreement_plan'].'",
				 q3_technical_result_status = "'.$one_row['q3_technical_agreement_result'].'" , q3_technical_comment = "'.$one_row['q3_technical_comment'].'", 
				 q4_technical_plan_status = "'.$one_row['q4_technical_agreement_plan'].'", q4_technical_result_status = "'.$one_row['q4_technical_agreement_result'].'",
				 q4_technical_comment = "'.$one_row['q4_technical_comment'].'", q4_behavioural_result_status = "'.$one_row['q4_behavioural_agreement_result'].'",
				 
				 q4_behavioural_comment = "'.$one_row['q4_behavioural_comment'].'", report_time = "'.date("Y/m/d").'"

				 where employee_id = '.$one_row['emp_id'].'

				
				');

			}

		
	//	(employee_id, budget_year_id, quarter, result_status) values('.$e_id.','.$budget_year_id.','.$quarter.' , 1)');
        

	}
 
 function report_db_to_excel(){
 $report_table = array();
 $one_row = array();
 
 	$this->loadModel('PerformanceExcelReport');

		//check if employee_id exists----------------do not insert--------------------------------------------------

		$rep_rows= $this->PerformanceExcelReport->query('select * from performance_excel_reports ');
   
   for($i = 0; $i < count($rep_rows) ; $i++){  
   $one_row = array();   
   
 	$one_row['emp_id'] = $rep_rows[$i]['performance_excel_reports']['employee_id'];
				$one_row['budget_year_id'] = $rep_rows[$i]['performance_excel_reports']['budget_year_id'];		
				$one_row['employee_id'] = $rep_rows[$i]['performance_excel_reports']['card_number']; 
				
				$one_row['first_name'] = $rep_rows[$i]['performance_excel_reports']['first_name'];
				$one_row['middle_name'] = $rep_rows[$i]['performance_excel_reports']['middle_name'];
				$one_row['last_name'] = $rep_rows[$i]['performance_excel_reports']['last_name'];
				$one_row['sex'] = $rep_rows[$i]['performance_excel_reports']['sex'];
				$one_row['date_of_employment'] = $rep_rows[$i]['performance_excel_reports']['date_of_employment'];
				$one_row['status'] = $rep_rows[$i]['performance_excel_reports']['status'];
        
        	$one_row['last_position'] = $rep_rows[$i]['performance_excel_reports']['last_position'];
        
        
          $one_row['branch'] = $rep_rows[$i]['performance_excel_reports']['branch'];                         
       
				
				$one_row['branch_district'] = $rep_rows[$i]['performance_excel_reports']['branch_district'];  
				$one_row['budget_year'] = $rep_rows[$i]['performance_excel_reports']['budget_year'];
			

				$one_row['q1'] = $rep_rows[$i]['performance_excel_reports']['q1'];
				$one_row['q2'] = $rep_rows[$i]['performance_excel_reports']['q2'];
				$one_row['semiannual_technical1'] = $rep_rows[$i]['performance_excel_reports']['q1q290'];
				$one_row['behavioural1'] = $rep_rows[$i]['performance_excel_reports']['behavioural1'];
				$one_row['semiannual_average1'] = $rep_rows[$i]['performance_excel_reports']['semi_annual_one'];
				$one_row['q3'] = $rep_rows[$i]['performance_excel_reports']['q3'];
				$one_row['q4'] = $rep_rows[$i]['performance_excel_reports']['q4'];
				$one_row['semiannual_technical2'] = $rep_rows[$i]['performance_excel_reports']['q3q490'];
				$one_row['behavioural2'] = $rep_rows[$i]['performance_excel_reports']['behavioural2'];
				$one_row['semiannual_average2'] = $rep_rows[$i]['performance_excel_reports']['semi_annual_two'];
				$one_row['annual'] = $rep_rows[$i]['performance_excel_reports']['annual'];
				$one_row['q1_training1']  = $rep_rows[$i]['performance_excel_reports']['q1_training1'];
				$one_row['q1_training2']  = $rep_rows[$i]['performance_excel_reports']['q1_training2'];
				$one_row['q1_training3']  = $rep_rows[$i]['performance_excel_reports']['q1_training3'];
				$one_row['q2_training1']  = $rep_rows[$i]['performance_excel_reports']['q2_training1'];
				$one_row['q2_training2']  = $rep_rows[$i]['performance_excel_reports']['q2_training2'];
				$one_row['q2_training3']  = $rep_rows[$i]['performance_excel_reports']['q2_training3'];
				$one_row['q3_training1']  = $rep_rows[$i]['performance_excel_reports']['q3_training1'];
				$one_row['q3_training2']  = $rep_rows[$i]['performance_excel_reports']['q3_training2'];
				$one_row['q3_training3']  = $rep_rows[$i]['performance_excel_reports']['q3_training3'];
				$one_row['q4_training1']  = $rep_rows[$i]['performance_excel_reports']['q4_training1'];
				$one_row['q4_training2']  = $rep_rows[$i]['performance_excel_reports']['q4_training2'];
				$one_row['q4_training3']  = $rep_rows[$i]['performance_excel_reports']['q4_training3'];
				$one_row['q1_technical_agreement_plan'] = $rep_rows[$i]['performance_excel_reports']['q1_technical_plan_status'];
				$one_row['q1_technical_agreement_result'] = $rep_rows[$i]['performance_excel_reports']['q1_technical_result_status'];
				$one_row['q1_technical_comment'] = $rep_rows[$i]['performance_excel_reports']['q1_technical_comment'];
				$one_row['q2_technical_agreement_plan'] = $rep_rows[$i]['performance_excel_reports']['q2_technical_plan_status'];
				$one_row['q2_technical_agreement_result'] = $rep_rows[$i]['performance_excel_reports']['q2_technical_result_status'];
				$one_row['q2_technical_comment'] = $rep_rows[$i]['performance_excel_reports']['q2_technical_comment'];
				$one_row['q2_behavioural_agreement_result'] = $rep_rows[$i]['performance_excel_reports']['q2_behavioural_result_status'];
				$one_row['q2_behavioural_comment'] = $rep_rows[$i]['performance_excel_reports']['q2_behavioural_comment'];
				$one_row['q3_technical_agreement_plan'] = $rep_rows[$i]['performance_excel_reports']['q3_technical_plan_status'];
				$one_row['q3_technical_agreement_result'] = $rep_rows[$i]['performance_excel_reports']['q3_technical_result_status'];
				$one_row['q3_technical_comment'] = $rep_rows[$i]['performance_excel_reports']['q3_technical_comment'];
				$one_row['q4_technical_agreement_plan'] = $rep_rows[$i]['performance_excel_reports']['q4_technical_plan_status'];
				$one_row['q4_technical_agreement_result'] = $rep_rows[$i]['performance_excel_reports']['q4_technical_result_status'];
				$one_row['q4_technical_comment'] = $rep_rows[$i]['performance_excel_reports']['q4_technical_comment'];
				$one_row['q4_behavioural_agreement_result'] = $rep_rows[$i]['performance_excel_reports']['q4_behavioural_result_status'];
				$one_row['q4_behavioural_comment'] = $rep_rows[$i]['performance_excel_reports']['q4_behavioural_comment'];
        
        
        	array_push($report_table, $one_row);
        
         } 
         
         return $report_table;
 
 }

	function all_report(){ //this is a report one row for one year for each employee
		$budget_year_search = 0;
   $continue = 'yes';

		if (!empty($this->data)) {
			$search_data = $this->data ;
			$budget_year_search = $search_data['CompetenceCategory']['budget_year_id'];
			$output_type = $search_data['CompetenceCategory']['output_type'];
      $continue = $search_data['CompetenceCategory']['continue'];
			//$branch_type = $search_data['CompetenceCategory']['branch_id'];
			//$budget_year_search = count($search_data);	
			$output_type = 'EXCEL';
		}
		else {
			$budget_year_search = 0; // means all years
			$branch_type = -3;
			$output_type = 'HTML';
      $continue = 'no';
		}
   
    //----------------------------now find the budget year------------------------
    if($continue == 'yes'){
    
     $this->loadModel('PerformanceExcelReport');
    $continue_row = $this->PerformanceExcelReport->query('select *  from performance_excel_reports limit 1 order by id desc');
    if(count($continue_row) > 0){
    $budget_year_search = $continue_row[0]['performance_excel_reports']['budget_year_id'];
    }
    else {
     $budget_year_search = 0;
    }
    
    
    }
   
    //----------------------------end of now find the budget year------------------------

		//$budget_year_search = 14;
		$this->loadModel('BudgetYear');
		$this->layout = 'ajax';	
		$emp_ids = array();
		$report_table = array();

		$one_row = array();

	    $budget_years = array();

		$this->loadModel('BranchPerformanceTrackingStatus');
		$this->loadModel('CompetenceResult');
//----------------------------------------training names--------------------------------------------

		$this->loadModel('Training');
		$trainings = array();
		$trainings = $this->Training->find('all');
		
		$training_list = array();
		foreach($trainings as $item){
				
			$training_list[$item["Training"]["id"]] = $item["Training"]["name"];
			
		}
//----------------------------------------end of training names------------------------------------------------------------
	$this->loadModel('EmployeeDetail');
	//$emp_ids = $this->get_emp_ids();
	//$emp_ids = $this->get_emp_ids_excel($branch_type);
	 $emp_ids = $this->get_emp_ids_excel(-3 , $continue);  //keep it all 
  //$emp_ids = array(4000,4001,4002,4003);
	//array_push($emp_ids, 4638);
	for($j = 0; $j < count($emp_ids); $j ++){
  $budget_years = array();
		$e_id = $emp_ids[$j];
//-----------------------------------first find the year hired-------------------------------------------------------------
		  $budget_years = array();
		  $hired_date_row =  $this->EmployeeDetail->query('select * from employee_details 
		  where employee_id = '. $e_id .' order by start_date');
		  
		  if(count($hired_date_row) > 0){

		  
		  $hired_date = $hired_date_row[0]['employee_details']['start_date'];

		  
		  $first_budget_year_row =  $this->BudgetYear->query('select * from budget_years 
		  where from_date <= "'. $hired_date .'" and to_date >= "'.$hired_date.'" order by order_by');

		  if(count($first_budget_year_row) > 0){

		  
		  
		  $first_budget_year_id = $first_budget_year_row[0]['budget_years']['id'];
		  $year_order_by_id = $first_budget_year_row[0]['budget_years']['order_by'];


		 // if($budget_year_search == 0){ // means all years
		//	$applicable_budget_year_row = $this->BudgetYear->query('select * from budget_years 
		//	where order_by >= '. $year_order_by_id );
		//  }
		//  else { // means single year
			$applicable_budget_year_row = $this->BudgetYear->query('select * from budget_years 
			where id >= '.$first_budget_year_id. ' and id = '.$budget_year_search);
		//  }

		  

		  foreach($applicable_budget_year_row as $item){ 
			if(!in_array( $item['budget_years']['id'] , $budget_years)){ 
				array_push($budget_years, $item['budget_years']['id']);
			}
		}

		//

		//--------------------------------------------------------find the emp name and permanent data-----------------------------
		$this->loadModel('Employee');
		$this->loadModel('User');
		$this->loadModel('Person');
		$this->loadModel('Branch');
    $this->loadModel('Position');
		$this->loadModel('HoPerformancePlan');

		$first_name = "";
		$middle_name = "";
		$last_name = "";
		$sex = "";
		$date_of_employment = "";
		$status = "";
		$last_position = "";
		$branch = "";
		$branch_district = "";

				$emp_rows= $this->Employee->query('select * from employees where id = '.$emp_ids[$j]);
				$user_id = $emp_rows[0]['employees']['user_id'];
				$emp_id = $emp_rows[0]['employees']['card'];
				$date_of_employment = $emp_rows[0]['employees']['date_of_employment'];
				$status = $emp_rows[0]['employees']['status'];

				$user_row = $this->User->query('select * from users where id = '. $user_id);
				if(count($user_row) > 0){
				$person_id = $user_row[0]['users']['person_id'];
				
				$person_row = $this->Person->query('select * from people where id = '. $person_id);

				$full_name = $person_row[0]['people']['first_name'].' '.$person_row[0]['people']['middle_name'].' '.$person_row[0]['people']['last_name'];
				$first_name = $person_row[0]['people']['first_name'];
				$middle_name = $person_row[0]['people']['middle_name'];
				$last_name = $person_row[0]['people']['last_name'];
				$sex = $person_row[0]['people']['sex'];
		
			}
		//-----------------------------------------------------end of finding the emp name and permanent data------------------------

		for($x = 0; $x < count($budget_years) ; $x++){ 

//-----------------------------------------------------find position and branch for each quarter------------------------------------------------------

//--now decide the position and branch he/she worked in each quarter---------------------------------------------------------
		   $budget_yr_row= $this->BudgetYear->query('select * from budget_years where id = '.$budget_years[$x]);
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
			}else{
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
				$one_row['emp_id'] = $e_id;
				$one_row['budget_year_id'] = $budget_years[$x];			
				$one_row['employee_id'] = $emp_id; 
				
				$one_row['first_name'] = $first_name;
				$one_row['middle_name'] = $middle_name;
				$one_row['last_name'] = $last_name;
				$one_row['sex'] = $sex;
				$one_row['date_of_employment'] = $date_of_employment;
				$one_row['status'] = $status;
				$last_position_row= $this->Position->query('select * from positions where id = '.$position_q4);
				//$one_row['last_position'] = $position_q4;
        if(count($last_position_row)){
        	$one_row['last_position'] = $last_position_row[0]['positions']['name'];
        }
        else{
        $one_row['last_position'] = "no q4 position";
        }
        $branch_row= $this->Branch->query('select * from branches where id = '.$branch_q4);
			  if(count($branch_row)){
          $one_row['branch'] = $branch_row[0]['branches']['name'];                       
        }
        else{
        $one_row['branch'] = "no q4 branch";
        }
				
				//$one_row['branch'] = $branch_q4;
				
				$one_row['branch_district'] = $branch_district;
				$one_row['budget_year'] = 0;
				$this->loadModel('BudgetYear');
				$conditions3 = array('BudgetYear.id' => $budget_years[$x] );
				$budgetYear3 = $this->BudgetYear->find('first', array('conditions' => $conditions3));
				$one_row['budget_year']  = $budgetYear3['BudgetYear']['name'];

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
				$one_row['q1_training1']  = "";
				$one_row['q1_training2']  = "";
				$one_row['q1_training3']  = "";
				$one_row['q2_training1']  = "";
				$one_row['q2_training2']  = "";
				$one_row['q2_training3']  = "";
				$one_row['q3_training1']  = "";
				$one_row['q3_training2']  = "";
				$one_row['q3_training3']  = "";
				$one_row['q4_training1']  = "";
				$one_row['q4_training2']  = "";
				$one_row['q4_training3']  = "";
				$one_row['q1_technical_agreement_plan'] = "-";
				$one_row['q1_technical_agreement_result'] = "-";
				$one_row['q1_technical_comment'] = "-";
				$one_row['q2_technical_agreement_plan'] = "-";
				$one_row['q2_technical_agreement_result'] = "-";
				$one_row['q2_technical_comment'] = "-";
				$one_row['q2_behavioural_agreement_result'] = "-";
				$one_row['q2_behavioural_comment'] = "-";
				$one_row['q3_technical_agreement_plan'] = "-";
				$one_row['q3_technical_agreement_result'] = "-";
				$one_row['q3_technical_comment'] = "-";
				$one_row['q4_technical_agreement_plan'] = "-";
				$one_row['q4_technical_agreement_result'] = "-";
				$one_row['q4_technical_comment'] = "-";
				$one_row['q4_behavioural_agreement_result'] = "-";
				$one_row['q4_behavioural_comment'] = "-";

//------------------------------start for the first quarter----------------------------------------------------------

if(count($position_id_for_quarter1_row) > 0){
	$position_q1 = $position_id_for_quarter1_row[0]["employee_details"]["position_id"];
	$branch_q1 = $position_id_for_quarter1_row[0]["employee_details"]["branch_id"];

 $branch_type_row1 =  $this->Branch->query('select * from branches 
   where id = '. $branch_q1 .' ');
   if(count($branch_type_row1) > 0){
	$branch_type1 = $branch_type_row1[0]['branches']['branch_category_id'];
	if($branch_type1 == 1){ //means it is branch 
	   $result_array1= $this->find_branch_result($e_id , $budget_years[$x],  $from_date , $to_date , $position_q1, $branch_q1, 1);
	   $one_row['q1']  = $result_array1['technical'];

	   //------------------------------------------agreement started---------------------------------------------------------------
	   $agreement_status_row = $this->BranchPerformanceTrackingStatus->query('select * from branch_performance_tracking_statuses 
	where employee_id = '. $e_id .' and budget_year_id = '.$budget_years[$x].' and quarter = 1');

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
		$one_row['q1_technical_comment'] = $agreement_status_row[0]['branch_performance_tracking_statuses']['comment'];
		
	}
	 //------------------------------------------agreement ended---------------------------------------------------------------

	}
	else { //means it is not branch
	   
		$hoPlan1 = $this->HoPerformancePlan->query('select * from ho_performance_plans 
	where employee_id = '. $e_id .' and budget_year_id = '.$budget_years[$x].' and quarter = 1');
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
		$one_row['q1_technical_comment'] = $hoPlan1[0]['ho_performance_plans']['comment'];
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
		$result_array2 = $this->find_branch_result($e_id , $budget_years[$x],  $from_date , $to_date , $position_q2,$branch_q2, 2);
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
where employee_id = '. $e_id .' and budget_year_id = '.$budget_years[$x].' and quarter = 2');

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
	$one_row['q2_technical_comment'] = $agreement_status_row[0]['branch_performance_tracking_statuses']['comment'];
	//---------------------------------------------------find the behavioural agreements--------------------------------------------
	$behavioural_row = $this->CompetenceResult->query('select * from competence_results 
	where employee_id = '. $e_id .' and budget_year_id = '.$budget_years[$x].' and quarter = 2');
	if(count($behavioural_row) > 0){
		if($behavioural_row[0]['competence_results']['result_status'] == 1){
		    $one_row['q2_technical_agreement_result'] == "Pending agreement";
	   }
	   else if($behavioural_row[0]['competence_results']['result_status'] == 2){
		$one_row['q2_technical_agreement_result'] == "Agreed";
   		}
	  else if($behavioural_row[0]['competence_results']['result_status'] == 3){
			$one_row['q2_technical_agreement_result'] == "Agreed with reservation";
		 }
		$one_row['q2_behavioural_comment'] = $behavioural_row[0]['competence_results']['comment'];
	}
	//---------------------------------------------------end of finding the behavioural agreements----------------------------------
	
}
//-------------------------------------------------------end the agreements-------------------------------------------------------
	
	}
	else { //means it is not branch
	 $hoPlan2 = $this->HoPerformancePlan->query('select * from ho_performance_plans 
	where employee_id = '. $e_id .' and budget_year_id = '.$budget_years[$x].' and quarter = 2');

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
		$one_row['q2_technical_comment'] = $hoPlan2[0]['ho_performance_plans']['comment'];

	//---------------------------------------------------find the behavioural agreements--------------------------------------------
	$behavioural_row = $this->CompetenceResult->query('select * from competence_results 
	where employee_id = '. $e_id .' and budget_year_id = '.$budget_years[$x].' and quarter = 2');
	if(count($behavioural_row) > 0){
		if($behavioural_row[0]['competence_results']['result_status'] == 1){
		    $one_row['q2_technical_agreement_result'] == "Pending agreement";
	   }
	   else if($behavioural_row[0]['competence_results']['result_status'] == 2){
		$one_row['q2_technical_agreement_result'] == "Agreed";
   		}
	  else if($behavioural_row[0]['competence_results']['result_status'] == 3){
			$one_row['q2_technical_agreement_result'] == "Agreed with reservation";
		 }
		$one_row['q2_behavioural_comment'] = $behavioural_row[0]['competence_results']['comment'];
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
		$result_array3= $this->find_branch_result($e_id , $budget_years[$x],  $from_date , $to_date , $position_q3, $branch_q3, 3);
		$one_row['q3'] = $result_array3['technical'];

		//------------------------------------------agreement started---------------------------------------------------------------
		$agreement_status_row = $this->BranchPerformanceTrackingStatus->query('select * from branch_performance_tracking_statuses 
		where employee_id = '. $e_id .' and budget_year_id = '.$budget_years[$x].' and quarter = 3');
	
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
			$one_row['q3_technical_comment'] = $agreement_status_row[0]['branch_performance_tracking_statuses']['comment'];
			
		}
		 //------------------------------------------agreement ended---------------------------------------------------------------
	}
	else { //means it is not branch
	 $hoPlan3 = $this->HoPerformancePlan->query('select * from ho_performance_plans 
	where employee_id = '. $e_id .' and budget_year_id = '.$budget_years[$x].' and quarter = 3');
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
		$one_row['q3_technical_comment'] = $hoPlan3[0]['ho_performance_plans']['comment'];
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
		$result_array4 = $this->find_branch_result($e_id , $budget_years[$x],  $from_date , $to_date , $position_q4, $branch_q4, 4);
	$one_row['q4'] = $result_array4['technical'];
   if($one_row['q3'] == 0){
   $one_row['semiannual_technical2'] = ($one_row['q4']) * 0.9;
   }
   else{
   $one_row['semiannual_technical2'] = (($one_row['q3'] + $one_row['q4'])/2) * 0.9;
   }
	
	$one_row['behavioural2'] = ($result_array4['behavioural']/20) * 0.5;
	$one_row['semiannual_average2'] = $one_row['semiannual_technical2'] + $one_row['behavioural2'];

	//---------------------------------------------------------the agreements---------------------------------------------------------
$agreement_status_row = $this->BranchPerformanceTrackingStatus->query('select * from branch_performance_tracking_statuses 
where employee_id = '. $e_id .' and budget_year_id = '.$budget_years[$x].' and quarter = 4');

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
	$one_row['q4_technical_comment'] = $agreement_status_row[0]['branch_performance_tracking_statuses']['comment'];
	//---------------------------------------------------find the behavioural agreements--------------------------------------------
	$behavioural_row = $this->CompetenceResult->query('select * from competence_results 
	where employee_id = '. $e_id .' and budget_year_id = '.$budget_years[$x].' and quarter = 4');
	if(count($behavioural_row) > 0){
		if($behavioural_row[0]['competence_results']['result_status'] == 1){
		    $one_row['q4_technical_agreement_result'] == "Pending agreement";
	   }
	   else if($behavioural_row[0]['competence_results']['result_status'] == 2){
		$one_row['q4_technical_agreement_result'] == "Agreed";
   		}
	  else if($behavioural_row[0]['competence_results']['result_status'] == 3){
			$one_row['q4_technical_agreement_result'] == "Agreed with reservation";
		 }
		$one_row['q4_behavioural_comment'] = $behavioural_row[0]['competence_results']['comment'];
	}
	//---------------------------------------------------end of finding the behavioural agreements----------------------------------
	
}
//-------------------------------------------------------end the agreements-------------------------------------------------------

	}
	else { //means it is not branch
	 $hoPlan4 = $this->HoPerformancePlan->query('select * from ho_performance_plans 
	where employee_id = '. $e_id .' and budget_year_id = '.$budget_years[$x].' and quarter = 4');
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
		$one_row['q4_technical_comment'] = $hoPlan4[0]['ho_performance_plans']['comment'];

	//---------------------------------------------------find the behavioural agreements--------------------------------------------
	$behavioural_row = $this->CompetenceResult->query('select * from competence_results 
	where employee_id = '. $e_id .' and budget_year_id = '.$budget_years[$x].' and quarter = 4');
	if(count($behavioural_row) > 0){
		if($behavioural_row[0]['competence_results']['result_status'] == 1){
		    $one_row['q4_technical_agreement_result'] == "Pending agreement";
	   }
	   else if($behavioural_row[0]['competence_results']['result_status'] == 2){
		$one_row['q4_technical_agreement_result'] == "Agreed";
   		}
	  else if($behavioural_row[0]['competence_results']['result_status'] == 3){
			$one_row['q4_technical_agreement_result'] == "Agreed with reservation";
		 }
		$one_row['q4_behavioural_comment'] = $behavioural_row[0]['competence_results']['comment'];
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
$this->loadModel('Allocatedtraining');
$trainings_row = $this->Allocatedtraining->query('select * from allocatedtrainings 
where employee_id = '. $emp_ids[$j] .' and budget_year_id = '.$budget_years[$x].'');

foreach($trainings_row as $item3){
if($item3['allocatedtrainings']['quarter'] == 1){
	$one_row['q1_training1'] = $item3['allocatedtrainings']['training1'] == 0 ? "empty" : $training_list[$item3['allocatedtrainings']['training1']];
	$one_row['q1_training2'] = $item3['allocatedtrainings']['training2'] == 0 ? "empty" : $training_list[$item3['allocatedtrainings']['training2']];
	$one_row['q1_training3'] = $item3['allocatedtrainings']['training3'] == 0 ? "empty" : $training_list[$item3['allocatedtrainings']['training3']];
}
if($item3['allocatedtrainings']['quarter'] == 2){
	$one_row['q2_training1'] = $item3['allocatedtrainings']['training1'] == 0 ? "empty" : $training_list[$item3['allocatedtrainings']['training1']];
	$one_row['q2_training2'] = $item3['allocatedtrainings']['training2'] == 0 ? "empty" : $training_list[$item3['allocatedtrainings']['training2']];
	$one_row['q2_training3'] = $item3['allocatedtrainings']['training3'] == 0 ? "empty" : $training_list[$item3['allocatedtrainings']['training3']];
}
if($item3['allocatedtrainings']['quarter'] == 3){
	$one_row['q3_training1'] = $item3['allocatedtrainings']['training1'] == 0 ? "empty" : $training_list[$item3['allocatedtrainings']['training1']];
	$one_row['q3_training2'] = $item3['allocatedtrainings']['training2'] == 0 ? "empty" : $training_list[$item3['allocatedtrainings']['training2']];
	$one_row['q3_training3'] = $item3['allocatedtrainings']['training3'] == 0 ? "empty" : $training_list[$item3['allocatedtrainings']['training3']];
}
if($item3['allocatedtrainings']['quarter'] == 4){
	$one_row['q4_training1'] = $item3['allocatedtrainings']['training1'] == 0 ? "empty" : $training_list[$item3['allocatedtrainings']['training1']];
	$one_row['q4_training2'] = $item3['allocatedtrainings']['training2'] == 0 ? "empty" : $training_list[$item3['allocatedtrainings']['training2']];
	$one_row['q4_training3'] = $item3['allocatedtrainings']['training3'] == 0 ? "empty" : $training_list[$item3['allocatedtrainings']['training3']];

}

}


//--------------------------------------end of find the trainings-------------------------------------------------------------------		
        $this->write_report_to_database( $one_row);
			//	array_push($report_table, $one_row);
		}
	}
}
	}
 
 //---------------------------------fetch all data from table into $report_table-------------------------------------------
  $report_table = $this->report_db_to_excel();


	$this->set(compact ('report_table',  'output_type' ));

	}



	function all_report3() {
		$budget_year_search = 0;

		if (!empty($this->data)) {
			$search_data = $this->data ;
			$budget_year_search = $search_data['CompetenceCategory']['budget_year_id'];
			$output_type = $search_data['CompetenceCategory']['output_type'];
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
		
       //----------------------------------------training names--------------------------------------------
					$this->loadModel('Training');
					$trainings = array();
					$trainings = $this->Training->find('all');
					
					$training_list = array();
					foreach($trainings as $item){
							
						$training_list[$item["Training"]["id"]] = $item["Training"]["name"];
						
					}
	   //----------------------------------------end of training names---------------------------------

		 $emp_ids = $this->get_emp_ids();

		 for($j = 0; $j < count($emp_ids); $j ++){
			
			$budget_years = array();
			$hoPlan = array();
			if($budget_year_search == 0){  // means all budget years
				 $hoPlan = $this->HoPerformancePlan->query('select * from ho_performance_plans 
				 where employee_id = '. $emp_ids[$j] .' ');
			}
			else {
				$hoPlan = $this->HoPerformancePlan->query('select * from ho_performance_plans 
				where employee_id = '. $emp_ids[$j] .' and budget_year_id = '.$budget_year_search.'');
			}
			
			if(count($hoPlan) > 0) {
				foreach($hoPlan as $item){ // incase a person has been here for more than one year
					if(!in_array( $item['ho_performance_plans']['budget_year_id'] , $budget_years)){ 
						array_push($budget_years, $item['ho_performance_plans']['budget_year_id']);
					}
				}
			//-----------------------------find emp name and stuff---------------------------------------------
			$this->loadModel('Employee');
			$this->loadModel('User');
			$this->loadModel('Person');

			$first_name = "";
			$middle_name = "";
			$last_name = "";
			$sex = "";
			$date_of_employment = "";
			$status = "";
			$last_position = "";
			$branch = "";
			$branch_district = "";

			       	$emp_rows= $this->Employee->query('select * from employees where id = '.$emp_ids[$j]);
					$user_id = $emp_rows[0]['employees']['user_id'];
					$emp_id = $emp_rows[0]['employees']['card'];
					$date_of_employment = $emp_rows[0]['employees']['date_of_employment'];
					$status = $emp_rows[0]['employees']['status'];

					$user_row = $this->User->query('select * from users where id = '. $user_id);
					if(count($user_row) > 0){
					$person_id = $user_row[0]['users']['person_id'];
					
					$person_row = $this->Person->query('select * from people where id = '. $person_id);

					$full_name = $person_row[0]['people']['first_name'].' '.$person_row[0]['people']['middle_name'].' '.$person_row[0]['people']['last_name'];
					$first_name = $person_row[0]['people']['first_name'];
					$middle_name = $person_row[0]['people']['middle_name'];
					$last_name = $person_row[0]['people']['last_name'];
					$sex = $person_row[0]['people']['sex'];
			
				}

				// get position and branch
					
						$this->loadModel('EmployeeDetail');
						$this->loadModel('Position');
						$this->loadModel('Branch');
						$position_id_row = $this->EmployeeDetail->query('select * from employee_details 
								where employee_id = '. $emp_ids[$j] .' order by start_date desc');
						if(count($position_id_row) > 0){
							$position_id = $position_id_row[0]['employee_details']['position_id'];
							$branch_id = $position_id_row[0]['employee_details']['branch_id'];
						}		
						
						$branch_name_row = $this->Branch->query('select * from branches 
								where id = '. $branch_id .' order by id desc');
						if(count($branch_name_row) > 0){
							$branch_name = $branch_name_row[0]['branches']['name'];
							$branch = $branch_name;
							$branch_district = $branch_name_row[0]['branches']['region'];	
						}

							
						$position_name_row = $this->Position->query('select * from positions
						where id = '. $position_id .' ');
						if(count($position_name_row) > 0){
							$position_name = $position_name_row[0]['positions']['name'];
							$last_position = $position_name;
						}
						

		      // end of get positions and branch
			//----------------------------end of finding emp name and stuff------------------------------------


			for($x = 0; $x < count($budget_years) ; $x++){ //each row in to the table

				$one_row['employee_id'] = $emp_id;
				$one_row['first_name'] = $first_name;
				$one_row['middle_name'] = $middle_name;
				$one_row['last_name'] = $last_name;
				$one_row['sex'] = $sex;
				$one_row['date_of_employment'] = $date_of_employment;
				$one_row['status'] = $status;
				$one_row['last_position'] = $last_position;
				$one_row['branch'] = $branch;
				$one_row['branch_district'] = $branch_district;
				$one_row['budget_year'] = 0;
				$this->loadModel('BudgetYear');
				$conditions3 = array('BudgetYear.id' => $budget_years[$x] );
				$hoPlan3 = $this->BudgetYear->find('first', array('conditions' => $conditions3));
				$one_row['budget_year']  = $hoPlan3['BudgetYear']['name'];

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
				$one_row['q1_training1']  = "";
				$one_row['q1_training2']  = "";
				$one_row['q1_training3']  = "";
				$one_row['q2_training1']  = "";
				$one_row['q2_training2']  = "";
				$one_row['q2_training3']  = "";
				$one_row['q3_training1']  = "";
				$one_row['q3_training2']  = "";
				$one_row['q3_training3']  = "";
				$one_row['q4_training1']  = "";
				$one_row['q4_training2']  = "";
				$one_row['q4_training3']  = "";

				$hoPlan2 = $this->HoPerformancePlan->query('select * from ho_performance_plans 
			where employee_id = '. $emp_ids[$j] .' and budget_year_id = '.$budget_years[$x].'');
				// $conditions2 = array('HoPerformancePlan.employee_id' => $emp_ids[$j], 'HoPerformancePlan.budget_year_id' => $budget_years[$x] );
				// $hoPlan2 = $this->HoPerformancePlan->find('all', array('conditions' => $conditions2));
				
				foreach($hoPlan2 as $item2){
					
					if($item2['ho_performance_plans']['quarter'] == 1){
						$one_row['q1'] = $item2['ho_performance_plans']['both_technical_percent'];
					}
					if($item2['ho_performance_plans']['quarter'] == 2){
						$one_row['q2'] = $item2['ho_performance_plans']['both_technical_percent'];
						$one_row['semiannual_technical1'] = $item2['ho_performance_plans']['semiannual_technical'];
						$one_row['behavioural1'] = $item2['ho_performance_plans']['behavioural_percent'];
						$one_row['semiannual_average1'] = $item2['ho_performance_plans']['semiannual_average'];
					}
					if($item2['ho_performance_plans']['quarter'] == 3){
						$one_row['q3'] = $item2['ho_performance_plans']['both_technical_percent'];
					}
					if($item2['ho_performance_plans']['quarter'] == 4){
						$one_row['q4'] = $item2['ho_performance_plans']['both_technical_percent'];
						$one_row['semiannual_technical2'] = $item2['ho_performance_plans']['semiannual_technical'];
						$one_row['behavioural2'] = $item2['ho_performance_plans']['behavioural_percent'];
						$one_row['semiannual_average2'] = $item2['ho_performance_plans']['semiannual_average'];

					}

				}

				if(count($hoPlan2) > 0){
										// $one_row['budget_year'] = $items2['HoPerformancePlan']['budget_year_id'];
								//---------------------find yearly average---------------------------------------------------------
								if($one_row['semiannual_average1'] > 0 && $one_row['semiannual_average2'] > 0){
									$one_row['annual'] = ($one_row['semiannual_average1'] + $one_row['semiannual_average2']) / 2 ;
								}
								else {
									if($one_row['semiannual_average1'] > 0){
										$one_row['annual'] = $one_row['semiannual_average1'];
									}
									if($one_row['semiannual_average2'] > 0){
										$one_row['annual'] = $one_row['semiannual_average2'];
									}
								}
								//-----------------------------------now add each row to the table---------------------------------------------
			//--------------------------------------now find the trainings--------------------------------------------------------------
			    $this->loadModel('Allocatedtraining');
				$trainings_row = $this->Allocatedtraining->query('select * from allocatedtrainings 
			 where employee_id = '. $emp_ids[$j] .' and budget_year_id = '.$budget_years[$x].'');

			foreach($trainings_row as $item3){
				if($item3['allocatedtrainings']['quarter'] == 1){
					$one_row['q1_training1'] = $training_list[$item3['allocatedtrainings']['training1']];
					$one_row['q1_training2'] = $training_list[$item3['allocatedtrainings']['training2']];
					$one_row['q1_training3'] = $training_list[$item3['allocatedtrainings']['training3']];
				}
				if($item3['allocatedtrainings']['quarter'] == 2){
					$one_row['q2_training1'] = $training_list[$item3['allocatedtrainings']['training1']];
					$one_row['q2_training2'] = $training_list[$item3['allocatedtrainings']['training2']];
					$one_row['q2_training3'] = $training_list[$item3['allocatedtrainings']['training3']];
				}
				if($item3['allocatedtrainings']['quarter'] == 3){
					$one_row['q3_training1'] = $training_list[$item3['allocatedtrainings']['training1']];
					$one_row['q3_training2'] = $training_list[$item3['allocatedtrainings']['training2']];
					$one_row['q3_training3'] = $training_list[$item3['allocatedtrainings']['training3']];
				}
				if($item3['allocatedtrainings']['quarter'] == 4){
					$one_row['q4_training1'] = $training_list[$item3['allocatedtrainings']['training1']];
					$one_row['q4_training2'] = $training_list[$item3['allocatedtrainings']['training2']];
					$one_row['q4_training3'] = $training_list[$item3['allocatedtrainings']['training3']];

				}

			}


			//--------------------------------------end of find the trainings-------------------------------------------------------------------		

								array_push($report_table, $one_row);
				}
			

			}

			}


			// enter the last one to the table
			
		 }
		
		 $this->set(compact ('report_table',  'output_type' ));
	
	}

	function all_report2() {
		$budget_year_search = 0;
		if (!empty($this->data)) {
			$search_data = $this->data ;
			$budget_year_search = $search_data['CompetenceCategory']['budget_year_id'];
			$output_type = $search_data['CompetenceCategory']['output_type'];
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
		
       //----------------------------------------training names--------------------------------------------
					$this->loadModel('Training');
					$trainings = array();
					$trainings = $this->Training->find('all');
					
					$training_list = array();
					foreach($trainings as $item){
							
						$training_list[$item["Training"]["id"]] = $item["Training"]["name"];
						
					}
	   //----------------------------------------end of training names---------------------------------

		 $emp_ids = $this->get_emp_ids();

		 for($j = 0; $j < count($emp_ids); $j ++){
			
			$budget_years = array();
			$hoPlan = array();
			if($budget_year_search == 0){  // means all budget years
				 $hoPlan = $this->HoPerformancePlan->query('select * from ho_performance_plans 
				 where employee_id = '. $emp_ids[$j] .' ');
			}
			else {
				$hoPlan = $this->HoPerformancePlan->query('select * from ho_performance_plans 
				where employee_id = '. $emp_ids[$j] .' and budget_year_id = '.$budget_year_search.'');
			}
			
			if(count($hoPlan) > 0) {
				foreach($hoPlan as $item){ // incase a person has been here for more than one year
					if(!in_array( $item['ho_performance_plans']['budget_year_id'] , $budget_years)){ 
						array_push($budget_years, $item['ho_performance_plans']['budget_year_id']);
					}
				}
			//-----------------------------find emp name and stuff---------------------------------------------
			$this->loadModel('Employee');
			$this->loadModel('User');
			$this->loadModel('Person');

			$first_name = "";
			$middle_name = "";
			$last_name = "";
			$sex = "";
			$date_of_employment = "";
			$status = "";
			$last_position = "";
			$branch = "";
			$branch_district = "";

			       	$emp_rows= $this->Employee->query('select * from employees where id = '.$emp_ids[$j]);
					$user_id = $emp_rows[0]['employees']['user_id'];
					$emp_id = $emp_rows[0]['employees']['card'];
					$date_of_employment = $emp_rows[0]['employees']['date_of_employment'];
					$status = $emp_rows[0]['employees']['status'];

					$user_row = $this->User->query('select * from users where id = '. $user_id);
					if(count($user_row) > 0){
					$person_id = $user_row[0]['users']['person_id'];
					
					$person_row = $this->Person->query('select * from people where id = '. $person_id);

					$full_name = $person_row[0]['people']['first_name'].' '.$person_row[0]['people']['middle_name'].' '.$person_row[0]['people']['last_name'];
					$first_name = $person_row[0]['people']['first_name'];
					$middle_name = $person_row[0]['people']['middle_name'];
					$last_name = $person_row[0]['people']['last_name'];
					$sex = $person_row[0]['people']['sex'];
			
				}

				// get position and branch
					
						$this->loadModel('EmployeeDetail');
						$this->loadModel('Position');
						$this->loadModel('Branch');
						$position_id_row = $this->EmployeeDetail->query('select * from employee_details 
								where employee_id = '. $emp_ids[$j] .' order by start_date desc');
						if(count($position_id_row) > 0){
							$position_id = $position_id_row[0]['employee_details']['position_id'];
							$branch_id = $position_id_row[0]['employee_details']['branch_id'];
						}		
						
						$branch_name_row = $this->Branch->query('select * from branches 
								where id = '. $branch_id .' order by id desc');
						if(count($branch_name_row) > 0){
							$branch_name = $branch_name_row[0]['branches']['name'];
							$branch = $branch_name;
							$branch_district = $branch_name_row[0]['branches']['region'];	
						}

							
						$position_name_row = $this->Position->query('select * from positions
						where id = '. $position_id .' ');
						if(count($position_name_row) > 0){
							$position_name = $position_name_row[0]['positions']['name'];
							$last_position = $position_name;
						}
						

		      // end of get positions and branch
			//----------------------------end of finding emp name and stuff------------------------------------


			for($x = 0; $x < count($budget_years) ; $x++){ //each row in to the table

				$one_row['employee_id'] = $emp_id;
				$one_row['first_name'] = $first_name;
				$one_row['middle_name'] = $middle_name;
				$one_row['last_name'] = $last_name;
				$one_row['sex'] = $sex;
				$one_row['date_of_employment'] = $date_of_employment;
				$one_row['status'] = $status;
				$one_row['last_position'] = $last_position;
				$one_row['branch'] = $branch;
				$one_row['branch_district'] = $branch_district;
				$one_row['budget_year'] = 0;
				$this->loadModel('BudgetYear');
				$conditions3 = array('BudgetYear.id' => $budget_years[$x] );
				$hoPlan3 = $this->BudgetYear->find('first', array('conditions' => $conditions3));
				$one_row['budget_year']  = $hoPlan3['BudgetYear']['name'];

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
				$one_row['q1_training1']  = "";
				$one_row['q1_training2']  = "";
				$one_row['q1_training3']  = "";
				$one_row['q2_training1']  = "";
				$one_row['q2_training2']  = "";
				$one_row['q2_training3']  = "";
				$one_row['q3_training1']  = "";
				$one_row['q3_training2']  = "";
				$one_row['q3_training3']  = "";
				$one_row['q4_training1']  = "";
				$one_row['q4_training2']  = "";
				$one_row['q4_training3']  = "";

				$hoPlan2 = $this->HoPerformancePlan->query('select * from ho_performance_plans 
			where employee_id = '. $emp_ids[$j] .' and budget_year_id = '.$budget_years[$x].'');
				// $conditions2 = array('HoPerformancePlan.employee_id' => $emp_ids[$j], 'HoPerformancePlan.budget_year_id' => $budget_years[$x] );
				// $hoPlan2 = $this->HoPerformancePlan->find('all', array('conditions' => $conditions2));
				
				foreach($hoPlan2 as $item2){
					
					if($item2['ho_performance_plans']['quarter'] == 1){
						$one_row['q1'] = $item2['ho_performance_plans']['both_technical_percent'];
					}
					if($item2['ho_performance_plans']['quarter'] == 2){
						$one_row['q2'] = $item2['ho_performance_plans']['both_technical_percent'];
						$one_row['semiannual_technical1'] = $item2['ho_performance_plans']['semiannual_technical'];
						$one_row['behavioural1'] = $item2['ho_performance_plans']['behavioural_percent'];
						$one_row['semiannual_average1'] = $item2['ho_performance_plans']['semiannual_average'];
					}
					if($item2['ho_performance_plans']['quarter'] == 3){
						$one_row['q3'] = $item2['ho_performance_plans']['both_technical_percent'];
					}
					if($item2['ho_performance_plans']['quarter'] == 4){
						$one_row['q4'] = $item2['ho_performance_plans']['both_technical_percent'];
						$one_row['semiannual_technical2'] = $item2['ho_performance_plans']['semiannual_technical'];
						$one_row['behavioural2'] = $item2['ho_performance_plans']['behavioural_percent'];
						$one_row['semiannual_average2'] = $item2['ho_performance_plans']['semiannual_average'];

					}

				}

				if(count($hoPlan2) > 0){
										// $one_row['budget_year'] = $items2['HoPerformancePlan']['budget_year_id'];
								//---------------------find yearly average---------------------------------------------------------
								if($one_row['semiannual_average1'] > 0 && $one_row['semiannual_average2'] > 0){
									$one_row['annual'] = ($one_row['semiannual_average1'] + $one_row['semiannual_average2']) / 2 ;
								}
								else {
									if($one_row['semiannual_average1'] > 0){
										$one_row['annual'] = $one_row['semiannual_average1'];
									}
									if($one_row['semiannual_average2'] > 0){
										$one_row['annual'] = $one_row['semiannual_average2'];
									}
								}
								//-----------------------------------now add each row to the table---------------------------------------------
			//--------------------------------------now find the trainings--------------------------------------------------------------
			    $this->loadModel('Allocatedtraining');
				$trainings = $this->Allocatedtraining->query('select * from allocatedtrainings 
			 where employee_id = '. $emp_ids[$j] .' and budget_year_id = '.$budget_years[$x].'');

			foreach($trainings as $item3){
				if($item3['allocatedtrainings']['quarter'] == 1){
					$one_row['q1_training1'] = $training_list[$item3['allocatedtrainings']['training1']];
					$one_row['q1_training2'] = $training_list[$item3['allocatedtrainings']['training2']];
					$one_row['q1_training3'] = $training_list[$item3['allocatedtrainings']['training3']];
				}
				if($item3['allocatedtrainings']['quarter'] == 2){
					$one_row['q2_training1'] = $training_list[$item3['allocatedtrainings']['training1']];
					$one_row['q2_training2'] = $training_list[$item3['allocatedtrainings']['training2']];
					$one_row['q2_training3'] = $training_list[$item3['allocatedtrainings']['training3']];
				}
				if($item3['allocatedtrainings']['quarter'] == 3){
					$one_row['q3_training1'] = $training_list[$item3['allocatedtrainings']['training1']];
					$one_row['q3_training2'] = $training_list[$item3['allocatedtrainings']['training2']];
					$one_row['q3_training3'] = $training_list[$item3['allocatedtrainings']['training3']];
				}
				if($item3['allocatedtrainings']['quarter'] == 4){
					$one_row['q4_training1'] = $training_list[$item3['allocatedtrainings']['training1']];
					$one_row['q4_training2'] = $training_list[$item3['allocatedtrainings']['training2']];
					$one_row['q4_training3'] = $training_list[$item3['allocatedtrainings']['training3']];

				}

			}


			//--------------------------------------end of find the trainings-------------------------------------------------------------------		

								array_push($report_table, $one_row);
				}
			

			}

			}


			// enter the last one to the table
			
		 }
		
		 $this->set(compact ('report_table',  'output_type' ));
	
	}

	
}
?>