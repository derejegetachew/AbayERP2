
{
	success:true,
	results: <?php echo $results; ?>,
	rows: [
<?php $st = false; $balance = 0;foreach($cards as $card){if($st) echo ","; ?>			{
            "id":"<?php echo $card[0]['id']; ?>",
            "item":"<?php echo $card[0]['item_name'] . ' - ' . $card[0]['item_description']; ?>",
			"supplied_issued":"<?php 
				if($card[0]['ims_grn_item_id'] == null){
						echo 'To '. $card[0]['supplier'];//echo $card[0]['out_unit_price'];
				}
				else if($card[0]['in_quantity'] != 0){
					echo 'From '. $card[0]['supplier'];
						
				}
				else if($card[0]['in_quantity'] == 0){
					if($card[0]['disp_quantity'] != 0){
						echo $card['ImsStore']['name']. ' store';
					}
					else{
						
							echo $card[0]['full_name'];
					}
				}
			?>",
			"grn_sirv":"<?php 
				if($card[0]['ims_grn_item_id'] == null){
					echo $card[0]['ims_sirv_item_id'];
				}
				else if($card[0]['ims_grn_item_id'] != 0){
					echo $card[0]['grn_name'];
				}
				else if($card[0]['ims_disposal_item_id'] != 0){
					echo $card['ImsDisposalItem']['ImsDisposal']['name'];
				}
				else echo $card[0]['srv_name']; 
				?>",
            "in_quantity":"<?php echo $card[0]['in_quantity'] != 0? $card[0]['in_quantity']: ''; ?>",
            "out_quantity":"<?php if($card[0]['out_quantity'] != 0){
									echo $card[0]['out_quantity'];
								} else if($card[0]['disp_quantity'] != 0){
									echo $card[0]['disp_quantity'];
								}else echo ''; ?>",
            "balance":"<?php if($card[0]['in_quantity'] != 0){
								$balance = sprintf("%.2f", $balance) + sprintf("%.2f", $card[0]['in_quantity']);
							}else if($card[0]['out_quantity'] != 0 ){
								$balance = sprintf("%.2f", $balance) - sprintf("%.2f", $card[0]['out_quantity']);
							}else if($card[0]['disp_quantity'] != 0 ){
								$balance = sprintf("%.2f", $balance) - sprintf("%.2f", $card[0]['disp_quantity']);
							}
				echo $balance; ?>",
			"initial":"<?php echo ''; ?>",
    "created":"<?php echo $card[0]['created']; ?>",
    "modified":"<?php echo $card[0]['modified']; ?>",
    "purchase_order_id":"<?php if($card[0]['ims_grn_item_id'] != 0){
				if($card[0]['ims_purchase_order_id'] == 0){
					echo  '<font color=red>Adjustment</font>'; 
				}else if($card[0]['out_quantity'] != 0 && $card[0]['ims_grn_item_id']!= 0){
          echo  '<font color=red>Adjustment</font>'; 
        }
			}
			else if($card[0]['ims_grn_item_id'] == null){
				echo  '<font color=green>Transfer</font>'; 
			}else if($card[0]['ims_disposal_item_id'] != 0){
				echo  '<font color=red>Disposal</font>'; 
			}
			?>"	}
<?php $st = true; } ?>		]
}