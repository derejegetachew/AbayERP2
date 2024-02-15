<?php
class LoanDisbursementRequestsController extends AppController {

	var $name = 'LoanDisbursementRequests';
	
	function index() {
        $position_id = $this->get_position_id();
        $position_array = array(899, 898, 49);
        
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
		//$district_name = "";
   $is_branch = false;
		$branches_array = array();
		$branches_row = $this->Branch->query('select * from branches where id = '.$branch_id.' and branch_category_id = 1 ');
   if(count($branches_row) > 0){
  // $branches_array[$branches_row[0]['branches']['id']] = $branches_row[0]['branches']['name'];
  $is_branch = true;
   }
   
  // $is_branch = true;
  // $branch_id = 377;
   
   
   
   $this->set('is_branch', $is_branch );
   $this->set('branch_id', $branch_id );
   
	}
	

	function search() {
	}

	function get_all_branches(){
		$this->loadModel('Branch');
		$branches_array = array();

		$branches_row = $this->Branch->query("select * from branches where fc_code != '000' ");
		
		foreach($branches_row as $item){
			$branches_array[$item['branches']['id']] = $item['branches']['name'];
		}

		return $branches_array;

	}
 
 function get_position_id(){  //899
 	$user = $this->Session->read();
		$user_id = $user['Auth']['User']['id'];
		$this->loadModel('Employee');
		$this->loadModel('EmployeeDetail');
		$this->loadModel('Branch');
   $emp_id = 0;
		$emp_id_row = $this->Employee->query('select * from employees where user_id = '.$user_id);
		if(count($emp_id_row) > 0){
			$emp_id = $emp_id_row[0]["employees"]["id"];
		}
   
   	$emp_detail_row = $this->EmployeeDetail->query('select * from employee_details where employee_id = '.$emp_id.' order by start_date desc');
		$position_id = 0;
	//	$position_id = 0;
		if(count($emp_detail_row) > 0){
			$position_id = $emp_detail_row[0]["employee_details"]["position_id"];
		//	$position_id = $emp_detail_row[0]["employee_details"]["position_id"];

		}
   
   return $position_id;
 
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
		//$district_name = "";
		$branches_array = array();
		$branches_row = $this->Branch->query('select * from branches where id = '.$branch_id.' and branch_category_id = 1 ');
   if(count($branches_row) > 0){
   $branches_array[$branches_row[0]['branches']['id']] = $branches_row[0]['branches']['name'];
   }
		
		//$district_name = $district_row[0]['branches']['name'];
		//------------------------------------end of get the district name---------------------------------------------------------
		// //-----------------------------------------find the branches of that district-----------------------------------------------
		
		// $branches_row = $this->Branch->query("select * from branches where region = '".$district_name."' and fc_code != '000' ");
		// foreach($branches_row as $item){
		// 	$branches_array[$item['branches']['id']] = $item['branches']['name'];
		// }
		//--------------------------------------------end of the branches of that district-------------------------------------------

		return $branches_array;


	}
 

	
	function list_data($id = null) {
		$start = (isset($_REQUEST['start'])) ? $_REQUEST['start'] : 0;
		$limit = (isset($_REQUEST['limit'])) ? $_REQUEST['limit'] : 5;
        $conditions = (isset($_REQUEST['conditions'])) ? $_REQUEST['conditions'] : '';

		$branches_array = $this->get_few_branches();

		

        eval("\$conditions = array( " . $conditions . " );");
        
        

	
        
        $position_id = $this->get_position_id();
        $position_array = array(899, 898, 49);
        
        if(in_array($position_id,  $position_array)){
            if($position_id == 898){
            $conditions['LoanDisbursementRequest.company_size'] = array(1);
            }
            if($position_id == 899){
            $conditions['LoanDisbursementRequest.company_size'] = array(2);
            }
        
        }
        else {
        	if (count($branches_array) != 0) {
            $conditions['LoanDisbursementRequest.branch'] = key($branches_array);
        }
        else{
            $conditions['LoanDisbursementRequest.branch'] = array();
        }
        
        }

       
		$this->set('get_all_branches' , $this->get_all_branches());
		
		$this->set('loanDisbursementRequests', $this->LoanDisbursementRequest->find('all', array('conditions' => $conditions, 'limit' => $limit, 'offset' => $start)));
		$this->set('results', $this->LoanDisbursementRequest->find('count', array('conditions' => $conditions)));
		

	}

	function view($id = null) {
		if (!$id) {
			$this->Session->setFlash(__('Invalid loan disbursement request', true));
			$this->redirect(array('action' => 'index'));
		}
		$this->LoanDisbursementRequest->recursive = 2;
		$this->set('loanDisbursementRequest', $this->LoanDisbursementRequest->read(null, $id));
	}

	function add($id = null) {
		if (!empty($this->data)) {

			$original_data = $this->data;
			
		//	$amount_approved = $original_data['LoanDisbursementRequest']['amount_approved'];
			
	
		//	$definitions_row = $this->CompetenceDefinition->query("select * from competence_definitions where competence_level_id = ".$definition_level_id." and competence_id = ".$definition_competence_id."");
			$this->LoanDisbursementRequest->create();
			$this->autoRender = false;
			if ($this->LoanDisbursementRequest->save($this->data)) {
				
				$this->Session->setFlash(__('The loan disbursement request has been saved', true), '');
				$this->render('/elements/success');
			} else {
				$this->Session->setFlash(__('The loan disbursement request could not be saved. Please, try again.', true), '');
				$this->render('/elements/failure');
			}
		}
   
   //----------------------------------------find the approval status array--------------------------------------
        $approval_status_array = array();
       $position_id = $this->get_position_id(); 
       $position_array = array(899, 898); 
       if(!in_array($position_id, $position_array) ){
           $approval_status_array[1] = "Pending";
       }
       else {
           $approval_status_array[1] = "Pending";
           $approval_status_array[2] = "Approved";
           $approval_status_array[3] = "Rejected";
       }
   
   //----------------------------------------end of finding the approval status array----------------------------

		$this->set('branches_array', $this->get_few_branches());
    $this->set('approval_status_array', $approval_status_array);

	}

	function edit($id = null, $parent_id = null) {
		if (!$id && empty($this->data)) {
			$this->Session->setFlash(__('Invalid loan disbursement request', true), '');
			$this->redirect(array('action' => 'index'));
		}
		if (!empty($this->data)) {
      $original_data = $this->data;
      //------------------------------------find approval status-------------------------------------------------------
      	$status_row = $this->LoanDisbursementRequest->query('select * from loan_disbursement_requests where 
        id = '.$original_data['LoanDisbursementRequest']['id'].' and branch_category_id = 1 ');
        $approval_status = 0;
        if(count($status_row) > 0){
          $approval_status = $status_row['loan_disbursement_requests'][0]['approval_status'];
        
        }
      //-----------------------------------end of find approval status--------------------------------------------------
      if($approval_status == 1){
      $this->autoRender = false;
			if ($this->LoanDisbursementRequest->save($this->data)) {
				$this->Session->setFlash(__('The loan disbursement request has been saved', true), '');
				$this->render('/elements/success');
			} else {
				$this->Session->setFlash(__('The loan disbursement request could not be saved. Please, try again.', true), '');
				$this->render('/elements/failure');
			}
      
      } else {
      
        $this->Session->setFlash(__('The status is not pending.', true), '');
				$this->render('/elements/failure3');
      
      }
   
			
		}
   
    //----------------------------------------find the approval status array--------------------------------------
       $approval_status_array = array();
       $position_id = $this->get_position_id(); 
       $position_array = array(899, 898); 
       if(!in_array($position_id, $position_array) ){
           $approval_status_array[1] = "Pending";
       }
       else {
           $approval_status_array[1] = "Pending";
           $approval_status_array[2] = "Approved";
           $approval_status_array[3] = "Rejected";
       }
       
   
   //----------------------------------------end of finding the approval status array----------------------------


    $this->set('approval_status_array', $approval_status_array);

		$this->set('branches_array', $this->get_few_branches());
		$this->set('loan_disbursement_request', $this->LoanDisbursementRequest->read(null, $id));
		
			
	}

	function delete($id = null) {
		$this->autoRender = false;
		if (!$id) {
			$this->Session->setFlash(__('Invalid id for loan disbursement request', true), '');
			$this->render('/elements/failure');
		}
		if (stripos($id, '_') !== false) {
            $ids = explode('_', $id);
            try{
                foreach ($ids as $i) {
                    $this->LoanDisbursementRequest->delete($i);
                }
				$this->Session->setFlash(__('Loan disbursement request deleted', true), '');
				$this->render('/elements/success');
            }
            catch (Exception $e){
				$this->Session->setFlash(__('Loan disbursement request was not deleted', true), '');
				$this->render('/elements/failure');
            }
        } else {
            if ($this->LoanDisbursementRequest->delete($id)) {
				$this->Session->setFlash(__('Loan disbursement request deleted', true), '');
				$this->render('/elements/success');
			} else {
				$this->Session->setFlash(__('Loan disbursement request was not deleted', true), '');
				$this->render('/elements/failure');
			}
        }
	}
}
?>