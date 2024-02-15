{
	success:true,
	results: <?php echo $results; ?>,
	rows: [
<?php $st = false; foreach($ims_budgets as $ims_budget){ if($st) echo ","; ?>			{
				"id":"<?php echo $ims_budget['ImsBudget']['id']; ?>",
				"name":"<?php echo $ims_budget['ImsBudget']['name']; ?>",
				"budget_year":"<?php echo $ims_budget['BudgetYear']['name']; ?>",
				"branch":"<?php echo $ims_budget['Branch']['name']; ?>",
				"created":"<?php echo $ims_budget['ImsBudget']['created']; ?>",
				"modified":"<?php echo $ims_budget['ImsBudget']['modified']; ?>"			}
<?php $st = true; } ?>		]
}