{
	success:true,
	results: <?php echo $results; ?>,
	rows: [
<?php $st = false; foreach($fms_incidents as $fms_incident){ if($st) echo ","; ?>			{
				"id":"<?php echo $fms_incident['FmsIncident']['id']; ?>",
				"fms_vehicle":"<?php echo $fms_incident['FmsVehicle']['plate_no']; ?>",
				"occurrence_date":"<?php echo $fms_incident['FmsIncident']['occurrence_date']; ?>",
				"occurrence_time":"<?php echo $fms_incident['FmsIncident']['occurrence_time']; ?>",
				"occurrence_place":"<?php echo $fms_incident['FmsIncident']['occurrence_place']; ?>",
				"details":"<?php echo $fms_incident['FmsIncident']['details']; ?>",
				"action_taken":"<?php echo $fms_incident['FmsIncident']['action_taken']; ?>",
				"created_by":"<?php echo $fms_incident['CreatedUser']['Person']['first_name'].' '.$fms_incident['CreatedUser']['Person']['middle_name']; ?>",
				"created":"<?php echo $fms_incident['FmsIncident']['created']; ?>",
				"modified":"<?php echo $fms_incident['FmsIncident']['modified']; ?>"			}
<?php $st = true; } ?>		]
}