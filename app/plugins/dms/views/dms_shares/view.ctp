
		
<?php $dmsShare_html = "<table cellspacing=3>" . 		"<tr><th align=right>" . __('Dms Document', true) . ":</th><td><b>" . $dmsShare['DmsDocument']['name'] . "</b></td></tr>" . 
		"<tr><th align=right>" . __('Branch', true) . ":</th><td><b>" . $dmsShare['Branch']['name'] . "</b></td></tr>" . 
		"<tr><th align=right>" . __('User', true) . ":</th><td><b>" . $dmsShare['User']['id'] . "</b></td></tr>" . 
		"<tr><th align=right>" . __('Read', true) . ":</th><td><b>" . $dmsShare['DmsShare']['read'] . "</b></td></tr>" . 
		"<tr><th align=right>" . __('Write', true) . ":</th><td><b>" . $dmsShare['DmsShare']['write'] . "</b></td></tr>" . 
		"<tr><th align=right>" . __('Delete', true) . ":</th><td><b>" . $dmsShare['DmsShare']['delete'] . "</b></td></tr>" . 
		"<tr><th align=right>" . __('Created', true) . ":</th><td><b>" . $dmsShare['DmsShare']['created'] . "</b></td></tr>" . 
		"<tr><th align=right>" . __('Modified', true) . ":</th><td><b>" . $dmsShare['DmsShare']['modified'] . "</b></td></tr>" . 
"</table>"; 
?>
		var dmsShare_view_panel_1 = {
			html : '<?php echo $dmsShare_html; ?>',
			frame : true,
			height: 80
		}
		var dmsShare_view_panel_2 = new Ext.TabPanel({
			activeTab: 0,
			anchor: '100%',
			height:190,
			plain:true,
			defaults:{autoScroll: true},
			items:[
						]
		});

		var DmsShareViewWindow = new Ext.Window({
			title: '<?php __('View DmsShare'); ?>: <?php echo $dmsShare['DmsShare']['id']; ?>',
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
				dmsShare_view_panel_1,
				dmsShare_view_panel_2
			],

			buttons: [{
				text: '<?php __('Close'); ?>',
				handler: function(btn){
					DmsShareViewWindow.close();
				}
			}]
		});
