{
	success:true,
	results: <?php echo $results; ?>,
	rows: [
<?php $st = false; foreach($cms_cases as $cms_case){ if($st) echo ","; ?>			{
				"id":"<?php echo $cms_case['CmsCase']['id']; ?>",
				"name":"<?php echo $cms_case['CmsCase']['name']; ?>",
				"content":"<?php echo $cms_case['CmsCase']['content']; ?>",
				"branch":"<?php echo $cms_case['Branch']['name']; ?>",
				"level":"<?php echo $cms_case['CmsCase']['level']; ?>",
				"attachement":"<?php echo $cms_case['CmsCase']['attachement']; ?>",
				"user":"<?php echo $cms_case['User']['id']; ?>",
				"status":"<?php echo $cms_case['CmsCase']['status']; ?>",
				"searchable":"<?php echo $cms_case['CmsCase']['searchable']; ?>",
				"created":"<?php echo $cms_case['CmsCase']['created']; ?>",
				"modified":"<?php echo $cms_case['CmsCase']['modified']; ?>"			}
<?php $st = true; } ?>		]
}