
		
<?php $imsSirvItem_html = "<table cellspacing=3>" . 		"<tr><th align=right>" . __('Ims Sirv', true) . ":</th><td><b>" . $imsSirvItem['ImsSirv']['name'] . "</b></td></tr>" . 
		"<tr><th align=right>" . __('Ims Item', true) . ":</th><td><b>" . $imsSirvItem['ImsItem']['name'] . "</b></td></tr>" . 
		"<tr><th align=right>" . __('Measurement', true) . ":</th><td><b>" . $imsSirvItem['ImsSirvItem']['measurement'] . "</b></td></tr>" . 
		"<tr><th align=right>" . __('Quantity', true) . ":</th><td><b>" . $imsSirvItem['ImsSirvItem']['quantity'] . "</b></td></tr>" . 
		"<tr><th align=right>" . __('Unit Price', true) . ":</th><td><b>" . $imsSirvItem['ImsSirvItem']['unit_price'] . "</b></td></tr>" . 
		"<tr><th align=right>" . __('Remark', true) . ":</th><td><b>" . $imsSirvItem['ImsSirvItem']['remark'] . "</b></td></tr>" . 
"</table>"; 
?>
		var imsSirvItem_view_panel_1 = {
			html : '<?php echo $imsSirvItem_html; ?>',
			frame : true,
			height: 80
		}
		var imsSirvItem_view_panel_2 = new Ext.TabPanel({
			activeTab: 0,
			anchor: '100%',
			height:190,
			plain:true,
			defaults:{autoScroll: true},
			items:[
						]
		});

		var ImsSirvItemViewWindow = new Ext.Window({
			title: '<?php __('View ImsSirvItem'); ?>: <?php echo $imsSirvItem['ImsSirvItem']['id']; ?>',
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
				imsSirvItem_view_panel_1,
				imsSirvItem_view_panel_2
			],

			buttons: [{
				text: '<?php __('Close'); ?>',
				handler: function(btn){
					ImsSirvItemViewWindow.close();
				}
			}]
		});
