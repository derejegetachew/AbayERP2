{
	success:true,
	results: <?php echo $results; ?>,
	rows: [
<?php $st = false; foreach($branchPerformanceSettings as $branch_performance_setting){ if($st) echo ","; ?>			{
				"id":"<?php echo $branch_performance_setting['BranchPerformanceSetting']['id']; ?>",
				"position":"<?php echo $positions[$branch_performance_setting['Position']['id']]; ?>",
				"goal":"<?php echo $branch_performance_setting['BranchPerformanceSetting']['goal']; ?>",
				"measure":"<?php echo $branch_performance_setting['BranchPerformanceSetting']['measure']; ?>",
				"target":"<?php echo $branch_performance_setting['BranchPerformanceSetting']['target']; ?>",
				"weight":"<?php echo $branch_performance_setting['BranchPerformanceSetting']['weight']; ?>",
				"five_pointer_min":"<?php echo $branch_performance_setting['BranchPerformanceSetting']['five_pointer_min']; ?>",
				"five_pointer_max_included":"<?php echo $branch_performance_setting['BranchPerformanceSetting']['five_pointer_max_included']; ?>",
				"four_pointer_min":"<?php echo $branch_performance_setting['BranchPerformanceSetting']['four_pointer_min']; ?>",
				"four_pointer_max_included":"<?php echo $branch_performance_setting['BranchPerformanceSetting']['four_pointer_max_included']; ?>",
				"three_pointer_min":"<?php echo $branch_performance_setting['BranchPerformanceSetting']['three_pointer_min']; ?>",
				"three_pointer_max_included":"<?php echo $branch_performance_setting['BranchPerformanceSetting']['three_pointer_max_included']; ?>",
				"two_pointer_min":"<?php echo $branch_performance_setting['BranchPerformanceSetting']['two_pointer_min']; ?>",
				"two_pointer_max_included":"<?php echo $branch_performance_setting['BranchPerformanceSetting']['two_pointer_max_included']; ?>",
				"one_pointer_min":"<?php echo $branch_performance_setting['BranchPerformanceSetting']['one_pointer_min']; ?>",
				"one_pointer_max_included":"<?php echo $branch_performance_setting['BranchPerformanceSetting']['one_pointer_max_included']; ?>",
}		
<?php $st = true; } ?>		]
}