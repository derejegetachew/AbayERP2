{
	success:true,
	results: <?php echo $results; ?>,
	rows: [
<?php $st = false; foreach($bp_items as $bp_item){ if($st) echo ","; ?>			
                {
				"id":"<?php echo $bp_item['BpItem']['id']; ?>",
				"name":"<?php echo $bp_item['BpItem']['name']; ?>",
				"accoun_no":"<?php echo $bp_item['BpItem']['accoun_no']; ?>",
				"created":"<?php echo $bp_item['BpItem']['created']; ?>",
				"modified":"<?php echo $bp_item['BpItem']['modified']; ?>"			
				}
<?php $st = true; } ?>]
}