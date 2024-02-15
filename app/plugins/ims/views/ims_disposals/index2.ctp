var store_parent_imsDisposals = new Ext.data.Store({
	reader: new Ext.data.JsonReader({
		root:'rows',
		totalProperty: 'results',
		fields: [
			'id','name','status','ims_store','created_by','modified_by','created','modified'	
		]
	}),
	proxy: new Ext.data.HttpProxy({
		url: '<?php echo $this->Html->url(array('controller' => 'imsDisposals', 'action' => 'list_data', $parent_id)); ?>'	})
});


function AddParentImsDisposal() {
	Ext.Ajax.request({
		url: '<?php echo $this->Html->url(array('controller' => 'imsDisposals', 'action' => 'add', $parent_id)); ?>',
		success: function(response, opts) {
			var parent_imsDisposal_data = response.responseText;
			
			eval(parent_imsDisposal_data);
			
			ImsDisposalAddWindow.show();
		},
		failure: function(response, opts) {
			Ext.Msg.alert('<?php __('Error'); ?>', '<?php __('Cannot get the imsDisposal add form. Error code'); ?>: ' + response.status);
		}
	});
}

function EditParentImsDisposal(id) {
	Ext.Ajax.request({
		url: '<?php echo $this->Html->url(array('controller' => 'imsDisposals', 'action' => 'edit')); ?>/'+id+'/<?php echo $parent_id; ?>',
		success: function(response, opts) {
			var parent_imsDisposal_data = response.responseText;
			
			eval(parent_imsDisposal_data);
			
			ImsDisposalEditWindow.show();
		},
		failure: function(response, opts) {
			Ext.Msg.alert('<?php __('Error'); ?>', '<?php __('Cannot get the imsDisposal edit form. Error code'); ?>: ' + response.status);
		}
	});
}

function ViewImsDisposal(id) {
	Ext.Ajax.request({
		url: '<?php echo $this->Html->url(array('controller' => 'imsDisposals', 'action' => 'view')); ?>/'+id,
		success: function(response, opts) {
			var imsDisposal_data = response.responseText;

			eval(imsDisposal_data);

			ImsDisposalViewWindow.show();
		},
		failure: function(response, opts) {
			Ext.Msg.alert('<?php __('Error'); ?>', '<?php __('Cannot get the imsDisposal view form. Error code'); ?>: ' + response.status);
		}
	});
}

function ViewImsDisposalImsDisposalItems(id) {
	Ext.Ajax.request({
		url: '<?php echo $this->Html->url(array('controller' => 'imsDisposalItems', 'action' => 'index2')); ?>/'+id,
		success: function(response, opts) {
			var parent_imsDisposalItems_data = response.responseText;

			eval(parent_imsDisposalItems_data);

			parentImsDisposalItemsViewWindow.show();
		},
		failure: function(response, opts) {
			Ext.Msg.alert('<?php __('Error'); ?>', '<?php __('Cannot get the campus view form. Error code'); ?>: ' + response.status);
		}
	});
}


function DeleteParentImsDisposal(id) {
	Ext.Ajax.request({
		url: '<?php echo $this->Html->url(array('controller' => 'imsDisposals', 'action' => 'delete')); ?>/'+id,
		success: function(response, opts) {
			Ext.Msg.alert('<?php __('Success'); ?>', '<?php __('ImsDisposal(s) successfully deleted!'); ?>');
			RefreshParentImsDisposalData();
		},
		failure: function(response, opts) {
			Ext.Msg.alert('<?php __('Error'); ?>', '<?php __('Cannot get the imsDisposal to be deleted. Error code'); ?>: ' + response.status);
		}
	});
}

function SearchByParentImsDisposalName(value){
	var conditions = '\'ImsDisposal.name LIKE\' => \'%' + value + '%\'';
	store_parent_imsDisposals.reload({
		 params: {
			start: 0,
			limit: list_size,
			conditions: conditions
	    }
	});
}

function RefreshParentImsDisposalData() {
	store_parent_imsDisposals.reload();
}



var g = new Ext.grid.GridPanel({
	title: '<?php __('ImsDisposals'); ?>',
	store: store_parent_imsDisposals,
	loadMask: true,
	stripeRows: true,
	height: 300,
	anchor: '100%',
    id: 'imsDisposalGrid',
	columns: [
		{header: "<?php __('Name'); ?>", dataIndex: 'name', sortable: true},
		{header: "<?php __('Status'); ?>", dataIndex: 'status', sortable: true},
		{header:"<?php __('ims_store'); ?>", dataIndex: 'ims_store', sortable: true},
		{header: "<?php __('Created By'); ?>", dataIndex: 'created_by', sortable: true},
		{header: "<?php __('Modified By'); ?>", dataIndex: 'modified_by', sortable: true},
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
            ViewImsDisposal(Ext.getCmp('imsDisposalGrid').getSelectionModel().getSelected().data.id);
        }
    },
	tbar: new Ext.Toolbar({
		items: [{
				xtype: 'tbbutton',
				text: '<?php __('Add'); ?>',
				tooltip:'<?php __('<b>Add ImsDisposal</b><br />Click here to create a new ImsDisposal'); ?>',
				icon: 'img/table_add.png',
				cls: 'x-btn-text-icon',
				handler: function(btn) {
					AddParentImsDisposal();
				}
			}, ' ', '-', ' ', {
				xtype: 'tbbutton',
				text: '<?php __('Edit'); ?>',
				id: 'edit-parent-imsDisposal',
				tooltip:'<?php __('<b>Edit ImsDisposal</b><br />Click here to modify the selected ImsDisposal'); ?>',
				icon: 'img/table_edit.png',
				cls: 'x-btn-text-icon',
				disabled: true,
				handler: function(btn) {
					var sm = g.getSelectionModel();
					var sel = sm.getSelected();
					if (sm.hasSelection()){
						EditParentImsDisposal(sel.data.id);
					};
				}
			}, ' ', '-', ' ', {
				xtype: 'tbbutton',
				text: '<?php __('Delete'); ?>',
				id: 'delete-parent-imsDisposal',
				tooltip:'<?php __('<b>Delete ImsDisposal(s)</b><br />Click here to remove the selected ImsDisposal(s)'); ?>',
				icon: 'img/table_delete.png',
				cls: 'x-btn-text-icon',
				disabled: true,
				handler: function(btn) {
					var sm = g.getSelectionModel();
					var sel = sm.getSelections();
					if (sm.hasSelection()){
						if(sel.length==1){
							Ext.Msg.show({
									title: '<?php __('Remove ImsDisposal'); ?>',
									buttons: Ext.MessageBox.YESNOCANCEL,
									msg: '<?php __('Remove'); ?> '+sel[0].data.name+'?',
									icon: Ext.MessageBox.QUESTION,
                                    fn: function(btn){
											if (btn == 'yes'){
													DeleteParentImsDisposal(sel[0].data.id);
											}
									}
							});
						} else {
							Ext.Msg.show({
									title: '<?php __('Remove ImsDisposal'); ?>',
									buttons: Ext.MessageBox.YESNOCANCEL,
									msg: '<?php __('Remove the selected ImsDisposal'); ?>?',
									icon: Ext.MessageBox.QUESTION,
                                    fn: function(btn){
											if (btn == 'yes'){
													var sel_ids = '';
													for(i=0;i<sel.length;i++){
														if(i>0)
															sel_ids += '_';
														sel_ids += sel[i].data.id;
													}
													DeleteParentImsDisposal(sel_ids);
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
				text: '<?php __('View ImsDisposal'); ?>',
				id: 'view-imsDisposal2',
				tooltip:'<?php __('<b>View ImsDisposal</b><br />Click here to see details of the selected ImsDisposal'); ?>',
				icon: 'img/table_view.png',
				cls: 'x-btn-text-icon',
				disabled: true,
				handler: function(btn) {
					var sm = g.getSelectionModel();
					var sel = sm.getSelected();
					if (sm.hasSelection()){
						ViewImsDisposal(sel.data.id);
					};
				},
				menu : {
					items: [
 {
						text: '<?php __('View Ims Disposal Items'); ?>',
                        icon: 'img/table_view.png',
						cls: 'x-btn-text-icon',
						handler: function(btn) {
							var sm = g.getSelectionModel();
							var sel = sm.getSelected();
							if (sm.hasSelection()){
								ViewImsDisposalImsDisposalItems(sel.data.id);
							};
						}
					}
					]
				}

            }, ' ', '->', {
				xtype: 'textfield',
				emptyText: '<?php __('[Search By Name]'); ?>',
				id: 'parent_imsDisposal_search_field',
				listeners: {
					specialkey: function(field, e){
						if (e.getKey() == e.ENTER) {
							SearchByParentImsDisposalName(Ext.getCmp('parent_imsDisposal_search_field').getValue());
						}
					}

				}
			}, {
				xtype: 'tbbutton',
				icon: 'img/search.png',
				cls: 'x-btn-text-icon',
				text: 'GO',
				tooltip:'<?php __('<b>GO</b><br />Click here to get search results'); ?>',
				id: 'parent_imsDisposal_go_button',
				handler: function(){
					SearchByParentImsDisposalName(Ext.getCmp('parent_imsDisposal_search_field').getValue());
				}
			}, ' '
	]}),
	bbar: new Ext.PagingToolbar({
		pageSize: list_size,
		store: store_parent_imsDisposals,
		displayInfo: true,
		displayMsg: '<?php __('Displaying {0} - {1} of {2}'); ?>',
		beforePageText: '<?php __('Page'); ?>',
		afterPageText: '<?php __('of {0}'); ?>',
		emptyMsg: '<?php __('No data to display'); ?>'
	})
});
g.getSelectionModel().on('rowselect', function(sm, rowIdx, r) {
	g.getTopToolbar().findById('edit-parent-imsDisposal').enable();
	g.getTopToolbar().findById('delete-parent-imsDisposal').enable();
        g.getTopToolbar().findById('view-imsDisposal2').enable();
	if(this.getSelections().length > 1){
		g.getTopToolbar().findById('edit-parent-imsDisposal').disable();
                g.getTopToolbar().findById('view-imsDisposal2').disable();
	}
});
g.getSelectionModel().on('rowdeselect', function(sm, rowIdx, r) {
	if(this.getSelections().length > 1){
		g.getTopToolbar().findById('edit-parent-imsDisposal').disable();
		g.getTopToolbar().findById('delete-parent-imsDisposal').enable();
                g.getTopToolbar().findById('view-imsDisposal2').disable();
	}
	else if(this.getSelections().length == 1){
		g.getTopToolbar().findById('edit-parent-imsDisposal').enable();
		g.getTopToolbar().findById('delete-parent-imsDisposal').enable();
                g.getTopToolbar().findById('view-imsDisposal2').enable();
	}
	else{
		g.getTopToolbar().findById('edit-parent-imsDisposal').disable();
		g.getTopToolbar().findById('delete-parent-imsDisposal').disable();
                g.getTopToolbar().findById('view-imsDisposal2').disable();
	}
});



var parentImsDisposalsViewWindow = new Ext.Window({
	title: 'ImsDisposal Under the selected Item',
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
			parentImsDisposalsViewWindow.close();
		}
	}]
});

store_parent_imsDisposals.load({
    params: {
        start: 0,    
        limit: list_size
    }
});