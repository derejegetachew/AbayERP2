{
	success:true,
	results: <?php echo $results; ?>,
	rows: [
<?php $st = false; foreach($educations as $education){ if($st) echo ","; ?>			{
				"id":"<?php echo $education['Education']['id']; ?>",
				"level_of_attainment":"<?php echo $education['Education']['level_of_attainment']; ?>",
				"field_of_study":"<?php echo $education['Education']['field_of_study']; ?>",
				"institution":"<?php echo $education['Education']['institution']; ?>",
				"from_date":"<?php echo $education['Education']['from_date']; ?>",
				"to_date":"<?php echo $education['Education']['to_date']; ?>",
				"is_bank_related":"<?php echo $education['Education']['is_bank_related']; ?>",
				"employee":"<?php echo $education['Employee']['id']; ?>",
				"created":"<?php echo $education['Education']['created']; ?>",
				"modified":"<?php echo $education['Education']['modified']; ?>"			}
<?php $st = true; } ?>		]
}