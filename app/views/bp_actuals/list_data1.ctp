{
	success:true,
	results: <?php echo $results; ?>,
	rows: [
<?php $st = false; foreach($bp_actuals as $bp_plan){ if($st) echo ","; ?>			
                 {
				 "id":"<?php echo $bp_plan['BpActual']['id']; ?>",
				 "branch":"<?php echo $bp_plan['Branch']['name']; ?>",
				 "month":"<?php echo $bp_plan['BpMonth']['name']; ?>",
				 "amount":"<?php echo $bp_plan['BpActual']['amount']; ?>",
				 "accont_no":"<?php echo $bp_plan['BpItem']['name']; ?>",
				  "remark":"<?php echo $bp_plan['BpActual']['remark']; ?>",
				 "created":"<?php echo $bp_plan['BpActual']['created']; ?>"			
				}
<?php $st = true; } ?>		]
}