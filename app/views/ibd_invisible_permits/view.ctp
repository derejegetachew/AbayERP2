
		
<?php $ibdInvisiblePermit_html = "<table cellspacing=3>" . 		"<tr><th align=right>" . __('DATE OF ISSUE', true) . ":</th><td><b>" . $ibdInvisiblePermit['IbdInvisiblePermit']['DATE_OF_ISSUE'] . "</b></td></tr>" . 
		"<tr><th align=right>" . __('NAME OF APPLICANT', true) . ":</th><td><b>" . $ibdInvisiblePermit['IbdInvisiblePermit']['NAME_OF_APPLICANT'] . "</b></td></tr>" . 
		"<tr><th align=right>" . __('PERMIT NO', true) . ":</th><td><b>" . $ibdInvisiblePermit['IbdInvisiblePermit']['PERMIT_NO'] . "</b></td></tr>" . 
		"<tr><th align=right>" . __('PURPOSE OF PAYMENT', true) . ":</th><td><b>" . $ibdInvisiblePermit['IbdInvisiblePermit']['PURPOSE_OF_PAYMENT'] . "</b></td></tr>" . 
		"<tr><th align=right>" . __('Currency Type', true) . ":</th><td><b>" . $ibdInvisiblePermit['CurrencyType']['id'] . "</b></td></tr>" . 
		"<tr><th align=right>" . __('FCY AMOUNT', true) . ":</th><td><b>" . $ibdInvisiblePermit['IbdInvisiblePermit']['FCY_AMOUNT'] . "</b></td></tr>" . 
		"<tr><th align=right>" . __('TT REFERENCE', true) . ":</th><td><b>" . $ibdInvisiblePermit['IbdInvisiblePermit']['TT_REFERENCE'] . "</b></td></tr>" . 
		"<tr><th align=right>" . __('RETENTION A OR B', true) . ":</th><td><b>" . $ibdInvisiblePermit['IbdInvisiblePermit']['RETENTION_A_OR_B'] . "</b></td></tr>" . 
		"<tr><th align=right>" . __('DIASPORA NRNT', true) . ":</th><td><b>" . $ibdInvisiblePermit['IbdInvisiblePermit']['DIASPORA_NRNT'] . "</b></td></tr>" . 
		"<tr><th align=right>" . __('FROM THEIR LCY ACCOUNT', true) . ":</th><td><b>" . $ibdInvisiblePermit['IbdInvisiblePermit']['FROM_THEIR_LCY_ACCOUNT'] . "</b></td></tr>" . 
		"<tr><th align=right>" . __('REMARK', true) . ":</th><td><b>" . $ibdInvisiblePermit['IbdInvisiblePermit']['REMARK'] . "</b></td></tr>" . 
"</table>"; 
?>
		var ibdInvisiblePermit_view_panel_1 = {
			html : '<?php echo $ibdInvisiblePermit_html; ?>',
			frame : true,
			height: 80
		}
		var ibdInvisiblePermit_view_panel_2 = new Ext.TabPanel({
			activeTab: 0,
			anchor: '100%',
			height:190,
			plain:true,
			defaults:{autoScroll: true},
			items:[
						]
		});

		var IbdInvisiblePermitViewWindow = new Ext.Window({
			title: '<?php __('View IbdInvisiblePermit'); ?>: <?php echo $ibdInvisiblePermit['IbdInvisiblePermit']['id']; ?>',
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
				ibdInvisiblePermit_view_panel_1,
				ibdInvisiblePermit_view_panel_2
			],

			buttons: [{
				text: '<?php __('Close'); ?>',
				handler: function(btn){
					IbdInvisiblePermitViewWindow.close();
				}
			}]
		});
