{
	success:true,
	results: <?php echo $results; ?>,
	rows: [
<?php $st = false; foreach($terminations as $termination){ if($st) echo ","; ?>			{
				"id":"<?php echo $termination['Termination']['id']; ?>",
				"employee":"<?php echo $termination['Employee']['id']; ?>",
				"reason":"<?php echo $termination['Termination']['reason']; ?>",
				"date":"<?php echo $termination['Termination']['date']; ?>",
				"note":"<?php echo $termination['Termination']['note']; ?>"			}
<?php $st = true; } ?>		]
}