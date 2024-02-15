{
	success:true,
	results: <?php echo $results; ?>,
	rows: [
<?php $st = false; foreach($branchPerformanceTrackings as $branch_performance_tracking){ 
	if(array_key_exists($branch_performance_tracking['Employee']['id'], $emps)){ if($st) echo ","; ?>			{
				"id":"<?php echo $branch_performance_tracking['BranchPerformanceTracking']['id']; ?>",
				"employee":"<?php echo $emps[$branch_performance_tracking['Employee']['id']]; ?>",
				"goal":"<?php echo $br_performance_settings[$branch_performance_tracking['BranchPerformanceTracking']['goal']]; ?>",
				"date":"<?php echo $branch_performance_tracking['BranchPerformanceTracking']['date']; ?>",
				"value":"<?php echo $branch_performance_tracking['BranchPerformanceTracking']['value']; ?>"			}
<?php $st = true; }} ?>		]
}