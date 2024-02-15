{
	success:true,
	results: <?php echo $results; ?>,
	rows: [
<?php $st = false; foreach($ims_disposals as $ims_disposal){ if($st) echo ","; ?>			{
				"id":"<?php echo $ims_disposal['d']['id']; ?>",
				"name":"<?php echo $ims_disposal['d']['name']; ?>",
				"status":"<?php if($ims_disposal['d']['status'] == 'approved'){ echo '<font color=green>approved</font>';}else if($ims_disposal['d']['status'] =='posted'){echo '<font color=#DF7401>posted</font>';}else if($ims_disposal['d']['status'] =='rejected'){echo '<font color=red>rejected</font>';} else echo $ims_disposal['d']['status']; ?>",
				"ims_store":"<?php echo $ims_disposal['s']['store']; ?>",
				"created_by":"<?php echo $ims_disposal[0]['created_by']; ?>",
				"approved_by":"<?php echo $ims_disposal[0]['approved_by']; ?>",
				"user_id":"<?php echo $ims_disposal['d']['created_by']; ?>",
				"created":"<?php echo $ims_disposal['d']['created']; ?>",
				"modified":"<?php echo $ims_disposal['d']['modified']; ?>"			}
<?php $st = true; } ?>		]
}