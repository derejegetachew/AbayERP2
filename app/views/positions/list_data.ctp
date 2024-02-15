{
	success:true,
	results: <?php echo $results; ?>,
	rows: [
<?php $st = false; foreach($positions as $position){ if($st) echo ","; ?>			{
				"id":"<?php echo $position['Position']['id']; ?>",
				"name":"<?php echo $position['Position']['name']; ?>",
				"grade":"<?php echo $position['Grade']['name']; ?>",
				"status":"<?php echo $position['Position']['status']; ?>",	
				"updated_by":"<?php echo $position['Position']['updated_by']; ?>",	
				"approved_by":"<?php echo $position['Position']['approved_by']; ?>"				}
<?php $st = true; } ?>		]
}