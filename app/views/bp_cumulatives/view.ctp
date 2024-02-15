
		
<?php $bpCumulative_html = "<table cellspacing=3>" . 		"<tr><th align=right>" . __('Bp Item', true) . ":</th><td><b>" . $bpCumulative['BpItem']['name'] . "</b></td></tr>" . 
		"<tr><th align=right>" . __('Bp Month', true) . ":</th><td><b>" . $bpCumulative['BpMonth']['name'] . "</b></td></tr>" . 
		"<tr><th align=right>" . __('Budget Year', true) . ":</th><td><b>" . $bpCumulative['BudgetYear']['name'] . "</b></td></tr>" . 
		"<tr><th align=right>" . __('Plan', true) . ":</th><td><b>" . $bpCumulative['BpCumulative']['plan'] . "</b></td></tr>" . 
		"<tr><th align=right>" . __('Actual', true) . ":</th><td><b>" . $bpCumulative['BpCumulative']['actual'] . "</b></td></tr>" . 
		"<tr><th align=right>" . __('CumilativePlan', true) . ":</th><td><b>" . $bpCumulative['BpCumulative']['cumilativePlan'] . "</b></td></tr>" . 
		"<tr><th align=right>" . __('CumilativeActual', true) . ":</th><td><b>" . $bpCumulative['BpCumulative']['cumilativeActual'] . "</b></td></tr>" . 
"</table>"; 
?>
		var bpCumulative_view_panel_1 = {
			html : '<?php echo $bpCumulative_html; ?>',
			frame : true,
			height: 80
		}
		var bpCumulative_view_panel_2 = new Ext.TabPanel({
			activeTab: 0,
			anchor: '100%',
			height:190,
			plain:true,
			defaults:{autoScroll: true},
			items:[
						]
		});

		var BpCumulativeViewWindow = new Ext.Window({
			title: '<?php __('View BpCumulative'); ?>: <?php echo $bpCumulative['BpCumulative']['id']; ?>',
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
				bpCumulative_view_panel_1,
				bpCumulative_view_panel_2
			],

			buttons: [{
				text: '<?php __('Close'); ?>',
				handler: function(btn){
					BpCumulativeViewWindow.close();
				}
			}]
		});
