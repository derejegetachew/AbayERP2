{
	success:true,
	results: <?php echo $results; ?>,
	rows: [
<?php $st = false; foreach($ibd_import_permits as $ibd_import_permit){ if($st) echo ","; ?>			{
				"id":"<?php echo $ibd_import_permit['IbdImportPermit']['id']; ?>",
				"PERMIT_ISSUE_DATE":"<?php echo $ibd_import_permit['IbdImportPermit']['PERMIT_ISSUE_DATE']; ?>",
				"NAME_OF_IMPORTER":"<?php echo $ibd_import_permit['IbdImportPermit']['NAME_OF_IMPORTER']; ?>",
				"IMPORT_PERMIT_NO":"<?php echo $ibd_import_permit['IbdImportPermit']['IMPORT_PERMIT_NO']; ?>",
				"currency_id":"<?php echo $ibd_import_permit['IbdImportPermit']['currency_id']; ?>",
				"FCY_AMOUNT":"<?php echo $ibd_import_permit['IbdImportPermit']['FCY_AMOUNT']; ?>",
				"PREVAILING_RATE":"<?php echo $ibd_import_permit['IbdImportPermit']['PREVAILING_RATE']; ?>",
				"LCY_AMOUNT":"<?php echo $ibd_import_permit['IbdImportPermit']['LCY_AMOUNT']; ?>",
				"payment_term_id":"<?php echo $ibd_import_permit['IbdImportPermit']['payment_term_id']; ?>",
				"REF_NO":"<?php echo $ibd_import_permit['IbdImportPermit']['REF_NO']; ?>",
				"ITEM_DESCRIPTION_OF_GOODS":"<?php echo $ibd_import_permit['IbdImportPermit']['ITEM_DESCRIPTION_OF_GOODS']; ?>",
				"SUPPLIERS_NAME":"<?php echo $ibd_import_permit['IbdImportPermit']['SUPPLIERS_NAME']; ?>",
				"MINUTE_NO":"<?php echo $ibd_import_permit['IbdImportPermit']['MINUTE_NO']; ?>",
				"FCY_APPROVAL_DATE":"<?php echo $ibd_import_permit['IbdImportPermit']['FCY_APPROVAL_DATE']; ?>",
				"FCY_APPROVAL_INTIAL_ORDER_NO":"<?php echo $ibd_import_permit['IbdImportPermit']['FCY_APPROVAL_INTIAL_ORDER_NO']; ?>",
				"FROM_THEIR_FCY_ACCOUNT":"<?php echo $ibd_import_permit['IbdImportPermit']['FROM_THEIR_FCY_ACCOUNT']; ?>",
				"THE_PRICE_AS_PER_NBE_SELLECTED":"<?php echo $ibd_import_permit['IbdImportPermit']['THE_PRICE_AS_PER_NBE_SELLECTED']; ?>",
				"NBE_UNDERTAKING":"<?php echo $ibd_import_permit['IbdImportPermit']['NBE_UNDERTAKING']; ?>",
				"SUPPLIERS_CREDIT":"<?php echo $ibd_import_permit['IbdImportPermit']['SUPPLIERS_CREDIT']; ?>",
				"EXPIRE_DTAE":"<?php echo $ibd_import_permit['IbdImportPermit']['EXPIRE_DTAE']; ?>",
				"REMARK":"<?php echo $ibd_import_permit['IbdImportPermit']['REMARK']; ?>",
"NBE_ACCOUNT":"<?php echo $ibd_import_permit['IbdImportPermit']['NBE_ACCOUNT']; ?>"
			}
<?php $st = true; } ?>		]
}