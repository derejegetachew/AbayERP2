
var store_branchPerformancePlan_branchPerformanceDetails = new Ext.data.Store({
	reader: new Ext.data.JsonReader({
		root:'rows',
		totalProperty: 'results',
		fields: [
			'id','branch_evaluation_criteria','plan_in_number','actual_result','accomplishment','rating','final_result','branch_performance_plan'		]
	}),
	proxy: new Ext.data.HttpProxy({
		url: '<?php echo $this->Html->url(array('controller' => 'branchPerformanceDetails', 'action' => 'list_data', $branchPerformancePlan['BranchPerformancePlan']['id'])); ?>'	})
});
		
<?php $branchPerformancePlan_html = "<table cellspacing=3>" . 		"<tr><th align=right>" . __('Branch', true) . ":</th><td><b>" . $branchPerformancePlan['Branch']['name'] . "</b></td></tr>" . 
		"<tr><th align=right>" . __('Budget Year', true) . ":</th><td><b>" . $branchPerformancePlan['BudgetYear']['name'] . "</b></td></tr>" . 
		"<tr><th align=right>" . __('Quarter', true) . ":</th><td><b>" . $branchPerformancePlan['BranchPerformancePlan']['quarter'] . "</b></td></tr>" . 
		"<tr><th align=right>" . __('Result', true) . ":</th><td><b>" . $branchPerformancePlan['BranchPerformancePlan']['result'] . "</b></td></tr>" . 
		"<tr><th align=right>" . __('Plan Status', true) . ":</th><td><b>" . $branchPerformancePlan['BranchPerformancePlan']['plan_status'] . "</b></td></tr>" . 
		"<tr><th align=right>" . __('Result Status', true) . ":</th><td><b>" . $branchPerformancePlan['BranchPerformancePlan']['result_status'] . "</b></td></tr>" . 
		"<tr><th align=right>" . __('Comment', true) . ":</th><td><b>" . $branchPerformancePlan['BranchPerformancePlan']['comment'] . "</b></td></tr>" . 
"</table>"; 
?>
		var branchPerformancePlan_view_panel_1 = {
			html : '<?php echo $branchPerformancePlan_html; ?>',
			frame : true,
			height: 80
		}
		var branchPerformancePlan_view_panel_2 = new Ext.TabPanel({
			activeTab: 0,
			anchor: '100%',
			height:190,
			plain:true,
			defaults:{autoScroll: true},
			items:[
			{
				xtype: 'grid',
				loadMask: true,
				stripeRows: true,
				store: store_branchPerformancePlan_branchPerformanceDetails,
				title: '<?php __('BranchPerformanceDetails'); ?>',
				enableColumnMove: false,
				listeners: {
					activate: function(){
						if(store_branchPerformancePlan_branchPerformanceDetails.getCount() == '')
							store_branchPerformancePlan_branchPerformanceDetails.reload();
					}
				},
				columns: [
					{header: "<?php __('Branch Evaluation Criteria'); ?>", dataIndex: 'branch_evaluation_criteria', sortable: true}
,					{header: "<?php __('Plan In Number'); ?>", dataIndex: 'plan_in_number', sortable: true}
,					{header: "<?php __('Actual Result'); ?>", dataIndex: 'actual_result', sortable: true}
,					{header: "<?php __('Accomplishment'); ?>", dataIndex: 'accomplishment', sortable: true}
,					{header: "<?php __('Rating'); ?>", dataIndex: 'rating', sortable: true}
,					{header: "<?php __('Final Result'); ?>", dataIndex: 'final_result', sortable: true}
,					{header: "<?php __('Branch Performance Plan'); ?>", dataIndex: 'branch_performance_plan', sortable: true}
		
				],
				viewConfig: {
					forceFit: true
				},
				bbar: new Ext.PagingToolbar({
					pageSize: view_list_size,
					store: store_branchPerformancePlan_branchPerformanceDetails,
					displayInfo: true,
					displayMsg: '<?php __('Displaying'); ?> {0} - {1} <?php __('of'); ?> {2}',
					beforePageText: '<?php __('Page'); ?>',
					afterPageText: '<?php __('of'); ?> {0}',
					emptyMsg: '<?php __('No data to display'); ?>'
				})
			}			]
		});

		var BranchPerformancePlanViewWindow = new Ext.Window({
			title: '<?php __('View BranchPerformancePlan'); ?>: <?php echo $branchPerformancePlan['BranchPerformancePlan']['id']; ?>',
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
				branchPerformancePlan_view_panel_1,
				branchPerformancePlan_view_panel_2
			],

			buttons: [{
				text: '<?php __('Close'); ?>',
				handler: function(btn){
					BranchPerformancePlanViewWindow.close();
				}
			}]
		});
