
		
<?php $dmsAttachment_html = "<table cellspacing=3>" . 		"<tr><th align=right>" . __('Name', true) . ":</th><td><b>" . $dmsAttachment['DmsAttachment']['name'] . "</b></td></tr>" . 
		"<tr><th align=right>" . __('File', true) . ":</th><td><b>" . $dmsAttachment['DmsAttachment']['file'] . "</b></td></tr>" . 
		"<tr><th align=right>" . __('Dms Message', true) . ":</th><td><b>" . $dmsAttachment['DmsMessage']['name'] . "</b></td></tr>" . 
		"<tr><th align=right>" . __('Created', true) . ":</th><td><b>" . $dmsAttachment['DmsAttachment']['created'] . "</b></td></tr>" . 
"</table>"; 
?>
		var dmsAttachment_view_panel_1 = {
			html : '<?php echo $dmsAttachment_html; ?>',
			frame : true,
			height: 80
		}
		var dmsAttachment_view_panel_2 = new Ext.TabPanel({
			activeTab: 0,
			anchor: '100%',
			height:190,
			plain:true,
			defaults:{autoScroll: true},
			items:[
						]
		});

		var DmsAttachmentViewWindow = new Ext.Window({
			title: '<?php __('View DmsAttachment'); ?>: <?php echo $dmsAttachment['DmsAttachment']['name']; ?>',
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
				dmsAttachment_view_panel_1,
				dmsAttachment_view_panel_2
			],

			buttons: [{
				text: '<?php __('Close'); ?>',
				handler: function(btn){
					DmsAttachmentViewWindow.close();
				}
			}]
		});
