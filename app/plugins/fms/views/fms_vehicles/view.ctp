
		
<?php $fmsVehicle_html = "<table cellspacing=3>" . 		"<tr><th align=right>" . __('Vehicle Type', true) . ":</th><td><b>" . $fmsVehicle['FmsVehicle']['vehicle_type'] . "</b></td></tr>" . 
		"<tr><th align=right>" . __('Plate No', true) . ":</th><td><b>" . $fmsVehicle['FmsVehicle']['plate_no'] . "</b></td></tr>" . 
		"<tr><th align=right>" . __('Model', true) . ":</th><td><b>" . $fmsVehicle['FmsVehicle']['model'] . "</b></td></tr>" . 
		"<tr><th align=right>" . __('Engine No', true) . ":</th><td><b>" . $fmsVehicle['FmsVehicle']['engine_no'] . "</b></td></tr>" . 
		"<tr><th align=right>" . __('Chassis No', true) . ":</th><td><b>" . $fmsVehicle['FmsVehicle']['chassis_no'] . "</b></td></tr>" . 
		"<tr><th align=right>" . __('Fuel Type', true) . ":</th><td><b>" . $fmsVehicle['FmsVehicle']['fuel_type'] . "</b></td></tr>" . 
		"<tr><th align=right>" . __('No Of Tyre', true) . ":</th><td><b>" . $fmsVehicle['FmsVehicle']['no_of_tyre'] . "</b></td></tr>" . 
		"<tr><th align=right>" . __('Horsepower', true) . ":</th><td><b>" . $fmsVehicle['FmsVehicle']['horsepower'] . "</b></td></tr>" . 
		"<tr><th align=right>" . __('Carload People', true) . ":</th><td><b>" . $fmsVehicle['FmsVehicle']['carload_people'] . "</b></td></tr>" . 
		"<tr><th align=right>" . __('Carload Goods', true) . ":</th><td><b>" . $fmsVehicle['FmsVehicle']['carload_goods'] . "</b></td></tr>" . 
		"<tr><th align=right>" . __('Purchase Amount', true) . ":</th><td><b>" . $fmsVehicle['FmsVehicle']['purchase_amount'] . "</b></td></tr>" . 
		"<tr><th align=right>" . __('Purchase Date', true) . ":</th><td><b>" . $fmsVehicle['FmsVehicle']['purchase_date'] . "</b></td></tr>" . 
		"<tr><th align=right>" . __('Remark', true) . ":</th><td><b>" . $fmsVehicle['FmsVehicle']['remark'] . "</b></td></tr>" . 
		"<tr><th align=right>" . __('Created By', true) . ":</th><td><b>" . $fmsVehicle['FmsVehicle']['created_by'] . "</b></td></tr>" . 
		"<tr><th align=right>" . __('Created', true) . ":</th><td><b>" . $fmsVehicle['FmsVehicle']['created'] . "</b></td></tr>" . 
		"<tr><th align=right>" . __('Modified', true) . ":</th><td><b>" . $fmsVehicle['FmsVehicle']['modified'] . "</b></td></tr>" . 
"</table>"; 
?>
		var fmsVehicle_view_panel_1 = {
			html : '<?php echo $fmsVehicle_html; ?>',
			frame : true,
			height: 80
		}
		var fmsVehicle_view_panel_2 = new Ext.TabPanel({
			activeTab: 0,
			anchor: '100%',
			height:190,
			plain:true,
			defaults:{autoScroll: true},
			items:[
						]
		});

		var FmsVehicleViewWindow = new Ext.Window({
			title: '<?php __('View FmsVehicle'); ?>: <?php echo $fmsVehicle['FmsVehicle']['id']; ?>',
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
				fmsVehicle_view_panel_1,
				fmsVehicle_view_panel_2
			],

			buttons: [{
				text: '<?php __('Close'); ?>',
				handler: function(btn){
					FmsVehicleViewWindow.close();
				}
			}]
		});
