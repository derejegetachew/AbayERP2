
		
<?php $competenceLevel_html = "<table cellspacing=3>" . 		"<tr><th align=right>" . __('Name', true) . ":</th><td><b>" . $competenceLevel['CompetenceLevel']['name'] . "</b></td></tr>" . 
"</table>"; 
?>
		var competenceLevel_view_panel_1 = {
			html : '<?php echo $competenceLevel_html; ?>',
			frame : true,
			height: 80
		}
		var competenceLevel_view_panel_2 = new Ext.TabPanel({
			activeTab: 0,
			anchor: '100%',
			height:190,
			plain:true,
			defaults:{autoScroll: true},
			items:[
						]
		});

		var CompetenceLevelViewWindow = new Ext.Window({
			title: '<?php __('View CompetenceLevel'); ?>: <?php echo $competenceLevel['CompetenceLevel']['name']; ?>',
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
				competenceLevel_view_panel_1,
				competenceLevel_view_panel_2
			],

			buttons: [{
				text: '<?php __('Close'); ?>',
				handler: function(btn){
					CompetenceLevelViewWindow.close();
				}
			}]
		});
