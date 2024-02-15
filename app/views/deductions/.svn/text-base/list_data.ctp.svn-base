{
	success:true,
	results: <?php echo $results; ?>,
	rows: [
<?php $st = false; foreach($deductions as $deduction){ if($st) echo ","; ?>			{
				"id":"<?php echo $deduction['Deduction']['id']; ?>",
				"name":"<?php echo $deduction['Deduction']['name']; ?>",
				"Measurement":"<?php echo $deduction['Deduction']['Measurement']; ?>",
				"amount":"<?php echo $deduction['Deduction']['amount']; ?>",
				"grade":"<?php echo $deduction['Grade']['name']; ?>",
				"start_date":"<?php echo $deduction['Deduction']['start_date']; ?>",
                                "end_date":"<?php if($deduction['Deduction']['end_date']=='0000-00-00') echo 'To Date'; else echo $deduction['Deduction']['end_date']; ?>"	}
<?php $st = true; } ?>		]
}