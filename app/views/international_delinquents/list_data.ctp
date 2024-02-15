{
	success:true,
	results: <?php echo $results; ?>,
	rows: [
<?php $st = false; foreach($international_delinquents as $international_delinquent){ if($st) echo ","; ?>			{
				"id":"<?php echo $international_delinquent['InternationalDelinquent']['id']; ?>",
				"name":"<?php echo $international_delinquent['InternationalDelinquent']['name']; ?>",
				"Nationality":"<?php echo $international_delinquent['InternationalDelinquent']['Nationality']; ?>",
				"BOD":"<?php echo $international_delinquent['InternationalDelinquent']['BOD']; ?>",
				"created":"<?php echo $international_delinquent['InternationalDelinquent']['created']; ?>",
				"modified":"<?php echo $international_delinquent['InternationalDelinquent']['modified']; ?>"			}
<?php $st = true; } ?>		]
}