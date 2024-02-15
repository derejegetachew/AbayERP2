
		
<?php $imsBudgetItem_html = "<table cellspacing=3>" . 		"<tr><th align=right>" . __('Ims Budget', true) . ":</th><td><b>" . $imsBudgetItem['ImsBudget']['name'] . "</b></td></tr>" . 
		"<tr><th align=right>" . __('Ims Item', true) . ":</th><td><b>" . $imsBudgetItem['ImsItem']['name'] . "</b></td></tr>" . 
		"<tr><th align=right>" . __('Quantity', true) . ":</th><td><b>" . $imsBudgetItem['ImsBudgetItem']['quantity'] . "</b></td></tr>" . 
		"<tr><th align=right>" . __('Measurement', true) . ":</th><td><b>" . $imsBudgetItem['ImsBudgetItem']['measurement'] . "</b></td></tr>" . 
		"<tr><th align=right>" . __('Created', true) . ":</th><td><b>" . $imsBudgetItem['ImsBudgetItem']['created'] . "</b></td></tr>" . 
		"<tr><th align=right>" . __('Modified', true) . ":</th><td><b>" . $imsBudgetItem['ImsBudgetItem']['modified'] . "</b></td></tr>" . 
"</table>"; 
?>
		var imsBudgetItem_view_panel_1 = {
			html : '<?php echo $imsBudgetItem_html; ?>',
			frame : true,
			height: 80
		}
		var imsBudgetItem_view_panel_2 = new Ext.TabPanel({
			activeTab: 0,
			anchor: '100%',
			height:190,
			plain:true,
			defaults:{autoScroll: true},
			items:[
						]
		});

		var ImsBudgetItemViewWindow = new Ext.Window({
			title: '<?php __('View ImsBudgetItem'); ?>: <?php echo $imsBudgetItem['ImsBudgetItem']['id']; ?>',
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
				imsBudgetItem_view_panel_1,
				imsBudgetItem_view_panel_2
			],

			buttons: [{
				text: '<?php __('Close'); ?>',
				handler: function(btn){
					ImsBudgetItemViewWindow.close();
				}
			}]
		});
