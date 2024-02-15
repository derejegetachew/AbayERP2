{
	success:true,
	results: <?php echo $results; ?>,
	rows: [
<?php $st = false; foreach($sp_regions as $sp_region){ if($st) echo ","; ?>			{
				"id":"<?php echo $sp_region['SpRegion']['id']; ?>",
				"name":"<?php echo $sp_region['SpRegion']['name']; ?>",
				"created":"<?php echo $sp_region['SpRegion']['created']; ?>",
				"modified":"<?php echo $sp_region['SpRegion']['modified']; ?>"			}
<?php $st = true; } ?>		]
}