{
	success:true,
	results: <?php echo $results; ?>,
	rows: [
<?php $st = false; foreach($ibdSettelments as $ibdSettelment){ if($st) echo ",";   ?>			{
				"id":"<?php echo $ibdSettelment['IbdIbcs']['id']; ?>",
				"reference":"<?php echo $ibdSettelment['IbdIbcs']['IBC_REFERENCE']; ?>",
				"date":"<?php echo $ibdSettelment['IbdIbcs']['ISSUE_DATE']; ?>",
				"rate":"<?php echo ($ibdSettelment['IbdIbcs']['SETT_Amount']/$ibdSettelment['IbdIbcs']['SETT_FCY']); ?>",
                "lcy_amount":"<?php echo $ibdSettelment['IbdIbcs']['SETT_Amount']; ?>",
                "fcy_amount":"<?php echo $ibdSettelment['IbdIbcs']['SETT_FCY']; ?>"
						}
<?php $st = true; } ?>		]
}