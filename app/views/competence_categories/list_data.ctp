{
	success:true,
	results: <?php echo $results; ?>,
	rows: [
<?php $st = false; foreach($competenceCategories as $competence_category){ if($st) echo ","; ?>			{
				"id":"<?php echo $competence_category['CompetenceCategory']['id']; ?>",
				"name":"<?php echo $competence_category['CompetenceCategory']['name']; ?>"			}
<?php $st = true; } ?>		]
}