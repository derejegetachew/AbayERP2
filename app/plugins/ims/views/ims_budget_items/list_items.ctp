{
	success:true,
	rows: [
<?php $st = false; foreach($results as $result){ if($st) echo ","; ?>			{
				"id":"<?php echo $result['id']; ?>",
				"name":"<?php echo $result['name']; ?>"
							}
<?php $st = true; } ?>		]
}