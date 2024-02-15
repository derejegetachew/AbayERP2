{
	success:true,
	results: <?php echo $results; ?>,
	rows: [
<?php $st = false; foreach($payroll_employees as $payroll_employee){ if($st) echo ","; ?>			{
				"id":"<?php echo $payroll_employee['PayrollEmployee']['id']; ?>",
				"payroll":"<?php echo $payroll_employee['Payroll']['name']; ?>",
                                "account_no":"<?php echo $payroll_employee['PayrollEmployee']['account_no']; ?>",
                                "pf_account_no":"<?php echo $payroll_employee['PayrollEmployee']['pf_account_no']; ?>",
				"employee":"<?php echo $payroll_employee['Employee']['id']; ?>",
				"status":"<?php echo $payroll_employee['PayrollEmployee']['status']; ?>",
				"date":"<?php echo $payroll_employee['PayrollEmployee']['date']; ?>",
				"remark":"<?php echo $payroll_employee['PayrollEmployee']['remark']; ?>"			}
<?php $st = true; } ?>		]
}