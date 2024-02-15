
		
<?php $email_html = "<table cellspacing=3>" . 		"<tr><th align=right>" . __('Name', true) . ":</th><td><b>" . $email['Email']['name'] . "</b></td></tr>" . 
		"<tr><th align=right>" . __('From Name', true) . ":</th><td><b>" . $email['Email']['from_name'] . "</b></td></tr>" . 
		"<tr><th align=right>" . __('From', true) . ":</th><td><b>" . $email['Email']['from'] . "</b></td></tr>" . 
		"<tr><th align=right>" . __('To', true) . ":</th><td><b>" . $email['Email']['to'] . "</b></td></tr>" . 
		"<tr><th align=right>" . __('Body', true) . ":</th><td><b>" . $email['Email']['body'] . "</b></td></tr>" . 
		"<tr><th align=right>" . __('Status', true) . ":</th><td><b>" . $email['Email']['status'] . "</b></td></tr>" . 
"</table>"; 
?>
		var email_view_panel_1 = {
			html : '<?php echo $email_html; ?>',
			frame : true,
			height: 80
		}
		var email_view_panel_2 = new Ext.TabPanel({
			activeTab: 0,
			anchor: '100%',
			height:190,
			plain:true,
			defaults:{autoScroll: true},
			items:[
						]
		});

		var EmailViewWindow = new Ext.Window({
			title: '<?php __('View Email'); ?>: <?php echo $email['Email']['name']; ?>',
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
				email_view_panel_1,
				email_view_panel_2
			],

			buttons: [{
				text: '<?php __('Close'); ?>',
				handler: function(btn){
					EmailViewWindow.close();
				}
			}]
		});
