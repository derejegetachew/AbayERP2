
var store_payroll_benefits = new Ext.data.Store({
	reader: new Ext.data.JsonReader({
		root:'rows',
		totalProperty: 'results',
		fields: [
			'id','name','Measurement','amount','apply_to','employee','grade','start_date','end_date','payroll'		]
	}),
	proxy: new Ext.data.HttpProxy({
		url: '<?php echo $this->Html->url(array('controller' => 'benefits', 'action' => 'list_data', $payroll['Payroll']['id'])); ?>'	})
});
var store_payroll_deductions = new Ext.data.Store({
	reader: new Ext.data.JsonReader({
		root:'rows',
		totalProperty: 'results',
		fields: [
			'id','name','Measurement','amount','apply_to','employee','grade','start_date','end_date','payroll'		]
	}),
	proxy: new Ext.data.HttpProxy({
		url: '<?php echo $this->Html->url(array('controller' => 'deductions', 'action' => 'list_data', $payroll['Payroll']['id'])); ?>'	})
});
var store_payroll_payrollEmployees = new Ext.data.Store({
	reader: new Ext.data.JsonReader({
		root:'rows',
		totalProperty: 'results',
		fields: [
			'id','payroll','employee','status'		]
	}),
	proxy: new Ext.data.HttpProxy({
		url: '<?php echo $this->Html->url(array('controller' => 'payrollEmployees', 'action' => 'list_data', $payroll['Payroll']['id'])); ?>'	})
});
var store_payroll_pensions = new Ext.data.Store({
	reader: new Ext.data.JsonReader({
		root:'rows',
		totalProperty: 'results',
		fields: [
			'id','name','pf_staff','pf_company','pen_staff','pen_company','payroll'		]
	}),
	proxy: new Ext.data.HttpProxy({
		url: '<?php echo $this->Html->url(array('controller' => 'pensions', 'action' => 'list_data', $payroll['Payroll']['id'])); ?>'	})
});
var store_payroll_prices = new Ext.data.Store({
	reader: new Ext.data.JsonReader({
		root:'rows',
		totalProperty: 'results',
		fields: [
			'id','gas','date','payroll'		]
	}),
	proxy: new Ext.data.HttpProxy({
		url: '<?php echo $this->Html->url(array('controller' => 'prices', 'action' => 'list_data', $payroll['Payroll']['id'])); ?>'	})
});
var store_payroll_taxRules = new Ext.data.Store({
	reader: new Ext.data.JsonReader({
		root:'rows',
		totalProperty: 'results',
		fields: [
			'id','name','min','max','percent','payroll'		]
	}),
	proxy: new Ext.data.HttpProxy({
		url: '<?php echo $this->Html->url(array('controller' => 'taxRules', 'action' => 'list_data', $payroll['Payroll']['id'])); ?>'	})
});
var store_payroll_users = new Ext.data.Store({
	reader: new Ext.data.JsonReader({
		root:'rows',
		totalProperty: 'results',
		fields: [
			'id','username','password','email','is_active','security_question','security_answer','person','branch','payroll','created','modified'		]
	}),
	proxy: new Ext.data.HttpProxy({
		url: '<?php echo $this->Html->url(array('controller' => 'users', 'action' => 'list_data', $payroll['Payroll']['id'])); ?>'	})
});
		
<?php $payroll_html = "<table cellspacing=3>" . 		"<tr><th align=right>" . __('Name', true) . ":</th><td><b>" . $payroll['Payroll']['name'] . "</b></td></tr>" . 
"</table>"; 
?>
		var payroll_view_panel_1 = {
			html : '<?php echo $payroll_html; ?>',
			frame : true,
			height: 80
		}
		var payroll_view_panel_2 = new Ext.TabPanel({
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
				store: store_payroll_benefits,
				title: '<?php __('Benefits'); ?>',
				enableColumnMove: false,
				listeners: {
					activate: function(){
						if(store_payroll_benefits.getCount() == '')
							store_payroll_benefits.reload();
					}
				},
				columns: [
					{header: "<?php __('Name'); ?>", dataIndex: 'name', sortable: true}
,					{header: "<?php __('Measurement'); ?>", dataIndex: 'Measurement', sortable: true}
,					{header: "<?php __('Amount'); ?>", dataIndex: 'amount', sortable: true}
,					{header: "<?php __('Apply To'); ?>", dataIndex: 'apply_to', sortable: true}
,					{header: "<?php __('Employee'); ?>", dataIndex: 'employee', sortable: true}
,					{header: "<?php __('Grade'); ?>", dataIndex: 'grade', sortable: true}
,					{header: "<?php __('Start Date'); ?>", dataIndex: 'start_date', sortable: true}
,					{header: "<?php __('End Date'); ?>", dataIndex: 'end_date', sortable: true}
		
				],
				viewConfig: {
					forceFit: true
				},
				bbar: new Ext.PagingToolbar({
					pageSize: view_list_size,
					store: store_payroll_benefits,
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
				store: store_payroll_deductions,
				title: '<?php __('Deductions'); ?>',
				enableColumnMove: false,
				listeners: {
					activate: function(){
						if(store_payroll_deductions.getCount() == '')
							store_payroll_deductions.reload();
					}
				},
				columns: [
					{header: "<?php __('Name'); ?>", dataIndex: 'name', sortable: true}
,					{header: "<?php __('Measurement'); ?>", dataIndex: 'Measurement', sortable: true}
,					{header: "<?php __('Amount'); ?>", dataIndex: 'amount', sortable: true}
,					{header: "<?php __('Apply To'); ?>", dataIndex: 'apply_to', sortable: true}
,					{header: "<?php __('Employee'); ?>", dataIndex: 'employee', sortable: true}
,					{header: "<?php __('Grade'); ?>", dataIndex: 'grade', sortable: true}
,					{header: "<?php __('Start Date'); ?>", dataIndex: 'start_date', sortable: true}
,					{header: "<?php __('End Date'); ?>", dataIndex: 'end_date', sortable: true}
		
				],
				viewConfig: {
					forceFit: true
				},
				bbar: new Ext.PagingToolbar({
					pageSize: view_list_size,
					store: store_payroll_deductions,
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
				store: store_payroll_payrollEmployees,
				title: '<?php __('PayrollEmployees'); ?>',
				enableColumnMove: false,
				listeners: {
					activate: function(){
						if(store_payroll_payrollEmployees.getCount() == '')
							store_payroll_payrollEmployees.reload();
					}
				},
				columns: [
					{header: "<?php __('Employee'); ?>", dataIndex: 'employee', sortable: true}
,					{header: "<?php __('Status'); ?>", dataIndex: 'status', sortable: true}
		
				],
				viewConfig: {
					forceFit: true
				},
				bbar: new Ext.PagingToolbar({
					pageSize: view_list_size,
					store: store_payroll_payrollEmployees,
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
				store: store_payroll_pensions,
				title: '<?php __('Pensions'); ?>',
				enableColumnMove: false,
				listeners: {
					activate: function(){
						if(store_payroll_pensions.getCount() == '')
							store_payroll_pensions.reload();
					}
				},
				columns: [
					{header: "<?php __('Name'); ?>", dataIndex: 'name', sortable: true}
,					{header: "<?php __('Pf Staff'); ?>", dataIndex: 'pf_staff', sortable: true}
,					{header: "<?php __('Pf Company'); ?>", dataIndex: 'pf_company', sortable: true}
,					{header: "<?php __('Pen Staff'); ?>", dataIndex: 'pen_staff', sortable: true}
,					{header: "<?php __('Pen Company'); ?>", dataIndex: 'pen_company', sortable: true}
		
				],
				viewConfig: {
					forceFit: true
				},
				bbar: new Ext.PagingToolbar({
					pageSize: view_list_size,
					store: store_payroll_pensions,
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
				store: store_payroll_prices,
				title: '<?php __('Prices'); ?>',
				enableColumnMove: false,
				listeners: {
					activate: function(){
						if(store_payroll_prices.getCount() == '')
							store_payroll_prices.reload();
					}
				},
				columns: [
					{header: "<?php __('Gas'); ?>", dataIndex: 'gas', sortable: true}
,					{header: "<?php __('Date'); ?>", dataIndex: 'date', sortable: true}
		
				],
				viewConfig: {
					forceFit: true
				},
				bbar: new Ext.PagingToolbar({
					pageSize: view_list_size,
					store: store_payroll_prices,
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
				store: store_payroll_taxRules,
				title: '<?php __('TaxRules'); ?>',
				enableColumnMove: false,
				listeners: {
					activate: function(){
						if(store_payroll_taxRules.getCount() == '')
							store_payroll_taxRules.reload();
					}
				},
				columns: [
					{header: "<?php __('Name'); ?>", dataIndex: 'name', sortable: true}
,					{header: "<?php __('Min'); ?>", dataIndex: 'min', sortable: true}
,					{header: "<?php __('Max'); ?>", dataIndex: 'max', sortable: true}
,					{header: "<?php __('Percent'); ?>", dataIndex: 'percent', sortable: true}
		
				],
				viewConfig: {
					forceFit: true
				},
				bbar: new Ext.PagingToolbar({
					pageSize: view_list_size,
					store: store_payroll_taxRules,
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
				store: store_payroll_users,
				title: '<?php __('Users'); ?>',
				enableColumnMove: false,
				listeners: {
					activate: function(){
						if(store_payroll_users.getCount() == '')
							store_payroll_users.reload();
					}
				},
				columns: [
					{header: "<?php __('Username'); ?>", dataIndex: 'username', sortable: true}
,					{header: "<?php __('Password'); ?>", dataIndex: 'password', sortable: true}
,					{header: "<?php __('Email'); ?>", dataIndex: 'email', sortable: true}
,					{header: "<?php __('Is Active'); ?>", dataIndex: 'is_active', sortable: true}
,					{header: "<?php __('Security Question'); ?>", dataIndex: 'security_question', sortable: true}
,					{header: "<?php __('Security Answer'); ?>", dataIndex: 'security_answer', sortable: true}
,					{header: "<?php __('Person'); ?>", dataIndex: 'person', sortable: true}
,					{header: "<?php __('Branch'); ?>", dataIndex: 'branch', sortable: true}
,					{header: "<?php __('Created'); ?>", dataIndex: 'created', sortable: true}
,					{header: "<?php __('Modified'); ?>", dataIndex: 'modified', sortable: true}
		
				],
				viewConfig: {
					forceFit: true
				},
				bbar: new Ext.PagingToolbar({
					pageSize: view_list_size,
					store: store_payroll_users,
					displayInfo: true,
					displayMsg: '<?php __('Displaying'); ?> {0} - {1} <?php __('of'); ?> {2}',
					beforePageText: '<?php __('Page'); ?>',
					afterPageText: '<?php __('of'); ?> {0}',
					emptyMsg: '<?php __('No data to display'); ?>'
				})
			}			]
		});

		var PayrollViewWindow = new Ext.Window({
			title: '<?php __('View Payroll'); ?>: <?php echo $payroll['Payroll']['name']; ?>',
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
				payroll_view_panel_1,
				payroll_view_panel_2
			],

			buttons: [{
				text: '<?php __('Close'); ?>',
				handler: function(btn){
					PayrollViewWindow.close();
				}
			}]
		});
