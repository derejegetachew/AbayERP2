{
	success:true,
	results: <?php echo $results; ?>,
	rows: [
<?php $st = false; foreach($brPerformancePlans as $br_performance_plan){ if($st) echo ","; ?>			{
				"id":"<?php echo $br_performance_plan['employee_id'].$br_performance_plan['budget_year_id'].$br_performance_plan['quarter']; ?>",
				"identifier" : "<?php echo $br_performance_plan['employee_id'].'-'.$br_performance_plan['budget_year_id'].'-'.$br_performance_plan['quarter']; ?>",
				"budget_year_id":"<?php echo $br_performance_plan['budget_year_id']; ?>",
				"budget_year": "<?php echo $br_performance_plan['budget_year']; ?>",
				"employee":"<?php echo $full_name  ; ?>",
				"quarter":"<?php 
				if($br_performance_plan['quarter'] == 1){
					echo "I"; 
				}
				if($br_performance_plan['quarter'] == 2){
					echo "II";
				}
				if($br_performance_plan['quarter'] == 3){
					echo "III"; 
				}
				if($br_performance_plan['quarter'] == 4){
					echo "IV";
				}

				
				?>",
				
						}
<?php $st = true; } ?>		]
}