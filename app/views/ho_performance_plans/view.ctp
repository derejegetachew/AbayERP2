
var store_hoPerformancePlan_hoPerformanceDetails = new Ext.data.Store({
	reader: new Ext.data.JsonReader({
		root:'rows',
		totalProperty: 'results',
		fields: [
			'id','objective','perspective','plan_description','plan_in_number','actual_result','measure','weight','accomplishment','total_score','final_score',
				]
	}),
	proxy: new Ext.data.HttpProxy({
		url: '<?php echo $this->Html->url(array('controller' => 'hoPerformanceDetails', 'action' => 'list_data', $hoPerformancePlan['HoPerformancePlan']['id'])); ?>'	})
});
		
<?php $hoPerformancePlan_html = "<table cellspacing=3>" . 		"<tr><th align=right>" . __('Name', true) . ":</th><td><b>" . $hoPerformancePlan['HoPerformancePlan']['name'] . "</b></td></tr>" . 
		"<tr><th align=right>" . __('Budget Year', true) . ":</th><td><b>" . $hoPerformancePlan['BudgetYear']['name'] . "</b></td></tr>" . 
		"<tr><th align=right>" . __('Employee', true) . ":</th><td><b>" . $hoPerformancePlan['Employee']['id'] . "</b></td></tr>" . 
		"<tr><th align=right>" . __('Quarter', true) . ":</th><td><b>" . $hoPerformancePlan['HoPerformancePlan']['quarter'] . "</b></td></tr>" . 
		"<tr><th align=right>" . __('Agreed', true) . ":</th><td><b>" . $hoPerformancePlan['HoPerformancePlan']['agreed'] . "</b></td></tr>" . 
		"<tr><th align=right>" . __('Comment', true) . ":</th><td><b>" . $hoPerformancePlan['HoPerformancePlan']['comment'] . "</b></td></tr>" . 
"</table>"; 
?>
		var hoPerformancePlan_view_panel_1 = {
			html : '<?php echo $hoPerformancePlan_html; ?>',
			frame : true,
			height: 80
		}
		var hoPerformancePlan_view_panel_2 = new Ext.TabPanel({
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
				store: store_hoPerformancePlan_hoPerformanceDetails,
				title: '<?php __('HoPerformanceDetails'); ?>',
				enableColumnMove: false,
				listeners: {
					activate: function(){
						if(store_hoPerformancePlan_hoPerformanceDetails.getCount() == '')
							store_hoPerformancePlan_hoPerformanceDetails.reload();
					}
				},
				columns: [
					{header: "<?php __('Objective'); ?>", dataIndex: 'objective', sortable: true}
,					{header: "<?php __('Perspective'); ?>", dataIndex: 'perspective', sortable: true}
,					{header: "<?php __('Plan Description'); ?>", dataIndex: 'plan_description', sortable: true}
,					{header: "<?php __('Plan In Number'); ?>", dataIndex: 'plan_in_number', sortable: true}
,					{header: "<?php __('Actual Result'); ?>", dataIndex: 'actual_result', sortable: true}
,					{header: "<?php __('Measure'); ?>", dataIndex: 'measure', sortable: true}
,					{header: "<?php __('Weight'); ?>", dataIndex: 'weight', sortable: true}
,					{header: "<?php __('Accomplishment'); ?>", dataIndex: 'accomplishment', sortable: true}
,					{header: "<?php __('Total Score'); ?>", dataIndex: 'total_score', sortable: true}
,					{header: "<?php __('Final Score'); ?>", dataIndex: 'final_score', sortable: true}
,					
		
				],
				viewConfig: {
					forceFit: true
				},
				bbar: new Ext.PagingToolbar({
					pageSize: view_list_size,
					store: store_hoPerformancePlan_hoPerformanceDetails,
					displayInfo: true,
					displayMsg: '<?php __('Displaying'); ?> {0} - {1} <?php __('of'); ?> {2}',
					beforePageText: '<?php __('Page'); ?>',
					afterPageText: '<?php __('of'); ?> {0}',
					emptyMsg: '<?php __('No data to display'); ?>'
				})
			}			]
		});

		var HoPerformancePlanViewWindow = new Ext.Window({
			title: '<?php __('View HoPerformancePlan'); ?>: <?php echo $hoPerformancePlan['HoPerformancePlan']['name']; ?>',
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
				hoPerformancePlan_view_panel_1,
				hoPerformancePlan_view_panel_2
			],

			buttons: [{
				text: '<?php __('Close'); ?>',
				handler: function(btn){
					HoPerformancePlanViewWindow.close();
				}
			}]
		});
