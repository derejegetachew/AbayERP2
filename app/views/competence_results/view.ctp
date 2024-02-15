
		
<?php $competenceResult_html = "<table cellspacing=3>" . 		"<tr><th align=right>" . __('Budget Year', true) . ":</th><td><b>" . $competenceResult['BudgetYear']['name'] . "</b></td></tr>" . 
		"<tr><th align=right>" . __('Quarter', true) . ":</th><td><b>" . $competenceResult['CompetenceResult']['quarter'] . "</b></td></tr>" . 
		"<tr><th align=right>" . __('Employee', true) . ":</th><td><b>" . $competenceResult['Employee']['id'] . "</b></td></tr>" . 
		"<tr><th align=right>" . __('Competence', true) . ":</th><td><b>" . $competenceResult['Competence']['name'] . "</b></td></tr>" . 
		"<tr><th align=right>" . __('Actual Competence', true) . ":</th><td><b>" . $competenceResult['CompetenceResult']['actual_competence'] . "</b></td></tr>" . 
		"<tr><th align=right>" . __('Score', true) . ":</th><td><b>" . $competenceResult['CompetenceResult']['score'] . "</b></td></tr>" . 
		"<tr><th align=right>" . __('Rating', true) . ":</th><td><b>" . $competenceResult['CompetenceResult']['rating'] . "</b></td></tr>" . 
"</table>"; 
?>
		var competenceResult_view_panel_1 = {
			html : '<?php echo $competenceResult_html; ?>',
			frame : true,
			height: 80
		}
		var competenceResult_view_panel_2 = new Ext.TabPanel({
			activeTab: 0,
			anchor: '100%',
			height:190,
			plain:true,
			defaults:{autoScroll: true},
			items:[
						]
		});

		var CompetenceResultViewWindow = new Ext.Window({
			title: '<?php __('View CompetenceResult'); ?>: <?php echo $competenceResult['CompetenceResult']['id']; ?>',
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
				competenceResult_view_panel_1,
				competenceResult_view_panel_2
			],

			buttons: [{
				text: '<?php __('Close'); ?>',
				handler: function(btn){
					CompetenceResultViewWindow.close();
				}
			}]
		});
