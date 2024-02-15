
var store_imsRequisition_imsRequisitionItems = new Ext.data.Store({
	reader: new Ext.data.JsonReader({
		root:'rows',
		totalProperty: 'results',
		fields: [
			'id','ims_requisition','ims_item','itemcode','quantity','measurement','remark','budget','created','modified'		]
	}),
	proxy: new Ext.data.HttpProxy({
		url: '<?php echo $this->Html->url(array('controller' => 'imsRequisitionItems', 'action' => 'list_data', $imsRequisition['ImsRequisition']['id'])); ?>'	})
});
		
<?php $imsRequisition_html = "<table cellspacing=3>" . 		
		"<tr><th align=right>" . __('Name', true) . ":</th><td><b>" . $imsRequisition['ImsRequisition']['name'] . "</b></td></tr>" . 
		"<tr><th align=right>" . __('Budget Year', true) . ":</th><td><b>" . $imsRequisition['BudgetYear']['name'] . "</b></td></tr>" . 
		"<tr><th align=right>" . __('Branch', true) . ":</th><td><b>" . $imsRequisition['Branch']['name'] . "</b></td></tr>" . 
		"<tr><th align=right>" . __('Purpose', true) . ":</th><td><b>" . $imsRequisition['ImsRequisition']['purpose'] . "</b></td></tr>" . 
		"<tr><th align=right>" . __('Requested By', true) . ":</th><td><b>" . $imsRequisition['ImsRequisition']['requested_by'] . "</b></td></tr>" . 		 
		"<tr><th align=right>" . __('Approved/Rejected By', true) . ":</th><td><b>" . $imsRequisition['ImsRequisition']['approved_rejected_by'] . "</b></td></tr>" . 
		"<tr><th align=right>" . __('Status', true) . ":</th><td><b>" . $imsRequisition['ImsRequisition']['status'] . "</b></td></tr>" .
		"<tr><th align=right>" . __('Created', true) . ":</th><td><b>" . $imsRequisition['ImsRequisition']['created'] . "</b></td></tr>" . 
		"<tr><th align=right>" . __('Modified', true) . ":</th><td><b>" . $imsRequisition['ImsRequisition']['modified'] . "</b></td></tr>" . 
"</table>"; 
?>
		var imsRequisition_view_panel_1 = {
			html : '<?php echo $imsRequisition_html; ?>',
			frame : true,
			height: 80
		}
		var imsRequisition_view_panel_2 = new Ext.TabPanel({
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
				store: store_imsRequisition_imsRequisitionItems,
				title: '<?php __('Requisition Items'); ?>',
				enableColumnMove: false,
				listeners: {
					activate: function(){
						if(store_imsRequisition_imsRequisitionItems.getCount() == '')
							store_imsRequisition_imsRequisitionItems.reload();
					}
				},
				columns: [
					{header: "<?php __('Requisition'); ?>", dataIndex: 'ims_requisition', sortable: true, hidden: true}
,					{header: "<?php __('Item'); ?>", dataIndex: 'ims_item', sortable: true}
,					{header: "<?php __('Code'); ?>", dataIndex: 'itemcode', sortable: true}
,					{header: "<?php __('Quantity'); ?>", dataIndex: 'quantity', sortable: true}
,					{header: "<?php __('Measurement'); ?>", dataIndex: 'measurement', sortable: true}
,					{header: "<?php __('Remark'); ?>", dataIndex: 'remark', sortable: true}
,					{header: "<?php __('Budget'); ?>", dataIndex: 'budget', sortable: true}
		
				],
				viewConfig: {
					forceFit: true
				},
				bbar: new Ext.PagingToolbar({
					pageSize: list_size,
					store: store_imsRequisition_imsRequisitionItems,
					displayInfo: true,
					displayMsg: '<?php __('Displaying'); ?> {0} - {1} <?php __('of'); ?> {2}',
					beforePageText: '<?php __('Page'); ?>',
					afterPageText: '<?php __('of'); ?> {0}',
					emptyMsg: '<?php __('No data to display'); ?>'
				})
			}			]
		});

		var ImsRequisitionViewWindow = new Ext.Window({
			title: '<?php __('View Requisition'); ?>: <?php echo $imsRequisition['ImsRequisition']['name']; ?>',
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
				imsRequisition_view_panel_1,
				imsRequisition_view_panel_2
			],

			buttons: [{
				text: '<?php __('Close'); ?>',
				handler: function(btn){
					ImsRequisitionViewWindow.close();
				}
			}]
		});
