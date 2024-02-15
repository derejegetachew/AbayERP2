{
	success:true,
	results: <?php echo $results; ?>,
	rows: [
<?php $st = false; foreach($grades as $grade){ if($st) echo ","; ?>			{
				"id":"<?php echo $grade['Grade']['id']; ?>",
				"name":"<?php echo $grade['Grade']['name']; ?>"			}
<?php $st = true; } ?>		]
}