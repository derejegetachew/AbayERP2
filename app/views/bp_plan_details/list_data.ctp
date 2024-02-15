{
	success:true,
	results: <?php echo $results; ?>,
	rows: [
<?php $st = false; foreach($bp_plan_details as $bp_plan_detail){ if($st) echo ","; ?>			{
				"id":"<?php echo $bp_plan_detail['BpPlanDetail']['id']; ?>",
				"bp_item":"<?php echo $bp_plan_detail['BpItem']['name']; ?>",
				"bp_plan":"<?php echo $bp_plan_detail['BpPlan']['id']; ?>",
				"amount":"<?php echo $bp_plan_detail['BpPlanDetail']['amount']; ?>",
				"month":"<?php echo $bp_plan_detail['BpPlanDetail']['month']; ?>"			
					}
<?php $st = true; } ?>		]
}