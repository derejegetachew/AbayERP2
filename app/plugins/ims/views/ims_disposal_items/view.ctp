
		
<?php $imsDisposalItem_html = "<table cellspacing=3>" . 		"<tr><th align=right>" . __('Ims Disposal', true) . ":</th><td><b>" . $imsDisposalItem['ImsDisposal']['name'] . "</b></td></tr>" . 
		"<tr><th align=right>" . __('Ims Item', true) . ":</th><td><b>" . $imsDisposalItem['ImsItem']['name'] . "</b></td></tr>" . 
		"<tr><th align=right>" . __('Measurement', true) . ":</th><td><b>" . $imsDisposalItem['ImsDisposalItem']['measurement'] . "</b></td></tr>" . 
		"<tr><th align=right>" . __('Quantity', true) . ":</th><td><b>" . $imsDisposalItem['ImsDisposalItem']['quantity'] . "</b></td></tr>" . 
		"<tr><th align=right>" . __('Remark', true) . ":</th><td><b>" . $imsDisposalItem['ImsDisposalItem']['remark'] . "</b></td></tr>" . 
		"<tr><th align=right>" . __('Created', true) . ":</th><td><b>" . $imsDisposalItem['ImsDisposalItem']['created'] . "</b></td></tr>" . 
		"<tr><th align=right>" . __('Modified', true) . ":</th><td><b>" . $imsDisposalItem['ImsDisposalItem']['modified'] . "</b></td></tr>" . 
"</table>"; 
?>
		var imsDisposalItem_view_panel_1 = {
			html : '<?php echo $imsDisposalItem_html; ?>',
			frame : true,
			height: 80
		}
		var imsDisposalItem_view_panel_2 = new Ext.TabPanel({
			activeTab: 0,
			anchor: '100%',
			height:190,
			plain:true,
			defaults:{autoScroll: true},
			items:[
						]
		});

		var ImsDisposalItemViewWindow = new Ext.Window({
			title: '<?php __('View ImsDisposalItem'); ?>: <?php echo $imsDisposalItem['ImsDisposalItem']['id']; ?>',
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
				imsDisposalItem_view_panel_1,
				imsDisposalItem_view_panel_2
			],

			buttons: [{
				text: '<?php __('Close'); ?>',
				handler: function(btn){
					ImsDisposalItemViewWindow.close();
				}
			}]
		});
