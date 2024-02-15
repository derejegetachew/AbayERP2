
		
<?php $result = $this->requestAction(
							array(
								'controller' => 'ims_maintenance_requests', 
								'action' => 'getUser'), 
							array('userid' => $imsMaintenanceRequest['ImsMaintenanceRequest']['requested_by'])
						);	

$result2 = $this->requestAction(
							array(
								'controller' => 'ims_maintenance_requests', 
								'action' => 'getUser'), 
							array('userid' => $imsMaintenanceRequest['ImsMaintenanceRequest']['approved_rejected_by'])
						);	

						
					
	$imsMaintenanceRequest_html = "<table cellspacing=3>" . 		"<tr><th align=right>" . __('Name', true) . ":</th><td><b>" . $imsMaintenanceRequest['ImsMaintenanceRequest']['name'] . "</b></td></tr>" . 
		"<tr><th align=right>" . __('Branch', true) . ":</th><td><b>" . $imsMaintenanceRequest['Branch']['name'] . "</b></td></tr>" . 
		"<tr><th align=right>" . __('Description', true) . ":</th><td><b>" . $imsMaintenanceRequest['ImsMaintenanceRequest']['description'] . "</b></td></tr>" . 
		"<tr><th align=right>" . __('Requested By', true) . ":</th><td><b>" . $result['Person']['first_name'] .' ' .$result['Person']['middle_name'] .' '.
						$result['Person']['last_name'] . "</b></td></tr>" . 
		"<tr><th align=right>" . __('Approved Rejected By', true) . ":</th><td><b>" . $result2['Person']['first_name'] .' ' .$result2['Person']['middle_name'] .' '.
						$result2['Person']['last_name'] . "</b></td></tr>" . 
		"<tr><th align=right>" . __('Status', true) . ":</th><td><b>" . $imsMaintenanceRequest['ImsMaintenanceRequest']['status'] . "</b></td></tr>" . 
		"<tr><th align=right>" . __('Ims Item', true) . ":</th><td><b>" . $imsMaintenanceRequest['ImsItem']['name'] . "</b></td></tr>" . 
		"<tr><th align=right>" . __('Tag', true) . ":</th><td><b>" . $imsMaintenanceRequest['ImsMaintenanceRequest']['tag'] . "</b></td></tr>" . 
		"<tr><th align=right>" . __('Branch Recommendation', true) . ":</th><td><b>" . $imsMaintenanceRequest['ImsMaintenanceRequest']['branch_recommendation'] . "</b></td></tr>" . 
		"<tr><th align=right>" . __('Technician Recommendation', true) . ":</th><td><b>" . $imsMaintenanceRequest['ImsMaintenanceRequest']['technician_recommendation'] . "</b></td></tr>" . 
		"<tr><th align=right>" . __('Remark', true) . ":</th><td><b>" . $imsMaintenanceRequest['ImsMaintenanceRequest']['remark'] . "</b></td></tr>" . 
		"<tr><th align=right>" . __('Created', true) . ":</th><td><b>" . $imsMaintenanceRequest['ImsMaintenanceRequest']['created'] . "</b></td></tr>" . 
		"<tr><th align=right>" . __('Modified', true) . ":</th><td><b>" . $imsMaintenanceRequest['ImsMaintenanceRequest']['modified'] . "</b></td></tr>" . 
"</table>"; 
?>
		var imsMaintenanceRequest_view_panel_1 = {
			html : '<?php echo $imsMaintenanceRequest_html; ?>',
			frame : true,
			height: 230
		}
		var imsMaintenanceRequest_view_panel_2 = new Ext.TabPanel({
			activeTab: 0,
			anchor: '100%',
			height:10,
			plain:true,
			defaults:{autoScroll: true},
			items:[
						]
		});

		var ImsMaintenanceRequestViewWindow = new Ext.Window({
			title: '<?php __('View Maintenance Request'); ?>: <?php echo $imsMaintenanceRequest['ImsMaintenanceRequest']['name']; ?>',
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
				imsMaintenanceRequest_view_panel_1,
				imsMaintenanceRequest_view_panel_2
			],

			buttons: [{
				text: '<?php __('Close'); ?>',
				handler: function(btn){
					ImsMaintenanceRequestViewWindow.close();
				}
			}]
		});
