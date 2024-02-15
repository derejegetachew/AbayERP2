{
	success:true,
	results: <?php echo $results; ?>,
	rows: [
<?php $st = false; foreach($competenceResults as $competence_result){ 
	if(array_key_exists($competence_result['CompetenceResult']['employee_id'], $emps)) { if($st) echo ","; ?>			{
				"id": "<?php echo $competence_result['CompetenceResult']['employee_id']."$".$competence_result['CompetenceResult']['budget_year_id']."$".$competence_result['CompetenceResult']['quarter']; ?>",
				"budget_year":"<?php echo $all_budget_years[$competence_result['CompetenceResult']['budget_year_id']]; ?>",
				"quarter":"<?php 
				if($competence_result['CompetenceResult']['quarter'] == 1){
					echo "I"; 
				}
				if($competence_result['CompetenceResult']['quarter'] == 2){
					echo "II"; 
				}
				if($competence_result['CompetenceResult']['quarter'] == 3){
					echo "III"; 
				}
				if($competence_result['CompetenceResult']['quarter'] == 4){
					echo "IV"; 
				}
				
				?>",
				
				"employee":"<?php echo $emps[$competence_result['CompetenceResult']['employee_id']] ; ?>",
				"result_status":"<?php 
				$result_status = $competence_result[0]['sum_status'] / $competence_result[0]['count_status'];
				if($result_status == 1){
					echo "Pending agreement";
				}
				else if($result_status == 2){
					echo "Agreed";
				}
				else if($result_status > 2){
					echo "Agreed with reservation";
				}
				else{
					echo "Unknown";
				}
				?>"
						}
<?php $st = true; }} ?>		]
}