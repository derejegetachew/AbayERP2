{
	success:true,
	results: <?php echo $results; ?>,
	rows: [
<?php $st = false; foreach($ims_sirvs as $ims_sirv){ if($st) echo ","; ?>			{
				"id":"<?php echo $ims_sirv['s']['id']; ?>",
				"name":"<?php echo $ims_sirv['s']['name']; ?>",
				"ims_requisition":"<?php
        /*
					$result = $this->requestAction(
						array(
							'controller' => 'ims_sirvs', 
							'action' => 'getrequisition'), 
						array('requisitionid' => $ims_sirv['ImsSirv']['ims_requisition_id'])
					);	
          		*/		
					//echo $result; 
           echo $ims_sirv['r']['request'];
				?>",
				"ims_branch":"<?php
        /*
					$result = $this->requestAction(
						array(
							'controller' => 'ims_sirvs', 
							'action' => 'getbranchname'), 
						array('requisitionid' => $ims_sirv['s']['ims_requisition_id'])
					);			
         		
					echo $result; 
                */
          echo $ims_sirv['b']['branch'];;
				?>",
				"status":"<?php echo $ims_sirv['s']['status']; ?>",
				"created":"<?php echo $ims_sirv['s']['created']; ?>",
				"modified":"<?php echo $ims_sirv['s']['modified']; ?>"			}
<?php $st = true; } ?>		]
}