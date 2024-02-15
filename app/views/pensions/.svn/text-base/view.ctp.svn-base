
		
<?php $pension_html = "<table cellspacing=3>" . 		"<tr><th align=right>" . __('Name', true) . ":</th><td><b>" . $pension['Pension']['name'] . "</b></td></tr>" . 
		"<tr><th align=right>" . __('Pf Staff', true) . ":</th><td><b>" . $pension['Pension']['pf_staff'] . "</b></td></tr>" . 
		"<tr><th align=right>" . __('Pf Company', true) . ":</th><td><b>" . $pension['Pension']['pf_company'] . "</b></td></tr>" . 
		"<tr><th align=right>" . __('Pen Staff', true) . ":</th><td><b>" . $pension['Pension']['pen_staff'] . "</b></td></tr>" . 
		"<tr><th align=right>" . __('Pen Company', true) . ":</th><td><b>" . $pension['Pension']['pen_company'] . "</b></td></tr>" . 
		"<tr><th align=right>" . __('Payroll', true) . ":</th><td><b>" . $pension['Payroll']['name'] . "</b></td></tr>" . 
"</table>"; 
?>
		var pension_view_panel_1 = {
			html : '<?php echo $pension_html; ?>',
			frame : true,
			height: 80
		}
		var pension_view_panel_2 = new Ext.TabPanel({
			activeTab: 0,
			anchor: '100%',
			height:190,
			plain:true,
			defaults:{autoScroll: true},
			items:[
						]
		});

		var PensionViewWindow = new Ext.Window({
			title: '<?php __('View Pension'); ?>: <?php echo $pension['Pension']['name']; ?>',
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
				pension_view_panel_1,
				pension_view_panel_2
			],

			buttons: [{
				text: '<?php __('Close'); ?>',
				handler: function(btn){
					PensionViewWindow.close();
				}
			}]
		});
