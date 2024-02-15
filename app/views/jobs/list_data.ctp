{
	success:true,
	results: <?php echo $results; ?>,
	rows: [
<?php $st = false; foreach($jobs as $job){ if($st) echo ","; ?>			{
				"id":"<?php echo $job['Job']['id']; ?>",
				"name":"<?php echo $job['Job']['name']; ?>",
				"start_date":"<?php echo $job['Job']['start_date']; ?>",
				"end_date":"<?php echo $job['Job']['end_date']; ?>",
				"grade":"<?php echo $job['Job']['grade']; ?>",
				"location":"<?php echo $job['Job']['location']; ?>",
				"status":"<?php echo $job['Job']['status']; ?>",
				"remark":"<?php echo $job['Job']['remark']; ?>"				}
<?php $st = true; } ?>		]
}