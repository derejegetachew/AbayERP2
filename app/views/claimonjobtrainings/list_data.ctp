{
	success:true,
	results: <?php echo $results; ?>,
	rows: [
<?php $st = false; foreach($claimonjobtrainings as $claimonjobtraining){ if($st) echo ","; ?>			{
				"id":"<?php echo $claimonjobtraining['Claimonjobtraining']['id']; ?>",
				"name":"<?php echo $claimonjobtraining['Claimonjobtraining']['name']; ?>",
				"branch":"<?php echo $claimonjobtraining['Claimonjobtraining']['branch']; ?>",
				"position":"<?php echo $claimonjobtraining['Claimonjobtraining']['position']; ?>",
				"date_of_employment":"<?php echo $claimonjobtraining['Claimonjobtraining']['date_of_employment']; ?>",
				"placement_date":"<?php echo $claimonjobtraining['Claimonjobtraining']['placement_date']; ?>",
				"date_responded":"<?php echo $claimonjobtraining['Claimonjobtraining']['date_responded']; ?>",
				"no_of_days":"<?php echo $claimonjobtraining['Claimonjobtraining']['no_of_days']; ?>",
				"payment_month":"<?php echo $claimonjobtraining['Claimonjobtraining']['payment_month']; ?>",
				"placement_branch":"<?php echo $claimonjobtraining['Claimonjobtraining']['placement_branch']; ?>",
				"basic_salary":"<?php echo $claimonjobtraining['Claimonjobtraining']['basic_salary']; ?>",
				"transport":"<?php echo $claimonjobtraining['Claimonjobtraining']['transport']; ?>",
				"hardship":"<?php echo $claimonjobtraining['Claimonjobtraining']['hardship']; ?>",
				"pension":"<?php echo $claimonjobtraining['Claimonjobtraining']['pension']; ?>",
				"total":"<?php echo $claimonjobtraining['Claimonjobtraining']['total']; ?>"			}
<?php $st = true; } ?>		]
}