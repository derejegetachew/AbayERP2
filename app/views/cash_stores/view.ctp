
		
<?php $cashStore_html = "<table cellspacing=3>" . 		"<tr><th align=right>" . __('Account No', true) . ":</th><td><b>" . $cashStore['CashStore']['account_no'] . "</b></td></tr>" . 
		"<tr><th align=right>" . __('Employee', true) . ":</th><td><b>" . $cashStore['Employee']['id'] . "</b></td></tr>" . 
		"<tr><th align=right>" . __('Value', true) . ":</th><td><b>" . $cashStore['CashStore']['value'] . "</b></td></tr>" . 
		"<tr><th align=right>" . __('Budget Year', true) . ":</th><td><b>" . $cashStore['BudgetYear']['name'] . "</b></td></tr>" . 
"</table>"; 
?>
		var cashStore_view_panel_1 = {
			html : '<?php echo $cashStore_html; ?>',
			frame : true,
			height: 80
		}
		var cashStore_view_panel_2 = new Ext.TabPanel({
			activeTab: 0,
			anchor: '100%',
			height:190,
			plain:true,
			defaults:{autoScroll: true},
			items:[
						]
		});

		var CashStoreViewWindow = new Ext.Window({
			title: '<?php __('View CashStore'); ?>: <?php echo $cashStore['CashStore']['id']; ?>',
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
				cashStore_view_panel_1,
				cashStore_view_panel_2
			],

			buttons: [{
				text: '<?php __('Close'); ?>',
				handler: function(btn){
					CashStoreViewWindow.close();
				}
			}]
		});
