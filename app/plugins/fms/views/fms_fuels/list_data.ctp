{
	success:true,
	results: <?php echo $results; ?>,
	rows: [
<?php $st = false; foreach($fms_fuels as $fms_fuel){ if($st) echo ","; ?>			{
				"id":"<?php echo $fms_fuel['FmsFuel']['id']; ?>",
				"fms_vehicle":"<?php echo $fms_fuel['FmsVehicle']['plate_no']; ?>",
				"fueled_day":"<?php echo $fms_fuel['FmsFuel']['fueled_day']; ?>",
				"litre":"<?php echo $fms_fuel['FmsFuel']['litre']; ?>",
				"price":"<?php echo $fms_fuel['FmsFuel']['price']; ?>",
				"kilometer":"<?php echo $fms_fuel['FmsFuel']['kilometer']; ?>",
				"driver":"<?php echo $fms_fuel['FmsFuel']['driver']; ?>",
				"round":"<?php echo $fms_fuel['FmsFuel']['round']; ?>",
				"status":"<?php echo $fms_fuel['FmsFuel']['status']; ?>",
				"created_by":"<?php echo $fms_fuel['CreatedUser']['Person']['first_name'].' '.$fms_fuel['CreatedUser']['Person']['middle_name']; ?>",
				"approved_by":"<?php echo $fms_fuel['FmsFuel']['approved_by'] <> 0? $fms_fuel['ApprovedUser']['Person']['first_name'].' '.$fms_fuel['ApprovedUser']['Person']['middle_name']: ''; ?>",
				"created":"<?php echo $fms_fuel['FmsFuel']['created']; ?>",
				"modified":"<?php echo $fms_fuel['FmsFuel']['modified']; ?>"			}
<?php $st = true; } ?>		]
}