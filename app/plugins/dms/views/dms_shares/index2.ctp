var store_parent_dmsShares = new Ext.data.Store({
	reader: new Ext.data.JsonReader({
		root:'rows',
		totalProperty: 'results',
		fields: [
			'id','dms_document','branch','user','read','write','delete','created','modified'	
		]
	}),
	proxy: new Ext.data.HttpProxy({
		url: '<?php echo $this->Html->url(array('controller' => 'dmsShares', 'action' => 'list_data', $parent_id)); ?>'	})
});


function AddParentDmsShare() {
	Ext.Ajax.request({
		url: '<?php echo $this->Html->url(array('controller' => 'dmsShares', 'action' => 'add', $parent_id)); ?>',
		success: function(response, opts) {
			var parent_dmsShare_data = response.responseText;
			
			eval(parent_dmsShare_data);
			
			DmsShareAddWindow.show();
		},
		failure: function(response, opts) {
			Ext.Msg.alert('<?php __('Error'); ?>', '<?php __('Cannot get the dmsShare add form. Error code'); ?>: ' + response.status);
		}
	});
}

function EditParentDmsShare(id) {
	Ext.Ajax.request({
		url: '<?php echo $this->Html->url(array('controller' => 'dmsShares', 'action' => 'edit')); ?>/'+id+'/<?php echo $parent_id; ?>',
		success: function(response, opts) {
			var parent_dmsShare_data = response.responseText;
			
			eval(parent_dmsShare_data);
			
			DmsShareEditWindow.show();
		},
		failure: function(response, opts) {
			Ext.Msg.alert('<?php __('Error'); ?>', '<?php __('Cannot get the dmsShare edit form. Error code'); ?>: ' + response.status);
		}
	});
}

function ViewDmsShare(id) {
	Ext.Ajax.request({
		url: '<?php echo $this->Html->url(array('controller' => 'dmsShares', 'action' => 'view')); ?>/'+id,
		success: function(response, opts) {
			var dmsShare_data = response.responseText;

			eval(dmsShare_data);

			DmsShareViewWindow.show();
		},
		failure: function(response, opts) {
			Ext.Msg.alert('<?php __('Error'); ?>', '<?php __('Cannot get the dmsShare view form. Error code'); ?>: ' + response.status);
		}
	});
}


function DeleteParentDmsShare(id) {
	Ext.Ajax.request({
		url: '<?php echo $this->Html->url(array('controller' => 'dmsShares', 'action' => 'delete')); ?>/'+id,
		success: function(response, opts) {
			Ext.Msg.alert('<?php __('Success'); ?>', '<?php __('DmsShare(s) successfully deleted!'); ?>');
			RefreshParentDmsShareData();
		},
		failure: function(response, opts) {
			Ext.Msg.alert('<?php __('Error'); ?>', '<?php __('Cannot get the dmsShare to be deleted. Error code'); ?>: ' + response.status);
		}
	});
}

function SearchByParentDmsShareName(value){
	var conditions = '\'DmsShare.name LIKE\' => \'%' + value + '%\'';
	store_parent_dmsShares.reload({
		 params: {
			start: 0,
			limit: list_size,
			conditions: conditions
	    }
	});
}

function RefreshParentDmsShareData() {
	store_parent_dmsShares.reload();
}



var g = new Ext.grid.GridPanel({
	title: '<?php __('DmsShares'); ?>',
	store: store_parent_dmsShares,
	loadMask: true,
	stripeRows: true,
	height: 300,
	anchor: '100%',
    id: 'dmsShareGrid',
	columns: [
		{header:"<?php __('dms_document'); ?>", dataIndex: 'dms_document', sortable: true},
		{header:"<?php __('branch'); ?>", dataIndex: 'branch', sortable: true},
		{header:"<?php __('user'); ?>", dataIndex: 'user', sortable: true},
		{header: "<?php __('Read'); ?>", dataIndex: 'read', sortable: true},
		{header: "<?php __('Write'); ?>", dataIndex: 'write', sortable: true},
		{header: "<?php __('Delete'); ?>", dataIndex: 'delete', sortable: true},
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
            ViewDmsShare(Ext.getCmp('dmsShareGrid').getSelectionModel().getSelected().data.id);
        }
    },
	tbar: new Ext.Toolbar({
		items: [{
				xtype: 'tbbutton',
				text: '<?php __('Add'); ?>',
				tooltip:'<?php __('<b>Add DmsShare</b><br />Click here to create a new DmsShare'); ?>',
				icon: 'img/table_add.png',
				cls: 'x-btn-text-icon',
				handler: function(btn) {
					AddParentDmsShare();
				}
			}, ' ', '-', ' ', {
				xtype: 'tbbutton',
				text: '<?php __('Edit'); ?>',
				id: 'edit-parent-dmsShare',
				tooltip:'<?php __('<b>Edit DmsShare</b><br />Click here to modify the selected DmsShare'); ?>',
				icon: 'img/table_edit.png',
				cls: 'x-btn-text-icon',
				disabled: true,
				handler: function(btn) {
					var sm = g.getSelectionModel();
					var sel = sm.getSelected();
					if (sm.hasSelection()){
						EditParentDmsShare(sel.data.id);
					};
				}
			}, ' ', '-', ' ', {
				xtype: 'tbbutton',
				text: '<?php __('Delete'); ?>',
				id: 'delete-parent-dmsShare',
				tooltip:'<?php __('<b>Delete DmsShare(s)</b><br />Click here to remove the selected DmsShare(s)'); ?>',
				icon: 'img/table_delete.png',
				cls: 'x-btn-text-icon',
				disabled: true,
				handler: function(btn) {
					var sm = g.getSelectionModel();
					var sel = sm.getSelections();
					if (sm.hasSelection()){
						if(sel.length==1){
							Ext.Msg.show({
									title: '<?php __('Remove DmsShare'); ?>',
									buttons: Ext.MessageBox.YESNOCANCEL,
									msg: '<?php __('Remove'); ?> '+sel[0].data.name+'?',
									icon: Ext.MessageBox.QUESTION,
                                    fn: function(btn){
											if (btn == 'yes'){
													DeleteParentDmsShare(sel[0].data.id);
											}
									}
							});
						} else {
							Ext.Msg.show({
									title: '<?php __('Remove DmsShare'); ?>',
									buttons: Ext.MessageBox.YESNOCANCEL,
									msg: '<?php __('Remove the selected DmsShare'); ?>?',
									icon: Ext.MessageBox.QUESTION,
                                    fn: function(btn){
											if (btn == 'yes'){
													var sel_ids = '';
													for(i=0;i<sel.length;i++){
														if(i>0)
															sel_ids += '_';
														sel_ids += sel[i].data.id;
													}
													DeleteParentDmsShare(sel_ids);
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
				text: '<?php __('View DmsShare'); ?>',
				id: 'view-dmsShare2',
				tooltip:'<?php __('<b>View DmsShare</b><br />Click here to see details of the selected DmsShare'); ?>',
				icon: 'img/table_view.png',
				cls: 'x-btn-text-icon',
				disabled: true,
				handler: function(btn) {
					var sm = g.getSelectionModel();
					var sel = sm.getSelected();
					if (sm.hasSelection()){
						ViewDmsShare(sel.data.id);
					};
				},
				menu : {
					items: [
					]
				}

            }, ' ', '->', {
				xtype: 'textfield',
				emptyText: '<?php __('[Search By Name]'); ?>',
				id: 'parent_dmsShare_search_field',
				listeners: {
					specialkey: function(field, e){
						if (e.getKey() == e.ENTER) {
							SearchByParentDmsShareName(Ext.getCmp('parent_dmsShare_search_field').getValue());
						}
					}

				}
			}, {
				xtype: 'tbbutton',
				icon: 'img/search.png',
				cls: 'x-btn-text-icon',
				text: 'GO',
				tooltip:'<?php __('<b>GO</b><br />Click here to get search results'); ?>',
				id: 'parent_dmsShare_go_button',
				handler: function(){
					SearchByParentDmsShareName(Ext.getCmp('parent_dmsShare_search_field').getValue());
				}
			}, ' '
	]}),
	bbar: new Ext.PagingToolbar({
		pageSize: list_size,
		store: store_parent_dmsShares,
		displayInfo: true,
		displayMsg: '<?php __('Displaying {0} - {1} of {2}'); ?>',
		beforePageText: '<?php __('Page'); ?>',
		afterPageText: '<?php __('of {0}'); ?>',
		emptyMsg: '<?php __('No data to display'); ?>'
	})
});
g.getSelectionModel().on('rowselect', function(sm, rowIdx, r) {
	g.getTopToolbar().findById('edit-parent-dmsShare').enable();
	g.getTopToolbar().findById('delete-parent-dmsShare').enable();
        g.getTopToolbar().findById('view-dmsShare2').enable();
	if(this.getSelections().length > 1){
		g.getTopToolbar().findById('edit-parent-dmsShare').disable();
                g.getTopToolbar().findById('view-dmsShare2').disable();
	}
});
g.getSelectionModel().on('rowdeselect', function(sm, rowIdx, r) {
	if(this.getSelections().length > 1){
		g.getTopToolbar().findById('edit-parent-dmsShare').disable();
		g.getTopToolbar().findById('delete-parent-dmsShare').enable();
                g.getTopToolbar().findById('view-dmsShare2').disable();
	}
	else if(this.getSelections().length == 1){
		g.getTopToolbar().findById('edit-parent-dmsShare').enable();
		g.getTopToolbar().findById('delete-parent-dmsShare').enable();
                g.getTopToolbar().findById('view-dmsShare2').enable();
	}
	else{
		g.getTopToolbar().findById('edit-parent-dmsShare').disable();
		g.getTopToolbar().findById('delete-parent-dmsShare').disable();
                g.getTopToolbar().findById('view-dmsShare2').disable();
	}
});



var parentDmsSharesViewWindow = new Ext.Window({
	title: 'DmsShare Under the selected Item',
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
			parentDmsSharesViewWindow.close();
		}
	}]
});

store_parent_dmsShares.load({
    params: {
        start: 0,    
        limit: list_size
    }
});