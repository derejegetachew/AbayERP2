{
	success:true,
	results: <?php echo $results; ?>,
	rows: [
<?php $st = false; foreach($bp_plans as $bp_plan){ if($st) echo ","; ?>			
                 {
				"id":"<?php echo $bp_plan['BpPlan']['id']; ?>",
				"branch":"<?php echo $bp_plan['Branch']['name']; ?>",
				"branch_id":"<?php echo $bp_plan['Branch']['id']; ?>",
				"month":"<?php echo $bp_plan['BpMonth']['name']; ?>",
				"amount":"<?php echo $bp_plan['BpPlan']['amount']; ?>",
				"bp_item":"<?php echo $bp_plan['BpItem']['name']; ?>",
			 	"budget_year":"<?php echo $bp_plan['BudgetYear']['name']; ?>",
				"budget_id":"<?php echo $bp_plan['BudgetYear']['id']; ?>",
				//"created":"<?php echo $bp_plan['BpPlan']['created']; ?>",
				//"modified":"<?php echo $bp_plan['BpPlan']['modified']; ?>"			
				}
<?php $st = true; } ?>		]
}