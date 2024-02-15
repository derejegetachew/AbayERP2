{
	success:true,
	results: <?php echo $results; ?>,
	rows: [
<?php $st = false; foreach($ims_stores_items as $ims_stores_item){ if($st) echo ","; ?>			{
				"id":"<?php echo $ims_stores_item['ImsStoresItem']['id']; ?>",
				"ims_store":"<?php echo $ims_stores_item['ImsStore']['name']; ?>",
				"ims_item":"<?php echo $ims_stores_item['ImsItem']['name']; ?>",
				"balance":"<?php echo $ims_stores_item['ImsStoresItem']['balance']; ?>",
				"created":"<?php echo $ims_stores_item['ImsStoresItem']['created']; ?>",
				"modified":"<?php echo $ims_stores_item['ImsStoresItem']['modified']; ?>"			}
<?php $st = true; } ?>		]
}