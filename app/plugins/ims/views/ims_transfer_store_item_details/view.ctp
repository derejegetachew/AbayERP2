
		
<?php $imsTransferStoreItemDetail_html = "<table cellspacing=3>" . 		"<tr><th align=right>" . __('Ims Transfer Store Item', true) . ":</th><td><b>" . $imsTransferStoreItemDetail['ImsTransferStoreItem']['name'] . "</b></td></tr>" . 
		"<tr><th align=right>" . __('Ims Item', true) . ":</th><td><b>" . $imsTransferStoreItemDetail['ImsItem']['name'] . "</b></td></tr>" . 
		"<tr><th align=right>" . __('Quantity', true) . ":</th><td><b>" . $imsTransferStoreItemDetail['ImsTransferStoreItemDetail']['quantity'] . "</b></td></tr>" . 
		"<tr><th align=right>" . __('Measurement', true) . ":</th><td><b>" . $imsTransferStoreItemDetail['ImsTransferStoreItemDetail']['measurement'] . "</b></td></tr>" . 
		"<tr><th align=right>" . __('Remark', true) . ":</th><td><b>" . $imsTransferStoreItemDetail['ImsTransferStoreItemDetail']['remark'] . "</b></td></tr>" . 
		"<tr><th align=right>" . __('Created', true) . ":</th><td><b>" . $imsTransferStoreItemDetail['ImsTransferStoreItemDetail']['created'] . "</b></td></tr>" . 
		"<tr><th align=right>" . __('Modified', true) . ":</th><td><b>" . $imsTransferStoreItemDetail['ImsTransferStoreItemDetail']['modified'] . "</b></td></tr>" . 
"</table>"; 
?>
		var imsTransferStoreItemDetail_view_panel_1 = {
			html : '<?php echo $imsTransferStoreItemDetail_html; ?>',
			frame : true,
			height: 80
		}
		var imsTransferStoreItemDetail_view_panel_2 = new Ext.TabPanel({
			activeTab: 0,
			anchor: '100%',
			height:190,
			plain:true,
			defaults:{autoScroll: true},
			items:[
						]
		});

		var ImsTransferStoreItemDetailViewWindow = new Ext.Window({
			title: '<?php __('View Transfer Store Item Detail'); ?>: <?php echo $imsTransferStoreItemDetail['ImsTransferStoreItemDetail']['id']; ?>',
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
				imsTransferStoreItemDetail_view_panel_1,
				imsTransferStoreItemDetail_view_panel_2
			],

			buttons: [{
				text: '<?php __('Close'); ?>',
				handler: function(btn){
					ImsTransferStoreItemDetailViewWindow.close();
				}
			}]
		});
