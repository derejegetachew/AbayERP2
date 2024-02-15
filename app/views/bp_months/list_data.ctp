{
	success:true,
	results: <?php echo $results; ?>,
	rows: [
<?php $st = false; foreach($bp_months as $bp_month){ if($st) echo ","; ?>			{
				"id":"<?php echo $bp_month['BpMonth']['id']; ?>",
				"name":"<?php echo $bp_month['BpMonth']['name']; ?>"			}
<?php $st = true; } ?>		]
}