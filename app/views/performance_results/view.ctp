
var store_performanceResult_employees = new Ext.data.Store({
	reader: new Ext.data.JsonReader({
		root:'rows',
		totalProperty: 'results',
		fields: [
			'id','mother_name','emp_loc','city','kebele','woreda','house_no','p_o_box','telephone','marital_status','spouse_name','card','date_of_employment','terms_of_employment','photo','contact_name','contact_region','contact_city','contact_kebele','contact_house_no','contact_residence_tel','contact_office_tel','contact_mobile','contact_email','contact_p_o_box','user','created','modified','status','trial'		]
	}),
	proxy: new Ext.data.HttpProxy({
		url: '<?php echo $this->Html->url(array('controller' => 'employees', 'action' => 'list_data', $performanceResult['PerformanceResult']['id'])); ?>'	})
});
		
<?php $performanceResult_html = "<table cellspacing=3>" . 		"<tr><th align=right>" . __('Employee', true) . ":</th><td><b>" . $performanceResult['Employee']['id'] . "</b></td></tr>" . 
		"<tr><th align=right>" . __('Budget Year', true) . ":</th><td><b>" . $performanceResult['BudgetYear']['name'] . "</b></td></tr>" . 
		"<tr><th align=right>" . __('First', true) . ":</th><td><b>" . $performanceResult['PerformanceResult']['first'] . "</b></td></tr>" . 
		"<tr><th align=right>" . __('Second', true) . ":</th><td><b>" . $performanceResult['PerformanceResult']['second'] . "</b></td></tr>" . 
		"<tr><th align=right>" . __('Average', true) . ":</th><td><b>" . $performanceResult['PerformanceResult']['average'] . "</b></td></tr>" . 
		"<tr><th align=right>" . __('Created', true) . ":</th><td><b>" . $performanceResult['PerformanceResult']['created'] . "</b></td></tr>" . 
		"<tr><th align=right>" . __('Modified', true) . ":</th><td><b>" . $performanceResult['PerformanceResult']['modified'] . "</b></td></tr>" . 
"</table>"; 
?>
		var performanceResult_view_panel_1 = {
			html : '<?php echo $performanceResult_html; ?>',
			frame : true,
			height: 80
		}
		var performanceResult_view_panel_2 = new Ext.TabPanel({
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
				store: store_performanceResult_employees,
				title: '<?php __('Employees'); ?>',
				enableColumnMove: false,
				listeners: {
					activate: function(){
						if(store_performanceResult_employees.getCount() == '')
							store_performanceResult_employees.reload();
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
,					{header: "<?php __('Status'); ?>", dataIndex: 'status', sortable: true}
,					{header: "<?php __('Trial'); ?>", dataIndex: 'trial', sortable: true}
		
				],
				viewConfig: {
					forceFit: true
				},
				bbar: new Ext.PagingToolbar({
					pageSize: view_list_size,
					store: store_performanceResult_employees,
					displayInfo: true,
					displayMsg: '<?php __('Displaying'); ?> {0} - {1} <?php __('of'); ?> {2}',
					beforePageText: '<?php __('Page'); ?>',
					afterPageText: '<?php __('of'); ?> {0}',
					emptyMsg: '<?php __('No data to display'); ?>'
				})
			}			]
		});

		var PerformanceResultViewWindow = new Ext.Window({
			title: '<?php __('View PerformanceResult'); ?>: <?php echo $performanceResult['PerformanceResult']['id']; ?>',
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
				performanceResult_view_panel_1,
				performanceResult_view_panel_2
			],

			buttons: [{
				text: '<?php __('Close'); ?>',
				handler: function(btn){
					PerformanceResultViewWindow.close();
				}
			}]
		});
