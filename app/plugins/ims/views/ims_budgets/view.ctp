
var store_imsBudget_imsBudgetItems = new Ext.data.Store({
	reader: new Ext.data.JsonReader({
		root:'rows',
		totalProperty: 'results',
		fields: [
			'id','ims_budget','ims_item','quantity','measurement','created','modified'		]
	}),
	proxy: new Ext.data.HttpProxy({
		url: '<?php echo $this->Html->url(array('controller' => 'imsBudgetItems', 'action' => 'list_data', $imsBudget['ImsBudget']['id'])); ?>'	})
});
		
<?php $imsBudget_html = "<table cellspacing=3>" . 		"<tr><th align=right>" . __('Name', true) . ":</th><td><b>" . $imsBudget['ImsBudget']['name'] . "</b></td></tr>" . 
		"<tr><th align=right>" . __('Budget Year', true) . ":</th><td><b>" . $imsBudget['BudgetYear']['name'] . "</b></td></tr>" . 
		"<tr><th align=right>" . __('Branch', true) . ":</th><td><b>" . $imsBudget['Branch']['name'] . "</b></td></tr>" . 
		"<tr><th align=right>" . __('Created', true) . ":</th><td><b>" . $imsBudget['ImsBudget']['created'] . "</b></td></tr>" . 
		"<tr><th align=right>" . __('Modified', true) . ":</th><td><b>" . $imsBudget['ImsBudget']['modified'] . "</b></td></tr>" . 
"</table>"; 
?>
		var imsBudget_view_panel_1 = {
			html : '<?php echo $imsBudget_html; ?>',
			frame : true,
			height: 80
		}
		var imsBudget_view_panel_2 = new Ext.TabPanel({
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
				store: store_imsBudget_imsBudgetItems,
				title: '<?php __('Budget Items'); ?>',
				enableColumnMove: false,
				listeners: {
					activate: function(){
						if(store_imsBudget_imsBudgetItems.getCount() == '')
							store_imsBudget_imsBudgetItems.reload();
					}
				},
				columns: [
					{header: "<?php __('Budget'); ?>", dataIndex: 'ims_budget', sortable: true}
,					{header: "<?php __('Item'); ?>", dataIndex: 'ims_item', sortable: true}
,					{header: "<?php __('Quantity'); ?>", dataIndex: 'quantity', sortable: true}
,					{header: "<?php __('Measurement'); ?>", dataIndex: 'measurement', sortable: true}
,					{header: "<?php __('Created'); ?>", dataIndex: 'created', sortable: true}
,					{header: "<?php __('Modified'); ?>", dataIndex: 'modified', sortable: true}
		
				],
				viewConfig: {
					forceFit: true
				},
				bbar: new Ext.PagingToolbar({
					pageSize: view_list_size,
					store: store_imsBudget_imsBudgetItems,
					displayInfo: true,
					displayMsg: '<?php __('Displaying'); ?> {0} - {1} <?php __('of'); ?> {2}',
					beforePageText: '<?php __('Page'); ?>',
					afterPageText: '<?php __('of'); ?> {0}',
					emptyMsg: '<?php __('No data to display'); ?>'
				})
			}			]
		});

		var ImsBudgetViewWindow = new Ext.Window({
			title: '<?php __('View Budget'); ?>: <?php echo $imsBudget['ImsBudget']['name']; ?>',
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
				imsBudget_view_panel_1,
				imsBudget_view_panel_2
			],

			buttons: [{
				text: '<?php __('Close'); ?>',
				handler: function(btn){
					ImsBudgetViewWindow.close();
				}
			}]
		});
