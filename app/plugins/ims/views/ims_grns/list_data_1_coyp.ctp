{
	success:true,
	results: <?php echo $results; ?>,
	rows: [
<?php $st = false; foreach($grns as $grn){ if($st) echo ","; ?>			{
				"id":"<?php echo $grn['ImsGrn']['id']; ?>",
				"name":"<?php echo $grn['ImsGrn']['name']; ?>",
				"supplier":"<?php echo $grn['ImsSupplier']['name']; ?>",
				"purchase_order":"<?php echo $grn['ImsPurchaseOrder']['name']; ?>",
				"date_purchased":"<?php echo $grn['ImsGrn']['date_purchased']; ?>",
				"created":"<?php echo $grn['ImsGrn']['created']; ?>",
				"modified":"<?php echo $grn['ImsGrn']['modified']; ?>",
                                "status":"<?php echo $grn['ImsGrn']['status'] ; ?>"         }
<?php $st = true; } ?>		]
}