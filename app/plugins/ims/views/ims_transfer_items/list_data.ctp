{
	success:true,
	results: <?php echo $results; ?>,
	rows: [
<?php $st = false; foreach($ims_transfer_items as $ims_transfer_item){ if($st) echo ","; ?>			{
				"id":"<?php echo $ims_transfer_item['ImsTransferItem']['id']; ?>",
				"ims_transfer":"<?php echo $ims_transfer_item['ImsTransfer']['name']; ?>",
				"ims_item":"<?php echo $ims_transfer_item['ImsItem']['name']; ?>",
				"quantity":"<?php echo $ims_transfer_item['ImsTransferItem']['quantity']; ?>",
				"unit_price":"<?php echo $ims_transfer_item['ImsTransferItem']['unit_price']; ?>",
				"tag":"<?php echo $ims_transfer_item['ImsTransferItem']['tag']; ?>",
				"created":"<?php echo $ims_transfer_item['ImsTransferItem']['created']; ?>",
				"modified":"<?php echo $ims_transfer_item['ImsTransferItem']['modified']; ?>"			}
<?php $st = true; } ?>		]
}