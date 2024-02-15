{
	success:true,
	results: <?php echo $results; ?>,
	rows: [
<?php $st = false; foreach($risks as $risk){ if($st) echo ","; ?>			{
				"id":"<?php echo $risk['OrmsRiskCategory']['id']; ?>",
				"name":"<?php echo $risk['OrmsRiskCategory']['name']; ?>"		}
<?php $st = true; } ?>		]
}