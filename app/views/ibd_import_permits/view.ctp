
		
<?php $ibdImportPermit_html = "<table cellspacing=3>" . 		"<tr><th align=right>" . __('PERMIT ISSUE DATE', true) . ":</th><td><b>" . $ibdImportPermit['IbdImportPermit']['PERMIT_ISSUE_DATE'] . "</b></td></tr>" . 
		"<tr><th align=right>" . __('NAME OF IMPORTER', true) . ":</th><td><b>" . $ibdImportPermit['IbdImportPermit']['NAME_OF_IMPORTER'] . "</b></td></tr>" . 
		"<tr><th align=right>" . __('IMPORT PERMIT NO', true) . ":</th><td><b>" . $ibdImportPermit['IbdImportPermit']['IMPORT_PERMIT_NO'] . "</b></td></tr>" . 
		"<tr><th align=right>" . __('Currency Id', true) . ":</th><td><b>" . $ibdImportPermit['IbdImportPermit']['currency_id'] . "</b></td></tr>" . 
		"<tr><th align=right>" . __('FCY AMOUNT', true) . ":</th><td><b>" . $ibdImportPermit['IbdImportPermit']['FCY_AMOUNT'] . "</b></td></tr>" . 
		"<tr><th align=right>" . __('PREVAILING RATE', true) . ":</th><td><b>" . $ibdImportPermit['IbdImportPermit']['PREVAILING_RATE'] . "</b></td></tr>" . 
		"<tr><th align=right>" . __('LCY AMOUNT', true) . ":</th><td><b>" . $ibdImportPermit['IbdImportPermit']['LCY_AMOUNT'] . "</b></td></tr>" . 
		"<tr><th align=right>" . __('Payment Term Id', true) . ":</th><td><b>" . $ibdImportPermit['IbdImportPermit']['payment_term_id'] . "</b></td></tr>" . 
		"<tr><th align=right>" . __('ITEM DESCRIPTION OF GOODS', true) . ":</th><td><b>" . $ibdImportPermit['IbdImportPermit']['ITEM_DESCRIPTION_OF_GOODS'] . "</b></td></tr>" . 
		"<tr><th align=right>" . __('SUPPLIERS NAME', true) . ":</th><td><b>" . $ibdImportPermit['IbdImportPermit']['SUPPLIERS_NAME'] . "</b></td></tr>" . 
		"<tr><th align=right>" . __('MINUTE NO', true) . ":</th><td><b>" . $ibdImportPermit['IbdImportPermit']['MINUTE_NO'] . "</b></td></tr>" . 
		"<tr><th align=right>" . __('FCY APPROVAL DATE', true) . ":</th><td><b>" . $ibdImportPermit['IbdImportPermit']['FCY_APPROVAL_DATE'] . "</b></td></tr>" . 
		"<tr><th align=right>" . __('FCY APPROVAL INTIAL ORDER NO', true) . ":</th><td><b>" . $ibdImportPermit['IbdImportPermit']['FCY_APPROVAL_INTIAL_ORDER_NO'] . "</b></td></tr>" . 
		"<tr><th align=right>" . __('FROM THEIR FCY ACCOUNT', true) . ":</th><td><b>" . $ibdImportPermit['IbdImportPermit']['FROM_THEIR_FCY_ACCOUNT'] . "</b></td></tr>" . 
		"<tr><th align=right>" . __('THE PRICE AS PER NBE SELLECTED', true) . ":</th><td><b>" . $ibdImportPermit['IbdImportPermit']['THE_PRICE_AS_PER_NBE_SELLECTED'] . "</b></td></tr>" . 
		"<tr><th align=right>" . __('NBE UNDERTAKING', true) . ":</th><td><b>" . $ibdImportPermit['IbdImportPermit']['NBE_UNDERTAKING'] . "</b></td></tr>" . 
		"<tr><th align=right>" . __('SUPPLIERS CREDIT', true) . ":</th><td><b>" . $ibdImportPermit['IbdImportPermit']['SUPPLIERS_CREDIT'] . "</b></td></tr>" . 
		"<tr><th align=right>" . __('REMARK', true) . ":</th><td><b>" . $ibdImportPermit['IbdImportPermit']['REMARK'] . "</b></td></tr>" . 
"</table>"; 
?>
		var ibdImportPermit_view_panel_1 = {
			html : '<?php echo $ibdImportPermit_html; ?>',
			frame : true,
			height: 80
		}
		var ibdImportPermit_view_panel_2 = new Ext.TabPanel({
			activeTab: 0,
			anchor: '100%',
			height:190,
			plain:true,
			defaults:{autoScroll: true},
			items:[
						]
		});

		var IbdImportPermitViewWindow = new Ext.Window({
			title: '<?php __('View IbdImportPermit'); ?>: <?php echo $ibdImportPermit['IbdImportPermit']['id']; ?>',
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
				ibdImportPermit_view_panel_1,
				ibdImportPermit_view_panel_2
			],

			buttons: [{
				text: '<?php __('Close'); ?>',
				handler: function(btn){
					IbdImportPermitViewWindow.close();
				}
			}]
		});
