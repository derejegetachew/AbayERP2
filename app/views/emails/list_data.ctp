{
	success:true,
	results: <?php echo $results; ?>,
	rows: [
<?php $st = false; foreach($emails as $email){ if($st) echo ","; ?>			{
				"id":"<?php echo $email['Email']['id']; ?>",
				"name":"<?php echo $email['Email']['name']; ?>",
				"from_name":"<?php echo $email['Email']['from_name']; ?>",
				"from":"<?php echo $email['Email']['from']; ?>",
				"to":"<?php echo $email['Email']['to']; ?>",
				"status":"<?php echo $email['Email']['status']; ?>"			}
<?php $st = true; } ?>		]
}