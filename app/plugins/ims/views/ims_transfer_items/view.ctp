
		
<?php $imsTransferItem_html = "<table cellspacing=3>" . 		"<tr><th align=right>" . __('Ims Transfer', true) . ":</th><td><b>" . $imsTransferItem['ImsTransfer']['name'] . "</b></td></tr>" . 
		"<tr><th align=right>" . __('Ims Item', true) . ":</th><td><b>" . $imsTransferItem['ImsItem']['name'] . "</b></td></tr>" . 
		"<tr><th align=right>" . __('Quantity', true) . ":</th><td><b>" . $imsTransferItem['ImsTransferItem']['quantity'] . "</b></td></tr>" . 
		"<tr><th align=right>" . __('Unit Price', true) . ":</th><td><b>" . $imsTransferItem['ImsTransferItem']['unit_price'] . "</b></td></tr>" . 
		"<tr><th align=right>" . __('Created', true) . ":</th><td><b>" . $imsTransferItem['ImsTransferItem']['created'] . "</b></td></tr>" . 
		"<tr><th align=right>" . __('Modified', true) . ":</th><td><b>" . $imsTransferItem['ImsTransferItem']['modified'] . "</b></td></tr>" . 
"</table>"; 
?>
		var imsTransferItem_view_panel_1 = {
			html : '<?php echo $imsTransferItem_html; ?>',
			frame : true,
			height: 80
		}
		var imsTransferItem_view_panel_2 = new Ext.TabPanel({
			activeTab: 0,
			anchor: '100%',
			height:190,
			plain:true,
			defaults:{autoScroll: true},
			items:[
						]
		});

		var ImsTransferItemViewWindow = new Ext.Window({
			title: '<?php __('View ImsTransferItem'); ?>: <?php echo $imsTransferItem['ImsTransferItem']['id']; ?>',
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
				imsTransferItem_view_panel_1,
				imsTransferItem_view_panel_2
			],

			buttons: [{
				text: '<?php __('Close'); ?>',
				handler: function(btn){
					ImsTransferItemViewWindow.close();
				}
			}]
		});
