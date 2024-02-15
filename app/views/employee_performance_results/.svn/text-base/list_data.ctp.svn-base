{
	success:true,
	results: <?php echo $results; ?>,
	rows: [
<?php $st = false; foreach($employee_performance_results as $employee_performance_result){ if($st) echo ","; ?>			{
				"id":"<?php echo $employee_performance_result['EmployeePerformanceResult']['id']; ?>",
				"employee":"<?php echo $employee_performance_result['Employee']['id']; ?>",
				"employee_performance":"<?php echo $employee_performance_result['EmployeePerformance']['id']; ?>",
				"performance_list":"<?php echo $employee_performance_result['PerformanceList']['name']; ?>",
				"performance_list_choice":"<?php echo $employee_performance_result['PerformanceListChoice']['name']; ?>"			}
<?php $st = true; } ?>		]
}