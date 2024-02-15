{
	success:true,
	results: <?php echo $results; ?>,
	rows: [
<?php $st = false; foreach($competenceLevels as $competence_level){ if($st) echo ","; ?>			{
				"id":"<?php echo $competence_level['CompetenceLevel']['id']; ?>",
				"name":"<?php echo $competence_level['CompetenceLevel']['name']; ?>"			}
<?php $st = true; } ?>		]
}