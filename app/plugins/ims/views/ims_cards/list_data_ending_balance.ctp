{
    success:true,
    results: <?php echo $results; ?>,
    rows: [
<?php $st = false; foreach($cards as $card){ if($st) echo ","; ?>			{
        "id":"<?php echo $card['ImsCard']['id']; ?>",
        "item":"<?php echo $card['ImsItem']['name'] . ' - ' . $card['ImsItem']['description']; ?>",
		"grn_sirv_no":"<?php echo $card['ImsCard']['ims_grn_item_id'] != 0? $card['ImsGrnItem']['ImsGrn']['name']: $card['ImsSirvItem']['ImsSirv']['name'];	?>",
        "in_quantity":"<?php echo $card['ImsCard']['in_quantity'] != 0? $card['ImsCard']['in_quantity']: ''; ?>",
        "out_quantity":"<?php echo $card['ImsCard']['out_quantity'] != 0? $card['ImsCard']['out_quantity']: ''; ?>",
		"unit_price":"<?php echo $card['ImsCard']['in_unit_price'] != 0.00? $card['ImsCard']['in_unit_price']:$card['ImsCard']['out_unit_price']; ?>",
        "balance":"<?php echo $card['ImsCard']['balance']; ?>",        
		"total_price":"<?php
			if($card['ImsCard']['in_quantity'] != 0){
				echo number_format($card['ImsCard']['in_quantity'] * $card['ImsCard']['in_unit_price'] , 2 , '.' , ',' ); 
			}
			else echo number_format($card['ImsCard']['out_quantity'] * $card['ImsCard']['out_unit_price'] , 2 , '.' , ',' );
		?>",
        "out_unit_price":"<?php echo $card['ImsCard']['out_unit_price']; ?>", 
		"balance_in_birr":"<?php  
			if($card['ImsCard']['in_quantity'] != 0){
				echo number_format($card['ImsCard']['balance'] * $card['ImsCard']['in_unit_price'], 2 , '.' , ',' );
			}
			else echo number_format($card['ImsCard']['balance'] * $card['ImsCard']['out_unit_price'], 2 , '.' , ',' );			
		?>", 
        "created":"<?php echo $card['ImsCard']['created']; ?>",
        "modified":"<?php echo $card['ImsCard']['modified']; ?>"			}
<?php $st = true; } ?>		]
}