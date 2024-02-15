{
	success:true,
	results: <?php echo $results; ?>,
	rows: [
<?php $st = false; foreach($miner_rules as $miner_rule){ if($st) echo ","; ?>			{
				"id":"<?php echo $miner_rule['MinerRule']['id']; ?>",
				"mine":"<?php echo $miner_rule['Mine']['name']; ?>",
				"tableField":"<?php echo $miner_rule['MinerRule']['tableField']; ?>",
				"param":"<?php echo $miner_rule['MinerRule']['param']; ?>",
				"value":"<?php echo $miner_rule['MinerRule']['value']; ?>"			}
<?php $st = true; } ?>		]
}