{
	success:true,
	results: <?php echo $results; ?>,
	rows: [
<?php $st = false; foreach($ims_requisitions as $ims_requisition){ if($st) echo ","; ?>			{
				"id":"<?php echo $ims_requisition['ImsRequisition']['id']; ?>",
				"name":"<?php echo $ims_requisition['ImsRequisition']['name']; ?>",
				"budget_year":"<?php echo $ims_requisition['BudgetYear']['name']; ?>",
				"branch":"<?php echo $ims_requisition['Branch']['name']; ?>",
				"purpose":"<?php echo $ims_requisition['ImsRequisition']['purpose']; ?>",
				"requested_by":"<?php 
					$result = $this->requestAction(
							array(
								'controller' => 'ims_requisitions', 
								'action' => 'getUser'), 
							array('userid' => $ims_requisition['ImsRequisition']['requested_by'])
						);				
					
						echo $result['Person']['first_name'] .' ' .$result['Person']['middle_name'] .' '.
						$result['Person']['last_name']; ?>",				
				"approved/rejected_by":"<?php 
					$result = $this->requestAction(
							array(
								'controller' => 'ims_requisitions', 
								'action' => 'getUser'), 
							array('userid' => $ims_requisition['ImsRequisition']['approved_rejected_by'])
						);				
					
						echo $result['Person']['first_name'] .' ' .$result['Person']['middle_name'] .' '.
						$result['Person']['last_name']; ?>",
				"status":"<?php echo $ims_requisition['ImsRequisition']['status']; ?>",
				"created":"<?php echo $ims_requisition['ImsRequisition']['created']; ?>",
				"modified":"<?php echo $ims_requisition['ImsRequisition']['modified']; ?>"			}
<?php $st = true; } ?>		]
}