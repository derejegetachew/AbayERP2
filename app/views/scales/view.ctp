
		
<?php $scale_html = "<table cellspacing=3>" . 		"<tr><th align=right>" . __('Grade', true) . ":</th><td><b>" . $scale['Grade']['name'] . "</b></td></tr>" . 
		"<tr><th align=right>" . __('Step', true) . ":</th><td><b>" . $scale['Step']['name'] . "</b></td></tr>" . 
		"<tr><th align=right>" . __('Salary', true) . ":</th><td><b>" . $scale['Scale']['salary'] . "</b></td></tr>" . 
"</table>"; 
?>
		var scale_view_panel_1 = {
			html : '<?php echo $scale_html; ?>',
			frame : true,
			height: 80
		}
		var scale_view_panel_2 = new Ext.TabPanel({
			activeTab: 0,
			anchor: '100%',
			height:190,
			plain:true,
			defaults:{autoScroll: true},
			items:[
						]
		});

		var ScaleViewWindow = new Ext.Window({
			title: '<?php __('View Scale'); ?>: <?php echo $scale['Scale']['id']; ?>',
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
				scale_view_panel_1,
				scale_view_panel_2
			],

			buttons: [{
				text: '<?php __('Close'); ?>',
				handler: function(btn){
					ScaleViewWindow.close();
				}
			}]
		});
