
var store_imsReturn_imsReturnItems = new Ext.data.Store({
	reader: new Ext.data.JsonReader({
		root:'rows',
		totalProperty: 'results',
		fields: [
			'id','ims_return','ims_sirv_item','quantity','remark','created','modified'		]
	}),
	proxy: new Ext.data.HttpProxy({
		url: '<?php echo $this->Html->url(array('controller' => 'imsReturnItems', 'action' => 'list_data', $imsReturn['ImsReturn']['id'])); ?>'	})
});
		
<?php $imsReturn_html = "<table cellspacing=3>" . 		"<tr><th align=right>" . __('Name', true) . ":</th><td><b>" . $imsReturn['ImsReturn']['name'] . "</b></td></tr>" . 
		"<tr><th align=right>" . __('Received By', true) . ":</th><td><b>" . $imsReturn['ImsReturn']['received_by'] . "</b></td></tr>" . 
		"<tr><th align=right>" . __('Created', true) . ":</th><td><b>" . $imsReturn['ImsReturn']['created'] . "</b></td></tr>" . 
		"<tr><th align=right>" . __('Modified', true) . ":</th><td><b>" . $imsReturn['ImsReturn']['modified'] . "</b></td></tr>" . 
"</table>"; 
?>
		var imsReturn_view_panel_1 = {
			html : '<?php echo $imsReturn_html; ?>',
			frame : true,
			height: 80
		}
		var imsReturn_view_panel_2 = new Ext.TabPanel({
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
				store: store_imsReturn_imsReturnItems,
				title: '<?php __('ImsReturnItems'); ?>',
				enableColumnMove: false,
				listeners: {
					activate: function(){
						if(store_imsReturn_imsReturnItems.getCount() == '')
							store_imsReturn_imsReturnItems.reload();
					}
				},
				columns: [
					{header: "<?php __('Ims Return'); ?>", dataIndex: 'ims_return', sortable: true}
,					{header: "<?php __('Ims Sirv Item'); ?>", dataIndex: 'ims_sirv_item', sortable: true}
,					{header: "<?php __('Quantity'); ?>", dataIndex: 'quantity', sortable: true}
,					{header: "<?php __('Remark'); ?>", dataIndex: 'remark', sortable: true}
,					{header: "<?php __('Created'); ?>", dataIndex: 'created', sortable: true}
,					{header: "<?php __('Modified'); ?>", dataIndex: 'modified', sortable: true}
		
				],
				viewConfig: {
					forceFit: true
				},
				bbar: new Ext.PagingToolbar({
					pageSize: view_list_size,
					store: store_imsReturn_imsReturnItems,
					displayInfo: true,
					displayMsg: '<?php __('Displaying'); ?> {0} - {1} <?php __('of'); ?> {2}',
					beforePageText: '<?php __('Page'); ?>',
					afterPageText: '<?php __('of'); ?> {0}',
					emptyMsg: '<?php __('No data to display'); ?>'
				})
			}			]
		});

		var ImsReturnViewWindow = new Ext.Window({
			title: '<?php __('View ImsReturn'); ?>: <?php echo $imsReturn['ImsReturn']['name']; ?>',
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
				imsReturn_view_panel_1,
				imsReturn_view_panel_2
			],

			buttons: [{
				text: '<?php __('Close'); ?>',
				handler: function(btn){
					ImsReturnViewWindow.close();
				}
			}]
		});
