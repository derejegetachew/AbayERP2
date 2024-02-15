{
	success:true,
	results: <?php echo $results; ?>,
	rows: [
<?php $st = false; foreach($fields as $field){ if($st) echo ","; ?>			{
				"id":"<?php echo $field['Field']['id']; ?>",
				"name":"<?php echo $field['Field']['name']; ?>",
				"type":"<?php echo $field['Field']['type']; ?>",
				"store":"<?php echo $field['Field']['store']; ?>"			}
<?php $st = true; } ?>		]
}