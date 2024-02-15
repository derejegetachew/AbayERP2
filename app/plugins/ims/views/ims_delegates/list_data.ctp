{
	success:true,
	results: <?php echo $results; ?>,
	rows: [
<?php $st = false; foreach($ims_delegates as $ims_delegate){ if($st) echo ","; ?>			{
				"id":"<?php echo $ims_delegate['ImsDelegate']['id']; ?>",
				"ims_requisition":"<?php echo $ims_delegate['ImsRequisition']['name']; ?>",
				"user":"<?php echo $ims_delegate['User']['id']; ?>",
				"name":"<?php echo $ims_delegate['ImsDelegate']['name']; ?>",
				"phone":"<?php echo $ims_delegate['ImsDelegate']['phone']; ?>",
				"created":"<?php echo $ims_delegate['ImsDelegate']['created']; ?>",
				"modified":"<?php echo $ims_delegate['ImsDelegate']['modified']; ?>"			}
<?php $st = true; } ?>		]
}