{
	success:true,
	results: <?php echo $results; ?>,
	rows: [
<?php $st = false; foreach($brPerformancePlans as $br_performance_plan){ if($st) echo ","; ?>			{
				"id":"<?php echo $br_performance_plan['BranchPerformancePlan']['id']; ?>",
				
				"budget_year":"<?php echo $br_performance_plan['BudgetYear']['name']; ?>",
				"branch":"<?php echo $branch_name ; ?>",
				"quarter":"<?php 
				if($br_performance_plan['BranchPerformancePlan']['quarter'] == 1){
					echo "I"; 
				}
				if($br_performance_plan['BranchPerformancePlan']['quarter'] == 2){
					echo "II";
				}
				if($br_performance_plan['BranchPerformancePlan']['quarter'] == 3){
					echo "III"; 
				}
				if($br_performance_plan['BranchPerformancePlan']['quarter'] == 4){
					echo "IV";
				}

				
				?>",
				
				"plan_status":"<?php 
				if($br_performance_plan['BranchPerformancePlan']['plan_status'] == 1){
					echo "incomplete";
				}else if($br_performance_plan['BranchPerformancePlan']['plan_status'] == 2){
					echo "pending agreement";
				}else if($br_performance_plan['BranchPerformancePlan']['plan_status'] == 3){
					echo "agreed";
				}else if($br_performance_plan['BranchPerformancePlan']['plan_status'] == 4){
					echo "agreed with reservation";
				}else{
					echo "";
				}
					  ?>",
					  "result_status":"<?php 
				 if($br_performance_plan['BranchPerformancePlan']['result_status'] == 1){
					echo "pending agreement";
				}else if($br_performance_plan['BranchPerformancePlan']['result_status'] == 2){
					echo "agreed";
				}else if($br_performance_plan['BranchPerformancePlan']['result_status'] == 3){
					echo "agreed with reservation";
				}else{
					echo "";
				}
					  ?>",
				
				"comment":"<?php echo $br_performance_plan['BranchPerformancePlan']['comment']; ?>"			}
				
<?php $st = true; } ?>		]
}