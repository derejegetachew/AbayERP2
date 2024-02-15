//<script>
var store_grn_grnItems = new Ext.data.Store({
	reader: new Ext.data.JsonReader({
		root:'rows',
		totalProperty: 'results',
		fields: [
			'id','grn','purchase_order_item','quantity','unit_price','created','modified'		]
	}),
	proxy: new Ext.data.HttpProxy({
		url: '<?php echo $this->Html->url(array('controller' => 'ims_grn_items', 'action' => 'list_data', $grn['ImsGrn']['id'])); ?>'	})
});
		
<?php $grn_html = "<table cellspacing=3>" . 		"<tr><th align=right>" . __('Name', true) . ":</th><td><b>" . $grn['ImsGrn']['name'] . "</b></td></tr>" . 
		"<tr><th align=right>" . __('Supplier', true) . ":</th><td><b>" . $grn['ImsSupplier']['name'] . "</b></td></tr>" . 
		"<tr><th align=right>" . __('Purchase Order', true) . ":</th><td><b>" . $grn['ImsPurchaseOrder']['name'] . "</b></td></tr>" . 
		"<tr><th align=right>" . __('Date Purchased', true) . ":</th><td><b>" . $grn['ImsGrn']['date_purchased'] . "</b></td></tr>" . 
		"<tr><th align=right>" . __('Created', true) . ":</th><td><b>" . $grn['ImsGrn']['created'] . "</b></td></tr>" . 
		"<tr><th align=right>" . __('Modified', true) . ":</th><td><b>" . $grn['ImsGrn']['modified'] . "</b></td></tr>" . 
"</table>"; 
?>
		var grn_view_panel_1 = {
			html : '<?php echo $grn_html; ?>',
			frame : true,
			height: 80
		}
		var grn_view_panel_2 = new Ext.TabPanel({
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
				store: store_grn_grnItems,
				title: '<?php __('GrnItems'); ?>',
				enableColumnMove: false,
				listeners: {
					activate: function(){
						if(store_grn_grnItems.getCount() == '')
							store_grn_grnItems.reload();
					}
				},
				columns: [
					{header: "<?php __('Purchase Order Item'); ?>", dataIndex: 'purchase_order_item', sortable: true}
,					{header: "<?php __('Quantity'); ?>", dataIndex: 'quantity', sortable: true}
,					{header: "<?php __('Unit Price'); ?>", dataIndex: 'unit_price', sortable: true}
,					{header: "<?php __('Created'); ?>", dataIndex: 'created', sortable: true}
,					{header: "<?php __('Modified'); ?>", dataIndex: 'modified', sortable: true}
		
				],
				viewConfig: {
					forceFit: true
				},
				bbar: new Ext.PagingToolbar({
					pageSize: list_size,
					store: store_grn_grnItems,
					displayInfo: true,
					displayMsg: '<?php __('Displaying'); ?> {0} - {1} <?php __('of'); ?> {2}',
					beforePageText: '<?php __('Page'); ?>',
					afterPageText: '<?php __('of'); ?> {0}',
					emptyMsg: '<?php __('No data to display'); ?>'
				})
			}			]
		});

		var GrnViewWindow = new Ext.Window({
			title: '<?php __('View Grn'); ?>: <?php echo $grn['ImsGrn']['name']; ?>',
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
				grn_view_panel_1,
				grn_view_panel_2
			],

			buttons: [{
				text: '<?php __('Close'); ?>',
				handler: function(btn){
					GrnViewWindow.close();
				}
			}]
		});
