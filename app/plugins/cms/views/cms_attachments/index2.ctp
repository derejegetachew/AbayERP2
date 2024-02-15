//<script>
var store_parent_cmsAttachments = new Ext.data.Store({
	reader: new Ext.data.JsonReader({
		root:'rows',
		totalProperty: 'results',
		fields: [
			'id','file','name','created','cms_reply'	
		]
	}),
	proxy: new Ext.data.HttpProxy({
		url: '<?php echo $this->Html->url(array('controller' => 'cmsAttachments', 'action' => 'list_data', $parent_id)); ?>'	})
});


function AddParentCmsAttachment() {
	Ext.Ajax.request({
		url: '<?php echo $this->Html->url(array('controller' => 'cmsAttachments', 'action' => 'add', $parent_id)); ?>',
		success: function(response, opts) {
			var parent_cmsAttachment_data = response.responseText;
			
			eval(parent_cmsAttachment_data);
			
			CmsAttachmentAddWindow.show();
		},
		failure: function(response, opts) {
			Ext.Msg.alert('<?php __('Error'); ?>', '<?php __('Cannot get the cmsAttachment add form. Error code'); ?>: ' + response.status);
		}
	});
}

function EditParentCmsAttachment(id) {
	window.open('<?php echo $this->Html->url(array('controller' => 'cmsAttachments', 'action' => 'download')); ?>/'+id,'_blank');
}

function ViewCmsAttachment(id) {
	Ext.Ajax.request({
		url: '<?php echo $this->Html->url(array('controller' => 'cmsAttachments', 'action' => 'view')); ?>/'+id,
		success: function(response, opts) {
			var cmsAttachment_data = response.responseText;

			eval(cmsAttachment_data);

			CmsAttachmentViewWindow.show();
		},
		failure: function(response, opts) {
			Ext.Msg.alert('<?php __('Error'); ?>', '<?php __('Cannot get the cmsAttachment view form. Error code'); ?>: ' + response.status);
		}
	});
}


function DeleteParentCmsAttachment(id) {
	Ext.Ajax.request({
		url: '<?php echo $this->Html->url(array('controller' => 'cmsAttachments', 'action' => 'delete')); ?>/'+id,
		success: function(response, opts) {
			Ext.Msg.alert('<?php __('Success'); ?>', '<?php __('Attachment successfully deleted!'); ?>');
			RefreshParentCmsAttachmentData();
		},
		failure: function(response, opts) {
			Ext.Msg.alert('<?php __('Error'); ?>', '<?php __('Cannot get the Attachment to be deleted. Error code'); ?>: ' + response.status);
		}
	});
}

function SearchByParentCmsAttachmentName(value){
	var conditions = '\'CmsAttachment.name LIKE\' => \'%' + value + '%\'';
	store_parent_cmsAttachments.reload({
		 params: {
			start: 0,
			limit: list_size,
			conditions: conditions
	    }
	});
}

function RefreshParentCmsAttachmentData() {
	store_parent_cmsAttachments.reload();
}



var g = new Ext.grid.GridPanel({
	title: '<?php __('Attachments'); ?>',
	store: store_parent_cmsAttachments,
	loadMask: true,
	stripeRows: true,
	height: 300,
	anchor: '100%',
    id: 'cmsAttachmentGrid',
	columns: [
		{header: "<?php __('File'); ?>", dataIndex: 'file', sortable: true, hidden:true},
		{header: "<?php __('Name'); ?>", dataIndex: 'name', sortable: true},
		{header: "<?php __('Created'); ?>", dataIndex: 'created', sortable: true},
		{header:"<?php __('cms_reply'); ?>", dataIndex: 'cms_reply', sortable: true, hidden:true}	],
	sm: new Ext.grid.RowSelectionModel({
		singleSelect: false
	}),
	viewConfig: {
		forceFit: true
	},
    listeners: {
        celldblclick: function(){
           // ViewCmsAttachment(Ext.getCmp('cmsAttachmentGrid').getSelectionModel().getSelected().data.id);
        }
    },
	tbar: new Ext.Toolbar({
		items: [{
				xtype: 'tbbutton',
				text: '<?php __('Upload'); ?>',
				tooltip:'<?php __('<b>Add Attachment</b><br />Click here to create a new Attachment'); ?>',
				icon: 'img/table_add.png',
				cls: 'x-btn-text-icon',
				handler: function(btn) {
					AddParentCmsAttachment();
				}
			}, ' ', '-', ' ', {
				xtype: 'tbbutton',
				text: '<?php __('Delete'); ?>',
				id: 'delete-parent-cmsAttachment',
				tooltip:'<?php __('<b>Delete Attachment(s)</b><br />Click here to remove the selected Attachment'); ?>',
				icon: 'img/table_delete.png',
				cls: 'x-btn-text-icon',
				disabled: true,
				handler: function(btn) {
					var sm = g.getSelectionModel();
					var sel = sm.getSelections();
					if (sm.hasSelection()){
						if(sel.length==1){
							Ext.Msg.show({
									title: '<?php __('Remove Attachment'); ?>',
									buttons: Ext.MessageBox.YESNOCANCEL,
									msg: '<?php __('Remove'); ?> '+sel[0].data.name+'?',
									icon: Ext.MessageBox.QUESTION,
                                    fn: function(btn){
											if (btn == 'yes'){
													DeleteParentCmsAttachment(sel[0].data.id);
											}
									}
							});
						} else {
							Ext.Msg.show({
									title: '<?php __('Remove Attachment'); ?>',
									buttons: Ext.MessageBox.YESNOCANCEL,
									msg: '<?php __('Remove the selected Attachment'); ?>?',
									icon: Ext.MessageBox.QUESTION,
                                    fn: function(btn){
											if (btn == 'yes'){
													var sel_ids = '';
													for(i=0;i<sel.length;i++){
														if(i>0)
															sel_ids += '_';
														sel_ids += sel[i].data.id;
													}
													DeleteParentCmsAttachment(sel_ids);
											}
									}
							});
						}
					} else {
						Ext.Msg.alert('<?php __('Warning'); ?>', '<?php __('Please select a record first'); ?>');
					};
				}
			}, 
	]}),
	bbar: new Ext.PagingToolbar({
		pageSize: list_size,
		store: store_parent_cmsAttachments,
		displayInfo: true,
		displayMsg: '<?php __('Displaying {0} - {1} of {2}'); ?>',
		beforePageText: '<?php __('Page'); ?>',
		afterPageText: '<?php __('of {0}'); ?>',
		emptyMsg: '<?php __('No data to display'); ?>'
	})
});
g.getSelectionModel().on('rowselect', function(sm, rowIdx, r) {
	g.getTopToolbar().findById('edit-parent-cmsAttachment').enable();
	g.getTopToolbar().findById('delete-parent-cmsAttachment').enable();
	if(this.getSelections().length > 1){
		g.getTopToolbar().findById('edit-parent-cmsAttachment').disable();
	}
});
g.getSelectionModel().on('rowdeselect', function(sm, rowIdx, r) {
	if(this.getSelections().length > 1){
		g.getTopToolbar().findById('edit-parent-cmsAttachment').disable();
		g.getTopToolbar().findById('delete-parent-cmsAttachment').enable();
	}
	else if(this.getSelections().length == 1){
		g.getTopToolbar().findById('edit-parent-cmsAttachment').enable();
		g.getTopToolbar().findById('delete-parent-cmsAttachment').enable();
	}
	else{
		g.getTopToolbar().findById('edit-parent-cmsAttachment').disable();
		g.getTopToolbar().findById('delete-parent-cmsAttachment').disable();
	}
});



var parentCmsAttachmentsViewWindow = new Ext.Window({
	title: 'Attachment Under the selected Case',
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
		text: 'Finish',
		handler: function(btn){
			parentCmsAttachmentsViewWindow.close();
			RefreshCmsReplyData();
		}
	}]
});

store_parent_cmsAttachments.load({
    params: {
        start: 0,    
        limit: list_size
    }
});