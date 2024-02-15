{
	success:true,
	results: <?php echo $results; ?>,
	rows: [
<?php $st = false; foreach($fms_maintenance_requests as $fms_maintenance_request){ if($st) echo ","; ?>			{
				"id":"<?php echo $fms_maintenance_request['FmsMaintenanceRequest']['id']; ?>",
				"company":"<?php echo $fms_maintenance_request['FmsMaintenanceRequest']['company']; ?>",
				"fms_vehicle":"<?php echo $fms_maintenance_request['FmsVehicle']['plate_no']; ?>",
				"km":"<?php echo $fms_maintenance_request['FmsMaintenanceRequest']['km']; ?>",
				"damage_type":"<?php echo $fms_maintenance_request['FmsMaintenanceRequest']['damage_type']; ?>",
				"examination":"<?php echo $fms_maintenance_request['FmsMaintenanceRequest']['examination']; ?>",
				"notifier":"<?php echo $fms_maintenance_request['FmsMaintenanceRequest']['notifier']; ?>",
				"confirmer":"<?php echo $fms_maintenance_request['FmsMaintenanceRequest']['confirmer']; ?>",
				"approver":"<?php echo $fms_maintenance_request['FmsMaintenanceRequest']['approver']; ?>",
				"status":"<?php echo $fms_maintenance_request['FmsMaintenanceRequest']['status']; ?>",
				"created":"<?php echo $fms_maintenance_request['FmsMaintenanceRequest']['created']; ?>",
				"modified":"<?php echo $fms_maintenance_request['FmsMaintenanceRequest']['modified']; ?>"			}
<?php $st = true; } ?>		]
}