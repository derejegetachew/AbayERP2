
		
<?php $tab_html = "<table cellspacing=3>" . 		"<tr><th align=right>" . __('Name', true) . ":</th><td><b>" . $tab['Tab']['name'] . "</b></td></tr>" . 
		"<tr><th align=right>" . __('Content', true) . ":</th><td><b>" . $tab['Tab']['content'] . "</b></td></tr>" . 
		"<tr><th align=right>" . __('Created', true) . ":</th><td><b>" . $tab['Tab']['created'] . "</b></td></tr>" . 
		"<tr><th align=right>" . __('Modified', true) . ":</th><td><b>" . $tab['Tab']['modified'] . "</b></td></tr>" . 
"</table>"; 
?>
		var tab_view_panel_1 = {
			html : '<?php echo $tab_html; ?>',
			frame : true,
			height: 80
		}
		var tab_view_panel_2 = new Ext.TabPanel({
			activeTab: 0,
			anchor: '100%',
			height:190,
			plain:true,
			defaults:{autoScroll: true},
			items:[
						]
		});

		var TabViewWindow = new Ext.Window({
			title: '<?php __('View Tab'); ?>: <?php echo $tab['Tab']['name']; ?>',
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
				tab_view_panel_1,
				tab_view_panel_2
			],

			buttons: [{
				text: '<?php __('Close'); ?>',
				handler: function(btn){
					TabViewWindow.close();
				}
			}]
		});
