{
	success:true,
	results: <?php echo $results; ?>,
	rows: [
<?php $st = false; foreach($competenceDefinitions as $competence_definition){ if($st) echo ","; ?>			{
				"id":"<?php echo $competence_definition['CompetenceDefinition']['id']; ?>",
				"competence":"<?php echo $competence_definition['Competence']['name']; ?>",
				"competence_level":"<?php echo $competence_definition['CompetenceLevel']['name']; ?>",
				"definition":"<?php echo $competence_definition['CompetenceDefinition']['definition']; ?>"			}
<?php $st = true; } ?>		]
}