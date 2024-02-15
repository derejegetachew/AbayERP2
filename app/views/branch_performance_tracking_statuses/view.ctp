
		
<?php $branchPerformanceTrackingStatus_html = "<table cellspacing=3>" . 		"<tr><th align=right>" . __('Employee', true) . ":</th><td><b>" . $branchPerformanceTrackingStatus['Employee']['id'] . "</b></td></tr>" . 
		"<tr><th align=right>" . __('Budget Year', true) . ":</th><td><b>" . $branchPerformanceTrackingStatus['BudgetYear']['name'] . "</b></td></tr>" . 
		"<tr><th align=right>" . __('Quarter', true) . ":</th><td><b>" . $branchPerformanceTrackingStatus['BranchPerformanceTrackingStatus']['quarter'] . "</b></td></tr>" . 
		"<tr><th align=right>" . __('Result Status', true) . ":</th><td><b>" . $branchPerformanceTrackingStatus['BranchPerformanceTrackingStatus']['result_status'] . "</b></td></tr>" . 
"</table>"; 
?>
		var branchPerformanceTrackingStatus_view_panel_1 = {
			html : '<?php echo $branchPerformanceTrackingStatus_html; ?>',
			frame : true,
			height: 80
		}
		var branchPerformanceTrackingStatus_view_panel_2 = new Ext.TabPanel({
			activeTab: 0,
			anchor: '100%',
			height:190,
			plain:true,
			defaults:{autoScroll: true},
			items:[
						]
		});

		var BranchPerformanceTrackingStatusViewWindow = new Ext.Window({
			title: '<?php __('View BranchPerformanceTrackingStatus'); ?>: <?php echo $branchPerformanceTrackingStatus['BranchPerformanceTrackingStatus']['id']; ?>',
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
				branchPerformanceTrackingStatus_view_panel_1,
				branchPerformanceTrackingStatus_view_panel_2
			],

			buttons: [{
				text: '<?php __('Close'); ?>',
				handler: function(btn){
					BranchPerformanceTrackingStatusViewWindow.close();
				}
			}]
		});
