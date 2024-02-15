
		
<?php $ibdOdbc_html = "<table cellspacing=3>" . 		"<tr><th align=right>" . __('Exporter Name', true) . ":</th><td><b>" . $ibdOdbc['IbdOdbc']['Exporter_Name'] . "</b></td></tr>" . 
		"<tr><th align=right>" . __('Payment Term', true) . ":</th><td><b>" . $ibdOdbc['PaymentTerm']['id'] . "</b></td></tr>" . 
		"<tr><th align=right>" . __('Doc Ref', true) . ":</th><td><b>" . $ibdOdbc['IbdOdbc']['Doc_Ref'] . "</b></td></tr>" . 
		"<tr><th align=right>" . __('Permit No', true) . ":</th><td><b>" . $ibdOdbc['IbdOdbc']['Permit_No'] . "</b></td></tr>" . 
		"<tr><th align=right>" . __('NBE Permit No', true) . ":</th><td><b>" . $ibdOdbc['IbdOdbc']['NBE_Permit_no'] . "</b></td></tr>" . 
		"<tr><th align=right>" . __('Branch Name', true) . ":</th><td><b>" . $ibdOdbc['IbdOdbc']['Branch_Name'] . "</b></td></tr>" . 
		"<tr><th align=right>" . __('ODBC DD', true) . ":</th><td><b>" . $ibdOdbc['IbdOdbc']['ODBC_DD'] . "</b></td></tr>" . 
		"<tr><th align=right>" . __('Destination', true) . ":</th><td><b>" . $ibdOdbc['IbdOdbc']['Destination'] . "</b></td></tr>" . 
		"<tr><th align=right>" . __('Single Ent', true) . ":</th><td><b>" . $ibdOdbc['IbdOdbc']['Single_Ent'] . "</b></td></tr>" . 
		"<tr><th align=right>" . __('Currency Type', true) . ":</th><td><b>" . $ibdOdbc['CurrencyType']['id'] . "</b></td></tr>" . 
		"<tr><th align=right>" . __('Doc Permitt Amount', true) . ":</th><td><b>" . $ibdOdbc['IbdOdbc']['doc_permitt_amount'] . "</b></td></tr>" . 
		"<tr><th align=right>" . __('Value Date', true) . ":</th><td><b>" . $ibdOdbc['IbdOdbc']['value_date'] . "</b></td></tr>" . 
		"<tr><th align=right>" . __('Proceed Amount', true) . ":</th><td><b>" . $ibdOdbc['IbdOdbc']['proceed_amount'] . "</b></td></tr>" . 
		"<tr><th align=right>" . __('Rate', true) . ":</th><td><b>" . $ibdOdbc['IbdOdbc']['rate'] . "</b></td></tr>" . 
		"<tr><th align=right>" . __('Lcy', true) . ":</th><td><b>" . $ibdOdbc['IbdOdbc']['lcy'] . "</b></td></tr>" . 
		"<tr><th align=right>" . __('Deduction', true) . ":</th><td><b>" . $ibdOdbc['IbdOdbc']['Deduction'] . "</b></td></tr>" . 
"</table>"; 
?>
		var ibdOdbc_view_panel_1 = {
			html : '<?php echo $ibdOdbc_html; ?>',
			frame : true,
			height: 80
		}
		var ibdOdbc_view_panel_2 = new Ext.TabPanel({
			activeTab: 0,
			anchor: '100%',
			height:190,
			plain:true,
			defaults:{autoScroll: true},
			items:[
						]
		});

		var IbdOdbcViewWindow = new Ext.Window({
			title: '<?php __('View IbdOdbc'); ?>: <?php echo $ibdOdbc['IbdOdbc']['id']; ?>',
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
				ibdOdbc_view_panel_1,
				ibdOdbc_view_panel_2
			],

			buttons: [{
				text: '<?php __('Close'); ?>',
				handler: function(btn){
					IbdOdbcViewWindow.close();
				}
			}]
		});
