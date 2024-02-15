{
	success:true,
	results: <?php echo $results; ?>,
	rows: [
<?php $st = false; foreach($cms_cases as $cms_case){if($st) echo ","; ?>			{
				'id':'<?php echo $cms_case['CmsCase']['id']; ?>',
				'case':'<div style="padding: 3px; border: 0px solid lightgray; pointer-events:none;"> ' +
						'<table style="width:100%"> ' +
							'<tr> ' +
								'<td width="30%" > ' +
									'<h1 style="margin: 0px;font-size: 13px;color: green;"> <?php $text = wordwrap($cms_case['CmsCase']['name'], 50, "<br />", false); echo $text; ?> </h1> ' +
									<!--'<p  style="margin: 0px; padding: 5px; font-family: helvetica; font-size: 15px;color: gray;"> <?php $text = wordwrap($cms_case['CmsReply']['0']['content'],122,'>--<'); $result = explode('>--<',$text); if(count($result) >0)//echo str_replace('<br />',' ',$result[0])?>' +--> 
								'</td>' +
								
							'</tr>' +
						'</table>' +
					'</div>',
				"level":"<?php echo $cms_case['CmsCase']['level']; ?>",
				"ticket":"<?php echo $cms_case['CmsCase']['ticket_number']; ?>",
				"branch":"<?php $result = $this->requestAction(
						array(
							'controller' => 'cms_cases', 
							'action' => 'GetBranch'), 
						array('userid' => $cms_case['CmsCase']['user_id']));echo $result; ?>",
				"status":"<?php echo $cms_case['CmsCase']['status']; ?>",
				"user":"<?php $result = $this->requestAction(
						array(
							'controller' => 'cms_cases', 
							'action' => 'GetEmpName'), 
						array('userid' => $cms_case['CmsCase']['user_id']));echo $result; ?>",
				"assignedTo":"<?php $result = $this->requestAction(
						array(
							'controller' => 'cms_cases', 
							'action' => 'GetAssignedEmpName'), 
						array('caseid' => $cms_case['CmsCase']['id']));echo $result; ?>",
				"user_id":"<?php echo $cms_case['CmsCase']['user_id']; ?>",
				"searchable":"<?php echo $cms_case['CmsCase']['searchable']; ?>",
				"created":"<?php $user_tz="Africa/Addis_Ababa";
						$result = DATE_FORMAT(new DateTime($cms_case['CmsCase']['created']),"M d Y h:i a");
						$schedule_date = new DateTime($cms_case['CmsCase']['created'], new DateTimeZone('UTC') );
						$schedule_date->setTimeZone(new DateTimeZone($user_tz));
						$result =  $schedule_date->format('M d Y h:i a');
						
						echo $cms_case['CmsCase']['created']; ?>",
				"modified":"<?php echo $cms_case['CmsCase']['modified']; ?>"			}
<?php $st = true; } ?>		]
}