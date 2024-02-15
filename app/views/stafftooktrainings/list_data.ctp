{
	success:true,
	results: <?php echo $results; ?>,
	rows: [
<?php $st = false; foreach($stafftooktrainings as $stafftooktraining){ if($st) echo ","; ?>			{
				"id":"<?php echo $stafftooktraining['Stafftooktraining']['id']; ?>",
				"employee":"<?php echo $stafftooktraining['Employee']['User']['Person']['first_name'].' '.$stafftooktraining['Employee']['User']['Person']['middle_name']; ?>",
				"position":"<?php echo $stafftooktraining['Position']['name']; ?>",
				"branch":"<?php echo $stafftooktraining['Branch']['name']; ?>",
				"created":"<?php echo $stafftooktraining['Stafftooktraining']['created']; ?>",
				"modified":"<?php echo $stafftooktraining['Stafftooktraining']['modified']; ?>"			}
<?php $st = true; } ?>		]
}