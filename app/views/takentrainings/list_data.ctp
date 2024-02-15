{
	success:true,
	results: <?php echo $results; ?>,
	rows: [
<?php $st = false; foreach($takentrainings as $takentraining){ if($st) echo ","; ?>			{
				"id":"<?php echo $takentraining['Takentraining']['id']; ?>",
				"training":"<?php echo $takentraining['Training']['name']; ?>",
				"from":"<?php echo $takentraining['Takentraining']['from']; ?>",
				"to":"<?php echo $takentraining['Takentraining']['to']; ?>",
				"half_day":"<?php echo $takentraining['Takentraining']['half_day']; ?>",
				"trainingvenue":"<?php echo $takentraining['Trainingvenue']['name']; ?>",
				"cost_per_person":"<?php echo $takentraining['Takentraining']['cost_per_person']; ?>",
				"trainer":"<?php echo $takentraining['Trainer']['name']; ?>",
				"trainingtarget":"<?php echo $takentraining['Trainingtarget']['name']; ?>",
				"certification":"<?php echo $takentraining['Takentraining']['certification']; ?>",
				"created":"<?php echo $takentraining['Takentraining']['created']; ?>",
				"modified":"<?php echo $takentraining['Takentraining']['modified']; ?>"			}
<?php $st = true; } ?>		]
}