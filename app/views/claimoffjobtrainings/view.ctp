
		
<?php $claimoffjobtraining_html = "<table cellspacing=3>" . 		"<tr><th align=right>" . __('Name', true) . ":</th><td><b>" . $claimoffjobtraining['Claimoffjobtraining']['name'] . "</b></td></tr>" . 
		"<tr><th align=right>" . __('Branch', true) . ":</th><td><b>" . $claimoffjobtraining['Claimoffjobtraining']['branch'] . "</b></td></tr>" . 
		"<tr><th align=right>" . __('Training Title', true) . ":</th><td><b>" . $claimoffjobtraining['Claimoffjobtraining']['training_title'] . "</b></td></tr>" . 
		"<tr><th align=right>" . __('Position', true) . ":</th><td><b>" . $claimoffjobtraining['Claimoffjobtraining']['position'] . "</b></td></tr>" . 
		"<tr><th align=right>" . __('Venue', true) . ":</th><td><b>" . $claimoffjobtraining['Claimoffjobtraining']['venue'] . "</b></td></tr>" . 
		"<tr><th align=right>" . __('Date Responded', true) . ":</th><td><b>" . $claimoffjobtraining['Claimoffjobtraining']['date_responded'] . "</b></td></tr>" . 
		"<tr><th align=right>" . __('Starting Date', true) . ":</th><td><b>" . $claimoffjobtraining['Claimoffjobtraining']['starting_date'] . "</b></td></tr>" . 
		"<tr><th align=right>" . __('Ending Date', true) . ":</th><td><b>" . $claimoffjobtraining['Claimoffjobtraining']['ending_date'] . "</b></td></tr>" . 
		"<tr><th align=right>" . __('Perdiem', true) . ":</th><td><b>" . $claimoffjobtraining['Claimoffjobtraining']['perdiem'] . "</b></td></tr>" . 
		"<tr><th align=right>" . __('Transport', true) . ":</th><td><b>" . $claimoffjobtraining['Claimoffjobtraining']['transport'] . "</b></td></tr>" . 
		"<tr><th align=right>" . __('Accomadation', true) . ":</th><td><b>" . $claimoffjobtraining['Claimoffjobtraining']['accomadation'] . "</b></td></tr>" . 
		"<tr><th align=right>" . __('Refreshment', true) . ":</th><td><b>" . $claimoffjobtraining['Claimoffjobtraining']['refreshment'] . "</b></td></tr>" . 
		"<tr><th align=right>" . __('Total', true) . ":</th><td><b>" . $claimoffjobtraining['Claimoffjobtraining']['total'] . "</b></td></tr>" . 
"</table>"; 
?>
		var claimoffjobtraining_view_panel_1 = {
			html : '<?php echo $claimoffjobtraining_html; ?>',
			frame : true,
			height: 80
		}
		var claimoffjobtraining_view_panel_2 = new Ext.TabPanel({
			activeTab: 0,
			anchor: '100%',
			height:190,
			plain:true,
			defaults:{autoScroll: true},
			items:[
						]
		});

		var ClaimoffjobtrainingViewWindow = new Ext.Window({
			title: '<?php __('View Claimoffjobtraining'); ?>: <?php echo $claimoffjobtraining['Claimoffjobtraining']['name']; ?>',
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
				claimoffjobtraining_view_panel_1,
				claimoffjobtraining_view_panel_2
			],

			buttons: [{
				text: '<?php __('Close'); ?>',
				handler: function(btn){
					ClaimoffjobtrainingViewWindow.close();
				}
			}]
		});
