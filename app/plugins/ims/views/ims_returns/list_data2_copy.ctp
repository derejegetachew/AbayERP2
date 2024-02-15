{
	success:true,
	results: <?php echo $results; ?>,
	rows: [
<?php $st = false; foreach($ims_returns as $ims_return){ pr($ims_return);if($st) echo ","; ?>			{
				"id":"<?php echo $ims_return['ImsReturn']['id']; ?>",
				"name":"<?php echo $ims_return['ImsReturn']['name']; ?>",
				"received_by":"<?php 
					$result = $this->requestAction(
							array(
								'controller' => 'ims_returns', 
								'action' => 'getUser'), 
							array('userid' => $ims_return['ImsReturn']['received_by'])
						);				
					
						echo $result['Person']['first_name'] .' ' .$result['Person']['middle_name'] .' '.
						$result['Person']['last_name']; ?>",
				"approved_by":"<?php 
					$result = $this->requestAction(
							array(
								'controller' => 'ims_returns', 
								'action' => 'getUser'), 
							array('userid' => $ims_return['ImsReturn']['approved_rejected_by'])
						);				
					
						echo $result['Person']['first_name'] .' ' .$result['Person']['middle_name'] .' '.
						$result['Person']['last_name']; ?>",
				"returned_by":"<?php 
					$result = $this->requestAction(
							array(
								'controller' => 'ims_returns', 
								'action' => 'getUser'), 
							array('userid' => $ims_return['ImsReturn']['returned_by'])
						);				
					
						echo $result['Person']['first_name'] .' ' .$result['Person']['middle_name'] .' '.
						$result['Person']['last_name']; ?>",
				"returned_from":"<?php echo $ims_return['ReturningBranch']['name']; ?>",
				"status":"<?php echo $ims_return['ImsReturn']['status']; ?>",
				"created":"<?php echo $ims_return['ImsReturn']['created']; ?>",
				"modified":"<?php echo $ims_return['ImsReturn']['modified']; ?>"			}
<?php $st = true; } ?>		]
}