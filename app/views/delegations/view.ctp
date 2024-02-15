
		
<?php $delegation_html = "<table cellspacing=3>" . 		"<tr><th align=right>" . __('Employee', true) . ":</th><td><b>" . $delegation['Employee']['id'] . "</b></td></tr>" . 
		"<tr><th align=right>" . __('Delegated', true) . ":</th><td><b>" . $delegation['Delegation']['delegated'] . "</b></td></tr>" . 
		"<tr><th align=right>" . __('Start', true) . ":</th><td><b>" . $delegation['Delegation']['start'] . "</b></td></tr>" . 
		"<tr><th align=right>" . __('End', true) . ":</th><td><b>" . $delegation['Delegation']['end'] . "</b></td></tr>" . 
		"<tr><th align=right>" . __('Comment', true) . ":</th><td><b>" . $delegation['Delegation']['comment'] . "</b></td></tr>" . 
		"<tr><th align=right>" . __('Created', true) . ":</th><td><b>" . $delegation['Delegation']['created'] . "</b></td></tr>" . 
"</table>"; 
?>
		var delegation_view_panel_1 = {
			html : '<?php echo $delegation_html; ?>',
			frame : true,
			height: 80
		}
		var delegation_view_panel_2 = new Ext.TabPanel({
			activeTab: 0,
			anchor: '100%',
			height:190,
			plain:true,
			defaults:{autoScroll: true},
			items:[
						]
		});

		var DelegationViewWindow = new Ext.Window({
			title: '<?php __('View Delegation'); ?>: <?php echo $delegation['Delegation']['id']; ?>',
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
				delegation_view_panel_1,
				delegation_view_panel_2
			],

			buttons: [{
				text: '<?php __('Close'); ?>',
				handler: function(btn){
					DelegationViewWindow.close();
				}
			}]
		});
