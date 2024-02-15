
		
<?php $employeeDetail_html = "<table cellspacing=3>" . 		"<tr><th align=right>" . __('Employee', true) . ":</th><td><b>" . $employeeDetail['Employee']['id'] . "</b></td></tr>" . 
		"<tr><th align=right>" . __('Grade', true) . ":</th><td><b>" . $employeeDetail['Grade']['name'] . "</b></td></tr>" . 
		"<tr><th align=right>" . __('Step', true) . ":</th><td><b>" . $employeeDetail['Step']['name'] . "</b></td></tr>" . 
		"<tr><th align=right>" . __('Position', true) . ":</th><td><b>" . $employeeDetail['Position']['name'] . "</b></td></tr>" . 
		"<tr><th align=right>" . __('Start Date', true) . ":</th><td><b>" . $employeeDetail['EmployeeDetail']['start_date'] . "</b></td></tr>" . 
		"<tr><th align=right>" . __('Created', true) . ":</th><td><b>" . $employeeDetail['EmployeeDetail']['created'] . "</b></td></tr>" . 
		"<tr><th align=right>" . __('Modified', true) . ":</th><td><b>" . $employeeDetail['EmployeeDetail']['modified'] . "</b></td></tr>" . 
"</table>"; 
?>
		var employeeDetail_view_panel_1 = {
			html : '<?php echo $employeeDetail_html; ?>',
			frame : true,
			height: 80
		}
		var employeeDetail_view_panel_2 = new Ext.TabPanel({
			activeTab: 0,
			anchor: '100%',
			height:190,
			plain:true,
			defaults:{autoScroll: true},
			items:[
						]
		});

		var EmployeeDetailViewWindow = new Ext.Window({
			title: '<?php __('View EmployeeDetail'); ?>: <?php echo $employeeDetail['EmployeeDetail']['id']; ?>',
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
				employeeDetail_view_panel_1,
				employeeDetail_view_panel_2
			],

			buttons: [{
				text: '<?php __('Close'); ?>',
				handler: function(btn){
					EmployeeDetailViewWindow.close();
				}
			}]
		});
