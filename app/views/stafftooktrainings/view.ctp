
		
<?php $stafftooktraining_html = "<table cellspacing=3>" . 		"<tr><th align=right>" . __('Takentraining', true) . ":</th><td><b>" . $stafftooktraining['Takentraining']['id'] . "</b></td></tr>" . 
		"<tr><th align=right>" . __('Employee', true) . ":</th><td><b>" . $stafftooktraining['Employee']['id'] . "</b></td></tr>" . 
		"<tr><th align=right>" . __('Position', true) . ":</th><td><b>" . $stafftooktraining['Position']['name'] . "</b></td></tr>" . 
		"<tr><th align=right>" . __('Branch', true) . ":</th><td><b>" . $stafftooktraining['Branch']['name'] . "</b></td></tr>" . 
		"<tr><th align=right>" . __('Created', true) . ":</th><td><b>" . $stafftooktraining['Stafftooktraining']['created'] . "</b></td></tr>" . 
		"<tr><th align=right>" . __('Modified', true) . ":</th><td><b>" . $stafftooktraining['Stafftooktraining']['modified'] . "</b></td></tr>" . 
"</table>"; 
?>
		var stafftooktraining_view_panel_1 = {
			html : '<?php echo $stafftooktraining_html; ?>',
			frame : true,
			height: 80
		}
		var stafftooktraining_view_panel_2 = new Ext.TabPanel({
			activeTab: 0,
			anchor: '100%',
			height:190,
			plain:true,
			defaults:{autoScroll: true},
			items:[
						]
		});

		var StafftooktrainingViewWindow = new Ext.Window({
			title: '<?php __('View Stafftooktraining'); ?>: <?php echo $stafftooktraining['Stafftooktraining']['id']; ?>',
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
				stafftooktraining_view_panel_1,
				stafftooktraining_view_panel_2
			],

			buttons: [{
				text: '<?php __('Close'); ?>',
				handler: function(btn){
					StafftooktrainingViewWindow.close();
				}
			}]
		});
