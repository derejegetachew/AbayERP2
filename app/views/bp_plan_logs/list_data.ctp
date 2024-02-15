{
	success:true,
	results: <?php echo $results; ?>,
	rows: [
<?php $st = false; foreach($bp_plan_logs as $bp_plan_log){ if($st) echo ","; ?>			{
				"id":"<?php echo $bp_plan_log['BpPlanLog']['id']; ?>",
				"bp_plan":"<?php echo $bp_plan_log['BpPlan']['id']; ?>",
				"user":"<?php echo $bp_plan_log['User']['id']; ?>",
				"type":"<?php echo $bp_plan_log['BpPlanLog']['type']; ?>",
				"created":"<?php echo $bp_plan_log['BpPlanLog']['created']; ?>"			}
<?php $st = true; } ?>		]
}