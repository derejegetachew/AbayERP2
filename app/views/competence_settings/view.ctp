
		
<?php $competenceSetting_html = "<table cellspacing=3>" . 		"<tr><th align=right>" . __('Grade', true) . ":</th><td><b>" . $competenceSetting['Grade']['name'] . "</b></td></tr>" . 
		"<tr><th align=right>" . __('Competence', true) . ":</th><td><b>" . $competenceSetting['Competence']['name'] . "</b></td></tr>" . 
		"<tr><th align=right>" . __('Expected Competence', true) . ":</th><td><b>" . $competenceSetting['CompetenceSetting']['expected_competence'] . "</b></td></tr>" . 
		"<tr><th align=right>" . __('Weight', true) . ":</th><td><b>" . $competenceSetting['CompetenceSetting']['weight'] . "</b></td></tr>" . 
"</table>"; 
?>
		var competenceSetting_view_panel_1 = {
			html : '<?php echo $competenceSetting_html; ?>',
			frame : true,
			height: 80
		}
		var competenceSetting_view_panel_2 = new Ext.TabPanel({
			activeTab: 0,
			anchor: '100%',
			height:190,
			plain:true,
			defaults:{autoScroll: true},
			items:[
						]
		});

		var CompetenceSettingViewWindow = new Ext.Window({
			title: '<?php __('View CompetenceSetting'); ?>: <?php echo $competenceSetting['CompetenceSetting']['id']; ?>',
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
				competenceSetting_view_panel_1,
				competenceSetting_view_panel_2
			],

			buttons: [{
				text: '<?php __('Close'); ?>',
				handler: function(btn){
					CompetenceSettingViewWindow.close();
				}
			}]
		});
