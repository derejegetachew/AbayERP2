{
	success:true,
	results: <?php echo $results; ?>,
	rows: [
<?php $st = false; foreach($holidays as $holiday){ if($st) echo ","; ?>			{
				"id":"<?php echo $holiday['Holiday']['id']; ?>",
				"employee":"<?php echo $holiday['Employee']['id']; ?>",
				"type":"<?php echo $holiday['Holiday']['type']; ?>",
				"from_date":"<?php echo $holiday['Holiday']['from_date']; ?>",
				"to_date":"<?php echo $holiday['Holiday']['to_date']; ?>",
				"filled_date":"<?php echo $holiday['Holiday']['filled_date']; ?>",
				"status":"<?php echo $holiday['Holiday']['status']; ?>"			}
<?php $st = true; } ?>		]
}