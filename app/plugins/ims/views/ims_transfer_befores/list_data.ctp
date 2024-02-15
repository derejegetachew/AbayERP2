{
	success:true,
	results: <?php echo $results; ?>,
	rows: [
<?php $st = false; foreach($ims_transfer_befores as $ims_transfer_before){ if($st) echo ","; ?>			{
				"id":"<?php echo $ims_transfer_before['ImsTransferBefore']['id']; ?>",
				"name":"<?php echo $ims_transfer_before['ImsTransferBefore']['name']; ?>",
				"ims_sirv_before":"<?php echo $ims_transfer_before['ImsSirvBefore']['name']; ?>",
				"from_user":"<?php 
					$result = $this->requestAction(
							array(
								'controller' => 'ims_transfer_befores', 
								'action' => 'getUser'), 
							array('userid' => $ims_transfer_before['ImsTransferBefore']['from_user'])
						);				
					
						echo $result['Person']['first_name'] .' ' .$result['Person']['middle_name'] .' '.
						$result['Person']['last_name']; ?>",
				"to_user":"<?php $result = $this->requestAction(
							array(
								'controller' => 'ims_transfer_befores', 
								'action' => 'getUser'), 
							array('userid' => $ims_transfer_before['ImsTransferBefore']['to_user'])
						);				
					
						echo $result['Person']['first_name'] .' ' .$result['Person']['middle_name'] .' '.
						$result['Person']['last_name']; ?>",
				
				"from_branch":"<?php echo $ims_transfer_before['TransfferingBranch']['name']; ?>",
				"to_branch":"<?php echo $ims_transfer_before['ReceivingBranch']['name']; ?>",
				"observer":"<?php $result = $this->requestAction(
							array(
								'controller' => 'ims_transfer_befores', 
								'action' => 'getUser'), 
							array('userid' => $ims_transfer_before['ImsTransferBefore']['observer'])
						);				
					
						echo $result['Person']['first_name'] .' ' .$result['Person']['middle_name'] .' '.
						$result['Person']['last_name']; ?>",
				"approved_by":"<?php $result = $this->requestAction(
							array(
								'controller' => 'ims_transfer_befores', 
								'action' => 'getUser'), 
							array('userid' => $ims_transfer_before['ImsTransferBefore']['approved_by'])
						);				
					
						echo $result['Person']['first_name'] .' ' .$result['Person']['middle_name'] .' '.
						$result['Person']['last_name'];?>",
				"created":"<?php echo $ims_transfer_before['ImsTransferBefore']['created']; ?>",
				"modified":"<?php echo $ims_transfer_before['ImsTransferBefore']['modified']; ?>"			}
<?php $st = true; } ?>		]
}