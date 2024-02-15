
		
<?php $termination_html = "<table cellspacing=3>" . 		"<tr><th align=right>" . __('Employee', true) . ":</th><td><b>" . $termination['Employee']['id'] . "</b></td></tr>" . 
		"<tr><th align=right>" . __('Reason', true) . ":</th><td><b>" . $termination['Termination']['reason'] . "</b></td></tr>" . 
		"<tr><th align=right>" . __('Date', true) . ":</th><td><b>" . $termination['Termination']['date'] . "</b></td></tr>" . 
		"<tr><th align=right>" . __('Note', true) . ":</th><td><b>" . $termination['Termination']['note'] . "</b></td></tr>" . 
"</table>"; 
?>
		var termination_view_panel_1 = {
			html : '<?php echo $termination_html; ?>',
			frame : true,
			height: 80
		}
		var termination_view_panel_2 = new Ext.TabPanel({
			activeTab: 0,
			anchor: '100%',
			height:190,
			plain:true,
			defaults:{autoScroll: true},
			items:[
						]
		});

		var TerminationViewWindow = new Ext.Window({
			title: '<?php __('View Termination'); ?>: <?php echo $termination['Termination']['id']; ?>',
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
				termination_view_panel_1,
				termination_view_panel_2
			],

			buttons: [{
				text: '<?php __('Close'); ?>',
				handler: function(btn){
					TerminationViewWindow.close();
				}
			}]
		});
