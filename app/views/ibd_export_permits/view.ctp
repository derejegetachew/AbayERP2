
		
<?php $ibdExportPermit_html = "<table cellspacing=3>" . 		"<tr><th align=right>" . __('PERMIT ISSUE DATE', true) . ":</th><td><b>" . $ibdExportPermit['IbdExportPermit']['PERMIT_ISSUE_DATE'] . "</b></td></tr>" . 
		"<tr><th align=right>" . __('EXPORTER NAME', true) . ":</th><td><b>" . $ibdExportPermit['IbdExportPermit']['EXPORTER_NAME'] . "</b></td></tr>" . 
		"<tr><th align=right>" . __('EXPORT PERMIT NO', true) . ":</th><td><b>" . $ibdExportPermit['IbdExportPermit']['EXPORT_PERMIT_NO'] . "</b></td></tr>" . 
		"<tr><th align=right>" . __('COMMODITY', true) . ":</th><td><b>" . $ibdExportPermit['IbdExportPermit']['COMMODITY'] . "</b></td></tr>" . 
		"<tr><th align=right>" . __('BUYER NAME', true) . ":</th><td><b>" . $ibdExportPermit['IbdExportPermit']['BUYER_NAME'] . "</b></td></tr>" . 
		"<tr><th align=right>" . __('Payment Term Id', true) . ":</th><td><b>" . $ibdExportPermit['IbdExportPermit']['payment_term_id'] . "</b></td></tr>" . 
		"<tr><th align=right>" . __('Currency Id', true) . ":</th><td><b>" . $ibdExportPermit['IbdExportPermit']['currency_id'] . "</b></td></tr>" . 
		"<tr><th align=right>" . __('FCY AMOUNT', true) . ":</th><td><b>" . $ibdExportPermit['IbdExportPermit']['FCY_AMOUNT'] . "</b></td></tr>" . 
		"<tr><th align=right>" . __('BUYING RATE', true) . ":</th><td><b>" . $ibdExportPermit['IbdExportPermit']['BUYING_RATE'] . "</b></td></tr>" . 
		"<tr><th align=right>" . __('LCY AMOUNT', true) . ":</th><td><b>" . $ibdExportPermit['IbdExportPermit']['LCY_AMOUNT'] . "</b></td></tr>" . 
		"<tr><th align=right>" . __('REMARK', true) . ":</th><td><b>" . $ibdExportPermit['IbdExportPermit']['REMARK'] . "</b></td></tr>" . 
"</table>"; 
?>
		var ibdExportPermit_view_panel_1 = {
			html : '<?php echo $ibdExportPermit_html; ?>',
			frame : true,
			height: 80
		}
		var ibdExportPermit_view_panel_2 = new Ext.TabPanel({
			activeTab: 0,
			anchor: '100%',
			height:190,
			plain:true,
			defaults:{autoScroll: true},
			items:[
						]
		});

		var IbdExportPermitViewWindow = new Ext.Window({
			title: '<?php __('View IbdExportPermit'); ?>: <?php echo $ibdExportPermit['IbdExportPermit']['id']; ?>',
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
				ibdExportPermit_view_panel_1,
				ibdExportPermit_view_panel_2
			],

			buttons: [{
				text: '<?php __('Close'); ?>',
				handler: function(btn){
					IbdExportPermitViewWindow.close();
				}
			}]
		});
