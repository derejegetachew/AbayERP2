{
	success:true,
	results: <?php echo $results; ?>,
	rows: [
<?php $st = false; foreach($confirmations as $confirmation){ if($st) echo ","; ?>			{
				"id":"<?php echo $confirmation['Confirmation']['id']; ?>",
				"user":"<?php echo $confirmation['User']['Person']['first_name'].' '.$confirmation['User']['Person']['middle_name']; ?>",
				"confirmation_code":"<?php echo $confirmation['Confirmation']['confirmation_code']; ?>",
				"status":"<?php echo $confirmation['Confirmation']['status']; ?>"			}
<?php $st = true; } ?>		]
}