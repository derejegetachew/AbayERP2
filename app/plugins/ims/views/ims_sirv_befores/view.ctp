
var store_imsSirvBefore_imsSirvItemBefores = new Ext.data.Store({
	reader: new Ext.data.JsonReader({
		root:'rows',
		totalProperty: 'results',
		fields: [
			'id','ims_sirv_before','ims_item','measurement','quantity','unit_price','remark'		]
	}),
	proxy: new Ext.data.HttpProxy({
		url: '<?php echo $this->Html->url(array('controller' => 'imsSirvItemBefores', 'action' => 'list_data', $imsSirvBefore['ImsSirvBefore']['id'])); ?>'	})
});
		
<?php $imsSirvBefore_html = "<table cellspacing=3>" . 		"<tr><th align=right>" . __('Name', true) . ":</th><td><b>" . $imsSirvBefore['ImsSirvBefore']['name'] . "</b></td></tr>" . 
		"<tr><th align=right>" . __('Branch', true) . ":</th><td><b>" . $imsSirvBefore['Branch']['name'] . "</b></td></tr>" . 
		"<tr><th align=right>" . __('Created', true) . ":</th><td><b>" . $imsSirvBefore['ImsSirvBefore']['created'] . "</b></td></tr>" . 
		"<tr><th align=right>" . __('Modified', true) . ":</th><td><b>" . $imsSirvBefore['ImsSirvBefore']['modified'] . "</b></td></tr>" . 
"</table>"; 
?>
		var imsSirvBefore_view_panel_1 = {
			html : '<?php echo $imsSirvBefore_html; ?>',
			frame : true,
			height: 80
		}
		var imsSirvBefore_view_panel_2 = new Ext.TabPanel({
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
				store: store_imsSirvBefore_imsSirvItemBefores,
				title: '<?php __('ImsSirvItemBefores'); ?>',
				enableColumnMove: false,
				listeners: {
					activate: function(){
						if(store_imsSirvBefore_imsSirvItemBefores.getCount() == '')
							store_imsSirvBefore_imsSirvItemBefores.reload();
					}
				},
				columns: [
					{header: "<?php __('Ims Sirv Before'); ?>", dataIndex: 'ims_sirv_before', sortable: true}
,					{header: "<?php __('Ims Item'); ?>", dataIndex: 'ims_item', sortable: true}
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
					store: store_imsSirvBefore_imsSirvItemBefores,
					displayInfo: true,
					displayMsg: '<?php __('Displaying'); ?> {0} - {1} <?php __('of'); ?> {2}',
					beforePageText: '<?php __('Page'); ?>',
					afterPageText: '<?php __('of'); ?> {0}',
					emptyMsg: '<?php __('No data to display'); ?>'
				})
			}			]
		});

		var ImsSirvBeforeViewWindow = new Ext.Window({
			title: '<?php __('View ImsSirvBefore'); ?>: <?php echo $imsSirvBefore['ImsSirvBefore']['name']; ?>',
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
				imsSirvBefore_view_panel_1,
				imsSirvBefore_view_panel_2
			],

			buttons: [{
				text: '<?php __('Close'); ?>',
				handler: function(btn){
					ImsSirvBeforeViewWindow.close();
				}
			}]
		});
