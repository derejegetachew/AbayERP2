{
	success:true,
	results: <?php echo $results; ?>,
	rows: [
<?php $st = false; foreach($ibd_tts as $ibd_tt){ if($st) echo ","; ?>			{
				"id":"<?php echo $ibd_tt['IbdTt']['id']; ?>",
				"DATE_OF_ISSUE":"<?php echo $ibd_tt['IbdTt']['DATE_OF_ISSUE']; ?>",
				"NAME_OF_APPLICANT":"<?php echo $ibd_tt['IbdTt']['NAME_OF_APPLICANT']; ?>",
				"beneficiary_name":"<?php echo $ibd_tt['IbdTt']['beneficiary_name']; ?>",
				"currency_id":"<?php echo $ibd_tt['IbdTt']['currency_id']; ?>",
				"FCY_AMOUNT":"<?php echo $ibd_tt['IbdTt']['FCY_AMOUNT']; ?>",
				"rate":"<?php echo $ibd_tt['IbdTt']['rate']; ?>",
				"LCY_AMOUNT":"<?php echo $ibd_tt['IbdTt']['LCY_AMOUNT']; ?>",
				"TT_REFERENCE":"<?php echo $ibd_tt['IbdTt']['TT_REFERENCE']; ?>",
				"PERMIT_NO":"<?php echo $ibd_tt['IbdTt']['PERMIT_NO']; ?>",
				"FCY_APPROVAL_DATE":"<?php echo $ibd_tt['IbdTt']['FCY_APPROVAL_DATE']; ?>",
				"FCY_APPROVAL_INTIAL_ORDER_NO":"<?php echo $ibd_tt['IbdTt']['FCY_APPROVAL_INTIAL_ORDER_NO']; ?>",
				"FROM_THEIR_FCY_ACCOUNT":"<?php echo $ibd_tt['IbdTt']['FROM_THEIR_FCY_ACCOUNT']; ?>",
				"FROM_LCY_ACCOUNT":"<?php echo $ibd_tt['IbdTt']['FROM_LCY_ACCOUNT']; ?>",
				"REIBURSING_BANK":"<?php echo $ibd_tt['IbdTt']['REIBURSING_BANK']; ?>",
				"permitType":"<?php echo $ibd_tt['IbdTt']['permitType']; ?>",
				"REMARK":"<?php echo $ibd_tt['IbdTt']['REMARK']; ?>"			

			}
<?php $st = true; } ?>		]
}