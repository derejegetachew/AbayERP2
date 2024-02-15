{
	success:true,
	results: <?php echo $results; ?>,
	rows: [
<?php $st = false; foreach($ims_requisitions as $ims_requisition){ if($st) echo ","; ?>			{
				"id":"<?php echo $ims_requisition['r']['id']; ?>",
				"name":"<?php echo $ims_requisition['r']['name']; ?>",
				"budget_year":"<?php echo $ims_requisition['y']['year']; ?>",
				"branch":"<?php echo $ims_requisition['b']['branch']; ?>",
				"purpose":"<?php echo $ims_requisition['r']['purpose']; ?>",
				"requested_by":"<?php
          echo $ims_requisition[0]['requester'];
         /*
					$result = $this->requestAction(
							array(
								'controller' => 'ims_requisitions', 
								'action' => 'getUser'), 
							array('userid' => $ims_requisition['ImsRequisition']['requested_by'])
						);				
					
						echo $result['Person']['first_name'] .' ' .$result['Person']['middle_name'] .' '.
						$result['Person']['last_name']; 
                                                 */
         
            
            ?>",				
				"approved/rejected_by":"<?php 
          echo $ims_requisition[0]['approver'];
        /*
					$result = $this->requestAction(
							array(
								'controller' => 'ims_requisitions', 
								'action' => 'getUser'), 
							array('userid' => $ims_requisition['ImsRequisition']['approved_rejected_by'])
						);				
					
						echo $result['Person']['first_name'] .' ' .$result['Person']['middle_name'] .' '.
						$result['Person']['last_name']; 
            */
            ?>",
				"status":"<?php if($ims_requisition['r']['status'] =='accepted'){ echo '<font color=green>accepted</font>';} else if ($ims_requisition['r']['status'] =='received'){ echo '<font color=green>received</font>';}else if($ims_requisition['r']['status'] =='approved'){echo '<font color=#DF7401>approved</font>';} else echo $ims_requisition['r']['status']; ?>",
				"created":"<?php echo $ims_requisition['r']['created']; ?>",
				"modified":"<?php echo $ims_requisition['r']['modified']; ?>"	,
        "action_dt":"<?php echo $ims_requisition['r']['action_dt']; ?>"	
        		}
<?php $st = true; } ?>		]
}