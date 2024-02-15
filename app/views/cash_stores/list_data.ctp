{
	success:true,
	results: <?php echo $results; ?>,
	rows: [
<?php $st = false; foreach($cash_stores as $cash_store){ if($st) echo ","; ?>			{
				"id":"<?php echo $cash_store['CashStore']['id']; ?>",
				"account_no":"<?php echo $cash_store['CashStore']['account_no']; ?>",
				"employee":"<?php echo $cash_store['Employee']['id']; ?>",
				"value":"<?php echo $cash_store['CashStore']['value']; ?>",
				"budget_year":"<?php echo $cash_store['BudgetYear']['name']; ?>"			}
<?php $st = true; } ?>		]
}