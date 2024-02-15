{
	success:true,
	results: <?php echo $results; ?>,
	rows: [
<?php $st = false; foreach($ims_disposal_items as $ims_disposal_item){ if($st) echo ","; ?>			{
				"id":"<?php echo $ims_disposal_item['ImsDisposalItem']['id']; ?>",
				"ims_disposal":"<?php echo $ims_disposal_item['ImsDisposal']['name']; ?>",
				"ims_item":"<?php echo $ims_disposal_item['ImsItem']['name']; ?>",
				"measurement":"<?php echo $ims_disposal_item['ImsDisposalItem']['measurement']; ?>",
				"quantity":"<?php echo $ims_disposal_item['ImsDisposalItem']['quantity']; ?>",
				"remark":"<?php echo $ims_disposal_item['ImsDisposalItem']['remark']; ?>",
				"created":"<?php echo $ims_disposal_item['ImsDisposalItem']['created']; ?>",
				"modified":"<?php echo $ims_disposal_item['ImsDisposalItem']['modified']; ?>"			}
<?php $st = true; } ?>		]
}