
		
<?php $faTransaction_html = "<table cellspacing=3>" . 		"<tr><th align=right>" . __('Fa Asset', true) . ":</th><td><b>" . $faTransaction['FaAsset']['name'] . "</b></td></tr>" . 
		"<tr><th align=right>" . __('Tax Depreciated Value', true) . ":</th><td><b>" . $faTransaction['FaTransaction']['tax_depreciated_value'] . "</b></td></tr>" . 
		"<tr><th align=right>" . __('Tax Book Value', true) . ":</th><td><b>" . $faTransaction['FaTransaction']['tax_book_value'] . "</b></td></tr>" . 
		"<tr><th align=right>" . __('Ifrs Depreciated Value', true) . ":</th><td><b>" . $faTransaction['FaTransaction']['ifrs_depreciated_value'] . "</b></td></tr>" . 
		"<tr><th align=right>" . __('Ifrs Book Value', true) . ":</th><td><b>" . $faTransaction['FaTransaction']['ifrs_book_value'] . "</b></td></tr>" . 
		"<tr><th align=right>" . __('Budget Year', true) . ":</th><td><b>" . $faTransaction['BudgetYear']['name'] . "</b></td></tr>" . 
"</table>"; 
?>
		var faTransaction_view_panel_1 = {
			html : '<?php echo $faTransaction_html; ?>',
			frame : true,
			height: 80
		}
		var faTransaction_view_panel_2 = new Ext.TabPanel({
			activeTab: 0,
			anchor: '100%',
			height:190,
			plain:true,
			defaults:{autoScroll: true},
			items:[
						]
		});

		var FaTransactionViewWindow = new Ext.Window({
			title: '<?php __('View FaTransaction'); ?>: <?php echo $faTransaction['FaTransaction']['id']; ?>',
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
				faTransaction_view_panel_1,
				faTransaction_view_panel_2
			],

			buttons: [{
				text: '<?php __('Close'); ?>',
				handler: function(btn){
					FaTransactionViewWindow.close();
				}
			}]
		});
