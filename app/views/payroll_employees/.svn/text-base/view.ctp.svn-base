
		
<?php $payrollEmployee_html = "<table cellspacing=3>" . 		"<tr><th align=right>" . __('Payroll', true) . ":</th><td><b>" . $payrollEmployee['Payroll']['name'] . "</b></td></tr>" . 
		"<tr><th align=right>" . __('Employee', true) . ":</th><td><b>" . $payrollEmployee['Employee']['id'] . "</b></td></tr>" . 
		"<tr><th align=right>" . __('Status', true) . ":</th><td><b>" . $payrollEmployee['PayrollEmployee']['status'] . "</b></td></tr>" . 
		"<tr><th align=right>" . __('Date', true) . ":</th><td><b>" . $payrollEmployee['PayrollEmployee']['date'] . "</b></td></tr>" . 
		"<tr><th align=right>" . __('Remark', true) . ":</th><td><b>" . $payrollEmployee['PayrollEmployee']['remark'] . "</b></td></tr>" . 
"</table>"; 
?>
		var payrollEmployee_view_panel_1 = {
			html : '<?php echo $payrollEmployee_html; ?>',
			frame : true,
			height: 80
		}
		var payrollEmployee_view_panel_2 = new Ext.TabPanel({
			activeTab: 0,
			anchor: '100%',
			height:190,
			plain:true,
			defaults:{autoScroll: true},
			items:[
						]
		});

		var PayrollEmployeeViewWindow = new Ext.Window({
			title: '<?php __('View PayrollEmployee'); ?>: <?php echo $payrollEmployee['PayrollEmployee']['id']; ?>',
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
				payrollEmployee_view_panel_1,
				payrollEmployee_view_panel_2
			],

			buttons: [{
				text: '<?php __('Close'); ?>',
				handler: function(btn){
					PayrollEmployeeViewWindow.close();
				}
			}]
		});
