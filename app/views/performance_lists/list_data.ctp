{
	success:true,
	results: <?php echo $results; ?>,
	rows: [
<?php $st = false; foreach($performance_lists as $performance_list){ if($st) echo ","; ?>			{
				"id":"<?php echo $performance_list['PerformanceList']['id']; ?>",
				"name":"<?php echo $performance_list['PerformanceList']['name']; ?>",
				"type":"<?php echo $performance_list['PerformanceList']['type']; ?>",
				"performance":"<?php echo $performance_list['Performance']['name']; ?>",
                                "perspective":"<?php echo $performance_list['PerformanceList']['perspective']; ?>"	}
<?php $st = true; } ?>		]
}