{
	success:true,
	results: <?php echo $results; ?>,
	rows: [
<?php $st = false; foreach($branches as $branch){ if($st) echo ","; ?>			{
				"id":"<?php echo $branch['Branch']['id']; ?>",
				"name":"<?php echo $branch['Branch']['name']; ?>",
				"list_order":"<?php echo $branch['Branch']['list_order']; ?>",
				"fc_code":"<?php echo $branch['Branch']['fc_code']; ?>",
				"bank":"<?php echo $branch['Bank']['name']; ?>",
				"branch_category":"<?php echo $branch['BranchCategory']['name']; ?>",
				"tag_code":"<?php echo $branch['Branch']['tag_code']; ?>",
				"region":"<?php echo $branch['Branch']['region']; ?>",
				"created":"<?php echo $branch['Branch']['created']; ?>",
				"modified":"<?php echo $branch['Branch']['modified']; ?>"			}
<?php $st = true; } ?>		]
}