
		
<?php $fmsDrivertovehicleAssignment_html = "<table cellspacing=3>" . 		"<tr><th align=right>" . __('Fms Driver', true) . ":</th><td><b>" . $fmsDrivertovehicleAssignment['FmsDriver']['id'] . "</b></td></tr>" . 
		"<tr><th align=right>" . __('Fms Vehicle', true) . ":</th><td><b>" . $fmsDrivertovehicleAssignment['FmsVehicle']['id'] . "</b></td></tr>" . 
		"<tr><th align=right>" . __('Start Date', true) . ":</th><td><b>" . $fmsDrivertovehicleAssignment['FmsDrivertovehicleAssignment']['start_date'] . "</b></td></tr>" . 
		"<tr><th align=right>" . __('End Date', true) . ":</th><td><b>" . $fmsDrivertovehicleAssignment['FmsDrivertovehicleAssignment']['end_date'] . "</b></td></tr>" . 
		"<tr><th align=right>" . __('Created By', true) . ":</th><td><b>" . $fmsDrivertovehicleAssignment['FmsDrivertovehicleAssignment']['created_by'] . "</b></td></tr>" . 
		"<tr><th align=right>" . __('Created', true) . ":</th><td><b>" . $fmsDrivertovehicleAssignment['FmsDrivertovehicleAssignment']['created'] . "</b></td></tr>" . 
		"<tr><th align=right>" . __('Modified', true) . ":</th><td><b>" . $fmsDrivertovehicleAssignment['FmsDrivertovehicleAssignment']['modified'] . "</b></td></tr>" . 
"</table>"; 
?>
		var fmsDrivertovehicleAssignment_view_panel_1 = {
			html : '<?php echo $fmsDrivertovehicleAssignment_html; ?>',
			frame : true,
			height: 80
		}
		var fmsDrivertovehicleAssignment_view_panel_2 = new Ext.TabPanel({
			activeTab: 0,
			anchor: '100%',
			height:190,
			plain:true,
			defaults:{autoScroll: true},
			items:[
						]
		});

		var FmsDrivertovehicleAssignmentViewWindow = new Ext.Window({
			title: '<?php __('View FmsDrivertovehicleAssignment'); ?>: <?php echo $fmsDrivertovehicleAssignment['FmsDrivertovehicleAssignment']['id']; ?>',
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
				fmsDrivertovehicleAssignment_view_panel_1,
				fmsDrivertovehicleAssignment_view_panel_2
			],

			buttons: [{
				text: '<?php __('Close'); ?>',
				handler: function(btn){
					FmsDrivertovehicleAssignmentViewWindow.close();
				}
			}]
		});
