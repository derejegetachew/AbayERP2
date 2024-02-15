{
	success:true,
	results: <?php echo $results; ?>,
	rows: [
<?php $st = false; foreach($ims_Requisition_Items as $ims_Requisition_Item){ if($st) echo ","; ?>			{
				"code":"<?php echo $ims_Requisition_Item['ImsItem']['description']; ?>",
				"description":"<?php echo $ims_Requisition_Item['ImsItem']['name']; ?>",
				"measurement":"<?php echo $ims_Requisition_Item['ImsRequisitionItem']['measurement']; ?>",
				"quantity":"<?php echo $ims_Requisition_Item['ImsRequisitionItem']['issued']; ?>",
				"remark":"<?php echo $ims_Requisition_Item['ImsRequisitionItem']['remark']; ?>"	,
				"serial":"" }
<?php $st = true; } ?>		]
}