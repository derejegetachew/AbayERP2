{
	success:true,
	results: <?php echo $results; ?>,
	rows: [
<?php $st = false; foreach($text_messages as $text_message){ if($st) echo ","; ?>			{
				"id":"<?php echo $text_message['TextMessage']['id']; ?>",
				"name":"<?php echo $text_message['TextMessage']['name']; ?>",
				"text":"<?php echo $text_message['TextMessage']['text']; ?>",
				"status":"<?php echo $text_message['TextMessage']['status']; ?>"			}
<?php $st = true; } ?>		]
}