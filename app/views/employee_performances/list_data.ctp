{
	success:true,
	results: <?php echo $results; ?>,
	rows: [
<?php $st = false; foreach($employee_performances as $employee_performance){ if($st) echo ","; ?>			{
				"id":"<?php echo $employee_performance['EmployeePerformance']['id']; ?>",
				"employee":"<?php echo $employee_performance['Employee']['id']; ?>",
				"performance":"<?php echo $employee_performance['Performance']['name']; ?>",
                                "performance_id":"<?php echo $employee_performance['Performance']['id']; ?>",
				"status":"<?php echo $employee_performance['EmployeePerformance']['status']; ?>",
				"created":"<?php echo $employee_performance['EmployeePerformance']['created']; ?>"			}
<?php $st = true; } ?>		]
}