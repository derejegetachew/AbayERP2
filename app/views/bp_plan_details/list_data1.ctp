{
	success:true,
	results: <?php echo $results; ?>,
	rows: [
<?php $st = false; foreach($bp_plan_details as $bp_plan_detail){ if($st) echo ","; ?>			
                {
              
				"id":"<?php echo $bp_plan_detail['0']['bp_item_id'] ; ?>",
				"month":"<?php echo $bp_plan_detail['0']['month']; ?>",
				"bp_item":"<?php echo $bp_plan_detail['0']['name']; ?>",
				"amount":"<?php echo round($bp_plan_detail['0']['planAmount'],3); ?>",
				"actualAmount":"<?php echo round($bp_plan_detail['0']['actualAmount'],3); ?>",
				"cumulativePlan":"<?php echo round($bp_plan_detail['0']['cumulativePlan'],3); ?>",
				"cumilativeActual":"<?php echo round($bp_plan_detail['0']['cumilativeActual'],3); ?>",
                "percent":"<?php if($bp_plan_detail['0']['planAmount']>0){ echo  round(($bp_plan_detail['0']['actualAmount']/$bp_plan_detail['0']['planAmount'])*100,0);}else{ echo 'no Budget';} ?>",
                "percent1":"<?php if($bp_plan_detail['0']['cumulativePlan']>0){ echo  round(($bp_plan_detail['0']['cumilativeActual']/$bp_plan_detail['0']['cumulativePlan'])*100,0);}else{ echo 'no Budget';} ?>"				
					}
<?php $st = true; } ?>		]
}