{
	success:true,
	results: <?php echo $results; ?>,
	rows: [
<?php $st = false; foreach($steps as $step){ if($st) echo ","; ?>			{
				"id":"<?php echo $step['Step']['id']; ?>",
				"name":"<?php echo $step['Step']['name']; ?>"			}
<?php $st = true; } ?>		]
}