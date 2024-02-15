
		
<?php $fmsRequisition_html = "<table cellspacing=3>" . 		"<tr><th align=right>" . __('Name', true) . ":</th><td><b>" . $fmsRequisition['FmsRequisition']['name'] . "</b></td></tr>" . 
		"<tr><th align=right>" . __('Requested By', true) . ":</th><td><b>" . $fmsRequisition['FmsRequisition']['requested_by'] . "</b></td></tr>" . 
		"<tr><th align=right>" . __('Approved By', true) . ":</th><td><b>" . $fmsRequisition['FmsRequisition']['approved_by'] . "</b></td></tr>" . 
		"<tr><th align=right>" . __('Branch', true) . ":</th><td><b>" . $fmsRequisition['Branch']['name'] . "</b></td></tr>" . 
		"<tr><th align=right>" . __('Town', true) . ":</th><td><b>" . $fmsRequisition['FmsRequisition']['town'] . "</b></td></tr>" . 
		"<tr><th align=right>" . __('Place', true) . ":</th><td><b>" . $fmsRequisition['FmsRequisition']['place'] . "</b></td></tr>" . 
		"<tr><th align=right>" . __('Departure Date', true) . ":</th><td><b>" . $fmsRequisition['FmsRequisition']['departure_date'] . "</b></td></tr>" . 
		"<tr><th align=right>" . __('Arrival Date', true) . ":</th><td><b>" . $fmsRequisition['FmsRequisition']['arrival_date'] . "</b></td></tr>" . 
		"<tr><th align=right>" . __('Departure Time', true) . ":</th><td><b>" . $fmsRequisition['FmsRequisition']['departure_time'] . "</b></td></tr>" . 
		"<tr><th align=right>" . __('Arrival Time', true) . ":</th><td><b>" . $fmsRequisition['FmsRequisition']['arrival_time'] . "</b></td></tr>" . 
		"<tr><th align=right>" . __('Travelers', true) . ":</th><td><b>" . $fmsRequisition['FmsRequisition']['travelers'] . "</b></td></tr>" . 
		"<tr><th align=right>" . __('Fms Vehicle', true) . ":</th><td><b>" . $fmsRequisition['FmsVehicle']['id'] . "</b></td></tr>" . 
		"<tr><th align=right>" . __('Start Odometer', true) . ":</th><td><b>" . $fmsRequisition['FmsRequisition']['start_odometer'] . "</b></td></tr>" . 
		"<tr><th align=right>" . __('End Odometer', true) . ":</th><td><b>" . $fmsRequisition['FmsRequisition']['end_odometer'] . "</b></td></tr>" . 
		"<tr><th align=right>" . __('Transport Clerk', true) . ":</th><td><b>" . $fmsRequisition['FmsRequisition']['transport_clerk'] . "</b></td></tr>" . 
		"<tr><th align=right>" . __('Transport Supervisor', true) . ":</th><td><b>" . $fmsRequisition['FmsRequisition']['transport_supervisor'] . "</b></td></tr>" . 
		"<tr><th align=right>" . __('Created', true) . ":</th><td><b>" . $fmsRequisition['FmsRequisition']['created'] . "</b></td></tr>" . 
		"<tr><th align=right>" . __('Modified', true) . ":</th><td><b>" . $fmsRequisition['FmsRequisition']['modified'] . "</b></td></tr>" . 
"</table>"; 
?>
		var fmsRequisition_view_panel_1 = {
			html : '<?php echo $fmsRequisition_html; ?>',
			frame : true,
			height: 80
		}
		var fmsRequisition_view_panel_2 = new Ext.TabPanel({
			activeTab: 0,
			anchor: '100%',
			height:190,
			plain:true,
			defaults:{autoScroll: true},
			items:[
						]
		});

		var FmsRequisitionViewWindow = new Ext.Window({
			title: '<?php __('View FmsRequisition'); ?>: <?php echo $fmsRequisition['FmsRequisition']['name']; ?>',
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
				fmsRequisition_view_panel_1,
				fmsRequisition_view_panel_2
			],

			buttons: [{
				text: '<?php __('Close'); ?>',
				handler: function(btn){
					FmsRequisitionViewWindow.close();
				}
			}]
		});
