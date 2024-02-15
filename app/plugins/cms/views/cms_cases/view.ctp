
		
<?php $cmsCase_html = "<table cellspacing=3>" . 		"<tr><th align=right>" . __('Name', true) . ":</th><td><b>" . $cmsCase['CmsCase']['name'] . "</b></td></tr>" . 
		"<tr><th align=right>" . __('Content', true) . ":</th><td><b>" . $cmsCase['CmsCase']['content'] . "</b></td></tr>" . 
		"<tr><th align=right>" . __('Branch', true) . ":</th><td><b>" . $cmsCase['Branch']['name'] . "</b></td></tr>" . 
		"<tr><th align=right>" . __('Level', true) . ":</th><td><b>" . $cmsCase['CmsCase']['level'] . "</b></td></tr>" . 
		"<tr><th align=right>" . __('Attachement', true) . ":</th><td><b>" . $cmsCase['CmsCase']['attachement'] . "</b></td></tr>" . 
		"<tr><th align=right>" . __('User', true) . ":</th><td><b>" . $cmsCase['User']['id'] . "</b></td></tr>" . 
		"<tr><th align=right>" . __('Status', true) . ":</th><td><b>" . $cmsCase['CmsCase']['status'] . "</b></td></tr>" . 
		"<tr><th align=right>" . __('Searchable', true) . ":</th><td><b>" . $cmsCase['CmsCase']['searchable'] . "</b></td></tr>" . 
		"<tr><th align=right>" . __('Created', true) . ":</th><td><b>" . $cmsCase['CmsCase']['created'] . "</b></td></tr>" . 
		"<tr><th align=right>" . __('Modified', true) . ":</th><td><b>" . $cmsCase['CmsCase']['modified'] . "</b></td></tr>" . 
"</table>"; 
?>
		var cmsCase_view_panel_1 = {
			html : '<?php echo $cmsCase_html; ?>',
			frame : true,
			height: 80
		}
		var cmsCase_view_panel_2 = new Ext.TabPanel({
			activeTab: 0,
			anchor: '100%',
			height:190,
			plain:true,
			defaults:{autoScroll: true},
			items:[
						]
		});

		var CmsCaseViewWindow = new Ext.Window({
			title: '<?php __('View CmsCase'); ?>: <?php echo $cmsCase['CmsCase']['name']; ?>',
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
				cmsCase_view_panel_1,
				cmsCase_view_panel_2
			],

			buttons: [{
				text: '<?php __('Close'); ?>',
				handler: function(btn){
					CmsCaseViewWindow.close();
				}
			}]
		});
