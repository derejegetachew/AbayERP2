{
	success:true,
	current:<?php echo $current; ?>,
	results: <?php echo $results; ?>,
	images: [
<?php $st = false; foreach($dms_documents as $dms_document){ if($st) echo ","; ?>			{
				"id":"<?php echo $dms_document['DmsDocument']['id']; ?>",
				"name":"<?php echo $dms_document['DmsDocument']['name']; ?>",
				"tag":"<?php if(isset($dms_document['DmsDocument']['tag'])) echo $dms_document['DmsDocument']['tag']; ?>",
				"countch":"<?php if(isset($dms_document['DmsDocument']['countch'])) echo $dms_document['DmsDocument']['countch'];?>",
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
				"url":"<?php 
				        if($dms_document['DmsDocument']['type']=='folder'){ 
							if($dms_document['DmsDocument']['shared']==1)
								echo 'img\/dms_icons\/foldershared.png';
							else
						      echo 'img\/dms_icons\/folder.png';
						}else { 
							if($dms_document['DmsDocument']['file_type']=='application')
								echo 'img\/dms_icons\/application.png';
							elseif($dms_document['DmsDocument']['file_type']=='video')
								echo 'img\/dms_icons\/video.png';
							elseif($dms_document['DmsDocument']['file_type']=='audio')
								echo 'img\/dms_icons\/audio.png';
							elseif($dms_document['DmsDocument']['file_type']=='image')
								echo 'img\/dms_icons\/image.png';
							elseif($dms_document['DmsDocument']['file_type']=='compressed')
								echo 'img\/dms_icons\/compressed.png';
							elseif($dms_document['DmsDocument']['file_type']=='document')
								echo 'img\/dms_icons\/document.png';
							else
								echo 'img\/dms_icons\/file.png';
								
						}
						?>"	}
<?php $st = true; } ?>		]
}