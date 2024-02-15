
		
<?php $textMessage_html = "<table cellspacing=3>" . 		"<tr><th align=right>" . __('Name', true) . ":</th><td><b>" . $textMessage['TextMessage']['name'] . "</b></td></tr>" . 
		"<tr><th align=right>" . __('Text', true) . ":</th><td><b>" . $textMessage['TextMessage']['text'] . "</b></td></tr>" . 
		"<tr><th align=right>" . __('Status', true) . ":</th><td><b>" . $textMessage['TextMessage']['status'] . "</b></td></tr>" . 
"</table>"; 
?>
		var textMessage_view_panel_1 = {
			html : '<?php echo $textMessage_html; ?>',
			frame : true,
			height: 80
		}
		var textMessage_view_panel_2 = new Ext.TabPanel({
			activeTab: 0,
			anchor: '100%',
			height:190,
			plain:true,
			defaults:{autoScroll: true},
			items:[
						]
		});

		var TextMessageViewWindow = new Ext.Window({
			title: '<?php __('View TextMessage'); ?>: <?php echo $textMessage['TextMessage']['name']; ?>',
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
				textMessage_view_panel_1,
				textMessage_view_panel_2
			],

			buttons: [{
				text: '<?php __('Close'); ?>',
				handler: function(btn){
					TextMessageViewWindow.close();
				}
			}]
		});
