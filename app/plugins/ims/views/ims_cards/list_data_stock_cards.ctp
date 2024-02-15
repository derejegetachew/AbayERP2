{
    success:true,
    results: <?php echo $results; ?>,
    rows: [
<?php $st = false; foreach($cards as $card){ if($st) echo ","; ?>			{
        "id":"<?php echo $card['ImsCard']['id']; ?>",
        "item":"<?php echo $card['ImsItem']['item']; ?>",
		"grn_sirv_no":"<?php echo $card['ImsCard']['grn_sirv_no'];	?>",
        "in_quantity":"<?php echo $card['ImsCard']['in_quantity']; ?>",
        "out_quantity":"<?php echo $card['ImsCard']['out_quantity']; ?>",
		"unit_price":"<?php echo $card['ImsCard']['unit_price']; ?>",
        "balance":"<?php echo $card['ImsCard']['balance']; ?>",        
		"total_price":"<?php echo $card['ImsCard']['total_price']; ?>",
        "out_unit_price":"<?php echo $card['ImsCard']['out_unit_price']; ?>", 
		"balance_in_birr":"<?php echo $card['ImsCard']['balance_in_birr']; ?>", 
        "created":"<?php echo $card['ImsCard']['created']; ?>",
        "modified":"<?php echo $card['ImsCard']['modified']; ?>",
		"purchase_order_id":"<?php echo $card['ImsCard']['purchase_order_id']; ?>"  }
<?php $st = true; } ?>		]
}