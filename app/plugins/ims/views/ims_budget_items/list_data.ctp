{
	success:true,
	results: <?php echo $results; ?>,
	rows: [
<?php $st = false; foreach($ims_budget_items as $ims_budget_item){ if($st) echo ","; ?>			{
				"id":"<?php echo $ims_budget_item['ImsBudgetItem']['id']; ?>",
				"ims_budget":"<?php echo $ims_budget_item['ImsBudget']['name']; ?>",
				"ims_item":"<?php echo $ims_budget_item['ImsItem']['name']; ?>",				
				"item_category":"<?php 
				$result = $this->requestAction(
						array(
							'controller' => 'ims_budget_items', 
							'action' => 'GetItemCategory'), 
						array('categoryid' => $ims_budget_item['ImsItem']['ims_item_category_id']));
				echo $result; 
				?>",
				"quantity":"<?php echo $ims_budget_item['ImsBudgetItem']['quantity']; ?>",
				"measurement":"<?php echo $ims_budget_item['ImsBudgetItem']['measurement']; ?>",
				"created":"<?php echo $ims_budget_item['ImsBudgetItem']['created']; ?>",
				"modified":"<?php echo $ims_budget_item['ImsBudgetItem']['modified']; ?>"			}
<?php $st = true; } ?>		]
}