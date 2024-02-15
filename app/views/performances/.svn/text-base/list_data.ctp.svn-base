{
	success:true,
	results: <?php echo $results; ?>,
	rows: [
<?php $st = false; foreach($performances as $performance){ if($st) echo ","; ?>			{
				"id":"<?php echo $performance['Performance']['id']; ?>",
				"name":"<?php echo $performance['Performance']['name']; ?>",
				"status":"<?php echo $performance['Performance']['status']; ?>"			}
<?php $st = true; } ?>		]
}