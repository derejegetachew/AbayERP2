{
	success:true,
	<?php 
	/*<div id="lst<?php echo $id; ?>" style="display: block;float: left;height: 45px;width: 13px;"><input type="checkbox" value="1" name="check" style="margin-top: 14px;" onclick="if (this.checked) document.getElementById(\'lst<?php echo $id; ?>\').style.backgroundColor=\'lightslategrey\'; else document.getElementById(\'lst<?php echo $id; ?>\').style.backgroundColor=\'unset\';"/></div>*/
	
	//when ever needed to put checkbox use above 
	?>
	results: <?php echo $results;  
		$user = $this->Session->read();	
		$user_id = $user['Auth']['User']['id'];?>,
	rows: [
<?php $st = false; foreach($dms_messages as $dms_message){ if($st) echo ","; ?>			{
				"id":"<?php echo $dms_message['DmsMessage']['id']; $id=$dms_message['DmsMessage']['id'];?>",
				"name":'<div style="pointer-events:none;border-bottom: 1px solid;margin-bottom: -3px;padding-bottom: 10px;" > ' +
						'<table style="width:100%"> ' +
							'<tr> ' +
								'<td style="padding-left:5px;padding-top: 2px;"> ' +
									'<?php 
									echo '<h1 style="color: rgb(128, 128, 128);font-size: 13px;text-transform: capitalize;overflow: hidden;text-overflow: ellipsis;white-space: nowrap;width: 240px;">'.$dms_message['DmsMessage']['Receiver']; ?> </h1> ' +
									'<p style="color: rgb(128, 128, 128);padding-right: 25px; float:left;overflow: hidden;text-overflow: ellipsis;white-space: nowrap;width: 175px;"><span style="color:lightslategrey;font-weight: bold;"><?php echo $dms_message['DmsMessage']['name']; ?></span>' + 
									'</p>' +
										'</td>' +
								'<td>' +
									'<p style="float: right;margin-right: 20px;padding-top: 19px;"><?php echo date("F j, Y",strtotime($dms_message['DmsMessage']['created'])); ?></p>' +
								'</td>' +
							'</tr>' +
						'</table>' +
					'</div>',
				"user":"<?php echo $dms_message['User']['id']; ?>",
				"created":"<?php echo $dms_message['DmsMessage']['created']; ?>",
				"message":'',
				"status":"<?php echo $dms_message['DmsMessage']['status']; ?>",
				"old_record":"<?php echo $dms_message['DmsMessage']['old_record']; ?>",
				"size":"<?php echo $dms_message['DmsMessage']['size']; ?>",
				"number":"<?php echo $dms_message['DmsMessage']['number']; ?>"			}
<?php $st = true; } ?>		]
}