{
	success:true,
	results: <?php echo $results; ?>,
	rows: [
<?php $st = false; foreach($branchEvaluationCriterias as $branch_evaluation_criteria){ if($st) echo ","; ?>			{
				"id":"<?php echo $branch_evaluation_criteria['BranchEvaluationCriteria']['id']; ?>",
				"goal":"<?php echo $branch_evaluation_criteria['BranchEvaluationCriteria']['goal']; ?>",
				"measure":"<?php echo $branch_evaluation_criteria['BranchEvaluationCriteria']['measure']; ?>",
				"target":"<?php echo $branch_evaluation_criteria['BranchEvaluationCriteria']['target']; ?>",
				"weight":"<?php echo $branch_evaluation_criteria['BranchEvaluationCriteria']['weight']; ?>",
				"direction":"<?php 
				if($branch_evaluation_criteria['BranchEvaluationCriteria']['direction'] == 1){
					echo 'Incremental';
				}
				if($branch_evaluation_criteria['BranchEvaluationCriteria']['direction'] == 2){
					echo 'Decremental';
				}
				if($branch_evaluation_criteria['BranchEvaluationCriteria']['direction'] == 3){
					echo 'Error';
				}
				if($branch_evaluation_criteria['BranchEvaluationCriteria']['direction'] == 4){
					echo 'Number of complains';
				}

				if($branch_evaluation_criteria['BranchEvaluationCriteria']['direction'] == 5){
					echo 'Delay';
				}

				if($branch_evaluation_criteria['BranchEvaluationCriteria']['direction'] == 6){
					echo 'SDT';
				}

				
				?>",
				"status":"<?php 
				if($branch_evaluation_criteria['BranchEvaluationCriteria']['STATUS'] == 1){
					echo 'Active';
				}
				if($branch_evaluation_criteria['BranchEvaluationCriteria']['STATUS'] == 2){
					echo 'Inactive';
				}
					
				?>",
						}
<?php $st = true; } ?>		]
}