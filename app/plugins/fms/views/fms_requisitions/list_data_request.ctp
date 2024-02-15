{
	success:true,
	results: <?php echo $results; ?>,
	rows: [
<?php $st = false; foreach($fms_requisitions as $fms_requisition){ if($st) echo ","; ?>			{
				"id":"<?php echo $fms_requisition['FmsRequisition']['id']; ?>",
				"name":"<?php echo $fms_requisition['FmsRequisition']['name']; ?>",
				"requested_by":"<?php echo $fms_requisition['RequestedUser']['Person']['first_name'].' '.$fms_requisition['RequestedUser']['Person']['middle_name']; ?>",
				"approved_by":"<?php echo $fms_requisition['FmsRequisition']['approved_by'] <> 0? $fms_requisition['ApprovedUser']['Person']['first_name'].' '.$fms_requisition['ApprovedUser']['Person']['middle_name']: ''; ?>",
				"branch":"<?php echo $fms_requisition['Branch']['name']; ?>",
				"town":"<?php echo $fms_requisition['FmsRequisition']['town']; ?>",
				"place":"<?php echo $fms_requisition['FmsRequisition']['place']; ?>",
				"departure_date":"<?php echo $fms_requisition['FmsRequisition']['departure_date']; ?>",
				"arrival_date":"<?php echo $fms_requisition['FmsRequisition']['arrival_date']; ?>",
				"departure_time":"<?php echo $fms_requisition['FmsRequisition']['departure_time']; ?>",
				"arrival_time":"<?php echo $fms_requisition['FmsRequisition']['arrival_time']; ?>",
				"travelers":"<?php echo $fms_requisition['FmsRequisition']['travelers']; ?>",
				"fms_vehicle":"<?php echo $fms_requisition['FmsVehicle']['id']; ?>",
				"start_odometer":"<?php echo $fms_requisition['FmsRequisition']['start_odometer']; ?>",
				"end_odometer":"<?php echo $fms_requisition['FmsRequisition']['end_odometer']; ?>",
				"transport_clerk":"<?php echo $fms_requisition['FmsRequisition']['transport_clerk']; ?>",
				"transport_supervisor":"<?php echo $fms_requisition['FmsRequisition']['transport_supervisor']; ?>",
				"status":"<?php echo $fms_requisition['FmsRequisition']['status']; ?>",
				"created":"<?php echo $fms_requisition['FmsRequisition']['created']; ?>",
				"modified":"<?php echo $fms_requisition['FmsRequisition']['modified']; ?>"			}
<?php $st = true; } ?>		]
}