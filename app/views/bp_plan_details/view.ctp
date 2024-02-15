
		
<?php $bpPlanDetail_html = "<table cellspacing=3>" . 		"<tr><th align=right>" . __('Bp Item', true) . ":</th><td><b>" . $bpPlanDetail['BpItem']['name'] . "</b></td></tr>" . 
		"<tr><th align=right>" . __('Bp Plan', true) . ":</th><td><b>" . $bpPlanDetail['BpPlan']['id'] . "</b></td></tr>" . 
		"<tr><th align=right>" . __('Amount', true) . ":</th><td><b>" . $bpPlanDetail['BpPlanDetail']['amount'] . "</b></td></tr>" . 
"</table>"; 
?>
		var bpPlanDetail_view_panel_1 = {
			html : '<?php echo $bpPlanDetail_html; ?>',
			frame : true,
			height: 80
		}
		var bpPlanDetail_view_panel_2 = new Ext.TabPanel({
			activeTab: 0,
			anchor: '100%',
			height:190,
			plain:true,
			defaults:{autoScroll: true},
			items:[
						]
		});

		var BpPlanDetailViewWindow = new Ext.Window({
			title: '<?php __('View BpPlanDetail'); ?>: <?php echo $bpPlanDetail['BpPlanDetail']['id']; ?>',
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
				bpPlanDetail_view_panel_1,
				bpPlanDetail_view_panel_2
			],

			buttons: [{
				text: '<?php __('Close'); ?>',
				handler: function(btn){
					BpPlanDetailViewWindow.close();
				}
			}]
		});
