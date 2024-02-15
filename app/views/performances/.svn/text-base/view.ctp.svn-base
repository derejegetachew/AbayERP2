
var store_performance_employeePerformanceResults = new Ext.data.Store({
	reader: new Ext.data.JsonReader({
		root:'rows',
		totalProperty: 'results',
		fields: [
			'id','employee','employee_performance','performance_list','performance_list_choice'		]
	}),
	proxy: new Ext.data.HttpProxy({
		url: '<?php echo $this->Html->url(array('controller' => 'employeePerformanceResults', 'action' => 'list_data', $performance['Performance']['id'])); ?>'	})
});
var store_performance_performanceLists = new Ext.data.Store({
	reader: new Ext.data.JsonReader({
		root:'rows',
		totalProperty: 'results',
		fields: [
			'id','name','type','performance'		]
	}),
	proxy: new Ext.data.HttpProxy({
		url: '<?php echo $this->Html->url(array('controller' => 'performanceLists', 'action' => 'list_data', $performance['Performance']['id'])); ?>'	})
});
var store_performance_employees = new Ext.data.Store({
	reader: new Ext.data.JsonReader({
		root:'rows',
		totalProperty: 'results',
		fields: [
			'id','mother_name','emp_loc','city','kebele','woreda','house_no','p_o_box','telephone','marital_status','spouse_name','card','date_of_employment','terms_of_employment','photo','contact_name','contact_region','contact_city','contact_kebele','contact_house_no','contact_residence_tel','contact_office_tel','contact_mobile','contact_email','contact_p_o_box','user','created','modified'		]
	}),
	proxy: new Ext.data.HttpProxy({
		url: '<?php echo $this->Html->url(array('controller' => 'employees', 'action' => 'list_data', $performance['Performance']['id'])); ?>'	})
});
		
<?php $performance_html = "<table cellspacing=3>" . 		"<tr><th align=right>" . __('Name', true) . ":</th><td><b>" . $performance['Performance']['name'] . "</b></td></tr>" . 
		"<tr><th align=right>" . __('Status', true) . ":</th><td><b>" . $performance['Performance']['status'] . "</b></td></tr>" . 
"</table>"; 
?>
		var performance_view_panel_1 = {
			html : '<?php echo $performance_html; ?>',
			frame : true,
			height: 80
		}
		var performance_view_panel_2 = new Ext.TabPanel({
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
				store: store_performance_employeePerformanceResults,
				title: '<?php __('EmployeePerformanceResults'); ?>',
				enableColumnMove: false,
				listeners: {
					activate: function(){
						if(store_performance_employeePerformanceResults.getCount() == '')
							store_performance_employeePerformanceResults.reload();
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
					store: store_performance_employeePerformanceResults,
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
				store: store_performance_performanceLists,
				title: '<?php __('PerformanceLists'); ?>',
				enableColumnMove: false,
				listeners: {
					activate: function(){
						if(store_performance_performanceLists.getCount() == '')
							store_performance_performanceLists.reload();
					}
				},
				columns: [
					{header: "<?php __('Name'); ?>", dataIndex: 'name', sortable: true}
,					{header: "<?php __('Type'); ?>", dataIndex: 'type', sortable: true}
		
				],
				viewConfig: {
					forceFit: true
				},
				bbar: new Ext.PagingToolbar({
					pageSize: view_list_size,
					store: store_performance_performanceLists,
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
				store: store_performance_employees,
				title: '<?php __('Employees'); ?>',
				enableColumnMove: false,
				listeners: {
					activate: function(){
						if(store_performance_employees.getCount() == '')
							store_performance_employees.reload();
					}
				},
				columns: [
					{header: "<?php __('Mother Name'); ?>", dataIndex: 'mother_name', sortable: true}
,					{header: "<?php __('Emp Loc'); ?>", dataIndex: 'emp_loc', sortable: true}
,					{header: "<?php __('City'); ?>", dataIndex: 'city', sortable: true}
,					{header: "<?php __('Kebele'); ?>", dataIndex: 'kebele', sortable: true}
,					{header: "<?php __('Woreda'); ?>", dataIndex: 'woreda', sortable: true}
,					{header: "<?php __('House No'); ?>", dataIndex: 'house_no', sortable: true}
,					{header: "<?php __('P O Box'); ?>", dataIndex: 'p_o_box', sortable: true}
,					{header: "<?php __('Telephone'); ?>", dataIndex: 'telephone', sortable: true}
,					{header: "<?php __('Marital Status'); ?>", dataIndex: 'marital_status', sortable: true}
,					{header: "<?php __('Spouse Name'); ?>", dataIndex: 'spouse_name', sortable: true}
,					{header: "<?php __('Card'); ?>", dataIndex: 'card', sortable: true}
,					{header: "<?php __('Date Of Employment'); ?>", dataIndex: 'date_of_employment', sortable: true}
,					{header: "<?php __('Terms Of Employment'); ?>", dataIndex: 'terms_of_employment', sortable: true}
,					{header: "<?php __('Photo'); ?>", dataIndex: 'photo', sortable: true}
,					{header: "<?php __('Contact Name'); ?>", dataIndex: 'contact_name', sortable: true}
,					{header: "<?php __('Contact Region'); ?>", dataIndex: 'contact_region', sortable: true}
,					{header: "<?php __('Contact City'); ?>", dataIndex: 'contact_city', sortable: true}
,					{header: "<?php __('Contact Kebele'); ?>", dataIndex: 'contact_kebele', sortable: true}
,					{header: "<?php __('Contact House No'); ?>", dataIndex: 'contact_house_no', sortable: true}
,					{header: "<?php __('Contact Residence Tel'); ?>", dataIndex: 'contact_residence_tel', sortable: true}
,					{header: "<?php __('Contact Office Tel'); ?>", dataIndex: 'contact_office_tel', sortable: true}
,					{header: "<?php __('Contact Mobile'); ?>", dataIndex: 'contact_mobile', sortable: true}
,					{header: "<?php __('Contact Email'); ?>", dataIndex: 'contact_email', sortable: true}
,					{header: "<?php __('Contact P O Box'); ?>", dataIndex: 'contact_p_o_box', sortable: true}
,					{header: "<?php __('User'); ?>", dataIndex: 'user', sortable: true}
,					{header: "<?php __('Created'); ?>", dataIndex: 'created', sortable: true}
,					{header: "<?php __('Modified'); ?>", dataIndex: 'modified', sortable: true}
		
				],
				viewConfig: {
					forceFit: true
				},
				bbar: new Ext.PagingToolbar({
					pageSize: view_list_size,
					store: store_performance_employees,
					displayInfo: true,
					displayMsg: '<?php __('Displaying'); ?> {0} - {1} <?php __('of'); ?> {2}',
					beforePageText: '<?php __('Page'); ?>',
					afterPageText: '<?php __('of'); ?> {0}',
					emptyMsg: '<?php __('No data to display'); ?>'
				})
			}			]
		});

		var PerformanceViewWindow = new Ext.Window({
			title: '<?php __('View Performance'); ?>: <?php echo $performance['Performance']['name']; ?>',
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
				performance_view_panel_1,
				performance_view_panel_2
			],

			buttons: [{
				text: '<?php __('Close'); ?>',
				handler: function(btn){
					PerformanceViewWindow.close();
				}
			}]
		});
