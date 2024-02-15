{
	success:true,
	results: <?php echo $results; ?>,
	rows: [
<?php $st = false; foreach($ims_sirv_befores as $ims_sirv_before){ if($st) echo ","; ?>			{
				"id":"<?php echo $ims_sirv_before['ImsSirvBefore']['id']; ?>",
				"name":"<?php echo $ims_sirv_before['ImsSirvBefore']['name']; ?>",
				"branch":"<?php echo $ims_sirv_before['Branch']['name']; ?>",
				"created":"<?php echo $ims_sirv_before['ImsSirvBefore']['created']; ?>",
				"modified":"<?php echo $ims_sirv_before['ImsSirvBefore']['modified']; ?>"			}
<?php $st = true; } ?>		]
}