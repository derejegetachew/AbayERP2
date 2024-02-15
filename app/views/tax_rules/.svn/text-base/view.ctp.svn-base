
		
<?php $taxRule_html = "<table cellspacing=3>" . 		"<tr><th align=right>" . __('Name', true) . ":</th><td><b>" . $taxRule['TaxRule']['name'] . "</b></td></tr>" . 
		"<tr><th align=right>" . __('Min', true) . ":</th><td><b>" . $taxRule['TaxRule']['min'] . "</b></td></tr>" . 
		"<tr><th align=right>" . __('Max', true) . ":</th><td><b>" . $taxRule['TaxRule']['max'] . "</b></td></tr>" . 
		"<tr><th align=right>" . __('Percent', true) . ":</th><td><b>" . $taxRule['TaxRule']['percent'] . "</b></td></tr>" . 
		"<tr><th align=right>" . __('Payroll', true) . ":</th><td><b>" . $taxRule['Payroll']['name'] . "</b></td></tr>" . 
"</table>"; 
?>
		var taxRule_view_panel_1 = {
			html : '<?php echo $taxRule_html; ?>',
			frame : true,
			height: 80
		}
		var taxRule_view_panel_2 = new Ext.TabPanel({
			activeTab: 0,
			anchor: '100%',
			height:190,
			plain:true,
			defaults:{autoScroll: true},
			items:[
						]
		});

		var TaxRuleViewWindow = new Ext.Window({
			title: '<?php __('View TaxRule'); ?>: <?php echo $taxRule['TaxRule']['name']; ?>',
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
				taxRule_view_panel_1,
				taxRule_view_panel_2
			],

			buttons: [{
				text: '<?php __('Close'); ?>',
				handler: function(btn){
					TaxRuleViewWindow.close();
				}
			}]
		});
