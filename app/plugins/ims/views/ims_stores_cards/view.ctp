
		
<?php $imsStoresCard_html = "<table cellspacing=3>" . 		"<tr><th align=right>" . __('Ims Store', true) . ":</th><td><b>" . $imsStoresCard['ImsStore']['name'] . "</b></td></tr>" . 
		"<tr><th align=right>" . __('Ims Requisition', true) . ":</th><td><b>" . $imsStoresCard['ImsRequisition']['name'] . "</b></td></tr>" . 
		"<tr><th align=right>" . __('Ims Card', true) . ":</th><td><b>" . $imsStoresCard['ImsCard']['id'] . "</b></td></tr>" . 
		"<tr><th align=right>" . __('Created', true) . ":</th><td><b>" . $imsStoresCard['ImsStoresCard']['created'] . "</b></td></tr>" . 
		"<tr><th align=right>" . __('Modified', true) . ":</th><td><b>" . $imsStoresCard['ImsStoresCard']['modified'] . "</b></td></tr>" . 
"</table>"; 
?>
		var imsStoresCard_view_panel_1 = {
			html : '<?php echo $imsStoresCard_html; ?>',
			frame : true,
			height: 80
		}
		var imsStoresCard_view_panel_2 = new Ext.TabPanel({
			activeTab: 0,
			anchor: '100%',
			height:190,
			plain:true,
			defaults:{autoScroll: true},
			items:[
						]
		});

		var ImsStoresCardViewWindow = new Ext.Window({
			title: '<?php __('View ImsStoresCard'); ?>: <?php echo $imsStoresCard['ImsStoresCard']['id']; ?>',
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
				imsStoresCard_view_panel_1,
				imsStoresCard_view_panel_2
			],

			buttons: [{
				text: '<?php __('Close'); ?>',
				handler: function(btn){
					ImsStoresCardViewWindow.close();
				}
			}]
		});
