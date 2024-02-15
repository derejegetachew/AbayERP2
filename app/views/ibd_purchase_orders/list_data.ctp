{
	success:true,
	results: <?php echo $results; ?>,
	rows: [
<?php $st = false; foreach($ibd_purchase_orders as $ibd_purchase_order){ if($st) echo ","; ?>			{
				"id":"<?php echo $ibd_purchase_order['IbdPurchaseOrder']['id']; ?>",
				"PURCHASE_ORDER_ISSUE_DATE":"<?php echo $ibd_purchase_order['IbdPurchaseOrder']['PURCHASE_ORDER_ISSUE_DATE']; ?>",
				"NAME_OF_IMPORTER":"<?php echo $ibd_purchase_order['IbdPurchaseOrder']['NAME_OF_IMPORTER']; ?>",
				"PURCHASE_ORDER_NO":"<?php echo $ibd_purchase_order['IbdPurchaseOrder']['PURCHASE_ORDER_NO']; ?>",
				"currency_id":"<?php echo $ibd_purchase_order['IbdPurchaseOrder']['currency_id']; ?>",
				"FCY_AMOUNT":"<?php echo $ibd_purchase_order['IbdPurchaseOrder']['FCY_AMOUNT']; ?>",
				"RATE":"<?php echo $ibd_purchase_order['IbdPurchaseOrder']['RATE']; ?>",
				"CAD_PAYABLE_IN_BIRR":"<?php echo $ibd_purchase_order['IbdPurchaseOrder']['CAD_PAYABLE_IN_BIRR']; ?>",
					"percent":"<?php echo $ibd_purchase_order['IbdPurchaseOrder']['percent']; ?>",
				"ITEM_DESCRIPTION_OF_GOODS":"<?php echo $ibd_purchase_order['IbdPurchaseOrder']['ITEM_DESCRIPTION_OF_GOODS']; ?>",
				"DRAWER_NAME":"<?php echo $ibd_purchase_order['IbdPurchaseOrder']['DRAWER_NAME']; ?>",
				"MINUTE_NO":"<?php echo $ibd_purchase_order['IbdPurchaseOrder']['MINUTE_NO']; ?>",
				"FCY_APPROVAL_DATE":"<?php echo $ibd_purchase_order['IbdPurchaseOrder']['FCY_APPROVAL_DATE']; ?>",
				"FCY_APPROVAL_INTIAL_ORDER_NO":"<?php echo $ibd_purchase_order['IbdPurchaseOrder']['FCY_APPROVAL_INTIAL_ORDER_NO']; ?>",
				"FROM_THEIR_FCY_ACCOUNT":"<?php echo $ibd_purchase_order['IbdPurchaseOrder']['FROM_THEIR_FCY_ACCOUNT']; ?>",
				"EXPIRE_DATE":"<?php echo $ibd_purchase_order['IbdPurchaseOrder']['EXPIRE_DATE']; ?>",
				"REM_FCY_AMOUNT":"<?php echo $ibd_purchase_order['IbdPurchaseOrder']['REM_FCY_AMOUNT']; ?>",
				"REM_CAD_PAYABLE_IN_BIRR":"<?php echo $ibd_purchase_order['IbdPurchaseOrder']['REM_CAD_PAYABLE_IN_BIRR']; ?>"		,
				"REMARK":"<?php echo $ibd_purchase_order['IbdPurchaseOrder']['REMARK']; ?>"	,
        			"NBE_ACCOUNT":"<?php echo $ibd_purchase_order['IbdPurchaseOrder']['NBE_ACCOUNT']; ?>"				
}
<?php $st = true; } ?>		]
}