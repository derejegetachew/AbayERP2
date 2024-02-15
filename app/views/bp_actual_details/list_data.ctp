{
	success:true,
	results: <?php echo $results; ?>,
	rows: [
<?php $st = false; foreach($bpActualDetails as $bp_actual_detail){ if($st) echo ","; ?>			{
				"id":"<?php echo $bp_actual_detail['BpActualDetail']['id']; ?>",
				"GLCode":"<?php echo $bp_actual_detail['BpActualDetail']['GLCode']; ?>",
				"GLDescription":"<?php echo str_replace(array('"'),array('`'),$bp_actual_detail['BpActualDetail']['GLDescription']); ?>",
				"TDate":"<?php echo $bp_actual_detail['BpActualDetail']['TDate']; ?>",
				"VDate":"<?php echo $bp_actual_detail['BpActualDetail']['VDate']; ?>",
				"RefNo":"<?php echo $bp_actual_detail['BpActualDetail']['RefNo']; ?>",
				"CCY":"<?php echo $bp_actual_detail['BpActualDetail']['CCY']; ?>",
				"DR":"<?php echo $bp_actual_detail['BpActualDetail']['DR']; ?>",
				"CR":"<?php echo $bp_actual_detail['BpActualDetail']['CR']; ?>",
				"TranCode":"<?php echo $bp_actual_detail['BpActualDetail']['TranCode']; ?>",
				"TranDesc":"<?php echo $bp_actual_detail['BpActualDetail']['TranDesc']; ?>",
				"Amount":"<?php echo $bp_actual_detail['BpActualDetail']['Amount']; ?>",
				"InstrumentCode":"<?php echo $bp_actual_detail['BpActualDetail']['InstrumentCode']; ?>",
				"CPO":"<?php echo $bp_actual_detail['BpActualDetail']['CPO']; ?>",
				"Description":"<?php echo str_replace(array('"'),array('`'),$bp_actual_detail['BpActualDetail']['Description']); ?>"			}
<?php $st = true; } ?>		]
}