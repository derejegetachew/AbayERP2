{
	success:true,
	results: <?php echo $results; ?>,
	rows: [
<?php $st = false; foreach($grns as $grn){ if($st) echo ","; ?>			{
				"id":"<?php echo $grn['g']['id']; ?>",
				"name":"<?php echo $grn['g']['name']; ?>",
				"supplier":"<?php echo $grn['s']['supplier']; ?>",
				"purchase_order":"<?php echo $grn['o']['purchase_order']; ?>",
				"date_purchased":"<?php echo $grn['g']['date_purchased']; ?>",
				"created":"<?php echo $grn['g']['created']; ?>",
				"modified":"<?php echo $grn['g']['modified']; ?>",
                                "status":"<?php echo $grn['g']['status'] ; ?>"         }
<?php $st = true; } ?>		]
}