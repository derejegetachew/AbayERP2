
		
<?php $ibdTt_html = "<table cellspacing=3>" . 		"<tr><th align=right>" . __('DATE OF ISSUE', true) . ":</th><td><b>" . $ibdTt['IbdTt']['DATE_OF_ISSUE'] . "</b></td></tr>" . 
		"<tr><th align=right>" . __('NAME OF APPLICANT', true) . ":</th><td><b>" . $ibdTt['IbdTt']['NAME_OF_APPLICANT'] . "</b></td></tr>" . 
		"<tr><th align=right>" . __('Currency Id', true) . ":</th><td><b>" . $ibdTt['IbdTt']['currency_id'] . "</b></td></tr>" . 
		"<tr><th align=right>" . __('FCY AMOUNT', true) . ":</th><td><b>" . $ibdTt['IbdTt']['FCY_AMOUNT'] . "</b></td></tr>" . 
		"<tr><th align=right>" . __('TT REFERENCE', true) . ":</th><td><b>" . $ibdTt['IbdTt']['TT_REFERENCE'] . "</b></td></tr>" . 
		"<tr><th align=right>" . __('PERMIT NO', true) . ":</th><td><b>" . $ibdTt['IbdTt']['PERMIT_NO'] . "</b></td></tr>" . 
		"<tr><th align=right>" . __('FCY APPROVAL DATE', true) . ":</th><td><b>" . $ibdTt['IbdTt']['FCY_APPROVAL_DATE'] . "</b></td></tr>" . 
		"<tr><th align=right>" . __('FCY APPROVAL INTIAL ORDER NO', true) . ":</th><td><b>" . $ibdTt['IbdTt']['FCY_APPROVAL_INTIAL_ORDER_NO'] . "</b></td></tr>" . 
		"<tr><th align=right>" . __('FROM THEIR FCY ACCOUNT', true) . ":</th><td><b>" . $ibdTt['IbdTt']['FROM_THEIR_FCY_ACCOUNT'] . "</b></td></tr>" . 
		"<tr><th align=right>" . __('REMARK', true) . ":</th><td><b>" . $ibdTt['IbdTt']['REMARK'] . "</b></td></tr>" . 
"</table>"; 
?>
		var ibdTt_view_panel_1 = {
			html : '<?php echo $ibdTt_html; ?>',
			frame : true,
			height: 80
		}
		var ibdTt_view_panel_2 = new Ext.TabPanel({
			activeTab: 0,
			anchor: '100%',
			height:190,
			plain:true,
			defaults:{autoScroll: true},
			items:[
						]
		});

		var IbdTtViewWindow = new Ext.Window({
			title: '<?php __('View IbdTt'); ?>: <?php echo $ibdTt['IbdTt']['id']; ?>',
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
				ibdTt_view_panel_1,
				ibdTt_view_panel_2
			],

			buttons: [{
				text: '<?php __('Close'); ?>',
				handler: function(btn){
					IbdTtViewWindow.close();
				}
			}]
		});
