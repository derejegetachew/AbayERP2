{
	success:true,
	results: <?php echo $results; ?>,
	rows: [
<?php $st = false; foreach($ims_sirvs as $ims_sirv){ if($st) echo ","; ?>			{
				"id":"<?php echo $ims_sirv['ImsSirv']['id']; ?>",
				"name":"<?php echo $ims_sirv['ImsSirv']['name']; ?>",
				"ims_requisition":"<?php
					$result = $this->requestAction(
						array(
							'controller' => 'ims_sirvs', 
							'action' => 'getrequisition'), 
						array('requisitionid' => $ims_sirv['ImsSirv']['ims_requisition_id'])
					);					
					echo $result; 
				?>",
				"ims_branch":"",
				"status":"<?php echo $ims_sirv['ImsSirv']['status']; ?>",
				"created":"<?php echo $ims_sirv['ImsSirv']['created']; ?>",
				"modified":"<?php echo $ims_sirv['ImsSirv']['modified']; ?>"			}
<?php $st = true; } ?>		]
}