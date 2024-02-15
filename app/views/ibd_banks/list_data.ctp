{
	success:true,
	results: <?php echo $results; ?>,
	rows: [
<?php $st = false; foreach($ibd_banks as $ibd_bank){ if($st) echo ","; ?>			{
				"id":"<?php echo $ibd_bank['IbdBank']['id']; ?>",
				"name":"<?php echo $ibd_bank['IbdBank']['name']; ?>",
				"created":"<?php echo $ibd_bank['IbdBank']['created']; ?>",
				"modified":"<?php echo $ibd_bank['IbdBank']['modified']; ?>"			}
<?php $st = true; } ?>		]
}