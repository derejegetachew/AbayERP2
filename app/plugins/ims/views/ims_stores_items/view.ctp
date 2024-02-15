
		
<?php $imsStoresItem_html = "<table cellspacing=3>" . 		"<tr><th align=right>" . __('Ims Store', true) . ":</th><td><b>" . $imsStoresItem['ImsStore']['name'] . "</b></td></tr>" . 
		"<tr><th align=right>" . __('Ims Item', true) . ":</th><td><b>" . $imsStoresItem['ImsItem']['name'] . "</b></td></tr>" . 
		"<tr><th align=right>" . __('Balance', true) . ":</th><td><b>" . $imsStoresItem['ImsStoresItem']['balance'] . "</b></td></tr>" . 
		"<tr><th align=right>" . __('Created', true) . ":</th><td><b>" . $imsStoresItem['ImsStoresItem']['created'] . "</b></td></tr>" . 
		"<tr><th align=right>" . __('Modified', true) . ":</th><td><b>" . $imsStoresItem['ImsStoresItem']['modified'] . "</b></td></tr>" . 
"</table>"; 
?>
		var imsStoresItem_view_panel_1 = {
			html : '<?php echo $imsStoresItem_html; ?>',
			frame : true,
			height: 80
		}
		var imsStoresItem_view_panel_2 = new Ext.TabPanel({
			activeTab: 0,
			anchor: '100%',
			height:190,
			plain:true,
			defaults:{autoScroll: true},
			items:[
						]
		});

		var ImsStoresItemViewWindow = new Ext.Window({
			title: '<?php __('View ImsStoresItem'); ?>: <?php echo $imsStoresItem['ImsStoresItem']['id']; ?>',
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
				imsStoresItem_view_panel_1,
				imsStoresItem_view_panel_2
			],

			buttons: [{
				text: '<?php __('Close'); ?>',
				handler: function(btn){
					ImsStoresItemViewWindow.close();
				}
			}]
		});
