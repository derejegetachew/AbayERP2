var store_parent_dmsDocuments = new Ext.data.Store({
	reader: new Ext.data.JsonReader({
		root:'rows',
		totalProperty: 'results',
		fields: [
			'id','name','type','user','parent_dms_document','shared','size','file_type','file_name','share_to','created','modified'	
		]
	}),
	proxy: new Ext.data.HttpProxy({
		url: '<?php echo $this->Html->url(array('controller' => 'dmsDocuments', 'action' => 'list_data', $parent_id)); ?>'	})
});


function AddParentDmsDocument() {
	Ext.Ajax.request({
		url: '<?php echo $this->Html->url(array('controller' => 'dmsDocuments', 'action' => 'add', $parent_id)); ?>',
		success: function(response, opts) {
			var parent_dmsDocument_data = response.responseText;
			
			eval(parent_dmsDocument_data);
			
			DmsDocumentAddWindow.show();
		},
		failure: function(response, opts) {
			Ext.Msg.alert('<?php __('Error'); ?>', '<?php __('Cannot get the dmsDocument add form. Error code'); ?>: ' + response.status);
		}
	});
}

function EditParentDmsDocument(id) {
	Ext.Ajax.request({
		url: '<?php echo $this->Html->url(array('controller' => 'dmsDocuments', 'action' => 'edit')); ?>/'+id+'/<?php echo $parent_id; ?>',
		success: function(response, opts) {
			var parent_dmsDocument_data = response.responseText;
			
			eval(parent_dmsDocument_data);
			
			DmsDocumentEditWindow.show();
		},
		failure: function(response, opts) {
			Ext.Msg.alert('<?php __('Error'); ?>', '<?php __('Cannot get the dmsDocument edit form. Error code'); ?>: ' + response.status);
		}
	});
}

function ViewDmsDocument(id) {
	Ext.Ajax.request({
		url: '<?php echo $this->Html->url(array('controller' => 'dmsDocuments', 'action' => 'view')); ?>/'+id,
		success: function(response, opts) {
			var dmsDocument_data = response.responseText;

			eval(dmsDocument_data);

			DmsDocumentViewWindow.show();
		},
		failure: function(response, opts) {
			Ext.Msg.alert('<?php __('Error'); ?>', '<?php __('Cannot get the dmsDocument view form. Error code'); ?>: ' + response.status);
		}
	});
}

function ViewDmsDocumentDmsDocuments(id) {
	Ext.Ajax.request({
		url: '<?php echo $this->Html->url(array('controller' => 'childDmsDocuments', 'action' => 'index2')); ?>/'+id,
		success: function(response, opts) {
			var parent_childDmsDocuments_data = response.responseText;

			eval(parent_childDmsDocuments_data);

			parentDmsDocumentsViewWindow.show();
		},
		failure: function(response, opts) {
			Ext.Msg.alert('<?php __('Error'); ?>', '<?php __('Cannot get the campus view form. Error code'); ?>: ' + response.status);
		}
	});
}

function ViewDmsDocumentDmsShares(id) {
	Ext.Ajax.request({
		url: '<?php echo $this->Html->url(array('controller' => 'dmsShares', 'action' => 'index2')); ?>/'+id,
		success: function(response, opts) {
			var parent_dmsShares_data = response.responseText;

			eval(parent_dmsShares_data);

			parentDmsSharesViewWindow.show();
		},
		failure: function(response, opts) {
			Ext.Msg.alert('<?php __('Error'); ?>', '<?php __('Cannot get the campus view form. Error code'); ?>: ' + response.status);
		}
	});
}


function DeleteParentDmsDocument(id) {
	Ext.Ajax.request({
		url: '<?php echo $this->Html->url(array('controller' => 'dmsDocuments', 'action' => 'delete')); ?>/'+id,
		success: function(response, opts) {
			Ext.Msg.alert('<?php __('Success'); ?>', '<?php __('DmsDocument(s) successfully deleted!'); ?>');
			RefreshParentDmsDocumentData();
		},
		failure: function(response, opts) {
			Ext.Msg.alert('<?php __('Error'); ?>', '<?php __('Cannot get the dmsDocument to be deleted. Error code'); ?>: ' + response.status);
		}
	});
}

function SearchByParentDmsDocumentName(value){
	var conditions = '\'DmsDocument.name LIKE\' => \'%' + value + '%\'';
	store_parent_dmsDocuments.reload({
		 params: {
			start: 0,
			limit: list_size,
			conditions: conditions
	    }
	});
}

function RefreshParentDmsDocumentData() {
	store_parent_dmsDocuments.reload();
}



var g = new Ext.grid.GridPanel({
	title: '<?php __('DmsDocuments'); ?>',
	store: store_parent_dmsDocuments,
	loadMask: true,
	stripeRows: true,
	height: 300,
	anchor: '100%',
    id: 'dmsDocumentGrid',
	columns: [
		{header: "<?php __('Name'); ?>", dataIndex: 'name', sortable: true},
		{header: "<?php __('Type'); ?>", dataIndex: 'type', sortable: true},
		{header:"<?php __('user'); ?>", dataIndex: 'user', sortable: true},
		{header:"<?php __('parent_dms_document'); ?>", dataIndex: 'parent_dms_document', sortable: true},
		{header: "<?php __('Shared'); ?>", dataIndex: 'shared', sortable: true},
		{header: "<?php __('Size'); ?>", dataIndex: 'size', sortable: true},
		{header: "<?php __('File Type'); ?>", dataIndex: 'file_type', sortable: true},
		{header: "<?php __('File Name'); ?>", dataIndex: 'file_name', sortable: true},
		{header: "<?php __('Share To'); ?>", dataIndex: 'share_to', sortable: true},
		{header: "<?php __('Created'); ?>", dataIndex: 'created', sortable: true},
		{header: "<?php __('Modified'); ?>", dataIndex: 'modified', sortable: true}	],
	sm: new Ext.grid.RowSelectionModel({
		singleSelect: false
	}),
	viewConfig: {
		forceFit: true
	},
    listeners: {
        celldblclick: function(){
            ViewDmsDocument(Ext.getCmp('dmsDocumentGrid').getSelectionModel().getSelected().data.id);
        }
    },
	tbar: new Ext.Toolbar({
		items: [{
				xtype: 'tbbutton',
				text: '<?php __('Add'); ?>',
				tooltip:'<?php __('<b>Add DmsDocument</b><br />Click here to create a new DmsDocument'); ?>',
				icon: 'img/table_add.png',
				cls: 'x-btn-text-icon',
				handler: function(btn) {
					AddParentDmsDocument();
				}
			}, ' ', '-', ' ', {
				xtype: 'tbbutton',
				text: '<?php __('Edit'); ?>',
				id: 'edit-parent-dmsDocument',
				tooltip:'<?php __('<b>Edit DmsDocument</b><br />Click here to modify the selected DmsDocument'); ?>',
				icon: 'img/table_edit.png',
				cls: 'x-btn-text-icon',
				disabled: true,
				handler: function(btn) {
					var sm = g.getSelectionModel();
					var sel = sm.getSelected();
					if (sm.hasSelection()){
						EditParentDmsDocument(sel.data.id);
					};
				}
			}, ' ', '-', ' ', {
				xtype: 'tbbutton',
				text: '<?php __('Delete'); ?>',
				id: 'delete-parent-dmsDocument',
				tooltip:'<?php __('<b>Delete DmsDocument(s)</b><br />Click here to remove the selected DmsDocument(s)'); ?>',
				icon: 'img/table_delete.png',
				cls: 'x-btn-text-icon',
				disabled: true,
				handler: function(btn) {
					var sm = g.getSelectionModel();
					var sel = sm.getSelections();
					if (sm.hasSelection()){
						if(sel.length==1){
							Ext.Msg.show({
									title: '<?php __('Remove DmsDocument'); ?>',
									buttons: Ext.MessageBox.YESNOCANCEL,
									msg: '<?php __('Remove'); ?> '+sel[0].data.name+'?',
									icon: Ext.MessageBox.QUESTION,
                                    fn: function(btn){
											if (btn == 'yes'){
													DeleteParentDmsDocument(sel[0].data.id);
											}
									}
							});
						} else {
							Ext.Msg.show({
									title: '<?php __('Remove DmsDocument'); ?>',
									buttons: Ext.MessageBox.YESNOCANCEL,
									msg: '<?php __('Remove the selected DmsDocument'); ?>?',
									icon: Ext.MessageBox.QUESTION,
                                    fn: function(btn){
											if (btn == 'yes'){
													var sel_ids = '';
													for(i=0;i<sel.length;i++){
														if(i>0)
															sel_ids += '_';
														sel_ids += sel[i].data.id;
													}
													DeleteParentDmsDocument(sel_ids);
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
				text: '<?php __('View DmsDocument'); ?>',
				id: 'view-dmsDocument2',
				tooltip:'<?php __('<b>View DmsDocument</b><br />Click here to see details of the selected DmsDocument'); ?>',
				icon: 'img/table_view.png',
				cls: 'x-btn-text-icon',
				disabled: true,
				handler: function(btn) {
					var sm = g.getSelectionModel();
					var sel = sm.getSelected();
					if (sm.hasSelection()){
						ViewDmsDocument(sel.data.id);
					};
				},
				menu : {
					items: [
 {
						text: '<?php __('View Dms Documents'); ?>',
                        icon: 'img/table_view.png',
						cls: 'x-btn-text-icon',
						handler: function(btn) {
							var sm = g.getSelectionModel();
							var sel = sm.getSelected();
							if (sm.hasSelection()){
								ViewDmsDocumentDmsDocuments(sel.data.id);
							};
						}
					}
, {
						text: '<?php __('View Dms Shares'); ?>',
                        icon: 'img/table_view.png',
						cls: 'x-btn-text-icon',
						handler: function(btn) {
							var sm = g.getSelectionModel();
							var sel = sm.getSelected();
							if (sm.hasSelection()){
								ViewDmsDocumentDmsShares(sel.data.id);
							};
						}
					}
					]
				}

            }, ' ', '->', {
				xtype: 'textfield',
				emptyText: '<?php __('[Search By Name]'); ?>',
				id: 'parent_dmsDocument_search_field',
				listeners: {
					specialkey: function(field, e){
						if (e.getKey() == e.ENTER) {
							SearchByParentDmsDocumentName(Ext.getCmp('parent_dmsDocument_search_field').getValue());
						}
					}

				}
			}, {
				xtype: 'tbbutton',
				icon: 'img/search.png',
				cls: 'x-btn-text-icon',
				text: 'GO',
				tooltip:'<?php __('<b>GO</b><br />Click here to get search results'); ?>',
				id: 'parent_dmsDocument_go_button',
				handler: function(){
					SearchByParentDmsDocumentName(Ext.getCmp('parent_dmsDocument_search_field').getValue());
				}
			}, ' '
	]}),
	bbar: new Ext.PagingToolbar({
		pageSize: list_size,
		store: store_parent_dmsDocuments,
		displayInfo: true,
		displayMsg: '<?php __('Displaying {0} - {1} of {2}'); ?>',
		beforePageText: '<?php __('Page'); ?>',
		afterPageText: '<?php __('of {0}'); ?>',
		emptyMsg: '<?php __('No data to display'); ?>'
	})
});
g.getSelectionModel().on('rowselect', function(sm, rowIdx, r) {
	g.getTopToolbar().findById('edit-parent-dmsDocument').enable();
	g.getTopToolbar().findById('delete-parent-dmsDocument').enable();
        g.getTopToolbar().findById('view-dmsDocument2').enable();
	if(this.getSelections().length > 1){
		g.getTopToolbar().findById('edit-parent-dmsDocument').disable();
        g.getTopToolbar().findById('view-dmsDocument2').disable();
	}
});
g.getSelectionModel().on('rowdeselect', function(sm, rowIdx, r) {
	if(this.getSelections().length > 1){
		g.getTopToolbar().findById('edit-parent-dmsDocument').disable();
		g.getTopToolbar().findById('delete-parent-dmsDocument').enable();
                g.getTopToolbar().findById('view-dmsDocument2').disable();
	}
	else if(this.getSelections().length == 1){
		g.getTopToolbar().findById('edit-parent-dmsDocument').enable();
		g.getTopToolbar().findById('delete-parent-dmsDocument').enable();
                g.getTopToolbar().findById('view-dmsDocument2').enable();
	}
	else{
		g.getTopToolbar().findById('edit-parent-dmsDocument').disable();
		g.getTopToolbar().findById('delete-parent-dmsDocument').disable();
                g.getTopToolbar().findById('view-dmsDocument2').disable();
	}
});



var parentDmsDocumentsViewWindow = new Ext.Window({
	title: 'DmsDocument Under the selected Item',
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
			parentDmsDocumentsViewWindow.close();
		}
	}]
});

store_parent_dmsDocuments.load({
    params: {
        start: 0,    
        limit: list_size
    }
});