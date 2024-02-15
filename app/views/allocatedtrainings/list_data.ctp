{
	success:true,
	results: <?php echo $results; ?>,
	rows: [
<?php $st = false; foreach($allocatedtrainings as $allocatedtraining){ 
	if(array_key_exists($allocatedtraining['Employee']['id'], $emps)) { if($st) echo ","; ?>			{
				"id":"<?php echo $allocatedtraining['Allocatedtraining']['id']; ?>",
				"budget_year":"<?php echo $allocatedtraining['BudgetYear']['name']; ?>",
				"quarter":"<?php 
				if($allocatedtraining['Allocatedtraining']['quarter'] == 1)
				echo "I";
				if($allocatedtraining['Allocatedtraining']['quarter'] == 2)
				echo "II";
				if($allocatedtraining['Allocatedtraining']['quarter'] == 3)
				echo "III";
				if($allocatedtraining['Allocatedtraining']['quarter'] == 4)
				echo "IV";
				 ?>",
				"employee":"<?php echo  $emps[$allocatedtraining['Employee']['id']] ; ?>",
				"training1":"<?php echo $allocatedtraining['Allocatedtraining']['training1'] > 0 ? $training_list[$allocatedtraining['Allocatedtraining']['training1']] : 'blank'; ?>",
				"training2":"<?php echo $allocatedtraining['Allocatedtraining']['training2'] > 0 ? $training_list[$allocatedtraining['Allocatedtraining']['training2']] : 'blank'; ?>",
				"training3":"<?php echo $allocatedtraining['Allocatedtraining']['training3'] > 0 ? $training_list[$allocatedtraining['Allocatedtraining']['training3']] : 'blank'; ?>"
							}
<?php $st = true; } } ?>		]
}