
		
<?php $pensionEmployee_html = "<table cellspacing=3>" . 		"<tr><th align=right>" . __('Pension', true) . ":</th><td><b>" . $pensionEmployee['Pension']['name'] . "</b></td></tr>" . 
		"<tr><th align=right>" . __('Employee', true) . ":</th><td><b>" . $pensionEmployee['Employee']['id'] . "</b></td></tr>" . 
"</table>"; 
?>
		var pensionEmployee_view_panel_1 = {
			html : '<?php echo $pensionEmployee_html; ?>',
			frame : true,
			height: 80
		}
		var pensionEmployee_view_panel_2 = new Ext.TabPanel({
			activeTab: 0,
			anchor: '100%',
			height:190,
			plain:true,
			defaults:{autoScroll: true},
			items:[
						]
		});

		var PensionEmployeeViewWindow = new Ext.Window({
			title: '<?php __('View PensionEmployee'); ?>: <?php echo $pensionEmployee['PensionEmployee']['id']; ?>',
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
				pensionEmployee_view_panel_1,
				pensionEmployee_view_panel_2
			],

			buttons: [{
				text: '<?php __('Close'); ?>',
				handler: function(btn){
					PensionEmployeeViewWindow.close();
				}
			}]
		});
