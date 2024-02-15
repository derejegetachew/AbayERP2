{
	success:true,
	results: <?php echo $results; ?>,
	rows: [
<?php $st = false; foreach($competenceSettings as $competence_setting){ if($st) echo ","; ?>			{
				"id":"<?php echo $competence_setting['CompetenceSetting']['id']; ?>",
				"grade":"<?php echo $competence_setting['Grade']['name']; ?>",
				"competence":"<?php echo $competence_setting['Competence']['name']; ?>",
				"expected_competence":"<?php echo $competence_setting['CompetenceSetting']['expected_competence']; ?>",
				"weight":"<?php echo $competence_setting['CompetenceSetting']['weight']; ?>"			}
<?php $st = true; } ?>		]
}