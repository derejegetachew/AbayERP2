{
	success:true,
	results: <?php echo $results; ?>,
	rows: [
<?php $st = false; foreach($disciplinary_records as $disciplinary_record){ if($st) echo ","; ?>			{
				"id":"<?php echo $disciplinary_record['DisciplinaryRecord']['id']; ?>",
				"employee":"<?php echo $disciplinary_record['Employee']['id']; ?>",
				"type":"<?php echo $disciplinary_record['DisciplinaryRecord']['type']; ?>",
				"start":"<?php echo $disciplinary_record['DisciplinaryRecord']['start']; ?>",
				"end":"<?php echo $disciplinary_record['DisciplinaryRecord']['end']; ?>",
				"remark":"<?php echo $disciplinary_record['DisciplinaryRecord']['remark']; ?>",
				"created":"<?php echo $disciplinary_record['DisciplinaryRecord']['created']; ?>",
				"modified":"<?php echo $disciplinary_record['DisciplinaryRecord']['modified']; ?>"			}
<?php $st = true; } ?>		]
}