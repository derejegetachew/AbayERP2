{
	success:true,
	results: <?php echo $results; ?>,
	rows: [
<?php $st = false; foreach($cms_attachments as $cms_attachment){ if($st) echo ","; ?>			{
				"id":"<?php echo $cms_attachment['CmsAttachment']['id']; ?>",
				"file":"<?php echo $cms_attachment['CmsAttachment']['file']; ?>",
				"name":"<?php echo $cms_attachment['CmsAttachment']['name']; ?>",
				"created":"<?php echo $cms_attachment['CmsAttachment']['created']; ?>",
				"cms_reply":"<?php echo $cms_attachment['CmsReply']['id']; ?>"			}
<?php $st = true; } ?>		]
}