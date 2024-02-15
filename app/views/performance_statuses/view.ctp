
		
<?php $performanceStatus_html = "<table cellspacing=3>" . 		"<tr><th align=right>" . __('Budget Year', true) . ":</th><td><b>" . $performanceStatus['BudgetYear']['name'] . "</b></td></tr>" . 
		"<tr><th align=right>" . __('Quarter', true) . ":</th><td><b>" . $performanceStatus['PerformanceStatus']['quarter'] . "</b></td></tr>" . 
		"<tr><th align=right>" . __('Status', true) . ":</th><td><b>" . $performanceStatus['PerformanceStatus']['status'] . "</b></td></tr>" . 
"</table>"; 
?>
		var performanceStatus_view_panel_1 = {
			html : '<?php echo $performanceStatus_html; ?>',
			frame : true,
			height: 80
		}
		var performanceStatus_view_panel_2 = new Ext.TabPanel({
			activeTab: 0,
			anchor: '100%',
			height:190,
			plain:true,
			defaults:{autoScroll: true},
			items:[
						]
		});

		var PerformanceStatusViewWindow = new Ext.Window({
			title: '<?php __('View PerformanceStatus'); ?>: <?php echo $performanceStatus['PerformanceStatus']['id']; ?>',
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
				performanceStatus_view_panel_1,
				performanceStatus_view_panel_2
			],

			buttons: [{
				text: '<?php __('Close'); ?>',
				handler: function(btn){
					PerformanceStatusViewWindow.close();
				}
			}]
		});
