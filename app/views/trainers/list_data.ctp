{
	success:true,
	results: <?php echo $results; ?>,
	rows: [
<?php $st = false; foreach($trainers as $trainer){ if($st) echo ","; ?>			{
				"id":"<?php echo $trainer['Trainer']['id']; ?>",
				"name":"<?php echo $trainer['Trainer']['name']; ?>",
				"type":"<?php echo $trainer['Trainer']['type']; ?>",
				"created":"<?php echo $trainer['Trainer']['created']; ?>",
				"modified":"<?php echo $trainer['Trainer']['modified']; ?>"			}
<?php $st = true; } ?>		]
}