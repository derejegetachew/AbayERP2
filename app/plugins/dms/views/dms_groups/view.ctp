
var store_dmsGroup_dmsGroupLists = new Ext.data.Store({
	reader: new Ext.data.JsonReader({
		root:'rows',
		totalProperty: 'results',
		fields: [
			'id','user','dms_group'		]
	}),
	proxy: new Ext.data.HttpProxy({
		url: '<?php echo $this->Html->url(array('controller' => 'dmsGroupLists', 'action' => 'list_data', $dmsGroup['DmsGroup']['id'])); ?>'	})
});
		
<?php $dmsGroup_html = "<table cellspacing=3>" . 		"<tr><th align=right>" . __('Name', true) . ":</th><td><b>" . $dmsGroup['DmsGroup']['name'] . "</b></td></tr>" . 
		"<tr><th align=right>" . __('User', true) . ":</th><td><b>" . $dmsGroup['User']['id'] . "</b></td></tr>" . 
		"<tr><th align=right>" . __('Public', true) . ":</th><td><b>" . $dmsGroup['DmsGroup']['public'] . "</b></td></tr>" . 
		"<tr><th align=right>" . __('Created', true) . ":</th><td><b>" . $dmsGroup['DmsGroup']['created'] . "</b></td></tr>" . 
"</table>"; 
?>
		var dmsGroup_view_panel_1 = {
			html : '<?php echo $dmsGroup_html; ?>',
			frame : true,
			height: 80
		}
		var dmsGroup_view_panel_2 = new Ext.TabPanel({
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
				store: store_dmsGroup_dmsGroupLists,
				title: '<?php __('DmsGroupLists'); ?>',
				enableColumnMove: false,
				listeners: {
					activate: function(){
						if(store_dmsGroup_dmsGroupLists.getCount() == '')
							store_dmsGroup_dmsGroupLists.reload();
					}
				},
				columns: [
					{header: "<?php __('User'); ?>", dataIndex: 'user', sortable: true}
,					{header: "<?php __('Dms Group'); ?>", dataIndex: 'dms_group', sortable: true}
		
				],
				viewConfig: {
					forceFit: true
				},
				bbar: new Ext.PagingToolbar({
					pageSize: view_list_size,
					store: store_dmsGroup_dmsGroupLists,
					displayInfo: true,
					displayMsg: '<?php __('Displaying'); ?> {0} - {1} <?php __('of'); ?> {2}',
					beforePageText: '<?php __('Page'); ?>',
					afterPageText: '<?php __('of'); ?> {0}',
					emptyMsg: '<?php __('No data to display'); ?>'
				})
			}			]
		});

		var DmsGroupViewWindow = new Ext.Window({
			title: '<?php __('View DmsGroup'); ?>: <?php echo $dmsGroup['DmsGroup']['name']; ?>',
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
				dmsGroup_view_panel_1,
				dmsGroup_view_panel_2
			],

			buttons: [{
				text: '<?php __('Close'); ?>',
				handler: function(btn){
					DmsGroupViewWindow.close();
				}
			}]
		});
