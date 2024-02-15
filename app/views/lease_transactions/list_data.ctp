{
	success:true,
	results: <?php echo $results; ?>,
	rows: [
<?php $st = false; foreach($lease_transactions as $lease_transaction){ if($st) echo ","; ?>			{
				"id":"<?php echo $lease_transaction['LeaseTransaction']['id']; ?>",
				"lease":"<?php echo $lease_transaction['Lease']['name']; ?>",
				"month":"<?php echo $lease_transaction['LeaseTransaction']['month']; ?>",
				"payment":"<?php echo $lease_transaction['LeaseTransaction']['payment']; ?>",
				"disount_factor":"<?php echo $lease_transaction['LeaseTransaction']['disount_factor']; ?>",
				"npv":"<?php echo $lease_transaction['LeaseTransaction']['npv']; ?>",
				"lease_liability":"<?php echo $lease_transaction['LeaseTransaction']['lease_liability']; ?>",
				"interest_charge":"<?php echo $lease_transaction['LeaseTransaction']['interest_charge']; ?>",
				"asset_nbv_bfwd":"<?php echo $lease_transaction['LeaseTransaction']['asset_nbv_bfwd']; ?>",
				"amortization":"<?php echo $lease_transaction['LeaseTransaction']['amortization']; ?>",
				"asset_nbv_cfwd":"<?php echo $lease_transaction['LeaseTransaction']['asset_nbv_cfwd']; ?>"			}
<?php $st = true; } ?>		]
}