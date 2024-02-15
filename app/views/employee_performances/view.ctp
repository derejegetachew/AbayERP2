
		
<?php $employeePerformance_html = "<table cellspacing=3>" . 		"<tr><th align=right>" . __('Employee', true) . ":</th><td><b>" . $employeePerformance['Employee']['id'] . "</b></td></tr>" . 
		"<tr><th align=right>" . __('Performance', true) . ":</th><td><b>" . $employeePerformance['Performance']['name'] . "</b></td></tr>" . 
		"<tr><th align=right>" . __('Status', true) . ":</th><td><b>" . $employeePerformance['EmployeePerformance']['status'] . "</b></td></tr>" . 
		"<tr><th align=right>" . __('Created', true) . ":</th><td><b>" . $employeePerformance['EmployeePerformance']['created'] . "</b></td></tr>" . 
"</table>"; 
?>
		var employeePerformance_view_panel_1 = {
			html : '<?php echo $employeePerformance_html; ?>',
			frame : true,
			height: 80
		}
		var employeePerformance_view_panel_2 = new Ext.TabPanel({
			activeTab: 0,
			anchor: '100%',
			height:190,
			plain:true,
			defaults:{autoScroll: true},
			items:[
						]
		});

		var EmployeePerformanceViewWindow = new Ext.Window({
			title: '<?php __('View EmployeePerformance'); ?>: <?php echo $employeePerformance['EmployeePerformance']['id']; ?>',
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
				employeePerformance_view_panel_1,
				employeePerformance_view_panel_2
			],

			buttons: [{
				text: '<?php __('Close'); ?>',
				handler: function(btn){
					EmployeePerformanceViewWindow.close();
				}
			}]
		});
