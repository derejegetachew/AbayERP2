//<script>
		
<?php $card_html = "<table cellspacing=3>" . 		"<tr><th align=right>" . __('Item', true) . ":</th><td><b>" . $card['Item']['name'] . "</b></td></tr>" . 
		"<tr><th align=right>" . __('Quantity', true) . ":</th><td><b>" . $card['Card']['quantity'] . "</b></td></tr>" . 
		"<tr><th align=right>" . __('Unit Price', true) . ":</th><td><b>" . $card['Card']['unit_price'] . "</b></td></tr>" . 
		"<tr><th align=right>" . __('Grn', true) . ":</th><td><b>" . $card['Grn']['name'] . "</b></td></tr>" . 
		"<tr><th align=right>" . __('Created', true) . ":</th><td><b>" . $card['Card']['created'] . "</b></td></tr>" . 
		"<tr><th align=right>" . __('Modified', true) . ":</th><td><b>" . $card['Card']['modified'] . "</b></td></tr>" . 
"</table>"; 
?>
		var card_view_panel_1 = {
			html : '<?php echo $card_html; ?>',
			frame : true,
			height: 80
		}
		var card_view_panel_2 = new Ext.TabPanel({
			activeTab: 0,
			anchor: '100%',
			height:190,
			plain:true,
			defaults:{autoScroll: true},
			items:[
						]
		});

		var CardViewWindow = new Ext.Window({
			title: '<?php __('View Card'); ?>: <?php echo $card['Card']['id']; ?>',
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
				card_view_panel_1,
				card_view_panel_2
			],

			buttons: [{
				text: '<?php __('Close'); ?>',
				handler: function(btn){
					CardViewWindow.close();
				}
			}]
		});
