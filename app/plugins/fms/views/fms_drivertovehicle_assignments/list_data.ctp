{
	success:true,
	results: <?php echo $results; ?>,
	rows: [
<?php $st = false; foreach($fms_drivertovehicle_assignments as $fms_drivertovehicle_assignment){ if($st) echo ","; ?>			{
				"id":"<?php echo $fms_drivertovehicle_assignment['FmsDrivertovehicleAssignment']['id']; ?>",
				"fms_driver":"<?php echo $fms_drivertovehicle_assignment['FmsDriver']['Person']['first_name'].' '.$fms_drivertovehicle_assignment['FmsDriver']['Person']['middle_name']; ?>",
				"fms_vehicle":"<?php echo $fms_drivertovehicle_assignment['FmsVehicle']['plate_no']; ?>",
				"start_date":"<?php echo $fms_drivertovehicle_assignment['FmsDrivertovehicleAssignment']['start_date']; ?>",
				"end_date":"<?php echo $fms_drivertovehicle_assignment['FmsDrivertovehicleAssignment']['end_date']; ?>",
				"created_by":"<?php echo $fms_drivertovehicle_assignment['CreatedUser']['Person']['first_name'].' '.$fms_drivertovehicle_assignment['CreatedUser']['Person']['middle_name']; ?>",
				"created":"<?php echo $fms_drivertovehicle_assignment['FmsDrivertovehicleAssignment']['created']; ?>",
				"modified":"<?php echo $fms_drivertovehicle_assignment['FmsDrivertovehicleAssignment']['modified']; ?>"			}
<?php $st = true; } ?>		]
}