{
	success:true,
	results: <?php echo $results; ?>,
	rows: [
<?php $st = false; foreach($scales as $scale){ if($st) echo ","; ?>			{
				"id":"<?php echo $scale['Scale']['id']; ?>",
				"grade":"<?php echo $scale['Grade']['name']; ?>",
				"step":"<?php echo $scale['Step']['name']; ?>",
				"salary":"<?php echo $scale['Scale']['salary']; ?>"			}
<?php $st = true; } ?>		]
}