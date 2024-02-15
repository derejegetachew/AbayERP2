{
	success:true,
	results: <?php echo $results; ?>,
	rows: [
<?php $st = false; foreach($fms_drivers as $fms_driver){ if($st) echo ","; ?>			{
				"id":"<?php echo $fms_driver['FmsDriver']['id']; ?>",
				"person":"<?php echo $fms_driver['Person']['first_name'].' '.$fms_driver['Person']['middle_name'].' '.$fms_driver['Person']['last_name']; ?>",
				"license_no":"<?php echo $fms_driver['FmsDriver']['license_no']; ?>",
				"date_given":"<?php echo $fms_driver['FmsDriver']['date_given']; ?>",
				"expiration_date":"<?php echo $fms_driver['FmsDriver']['expiration_date']; ?>",
				"created_by":"<?php echo $fms_driver['CreatedUser']['Person']['first_name'].' '.$fms_driver['CreatedUser']['Person']['middle_name']; ?>",
				"created":"<?php echo $fms_driver['FmsDriver']['created']; ?>",
				"modified":"<?php echo $fms_driver['FmsDriver']['modified']; ?>"			}
<?php $st = true; } ?>		]
}