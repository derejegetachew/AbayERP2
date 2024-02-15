{
	success:true,
	results: <?php echo $results; ?>,
	rows: [
<?php $st = false; foreach($ims_sirv_item_befores as $ims_sirv_item_before){ if($st) echo ","; ?>			{
				"id":"<?php echo $ims_sirv_item_before['ImsSirvItemBefore']['id']; ?>",
				"ims_sirv_before":"<?php echo $ims_sirv_item_before['ImsSirvBefore']['name']; ?>",
				"ims_item":"<?php echo $ims_sirv_item_before['ImsItem']['name']; ?>",
				"measurement":"<?php echo $ims_sirv_item_before['ImsSirvItemBefore']['measurement']; ?>",
				"quantity":"<?php echo $ims_sirv_item_before['ImsSirvItemBefore']['quantity']; ?>",
				"unit_price":"<?php echo $ims_sirv_item_before['ImsSirvItemBefore']['unit_price']; ?>",
				"remark":"<?php echo $ims_sirv_item_before['ImsSirvItemBefore']['remark']; ?>"			}
<?php $st = true; } ?>		]
}