{
	success:true,
	results: <?php echo $results; ?>,
	rows: [
<?php $st = false; foreach($fms_maintenances as $fms_maintenance){ if($st) echo ","; ?>			{
				"id":"<?php echo $fms_maintenance['FmsMaintenance']['id']; ?>",
				"fms_vehicle":"<?php echo $fms_maintenance['FmsVehicle']['plate_no']; ?>",
				"item":"<?php echo $fms_maintenance['FmsMaintenance']['item']; ?>",
				"serial":"<?php echo $fms_maintenance['FmsMaintenance']['serial']; ?>",
				"measurement":"<?php echo $fms_maintenance['FmsMaintenance']['measurement']; ?>",
				"quantity":"<?php echo $fms_maintenance['FmsMaintenance']['quantity']; ?>",
				"unit_price":"<?php echo $fms_maintenance['FmsMaintenance']['unit_price']; ?>",
				"status":"<?php echo $fms_maintenance['FmsMaintenance']['status']; ?>",
				"created_by":"<?php echo $fms_maintenance['CreatedUser']['Person']['first_name'].' '.$fms_maintenance['CreatedUser']['Person']['middle_name']; ?>",
				"approved_by":"<?php echo $fms_maintenance['FmsMaintenance']['approved_by'] <> 0? $fms_maintenance['ApprovedUser']['Person']['first_name'].' '.$fms_maintenance['ApprovedUser']['Person']['middle_name']: ''; ?>",
				"created":"<?php echo $fms_maintenance['FmsMaintenance']['created']; ?>",
				"modified":"<?php echo $fms_maintenance['FmsMaintenance']['modified']; ?>"			}
<?php $st = true; } ?>		]
}