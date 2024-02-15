{
	success:true,
	results: <?php echo $results; ?>,
	rows: [
<?php $st = false; foreach($ims_maintenance_requests as $ims_maintenance_request){ if($st) echo ","; ?>			{
				"id":"<?php echo $ims_maintenance_request['ImsMaintenanceRequest']['id']; ?>",
				"name":"<?php echo $ims_maintenance_request['ImsMaintenanceRequest']['name']; ?>",
				"branch":"<?php echo $ims_maintenance_request['Branch']['name']; ?>",
				"description":"<?php echo $ims_maintenance_request['ImsMaintenanceRequest']['description']; ?>",
				"requested_by":"<?php 
					$result = $this->requestAction(
							array(
								'controller' => 'ims_maintenance_requests', 
								'action' => 'getUser'), 
							array('userid' => $ims_maintenance_request['ImsMaintenanceRequest']['requested_by'])
						);				
					
						echo $result['Person']['first_name'] .' ' .$result['Person']['middle_name'] .' '.
						$result['Person']['last_name']; ?>",
				"approved_rejected_by":"<?php if($ims_maintenance_request['ImsMaintenanceRequest']['approved_rejected_by'] != 0){
					$result = $this->requestAction(
							array(
								'controller' => 'ims_maintenance_requests', 
								'action' => 'getUser'), 
							array('userid' => $ims_maintenance_request['ImsMaintenanceRequest']['approved_rejected_by'])
						);				
					
						echo $result['Person']['first_name'] .' ' .$result['Person']['middle_name'] .' '.
						$result['Person']['last_name']; } else echo '';?>",
				"received_by":"<?php if($ims_maintenance_request['ImsMaintenanceRequest']['received_by'] != 0){
					$result = $this->requestAction(
							array(
								'controller' => 'ims_maintenance_requests', 
								'action' => 'getUser'), 
							array('userid' => $ims_maintenance_request['ImsMaintenanceRequest']['received_by'])
						);				
					
						echo $result['Person']['first_name'] .' ' .$result['Person']['middle_name'] .' '.
						$result['Person']['last_name']; } else echo '';?>",
				"status":"<?php echo $ims_maintenance_request['ImsMaintenanceRequest']['status']; ?>",
				"ims_item":"<?php echo $ims_maintenance_request['ImsItem']['name']; ?>",
				"tag":"<?php echo $ims_maintenance_request['ImsMaintenanceRequest']['tag']; ?>",
				"branch_recommendation":"<?php echo $ims_maintenance_request['ImsMaintenanceRequest']['branch_recommendation']; ?>",
				"technician_recommendation":"<?php echo $ims_maintenance_request['ImsMaintenanceRequest']['technician_recommendation']; ?>",
				"remark":"<?php echo $ims_maintenance_request['ImsMaintenanceRequest']['remark']; ?>",
				"created":"<?php echo $ims_maintenance_request['ImsMaintenanceRequest']['created']; ?>",
				"modified":"<?php echo $ims_maintenance_request['ImsMaintenanceRequest']['modified']; ?>"			}
<?php $st = true; } ?>		]
}