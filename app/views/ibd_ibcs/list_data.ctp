{
	success:true,
	results: <?php echo $results; ?>,
	rows: [
<?php $st = false; foreach($ibd_ibcs as $ibd_ibc){ if($st) echo ",";  ?>			{

				"id":"<?php echo $ibd_ibc['IbdIbc']['id']; ?>",
				"ISSUE_DATE":"<?php echo $ibd_ibc['IbdIbc']['ISSUE_DATE']; ?>",
				"NAME_OF_IMPORTER":"<?php echo $ibd_ibc['IbdIbc']['NAME_OF_IMPORTER']; ?>",
				"IBC_REFERENCE":"<?php if($ibd_ibc['IbdIbc']['po_updated'] =='0') {echo '<font color=red>'.$ibd_ibc['IbdIbc']['IBC_REFERENCE'].'</font>';}else{echo '<font color=black>'.$ibd_ibc['IbdIbc']['IBC_REFERENCE'].'</font>';} ?>",
				"currency_id":"<?php echo $ibd_ibc['IbdIbc']['currency_id']; ?>",
				"FCY_AMOUNT":"<?php echo $ibd_ibc['IbdIbc']['FCY_AMOUNT']; ?>",
				"REMITTING_BANK":"<?php echo $ibd_ibc['IbdIbc']['REMITTING_BANK']; ?>",
				"REIBURSING_BANK":"<?php echo $ibd_ibc['IbdIbc']['REIBURSING_BANK']; ?>",
				"PURCHASE_ORDER_NO":"<?php echo $ibd_ibc['IbdIbc']['PURCHASE_ORDER_NO']; ?>",
				"FCY_APPROVAL_INITIAL_NO":"<?php echo $ibd_ibc['IbdIbc']['FCY_APPROVAL_INITIAL_NO']; ?>",
				"REM_FCY_AMOUNT":"<?php echo $ibd_ibc['IbdIbc']['REM_FCY_AMOUNT']; ?>",
				"REM_CAD_PAYABLE_IN_BIRR":"<?php echo $ibd_ibc['IbdIbc']['REM_CAD_PAYABLE_IN_BIRR']; ?>",
				"SETT_Date":"<?php echo $ibd_ibc['IbdIbc']['SETT_Date']; ?>",	
				"SETT_Amount":"<?php echo $ibd_ibc['IbdIbc']['SETT_Amount']; ?>",	
				"PERMIT_NO":"<?php echo $ibd_ibc['IbdIbc']['PERMIT_NO']; ?>",
				"SETT_FCY":"<?php echo $ibd_ibc['IbdIbc']['SETT_FCY']; ?>",
				"po_updated":"<?php echo $ibd_ibc['IbdIbc']['po_updated']; ?>",
				"IBC":"<?php echo $ibd_ibc['IbdIbc']['IBC_REFERENCE']; ?>"
					}
<?php $st = true; } ?>		]
}