{
	success:true,
	results: <?php echo $results; ?>,
	rows: [
<?php $st = false; foreach($ibd_outstanding_export_lcs as $ibd_outstanding_export_lc){ if($st) echo ","; ?>			{
				"id":"<?php echo $ibd_outstanding_export_lc['IbdOutstandingExportLc']['id']; ?>",
				"exporter_name":"<?php echo $ibd_outstanding_export_lc['IbdOutstandingExportLc']['exporter_name']; ?>",
				"total_lc_fcy":"<?php echo $ibd_outstanding_export_lc['IbdOutstandingExportLc']['total_lc_fcy']; ?>",
				"total_lc_amount":"<?php echo $ibd_outstanding_export_lc['IbdOutstandingExportLc']['total_lc_amount']; ?>",
				"outstanding_lc_fcy":"<?php echo $ibd_outstanding_export_lc['IbdOutstandingExportLc']['outstanding_lc_fcy']; ?>",
				"outstanding_lc_amount":"<?php echo $ibd_outstanding_export_lc['IbdOutstandingExportLc']['outstanding_lc_amount']; ?>",
				"issuing_bank_ref_no":"<?php echo $ibd_outstanding_export_lc['IbdOutstandingExportLc']['issuing_bank_ref_no']; ?>",
				"our_ref_no":"<?php echo $ibd_outstanding_export_lc['IbdOutstandingExportLc']['our_ref_no']; ?>",
				"date_of_issue":"<?php echo $ibd_outstanding_export_lc['IbdOutstandingExportLc']['date_of_issue']; ?>",
				"expire_date":"<?php echo $ibd_outstanding_export_lc['IbdOutstandingExportLc']['expire_date']; ?>",
				"place_of_expire":"<?php echo $ibd_outstanding_export_lc['IbdOutstandingExportLc']['place_of_expire']; ?>",
				"sett_date":"<?php echo $ibd_outstanding_export_lc['IbdOutstandingExportLc']['sett_date']; ?>",
				"sett_fcy":"<?php echo $ibd_outstanding_export_lc['IbdOutstandingExportLc']['sett_fcy']; ?>",
				"sett_amount":"<?php echo $ibd_outstanding_export_lc['IbdOutstandingExportLc']['sett_amount']; ?>",
				"sett_reference_no":"<?php echo $ibd_outstanding_export_lc['IbdOutstandingExportLc']['sett_reference_no']; ?>",
				"outstanding_remaining_lc_fcy":"<?php echo $ibd_outstanding_export_lc['IbdOutstandingExportLc']['outstanding_remaining_lc_fcy']; ?>",
				"outstanding_remaining_lc_value":"<?php echo $ibd_outstanding_export_lc['IbdOutstandingExportLc']['outstanding_remaining_lc_value']; ?>"			}
<?php $st = true; } ?>		]
}