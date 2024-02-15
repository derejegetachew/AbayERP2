
		
<?php $ibdLc_html = "<table cellspacing=3>" . 		"<tr><th align=right>" . __('LC ISSUE DATE', true) . ":</th><td><b>" . $ibdLc['IbdLc']['LC_ISSUE_DATE'] . "</b></td></tr>" . 
		"<tr><th align=right>" . __('NAME OF IMPORTER', true) . ":</th><td><b>" . $ibdLc['IbdLc']['NAME_OF_IMPORTER'] . "</b></td></tr>" . 
		"<tr><th align=right>" . __('LC REF NO', true) . ":</th><td><b>" . $ibdLc['IbdLc']['LC_REF_NO'] . "</b></td></tr>" . 
		"<tr><th align=right>" . __('PERMIT NO', true) . ":</th><td><b>" . $ibdLc['IbdLc']['PERMIT_NO'] . "</b></td></tr>" . 
		"<tr><th align=right>" . __('Currency Type', true) . ":</th><td><b>" . $ibdLc['CurrencyType']['id'] . "</b></td></tr>" . 
		"<tr><th align=right>" . __('FCY AMOUNT', true) . ":</th><td><b>" . $ibdLc['IbdLc']['FCY_AMOUNT'] . "</b></td></tr>" . 
		"<tr><th align=right>" . __('OPENING RATE', true) . ":</th><td><b>" . $ibdLc['IbdLc']['OPENING_RATE'] . "</b></td></tr>" . 
		"<tr><th align=right>" . __('LCY AMOUNT', true) . ":</th><td><b>" . $ibdLc['IbdLc']['LCY_AMOUNT'] . "</b></td></tr>" . 
		"<tr><th align=right>" . __('MARGIN AMT', true) . ":</th><td><b>" . $ibdLc['IbdLc']['MARGIN_AMT'] . "</b></td></tr>" . 
		"<tr><th align=right>" . __('OPEN THROUGH', true) . ":</th><td><b>" . $ibdLc['IbdLc']['OPEN_THROUGH'] . "</b></td></tr>" . 
		"<tr><th align=right>" . __('REIBURSING BANK', true) . ":</th><td><b>" . $ibdLc['IbdLc']['REIBURSING_BANK'] . "</b></td></tr>" . 
		"<tr><th align=right>" . __('MARGIN AMOUNT', true) . ":</th><td><b>" . $ibdLc['IbdLc']['MARGIN_AMOUNT'] . "</b></td></tr>" . 
		"<tr><th align=right>" . __('EXPIRY DATE', true) . ":</th><td><b>" . $ibdLc['IbdLc']['EXPIRY_DATE'] . "</b></td></tr>" . 
		"<tr><th align=right>" . __('SETT DATE', true) . ":</th><td><b>" . $ibdLc['IbdLc']['SETT_DATE'] . "</b></td></tr>" . 
		"<tr><th align=right>" . __('SETT FCY AMOUNT', true) . ":</th><td><b>" . $ibdLc['IbdLc']['SETT_FCY_AMOUNT'] . "</b></td></tr>" . 
		"<tr><th align=right>" . __('SETT Rate', true) . ":</th><td><b>" . $ibdLc['IbdLc']['SETT_Rate'] . "</b></td></tr>" . 
		"<tr><th align=right>" . __('SETT LCY Amt', true) . ":</th><td><b>" . $ibdLc['IbdLc']['SETT_LCY_Amt'] . "</b></td></tr>" . 
		"<tr><th align=right>" . __('SETT Margin Amt', true) . ":</th><td><b>" . $ibdLc['IbdLc']['SETT_Margin_Amt'] . "</b></td></tr>" . 
		"<tr><th align=right>" . __('OUT FCY AMOUNT', true) . ":</th><td><b>" . $ibdLc['IbdLc']['OUT_FCY_AMOUNT'] . "</b></td></tr>" . 
		"<tr><th align=right>" . __('OUT BIRR VALUE', true) . ":</th><td><b>" . $ibdLc['IbdLc']['OUT_BIRR_VALUE'] . "</b></td></tr>" . 
		"<tr><th align=right>" . __('OUT Margin Amt', true) . ":</th><td><b>" . $ibdLc['IbdLc']['OUT_Margin_Amt'] . "</b></td></tr>" . 
"</table>"; 
?>
		var ibdLc_view_panel_1 = {
			html : '<?php echo $ibdLc_html; ?>',
			frame : true,
			height: 80
		}
		var ibdLc_view_panel_2 = new Ext.TabPanel({
			activeTab: 0,
			anchor: '100%',
			height:190,
			plain:true,
			defaults:{autoScroll: true},
			items:[
						]
		});

		var IbdLcViewWindow = new Ext.Window({
			title: '<?php __('View IbdLc'); ?>: <?php echo $ibdLc['IbdLc']['id']; ?>',
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
				ibdLc_view_panel_1,
				ibdLc_view_panel_2
			],

			buttons: [{
				text: '<?php __('Close'); ?>',
				handler: function(btn){
					IbdLcViewWindow.close();
				}
			}]
		});
