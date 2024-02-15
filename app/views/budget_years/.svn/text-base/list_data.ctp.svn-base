{
	success:true,
	results: <?php echo $results; ?>,
	rows: [
<?php $st = false; foreach($budget_years as $budget_year){ if($st) echo ","; ?>			{
				"id":"<?php echo $budget_year['BudgetYear']['id']; ?>",
				"from_date":"<?php echo $budget_year['BudgetYear']['from_date']; ?>",
				"to_date":"<?php echo $budget_year['BudgetYear']['to_date']; ?>",
				"name":"<?php echo $budget_year['BudgetYear']['name']; ?>"			}
<?php $st = true; } ?>		]
}