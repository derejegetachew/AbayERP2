var store_parent_dmsMessages = new Ext.data.Store({
	reader: new Ext.data.JsonReader({
		root:'rows',
		totalProperty: 'results',
		fields: [
			'id','name','user','created','message','status','old_record','size','number'	
		]
	}),
	proxy: new Ext.data.HttpProxy({
		url: '<?php echo $this->Html->url(array('controller' => 'dmsMessages', 'action' => 'list_data', $parent_id)); ?>'	})
});


function AddParentDmsMessage() {
	Ext.Ajax.request({
		url: '<?php echo $this->Html->url(array('controller' => 'dmsMessages', 'action' => 'add', $parent_id)); ?>',
		success: function(response, opts) {
			var parent_dmsMessage_data = response.responseText;
			
			eval(parent_dmsMessage_data);
			
			DmsMessageAddWindow.show();
		},
		failure: function(response, opts) {
			Ext.Msg.alert('<?php __('Error'); ?>', '<?php __('Cannot get the dmsMessage add form. Error code'); ?>: ' + response.status);
		}
	});
}

function EditParentDmsMessage(id) {
	Ext.Ajax.request({
		url: '<?php echo $this->Html->url(array('controller' => 'dmsMessages', 'action' => 'edit')); ?>/'+id+'/<?php echo $parent_id; ?>',
		success: function(response, opts) {
			var parent_dmsMessage_data = response.responseText;
			
			eval(parent_dmsMessage_data);
			
			DmsMessageEditWindow.show();
		},
		failure: function(response, opts) {
			Ext.Msg.alert('<?php __('Error'); ?>', '<?php __('Cannot get the dmsMessage edit form. Error code'); ?>: ' + response.status);
		}
	});
}

function ViewDmsMessage(id) {
	Ext.Ajax.request({
		url: '<?php echo $this->Html->url(array('controller' => 'dmsMessages', 'action' => 'view')); ?>/'+id,
		success: function(response, opts) {
			var dmsMessage_data = response.responseText;

			eval(dmsMessage_data);

			DmsMessageViewWindow.show();
		},
		failure: function(response, opts) {
			Ext.Msg.alert('<?php __('Error'); ?>', '<?php __('Cannot get the dmsMessage view form. Error code'); ?>: ' + response.status);
		}
	});
}

function ViewDmsMessageDmsAttachments(id) {
	Ext.Ajax.request({
		url: '<?php echo $this->Html->url(array('controller' => 'dmsAttachments', 'action' => 'index2')); ?>/'+id,
		success: function(response, opts) {
			var parent_dmsAttachments_data = response.responseText;

			eval(parent_dmsAttachments_data);

			parentDmsAttachmentsViewWindow.show();
		},
		failure: function(response, opts) {
			Ext.Msg.alert('<?php __('Error'); ?>', '<?php __('Cannot get the campus view form. Error code'); ?>: ' + response.status);
		}
	});
}

function ViewDmsMessageDmsDocuments(id) {
	Ext.Ajax.request({
		url: '<?php echo $this->Html->url(array('controller' => 'dmsDocuments', 'action' => 'index2')); ?>/'+id,
		success: function(response, opts) {
			var parent_dmsDocuments_data = response.responseText;

			eval(parent_dmsDocuments_data);

			parentDmsDocumentsViewWindow.show();
		},
		failure: function(response, opts) {
			Ext.Msg.alert('<?php __('Error'); ?>', '<?php __('Cannot get the campus view form. Error code'); ?>: ' + response.status);
		}
	});
}

function ViewDmsMessageDmsRecipients(id) {
	Ext.Ajax.request({
		url: '<?php echo $this->Html->url(array('controller' => 'dmsRecipients', 'action' => 'index2')); ?>/'+id,
		success: function(response, opts) {
			var parent_dmsRecipients_data = response.responseText;

			eval(parent_dmsRecipients_data);

			parentDmsRecipientsViewWindow.show();
		},
		failure: function(response, opts) {
			Ext.Msg.alert('<?php __('Error'); ?>', '<?php __('Cannot get the campus view form. Error code'); ?>: ' + response.status);
		}
	});
}


function DeleteParentDmsMessage(id) {
	Ext.Ajax.request({
		url: '<?php echo $this->Html->url(array('controller' => 'dmsMessages', 'action' => 'delete')); ?>/'+id,
		success: function(response, opts) {
			Ext.Msg.alert('<?php __('Success'); ?>', '<?php __('DmsMessage(s) successfully deleted!'); ?>');
			RefreshParentDmsMessageData();
		},
		failure: function(response, opts) {
			Ext.Msg.alert('<?php __('Error'); ?>', '<?php __('Cannot get the dmsMessage to be deleted. Error code'); ?>: ' + response.status);
		}
	});
}

function SearchByParentDmsMessageName(value){
	var conditions = '\'DmsMessage.name LIKE\' => \'%' + value + '%\'';
	store_parent_dmsMessages.reload({
		 params: {
			start: 0,
			limit: list_size,
			conditions: conditions
	    }
	});
}

function RefreshParentDmsMessageData() {
	store_parent_dmsMessages.reload();
}



var g = new Ext.grid.GridPanel({
	title: '<?php __('DmsMessages'); ?>',
	store: store_parent_dmsMessages,
	loadMask: true,
	stripeRows: true,
	height: 300,
	anchor: '100%',
    id: 'dmsMessageGrid',
	columns: [
		{header: "<?php __('Name'); ?>", dataIndex: 'name', sortable: true},
		{header:"<?php __('user'); ?>", dataIndex: 'user', sortable: true},
		{header: "<?php __('Created'); ?>", dataIndex: 'created', sortable: true},
		{header: "<?php __('Message'); ?>", dataIndex: 'message', sortable: true},
		{header: "<?php __('Status'); ?>", dataIndex: 'status', sortable: true},
		{header: "<?php __('Old Record'); ?>", dataIndex: 'old_record', sortable: true},
		{header: "<?php __('Size'); ?>", dataIndex: 'size', sortable: true},
		{header: "<?php __('Number'); ?>", dataIndex: 'number', sortable: true}	],
	sm: new Ext.grid.RowSelectionModel({
		singleSelect: false
	}),
	viewConfig: {
		forceFit: true
	},
    listeners: {
        celldblclick: function(){
            ViewDmsMessage(Ext.getCmp('dmsMessageGrid').getSelectionModel().getSelected().data.id);
        }
    },
	tbar: new Ext.Toolbar({
		items: [{
				xtype: 'tbbutton',
				text: '<?php __('Add'); ?>',
				tooltip:'<?php __('<b>Add DmsMessage</b><br />Click here to create a new DmsMessage'); ?>',
				icon: 'img/table_add.png',
				cls: 'x-btn-text-icon',
				handler: function(btn) {
					AddParentDmsMessage();
				}
			}, ' ', '-', ' ', {
				xtype: 'tbbutton',
				text: '<?php __('Edit'); ?>',
				id: 'edit-parent-dmsMessage',
				tooltip:'<?php __('<b>Edit DmsMessage</b><br />Click here to modify the selected DmsMessage'); ?>',
				icon: 'img/table_edit.png',
				cls: 'x-btn-text-icon',
				disabled: true,
				handler: function(btn) {
					var sm = g.getSelectionModel();
					var sel = sm.getSelected();
					if (sm.hasSelection()){
						EditParentDmsMessage(sel.data.id);
					};
				}
			}, ' ', '-', ' ', {
				xtype: 'tbbutton',
				text: '<?php __('Delete'); ?>',
				id: 'delete-parent-dmsMessage',
				tooltip:'<?php __('<b>Delete DmsMessage(s)</b><br />Click here to remove the selected DmsMessage(s)'); ?>',
				icon: 'img/table_delete.png',
				cls: 'x-btn-text-icon',
				disabled: true,
				handler: function(btn) {
					var sm = g.getSelectionModel();
					var sel = sm.getSelections();
					if (sm.hasSelection()){
						if(sel.length==1){
							Ext.Msg.show({
									title: '<?php __('Remove DmsMessage'); ?>',
									buttons: Ext.MessageBox.YESNOCANCEL,
									msg: '<?php __('Remove'); ?> '+sel[0].data.name+'?',
									icon: Ext.MessageBox.QUESTION,
                                    fn: function(btn){
											if (btn == 'yes'){
													DeleteParentDmsMessage(sel[0].data.id);
											}
									}
							});
						} else {
							Ext.Msg.show({
									title: '<?php __('Remove DmsMessage'); ?>',
									buttons: Ext.MessageBox.YESNOCANCEL,
									msg: '<?php __('Remove the selected DmsMessage'); ?>?',
									icon: Ext.MessageBox.QUESTION,
                                    fn: function(btn){
											if (btn == 'yes'){
													var sel_ids = '';
													for(i=0;i<sel.length;i++){
														if(i>0)
															sel_ids += '_';
														sel_ids += sel[i].data.id;
													}
													DeleteParentDmsMessage(sel_ids);
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
				text: '<?php __('View DmsMessage'); ?>',
				id: 'view-dmsMessage2',
				tooltip:'<?php __('<b>View DmsMessage</b><br />Click here to see details of the selected DmsMessage'); ?>',
				icon: 'img/table_view.png',
				cls: 'x-btn-text-icon',
				disabled: true,
				handler: function(btn) {
					var sm = g.getSelectionModel();
					var sel = sm.getSelected();
					if (sm.hasSelection()){
						ViewDmsMessage(sel.data.id);
					};
				},
				menu : {
					items: [
 {
						text: '<?php __('View Dms Attachments'); ?>',
                        icon: 'img/table_view.png',
						cls: 'x-btn-text-icon',
						handler: function(btn) {
							var sm = g.getSelectionModel();
							var sel = sm.getSelected();
							if (sm.hasSelection()){
								ViewDmsMessageDmsAttachments(sel.data.id);
							};
						}
					}
, {
						text: '<?php __('View Dms Documents'); ?>',
                        icon: 'img/table_view.png',
						cls: 'x-btn-text-icon',
						handler: function(btn) {
							var sm = g.getSelectionModel();
							var sel = sm.getSelected();
							if (sm.hasSelection()){
								ViewDmsMessageDmsDocuments(sel.data.id);
							};
						}
					}
, {
						text: '<?php __('View Dms Recipients'); ?>',
                        icon: 'img/table_view.png',
						cls: 'x-btn-text-icon',
						handler: function(btn) {
							var sm = g.getSelectionModel();
							var sel = sm.getSelected();
							if (sm.hasSelection()){
								ViewDmsMessageDmsRecipients(sel.data.id);
							};
						}
					}
					]
				}

            }, ' ', '->', {
				xtype: 'textfield',
				emptyText: '<?php __('[Search By Name]'); ?>',
				id: 'parent_dmsMessage_search_field',
				listeners: {
					specialkey: function(field, e){
						if (e.getKey() == e.ENTER) {
							SearchByParentDmsMessageName(Ext.getCmp('parent_dmsMessage_search_field').getValue());
						}
					}

				}
			}, {
				xtype: 'tbbutton',
				icon: 'img/search.png',
				cls: 'x-btn-text-icon',
				text: 'GO',
				tooltip:'<?php __('<b>GO</b><br />Click here to get search results'); ?>',
				id: 'parent_dmsMessage_go_button',
				handler: function(){
					SearchByParentDmsMessageName(Ext.getCmp('parent_dmsMessage_search_field').getValue());
				}
			}, ' '
	]}),
	bbar: new Ext.PagingToolbar({
		pageSize: list_size,
		store: store_parent_dmsMessages,
		displayInfo: true,
		displayMsg: '<?php __('Displaying {0} - {1} of {2}'); ?>',
		beforePageText: '<?php __('Page'); ?>',
		afterPageText: '<?php __('of {0}'); ?>',
		emptyMsg: '<?php __('No data to display'); ?>'
	})
});
g.getSelectionModel().on('rowselect', function(sm, rowIdx, r) {
	g.getTopToolbar().findById('edit-parent-dmsMessage').enable();
	g.getTopToolbar().findById('delete-parent-dmsMessage').enable();
        g.getTopToolbar().findById('view-dmsMessage2').enable();
	if(this.getSelections().length > 1){
		g.getTopToolbar().findById('edit-parent-dmsMessage').disable();
                g.getTopToolbar().findById('view-dmsMessage2').disable();
	}
});
g.getSelectionModel().on('rowdeselect', function(sm, rowIdx, r) {
	if(this.getSelections().length > 1){
		g.getTopToolbar().findById('edit-parent-dmsMessage').disable();
		g.getTopToolbar().findById('delete-parent-dmsMessage').enable();
                g.getTopToolbar().findById('view-dmsMessage2').disable();
	}
	else if(this.getSelections().length == 1){
		g.getTopToolbar().findById('edit-parent-dmsMessage').enable();
		g.getTopToolbar().findById('delete-parent-dmsMessage').enable();
                g.getTopToolbar().findById('view-dmsMessage2').enable();
	}
	else{
		g.getTopToolbar().findById('edit-parent-dmsMessage').disable();
		g.getTopToolbar().findById('delete-parent-dmsMessage').disable();
                g.getTopToolbar().findById('view-dmsMessage2').disable();
	}
});



var parentDmsMessagesViewWindow = new Ext.Window({
	title: 'DmsMessage Under the selected Item',
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
			parentDmsMessagesViewWindow.close();
		}
	}]
});

store_parent_dmsMessages.load({
    params: {
        start: 0,    
        limit: list_size
    }
});