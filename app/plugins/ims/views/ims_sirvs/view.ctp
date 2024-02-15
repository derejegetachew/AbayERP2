
var store_imsSirv_imsSirvItems = new Ext.data.Store({
	reader: new Ext.data.JsonReader({
		root:'rows',
		totalProperty: 'results',
		fields: [
			'id','ims_sirv','ims_item','measurement','quantity','unit_price','remark'		]
	}),
	proxy: new Ext.data.HttpProxy({
		url: '<?php echo $this->Html->url(array('controller' => 'imsSirvItems', 'action' => 'list_data', $imsSirv['ImsSirv']['id'])); ?>'	})
});
		
<?php $imsSirv_html = "<table cellspacing=3>" . 		"<tr><th align=right>" . __('Name', true) . ":</th><td><b>" . $imsSirv['ImsSirv']['name'] . "</b></td></tr>" . 
		"<tr><th align=right>" . __('Requisition', true) . ":</th><td><b>" . $imsSirv['ImsRequisition']['name'] . "</b></td></tr>" . 
		"<tr><th align=right>" . __('Created', true) . ":</th><td><b>" . $imsSirv['ImsSirv']['created'] . "</b></td></tr>" . 
		"<tr><th align=right>" . __('Modified', true) . ":</th><td><b>" . $imsSirv['ImsSirv']['modified'] . "</b></td></tr>" . 
"</table>"; 
?>
		var imsSirv_view_panel_1 = {
			html : '<?php echo $imsSirv_html; ?>',
			frame : true,
			height: 80
		}
		var imsSirv_view_panel_2 = new Ext.TabPanel({
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
				store: store_imsSirv_imsSirvItems,
				title: '<?php __('Sirv Items'); ?>',
				enableColumnMove: false,
				listeners: {
					activate: function(){
						if(store_imsSirv_imsSirvItems.getCount() == '')
							store_imsSirv_imsSirvItems.reload();
					}
				},
				columns: [
					{header: "<?php __('Sirv'); ?>", dataIndex: 'ims_sirv', sortable: true}
,					{header: "<?php __('Item'); ?>", dataIndex: 'ims_item', sortable: true}
,					{header: "<?php __('Measurement'); ?>", dataIndex: 'measurement', sortable: true}
,					{header: "<?php __('Quantity'); ?>", dataIndex: 'quantity', sortable: true}
,					{header: "<?php __('Unit Price'); ?>", dataIndex: 'unit_price', sortable: true}
,					{header: "<?php __('Remark'); ?>", dataIndex: 'remark', sortable: true}
		
				],
				viewConfig: {
					forceFit: true
				},
				bbar: new Ext.PagingToolbar({
					pageSize: view_list_size,
					store: store_imsSirv_imsSirvItems,
					displayInfo: true,
					displayMsg: '<?php __('Displaying'); ?> {0} - {1} <?php __('of'); ?> {2}',
					beforePageText: '<?php __('Page'); ?>',
					afterPageText: '<?php __('of'); ?> {0}',
					emptyMsg: '<?php __('No data to display'); ?>'
				})
			}			]
		});

		var ImsSirvViewWindow = new Ext.Window({
			title: '<?php __('View Sirv'); ?>: <?php echo $imsSirv['ImsSirv']['name']; ?>',
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
				imsSirv_view_panel_1,
				imsSirv_view_panel_2
			],

			buttons: [{
				text: '<?php __('Close'); ?>',
				handler: function(btn){
					ImsSirvViewWindow.close();
				}
			}]
		});
