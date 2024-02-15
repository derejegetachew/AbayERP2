{
	success:true,
	results: <?php echo $results; ?>,
	rows: [
<?php $st = false; foreach($ibd_documents as $ibd_document){ if($st) echo ","; ?>			{
				"id":"<?php echo $ibd_document['IbdDocument']['id']; ?>",
				"name":"<?php echo $ibd_document['IbdDocument']['name']; ?>",
				"description":"<?php echo $ibd_document['IbdDocument']['description']; ?>",
				"controller":"<?php echo $ibd_document['IbdDocument']['controller']; ?>",
				"action":"<?php echo $ibd_document['IbdDocument']['action']; ?>",
				"doc_type":"<?php echo $ibd_document['IbdDocument']['doc_type']; ?>",
				"created":"<?php echo $ibd_document['IbdDocument']['created']; ?>",
				"modified":"<?php echo $ibd_document['IbdDocument']['modified']; ?>"			}
<?php $st = true; } ?>		]
}