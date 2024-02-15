
		
<?php $frwfmEvent_html = "<table cellspacing=3>" . 		"<tr><th align=right>" . __('Frwfm Application', true) . ":</th><td><b>" . $frwfmEvent['FrwfmApplication']['id'] . "</b></td></tr>" . 
		"<tr><th align=right>" . __('User', true) . ":</th><td><b>" . $frwfmEvent['User']['id'] . "</b></td></tr>" . 
		"<tr><th align=right>" . __('Action', true) . ":</th><td><b>" . $frwfmEvent['FrwfmEvent']['action'] . "</b></td></tr>" . 
		"<tr><th align=right>" . __('Remark', true) . ":</th><td><b>" . $frwfmEvent['FrwfmEvent']['remark'] . "</b></td></tr>" . 
		"<tr><th align=right>" . __('Created', true) . ":</th><td><b>" . $frwfmEvent['FrwfmEvent']['created'] . "</b></td></tr>" . 
"</table>"; 
?>
		var frwfmEvent_view_panel_1 = {
			html : '<?php echo $frwfmEvent_html; ?>',
			frame : true,
			height: '100%'
		}
		var frwfmEvent_view_panel_2 = new Ext.TabPanel({
			activeTab: 0,
			anchor: '100%',
			height:190,
			plain:true,
			defaults:{autoScroll: true},
			items:[
						]
		});

		var FrwfmEventViewWindow = new Ext.Window({
			title: '<?php __('View FrwfmEvent'); ?>: <?php echo $frwfmEvent['FrwfmEvent']['id']; ?>',
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
				frwfmEvent_view_panel_1
			],

			buttons: [{
				text: '<?php __('Close'); ?>',
				handler: function(btn){
					FrwfmEventViewWindow.close();
				}
			}]
		});
