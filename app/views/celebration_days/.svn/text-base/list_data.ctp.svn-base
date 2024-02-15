{
	success:true,
	results: <?php echo $results; ?>,
	rows: [
<?php $st = false; foreach($celebration_days as $celebration_day){ if($st) echo ","; ?>			{
				"id":"<?php echo $celebration_day['CelebrationDay']['id']; ?>",
				"day":"<?php echo $celebration_day['CelebrationDay']['day']; ?>",
				"name":"<?php echo $celebration_day['CelebrationDay']['name']; ?>",
				"budget_year":"<?php echo $celebration_day['BudgetYear']['name']; ?>"			}
<?php $st = true; } ?>		]
}