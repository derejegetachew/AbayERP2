
		
<?php $cmsAttachment_html = "<table cellspacing=3>" . 		"<tr><th align=right>" . __('File', true) . ":</th><td><b>" . $cmsAttachment['CmsAttachment']['file'] . "</b></td></tr>" . 
		"<tr><th align=right>" . __('Name', true) . ":</th><td><b>" . $cmsAttachment['CmsAttachment']['name'] . "</b></td></tr>" . 
		"<tr><th align=right>" . __('Created', true) . ":</th><td><b>" . $cmsAttachment['CmsAttachment']['created'] . "</b></td></tr>" . 
		"<tr><th align=right>" . __('Cms Reply', true) . ":</th><td><b>" . $cmsAttachment['CmsReply']['id'] . "</b></td></tr>" . 
"</table>"; 
?>
		var cmsAttachment_view_panel_1 = {
			html : '<?php echo $cmsAttachment_html; ?>',
			frame : true,
			height: 80
		}
		var cmsAttachment_view_panel_2 = new Ext.TabPanel({
			activeTab: 0,
			anchor: '100%',
			height:190,
			plain:true,
			defaults:{autoScroll: true},
			items:[
						]
		});

		var CmsAttachmentViewWindow = new Ext.Window({
			title: '<?php __('View CmsAttachment'); ?>: <?php echo $cmsAttachment['CmsAttachment']['name']; ?>',
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
				cmsAttachment_view_panel_1,
				cmsAttachment_view_panel_2
			],

			buttons: [{
				text: '<?php __('Close'); ?>',
				handler: function(btn){
					CmsAttachmentViewWindow.close();
				}
			}]
		});
