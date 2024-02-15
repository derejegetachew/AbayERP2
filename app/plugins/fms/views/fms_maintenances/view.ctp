
		
<?php $fmsMaintenance_html = "<table cellspacing=3>" . 		"<tr><th align=right>" . __('Fms Vehicle', true) . ":</th><td><b>" . $fmsMaintenance['FmsVehicle']['id'] . "</b></td></tr>" . 
		"<tr><th align=right>" . __('Item', true) . ":</th><td><b>" . $fmsMaintenance['FmsMaintenance']['item'] . "</b></td></tr>" . 
		"<tr><th align=right>" . __('Serial', true) . ":</th><td><b>" . $fmsMaintenance['FmsMaintenance']['serial'] . "</b></td></tr>" . 
		"<tr><th align=right>" . __('Measurement', true) . ":</th><td><b>" . $fmsMaintenance['FmsMaintenance']['measurement'] . "</b></td></tr>" . 
		"<tr><th align=right>" . __('Quantity', true) . ":</th><td><b>" . $fmsMaintenance['FmsMaintenance']['quantity'] . "</b></td></tr>" . 
		"<tr><th align=right>" . __('Unit Price', true) . ":</th><td><b>" . $fmsMaintenance['FmsMaintenance']['unit_price'] . "</b></td></tr>" . 
		"<tr><th align=right>" . __('Status', true) . ":</th><td><b>" . $fmsMaintenance['FmsMaintenance']['status'] . "</b></td></tr>" . 
		"<tr><th align=right>" . __('Created By', true) . ":</th><td><b>" . $fmsMaintenance['FmsMaintenance']['created_by'] . "</b></td></tr>" . 
		"<tr><th align=right>" . __('Approved By', true) . ":</th><td><b>" . $fmsMaintenance['FmsMaintenance']['approved_by'] . "</b></td></tr>" . 
		"<tr><th align=right>" . __('Created', true) . ":</th><td><b>" . $fmsMaintenance['FmsMaintenance']['created'] . "</b></td></tr>" . 
		"<tr><th align=right>" . __('Modified', true) . ":</th><td><b>" . $fmsMaintenance['FmsMaintenance']['modified'] . "</b></td></tr>" . 
"</table>"; 
?>
		var fmsMaintenance_view_panel_1 = {
			html : '<?php echo $fmsMaintenance_html; ?>',
			frame : true,
			height: 80
		}
		var fmsMaintenance_view_panel_2 = new Ext.TabPanel({
			activeTab: 0,
			anchor: '100%',
			height:190,
			plain:true,
			defaults:{autoScroll: true},
			items:[
						]
		});

		var FmsMaintenanceViewWindow = new Ext.Window({
			title: '<?php __('View FmsMaintenance'); ?>: <?php echo $fmsMaintenance['FmsMaintenance']['id']; ?>',
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
				fmsMaintenance_view_panel_1,
				fmsMaintenance_view_panel_2
			],

			buttons: [{
				text: '<?php __('Close'); ?>',
				handler: function(btn){
					FmsMaintenanceViewWindow.close();
				}
			}]
		});
