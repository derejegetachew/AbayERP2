<?php

class ReportTestController extends AppController {

    var $name = 'Reports';

    function index($id = null) {
        $this->autoRender = false;
        $results;

        //put code below
              $conditions['YEAR(PayrollReport.date)'] = date('Y', strtotime($this->data['field']['date']));
        $conditions['MONTH(PayrollReport.date)'] = date('m', strtotime($this->data['field']['date']));
        $conditions['PayrollReport.status'] = 'Approved';
        $conditions['PayrollReport.payroll_id'] = $this->data['field']['payroll'];
        $this->loadModel('PayrollReport');
        $r_emps = $this->PayrollReport->find('all', array('conditions' => $conditions));
//print_r($r_emps);
        if (!empty($r_emps)) {
            $this->loadModel('BkPayroll');
            $this->BkPayroll->recursive = 0;
            $conditionsbk['BkPayroll.payroll_report_id'] = $r_emps[0]['PayrollReport']['id'];
            $bkpayrolls = $this->BkPayroll->find('all', array('conditions' => $conditionsbk));
            $i = 0;
            //FOr Managerial Staff
            foreach ($bkpayrolls as $bkpayroll) {
                $emp_id = $bkpayroll['BkPayroll']['employee_id'];
                $this->loadModel('Employee');
                $conditionsd['Employee.id'] = $emp_id;
                $this->Employee->recursive = 2;
                $empdet = $this->Employee->find('all', array('conditions' => $conditionsd));
                $empdetxs = $empdet[0]['EmployeeDetail'];
                if (!empty($empdet[0]['Employee']) && !empty($empdet[0]['User'])) {
                    foreach ($empdetxs as $empdetx) {
                        if (date('Y-m', strtotime($empdetx['start_date'])) <= ($empdetx['end_date'] == '0000-00-00' || date('Y-m', strtotime($this->data['field']['date'])) && date('Y-m', strtotime($empdetx['end_date'])) >= date('Y-m', strtotime($this->data['field']['date']))))
                            if ($empdetx['Position']['is_managerial'] == 1) {

                                $fullname = $empdet[0]['User']['Person']['first_name'] . ' ' . $empdet[0]['User']['Person']['middle_name'];
                                $results[$i][0] = $i + 1;
                                $results[$i][1] = $fullname;
                                $results[$i][2] = $bkpayroll['BkPayroll']['account_no'];
                                $results[$i][3] = $bkpayroll['BkPayroll']['basic_salary'];

                                $this->loadModel('BkBenefit');
                                $this->BkBenefit->recursive = 0;
                                $conditionsbnk['BkBenefit.payroll_report_id'] = $r_emps[0]['PayrollReport']['id'];
                                $conditionsbnk['BkBenefit.employee_id'] = $emp_id;
                                $bkbens = $this->BkBenefit->find('all', array('conditions' => $conditionsbnk));
                                $sumtra = 0;
                                $sumtraf = 0;
                                $sumtrafx = 0;
                                $sumtrax = 0;
                                $sumhou = 0;
                                $sumrep = 0; $sumrepx = 0;
                                $sumind = 0;
                                $sumtel = 0;
                                $sumoth = 0;
                                foreach ($bkbens as $bkben) {

                                    $this->loadModel('Benefit');
                                    $conditionsbn['Benefit.id'] = $bkben['BkBenefit']['benefit_id'];
                                    $empdetb = $this->Benefit->find('all', array('conditions' => $conditionsbn));

                                    if ($empdetb[0]['Benefit']['name'] == 'Transport Allowance' || $empdetb[0]['Benefit']['name'] == 'Additional Transport Allowance' || $empdetb[0]['Benefit']['name'] == 'IT Transportation') {
                                        if ($empdetb[0]['Benefit']['Measurement'] == 'Birr')
                                            $sumtra = $sumtra + $bkben['BkBenefit']['amount'];
                                        if ($empdetb[0]['Benefit']['Measurement'] == 'Gas') {
                                            $sumtraf = $sumtraf + $bkben['BkBenefit']['amount'];
                                            if ($sumtraf > 1000) {
                                                $sumtrafx = $sumtraf - 1000;
                                            }
                                            if ($sumtra > 1000)
                                                $sumtrax = $sumtra - 1000;
                                        }
                                    }
                                    if ($empdetb[0]['Benefit']['name'] == 'Housing Allowance')
                                        $sumhou = $sumhou + $bkben['BkBenefit']['amount'];
                                    if ($empdetb[0]['Benefit']['name'] == 'Representation Allowance')
                                        $sumrep = $sumrep + $bkben['BkBenefit']['amount'];
                                    if ($empdetb[0]['Benefit']['name'] == 'Taxable Representation Allowance')
                                        $sumrep = $sumrep + $bkben['BkBenefit']['amount'];
                                    if ($empdetb[0]['Benefit']['name'] == 'Cash Indeminity')
                                        $sumind = $sumind + $bkben['BkBenefit']['amount'];
                                    if ($empdetb[0]['Benefit']['name'] == 'Telephone Allowance')
                                        $sumtel = $sumtel + $bkben['BkBenefit']['amount'];
                                    if ($empdetb[0]['Benefit']['name'] == 'Other Benefits')
                                        $sumoth = $sumoth + $bkben['BkBenefit']['amount'];
                                }
                                $results[$i][4] = $sumtraf;
                                $results[$i][5] = $sumtra;
                                $results[$i][6] = $sumhou;
                                $results[$i][7] = $sumrep;
                                $results[$i][8] = $sumrepx;
                                $results[$i][9] = $sumtrafx;
                                $results[$i][10] = $sumtrax;
                                $results[$i][11] = $sumind;
                                $results[$i][12] = $results[$i][3] + $sumhou + $results[$i][8] + $sumtrafx + $sumtrax + $sumind; //total taxable income
                                $results[$i][13] = $sumtel;
                                $results[$i][14] = $sumoth;
                                $results[$i][15] = $sumtel + $sumoth;
                                $results[$i][16] = $bkpayroll['BkPayroll']['gross_pay'];
                                $results[$i][17] = $bkpayroll['BkPayroll']['income_tax'];

                                $this->loadModel('BkPension');
                                $this->BkPension->recursive = 0;
                                $conditionspenk['BkPension.payroll_report_id'] = $r_emps[0]['PayrollReport']['id'];
                                $conditionspenk['BkPension.employee_id'] = $emp_id;
                                $bkpens = $this->BkPension->find('all', array('conditions' => $conditionspenk));

                                $this->loadModel('Pension');
                                $conditionspen['Pension.id'] = $bkpens[0]['BkPension']['pension_id'];
                                $emppen = $this->Pension->find('all', array('conditions' => $conditionspen));

                                if ($emppen[0]['Pension']['pf_staff'] == 8)
                                    $results[$i][18] = $bkpayroll['BkPayroll']['basic_salary'] * 0.08;
                                if ($emppen[0]['Pension']['pf_staff'] == 1)
                                    $results[$i][19] = $bkpayroll['BkPayroll']['basic_salary'] * 0.01;
                                if ($emppen[0]['Pension']['pen_staff'] == 1)
                                    $results[$i][20] = $bkpayroll['BkPayroll']['basic_salary'] * 0.07;
                                if ($emppen[0]['Pension']['pf_company'] == 12)
                                    $pfca = $bkpayroll['BkPayroll']['basic_salary'] * 0.12;
                                if ($emppen[0]['Pension']['pf_company'] == 3)
                                    $pfcb = $bkpayroll['BkPayroll']['basic_salary'] * 0.03;
                                if ($emppen[0]['Pension']['pen_company'] == 9)
                                    $pnc = $bkpayroll['BkPayroll']['basic_salary'] * 0.09;

                                $this->loadModel('BkDeduction');
                                $this->BkDeduction->recursive = 0;
                                $conditionsddk['BkDeduction.payroll_report_id'] = $r_emps[0]['PayrollReport']['id'];
                                $conditionsddk['BkDeduction.employee_id'] = $emp_id;
                                $bkdeds = $this->BkDeduction->find('all', array('conditions' => $conditionsddk));
                                $sumaga = 0;
                                $sumcos = 0;
                                $sumsoc = 0;
                                foreach ($bkdeds as $bkded) {

                                    $this->loadModel('Deduction');
                                    $conditionsde['Deduction.id'] = $bkded['BkDeduction']['deduction_id'];
                                    $deds = $this->Deduction->find('all', array('conditions' => $conditionsde));
                                 
                                        if ($deds[0]['Deduction']['name'] == 'Agar children Aid')
                                            $sumaga = $sumaga + $bkded['BkDeduction']['amount'];
                                        if ($deds[0]['Deduction']['name'] == 'Social contribution')
                                            $sumsoc = $sumsoc + $bkded['BkDeduction']['amount'];
                                        if ($deds[0]['Deduction']['name'] == 'Cost Sharing')
                                            $sumcos = $sumcos + $bkded['BkDeduction']['amount'];
                                    
                                }
                                $results[$i][21] = $sumaga;
                                $results[$i][22] = $sumcos;
                                $results[$i][23] = $sumsoc;


                                $this->loadModel('BkLoan');
                                $this->BkLoan->recursive = 0;
                                $conditionslnk['BkLoan.payroll_report_id'] = $r_emps[0]['PayrollReport']['id'];
                                $conditionslnk['BkLoan.employee_id'] = $emp_id;
                                $bklns = $this->BkLoan->find('all', array('conditions' => $conditionslnk));

                                $sumh = 0;
                                $sumcar = 0;
                                $sumem = 0;
                                $sumper = 0;
                                foreach ($bklns as $bkln) {

                                    $this->loadModel('Loan');
                                    $conditionsln['Loan.id'] = $bkln['BkLoan']['loan_id'];
                                    $r_lins = $this->Loan->find('all', array('conditions' => $conditionsln));

                                    if ($r_lins[0]['Loan']['Type'] == 'House Loan')
                                        $sumh = $sumh + $r_lins[0]['Loan']['Per_month'];

                                    if ($r_lins[0]['Loan']['Type'] == 'Car Loan')
                                        $sumcar = $sumcar + $r_lins[0]['Loan']['Per_month'];

                                    if ($r_lins[0]['Loan']['Type'] == 'Emergency Loan')
                                        $sumem = $sumem + $r_lins[0]['Loan']['Per_month'];

                                    if ($r_lins[0]['Loan']['Type'] == 'Personal Loan')
                                        $sumper = $sumper + $r_lins[0]['Loan']['Per_month'];
                                }
                                $results[$i][24] = $sumh;
                                $results[$i][25] = $sumcar;
                                $results[$i][26] = $sumem;
                                $results[$i][27] = $sumper;
                                //total deduction
                                $results[$i][28] = $results[$i][17] + $results[$i][18] + $results[$i][19] + $results[$i][20] + $results[$i][21] + $results[$i][22] + $results[$i][23] + $results[$i][24];
                                $results[$i][28] = $results[$i][28] + $results[$i][25] + $results[$i][26] + $results[$i][27];

                                $results[$i][29] = $pfca;
                                $results[$i][30] = $pfcb;
                                $results[$i][31] = $pnc;
                                $results[$i][32] = $bkpayroll['BkPayroll']['pf_account_no'];
                                $results[$i][33] = $results[$i][18] + $results[$i][19] + $results[$i][29] + $results[$i][30];
                                $results[$i][34] = $results[$i][20] + $results[$i][31];
                                $results[$i][35] = $bkpayroll['BkPayroll']['net_pay'];

                                $g3 = $g3 + $results[$i][3];
                                $g4 = $g4 + $results[$i][4];
                                $g5 = $g5 + $results[$i][5];
                                $g6 = $g6 + $results[$i][6];
                                $g7 = $g7 + $results[$i][7];
                                $g8 = $g8 + $results[$i][8];
                                $g9 = $g9 + $results[$i][9];
                                $g10 = $g10 + $results[$i][10];
                                $g11 = $g11 + $results[$i][11];
                                $g12 = $g12 + $results[$i][12];
                                $g13 = $g13 + $results[$i][13];
                                $g14 = $g14 + $results[$i][14];
                                $g15 = $g115 + $results[$i][15];
                                $g16 = $g16 + $results[$i][16];
                                $g17 = $g17 + $results[$i][17];
                                $g18 = $g18 + $results[$i][18];
                                $g19 = $g19 + $results[$i][19];
                                $g20 = $g20 + $results[$i][20];
                                $g21 = $g21 + $results[$i][21];
                                $g22 = $g22 + $results[$i][22];
                                $g23 = $g23 + $results[$i][23];
                                $g24 = $g24 + $results[$i][24];
                                $g25 = $g25 + $results[$i][25];
                                $g26 = $g26 + $results[$i][26];
                                $g27 = $g27 + $results[$i][27];
                                $g28 = $g28 + $results[$i][28];
                                $g29 = $g29 + $results[$i][29];
                                $g30 = $g30 + $results[$i][30];
                                $g31 = $g31 + $results[$i][31];
                                $g32 = $g32 + $results[$i][32];
                                $g33 = $g33 + $results[$i][33];
                                $g34 = $g34 + $results[$i][34];
                                $g35 = $g35 + $results[$i][35];

                                //sub total
                                $gs3 = $gs3 + $results[$i][3];
                                $gs4 = $gs4 + $results[$i][4];
                                $gs5 = $gs5 + $results[$i][5];
                                $gs6 = $gs6 + $results[$i][6];
                                $gs7 = $gs7 + $results[$i][7];
                                $gs8 = $gs8 + $results[$i][8];
                                $gs9 = $gs9 + $results[$i][9];
                                $gs10 = $gs10 + $results[$i][10];
                                $gs11 = $gs11 + $results[$i][11];
                                $gs12 = $gs12 + $results[$i][12];
                                $gs13 = $gs13 + $results[$i][13];
                                $gs14 = $gs14 + $results[$i][14];
                                $gs15 = $gs115 + $results[$i][15];
                                $gs16 = $gs16 + $results[$i][16];
                                $gs17 = $gs17 + $results[$i][17];
                                $gs18 = $gs18 + $results[$i][18];
                                $gs19 = $gs19 + $results[$i][19];
                                $gs20 = $gs20 + $results[$i][20];
                                $gs21 = $gs21 + $results[$i][21];
                                $gs22 = $gs22 + $results[$i][22];
                                $gs23 = $gs23 + $results[$i][23];
                                $gs24 = $gs24 + $results[$i][24];
                                $gs25 = $gs25 + $results[$i][25];
                                $gs26 = $gs26 + $results[$i][26];
                                $gs27 = $gs27 + $results[$i][27];
                                $gs28 = $gs28 + $results[$i][28];
                                $gs29 = $gs29 + $results[$i][29];
                                $gs30 = $gs30 + $results[$i][30];
                                $gs31 = $gs31 + $results[$i][31];
                                $gs32 = $gs32 + $results[$i][32];
                                $gs33 = $gs33 + $results[$i][33];
                                $gs34 = $gs34 + $results[$i][34];
                                $gs35 = $gs35 + $results[$i][35];

                                $i++;
                            }
                    }
                }
            }
            
            $results[$i + 1][1] = 'Sub Total';
            $results[$i + 1][3] = $gs3;
            $results[$i + 1][4] = $gs4;
            $results[$i + 1][5] = $gs5;
            $results[$i + 1][6] = $gs6;
            $results[$i + 1][7] = $gs7;
            $results[$i + 1][8] = $gs8;
            $results[$i + 1][9] = $gs9;
            $results[$i + 1][10] = $gs10;
            $results[$i + 1][11] = $gs11;
            $results[$i + 1][12] = $gs12;
            $results[$i + 1][13] = $gs13;
            $results[$i + 1][14] = $gs14;
            $results[$i + 1][15] = $gs15;
            $results[$i + 1][16] = $gs16;
            $results[$i + 1][17] = $gs17;
            $results[$i + 1][18] = $gs18;
            $results[$i + 1][19] = $gs19;
            $results[$i + 1][20] = $gs20;
            $results[$i + 1][21] = $gs21;
            $results[$i + 1][22] = $gs22;
            $results[$i + 1][23] = $gs23;
            $results[$i + 1][24] = $gs24;
            $results[$i + 1][25] = $gs25;
            $results[$i + 1][26] = $gs26;
            $results[$i + 1][27] = $gs27;
            $results[$i + 1][28] = $gs28;
            $results[$i + 1][29] = $gs29;
            $results[$i + 1][30] = $gs30;
            $results[$i + 1][31] = $gs31;
            $results[$i + 1][32] = $gs32;
            $results[$i + 1][33] = $gs33;
            $results[$i + 1][34] = $gs34;
            $results[$i + 1][35] = $gs35;
            $i++;$i++;
            //for other STAFFS

            foreach ($bkpayrolls as $bkpayroll) {
                $emp_id = $bkpayroll['BkPayroll']['employee_id'];
                $this->loadModel('Employee');
                $conditionsd['Employee.id'] = $emp_id;
                $this->Employee->recursive = 2;
                $empdet = $this->Employee->find('all', array('conditions' => $conditionsd));
                $empdetxs = $empdet[0]['EmployeeDetail'];
                if (!empty($empdet[0]['Employee']) && !empty($empdet[0]['User'])) {
                    foreach ($empdetxs as $empdetx) {
                        if (date('Y-m', strtotime($empdetx['start_date'])) <= ($empdetx['end_date'] == '0000-00-00' || date('Y-m', strtotime($this->data['field']['date'])) && date('Y-m', strtotime($empdetx['end_date'])) >= date('Y-m', strtotime($this->data['field']['date']))))
                            if ($empdetx['Position']['is_managerial'] != 1) {

                                $fullname = $empdet[0]['User']['Person']['first_name'] . ' ' . $empdet[0]['User']['Person']['middle_name'];
                                $results[$i][0] = $i - 1;
                                $results[$i][1] = $fullname;
                                $results[$i][2] = $bkpayroll['BkPayroll']['account_no'];
                                $results[$i][3] = $bkpayroll['BkPayroll']['basic_salary'];

                                $this->loadModel('BkBenefit');
                                $this->BkBenefit->recursive = 0;
                                $conditionsbnk['BkBenefit.payroll_report_id'] = $r_emps[0]['PayrollReport']['id'];
                                $conditionsbnk['BkBenefit.employee_id'] = $emp_id;
                                $bkbens = $this->BkBenefit->find('all', array('conditions' => $conditionsbnk));
                                $sumtra = 0;
                                $sumtraf = 0;
                                $sumtrafx = 0;
                                $sumtrax = 0;
                                $sumhou = 0;
                                $sumrep = 0;
                                $sumind = 0;
                                $sumtel = 0;
                                $sumoth = 0;
                                
                                foreach ($bkbens as $bkben) {
 if($bkben['BkBenefit']['divider']==0 && $bkben['BkBenefit']['days']==0){
                        $bkben['BkBenefit']['divider']=30;$bkben['BkBenefit']['days']=30;}
                                    $this->loadModel('Benefit');
                                    $conditionsbn['Benefit.id'] = $bkben['BkBenefit']['benefit_id'];
                                    $empdetb = $this->Benefit->find('all', array('conditions' => $conditionsbn));

                                    if ($empdetb[0]['Benefit']['name'] == 'Transport Allowance' || $empdetb[0]['Benefit']['name'] == 'Additional Transport Allowance' || $empdetb[0]['Benefit']['name'] == 'IT Transportation') {
                                       if ($empdetb[0]['Benefit']['Measurement'] == 'Birr')
                                            $sumtra = $sumtra + $bkben['BkBenefit']['amount'];
                                        if ($empdetb[0]['Benefit']['Measurement'] == 'Gas') {
                                            $sumtraf = $sumtraf + $bkben['BkBenefit']['amount'];
                                            if ($sumtraf > 1000) {
                                                $sumtrafx = $sumtraf - 1000;
                                            }
                                            if ($sumtra > 1000)
                                                $sumtrax = $sumtra - 1000;
                                        }
                                            
                                    }
                                    if ($empdetb[0]['Benefit']['name'] == 'Housing Allowance')
                                        $sumhou = $sumhou + $bkben['BkBenefit']['amount'];
                                    if ($empdetb[0]['Benefit']['name'] == 'Representation Allowance')
                                        $sumrep = $sumrep + $bkben['BkBenefit']['amount'];

                                    if ($empdetb[0]['Benefit']['name'] == 'Cash Indeminity')
                                        $sumind = $sumind + $bkben['BkBenefit']['amount'];
                                    if ($empdetb[0]['Benefit']['name'] == 'Telephone Allowance')
                                        $sumtel = $sumtel + $bkben['BkBenefit']['amount'];
                                    if ($empdetb[0]['Benefit']['name'] == 'Other Benefits')
                                        $sumoth = $sumoth + $bkben['BkBenefit']['amount'];
                                }
                                $results[$i][4] = $sumtraf;
                                $results[$i][5] = $sumtra;
                                $results[$i][6] = $sumhou;
                                $results[$i][7] = $sumrep;
                                $results[$i][8] = $sumrep;
                                $results[$i][9] = $sumtrafx;
                                $results[$i][10] = $sumtrax;
                                $results[$i][11] = $sumind;
                                $results[$i][12] = $results[$i][3] + $sumhou + $results[$i][8] + $sumtrafx + $sumtrax + $sumind; //total taxable income
                                $results[$i][13] = $sumtel;
                                $results[$i][14] = $sumoth;
                                $results[$i][15] = $sumtel + $sumoth;
                                $results[$i][16] = $bkpayroll['BkPayroll']['gross_pay'];
                                $results[$i][17] = $bkpayroll['BkPayroll']['income_tax'];

                                $this->loadModel('BkPension');
                                $this->BkPension->recursive = 0;
                                $conditionspenk['BkPension.payroll_report_id'] = $r_emps[0]['PayrollReport']['id'];
                                $conditionspenk['BkPension.employee_id'] = $emp_id;
                                $bkpens = $this->BkPension->find('all', array('conditions' => $conditionspenk));

                                $this->loadModel('Pension');
                                $conditionspen['Pension.id'] = $bkpens[0]['BkPension']['pension_id'];
                                $emppen = $this->Pension->find('all', array('conditions' => $conditionspen));

                                if ($emppen[0]['Pension']['pf_staff'] == 8)
                                    $results[$i][18] = $bkpayroll['BkPayroll']['basic_salary'] * 0.08;
                                if ($emppen[0]['Pension']['pf_staff'] == 1)
                                    $results[$i][19] = $bkpayroll['BkPayroll']['basic_salary'] * 0.01;
                                if ($emppen[0]['Pension']['pen_staff'] == 1)
                                    $results[$i][20] = $bkpayroll['BkPayroll']['basic_salary'] * 0.07;
                                if ($emppen[0]['Pension']['pf_company'] == 12)
                                    $pfca = $bkpayroll['BkPayroll']['basic_salary'] * 0.12;
                                if ($emppen[0]['Pension']['pf_company'] == 3)
                                    $pfcb = $bkpayroll['BkPayroll']['basic_salary'] * 0.03;
                                if ($emppen[0]['Pension']['pen_company'] == 9)
                                    $pnc = $bkpayroll['BkPayroll']['basic_salary'] * 0.09;

                                $this->loadModel('BkDeduction');
                                $this->BkDeduction->recursive = 0;
                                $conditionsddk['BkDeduction.payroll_report_id'] = $r_emps[0]['PayrollReport']['id'];
                                $conditionsddk['BkDeduction.employee_id'] = $emp_id;
                                $bkdeds = $this->BkDeduction->find('all', array('conditions' => $conditionsddk));
                                $sumaga = 0;
                                $sumcos = 0;
                                $sumsoc = 0;
                                foreach ($bkdeds as $bkded) {

                                    $this->loadModel('Deduction');
                                    $conditionsde['Deduction.id'] = $bkded['BkDeduction']['deduction_id'];
                                    $deds = $this->Deduction->find('all', array('conditions' => $conditionsde));
                                    
                                        if ($deds[0]['Deduction']['name'] == 'Agar children Aid')
                                            $sumaga = $sumaga + $bkded['BkDeduction']['amount'];
                                        if ($deds[0]['Deduction']['name'] == 'Social contribution')
                                            $sumsoc = $sumsoc + $bkded['BkDeduction']['amount'];
                                        if ($deds[0]['Deduction']['name'] == 'Cost Sharing')
                                            $sumcos = $sumcos + $bkded['BkDeduction']['amount'];
                                    
                                }
                                $results[$i][21] = $sumaga;
                                $results[$i][22] = $sumcos;
                                $results[$i][23] = $sumsoc;


                                $this->loadModel('BkLoan');
                                $this->BkLoan->recursive = 0;
                                $conditionslnk['BkLoan.payroll_report_id'] = $r_emps[0]['PayrollReport']['id'];
                                $conditionslnk['BkLoan.employee_id'] = $emp_id;
                                $bklns = $this->BkLoan->find('all', array('conditions' => $conditionslnk));

                                $sumh = 0;
                                $sumcar = 0;
                                $sumem = 0;
                                $sumper = 0;
                                foreach ($bklns as $bkln) {

                                    $this->loadModel('Loan');
                                    $conditionsln['Loan.id'] = $bkln['BkLoan']['loan_id'];
                                    $r_lins = $this->Loan->find('all', array('conditions' => $conditionsln));

                                    if ($r_lins[0]['Loan']['Type'] == 'House Loan')
                                        $sumh = $sumh + $r_lins[0]['Loan']['Per_month'];

                                    if ($r_lins[0]['Loan']['Type'] == 'Car Loan')
                                        $sumcar = $sumcar + $r_lins[0]['Loan']['Per_month'];

                                    if ($r_lins[0]['Loan']['Type'] == 'Emergency Loan')
                                        $sumem = $sumem + $r_lins[0]['Loan']['Per_month'];

                                    if ($r_lins[0]['Loan']['Type'] == 'Personal Loan')
                                        $sumper = $sumper + $r_lins[0]['Loan']['Per_month'];
                                }
                                $results[$i][24] = $sumh;
                                $results[$i][25] = $sumcar;
                                $results[$i][26] = $sumem;
                                $results[$i][27] = $sumper;
                                //total deduction
                                $results[$i][28] = $results[$i][17] + $results[$i][18] + $results[$i][19] + $results[$i][20] + $results[$i][21] + $results[$i][22] + $results[$i][23] + $results[$i][24];
                                $results[$i][28] = $results[$i][28] + $results[$i][25] + $results[$i][26] + $results[$i][27];

                                $results[$i][29] = $pfca;
                                $results[$i][30] = $pfcb;
                                $results[$i][31] = $pnc;
                                $results[$i][32] = $bkpayroll['BkPayroll']['pf_account_no'];
                                $results[$i][33] = $results[$i][18] + $results[$i][19] + $results[$i][29] + $results[$i][30];
                                $results[$i][34] = $results[$i][20] + $results[$i][31];
                                $results[$i][35] = $bkpayroll['BkPayroll']['net_pay'];

                                $g3 = $g3 + $results[$i][3];
                                $g4 = $g4 + $results[$i][4];
                                $g5 = $g5 + $results[$i][5];
                                $g6 = $g6 + $results[$i][6];
                                $g7 = $g7 + $results[$i][7];
                                $g8 = $g8 + $results[$i][8];
                                $g9 = $g9 + $results[$i][9];
                                $g10 = $g10 + $results[$i][10];
                                $g11 = $g11 + $results[$i][11];
                                $g12 = $g12 + $results[$i][12];
                                $g13 = $g13 + $results[$i][13];
                                $g14 = $g14 + $results[$i][14];
                                $g15 = $g115 + $results[$i][15];
                                $g16 = $g16 + $results[$i][16];
                                $g17 = $g17 + $results[$i][17];
                                $g18 = $g18 + $results[$i][18];
                                $g19 = $g19 + $results[$i][19];
                                $g20 = $g20 + $results[$i][20];
                                $g21 = $g21 + $results[$i][21];
                                $g22 = $g22 + $results[$i][22];
                                $g23 = $g23 + $results[$i][23];
                                $g24 = $g24 + $results[$i][24];
                                $g25 = $g25 + $results[$i][25];
                                $g26 = $g26 + $results[$i][26];
                                $g27 = $g27 + $results[$i][27];
                                $g28 = $g28 + $results[$i][28];
                                $g29 = $g29 + $results[$i][29];
                                $g30 = $g30 + $results[$i][30];
                                $g31 = $g31 + $results[$i][31];
                                $g32 = $g32 + $results[$i][32];
                                $g33 = $g33 + $results[$i][33];
                                $g34 = $g34 + $results[$i][34];
                                $g35 = $g35 + $results[$i][35];

                                $i++;
                            }
                    }
                }
            }
            $results[$i + 1][1] = 'Grand Total';
            $results[$i + 1][3] = $g3;
            $results[$i + 1][4] = $g4;
            $results[$i + 1][5] = $g5;
            $results[$i + 1][6] = $g6;
            $results[$i + 1][7] = $g7;
            $results[$i + 1][8] = $g8;
            $results[$i + 1][9] = $g9;
            $results[$i + 1][10] = $g10;
            $results[$i + 1][11] = $g11;
            $results[$i + 1][12] = $g12;
            $results[$i + 1][13] = $g13;
            $results[$i + 1][14] = $g14;
            $results[$i + 1][15] = $g15;
            $results[$i + 1][16] = $g16;
            $results[$i + 1][17] = $g17;
            $results[$i + 1][18] = $g18;
            $results[$i + 1][19] = $g19;
            $results[$i + 1][20] = $g20;
            $results[$i + 1][21] = $g21;
            $results[$i + 1][22] = $g22;
            $results[$i + 1][23] = $g23;
            $results[$i + 1][24] = $g24;
            $results[$i + 1][25] = $g25;
            $results[$i + 1][26] = $g26;
            $results[$i + 1][27] = $g27;
            $results[$i + 1][28] = $g28;
            $results[$i + 1][29] = $g29;
            $results[$i + 1][30] = $g30;
            $results[$i + 1][31] = $g31;
            $results[$i + 1][32] = $g32;
            $results[$i + 1][33] = $g33;
            $results[$i + 1][34] = $g34;
            $results[$i + 1][35] = $g35;
        }

        
        $output='';

        $tbh = '<page><table border=1 width="30" cellspacing="2" cellpadding="0" border="0" bgcolor="#ff6600">
            <tr bgcolor="#ffffff" style="font-size:12px;">
                <th colspan="4" ></th>
                <th colspan="2" >Transport<br>Allowance</th>
                <th colspan="3" ></th>
                <th colspan="2" >Taxable<br>Transport<br>Allowance</th>
                <th colspan="2" ></th>
                <th colspan="2" >Non Taxable<br>Income</th>
                <th colspan="3" ></th></tr>
            <tr bgcolor="#ffffff" style="font-size:12px;">
            <th>S.N</th>
            <th>Name</th>
            <th>Account<br>No</th>
            <th>Basic<br>Salary</th>
            <th>Fuel</th>
            <th>Cash</th>
            <th>House<br>Allowance</th>
            <th>Representation<br>Allowance</th>
            <th>Taxable<br>Representation<br>Allowance</th>
            <th>Fuel</th>
            <th>Cash</th>
            <th>Cash indeminity<br>to Employee</th>
            <th>Total<br>taxable income</th>
            <th>telephone<br>allowance</th>
            <th>Other<br>Benefit</th>
            <th>Total<br>non taxable<br>income</th>
            <th>Gross Pay</th>
            <th>Income Tax</th></tr>';
        
        $zz=0;
       
        foreach ($results as $result) {
            if($zz==0){
                $output = $output . $tbh;
            }
            $output = $output . '<tr bgcolor="#ffffff" style="font-family:Arial, Helvetica, sans-serif;font-size:10px;">';

            for($xx=0; $xx<18; $xx++) {
                if (is_numeric($result[$xx]))
                   $result[$xx] = '<p style="text-align: right;margin:0px">' . $result[$xx] . '</p>';
                $output = $output . '<td >' . $result[$xx] . '</td>';
            }
            $output = $output . '</tr>';
            $zz++;
            if($zz==40){
                 $output = $output.'</table></page>';
                 $zz=0;
            }
        }
        if($zz!=0)
        $output = $output.'</table></page>';
        
        
         $tbh = '<page><table border=1 width="30" cellspacing="2" cellpadding="0" border="0" bgcolor="#ff6600">
            <tr bgcolor="#ffffff" style="font-size:12px;">
                <th colspan="2" ></th>
                <th colspan="6" >Other<br>Deductions</th>
                <th colspan="4" >Loan<br>Repayments</th>
                <th colspan="8" ></th></tr>
            <tr bgcolor="#ffffff" style="font-size:12px;">
            <th>S.N</th>
            <th>Name</th>
            <th>PF 8%</th>
            <th>PF 1%</th>
            <th>Pension 7%</th>
            <th>Agar</th>
            <th>Cost<br>Sharing</th>
            <th>Social<br>Contribution</th>
            <th>House<br>Loan</th>
            <th>Car<br>Loan</th>
            <th>Emmergency<br>Loan</th>
            <th>Personal<br>Loan</th>
            <th>Total<br>Deduction</th>
            <th>PF 12%</th>
            <th>PF 3%</th>
            <th>Pension 9%</th>
            <th>PF<br>Account<br>No</th>
            <th>Total<br>PF</th>
            <th>Total<br>Pension</th>
            <th>Net Pay</th></tr>';
         
             $zz=0;
       
        foreach ($results as $result) {
            if($zz==0){
                $output = $output . $tbh;
            }
            $output = $output . '<tr bgcolor="#ffffff" style="font-family:Arial, Helvetica, sans-serif;font-size:10px;">';

                  $output = $output . '<td >' . $result[0] . '</td>';
                  $output = $output . '<td >' . $result[1] . '</td>';
            for($xx=18; $xx<36; $xx++) {
                if (is_numeric($result[$xx]))
                   $result[$xx] = '<p style="text-align: right;margin:0px">' . $result[$xx] . '</p>';
                $output = $output . '<td >' . $result[$xx] . '</td>';
            }
            $output = $output . '</tr>';
            $zz++;
            if($zz==40){
                 $output = $output.'</table></page>';
                 $zz=0;
            }
        }
        if($zz!=0)
        $output = $output.'</table></page>';
        
        //echo $output;
       require_once(APPLIBS . DS . 'html2pdf' . DS . 'html2pdf.class.php');
                $h2p = new HTML2PDF('L', 'A4', 'en');
                $h2p->writeHTML($output);
                //$file = $report['Report']['name'] . ".pdf";
                $h2p->Output('filename.pdf');
            //end of report code    
                
       
 
    }

}

?>