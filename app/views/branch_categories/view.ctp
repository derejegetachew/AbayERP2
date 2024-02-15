
		
<?php $branchCategory_html = "<table cellspacing=3>" . 		"<tr><th align=right>" . __('Name', true) . ":</th><td><b>" . $branchCategory['BranchCategory']['name'] . "</b></td></tr>" . 
		"<tr><th align=right>" . __('Created', true) . ":</th><td><b>" . $branchCategory['BranchCategory']['created'] . "</b></td></tr>" . 
		"<tr><th align=right>" . __('Modified', true) . ":</th><td><b>" . $branchCategory['BranchCategory']['modified'] . "</b></td></tr>" . 
"</table>"; 
?>
		var branchCategory_view_panel_1 = {
			html : '<?php echo $branchCategory_html; ?>',
			frame : true,
			height: 80
		}
		var branchCategory_view_panel_2 = new Ext.TabPanel({
			activeTab: 0,
			anchor: '100%',
			height:190,
			plain:true,
			defaults:{autoScroll: true},
			items:[
						]
		});

		var BranchCategoryViewWindow = new Ext.Window({
			title: '<?php __('View BranchCategory'); ?>: <?php echo $branchCategory['BranchCategory']['name']; ?>',
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
				branchCategory_view_panel_1,
				branchCategory_view_panel_2
			],

			buttons: [{
				text: '<?php __('Close'); ?>',
				handler: function(btn){
					BranchCategoryViewWindow.close();
				}
			}]
		});
