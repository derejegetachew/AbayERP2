{
	success:true,
	results: <?php echo $results; ?>,
	rows: [
<?php $st = false; foreach($payroll_reports as $payroll_report){ if($st) echo ","; ?>			{
				"id":"<?php echo $payroll_report['PayrollReport']['id']; ?>",
				"date":"<?php echo $payroll_report['PayrollReport']['date']; ?>",
				"payroll":"<?php echo $payroll_report['Payroll']['name']; ?>",
				"budget_year":"<?php echo $payroll_report['BudgetYear']['name']; ?>",
                                "status":"<?php echo $payroll_report['PayrollReport']['status']; ?>"    }
<?php $st = true; } ?>		]
}