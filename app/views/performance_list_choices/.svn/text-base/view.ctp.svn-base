
var store_performanceListChoice_employeePerformanceResults = new Ext.data.Store({
	reader: new Ext.data.JsonReader({
		root:'rows',
		totalProperty: 'results',
		fields: [
			'id','employee','employee_performance','performance_list','performance_list_choice'		]
	}),
	proxy: new Ext.data.HttpProxy({
		url: '<?php echo $this->Html->url(array('controller' => 'employeePerformanceResults', 'action' => 'list_data', $performanceListChoice['PerformanceListChoice']['id'])); ?>'	})
});
		
<?php $performanceListChoice_html = "<table cellspacing=3>" . 		"<tr><th align=right>" . __('Name', true) . ":</th><td><b>" . $performanceListChoice['PerformanceListChoice']['name'] . "</b></td></tr>" . 
		"<tr><th align=right>" . __('Performance List', true) . ":</th><td><b>" . $performanceListChoice['PerformanceList']['name'] . "</b></td></tr>" . 
"</table>"; 
?>
		var performanceListChoice_view_panel_1 = {
			html : '<?php echo $performanceListChoice_html; ?>',
			frame : true,
			height: 80
		}
		var performanceListChoice_view_panel_2 = new Ext.TabPanel({
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
				store: store_performanceListChoice_employeePerformanceResults,
				title: '<?php __('EmployeePerformanceResults'); ?>',
				enableColumnMove: false,
				listeners: {
					activate: function(){
						if(store_performanceListChoice_employeePerformanceResults.getCount() == '')
							store_performanceListChoice_employeePerformanceResults.reload();
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
					store: store_performanceListChoice_employeePerformanceResults,
					displayInfo: true,
					displayMsg: '<?php __('Displaying'); ?> {0} - {1} <?php __('of'); ?> {2}',
					beforePageText: '<?php __('Page'); ?>',
					afterPageText: '<?php __('of'); ?> {0}',
					emptyMsg: '<?php __('No data to display'); ?>'
				})
			}			]
		});

		var PerformanceListChoiceViewWindow = new Ext.Window({
			title: '<?php __('View PerformanceListChoice'); ?>: <?php echo $performanceListChoice['PerformanceListChoice']['name']; ?>',
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
				performanceListChoice_view_panel_1,
				performanceListChoice_view_panel_2
			],

			buttons: [{
				text: '<?php __('Close'); ?>',
				handler: function(btn){
					PerformanceListChoiceViewWindow.close();
				}
			}]
		});
