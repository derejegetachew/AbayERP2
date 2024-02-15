{
	success:true,
	results: <?php echo $results; ?>,
	rows: [
<?php $st = false; foreach($experiences as $experience){ if($st) echo ","; ?>			{
				"id":"<?php echo $experience['Experience']['id']; ?>",
				"employer":"<?php echo $experience['Experience']['employer']; ?>",
				"job_title":"<?php echo $experience['Experience']['job_title']; ?>",
				"from_date":"<?php echo $experience['Experience']['from_date']; ?>",
				"to_date":"<?php echo $experience['Experience']['to_date']; ?>",
				"employee":"<?php echo $experience['Employee']['id']; ?>",
				"created":"<?php echo $experience['Experience']['created']; ?>",
				"modified":"<?php echo $experience['Experience']['modified']; ?>"			}
<?php $st = true; } ?>		]
}