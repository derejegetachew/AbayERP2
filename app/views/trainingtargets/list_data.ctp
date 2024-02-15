{
	success:true,
	results: <?php echo $results; ?>,
	rows: [
<?php $st = false; foreach($trainingtargets as $trainingtarget){ if($st) echo ","; ?>			{
				"id":"<?php echo $trainingtarget['Trainingtarget']['id']; ?>",
				"name":"<?php echo $trainingtarget['Trainingtarget']['name']; ?>",
				"created":"<?php echo $trainingtarget['Trainingtarget']['created']; ?>",
				"modified":"<?php echo $trainingtarget['Trainingtarget']['modified']; ?>"			}
<?php $st = true; } ?>		]
}