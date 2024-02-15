
var store_dmsMessage_dmsAttachments = new Ext.data.Store({
	reader: new Ext.data.JsonReader({
		root:'rows',
		totalProperty: 'results',
		fields: [
			'id','name','file','dms_message','created'		]
	}),
	proxy: new Ext.data.HttpProxy({
		url: '<?php echo $this->Html->url(array('controller' => 'dmsAttachments', 'action' => 'list_data', $dmsMessage['DmsMessage']['id'])); ?>'	})
});
var store_dmsMessage_dmsDocuments = new Ext.data.Store({
	reader: new Ext.data.JsonReader({
		root:'rows',
		totalProperty: 'results',
		fields: [
			'id','name','type','user','parent','shared','size','file_type','file_name','share_to','created','modified','read','dms_message'		]
	}),
	proxy: new Ext.data.HttpProxy({
		url: '<?php echo $this->Html->url(array('controller' => 'dmsDocuments', 'action' => 'list_data', $dmsMessage['DmsMessage']['id'])); ?>'	})
});
var store_dmsMessage_dmsRecipients = new Ext.data.Store({
	reader: new Ext.data.JsonReader({
		root:'rows',
		totalProperty: 'results',
		fields: [
			'id','dms_message','user'		]
	}),
	proxy: new Ext.data.HttpProxy({
		url: '<?php echo $this->Html->url(array('controller' => 'dmsRecipients', 'action' => 'list_data', $dmsMessage['DmsMessage']['id'])); ?>'	})
});
		
<?php $dmsMessage_html = "<table cellspacing=3>" . 		"<tr><th align=right>" . __('Name', true) . ":</th><td><b>" . $dmsMessage['DmsMessage']['name'] . "</b></td></tr>" . 
		"<tr><th align=right>" . __('User', true) . ":</th><td><b>" . $dmsMessage['User']['id'] . "</b></td></tr>" . 
		"<tr><th align=right>" . __('Created', true) . ":</th><td><b>" . $dmsMessage['DmsMessage']['created'] . "</b></td></tr>" . 
		"<tr><th align=right>" . __('Message', true) . ":</th><td><b>" . $dmsMessage['DmsMessage']['message'] . "</b></td></tr>" . 
		"<tr><th align=right>" . __('Status', true) . ":</th><td><b>" . $dmsMessage['DmsMessage']['status'] . "</b></td></tr>" . 
		"<tr><th align=right>" . __('Old Record', true) . ":</th><td><b>" . $dmsMessage['DmsMessage']['old_record'] . "</b></td></tr>" . 
		"<tr><th align=right>" . __('Size', true) . ":</th><td><b>" . $dmsMessage['DmsMessage']['size'] . "</b></td></tr>" . 
		"<tr><th align=right>" . __('Number', true) . ":</th><td><b>" . $dmsMessage['DmsMessage']['number'] . "</b></td></tr>" . 
"</table>"; 
?>
		var dmsMessage_view_panel_1 = {
			html : '<?php echo $dmsMessage_html; ?>',
			frame : true,
			height: 80
		}
		var dmsMessage_view_panel_2 = new Ext.TabPanel({
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
				store: store_dmsMessage_dmsAttachments,
				title: '<?php __('DmsAttachments'); ?>',
				enableColumnMove: false,
				listeners: {
					activate: function(){
						if(store_dmsMessage_dmsAttachments.getCount() == '')
							store_dmsMessage_dmsAttachments.reload();
					}
				},
				columns: [
					{header: "<?php __('Name'); ?>", dataIndex: 'name', sortable: true}
,					{header: "<?php __('File'); ?>", dataIndex: 'file', sortable: true}
,					{header: "<?php __('Dms Message'); ?>", dataIndex: 'dms_message', sortable: true}
,					{header: "<?php __('Created'); ?>", dataIndex: 'created', sortable: true}
		
				],
				viewConfig: {
					forceFit: true
				},
				bbar: new Ext.PagingToolbar({
					pageSize: view_list_size,
					store: store_dmsMessage_dmsAttachments,
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
				store: store_dmsMessage_dmsDocuments,
				title: '<?php __('DmsDocuments'); ?>',
				enableColumnMove: false,
				listeners: {
					activate: function(){
						if(store_dmsMessage_dmsDocuments.getCount() == '')
							store_dmsMessage_dmsDocuments.reload();
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
,					{header: "<?php __('Read'); ?>", dataIndex: 'read', sortable: true}
,					{header: "<?php __('Dms Message'); ?>", dataIndex: 'dms_message', sortable: true}
		
				],
				viewConfig: {
					forceFit: true
				},
				bbar: new Ext.PagingToolbar({
					pageSize: view_list_size,
					store: store_dmsMessage_dmsDocuments,
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
				store: store_dmsMessage_dmsRecipients,
				title: '<?php __('DmsRecipients'); ?>',
				enableColumnMove: false,
				listeners: {
					activate: function(){
						if(store_dmsMessage_dmsRecipients.getCount() == '')
							store_dmsMessage_dmsRecipients.reload();
					}
				},
				columns: [
					{header: "<?php __('Dms Message'); ?>", dataIndex: 'dms_message', sortable: true}
,					{header: "<?php __('User'); ?>", dataIndex: 'user', sortable: true}
		
				],
				viewConfig: {
					forceFit: true
				},
				bbar: new Ext.PagingToolbar({
					pageSize: view_list_size,
					store: store_dmsMessage_dmsRecipients,
					displayInfo: true,
					displayMsg: '<?php __('Displaying'); ?> {0} - {1} <?php __('of'); ?> {2}',
					beforePageText: '<?php __('Page'); ?>',
					afterPageText: '<?php __('of'); ?> {0}',
					emptyMsg: '<?php __('No data to display'); ?>'
				})
			}			]
		});

		var DmsMessageViewWindow = new Ext.Window({
			title: '<?php __('View DmsMessage'); ?>: <?php echo $dmsMessage['DmsMessage']['name']; ?>',
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
				dmsMessage_view_panel_1,
				dmsMessage_view_panel_2
			],

			buttons: [{
				text: '<?php __('Close'); ?>',
				handler: function(btn){
					DmsMessageViewWindow.close();
				}
			}]
		});
