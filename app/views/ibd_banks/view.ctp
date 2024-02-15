
		
<?php $ibdBank_html = "<table cellspacing=3>" . 		"<tr><th align=right>" . __('Name', true) . ":</th><td><b>" . $ibdBank['IbdBank']['name'] . "</b></td></tr>" . 
		"<tr><th align=right>" . __('Created', true) . ":</th><td><b>" . $ibdBank['IbdBank']['created'] . "</b></td></tr>" . 
		"<tr><th align=right>" . __('Modified', true) . ":</th><td><b>" . $ibdBank['IbdBank']['modified'] . "</b></td></tr>" . 
"</table>"; 
?>
		var ibdBank_view_panel_1 = {
			html : '<?php echo $ibdBank_html; ?>',
			frame : true,
			height: 80
		}
		var ibdBank_view_panel_2 = new Ext.TabPanel({
			activeTab: 0,
			anchor: '100%',
			height:190,
			plain:true,
			defaults:{autoScroll: true},
			items:[
						]
		});

		var IbdBankViewWindow = new Ext.Window({
			title: '<?php __('View IbdBank'); ?>: <?php echo $ibdBank['IbdBank']['name']; ?>',
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
				ibdBank_view_panel_1,
				ibdBank_view_panel_2
			],

			buttons: [{
				text: '<?php __('Close'); ?>',
				handler: function(btn){
					IbdBankViewWindow.close();
				}
			}]
		});
