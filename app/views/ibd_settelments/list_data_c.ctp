{
	success:true,
	results: <?php echo $results; ?>,
	rows: [
<?php $st = false; foreach($ibdSettelments as $ibdSettelment){ if($st) echo ",";   ?>			{
				"id":"<?php echo $ibdSettelment['IbdSettelment']['id']; ?>",
				"reference":"<?php echo $ibdSettelment['IbdSettelment']['reference']; ?>",
				"date":"<?php echo $ibdSettelment['IbdSettelment']['date']; ?>",
				"rate":"<?php echo $ibdSettelment['IbdSettelment']['rate']; ?>",
                "lcy_amount":"<?php echo $ibdSettelment['IbdSettelment']['lcy_amount']; ?>",
                "fcy_amount":"<?php echo $ibdSettelment['IbdSettelment']['fcy_amount']; ?>"
						}
<?php $st = true; } ?>		]
}