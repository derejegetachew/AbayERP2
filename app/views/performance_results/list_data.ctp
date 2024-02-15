{
	success:true,
	results: <?php echo $results; ?>,
	rows: [
<?php $st = false; foreach($performance_results as $performance_result){ if($st) echo ","; ?>			{
				"id":"<?php echo $performance_result['PerformanceResult']['id']; ?>",
				"employee":"<?php echo $performance_result['Employee']['id']; ?>",
				"budget_year":"<?php echo $performance_result['BudgetYear']['name']; ?>",
				"first":"<?php echo $performance_result['PerformanceResult']['first']; ?>",
				"second":"<?php echo $performance_result['PerformanceResult']['second']; ?>",
				"third":"<?php echo $performance_result['PerformanceResult']['third']; ?>",
				"fourth":"<?php echo $performance_result['PerformanceResult']['fourth']; ?>",
				"average":"<?php echo $performance_result['PerformanceResult']['average']; ?>",
				"created":"<?php echo $performance_result['PerformanceResult']['created']; ?>",
				"modified":"<?php echo $performance_result['PerformanceResult']['modified']; ?>"			}
<?php $st = true; } ?>		]
}