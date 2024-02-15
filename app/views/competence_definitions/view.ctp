
		
<?php $competenceDefinition_html = "<table cellspacing=3>" . 		"<tr><th align=right>" . __('Competence', true) . ":</th><td><b>" . $competenceDefinition['Competence']['name'] . "</b></td></tr>" . 
		"<tr><th align=right>" . __('Competence Level', true) . ":</th><td><b>" . $competenceDefinition['CompetenceLevel']['name'] . "</b></td></tr>" . 
		"<tr><th align=right>" . __('Definition', true) . ":</th><td><b>" . $competenceDefinition['CompetenceDefinition']['definition'] . "</b></td></tr>" . 
"</table>"; 
?>
		var competenceDefinition_view_panel_1 = {
			html : '<?php echo $competenceDefinition_html; ?>',
			frame : true,
			height: 80
		}
		var competenceDefinition_view_panel_2 = new Ext.TabPanel({
			activeTab: 0,
			anchor: '100%',
			height:190,
			plain:true,
			defaults:{autoScroll: true},
			items:[
						]
		});

		var CompetenceDefinitionViewWindow = new Ext.Window({
			title: '<?php __('View CompetenceDefinition'); ?>: <?php echo $competenceDefinition['CompetenceDefinition']['id']; ?>',
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
				competenceDefinition_view_panel_1,
				competenceDefinition_view_panel_2
			],

			buttons: [{
				text: '<?php __('Close'); ?>',
				handler: function(btn){
					CompetenceDefinitionViewWindow.close();
				}
			}]
		});
