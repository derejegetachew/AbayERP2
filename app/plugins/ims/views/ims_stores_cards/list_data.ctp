{
	success:true,
	results: <?php echo $results; ?>,
	rows: [
<?php $st = false; foreach($ims_stores_cards as $ims_stores_card){ if($st) echo ","; ?>			{
				"id":"<?php echo $ims_stores_card['ImsStoresCard']['id']; ?>",
				"ims_store":"<?php echo $ims_stores_card['ImsStore']['name']; ?>",
				"ims_requisition":"<?php echo $ims_stores_card['ImsRequisition']['name']; ?>",
				"ims_card":"<?php echo $ims_stores_card['ImsCard']['id']; ?>",
				"created":"<?php echo $ims_stores_card['ImsStoresCard']['created']; ?>",
				"modified":"<?php echo $ims_stores_card['ImsStoresCard']['modified']; ?>"			}
<?php $st = true; } ?>		]
}