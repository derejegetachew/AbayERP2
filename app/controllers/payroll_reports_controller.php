<?php

class PayrollReportsController extends AppController {

    var $name = 'PayrollReports';

    function index() {
        $payrolls = $this->PayrollReport->Payroll->find('all');
        $this->set(compact('payrolls'));
    }

    function index3($id = null) {
        $payrolls = $this->PayrollReport->Payroll->find('all');
        $this->set(compact('payrolls'));
        $this->set('parent_id', $id);
    }

    function index2($id = null) {
        $this->set('parent_id', $id);
    }

    function search() {
        
    }

    function list_data($id = null) {
        $start = (isset($_REQUEST['start'])) ? $_REQUEST['start'] : 0;
        $limit = (isset($_REQUEST['limit'])) ? $_REQUEST['limit'] : 5;
        $payroll_id = (isset($_REQUEST['payroll_id'])) ? $_REQUEST['payroll_id'] : -1;
        if ($id)
            $payroll_id = ($id) ? $id : -1;
        $conditions = (isset($_REQUEST['conditions'])) ? $_REQUEST['conditions'] : '';

        eval("\$conditions = array( " . $conditions . " );");

        $conditions['PayrollReport.payroll_id'] = $this->Session->read('Auth.User.payroll_id');


        $this->set('payroll_reports', $this->PayrollReport->find('all', array('conditions' => $conditions, 'limit' => $limit, 'offset' => $start)));
        $this->set('results', $this->PayrollReport->find('count', array('conditions' => $conditions)));
    }

    function array_sort_by_column(&$arr, $col, $dir = SORT_ASC) {
        $sort_col = array();
        foreach ($arr as $key => $row) {
            $sort_col[$key] = $row[$col];
        }

        array_multisort($sort_col, $dir, $arr);
    }
  function temppayrollx($id) {
	  $this->autoRender = false;
        $this->PayrollReport->recursive = 2; // always 5
        $report = $this->PayrollReport->read(null, $id);
		print_r($report['Payroll']['PayrollEmployee']);
		exit();
  }
  
  function temppayroll($id) {
		$this->autoRender = false;
        $this->PayrollReport->recursive = 2; // always 5
        $report = $this->PayrollReport->read(null, $id);
		if ($report['PayrollReport']['status'] != 'Not Approved')
			exit();
        $rec_i = 0;
		//gas price
			$this->loadModel('Price');
            $conditions['Price.payroll_id'] = $report['PayrollReport']['payroll_id'];
            $conditions['Price.status'] = 'active';
            $prc = $this->Price->find('all', array('conditions' => $conditions, 'order' => 'Price.date DESC'));
			$gasprice=$prc[0]['Price']['gas'];
        foreach ($report['Payroll']['PayrollEmployee'] as $employees) {
            if ($employees['status'] == 'active') {
                $emp_id = $employees['employee_id'];
                $this->loadModel('Employee');
                $conditionsd['Employee.id'] = $emp_id;
                $this->Employee->recursive = 2;
                $empdet = $this->Employee->find('all', array('conditions' => $conditionsd));
				if($empdet[0]['Employee']['status']=='active')
                if (!empty($empdet[0]['Employee']) && !empty($empdet[0]['User'])) {
				$fixed_deds='';
                    $arremps = $empdet[0]['EmployeeDetail'];
                    $this->array_sort_by_column($arremps, "start_date", SORT_DESC);
                    $daysofmonth = 30;// date('t'); 
                    $salary = 0;
                    $totaldays = 0;
                    $partial = 0;
					$temppayroll[$rec_i]['managerial']=$arremps[0]['Position']['is_managerial']; 
					if($employees['salary']==0){
					
                    foreach ($arremps as $arremp) {
					
                        $days = 0;
                        if (date('Y-m', strtotime($arremp['start_date'])) < date('Y-m') && ($arremp['end_date'] == '0000-00-00' || date('Y-m', strtotime($arremp['end_date'])) > date('Y-m'))) {
                            $days = $daysofmonth;
                        }
                        if (date('Y-m', strtotime($arremp['start_date'])) == date('Y-m')) {
                            $start = strtotime($arremp['start_date']);
                            if ($arremp['end_date'] == '0000-00-00' || date('Y-m', strtotime($arremp['end_date'])) > date('Y-m'))
                                $end = strtotime(date('Y-m') . '-'.$daysofmonth);
                            else
                                $end = (strtotime(date('d',strtotime($arremp['end_date']))) >= date('t',strtotime($arremp['end_date'])) ? date('Y-m',strtotime($arremp['end_date'])).'-'.$daysofmonth : $arremp['end_date']);
                            $days = floor(abs($end - $start) / 86400);
                            $days++;
                        }
                        if (date('Y-m', strtotime($arremp['start_date'])) < date('Y-m') && date('Y-m', strtotime($arremp['end_date'])) == date('Y-m')) {
                            $end = strtotime($arremp['end_date']);
                            $start = strtotime(date('Y-m') . '-01');
                            $days = floor(abs($end - $start) / 86400);
                            $days++;
                        }
                        if ($days > 0) {
                            if ($days >= date('t'))
                                $days = $daysofmonth;
							if($days>30)
								$days=30;
                            if ($days != $daysofmonth)
                                $partial++;

                            $con['Scale.grade_id'] = $arremp['grade_id'];
                            $con['Scale.step_id'] = $arremp['step_id'];
                            $this->loadModel('Scale');
                            $salarya = $this->Scale->find('all', array('conditions' => $con));
                            $fullsal = $salarya[0]['Scale']['salary'];

                            $ssalary = ($fullsal / $daysofmonth) * $days;
                            $salary = $salary + $ssalary;
                            $totaldays = $totaldays + $days;
                        
                        //Grade Benefit
                        $arrs = $report['Payroll']['Benefit'];
                        $grade_id = $arremp['grade_id'];
                        foreach ($arrs as $arr) {
                            $sumx = $sumtx = 0;
                            if ($arr['status'] == 'active') {
                                if (date('Y-m') >= date('Y-m', strtotime($arr['start_date'])) && (date('Y-m') <= date('Y-m', strtotime($arr['end_date'])) || $arr['end_date'] == '0000-00-00')) {
                                    if ($arr['grade_id'] == $grade_id) {
                                        $sumx = ($this->measure($ssalary, $arr['amount'], $arr['Measurement'], $report['PayrollReport']['payroll_id'])/$daysofmonth)*$days;
										
										$temppayroll[$rec_i]['B_' .$arr['Measurement'].'_'. $arr['name']]+=$sumx;
               if ($arr['taxable'] == 1 && $arr['over'] < $temppayroll[$rec_i]['B_' .$arr['Measurement'].'_'. $arr['name']]) {
                                   $sumtx = $temppayroll[$rec_i]['B_' .$arr['Measurement'].'_'. $arr['name']] - $arr['over'];
                                            $sumx = $arr['over'];
											$temppayroll[$rec_i]['B_' .$arr['Measurement'].'_'. $arr['name']]=$arr['over'];
                                        }
                                        
                                        if ($sumtx > 0)
                                            $temppayroll[$rec_i]['B_' .$arr['Measurement'].'_'. $arr['name'] . '_taxable']+=$sumtx;
                                    }
                                }
                            }
                        }
                        //Grade Deductions
                        $arrs = $report['Payroll']['Deduction'];
                        foreach ($arrs as $arr) {
                            if ($arr['status'] == 'active') {
                                if (date('Y-m-d') >= date('Y-m-d', strtotime($arr['start_date'])) && (date('Y-m-d') <= date('Y-m-d', strtotime($arr['end_date'])) || $arr['end_date'] == '0000-00-00')) {
                                    if ($arr['grade_id'] == $grade_id) {
                                        if ($arr['Measurement'] == 'Birr') {
										if(strpos($fixed_deds,$arr['name'])===false){
                                            $temppayroll[$rec_i]['D_' . $arr['name']]+=$arr['amount'];
											$fixed_deds=$fixed_deds.' '.$arr['name'];
											}
                                        }
                                        if ($arr['Measurement'] == 'Percentile: Basic Salary') {
                                            $temppayroll[$rec_i]['D_' . $arr['name']]+= ($ssalary * $arr['amount'] / 100);
                                        }
                                        /*if ($arr['Measurement'] == 'Percentile: Gross Salary') {  //gross amound could not be found
                                            $temppayroll[$rec_i]['D_' . $arr['name']]+= ($gross * $arr['amount'] / 100);
                                        }*/
                                    }
                                }
                            }
                        }
					  }
					 
                    }
					
					}
					
					if($employees['salary']>0) //Set SPECIAL SALARY
						$salary=$employees['salary'];
					
                    //specific Benefit
                    $arrs = $report['Payroll']['Benefit'];
                    foreach ($arrs as $arr) {
                        $sumx = $sumtx = 0;
                        if ($arr['status'] == 'active') {
                            if (date('Y-m') >= date('Y-m', strtotime($arr['start_date'])) && (date('Y-m') <= date('Y-m', strtotime($arr['end_date'])) || $arr['end_date'] == '0000-00-00')) {
                                if ($arr['employee_id'] == $emp_id) {
                                    $sumx = ($this->measure($salary, $arr['amount'], $arr['Measurement'], $report['PayrollReport']['payroll_id'])/$daysofmonth)*$daysofmonth;
                                    if ($arr['taxable'] == 1 && $arr['over'] < $sumx) {
                                        $sumtx = $sumx - $arr['over'];
                                        $sumx = $arr['over'];
                                    }
                                    $temppayroll[$rec_i]['B_' .$arr['Measurement'].'_'. $arr['name']] = $sumx; //. '_employee'
                                    if ($sumtx > 0)
                                        $temppayroll[$rec_i]['B_' .$arr['Measurement'].'_'. $arr['name'] . '_taxable'] = $sumtx; //_employee
										
									/*if(isset($temppayroll[$rec_i]['B_' .$arr['Measurement'].'_'. $arr['name']])){//replace grade benefits with specific benefits
										$temppayroll[$rec_i]['B_' .$arr['Measurement'].'_'. $arr['name']]=0;
										if(isset($temppayroll[$rec_i]['B_' .$arr['Measurement'].'_'. $arr['name'] . '_taxable']))
										 $temppayroll[$rec_i]['B_' .$arr['Measurement'].'_'. $arr['name'] . '_taxable']=0;
									}*/
                                }
                            }
                        }
                    }
					//calculate perdium
					$arrs = $report['Payroll']['Perrdiemm'];
					$txperd=0;
					$ntxperd=0;
					$perd=0;
                    foreach ($arrs as $arr) {
						if((date('Y-m')== date('Y-m',strtotime($arr['date']))) && $arr['employee_id']==$emp_id){
							$temppayroll[$rec_i]['days_perdium']+=$arr['days'];
							$temppayroll[$rec_i]['total_perdium']+=($arr['days']*$arr['rate']);
							$temppayroll[$rec_i]['taxable_perdium']+=($arr['days']*$arr['rate'])-($arr['days']*$arr['taxable']);
							$temppayroll[$rec_i]['non_tx_perdium']+=($arr['days']*$arr['rate'])-(($arr['days']*$arr['rate'])-($arr['days']*$arr['taxable']));
						}
					}
					if($temppayroll[$rec_i]['days_perdium']>0){
					$temppayroll[$rec_i]['perdium_rate']=$temppayroll[$rec_i]['total_perdium']/$temppayroll[$rec_i]['days_perdium'];
					$txperd=$temppayroll[$rec_i]['taxable_perdium'];
					$ntxperd=$temppayroll[$rec_i]['non_tx_perdium'];
					$perd=$temppayroll[$rec_i]['total_perdium'];
					}
					//Sum benefits
					$sumbens=0;
					$bens=$temppayroll[$rec_i];
					foreach($bens as $key=>$ben){
					if (strpos($key,'B_') !== false)
					$sumbens+=$ben;
					}
					$temppayroll[$rec_i]['benefits'] = $sumbens;
					$gross=$salary+$sumbens;
					$temppayroll[$rec_i]['gross'] = $gross;
                    //Specific Deduction & Deduction from gross pay
                    $arrs = $report['Payroll']['Deduction'];
                    foreach ($arrs as $arr) {
                        if ($arr['status'] == 'active') {
                            if (date('Y-m-d') >= date('Y-m-d', strtotime($arr['start_date'])) && (date('Y-m-d') <= date('Y-m-d', strtotime($arr['end_date'])) || $arr['end_date'] == '0000-00-00')) {
                                if ($arr['grade_id'] == $grade_id) {
                                    if ($arr['Measurement'] == 'Percentile: Gross Salary') {
                                        $temppayroll[$rec_i]['D_' . $arr['name']]+= ($gross * $arr['amount'] / 100);
                                    }
                                }
                                if ($arr['employee_id'] == $emp_id) {
                                    if ($arr['Measurement'] == 'Birr') {
                                        //$temppayroll[$rec_i]['D_' . $arr['name'] . '_employee']+=$arr['amount']; //old
										$temppayroll[$rec_i]['D_' . $arr['name']]+=$arr['amount']; //replace grade deduction
                                    }
                                    if ($arr['Measurement'] == 'Percentile: Basic Salary') {
                                        $temppayroll[$rec_i]['D_' . $arr['name']]+= ($salary * $arr['amount'] / 100) ; //replace grade deduction
                                    }
                                    if ($arr['Measurement'] == 'Percentile: Gross Salary') {
                                        $temppayroll[$rec_i]['D_' . $arr['name']]+= ($gross * $arr['amount'] / 100); //replace grade deduction
                                    }
                                }
                            }
                        }
                    }
					//Sum taxable benefits
					$sumtxbens=0;
					$bens=$temppayroll[$rec_i];
					foreach($bens as $key=>$ben){
					if (strpos($key,'B_') !== false && strpos($key,'_taxable') !== false)
					$sumtxbens+=$ben;
					}
					//taxable income
					$taxable_income=$salary+$sumtxbens+$txperd;
					$temppayroll[$rec_i]['taxable_income'] = $taxable_income;
					//total non taxable income
					$sumntxbens=0;
					$bens=$temppayroll[$rec_i];
					foreach($bens as $key=>$ben){
					if (strpos($key,'B_') !== false && strpos($key,'_taxable') === false)
					$sumntxbens+=$ben;
					}
					$ntaxable_income=$sumntxbens;
					$temppayroll[$rec_i]['non_taxable_income'] = $ntaxable_income;
					//sum deductions
					$sumdeds=0;
					$deds=$temppayroll[$rec_i];
					foreach($deds as $key=>$ded){
					if (strpos($key,'D_') !== false)
					$sumdeds+=$ded;
					}
					$deducs=$sumdeds;
					$temppayroll[$rec_i]['Deductions Sum'] = $deducs;
					//Loan
					$totalloan=0;
					$this->loadModel('Loan');
					$this->Loan->recursive = 1;
					$conditionsl['Loan.employee_id'] = $emp_id;
					$conditionsl['Loan.status'] = 'active';
					$loans = $this->Loan->find('all', array('conditions' => $conditionsl));
					foreach ($loans as $arr) {
						$date1 = $arr['Loan']['start'];
						$ts1 = strtotime($date1);
						$year1 = date('Y', $ts1);
						$year2 = date('Y');
						$month1 = date('m', $ts1);
						$month2 = date('m');
						$diff = (($year2 - $year1) * 12) + ($month2 - $month1);
						if ($diff < $arr['Loan']['no_months'] && $diff >= 0) {
							$temppayroll[$rec_i]['L_'.$arr['Loan']['Type']] += $arr['Loan']['Per_month'];
							$totalloan+=$arr['Loan']['Per_month'];
						}
					}
					//income tax
					$arrs=$report['Payroll']['TaxRule'];
					 foreach ($arrs as $arr) {
						if ($arr['status'] == 'active') {
							if ($taxable_income >= $arr['min'] && $taxable_income <= $arr['max']) {
								$temppayroll[$rec_i]['Income Tax']=($taxable_income * ($arr['percent'] / 100)) - $arr['deductable'];
								$temppayroll[$rec_i]['Tax Rule'] = $arr['id'];
							}
						}
					}
					//calculate pension
					$pfcompany=$pfstaff=$pencompany=$penstaff=0;
					$this->loadModel('PensionEmployee');
					$pen = $this->PensionEmployee->findbyemployee_id($emp_id);
					if (isset($pen)) {
						if ($pen['Pension']['status'] == 'active') {
							if($pen['Pension']['pf_company']>0)	
							 $temppayroll[$rec_i]['Pf company '.$pen['Pension']['pf_company']] = $salary * ($pen['Pension']['pf_company'] / 100);
							 $pfcompany = $salary * ($pen['Pension']['pf_company'] / 100);
							 if($pen['Pension']['pen_company']>0)
							 $temppayroll[$rec_i]['Pension company '.$pen['Pension']['pen_company']] = $salary * ($pen['Pension']['pen_company'] / 100);
							 $pencompany=$salary * ($pen['Pension']['pen_company'] / 100);
							 if($pen['Pension']['pf_staff']>0)
							$temppayroll[$rec_i]['Pf staff '.$pen['Pension']['pf_staff']] = $salary * ($pen['Pension']['pf_staff'] / 100);
							$pfstaff=$salary * ($pen['Pension']['pf_staff'] / 100);
							if($pen['Pension']['pen_staff']>0)
							$temppayroll[$rec_i]['Pension staff '.$pen['Pension']['pen_staff']] = $salary * ($pen['Pension']['pen_staff'] / 100);
							$penstaff=$salary * ($pen['Pension']['pen_staff'] / 100);
							$temppayroll[$rec_i]['Pen pf Rule']=$pen['Pension']['id'];
						}
					}
					//Cash Indeminity Store
					$this->loadModel('CashStore');
                    $this->CashStore->recursive = 1;
                    $conditionsc['CashStore.budget_year_id']=$report['PayrollReport']['budget_year_id'];
					$conditionsc['CashStore.employee_id']=$emp_id;
                    $cash_stores = $this->CashStore->find('all', array('conditions' => $conditionsc));
                    foreach($cash_stores as $cash_store){
                        $temppayroll[$rec_i]['CashStore'] += $cash_store['CashStore']['value'];
                    }
					$temppayroll[$rec_i]['All Deductions']=$totalloan+$pfstaff+$penstaff+$temppayroll[$rec_i]['Income Tax']+$temppayroll[$rec_i]['Deductions Sum'];
					$temppayroll[$rec_i]['net']=$temppayroll[$rec_i]['gross']-$temppayroll[$rec_i]['All Deductions'];
					$temppayroll[$rec_i]['gas_price']=$gasprice;
					$temppayroll[$rec_i]['payroll_Report_id'] = $id;
					$temppayroll[$rec_i]['payroll_id'] = $report['PayrollReport']['payroll_id'];
					$temppayroll[$rec_i]['employee_id'] = $emp_id;
					$temppayroll[$rec_i]['work_days'] = $totaldays;
					$temppayroll[$rec_i]['partial'] = $partial;
					$temppayroll[$rec_i]['salary'] = $salary;
					$temppayroll[$rec_i]['account_no'] = $employees['account_no'];
					$temppayroll[$rec_i]['pf_account_no'] = $employees['pf_account_no'];

                $rec_i++;
                }
            }
        }
		//print_r($temppayroll);
		$this->PayrollReport->query("DELETE FROM `temppayroll` WHERE `payroll_Report_id`=$id");
		
		$columns=$this->PayrollReport->query("SHOW COLUMNS FROM temppayroll");
		$rows=array();
		foreach($columns as $column)
			array_push($rows,$column['COLUMNS']['Field']);
		foreach($temppayroll as $temps){
		
		$comma=0;$fieldrows='';$fieldvalues='';
			foreach($temps as $key=>$temp){
				if(array_search($key, $rows)===false){
					$this->PayrollReport->query("ALTER TABLE temppayroll ADD `$key`  DOUBLE DEFAULT 0");
					$columns=$this->PayrollReport->query("SHOW COLUMNS FROM temppayroll"); //refresh columns
					$rows=array();
					foreach($columns as $column)
					array_push($rows,$column['COLUMNS']['Field']);
					}
				if($comma==0)
				$fieldrows=$fieldrows . '`'.$key.'`';
				else
				$fieldrows=$fieldrows . ',`'.$key.'`';
			
				if($comma==0)
				$fieldvalues=$fieldvalues."'".$temp."'";
				else
				$fieldvalues=$fieldvalues.",'".$temp."'";
				
				$comma++;
			}
			if($comma>0)
			$this->PayrollReport->query("INSERT INTO `temppayroll` ($fieldrows) VALUES ( $fieldvalues)");
			//echo "INSERT INTO `temppayroll` ($fieldrows) VALUES ( $fieldvalues)";
		}
		//echo "<input type= 'button' onclick='javascript:history.back();return false;' value='Processing Completed. Click to go back'>";
    }
	
    function list_data2($id = null) {
        if (!$id) {
            $this->Session->setFlash(__('Invalid payroll report', true));
            $this->redirect(array('action' => 'index'));
        }
		
        $JSC = '{	success:true,	results: 5,	rows: [';
        $this->PayrollReport->recursive = 2; // always 5
        $report = $this->PayrollReport->read(null, $id);

        //echo 'Name:'.$report[Payroll][PayrollEmployee];
        $payroll_id = $report['PayrollReport']['payroll_id'];

        if ($report['PayrollReport']['status'] == 'Not Approved') {
			$this->temppayroll($id);
            foreach ($report['Payroll']['PayrollEmployee'] as $employees) {
                //if (!empty($employees['Employee'])) {
                if ($employees['status'] == 'active') {
                    
                    //$emp_id = $employees['Employee']['id'];
                    //$fullname = $employees['Employee']['User']['Person']['first_name'] . ' ' . $employees['Employee']['User']['Person']['middle_name'] . ' ' . $employees['Employee']['User']['Person']['last_name'];
                    //$this->array_sort_by_column($employees['Employee']['EmployeeDetail'], "start_date", SORT_DESC);
                    //$salary = $employees['Employee']['EmployeeDetail'][0]['salary'];
                    //$grade_id = $employees['Employee']['EmployeeDetail'][0]['grade_id'];
                    $emp_id = $employees['employee_id'];
                    $this->loadModel('Employee');
                    $conditionsd['Employee.id'] = $emp_id;
                    $this->Employee->recursive = 2;
                    $empdet = $this->Employee->find('all', array('conditions' => $conditionsd));
                    //print_r($empdet);
					if($empdet[0]['Employee']['status']=='active')
                    if (!empty($empdet[0]['Employee']) && !empty($empdet[0]['User'])) {
						$JSC.='{' . "\n";
                        $fullname = $empdet[0]['User']['Person']['first_name'] . ' ' . $empdet[0]['User']['Person']['middle_name'] . ' ' . $empdet[0]['User']['Person']['last_name'];
                        $arremps = $empdet[0]['EmployeeDetail'];
                        $this->array_sort_by_column($arremps, "start_date", SORT_DESC);
                        //$daysofmonth=date('t');
                        $daysofmonth = 30;
                        $salary = 0;
                        foreach ($arremps as $arremp) {
                            $days = 0;
                            if (date('Y-m', strtotime($arremp['start_date'])) < date('Y-m') && ($arremp['end_date'] == '0000-00-00' || date('Y-m', strtotime($arremp['end_date'])) > date('Y-m'))) {
                                $days = $daysofmonth;
                            }
                            if (date('Y-m', strtotime($arremp['start_date'])) == date('Y-m')) {
                                $start = strtotime($arremp['start_date']);
                                if ($arremp['end_date'] == '0000-00-00' || date('Y-m', strtotime($arremp['end_date'])) > date('Y-m'))
                                    $end = strtotime(date('Y-m') . '-'.$daysofmonth);
                            else
                                $end = (strtotime(date('d',strtotime($arremp['end_date']))) >= date('t',strtotime($arremp['end_date'])) ? date('Y-m',strtotime($arremp['end_date'])).'-'.$daysofmonth : $arremp['end_date']);
                                $days = floor(abs($end - $start) / 86400);
                                $days++;
                            }
                            if (date('Y-m', strtotime($arremp['start_date'])) < date('Y-m') && date('Y-m', strtotime($arremp['end_date'])) == date('Y-m')) {
                                $end = strtotime($arremp['end_date']);
                                $start = strtotime(date('Y-m') . '-01');
                                $days = floor(abs($end - $start) / 86400);
                                $days++;
                            }
                            if ($days > 0) {
                                if ($days >= date('t'))
                                    $days = $daysofmonth;
                                $fullsal = $arremp['salary'];
                                $ssalary = ($arremp['salary'] / $daysofmonth) * $days;
                                $salary = $salary + $ssalary;
                            }
                        }
						$salary=round($salary,2);
                        $be[0] = $bg[0] = $tbe[0] = $tbg[0] = 0;
                        if ($empdet[0]['Employee']['trial'] == 'false') {
                            $be = $this->calculate_benefits($report['Payroll']['Benefit'], $arremps, $emp_id, 0, 0, $salary, $payroll_id);
                            $bg = $this->calculate_benefits($report['Payroll']['Benefit'], $arremps, 0, $grade_id = 1, 0, $salary, $payroll_id);
                            $tbe = $this->calculate_benefits($report['Payroll']['Benefit'], $arremps, $emp_id, 0, 1, $salary, $payroll_id);
                            if ($tbe[1] > 0)
                                $be[0] = $be[0] + $tbe[1];
                            $tbg = $this->calculate_benefits($report['Payroll']['Benefit'], $arremps, 0, $grade_id = 1, 1, $salary, $payroll_id);
                            if ($tbg[1] > 0)
                                $bg[0] = $bg[0] + $tbg[1];
                        }
						$perd=$this->calculateperdium($report['Payroll']['Perrdiemm'],$emp_id);
                        $gross = $salary + $be[0] + $bg[0] + $tbe[0] + $tbg[0];
                        $sdg = $this->calculate_deductions($report['Payroll']['Deduction'], $arremps, $emp_id, 0, $gross, $salary, $payroll_id);
                        $gdg = $this->calculate_deductions($report['Payroll']['Deduction'], $arremps, 0, $grade_id = 1, $gross, $salary, $payroll_id);
                        $taxable_income = $salary + $tbe[0] + $tbg[0]+$perd[1];
                        $loans = $this->calculate_loans($emp_id);
                        $ict = $this->calculate_tax($report['Payroll']['TaxRule'], $taxable_income);
                        $pf = $this->calculate_pension($emp_id, 'pf_staff', $salary);
                        $pension = $this->calculate_pension($emp_id, 'pension_staff', $salary);
                        $pf_pn_dedc = $this->calculate_pension($emp_id, 'pension_staff', $salary) + $this->calculate_pension($emp_id, 'pf_staff', $salary);
                        $tot_dedc = $sdg + $gdg + $pf_pn_dedc;
                        $net = $gross - $ict - $tot_dedc - $loans;
						$query="SELECT * FROM  `temppayroll` WHERE `temppayroll`.`payroll_Report_id`=$id AND `temppayroll`.`employee_id`=$emp_id";
						$resultqq =$this->PayrollReport->query($query);
                        $JSC.='"id":"' . $emp_id . '",' . "\n";
                        $JSC.='"name":"' . $fullname . '",' . "\n";
                        $JSC.= '"basic_salary":"' . $salary . '",' . "\n";
                        $JSC.= '"non_taxable_benefits":"' . ($be[0] + $bg[0]) . '",' . "\n";
                        $JSC.= '"taxable_benefits":"' . ($tbe[0] + $tbg[0] + $perd[1]) . '",' . "\n";
                        $JSC.= '"gross_pay":"' . $gross . '",' . "\n";
                        $JSC.= '"income_tax":"' . $resultqq[0]['temppayroll']['Income Tax'] . '",' . "\n";
                        $JSC.= '"deductions":"' . $tot_dedc . '",' . "\n";
                        $JSC.= '"loan_repayements":"' . $loans . '",' . "\n";
                        $JSC.= '"total_pf":"' . $pf . '",' . "\n";
                        $JSC.= '"total_pension":"' . $pension . '",' . "\n";
						
                        $JSC.= '"net_pay":"<b style=\'color:red\'>' . $resultqq[0]['temppayroll']['net'] . '</b>",' . "\n";
                        $JSC.='},' . "\n";
                    }
                }
            }
        }
        if ($report['PayrollReport']['status'] == 'Approved') {
            $this->loadModel('BkPayroll');
            $this->BkPayroll->recursive = 0;
            $conditionsbk['BkPayroll.payroll_report_id'] = $id;
            $bkpayrolls = $this->BkPayroll->find('all', array('conditions' => $conditionsbk));
            //print_r($bkpayrolls);
            foreach ($bkpayrolls as $bkpayroll) {
                $emp_id = $bkpayroll['BkPayroll']['employee_id'];
                $this->loadModel('Employee');
                $conditionsd['Employee.id'] = $emp_id;
                $this->Employee->recursive = 2;
                $empdet = $this->Employee->find('all', array('conditions' => $conditionsd));

                if (!empty($empdet[0]['Employee']) && !empty($empdet[0]['User'])) {
                    $fullname = $empdet[0]['User']['Person']['first_name'] . ' ' . $empdet[0]['User']['Person']['middle_name'] . ' ' . $empdet[0]['User']['Person']['last_name'];

                    $JSC.='{' . "\n";
                    $JSC.='"id":"' . $bkpayroll['BkPayroll']['employee_id'] . '",' . "\n";
                    $JSC.='"name":"' . $fullname . '",' . "\n";
                    $JSC.= '"basic_salary":"' . $bkpayroll['BkPayroll']['basic_salary'] . '",' . "\n";
                    $JSC.= '"non_taxable_benefits":"' . $bkpayroll['BkPayroll']['non_taxable_benefit'] . '",' . "\n";
                    $JSC.= '"taxable_benefits":"' . $bkpayroll['BkPayroll']['taxable_benefit'] . '",' . "\n";
                    $JSC.= '"gross_pay":"' . $bkpayroll['BkPayroll']['gross_pay'] . '",' . "\n";
                    $JSC.= '"income_tax":"' . $bkpayroll['BkPayroll']['income_tax'] . '",' . "\n";
                    $JSC.= '"deductions":"' . $bkpayroll['BkPayroll']['deductions'] . '",' . "\n";
                    $JSC.= '"loan_repayements":"' . $bkpayroll['BkPayroll']['loans'] . '",' . "\n";
                    $JSC.= '"total_pf":"' . $bkpayroll['BkPayroll']['total_pf'] . '",' . "\n";
                    $JSC.= '"total_pension":"' . $bkpayroll['BkPayroll']['total_pension'] . '",' . "\n";
                    $JSC.= '"net_pay":"<b style=\'color:red\'>' . $bkpayroll['BkPayroll']['net_pay'] . '</b>",' . "\n";
                    $JSC.='},' . "\n";
                }
            }
        }

        $JSC.=']}';
        echo $JSC;
        //$this->set('JSC', $JSC);
        //print_r($report);
    }

	function calculateperdium($arrs,$emp_id){
					$txperd=0;
					$ntxperd=0;
                    foreach ($arrs as $arr) {
						if((date('Y-m')== date('Y-m',strtotime($arr['date']))) && $arr['employee_id']==$emp_id){
							
							$total+=($arr['days']*$arr['rate']);
							$txperd+=($arr['days']*$arr['rate'])-($arr['days']*$arr['taxable']);
							$ntxperd+=($arr['days']*$arr['rate'])-(($arr['days']*$arr['rate'])-($arr['days']*$arr['taxable']));
						}
					}

					$perd[0]=$ntxperd;
					$perd[1]=$txperd;
					
					return $perd;
	}
    function measure($sal, $amt, $measure, $payroll_id) {
        if ($measure == 'Gas') {
            $this->loadModel('Price');
            $conditions['Price.payroll_id'] = $payroll_id;
            $conditions['Price.status'] = 'active';
            $prc = $this->Price->find('all', array('conditions' => $conditions, 'order' => 'Price.date DESC'));
            return $amt * $prc[0]['Price']['gas'];
        } else if ($measure == 'Percentile') {
            return $sal * ($amt / 100);
        } else {
            return $amt;
        }
    }

    function calculate_benefits($arrs, $arremps, $emp_id, $grade_id, $tax, $salary, $payroll_id, $payroll_report = null, $save = false) {
        $sum[0] = 0;
        $sum[1] = 0;

        $daysofmonth = 30;
        if ($grade_id != 0) {//for grade benefits
            foreach ($arremps as $arremp) {
                $days = 0;
                if (date('Y-m', strtotime($arremp['start_date'])) < date('Y-m') && ($arremp['end_date'] == '0000-00-00' || date('Y-m', strtotime($arremp['end_date'])) > date('Y-m'))) {
                    $days = $daysofmonth;
                }
                if (date('Y-m', strtotime($arremp['start_date'])) == date('Y-m')) {
                    $start = strtotime($arremp['start_date']);
                    if ($arremp['end_date'] == '0000-00-00' || date('Y-m', strtotime($arremp['end_date'])) > date('Y-m'))
                        $end = strtotime(date('Y-m') . '-'.$daysofmonth);
                    else
                                $end = (strtotime(date('d',strtotime($arremp['end_date']))) >= date('t',strtotime($arremp['end_date'])) ? date('Y-m',strtotime($arremp['end_date'])).'-'.$daysofmonth : $arremp['end_date']);
                    $days = floor(abs($end - $start) / 86400);
                    $days++;
                }
                if (date('Y-m', strtotime($arremp['start_date'])) < date('Y-m') && date('Y-m', strtotime($arremp['end_date'])) == date('Y-m')) {
                    $end = strtotime($arremp['end_date']);
                    $start = strtotime(date('Y-m') . '-01');
                    $days = floor(abs($end - $start) / 86400);
                    $days++;
                }
                if ($days > 0) {
                    if ($days >= date('t'))
                        $days = $daysofmonth;

                    $fullsalary = $arremp['salary'];

                    $grade_id = $arremp['grade_id'];
                    foreach ($arrs as $arr) {
                        if ($arr['status'] == 'active') {
                            if ($arr['taxable'] == $tax) {
                                if (date('Y-m') >= date('Y-m', strtotime($arr['start_date'])) && (date('Y-m') <= date('Y-m', strtotime($arr['end_date'])) || $arr['end_date'] == '0000-00-00')) {
                                    if ($arr['grade_id'] == $grade_id) {
                                        $sumx = ($this->measure($fullsalary, $arr['amount'], $arr['Measurement'], $payroll_id) / $daysofmonth) * $days;
											$sumx=round($sumx,2);
                                        if ($save == 'true') {
                                            $this->data['BkBenefit']['benefit_id'] = $arr['id'];
                                            $this->data['BkBenefit']['payroll_report_id'] = $payroll_report;
                                            $this->data['BkBenefit']['employee_id'] = $emp_id;
                                            $this->data['BkBenefit']['divider'] = $daysofmonth;
                                            $this->data['BkBenefit']['days'] = $days;
                                            $this->data['BkBenefit']['amount'] = $sumx;
                                            //print_r( $this->data);
                                            $this->PayrollReport->BkBenefit->create();
                                            $this->PayrollReport->BkBenefit->save($this->data);
                                        }

                                        if ($arr['over'] > 0 && $sumx > $arr['over']) {
                                            $sumx = $sumx - $arr['over'];
                                            $sum[1] = $sum[1] + $arr['over'];
                                        }
                                        $sum[0] = $sum[0] + $sumx;
                                    }
                                }
                            }
                        }
                    }
                }
            }
        }
        if ($emp_id != 0 && $grade_id == 0) {//Benefits specific to employee
            foreach ($arrs as $arr) {
                if ($arr['status'] == 'active') {
                    if ($arr['taxable'] == $tax) {
                        if (date('Y-m') >= date('Y-m', strtotime($arr['start_date'])) && (date('Y-m') <= date('Y-m', strtotime($arr['end_date'])) || $arr['end_date'] == '0000-00-00')) {
                            if ($arr['employee_id'] == $emp_id) {
                                $sumx = $this->measure($salary, $arr['amount'], $arr['Measurement'], $payroll_id);
								$sumx=round($sumx,2);
                                if ($save == 'true') {
                                    $this->data['BkBenefit']['benefit_id'] = $arr['id'];
                                    $this->data['BkBenefit']['payroll_report_id'] = $payroll_report;
                                    $this->data['BkBenefit']['employee_id'] = $emp_id;
                                    $this->data['BkBenefit']['divider'] = 0;
                                    $this->data['BkBenefit']['days'] = 0;
                                    $this->data['BkBenefit']['amount'] = $sumx;
                                    //print_r( $this->data);
                                    $this->PayrollReport->BkBenefit->create();
                                    $this->PayrollReport->BkBenefit->save($this->data);
                                }

                                if ($arr['over'] > 0 && $sumx > $arr['over']) {
                                    $sumx = $sumx - $arr['over'];
                                    $sum[1] = $sum[1] + $arr['over'];
                                }
                                $sum[0] = $sum[0] + $sumx;
                            }
                        }
                    }
                }
            }
        }
        return $sum;
    }

    function calculate_deductions($arrs, $arremps, $emp_id, $grade_id, $gross, $salary, $payroll_id, $payroll_report = null, $save = false) {
        $sum = 0;
		$fixed_deds='';
        $daysofmonth = 30;
        if ($grade_id != 0) {//for grade benefits
            foreach ($arremps as $arremp) {
                $days = 0;
                if (date('Y-m', strtotime($arremp['start_date'])) < date('Y-m') && ($arremp['end_date'] == '0000-00-00' || date('Y-m', strtotime($arremp['end_date'])) > date('Y-m'))) {
                    $days = $daysofmonth;
                }
                if (date('Y-m', strtotime($arremp['start_date'])) == date('Y-m')) {
                    $start = strtotime($arremp['start_date']);
                    if ($arremp['end_date'] == '0000-00-00' || date('Y-m', strtotime($arremp['end_date'])) > date('Y-m'))
                        $end = strtotime(date('Y-m') . '-'.$daysofmonth);
                            else
                                $end = (strtotime(date('d',strtotime($arremp['end_date']))) >= date('t',strtotime($arremp['end_date'])) ? date('Y-m',strtotime($arremp['end_date'])).'-'.$daysofmonth : $arremp['end_date']);
                    $days = floor(abs($end - $start) / 86400);
                    $days++;
                }
                if (date('Y-m', strtotime($arremp['start_date'])) < date('Y-m') && date('Y-m', strtotime($arremp['end_date'])) == date('Y-m')) {
                    $end = strtotime($arremp['end_date']);
                    $start = strtotime(date('Y-m') . '-01');
                    $days = floor(abs($end - $start) / 86400);
                    $days++;
                }
                if ($days > 0) {
                    if ($days >= date('t'))
                        $days = $daysofmonth;

                    $fullsalary = $arremp['salary'];

                    $grade_id = $arremp['grade_id'];
                    foreach ($arrs as $arr) {
                        if ($arr['status'] == 'active') {
                            if (date('Y-m-d') >= date('Y-m-d', strtotime($arr['start_date'])) && (date('Y-m-d') <= date('Y-m-d', strtotime($arr['end_date'])) || $arr['end_date'] == '0000-00-00')) {
                                //if (date('m') >= date('m', strtotime($arr['start_date'])) && (date('m') <= date('m', strtotime($arr['end_date'])) || $arr['end_date'] == '0000-00-00')) {
                                if ($arr['grade_id'] == $grade_id) {

                                    if ($arr['Measurement'] == 'Birr') {
										if(strpos($fixed_deds,$arr['name'])===false){
                                        $sum = $sum + $arr['amount'];
                                        $sumx = $arr['amount'];
										$fixed_deds=$fixed_deds.' '.$arr['name'];
										}
                                    }
                                    if ($arr['Measurement'] == 'Percentile: Basic Salary') {
                                        $sum = $sum + (($fullsalary * $arr['amount'] / 100) / $daysofmonth) * $days;
                                        $sumx = (($fullsalary * $arr['amount'] / 100) / $daysofmonth) * $days;
                                    }
                                    if ($arr['Measurement'] == 'Percentile: Gross Salary') {
                                        $sum = $sum + ($gross * $arr['amount'] / 100);
                                        $sumx = ($gross * $arr['amount'] / 100);
                                    }
									$sum=round($sum,2);
									$sumx=round($sumx,2);
                                    if ($save == 'true') {
                                        $this->data2['BkDeduction']['deduction_id'] = $arr['id'];
                                        $this->data2['BkDeduction']['payroll_report_id'] = $payroll_report;
                                        $this->data2['BkDeduction']['employee_id'] = $emp_id;
                                        $this->data2['BkDeduction']['divider'] = $daysofmonth;
                                        $this->data2['BkDeduction']['days'] = $days;
                                        $this->data2['BkDeduction']['amount'] = $sumx;
                                        //print_r( $this->data2);
                                        $this->PayrollReport->BkDeduction->create();
                                        $this->PayrollReport->BkDeduction->save($this->data2);
                                    }
                                }
                                //}
                            }
                        }
                    }
                }
            }
        }
        if ($emp_id != 0 && $grade_id == 0) {//Deductions specific to employee
            foreach ($arrs as $arr) {
                if ($arr['status'] == 'active') {
                    if (date('Y-m-d') >= date('Y-m-d', strtotime($arr['start_date'])) && (date('Y-m-d') <= date('Y-m-d', strtotime($arr['end_date'])) || $arr['end_date'] == '0000-00-00')) {
                        //if (date('m') >= date('m', strtotime($arr['start_date'])) && (date('m') <= date('m', strtotime($arr['end_date'])) || $arr['end_date'] == '0000-00-00')) {
                        if ($arr['employee_id'] == $emp_id) {
                            if ($arr['Measurement'] == 'Birr') {
                                $sum = $sum + $arr['amount'];
                                $sumx = $arr['amount'];
                            }
                            if ($arr['Measurement'] == 'Percentile: Basic Salary') {
                                $sum = $sum + ($salary * $arr['amount'] / 100);
                                $sumx = ($salary * $arr['amount'] / 100);
                            }
                            if ($arr['Measurement'] == 'Percentile: Gross Salary') {
                                $sum = $sum + ($gross * $arr['amount'] / 100);
                                $sumx = ($gross * $arr['amount'] / 100);
                            }
							$sum=round($sum,2);
							$sumx=round($sumx,2);
                            if ($save == 'true') {
                                $this->data2['BkDeduction']['deduction_id'] = $arr['id'];
                                $this->data2['BkDeduction']['payroll_report_id'] = $payroll_report;
                                $this->data2['BkDeduction']['employee_id'] = $emp_id;
                                $this->data2['BkDeduction']['divider'] = 0;
                                $this->data2['BkDeduction']['days'] = 0;
                                $this->data2['BkDeduction']['amount'] = $sumx;
                                //print_r( $this->data2);
                                $this->PayrollReport->BkDeduction->create();
                                $this->PayrollReport->BkDeduction->save($this->data2);
                            }
                        }
                        //}
                    }
                }
            }
        }
        return $sum;
    }

    function calculate_tax($arrs, $salary) {
        foreach ($arrs as $arr) {
            if ($arr['status'] == 'active') {
                if ($salary >= $arr['min'] && $salary <= $arr['max']) {
                    return round(($salary * ($arr['percent'] / 100)) - $arr['deductable'],2);
                }
            }
        }
    }

    function calculate_loans($emp_id) {
        $sum = 0;
        $this->loadModel('Loan');
        $this->Loan->recursive = 1;
        $conditions['Loan.employee_id'] = $emp_id;
        $conditions['Loan.status'] = 'active';
        $loans = $this->Loan->find('all', array('conditions' => $conditions));
        foreach ($loans as $arr) {
            if (date('Y') >= date('Y', strtotime($arr['Loan']['start'])))
            //if (date('m') >= date('m', strtotime($arr['Loan']['start']))) {
                $date1 = $arr['Loan']['start'];

            $ts1 = strtotime($date1);

            $year1 = date('Y', $ts1);
            $year2 = date('Y');

            $month1 = date('m', $ts1);
            $month2 = date('m');

            $diff = (($year2 - $year1) * 12) + ($month2 - $month1);
            if ($diff < $arr['Loan']['no_months'] && $diff >= 0) {
                $sum = $sum + $arr['Loan']['Per_month'];
            }
            //}
        }
        return round($sum,2);
    }

    function calculate_pension($emp_id, $type, $salary) {
        $sum = 0;
        $this->loadModel('PensionEmployee');
        $pen = $this->PensionEmployee->findbyemployee_id($emp_id);

        if (isset($pen)) {
            if ($pen['Pension']['status'] == 'active') {
                if ($type == 'pf_total') {
                    $sum = ($salary * ($pen['Pension']['pf_staff'] / 100)) + ($salary * ($pen['Pension']['pf_company'] / 100));
                }
                if ($type == 'pension_total') {
                    $sum = ($salary * ($pen['Pension']['pen_staff'] / 100)) + ($salary * ($pen['Pension']['pen_company'] / 100));
                }
                if ($type == 'pf_staff') {
                    $sum = ($salary * ($pen['Pension']['pf_staff'] / 100));
                }
                if ($type == 'pension_staff') {
                    $sum = ($salary * ($pen['Pension']['pen_staff'] / 100));
                }
            }
        }
        return round($sum,2);
    }

    function add($id = null) {
        if (!empty($this->data)) {
            $this->PayrollReport->create();
            $this->autoRender = false;
            $this->data['PayrollReport']['maker_id'] = $this->Session->read('Auth.User.id');
            if ($this->PayrollReport->save($this->data)) {
                $this->Session->setFlash(__('The payroll report has been saved', true), '');
                $this->render('/elements/success');
            } else {
                $this->Session->setFlash(__('The payroll report could not be saved. Please, try again.', true), '');
                $this->render('/elements/failure');
            }
        }
        if ($id)
            $this->set('parent_id', $id);
        $payrolls = $this->PayrollReport->Payroll->find('list');
        $budget_years = $this->PayrollReport->BudgetYear->find('list');
        $this->set(compact('payrolls', 'budget_years'));
    }

    function send($id = null) {
        if (isset($this->data)) {
            $this->loadModel('Report');
            $report = $this->Report->read(null, 25);

            $id = $this->data['PayrollReport']['id'];
            $this->autoRender = false;
            $reportchk = $this->PayrollReport->read(null, $id);
            if ($reportchk['PayrollReport']['status'] == 'Approved' && $reportchk['PayrollReport']['sent'] == 'not_sent') {
                $conditions['PayrollReport.id'] = $id;
                $r_emps = $this->PayrollReport->find('all', array('conditions' => $conditions));

                $this->loadModel('BkPayroll');
                $this->BkPayroll->recursive = 0;
                $conditionsbk['BkPayroll.payroll_report_id'] = $r_emps[0]['PayrollReport']['id'];
                $bkpayrolls = $this->BkPayroll->find('all', array('conditions' => $conditionsbk));
                $i = 0;
                foreach ($bkpayrolls as $bkpayroll) {
                    $emp_id = $bkpayroll['BkPayroll']['employee_id'];
                    $this->loadModel('Employee');
                    $conditionsdvvc['Employee.id'] = $emp_id;
                    $this->Employee->recursive = 2;
                    $empdet = $this->Employee->find('all', array('conditions' => $conditionsdvvc));
                    $user_id = $empdet[0]['User']['id'];

                    if ($empdet[0]['User']['email'] != '') {
                        $email = $empdet[0]['User']['email'];
                        $payroll_report_id=$id;
						$employee_id=$emp_id;
                        eval($report['Report']['PHP']);
						
                        $output = $outreport;

                        $this->data['Email']['name'] = 'Your monthly payroll report for ' . date('M, Y', strtotime($r_emps[0]['PayrollReport']['date']));
                        $this->data['Email']['to'] = $email;
                        $this->data['Email']['from'] = 'abayerp@abaybank.com.et';
                        $this->data['Email']['from_name'] = 'AbayERP';
                        $this->data['Email']['body'] = $output;
                        $this->loadModel('Email');
                        $this->Email->create();
                        $this->Email->save($this->data);
                    }
                }
                $this->data2['PayrollReport']['id'] = $id;
                $this->data2['PayrollReport']['sent'] = 'sent';
                $this->PayrollReport->save($this->data2);
                $this->Session->setFlash(__('The payroll report has been Sent', true), '');
                $this->render('/elements/success');
            }else {
                $this->Session->setFlash(__('Payroll Report Not Approved Or Sent Already', true), '');
                $this->render('/elements/failure');
            }
        } else {
            if ($id) {
                $this->set('id', $id);
            }
        }
    }

	function open_report_payroll($payroll=null,$send=null){
	$this->autoRender = false;
	if($send!=null){
		$this->loadModel('PayrollReport');
	$query="SELECT `viewemployee`.`user_id` FROM `viewemployee`  JOIN `viewpayroll` USING (`Record Id`) WHERE `viewpayroll`.`Report Id`=".$payroll." ";
	$receipients=$this->PayrollReport->query($query);
	$receivers='';
		foreach($receipients as $receip){
		$receivers.=$receip['viewemployee']['user_id'].',';
		}
		$message='Dear Employee,xNewLinexPlease follow the link below to view your monthly payroll record.xNewLinexxNewLinex<a   href="http://10.1.85.11/AbayERP/payroll_reports/open_report_payroll/'.$payroll.'">Click to Open Payroll Report</a>';
		$message=urlencode($message);
		$subject='Payroll Report';
		
		$this->redirect(array('controller' => 'dms/dms_messages', 'action' => 'add_wz_param',$receivers,$subject,$message));
		//$this->render('../plugin/dms/DmsMessages/add_wz_param');
	}else{
		$this->autoRender = false;
		$employee=$this->Session->read('Auth.User.id');
		$this->loadModel('Employee');
		$this->Employee->recursive=-1;
		$employee=$this->Employee->find('first',array('conditions'=>array('Employee.user_id'=>$employee)));
		$url="http://10.1.85.253:8080/iportal/frameset?__report=C%3A%5CUsers%5CAdministrator%5CDocuments%5CWorkspace%5CAbay+Report%5CReport+Designs%5Cpayroll_summary.rptdesign&__format=html&__svg=true&__locale=en_US&__timezone=PST&__masterpage=true&__rtl=false&__cubememsize=10&__resourceFolder=C%3A%5CUsers%5CAdministrator%5CDocuments%5CWorkspace%5CAbay+Report&-340711965"."&payroll=".$payroll."&employee=".$employee['Employee']['id'];
		header("Location: ".$url); /* Redirect browser */
		exit();	
	}
	}
    function approve($id = null) {
        if (isset($this->data)) {
		$this->temppayroll($id);
            $id = $this->data['PayrollReport']['id'];
            $this->autoRender = false;
            $reportchk = $this->PayrollReport->read(null, $id);
            //print_r($report);
            if ($reportchk['PayrollReport']['status'] == 'Not Approved') {
                $this->loadModel('GroupsUser');
                $conditionsg['GroupsUser.group_id'] = '19';
                $conditionsg['GroupsUser.user_id'] = $this->Session->read('Auth.User.id');
                $perm = $this->GroupsUser->find('count', array('conditions' => $conditionsg));
                if ($perm > 0) {

                    $this->PayrollReport->recursive = 2; // always 5
                    $report = $this->PayrollReport->read(null, $id);
                    $payroll_id = $report['PayrollReport']['payroll_id'];
                    //print_r($report['Payroll']['PayrollEmployee']);

                    foreach ($report['Payroll']['PayrollEmployee'] as $employees) {
                        //if (!empty($employees['Employee'])) {
                        if ($employees['status'] == 'active') {
                            $emp_id = $employees['employee_id'];

                            $this->loadModel('Employee');
                            $conditionsd['Employee.id'] = $emp_id;
                            $this->Employee->recursive = 1;
                            $empdet = $this->Employee->find('all', array('conditions' => $conditionsd));
							if (!empty($empdet[0]['Employee']) && !empty($empdet[0]['User'])) {
                            $arremps = $empdet[0]['EmployeeDetail'];
                            $this->array_sort_by_column($arremps, "start_date", SORT_DESC);
                            $daysofmonth = 30;
                            $salary = 0;
                            foreach ($arremps as $arremp) {
                                $days = 0;
                                if (date('Y-m', strtotime($arremp['start_date'])) < date('Y-m') && ($arremp['end_date'] == '0000-00-00' || date('Y-m', strtotime($arremp['end_date'])) > date('Y-m'))) {
                                    $days = $daysofmonth;
                                }
                                if (date('Y-m', strtotime($arremp['start_date'])) == date('Y-m')) {
                                    $start = strtotime($arremp['start_date']);
                                    if ($arremp['end_date'] == '0000-00-00' || date('Y-m', strtotime($arremp['end_date'])) > date('Y-m'))
                                        $end = strtotime(date('Y-m') . '-'.$daysofmonth);
                            else
                                $end = (strtotime(date('d',strtotime($arremp['end_date']))) >= date('t',strtotime($arremp['end_date'])) ? date('Y-m',strtotime($arremp['end_date'])).'-'.$daysofmonth : $arremp['end_date']);
                                    $days = floor(abs($end - $start) / 86400);
                                    $days++;
                                }
                                if (date('Y-m', strtotime($arremp['start_date'])) < date('Y-m') && date('Y-m', strtotime($arremp['end_date'])) == date('Y-m')) {
                                    $end = strtotime($arremp['end_date']);
                                    $start = strtotime(date('Y-m') . '-01');
                                    $days = floor(abs($end - $start) / 86400);
                                    $days++;
                                }
                                if ($days > 0) {
                                    if ($days >= date('t'))
                                        $days = $daysofmonth;
                                    $fullsal = $arremp['salary'];
                                    $ssalary = ($arremp['salary'] / $daysofmonth) * $days;
                                    $salary = $salary + $ssalary;
                                }
                            }
							$salary=round($salary,2);
                            $arrs = $report['Payroll']['Benefit'];
                            $be = $this->calculate_benefits($arrs, $arremps, $emp_id, 0, 0, $salary, $payroll_id, $id, true);
                            $bg = $this->calculate_benefits($arrs, $arremps, $emp_id, $grade_id = 1, 0, $salary, $payroll_id, $id, true);
                            $tbe = $this->calculate_benefits($arrs, $arremps, $emp_id, 0, 1, $salary, $payroll_id, $id, true);
                            $tbg = $this->calculate_benefits($arrs, $arremps, $emp_id, $grade_id = 1, 1, $salary, $payroll_id, $id, true);
							$perd=$this->calculateperdium($report['Payroll']['Perrdiemm'],$emp_id);
                            //backup Benefits
                            $gross = $salary + $be[0] + $bg[0] + $tbe[0] + $tbg[0];
                            //backup deductions
                            $arr2 = $report['Payroll']['Deduction'];
                            $sdg = $this->calculate_deductions($arr2, $arremps, $emp_id, 0, $gross, $salary, $payroll_id, $id, true);
                            $gdg = $this->calculate_deductions($arr2, $arremps, $emp_id, $grade_id = 1, $gross, $salary, $payroll_id, $id, true);
                            //Backup Tax rules
                            $arr3 = $report['Payroll']['TaxRule'];
                            foreach ($arr3 as $arr) {
                                if ($arr['status'] == 'active') {
                                    if ($salary >= $arr['min'] && $salary <= $arr['max']) {
                                        $this->data3['BkTaxrule']['tax_rule_id'] = $arr['id'];
                                        $this->data3['BkTaxrule']['payroll_report_id'] = $id;
                                        $this->data3['BkTaxrule']['employee_id'] = $emp_id;
                                        //print_r( $this->data3);
                                        $this->PayrollReport->BkTaxrule->create();
                                        $this->PayrollReport->BkTaxrule->save($this->data3);
                                    }
                                }
                            }
                            //backup pension
                            $this->loadModel('PensionEmployee');
                            $pen = $this->PensionEmployee->findbyemployee_id($emp_id);
                            $this->data4['BkPension']['pension_id'] = $pen['Pension']['id'];
                            $this->data4['BkPension']['payroll_report_id'] = $id;
                            $this->data4['BkPension']['employee_id'] = $emp_id;
                            //print_r($this->data4);
                            $this->PayrollReport->BkPension->create();
                            $this->PayrollReport->BkPension->save($this->data4);
                            //backup loan
                            $this->loadModel('Loan');
                            $this->Loan->recursive = 1;
                            $conditionsl['Loan.employee_id'] = $emp_id;
                            $conditionsl['Loan.status'] = 'active';
                            $loans = $this->Loan->find('all', array('conditions' => $conditionsl));
                            if (!empty($loans))
                                foreach ($loans as $arr) {
                                    if (date('Y') >= date('Y', strtotime($arr['Loan']['start'])))
                                    // if (date('m') >= date('m', strtotime($arr['Loan']['start']))) {
                                        $date1 = $arr['Loan']['start'];

                                    $ts1 = strtotime($date1);

                                    $year1 = date('Y', $ts1);
                                    $year2 = date('Y');

                                    $month1 = date('m', $ts1);
                                    $month2 = date('m');

                                    $diff = (($year2 - $year1) * 12) + ($month2 - $month1);
                                    if ($diff < $arr['Loan']['no_months']) {
                                        $this->data5['BkLoan']['loan_id'] = $arr['Loan']['id'];
                                        $this->data5['BkLoan']['payroll_report_id'] = $id;
                                        $this->data5['BkLoan']['employee_id'] = $emp_id;
                                        //print_r($this->data4);
                                        $this->PayrollReport->BkLoan->create();
                                        $this->PayrollReport->BkLoan->save($this->data5);
                                    }
                                    // }
                                }
                        }
                        }// don't check if employee is not empty
                    }
                    //backup gas prices
                    $this->loadModel('Price');
                    $conditions2['Price.payroll_id'] = $payroll_id;
                    $conditions2['Price.status'] = 'active';
                    $prc = $this->Price->find('all', array('conditions' => $conditions2, 'order' => 'Price.date DESC'));
                    $this->data6['BkPrice']['price_id'] = $prc[0]['Price']['id'];
                    $this->data6['BkPrice']['payroll_report_id'] = $id;
                    //print_r($this->data4);
                    $this->PayrollReport->BkPrice->create();
                    $this->PayrollReport->BkPrice->save($this->data6);

                    foreach ($report['Payroll']['PayrollEmployee'] as $employees) {
                        // if (!empty($employees['Employee'])) {
                        if ($employees['status'] == 'active') {
                            $emp_id = $employees['employee_id'];

                            $this->loadModel('Employee');
                            $conditionsd['Employee.id'] = $emp_id;
                            $this->Employee->recursive = 1;
                            $empdet = $this->Employee->find('all', array('conditions' => $conditionsd));

                            $arremps = $empdet[0]['EmployeeDetail'];
                            $this->array_sort_by_column($arremps, "start_date", SORT_DESC);
                            $daysofmonth = 30;
                            $salary = 0;

                            foreach ($arremps as $arremp) {
                                $days = 0;
                                if (date('Y-m', strtotime($arremp['start_date'])) < date('Y-m') && ($arremp['end_date'] == '0000-00-00' || date('Y-m', strtotime($arremp['end_date'])) > date('Y-m'))) {
                                    $days = $daysofmonth;
                                }
                                if (date('Y-m', strtotime($arremp['start_date'])) == date('Y-m')) {
                                    $start = strtotime($arremp['start_date']);
                                    if ($arremp['end_date'] == '0000-00-00' || date('Y-m', strtotime($arremp['end_date'])) > date('Y-m'))
                                         $end = strtotime(date('Y-m') . '-'.$daysofmonth);
                            else
                                $end = (strtotime(date('d',strtotime($arremp['end_date']))) >= date('t',strtotime($arremp['end_date'])) ? date('Y-m',strtotime($arremp['end_date'])).'-'.$daysofmonth : $arremp['end_date']);
                                    $days = floor(abs($end - $start) / 86400);
                                    $days++;
                                }
                                if (date('Y-m', strtotime($arremp['start_date'])) < date('Y-m') && date('Y-m', strtotime($arremp['end_date'])) == date('Y-m')) {
                                    $end = strtotime($arremp['end_date']);
                                    $start = strtotime(date('Y-m') . '-01');
                                    $days = floor(abs($end - $start) / 86400);
                                    $days++;
                                }
                                if ($days > 0) {
                                    if ($days >= date('t'))
                                        $days = $daysofmonth;
                                    $fullsal = $arremp['salary'];
                                    $ssalary = ($arremp['salary'] / $daysofmonth) * $days;
                                    $salary = $salary + $ssalary;
                                }
                            }
							$salary=round($salary,2);

                            $be = $this->calculate_benefits($report['Payroll']['Benefit'], $arremps, $emp_id, 0, 0, $salary, $payroll_id);
                            $bg = $this->calculate_benefits($report['Payroll']['Benefit'], $arremps, 0, $grade_id = 1, 0, $salary, $payroll_id);
                            $tbe = $this->calculate_benefits($report['Payroll']['Benefit'], $arremps, $emp_id, 0, 1, $salary, $payroll_id);
                            if ($tbe[1] > 0)
                                $be[0] = $be[0] + $tbe[1];
                            $tbg = $this->calculate_benefits($report['Payroll']['Benefit'], $arremps, 0, $grade_id = 1, 1, $salary, $payroll_id);
                            if ($tbg[1] > 0)
                                $bg[0] = $bg[0] + $tbg[1];
							$perd=$this->calculateperdium($report['Payroll']['Perrdiemm'],$emp_id);
                            $gross = $salary + $be[0] + $bg[0] + $tbe[0] + $tbg[0] ;
                            $sdg = $this->calculate_deductions($report['Payroll']['Deduction'], $arremps, $emp_id, 0, $gross, $salary, $payroll_id);
                            $gdg = $this->calculate_deductions($report['Payroll']['Deduction'], $arremps, 0, $grade_id = 1, $gross, $salary, $payroll_id);
                            $taxable_income = $salary + $tbe[0] + $tbg[0] + $perd[1];
                            $cloans = $this->calculate_loans($emp_id);
                            $ict = $this->calculate_tax($report['Payroll']['TaxRule'], $taxable_income);
                            $pf = $this->calculate_pension($emp_id, 'pf_staff', $salary);
                            $pension = $this->calculate_pension($emp_id, 'pension_staff', $salary);
                            $pf_pn_dedc = $this->calculate_pension($emp_id, 'pension_staff', $salary) + $this->calculate_pension($emp_id, 'pf_staff', $salary);
                            $tot_dedc = $sdg + $gdg + $pf_pn_dedc;
                            $net = $gross - $ict - $tot_dedc - $cloans;

                            $this->datapy['BkPayroll']['basic_salary'] = $salary;
                            $this->datapy['BkPayroll']['account_no'] = $employees['account_no'];
                            $this->datapy['BkPayroll']['pf_account_no'] = $employees['pf_account_no'];
                            $this->datapy['BkPayroll']['employee_id'] = $emp_id;
                            $this->datapy['BkPayroll']['gross_pay'] = $gross;
                            $this->datapy['BkPayroll']['net_pay'] = $net;
                            $this->datapy['BkPayroll']['taxable_benefit'] = $tbe[0] + $tbg[0] + $perd[1];
                            $this->datapy['BkPayroll']['non_taxable_benefit'] = $be[0] + $bg[0] ;
                            $this->datapy['BkPayroll']['income_tax'] = $ict;
                            $this->datapy['BkPayroll']['total_pf'] = $pf;
                            $this->datapy['BkPayroll']['total_pension'] = $pension;
                            $this->datapy['BkPayroll']['deductions'] = $tot_dedc;
                            $this->datapy['BkPayroll']['loans'] = $cloans;
                            $this->datapy['BkPayroll']['payroll_id'] = $payroll_id;
                            $this->datapy['BkPayroll']['payroll_report_id'] = $id;
                            $this->PayrollReport->BkPayroll->create();
                            $this->PayrollReport->BkPayroll->save($this->datapy);
                        }
                        //}
                    }


                    //change status of payroll
                    $this->datar['PayrollReport']['checker_id'] = $this->Session->read('Auth.User.id');
                    $this->datar['PayrollReport']['status'] = 'Approved';
                    $this->PayrollReport->save($this->datar);

                    $this->Session->setFlash(__('The payroll report has been Approved', true), '');
                    $this->render('/elements/success');
                }else {
                    $this->Session->setFlash(__('You dont have the permission to approve the payroll', true), '');
                    $this->render('/elements/failure');
                }
            } else {
                $this->Session->setFlash(__('Payroll Already Approved', true), '');
                $this->render('/elements/failure');
            }
        } else {
            if ($id) {
                $this->set('id', $id);
            }
        }
    }

    function edit($id = null, $parent_id = null) {
        if (!$id && empty($this->data)) {
            $this->Session->setFlash(__('Invalid payroll report', true), '');
            $this->redirect(array('action' => 'index'));
        }
        if (!empty($this->data)) {
            $this->autoRender = false;
            if ($this->PayrollReport->save($this->data)) {
                $this->Session->setFlash(__('The payroll report has been saved', true), '');
                $this->render('/elements/success');
            } else {
                $this->Session->setFlash(__('The payroll report could not be saved. Please, try again.', true), '');
                $this->render('/elements/failure');
            }
        }
        $this->set('payroll__report', $this->PayrollReport->read(null, $id));

        if ($parent_id) {
            $this->set('parent_id', $parent_id);
        }

        $payrolls = $this->PayrollReport->Payroll->find('list');
        $budget_years = $this->PayrollReport->BudgetYear->find('list');
        $this->set(compact('payrolls', 'budget_years'));
    }

    function delete($id = null) {
        $this->autoRender = false;
        if (!$id) {
            $this->Session->setFlash(__('Invalid id for payroll report', true), '');
            $this->render('/elements/failure');
        }
        if (stripos($id, '_') !== false) {
            $ids = explode('_', $id);
            try {
                foreach ($ids as $i) {
                    $this->PayrollReport->delete($i);
                }
                $this->Session->setFlash(__('Payroll report deleted', true), '');
                $this->render('/elements/success');
            } catch (Exception $e) {
                $this->Session->setFlash(__('Payroll report was not deleted', true), '');
                $this->render('/elements/failure');
            }
        } else {
            $reportchk = $this->PayrollReport->read(null, $id);
            //print_r($report);
            if ($reportchk['PayrollReport']['status'] == 'Approved') {
                $this->Session->setFlash(__('Payroll can not be deleted after being approved', true), '');
                $this->render('/elements/failure');
            } else {
                if ($this->PayrollReport->delete($id)) {
                    $this->Session->setFlash(__('Payroll report deleted', true), '');
                    $this->render('/elements/success');
                } else {
                    $this->Session->setFlash(__('Payroll report was not deleted', true), '');
                    $this->render('/elements/failure');
                }
            }
        }
    }

}

?>