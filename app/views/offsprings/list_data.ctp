{
	success:true,
	results: <?php echo $results; ?>,
	rows: [
<?php $st = false; foreach($offsprings as $offspring){ if($st) echo ","; ?>			{
				"id":"<?php echo $offspring['Offspring']['id']; ?>",
				"first_name":"<?php echo $offspring['Offspring']['first_name']; ?>",
				"last_name":"<?php echo $offspring['Offspring']['last_name']; ?>",
				"sex":"<?php echo $offspring['Offspring']['sex']; ?>",
				"birth_date":"<?php echo $offspring['Offspring']['birth_date']; ?>",
				"employee":"<?php echo $offspring['Employee']['id']; ?>",
				"created":"<?php echo $offspring['Offspring']['created']; ?>",
				"modified":"<?php echo $offspring['Offspring']['modified']; ?>"			}
<?php $st = true; } ?>		]
}