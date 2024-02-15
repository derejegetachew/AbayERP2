
		
<?php $bpPlanLog_html = "<table cellspacing=3>" . 		"<tr><th align=right>" . __('Bp Plan', true) . ":</th><td><b>" . $bpPlanLog['BpPlan']['id'] . "</b></td></tr>" . 
		"<tr><th align=right>" . __('User', true) . ":</th><td><b>" . $bpPlanLog['User']['id'] . "</b></td></tr>" . 
		"<tr><th align=right>" . __('Type', true) . ":</th><td><b>" . $bpPlanLog['BpPlanLog']['type'] . "</b></td></tr>" . 
		"<tr><th align=right>" . __('Created', true) . ":</th><td><b>" . $bpPlanLog['BpPlanLog']['created'] . "</b></td></tr>" . 
"</table>"; 
?>
		var bpPlanLog_view_panel_1 = {
			html : '<?php echo $bpPlanLog_html; ?>',
			frame : true,
			height: 80
		}
		var bpPlanLog_view_panel_2 = new Ext.TabPanel({
			activeTab: 0,
			anchor: '100%',
			height:190,
			plain:true,
			defaults:{autoScroll: true},
			items:[
						]
		});

		var BpPlanLogViewWindow = new Ext.Window({
			title: '<?php __('View BpPlanLog'); ?>: <?php echo $bpPlanLog['BpPlanLog']['id']; ?>',
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
				bpPlanLog_view_panel_1,
				bpPlanLog_view_panel_2
			],

			buttons: [{
				text: '<?php __('Close'); ?>',
				handler: function(btn){
					BpPlanLogViewWindow.close();
				}
			}]
		});
