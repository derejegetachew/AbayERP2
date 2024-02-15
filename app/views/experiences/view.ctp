
		
<?php $experience_html = "<table cellspacing=3>" . 		"<tr><th align=right>" . __('Employer', true) . ":</th><td><b>" . $experience['Experience']['employer'] . "</b></td></tr>" . 
		"<tr><th align=right>" . __('Job Title', true) . ":</th><td><b>" . $experience['Experience']['job_title'] . "</b></td></tr>" . 
		"<tr><th align=right>" . __('From Date', true) . ":</th><td><b>" . $experience['Experience']['from_date'] . "</b></td></tr>" . 
		"<tr><th align=right>" . __('To Date', true) . ":</th><td><b>" . $experience['Experience']['to_date'] . "</b></td></tr>" . 
		"<tr><th align=right>" . __('Employee', true) . ":</th><td><b>" . $experience['Employee']['id'] . "</b></td></tr>" . 
		"<tr><th align=right>" . __('Created', true) . ":</th><td><b>" . $experience['Experience']['created'] . "</b></td></tr>" . 
		"<tr><th align=right>" . __('Modified', true) . ":</th><td><b>" . $experience['Experience']['modified'] . "</b></td></tr>" . 
"</table>"; 
?>
		var experience_view_panel_1 = {
			html : '<?php echo $experience_html; ?>',
			frame : true,
			height: 80
		}
		var experience_view_panel_2 = new Ext.TabPanel({
			activeTab: 0,
			anchor: '100%',
			height:190,
			plain:true,
			defaults:{autoScroll: true},
			items:[
						]
		});

		var ExperienceViewWindow = new Ext.Window({
			title: '<?php __('View Experience'); ?>: <?php echo $experience['Experience']['id']; ?>',
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
				experience_view_panel_1,
				experience_view_panel_2
			],

			buttons: [{
				text: '<?php __('Close'); ?>',
				handler: function(btn){
					ExperienceViewWindow.close();
				}
			}]
		});
