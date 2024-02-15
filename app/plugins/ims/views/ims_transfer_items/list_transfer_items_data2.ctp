{
	success:true,
	results: <?php echo $results; ?>,
	rows: [
<?php $st = false; $tagresult; foreach($ims_Transfer_Items as $ims_Transfer_Item){ if($st) echo ","; ?>			{
				"id":"<?php echo $ims_Transfer_Item['ImsTransferItem']['id']; ?>",
				"code":"<?php echo $ims_Transfer_Item['ImsItem']['description']; ?>",
				"description":"<?php echo $ims_Transfer_Item['ImsItem']['name']; ?>",
				"measurement":"<?php echo $ims_Transfer_Item['ImsTransferItem']['measurement']; ?>",
				"remaining":"<?php echo $ims_Transfer_Item['ImsTransferItem']['quantity']; ?>",
				"quantity":"<?php echo $ims_Transfer_Item['ImsTransferItem']['quantity']; ?>",
				"unit_price":"<?php echo $ims_Transfer_Item['ImsTransferItem']['unit_price']; ?>",
				"remark":"",
				"tag":"<?php echo $ims_Transfer_Item['ImsTransferItem']['tag'];?>"			}
<?php $st = true; } ?>		]
}