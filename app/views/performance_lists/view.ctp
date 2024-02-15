
var store_performanceList_employeePerformanceResults = new Ext.data.Store({
	reader: new Ext.data.JsonReader({
		root:'rows',
		totalProperty: 'results',
		fields: [
			'id','employee','employee_performance','performance_list','performance_list_choice'		]
	}),
	proxy: new Ext.data.HttpProxy({
		url: '<?php echo $this->Html->url(array('controller' => 'employeePerformanceResults', 'action' => 'list_data', $performanceList['PerformanceList']['id'])); ?>'	})
});
var store_performanceList_performanceListChoices = new Ext.data.Store({
	reader: new Ext.data.JsonReader({
		root:'rows',
		totalProperty: 'results',
		fields: [
			'id','name','performance_list'		]
	}),
	proxy: new Ext.data.HttpProxy({
		url: '<?php echo $this->Html->url(array('controller' => 'performanceListChoices', 'action' => 'list_data', $performanceList['PerformanceList']['id'])); ?>'	})
});
		
<?php $performanceList_html = "<table cellspacing=3>" . 		"<tr><th align=right>" . __('Name', true) . ":</th><td><b>" . $performanceList['PerformanceList']['name'] . "</b></td></tr>" . 
		"<tr><th align=right>" . __('Type', true) . ":</th><td><b>" . $performanceList['PerformanceList']['type'] . "</b></td></tr>" . 
		"<tr><th align=right>" . __('Performance', true) . ":</th><td><b>" . $performanceList['Performance']['name'] . "</b></td></tr>" . 
"</table>"; 
?>
		var performanceList_view_panel_1 = {
			html : '<?php echo $performanceList_html; ?>',
			frame : true,
			height: 80
		}
		var performanceList_view_panel_2 = new Ext.TabPanel({
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
				store: store_performanceList_employeePerformanceResults,
				title: '<?php __('EmployeePerformanceResults'); ?>',
				enableColumnMove: false,
				listeners: {
					activate: function(){
						if(store_performanceList_employeePerformanceResults.getCount() == '')
							store_performanceList_employeePerformanceResults.reload();
					}
				},
				columns: [
					{header: "<?php __('Employee'); ?>", dataIndex: 'employee', sortable: true}
,					{header: "<?php __('Employee Performance'); ?>", dataIndex: 'employee_performance', sortable: true}
,					{header: "<?php __('Performance List'); ?>", dataIndex: 'performance_list', sortable: true}
,					{header: "<?php __('Performance List Choice'); ?>", dataIndex: 'performance_list_choice', sortable: true}
		
				],
				viewConfig: {
					forceFit: true
				},
				bbar: new Ext.PagingToolbar({
					pageSize: view_list_size,
					store: store_performanceList_employeePerformanceResults,
					displayInfo: true,
					displayMsg: '<?php __('Displaying'); ?> {0} - {1} <?php __('of'); ?> {2}',
					beforePageText: '<?php __('Page'); ?>',
					afterPageText: '<?php __('of'); ?> {0}',
					emptyMsg: '<?php __('No data to display'); ?>'
				})
			},
{
				xtype: 'grid',
				loadMask: true,
				stripeRows: true,
				store: store_performanceList_performanceListChoices,
				title: '<?php __('PerformanceListChoices'); ?>',
				enableColumnMove: false,
				listeners: {
					activate: function(){
						if(store_performanceList_performanceListChoices.getCount() == '')
							store_performanceList_performanceListChoices.reload();
					}
				},
				columns: [
					{header: "<?php __('Name'); ?>", dataIndex: 'name', sortable: true}
,					{header: "<?php __('Performance List'); ?>", dataIndex: 'performance_list', sortable: true}
		
				],
				viewConfig: {
					forceFit: true
				},
				bbar: new Ext.PagingToolbar({
					pageSize: view_list_size,
					store: store_performanceList_performanceListChoices,
					displayInfo: true,
					displayMsg: '<?php __('Displaying'); ?> {0} - {1} <?php __('of'); ?> {2}',
					beforePageText: '<?php __('Page'); ?>',
					afterPageText: '<?php __('of'); ?> {0}',
					emptyMsg: '<?php __('No data to display'); ?>'
				})
			}			]
		});

		var PerformanceListViewWindow = new Ext.Window({
			title: '<?php __('View PerformanceList'); ?>: <?php echo $performanceList['PerformanceList']['name']; ?>',
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
				performanceList_view_panel_1,
				performanceList_view_panel_2
			],

			buttons: [{
				text: '<?php __('Close'); ?>',
				handler: function(btn){
					PerformanceListViewWindow.close();
				}
			}]
		});
