
		
<?php $ibdDocument_html = "<table cellspacing=3>" . 		"<tr><th align=right>" . __('Name', true) . ":</th><td><b>" . $ibdDocument['IbdDocument']['name'] . "</b></td></tr>" . 
		"<tr><th align=right>" . __('Description', true) . ":</th><td><b>" . $ibdDocument['IbdDocument']['description'] . "</b></td></tr>" . 
		"<tr><th align=right>" . __('Controller', true) . ":</th><td><b>" . $ibdDocument['IbdDocument']['controller'] . "</b></td></tr>" . 
		"<tr><th align=right>" . __('Action', true) . ":</th><td><b>" . $ibdDocument['IbdDocument']['action'] . "</b></td></tr>" . 
		"<tr><th align=right>" . __('Created', true) . ":</th><td><b>" . $ibdDocument['IbdDocument']['created'] . "</b></td></tr>" . 
		"<tr><th align=right>" . __('Modified', true) . ":</th><td><b>" . $ibdDocument['IbdDocument']['modified'] . "</b></td></tr>" . 
"</table>"; 
?>
		var ibdDocument_view_panel_1 = {
			html : '<?php echo $ibdDocument_html; ?>',
			frame : true,
			height: 80
		}
		var ibdDocument_view_panel_2 = new Ext.TabPanel({
			activeTab: 0,
			anchor: '100%',
			height:190,
			plain:true,
			defaults:{autoScroll: true},
			items:[
						]
		});

		var IbdDocumentViewWindow = new Ext.Window({
			title: '<?php __('View IbdDocument'); ?>: <?php echo $ibdDocument['IbdDocument']['name']; ?>',
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
				ibdDocument_view_panel_1,
				ibdDocument_view_panel_2
			],

			buttons: [{
				text: '<?php __('Close'); ?>',
				handler: function(btn){
					IbdDocumentViewWindow.close();
				}
			}]
		});
