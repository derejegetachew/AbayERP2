{
	success:true,
	results: <?php echo $results; ?>,
	rows: [
<?php $st = false; foreach($ims_rents as $ims_rent){ if($st) echo ","; ?>			{
				<?php 
					$today = date("Y-m-d"); 
					$end_date = date("Y-m-d", strtotime('+30 days'));
					$end_date_contract = date("Y-m-d", strtotime('+90 days'));
					$color = 'black';
					if($ims_rent['ImsRent']['contract_end_date'] < $end_date_contract){
						$color = 'red';
					}
					
					else if($ims_rent['ImsRent']['prepayed_end_date'] < $end_date){
						$color = 'blue';
					}
				?>
				
				"id":"<?php echo $ims_rent['ImsRent']['id']; ?>",
				"branch":"<?php echo $ims_rent['Branch']['name'] != 'None'? '<font color = '.$color.'>' .$ims_rent['Branch']['name'] : '<font color = '.$color.'>' .$ims_rent['ImsRent']['branch_id']; ?>",
        "region":"<?php echo '<font color = '.$color.'>' .$ims_rent['Branch']['region']; ?>",
				"width":"<?php echo '<font color = '.$color.'>' .$ims_rent['ImsRent']['width']; ?>",
				"monthly_rent":"<?php echo '<font color = '.$color.'>' .number_format($ims_rent['ImsRent']['monthly_rent'], 2, '.', ','); ?>",
				"contract_signed_date":"<?php echo '<font color = '.$color.'>' .$ims_rent['ImsRent']['contract_signed_date']; ?>",
				"contract_age":"<?php echo '<font color = '.$color.'>' .$ims_rent['ImsRent']['contract_age']; ?>",
				"contract_functional_date":"<?php echo '<font color = '.$color.'>' .$ims_rent['ImsRent']['contract_functional_date']; ?>",
				"contract_end_date":"<?php echo '<font color = '.$color.'>' .$ims_rent['ImsRent']['contract_end_date']; ?>",
				"prepayed_amount":"<?php echo '<font color = '.$color.'>' .$ims_rent['ImsRent']['prepayed_amount']; ?>",
				"prepayed_end_date":"<?php echo '<font color = '.$color.'>' .$ims_rent['ImsRent']['prepayed_end_date']; ?>",
				"created_by":"<?php 
					$result = $this->requestAction(
							array(
								'controller' => 'ims_rents', 
								'action' => 'getUser'), 
							array('userid' => $ims_rent['ImsRent']['created_by'])
						);				
					
						echo '<font color = '.$color.'>' .$result['Person']['first_name'] .' ' .$result['Person']['middle_name'] .' '.
						$result['Person']['last_name']; ?>",
				"renter":"<?php echo '<font color = '.$color.'>' .$ims_rent['ImsRent']['renter']; ?>",
				"address":"<?php echo '<font color = '.$color.'>' .$ims_rent['ImsRent']['address']; ?>",
				"created":"<?php echo '<font color = '.$color.'>' .$ims_rent['ImsRent']['created']; ?>",
				"modified":"<?php echo '<font color = '.$color.'>' .$ims_rent['ImsRent']['modified']; ?>",
        "rem_amount_term":"<?php echo '<font color = '.$color.'>' .$ims_rent['ImsRent']['rem_payment_term']; ?>"		
        	}
<?php $st = true; } ?>		]
}