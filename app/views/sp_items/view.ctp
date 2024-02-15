
		
<?php $spItem_html = "<table cellspacing=3>" . 		"<tr><th align=right>" . __('Name', true) . ":</th><td><b>" . $spItem['SpItem']['name'] . "</b></td></tr>" . 
		"<tr><th align=right>" . __('Desc', true) . ":</th><td><b>" . $spItem['SpItem']['desc'] . "</b></td></tr>" . 
		"<tr><th align=right>" . __('Price', true) . ":</th><td><b>" . $spItem['SpItem']['price'] . "</b></td></tr>" . 
		"<tr><th align=right>" . __('Um', true) . ":</th><td><b>" . $spItem['SpItem']['um'] . "</b></td></tr>" . 
		"<tr><th align=right>" . __('Sp Item Group', true) . ":</th><td><b>" . $spItem['SpItemGroup']['name'] . "</b></td></tr>" . 
		"<tr><th align=right>" . __('Created', true) . ":</th><td><b>" . $spItem['SpItem']['created'] . "</b></td></tr>" . 
		"<tr><th align=right>" . __('Modified', true) . ":</th><td><b>" . $spItem['SpItem']['modified'] . "</b></td></tr>" . 
"</table>"; 
?>
		var spItem_view_panel_1 = {
			html : '<?php echo $spItem_html; ?>',
			frame : true,
			height: 80
		}
		var spItem_view_panel_2 = new Ext.TabPanel({
			activeTab: 0,
			anchor: '100%',
			height:190,
			plain:true,
			defaults:{autoScroll: true},
			items:[
						]
		});

		var SpItemViewWindow = new Ext.Window({
			title: '<?php __('View SpItem'); ?>: <?php echo $spItem['SpItem']['name']; ?>',
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
				spItem_view_panel_1,
				spItem_view_panel_2
			],

			buttons: [{
				text: '<?php __('Close'); ?>',
				handler: function(btn){
					SpItemViewWindow.close();
				}
			}]
		});
