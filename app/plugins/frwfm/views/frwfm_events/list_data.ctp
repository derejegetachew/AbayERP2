{
	success:true,
	results: <?php echo $results; ?>,
	rows: [
<?php $st = false; foreach($frwfm_events as $frwfm_event){ if($st) echo ","; ?>			{
				"id":"<?php echo $frwfm_event['FrwfmEvent']['id']; ?>",
				"frwfm_application":"<?php echo $frwfm_event['FrwfmApplication']['id']; ?>",
				"user":"<?php echo $frwfm_event['User']['Person']['first_name']. ' '. $frwfm_event['User']['Person']['middle_name']; ?>",
				"action":"<?php echo $frwfm_event['FrwfmEvent']['action']; ?>",
				"remark":"<?php echo $frwfm_event['FrwfmEvent']['remark']; ?>",
				"created":"<?php echo $frwfm_event['FrwfmEvent']['created']; ?>"			}
<?php $st = true; } ?>		]
}