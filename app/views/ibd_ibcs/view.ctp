
		
<?php $ibdIbc_html = "<table cellspacing=3>" . 		"<tr><th align=right>" . __('ISSUE DATE', true) . ":</th><td><b>" . $ibdIbc['IbdIbc']['ISSUE_DATE'] . "</b></td></tr>" . 
		"<tr><th align=right>" . __('NAME OF IMPORTER', true) . ":</th><td><b>" . $ibdIbc['IbdIbc']['NAME_OF_IMPORTER'] . "</b></td></tr>" . 
		"<tr><th align=right>" . __('IBC REFERENCE', true) . ":</th><td><b>" . $ibdIbc['IbdIbc']['IBC_REFERENCE'] . "</b></td></tr>" . 
		"<tr><th align=right>" . __('Currency Id', true) . ":</th><td><b>" . $ibdIbc['IbdIbc']['currency_id'] . "</b></td></tr>" . 
		"<tr><th align=right>" . __('FCY AMOUNT', true) . ":</th><td><b>" . $ibdIbc['IbdIbc']['FCY_AMOUNT'] . "</b></td></tr>" . 
		"<tr><th align=right>" . __('REMITTING BANK', true) . ":</th><td><b>" . $ibdIbc['IbdIbc']['REMITTING_BANK'] . "</b></td></tr>" . 
		"<tr><th align=right>" . __('REIBURSING BANK', true) . ":</th><td><b>" . $ibdIbc['IbdIbc']['REIBURSING_BANK'] . "</b></td></tr>" . 
		"<tr><th align=right>" . __('PURCHASE ORDER NO', true) . ":</th><td><b>" . $ibdIbc['IbdIbc']['PURCHASE_ORDER_NO'] . "</b></td></tr>" . 
		"<tr><th align=right>" . __('FCY APPROVAL INITIAL NO', true) . ":</th><td><b>" . $ibdIbc['IbdIbc']['FCY_APPROVAL_INITIAL_NO'] . "</b></td></tr>" . 
		"<tr><th align=right>" . __('SETT FCY', true) . ":</th><td><b>" . $ibdIbc['IbdIbc']['SETT_FCY'] . "</b></td></tr>" . 
		"<tr><th align=right>" . __('SETT Amount', true) . ":</th><td><b>" . $ibdIbc['IbdIbc']['SETT_Amount'] . "</b></td></tr>" . 
		"<tr><th align=right>" . __('SETT Date', true) . ":</th><td><b>" . $ibdIbc['IbdIbc']['SETT_Date'] . "</b></td></tr>" . 
"</table>"; 
?>
		var ibdIbc_view_panel_1 = {
			html : '<?php echo $ibdIbc_html; ?>',
			frame : true,
			height: 80
		}
		var ibdIbc_view_panel_2 = new Ext.TabPanel({
			activeTab: 0,
			anchor: '100%',
			height:190,
			plain:true,
			defaults:{autoScroll: true},
			items:[
						]
		});

		var IbdIbcViewWindow = new Ext.Window({
			title: '<?php __('View IbdIbc'); ?>: <?php echo $ibdIbc['IbdIbc']['id']; ?>',
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
				ibdIbc_view_panel_1,
				ibdIbc_view_panel_2
			],

			buttons: [{
				text: '<?php __('Close'); ?>',
				handler: function(btn){
					IbdIbcViewWindow.close();
				}
			}]
		});
