
var store_spItemGroup_childSpItemGroups = new Ext.data.Store({
	reader: new Ext.data.JsonReader({
		root:'rows',
		totalProperty: 'results',
		fields: [
			'id','name','parent','created','modified'		]
	}),
	proxy: new Ext.data.HttpProxy({
		url: '<?php echo $this->Html->url(array('controller' => 'childSpItemGroups', 'action' => 'list_data', $spItemGroup['SpItemGroup']['id'])); ?>'	})
});
var store_spItemGroup_spItems = new Ext.data.Store({
	reader: new Ext.data.JsonReader({
		root:'rows',
		totalProperty: 'results',
		fields: [
			'id','name','desc','price','um','sp_item_group','created','modified'		]
	}),
	proxy: new Ext.data.HttpProxy({
		url: '<?php echo $this->Html->url(array('controller' => 'spItems', 'action' => 'list_data', $spItemGroup['SpItemGroup']['id'])); ?>'	})
});
		
<?php $spItemGroup_html = "<table cellspacing=3>" . 		"<tr><th align=right>" . __('Name', true) . ":</th><td><b>" . $spItemGroup['SpItemGroup']['name'] . "</b></td></tr>" . 
		"<tr><th align=right>" . __('Parent Sp Item Group', true) . ":</th><td><b>" . $spItemGroup['ParentSpItemGroup']['name'] . "</b></td></tr>" . 
		"<tr><th align=right>" . __('Created', true) . ":</th><td><b>" . $spItemGroup['SpItemGroup']['created'] . "</b></td></tr>" . 
		"<tr><th align=right>" . __('Modified', true) . ":</th><td><b>" . $spItemGroup['SpItemGroup']['modified'] . "</b></td></tr>" . 
"</table>"; 
?>
		var spItemGroup_view_panel_1 = {
			html : '<?php echo $spItemGroup_html; ?>',
			frame : true,
			height: 80
		}
		var spItemGroup_view_panel_2 = new Ext.TabPanel({
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
				store: store_spItemGroup_childSpItemGroups,
				title: '<?php __('ChildSpItemGroups'); ?>',
				enableColumnMove: false,
				listeners: {
					activate: function(){
						if(store_spItemGroup_childSpItemGroups.getCount() == '')
							store_spItemGroup_childSpItemGroups.reload();
					}
				},
				columns: [
					{header: "<?php __('Name'); ?>", dataIndex: 'name', sortable: true}
,					{header: "<?php __('Parent'); ?>", dataIndex: 'parent', sortable: true}
,					{header: "<?php __('Created'); ?>", dataIndex: 'created', sortable: true}
,					{header: "<?php __('Modified'); ?>", dataIndex: 'modified', sortable: true}
		
				],
				viewConfig: {
					forceFit: true
				},
				bbar: new Ext.PagingToolbar({
					pageSize: view_list_size,
					store: store_spItemGroup_childSpItemGroups,
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
				store: store_spItemGroup_spItems,
				title: '<?php __('SpItems'); ?>',
				enableColumnMove: false,
				listeners: {
					activate: function(){
						if(store_spItemGroup_spItems.getCount() == '')
							store_spItemGroup_spItems.reload();
					}
				},
				columns: [
					{header: "<?php __('Name'); ?>", dataIndex: 'name', sortable: true}
,					{header: "<?php __('Desc'); ?>", dataIndex: 'desc', sortable: true}
,					{header: "<?php __('Price'); ?>", dataIndex: 'price', sortable: true}
,					{header: "<?php __('Um'); ?>", dataIndex: 'um', sortable: true}
,					{header: "<?php __('Sp Item Group'); ?>", dataIndex: 'sp_item_group', sortable: true}
,					{header: "<?php __('Created'); ?>", dataIndex: 'created', sortable: true}
,					{header: "<?php __('Modified'); ?>", dataIndex: 'modified', sortable: true}
		
				],
				viewConfig: {
					forceFit: true
				},
				bbar: new Ext.PagingToolbar({
					pageSize: view_list_size,
					store: store_spItemGroup_spItems,
					displayInfo: true,
					displayMsg: '<?php __('Displaying'); ?> {0} - {1} <?php __('of'); ?> {2}',
					beforePageText: '<?php __('Page'); ?>',
					afterPageText: '<?php __('of'); ?> {0}',
					emptyMsg: '<?php __('No data to display'); ?>'
				})
			}			]
		});

		var SpItemGroupViewWindow = new Ext.Window({
			title: '<?php __('View SpItemGroup'); ?>: <?php echo $spItemGroup['SpItemGroup']['name']; ?>',
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
				spItemGroup_view_panel_1,
				spItemGroup_view_panel_2
			],

			buttons: [{
				text: '<?php __('Close'); ?>',
				handler: function(btn){
					SpItemGroupViewWindow.close();
				}
			}]
		});
