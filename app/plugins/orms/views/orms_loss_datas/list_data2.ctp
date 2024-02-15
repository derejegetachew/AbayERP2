{
	success:true,
	results: <?php echo $results; ?>,
	rows: [
<?php $st = false; foreach($ormsLossDatas as $orms_loss_data){ if($st) echo ",";?>			{
				"id":"<?php echo $orms_loss_data['OrmsLossData']['id']; ?>",
				"branch":"<?php echo $orms_loss_data['Branch']['name']; ?>",
				"risk_category":"<?php 
					$result = $this->requestAction(
							array(
								'controller' => 'orms_loss_datas', 
								'action' => 'getparent'), 
							array('childid' => $orms_loss_data['OrmsLossData']['orms_risk_category_id'])
						);
							$category = explode('~',$result,2); echo $category[1];?>",
				"risk_subcategory":"<?php echo $category[0]; ?>",
				"risk":"<?php echo $orms_loss_data['OrmsRiskCategory']['name']; ?>",
				"created_by":"<?php echo $orms_loss_data['CreatedUser']['Person']['first_name'].' '.$orms_loss_data['CreatedUser']['Person']['middle_name']; ?>",
				"approved_by":"<?php echo $orms_loss_data['OrmsLossData']['approved_by']<> 0?$orms_loss_data['ApprovedUser']['Person']['first_name'].' '.$orms_loss_data['ApprovedUser']['Person']['middle_name']: ''; ?>",
				"occured_from":"<?php echo $orms_loss_data['OrmsLossData']['occured_from']; ?>",
				"occured_to":"<?php echo $orms_loss_data['OrmsLossData']['occured_to']; ?>",
				"discovered_date":"<?php echo $orms_loss_data['OrmsLossData']['discovered_date']; ?>",				
				"description":"<?php echo $orms_loss_data['OrmsLossData']['description']; ?>",
				"severity":"<?php if($orms_loss_data['OrmsLossData']['severity'] == 1){
								echo 'Insignificant'; 
							} else if($orms_loss_data['OrmsLossData']['severity'] == 2){
								echo 'Minor'; 
							} else if($orms_loss_data['OrmsLossData']['severity'] == 3){
								echo 'Moderate'; 
							} else if($orms_loss_data['OrmsLossData']['severity'] == 4){
								echo 'Major'; 
							}else if($orms_loss_data['OrmsLossData']['severity'] == 5){
								echo 'Disastrous'; 
							}?>",
				"frequency":"<?php if($orms_loss_data['OrmsLossData']['frequency'] == 1){
								echo 'Rare'; 
							} else if($orms_loss_data['OrmsLossData']['frequency'] == 2){
								echo 'Unlikely'; 
							} else if($orms_loss_data['OrmsLossData']['frequency'] == 3){
								echo 'Possible'; 
							} else if($orms_loss_data['OrmsLossData']['frequency'] == 4){
								echo 'Likely'; 
							}else if($orms_loss_data['OrmsLossData']['frequency'] == 5){
								echo 'Almost certain'; 
							}?>",
				"insured_amount":"<?php echo $orms_loss_data['OrmsLossData']['insured_amount']; ?>",
				"status":"<?php echo $orms_loss_data['OrmsLossData']['status']; ?>",
				"created":"<?php echo $orms_loss_data['OrmsLossData']['created']; ?>",
				"modified":"<?php echo $orms_loss_data['OrmsLossData']['modified']; ?>"			}
<?php $st = true; } ?>		]
}