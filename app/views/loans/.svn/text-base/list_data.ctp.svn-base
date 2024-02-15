{
	success:true,
	results: <?php echo $results; ?>,
	rows: [
<?php $st = false; foreach($loans as $loan){ if($st) echo ","; ?>			{
				"id":"<?php echo $loan['Loan']['id']; ?>",
				"employee":"<?php echo $loan['Employee']['id']; ?>",
				"Type":"<?php echo $loan['Loan']['Type']; ?>",
				"Per_month":"<?php echo $loan['Loan']['Per_month']; ?>",
				"start":"<?php echo $loan['Loan']['start']; ?>",
				"no_months":"<?php echo $loan['Loan']['no_months']; ?>",
				"total":"<?php echo $loan['Loan']['total']; ?>",
                                "status":"<?php echo $loan['Loan']['status']; ?>" }
<?php $st = true; } ?>		]
}