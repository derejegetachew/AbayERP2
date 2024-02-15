{
	success:true,
	results: <?php echo $results; ?>,
	rows: [
<?php $st = false; foreach($ims_Requisition_Items as $ims_Requisition_Item){ if($st) echo ","; ?>			{
				"code":"<?php echo $ims_Requisition_Item['ImsItem']['description']; ?>",
				"description":"<?php echo $ims_Requisition_Item['ImsItem']['name']; ?>",
				"measurement":"<?php echo $ims_Requisition_Item['ImsRequisitionItem']['measurement']; ?>",
				"quantity":"<?php echo $ims_Requisition_Item['ImsRequisitionItem']['quantity']; ?>",
				"issued":"<?php echo $ims_Requisition_Item['ImsRequisitionItem']['issued']; ?>",
				"remark":"<?php echo $ims_Requisition_Item['ImsRequisitionItem']['remark']; ?>",
				"balance":"<?php if(count($ims_Requisition_Item['ImsItem']['ImsCard'])>0) { echo $ims_Requisition_Item['ImsItem']['ImsCard'][count($ims_Requisition_Item['ImsItem']['ImsCard']) - 1]['balance'];}else echo 0; ?>",
				"reserved":"<?php
					$result = $this->requestAction(
						array(
							'controller' => 'ims_sirv_items', 
							'action' => 'getreserved'), 
						array('itemid' => $ims_Requisition_Item['ImsItem']['id'])
					);					
					echo '<font color=red>'.$result.'</font>'; 
				?>"
				<?php 
					/*foreach($stores as $store){ 
						echo ',"'.$store['ImsStore']['name'].'":"';
						$found=false;
						foreach($ims_Requisition_Item['ImsItem']['ImsStoresItem'] as $storeitem){
							if($storeitem['ims_store_id'] == $store['ImsStore']['id']){
								 echo $storeitem['balance'];
								 $found =true;
								 break;
							}
						}
						if(!$found)
							echo "0";
						echo '"';
				}*/?>,
				"balance_store":"<?php $found=false;
						foreach($ims_Requisition_Item['ImsItem']['ImsStoresItem'] as $storeitem){
							if($storeitem['ims_store_id'] == $ims_store_id){
								 echo $storeitem['balance'];
								 $found =true;
								 break;
							}
						}
						if(!$found)
							echo 0; ?>",
				"reserved_store":"<?php
					$result1 = $this->requestAction(
						array(
							'controller' => 'ims_sirv_items', 
							'action' => 'getreservedstore'), 
						array('itemid' => $ims_Requisition_Item['ImsItem']['id'],'storeid' => $ims_store_id)
					);					
					echo '<font color=red>'.$result1.'</font>'; 
				?>"}
<?php $st = true; } ?>		]
}