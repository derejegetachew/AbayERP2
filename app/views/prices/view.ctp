
		
<?php $price_html = "<table cellspacing=3>" . 		"<tr><th align=right>" . __('Gas', true) . ":</th><td><b>" . $price['Price']['gas'] . "</b></td></tr>" . 
		"<tr><th align=right>" . __('Date', true) . ":</th><td><b>" . $price['Price']['date'] . "</b></td></tr>" . 
		"<tr><th align=right>" . __('Payroll', true) . ":</th><td><b>" . $price['Payroll']['name'] . "</b></td></tr>" . 
"</table>"; 
?>
		var price_view_panel_1 = {
			html : '<?php echo $price_html; ?>',
			frame : true,
			height: 80
		}
		var price_view_panel_2 = new Ext.TabPanel({
			activeTab: 0,
			anchor: '100%',
			height:190,
			plain:true,
			defaults:{autoScroll: true},
			items:[
						]
		});

		var PriceViewWindow = new Ext.Window({
			title: '<?php __('View Price'); ?>: <?php echo $price['Price']['id']; ?>',
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
				price_view_panel_1,
				price_view_panel_2
			],

			buttons: [{
				text: '<?php __('Close'); ?>',
				handler: function(btn){
					PriceViewWindow.close();
				}
			}]
		});
