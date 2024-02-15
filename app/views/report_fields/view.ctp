
		
<?php $reportField_html = "<table cellspacing=3>" . 		"<tr><th align=right>" . __('Report', true) . ":</th><td><b>" . $reportField['Report']['name'] . "</b></td></tr>" . 
		"<tr><th align=right>" . __('Field', true) . ":</th><td><b>" . $reportField['Field']['name'] . "</b></td></tr>" . 
		"<tr><th align=right>" . __('Renamed', true) . ":</th><td><b>" . $reportField['ReportField']['Renamed'] . "</b></td></tr>" . 
		"<tr><th align=right>" . __('Getas', true) . ":</th><td><b>" . $reportField['ReportField']['getas'] . "</b></td></tr>" . 
"</table>"; 
?>
		var reportField_view_panel_1 = {
			html : '<?php echo $reportField_html; ?>',
			frame : true,
			height: 80
		}
		var reportField_view_panel_2 = new Ext.TabPanel({
			activeTab: 0,
			anchor: '100%',
			height:190,
			plain:true,
			defaults:{autoScroll: true},
			items:[
						]
		});

		var ReportFieldViewWindow = new Ext.Window({
			title: '<?php __('View ReportField'); ?>: <?php echo $reportField['ReportField']['id']; ?>',
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
				reportField_view_panel_1,
				reportField_view_panel_2
			],

			buttons: [{
				text: '<?php __('Close'); ?>',
				handler: function(btn){
					ReportFieldViewWindow.close();
				}
			}]
		});
