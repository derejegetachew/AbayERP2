{
	success:true,
	results: <?php echo $results; ?>,
	rows: [
<?php $st = false; foreach($competences as $competence){ if($st) echo ","; ?>			{
				"id":"<?php echo $competence['Competence']['id']; ?>",
				"name":"<?php echo $competence['Competence']['name']; ?>",
				"definition":"<?php echo $competence['Competence']['definition']; ?>",
				"competence_category":"<?php echo $competence['CompetenceCategory']['name']; ?>"			}
<?php $st = true; } ?>		]
}