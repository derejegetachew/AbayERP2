
		
<?php $bpActualDetail_html = "<table cellspacing=3>" . 		"<tr><th align=right>" . __('GLCode', true) . ":</th><td><b>" . $bpActualDetail['BpActualDetail']['GLCode'] . "</b></td></tr>" . 
		"<tr><th align=right>" . __('GLDescription', true) . ":</th><td><b>" . $bpActualDetail['BpActualDetail']['GLDescription'] . "</b></td></tr>" . 
		"<tr><th align=right>" . __('TDate', true) . ":</th><td><b>" . $bpActualDetail['BpActualDetail']['TDate'] . "</b></td></tr>" . 
		"<tr><th align=right>" . __('VDate', true) . ":</th><td><b>" . $bpActualDetail['BpActualDetail']['VDate'] . "</b></td></tr>" . 
		"<tr><th align=right>" . __('RefNo', true) . ":</th><td><b>" . $bpActualDetail['BpActualDetail']['RefNo'] . "</b></td></tr>" . 
		"<tr><th align=right>" . __('CCY', true) . ":</th><td><b>" . $bpActualDetail['BpActualDetail']['CCY'] . "</b></td></tr>" . 
		"<tr><th align=right>" . __('DR', true) . ":</th><td><b>" . $bpActualDetail['BpActualDetail']['DR'] . "</b></td></tr>" . 
		"<tr><th align=right>" . __('CR', true) . ":</th><td><b>" . $bpActualDetail['BpActualDetail']['CR'] . "</b></td></tr>" . 
		"<tr><th align=right>" . __('TranCode', true) . ":</th><td><b>" . $bpActualDetail['BpActualDetail']['TranCode'] . "</b></td></tr>" . 
		"<tr><th align=right>" . __('TranDesc', true) . ":</th><td><b>" . $bpActualDetail['BpActualDetail']['TranDesc'] . "</b></td></tr>" . 
		"<tr><th align=right>" . __('Amount', true) . ":</th><td><b>" . $bpActualDetail['BpActualDetail']['Amount'] . "</b></td></tr>" . 
		"<tr><th align=right>" . __('InstrumentCode', true) . ":</th><td><b>" . $bpActualDetail['BpActualDetail']['InstrumentCode'] . "</b></td></tr>" . 
		"<tr><th align=right>" . __('CPO', true) . ":</th><td><b>" . $bpActualDetail['BpActualDetail']['CPO'] . "</b></td></tr>" . 
		"<tr><th align=right>" . __('Description', true) . ":</th><td><b>" . $bpActualDetail['BpActualDetail']['Description'] . "</b></td></tr>" . 
"</table>"; 
?>
		var bpActualDetail_view_panel_1 = {
			html : '<?php echo $bpActualDetail_html; ?>',
			frame : true,
			height: 80
		}
		var bpActualDetail_view_panel_2 = new Ext.TabPanel({
			activeTab: 0,
			anchor: '100%',
			height:190,
			plain:true,
			defaults:{autoScroll: true},
			items:[
						]
		});

		var BpActualDetailViewWindow = new Ext.Window({
			title: '<?php __('View BpActualDetail'); ?>: <?php echo $bpActualDetail['BpActualDetail']['id']; ?>',
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
				bpActualDetail_view_panel_1,
				bpActualDetail_view_panel_2
			],

			buttons: [{
				text: '<?php __('Close'); ?>',
				handler: function(btn){
					BpActualDetailViewWindow.close();
				}
			}]
		});
