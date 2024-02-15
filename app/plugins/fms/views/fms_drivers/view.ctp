
		
<?php $fmsDriver_html = "<table cellspacing=3>" . 		"<tr><th align=right>" . __('Person', true) . ":</th><td><b>" . $fmsDriver['Person']['id'] . "</b></td></tr>" . 
		"<tr><th align=right>" . __('License No', true) . ":</th><td><b>" . $fmsDriver['FmsDriver']['license_no'] . "</b></td></tr>" . 
		"<tr><th align=right>" . __('Date Given', true) . ":</th><td><b>" . $fmsDriver['FmsDriver']['date_given'] . "</b></td></tr>" . 
		"<tr><th align=right>" . __('Expiration Date', true) . ":</th><td><b>" . $fmsDriver['FmsDriver']['expiration_date'] . "</b></td></tr>" . 
		"<tr><th align=right>" . __('Created By', true) . ":</th><td><b>" . $fmsDriver['FmsDriver']['created_by'] . "</b></td></tr>" . 
		"<tr><th align=right>" . __('Created', true) . ":</th><td><b>" . $fmsDriver['FmsDriver']['created'] . "</b></td></tr>" . 
		"<tr><th align=right>" . __('Modified', true) . ":</th><td><b>" . $fmsDriver['FmsDriver']['modified'] . "</b></td></tr>" . 
"</table>"; 
?>
		var fmsDriver_view_panel_1 = {
			html : '<?php echo $fmsDriver_html; ?>',
			frame : true,
			height: 80
		}
		var fmsDriver_view_panel_2 = new Ext.TabPanel({
			activeTab: 0,
			anchor: '100%',
			height:190,
			plain:true,
			defaults:{autoScroll: true},
			items:[
						]
		});

		var FmsDriverViewWindow = new Ext.Window({
			title: '<?php __('View FmsDriver'); ?>: <?php echo $fmsDriver['FmsDriver']['id']; ?>',
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
				fmsDriver_view_panel_1,
				fmsDriver_view_panel_2
			],

			buttons: [{
				text: '<?php __('Close'); ?>',
				handler: function(btn){
					FmsDriverViewWindow.close();
				}
			}]
		});
