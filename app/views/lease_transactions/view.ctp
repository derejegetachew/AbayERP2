
		
<?php $leaseTransaction_html = "<table cellspacing=3>" . 		"<tr><th align=right>" . __('Lease', true) . ":</th><td><b>" . $leaseTransaction['Lease']['name'] . "</b></td></tr>" . 
		"<tr><th align=right>" . __('Month', true) . ":</th><td><b>" . $leaseTransaction['LeaseTransaction']['month'] . "</b></td></tr>" . 
		"<tr><th align=right>" . __('Payment', true) . ":</th><td><b>" . $leaseTransaction['LeaseTransaction']['payment'] . "</b></td></tr>" . 
		"<tr><th align=right>" . __('Disount Factor', true) . ":</th><td><b>" . $leaseTransaction['LeaseTransaction']['disount_factor'] . "</b></td></tr>" . 
		"<tr><th align=right>" . __('Npv', true) . ":</th><td><b>" . $leaseTransaction['LeaseTransaction']['npv'] . "</b></td></tr>" . 
		"<tr><th align=right>" . __('Lease Liability', true) . ":</th><td><b>" . $leaseTransaction['LeaseTransaction']['lease_liability'] . "</b></td></tr>" . 
		"<tr><th align=right>" . __('Interest Charge', true) . ":</th><td><b>" . $leaseTransaction['LeaseTransaction']['interest_charge'] . "</b></td></tr>" . 
		"<tr><th align=right>" . __('Asset Nbv Bfwd', true) . ":</th><td><b>" . $leaseTransaction['LeaseTransaction']['asset_nbv_bfwd'] . "</b></td></tr>" . 
		"<tr><th align=right>" . __('Amortization', true) . ":</th><td><b>" . $leaseTransaction['LeaseTransaction']['amortization'] . "</b></td></tr>" . 
		"<tr><th align=right>" . __('Asset Nbv Cfwd', true) . ":</th><td><b>" . $leaseTransaction['LeaseTransaction']['asset_nbv_cfwd'] . "</b></td></tr>" . 
"</table>"; 
?>
		var leaseTransaction_view_panel_1 = {
			html : '<?php echo $leaseTransaction_html; ?>',
			frame : true,
			height: 80
		}
		var leaseTransaction_view_panel_2 = new Ext.TabPanel({
			activeTab: 0,
			anchor: '100%',
			height:190,
			plain:true,
			defaults:{autoScroll: true},
			items:[
						]
		});

		var LeaseTransactionViewWindow = new Ext.Window({
			title: '<?php __('View LeaseTransaction'); ?>: <?php echo $leaseTransaction['LeaseTransaction']['id']; ?>',
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
				leaseTransaction_view_panel_1,
				leaseTransaction_view_panel_2
			],

			buttons: [{
				text: '<?php __('Close'); ?>',
				handler: function(btn){
					LeaseTransactionViewWindow.close();
				}
			}]
		});
