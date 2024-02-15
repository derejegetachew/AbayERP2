{
	success:true,
	results: <?php echo $results;  
		$user = $this->Session->read();	
		$user_id = $user['Auth']['User']['id'];?>,
	rows: [
<?php $st = false; foreach($dms_messages as $dms_message){ if($st) echo ","; ?>			{
				"id":"<?php echo $dms_message['DmsMessage']['id']; ?>",
				"name":'<div style="pointer-events:none;"> ' +
						'<table style="width:100%"> ' +
							'<tr> ' +
								'<td> ' +
									'<h1 style="margin: 0px;font-size: 12px;font-weight:lighter"> <?php 
									foreach($dms_message['DmsRecipient'] as $recp){
									if($recp['user_id']==$user_id && $recp['read']=='false') 
									echo '<h1 style="font-size: 12px;">'; }
									echo $dms_message['DmsMessage']['name']; ?> </h1> ' +
									'<p  style="margin: 0px; padding: 3px; font-family: helvetica; font-size: 10px;color: gray;"> <?php $text = wordwrap($dms_message['DmsMessage']['message'],122,'>--<'); $result = explode('>--<',$text); if(count($result) >0)echo str_replace('<br />',' ',$result[0])?>' + 
								'</td>' +
								'<td>' +
									'<p style="padding-right: 25px; float:right">From <b> <?php echo $dms_message['User']['Person']['first_name'].' '.$dms_message['User']['Person']['middle_name']; ?></b></br>' +
									'<?php echo $dms_message['DmsMessage']['created']; ?></p>' +
								'</td>' +
							'</tr>' +
						'</table>' +
					'</div>',
				"user":"<?php echo $dms_message['User']['id']; ?>",
				"created":"<?php echo $dms_message['DmsMessage']['created']; ?>",
				"message":'<div style="padding: 3px;margin-bottom: 25px"> ' +
						'<table style="width:100%"> ' +
							'<tr> ' +
								'<td colspan=2> ' +
									'<div  style="margin: 0px; padding: 5px; font-family: tahoma;font-size: 13px;color: black; white-space: normal;"> <?php echo $dms_message['DmsMessage']['message'];?></br></div>' + 
								'</td>' +								
							'</tr>' +
							'<tr>'+
								'<td><?php if(count($dms_message['DmsAttachment']) >0){?><hr><span style="color:brown;">Attachments</span></br></br><?php }?>' +
									'<?php foreach($dms_message['DmsAttachment'] as $attachment){
										echo '<a href="'.$this->Html->url(array('controller' => 'dmsAttachments', 'action' => 'download')).'/'.$attachment['id'].'">'.$attachment['name'].'</a>&nbsp&nbsp&nbsp';
									}
									?>'+
								'</td>' +
								'<td>' +
									'<p style="padding-right: 25px; float:right;">From <b> <?php echo $dms_message['User']['Person']['first_name'].' '.$dms_message['User']['Person']['middle_name']; ?></b></br>' +
									'<?php echo $dms_message['DmsMessage']['created']; ?></p>' +
								'</td>' +
							'</tr>' +
						'</table>' +
					'</div>',
				"status":"<?php echo $dms_message['DmsMessage']['status']; ?>",
				"old_record":"<?php echo $dms_message['DmsMessage']['old_record']; ?>",
				"size":"<?php echo $dms_message['DmsMessage']['size']; ?>",
				"number":"<?php echo $dms_message['DmsMessage']['number']; ?>"			}
<?php $st = true; } ?>		]
}