{
	success:true,
	results: <?php echo $results; ?>,
	rows: [
<?php $st = false; foreach($performance_list_choices as $performance_list_choice){ if($st) echo ","; ?>			{
				"id":"<?php echo $performance_list_choice['PerformanceListChoice']['id']; ?>",
				"name":"<?php echo $performance_list_choice['PerformanceListChoice']['name']; ?>",
				"performance_list":"<?php echo $performance_list_choice['PerformanceList']['name']; ?>"			}
<?php $st = true; } ?>		]
}