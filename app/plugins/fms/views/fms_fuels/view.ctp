
		
<?php $fmsFuel_html = "<table cellspacing=3>" . 		"<tr><th align=right>" . __('Fms Vehicle', true) . ":</th><td><b>" . $fmsFuel['FmsVehicle']['id'] . "</b></td></tr>" . 
		"<tr><th align=right>" . __('Fueled Day', true) . ":</th><td><b>" . $fmsFuel['FmsFuel']['fueled_day'] . "</b></td></tr>" . 
		"<tr><th align=right>" . __('Litre', true) . ":</th><td><b>" . $fmsFuel['FmsFuel']['litre'] . "</b></td></tr>" . 
		"<tr><th align=right>" . __('Price', true) . ":</th><td><b>" . $fmsFuel['FmsFuel']['price'] . "</b></td></tr>" . 
		"<tr><th align=right>" . __('Kilometer', true) . ":</th><td><b>" . $fmsFuel['FmsFuel']['kilometer'] . "</b></td></tr>" . 
		"<tr><th align=right>" . __('Status', true) . ":</th><td><b>" . $fmsFuel['FmsFuel']['status'] . "</b></td></tr>" . 
		"<tr><th align=right>" . __('Created By', true) . ":</th><td><b>" . $fmsFuel['FmsFuel']['created_by'] . "</b></td></tr>" . 
		"<tr><th align=right>" . __('Approved By', true) . ":</th><td><b>" . $fmsFuel['FmsFuel']['approved_by'] . "</b></td></tr>" . 
		"<tr><th align=right>" . __('Created', true) . ":</th><td><b>" . $fmsFuel['FmsFuel']['created'] . "</b></td></tr>" . 
		"<tr><th align=right>" . __('Modified', true) . ":</th><td><b>" . $fmsFuel['FmsFuel']['modified'] . "</b></td></tr>" . 
"</table>"; 
?>
		var fmsFuel_view_panel_1 = {
			html : '<?php echo $fmsFuel_html; ?>',
			frame : true,
			height: 80
		}
		var fmsFuel_view_panel_2 = new Ext.TabPanel({
			activeTab: 0,
			anchor: '100%',
			height:190,
			plain:true,
			defaults:{autoScroll: true},
			items:[
						]
		});

		var FmsFuelViewWindow = new Ext.Window({
			title: '<?php __('View FmsFuel'); ?>: <?php echo $fmsFuel['FmsFuel']['id']; ?>',
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
				fmsFuel_view_panel_1,
				fmsFuel_view_panel_2
			],

			buttons: [{
				text: '<?php __('Close'); ?>',
				handler: function(btn){
					FmsFuelViewWindow.close();
				}
			}]
		});
