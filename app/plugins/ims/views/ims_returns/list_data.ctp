{
	success:true,
	results: <?php echo $results; ?>,
	rows: [
<?php $st = false; foreach($ims_returns as $ims_return){ pr($ims_return);if($st) echo ","; ?>			{
				"id":"<?php echo $ims_return['r']['id']; ?>",
				"name":"<?php echo $ims_return['r']['name']; ?>",
				"received_by":"<?php echo $ims_return[0]['received_by']; ?>",
				"approved_by":"<?php echo $ims_return[0]['approved_by']; ?>",
				"returned_by":"<?php echo $ims_return[0]['returned_by']; ?>",
				"returned_from":"<?php echo $ims_return[0]['returned_from']; ?>",
				"status":"<?php echo $ims_return['r']['status']; ?>",
				"created":"<?php echo $ims_return['r']['created']; ?>",
				"modified":"<?php echo $ims_return['r']['modified']; ?>"			}
<?php $st = true; } ?>		]
}