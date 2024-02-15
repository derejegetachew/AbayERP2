{
	success:true,
	results: <?php echo $results; ?>,
	rows: [
<?php $st = false; foreach($trainingvenues as $trainingvenue){ if($st) echo ","; ?>			{
				"id":"<?php echo $trainingvenue['Trainingvenue']['id']; ?>",
				"name":"<?php echo $trainingvenue['Trainingvenue']['name']; ?>",
				"address":"<?php echo $trainingvenue['Trainingvenue']['address']; ?>",
				"created":"<?php echo $trainingvenue['Trainingvenue']['created']; ?>",
				"modified":"<?php echo $trainingvenue['Trainingvenue']['modified']; ?>"			}
<?php $st = true; } ?>		]
}