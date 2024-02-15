
	
<?php $branchPerformanceSetting_html = "<table cellspacing=3>" . 		"<tr><th align=right>" . __('Position', true) . ":</th><td><b>" . $branchPerformanceSetting['Position']['name'] . "</b></td></tr>" . 
		"<tr><th align=right>" . __('Goal', true) . ":</th><td><b>" . $branchPerformanceSetting['BranchPerformanceSetting']['goal'] . "</b></td></tr>" . 
		"<tr><th align=right>" . __('Measure', true) . ":</th><td><b>" . $branchPerformanceSetting['BranchPerformanceSetting']['measure'] . "</b></td></tr>" . 
		"<tr><th align=right>" . __('Target', true) . ":</th><td><b>" . $branchPerformanceSetting['BranchPerformanceSetting']['target'] . "</b></td></tr>" . 
		"<tr><th align=right>" . __('Weight', true) . ":</th><td><b>" . $branchPerformanceSetting['BranchPerformanceSetting']['weight'] . "</b></td></tr>" . 
		"<tr><th align=right>" . __('Five Pointer Min', true) . ":</th><td><b>" . $branchPerformanceSetting['BranchPerformanceSetting']['five_pointer_min'] . "</b></td></tr>" . 
		"<tr><th align=right>" . __('Five Pointer Max Included', true) . ":</th><td><b>" . $branchPerformanceSetting['BranchPerformanceSetting']['five_pointer_max_included'] . "</b></td></tr>" . 
		"<tr><th align=right>" . __('Four Pointer Min', true) . ":</th><td><b>" . $branchPerformanceSetting['BranchPerformanceSetting']['four_pointer_min'] . "</b></td></tr>" . 
		"<tr><th align=right>" . __('Four Pointer Max Included', true) . ":</th><td><b>" . $branchPerformanceSetting['BranchPerformanceSetting']['four_pointer_max_included'] . "</b></td></tr>" . 
		"<tr><th align=right>" . __('Three Pointer Min', true) . ":</th><td><b>" . $branchPerformanceSetting['BranchPerformanceSetting']['three_pointer_min'] . "</b></td></tr>" . 
		"<tr><th align=right>" . __('Three Pointer Max Included', true) . ":</th><td><b>" . $branchPerformanceSetting['BranchPerformanceSetting']['three_pointer_max_included'] . "</b></td></tr>" . 
		"<tr><th align=right>" . __('Two Pointer Min', true) . ":</th><td><b>" . $branchPerformanceSetting['BranchPerformanceSetting']['two_pointer_min'] . "</b></td></tr>" . 
		"<tr><th align=right>" . __('Two Pointer Max Included', true) . ":</th><td><b>" . $branchPerformanceSetting['BranchPerformanceSetting']['two_pointer_max_included'] . "</b></td></tr>" . 
		"<tr><th align=right>" . __('One Pointer Min', true) . ":</th><td><b>" . $branchPerformanceSetting['BranchPerformanceSetting']['one_pointer_min'] . "</b></td></tr>" . 
		"<tr><th align=right>" . __('One Pointer Max Included', true) . ":</th><td><b>" . $branchPerformanceSetting['BranchPerformanceSetting']['one_pointer_max_included'] . "</b></td></tr>" . 
		
"</table>"; 
?>
		var branchPerformanceSetting_view_panel_1 = {
			html : '<?php echo $branchPerformanceSetting_html; ?>',
			frame : true,
			height: 180,
			autoScroll: true,
		}
		var branchPerformanceSetting_view_panel_2 = new Ext.TabPanel({
			activeTab: 0,
			anchor: '100%',
			height:190,
			plain:true,
			defaults:{autoScroll: true},
			items:[
						]
		});

		var BranchPerformanceSettingViewWindow = new Ext.Window({
			title: '<?php __('View BranchPerformanceSetting'); ?>: <?php echo $branchPerformanceSetting['BranchPerformanceSetting']['id']; ?>',
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
				branchPerformanceSetting_view_panel_1,
				branchPerformanceSetting_view_panel_2
			],

			buttons: [{
				text: '<?php __('Close'); ?>',
				handler: function(btn){
					BranchPerformanceSettingViewWindow.close();
				}
			}]
		});
