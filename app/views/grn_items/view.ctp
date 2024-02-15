
var store_grnItem_stores = new Ext.data.Store({
	reader: new Ext.data.JsonReader({
		root:'rows',
		totalProperty: 'results',
		fields: [
			'id','name','address','created','modified'		]
	}),
	proxy: new Ext.data.HttpProxy({
		url: '<?php echo $this->Html->url(array('controller' => 'stores', 'action' => 'list_data', $grnItem['GrnItem']['id'])); ?>'	})
});
		
<?php $grnItem_html = "<table cellspacing=3>" . 		"<tr><th align=right>" . __('Grn', true) . ":</th><td><b>" . $grnItem['Grn']['name'] . "</b></td></tr>" . 
		"<tr><th align=right>" . __('Purchase Order Item', true) . ":</th><td><b>" . $grnItem['PurchaseOrderItem']['id'] . "</b></td></tr>" . 
		"<tr><th align=right>" . __('Quantity', true) . ":</th><td><b>" . $grnItem['GrnItem']['quantity'] . "</b></td></tr>" . 
		"<tr><th align=right>" . __('Unit Price', true) . ":</th><td><b>" . $grnItem['GrnItem']['unit_price'] . "</b></td></tr>" . 
		"<tr><th align=right>" . __('Created', true) . ":</th><td><b>" . $grnItem['GrnItem']['created'] . "</b></td></tr>" . 
		"<tr><th align=right>" . __('Modified', true) . ":</th><td><b>" . $grnItem['GrnItem']['modified'] . "</b></td></tr>" . 
"</table>"; 
?>
		var grnItem_view_panel_1 = {
			html : '<?php echo $grnItem_html; ?>',
			frame : true,
			height: 80
		}
		var grnItem_view_panel_2 = new Ext.TabPanel({
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
				store: store_grnItem_stores,
				title: '<?php __('Stores'); ?>',
				enableColumnMove: false,
				listeners: {
					activate: function(){
						if(store_grnItem_stores.getCount() == '')
							store_grnItem_stores.reload();
					}
				},
				columns: [
					{header: "<?php __('Name'); ?>", dataIndex: 'name', sortable: true}
,					{header: "<?php __('Address'); ?>", dataIndex: 'address', sortable: true}
,					{header: "<?php __('Created'); ?>", dataIndex: 'created', sortable: true}
,					{header: "<?php __('Modified'); ?>", dataIndex: 'modified', sortable: true}
		
				],
				viewConfig: {
					forceFit: true
				},
				bbar: new Ext.PagingToolbar({
					pageSize: view_list_size,
					store: store_grnItem_stores,
					displayInfo: true,
					displayMsg: '<?php __('Displaying'); ?> {0} - {1} <?php __('of'); ?> {2}',
					beforePageText: '<?php __('Page'); ?>',
					afterPageText: '<?php __('of'); ?> {0}',
					emptyMsg: '<?php __('No data to display'); ?>'
				})
			}			]
		});

		var GrnItemViewWindow = new Ext.Window({
			title: '<?php __('View GrnItem'); ?>: <?php echo $grnItem['GrnItem']['id']; ?>',
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
				grnItem_view_panel_1,
				grnItem_view_panel_2
			],

			buttons: [{
				text: '<?php __('Close'); ?>',
				handler: function(btn){
					GrnItemViewWindow.close();
				}
			}]
		});
