{
	success:true,
	results: <?php echo $results; ?>,
	rows: [
<?php $st = false; foreach($ims_transfer_item_befores as $ims_transfer_item_before){ if($st) echo ","; ?>			{
				"id":"<?php echo $ims_transfer_item_before['ImsTransferItemBefore']['id']; ?>",
				"ims_transfer_before":"<?php echo $ims_transfer_item_before['ImsTransferBefore']['name']; ?>",
				"ims_sirv_item_before":"<?php echo $ims_transfer_item_before['ImsSirvItemBefore']['id']; ?>",
				"ims_item":"<?php echo $ims_transfer_item_before['ImsItem']['name']; ?>",
				"measurement":"<?php echo $ims_transfer_item_before['ImsTransferItemBefore']['measurement']; ?>",
				"quantity":"<?php echo $ims_transfer_item_before['ImsTransferItemBefore']['quantity']; ?>",
				"unit_price":"<?php echo $ims_transfer_item_before['ImsTransferItemBefore']['unit_price']; ?>",
				"tag":"<?php echo $ims_transfer_item_before['ImsTransferItemBefore']['tag']; ?>",
				"created":"<?php echo $ims_transfer_item_before['ImsTransferItemBefore']['created']; ?>",
				"modified":"<?php echo $ims_transfer_item_before['ImsTransferItemBefore']['modified']; ?>"			}
<?php $st = true; } ?>		]
}