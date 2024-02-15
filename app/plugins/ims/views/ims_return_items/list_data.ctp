{
	success:true,
	results: <?php echo $results; ?>,
	rows: [
<?php $st = false; foreach($ims_return_items as $ims_return_item){pr($ims_return_item); if($st) echo ","; ?>			{
				"id":"<?php echo $ims_return_item['ImsReturnItem']['id']; ?>",
				"ims_return":"<?php echo $ims_return_item['ImsReturn']['name']; ?>",
				"ims_sirv_item":"<?php 
					$result = $this->requestAction(
							array(
								'controller' => 'ims_return_items', 
								'action' => 'getSIRV'), 
							array('sirvitemid' => $ims_return_item['ImsSirvItem']['id'])
						);				
					
						echo $result['ImsSirv']['name']; ?>",
				"ims_item":"<?php echo $ims_return_item['ImsItem']['name']; ?>",
				"measurement":"<?php echo $ims_return_item['ImsReturnItem']['measurement']; ?>",
				"quantity":"<?php echo $ims_return_item['ImsReturnItem']['quantity']; ?>",
				"unit_price":"<?php echo $ims_return_item['ImsReturnItem']['unit_price']; ?>",
				"tag":"<?php echo $ims_return_item['ImsReturnItem']['tag']; ?>",
				"remark":"<?php echo $ims_return_item['ImsReturnItem']['remark']; ?>",
				"created":"<?php echo $ims_return_item['ImsReturnItem']['created']; ?>",
				"modified":"<?php echo $ims_return_item['ImsReturnItem']['modified']; ?>"			}
<?php $st = true; } ?>		]
}