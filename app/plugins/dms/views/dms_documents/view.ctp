
var store_dmsDocument_childDmsDocuments = new Ext.data.Store({
	reader: new Ext.data.JsonReader({
		root:'rows',
		totalProperty: 'results',
		fields: [
			'id','name','type','user','parent','shared','size','file_type','file_name','share_to','created','modified'		]
	}),
	proxy: new Ext.data.HttpProxy({
		url: '<?php echo $this->Html->url(array('controller' => 'childDmsDocuments', 'action' => 'list_data', $dmsDocument['DmsDocument']['id'])); ?>'	})
});
var store_dmsDocument_dmsShares = new Ext.data.Store({
	reader: new Ext.data.JsonReader({
		root:'rows',
		totalProperty: 'results',
		fields: [
			'id','dms_document','branch','user','read','write','delete','created','modified'		]
	}),
	proxy: new Ext.data.HttpProxy({
		url: '<?php echo $this->Html->url(array('controller' => 'dmsShares', 'action' => 'list_data', $dmsDocument['DmsDocument']['id'])); ?>'	})
});
		
<?php $dmsDocument_html = "<table cellspacing=3>" . 		"<tr><th align=right>" . __('Name', true) . ":</th><td><b>" . $dmsDocument['DmsDocument']['name'] . "</b></td></tr>" . 
		"<tr><th align=right>" . __('Type', true) . ":</th><td><b>" . $dmsDocument['DmsDocument']['type'] . "</b></td></tr>" . 
		"<tr><th align=right>" . __('User', true) . ":</th><td><b>" . $dmsDocument['User']['id'] . "</b></td></tr>" . 
		"<tr><th align=right>" . __('Parent Dms Document', true) . ":</th><td><b>" . $dmsDocument['ParentDmsDocument']['name'] . "</b></td></tr>" . 
		"<tr><th align=right>" . __('Shared', true) . ":</th><td><b>" . $dmsDocument['DmsDocument']['shared'] . "</b></td></tr>" . 
		"<tr><th align=right>" . __('Size', true) . ":</th><td><b>" . $dmsDocument['DmsDocument']['size'] . "</b></td></tr>" . 
		"<tr><th align=right>" . __('File Type', true) . ":</th><td><b>" . $dmsDocument['DmsDocument']['file_type'] . "</b></td></tr>" . 
		"<tr><th align=right>" . __('File Name', true) . ":</th><td><b>" . $dmsDocument['DmsDocument']['file_name'] . "</b></td></tr>" . 
		"<tr><th align=right>" . __('Share To', true) . ":</th><td><b>" . $dmsDocument['DmsDocument']['share_to'] . "</b></td></tr>" . 
		"<tr><th align=right>" . __('Created', true) . ":</th><td><b>" . $dmsDocument['DmsDocument']['created'] . "</b></td></tr>" . 
		"<tr><th align=right>" . __('Modified', true) . ":</th><td><b>" . $dmsDocument['DmsDocument']['modified'] . "</b></td></tr>" . 
"</table>"; 
?>
		var dmsDocument_view_panel_1 = {
			html : '<?php echo $dmsDocument_html; ?>',
			frame : true,
			height: 80
		}
		var dmsDocument_view_panel_2 = new Ext.TabPanel({
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
				store: store_dmsDocument_childDmsDocuments,
				title: '<?php __('ChildDmsDocuments'); ?>',
				enableColumnMove: false,
				listeners: {
					activate: function(){
						if(store_dmsDocument_childDmsDocuments.getCount() == '')
							store_dmsDocument_childDmsDocuments.reload();
					}
				},
				columns: [
					{header: "<?php __('Name'); ?>", dataIndex: 'name', sortable: true}
,					{header: "<?php __('Type'); ?>", dataIndex: 'type', sortable: true}
,					{header: "<?php __('User'); ?>", dataIndex: 'user', sortable: true}
,					{header: "<?php __('Parent'); ?>", dataIndex: 'parent', sortable: true}
,					{header: "<?php __('Shared'); ?>", dataIndex: 'shared', sortable: true}
,					{header: "<?php __('Size'); ?>", dataIndex: 'size', sortable: true}
,					{header: "<?php __('File Type'); ?>", dataIndex: 'file_type', sortable: true}
,					{header: "<?php __('File Name'); ?>", dataIndex: 'file_name', sortable: true}
,					{header: "<?php __('Share To'); ?>", dataIndex: 'share_to', sortable: true}
,					{header: "<?php __('Created'); ?>", dataIndex: 'created', sortable: true}
,					{header: "<?php __('Modified'); ?>", dataIndex: 'modified', sortable: true}
		
				],
				viewConfig: {
					forceFit: true
				},
				bbar: new Ext.PagingToolbar({
					pageSize: view_list_size,
					store: store_dmsDocument_childDmsDocuments,
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
				store: store_dmsDocument_dmsShares,
				title: '<?php __('DmsShares'); ?>',
				enableColumnMove: false,
				listeners: {
					activate: function(){
						if(store_dmsDocument_dmsShares.getCount() == '')
							store_dmsDocument_dmsShares.reload();
					}
				},
				columns: [
					{header: "<?php __('Dms Document'); ?>", dataIndex: 'dms_document', sortable: true}
,					{header: "<?php __('Branch'); ?>", dataIndex: 'branch', sortable: true}
,					{header: "<?php __('User'); ?>", dataIndex: 'user', sortable: true}
,					{header: "<?php __('Read'); ?>", dataIndex: 'read', sortable: true}
,					{header: "<?php __('Write'); ?>", dataIndex: 'write', sortable: true}
,					{header: "<?php __('Delete'); ?>", dataIndex: 'delete', sortable: true}
,					{header: "<?php __('Created'); ?>", dataIndex: 'created', sortable: true}
,					{header: "<?php __('Modified'); ?>", dataIndex: 'modified', sortable: true}
		
				],
				viewConfig: {
					forceFit: true
				},
				bbar: new Ext.PagingToolbar({
					pageSize: view_list_size,
					store: store_dmsDocument_dmsShares,
					displayInfo: true,
					displayMsg: '<?php __('Displaying'); ?> {0} - {1} <?php __('of'); ?> {2}',
					beforePageText: '<?php __('Page'); ?>',
					afterPageText: '<?php __('of'); ?> {0}',
					emptyMsg: '<?php __('No data to display'); ?>'
				})
			}			]
		});

		var DmsDocumentViewWindow = new Ext.Window({
			title: '<?php __('View DmsDocument'); ?>: <?php echo $dmsDocument['DmsDocument']['name']; ?>',
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
				dmsDocument_view_panel_1,
				dmsDocument_view_panel_2
			],

			buttons: [{
				text: '<?php __('Close'); ?>',
				handler: function(btn){
					DmsDocumentViewWindow.close();
				}
			}]
		});
