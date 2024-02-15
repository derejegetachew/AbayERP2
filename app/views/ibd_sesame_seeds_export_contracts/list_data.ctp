{
	success:true,
	results: <?php echo $results; ?>,
	rows: [
<?php $st = false; foreach($ibd_sesame_seeds_export_contracts as $ibd_sesame_seeds_export_contract){ if($st) echo ","; ?>			{
				"id":"<?php echo $ibd_sesame_seeds_export_contract['IbdSesameSeedsExportContract']['id']; ?>",
				"exporter_name":"<?php echo $ibd_sesame_seeds_export_contract['IbdSesameSeedsExportContract']['exporter_name']; ?>",
				"contract_date":"<?php echo $ibd_sesame_seeds_export_contract['IbdSesameSeedsExportContract']['contract_date']; ?>",
				"contract_registry_date":"<?php echo $ibd_sesame_seeds_export_contract['IbdSesameSeedsExportContract']['contract_registry_date']; ?>",
				"contract_registration_no":"<?php echo $ibd_sesame_seeds_export_contract['IbdSesameSeedsExportContract']['contract_registration_no']; ?>",
				"quantity_mt":"<?php echo $ibd_sesame_seeds_export_contract['IbdSesameSeedsExportContract']['quantity_mt']; ?>",
				"price_mt":"<?php echo $ibd_sesame_seeds_export_contract['IbdSesameSeedsExportContract']['price_mt']; ?>",
				"type_of_currency":"<?php echo $ibd_sesame_seeds_export_contract['IbdSesameSeedsExportContract']['type_of_currency']; ?>",
				"total_price":"<?php echo $ibd_sesame_seeds_export_contract['IbdSesameSeedsExportContract']['total_price']; ?>",
				"shipment_date":"<?php echo $ibd_sesame_seeds_export_contract['IbdSesameSeedsExportContract']['shipment_date']; ?>",
				"delivery_term":"<?php echo $ibd_sesame_seeds_export_contract['IbdSesameSeedsExportContract']['delivery_term']; ?>",
				"payment_method":"<?php echo $ibd_sesame_seeds_export_contract['IbdSesameSeedsExportContract']['payment_method']; ?>",
				"sales_contract_reference":"<?php echo $ibd_sesame_seeds_export_contract['IbdSesameSeedsExportContract']['sales_contract_reference']; ?>"			}
<?php $st = true; } ?>		]
}