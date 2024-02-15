
		
<?php $payrollReport_html = "<table cellspacing=3>" . 		"<tr><th align=right>" . __('Date', true) . ":</th><td><b>" . $payrollReport['PayrollReport']['date'] . "</b></td></tr>" . 
		"<tr><th align=right>" . __('Payroll', true) . ":</th><td><b>" . $payrollReport['Payroll']['name'] . "</b></td></tr>" . 
		"<tr><th align=right>" . __('Budget Year', true) . ":</th><td><b>" . $payrollReport['BudgetYear']['name'] . "</b></td></tr>" . 
"</table>"; 
?>
		var payrollReport_view_panel_1 = {
			html : '<?php echo $payrollReport_html; ?>',
			frame : true,
			height: 80
		}
		var payrollReport_view_panel_2 = new Ext.TabPanel({
			activeTab: 0,
			anchor: '100%',
			height:190,
			plain:true,
			defaults:{autoScroll: true},
			items:[
						]
		});

		var PayrollReportViewWindow = new Ext.Window({
			title: '<?php __('View PayrollReport'); ?>: <?php echo $payrollReport['PayrollReport']['id']; ?>',
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
				payrollReport_view_panel_1,
				payrollReport_view_panel_2
			],

			buttons: [{
				text: '<?php __('Close'); ?>',
				handler: function(btn){
					PayrollReportViewWindow.close();
				}
			}]
		});
