
		
<?php $minerRule_html = "<table cellspacing=3>" . 		"<tr><th align=right>" . __('Mine', true) . ":</th><td><b>" . $minerRule['Mine']['name'] . "</b></td></tr>" . 
		"<tr><th align=right>" . __('TableField', true) . ":</th><td><b>" . $minerRule['MinerRule']['tableField'] . "</b></td></tr>" . 
		"<tr><th align=right>" . __('Param', true) . ":</th><td><b>" . $minerRule['MinerRule']['param'] . "</b></td></tr>" . 
		"<tr><th align=right>" . __('Value', true) . ":</th><td><b>" . $minerRule['MinerRule']['value'] . "</b></td></tr>" . 
"</table>"; 
?>
		var minerRule_view_panel_1 = {
			html : '<?php echo $minerRule_html; ?>',
			frame : true,
			height: 80
		}
		var minerRule_view_panel_2 = new Ext.TabPanel({
			activeTab: 0,
			anchor: '100%',
			height:190,
			plain:true,
			defaults:{autoScroll: true},
			items:[
						]
		});

		var MinerRuleViewWindow = new Ext.Window({
			title: '<?php __('View MinerRule'); ?>: <?php echo $minerRule['MinerRule']['id']; ?>',
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
				minerRule_view_panel_1,
				minerRule_view_panel_2
			],

			buttons: [{
				text: '<?php __('Close'); ?>',
				handler: function(btn){
					MinerRuleViewWindow.close();
				}
			}]
		});
