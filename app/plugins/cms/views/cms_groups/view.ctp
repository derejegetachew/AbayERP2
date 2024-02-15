
		
<?php $cmsGroup_html = "<table cellspacing=3>" . 		"<tr><th align=right>" . __('Name', true) . ":</th><td><b>" . $cmsGroup['CmsGroup']['name'] . "</b></td></tr>" . 
		"<tr><th align=right>" . __('User', true) . ":</th><td><b>" . $cmsGroup['User']['id'] . "</b></td></tr>" . 
		"<tr><th align=right>" . __('Created', true) . ":</th><td><b>" . $cmsGroup['CmsGroup']['created'] . "</b></td></tr>" . 
		"<tr><th align=right>" . __('Modified', true) . ":</th><td><b>" . $cmsGroup['CmsGroup']['modified'] . "</b></td></tr>" . 
"</table>"; 
?>
		var cmsGroup_view_panel_1 = {
			html : '<?php echo $cmsGroup_html; ?>',
			frame : true,
			height: 80
		}
		var cmsGroup_view_panel_2 = new Ext.TabPanel({
			activeTab: 0,
			anchor: '100%',
			height:190,
			plain:true,
			defaults:{autoScroll: true},
			items:[
						]
		});

		var CmsGroupViewWindow = new Ext.Window({
			title: '<?php __('View CmsGroup'); ?>: <?php echo $cmsGroup['CmsGroup']['name']; ?>',
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
				cmsGroup_view_panel_1,
				cmsGroup_view_panel_2
			],

			buttons: [{
				text: '<?php __('Close'); ?>',
				handler: function(btn){
					CmsGroupViewWindow.close();
				}
			}]
		});
