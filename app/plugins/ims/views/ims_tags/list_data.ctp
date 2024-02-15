{
	success:true,
	results: <?php echo $results; ?>,
	rows: [
<?php $st = false; foreach($ims_tags as $ims_tag){ if($st) echo ","; ?>			{
				"id":"<?php echo $ims_tag['ImsTag']['id']; ?>",
				"code":"<?php echo $ims_tag['ImsTag']['code']; ?>",
				"ims_sirv_item":"<?php echo $ims_tag['ImsSirvItem']['id']; ?>",
				"ims_sirv_item_before":"<?php echo $ims_tag['ImsSirvItemBefore']['id']; ?>",
				"created":"<?php echo $ims_tag['ImsTag']['created']; ?>",
				"modified":"<?php echo $ims_tag['ImsTag']['modified']; ?>"			}
<?php $st = true; } ?>		]
}