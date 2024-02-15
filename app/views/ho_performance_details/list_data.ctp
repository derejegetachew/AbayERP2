{
	success:true,
	results: <?php echo $results; ?>,
	rows: [
<?php $st = false; foreach($hoPerformanceDetails as $ho_performance_detail){ if($st) echo ","; ?>			{
				"id":"<?php echo $ho_performance_detail['HoPerformanceDetail']['id']; ?>",
				"objective":"<?php echo $ho_performance_detail['HoPerformanceDetail']['objective']; ?>",
				"perspective":"<?php echo $ho_performance_detail['HoPerformanceDetail']['perspective']; ?>",
				"plan_description":"<?php echo $ho_performance_detail['HoPerformanceDetail']['plan_description']; ?>",
				"plan_in_number":"<?php echo $ho_performance_detail['HoPerformanceDetail']['plan_in_number']; ?>",
				"actual_result":"<?php echo $ho_performance_detail['HoPerformanceDetail']['actual_result']; ?>",
				"measure":"<?php echo $ho_performance_detail['HoPerformanceDetail']['measure']; ?>",
				"weight":"<?php echo $ho_performance_detail['HoPerformanceDetail']['weight']; ?>",
				"accomplishment":"<?php echo $ho_performance_detail['HoPerformanceDetail']['accomplishment']; ?>",
				"total_score":"<?php echo $ho_performance_detail['HoPerformanceDetail']['total_score']; ?>",
				"final_score":"<?php echo $ho_performance_detail['HoPerformanceDetail']['final_score']; ?>",
				"direction":"<?php
				if($ho_performance_detail['HoPerformanceDetail']['direction'] == 1){
							echo "Incremental";
				}
				if($ho_performance_detail['HoPerformanceDetail']['direction'] == 2){
					echo "Decremental";
					}
					if($ho_performance_detail['HoPerformanceDetail']['direction'] == 3){
					echo "Error";
					}
					if($ho_performance_detail['HoPerformanceDetail']['direction'] == 4){
						echo "No Complains";
					}
					if($ho_performance_detail['HoPerformanceDetail']['direction'] == 5){
						echo "Delay";
					}
					if($ho_performance_detail['HoPerformanceDetail']['direction'] == 6){
						echo "SDT";
					}
					if($ho_performance_detail['HoPerformanceDetail']['direction'] == 7){
						echo "NPL";
					}
					if($ho_performance_detail['HoPerformanceDetail']['direction'] == 8){
						echo "RATE";
					}
				
				 ?>",
				"ho_performance_plan":"<?php echo $ho_performance_detail['HoPerformancePlan']['id']; ?>"			
			}
<?php $st = true; } ?>		]
}