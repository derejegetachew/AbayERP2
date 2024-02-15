
var store_imsSirvItemBefore_imsTags = new Ext.data.Store({
	reader: new Ext.data.JsonReader({
		root:'rows',
		totalProperty: 'results',
		fields: [
			'id','code','ims_sirv_item','ims_sirv_item_before','created','modified'		]
	}),
	proxy: new Ext.data.HttpProxy({
		url: '<?php echo $this->Html->url(array('controller' => 'imsTags', 'action' => 'list_data', $imsSirvItemBefore['ImsSirvItemBefore']['id'])); ?>'	})
});
		
<?php $imsSirvItemBefore_html = "<table cellspacing=3>" . 		"<tr><th align=right>" . __('Ims Sirv Before', true) . ":</th><td><b>" . $imsSirvItemBefore['ImsSirvBefore']['name'] . "</b></td></tr>" . 
		"<tr><th align=right>" . __('Ims Item', true) . ":</th><td><b>" . $imsSirvItemBefore['ImsItem']['name'] . "</b></td></tr>" . 
		"<tr><th align=right>" . __('Measurement', true) . ":</th><td><b>" . $imsSirvItemBefore['ImsSirvItemBefore']['measurement'] . "</b></td></tr>" . 
		"<tr><th align=right>" . __('Quantity', true) . ":</th><td><b>" . $imsSirvItemBefore['ImsSirvItemBefore']['quantity'] . "</b></td></tr>" . 
		"<tr><th align=right>" . __('Unit Price', true) . ":</th><td><b>" . $imsSirvItemBefore['ImsSirvItemBefore']['unit_price'] . "</b></td></tr>" . 
		"<tr><th align=right>" . __('Remark', true) . ":</th><td><b>" . $imsSirvItemBefore['ImsSirvItemBefore']['remark'] . "</b></td></tr>" . 
"</table>"; 
?>
		var imsSirvItemBefore_view_panel_1 = {
			html : '<?php echo $imsSirvItemBefore_html; ?>',
			frame : true,
			height: 80
		}
		var imsSirvItemBefore_view_panel_2 = new Ext.TabPanel({
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
				store: store_imsSirvItemBefore_imsTags,
				title: '<?php __('ImsTags'); ?>',
				enableColumnMove: false,
				listeners: {
					activate: function(){
						if(store_imsSirvItemBefore_imsTags.getCount() == '')
							store_imsSirvItemBefore_imsTags.reload();
					}
				},
				columns: [
					{header: "<?php __('Code'); ?>", dataIndex: 'code', sortable: true}
,					{header: "<?php __('Ims Sirv Item'); ?>", dataIndex: 'ims_sirv_item', sortable: true}
,					{header: "<?php __('Ims Sirv Item Before'); ?>", dataIndex: 'ims_sirv_item_before', sortable: true}
,					{header: "<?php __('Created'); ?>", dataIndex: 'created', sortable: true}
,					{header: "<?php __('Modified'); ?>", dataIndex: 'modified', sortable: true}
		
				],
				viewConfig: {
					forceFit: true
				},
				bbar: new Ext.PagingToolbar({
					pageSize: view_list_size,
					store: store_imsSirvItemBefore_imsTags,
					displayInfo: true,
					displayMsg: '<?php __('Displaying'); ?> {0} - {1} <?php __('of'); ?> {2}',
					beforePageText: '<?php __('Page'); ?>',
					afterPageText: '<?php __('of'); ?> {0}',
					emptyMsg: '<?php __('No data to display'); ?>'
				})
			}			]
		});

		var ImsSirvItemBeforeViewWindow = new Ext.Window({
			title: '<?php __('View ImsSirvItemBefore'); ?>: <?php echo $imsSirvItemBefore['ImsSirvItemBefore']['id']; ?>',
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
				imsSirvItemBefore_view_panel_1,
				imsSirvItemBefore_view_panel_2
			],

			buttons: [{
				text: '<?php __('Close'); ?>',
				handler: function(btn){
					ImsSirvItemBeforeViewWindow.close();
				}
			}]
		});
