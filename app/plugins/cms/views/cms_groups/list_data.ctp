{
	success:true,
	results: <?php echo $results; ?>,
	rows: [
<?php $st = false; foreach($cms_groups as $cms_group){ if($st) echo ","; ?>			{
				"id":"<?php echo $cms_group['CmsGroup']['id']; ?>",
				"name":"<?php echo $cms_group['CmsGroup']['name']; ?>",
				"user":"<?php echo $cms_group['User']['Person']['first_name'].' '.$cms_group['User']['Person']['middle_name']; ?>",
				"branch":"<?php echo $cms_group['Branch']['name']; ?>",
				"created":"<?php echo $cms_group['CmsGroup']['created']; ?>",
				"modified":"<?php echo $cms_group['CmsGroup']['modified']; ?>"			}
<?php $st = true; } ?>		]
}