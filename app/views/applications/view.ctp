
		
<?php $application_html = "<table cellspacing=3>" . 		"<tr><th align=right>" . __('Employee', true) . ":</th><td><b>" . $application['Employee']['User']['Person']['first_name']." ".$application['Employee']['User']['Person']['middle_name']." ".$application['Employee']['User']['Person']['last_name'] . "</b></td></tr>" . 
		"<tr><th align=right>" . __('Job', true) . ":</th><td><b>" . $application['Job']['name'] . "</b></td></tr>" . 
		"<tr><th align=right>" . __('Letter', true) . ":</th><td><b>" . $application['Application']['letter'] . "</b></td></tr>" . 
		"<tr><th align=right>" . __('Date', true) . ":</th><td><b>" . $application['Application']['created'] . "</b></td></tr>" . 
"</table>"; 
?>
		var application_view_panel_1 = {
			html : '<?php echo $application_html; ?>',
			frame : true,
			height: 300
		}
		var application_view_panel_2 = new Ext.TabPanel({
			activeTab: 0,
			anchor: '100%',
			height:190,
			plain:true,
			defaults:{autoScroll: true},
			items:[
						]
		});

		var ApplicationViewWindow = new Ext.Window({
			title: '<?php __('View Application'); ?>: <?php echo $application['Application']['id']; ?>',
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
				application_view_panel_1
			],

			buttons: [{
				text: '<?php __('Close'); ?>',
				handler: function(btn){
					ApplicationViewWindow.close();
				}
			}]
		});
