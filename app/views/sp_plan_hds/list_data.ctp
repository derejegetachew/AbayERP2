{
	success:true,
	results: <?php echo $results; ?>,
	rows: [
		
<?php $st = false;foreach($sp_plan_hds as $sp_plan_hd) { if($st) {echo ","; }    ?>
{
              	"id":"<?php echo $sp_plan_hd['SpPlanHd']['id']; ?>",
				"branch":"<?php echo $sp_plan_hd['Branch']['name']; ?>",
				"budget_year":"<?php echo $sp_plan_hd['BudgetYear']['name']; ?>"
				
						}
<?php $st = true; } ?>	
	
]
}