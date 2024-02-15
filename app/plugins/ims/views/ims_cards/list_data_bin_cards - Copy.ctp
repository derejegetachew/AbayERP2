
{
	success:true,
	results: <?php echo $results; ?>,
	rows: [
<?php $st = false; $balance = 0;foreach($cards as $card){if($st) echo ","; ?>			{
            "id":"<?php echo $card['ImsCard']['id']; ?>",
            "item":"<?php echo $card['ImsItem']['name'] . ' - ' . $card['ImsItem']['description']; ?>",
			"supplied_issued":"<?php 
				if($card['ImsCard']['ims_grn_item_id'] == null){
					echo $card['ImsCard']['out_unit_price'];
				}
				else if($card['ImsCard']['in_quantity'] != 0){
					$result = $this->requestAction(
							array(
								'controller' => 'ims_cards', 
								'action' => 'getSupplier'), 
							array('grnitemid' => $card['ImsCard']['ims_grn_item_id'])
						);
						if($result['ImsGrn']['ImsSupplier'] != null){
							echo $result['ImsGrn']['ImsSupplier']['name'];
						}
				}
				else if($card['ImsCard']['in_quantity'] == 0){
					$result = $this->requestAction(
							array(
								'controller' => 'ims_cards', 
								'action' => 'getUser'), 
							array('sirvitemid' => $card['ImsCard']['ims_sirv_item_id'])
						);
						
					$result1 = $this->requestAction(
							array(
								'controller' => 'ims_cards', 
								'action' => 'getbranch'), 
							array('sirvitemid' => $card['ImsCard']['ims_sirv_item_id'])
						);
						echo $result1['Branch']['name'].'('.$result['Person']['first_name'].' '.$result['Person']['middle_name'].')';
				}
			?>",
			"grn_sirv":"<?php 
				if($card['ImsCard']['ims_grn_item_id'] == null){
					echo $card['ImsCard']['ims_sirv_item_id'];
				}
				else if($card['ImsCard']['ims_grn_item_id'] != 0){
					echo $card['ImsGrnItem']['ImsGrn']['name'];
				}
				else echo $card['ImsSirvItem']['ImsSirv']['name']; 
				?>",
            "in_quantity":"<?php echo $card['ImsCard']['in_quantity'] != 0? $card['ImsCard']['in_quantity']: ''; ?>",
            "out_quantity":"<?php echo $card['ImsCard']['out_quantity'] != 0? $card['ImsCard']['out_quantity']: ''; ?>",
            "balance":"<?php if($card['ImsCard']['in_quantity'] != 0){
								$balance = $balance + $card['ImsCard']['in_quantity'];
							}else if($card['ImsCard']['out_quantity'] != 0 ){
								$balance = $balance - $card['ImsCard']['out_quantity'];
							}
				echo $balance; ?>",
			"initial":"<?php echo ''; ?>",
            "created":"<?php echo $card['ImsCard']['created']; ?>",
            "modified":"<?php echo $card['ImsCard']['modified']; ?>",
			"purchase_order_id":"<?php if($card['ImsCard']['ims_grn_item_id'] != 0){
				if($card['ImsGrnItem']['ImsGrn']['ims_purchase_order_id'] == 0){
					echo  '<font color=red>Adjustment</font>'; 
				}
			}
			else if($card['ImsCard']['ims_grn_item_id'] == null){
				echo  '<font color=green>Transfer</font>'; 
			}
			?>"	}
<?php $st = true; } ?>		]
}