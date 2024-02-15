
		
<?php $holiday_html = "<table cellspacing=3>" . 		"<tr><th align=right>" . __('Employee', true) . ":</th><td><b>" . $holiday['Employee']['id'] . "</b></td></tr>" . 
		"<tr><th align=right>" . __('Type', true) . ":</th><td><b>" . $holiday['Holiday']['type'] . "</b></td></tr>" . 
		"<tr><th align=right>" . __('From Date', true) . ":</th><td><b>" . $holiday['Holiday']['from_date'] . "</b></td></tr>" . 
		"<tr><th align=right>" . __('To Date', true) . ":</th><td><b>" . $holiday['Holiday']['to_date'] . "</b></td></tr>" . 
		"<tr><th align=right>" . __('Filled Date', true) . ":</th><td><b>" . $holiday['Holiday']['filled_date'] . "</b></td></tr>" . 
		"<tr><th align=right>" . __('Status', true) . ":</th><td><b>" . $holiday['Holiday']['status'] . "</b></td></tr>" . 
"</table>"; 
?>
		var holiday_view_panel_1 = {
			html : '<?php echo $holiday_html; ?>',
			frame : true,
			height: 80
		}
		var holiday_view_panel_2 = new Ext.TabPanel({
			activeTab: 0,
			anchor: '100%',
			height:190,
			plain:true,
			defaults:{autoScroll: true},
			items:[
						]
		});

		var HolidayViewWindow = new Ext.Window({
			title: '<?php __('View Holiday'); ?>: <?php echo $holiday['Holiday']['id']; ?>',
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
				holiday_view_panel_1,
				holiday_view_panel_2
			],

			buttons: [{
				text: '<?php __('Close'); ?>',
				handler: function(btn){
					HolidayViewWindow.close();
				}
			}]
		});
