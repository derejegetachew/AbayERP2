{
	success:true,
	results: <?php echo $results; ?>,
	rows: [
<?php $st = false; foreach($ims_transfers as $ims_transfer){ if($st) echo ","; ?>			{
				"id":"<?php echo $ims_transfer['ImsTransfer']['id']; ?>",
				"name":"<?php echo $ims_transfer['ImsTransfer']['name']; ?>",
				"ims_sirv":"<?php echo $ims_transfer['ImsSirv']['name']; ?>",
				"from_user":"<?php 
					$result = $this->requestAction(
							array(
								'controller' => 'ims_transfers', 
								'action' => 'getUser'), 
							array('userid' => $ims_transfer['ImsTransfer']['from_user'])
						);				
					
						echo $result['Person']['first_name'] .' ' .$result['Person']['middle_name'] .' '.
						$result['Person']['last_name']; ?>",
				"to_user":"<?php $result = $this->requestAction(
							array(
								'controller' => 'ims_transfers', 
								'action' => 'getUser'), 
							array('userid' => $ims_transfer['ImsTransfer']['to_user'])
						);				
					
						echo $result['Person']['first_name'] .' ' .$result['Person']['middle_name'] .' '.
						$result['Person']['last_name']; ?>",
				"from_branch":"<?php echo $ims_transfer['TransfferingBranch']['name']; ?>",
				"to_branch":"<?php echo $ims_transfer['ReceivingBranch']['name']; ?>",
				"observer":"<?php $result = $this->requestAction(
							array(
								'controller' => 'ims_transfers', 
								'action' => 'getUser'), 
							array('userid' => $ims_transfer['ImsTransfer']['observer'])
						);				
					
						echo $result['Person']['first_name'] .' ' .$result['Person']['middle_name'] .' '.
						$result['Person']['last_name']; ?>",
				"approved_by":"<?php $result = $this->requestAction(
							array(
								'controller' => 'ims_transfers', 
								'action' => 'getUser'), 
							array('userid' => $ims_transfer['ImsTransfer']['approved_by'])
						);				
					
						echo $result['Person']['first_name'] .' ' .$result['Person']['middle_name'] .' '.
						$result['Person']['last_name'];?>",
				"created":"<?php echo $ims_transfer['ImsTransfer']['created']; ?>",
				"modified":"<?php echo $ims_transfer['ImsTransfer']['modified']; ?>"			}
<?php $st = true; } ?>		]
}