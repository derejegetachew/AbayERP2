{
	success:true,
	results: <?php echo $results; ?>,
	rows: [
<?php $st = false; foreach($branchPerformanceDetails as $branch_performance_detail){ if($st) echo ","; ?>			{
				"id":"<?php echo $branch_performance_detail['BranchPerformanceDetail']['id']; ?>",
				"branch_evaluation_criteria":"<?php 
				echo $all_criterias[$branch_performance_detail['BranchEvaluationCriteria']['id']]; 
				?>",
				"plan_in_number":"<?php echo $branch_performance_detail['BranchPerformanceDetail']['plan_in_number']; ?>",
				"actual_result":"<?php echo $branch_performance_detail['BranchPerformanceDetail']['actual_result']; ?>",
				"accomplishment":"<?php echo $branch_performance_detail['BranchPerformanceDetail']['accomplishment']; ?>",
				"rating":"<?php echo $branch_performance_detail['BranchPerformanceDetail']['rating']; ?>",
				"final_result":"<?php echo $branch_performance_detail['BranchPerformanceDetail']['final_result']; ?>",
				"branch_performance_plan":"<?php echo $branch_performance_detail['BranchPerformancePlan']['id']; ?>"			}
<?php $st = true; } ?>		]
}