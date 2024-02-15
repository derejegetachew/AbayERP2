
var store_imsDisposal_imsDisposalItems = new Ext.data.Store({
	reader: new Ext.data.JsonReader({
		root:'rows',
		totalProperty: 'results',
		fields: [
			'id','ims_disposal','ims_item','measurement','quantity','remark','created','modified'		]
	}),
	proxy: new Ext.data.HttpProxy({
		url: '<?php echo $this->Html->url(array('controller' => 'imsDisposalItems', 'action' => 'list_data', $imsDisposal['ImsDisposal']['id'])); ?>'	})
});
		
<?php $imsDisposal_html = "<table cellspacing=3>" . 		"<tr><th align=right>" . __('Name', true) . ":</th><td><b>" . $imsDisposal['ImsDisposal']['name'] . "</b></td></tr>" . 
		"<tr><th align=right>" . __('Status', true) . ":</th><td><b>" . $imsDisposal['ImsDisposal']['status'] . "</b></td></tr>" . 
		"<tr><th align=right>" . __('Store', true) . ":</th><td><b>" . $imsDisposal['ImsStore']['name'] . "</b></td></tr>" . 
		"<tr><th align=right>" . __('Created By', true) . ":</th><td><b>" . $imsDisposal['ImsDisposal']['created_by'] . "</b></td></tr>" . 
		"<tr><th align=right>" . __('Approved By', true) . ":</th><td><b>" . $imsDisposal['ImsDisposal']['approved_by'] . "</b></td></tr>" . 
		"<tr><th align=right>" . __('Created', true) . ":</th><td><b>" . $imsDisposal['ImsDisposal']['created'] . "</b></td></tr>" . 
		"<tr><th align=right>" . __('Modified', true) . ":</th><td><b>" . $imsDisposal['ImsDisposal']['modified'] . "</b></td></tr>" . 
"</table>"; 
?>
		var imsDisposal_view_panel_1 = {
			html : '<?php echo $imsDisposal_html; ?>',
			frame : true,
			height: 80
		}
		var imsDisposal_view_panel_2 = new Ext.TabPanel({
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
				store: store_imsDisposal_imsDisposalItems,
				title: '<?php __('ImsDisposalItems'); ?>',
				enableColumnMove: false,
				listeners: {
					activate: function(){
						if(store_imsDisposal_imsDisposalItems.getCount() == '')
							store_imsDisposal_imsDisposalItems.reload();
					}
				},
				columns: [
					{header: "<?php __('Disposal'); ?>", dataIndex: 'ims_disposal', sortable: true, hidden: true}
,					{header: "<?php __('Item'); ?>", dataIndex: 'ims_item', sortable: true}
,					{header: "<?php __('Measurement'); ?>", dataIndex: 'measurement', sortable: true}
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
					store: store_imsDisposal_imsDisposalItems,
					displayInfo: true,
					displayMsg: '<?php __('Displaying'); ?> {0} - {1} <?php __('of'); ?> {2}',
					beforePageText: '<?php __('Page'); ?>',
					afterPageText: '<?php __('of'); ?> {0}',
					emptyMsg: '<?php __('No data to display'); ?>'
				})
			}			]
		});

		var ImsDisposalViewWindow = new Ext.Window({
			title: '<?php __('View ImsDisposal'); ?>: <?php echo $imsDisposal['ImsDisposal']['name']; ?>',
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
				imsDisposal_view_panel_1,
				imsDisposal_view_panel_2
			],

			buttons: [{
				text: '<?php __('Close'); ?>',
				handler: function(btn){
					ImsDisposalViewWindow.close();
				}
			}]
		});
