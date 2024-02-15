
		
<?php $allocatedtraining_html = "<table cellspacing=3>" . 		"<tr><th align=right>" . __('Budget Year', true) . ":</th><td><b>" . $allocatedtraining['BudgetYear']['name'] . "</b></td></tr>" . 
		"<tr><th align=right>" . __('Quarter', true) . ":</th><td><b>" . $allocatedtraining['Allocatedtraining']['quarter'] . "</b></td></tr>" . 
		"<tr><th align=right>" . __('Employee', true) . ":</th><td><b>" . $allocatedtraining['Employee']['id'] . "</b></td></tr>" . 
		"<tr><th align=right>" . __('Training1', true) . ":</th><td><b>" . $allocatedtraining['Allocatedtraining']['training1'] . "</b></td></tr>" . 
		"<tr><th align=right>" . __('Training2', true) . ":</th><td><b>" . $allocatedtraining['Allocatedtraining']['training2'] . "</b></td></tr>" . 
		"<tr><th align=right>" . __('Training3', true) . ":</th><td><b>" . $allocatedtraining['Allocatedtraining']['training3'] . "</b></td></tr>" . 
		
"</table>"; 
?>
		var allocatedtraining_view_panel_1 = {
			html : '<?php echo $allocatedtraining_html; ?>',
			frame : true,
			height: 80
		}
		var allocatedtraining_view_panel_2 = new Ext.TabPanel({
			activeTab: 0,
			anchor: '100%',
			height:190,
			plain:true,
			defaults:{autoScroll: true},
			items:[
						]
		});

		var AllocatedtrainingViewWindow = new Ext.Window({
			title: '<?php __('View Allocatedtraining'); ?>: <?php echo $allocatedtraining['Allocatedtraining']['id']; ?>',
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
				allocatedtraining_view_panel_1,
				allocatedtraining_view_panel_2
			],

			buttons: [{
				text: '<?php __('Close'); ?>',
				handler: function(btn){
					AllocatedtrainingViewWindow.close();
				}
			}]
		});
