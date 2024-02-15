
var store_supplier_grns = new Ext.data.Store({
	reader: new Ext.data.JsonReader({
		root:'rows',
		totalProperty: 'results',
		fields: [
			'id','name','supplier','purchase_order','date_purchased','created','modified'		]
	}),
	proxy: new Ext.data.HttpProxy({
		url: '<?php echo $this->Html->url(array('controller' => 'grns', 'action' => 'list_data', $supplier['Supplier']['id'])); ?>'	})
});
		
<?php $supplier_html = "<table cellspacing=3>" . 		"<tr><th align=right>" . __('Name', true) . ":</th><td><b>" . $supplier['Supplier']['name'] . "</b></td></tr>" . 
		"<tr><th align=right>" . __('Address', true) . ":</th><td><b>" . $supplier['Supplier']['address'] . "</b></td></tr>" . 
		"<tr><th align=right>" . __('Created', true) . ":</th><td><b>" . $supplier['Supplier']['created'] . "</b></td></tr>" . 
		"<tr><th align=right>" . __('Modified', true) . ":</th><td><b>" . $supplier['Supplier']['modified'] . "</b></td></tr>" . 
"</table>"; 
?>
		var supplier_view_panel_1 = {
			html : '<?php echo $supplier_html; ?>',
			frame : true,
			height: 80
		}
		var supplier_view_panel_2 = new Ext.TabPanel({
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
				store: store_supplier_grns,
				title: '<?php __('Grns'); ?>',
				enableColumnMove: false,
				listeners: {
					activate: function(){
						if(store_supplier_grns.getCount() == '')
							store_supplier_grns.reload();
					}
				},
				columns: [
					{header: "<?php __('Name'); ?>", dataIndex: 'name', sortable: true}
,					{header: "<?php __('Purchase Order'); ?>", dataIndex: 'purchase_order', sortable: true}
,					{header: "<?php __('Date Purchased'); ?>", dataIndex: 'date_purchased', sortable: true}
,					{header: "<?php __('Created'); ?>", dataIndex: 'created', sortable: true}
,					{header: "<?php __('Modified'); ?>", dataIndex: 'modified', sortable: true}
		
				],
				viewConfig: {
					forceFit: true
				},
				bbar: new Ext.PagingToolbar({
					pageSize: view_list_size,
					store: store_supplier_grns,
					displayInfo: true,
					displayMsg: '<?php __('Displaying'); ?> {0} - {1} <?php __('of'); ?> {2}',
					beforePageText: '<?php __('Page'); ?>',
					afterPageText: '<?php __('of'); ?> {0}',
					emptyMsg: '<?php __('No data to display'); ?>'
				})
			}			]
		});

		var SupplierViewWindow = new Ext.Window({
			title: '<?php __('View Supplier'); ?>: <?php echo $supplier['Supplier']['name']; ?>',
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
				supplier_view_panel_1,
				supplier_view_panel_2
			],

			buttons: [{
				text: '<?php __('Close'); ?>',
				handler: function(btn){
					SupplierViewWindow.close();
				}
			}]
		});
