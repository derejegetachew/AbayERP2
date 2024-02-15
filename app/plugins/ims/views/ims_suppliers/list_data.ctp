{
	success:true,
	results: <?php echo $results; ?>,
	rows: [
<?php $st = false; foreach($suppliers as $supplier){ if($st) echo ","; ?>			{
				"id":"<?php echo $supplier['ImsSupplier']['id']; ?>",
				"name":"<?php echo $supplier['ImsSupplier']['name']; ?>",
				"address":"<?php echo $supplier['ImsSupplier']['address']; ?>",
				"tin":"<?php echo $supplier['ImsSupplier']['tin']; ?>",
				"created":"<?php echo $supplier['ImsSupplier']['created']; ?>",
				"modified":"<?php echo $supplier['ImsSupplier']['modified']; ?>"			}
<?php $st = true; } ?>		]
}