
		
<?php $ibdLiveStock_html = "<table cellspacing=3>" . 		"<tr><th align=right>" . __('Exporter Name', true) . ":</th><td><b>" . $ibdLiveStock['IbdLiveStock']['exporter_name'] . "</b></td></tr>" . 
		"<tr><th align=right>" . __('Contract Date', true) . ":</th><td><b>" . $ibdLiveStock['IbdLiveStock']['contract_date'] . "</b></td></tr>" . 
		"<tr><th align=right>" . __('Contract Registry Date', true) . ":</th><td><b>" . $ibdLiveStock['IbdLiveStock']['contract_registry_date'] . "</b></td></tr>" . 
		"<tr><th align=right>" . __('Contract Registration No', true) . ":</th><td><b>" . $ibdLiveStock['IbdLiveStock']['contract_registration_no'] . "</b></td></tr>" . 
		"<tr><th align=right>" . __('Quantity Mt', true) . ":</th><td><b>" . $ibdLiveStock['IbdLiveStock']['quantity_mt'] . "</b></td></tr>" . 
		"<tr><th align=right>" . __('Price Mt', true) . ":</th><td><b>" . $ibdLiveStock['IbdLiveStock']['price_mt'] . "</b></td></tr>" . 
		"<tr><th align=right>" . __('Type Of Currency', true) . ":</th><td><b>" . $ibdLiveStock['IbdLiveStock']['type_of_currency'] . "</b></td></tr>" . 
		"<tr><th align=right>" . __('Total Price', true) . ":</th><td><b>" . $ibdLiveStock['IbdLiveStock']['total_price'] . "</b></td></tr>" . 
		"<tr><th align=right>" . __('Shipment Date', true) . ":</th><td><b>" . $ibdLiveStock['IbdLiveStock']['shipment_date'] . "</b></td></tr>" . 
		"<tr><th align=right>" . __('Delivery Term', true) . ":</th><td><b>" . $ibdLiveStock['IbdLiveStock']['delivery_term'] . "</b></td></tr>" . 
		"<tr><th align=right>" . __('Payment Method', true) . ":</th><td><b>" . $ibdLiveStock['IbdLiveStock']['payment_method'] . "</b></td></tr>" . 
		"<tr><th align=right>" . __('Sales Contract Reference', true) . ":</th><td><b>" . $ibdLiveStock['IbdLiveStock']['sales_contract_reference'] . "</b></td></tr>" . 
		"<tr><th align=right>" . __('Commodity Type', true) . ":</th><td><b>" . $ibdLiveStock['IbdLiveStock']['commodity_type'] . "</b></td></tr>" . 
"</table>"; 
?>
		var ibdLiveStock_view_panel_1 = {
			html : '<?php echo $ibdLiveStock_html; ?>',
			frame : true,
			height: 80
		}
		var ibdLiveStock_view_panel_2 = new Ext.TabPanel({
			activeTab: 0,
			anchor: '100%',
			height:190,
			plain:true,
			defaults:{autoScroll: true},
			items:[
						]
		});

		var IbdLiveStockViewWindow = new Ext.Window({
			title: '<?php __('View IbdLiveStock'); ?>: <?php echo $ibdLiveStock['IbdLiveStock']['id']; ?>',
			width: 500,
			height:345,
			minWidth: 500,
			minHeight: 345,
			resizable: false,
			plain:true,
			bodyStyle:'padding:5px;',
			buttonAlign:'center',
                        modal: true,
			items: [ 
				ibdLiveStock_view_panel_1,
				ibdLiveStock_view_panel_2
			],

			buttons: [{
				text: '<?php __('Close'); ?>',
				handler: function(btn){
					IbdLiveStockViewWindow.close();
				}
			}]
		});
