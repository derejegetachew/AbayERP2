
var store_imsTransfer_imsTransferItems = new Ext.data.Store({
	reader: new Ext.data.JsonReader({
		root:'rows',
		totalProperty: 'results',
		fields: [
			'id','ims_transfer','ims_item','quantity','unit_price','created','modified'		]
	}),
	proxy: new Ext.data.HttpProxy({
		url: '<?php echo $this->Html->url(array('controller' => 'imsTransferItems', 'action' => 'list_data', $imsTransfer['ImsTransfer']['id'])); ?>'	})
});
		
<?php $imsTransfer_html = "<table cellspacing=3>" . 		"<tr><th align=right>" . __('Name', true) . ":</th><td><b>" . $imsTransfer['ImsTransfer']['name'] . "</b></td></tr>" . 
		"<tr><th align=right>" . __('Ims Sirv', true) . ":</th><td><b>" . $imsTransfer['ImsSirv']['name'] . "</b></td></tr>" . 
		"<tr><th align=right>" . __('From User', true) . ":</th><td><b>" . $imsTransfer['ImsTransfer']['from_user'] . "</b></td></tr>" . 
		"<tr><th align=right>" . __('To User', true) . ":</th><td><b>" . $imsTransfer['ImsTransfer']['to_user'] . "</b></td></tr>" . 
		"<tr><th align=right>" . __('From Branch', true) . ":</th><td><b>" . $imsTransfer['ImsTransfer']['from_branch'] . "</b></td></tr>" . 
		"<tr><th align=right>" . __('To Branch', true) . ":</th><td><b>" . $imsTransfer['ImsTransfer']['to_branch'] . "</b></td></tr>" . 
		"<tr><th align=right>" . __('Observer', true) . ":</th><td><b>" . $imsTransfer['ImsTransfer']['observer'] . "</b></td></tr>" . 
		"<tr><th align=right>" . __('Approved By', true) . ":</th><td><b>" . $imsTransfer['ImsTransfer']['approved_by'] . "</b></td></tr>" . 
		"<tr><th align=right>" . __('Created', true) . ":</th><td><b>" . $imsTransfer['ImsTransfer']['created'] . "</b></td></tr>" . 
		"<tr><th align=right>" . __('Modified', true) . ":</th><td><b>" . $imsTransfer['ImsTransfer']['modified'] . "</b></td></tr>" . 
"</table>"; 
?>
		var imsTransfer_view_panel_1 = {
			html : '<?php echo $imsTransfer_html; ?>',
			frame : true,
			height: 80
		}
		var imsTransfer_view_panel_2 = new Ext.TabPanel({
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
				store: store_imsTransfer_imsTransferItems,
				title: '<?php __('ImsTransferItems'); ?>',
				enableColumnMove: false,
				listeners: {
					activate: function(){
						if(store_imsTransfer_imsTransferItems.getCount() == '')
							store_imsTransfer_imsTransferItems.reload();
					}
				},
				columns: [
					{header: "<?php __('Ims Transfer'); ?>", dataIndex: 'ims_transfer', sortable: true}
,					{header: "<?php __('Ims Item'); ?>", dataIndex: 'ims_item', sortable: true}
,					{header: "<?php __('Quantity'); ?>", dataIndex: 'quantity', sortable: true}
,					{header: "<?php __('Unit Price'); ?>", dataIndex: 'unit_price', sortable: true}
,					{header: "<?php __('Created'); ?>", dataIndex: 'created', sortable: true}
,					{header: "<?php __('Modified'); ?>", dataIndex: 'modified', sortable: true}
		
				],
				viewConfig: {
					forceFit: true
				},
				bbar: new Ext.PagingToolbar({
					pageSize: view_list_size,
					store: store_imsTransfer_imsTransferItems,
					displayInfo: true,
					displayMsg: '<?php __('Displaying'); ?> {0} - {1} <?php __('of'); ?> {2}',
					beforePageText: '<?php __('Page'); ?>',
					afterPageText: '<?php __('of'); ?> {0}',
					emptyMsg: '<?php __('No data to display'); ?>'
				})
			}			]
		});

		var ImsTransferViewWindow = new Ext.Window({
			title: '<?php __('View ImsTransfer'); ?>: <?php echo $imsTransfer['ImsTransfer']['name']; ?>',
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
				imsTransfer_view_panel_1,
				imsTransfer_view_panel_2
			],

			buttons: [{
				text: '<?php __('Close'); ?>',
				handler: function(btn){
					ImsTransferViewWindow.close();
				}
			}]
		});
