
		
<?php $language_html = "<table cellspacing=3>" . 		"<tr><th align=right>" . __('Name', true) . ":</th><td><b>" . $language['Language']['name'] . "</b></td></tr>" . 
		"<tr><th align=right>" . __('Speak', true) . ":</th><td><b>" . $language['Language']['speak'] . "</b></td></tr>" . 
		"<tr><th align=right>" . __('Read', true) . ":</th><td><b>" . $language['Language']['read'] . "</b></td></tr>" . 
		"<tr><th align=right>" . __('Write', true) . ":</th><td><b>" . $language['Language']['write'] . "</b></td></tr>" . 
		"<tr><th align=right>" . __('Listen', true) . ":</th><td><b>" . $language['Language']['listen'] . "</b></td></tr>" . 
		"<tr><th align=right>" . __('Employee', true) . ":</th><td><b>" . $language['Employee']['id'] . "</b></td></tr>" . 
		"<tr><th align=right>" . __('Created', true) . ":</th><td><b>" . $language['Language']['created'] . "</b></td></tr>" . 
		"<tr><th align=right>" . __('Modified', true) . ":</th><td><b>" . $language['Language']['modified'] . "</b></td></tr>" . 
"</table>"; 
?>
		var language_view_panel_1 = {
			html : '<?php echo $language_html; ?>',
			frame : true,
			height: 80
		}
		var language_view_panel_2 = new Ext.TabPanel({
			activeTab: 0,
			anchor: '100%',
			height:190,
			plain:true,
			defaults:{autoScroll: true},
			items:[
						]
		});

		var LanguageViewWindow = new Ext.Window({
			title: '<?php __('View Language'); ?>: <?php echo $language['Language']['name']; ?>',
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
				language_view_panel_1,
				language_view_panel_2
			],

			buttons: [{
				text: '<?php __('Close'); ?>',
				handler: function(btn){
					LanguageViewWindow.close();
				}
			}]
		});
