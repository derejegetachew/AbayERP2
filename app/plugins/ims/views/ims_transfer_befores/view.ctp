
var store_imsTransferBefore_imsTransferItemBefores = new Ext.data.Store({
	reader: new Ext.data.JsonReader({
		root:'rows',
		totalProperty: 'results',
		fields: [
			'id','ims_transfer_before','ims_sirv_item_before','ims_item','measurement','quantity','unit_price','tag','created','modified'		]
	}),
	proxy: new Ext.data.HttpProxy({
		url: '<?php echo $this->Html->url(array('controller' => 'imsTransferItemBefores', 'action' => 'list_data', $imsTransferBefore['ImsTransferBefore']['id'])); ?>'	})
});
		
<?php $imsTransferBefore_html = "<table cellspacing=3>" . 		"<tr><th align=right>" . __('Name', true) . ":</th><td><b>" . $imsTransferBefore['ImsTransferBefore']['name'] . "</b></td></tr>" . 
		"<tr><th align=right>" . __('Ims Sirv Before', true) . ":</th><td><b>" . $imsTransferBefore['ImsSirvBefore']['name'] . "</b></td></tr>" . 
		"<tr><th align=right>" . __('From User', true) . ":</th><td><b>" . $imsTransferBefore['ImsTransferBefore']['from_user'] . "</b></td></tr>" . 
		"<tr><th align=right>" . __('To User', true) . ":</th><td><b>" . $imsTransferBefore['ImsTransferBefore']['to_user'] . "</b></td></tr>" . 
		"<tr><th align=right>" . __('From Branch', true) . ":</th><td><b>" . $imsTransferBefore['ImsTransferBefore']['from_branch'] . "</b></td></tr>" . 
		"<tr><th align=right>" . __('To Branch', true) . ":</th><td><b>" . $imsTransferBefore['ImsTransferBefore']['to_branch'] . "</b></td></tr>" . 
		"<tr><th align=right>" . __('Observer', true) . ":</th><td><b>" . $imsTransferBefore['ImsTransferBefore']['observer'] . "</b></td></tr>" . 
		"<tr><th align=right>" . __('Approved By', true) . ":</th><td><b>" . $imsTransferBefore['ImsTransferBefore']['approved_by'] . "</b></td></tr>" . 
		"<tr><th align=right>" . __('Created', true) . ":</th><td><b>" . $imsTransferBefore['ImsTransferBefore']['created'] . "</b></td></tr>" . 
		"<tr><th align=right>" . __('Modified', true) . ":</th><td><b>" . $imsTransferBefore['ImsTransferBefore']['modified'] . "</b></td></tr>" . 
"</table>"; 
?>
		var imsTransferBefore_view_panel_1 = {
			html : '<?php echo $imsTransferBefore_html; ?>',
			frame : true,
			height: 80
		}
		var imsTransferBefore_view_panel_2 = new Ext.TabPanel({
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
				store: store_imsTransferBefore_imsTransferItemBefores,
				title: '<?php __('ImsTransferItemBefores'); ?>',
				enableColumnMove: false,
				listeners: {
					activate: function(){
						if(store_imsTransferBefore_imsTransferItemBefores.getCount() == '')
							store_imsTransferBefore_imsTransferItemBefores.reload();
					}
				},
				columns: [
					{header: "<?php __('Ims Transfer Before'); ?>", dataIndex: 'ims_transfer_before', sortable: true}
,					{header: "<?php __('Ims Sirv Item Before'); ?>", dataIndex: 'ims_sirv_item_before', sortable: true}
,					{header: "<?php __('Ims Item'); ?>", dataIndex: 'ims_item', sortable: true}
,					{header: "<?php __('Measurement'); ?>", dataIndex: 'measurement', sortable: true}
,					{header: "<?php __('Quantity'); ?>", dataIndex: 'quantity', sortable: true}
,					{header: "<?php __('Unit Price'); ?>", dataIndex: 'unit_price', sortable: true}
,					{header: "<?php __('Tag'); ?>", dataIndex: 'tag', sortable: true}
,					{header: "<?php __('Created'); ?>", dataIndex: 'created', sortable: true}
,					{header: "<?php __('Modified'); ?>", dataIndex: 'modified', sortable: true}
		
				],
				viewConfig: {
					forceFit: true
				},
				bbar: new Ext.PagingToolbar({
					pageSize: view_list_size,
					store: store_imsTransferBefore_imsTransferItemBefores,
					displayInfo: true,
					displayMsg: '<?php __('Displaying'); ?> {0} - {1} <?php __('of'); ?> {2}',
					beforePageText: '<?php __('Page'); ?>',
					afterPageText: '<?php __('of'); ?> {0}',
					emptyMsg: '<?php __('No data to display'); ?>'
				})
			}			]
		});

		var ImsTransferBeforeViewWindow = new Ext.Window({
			title: '<?php __('View ImsTransferBefore'); ?>: <?php echo $imsTransferBefore['ImsTransferBefore']['name']; ?>',
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
				imsTransferBefore_view_panel_1,
				imsTransferBefore_view_panel_2
			],

			buttons: [{
				text: '<?php __('Close'); ?>',
				handler: function(btn){
					ImsTransferBeforeViewWindow.close();
				}
			}]
		});
