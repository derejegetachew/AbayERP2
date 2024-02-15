
		
<?php $ibdSesameSeedsExportContract_html = "<table cellspacing=3>" . 		"<tr><th align=right>" . __('Exporter Name', true) . ":</th><td><b>" . $ibdSesameSeedsExportContract['IbdSesameSeedsExportContract']['exporter_name'] . "</b></td></tr>" . 
		"<tr><th align=right>" . __('Contract Date', true) . ":</th><td><b>" . $ibdSesameSeedsExportContract['IbdSesameSeedsExportContract']['contract_date'] . "</b></td></tr>" . 
		"<tr><th align=right>" . __('Contract Registry Date', true) . ":</th><td><b>" . $ibdSesameSeedsExportContract['IbdSesameSeedsExportContract']['contract_registry_date'] . "</b></td></tr>" . 
		"<tr><th align=right>" . __('Contract Registration No', true) . ":</th><td><b>" . $ibdSesameSeedsExportContract['IbdSesameSeedsExportContract']['contract_registration_no'] . "</b></td></tr>" . 
		"<tr><th align=right>" . __('Quantity Mt', true) . ":</th><td><b>" . $ibdSesameSeedsExportContract['IbdSesameSeedsExportContract']['quantity_mt'] . "</b></td></tr>" . 
		"<tr><th align=right>" . __('Price Mt', true) . ":</th><td><b>" . $ibdSesameSeedsExportContract['IbdSesameSeedsExportContract']['price_mt'] . "</b></td></tr>" . 
		"<tr><th align=right>" . __('Type Of Currency', true) . ":</th><td><b>" . $ibdSesameSeedsExportContract['IbdSesameSeedsExportContract']['type_of_currency'] . "</b></td></tr>" . 
		"<tr><th align=right>" . __('Total Price', true) . ":</th><td><b>" . $ibdSesameSeedsExportContract['IbdSesameSeedsExportContract']['total_price'] . "</b></td></tr>" . 
		"<tr><th align=right>" . __('Shipment Date', true) . ":</th><td><b>" . $ibdSesameSeedsExportContract['IbdSesameSeedsExportContract']['shipment_date'] . "</b></td></tr>" . 
		"<tr><th align=right>" . __('Delivery Term', true) . ":</th><td><b>" . $ibdSesameSeedsExportContract['IbdSesameSeedsExportContract']['delivery_term'] . "</b></td></tr>" . 
		"<tr><th align=right>" . __('Payment Method', true) . ":</th><td><b>" . $ibdSesameSeedsExportContract['IbdSesameSeedsExportContract']['payment_method'] . "</b></td></tr>" . 
		"<tr><th align=right>" . __('Sales Contract Reference', true) . ":</th><td><b>" . $ibdSesameSeedsExportContract['IbdSesameSeedsExportContract']['sales_contract_reference'] . "</b></td></tr>" . 
"</table>"; 
?>
		var ibdSesameSeedsExportContract_view_panel_1 = {
			html : '<?php echo $ibdSesameSeedsExportContract_html; ?>',
			frame : true,
			height: 80
		}
		var ibdSesameSeedsExportContract_view_panel_2 = new Ext.TabPanel({
			activeTab: 0,
			anchor: '100%',
			height:190,
			plain:true,
			defaults:{autoScroll: true},
			items:[
						]
		});

		var IbdSesameSeedsExportContractViewWindow = new Ext.Window({
			title: '<?php __('View IbdSesameSeedsExportContract'); ?>: <?php echo $ibdSesameSeedsExportContract['IbdSesameSeedsExportContract']['id']; ?>',
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
				ibdSesameSeedsExportContract_view_panel_1,
				ibdSesameSeedsExportContract_view_panel_2
			],

			buttons: [{
				text: '<?php __('Close'); ?>',
				handler: function(btn){
					IbdSesameSeedsExportContractViewWindow.close();
				}
			}]
		});
