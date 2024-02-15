{
	success:true,
	results: <?php echo $results; ?>,
	rows: [
<?php $st = false; foreach($branchPerformancePlans as $branch_performance_plan){ if($st) echo ","; ?>			{
				"id":"<?php echo $branch_performance_plan['BranchPerformancePlan']['id']; ?>",
				"branch":"<?php echo $branch_performance_plan['Branch']['name']; ?>",
				"budget_year":"<?php echo $branch_performance_plan['BudgetYear']['name']; ?>",
				"quarter":"<?php 
				if($branch_performance_plan['BranchPerformancePlan']['quarter'] == 1){
					echo "I";
				}
				if($branch_performance_plan['BranchPerformancePlan']['quarter'] == 2){
					echo "II";
				}
				if($branch_performance_plan['BranchPerformancePlan']['quarter'] == 3){
					echo "III";
				}
				if($branch_performance_plan['BranchPerformancePlan']['quarter'] == 4){
					echo "IV";
				}
				 
				?>",
				"result":"<?php echo $branch_performance_plan['BranchPerformancePlan']['result']; ?>",
				"plan_status":"<?php 
			//	echo $branch_performance_plan['BranchPerformancePlan']['plan_status'];
			// 1 used to be "incomplete"
				if($branch_performance_plan['BranchPerformancePlan']['plan_status'] == 2){
					echo "Pending agreement";
				}
				if($branch_performance_plan['BranchPerformancePlan']['plan_status'] == 3){
					echo "Agreed";
				}
				if($branch_performance_plan['BranchPerformancePlan']['plan_status'] == 4){
					echo "Agreed with reservation";
				}
				
				?>",
				"result_status":"<?php 
				// echo $branch_performance_plan['BranchPerformancePlan']['result_status']; 
				if($branch_performance_plan['BranchPerformancePlan']['result_status'] == 1){
					echo "Pending agreement";
				}
				if($branch_performance_plan['BranchPerformancePlan']['result_status'] == 2){
					echo "Agreed";
				}
				if($branch_performance_plan['BranchPerformancePlan']['result_status'] == 3){
					echo "Agreed with reservation";
				}

				?>",
				"comment":"<?php echo $branch_performance_plan['BranchPerformancePlan']['comment']; ?>"			}
<?php $st = true; } ?>		]
}