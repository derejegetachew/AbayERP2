{
	success:true,
	results: <?php echo $results; ?>,
	rows: [
<?php $st = false; foreach($grns as $grn){ if($st) echo ","; ?>			{
				"id":"<?php echo $grn['Grn']['id']; ?>",
				"name":"<?php echo $grn['Grn']['name']; ?>",
				"supplier":"<?php echo $grn['Supplier']['name']; ?>",
				"purchase_order":"<?php echo $grn['PurchaseOrder']['name']; ?>",
				"date_purchased":"<?php echo $grn['Grn']['date_purchased']; ?>",
				"created":"<?php echo $grn['Grn']['created']; ?>",
				"modified":"<?php echo $grn['Grn']['modified']; ?>",
                                "status":"<?php echo $grn['Grn']['status']; ?>"         }
<?php $st = true; } ?>		]
}