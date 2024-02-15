{
	success:true,
	results: <?php echo $results; ?>,
	rows: [
<?php $st = false; foreach($cms_cases as $cms_case){ if($st) echo ","; ?>			{
				'id':'<?php echo $cms_case['CmsCase']['id']; ?>',
				'case':'<div style="padding: 3px; border: 3px solid lightgray;"> ' +
						'<table> ' +
							'<tr> ' +
								'<td> ' +
									'<h1 style="margin: 0px;font-size: 13px;color: black;"> <?php echo $cms_case['CmsCase']['name']; ?> </h1> ' +
									'<div  style="margin: 0px; padding: 5px; font-family: helvetica; font-size: 15px;color: gray; white-space: normal;"> <?php foreach($cms_case['CmsReply'] as $replies){echo $replies['content'];}?></br></div>' + 
								'</td>' +
								'<td>' +
									'<p style="padding-left: 160px;">by <b> <?php echo $cms_case['User']['username']; ?></b></br>' +
									'<?php echo $cms_case['Branch']['name']; ?></br>' +
									'<?php echo $cms_case['CmsCase']['created']; ?></p>' +
								'</td>' +
							'</tr>' +
						'</table>' +
					'</div>',
				"level":"<?php echo $cms_case['CmsCase']['level']; ?>",
				"status":"<?php echo $cms_case['CmsCase']['status']; ?>",
				"searchable":"<?php echo $cms_case['CmsCase']['searchable']; ?>",
				"modified":"<?php echo $cms_case['CmsCase']['modified']; ?>"			}
<?php $st = true; } ?>		]
}