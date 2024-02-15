{
	success:true,
	results: <?php echo $results; ?>,
	rows: [
<?php $st = false; foreach($performanceStatuses as $performance_status){ if($st) echo ","; ?>			{
				"id":"<?php echo $performance_status['PerformanceStatus']['id']; ?>",
				"budget_year":"<?php echo $performance_status['BudgetYear']['name']; ?>",
				"quarter":"<?php echo $performance_status['PerformanceStatus']['quarter']; ?>",
				"status":"<?php echo $performance_status['PerformanceStatus']['status']; ?>"			}
<?php $st = true; } ?>		]
}