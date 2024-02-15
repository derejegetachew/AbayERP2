{
	success:true,
	results: <?php echo $results; ?>,
	rows: [
<?php $st = false; foreach($dms_groups as $dms_group){ if($st) echo ","; ?>			{
				"id":"<?php echo $dms_group['DmsGroup']['id']; ?>",
				"name":"<?php echo $dms_group['DmsGroup']['name'];  if($dms_group['DmsGroup']['public']==1) echo ' - PUBLIC'; else echo ' - Private';  ?>",
				"user":"<?php echo $dms_group['User']['Person']['first_name'].' '.$dms_group['User']['Person']['middle_name']; ?>",
				"public":"<?php echo $dms_group['DmsGroup']['public']; ?>",
				"created":"<?php echo $dms_group['DmsGroup']['created']; ?>"			}
<?php $st = true; } ?>		]
}