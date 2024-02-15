
var store_imsTransferStoreItem_imsTransferStoreItemDetails = new Ext.data.Store({
	reader: new Ext.data.JsonReader({
		root:'rows',
		totalProperty: 'results',
		fields: [
			'id','ims_transfer_store_item','ims_item','quantity','measurement','created','modified'		]
	}),
	proxy: new Ext.data.HttpProxy({
		url: '<?php echo $this->Html->url(array('controller' => 'imsTransferStoreItemDetails', 'action' => 'list_data', $imsTransferStoreItem['ImsTransferStoreItem']['id'])); ?>'	})
});
		
<?php $imsTransferStoreItem_html = "<table cellspacing=3>" . 		"<tr><th align=right>" . __('Name', true) . ":</th><td><b>" . $imsTransferStoreItem['ImsTransferStoreItem']['name'] . "</b></td></tr>" . 
		"<tr><th align=right>" . __('From Store', true) . ":</th><td><b>" . $imsTransferStoreItem['ImsTransferStoreItem']['from_store'] . "</b></td></tr>" . 
		"<tr><th align=right>" . __('To Store', true) . ":</th><td><b>" . $imsTransferStoreItem['ImsTransferStoreItem']['to_store'] . "</b></td></tr>" . 
		"<tr><th align=right>" . __('From Store Keeper', true) . ":</th><td><b>" . $imsTransferStoreItem['ImsTransferStoreItem']['from_store_keeper'] . "</b></td></tr>" . 
		"<tr><th align=right>" . __('To Store Keeper', true) . ":</th><td><b>" . $imsTransferStoreItem['ImsTransferStoreItem']['to_store_keeper'] . "</b></td></tr>" . 
		"<tr><th align=right>" . __('Remark', true) . ":</th><td><b>" . $imsTransferStoreItem['ImsTransferStoreItem']['remark'] . "</b></td></tr>" . 
		"<tr><th align=right>" . __('Status', true) . ":</th><td><b>" . $imsTransferStoreItem['ImsTransferStoreItem']['status'] . "</b></td></tr>" . 
		"<tr><th align=right>" . __('Created', true) . ":</th><td><b>" . $imsTransferStoreItem['ImsTransferStoreItem']['created'] . "</b></td></tr>" . 
		"<tr><th align=right>" . __('Modified', true) . ":</th><td><b>" . $imsTransferStoreItem['ImsTransferStoreItem']['modified'] . "</b></td></tr>" . 
"</table>"; 
?>
		var imsTransferStoreItem_view_panel_1 = {
			html : '<?php echo $imsTransferStoreItem_html; ?>',
			frame : true,
			height: 80
		}
		var imsTransferStoreItem_view_panel_2 = new Ext.TabPanel({
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
				store: store_imsTransferStoreItem_imsTransferStoreItemDetails,
				title: '<?php __('ImsTransferStoreItemDetails'); ?>',
				enableColumnMove: false,
				listeners: {
					activate: function(){
						if(store_imsTransferStoreItem_imsTransferStoreItemDetails.getCount() == '')
							store_imsTransferStoreItem_imsTransferStoreItemDetails.reload();
					}
				},
				columns: [
					{header: "<?php __('Ims Transfer Store Item'); ?>", dataIndex: 'ims_transfer_store_item', sortable: true}
,					{header: "<?php __('Ims Item'); ?>", dataIndex: 'ims_item', sortable: true}
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
					store: store_imsTransferStoreItem_imsTransferStoreItemDetails,
					displayInfo: true,
					displayMsg: '<?php __('Displaying'); ?> {0} - {1} <?php __('of'); ?> {2}',
					beforePageText: '<?php __('Page'); ?>',
					afterPageText: '<?php __('of'); ?> {0}',
					emptyMsg: '<?php __('No data to display'); ?>'
				})
			}			]
		});

		var ImsTransferStoreItemViewWindow = new Ext.Window({
			title: '<?php __('View ImsTransferStoreItem'); ?>: <?php echo $imsTransferStoreItem['ImsTransferStoreItem']['name']; ?>',
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
				imsTransferStoreItem_view_panel_1,
				imsTransferStoreItem_view_panel_2
			],

			buttons: [{
				text: '<?php __('Close'); ?>',
				handler: function(btn){
					ImsTransferStoreItemViewWindow.close();
				}
			}]
		});
