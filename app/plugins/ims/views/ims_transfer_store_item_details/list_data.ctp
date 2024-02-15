{
	success:true,
	results: <?php echo $results; ?>,
	rows: [
<?php $st = false; foreach($ims_transfer_store_item_details as $ims_transfer_store_item_detail){ if($st) echo ","; ?>			{
				"id":"<?php echo $ims_transfer_store_item_detail['ImsTransferStoreItemDetail']['id']; ?>",
				"ims_transfer_store_item":"<?php echo $ims_transfer_store_item_detail['ImsTransferStoreItem']['name']; ?>",
				"ims_item":"<?php echo $ims_transfer_store_item_detail['ImsItem']['name']; ?>",
				"quantity":"<?php echo $ims_transfer_store_item_detail['ImsTransferStoreItemDetail']['quantity']; ?>",
				"measurement":"<?php echo $ims_transfer_store_item_detail['ImsTransferStoreItemDetail']['measurement']; ?>",
				"remark":"<?php echo $ims_transfer_store_item_detail['ImsTransferStoreItemDetail']['remark']; ?>",
				"created":"<?php echo $ims_transfer_store_item_detail['ImsTransferStoreItemDetail']['created']; ?>",
				"modified":"<?php echo $ims_transfer_store_item_detail['ImsTransferStoreItemDetail']['modified']; ?>"			}
<?php $st = true; } ?>		]
}