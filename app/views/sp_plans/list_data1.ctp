{
	success:true,
	results: <?php echo $results; ?>,
	rows: [
<?php $st = false; foreach($sp_plans as $sp_plan){ if($st) echo ","; ?>			{
				"id":"<?php echo $sp_plan['SpPlan']['id']; ?>",
				"plan_id":"<?php echo $sp_plan['SpPlan']['sp_plan_hd_id']; ?>",
				"sp_item":"<?php echo $sp_plan['SpItem']['name']; ?>",
				"group":"<?php echo $sp_plan['SpItem']['SpItemGroup']['name']; ?>",
				"user":"<?php echo $sp_plan['User']['username']; ?>",
				"march_end":"<?php echo $sp_plan['SpPlan']['march_end']; ?>",
				"june_end":"<?php echo $sp_plan['SpPlan']['june_end']; ?>",
				"july":"<?php echo $sp_plan['SpPlan']['july']; ?>",
				"august":"<?php echo $sp_plan['SpPlan']['august']; ?>",
				"september":"<?php echo $sp_plan['SpPlan']['september']; ?>",
				"october":"<?php echo $sp_plan['SpPlan']['october']; ?>",
				"november":"<?php echo $sp_plan['SpPlan']['november']; ?>",
				"december":"<?php echo $sp_plan['SpPlan']['december']; ?>",
				"january":"<?php echo $sp_plan['SpPlan']['january']; ?>",
				"february":"<?php echo $sp_plan['SpPlan']['february']; ?>",
				"march":"<?php echo $sp_plan['SpPlan']['march']; ?>",
				"april":"<?php echo $sp_plan['SpPlan']['april']; ?>",
				"may":"<?php echo $sp_plan['SpPlan']['may']; ?>",
				"june":"<?php echo $sp_plan['SpPlan']['june']; ?>"			}
<?php $st = true; } ?>		]
}