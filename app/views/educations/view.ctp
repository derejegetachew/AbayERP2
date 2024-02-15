
		
<?php $education_html = "<table cellspacing=3>" . 		"<tr><th align=right>" . __('Level Of Attainment', true) . ":</th><td><b>" . $education['Education']['level_of_attainment'] . "</b></td></tr>" . 
		"<tr><th align=right>" . __('Field Of Study', true) . ":</th><td><b>" . $education['Education']['field_of_study'] . "</b></td></tr>" . 
		"<tr><th align=right>" . __('Institution', true) . ":</th><td><b>" . $education['Education']['institution'] . "</b></td></tr>" . 
		"<tr><th align=right>" . __('From Date', true) . ":</th><td><b>" . $education['Education']['from_date'] . "</b></td></tr>" . 
		"<tr><th align=right>" . __('To Date', true) . ":</th><td><b>" . $education['Education']['to_date'] . "</b></td></tr>" . 
		"<tr><th align=right>" . __('Is Bank Related', true) . ":</th><td><b>" . $education['Education']['is_bank_related'] . "</b></td></tr>" . 
		"<tr><th align=right>" . __('Employee', true) . ":</th><td><b>" . $education['Employee']['id'] . "</b></td></tr>" . 
		"<tr><th align=right>" . __('Created', true) . ":</th><td><b>" . $education['Education']['created'] . "</b></td></tr>" . 
		"<tr><th align=right>" . __('Modified', true) . ":</th><td><b>" . $education['Education']['modified'] . "</b></td></tr>" . 
"</table>"; 
?>
		var education_view_panel_1 = {
			html : '<?php echo $education_html; ?>',
			frame : true,
			height: 80
		}
		var education_view_panel_2 = new Ext.TabPanel({
			activeTab: 0,
			anchor: '100%',
			height:190,
			plain:true,
			defaults:{autoScroll: true},
			items:[
						]
		});

		var EducationViewWindow = new Ext.Window({
			title: '<?php __('View Education'); ?>: <?php echo $education['Education']['id']; ?>',
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
				education_view_panel_1,
				education_view_panel_2
			],

			buttons: [{
				text: '<?php __('Close'); ?>',
				handler: function(btn){
					EducationViewWindow.close();
				}
			}]
		});
