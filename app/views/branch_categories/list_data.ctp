{
	success:true,
	results: <?php echo $results; ?>,
	rows: [
<?php $st = false; foreach($branch_categories as $branch_category){ if($st) echo ","; ?>			{
				"id":"<?php echo $branch_category['BranchCategory']['id']; ?>",
				"name":"<?php echo $branch_category['BranchCategory']['name']; ?>",
				"created":"<?php echo $branch_category['BranchCategory']['created']; ?>",
				"modified":"<?php echo $branch_category['BranchCategory']['modified']; ?>"			}
<?php $st = true; } ?>		]
}