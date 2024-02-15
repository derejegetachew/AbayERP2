
		
<?php $disciplinaryRecord_html = "<table cellspacing=3>" . 		"<tr><th align=right>" . __('Employee', true) . ":</th><td><b>" . $disciplinaryRecord['Employee']['id'] . "</b></td></tr>" . 
		"<tr><th align=right>" . __('Type', true) . ":</th><td><b>" . $disciplinaryRecord['DisciplinaryRecord']['type'] . "</b></td></tr>" . 
		"<tr><th align=right>" . __('Start', true) . ":</th><td><b>" . $disciplinaryRecord['DisciplinaryRecord']['start'] . "</b></td></tr>" . 
		"<tr><th align=right>" . __('End', true) . ":</th><td><b>" . $disciplinaryRecord['DisciplinaryRecord']['end'] . "</b></td></tr>" . 
		"<tr><th align=right>" . __('Remark', true) . ":</th><td><b>" . $disciplinaryRecord['DisciplinaryRecord']['remark'] . "</b></td></tr>" . 
		"<tr><th align=right>" . __('Created', true) . ":</th><td><b>" . $disciplinaryRecord['DisciplinaryRecord']['created'] . "</b></td></tr>" . 
		"<tr><th align=right>" . __('Modified', true) . ":</th><td><b>" . $disciplinaryRecord['DisciplinaryRecord']['modified'] . "</b></td></tr>" . 
"</table>"; 
?>
		var disciplinaryRecord_view_panel_1 = {
			html : '<?php echo $disciplinaryRecord_html; ?>',
			frame : true,
			height: 80
		}
		var disciplinaryRecord_view_panel_2 = new Ext.TabPanel({
			activeTab: 0,
			anchor: '100%',
			height:190,
			plain:true,
			defaults:{autoScroll: true},
			items:[
						]
		});

		var DisciplinaryRecordViewWindow = new Ext.Window({
			title: '<?php __('View DisciplinaryRecord'); ?>: <?php echo $disciplinaryRecord['DisciplinaryRecord']['id']; ?>',
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
				disciplinaryRecord_view_panel_1,
				disciplinaryRecord_view_panel_2
			],

			buttons: [{
				text: '<?php __('Close'); ?>',
				handler: function(btn){
					DisciplinaryRecordViewWindow.close();
				}
			}]
		});
