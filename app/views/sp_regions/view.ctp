
var store_spRegion_branches = new Ext.data.Store({
	reader: new Ext.data.JsonReader({
		root:'rows',
		totalProperty: 'results',
		fields: [
			'id','name','list_order','fc_code','created','modified','bank','sp_region'		]
	}),
	proxy: new Ext.data.HttpProxy({
		url: '<?php echo $this->Html->url(array('controller' => 'branches', 'action' => 'list_data', $spRegion['SpRegion']['id'])); ?>'	})
});
		
<?php $spRegion_html = "<table cellspacing=3>" . 		"<tr><th align=right>" . __('Name', true) . ":</th><td><b>" . $spRegion['SpRegion']['name'] . "</b></td></tr>" . 
		"<tr><th align=right>" . __('Created', true) . ":</th><td><b>" . $spRegion['SpRegion']['created'] . "</b></td></tr>" . 
		"<tr><th align=right>" . __('Modified', true) . ":</th><td><b>" . $spRegion['SpRegion']['modified'] . "</b></td></tr>" . 
"</table>"; 
?>
		var spRegion_view_panel_1 = {
			html : '<?php echo $spRegion_html; ?>',
			frame : true,
			height: 80
		}
		var spRegion_view_panel_2 = new Ext.TabPanel({
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
				store: store_spRegion_branches,
				title: '<?php __('Branches'); ?>',
				enableColumnMove: false,
				listeners: {
					activate: function(){
						if(store_spRegion_branches.getCount() == '')
							store_spRegion_branches.reload();
					}
				},
				columns: [
					{header: "<?php __('Name'); ?>", dataIndex: 'name', sortable: true}
,					{header: "<?php __('List Order'); ?>", dataIndex: 'list_order', sortable: true}
,					{header: "<?php __('Fc Code'); ?>", dataIndex: 'fc_code', sortable: true}
,					{header: "<?php __('Created'); ?>", dataIndex: 'created', sortable: true}
,					{header: "<?php __('Modified'); ?>", dataIndex: 'modified', sortable: true}
,					{header: "<?php __('Bank'); ?>", dataIndex: 'bank', sortable: true}
,					{header: "<?php __('Sp Region'); ?>", dataIndex: 'sp_region', sortable: true}
		
				],
				viewConfig: {
					forceFit: true
				},
				bbar: new Ext.PagingToolbar({
					pageSize: view_list_size,
					store: store_spRegion_branches,
					displayInfo: true,
					displayMsg: '<?php __('Displaying'); ?> {0} - {1} <?php __('of'); ?> {2}',
					beforePageText: '<?php __('Page'); ?>',
					afterPageText: '<?php __('of'); ?> {0}',
					emptyMsg: '<?php __('No data to display'); ?>'
				})
			}			]
		});

		var SpRegionViewWindow = new Ext.Window({
			title: '<?php __('View SpRegion'); ?>: <?php echo $spRegion['SpRegion']['name']; ?>',
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
				spRegion_view_panel_1,
				spRegion_view_panel_2
			],

			buttons: [{
				text: '<?php __('Close'); ?>',
				handler: function(btn){
					SpRegionViewWindow.close();
				}
			}]
		});
