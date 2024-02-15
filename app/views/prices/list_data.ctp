{
	success:true,
	results: <?php echo $results; ?>,
	rows: [
<?php $st = false; foreach($prices as $price){ if($st) echo ","; ?>			{
				"id":"<?php echo $price['Price']['id']; ?>",
				"gas":"<?php echo $price['Price']['gas']; ?>",
				"date":"<?php echo $price['Price']['date']; ?>",
				"payroll":"<?php echo $price['Payroll']['name']; ?>"			}
<?php $st = true; } ?>		]
}