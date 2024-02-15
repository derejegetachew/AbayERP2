
		
<?php $imsRequisitionItem_html = "<table cellspacing=3>" . 		"<tr><th align=right>" . __('Ims Requisition', true) . ":</th><td><b>" . $imsRequisitionItem['ImsRequisition']['name'] . "</b></td></tr>" . 
		"<tr><th align=right>" . __('Ims Item', true) . ":</th><td><b>" . $imsRequisitionItem['ImsItem']['name'] . "</b></td></tr>" . 
		"<tr><th align=right>" . __('Quantity', true) . ":</th><td><b>" . $imsRequisitionItem['ImsRequisitionItem']['quantity'] . "</b></td></tr>" . 
		"<tr><th align=right>" . __('Measurement', true) . ":</th><td><b>" . $imsRequisitionItem['ImsRequisitionItem']['measurement'] . "</b></td></tr>" . 
		"<tr><th align=right>" . __('Remark', true) . ":</th><td><b>" . $imsRequisitionItem['ImsRequisitionItem']['remark'] . "</b></td></tr>" . 
		"<tr><th align=right>" . __('Created', true) . ":</th><td><b>" . $imsRequisitionItem['ImsRequisitionItem']['created'] . "</b></td></tr>" . 
		"<tr><th align=right>" . __('Modified', true) . ":</th><td><b>" . $imsRequisitionItem['ImsRequisitionItem']['modified'] . "</b></td></tr>" . 
"</table>"; 
?>
		var imsRequisitionItem_view_panel_1 = {
			html : '<?php echo $imsRequisitionItem_html; ?>',
			frame : true,
			height: 80
		}
		var imsRequisitionItem_view_panel_2 = new Ext.TabPanel({
			activeTab: 0,
			anchor: '100%',
			height:190,
			plain:true,
			defaults:{autoScroll: true},
			items:[
						]
		});

		var ImsRequisitionItemViewWindow = new Ext.Window({
			title: '<?php __('View ImsRequisitionItem'); ?>: <?php echo $imsRequisitionItem['ImsRequisitionItem']['id']; ?>',
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
				imsRequisitionItem_view_panel_1,
				imsRequisitionItem_view_panel_2
			],

			buttons: [{
				text: '<?php __('Close'); ?>',
				handler: function(btn){
					ImsRequisitionItemViewWindow.close();
				}
			}]
		});
