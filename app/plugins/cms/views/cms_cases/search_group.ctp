{
	success:true,
	results: <?php echo $results; ?>,
	rows: [
<?php $st = false; foreach($groups as $group){ if($st) echo ","; ?>			{
				"id":"<?php echo $group['CmsGroup']['id']; ?>",
				"name":"<?php echo $group['CmsGroup']['name']; ?>"		}
<?php $st = true; } ?>		]
}