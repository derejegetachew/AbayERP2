{
	success:true,
	results: <?php echo $results; ?>,
	rows: [
<?php $st = false; foreach($languages as $language){ if($st) echo ","; ?>			{
				"id":"<?php echo $language['Language']['id']; ?>",
				"name":"<?php echo $language['Language']['name']; ?>",
				"speak":"<?php echo $language['Language']['speak']; ?>",
				"read":"<?php echo $language['Language']['read']; ?>",
				"write":"<?php echo $language['Language']['write']; ?>",
				"listen":"<?php echo $language['Language']['listen']; ?>",
				"employee":"<?php echo $language['Employee']['id']; ?>",
				"created":"<?php echo $language['Language']['created']; ?>",
				"modified":"<?php echo $language['Language']['modified']; ?>"			}
<?php $st = true; } ?>		]
}