{
	success:true,
	results: <?php echo $results; ?>,
	rows: [
<?php $st = false; foreach($dms_shares as $dms_share){ if($st) echo ","; ?>			{
				"id":"<?php echo $dms_share['DmsShare']['id']; ?>",
				"dms_document":"<?php echo $dms_share['DmsDocument']['name']; ?>",
				"branch":"<?php echo $dms_share['Branch']['name']; ?>",
				"user":"<?php echo $dms_share['User']['id']; ?>",
				"read":"<?php echo $dms_share['DmsShare']['read']; ?>",
				"write":"<?php echo $dms_share['DmsShare']['write']; ?>",
				"delete":"<?php echo $dms_share['DmsShare']['delete']; ?>",
				"created":"<?php echo $dms_share['DmsShare']['created']; ?>",
				"modified":"<?php echo $dms_share['DmsShare']['modified']; ?>"			}
<?php $st = true; } ?>		]
}