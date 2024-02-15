
		
<?php $branchPerformanceTracking_html = "<table cellspacing=3>" . 		"<tr><th align=right>" . __('Employee', true) . ":</th><td><b>" . $emps[$branchPerformanceTracking['Employee']['id']] . "</b></td></tr>" . 
		"<tr><th align=right>" . __('Goal', true) . ":</th><td><b>" . $all_settings[$branchPerformanceTracking['BranchPerformanceTracking']['goal']] . "</b></td></tr>" . 
		"<tr><th align=right>" . __('Date', true) . ":</th><td><b>" . $branchPerformanceTracking['BranchPerformanceTracking']['date'] . "</b></td></tr>" . 
		"<tr><th align=right>" . __('Value', true) . ":</th><td><b>" . $branchPerformanceTracking['BranchPerformanceTracking']['value'] . "</b></td></tr>" . 
"</table>"; 
?>
		var branchPerformanceTracking_view_panel_1 = {
			html : '<?php echo $branchPerformanceTracking_html; ?>',
			frame : true,
			height: 80
		}
		var branchPerformanceTracking_view_panel_2 = new Ext.TabPanel({
			activeTab: 0,
			anchor: '100%',
			height:190,
			plain:true,
			defaults:{autoScroll: true},
			items:[
						]
		});

		var BranchPerformanceTrackingViewWindow = new Ext.Window({
			title: '<?php __('View BranchPerformanceTracking'); ?>: <?php echo $branchPerformanceTracking['BranchPerformanceTracking']['id']; ?>',
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
				branchPerformanceTracking_view_panel_1,
				branchPerformanceTracking_view_panel_2
			],

			buttons: [{
				text: '<?php __('Close'); ?>',
				handler: function(btn){
					BranchPerformanceTrackingViewWindow.close();
				}
			}]
		});
