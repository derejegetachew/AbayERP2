{
	success:true,
	results: <?php echo $results; ?>,
	rows: [
<?php $st = false; foreach($bp_cumulatives as $bp_cumulative){ if($st) echo ","; ?>			{
				"id":"<?php echo $bp_cumulative['BpCumulative']['id']; ?>",
				"bp_item":"<?php echo $bp_cumulative['BpItem']['name']; ?>",
				"bp_month":"<?php echo $bp_cumulative['BpMonth']['name']; ?>",
				"budget_year":"<?php echo $bp_cumulative['BudgetYear']['name']; ?>",
				"plan":"<?php echo $bp_cumulative['BpCumulative']['plan']; ?>",
				"actual":"<?php echo $bp_cumulative['BpCumulative']['actual']; ?>",
				"cumilativePlan":"<?php echo $bp_cumulative['BpCumulative']['cumilativePlan']; ?>",
				"cumilativeActual":"<?php echo $bp_cumulative['BpCumulative']['cumilativeActual']; ?>"			}
<?php $st = true; } ?>		]
}