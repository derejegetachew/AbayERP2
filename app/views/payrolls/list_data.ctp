{
	success:true,
	results: <?php echo $results; ?>,
	rows: [
<?php $st = false; foreach($payrolls as $payroll){ if($st) echo ","; ?>			{
				"id":"<?php echo $payroll['Payroll']['id']; ?>",
				"name":"<?php echo $payroll['Payroll']['name']; ?>"			}
<?php $st = true; } ?>		]
}