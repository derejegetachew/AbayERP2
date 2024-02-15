
var store_bpItem_bpActuals = new Ext.data.Store({
	reader: new Ext.data.JsonReader({
		root:'rows',
		totalProperty: 'results',
		fields: [
			'id','amount','month','branch','bp_item','remark','type','created','modified'		]
	}),
	proxy: new Ext.data.HttpProxy({
		url: '<?php echo $this->Html->url(array('controller' => 'bpActuals', 'action' => 'list_data', $bpItem['BpItem']['id'])); ?>'	})
});
var store_bpItem_bpPlans = new Ext.data.Store({
	reader: new Ext.data.JsonReader({
		root:'rows',
		totalProperty: 'results',
		fields: [
			'id','branch','month','amount','bp_item','budget_year','created','modified'		]
	}),
	proxy: new Ext.data.HttpProxy({
		url: '<?php echo $this->Html->url(array('controller' => 'bpPlans', 'action' => 'list_data', $bpItem['BpItem']['id'])); ?>'	})
});
		
<?php $bpItem_html = "<table cellspacing=3>" . 		"<tr><th align=right>" . __('Name', true) . ":</th><td><b>" . $bpItem['BpItem']['name'] . "</b></td></tr>" . 
		"<tr><th align=right>" . __('Accoun No', true) . ":</th><td><b>" . $bpItem['BpItem']['accoun_no'] . "</b></td></tr>" . 
		"<tr><th align=right>" . __('Created', true) . ":</th><td><b>" . $bpItem['BpItem']['created'] . "</b></td></tr>" . 
		"<tr><th align=right>" . __('Modified', true) . ":</th><td><b>" . $bpItem['BpItem']['modified'] . "</b></td></tr>" . 
"</table>"; 
?>
		var bpItem_view_panel_1 = {
			html : '<?php echo $bpItem_html; ?>',
			frame : true,
			height: 80
		}
		var bpItem_view_panel_2 = new Ext.TabPanel({
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
				store: store_bpItem_bpActuals,
				title: '<?php __('BpActuals'); ?>',
				enableColumnMove: false,
				listeners: {
					activate: function(){
						if(store_bpItem_bpActuals.getCount() == '')
							store_bpItem_bpActuals.reload();
					}
				},
				columns: [
					{header: "<?php __('Amount'); ?>", dataIndex: 'amount', sortable: true}
,					{header: "<?php __('Month'); ?>", dataIndex: 'month', sortable: true}
,					{header: "<?php __('Branch'); ?>", dataIndex: 'branch', sortable: true}
,					{header: "<?php __('Bp Item'); ?>", dataIndex: 'bp_item', sortable: true}
,					{header: "<?php __('Remark'); ?>", dataIndex: 'remark', sortable: true}
,					{header: "<?php __('Type'); ?>", dataIndex: 'type', sortable: true}
,					{header: "<?php __('Created'); ?>", dataIndex: 'created', sortable: true}
,					{header: "<?php __('Modified'); ?>", dataIndex: 'modified', sortable: true}
		
				],
				viewConfig: {
					forceFit: true
				},
				bbar: new Ext.PagingToolbar({
					pageSize: view_list_size,
					store: store_bpItem_bpActuals,
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
				store: store_bpItem_bpPlans,
				title: '<?php __('BpPlans'); ?>',
				enableColumnMove: false,
				listeners: {
					activate: function(){
						if(store_bpItem_bpPlans.getCount() == '')
							store_bpItem_bpPlans.reload();
					}
				},
				columns: [
					{header: "<?php __('Branch'); ?>", dataIndex: 'branch', sortable: true}
,					{header: "<?php __('Month'); ?>", dataIndex: 'month', sortable: true}
,					{header: "<?php __('Amount'); ?>", dataIndex: 'amount', sortable: true}
,					{header: "<?php __('Bp Item'); ?>", dataIndex: 'bp_item', sortable: true}
,					{header: "<?php __('Budget Year'); ?>", dataIndex: 'budget_year', sortable: true}
,					{header: "<?php __('Created'); ?>", dataIndex: 'created', sortable: true}
,					{header: "<?php __('Modified'); ?>", dataIndex: 'modified', sortable: true}
		
				],
				viewConfig: {
					forceFit: true
				},
				bbar: new Ext.PagingToolbar({
					pageSize: view_list_size,
					store: store_bpItem_bpPlans,
					displayInfo: true,
					displayMsg: '<?php __('Displaying'); ?> {0} - {1} <?php __('of'); ?> {2}',
					beforePageText: '<?php __('Page'); ?>',
					afterPageText: '<?php __('of'); ?> {0}',
					emptyMsg: '<?php __('No data to display'); ?>'
				})
			}			]
		});

		var BpItemViewWindow = new Ext.Window({
			title: '<?php __('View BpItem'); ?>: <?php echo $bpItem['BpItem']['name']; ?>',
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
				bpItem_view_panel_1,
				bpItem_view_panel_2
			],

			buttons: [{
				text: '<?php __('Close'); ?>',
				handler: function(btn){
					BpItemViewWindow.close();
				}
			}]
		});
