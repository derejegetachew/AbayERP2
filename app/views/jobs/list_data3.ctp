{
	success:true,
	results: <?php echo $results; ?>,
	rows: [
<?php $st = false; foreach($jobs as $job){ if($st) echo ","; ?>			{
				"id":"<?php echo $job['Job']['id']; ?>",
				"name":"<?php echo "<div style='white-space: normal'>".$job['Job']['name']."</div>"; ?>",
				"start_date":"<?php echo $job['Job']['start_date']; ?>",
				"description":"<?php $job['Job']['description'] = preg_replace("/[\n\r]/"," ",$job['Job']['description']);  echo "<div style='white-space: normal'>".$job['Job']['description']."</div>"; ?>",
				"end_date":"<?php echo $job['Job']['end_date']; ?>",
				"grade":"<?php echo $job['Job']['grade']; ?>",
				"location":"<?php echo "<div style='white-space: normal'>".$job['Job']['location']."</div>"; ?>",
				"remark":"<?php echo $job['Job']['remark']; ?>"		}
<?php $st = true; } ?>		]
}