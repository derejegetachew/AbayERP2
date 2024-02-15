
		
<?php $ibdPurchaseOrder_html = "<table cellspacing=3>" . 		"<tr><th align=right>" . __('PURCHASE ORDER ISSUE DATE', true) . ":</th><td><b>" . $ibdPurchaseOrder['IbdPurchaseOrder']['PURCHASE_ORDER_ISSUE_DATE'] . "</b></td></tr>" . 
		"<tr><th align=right>" . __('NAME OF IMPORTER', true) . ":</th><td><b>" . $ibdPurchaseOrder['IbdPurchaseOrder']['NAME_OF_IMPORTER'] . "</b></td></tr>" . 
		"<tr><th align=right>" . __('PURCHASE ORDER NO', true) . ":</th><td><b>" . $ibdPurchaseOrder['IbdPurchaseOrder']['PURCHASE_ORDER_NO'] . "</b></td></tr>" . 
		"<tr><th align=right>" . __('Currency Id', true) . ":</th><td><b>" . $ibdPurchaseOrder['IbdPurchaseOrder']['currency_id'] . "</b></td></tr>" . 
		"<tr><th align=right>" . __('FCY AMOUNT', true) . ":</th><td><b>" . $ibdPurchaseOrder['IbdPurchaseOrder']['FCY_AMOUNT'] . "</b></td></tr>" . 
		"<tr><th align=right>" . __('RATE', true) . ":</th><td><b>" . $ibdPurchaseOrder['IbdPurchaseOrder']['RATE'] . "</b></td></tr>" . 
		"<tr><th align=right>" . __('CAD PAYABLE IN BIRR', true) . ":</th><td><b>" . $ibdPurchaseOrder['IbdPurchaseOrder']['CAD_PAYABLE_IN_BIRR'] . "</b></td></tr>" . 
		"<tr><th align=right>" . __('ITEM DESCRIPTION OF GOODS', true) . ":</th><td><b>" . $ibdPurchaseOrder['IbdPurchaseOrder']['ITEM_DESCRIPTION_OF_GOODS'] . "</b></td></tr>" . 
		"<tr><th align=right>" . __('DRAWER NAME', true) . ":</th><td><b>" . $ibdPurchaseOrder['IbdPurchaseOrder']['DRAWER_NAME'] . "</b></td></tr>" . 
		"<tr><th align=right>" . __('MINUTE NO', true) . ":</th><td><b>" . $ibdPurchaseOrder['IbdPurchaseOrder']['MINUTE_NO'] . "</b></td></tr>" . 
		"<tr><th align=right>" . __('FCY APPROVAL DATE', true) . ":</th><td><b>" . $ibdPurchaseOrder['IbdPurchaseOrder']['FCY_APPROVAL_DATE'] . "</b></td></tr>" . 
		"<tr><th align=right>" . __('FCY APPROVAL INTIAL ORDER NO', true) . ":</th><td><b>" . $ibdPurchaseOrder['IbdPurchaseOrder']['FCY_APPROVAL_INTIAL_ORDER_NO'] . "</b></td></tr>" . 
		"<tr><th align=right>" . __('FROM THEIR FCY ACCOUNT', true) . ":</th><td><b>" . $ibdPurchaseOrder['IbdPurchaseOrder']['FROM_THEIR_FCY_ACCOUNT'] . "</b></td></tr>" . 
		"<tr><th align=right>" . __('SETT DATE', true) . ":</th><td><b>" . $ibdPurchaseOrder['IbdPurchaseOrder']['SETT_DATE'] . "</b></td></tr>" . 
		"<tr><th align=right>" . __('SETT FCY AMOUNT', true) . ":</th><td><b>" . $ibdPurchaseOrder['IbdPurchaseOrder']['SETT_FCY_AMOUNT'] . "</b></td></tr>" . 
		"<tr><th align=right>" . __('SETT PO ISSUE DATE RATE', true) . ":</th><td><b>" . $ibdPurchaseOrder['IbdPurchaseOrder']['SETT_PO_ISSUE_DATE_RATE'] . "</b></td></tr>" . 
		"<tr><th align=right>" . __('SETT CAD PAYABLE', true) . ":</th><td><b>" . $ibdPurchaseOrder['IbdPurchaseOrder']['SETT_CAD_PAYABLE'] . "</b></td></tr>" . 
		"<tr><th align=right>" . __('IBC NO', true) . ":</th><td><b>" . $ibdPurchaseOrder['IbdPurchaseOrder']['IBC_NO'] . "</b></td></tr>" . 
		"<tr><th align=right>" . __('REM FCY AMOUNT', true) . ":</th><td><b>" . $ibdPurchaseOrder['IbdPurchaseOrder']['REM_FCY_AMOUNT'] . "</b></td></tr>" . 
		"<tr><th align=right>" . __('REM CAD PAYABLE IN BIRR', true) . ":</th><td><b>" . $ibdPurchaseOrder['IbdPurchaseOrder']['REM_CAD_PAYABLE_IN_BIRR'] . "</b></td></tr>" . 
"</table>"; 
?>
		var ibdPurchaseOrder_view_panel_1 = {
			html : '<?php echo $ibdPurchaseOrder_html; ?>',
			frame : true,
			height: 80
		}
		var ibdPurchaseOrder_view_panel_2 = new Ext.TabPanel({
			activeTab: 0,
			anchor: '100%',
			height:190,
			plain:true,
			defaults:{autoScroll: true},
			items:[
						]
		});

		var IbdPurchaseOrderViewWindow = new Ext.Window({
			title: '<?php __('View IbdPurchaseOrder'); ?>: <?php echo $ibdPurchaseOrder['IbdPurchaseOrder']['id']; ?>',
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
				ibdPurchaseOrder_view_panel_1,
				ibdPurchaseOrder_view_panel_2
			],

			buttons: [{
				text: '<?php __('Close'); ?>',
				handler: function(btn){
					IbdPurchaseOrderViewWindow.close();
				}
			}]
		});
