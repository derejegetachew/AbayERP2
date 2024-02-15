{
	success:true,
	results: <?php echo $results; ?>,
	rows: [
<?php $st = false; foreach($fa_transactions as $fa_transaction){ if($st) echo ","; ?>			{
				"id":"<?php echo $fa_transaction['FaTransaction']['id']; ?>",
				"fa_asset":"<?php echo $fa_transaction['FaAsset']['name']; ?>",
				"tax_depreciated_value":"<?php echo $fa_transaction['FaTransaction']['tax_depreciated_value']; ?>",
				"tax_book_value":"<?php echo $fa_transaction['FaTransaction']['tax_book_value']; ?>",
				"ifrs_depreciated_value":"<?php echo $fa_transaction['FaTransaction']['ifrs_depreciated_value']; ?>",
				"ifrs_book_value":"<?php echo $fa_transaction['FaTransaction']['ifrs_book_value']; ?>",
				"budget_year":"<?php echo $fa_transaction['BudgetYear']['name']; ?>"			}
<?php $st = true; } ?>		]
}