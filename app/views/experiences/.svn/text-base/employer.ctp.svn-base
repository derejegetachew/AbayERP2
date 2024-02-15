{
	success:true,
	results: <?php echo $results; ?>,
	rows: [
<?php $st = false; foreach($experiences as $experience){ if($st) echo ","; ?>			{
				"id":"<?php echo $experience['Experience']['id']; ?>",
				"employer":"<?php echo $experience['Experience']['employer']; ?>",
				"job_title":"<?php echo $experience['Experience']['job_title']; ?>"			}
<?php $st = true; } ?>		]
}