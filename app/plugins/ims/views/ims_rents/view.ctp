
		
<?php $imsRent_html = "<table cellspacing=3>" . 		"<tr><th align=right>" . __('Branch', true) . ":</th><td><b>" . $imsRent['Branch']['name'] . "</b></td></tr>" . 
		"<tr><th align=right>" . __('Width', true) . ":</th><td><b>" . $imsRent['ImsRent']['width'] . "</b></td></tr>" . 
		"<tr><th align=right>" . __('Monthly Rent', true) . ":</th><td><b>" . $imsRent['ImsRent']['monthly_rent'] . "</b></td></tr>" . 
		"<tr><th align=right>" . __('Contract Signed Date', true) . ":</th><td><b>" . $imsRent['ImsRent']['contract_signed_date'] . "</b></td></tr>" . 
		"<tr><th align=right>" . __('Contract Age', true) . ":</th><td><b>" . $imsRent['ImsRent']['contract_age'] . "</b></td></tr>" . 
		"<tr><th align=right>" . __('Contract Functional Date', true) . ":</th><td><b>" . $imsRent['ImsRent']['contract_functional_date'] . "</b></td></tr>" . 
		"<tr><th align=right>" . __('Contract End Date', true) . ":</th><td><b>" . $imsRent['ImsRent']['contract_end_date'] . "</b></td></tr>" . 
		"<tr><th align=right>" . __('Prepayed Amount', true) . ":</th><td><b>" . $imsRent['ImsRent']['prepayed_amount'] . "</b></td></tr>" . 
		"<tr><th align=right>" . __('Prepayed End Date', true) . ":</th><td><b>" . $imsRent['ImsRent']['prepayed_end_date'] . "</b></td></tr>" . 
		"<tr><th align=right>" . __('Renter name', true) . ":</th><td><b>" . $imsRent['ImsRent']['renter'] . "</b></td></tr>" .
		"<tr><th align=right>" . __('Renter address', true) . ":</th><td><b>" . $imsRent['ImsRent']['address'] . "</b></td></tr>" .
"</table>"; 
?>
		var imsRent_view_panel_1 = {
			html : '<?php echo $imsRent_html; ?>',
			frame : true,
			height: 190
		}
		var imsRent_view_panel_2 = new Ext.TabPanel({
			activeTab: 0,
			anchor: '100%',
			height:190,
			plain:true,
			defaults:{autoScroll: true},
			items:[
						]
		});

		var ImsRentViewWindow = new Ext.Window({
			title: '<?php __('View ImsRent'); ?>: <?php echo $imsRent['ImsRent']['id']; ?>',
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
				imsRent_view_panel_1,
				imsRent_view_panel_2
			],

			buttons: [{
				text: '<?php __('Close'); ?>',
				handler: function(btn){
					ImsRentViewWindow.close();
				}
			}]
		});
