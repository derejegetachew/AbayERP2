var store_parent_cmsReplies = new Ext.data.Store({
	reader: new Ext.data.JsonReader({
		root:'rows',
		totalProperty: 'results',
		fields: [
			'id','content','cms_case','user','created'	
		]
	}),
	proxy: new Ext.data.HttpProxy({
		url: '<?php echo $this->Html->url(array('controller' => 'cmsReplies', 'action' => 'list_data', $parent_id)); ?>'	})
});


function AddParentCmsReply() {
	Ext.Ajax.request({
		url: '<?php echo $this->Html->url(array('controller' => 'cmsReplies', 'action' => 'add', $parent_id)); ?>',
		success: function(response, opts) {
			var parent_cmsReply_data = response.responseText;
			
			eval(parent_cmsReply_data);
			
			CmsReplyAddWindow.show();
		},
		failure: function(response, opts) {
			Ext.Msg.alert('<?php __('Error'); ?>', '<?php __('Cannot get the cmsReply add form. Error code'); ?>: ' + response.status);
		}
	});
}

function EditParentCmsReply(id) {
	Ext.Ajax.request({
		url: '<?php echo $this->Html->url(array('controller' => 'cmsReplies', 'action' => 'edit')); ?>/'+id+'/<?php echo $parent_id; ?>',
		success: function(response, opts) {
			var parent_cmsReply_data = response.responseText;
			
			eval(parent_cmsReply_data);
			
			CmsReplyEditWindow.show();
		},
		failure: function(response, opts) {
			Ext.Msg.alert('<?php __('Error'); ?>', '<?php __('Cannot get the cmsReply edit form. Error code'); ?>: ' + response.status);
		}
	});
}

function ViewCmsReply(id) {
	Ext.Ajax.request({
		url: '<?php echo $this->Html->url(array('controller' => 'cmsReplies', 'action' => 'view')); ?>/'+id,
		success: function(response, opts) {
			var cmsReply_data = response.responseText;

			eval(cmsReply_data);

			CmsReplyViewWindow.show();
		},
		failure: function(response, opts) {
			Ext.Msg.alert('<?php __('Error'); ?>', '<?php __('Cannot get the cmsReply view form. Error code'); ?>: ' + response.status);
		}
	});
}

function ViewCmsReplyCmsAttachments(id) {
	Ext.Ajax.request({
		url: '<?php echo $this->Html->url(array('controller' => 'cmsAttachments', 'action' => 'index2')); ?>/'+id,
		success: function(response, opts) {
			var parent_cmsAttachments_data = response.responseText;

			eval(parent_cmsAttachments_data);

			parentCmsAttachmentsViewWindow.show();
		},
		failure: function(response, opts) {
			Ext.Msg.alert('<?php __('Error'); ?>', '<?php __('Cannot get the campus view form. Error code'); ?>: ' + response.status);
		}
	});
}


function DeleteParentCmsReply(id) {
	Ext.Ajax.request({
		url: '<?php echo $this->Html->url(array('controller' => 'cmsReplies', 'action' => 'delete')); ?>/'+id,
		success: function(response, opts) {
			Ext.Msg.alert('<?php __('Success'); ?>', '<?php __('CmsReply(s) successfully deleted!'); ?>');
			RefreshParentCmsReplyData();
		},
		failure: function(response, opts) {
			Ext.Msg.alert('<?php __('Error'); ?>', '<?php __('Cannot get the cmsReply to be deleted. Error code'); ?>: ' + response.status);
		}
	});
}

function SearchByParentCmsReplyName(value){
	var conditions = '\'CmsReply.name LIKE\' => \'%' + value + '%\'';
	store_parent_cmsReplies.reload({
		 params: {
			start: 0,
			limit: list_size,
			conditions: conditions
	    }
	});
}

function RefreshParentCmsReplyData() {
	store_parent_cmsReplies.reload();
}



var g = new Ext.grid.GridPanel({
	title: '<?php __('CmsReplies'); ?>',
	store: store_parent_cmsReplies,
	loadMask: true,
	stripeRows: true,
	height: 300,
	anchor: '100%',
    id: 'cmsReplyGrid',
	columns: [
		{header: "<?php __('Content'); ?>", dataIndex: 'content', sortable: true},
		{header:"<?php __('cms_case'); ?>", dataIndex: 'cms_case', sortable: true},
		{header:"<?php __('user'); ?>", dataIndex: 'user', sortable: true},
		{header: "<?php __('Created'); ?>", dataIndex: 'created', sortable: true}	],
	sm: new Ext.grid.RowSelectionModel({
		singleSelect: false
	}),
	viewConfig: {
		forceFit: true
	},
    listeners: {
        celldblclick: function(){
            ViewCmsReply(Ext.getCmp('cmsReplyGrid').getSelectionModel().getSelected().data.id);
        }
    },
	tbar: new Ext.Toolbar({
		items: [{
				xtype: 'tbbutton',
				text: '<?php __('Add'); ?>',
				tooltip:'<?php __('<b>Add CmsReply</b><br />Click here to create a new CmsReply'); ?>',
				icon: 'img/table_add.png',
				cls: 'x-btn-text-icon',
				handler: function(btn) {
					AddParentCmsReply();
				}
			}, ' ', '-', ' ', {
				xtype: 'tbbutton',
				text: '<?php __('Edit'); ?>',
				id: 'edit-parent-cmsReply',
				tooltip:'<?php __('<b>Edit CmsReply</b><br />Click here to modify the selected CmsReply'); ?>',
				icon: 'img/table_edit.png',
				cls: 'x-btn-text-icon',
				disabled: true,
				handler: function(btn) {
					var sm = g.getSelectionModel();
					var sel = sm.getSelected();
					if (sm.hasSelection()){
						EditParentCmsReply(sel.data.id);
					};
				}
			}, ' ', '-', ' ', {
				xtype: 'tbbutton',
				text: '<?php __('Delete'); ?>',
				id: 'delete-parent-cmsReply',
				tooltip:'<?php __('<b>Delete CmsReply(s)</b><br />Click here to remove the selected CmsReply(s)'); ?>',
				icon: 'img/table_delete.png',
				cls: 'x-btn-text-icon',
				disabled: true,
				handler: function(btn) {
					var sm = g.getSelectionModel();
					var sel = sm.getSelections();
					if (sm.hasSelection()){
						if(sel.length==1){
							Ext.Msg.show({
									title: '<?php __('Remove CmsReply'); ?>',
									buttons: Ext.MessageBox.YESNOCANCEL,
									msg: '<?php __('Remove'); ?> '+sel[0].data.name+'?',
									icon: Ext.MessageBox.QUESTION,
                                    fn: function(btn){
											if (btn == 'yes'){
													DeleteParentCmsReply(sel[0].data.id);
											}
									}
							});
						} else {
							Ext.Msg.show({
									title: '<?php __('Remove CmsReply'); ?>',
									buttons: Ext.MessageBox.YESNOCANCEL,
									msg: '<?php __('Remove the selected CmsReply'); ?>?',
									icon: Ext.MessageBox.QUESTION,
                                    fn: function(btn){
											if (btn == 'yes'){
													var sel_ids = '';
													for(i=0;i<sel.length;i++){
														if(i>0)
															sel_ids += '_';
														sel_ids += sel[i].data.id;
													}
													DeleteParentCmsReply(sel_ids);
											}
									}
							});
						}
					} else {
						Ext.Msg.alert('<?php __('Warning'); ?>', '<?php __('Please select a record first'); ?>');
					};
				}
			}, ' ','-',' ', {
				xtype: 'tbsplit',
				text: '<?php __('View CmsReply'); ?>',
				id: 'view-cmsReply2',
				tooltip:'<?php __('<b>View CmsReply</b><br />Click here to see details of the selected CmsReply'); ?>',
				icon: 'img/table_view.png',
				cls: 'x-btn-text-icon',
				disabled: true,
				handler: function(btn) {
					var sm = g.getSelectionModel();
					var sel = sm.getSelected();
					if (sm.hasSelection()){
						ViewCmsReply(sel.data.id);
					};
				},
				menu : {
					items: [
 {
						text: '<?php __('View Cms Attachments'); ?>',
                        icon: 'img/table_view.png',
						cls: 'x-btn-text-icon',
						handler: function(btn) {
							var sm = g.getSelectionModel();
							var sel = sm.getSelected();
							if (sm.hasSelection()){
								ViewCmsReplyCmsAttachments(sel.data.id);
							};
						}
					}
					]
				}

            }, ' ', '->', {
				xtype: 'textfield',
				emptyText: '<?php __('[Search By Name]'); ?>',
				id: 'parent_cmsReply_search_field',
				listeners: {
					specialkey: function(field, e){
						if (e.getKey() == e.ENTER) {
							SearchByParentCmsReplyName(Ext.getCmp('parent_cmsReply_search_field').getValue());
						}
					}

				}
			}, {
				xtype: 'tbbutton',
				icon: 'img/search.png',
				cls: 'x-btn-text-icon',
				text: 'GO',
				tooltip:'<?php __('<b>GO</b><br />Click here to get search results'); ?>',
				id: 'parent_cmsReply_go_button',
				handler: function(){
					SearchByParentCmsReplyName(Ext.getCmp('parent_cmsReply_search_field').getValue());
				}
			}, ' '
	]}),
	bbar: new Ext.PagingToolbar({
		pageSize: list_size,
		store: store_parent_cmsReplies,
		displayInfo: true,
		displayMsg: '<?php __('Displaying {0} - {1} of {2}'); ?>',
		beforePageText: '<?php __('Page'); ?>',
		afterPageText: '<?php __('of {0}'); ?>',
		emptyMsg: '<?php __('No data to display'); ?>'
	})
});
g.getSelectionModel().on('rowselect', function(sm, rowIdx, r) {
	g.getTopToolbar().findById('edit-parent-cmsReply').enable();
	g.getTopToolbar().findById('delete-parent-cmsReply').enable();
        g.getTopToolbar().findById('view-cmsReply2').enable();
	if(this.getSelections().length > 1){
		g.getTopToolbar().findById('edit-parent-cmsReply').disable();
                g.getTopToolbar().findById('view-cmsReply2').disable();
	}
});
g.getSelectionModel().on('rowdeselect', function(sm, rowIdx, r) {
	if(this.getSelections().length > 1){
		g.getTopToolbar().findById('edit-parent-cmsReply').disable();
		g.getTopToolbar().findById('delete-parent-cmsReply').enable();
                g.getTopToolbar().findById('view-cmsReply2').disable();
	}
	else if(this.getSelections().length == 1){
		g.getTopToolbar().findById('edit-parent-cmsReply').enable();
		g.getTopToolbar().findById('delete-parent-cmsReply').enable();
                g.getTopToolbar().findById('view-cmsReply2').enable();
	}
	else{
		g.getTopToolbar().findById('edit-parent-cmsReply').disable();
		g.getTopToolbar().findById('delete-parent-cmsReply').disable();
                g.getTopToolbar().findById('view-cmsReply2').disable();
	}
});



var parentCmsRepliesViewWindow = new Ext.Window({
	title: 'CmsReply Under the selected Item',
	width: 700,
	height:375,
	minWidth: 700,
	minHeight: 400,
	resizable: false,
	plain:true,
	bodyStyle:'padding:5px;',
	buttonAlign:'center',
        modal: true,
	items: [
		g
	],

	buttons: [{
		text: 'Close',
		handler: function(btn){
			parentCmsRepliesViewWindow.close();
		}
	}]
});

store_parent_cmsReplies.load({
    params: {
        start: 0,    
        limit: list_size
    }
});