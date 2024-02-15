{
	success:true,
	results: <?php echo $results; ?>,
	rows: [
<?php $st = false; foreach($hoPerformancePlans as $ho_performance_plan){
	 if(array_key_exists($ho_performance_plan['HoPerformancePlan']['employee_id'], $emps)) { if($st) echo ","; ?>			{
				"id":"<?php echo $ho_performance_plan['HoPerformancePlan']['id']; ?>",
				
				"budget_year":"<?php echo $ho_performance_plan['BudgetYear']['name']; ?>",
				"employee":"<?php echo  $emps[$ho_performance_plan['HoPerformancePlan']['employee_id']]; ?> ",
				"quarter":"<?php 
				if($ho_performance_plan['HoPerformancePlan']['quarter'] == 1){
					echo "I";
				}
				if($ho_performance_plan['HoPerformancePlan']['quarter'] == 2){
					echo "II";
				}
				if($ho_performance_plan['HoPerformancePlan']['quarter'] == 3){
					echo "III"; 
				}
				if($ho_performance_plan['HoPerformancePlan']['quarter'] == 4){
					echo "IV"; 
				}

				
				?>",
				"self_technical_percent":"<?php echo $ho_performance_plan['HoPerformancePlan']['self_technical_percent']; ?>",
				"spvr_technical_percent":"<?php echo $ho_performance_plan['HoPerformancePlan']['spvr_technical_percent']; ?>",
				"both_technical_percent":"<?php echo $ho_performance_plan['HoPerformancePlan']['both_technical_percent']; ?>",
				"semiannual_technical":"<?php echo $ho_performance_plan['HoPerformancePlan']['semiannual_technical']; ?>",
				"behavioural_percent":"<?php echo $ho_performance_plan['HoPerformancePlan']['behavioural_percent']; ?>",
				"semiannual_average":"<?php echo $ho_performance_plan['HoPerformancePlan']['semiannual_average']; ?>",
				"plan_status":"<?php 
				if($ho_performance_plan['HoPerformancePlan']['plan_status'] == 1){
					echo "incomplete";
				}else if($ho_performance_plan['HoPerformancePlan']['plan_status'] == 2){
					echo "pending agreement";
				}else if($ho_performance_plan['HoPerformancePlan']['plan_status'] == 3){
					echo "agreed";
				}else if($ho_performance_plan['HoPerformancePlan']['plan_status'] == 2){
					echo "agreed with reservation";
				}else{
					echo "";
				}
					  ?>",
				"result_status":"<?php 
				if($ho_performance_plan['HoPerformancePlan']['result_status'] == 1){
					echo "pending agreement";
				}else if($ho_performance_plan['HoPerformancePlan']['result_status'] == 2){
					echo "agreed";
				}else if($ho_performance_plan['HoPerformancePlan']['result_status'] == 3){
					echo "agreed with reservation";
				}else {
					echo "";
				}  ?>",
				"comment":"<?php echo $ho_performance_plan['HoPerformancePlan']['comment']; ?>"			}
<?php $st = true; }} ?>		]
}