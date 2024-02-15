{
	success:true,
	results: <?php echo $results; ?>,
	rows: [
<?php $st = false; foreach($ims_Grn_Items as $ims_Grn_Item){ if($st) echo ","; ?>			{
				"id":"<?php echo $ims_Grn_Item['ImsGrnItem']['id']; ?>",
				"code":"<?php echo $ims_Grn_Item['ImsPurchaseOrderItem']['ImsItem']['description']; ?>",
				"description":"<?php echo $ims_Grn_Item['ImsPurchaseOrderItem']['ImsItem']['name']; ?>",
				"measurement":"<?php echo $ims_Grn_Item['ImsPurchaseOrderItem']['measurement']; ?>",
				"quantity":"<?php echo $ims_Grn_Item['ImsGrnItem']['quantity']; ?>",
				"unit_price":"<?php echo $ims_Grn_Item['ImsGrnItem']['unit_price']; ?>"	}
<?php $st = true; } ?>		]
}