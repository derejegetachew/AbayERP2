//<script>
var store_parent_dmsAttachments = new Ext.data.Store({
	reader: new Ext.data.JsonReader({
		root:'rows',
		totalProperty: 'results',
		fields: [
			'id','file','name','created'
		]
	}),
	proxy: new Ext.data.HttpProxy({
		url: '<?php echo $this->Html->url(array('controller' => 'dmsAttachments', 'action' => 'list_data', $parent_id)); ?>'	})
});


function AddParentDmsAttachment() {
	Ext.Ajax.request({
		url: '<?php echo $this->Html->url(array('controller' => 'dmsAttachments', 'action' => 'add', $parent_id)); ?>',
		success: function(response, opts) {
			var parent_dmsAttachment_data = response.responseText;
			
			eval(parent_dmsAttachment_data);
			
			DmsAttachmentAddWindow.show();
		},
		failure: function(response, opts) {
			Ext.Msg.alert('<?php __('Error'); ?>', '<?php __('Cannot get the dmsAttachment add form. Error code'); ?>: ' + response.status);
		}
	});
}

function EditParentDmsAttachment(id) {
	window.open('<?php echo $this->Html->url(array('controller' => 'dmsAttachments', 'action' => 'download')); ?>/'+id,'_blank');
}

function ViewDmsAttachment(id) {
	Ext.Ajax.request({
		url: '<?php echo $this->Html->url(array('controller' => 'dmsAttachments', 'action' => 'view')); ?>/'+id,
		success: function(response, opts) {
			var dmsAttachment_data = response.responseText;

			eval(dmsAttachment_data);

			DmsAttachmentViewWindow.show();
		},
		failure: function(response, opts) {
			Ext.Msg.alert('<?php __('Error'); ?>', '<?php __('Cannot get the dmsAttachment view form. Error code'); ?>: ' + response.status);
		}
	});
}


function DeleteParentDmsAttachment(id) {
	Ext.Ajax.request({
		url: '<?php echo $this->Html->url(array('controller' => 'dmsAttachments', 'action' => 'delete')); ?>/'+id,
		success: function(response, opts) {
			Ext.Msg.alert('<?php __('Success'); ?>', '<?php __('Attachment successfully deleted!'); ?>');
			RefreshParentDmsAttachmentData();
		},
		failure: function(response, opts) {
			Ext.Msg.alert('<?php __('Error'); ?>', '<?php __('Cannot get the Attachment to be deleted. Error code'); ?>: ' + response.status);
		}
	});
}

function SearchByParentDmsAttachmentName(value){
	var conditions = '\'DmsAttachment.name LIKE\' => \'%' + value + '%\'';
	store_parent_dmsAttachments.reload({
		 params: {
			start: 0,
			limit: list_size,
			conditions: conditions
	    }
	});
}

function RefreshParentDmsAttachmentData() {
	store_parent_dmsAttachments.reload();
}



var g = new Ext.grid.GridPanel({
	title: '<?php __('Attachments'); ?>',
	store: store_parent_dmsAttachments,
	loadMask: true,
	stripeRows: true,
	height: 300,
	anchor: '100%',
    id: 'dmsAttachmentGrid',
	columns: [
		{header: "<?php __('File'); ?>", dataIndex: 'file', sortable: true, hidden:true},
		{header: "<?php __('Name'); ?>", dataIndex: 'name', sortable: true},
		{header: "<?php __('Created'); ?>", dataIndex: 'created', sortable: true}],
	sm: new Ext.grid.RowSelectionModel({
		singleSelect: false
	}),
	viewConfig: {
		forceFit: true
	},
    listeners: {
        celldblclick: function(){
           // ViewDmsAttachment(Ext.getCmp('dmsAttachmentGrid').getSelectionModel().getSelected().data.id);
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
					AddParentDmsAttachment();
				}
			}, ' ', '-', ' ', {
				xtype: 'tbbutton',
				text: '<?php __('Delete'); ?>',
				id: 'delete-parent-dmsAttachment',
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
													DeleteParentDmsAttachment(sel[0].data.id);
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
													DeleteParentDmsAttachment(sel_ids);
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
		store: store_parent_dmsAttachments,
		displayInfo: true,
		displayMsg: '<?php __('Displaying {0} - {1} of {2}'); ?>',
		beforePageText: '<?php __('Page'); ?>',
		afterPageText: '<?php __('of {0}'); ?>',
		emptyMsg: '<?php __('No data to display'); ?>'
	})
});
g.getSelectionModel().on('rowselect', function(sm, rowIdx, r) {
	g.getTopToolbar().findById('delete-parent-dmsAttachment').enable();
	if(this.getSelections().length > 1){
	}
});
g.getSelectionModel().on('rowdeselect', function(sm, rowIdx, r) {
	if(this.getSelections().length > 1){
		g.getTopToolbar().findById('delete-parent-dmsAttachment').enable();
	}
	else if(this.getSelections().length == 1){
		g.getTopToolbar().findById('delete-parent-dmsAttachment').enable();
	}
	else{
		g.getTopToolbar().findById('delete-parent-dmsAttachment').disable();
	}
});



var parentDmsAttachmentsViewWindow = new Ext.Window({
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
			parentDmsAttachmentsViewWindow.close();
			RefreshDmsReplyData();
		}
	}]
});

store_parent_dmsAttachments.load({
    params: {
        start: 0,    
        limit: list_size
    }
});