{
	success:true,
	results: <?php echo $results; ?>,
	rows: [
<?php $st = false; foreach($pension_employees as $pension_employee){ if($st) echo ","; ?>			{
				"id":"<?php echo $pension_employee['PensionEmployee']['id']; ?>",
				"pension":"<?php echo $pension_employee['Pension']['name']; ?>",
				"employee":"<?php echo $pension_employee['Employee']['id']; ?>"			}
<?php $st = true; } ?>		]
}