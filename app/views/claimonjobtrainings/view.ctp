
		
<?php $claimonjobtraining_html = "<table cellspacing=3>" . 		"<tr><th align=right>" . __('Name', true) . ":</th><td><b>" . $claimonjobtraining['Claimonjobtraining']['name'] . "</b></td></tr>" . 
		"<tr><th align=right>" . __('Branch', true) . ":</th><td><b>" . $claimonjobtraining['Claimonjobtraining']['branch'] . "</b></td></tr>" . 
		"<tr><th align=right>" . __('Position', true) . ":</th><td><b>" . $claimonjobtraining['Claimonjobtraining']['position'] . "</b></td></tr>" . 
		"<tr><th align=right>" . __('Date Of Employment', true) . ":</th><td><b>" . $claimonjobtraining['Claimonjobtraining']['date_of_employment'] . "</b></td></tr>" . 
		"<tr><th align=right>" . __('Placement Date', true) . ":</th><td><b>" . $claimonjobtraining['Claimonjobtraining']['placement_date'] . "</b></td></tr>" . 
		"<tr><th align=right>" . __('Date Responded', true) . ":</th><td><b>" . $claimonjobtraining['Claimonjobtraining']['date_responded'] . "</b></td></tr>" . 
		"<tr><th align=right>" . __('No Of Days', true) . ":</th><td><b>" . $claimonjobtraining['Claimonjobtraining']['no_of_days'] . "</b></td></tr>" . 
		"<tr><th align=right>" . __('Payment Month', true) . ":</th><td><b>" . $claimonjobtraining['Claimonjobtraining']['payment_month'] . "</b></td></tr>" . 
		"<tr><th align=right>" . __('Placement Branch', true) . ":</th><td><b>" . $claimonjobtraining['Claimonjobtraining']['placement_branch'] . "</b></td></tr>" . 
		"<tr><th align=right>" . __('Basic Salary', true) . ":</th><td><b>" . $claimonjobtraining['Claimonjobtraining']['basic_salary'] . "</b></td></tr>" . 
		"<tr><th align=right>" . __('Transport', true) . ":</th><td><b>" . $claimonjobtraining['Claimonjobtraining']['transport'] . "</b></td></tr>" . 
		"<tr><th align=right>" . __('Hardship', true) . ":</th><td><b>" . $claimonjobtraining['Claimonjobtraining']['hardship'] . "</b></td></tr>" . 
		"<tr><th align=right>" . __('Pension', true) . ":</th><td><b>" . $claimonjobtraining['Claimonjobtraining']['pension'] . "</b></td></tr>" . 
		"<tr><th align=right>" . __('Total', true) . ":</th><td><b>" . $claimonjobtraining['Claimonjobtraining']['total'] . "</b></td></tr>" . 
"</table>"; 
?>
		var claimonjobtraining_view_panel_1 = {
			html : '<?php echo $claimonjobtraining_html; ?>',
			frame : true,
			height: 80
		}
		var claimonjobtraining_view_panel_2 = new Ext.TabPanel({
			activeTab: 0,
			anchor: '100%',
			height:190,
			plain:true,
			defaults:{autoScroll: true},
			items:[
						]
		});

		var ClaimonjobtrainingViewWindow = new Ext.Window({
			title: '<?php __('View Claimonjobtraining'); ?>: <?php echo $claimonjobtraining['Claimonjobtraining']['name']; ?>',
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
				claimonjobtraining_view_panel_1,
				claimonjobtraining_view_panel_2
			],

			buttons: [{
				text: '<?php __('Close'); ?>',
				handler: function(btn){
					ClaimonjobtrainingViewWindow.close();
				}
			}]
		});
