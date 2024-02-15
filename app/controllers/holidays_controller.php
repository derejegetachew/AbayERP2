<?php

class HolidaysController extends AppController {

    var $name = 'Holidays';

	
	function batchleavebalance(){
		
		$report_date="2018-05-30";//set to null for default
		$emps = $this->Holiday->Employee->find('all');
        $balance=array();
		foreach($emps as $emp){
			//$annual = $this->calculate_annual_leave_backdate($emp['Employee']['id'],1,$report_date);
			$annual = $this->calculate_annual_leave($emp['Employee']['id'],1);
			$most_recent_2years = $annual[1];
			$taken_sys = $this->calculate_system_leave_taken($emp['Employee']['id'],1,0,$report_date);
			//$taken_sys_half = $this->calculate_system_leave_taken($emp['Employee']['id'],2,1,$report_date);
			$taken_sys_half = $this->calculate_system_leave_taken($emp['Employee']['id'],2,1);
			
			$taken_sys = $taken_sys + ($taken_sys_half/2);
			$taken_before = $this->leave_taken_before($emp['Employee']['id'],1);
			$alltaken=$taken_sys+$taken_before;
			$total = $annual[0];
			$bal=$annual[0]-$alltaken;
			$expired = $bal - $most_recent_2years;
			if($expired < 0){
				$expired = 0;
			}
			$bal=$bal-$expired;
			
			unset($balance);
			$balance = $this->Holiday->LeaveType->LeaveRule->find('all', array('conditions' => array('LeaveRule.employee_id' => $emp['Employee']['id'], 'LeaveRule.leave_type_id' => 1)));
			 if (!empty($balance)) {
				$this->data['LeaveRule']['total'] = $annual[0];
				$this->data['LeaveRule']['taken'] = $alltaken;
                $this->data['LeaveRule']['balance'] = $bal;
				$this->data['LeaveRule']['expired'] = $expired;
                $this->data['LeaveRule']['id'] = $balance[0]['LeaveRule']['id'];
				$this->data['LeaveRule']['leave_type_id'] = $balance[0]['LeaveRule']['leave_type_id'];
                $this->Holiday->LeaveType->LeaveRule->save($this->data);
			 }else{			 
				if($this->initializeleave($emp['Employee']['id'])==true){
				$balance = $this->Holiday->LeaveType->LeaveRule->find('all', array('conditions' => array('LeaveRule.employee_id' => $emp['Employee']['id'], 'LeaveRule.leave_type_id' => 1)));
				$this->data['LeaveRule']['total'] = $annual[0];
				$this->data['LeaveRule']['taken'] = $alltaken;
                $this->data['LeaveRule']['balance'] = $bal;
				$this->data['LeaveRule']['expired'] = $expired;
                $this->data['LeaveRule']['id'] = $balance[0]['LeaveRule']['id'];
				$this->data['LeaveRule']['leave_type_id'] = $balance[0]['LeaveRule']['leave_type_id'];
                $this->Holiday->LeaveType->LeaveRule->save($this->data);
				}
			 }
			//print_r($this->data);
		}
		echo 'Done';
	}
	
	function batch_report($report_date = null,$salary=null){

		//$report_date="2020-4-8"; //set to null for default
		$report_date=date("Y-m-d", strtotime($report_date));
		 $conditions['Employee.date_of_employment <= '] = $report_date;
		// $conditions['Termination.date > '] = $report_date;
		$this->loadModel('Employee');
		$this->Employee->recursive=1;
		$this->User->recursive=0;
		$this->loadModel('User');
		$this->Employee->unbindModel(array('belongsTo' => array('EmpLoc','ContactLocation'),'hasMany' => array('Education','EmployeeDetail','Experience','Language','Offspring','Loan','DisciplinaryRecord')));
		//$this->Employee->User->unbindModel(array('belongsTo' => array('Branch','Payroll'),'hasMany' => array('Group')));
		$emps = $this->Employee->find('all', array('conditions' => $conditions));
        $balance=array();
		$output= '<table><tr><td>Full Name</td><td>Branch</td><td>Region</td>';
		if($salary=='true')
		$output.='<td>Salary</td>';
		$output.='<td>Position</td><td>Employement Date</td><td>ID Card</td><td>Total Leave</td><td>Leave Taken Manually</td><td>Leave Taken by System</td><td>Most Recent 2 Years</td><td>Balance</td><td>Expired</td></tr>';
		
		foreach($emps as $emp){
			//print_r($emps);
			if(!empty($emp['Termination'][0]))
				if($emp['Termination'][0]['date'] < $report_date)
					continue;
					
			$usare=$this->User->read(null,$emp['Employee']['user_id']);
			$output.= '<tr><td>'.$usare['Person']['first_name'].' '.$usare['Person']['middle_name'].'</td>';		
			
			$annual = $this->calculate_annual_leave_backdate($emp['Employee']['id'],1,$report_date,&$output,$salary);
			
			$output.= '<td>'.$emp['Employee']['date_of_employment'].'</td>';		
			$output.= '<td>'.$emp['Employee']['card'].'</td>';
			//$annual = $this->calculate_annual_leave($emp['Employee']['id'],1);
				//print_r($emps);
		
			$most_recent_2years = $annual[1];
			$taken_sys = $this->calculate_system_leave_taken($emp['Employee']['id'],1,0,$report_date);
			$taken_sys_half = $this->calculate_system_leave_taken($emp['Employee']['id'],2,1,$report_date);
			//$taken_sys_half = $this->calculate_system_leave_taken($emp['Employee']['id'],2,1);
			
			$taken_sys = $taken_sys + ($taken_sys_half/2);
			$taken_before = $this->leave_taken_before($emp['Employee']['id'],1);
			$alltaken=$taken_sys+$taken_before;
			$total = $annual[0];
			$bal=$annual[0]-$alltaken;
			$expired = 0;
			if($bal>$most_recent_2years)
				$expired = $bal - $most_recent_2years;
			if($expired < 0){
				$expired = 0;
			}
			
			$bal=$bal-$expired;
			//$bal=$bal-$expired - $taken_before;
			
			
			$output.= '<td>'.$annual[0].'</td>';
			$output.= '<td>'.$taken_before.'</td>';
			$output.= '<td>'.$taken_sys.'</td>';
			$output.= '<td>'.$most_recent_2years.'</td>';
			$output.= '<td>'.$bal.'</td>';
			$output.= '<td>'.$expired.'</td></tr>';
		
		}
				header("Content-type: application/vnd.ms-excel");
                header("Content-Disposition: attachment; filename=report.xls");
                echo $output;
		//echo 'Done';
	}
    function index() {
       $emp = $this->Holiday->Employee->findByuser_id($this->Session->read('Auth.User.id'));
        if (!empty($emp)) {
		$annual = $this->calculate_annual_leave($emp['Employee']['id'],1);
		$taken_sys = $this->calculate_system_leave_taken($emp['Employee']['id'],1,0);
		$taken_sys_half = $this->calculate_system_leave_taken($emp['Employee']['id'],2,1);
		$taken_sys = $taken_sys + ($taken_sys_half/2);
		$taken_before = $this->leave_taken_before($emp['Employee']['id'],1);
		$alltaken=$taken_sys+$taken_before;
		$bal=$annual[0]-$alltaken;
            $balance = $this->Holiday->LeaveType->LeaveRule->find('all', array('conditions' => array('LeaveRule.employee_id' => $emp['Employee']['id'], 'LeaveRule.leave_type_id' => 1)));
            if (!empty($balance)) {

                $this->data['LeaveRule']['total'] = $annual[0];
				$this->data['LeaveRule']['taken'] = $alltaken;
                $this->data['LeaveRule']['balance'] = $bal;
                $this->data['LeaveRule']['id'] = $balance[0]['LeaveRule']['id'];
				$this->data['LeaveRule']['leave_type_id'] = $balance[0]['LeaveRule']['leave_type_id'];
                $this->Holiday->LeaveType->LeaveRule->save($this->data);

                $halfbalance = $this->Holiday->LeaveType->LeaveRule->find('all', array('conditions' => array('LeaveRule.employee_id' => $emp['Employee']['id'], 'LeaveRule.leave_type_id' => 2)));
                $this->data['LeaveRule']['total'] = $annual[0] * 2;
				$this->data['LeaveRule']['taken'] = $alltaken*2;
                $this->data['LeaveRule']['balance'] = $bal*2;
                $this->data['LeaveRule']['id'] = $halfbalance[0]['LeaveRule']['id'];
				$this->data['LeaveRule']['leave_type_id'] = $halfbalance[0]['LeaveRule']['leave_type_id'];
                $this->Holiday->LeaveType->LeaveRule->save($this->data);
            } else {
                if($this->initializeleave($emp['Employee']['id'])==true){
				$balance = $this->Holiday->LeaveType->LeaveRule->find('all', array('conditions' => array('LeaveRule.employee_id' => $emp['Employee']['id'], 'LeaveRule.leave_type_id' => 1)));
				$this->data['LeaveRule']['total'] = $annual[0];
				$this->data['LeaveRule']['taken'] = $alltaken;
                $this->data['LeaveRule']['balance'] = $bal;
                $this->data['LeaveRule']['id'] = $balance[0]['LeaveRule']['id'];
				$this->data['LeaveRule']['leave_type_id'] = $balance[0]['LeaveRule']['leave_type_id'];
                $this->Holiday->LeaveType->LeaveRule->save($this->data);

                $halfbalance = $this->Holiday->LeaveType->LeaveRule->find('all', array('conditions' => array('LeaveRule.employee_id' => $emp['Employee']['id'], 'LeaveRule.leave_type_id' => 2)));
                $this->data['LeaveRule']['total'] = $annual[0] * 2;
				$this->data['LeaveRule']['taken'] = $alltaken*2;
                $this->data['LeaveRule']['balance'] = $bal*2;
                $this->data['LeaveRule']['id'] = $halfbalance[0]['LeaveRule']['id'];
				$this->data['LeaveRule']['leave_type_id'] = $halfbalance[0]['LeaveRule']['leave_type_id'];
                $this->Holiday->LeaveType->LeaveRule->save($this->data);
				}
            }
        }
        /*$this->set('balance', $bal.'total: '.$annual[0].' available: '. $annual[1]);*/
		$expired = ' days <div style="color: darkred; display: inline;">&nbsp;&nbsp;&nbsp; |&nbsp;&nbsp;&nbsp; Expired: 0';
		if(($bal > $annual[1])){
		$expired = ' days <div style="color: red; display: inline;"> | Expired: '.($bal - $annual[1]).' days</div>';
		$bal=$bal-($bal - $annual[1]);
		}
		
		
		$this->set('balance', $bal.$expired);
    }

    function index3() {
        //$employees = $this->Holiday->Employee->find('all');
        //$this->set(compact('employees'));
    }
    //returns all supervised staff under the employee
    // and check if one of supervised are on leave manage the staff under him/her
	function is_delegated($emp_id){
	$delg=0;
	$conditiond['Delegation.employee_id']=$emp_id;
	$conditiond['Delegation.start <=']=date('Y-m-d');
	$conditiond['Delegation.end >=']=date('Y-m-d');
	$this->loadModel('Delegation');
			 $delg = $this->Delegation->find('count', array('conditions' => $conditiond));
			 if($delg>0)
				return true;
			else
				return false;
			 
	}
    function supervised($emp_id,$loop = null){
		if($loop!="loop"){
			if(!empty($this->params['pass']))
			$emp_id = $this->params['pass']['emp_id'];
		}
		$this->loadModel('Supervisor');
		$this->Supervisor->recursive = -1;
        $supervised = $this->Supervisor->find('all', array('conditions' => array('sup_emp_id' => $emp_id)));
    
        $empls = array();
        $conditions = array();
        foreach ($supervised as $sups) {
            $empls = array_merge(array($sups['Supervisor']['emp_id']), $empls);
            $this->loadModel("Holiday");
			$this->Holiday->recursive = -1;
            $cond['Holiday.employee_id'] = $sups['Supervisor']['emp_id'];
            $cond['Holiday.from_date <='] = date('Y-m-d');
            $cond['Holiday.to_date >='] = date('Y-m-d');
            $cond['Holiday.status'] = 'On Leave';
            $onleave = $this->Holiday->find('count',array('conditions' => $cond));
            if($onleave > 0 && $this->is_delegated($sups['Supervisor']['emp_id'])===false)
                $empls = array_merge($this->supervised($sups['Supervisor']['emp_id'],"loop"), $empls);
        }
        $conditiond['Delegation.delegated']=$emp_id;
		$conditiond['Delegation.start <=']=date('Y-m-d');
		$conditiond['Delegation.end >=']=date('Y-m-d');
		$this->loadModel('Delegation');
		$this->Delegation->recursive = -1;
			 $delgs = $this->Delegation->find('all', array('conditions' => $conditiond));
			 foreach($delgs as $delg){
			 $empls = array_merge($this->supervised($delg['Delegation']['employee_id'],"loop"), $empls);
			 }
        return $empls;
    }
    function list_data3() {
        $this->requestAction('/holidays/startleave');
        $this->requestAction('/holidays/endleave');
        $this->loadModel('Employee');
        $emp = $this->Employee->findByuser_id($this->Session->read('Auth.User.id'));
        $this->loadModel('Supervisor');
        //$supervised = $this->Supervisor->find('all', array('conditions' => array('sup_emp_id' => $emp['Employee']['id'])));
        $empls = $this->supervised($emp['Employee']['id']);
        /*
        $empls = array();
        $conditions = array();
        foreach ($supervised as $sups) {
            $empls = array_merge(array($sups['Supervisor']['emp_id']), $empls);
            $this->loadModel("Holiday");
            $cond['Holiday.employee_id'] = $sups['Supervisor']['emp_id'];
            $cond['Holiday.from_date <='] = date('Y-m-d');
            $cond['Holiday.to_date >='] = date('Y-m-d');
            $cond['Holiday.status'] = 'On Leave';
            $onleave = $this->Holiday->find('count',array('conditions' => $cond));
        }
         * 
         */
        //print_r($empls);
        $conditions = array();
        $statarr = array('Pending Approval','Resubmitted for Cancellation','Resubmitted for Correction');
        $conditions = array_merge(array("OR" => array("Holiday.status" => $statarr)), $conditions);
        $empcond=array("OR " => array("Holiday.employee_id" => $empls));
        $conditions = array_merge($empcond, $conditions);
        //print_r($conditions);
        
        $this->Holiday->recursive = 1;
        //$this->set('holidays', $this->Holiday->find('all', array('conditions' => $conditions)));
        $holidays = $this->Holiday->find('all', array('conditions' => array("AND" => $conditions)));
		$this->loadModel('User');
		$this->User->recursive = 0;
        $i = 0;
        foreach ($holidays As $holiday) {
            if ($holiday['Holiday']['leave_type_id'] == 2){
                $holidays[$i]['Holiday']['no_of_dates'] = $this->calculate($holiday['Holiday']['from_date'], $holiday['Holiday']['to_date'], 1);
				$holidays[$i]['Holiday']['no_of_dates'] = $holidays[$i]['Holiday']['no_of_dates'] / 2;
            }else
                $holidays[$i]['Holiday']['no_of_dates'] = $this->calculate($holiday['Holiday']['from_date'], $holiday['Holiday']['to_date'], 0,$holiday['Holiday']['employee_id']);
            
			$userx = $this->User->find('first', array('conditions' => array('User.id' => $holiday['Employee']['user_id'])));
			$holidays[$i]['Employee']['User']['Person']['first_name']=$userx['Person']['first_name'];
			$holidays[$i]['Employee']['User']['Person']['middle_name']=$userx['Person']['middle_name'];
			$holidays[$i]['Employee']['User']['Person']['last_name']=$userx['Person']['last_name'];
			$i++;
        }
		$this->loadModel('LeaveModification');
		$modifications=$this->LeaveModification->find('all');
		foreach($modifications as $mod){
				$leamods[$mod['LeaveModification']['holiday_id']]=$mod;
				$leamods[$mod['LeaveModification']['holiday_id']]['no_of_dates_half'] = $this->calculate($mod['LeaveModification']['from_new'], $mod['LeaveModification']['to_new'], 1);
				$leamods[$mod['LeaveModification']['holiday_id']]['no_of_dates_full'] = $this->calculate($mod['LeaveModification']['from_new'], $mod['LeaveModification']['to_new'], 0,$mod['LeaveModification']['employee_id']);
		}
		if(isset($leamods)>0)
		$this->set('leamods',$leamods);
        $this->set('holidays', $holidays);
    }

    function index2($id = null) {
        $this->set('parent_id', $id);
    }

    function search() {
        
    }

    function list_data($id = null) {
        $this->requestAction('/holidays/startleave');
        $this->requestAction('/holidays/endleave');
        $start = (isset($_REQUEST['start'])) ? $_REQUEST['start'] : 0;
        $limit = (isset($_REQUEST['limit'])) ? $_REQUEST['limit'] : 5;
        $employee_id = (isset($_REQUEST['employee_id'])) ? $_REQUEST['employee_id'] : -1;
        if ($id)
            $employee_id = ($id) ? $id : -1;
        
        $this->Holiday->Employee->recursive=-1;
        $emp = $this->Holiday->Employee->findByuser_id($this->Session->read('Auth.User.id'));
        $employee_id = $emp['Employee']['id'];
        $conditions = (isset($_REQUEST['conditions'])) ? $_REQUEST['conditions'] : '';

        eval("\$conditions = array( " . $conditions . " );");
        if ($employee_id != -1) {
            $conditions['Holiday.employee_id'] = $employee_id;
        }
        
        //$this->Holiday->recursive=-1;

        $holidays = $this->Holiday->find('all', array('conditions' => $conditions, 'limit' => $limit, 'offset' => $start));
        $i = 0;
        foreach ($holidays As $holiday) {
            if ($holiday['Holiday']['leave_type_id'] == 2){
                $holidays[$i]['Holiday']['no_of_dates'] = $this->calculate($holiday['Holiday']['from_date'], $holiday['Holiday']['to_date'], 1);
                $holidays[$i]['Holiday']['no_of_dates'] = $holidays[$i]['Holiday']['no_of_dates'] / 2;
            }else
                $holidays[$i]['Holiday']['no_of_dates'] = $this->calculate($holiday['Holiday']['from_date'], $holiday['Holiday']['to_date'], 0,$holiday['Holiday']['employee_id']);
            $i++;
        }
		$this->loadModel('LeaveModification');
   $this->LeaveModification->recursive=-1;
		$modifications=$this->LeaveModification->find('all');
		foreach($modifications as $mod){
				$leamods[$mod['LeaveModification']['holiday_id']]=$mod;
				$leamods[$mod['LeaveModification']['holiday_id']]['no_of_dates_half'] = $this->calculate($mod['LeaveModification']['from_new'], $mod['LeaveModification']['to_new'], 1);
				$leamods[$mod['LeaveModification']['holiday_id']]['no_of_dates_full'] = $this->calculate($mod['LeaveModification']['from_new'], $mod['LeaveModification']['to_new'], 0,$mod['LeaveModification']['employee_id']);
		}
   
		if(isset($leamods)>0)
		$this->set('leamods',$leamods);
        $this->set('holidays', $holidays);
        //print_r($holidays);
        $this->set('results', $this->Holiday->find('count', array('conditions' => $conditions)));
    }

    function startleave() {
        $this->autoRender = false;
        $holidays = $this->Holiday->find('all', array('conditions' => array('Holiday.from_date <=' => date('Y-m-d'), 'Holiday.status' => 'Scheduled')));
        $this->data['Holiday']['status'] = 'On Leave';
		
        foreach ($holidays As $holiday) {
            $this->data['Holiday']['id'] = $holiday['Holiday']['id'];
            $this->Holiday->save($this->data);      
        }
    }

    function endleave() {
        $this->autoRender = false;
        $holidays = $this->Holiday->find('all', array('conditions' => array('Holiday.to_date <' => date('Y-m-d'), 'Holiday.status' => 'On Leave')));
        $this->data['Holiday']['status'] = 'Taken';
        foreach ($holidays As $holiday) {
            $this->data['Holiday']['id'] = $holiday['Holiday']['id'];
            $this->Holiday->save($this->data);
        }
    }

	function calculate_annual_leave_backdate($id,$exp = null,$report_date = null,$output,$salary) {
		
		 $this->autoRender = false;
			//$this->Holiday->Employee->recursive = 2;
            //$emp = $this->Holiday->Employee->read(null, $id);//why not directly fetching employees?
			//print_r($emp);
			$this->loadModel('EmployeeDetail');
            $this->EmployeeDetail->recursive = 0;
            $emp = $this->EmployeeDetail->find('all', array('conditions'=>array('employee_id'=>$id)));
			
			//$emp['EmployeeDetail']['Position']=$emp['Position'];
			$updinc=0;
			$updemp=array();
			foreach($emp as $vals){
			$updemp['EmployeeDetail'][$updinc]=$vals['EmployeeDetail'];
			$updemp['EmployeeDetail'][$updinc]['Position']=$vals['Position'];
			$updemp['EmployeeDetail'][$updinc]['Branch']=$vals['Branch'];
				$updinc++;
			}			
			$emp=array();
			$emp=$updemp;
			$this->array_sort_by_column($emp['EmployeeDetail'], "start_date");

			foreach($emp['EmployeeDetail'] as $x => $empdetail){
				if($empdetail['start_date'] > $report_date){
				   unset($emp['EmployeeDetail'][$x]);
				}
			}
			$output.='<td>'.$emp['EmployeeDetail'][count($emp['EmployeeDetail'])-1]['Branch']['name'].'</td>';
			$output.='<td>'.$emp['EmployeeDetail'][count($emp['EmployeeDetail'])-1]['Branch']['region'].'</td>';
			
			if($salary=='true'){
				   $con['Scale.grade_id'] = $emp['EmployeeDetail'][count($emp['EmployeeDetail'])-1]['grade_id'];
                   $con['Scale.step_id'] = $emp['EmployeeDetail'][count($emp['EmployeeDetail'])-1]['step_id'];

                   $this->loadModel('Scale');
				   $this->Scale->recursive=0;
                   $salary = $this->Scale->find('all', array('conditions' => $con));
				   $output.='<td>'.$salary[0]['Scale']['salary'].'</td>';
			}
			$output.='<td>'.$emp['EmployeeDetail'][count($emp['EmployeeDetail'])-1]['Position']['name'].'</td>';
			$emp['EmployeeDetail'] = array_values($emp['EmployeeDetail']);
			
			$emp['EmployeeDetail'][count($emp['EmployeeDetail'])-1]['end_date'] = $report_date;
			//echo '<td>'.$emp['EmployeeDetail'][count($emp['EmployeeDetail'])-1]['start_date'].'</td>';
            /*---------------------------------------------------------------------------------------------*/

            //$first_start_date = strtotime($emp['EmployeeDetail'][0]['start_date']);
			$first_start_date = $emp['EmployeeDetail'][0]['start_date'];
			//echo $first_start_date;
			/*---------------------------------------------------------------------------------------------*/
		
		/*-----------------------------------------------*/
		$before_two_years = strtotime("-2 year", strtotime($report_date));
		$before_two_years = date("Y-m-d", $before_two_years);
		$emp2=$emp;
		foreach($emp2['EmployeeDetail'] as $x => $empdetail){
				if($empdetail['start_date'] > $before_two_years){
				   unset($emp2['EmployeeDetail'][$x]);
				}
			}
			$emp2['EmployeeDetail'] = array_values($emp2['EmployeeDetail']);
			$emp2['EmployeeDetail'][count($emp['EmployeeDetail'])-1]['end_date'] = $before_two_years;
            
		/*-----------------------------------------------*/
		
		$totoal_teme = $this->leave_calculator($id, $emp, $report_date,$first_start_date, 1);
		$total_after_two_years = $totoal_teme;
		if(strtotime($first_start_date) < strtotime($before_two_years)){
			$total_after_two_years = $totoal_teme - $this->leave_calculator($id, $emp2, $before_two_years, $first_start_date, 1);
		}
		
		if($exp != null){
			$total_with_expired = array($totoal_teme, $total_after_two_years );
			return $total_with_expired;
		}
		else {
			return $totoal_teme;
		}
		
	}
	
	function calculate_annual_leave($id,$exp = null) {
			
			// $this->autoRender = false;
				$this->Holiday->Employee->recursive = 2;
				$emp = $this->Holiday->Employee->read(null, $id);//why not directly fetching employees?
				if($emp['Employee']['terms_of_employment']=='Contract')
					if($exp != null)
						return array(0,0);
					else
						return 0;
					
				$this->array_sort_by_column($emp['EmployeeDetail'], 'start_date');

				/*---------------------------------------------------------------------------------------------*/

				//$first_start_date = strtotime($emp['EmployeeDetail'][0]['start_date']);
				$first_start_date = $emp['EmployeeDetail'][0]['start_date'];
				//echo $first_start_date;
				/*---------------------------------------------------------------------------------------------*/
			
			/*-----------------------------------------------*/
			$before_two_years = strtotime("-2 year", time());
			$before_two_years = date("Y-m-d", $before_two_years);
			//echo $before_two_years;
			/*-----------------------------------------------*/
			
			$totoal_teme = $this->leave_calculator($id, $emp, $before_two_years,$first_start_date, 0);
			$total_after_two_years = $totoal_teme;
			if(strtotime($first_start_date) < strtotime($before_two_years)){
				$total_after_two_years = $totoal_teme - $this->leave_calculator($id, $emp, $before_two_years, $first_start_date, 1);
			}
			
			if($exp != null){
				$total_with_expired = array($totoal_teme, $total_after_two_years );
				return $total_with_expired;
			}
			else {
				return $totoal_teme;
			}
			
		}
	
	function leave_calculator($id, $emp, $before_two_years,$first_start_date, $is_before_two_years) {
		$total1 = 0;
		$total2 = 0;
		$total = 0;
		$now = date("Y-m-d", time());
		/*----------------------------------------------------------------------------------------------*/
			if($is_before_two_years == 1 && strtotime($first_start_date) < strtotime($before_two_years)){
				$emp['EmployeeDetail'][count($emp['EmployeeDetail'])-1]['end_date'] = $before_two_years;
			}
		/*----------------------------------------------------------------------------------------------*/
		//$before_two_years_ignored_increments_nonmanager = floor(($first_start_date - strtotime($emp['EmployeeDetail'][0]['start_date'])) / (86400*365.25));
		//$before_two_years_ignored_increments_manager = 0;
		if ($id) {
            $total = 0;
            /*---------------------------------------------------------------------------------------------*/
            $diffinyear  = 0;//$i is the time difference in year between the start date of the employee upto 
					//the time when he is asking the leave
            
			$index_manager_position = -1;
			$yeardiff_manager_position = -1;
			$thelast_end_date = time();//this is used if the employee is terminated
				

			foreach($emp['EmployeeDetail'] as $index=>$empDetail) {
				if($empDetail['Position']['is_managerial'] == 1){
					$index_manager_position = $index;
					//$yeardiff_manager_position = (strtotime($emp['EmployeeDetail'][$index_manager_position-1]['end_date']) - strtotime($emp['EmployeeDetail'][0]['start_date'])) / (86400*365.25);
					
					/*------------------------------------------------------------------------------------*/
					$datetime1 = date_create($emp['EmployeeDetail'][0]['start_date']);

					//$datetime2 = date_create($emp['EmployeeDetail'][$index_manager_position-1]['end_date']);
					//$datetime2 = date_create("2017-06-20");
					$now = date("Y-m-d", time());
					if($index_manager_position==0){
						$interval = 0;//interval is used to determine whether one has become manager before or after 4 years
					}
					else {
						$interval = date_diff(date_create($emp['EmployeeDetail'][0]['start_date']), date_create($emp['EmployeeDetail'][$index_manager_position-1]['end_date']));
					}
					$yeardiff_manager_position = $interval->y;
					//$datetime2->diff($start_date)->format("%a");
					
					//echo "  ".$yeardiff_manager_position."  ";
					/*------------------------------------------------------------------------------------*/
					
					$yeardiff_manager_position = floor($yeardiff_manager_position);
					//echo "yeardiff_manager_position = ".$yeardiff_manager_position;
					break;
				}
			}
			/*----------------------------------------------------------------------------------------------*/
			foreach($emp['EmployeeDetail'] as $index=>$empDetail) {
				$thelast_end_date = $empDetail['end_date'];
				//echo $thelast_end_date."_____";
			}
			/*----------------------------------------------------------------------------------------------*/
			if($index_manager_position == -1 || $yeardiff_manager_position >= 4){//for nonmanagers stuff
				//echo $index_manager_position."    ";
                $k=0;//$k is the number of days added each year
				/*----------------------------------------------------------------*/
				$now = date("Y-m-d", time());// or your date as well
				if($is_before_two_years == 1){
					$now = $thelast_end_date;
					
					//$before_two_years = strtotime("-2 year", time());
					//$now = date("Y-m-d", $before_two_years);
				}
                else if(($thelast_end_date=='0000-00-00') && $is_before_two_years == 0){
					$now = date("Y-m-d", time()); // or your date as well
				}
				else{
					//$now = strtotime($thelast_end_date);
					$now = $thelast_end_date;
				}
				/*----------------------------------------------------------------*/
				$diffinyear = 0;
				if(strtotime($now) > strtotime($first_start_date)){ 
					$diffinyear = date_diff(date_create($first_start_date), date_create($now))->y;
				}
				
				$remainingfraction = date_diff(date_create($first_start_date), date_create($now))->m + (date_diff(date_create($first_start_date), date_create($now))->d)/30;
				$integeri = floor($diffinyear);
				//echo $integeri;
                for($j=0; $j<$integeri; $j++){
                    $k = $k + $j;
                }
				//$thelastremainingyears = $remainingfraction*(16+$integeri);
				$thelastremainingyears = $remainingfraction*(16 + $integeri)/12;
				
				//echo "  ".$thelastremainingyears."  ";
				$total = 16*$integeri + $k + $thelastremainingyears;
				//echo $total.'-';
                //echo "   ". "      ".$diffinyear;
				return number_format((float)$total, 2, '.', '');
			}
			elseif($index_manager_position != -1 && $yeardiff_manager_position < 4){ //for one have been manager 
				//echo "am i here?";
				$k1=0;//$k is the number of days added each year
				$k2=0;//$k is the number of days added each year
				
				$diffinyear1 = 0;//the time in year an employee has spent on nonmanagerial position
				$diffinyear2 = 0;//the time in year an employee has spent on managerial position
                
				/*----------------------------------------------------------------*/
				$now = date("Y-m-d", time());
				
				if($is_before_two_years == 1){
					$now = $thelast_end_date;
					//$before_two_years = strtotime("-2 year", time());
					//$now = date("Y-m-d", $before_two_years);
				}
				
                else if(($thelast_end_date=='0000-00-00') && $is_before_two_years == 0){
					$now = date("Y-m-d", time()); // or your date as well
				}
				else{
					$now = $thelast_end_date;
				}
				/*----------------------------------------------------------------*/
				
				$manager_start_date = $emp['EmployeeDetail'][$index_manager_position]['start_date'];
				$nonmanager_end_date = $emp['EmployeeDetail'][$index_manager_position-1]['end_date'];
				if(strtotime($first_start_date) < strtotime($nonmanager_end_date)){
					if(($is_before_two_years == 1) && (strtotime($now) < strtotime($manager_start_date))){
						$diffinyear1 = date_diff(date_create($first_start_date), date_create($now))->y;
					}
					else {
						$diffinyear1 = date_diff(date_create($first_start_date), date_create($nonmanager_end_date))->y;
					//echo "hello";
					}
					
				}
				/*------------------------------------------------------------------------*/
				if(strtotime($first_start_date) < strtotime($manager_start_date)){
					$diffinyear2 = date_diff(date_create($manager_start_date), date_create($now))->y;
				}
				else if(strtotime($first_start_date) >= strtotime($manager_start_date)){
					$diffinyear2 = date_diff(date_create($manager_start_date), date_create($now))->y;
				}
				else{}
				/*------------------------------------------------------------------------*/
				if (($is_before_two_years == 1) && (strtotime($now) < strtotime($manager_start_date))){
					$remainingfraction1 = date_diff(date_create($first_start_date), date_create($now))->m + (date_diff(date_create($first_start_date), date_create($now))->d)/30;
				}
				else {
					$remainingfraction1 = date_diff(date_create($first_start_date), date_create($nonmanager_end_date))->m + (date_diff(date_create($first_start_date), date_create($nonmanager_end_date))->d)/30;
				}
				
				$remainingfraction2 = date_diff(date_create($manager_start_date), date_create($now))->m + (date_diff(date_create($manager_start_date), date_create($now))->d)/30;
				
				$integeri1 = floor($diffinyear1);
				$integeri2 = floor($diffinyear2);
				
				//echo $integeri;
                for($j=0; $j<$integeri1; $j++){
                    $k1 = $k1 + $j;
                }
				
				 for($a=0; $a<$integeri2; $a++){
                    $k2 = $k2 + $a;
                }
				
				$thelastremainingyears1 = $remainingfraction1*(16+$integeri1)/12;
				$thelastremainingyears2 = $remainingfraction2*(20+$integeri2)/12;
				//echo "  ".$thelastremainingyears."  ";
				$total1 = 16*$integeri1 + $k1 + $thelastremainingyears1;
				$total2 = (20)*$integeri2 + $k2 + $thelastremainingyears2;
				//echo " mgr ".($total1 + $total2);
				
				if(($is_before_two_years == 1) && (strtotime($now) < strtotime($manager_start_date))){
					return number_format((float)($total1), 2, '.', '');
				}
				
				if($index_manager_position == 0){
					return number_format((float)($total2), 2, '.', '');
				}
				else {
					//echo "Total = ".($total1 + $total2);
					return number_format((float)($total1 + $total2), 2, '.', '');
					}
			}
			else{
				
			}
			/*----------------------------------------------------------------------------------------------*/
        }
		//return $total1 + $total2;
	}
	
	function calculate_system_leave_taken($id,$leavetype,$caltype,$report_date = null){
	if($id){
		$totals=0;
		if($report_date==null)
			$report_date="2099-09-09";	
		
    $conditionsslt['Holiday.employee_id'] = $id;
	$conditionsslt['Holiday.leave_type_id'] = $leavetype;
	$conditionsslt['Holiday.to_date <='] = $report_date;
	$conditionsslt['Holiday.status'] = array('Taken','On Leave','Resubmitted for Correction','Resubmitted for Cancellation');
		$holidays = $this->Holiday->find('all', array('conditions' => $conditionsslt));

        foreach ($holidays As $holiday) {
                $totals += $this->calculate($holiday['Holiday']['from_date'], $holiday['Holiday']['to_date'], $caltype,$id);    
        }
		return $totals;
	}}
    function array_sort_by_column(&$arr, $col, $dir = SORT_ASC) {
        $sort_col = array();
        foreach ($arr as $key => $row) {
            $sort_col[$key] = $row[$col];
        }
		array_multisort($sort_col, $dir, $arr);
    }
	function leave_taken_before($id){
		$this->loadModel('LeaveAnnualSetup');
      $res = $this->LeaveAnnualSetup->find('all', array('conditions' => array('LeaveAnnualSetup.employee_id' => $id)));
		if(!empty($res))
		return $res[0]['LeaveAnnualSetup']['taken'];
		else
		return 0;
	}
    function initializeleave($id) {
        if ($id) {
		
			$this->Holiday->LeaveType->LeaveRule->deleteAll(array('LeaveRule.employee_id'=>$id));
            // $this->autoRender = false;
            $this->Holiday->Employee->recursive = 2;
            $emp = $this->Holiday->Employee->read(null, $id);
			$lv=16;	$sk=180; $mp=3; $fp=300;	$oth=300;
			if($emp['Employee']['terms_of_employment']=='Contract'){
				$lv=0;	$sk=0; $mp=0; $fp=0;	$oth=0;
			}
                $this->data2['LeaveRule']['employee_id'] = $id;
                $this->data2['LeaveRule']['leave_type_id'] = 1;
                $this->data2['LeaveRule']['total'] = $lv;
                $this->data2['LeaveRule']['balance'] = $lv;
                $this->Holiday->LeaveType->LeaveRule->create();
                $this->Holiday->LeaveType->LeaveRule->save($this->data2);

                $this->data2['LeaveRule']['employee_id'] = $id;
                $this->data2['LeaveRule']['leave_type_id'] = 2;
                $this->data2['LeaveRule']['total'] = $lv * 2;
                $this->data2['LeaveRule']['balance'] = $lv * 2;
                $this->Holiday->LeaveType->LeaveRule->create();
                $this->Holiday->LeaveType->LeaveRule->save($this->data2);

                $this->data2['LeaveRule']['employee_id'] = $id;
                $this->data2['LeaveRule']['leave_type_id'] = 3;
                $this->data2['LeaveRule']['total'] = $sk;
                $this->data2['LeaveRule']['balance'] = $sk;
                $this->Holiday->LeaveType->LeaveRule->create();
                $this->Holiday->LeaveType->LeaveRule->save($this->data2);

                $this->data2['LeaveRule']['employee_id'] = $id;
                $this->data2['LeaveRule']['leave_type_id'] = 4;
                if ($emp['User']['Person']['sex'] == 'F') {
                    $this->data2['LeaveRule']['total'] = $fp;
                    $this->data2['LeaveRule']['balance'] = $fp;
                } else {
                    $this->data2['LeaveRule']['total'] = $mp;
                    $this->data2['LeaveRule']['balance'] = $mp;
                }
                $this->Holiday->LeaveType->LeaveRule->create();
                $this->Holiday->LeaveType->LeaveRule->save($this->data2);

                $this->data2['LeaveRule']['employee_id'] = $id;
                $this->data2['LeaveRule']['leave_type_id'] = 5;
                $this->data2['LeaveRule']['total'] = $oth;
                $this->data2['LeaveRule']['balance'] = $oth;
                $this->Holiday->LeaveType->LeaveRule->create();
                $this->Holiday->LeaveType->LeaveRule->save($this->data2);

                $this->data2['LeaveRule']['employee_id'] = $id;
                $this->data2['LeaveRule']['leave_type_id'] = 6;
                $this->data2['LeaveRule']['total'] = $oth;
                $this->data2['LeaveRule']['balance'] = $oth;
                $this->Holiday->LeaveType->LeaveRule->create();
                $this->Holiday->LeaveType->LeaveRule->save($this->data2);

                $this->data2['LeaveRule']['employee_id'] = $id;
                $this->data2['LeaveRule']['leave_type_id'] = 7;
                $this->data2['LeaveRule']['total'] = $oth;
                $this->data2['LeaveRule']['balance'] = $oth;
                $this->Holiday->LeaveType->LeaveRule->create();
                $this->Holiday->LeaveType->LeaveRule->save($this->data2);
            

			return true;
        }
    }

    function view($id = null) {
        if (!$id) {
            $this->Session->setFlash(__('Invalid holiday', true));
            $this->redirect(array('action' => 'index'));
        }
        $this->Holiday->recursive = 2;
        $this->set('holiday', $this->Holiday->read(null, $id));
    }

    function calculate($from, $to, $sat,$emp_id = null) {
        //$this->autoRender = false;
        // $from='2013-04-05';
        // $to='2013-04-5';
		if(isset($emp_id)){
			$this->loadModel('LeaveAnnualSetup');
      
   $this->LeaveAnnualSetup->recursive=-1;
		$res = $this->LeaveAnnualSetup->find('all', array('conditions' => array('LeaveAnnualSetup.employee_id' => $emp_id)));
          if(!empty($res))
			$saton = $res[0]['LeaveAnnualSetup']['saturday']; //for branch staff
		}
        $frm = strtotime($from);
        $td = strtotime($to);
        $ndate = $td - $frm;
        $numdate = floor($ndate / (60 * 60 * 24)) + 1;
        $this->loadModel('BudgetYear');
        $this->$this->BudgetYear->recursive=-1;
        $query = $this->BudgetYear->find('first', array('conditions' => array(
                'and' => array(
                    array('BudgetYear.from_date <= ' => date('Y-m-d', $frm),
                        'BudgetYear.to_date >= ' => date('Y-m-d', $frm)
                    ),
                    array('BudgetYear.from_date <= ' => date('Y-m-d', $td),
                        'BudgetYear.to_date >= ' => date('Y-m-d', $td)
                    )
            ))));
//print_r($query);
        if (is_array($query)) {
            $byid = $query['BudgetYear']['id'];
            for ($i = 0; $i > -1; $i++) {
                if ($frm > $td)
                    break;

                $this->BudgetYear->CelebrationDay->recursive=-1;
                $chkhol = $this->BudgetYear->CelebrationDay->find('count', array('conditions' => array('CelebrationDay.day' => date('Y-m-d', $frm), 'CelebrationDay.budget_year_id' => $byid)));
                if ($chkhol >= 1) {
                    $numdate--;
                } else {

                    if (date('l', $frm) == 'Sunday')
                        $numdate--;
                    if (date('l', $frm) == 'Saturday' && ($sat != 1 && $saton == 0)) 
                        $numdate = $numdate - 0.5;
                }

                // echo date('Y-m-d', $frm);
                $frm = strtotime("+1 day", $frm);
            }
        }else {
            for ($i = 0; $i > -1; $i++) {
                if ($frm > $td)
                    break;



                if (date('l', $frm) == 'Sunday')
                    $numdate--;
                if (date('l', $frm) == 'Saturday' && ($sat != 1 && $saton == 0))
                    $numdate = $numdate - 0.5;


                // echo date('Y-m-d', $frm);
                $frm = strtotime("+1 day", $frm);
            }
        }
        //echo $numdate;
        //exit();
        return abs($numdate);
    }

    function set_leave($id = null, $parent_id = null) {

        if (!empty($this->data)) {
            $this->autoRender = false;

			$this->loadModel('LeaveAnnualSetup');
            $this->LeaveAnnualSetup->save($this->data);
            $this->Session->setFlash(__('Annual Leave configured for employee', true), '');
            $this->render('/elements/success');
        } else {

            if ($id) {
                $this->set('parent_id', $id);
            }
			$this->loadModel('LeaveAnnualSetup');
      $res = $this->LeaveAnnualSetup->find('all', array('conditions' => array('LeaveAnnualSetup.employee_id' => $id)));

          if(empty($res))
                $this->set('taken', 0);
		  else{
				$this->set('taken', $res[0]['LeaveAnnualSetup']['taken']);
				$this->set('saturday', $res[0]['LeaveAnnualSetup']['saturday']);
				$this->set('id', $res[0]['LeaveAnnualSetup']['id']);
				}
             
        }
    }

    function add($id = null) {
        if (!empty($this->data)) {
            $balance = $this->Holiday->LeaveType->LeaveRule->find('first', array('conditions' => array('LeaveRule.employee_id' => $this->data['Holiday']['employee_id'], 'LeaveRule.leave_type_id' => $this->data['Holiday']['leave_type_id'])));
	    //var_dump($balance);die();
            $tempdate = explode('/', $this->data['Holiday']['from_date']);
            if (count($tempdate) >= 3)
                $from_date = $tempdate[2] . '-' . $tempdate[1] . '-' . $tempdate[0];

            $tempdate = explode('/', $this->data['Holiday']['to_date']);
            if (count($tempdate) >= 3)
                $to_date = $tempdate[2] . '-' . $tempdate[1] . '-' . $tempdate[0];

            if (is_array($balance)) {
                if ($this->calculate($from_date, $to_date, 0,$this->data['Holiday']['employee_id']) > $balance['LeaveRule']['balance']) {
                    $this->Session->setFlash(__('You have only ' . $balance['LeaveRule']['balance'] . ' ' . $balance['LeaveType']['name'] . ' left.', true), '');
                    $this->render('/elements/failure');
                }
                //if annual half day
                elseif ($this->calculate($from_date, $to_date, 1) > $balance['LeaveRule']['balance'] && $this->data['Holiday']['leave_type_id'] == 2) {
                    $this->Session->setFlash(__('You have only ' . $balance['LeaveRule']['balance'] . ' ' . $balance['LeaveType']['name'] . ' left.', true), '');
                    $this->render('/elements/failure');
                } else {

                    $this->Holiday->create();
                    $this->autoRender = false;
		    $this->data['Holiday']['filled_date']=date('Y-m-d');
		    //var_dump($this->data['Holiday']['filled_date']);die();
                    if ($this->Holiday->save($this->data)) {
						$this->loadModel('Supervisor');
						$supp=$this->Supervisor->find('first',array('conditions'=>array('Supervisor.emp_id'=>$this->data['Holiday']['employee_id'])));
						$this->loadModel('Employee');
						$this->Employee->recursive=-1;
						$sup_emp=$this->Employee->read(null,$supp['Supervisor']['sup_emp_id']);
						$this->loadModel('User');
						$user=$this->Employee->read(null,$this->data['Holiday']['employee_id']);
						$user=$this->User->read(null,$user['Employee']['user_id']);
						$this->loadModel('People');
						$person=$this->People->read(null,$user['User']['person_id']);
						$sup_tel=$sup_emp['Employee']['telephone'];
						$user_name=$person['People']['first_name'].' '.$person['People']['middle_name'];
						//$message=$user_name." has requested leave. - AbayERP";
						$message=$user_name." has requested ".$balance['LeaveType']['name']." from ".$from_date." to ".$to_date." for ".$this->calculate($from_date, $to_date, 0)." day(s). - AbayERP";
						$message=urlencode($message);
						file_get_contents('http://10.1.85.10/sms_manager/send_fast.php?redirect='.urlencode($_SERVER["REDIRECT_URL"]).'&to='.$sup_tel.'&msg='.$message);
					
                        $this->Session->setFlash(__('Leave Applied Succesfully.', true), '');
                        $this->render('/elements/success');
                    } else {
                        $this->Session->setFlash(__('Error Found with your entry. Please, try again.', true), '');
                        $this->render('/elements/failure');
                    }
                }
            } else {
                $this->Session->setFlash(__('The leave you are requesting is not configured for you. Please contact Administrators.', true), '');
                $this->render('/elements/failure');
            }
        }
        if ($id)
            $this->set('parent_id', $id);

        $employees = $this->Holiday->Employee->find('list');
        $leave_types = $this->Holiday->LeaveType->find('list');
        $this->set(compact('employees', 'leave_types'));
        $this->set('employee', $this->Holiday->Employee->findByuser_id($this->Session->read('Auth.User.id')));
    }

    function edit($id = null, $parent_id = null) {
        if (!$id && empty($this->data)) {
            $this->Session->setFlash(__('Invalid holiday', true), '');
            $this->redirect(array('action' => 'index'));
        }
        if (!empty($this->data)) {
            $this->autoRender = false;
            if ($this->Holiday->save($this->data)) {
                $this->Session->setFlash(__('The holiday has been saved', true), '');
                $this->render('/elements/success');
            } else {
                $this->Session->setFlash(__('The holiday could not be saved. Please, try again.', true), '');
                $this->render('/elements/failure');
            }
        }
        $this->set('holiday', $this->Holiday->read(null, $id));

        if ($parent_id) {
            $this->set('parent_id', $parent_id);
        }

        $employees = $this->Holiday->Employee->find('list');
        $leave_types = $this->Holiday->LeaveType->find('list');
        $this->set(compact('employees', 'leave_types'));
    }
	
	function modify($id = null, $parent_id = null) {
        if (!$id && empty($this->data)) {
            $this->Session->setFlash(__('Invalid holiday', true), '');
            $this->redirect(array('action' => 'index'));
        }
        if (!empty($this->data)) {
            $this->autoRender = false;
			$hol=$this->Holiday->read(null, $this->data['Holiday']['id']);
			//echo $_GET['task'];
			if($_GET['task']=='modify')
			if($hol['Holiday']['status']=='On Leave' || $hol['Holiday']['status']=='Taken' || $hol['Holiday']['status']=='Rejected'){
			 $balance = $this->Holiday->LeaveType->LeaveRule->find('first', array('conditions' => array('LeaveRule.employee_id' => $hol['Holiday']['employee_id'], 'LeaveRule.leave_type_id' => $hol['Holiday']['leave_type_id'])));

            $from_date = $this->data['Holiday']['from_dates'];
 
            $tempdate = explode('/', $this->data['Holiday']['to_date']);
            if (count($tempdate) >= 3)
                $to_date = $tempdate[2] . '-' . $tempdate[1] . '-' . $tempdate[0];
				
				$frm=$hol['Holiday']['from_date'];
				$todt=$hol['Holiday']['to_date'];
            if (is_array($balance)) {
                if (($this->calculate($from_date, $to_date, 0,$hol['Holiday']['employee_id']) - $this->calculate($frm, $todt, 0,$hol['Holiday']['employee_id'])) > $balance['LeaveRule']['balance']) {
                    $this->Session->setFlash(__('You have only ' . $balance['LeaveRule']['balance'] . ' ' . $balance['LeaveType']['name'] . ' left.', true), '');
                    $this->render('/elements/failure');
                }
                //if annual half day
                elseif (($this->calculate($from_date, $to_date, 1)-$this->calculate($frm, $todt, 1)) > $balance['LeaveRule']['balance'] && $hol['Holiday']['leave_type_id'] == 2) {
                    $this->Session->setFlash(__('You have only ' . $balance['LeaveRule']['balance'] . ' ' . $balance['LeaveType']['name'] . ' left.', true), '');
                    $this->render('/elements/failure');
                } else {
			$this->data2['Holiday']['id']=$this->data['Holiday']['id'];
			$this->data2['Holiday']['status']='Resubmitted for Correction';
			$this->Holiday->save($this->data2);
			$this->loadModel('LeaveModification');
			$this->LeaveModification->create();
			$this->data3['LeaveModification']['todo']=$_GET['task'];
			$this->data3['LeaveModification']['from_old']=$hol['Holiday']['from_date'];
			$this->data3['LeaveModification']['to_old']=$hol['Holiday']['to_date'];
			$this->data3['LeaveModification']['from_new']=$this->data['Holiday']['from_dates'];
			$this->data3['LeaveModification']['to_new']=$this->data['Holiday']['to_date'];
			$this->data3['LeaveModification']['holiday_id']=$hol['Holiday']['id'];
			$this->data3['LeaveModification']['employee_id']=$hol['Holiday']['employee_id'];
			$this->data3['LeaveModification']['status']='pending';
			if($this->LeaveModification->save($this->data3)){
						$this->loadModel('Supervisor');
						$supp=$this->Supervisor->find('first',array('conditions'=>array('Supervisor.emp_id'=>$this->data['Holiday']['employee_id'])));
						$this->loadModel('Employee');
						$this->Employee->recursive=-1;
						$sup_emp=$this->Employee->read(null,$supp['Supervisor']['sup_emp_id']);
						$this->loadModel('User');
						$user=$this->Employee->read(null,$this->data['Holiday']['employee_id']);
						$user=$this->User->read(null,$user['Employee']['user_id']);
						$this->loadModel('People');
						$person=$this->People->read(null,$user['User']['person_id']);
						$sup_tel=$sup_emp['Employee']['telephone'];
						$user_name=$person['People']['first_name'].' '.$person['People']['middle_name'];
						$message=$user_name." has submitted date changes on past leave record. - AbayERP";
						$message=urlencode($message);
						file_get_contents('http://10.1.85.10/sms_manager/send_fast.php?redirect='.urlencode($_SERVER["REDIRECT_URL"]).'&to='.$sup_tel.'&msg='.$message);
			}
			
			$this->Session->setFlash(__('The Changes have been sent to be reviewed to your supervisor', true), '');
			$this->render('/elements/success');
			}}
			}elseif($hol['Holiday']['status']=='Pending Approval'  ||  $hol['Holiday']['status']=='Scheduled'){
			$hol=$this->Holiday->read(null, $this->data['Holiday']['id']);
			 $balance = $this->Holiday->LeaveType->LeaveRule->find('first', array('conditions' => array('LeaveRule.employee_id' => $hol['Holiday']['employee_id'], 'LeaveRule.leave_type_id' => $hol['Holiday']['leave_type_id'])));

            $from_date = $this->data['Holiday']['from_dates'];

            $tempdate = explode('/', $this->data['Holiday']['to_date']);
            if (count($tempdate) >= 3)
                $to_date = $tempdate[2] . '-' . $tempdate[1] . '-' . $tempdate[0];

            if (is_array($balance)) {
			
                if ($this->calculate($from_date, $to_date, 0,$hol['Holiday']['employee_id']) > $balance['LeaveRule']['balance']) {
                    $this->Session->setFlash(__('You have only ' . $balance['LeaveRule']['balance'] . ' ' . $balance['LeaveType']['name'] . ' left.', true), '');
                    $this->render('/elements/failure');
                }
                //if annual half day
                elseif ($this->calculate($from_date, $to_date, 1) > $balance['LeaveRule']['balance'] && $hol['Holiday']['leave_type_id'] == 2) {
                    $this->Session->setFlash(__('You have only ' . $balance['LeaveRule']['balance'] . ' ' . $balance['LeaveType']['name'] . ' left.', true), '');
                    $this->render('/elements/failure');
                } else {
				if ($this->Holiday->save($this->data)) {
					$this->Session->setFlash(__('The Changes have been applied', true), '');
					$this->render('/elements/success');
				} else {
					$this->Session->setFlash(__('The Changes could not be applied', true), '');
					$this->render('/elements/failure');
				}
				}
				}
			}
			
			if($_GET['task']=='delete')
			if($hol['Holiday']['status']=='On Leave' || $hol['Holiday']['status']=='Taken' || $hol['Holiday']['status']=='Rejected'){
				$this->data2['Holiday']['id']=$this->data['Holiday']['id'];
				$this->data2['Holiday']['status']='Resubmitted for Cancellation';
				$this->Holiday->save($this->data2);
				$this->loadModel('LeaveModification');
				$this->LeaveModification->create();
				$this->data3['LeaveModification']['todo']=$_GET['task'];
				$this->data3['LeaveModification']['from_old']=$hol['Holiday']['from_date'];
				$this->data3['LeaveModification']['to_old']=$hol['Holiday']['to_date'];
				$this->data3['LeaveModification']['from_new']=$hol['Holiday']['from_date'];
				$this->data3['LeaveModification']['to_new']=$hol['Holiday']['to_date'];
				$this->data3['LeaveModification']['holiday_id']=$hol['Holiday']['id'];
				$this->data3['LeaveModification']['employee_id']=$hol['Holiday']['employee_id'];
				$this->data3['LeaveModification']['status']='pending';
				if($this->LeaveModification->save($this->data3)){
						$this->loadModel('Supervisor');
						$supp=$this->Supervisor->find('first',array('conditions'=>array('Supervisor.emp_id'=>$this->data['Holiday']['employee_id'])));
						$this->loadModel('Employee');
						$this->Employee->recursive=-1;
						$sup_emp=$this->Employee->read(null,$supp['Supervisor']['sup_emp_id']);
						$this->loadModel('User');
						$user=$this->Employee->read(null,$this->data['Holiday']['employee_id']);
						$user=$this->User->read(null,$user['Employee']['user_id']);
						$this->loadModel('People');
						$person=$this->People->read(null,$user['User']['person_id']);
						$sup_tel=$sup_emp['Employee']['telephone'];
						$user_name=$person['People']['first_name'].' '.$person['People']['middle_name'];
						$message=$user_name." has requested past leave record to be removed. - AbayERP";
						$message=urlencode($message);
						file_get_contents('http://10.1.85.10/sms_manager/send_fast.php?redirect='.urlencode($_SERVER["REDIRECT_URL"]).'&to='.$sup_tel.'&msg='.$message);
				}
				$this->Session->setFlash(__('Request sent to be canceled', true), '');
				$this->render('/elements/success');
			}elseif($hol['Holiday']['status']=='Pending Approval'  ||  $hol['Holiday']['status']=='Scheduled'){
				if ($this->Holiday->delete($this->data['Holiday']['id'])) {
					$this->Session->setFlash(__('The Leave have been canceled', true), '');
					$this->render('/elements/success');
				} else {
					$this->Session->setFlash(__('The Leave could not be canceled', true), '');
					$this->render('/elements/failure');
				}
			}
        }
        $this->set('holiday', $this->Holiday->read(null, $id));

        if ($parent_id) {
            $this->set('parent_id', $parent_id);
        }

       // $employees = $this->Holiday->Employee->find('list');
       // $leave_types = $this->Holiday->LeaveType->find('list');
       // $this->set(compact('employees', 'leave_types'));
    }

    function delete($id = null) {
        $this->autoRender = false;
        if (!$id) {
            $this->Session->setFlash(__('Invalid id for holiday', true), '');
            $this->render('/elements/failure');
        }
        if (stripos($id, '_') !== false) {
            $ids = explode('_', $id);
            try {
                foreach ($ids as $i) {
                    $this->Holiday->delete($i);
                }
                $this->Session->setFlash(__('Holiday deleted', true), '');
                $this->render('/elements/success');
            } catch (Exception $e) {
                $this->Session->setFlash(__('Holiday was not deleted', true), '');
                $this->render('/elements/failure');
            }
        } else {
            if ($this->Holiday->delete($id)) {
                $this->Session->setFlash(__('Holiday deleted', true), '');
                $this->render('/elements/success');
            } else {
                $this->Session->setFlash(__('Holiday was not deleted', true), '');
                $this->render('/elements/failure');
            }
        }
    }

    function cancel($id = null) {
        if (!$id && empty($this->data)) {
            $this->Session->setFlash(__('Invalid holiday', true), '');
            $this->redirect(array('action' => 'index'));
        }
        $this->data['Holiday']['status'] = 'Canceled';
        if (!empty($this->data)) {
            $this->autoRender = false;
            if ($this->Holiday->save($this->data)) {
                $this->Session->setFlash(__('The Leave has been Canceled', true), '');
                $this->render('/elements/success');
            } else {
                $this->Session->setFlash(__('The Leave could not be canceled. Please, try again.', true), '');
                $this->render('/elements/failure');
            }
        }
    }

    function approve($id = null) {
        if (!$id && empty($this->data)) {
            $this->Session->setFlash(__('Invalid holiday', true), '');
            $this->redirect(array('action' => 'index'));
        }
        $emp = $this->Holiday->Employee->findByuser_id($this->Session->read('Auth.User.id'));
        $this->data['Holiday']['approved_by'] = $emp['Employee']['id'];
		$hol=$this->Holiday->read(null, $id);
		
		if($hol['Holiday']['status']=='Resubmitted for Correction'){
		$this->loadModel('LeaveModification');
		$cons['LeaveModification.holiday_id']=$id;
		$mod=$this->LeaveModification->find('all', $cons);
		$this->data['Holiday']['status'] = 'Scheduled';
		$this->data['Holiday']['from_date'] = $mod[0]['LeaveModification']['from_new'];
		$this->data['Holiday']['to_date'] = $mod[0]['LeaveModification']['to_new'];
        if (!empty($this->data)) {
            $this->autoRender = false;
            	
				$balance = $this->Holiday->LeaveType->LeaveRule->find('first', array('conditions' => array('LeaveRule.employee_id' => $hol['Holiday']['employee_id'], 'LeaveRule.leave_type_id' => $hol['Holiday']['leave_type_id'])));
				
				$from_date=$hol['Holiday']['from_date'];
				$to_date=$hol['Holiday']['to_date'];
				$old=$this->calculate($from_date, $to_date, 0,$hol['Holiday']['employee_id']);
				$bal = $old + $balance['LeaveRule']['balance'];
				
			$from_new=$mod[0]['LeaveModification']['from_new'];
			$to_new=$mod[0]['LeaveModification']['to_new'];
			$new=$this->calculate($from_new, $to_new, 0,$hol['Holiday']['employee_id']);
			$ldays=$new-$old;
			if($new<=$bal){
				
				if ($this->Holiday->save($this->data)) {
				$this->loadModel('LeaveModification');
				$this->LeaveModification->deleteAll(array('LeaveModification.holiday_id'=>$id));
			
					$this->data2['LeaveRule']['balance'] = $balance['LeaveRule']['balance'] - $ldays;
					$this->data2['LeaveRule']['taken']  = $balance['LeaveRule']['taken'] + $ldays;
					$this->data2['LeaveRule']['id']  = $balance['LeaveRule']['id'];
					$this->Holiday->LeaveType->LeaveRule->save($this->data2);
					
					$empid=$this->Holiday->read(null,$id);
					$this->loadModel('Employee');
					$this->Employee->recursive=-1;
					$emp=$this->Employee->read(null,$empid['Holiday']['employee_id']);
					$emp_tel=$emp['Employee']['telephone'];
					$message="The changes you requested on your past leave record has been approved. - AbayERP";
					$message=urlencode($message);
					file_get_contents('http://10.1.85.10/sms_manager/send.php?redirect='.urlencode($_SERVER["REDIRECT_URL"]).'&to='.$emp_tel.'&msg='.$message);
					
                $this->Session->setFlash(__('The Changes has been Approved', true), '');
                $this->render('/elements/success');
				} else {
                $this->Session->setFlash(__('The Changes could not be Approved. Please, try again.', true), '');
                $this->render('/elements/failure');
				}
			}else{
			$this->Session->setFlash(__('The Changes could not be Approved. Insufficient balance.', true), '');
			$this->render('/elements/failure');
			}
           
        }
		}elseif($hol['Holiday']['status']=='Resubmitted for Cancellation'){
			$this->Holiday->delete($id);
			$this->loadModel('LeaveModification');
			$this->LeaveModification->deleteAll(array('LeaveModification.holiday_id'=>$id));
			
			$balance = $this->Holiday->LeaveType->LeaveRule->find('first', array('conditions' => array('LeaveRule.employee_id' => $hol['Holiday']['employee_id'], 'LeaveRule.leave_type_id' => $hol['Holiday']['leave_type_id'])));
				
				$from_date=$hol['Holiday']['from_date'];
				$to_date=$hol['Holiday']['to_date'];
				$old=$this->calculate($from_date, $to_date, 0,$hol['Holiday']['employee_id']);
				$bal = $old + $balance['LeaveRule']['balance'];
											
					$this->data2['LeaveRule']['balance'] = $bal;
					$this->data2['LeaveRule']['taken']  = $balance['LeaveRule']['taken'] - $old;
					$this->data2['LeaveRule']['id']  = $balance['LeaveRule']['id'];
					$this->Holiday->LeaveType->LeaveRule->save($this->data2);
					
							$empid=$this->Holiday->read(null,$id);
							$this->loadModel('Employee');
							$this->Employee->recursive=-1;
							$emp=$this->Employee->read(null,$empid['Holiday']['employee_id']);
							$emp_tel=$emp['Employee']['telephone'];
							$message="your request on the removal of past leave record has been approved and removed. - AbayERP";
							$message=urlencode($message);
							file_get_contents('http://10.1.85.10/sms_manager/send_fast.php?redirect='.urlencode($_SERVER["REDIRECT_URL"]).'&to='.$emp_tel.'&msg='.$message);
		}else{
			$this->data['Holiday']['status'] = 'Scheduled';
		    if (!empty($this->data)) {
            $this->autoRender = false;
            if ($this->Holiday->save($this->data)) {
							$empid=$this->Holiday->read(null,$id);
							$this->loadModel('Employee');
							$this->Employee->recursive=-1;
							$emp=$this->Employee->read(null,$empid['Holiday']['employee_id']);
							$emp_tel=$emp['Employee']['telephone'];
							$message="The leave you requested has been approved. - AbayERP";
							$message=urlencode($message);
							file_get_contents('http://10.1.85.10/sms_manager/send_fast.php?redirect='.urlencode($_SERVER["REDIRECT_URL"]).'&to='.$emp_tel.'&msg='.$message);
                $this->Session->setFlash(__('The Leave has been Approved', true), '');
                $this->render('/elements/success');
            } else {
                $this->Session->setFlash(__('The Leave could not be Approved. Please, try again.', true), '');
                $this->render('/elements/failure');
            }
		  }
		}
    }

    function reject($id = null) {
        if (!$id && empty($this->data)) {
            $this->Session->setFlash(__('Invalid holiday', true), '');
            $this->redirect(array('action' => 'index'));
        }
        $emp = $this->Holiday->Employee->findByuser_id($this->Session->read('Auth.User.id'));
        $hol=$this->Holiday->read(null, $id);
		
		$this->autoRender = false;
		if($hol['Holiday']['status']=='Resubmitted for Correction' || $hol['Holiday']['status']=='Resubmitted for Cancellation'){
		
			$this->data['Holiday']['status'] = 'Scheduled';
			$this->Holiday->save($this->data);
			
			$this->loadModel('LeaveModification');
			$this->LeaveModification->deleteAll(array('LeaveModification.holiday_id'=>$id));
			
					$empid=$this->Holiday->read(null,$id);
					$this->loadModel('Employee');
					$this->Employee->recursive=-1;
					$emp=$this->Employee->read(null,$empid['Holiday']['employee_id']);
					$emp_tel=$emp['Employee']['telephone'];
					$message="The changes you requested on your past leave record has been rejected. - AbayERP";
					$message=urlencode($message);
					file_get_contents('http://10.1.85.10/sms_manager/send_fast.php?redirect='.urlencode($_SERVER["REDIRECT_URL"]).'&to='.$emp_tel.'&msg='.$message);
			$this->Session->setFlash(__('The Request has been Rejected', true), '');
			$this->render('/elements/success');
		}else{
			$this->data['Holiday']['approved_by'] = $emp['Employee']['id'];
			$this->data['Holiday']['status'] = 'Rejected';
			if ($this->Holiday->save($this->data)) {
					$empid=$this->Holiday->read(null,$id);
					$this->loadModel('Employee');
					$this->Employee->recursive=-1;
					$emp=$this->Employee->read(null,$empid['Holiday']['employee_id']);
					$emp_tel=$emp['Employee']['telephone'];
					$message="The leave you requested has been rejected. - AbayERP";
					$message=urlencode($message);
					file_get_contents('http://10.1.85.10/sms_manager/send_fast.php?redirect='.urlencode($_SERVER["REDIRECT_URL"]).'&to='.$emp_tel.'&msg='.$message);
                $this->Session->setFlash(__('The Leave has been Rejected', true), '');
                $this->render('/elements/success');
            } else {
                $this->Session->setFlash(__('The Leave could not be Rejected. Please, try again.', true), '');
                $this->render('/elements/failure');
            }
		
		}
            
           
        
    }
	
	function leavereport($id = null){
	$this->autoRender = false;
	$emp['Employee']['id']=$id;
	  if (!empty($emp)) {
		$annual = $this->calculate_annual_leave($emp['Employee']['id'],1);
		$most_recent_2years = $annual[1];
		$taken_sys = $this->calculate_system_leave_taken($emp['Employee']['id'],1,0);
		$taken_sys_half = $this->calculate_system_leave_taken($emp['Employee']['id'],2,1);
		$taken_sys = $taken_sys + ($taken_sys_half/2);
		$taken_before = $this->leave_taken_before($emp['Employee']['id'],1);
		$alltaken=$taken_sys+$taken_before;
		$total = $annual[0];
		$bal=$annual[0]-$alltaken;
		$expired = $bal - $most_recent_2years;
		if($expired < 0){
			$expired = 0;
		}
            $balance = $this->Holiday->LeaveType->LeaveRule->find('all', array('conditions' => array('LeaveRule.employee_id' => $emp['Employee']['id'], 'LeaveRule.leave_type_id' => 1)));
             if (!empty($balance)) {
				$this->data['LeaveRule']['total'] = $annual[0];
				$this->data['LeaveRule']['taken'] = $alltaken;
                $this->data['LeaveRule']['balance'] = $bal;
                $this->data['LeaveRule']['id'] = $balance[0]['LeaveRule']['id'];
				$this->data['LeaveRule']['leave_type_id'] = $balance[0]['LeaveRule']['leave_type_id'];
                $this->Holiday->LeaveType->LeaveRule->save($this->data);
			 }else{			 
				if($this->initializeleave($emp['Employee']['id'])==true){
				$balance = $this->Holiday->LeaveType->LeaveRule->find('all', array('conditions' => array('LeaveRule.employee_id' => $emp['Employee']['id'], 'LeaveRule.leave_type_id' => 1)));
				$this->data['LeaveRule']['total'] = $annual[0];
				$this->data['LeaveRule']['taken'] = $alltaken;
                $this->data['LeaveRule']['balance'] = $bal;
                $this->data['LeaveRule']['id'] = $balance[0]['LeaveRule']['id'];
				$this->data['LeaveRule']['leave_type_id'] = $balance[0]['LeaveRule']['leave_type_id'];
                $this->Holiday->LeaveType->LeaveRule->save($this->data);
				}
			 }
			 //echo $annual[0];
			 						$emp=$this->Holiday->Employee->read(null,$emp['Employee']['id']);
					
						$user_name=$emp['User']['Person']['first_name'].' '.$emp['User']['Person']['middle_name'];
		echo '<h2>Staff Leave Summary Report</h2>';
		echo 'Name: '.$user_name;
		echo '<br>Total leave : '.number_format($total, 2, '.', '');
		echo '<br>';
		echo 'Leave Balance of this employee : '.number_format($bal, 2, '.', '');
		echo '<br>Total Annual Leave Taken through AbayERP : '.$taken_sys;
		echo '<br>Total Annual Leave Taken before AbayERP : '.$taken_before;
		echo '<br>Most Recent 2 Years Leave : '.$most_recent_2years;//this is added by Temesgen
		echo '<br>Expired : '.$expired;
		echo '<br><br>';
		echo 'Leave History';
        }
	
	//$conditions['Holiday.employee_id'] = $id;
	//$conditions['Holiday.status'] = 'Taken';
	$conditions['Holiday.employee_id'] = $id;
	$conditions['Holiday.status'] = array('Taken','Scheduled','On Leave','Resubmitted for Correction','Resubmitted for Cancellation');

        $holidays = $this->Holiday->find('all', array('conditions' => $conditions));
        $i = 0;
        foreach ($holidays As $holiday) {
            if ($holiday['Holiday']['leave_type_id'] == 2){
                $holidays[$i]['Holiday']['no_of_dates'] = $this->calculate($holiday['Holiday']['from_date'], $holiday['Holiday']['to_date'], 1);
                $holidays[$i]['Holiday']['no_of_dates'] = $holidays[$i]['Holiday']['no_of_dates'] / 2;
            }else
                $holidays[$i]['Holiday']['no_of_dates'] = $this->calculate($holiday['Holiday']['from_date'], $holiday['Holiday']['to_date'], 0,$holiday['Holiday']['employee_id']);
            $i++;
			
			echo '<br>'.$holiday['LeaveType']['name'].' ------ From ['.$holiday['Holiday']['from_date'].'] To ['.$holiday['Holiday']['to_date'].'] ========= Total: '.$holidays[$i-1]['Holiday']['no_of_dates'].' day(s)';
        }
	}
	
}

?>