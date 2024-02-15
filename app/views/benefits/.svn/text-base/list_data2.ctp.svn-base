{
	success:true,
	results: <?php echo $results; ?>,
	rows: [
<?php $st = false; foreach($benefits as $benefit){ if($st) echo ","; ?>			{
				"id":"<?php echo $benefit['Benefit']['id']; ?>",
				"name":"<?php echo $benefit['Benefit']['name']; ?>",
				"Measurement":"<?php echo $benefit['Benefit']['Measurement']; ?>",
				"amount":"<?php echo $benefit['Benefit']['amount']; ?>",
				"grade":"<?php echo $benefit['Grade']['name']; ?>",
				"start_date":"<?php echo $benefit['Benefit']['start_date']; ?>",
                                "end_date":"<?php if($benefit['Benefit']['end_date']=='0000-00-00') echo 'To Date'; else echo $benefit['Benefit']['end_date']; ?>"	}
<?php $st = true; } ?>		]
}