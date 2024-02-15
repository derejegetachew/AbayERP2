
		
<?php $offspring_html = "<table cellspacing=3>" . 		"<tr><th align=right>" . __('First Name', true) . ":</th><td><b>" . $offspring['Offspring']['first_name'] . "</b></td></tr>" . 
		"<tr><th align=right>" . __('Last Name', true) . ":</th><td><b>" . $offspring['Offspring']['last_name'] . "</b></td></tr>" . 
		"<tr><th align=right>" . __('Sex', true) . ":</th><td><b>" . $offspring['Offspring']['sex'] . "</b></td></tr>" . 
		"<tr><th align=right>" . __('Birth Date', true) . ":</th><td><b>" . $offspring['Offspring']['birth_date'] . "</b></td></tr>" . 
		"<tr><th align=right>" . __('Employee', true) . ":</th><td><b>" . $offspring['Employee']['id'] . "</b></td></tr>" . 
		"<tr><th align=right>" . __('Created', true) . ":</th><td><b>" . $offspring['Offspring']['created'] . "</b></td></tr>" . 
		"<tr><th align=right>" . __('Modified', true) . ":</th><td><b>" . $offspring['Offspring']['modified'] . "</b></td></tr>" . 
"</table>"; 
?>
		var offspring_view_panel_1 = {
			html : '<?php echo $offspring_html; ?>',
			frame : true,
			height: 80
		}
		var offspring_view_panel_2 = new Ext.TabPanel({
			activeTab: 0,
			anchor: '100%',
			height:190,
			plain:true,
			defaults:{autoScroll: true},
			items:[
						]
		});

		var OffspringViewWindow = new Ext.Window({
			title: '<?php __('View Offspring'); ?>: <?php echo $offspring['Offspring']['id']; ?>',
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
				offspring_view_panel_1,
				offspring_view_panel_2
			],

			buttons: [{
				text: '<?php __('Close'); ?>',
				handler: function(btn){
					OffspringViewWindow.close();
				}
			}]
		});
