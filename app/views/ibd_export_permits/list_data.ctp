{
	success:true,
	results: <?php echo $results; ?>,
	rows: [
<?php $st = false; foreach($ibd_export_permits as $ibd_export_permit){ if($st) echo ","; ?>			{
				"id":"<?php echo $ibd_export_permit['IbdExportPermit']['id']; ?>",
				"PERMIT_ISSUE_DATE":"<?php echo $ibd_export_permit['IbdExportPermit']['PERMIT_ISSUE_DATE']; ?>",
				"EXPORTER_NAME":"<?php echo $ibd_export_permit['IbdExportPermit']['EXPORTER_NAME']; ?>",
				"EXPORT_PERMIT_NO":"<?php echo $ibd_export_permit['IbdExportPermit']['EXPORT_PERMIT_NO']; ?>",
				"COMMODITY":"<?php echo $ibd_export_permit['IbdExportPermit']['COMMODITY']; ?>",
				"BUYER_NAME":"<?php echo $ibd_export_permit['IbdExportPermit']['BUYER_NAME']; ?>",
				"payment_term_id":"<?php echo $ibd_export_permit['IbdExportPermit']['payment_term_id']; ?>",
				"currency_id":"<?php echo $ibd_export_permit['IbdExportPermit']['currency_id']; ?>",
				"Advance_amount":"<?php echo $ibd_export_permit['IbdExportPermit']['Advance_amount']; ?>",
				"FCY_AMOUNT":"<?php echo $ibd_export_permit['IbdExportPermit']['FCY_AMOUNT']; ?>",
				"LC_REF_NO":"<?php echo $ibd_export_permit['IbdExportPermit']['LC_REF_NO']; ?>",
				"BUYING_RATE":"<?php echo $ibd_export_permit['IbdExportPermit']['BUYING_RATE']; ?>",
				"LCY_AMOUNT":"<?php echo $ibd_export_permit['IbdExportPermit']['LCY_AMOUNT']; ?>",
				"REMARK":"<?php echo $ibd_export_permit['IbdExportPermit']['REMARK']; ?>"			}
<?php $st = true; } ?>		]
}