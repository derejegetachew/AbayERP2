
		
<?php $competence_html = "<table cellspacing=3>" . 		"<tr><th align=right>" . __('Name', true) . ":</th><td><b>" . $competence['Competence']['name'] . "</b></td></tr>" . 
		"<tr><th align=right>" . __('Definition', true) . ":</th><td><b>" . $competence['Competence']['definition'] . "</b></td></tr>" . 
		"<tr><th align=right>" . __('Competence Category', true) . ":</th><td><b>" . $competence['CompetenceCategory']['name'] . "</b></td></tr>" . 
"</table>"; 
?>
		var competence_view_panel_1 = {
			html : '<?php echo $competence_html; ?>',
			frame : true,
			height: 80
		}
		var competence_view_panel_2 = new Ext.TabPanel({
			activeTab: 0,
			anchor: '100%',
			height:190,
			plain:true,
			defaults:{autoScroll: true},
			items:[
						]
		});

		var CompetenceViewWindow = new Ext.Window({
			title: '<?php __('View Competence'); ?>: <?php echo $competence['Competence']['name']; ?>',
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
				competence_view_panel_1,
				competence_view_panel_2
			],

			buttons: [{
				text: '<?php __('Close'); ?>',
				handler: function(btn){
					CompetenceViewWindow.close();
				}
			}]
		});
