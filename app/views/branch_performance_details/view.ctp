
		
<?php $branchPerformanceDetail_html = "<table cellspacing=3>" . 		"<tr><th align=right>" . __('Branch Evaluation Criteria', true) . ":</th><td><b>" . $all_criterias[$branchPerformanceDetail['BranchEvaluationCriteria']['id']] . "</b></td></tr>" . 
		"<tr><th align=right>" . __('Plan In Number', true) . ":</th><td><b>" . $branchPerformanceDetail['BranchPerformanceDetail']['plan_in_number'] . "</b></td></tr>" . 
		"<tr><th align=right>" . __('Actual Result', true) . ":</th><td><b>" . $branchPerformanceDetail['BranchPerformanceDetail']['actual_result'] . "</b></td></tr>" . 
		"<tr><th align=right>" . __('Accomplishment', true) . ":</th><td><b>" . $branchPerformanceDetail['BranchPerformanceDetail']['accomplishment'] . "</b></td></tr>" . 
		"<tr><th align=right>" . __('Rating', true) . ":</th><td><b>" . $branchPerformanceDetail['BranchPerformanceDetail']['rating'] . "</b></td></tr>" . 
		"<tr><th align=right>" . __('Final Result', true) . ":</th><td><b>" . $branchPerformanceDetail['BranchPerformanceDetail']['final_result'] . "</b></td></tr>" . 
		"<tr><th align=right>" . __('Branch Performance Plan', true) . ":</th><td><b>" . $branchPerformanceDetail['BranchPerformancePlan']['id'] . "</b></td></tr>" . 
"</table>"; 
?>
		var branchPerformanceDetail_view_panel_1 = {
			html : '<?php echo $branchPerformanceDetail_html; ?>',
			frame : true,
			autoScroll: true,
			height: 180
		}
		var branchPerformanceDetail_view_panel_2 = new Ext.TabPanel({
			activeTab: 0,
			anchor: '100%',
			height:190,
			plain:true,
			autoScroll: true,
			defaults:{autoScroll: true},
			items:[
						]
		});

		var BranchPerformanceDetailViewWindow = new Ext.Window({
			title: '<?php __('View BranchPerformanceDetail'); ?>: <?php echo $branchPerformanceDetail['BranchPerformanceDetail']['id']; ?>',
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
				branchPerformanceDetail_view_panel_1,
				branchPerformanceDetail_view_panel_2
			],

			buttons: [{
				text: '<?php __('Close'); ?>',
				handler: function(btn){
					BranchPerformanceDetailViewWindow.close();
				}
			}]
		});
