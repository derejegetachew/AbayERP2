{
	success:true,
	results: <?php echo $results; ?>,
	rows: [
<?php $st = false; foreach($branch_performance_tracking_statuses as $branch_performance_tracking_status){ if($st) echo ","; ?>			{
				"id":"<?php echo $branch_performance_tracking_status['BranchPerformanceTrackingStatus']['id']; ?>",
				"employee":"<?php echo $branch_performance_tracking_status['Employee']['id']; ?>",
				"budget_year":"<?php echo $branch_performance_tracking_status['BudgetYear']['name']; ?>",
				"quarter":"<?php echo $branch_performance_tracking_status['BranchPerformanceTrackingStatus']['quarter']; ?>",
				"result_status":"<?php echo $branch_performance_tracking_status['BranchPerformanceTrackingStatus']['result_status']; ?>"			}
<?php $st = true; } ?>		]
}