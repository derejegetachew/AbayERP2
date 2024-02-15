
		
<?php $frwfmDocument_html = "<table cellspacing=3>" . 		"<tr><th align=right>" . __('Frwfm Application', true) . ":</th><td><b>" . $frwfmDocument['FrwfmApplication']['id'] . "</b></td></tr>" . 
		"<tr><th align=right>" . __('Name', true) . ":</th><td><b>" . $frwfmDocument['FrwfmDocument']['name'] . "</b></td></tr>" . 
		"<tr><th align=right>" . __('File Path', true) . ":</th><td><b>" . $frwfmDocument['FrwfmDocument']['file_path'] . "</b></td></tr>" . 
		"<tr><th align=right>" . __('Created', true) . ":</th><td><b>" . $frwfmDocument['FrwfmDocument']['created'] . "</b></td></tr>" . 
"</table>"; 
?>
		var frwfmDocument_view_panel_1 = {
			html : '<?php echo $frwfmDocument_html; ?>',
			frame : true,
			height: 80
		}
		var frwfmDocument_view_panel_2 = new Ext.TabPanel({
			activeTab: 0,
			anchor: '100%',
			height:190,
			plain:true,
			defaults:{autoScroll: true},
			items:[
						]
		});

		var FrwfmDocumentViewWindow = new Ext.Window({
			title: '<?php __('View FrwfmDocument'); ?>: <?php echo $frwfmDocument['FrwfmDocument']['name']; ?>',
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
				frwfmDocument_view_panel_1,
				frwfmDocument_view_panel_2
			],

			buttons: [{
				text: '<?php __('Close'); ?>',
				handler: function(btn){
					FrwfmDocumentViewWindow.close();
				}
			}]
		});
