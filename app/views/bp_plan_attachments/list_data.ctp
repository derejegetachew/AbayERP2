{
	success:true,
	results: <?php echo $results; ?>,
	rows: [
<?php $st = false; foreach($bp_Plan_Attachments as $bp_plan_attachment){ if($st) echo ","; ?>			{
				"id":"<?php echo $bp_plan_attachment['BpPlanAttachment']['id']; ?>",
				
				"file_name":"<?php echo $bp_plan_attachment['BpPlanAttachment']['file_name']; ?>",
				"path":"<?php echo $bp_plan_attachment['BpPlanAttachment']['path']; ?>",
				"created":"<?php echo $bp_plan_attachment['BpPlanAttachment']['created']; ?>",
				"original":"<?php echo $bp_plan_attachment['BpPlanAttachment']['original']; ?>",		
				"modified":"<?php echo $bp_plan_attachment['BpPlanAttachment']['modified']; ?>"		}
<?php $st = true; } ?>		]
}