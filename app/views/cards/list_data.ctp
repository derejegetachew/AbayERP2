{
	success:true,
	results: <?php echo $results; ?>,
	rows: [
<?php $st = false; foreach($cards as $card){ if($st) echo ","; ?>			{
				"id":"<?php echo $card['Card']['id']; ?>",
				"item":"<?php echo $card['Item']['name']; ?>",
				"quantity":"<?php echo $card['Card']['quantity']; ?>",
				"unit_price":"<?php echo $card['Card']['unit_price']; ?>",
				"grn":"<?php echo $card['Grn']['name']; ?>",
				"created":"<?php echo $card['Card']['created']; ?>",
				"modified":"<?php echo $card['Card']['modified']; ?>"			}
<?php $st = true; } ?>		]
}