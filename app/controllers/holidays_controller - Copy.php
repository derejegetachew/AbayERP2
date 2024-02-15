<?php

class HolidaysController extends AppController {

    var $name = 'Holidays';

	
	function batchleavebalance(){
		
		$emps = $this->Holiday->Employee->find('all');
        $balance=array();
		foreach($emps as $emp){
			$annual = $this->calculate_annual_leave($emp['Employee']['id']);
			$taken_sys = $this->calculate_system_leave_taken($emp['Employee']['id'],1,0);
			$taken_sys_half = $this->calculate_system_leave_taken($emp['Employee']['id'],2,1);
			$taken_sys = $taken_sys + ($taken_sys_half/2);
			$taken_before = $this->leave_taken_before($emp['Employee']['id'],1);
			$alltaken=$taken_sys+$taken_before;
			$bal=$annual-$alltaken;
			
			unset($balance);
			$balance = $this->Holiday->LeaveType->LeaveRule->find('all', array('conditions' => array('LeaveRule.employee_id' => $emp['Employee']['id'], 'LeaveRule.leave_type_id' => 1)));
			 if (!empty($balance)) {
				$this->data['LeaveRule']['total'] = $annual;
				$this->data['LeaveRule']['taken'] = $alltaken;
                $this->data['LeaveRule']['balance'] = $bal;
                $this->data['LeaveRule']['id'] = $balance[0]['LeaveRule']['id'];
				$this->data['LeaveRule']['leave_type_id'] = $balance[0]['LeaveRule']['leave_type_id'];
                $this->Holiday->LeaveType->LeaveRule->save($this->data);
			 }else{			 
				if($this->initializeleave($emp['Employee']['id'])==true){
				$balance = $this->Holiday->LeaveType->LeaveRule->find('all', array('conditions' => array('LeaveRule.employee_id' => $emp['Employee']['id'], 'LeaveRule.leave_type_id' => 1)));
				$this->data['LeaveRule']['total'] = $annual;
				$this->data['LeaveRule']['taken'] = $alltaken;
                $this->data['LeaveRule']['balance'] = $bal;
                $this->data['LeaveRule']['id'] = $balance[0]['LeaveRule']['id'];
				$this->data['LeaveRule']['leave_type_id'] = $balance[0]['LeaveRule']['leave_type_id'];
                $this->Holiday->LeaveType->LeaveRule->save($this->data);
				}
			 }
		}
		echo 'Done';
	}
	
    function index() {
        //$this->autoRender = false;
        //$employees = $this->Holiday->Employee->find('all');
        //$this->set(compact('employees'));
        $emp = $this->Holiday->Employee->findByuser_id($this->Session->read('Auth.User.id'));
        if (!empty($emp)) {
		$annual = $this->calculate_annual_leave($emp['Employee']['id']);
		$taken_sys = $this->calculate_system_leave_taken($emp['Employee']['id'],1,0);
		$taken_sys_half = $this->calculate_system_leave_taken($emp['Employee']['id'],2,1);
		$taken_sys = $taken_sys + ($taken_sys_half/2);
		$taken_before = $this->leave_taken_before($emp['Employee']['id'],1);
		$alltaken=$taken_sys+$taken_before;
		$bal=$annual-$alltaken;
            $balance = $this->Holiday->LeaveType->LeaveRule->find('all', array('conditions' => array('LeaveRule.employee_id' => $emp['Employee']['id'], 'LeaveRule.leave_type_id' => 1)));
            if (!empty($balance)) {

                $this->data['LeaveRule']['total'] = $annual;
				$this->data['LeaveRule']['taken'] = $alltaken;
                $this->data['LeaveRule']['balance'] = $bal;
                $this->data['LeaveRule']['id'] = $balance[0]['LeaveRule']['id'];
				$this->data['LeaveRule']['leave_type_id'] = $balance[0]['LeaveRule']['leave_type_id'];
                $this->Holiday->LeaveType->LeaveRule->save($this->data);

                $halfbalance = $this->Holiday->LeaveType->LeaveRule->find('all', array('conditions' => array('LeaveRule.employee_id' => $emp['Employee']['id'], 'LeaveRule.leave_type_id' => 2)));
                $this->data['LeaveRule']['total'] = $annual * 2;
				$this->data['LeaveRule']['taken'] = $alltaken*2;
                $this->data['LeaveRule']['balance'] = $bal*2;
                $this->data['LeaveRule']['id'] = $halfbalance[0]['LeaveRule']['id'];
				$this->data['LeaveRule']['leave_type_id'] = $halfbalance[0]['LeaveRule']['leave_type_id'];
                $this->Holiday->LeaveType->LeaveRule->save($this->data);
            } else {
                if($this->initializeleave($emp['Employee']['id'])==true){
				$balance = $this->Holiday->LeaveType->LeaveRule->find('all', array('conditions' => array('LeaveRule.employee_id' => $emp['Employee']['id'], 'LeaveRule.leave_type_id' => 1)));
				$this->data['LeaveRule']['total'] = $annual;
				$this->data['LeaveRule']['taken'] = $alltaken;
                $this->data['LeaveRule']['balance'] = $bal;
                $this->data['LeaveRule']['id'] = $balance[0]['LeaveRule']['id'];
				$this->data['LeaveRule']['leave_type_id'] = $balance[0]['LeaveRule']['leave_type_id'];
                $this->Holiday->LeaveType->LeaveRule->save($this->data);

                $halfbalance = $this->Holiday->LeaveType->LeaveRule->find('all', array('conditions' => array('LeaveRule.employee_id' => $emp['Employee']['id'], 'LeaveRule.leave_type_id' => 2)));
                $this->data['LeaveRule']['total'] = $annual * 2;
				$this->data['LeaveRule']['taken'] = $alltaken*2;
                $this->data['LeaveRule']['balance'] = $bal*2;
                $this->data['LeaveRule']['id'] = $halfbalance[0]['LeaveRule']['id'];
				$this->data['LeaveRule']['leave_type_id'] = $halfbalance[0]['LeaveRule']['leave_type_id'];
                $this->Holiday->LeaveType->LeaveRule->save($this->data);
				}
            }
        }
        $this->set('balance', $bal);
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
		$this->User->recursive = 1;
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
        $emp = $this->Holiday->Employee->findByuser_id($this->Session->read('Auth.User.id'));
        $employee_id = $emp['Employee']['id'];
        $conditions = (isset($_REQUEST['conditions'])) ? $_REQUEST['conditions'] : '';

        eval("\$conditions = array( " . $conditions . " );");
        if ($employee_id != -1) {
            $conditions['Holiday.employee_id'] = $employee_id;
        }

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

    function calculate_annual_leave($id) {
        // $this->autoRender = false;
        $increment = 16;
        if ($id) {
            $total = 0;
            // $this->autoRender = false;
            $this->Holiday->Employee->recursive = 2;
            $emp = $this->Holiday->Employee->read(null, $id);
            $this->array_sort_by_column($emp['EmployeeDetail'], "start_date");
            $empdate = $emp['EmployeeDetail'][0]['start_date'];
            if ($emp['EmployeeDetail'][0]['Position']['is_managerial'] == 0) {
                $ration = $increment / 12;
            } else {
                $increment = 20;
                $ration = $increment / 12;
            }

            $this->loadModel('BudgetYear');
            $query = $this->BudgetYear->find('first', array('conditions' =>
                array('BudgetYear.from_date <= ' => $empdate,
                    'BudgetYear.to_date >= ' => $empdate
                    )));
            if (is_array($query)) {
                $from = $query['BudgetYear']['from_date'];
                $to = $query['BudgetYear']['to_date'];
            }else
                return 0;

            $empdate = strtotime($empdate);

            while (date('Y-m-d', $empdate) < date('Y-m-d')) {
                //increment every bugdet year
                if (date('Y-m-d', $empdate) >= $from && date('Y-m-d', $empdate) <= $to) {
                    //do nothing
                } else {
                    $this->loadModel('BudgetYear');
                    $query = $this->BudgetYear->find('first', array('conditions' =>
                        array('BudgetYear.from_date <= ' => date('Y-m-d', $empdate),
                            'BudgetYear.to_date >= ' => date('Y-m-d', $empdate)
                            )));

                    if (is_array($query)) {
                        $from = $query['BudgetYear']['from_date'];
                        $to = $query['BudgetYear']['to_date'];
                    }else
                        return 0;

                    $increment++;
                    $ration = $increment / 12;
                }
                //check if hired to be managerial
                foreach ($emp['EmployeeDetail'] as $empdetail) {

                    if (date('Y-m', strtotime($empdetail['start_date'])) == date('Y-m', $empdate)) {
                        if ($empdetail['Position']['is_managerial'] == 1 && $total < 20) {
                            $increment = 20;
                            $ration = $increment / 12;
                        }
                    }
                }



                $total = $ration + $total;

                $empdate = strtotime("+1 month", $empdate);
            }
            return $total;
        }
    }
	
	function calculate_system_leave_taken($id,$leavetype,$caltype){
		if($id){
			$totals=0;
		$conditionsslt['Holiday.employee_id'] = $id;
		$conditionsslt['Holiday.leave_type_id'] = $leavetype;
		//$conditionsslt['Holiday.to_date <'] = '2016-06-30';
		$conditionsslt['Holiday.status'] = array('Taken','On Leave','Resubmitted for Correction','Resubmitted for Cancellation');
			$holidays = $this->Holiday->find('all', array('conditions' => $conditionsslt));
			foreach ($holidays As $holiday) {
					$totals += $this->calculate($holiday['Holiday']['from_date'], $holiday['Holiday']['to_date'], $caltype,$id);    
			}
			return $totals;
		}
	}
	
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

                $this->data2['LeaveRule']['employee_id'] = $id;
                $this->data2['LeaveRule']['leave_type_id'] = 1;
                $this->data2['LeaveRule']['total'] = 16;
                $this->data2['LeaveRule']['balance'] = 16;
                $this->Holiday->LeaveType->LeaveRule->create();
                $this->Holiday->LeaveType->LeaveRule->save($this->data2);

                $this->data2['LeaveRule']['employee_id'] = $id;
                $this->data2['LeaveRule']['leave_type_id'] = 2;
                $this->data2['LeaveRule']['total'] = 16 * 2;
                $this->data2['LeaveRule']['balance'] = 16 * 2;
                $this->Holiday->LeaveType->LeaveRule->create();
                $this->Holiday->LeaveType->LeaveRule->save($this->data2);

                $this->data2['LeaveRule']['employee_id'] = $id;
                $this->data2['LeaveRule']['leave_type_id'] = 3;
                $this->data2['LeaveRule']['total'] = 180;
                $this->data2['LeaveRule']['balance'] = 180;
                $this->Holiday->LeaveType->LeaveRule->create();
                $this->Holiday->LeaveType->LeaveRule->save($this->data2);

                $this->data2['LeaveRule']['employee_id'] = $id;
                $this->data2['LeaveRule']['leave_type_id'] = 4;
                if ($emp['User']['Person']['sex'] == 'F') {
                    $this->data2['LeaveRule']['total'] = 90;
                    $this->data2['LeaveRule']['balance'] = 90;
                } else {
                    $this->data2['LeaveRule']['total'] = 3;
                    $this->data2['LeaveRule']['balance'] = 3;
                }
                $this->Holiday->LeaveType->LeaveRule->create();
                $this->Holiday->LeaveType->LeaveRule->save($this->data2);

                $this->data2['LeaveRule']['employee_id'] = $id;
                $this->data2['LeaveRule']['leave_type_id'] = 5;
                $this->data2['LeaveRule']['total'] = 300;
                $this->data2['LeaveRule']['balance'] = 300;
                $this->Holiday->LeaveType->LeaveRule->create();
                $this->Holiday->LeaveType->LeaveRule->save($this->data2);

                $this->data2['LeaveRule']['employee_id'] = $id;
                $this->data2['LeaveRule']['leave_type_id'] = 6;
                $this->data2['LeaveRule']['total'] = 300;
                $this->data2['LeaveRule']['balance'] = 300;
                $this->Holiday->LeaveType->LeaveRule->create();
                $this->Holiday->LeaveType->LeaveRule->save($this->data2);

                $this->data2['LeaveRule']['employee_id'] = $id;
                $this->data2['LeaveRule']['leave_type_id'] = 7;
                $this->data2['LeaveRule']['total'] = 300;
                $this->data2['LeaveRule']['balance'] = 300;
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
		$res = $this->LeaveAnnualSetup->find('all', array('conditions' => array('LeaveAnnualSetup.employee_id' => $emp_id)));
          if(!empty($res))
			$saton = $res[0]['LeaveAnnualSetup']['saturday']; //for branch staff
		}
        $frm = strtotime($from);
        $td = strtotime($to);
        $ndate = $td - $frm;
        $numdate = floor($ndate / (60 * 60 * 24)) + 1;
        $this->loadModel('BudgetYear');
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
        return $numdate;
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
                    if ($this->Holiday->save($this->data)) {
						$this->loadModel('Supervisor');
						$supp=$this->Supervisor->find('first',array('conditions'=>array('Supervisor.emp_id'=>$this->data['Holiday']['employee_id'])));
						$this->loadModel('Employee');
						$this->Employee->recursive=3;
						$sup_emp=$this->Employee->read(null,$supp['Supervisor']['sup_emp_id']);
						$emp=$this->Employee->read(null,$this->data['Holiday']['employee_id']);
						$sup_tel=$sup_emp['Employee']['telephone'];
						$user_name=$emp['User']['Person']['first_name'].' '.$emp['User']['Person']['middle_name'];
						//$message=$user_name." has requested leave. - AbayERP";
						$message=$user_name." has requested ".$balance['LeaveType']['name']." from ".$from_date." to ".$to_date." for ".$this->calculate($from_date, $to_date, 0)." day(s). - AbayERP";
						$message=urlencode($message);
						file_get_contents('http://10.1.85.10/sms_manager/send.php?redirect='.urlencode($_SERVER["REDIRECT_URL"]).'&to='.$sup_tel.'&msg='.$message);
					
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
						$this->Employee->recursive=3;
						$sup_emp=$this->Employee->read(null,$supp['Supervisor']['sup_emp_id']);
						$emp=$this->Employee->read(null,$this->data['Holiday']['employee_id']);
						$sup_tel=$sup_emp['Employee']['telephone'];
						$user_name=$emp['User']['Person']['first_name'].' '.$emp['User']['Person']['middle_name'];
						$message=$user_name." has submitted date changes on past leave record. - AbayERP";
						$message=urlencode($message);
						file_get_contents('http://10.1.85.10/sms_manager/send.php?redirect='.urlencode($_SERVER["REDIRECT_URL"]).'&to='.$sup_tel.'&msg='.$message);
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
						$this->Employee->recursive=3;
						$sup_emp=$this->Employee->read(null,$supp['Supervisor']['sup_emp_id']);
						$emp=$this->Employee->read(null,$this->data['Holiday']['employee_id']);
						$sup_tel=$sup_emp['Employee']['telephone'];
						$user_name=$emp['User']['Person']['first_name'].' '.$emp['User']['Person']['middle_name'];
						$message=$user_name." has requested past leave record to be removed. - AbayERP";
						$message=urlencode($message);
						file_get_contents('http://10.1.85.10/sms_manager/send.php?redirect='.urlencode($_SERVER["REDIRECT_URL"]).'&to='.$sup_tel.'&msg='.$message);
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
					$this->Employee->recursive=3;
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
							$this->Employee->recursive=3;
							$emp=$this->Employee->read(null,$empid['Holiday']['employee_id']);
							$emp_tel=$emp['Employee']['telephone'];
							$message="your request on the removal of past leave record has been approved and removed. - AbayERP";
							$message=urlencode($message);
							file_get_contents('http://10.1.85.10/sms_manager/send.php?redirect='.urlencode($_SERVER["REDIRECT_URL"]).'&to='.$emp_tel.'&msg='.$message);
		}else{
			$this->data['Holiday']['status'] = 'Scheduled';
		    if (!empty($this->data)) {
            $this->autoRender = false;
            if ($this->Holiday->save($this->data)) {
							$empid=$this->Holiday->read(null,$id);
							$this->loadModel('Employee');
							$this->Employee->recursive=3;
							$emp=$this->Employee->read(null,$empid['Holiday']['employee_id']);
							$emp_tel=$emp['Employee']['telephone'];
							$message="The leave you requested has been approved. - AbayERP";
							$message=urlencode($message);
							file_get_contents('http://10.1.85.10/sms_manager/send.php?redirect='.urlencode($_SERVER["REDIRECT_URL"]).'&to='.$emp_tel.'&msg='.$message);
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
					$this->Employee->recursive=3;
					$emp=$this->Employee->read(null,$empid['Holiday']['employee_id']);
					$emp_tel=$emp['Employee']['telephone'];
					$message="The changes you requested on your past leave record has been rejected. - AbayERP";
					$message=urlencode($message);
					file_get_contents('http://10.1.85.10/sms_manager/send.php?redirect='.urlencode($_SERVER["REDIRECT_URL"]).'&to='.$emp_tel.'&msg='.$message);
			$this->Session->setFlash(__('The Request has been Rejected', true), '');
			$this->render('/elements/success');
		}else{
			$this->data['Holiday']['approved_by'] = $emp['Employee']['id'];
			$this->data['Holiday']['status'] = 'Rejected';
			if ($this->Holiday->save($this->data)) {
					$empid=$this->Holiday->read(null,$id);
					$this->loadModel('Employee');
					$this->Employee->recursive=3;
					$emp=$this->Employee->read(null,$empid['Holiday']['employee_id']);
					$emp_tel=$emp['Employee']['telephone'];
					$message="The leave you requested has been rejected. - AbayERP";
					$message=urlencode($message);
					file_get_contents('http://10.1.85.10/sms_manager/send.php?redirect='.urlencode($_SERVER["REDIRECT_URL"]).'&to='.$emp_tel.'&msg='.$message);
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
		$annual = $this->calculate_annual_leave($emp['Employee']['id']);
		$taken_sys = $this->calculate_system_leave_taken($emp['Employee']['id'],1,0);
		$taken_sys_half = $this->calculate_system_leave_taken($emp['Employee']['id'],2,1);
		$taken_sys = $taken_sys + ($taken_sys_half/2);
		$taken_before = $this->leave_taken_before($emp['Employee']['id'],1);
		$alltaken=$taken_sys+$taken_before;
		$bal=$annual-$alltaken;
            $balance = $this->Holiday->LeaveType->LeaveRule->find('all', array('conditions' => array('LeaveRule.employee_id' => $emp['Employee']['id'], 'LeaveRule.leave_type_id' => 1)));
            if (!empty($balance)) {

                $this->data['LeaveRule']['total'] = $annual;
				$this->data['LeaveRule']['taken'] = $alltaken;
                $this->data['LeaveRule']['balance'] = $bal;
                $this->data['LeaveRule']['id'] = $balance[0]['LeaveRule']['id'];
				$this->data['LeaveRule']['leave_type_id'] = $balance[0]['LeaveRule']['leave_type_id'];
                $this->Holiday->LeaveType->LeaveRule->save($this->data);

                $halfbalance = $this->Holiday->LeaveType->LeaveRule->find('all', array('conditions' => array('LeaveRule.employee_id' => $emp['Employee']['id'], 'LeaveRule.leave_type_id' => 2)));
                $this->data['LeaveRule']['total'] = $annual * 2;
				$this->data['LeaveRule']['taken'] = $alltaken*2;
                $this->data['LeaveRule']['balance'] = $bal*2;
                $this->data['LeaveRule']['id'] = $halfbalance[0]['LeaveRule']['id'];
				$this->data['LeaveRule']['leave_type_id'] = $halfbalance[0]['LeaveRule']['leave_type_id'];
                $this->Holiday->LeaveType->LeaveRule->save($this->data);
            } else {
                $this->initializeleave($emp['Employee']['id']);
				$balance = $this->Holiday->LeaveType->LeaveRule->find('all', array('conditions' => array('LeaveRule.employee_id' => $emp['Employee']['id'], 'LeaveRule.leave_type_id' => 1)));
				$this->data['LeaveRule']['total'] = $annual;
				$this->data['LeaveRule']['taken'] = $alltaken;
                $this->data['LeaveRule']['balance'] = $bal;
                $this->data['LeaveRule']['id'] = $balance[0]['LeaveRule']['id'];
				$this->data['LeaveRule']['leave_type_id'] = $balance[0]['LeaveRule']['leave_type_id'];
                $this->Holiday->LeaveType->LeaveRule->save($this->data);

                $halfbalance = $this->Holiday->LeaveType->LeaveRule->find('all', array('conditions' => array('LeaveRule.employee_id' => $emp['Employee']['id'], 'LeaveRule.leave_type_id' => 2)));
                $this->data['LeaveRule']['total'] = $annual * 2;
				$this->data['LeaveRule']['taken'] = $alltaken*2;
                $this->data['LeaveRule']['balance'] = $bal*2;
                $this->data['LeaveRule']['id'] = $halfbalance[0]['LeaveRule']['id'];
				$this->data['LeaveRule']['leave_type_id'] = $halfbalance[0]['LeaveRule']['leave_type_id'];
                $this->Holiday->LeaveType->LeaveRule->save($this->data);

            }
		echo '<h2>Staff Leave Summary Report</h2>';
		echo 'Leave Balance of this employee : '.number_format($bal, 0, '.', '');
		echo '<br>Total Annual Leave Taken through AbayERP : '.$taken_sys;
		echo '<br>Total Annual Leave Taken before AbayERP : '.$taken_before;
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