{
	success:true,
	results: <?php echo $results; ?>,
	rows: [
<?php $st = false; foreach($ibd_lcs as $ibd_lc){ if($st) echo ","; ?>			{
				"id":"<?php echo $ibd_lc['IbdLc']['id']; ?>",
				"LC_ISSUE_DATE":"<?php echo $ibd_lc['IbdLc']['LC_ISSUE_DATE']; ?>",
				"NAME_OF_IMPORTER":"<?php echo $ibd_lc['IbdLc']['NAME_OF_IMPORTER']; ?>",
				"LC_REF_NO":"<?php echo $ibd_lc['IbdLc']['LC_REF_NO']; ?>",
				"PERMIT_NO":"<?php echo $ibd_lc['IbdLc']['PERMIT_NO']; ?>",
				"currency_type":"<?php echo $ibd_lc['CurrencyType']['id']; ?>",
				"FCY_AMOUNT":"<?php echo $ibd_lc['IbdLc']['FCY_AMOUNT']; ?>",
				"OPENING_RATE":"<?php echo $ibd_lc['IbdLc']['OPENING_RATE']; ?>",
				"LCY_AMOUNT":"<?php echo $ibd_lc['IbdLc']['LCY_AMOUNT']; ?>",
				"MARGIN_AMT":"<?php echo $ibd_lc['IbdLc']['MARGIN_AMT']; ?>",
				"OPEN_THROUGH":"<?php echo $ibd_lc['IbdLc']['OPEN_THROUGH']; ?>",
				"REIBURSING_BANK":"<?php echo $ibd_lc['IbdLc']['REIBURSING_BANK']; ?>",
				"MARGIN_AMOUNT":"<?php echo $ibd_lc['IbdLc']['MARGIN_AMOUNT']; ?>",
				"EXPIRY_DATE":"<?php echo $ibd_lc['IbdLc']['EXPIRY_DATE']; ?>",
				"SETT_DATE":"<?php echo $ibd_lc['IbdLc']['SETT_DATE']; ?>",
				"SETT_FCY_AMOUNT":"<?php echo $ibd_lc['IbdLc']['SETT_FCY_AMOUNT']; ?>",
				"SETT_Rate":"<?php echo $ibd_lc['IbdLc']['SETT_Rate']; ?>",
				"SETT_LCY_Amt":"<?php echo $ibd_lc['IbdLc']['SETT_LCY_Amt']; ?>",
				"SETT_Margin_Amt":"<?php echo $ibd_lc['IbdLc']['SETT_Margin_Amt']; ?>",
				"OUT_FCY_AMOUNT":"<?php echo $ibd_lc['IbdLc']['OUT_FCY_AMOUNT']; ?>",
				"OUT_BIRR_VALUE":"<?php echo $ibd_lc['IbdLc']['OUT_BIRR_VALUE']; ?>",
				"OUT_Margin_Amt":"<?php echo $ibd_lc['IbdLc']['OUT_Margin_Amt']; ?>"			}
<?php $st = true; } ?>		]
}