
		
<?php $fmsMaintenanceRequest_html = "<table cellspacing=3>" . 		"<tr><th align=right>" . __('Company', true) . ":</th><td><b>" . $fmsMaintenanceRequest['FmsMaintenanceRequest']['company'] . "</b></td></tr>" . 
		"<tr><th align=right>" . __('Fms Vehicle', true) . ":</th><td><b>" . $fmsMaintenanceRequest['FmsVehicle']['id'] . "</b></td></tr>" . 
		"<tr><th align=right>" . __('Km', true) . ":</th><td><b>" . $fmsMaintenanceRequest['FmsMaintenanceRequest']['km'] . "</b></td></tr>" . 
		"<tr><th align=right>" . __('Damage Type', true) . ":</th><td><b>" . $fmsMaintenanceRequest['FmsMaintenanceRequest']['damage_type'] . "</b></td></tr>" . 
		"<tr><th align=right>" . __('Examination', true) . ":</th><td><b>" . $fmsMaintenanceRequest['FmsMaintenanceRequest']['examination'] . "</b></td></tr>" . 
		"<tr><th align=right>" . __('Notifier', true) . ":</th><td><b>" . $fmsMaintenanceRequest['FmsMaintenanceRequest']['notifier'] . "</b></td></tr>" . 
		"<tr><th align=right>" . __('Confirmer', true) . ":</th><td><b>" . $fmsMaintenanceRequest['FmsMaintenanceRequest']['confirmer'] . "</b></td></tr>" . 
		"<tr><th align=right>" . __('Approver', true) . ":</th><td><b>" . $fmsMaintenanceRequest['FmsMaintenanceRequest']['approver'] . "</b></td></tr>" . 
		"<tr><th align=right>" . __('Created', true) . ":</th><td><b>" . $fmsMaintenanceRequest['FmsMaintenanceRequest']['created'] . "</b></td></tr>" . 
		"<tr><th align=right>" . __('Modified', true) . ":</th><td><b>" . $fmsMaintenanceRequest['FmsMaintenanceRequest']['modified'] . "</b></td></tr>" . 
"</table>"; 
?>
		var fmsMaintenanceRequest_view_panel_1 = {
			html : '<?php echo $fmsMaintenanceRequest_html; ?>',
			frame : true,
			height: 80
		}
		var fmsMaintenanceRequest_view_panel_2 = new Ext.TabPanel({
			activeTab: 0,
			anchor: '100%',
			height:190,
			plain:true,
			defaults:{autoScroll: true},
			items:[
						]
		});

		var FmsMaintenanceRequestViewWindow = new Ext.Window({
			title: '<?php __('View FmsMaintenanceRequest'); ?>: <?php echo $fmsMaintenanceRequest['FmsMaintenanceRequest']['id']; ?>',
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
				fmsMaintenanceRequest_view_panel_1,
				fmsMaintenanceRequest_view_panel_2
			],

			buttons: [{
				text: '<?php __('Close'); ?>',
				handler: function(btn){
					FmsMaintenanceRequestViewWindow.close();
				}
			}]
		});
