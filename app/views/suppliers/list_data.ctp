{
	success:true,
	results: <?php echo $results; ?>,
	rows: [
<?php $st = false; foreach($suppliers as $supplier){ if($st) echo ","; ?>			{
				"id":"<?php echo $supplier['Supplier']['id']; ?>",
				"name":"<?php echo $supplier['Supplier']['name']; ?>",
				"address":"<?php echo $supplier['Supplier']['address']; ?>",
				"created":"<?php echo $supplier['Supplier']['created']; ?>",
				"modified":"<?php echo $supplier['Supplier']['modified']; ?>"			}
<?php $st = true; } ?>		]
}