{
	success:true,
	results: <?php echo $results; ?>,
	rows: [
<?php $st = false; foreach($report_fields as $report_field){ if($st) echo ","; ?>			{
				"id":"<?php echo $report_field['ReportField']['id']; ?>",
				"report":"<?php echo $report_field['Report']['name']; ?>",
				"field":"<?php echo $report_field['Field']['name']; ?>",
				"Renamed":"<?php echo $report_field['ReportField']['Renamed']; ?>",
				"getas":"<?php echo $report_field['ReportField']['getas']; ?>"			}
<?php $st = true; } ?>		]
}