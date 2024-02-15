
		
<?php $dmsGroupList_html = "<table cellspacing=3>" . 		"<tr><th align=right>" . __('User', true) . ":</th><td><b>" . $dmsGroupList['User']['id'] . "</b></td></tr>" . 
		"<tr><th align=right>" . __('Dms Group', true) . ":</th><td><b>" . $dmsGroupList['DmsGroup']['name'] . "</b></td></tr>" . 
"</table>"; 
?>
		var dmsGroupList_view_panel_1 = {
			html : '<?php echo $dmsGroupList_html; ?>',
			frame : true,
			height: 80
		}
		var dmsGroupList_view_panel_2 = new Ext.TabPanel({
			activeTab: 0,
			anchor: '100%',
			height:190,
			plain:true,
			defaults:{autoScroll: true},
			items:[
						]
		});

		var DmsGroupListViewWindow = new Ext.Window({
			title: '<?php __('View DmsGroupList'); ?>: <?php echo $dmsGroupList['DmsGroupList']['id']; ?>',
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
				dmsGroupList_view_panel_1,
				dmsGroupList_view_panel_2
			],

			buttons: [{
				text: '<?php __('Close'); ?>',
				handler: function(btn){
					DmsGroupListViewWindow.close();
				}
			}]
		});
