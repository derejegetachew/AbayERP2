{
	success:true,
	results: <?php echo $results; ?>,
	rows: [
<?php $st = false; foreach($mines as $mine){ if($st) echo ","; ?>			{
				"id":"<?php echo $mine['Mine']['id']; ?>",
				"name":"<?php echo $mine['Mine']['name']; ?>",
				"field":"<?php echo $mine['Mine']['field']; ?>"			}
<?php $st = true; } ?>		]
}