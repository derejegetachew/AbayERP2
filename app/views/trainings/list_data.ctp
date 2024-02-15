{
	success:true,
	results: <?php echo $results; ?>,
	rows: [
<?php $st = false; foreach($trainings as $training){ if($st) echo ","; ?>			{
				"id":"<?php echo $training['Training']['id']; ?>",
				"name":"<?php echo $training['Training']['name']; ?>",
				"type":"<?php echo $training['Training']['type']; ?>",
				"created":"<?php echo $training['Training']['created']; ?>",
				"modified":"<?php echo $training['Training']['modified']; ?>"			}
<?php $st = true; } ?>		]
}