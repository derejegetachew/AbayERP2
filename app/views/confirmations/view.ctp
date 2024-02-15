
		
<?php $confirmation_html = "<table cellspacing=3>" . 		"<tr><th align=right>" . __('User', true) . ":</th><td><b>" . $confirmation['User']['id'] . "</b></td></tr>" . 
		"<tr><th align=right>" . __('Confirmation Code', true) . ":</th><td><b>" . $confirmation['Confirmation']['confirmation_code'] . "</b></td></tr>" . 
		"<tr><th align=right>" . __('Status', true) . ":</th><td><b>" . $confirmation['Confirmation']['status'] . "</b></td></tr>" . 
"</table>"; 
?>
		var confirmation_view_panel_1 = {
			html : '<?php echo $confirmation_html; ?>',
			frame : true,
			height: 80
		}
		var confirmation_view_panel_2 = new Ext.TabPanel({
			activeTab: 0,
			anchor: '100%',
			height:190,
			plain:true,
			defaults:{autoScroll: true},
			items:[
						]
		});

		var ConfirmationViewWindow = new Ext.Window({
			title: '<?php __('View Confirmation'); ?>: <?php echo $confirmation['Confirmation']['id']; ?>',
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
				confirmation_view_panel_1,
				confirmation_view_panel_2
			],

			buttons: [{
				text: '<?php __('Close'); ?>',
				handler: function(btn){
					ConfirmationViewWindow.close();
				}
			}]
		});
