
var store_branchEvaluationCriteria_branchPerformanceDetails = new Ext.data.Store({
	reader: new Ext.data.JsonReader({
		root:'rows',
		totalProperty: 'results',
		fields: [
			'id','branch_evaluation_criteria','plan_in_number','actual_result','accomplishment','rating','final_result','branch_performance_plan'		]
	}),
	proxy: new Ext.data.HttpProxy({
		url: '<?php echo $this->Html->url(array('controller' => 'branchPerformanceDetails', 'action' => 'list_data', $branchEvaluationCriteria['BranchEvaluationCriteria']['id'])); ?>'	})
});
<?php 
$direction = "";
$options['items'] = array(1 => "incremental", 2 => "decremental", 3 => "Error", 4 => "No of Complains", 5 => "Delay", 6 => "SDT(Standard Delivery Time)");
if($branchEvaluationCriteria['BranchEvaluationCriteria']['direction'] == 1){
	$direction = "Incremental";
}
if($branchEvaluationCriteria['BranchEvaluationCriteria']['direction'] == 2){
	$direction = "Decremental";
}
if($branchEvaluationCriteria['BranchEvaluationCriteria']['direction'] == 3){
	$direction = "Error";
}
if($branchEvaluationCriteria['BranchEvaluationCriteria']['direction'] == 4){
	$direction = "No of Complains";
}

if($branchEvaluationCriteria['BranchEvaluationCriteria']['direction'] == 5){
	$direction = "Delay";
}

if($branchEvaluationCriteria['BranchEvaluationCriteria']['direction'] == 6){
	$direction = "SDT(Standard Delivery Time)";
}



?>
		
<?php $branchEvaluationCriteria_html = "<table cellspacing=3>" . 		"<tr><th align=right>" . __('Goal', true) . ":</th><td><b>" . $branchEvaluationCriteria['BranchEvaluationCriteria']['goal'] . "</b></td></tr>" . 
		"<tr><th align=right>" . __('Measure', true) . ":</th><td><b>" . $branchEvaluationCriteria['BranchEvaluationCriteria']['measure'] . "</b></td></tr>" . 
		"<tr><th align=right>" . __('Target', true) . ":</th><td><b>" . $branchEvaluationCriteria['BranchEvaluationCriteria']['target'] . "</b></td></tr>" . 
		"<tr><th align=right>" . __('Weight', true) . ":</th><td><b>" . $branchEvaluationCriteria['BranchEvaluationCriteria']['weight'] . "</b></td></tr>" . 
		"<tr><th align=right>" . __('Direction', true) . ":</th><td><b>" .$direction. "</b></td></tr>" . 
		
"</table>"; 
?>
		var branchEvaluationCriteria_view_panel_1 = {
			html : '<?php echo $branchEvaluationCriteria_html; ?>',
			frame : true,
			height: 80
		}
		var branchEvaluationCriteria_view_panel_2 = new Ext.TabPanel({
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
				store: store_branchEvaluationCriteria_branchPerformanceDetails,
				title: '<?php __('BranchPerformanceDetails'); ?>',
				enableColumnMove: false,
				listeners: {
					activate: function(){
						if(store_branchEvaluationCriteria_branchPerformanceDetails.getCount() == '')
							store_branchEvaluationCriteria_branchPerformanceDetails.reload();
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
					store: store_branchEvaluationCriteria_branchPerformanceDetails,
					displayInfo: true,
					displayMsg: '<?php __('Displaying'); ?> {0} - {1} <?php __('of'); ?> {2}',
					beforePageText: '<?php __('Page'); ?>',
					afterPageText: '<?php __('of'); ?> {0}',
					emptyMsg: '<?php __('No data to display'); ?>'
				})
			}			]
		});

		var BranchEvaluationCriteriaViewWindow = new Ext.Window({
			title: '<?php __('View BranchEvaluationCriteria'); ?>: <?php echo $branchEvaluationCriteria['BranchEvaluationCriteria']['id']; ?>',
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
				branchEvaluationCriteria_view_panel_1,
				branchEvaluationCriteria_view_panel_2
			],

			buttons: [{
				text: '<?php __('Close'); ?>',
				handler: function(btn){
					BranchEvaluationCriteriaViewWindow.close();
				}
			}]
		});
