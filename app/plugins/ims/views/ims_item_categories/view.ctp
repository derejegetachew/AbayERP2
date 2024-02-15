
var store_itemCategory_childItemCategories = new Ext.data.Store({
	reader: new Ext.data.JsonReader({
		root:'rows',
		totalProperty: 'results',
		fields: [
			'id','name','parent','lft','rght','created','modified'		]
	}),
	proxy: new Ext.data.HttpProxy({
		url: '<?php echo $this->Html->url(array('controller' => 'childItemCategories', 'action' => 'list_data', $itemCategory['ItemCategory']['id'])); ?>'	})
});
var store_itemCategory_items = new Ext.data.Store({
	reader: new Ext.data.JsonReader({
		root:'rows',
		totalProperty: 'results',
		fields: [
			'id','name','description','item_category','created','modified'		]
	}),
	proxy: new Ext.data.HttpProxy({
		url: '<?php echo $this->Html->url(array('controller' => 'ims_items', 'action' => 'list_data', $itemCategory['ItemCategory']['id'])); ?>'	})
});
		
<?php $itemCategory_html = "<table cellspacing=3>" . 		"<tr><th align=right>" . __('Name', true) . ":</th><td><b>" . $itemCategory['ItemCategory']['name'] . "</b></td></tr>" . 
		"<tr><th align=right>" . __('Parent Item Category', true) . ":</th><td><b>" . $itemCategory['ParentItemCategory']['name'] . "</b></td></tr>" . 
		"<tr><th align=right>" . __('Lft', true) . ":</th><td><b>" . $itemCategory['ItemCategory']['lft'] . "</b></td></tr>" . 
		"<tr><th align=right>" . __('Rght', true) . ":</th><td><b>" . $itemCategory['ItemCategory']['rght'] . "</b></td></tr>" . 
		"<tr><th align=right>" . __('Created', true) . ":</th><td><b>" . $itemCategory['ItemCategory']['created'] . "</b></td></tr>" . 
		"<tr><th align=right>" . __('Modified', true) . ":</th><td><b>" . $itemCategory['ItemCategory']['modified'] . "</b></td></tr>" . 
"</table>"; 
?>
		var itemCategory_view_panel_1 = {
			html : '<?php echo $itemCategory_html; ?>',
			frame : true,
			height: 80
		}
		var itemCategory_view_panel_2 = new Ext.TabPanel({
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
				store: store_itemCategory_childItemCategories,
				title: '<?php __('ChildItemCategories'); ?>',
				enableColumnMove: false,
				listeners: {
					activate: function(){
						if(store_itemCategory_childItemCategories.getCount() == '')
							store_itemCategory_childItemCategories.reload();
					}
				},
				columns: [
					{header: "<?php __('Name'); ?>", dataIndex: 'name', sortable: true}
,					{header: "<?php __('Parent'); ?>", dataIndex: 'parent', sortable: true}
,					{header: "<?php __('Lft'); ?>", dataIndex: 'lft', sortable: true}
,					{header: "<?php __('Rght'); ?>", dataIndex: 'rght', sortable: true}
,					{header: "<?php __('Created'); ?>", dataIndex: 'created', sortable: true}
,					{header: "<?php __('Modified'); ?>", dataIndex: 'modified', sortable: true}
		
				],
				viewConfig: {
					forceFit: true
				},
				bbar: new Ext.PagingToolbar({
					pageSize: view_list_size,
					store: store_itemCategory_childItemCategories,
					displayInfo: true,
					displayMsg: '<?php __('Displaying'); ?> {0} - {1} <?php __('of'); ?> {2}',
					beforePageText: '<?php __('Page'); ?>',
					afterPageText: '<?php __('of'); ?> {0}',
					emptyMsg: '<?php __('No data to display'); ?>'
				})
			},
{
				xtype: 'grid',
				loadMask: true,
				stripeRows: true,
				store: store_itemCategory_items,
				title: '<?php __('Items'); ?>',
				enableColumnMove: false,
				listeners: {
					activate: function(){
						if(store_itemCategory_items.getCount() == '')
							store_itemCategory_items.reload();
					}
				},
				columns: [
					{header: "<?php __('Name'); ?>", dataIndex: 'name', sortable: true}
,					{header: "<?php __('Description'); ?>", dataIndex: 'description', sortable: true}
,					{header: "<?php __('Item Category'); ?>", dataIndex: 'item_category', sortable: true}
,					{header: "<?php __('Created'); ?>", dataIndex: 'created', sortable: true}
,					{header: "<?php __('Modified'); ?>", dataIndex: 'modified', sortable: true}
		
				],
				viewConfig: {
					forceFit: true
				},
				bbar: new Ext.PagingToolbar({
					pageSize: view_list_size,
					store: store_itemCategory_items,
					displayInfo: true,
					displayMsg: '<?php __('Displaying'); ?> {0} - {1} <?php __('of'); ?> {2}',
					beforePageText: '<?php __('Page'); ?>',
					afterPageText: '<?php __('of'); ?> {0}',
					emptyMsg: '<?php __('No data to display'); ?>'
				})
			}			]
		});

		var ItemCategoryViewWindow = new Ext.Window({
			title: '<?php __('View ItemCategory'); ?>: <?php echo $itemCategory['ItemCategory']['name']; ?>',
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
				itemCategory_view_panel_1,
				itemCategory_view_panel_2
			],

			buttons: [{
				text: '<?php __('Close'); ?>',
				handler: function(btn){
					ItemCategoryViewWindow.close();
				}
			}]
		});
