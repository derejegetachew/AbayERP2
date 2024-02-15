{
	success:true,
	results: <?php echo $results; ?>,
	images: [
<?php $st = false; foreach($dms_documents as $dms_document){ if($st) echo ","; ?>			{
				"id":"<?php echo $dms_document['DmsDocument']['id']; ?>",
				"name":"<?php echo $dms_document['DmsDocument']['name']; ?>",
				"shortName":"<?php echo $dms_document['DmsDocument']['name']; ?>",
				"type":"<?php echo $dms_document['DmsDocument']['type']; ?>",
				"user":"<?php echo $dms_document['User']['id']; ?>",
				"parent_dms_document":"<?php echo $dms_document['ParentDmsDocument']['name']; ?>",
				"shared":"<?php echo $dms_document['DmsDocument']['shared']; ?>",
				"size":"<?php echo $dms_document['DmsDocument']['size']; ?>",
				"file_type":"<?php echo $dms_document['DmsDocument']['file_type']; ?>",
				"file_name":"<?php echo $dms_document['DmsDocument']['file_name']; ?>",
				"share_to":"<?php echo $dms_document['DmsDocument']['share_to']; ?>",
				"created":"<?php echo $dms_document['DmsDocument']['created']; ?>",
				"modified":"<?php echo $dms_document['DmsDocument']['modified']; ?>",
				"url":"<?php if($dms_document['DmsDocument']['type']=='folder') echo 'images\/thumbs\/folder.jpg'; ?>"					}
<?php $st = true; } ?>		]
}