
		
<?php $composition_html = "<table cellspacing=3>" . 		"<tr><th align=right>" . __('Position', true) . ":</th><td><b>" . $composition['Position']['name'] . "</b></td></tr>" . 
		"<tr><th align=right>" . __('Branch', true) . ":</th><td><b>" . $composition['Branch']['name'] . "</b></td></tr>" . 
		"<tr><th align=right>" . __('Count', true) . ":</th><td><b>" . $composition['Composition']['count'] . "</b></td></tr>" . 
		"<tr><th align=right>" . __('Created', true) . ":</th><td><b>" . $composition['Composition']['created'] . "</b></td></tr>" . 
		"<tr><th align=right>" . __('Modified', true) . ":</th><td><b>" . $composition['Composition']['modified'] . "</b></td></tr>" . 
"</table>"; 
?>
		var composition_view_panel_1 = {
			html : '<?php echo $composition_html; ?>',
			frame : true,
			height: 80
		}
		var composition_view_panel_2 = new Ext.TabPanel({
			activeTab: 0,
			anchor: '100%',
			height:190,
			plain:true,
			defaults:{autoScroll: true},
			items:[
						]
		});

		var CompositionViewWindow = new Ext.Window({
			title: '<?php __('View Composition'); ?>: <?php echo $composition['Composition']['id']; ?>',
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
				composition_view_panel_1,
				composition_view_panel_2
			],

			buttons: [{
				text: '<?php __('Close'); ?>',
				handler: function(btn){
					CompositionViewWindow.close();
				}
			}]
		});
