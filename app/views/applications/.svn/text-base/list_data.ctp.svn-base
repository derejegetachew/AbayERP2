{
	success:true,
	results: <?php echo $results; ?>,
	rows: [
<?php $st = false; foreach($applications as $application){ if($st) echo ","; ?>			{
				"id":"<?php echo $application['Application']['id']; ?>",
				"employee":"<?php echo $application['Employee']['User']['Person']['first_name'].' '.$application['Employee']['User']['Person']['middle_name'].' '.$application['Employee']['User']['Person']['last_name']; ?>",
				"job":"<?php echo $application['Job']['name']; ?>",
				"letter":"<?php echo $application['Application']['letter']; ?>",
				"date":"<?php echo $application['Application']['created']; ?>"			}
<?php $st = true; } ?>		]
}