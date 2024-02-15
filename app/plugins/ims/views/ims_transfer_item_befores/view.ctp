
		
<?php $imsTransferItemBefore_html = "<table cellspacing=3>" . 		"<tr><th align=right>" . __('Ims Transfer Before', true) . ":</th><td><b>" . $imsTransferItemBefore['ImsTransferBefore']['name'] . "</b></td></tr>" . 
		"<tr><th align=right>" . __('Ims Sirv Item Before', true) . ":</th><td><b>" . $imsTransferItemBefore['ImsSirvItemBefore']['id'] . "</b></td></tr>" . 
		"<tr><th align=right>" . __('Ims Item', true) . ":</th><td><b>" . $imsTransferItemBefore['ImsItem']['name'] . "</b></td></tr>" . 
		"<tr><th align=right>" . __('Measurement', true) . ":</th><td><b>" . $imsTransferItemBefore['ImsTransferItemBefore']['measurement'] . "</b></td></tr>" . 
		"<tr><th align=right>" . __('Quantity', true) . ":</th><td><b>" . $imsTransferItemBefore['ImsTransferItemBefore']['quantity'] . "</b></td></tr>" . 
		"<tr><th align=right>" . __('Unit Price', true) . ":</th><td><b>" . $imsTransferItemBefore['ImsTransferItemBefore']['unit_price'] . "</b></td></tr>" . 
		"<tr><th align=right>" . __('Tag', true) . ":</th><td><b>" . $imsTransferItemBefore['ImsTransferItemBefore']['tag'] . "</b></td></tr>" . 
		"<tr><th align=right>" . __('Created', true) . ":</th><td><b>" . $imsTransferItemBefore['ImsTransferItemBefore']['created'] . "</b></td></tr>" . 
		"<tr><th align=right>" . __('Modified', true) . ":</th><td><b>" . $imsTransferItemBefore['ImsTransferItemBefore']['modified'] . "</b></td></tr>" . 
"</table>"; 
?>
		var imsTransferItemBefore_view_panel_1 = {
			html : '<?php echo $imsTransferItemBefore_html; ?>',
			frame : true,
			height: 80
		}
		var imsTransferItemBefore_view_panel_2 = new Ext.TabPanel({
			activeTab: 0,
			anchor: '100%',
			height:190,
			plain:true,
			defaults:{autoScroll: true},
			items:[
						]
		});

		var ImsTransferItemBeforeViewWindow = new Ext.Window({
			title: '<?php __('View ImsTransferItemBefore'); ?>: <?php echo $imsTransferItemBefore['ImsTransferItemBefore']['id']; ?>',
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
				imsTransferItemBefore_view_panel_1,
				imsTransferItemBefore_view_panel_2
			],

			buttons: [{
				text: '<?php __('Close'); ?>',
				handler: function(btn){
					ImsTransferItemBeforeViewWindow.close();
				}
			}]
		});
