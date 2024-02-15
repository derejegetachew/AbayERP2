{
	success:true,
	results: <?php echo $results; ?>,
	rows: [
<?php $st = false; foreach($delegations as $delegation){ if($st) echo ","; ?>			{
				"id":"<?php echo $delegation['Delegation']['id']; ?>",
				"employee":"<?php echo $delegation['Employee']['User']['Person']['first_name'].' '.$delegation['Employee']['User']['Person']['middle_name']; ?>",
				"delegated":"<?php echo $delegation['DelEmployee']['User']['Person']['middle_name'].' '.$delegation['DelEmployee']['User']['Person']['middle_name']; ?>",
				"start":"<?php echo $delegation['Delegation']['start']; ?>",
				"end":"<?php echo $delegation['Delegation']['end']; ?>",
				"comment":"<?php echo $delegation['Delegation']['comment']; ?>",
				"created":"<?php echo $delegation['Delegation']['created']; ?>"			}
<?php $st = true; } ?>		]
}