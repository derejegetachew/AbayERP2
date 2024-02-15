{
	success:true,
	results: <?php echo $results; ?>,
	rows: [
<?php $st = false; foreach($ims_requisition_items as $ims_requisition_item){ if($st) echo ","; ?>			{
				"id":"<?php echo $ims_requisition_item['ImsRequisitionItem']['id']; ?>",
				"ims_requisition":"<?php echo $ims_requisition_item['ImsRequisition']['name']; ?>",
				"ims_item":"<?php echo $ims_requisition_item['ImsItem']['name']; ?>",
				"itemcode":"<?php echo $ims_requisition_item['ImsItem']['description']; ?>",
				"quantity":"<?php echo $ims_requisition_item['ImsRequisitionItem']['quantity']; ?>",
				"measurement":"<?php echo $ims_requisition_item['ImsRequisitionItem']['measurement']; ?>",
				"remark":"<?php echo $ims_requisition_item['ImsRequisitionItem']['remark']; ?>",
				"budget":"<?php 
				$result = $this->requestAction(
						array(
							'controller' => 'ims_requisition_items', 
							'action' => 'budget'), 
						array('itemid' => $ims_requisition_item['ImsItem']['id'],'branchid' => $ims_requisition_item['ImsRequisition']['branch_id']
							,'budgetyearid' => $ims_requisition_item['ImsRequisition']['budget_year_id'],'quantity' => $ims_requisition_item['ImsRequisitionItem']['quantity'])
					);
				if($result == 'Out of Budget'){
					echo '<font color=red>Out of Budget</font>';
				}else if($result == 'No Budget'){
					echo '<font color=red>No Budget</font>';
				}else echo '<font color=black>Within Budget</font>';				
				?>",
				"created":"<?php echo $ims_requisition_item['ImsRequisitionItem']['created']; ?>",
				"modified":"<?php echo $ims_requisition_item['ImsRequisitionItem']['modified']; ?>"			}
<?php $st = true; } ?>		]
}