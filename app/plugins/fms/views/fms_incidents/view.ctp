
		
<?php $fmsIncident_html = "<table cellspacing=3>" . 		"<tr><th align=right>" . __('Fms Vehicle', true) . ":</th><td><b>" . $fmsIncident['FmsVehicle']['id'] . "</b></td></tr>" . 
		"<tr><th align=right>" . __('Occurrence Date', true) . ":</th><td><b>" . $fmsIncident['FmsIncident']['occurrence_date'] . "</b></td></tr>" . 
		"<tr><th align=right>" . __('Occurrence Time', true) . ":</th><td><b>" . $fmsIncident['FmsIncident']['occurrence_time'] . "</b></td></tr>" . 
		"<tr><th align=right>" . __('Occurrence Place', true) . ":</th><td><b>" . $fmsIncident['FmsIncident']['occurrence_place'] . "</b></td></tr>" . 
		"<tr><th align=right>" . __('Details', true) . ":</th><td><b>" . $fmsIncident['FmsIncident']['details'] . "</b></td></tr>" . 
		"<tr><th align=right>" . __('Action Taken', true) . ":</th><td><b>" . $fmsIncident['FmsIncident']['action_taken'] . "</b></td></tr>" . 
		"<tr><th align=right>" . __('Created By', true) . ":</th><td><b>" . $fmsIncident['FmsIncident']['created_by'] . "</b></td></tr>" . 
		"<tr><th align=right>" . __('Created', true) . ":</th><td><b>" . $fmsIncident['FmsIncident']['created'] . "</b></td></tr>" . 
		"<tr><th align=right>" . __('Modified', true) . ":</th><td><b>" . $fmsIncident['FmsIncident']['modified'] . "</b></td></tr>" . 
"</table>"; 
?>
		var fmsIncident_view_panel_1 = {
			html : '<?php echo $fmsIncident_html; ?>',
			frame : true,
			height: 80
		}
		var fmsIncident_view_panel_2 = new Ext.TabPanel({
			activeTab: 0,
			anchor: '100%',
			height:190,
			plain:true,
			defaults:{autoScroll: true},
			items:[
						]
		});

		var FmsIncidentViewWindow = new Ext.Window({
			title: '<?php __('View FmsIncident'); ?>: <?php echo $fmsIncident['FmsIncident']['id']; ?>',
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
				fmsIncident_view_panel_1,
				fmsIncident_view_panel_2
			],

			buttons: [{
				text: '<?php __('Close'); ?>',
				handler: function(btn){
					FmsIncidentViewWindow.close();
				}
			}]
		});
