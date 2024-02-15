{
	success:true,
	results: <?php echo $results; ?>,
	rows: [
<?php $st = false; foreach($ibd_invisible_permits as $ibd_invisible_permit){ if($st) echo ","; ?>			{
				"id":"<?php echo $ibd_invisible_permit['IbdInvisiblePermit']['id']; ?>",
				"DATE_OF_ISSUE":"<?php echo $ibd_invisible_permit['IbdInvisiblePermit']['DATE_OF_ISSUE']; ?>",
				"NAME_OF_APPLICANT":"<?php echo $ibd_invisible_permit['IbdInvisiblePermit']['NAME_OF_APPLICANT']; ?>",
				"PERMIT_NO":"<?php echo $ibd_invisible_permit['IbdInvisiblePermit']['PERMIT_NO']; ?>",
				"PURPOSE_OF_PAYMENT":"<?php echo $ibd_invisible_permit['IbdInvisiblePermit']['PURPOSE_OF_PAYMENT']; ?>",
				"currency_id":"<?php echo $ibd_invisible_permit['CurrencyType']['id']; ?>",
				"FCY_AMOUNT":"<?php echo $ibd_invisible_permit['IbdInvisiblePermit']['FCY_AMOUNT']; ?>",
				"rate":"<?php echo $ibd_invisible_permit['IbdInvisiblePermit']['rate']; ?>",
				"LCY_AMOUNT":"<?php echo $ibd_invisible_permit['IbdInvisiblePermit']['LCY_AMOUNT']; ?>",
				"TT_REFERENCE":"<?php echo $ibd_invisible_permit['IbdInvisiblePermit']['TT_REFERENCE']; ?>",
				
				"FROM_THEIR_LCY_ACCOUNT":"<?php echo $ibd_invisible_permit['IbdInvisiblePermit']['FROM_THEIR_LCY_ACCOUNT']; ?>",
				"REMARK":"<?php echo $ibd_invisible_permit['IbdInvisiblePermit']['REMARK']; ?>"			}
<?php $st = true; } ?>		]
}