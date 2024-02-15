{
	success:true,
	results: <?php echo $results; ?>,
	rows: [
<?php $st = false; foreach($leases as $lease){ if($st) echo ","; ?>			{
				"id":"<?php echo $lease['Lease']['id']; ?>",
				"name":"<?php echo $lease['Lease']['name']; ?>",
				"branch_code":"<?php echo $lease['Lease']['branch_code']; ?>",
				"contract_years":"<?php echo $lease['Lease']['contract_years']; ?>",
				"start_date":"<?php echo $lease['Lease']['start_date']; ?>",
				"end_date":"<?php echo $lease['Lease']['end_date']; ?>",
				"total_amount":"<?php echo $lease['Lease']['total_amount']; ?>",
				"paid_years":"<?php echo $lease['Lease']['paid_years']; ?>",
				"paid_amount":"<?php echo $lease['Lease']['paid_amount']; ?>",
				"rent_amount":"<?php echo $lease['Lease']['rent_amount']; ?>",
				"expensed":"<?php echo $lease['Lease']['expensed']; ?>",
				"gl_balance":"<?php echo $lease['Lease']['gl_balance']; ?>",
				"is_lease":"<?php echo $lease['Lease']['is_lease']; ?>",
				"discount":"<?php echo $lease['Lease']['discount']; ?>",
        "rem_year_payment":"<?php echo $lease['Lease']['rem_year_payment']; ?>"		}
<?php $st = true; } ?>		]
}