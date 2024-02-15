
		
<?php $imsDelegate_html = "<table cellspacing=3>" . 		"<tr><th align=right>" . __('Ims Requisition', true) . ":</th><td><b>" . $imsDelegate['ImsRequisition']['name'] . "</b></td></tr>" . 
		"<tr><th align=right>" . __('User', true) . ":</th><td><b>" . $imsDelegate['User']['id'] . "</b></td></tr>" . 
		"<tr><th align=right>" . __('Name', true) . ":</th><td><b>" . $imsDelegate['ImsDelegate']['name'] . "</b></td></tr>" . 
		"<tr><th align=right>" . __('Phone', true) . ":</th><td><b>" . $imsDelegate['ImsDelegate']['phone'] . "</b></td></tr>" . 
		"<tr><th align=right>" . __('Created', true) . ":</th><td><b>" . $imsDelegate['ImsDelegate']['created'] . "</b></td></tr>" . 
		"<tr><th align=right>" . __('Modified', true) . ":</th><td><b>" . $imsDelegate['ImsDelegate']['modified'] . "</b></td></tr>" . 
"</table>"; 
?>
		var imsDelegate_view_panel_1 = {
			html : '<?php echo $imsDelegate_html; ?>',
			frame : true,
			height: 80
		}
		var imsDelegate_view_panel_2 = new Ext.TabPanel({
			activeTab: 0,
			anchor: '100%',
			height:190,
			plain:true,
			defaults:{autoScroll: true},
			items:[
						]
		});

		var ImsDelegateViewWindow = new Ext.Window({
			title: '<?php __('View ImsDelegate'); ?>: <?php echo $imsDelegate['ImsDelegate']['name']; ?>',
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
				imsDelegate_view_panel_1,
				imsDelegate_view_panel_2
			],

			buttons: [{
				text: '<?php __('Close'); ?>',
				handler: function(btn){
					ImsDelegateViewWindow.close();
				}
			}]
		});
