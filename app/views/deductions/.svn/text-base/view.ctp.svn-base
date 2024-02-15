
		
<?php $deduction_html = "<table cellspacing=3>" . 		"<tr><th align=right>" . __('Name', true) . ":</th><td><b>" . $deduction['Deduction']['name'] . "</b></td></tr>" . 
		"<tr><th align=right>" . __('Measurement', true) . ":</th><td><b>" . $deduction['Deduction']['Measurement'] . "</b></td></tr>" . 
		"<tr><th align=right>" . __('Amount', true) . ":</th><td><b>" . $deduction['Deduction']['amount'] . "</b></td></tr>" . 
		"<tr><th align=right>" . __('Grade', true) . ":</th><td><b>" . $deduction['Grade']['name'] . "</b></td></tr>" . 
		"<tr><th align=right>" . __('Start Date', true) . ":</th><td><b>" . $deduction['Deduction']['start_date'] . "</b></td></tr>" . 
		"<tr><th align=right>" . __('End Date', true) . ":</th><td><b>" . $deduction['Deduction']['end_date'] . "</b></td></tr>" . 
"</table>"; 
?>
		var deduction_view_panel_1 = {
			html : '<?php echo $deduction_html; ?>',
			frame : true,
			height: 80
		}
		var deduction_view_panel_2 = new Ext.TabPanel({
			activeTab: 0,
			anchor: '100%',
			height:190,
			plain:true,
			defaults:{autoScroll: true},
			items:[
						]
		});

		var DeductionViewWindow = new Ext.Window({
			title: '<?php __('View Deduction'); ?>: <?php echo $deduction['Deduction']['name']; ?>',
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
				deduction_view_panel_1,
				deduction_view_panel_2
			],

			buttons: [{
				text: '<?php __('Close'); ?>',
				handler: function(btn){
					DeductionViewWindow.close();
				}
			}]
		});
