
		
<?php $availableBirrNote_html = "<table cellspacing=3>" . 		"<tr><th align=right>" . __('Branch', true) . ":</th><td><b>" . $availableBirrNote['Branch']['name'] . "</b></td></tr>" . 
		"<tr><th align=right>" . __('User', true) . ":</th><td><b>" . $availableBirrNote['User']['id'] . "</b></td></tr>" . 
		"<tr><th align=right>" . __('Old 10 Birr', true) . ":</th><td><b>" . $availableBirrNote['AvailableBirrNote']['old_10_birr'] . "</b></td></tr>" . 
		"<tr><th align=right>" . __('Old 50 Birr', true) . ":</th><td><b>" . $availableBirrNote['AvailableBirrNote']['old_50_birr'] . "</b></td></tr>" . 
		"<tr><th align=right>" . __('Old 100 Birr', true) . ":</th><td><b>" . $availableBirrNote['AvailableBirrNote']['old_100_birr'] . "</b></td></tr>" . 
		"<tr><th align=right>" . __('New 200 Birr', true) . ":</th><td><b>" . $availableBirrNote['AvailableBirrNote']['new_200_birr'] . "</b></td></tr>" . 
		"<tr><th align=right>" . __('New 100 Birr', true) . ":</th><td><b>" . $availableBirrNote['AvailableBirrNote']['new_100_birr'] . "</b></td></tr>" . 
		"<tr><th align=right>" . __('New 50 Birr', true) . ":</th><td><b>" . $availableBirrNote['AvailableBirrNote']['new_50_birr'] . "</b></td></tr>" . 
		"<tr><th align=right>" . __('New 10 Birr', true) . ":</th><td><b>" . $availableBirrNote['AvailableBirrNote']['new_10_birr'] . "</b></td></tr>" . 
		"<tr><th align=right>" . __('New 5 Birr', true) . ":</th><td><b>" . $availableBirrNote['AvailableBirrNote']['new_5_birr'] . "</b></td></tr>" . 
		"<tr><th align=right>" . __('New 1 Birr', true) . ":</th><td><b>" . $availableBirrNote['AvailableBirrNote']['new_1_birr'] . "</b></td></tr>" . 
		"<tr><th align=right>" . __('New 50 Cents', true) . ":</th><td><b>" . $availableBirrNote['AvailableBirrNote']['new_50_cents'] . "</b></td></tr>" . 
		"<tr><th align=right>" . __('New 25 Cents', true) . ":</th><td><b>" . $availableBirrNote['AvailableBirrNote']['new_25_cents'] . "</b></td></tr>" . 
		"<tr><th align=right>" . __('New 10 Cents', true) . ":</th><td><b>" . $availableBirrNote['AvailableBirrNote']['new_10_cents'] . "</b></td></tr>" . 
		"<tr><th align=right>" . __('New 5 Cents', true) . ":</th><td><b>" . $availableBirrNote['AvailableBirrNote']['new_5_cents'] . "</b></td></tr>" . 
		"<tr><th align=right>" . __('Date Of', true) . ":</th><td><b>" . $availableBirrNote['AvailableBirrNote']['date_of'] . "</b></td></tr>" . 
		"<tr><th align=right>" . __('Created', true) . ":</th><td><b>" . $availableBirrNote['AvailableBirrNote']['created'] . "</b></td></tr>" . 
		"<tr><th align=right>" . __('Updated', true) . ":</th><td><b>" . $availableBirrNote['AvailableBirrNote']['updated'] . "</b></td></tr>" . 
"</table>"; 
?>
		var availableBirrNote_view_panel_1 = {
			html : '<?php echo $availableBirrNote_html; ?>',
			frame : true,
			height: 80
		}
		var availableBirrNote_view_panel_2 = new Ext.TabPanel({
			activeTab: 0,
			anchor: '100%',
			height:190,
			plain:true,
			defaults:{autoScroll: true},
			items:[
						]
		});

		var AvailableBirrNoteViewWindow = new Ext.Window({
			title: '<?php __('View AvailableBirrNote'); ?>: <?php echo $availableBirrNote['AvailableBirrNote']['id']; ?>',
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
				availableBirrNote_view_panel_1,
				availableBirrNote_view_panel_2
			],

			buttons: [{
				text: '<?php __('Close'); ?>',
				handler: function(btn){
					AvailableBirrNoteViewWindow.close();
				}
			}]
		});
