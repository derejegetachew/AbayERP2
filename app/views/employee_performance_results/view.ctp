
		
<?php $employeePerformanceResult_html = "<table cellspacing=3>" . 		"<tr><th align=right>" . __('Employee', true) . ":</th><td><b>" . $employeePerformanceResult['Employee']['id'] . "</b></td></tr>" . 
		"<tr><th align=right>" . __('Employee Performance', true) . ":</th><td><b>" . $employeePerformanceResult['EmployeePerformance']['id'] . "</b></td></tr>" . 
		"<tr><th align=right>" . __('Performance List', true) . ":</th><td><b>" . $employeePerformanceResult['PerformanceList']['name'] . "</b></td></tr>" . 
		"<tr><th align=right>" . __('Performance List Choice', true) . ":</th><td><b>" . $employeePerformanceResult['PerformanceListChoice']['name'] . "</b></td></tr>" . 
"</table>"; 
?>
		var employeePerformanceResult_view_panel_1 = {
			html : '<?php echo $employeePerformanceResult_html; ?>',
			frame : true,
			height: 80
		}
		var employeePerformanceResult_view_panel_2 = new Ext.TabPanel({
			activeTab: 0,
			anchor: '100%',
			height:190,
			plain:true,
			defaults:{autoScroll: true},
			items:[
						]
		});

		var EmployeePerformanceResultViewWindow = new Ext.Window({
			title: '<?php __('View EmployeePerformanceResult'); ?>: <?php echo $employeePerformanceResult['EmployeePerformanceResult']['id']; ?>',
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
				employeePerformanceResult_view_panel_1,
				employeePerformanceResult_view_panel_2
			],

			buttons: [{
				text: '<?php __('Close'); ?>',
				handler: function(btn){
					EmployeePerformanceResultViewWindow.close();
				}
			}]
		});
