{
	success:true,
	results: <?php echo $results; ?>,
	rows: [
<?php $st = false; foreach($mis_letter_details as $mis_letter_detail){ if($st) echo ","; ?>			{
				"id":"<?php echo $mis_letter_detail['MisLetterDetail']['id']; ?>",
				"mis_letter":"<?php echo $mis_letter_detail['MisLetter']['id']; ?>",
				"type":"<?php echo $mis_letter_detail['MisLetterDetail']['type']; ?>",
				"account_of":"<?php echo $mis_letter_detail['MisLetterDetail']['account_of']; ?>",
				"account_number":"<?php echo $mis_letter_detail['MisLetterDetail']['account_number']; ?>",
				"amount":"<?php echo $mis_letter_detail['MisLetterDetail']['amount']; ?>",
				"branch":"<?php echo $mis_letter_detail['Branch']['name']; ?>",
				"parent_status":"<?php echo $mis_letter_detail['MisLetter']['status']; ?>",
				"status":"<?php echo $mis_letter_detail['MisLetterDetail']['status']; ?>",
				"created_by":"<?php echo $mis_letter_detail['CreatedUser']['Person']['first_name'].' '.$mis_letter_detail['CreatedUser']['Person']['middle_name'].' '.$mis_letter_detail['CreatedUser']['Person']['last_name']; ?>",
				"replied_by":"<?php echo $mis_letter_detail['RepliedUser']['Person']['first_name'].' '.$mis_letter_detail['RepliedUser']['Person']['middle_name'].' '.$mis_letter_detail['RepliedUser']['Person']['last_name']; ?>",
				"completed_by":"<?php echo $mis_letter_detail['CompletedUser']['Person']['first_name'].' '.$mis_letter_detail['CompletedUser']['Person']['middle_name'].' '.$mis_letter_detail['CompletedUser']['Person']['last_name']; ?>",
				"letter_prepared_by":"<?php echo $mis_letter_detail['LetterPreparedUser']['Person']['first_name'].' '.$mis_letter_detail['LetterPreparedUser']['Person']['middle_name'].' '.$mis_letter_detail['LetterPreparedUser']['Person']['last_name']; ?>",
				"remark":"<?php echo $mis_letter_detail['MisLetterDetail']['remark']; ?>",
				"file":"<?php echo $mis_letter_detail['MisLetterDetail']['file']; ?>",
				"created":"<?php echo $mis_letter_detail['MisLetterDetail']['created']; ?>",
				"modified":"<?php echo $mis_letter_detail['MisLetterDetail']['modified']; ?>"			}
<?php $st = true; } ?>		]
}