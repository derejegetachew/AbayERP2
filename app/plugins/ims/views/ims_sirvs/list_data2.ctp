{
	success:true,
	results: <?php echo $results; ?>,
	rows: [
<?php $st = false; foreach($ims_sirvs as $ims_sirv){ if($st) echo ","; ?>			{
				"id":"<?php echo $ims_sirv['ImsSirv']['id']; ?>",
				"name":"<?php echo $ims_sirv['ImsSirv']['name']; ?>",
				"ims_requisition":"<?php echo $ims_sirv['ImsRequisition']['name']; ?>",
				"ims_branch":"<?php
					$result = $this->requestAction(
						array(
							'controller' => 'ims_sirvs', 
							'action' => 'getbranch'), 
						array('branchid' => $ims_sirv['ImsRequisition']['branch_id'])
					);					
					echo $result; 
				?>",
				"status":"<?php echo $ims_sirv['ImsSirv']['status']; ?>",
				"created":"<?php echo $ims_sirv['ImsSirv']['created']; ?>",
				"modified":"<?php echo $ims_sirv['ImsSirv']['modified']; ?>"			}
<?php $st = true; } ?>		]
}