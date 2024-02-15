{
	success:true,
	results: <?php echo $results; ?>,
	rows: [
<?php $st = false; foreach($ibd_live_stocks as $ibd_live_stock){ if($st) echo ","; ?>			{
				"id":"<?php echo $ibd_live_stock['IbdLiveStock']['id']; ?>",
				"exporter_name":"<?php echo $ibd_live_stock['IbdLiveStock']['exporter_name']; ?>",
				"contract_date":"<?php echo $ibd_live_stock['IbdLiveStock']['contract_date']; ?>",
				"contract_registry_date":"<?php echo $ibd_live_stock['IbdLiveStock']['contract_registry_date']; ?>",
				"contract_registration_no":"<?php echo $ibd_live_stock['IbdLiveStock']['contract_registration_no']; ?>",
				"quantity_mt":"<?php echo $ibd_live_stock['IbdLiveStock']['quantity_mt']; ?>",
				"price_mt":"<?php echo $ibd_live_stock['IbdLiveStock']['price_mt']; ?>",
				"type_of_currency":"<?php echo $ibd_live_stock['IbdLiveStock']['type_of_currency']; ?>",
				"total_price":"<?php echo $ibd_live_stock['IbdLiveStock']['total_price']; ?>",
				"shipment_date":"<?php echo $ibd_live_stock['IbdLiveStock']['shipment_date']; ?>",
				"delivery_term":"<?php echo $ibd_live_stock['IbdLiveStock']['delivery_term']; ?>",
				"payment_method":"<?php echo $ibd_live_stock['IbdLiveStock']['payment_method']; ?>",
				"sales_contract_reference":"<?php echo $ibd_live_stock['IbdLiveStock']['sales_contract_reference']; ?>",
				"commodity_type":"<?php echo $ibd_live_stock['IbdLiveStock']['commodity_type']; ?>"			}
<?php $st = true; } ?>		]
}