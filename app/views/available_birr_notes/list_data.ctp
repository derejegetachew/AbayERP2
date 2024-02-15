{
	success:true,
	results: <?php echo $results; ?>,
	rows: [
<?php $st = false; foreach($availableBirrNotes as $available_birr_note){ if($st) echo ","; ?>			{
				"id":"<?php echo $available_birr_note['AvailableBirrNote']['id']; ?>",
				"old_10_birr":"<?php echo $available_birr_note['AvailableBirrNote']['old_10_birr']; ?>",
				"old_50_birr":"<?php echo $available_birr_note['AvailableBirrNote']['old_50_birr']; ?>",
				"old_100_birr":"<?php echo $available_birr_note['AvailableBirrNote']['old_100_birr']; ?>",
				"new_200_birr":"<?php echo $available_birr_note['AvailableBirrNote']['new_200_birr']; ?>",
				"new_100_birr":"<?php echo $available_birr_note['AvailableBirrNote']['new_100_birr']; ?>",
				"new_50_birr":"<?php echo $available_birr_note['AvailableBirrNote']['new_50_birr']; ?>",
				"new_10_birr":"<?php echo $available_birr_note['AvailableBirrNote']['new_10_birr']; ?>",
				"new_5_birr":"<?php echo $available_birr_note['AvailableBirrNote']['new_5_birr']; ?>",
				"new_1_birr":"<?php echo $available_birr_note['AvailableBirrNote']['new_1_birr']; ?>",
				"new_50_cents":"<?php echo $available_birr_note['AvailableBirrNote']['new_50_cents']; ?>",
				"new_25_cents":"<?php echo $available_birr_note['AvailableBirrNote']['new_25_cents']; ?>",
				"new_10_cents":"<?php echo $available_birr_note['AvailableBirrNote']['new_10_cents']; ?>",
				"new_5_cents":"<?php echo $available_birr_note['AvailableBirrNote']['new_5_cents']; ?>",
				"date_of":"<?php echo $available_birr_note['AvailableBirrNote']['date_of']; ?>",
				"created":"<?php echo $available_birr_note['AvailableBirrNote']['created']; ?>",
				"updated":"<?php echo $available_birr_note['AvailableBirrNote']['updated']; ?>"			}
<?php $st = true; } ?>		]
}