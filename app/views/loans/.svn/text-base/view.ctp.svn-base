
		
<?php $loan_html = "<table cellspacing=3>" . 
		"<tr><th align=right>" . __('Loan Type', true) . ":</th><td><b>" . $loan['Loan']['Type'] . "</b></td></tr>" . 
		"<tr><th align=right>" . __('Deduction', true) . ":</th><td><b>" . $loan['Loan']['Per_month'] . "</b></td></tr>" . 
		"<tr><th align=right>" . __('Start Date', true) . ":</th><td><b>" . $loan['Loan']['start'] . "</b></td></tr>" . 
		"<tr><th align=right>" . __('Number of Months', true) . ":</th><td><b>" . $loan['Loan']['no_months'] . "</b></td></tr>" . 
		"<tr><th align=right>" . __('Description', true) . ":</th><td><b>" . $loan['Loan']['description'] . "</b></td></tr>" . 
                "<tr><th align=right>" . __('Status', true) . ":</th><td><b>" . $loan['Loan']['status'] . "</b></td></tr>" . 
                "<tr><th align=right>" . __('Close Remark', true) . ":</th><td><b>" . $loan['Loan']['remark'] . "</b></td></tr>" . 
"</table>"; 
?>
		var loan_view_panel_1 = {
			html : '<?php echo $loan_html; ?>',
			frame : true,
			height: 200
		}
		var loan_view_panel_2 = new Ext.TabPanel({
			activeTab: 0,
			anchor: '100%',
			height:200,
			plain:true,
			defaults:{autoScroll: true},
			items:[
						]
		});

		var LoanViewWindow = new Ext.Window({
			title: '<?php __('View Loan'); ?>: <?php echo $loan['Loan']['id']; ?>',
			width: 500,
			height:240,
			minWidth: 500,
			minHeight: 345,
			resizable: false,
			plain:true,
			bodyStyle:'padding:5px;',
			buttonAlign:'center',
                        modal: true,
			items: [ 
				loan_view_panel_1
			],

			buttons: [{
				text: '<?php __('Close'); ?>',
				handler: function(btn){
					LoanViewWindow.close();
				}
			}]
		});
