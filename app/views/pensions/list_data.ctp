{
	success:true,
	results: <?php echo $results; ?>,
	rows: [
<?php $st = false; foreach($pensions as $pension){ if($st) echo ","; ?>			{
				"id":"<?php echo $pension['Pension']['id']; ?>",
				"name":"<?php echo $pension['Pension']['name']; ?>",
				"pf_staff":"<?php echo $pension['Pension']['pf_staff']; ?>",
				"pf_company":"<?php echo $pension['Pension']['pf_company']; ?>",
				"pen_staff":"<?php echo $pension['Pension']['pen_staff']; ?>",
				"pen_company":"<?php echo $pension['Pension']['pen_company']; ?>",
				"payroll":"<?php echo $pension['Payroll']['name']; ?>"			}
<?php $st = true; } ?>		]
}