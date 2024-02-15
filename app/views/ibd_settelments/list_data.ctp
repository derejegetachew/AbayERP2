{
	success:true,
	results: <?php echo $results; ?>,
	rows: [
<?php $st = false; foreach($ibd_Settelments as $ibd_Settelment){ if($st) echo ","; ?>			{
				"id":"<?php echo $ibd_Settelment['IbdSettelment']['id']; ?>",
				"reference":"<?php echo $ibd_Settelment['IbdSettelment']['reference']; ?>",
				"rate":"<?php echo $ibd_Settelment['IbdSettelment']['rate']; ?>",
                "lcy_amount":"<?php echo $ibd_Settelment['IbdSettelment']['lcy_amount']; ?>",
                "fcy_amount":"<?php echo $ibd_Settelment['IbdSettelment']['fcy_amount']; ?>",
                 "margin_amount":"<?php echo $ibd_Settelment['IbdSettelment']['margin_amount']; ?>"
						}
<?php $st = true; } ?>		]
}