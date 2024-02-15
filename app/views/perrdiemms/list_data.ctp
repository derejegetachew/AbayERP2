{
	success:true,
	results: <?php echo $results; ?>,
	rows: [
<?php $st = false; foreach($perrdiemms as $perrdiemm){ if($st) echo ","; ?>			{
				"id":"<?php echo $perrdiemm['Perrdiemm']['id']; ?>",
				"employee":"<?php echo $perrdiemm['Employee']['id']; ?>",
				"payroll":"<?php echo $perrdiemm['Payroll']['name']; ?>",
				"days":"<?php echo $perrdiemm['Perrdiemm']['days']; ?>",
				"rate":"<?php echo $perrdiemm['Perrdiemm']['rate']; ?>",
				"taxable":"<?php echo $perrdiemm['Perrdiemm']['taxable']; ?>",
				"date":"<?php echo $perrdiemm['Perrdiemm']['date']; ?>"			}
<?php $st = true; } ?>		]
}