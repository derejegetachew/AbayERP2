{
	success:true,
	results: <?php echo $results; ?>,
	rows: [
<?php $st = false; foreach($ibd_odbps as $ibd_odbp){ if($st) echo ","; ?>			{
				"id":"<?php echo $ibd_odbp['IbdOdbp']['id']; ?>",
				"date":"<?php echo $ibd_odbp['IbdOdbp']['date']; ?>",
				"name_of_exporter":"<?php echo $ibd_odbp['IbdOdbp']['name_of_exporter']; ?>",
				"ref_no":"<?php echo $ibd_odbp['IbdOdbp']['ref_no']; ?>",
				"permit_no":"<?php echo $ibd_odbp['IbdOdbp']['permit_no']; ?>",
				"type":"<?php echo $ibd_odbp['IbdOdbp']['type']; ?>",
				"currency_code":"<?php echo $ibd_odbp['IbdOdbp']['currency_code']; ?>",
				"fct":"<?php echo $ibd_odbp['IbdOdbp']['fct']; ?>",
					"rate":"<?php echo $ibd_odbp['IbdOdbp']['rate']; ?>",
				"lcy":"<?php echo $ibd_odbp['IbdOdbp']['lcy']; ?>",
				"sett_fcy":"<?php echo $ibd_odbp['IbdOdbp']['sett_fcy']; ?>",
				"Deduction":"<?php echo $ibd_odbp['IbdOdbp']['Deduction']; ?>",
				"sett_date":"<?php echo $ibd_odbp['IbdOdbp']['sett_date']; ?>"			}
<?php $st = true; } ?>		]
}