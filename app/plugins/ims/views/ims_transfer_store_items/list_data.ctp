{
	success:true,
	results: <?php echo $results; ?>,
	rows: [
<?php $st = false; foreach($ims_transfer_store_items as $ims_transfer_store_item){ if($st) echo ","; ?>			{
				"id":"<?php echo $ims_transfer_store_item['ImsTransferStoreItem']['id']; ?>",
				"name":"<?php echo $ims_transfer_store_item['ImsTransferStoreItem']['name']; ?>",
				"from_store":"<?php echo $ims_transfer_store_item['FromStore']['name']; ?>",
				"to_store":"<?php echo $ims_transfer_store_item['ToStore']['name']; ?>",
				"from_store_keeper":"<?php 
					$result = $this->requestAction(
							array(
								'controller' => 'ims_transfer_store_items', 
								'action' => 'getUser'), 
							array('userid' => $ims_transfer_store_item['ImsTransferStoreItem']['from_store_keeper'])
						);				
					
						echo $result['Person']['first_name'] .' ' .$result['Person']['middle_name'] .' '.
						$result['Person']['last_name']; ?>",
				"to_store_keeper":"<?php 
					$result = $this->requestAction(
							array(
								'controller' => 'ims_transfer_store_items', 
								'action' => 'getUser'), 
							array('userid' => $ims_transfer_store_item['ImsTransferStoreItem']['to_store_keeper'])
						);				
					
						echo $result['Person']['first_name'] .' ' .$result['Person']['middle_name'] .' '.
						$result['Person']['last_name']; ?>",
				"remark":"<?php echo $ims_transfer_store_item['ImsTransferStoreItem']['remark']; ?>",
				"status":"<?php if($ims_transfer_store_item['ImsTransferStoreItem']['status'] =='posted'){echo '<font color=#DF7401>posted</font>';}else if($ims_transfer_store_item['ImsTransferStoreItem']['status'] =='accepted'){echo '<font color=green>accepted</font>';} else echo $ims_transfer_store_item['ImsTransferStoreItem']['status'];?>",
				"created":"<?php echo $ims_transfer_store_item['ImsTransferStoreItem']['created']; ?>",
				"modified":"<?php echo $ims_transfer_store_item['ImsTransferStoreItem']['modified']; ?>"			}
<?php $st = true; } ?>		]
}