
		
<?php $competenceCategory_html = "<table cellspacing=3>" . 		"<tr><th align=right>" . __('Name', true) . ":</th><td><b>" . $competenceCategory['CompetenceCategory']['name'] . "</b></td></tr>" . 
"</table>"; 
?>
		var competenceCategory_view_panel_1 = {
			html : '<?php echo $competenceCategory_html; ?>',
			frame : true,
			height: 80
		}
		var competenceCategory_view_panel_2 = new Ext.TabPanel({
			activeTab: 0,
			anchor: '100%',
			height:190,
			plain:true,
			defaults:{autoScroll: true},
			items:[
						]
		});

		var CompetenceCategoryViewWindow = new Ext.Window({
			title: '<?php __('View CompetenceCategory'); ?>: <?php echo $competenceCategory['CompetenceCategory']['name']; ?>',
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
				competenceCategory_view_panel_1,
				competenceCategory_view_panel_2
			],

			buttons: [{
				text: '<?php __('Close'); ?>',
				handler: function(btn){
					CompetenceCategoryViewWindow.close();
				}
			}]
		});
