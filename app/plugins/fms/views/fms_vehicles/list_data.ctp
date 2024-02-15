{
	success:true,
	results: <?php echo $results; ?>,
	rows: [
<?php $st = false; foreach($fms_vehicles as $fms_vehicle){ if($st) echo ","; ?>			{
				"id":"<?php echo $fms_vehicle['FmsVehicle']['id']; ?>",
				"vehicle_type":"<?php echo $fms_vehicle['FmsVehicle']['vehicle_type']; ?>",
				"plate_no":"<?php echo $fms_vehicle['FmsVehicle']['plate_no']; ?>",
				"model":"<?php echo $fms_vehicle['FmsVehicle']['model']; ?>",
				"engine_no":"<?php echo $fms_vehicle['FmsVehicle']['engine_no']; ?>",
				"chassis_no":"<?php echo $fms_vehicle['FmsVehicle']['chassis_no']; ?>",
				"fuel_type":"<?php echo $fms_vehicle['FmsVehicle']['fuel_type']; ?>",
				"no_of_tyre":"<?php echo $fms_vehicle['FmsVehicle']['no_of_tyre']; ?>",
				"horsepower":"<?php echo $fms_vehicle['FmsVehicle']['horsepower']; ?>",
				"carload_people":"<?php echo $fms_vehicle['FmsVehicle']['carload_people']; ?>",
				"carload_goods":"<?php echo $fms_vehicle['FmsVehicle']['carload_goods']; ?>",
				"purchase_amount":"<?php echo $fms_vehicle['FmsVehicle']['purchase_amount']; ?>",
				"purchase_date":"<?php echo $fms_vehicle['FmsVehicle']['purchase_date']; ?>",
				"remark":"<?php echo $fms_vehicle['FmsVehicle']['remark']; ?>",
				"created_by":"<?php echo $fms_vehicle['CreatedUser']['Person']['first_name'].' '.$fms_vehicle['CreatedUser']['Person']['middle_name']; ?>",
				"created":"<?php echo $fms_vehicle['FmsVehicle']['created']; ?>",
				"modified":"<?php echo $fms_vehicle['FmsVehicle']['modified']; ?>"			}
<?php $st = true; } ?>		]
}