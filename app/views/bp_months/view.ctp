
var store_bpMonth_bpActuals = new Ext.data.Store({
	reader: new Ext.data.JsonReader({
		root:'rows',
		totalProperty: 'results',
		fields: [
			'id','amount','bp_month','branch','bp_item','accont_no','bp_plan','remark','type','bp_actual_detail','created','modified'		]
	}),
	proxy: new Ext.data.HttpProxy({
		url: '<?php echo $this->Html->url(array('controller' => 'bpActuals', 'action' => 'list_data', $bpMonth['BpMonth']['id'])); ?>'	})
});
var store_bpMonth_bpPlans = new Ext.data.Store({
	reader: new Ext.data.JsonReader({
		root:'rows',
		totalProperty: 'results',
		fields: [
			'id','branch','bp_month','amount','bp_item','budget_year','status','created','modified'		]
	}),
	proxy: new Ext.data.HttpProxy({
		url: '<?php echo $this->Html->url(array('controller' => 'bpPlans', 'action' => 'list_data', $bpMonth['BpMonth']['id'])); ?>'	})
});
		
<?php $bpMonth_html = "<table cellspacing=3>" . 		"<tr><th align=right>" . __('Name', true) . ":</th><td><b>" . $bpMonth['BpMonth']['name'] . "</b></td></tr>" . 
"</table>"; 
?>
		var bpMonth_view_panel_1 = {
			html : '<?php echo $bpMonth_html; ?>',
			frame : true,
			height: 80
		}
		var bpMonth_view_panel_2 = new Ext.TabPanel({
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
				store: store_bpMonth_bpActuals,
				title: '<?php __('BpActuals'); ?>',
				enableColumnMove: false,
				listeners: {
					activate: function(){
						if(store_bpMonth_bpActuals.getCount() == '')
							store_bpMonth_bpActuals.reload();
					}
				},
				columns: [
					{header: "<?php __('Amount'); ?>", dataIndex: 'amount', sortable: true}
,					{header: "<?php __('Bp Month'); ?>", dataIndex: 'bp_month', sortable: true}
,					{header: "<?php __('Branch'); ?>", dataIndex: 'branch', sortable: true}
,					{header: "<?php __('Bp Item'); ?>", dataIndex: 'bp_item', sortable: true}
,					{header: "<?php __('Accont No'); ?>", dataIndex: 'accont_no', sortable: true}
,					{header: "<?php __('Bp Plan'); ?>", dataIndex: 'bp_plan', sortable: true}
,					{header: "<?php __('Remark'); ?>", dataIndex: 'remark', sortable: true}
,					{header: "<?php __('Type'); ?>", dataIndex: 'type', sortable: true}
,					{header: "<?php __('Bp Actual Detail'); ?>", dataIndex: 'bp_actual_detail', sortable: true}
,					{header: "<?php __('Created'); ?>", dataIndex: 'created', sortable: true}
,					{header: "<?php __('Modified'); ?>", dataIndex: 'modified', sortable: true}
		
				],
				viewConfig: {
					forceFit: true
				},
				bbar: new Ext.PagingToolbar({
					pageSize: view_list_size,
					store: store_bpMonth_bpActuals,
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
				store: store_bpMonth_bpPlans,
				title: '<?php __('BpPlans'); ?>',
				enableColumnMove: false,
				listeners: {
					activate: function(){
						if(store_bpMonth_bpPlans.getCount() == '')
							store_bpMonth_bpPlans.reload();
					}
				},
				columns: [
					{header: "<?php __('Branch'); ?>", dataIndex: 'branch', sortable: true}
,					{header: "<?php __('Bp Month'); ?>", dataIndex: 'bp_month', sortable: true}
,					{header: "<?php __('Amount'); ?>", dataIndex: 'amount', sortable: true}
,					{header: "<?php __('Bp Item'); ?>", dataIndex: 'bp_item', sortable: true}
,					{header: "<?php __('Budget Year'); ?>", dataIndex: 'budget_year', sortable: true}
,					{header: "<?php __('Status'); ?>", dataIndex: 'status', sortable: true}
,					{header: "<?php __('Created'); ?>", dataIndex: 'created', sortable: true}
,					{header: "<?php __('Modified'); ?>", dataIndex: 'modified', sortable: true}
		
				],
				viewConfig: {
					forceFit: true
				},
				bbar: new Ext.PagingToolbar({
					pageSize: view_list_size,
					store: store_bpMonth_bpPlans,
					displayInfo: true,
					displayMsg: '<?php __('Displaying'); ?> {0} - {1} <?php __('of'); ?> {2}',
					beforePageText: '<?php __('Page'); ?>',
					afterPageText: '<?php __('of'); ?> {0}',
					emptyMsg: '<?php __('No data to display'); ?>'
				})
			}			]
		});

		var BpMonthViewWindow = new Ext.Window({
			title: '<?php __('View BpMonth'); ?>: <?php echo $bpMonth['BpMonth']['name']; ?>',
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
				bpMonth_view_panel_1,
				bpMonth_view_panel_2
			],

			buttons: [{
				text: '<?php __('Close'); ?>',
				handler: function(btn){
					BpMonthViewWindow.close();
				}
			}]
		});
