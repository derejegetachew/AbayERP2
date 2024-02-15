{
	success:true,
	results: <?php echo $results; ?>,
	rows: [
<?php $st = false; foreach($claimoffjobtrainings as $claimoffjobtraining){ if($st) echo ","; ?>			{
				"id":"<?php echo $claimoffjobtraining['Claimoffjobtraining']['id']; ?>",
				"name":"<?php echo $claimoffjobtraining['Claimoffjobtraining']['name']; ?>",
				"branch":"<?php echo $claimoffjobtraining['Claimoffjobtraining']['branch']; ?>",
				"training_title":"<?php echo $claimoffjobtraining['Claimoffjobtraining']['training_title']; ?>",
				"position":"<?php echo $claimoffjobtraining['Claimoffjobtraining']['position']; ?>",
				"venue":"<?php echo $claimoffjobtraining['Claimoffjobtraining']['venue']; ?>",
				"date_responded":"<?php echo $claimoffjobtraining['Claimoffjobtraining']['date_responded']; ?>",
				"starting_date":"<?php echo $claimoffjobtraining['Claimoffjobtraining']['starting_date']; ?>",
				"ending_date":"<?php echo $claimoffjobtraining['Claimoffjobtraining']['ending_date']; ?>",
				"perdiem":"<?php echo $claimoffjobtraining['Claimoffjobtraining']['perdiem']; ?>",
				"transport":"<?php echo $claimoffjobtraining['Claimoffjobtraining']['transport']; ?>",
				"accomadation":"<?php echo $claimoffjobtraining['Claimoffjobtraining']['accomadation']; ?>",
				"refreshment":"<?php echo $claimoffjobtraining['Claimoffjobtraining']['refreshment']; ?>",
				"total":"<?php echo $claimoffjobtraining['Claimoffjobtraining']['total']; ?>"			}
<?php $st = true; } ?>		]
}