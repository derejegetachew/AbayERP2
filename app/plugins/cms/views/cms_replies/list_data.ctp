{
	success:true,
	results: <?php echo $results; ?>,
	rows: [
<?php $st = false; foreach($cms_replies as $cms_reply){ if($st) echo ","; ?>			{
				"id":"<?php echo $cms_reply['CmsReply']['id']; ?>",
				"content":'<div style="padding: 3px;margin-bottom: 25px"> ' +
						'<table style="width:100%"> ' +
							'<tr> ' +
								'<td colspan=2> ' +
									'<div  style="margin: 0px; padding: 5px; font-family: tahoma;font-size: 13px;color: black; white-space: normal;"> <?php echo $cms_reply['CmsReply']['content'];?></br></div>' + 
								'</td>' +								
							'</tr>' +
							'<tr>'+
								'<td><?php if(count($cms_reply['CmsAttachment']) >0){?><hr><span style="color:brown;">Attachments</span></br></br><?php }?>' +
									'<?php foreach($cms_reply['CmsAttachment'] as $attachment){
										echo '<a href="'.$this->Html->url(array('controller' => 'cmsAttachments', 'action' => 'download')).'/'.$attachment['id'].'">'.$attachment['name'].'</a>&nbsp&nbsp&nbsp';
									}
									?>'+
								'</td>' +
								'<td>' +
									'<p style="padding-right: 25px; float:right;">by <b> <?php  $result = explode('~',$this->requestAction(
						array(
							'controller' => 'cms_replies', 
							'action' => 'GetEmpName'), 
						array('userid' => $cms_reply['User']['id'])));echo($result[0]); ?></b></br>' +
									'<?php echo $cms_reply['CmsReply']['created']; ?></p>' +
								'</td>' +
							'</tr>' +
						'</table>' +
					'</div>',
				"cms_case":"<?php echo $cms_reply['CmsCase']['name']; ?>",
				"user":"<?php echo $cms_reply['User']['id']; ?>",
				"created":"<?php echo $cms_reply['CmsReply']['created']; ?>"			}
<?php $st = true; } ?>		]
}