{
	success:true,
	results: <?php echo $results; ?>,
	rows: [
<?php $st = false; foreach($ims_sirv_items as $ims_sirv_item){ if($st) echo ","; ?>			{
				"id":"<?php echo $ims_sirv_item['ImsSirvItem']['id']; ?>",
				"ims_sirv":"<?php echo $ims_sirv_item['ImsSirv']['name']; ?>",
				"ims_item":"<?php echo $ims_sirv_item['ImsItem']['name']; ?>",
				"measurement":"<?php echo $ims_sirv_item['ImsSirvItem']['measurement']; ?>",
				"quantity":"<?php echo $ims_sirv_item['ImsSirvItem']['quantity']; ?>",
				"unit_price":"<?php echo $ims_sirv_item['ImsSirvItem']['unit_price']; ?>",
				"remark":"<?php echo $ims_sirv_item['ImsSirvItem']['remark']; ?>"			}
<?php $st = true; } ?>		]
}