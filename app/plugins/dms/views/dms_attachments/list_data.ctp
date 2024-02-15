{
	success:true,
	results: <?php echo $results; ?>,
	rows: [
<?php $st = false; foreach($dms_attachments as $dms_attachment){ if($st) echo ","; ?>			{
				"id":"<?php echo $dms_attachment['DmsAttachment']['id']; ?>",
				"name":"<?php echo $dms_attachment['DmsAttachment']['name']; ?>",
				"file":"<?php echo $dms_attachment['DmsAttachment']['file']; ?>",
				"dms_message":"<?php echo $dms_attachment['DmsMessage']['name']; ?>",
				"created":"<?php echo $dms_attachment['DmsAttachment']['created']; ?>"			}
<?php $st = true; } ?>		]
}