{
	success:true,
	results: <?php echo $results; ?>,
	rows: [
<?php $st = false; foreach($ims_disposals as $ims_disposal){ if($st) echo ","; ?>			{
				"id":"<?php echo $ims_disposal['ImsDisposal']['id']; ?>",
				"name":"<?php echo $ims_disposal['ImsDisposal']['name']; ?>",
				"status":"<?php if($ims_disposal['ImsDisposal']['status'] == 'approved'){ echo '<font color=green>approved</font>';}else if($ims_disposal['ImsDisposal']['status'] =='posted'){echo '<font color=#DF7401>posted</font>';}else if($ims_disposal['ImsDisposal']['status'] =='rejected'){echo '<font color=red>rejected</font>';} else echo $ims_disposal['ImsDisposal']['status']; ?>",
				"ims_store":"<?php echo $ims_disposal['ImsStore']['name']; ?>",
				"created_by":"<?php echo $ims_disposal['CreatedUser']['Person']['first_name']. ' ' . $ims_disposal['CreatedUser']['Person']['middle_name'] . ' ' . 
                    $ims_disposal['CreatedUser']['Person']['last_name']; ?>",
				"approved_by":"<?php echo $ims_disposal['ImsDisposal']['approved_by']<> 0? $ims_disposal['ApprovedUser']['Person']['first_name'] . ' ' . $ims_disposal['ApprovedUser']['Person']['middle_name'] . ' ' . 
                    $ims_disposal['ApprovedUser']['Person']['last_name']: ''; ?>",
				"user_id":"<?php echo $ims_disposal['ImsDisposal']['created_by']; ?>",
				"created":"<?php echo $ims_disposal['ImsDisposal']['created']; ?>",
				"modified":"<?php echo $ims_disposal['ImsDisposal']['modified']; ?>"			}
<?php $st = true; } ?>		]
}