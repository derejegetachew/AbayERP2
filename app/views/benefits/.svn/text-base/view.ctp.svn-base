
		
<?php $benefit_html = "<table cellspacing=3>" . 		"<tr><th align=right>" . __('Name', true) . ":</th><td><b>" . $benefit['Benefit']['name'] . "</b></td></tr>" . 
		"<tr><th align=right>" . __('Measurement', true) . ":</th><td><b>" . $benefit['Benefit']['Measurement'] . "</b></td></tr>" . 
		"<tr><th align=right>" . __('Amount', true) . ":</th><td><b>" . $benefit['Benefit']['amount'] . "</b></td></tr>" . 
		"<tr><th align=right>" . __('Grade', true) . ":</th><td><b>" . $benefit['Grade']['name'] . "</b></td></tr>" . 
		"<tr><th align=right>" . __('Start Date', true) . ":</th><td><b>" . $benefit['Benefit']['start_date'] . "</b></td></tr>" . 
		"<tr><th align=right>" . __('End Date', true) . ":</th><td><b>" . $benefit['Benefit']['end_date'] . "</b></td></tr>" . 
"</table>"; 
?>
		var benefit_view_panel_1 = {
			html : '<?php echo $benefit_html; ?>',
			frame : true,
			height: 80
		}
		var benefit_view_panel_2 = new Ext.TabPanel({
			activeTab: 0,
			anchor: '100%',
			height:190,
			plain:true,
			defaults:{autoScroll: true},
			items:[
						]
		});

		var BenefitViewWindow = new Ext.Window({
			title: '<?php __('View Benefit'); ?>: <?php echo $benefit['Benefit']['name']; ?>',
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
				benefit_view_panel_1,
				benefit_view_panel_2
			],

			buttons: [{
				text: '<?php __('Close'); ?>',
				handler: function(btn){
					BenefitViewWindow.close();
				}
			}]
		});
