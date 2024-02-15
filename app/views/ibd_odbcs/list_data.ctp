{
	success:true,
	results: <?php echo $results; ?>,
	rows: [
<?php $st = false; foreach($ibd_odbcs as $ibd_odbc){ if($st) echo ","; ?>			{
				"id":"<?php echo $ibd_odbc['IbdOdbc']['id']; ?>",
				"Exporter_Name":"<?php echo $ibd_odbc['IbdOdbc']['Exporter_Name']; ?>",
				"payment_term":"<?php echo $ibd_odbc['PaymentTerm']['id']; ?>",
				"Doc_Ref":"<?php echo $ibd_odbc['IbdOdbc']['Doc_Ref']; ?>",
				"Permit_No":"<?php echo $ibd_odbc['IbdOdbc']['Permit_No']; ?>",
				"NBE_Permit_no":"<?php echo $ibd_odbc['IbdOdbc']['NBE_Permit_no']; ?>",
				"Branch_Name":"<?php echo $ibd_odbc['IbdOdbc']['Branch_Name']; ?>",
				"ODBC_DD":"<?php echo $ibd_odbc['IbdOdbc']['ODBC_DD']; ?>",
				"Destination":"<?php echo $ibd_odbc['IbdOdbc']['Destination']; ?>",
				"Single_Ent":"<?php echo $ibd_odbc['IbdOdbc']['Single_Ent']; ?>",
				"currency_type":"<?php echo $ibd_odbc['CurrencyType']['id']; ?>",
				"doc_permitt_amount":"<?php echo $ibd_odbc['IbdOdbc']['doc_permitt_amount']; ?>",
				"value_date":"<?php echo $ibd_odbc['IbdOdbc']['value_date']; ?>",
				"proceed_amount":"<?php echo $ibd_odbc['IbdOdbc']['proceed_amount']; ?>",
				"rate":"<?php echo $ibd_odbc['IbdOdbc']['rate']; ?>",
				"lcy":"<?php echo $ibd_odbc['IbdOdbc']['lcy']; ?>",
				"Deduction":"<?php echo $ibd_odbc['IbdOdbc']['Deduction']; ?>"			}
<?php $st = true; } ?>		]
}