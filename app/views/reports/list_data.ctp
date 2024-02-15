{
	success:true,
	results: <?php echo $results; ?>,
	rows: [
<?php $st = false; foreach($reports as $report){ if($st) echo ","; ?>			{
				"id":"<?php echo $report['Report']['id']; ?>",
				"name":"<?php echo $report['Report']['name']; ?>",
				"type":"<?php echo $report['Report']['type']; ?>",
				"report_group":"<?php echo $report['ReportGroup']['name']; ?>"			}
<?php $st = true; } ?>		]
}