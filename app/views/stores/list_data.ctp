{
	success:true,
	results: <?php echo $results; ?>,
	rows: [
<?php $st = false; foreach($stores as $store){ if($st) echo ","; ?>			{
            "id":"<?php echo $store['Store']['id']; ?>",
            "name":"<?php echo $store['Store']['name']; ?>",
            "address":"<?php echo $store['Store']['address']; ?>",
            "created":"<?php echo $store['Store']['created']; ?>",
            "modified":"<?php echo $store['Store']['modified']; ?>"			}
<?php $st = true; } ?>		]
}