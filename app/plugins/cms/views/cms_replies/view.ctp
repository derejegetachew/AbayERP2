
var store_cmsReply_cmsAttachments = new Ext.data.Store({
	reader: new Ext.data.JsonReader({
		root:'rows',
		totalProperty: 'results',
		fields: [
			'id','file','name','created','cms_reply'		]
	}),
	proxy: new Ext.data.HttpProxy({
		url: '<?php echo $this->Html->url(array('controller' => 'cmsAttachments', 'action' => 'list_data', $cmsReply['CmsReply']['id'])); ?>'	})
});
		
<?php $cmsReply_html = "<table cellspacing=3>" . 		"<tr><th align=right>" . __('Content', true) . ":</th><td><b>" . $cmsReply['CmsReply']['content'] . "</b></td></tr>" . 
		"<tr><th align=right>" . __('Cms Case', true) . ":</th><td><b>" . $cmsReply['CmsCase']['name'] . "</b></td></tr>" . 
		"<tr><th align=right>" . __('User', true) . ":</th><td><b>" . $cmsReply['User']['id'] . "</b></td></tr>" . 
		"<tr><th align=right>" . __('Created', true) . ":</th><td><b>" . $cmsReply['CmsReply']['created'] . "</b></td></tr>" . 
"</table>"; 
?>
		var cmsReply_view_panel_1 = {
			html : '<?php echo $cmsReply_html; ?>',
			frame : true,
			height: 80
		}
		var cmsReply_view_panel_2 = new Ext.TabPanel({
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
				store: store_cmsReply_cmsAttachments,
				title: '<?php __('CmsAttachments'); ?>',
				enableColumnMove: false,
				listeners: {
					activate: function(){
						if(store_cmsReply_cmsAttachments.getCount() == '')
							store_cmsReply_cmsAttachments.reload();
					}
				},
				columns: [
					{header: "<?php __('File'); ?>", dataIndex: 'file', sortable: true}
,					{header: "<?php __('Name'); ?>", dataIndex: 'name', sortable: true}
,					{header: "<?php __('Created'); ?>", dataIndex: 'created', sortable: true}
,					{header: "<?php __('Cms Reply'); ?>", dataIndex: 'cms_reply', sortable: true}
		
				],
				viewConfig: {
					forceFit: true
				},
				bbar: new Ext.PagingToolbar({
					pageSize: view_list_size,
					store: store_cmsReply_cmsAttachments,
					displayInfo: true,
					displayMsg: '<?php __('Displaying'); ?> {0} - {1} <?php __('of'); ?> {2}',
					beforePageText: '<?php __('Page'); ?>',
					afterPageText: '<?php __('of'); ?> {0}',
					emptyMsg: '<?php __('No data to display'); ?>'
				})
			}			]
		});

		var CmsReplyViewWindow = new Ext.Window({
			title: '<?php __('View CmsReply'); ?>: <?php echo $cmsReply['CmsReply']['id']; ?>',
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
				cmsReply_view_panel_1,
				cmsReply_view_panel_2
			],

			buttons: [{
				text: '<?php __('Close'); ?>',
				handler: function(btn){
					CmsReplyViewWindow.close();
				}
			}]
		});
