
		
<?php $imsTag_html = "<table cellspacing=3>" . 		"<tr><th align=right>" . __('Code', true) . ":</th><td><b>" . $imsTag['ImsTag']['code'] . "</b></td></tr>" . 
		"<tr><th align=right>" . __('Ims Sirv Item', true) . ":</th><td><b>" . $imsTag['ImsSirvItem']['id'] . "</b></td></tr>" . 
		"<tr><th align=right>" . __('Ims Sirv Item Before', true) . ":</th><td><b>" . $imsTag['ImsSirvItemBefore']['id'] . "</b></td></tr>" . 
		"<tr><th align=right>" . __('Created', true) . ":</th><td><b>" . $imsTag['ImsTag']['created'] . "</b></td></tr>" . 
		"<tr><th align=right>" . __('Modified', true) . ":</th><td><b>" . $imsTag['ImsTag']['modified'] . "</b></td></tr>" . 
"</table>"; 
?>
		var imsTag_view_panel_1 = {
			html : '<?php echo $imsTag_html; ?>',
			frame : true,
			height: 80
		}
		var imsTag_view_panel_2 = new Ext.TabPanel({
			activeTab: 0,
			anchor: '100%',
			height:190,
			plain:true,
			defaults:{autoScroll: true},
			items:[
						]
		});

		var ImsTagViewWindow = new Ext.Window({
			title: '<?php __('View ImsTag'); ?>: <?php echo $imsTag['ImsTag']['id']; ?>',
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
				imsTag_view_panel_1,
				imsTag_view_panel_2
			],

			buttons: [{
				text: '<?php __('Close'); ?>',
				handler: function(btn){
					ImsTagViewWindow.close();
				}
			}]
		});
