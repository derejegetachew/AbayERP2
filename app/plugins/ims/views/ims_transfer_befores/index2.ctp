var store_parent_imsTransferBefores = new Ext.data.Store({
	reader: new Ext.data.JsonReader({
		root:'rows',
		totalProperty: 'results',
		fields: [
			'id','name','ims_sirv_before','from_user','to_user','from_branch','to_branch','observer','approved_by','created','modified'	
		]
	}),
	proxy: new Ext.data.HttpProxy({
		url: '<?php echo $this->Html->url(array('controller' => 'imsTransferBefores', 'action' => 'list_data', $parent_id)); ?>'	})
});


function AddParentImsTransferBefore() {
	Ext.Ajax.request({
		url: '<?php echo $this->Html->url(array('controller' => 'imsTransferBefores', 'action' => 'add', $parent_id)); ?>',
		success: function(response, opts) {
			var parent_imsTransferBefore_data = response.responseText;
			
			eval(parent_imsTransferBefore_data);
			
			ImsTransferBeforeAddWindow.show();
		},
		failure: function(response, opts) {
			Ext.Msg.alert('<?php __('Error'); ?>', '<?php __('Cannot get the imsTransferBefore add form. Error code'); ?>: ' + response.status);
		}
	});
}

function EditParentImsTransferBefore(id) {
	Ext.Ajax.request({
		url: '<?php echo $this->Html->url(array('controller' => 'imsTransferBefores', 'action' => 'edit')); ?>/'+id+'/<?php echo $parent_id; ?>',
		success: function(response, opts) {
			var parent_imsTransferBefore_data = response.responseText;
			
			eval(parent_imsTransferBefore_data);
			
			ImsTransferBeforeEditWindow.show();
		},
		failure: function(response, opts) {
			Ext.Msg.alert('<?php __('Error'); ?>', '<?php __('Cannot get the imsTransferBefore edit form. Error code'); ?>: ' + response.status);
		}
	});
}

function ViewImsTransferBefore(id) {
	Ext.Ajax.request({
		url: '<?php echo $this->Html->url(array('controller' => 'imsTransferBefores', 'action' => 'view')); ?>/'+id,
		success: function(response, opts) {
			var imsTransferBefore_data = response.responseText;

			eval(imsTransferBefore_data);

			ImsTransferBeforeViewWindow.show();
		},
		failure: function(response, opts) {
			Ext.Msg.alert('<?php __('Error'); ?>', '<?php __('Cannot get the imsTransferBefore view form. Error code'); ?>: ' + response.status);
		}
	});
}

function ViewImsTransferBeforeImsTransferItemBefores(id) {
	Ext.Ajax.request({
		url: '<?php echo $this->Html->url(array('controller' => 'imsTransferItemBefores', 'action' => 'index2')); ?>/'+id,
		success: function(response, opts) {
			var parent_imsTransferItemBefores_data = response.responseText;

			eval(parent_imsTransferItemBefores_data);

			parentImsTransferItemBeforesViewWindow.show();
		},
		failure: function(response, opts) {
			Ext.Msg.alert('<?php __('Error'); ?>', '<?php __('Cannot get the campus view form. Error code'); ?>: ' + response.status);
		}
	});
}


function DeleteParentImsTransferBefore(id) {
	Ext.Ajax.request({
		url: '<?php echo $this->Html->url(array('controller' => 'imsTransferBefores', 'action' => 'delete')); ?>/'+id,
		success: function(response, opts) {
			Ext.Msg.alert('<?php __('Success'); ?>', '<?php __('ImsTransferBefore(s) successfully deleted!'); ?>');
			RefreshParentImsTransferBeforeData();
		},
		failure: function(response, opts) {
			Ext.Msg.alert('<?php __('Error'); ?>', '<?php __('Cannot get the imsTransferBefore to be deleted. Error code'); ?>: ' + response.status);
		}
	});
}

function SearchByParentImsTransferBeforeName(value){
	var conditions = '\'ImsTransferBefore.name LIKE\' => \'%' + value + '%\'';
	store_parent_imsTransferBefores.reload({
		 params: {
			start: 0,
			limit: list_size,
			conditions: conditions
	    }
	});
}

function RefreshParentImsTransferBeforeData() {
	store_parent_imsTransferBefores.reload();
}



var g = new Ext.grid.GridPanel({
	title: '<?php __('ImsTransferBefores'); ?>',
	store: store_parent_imsTransferBefores,
	loadMask: true,
	stripeRows: true,
	height: 300,
	anchor: '100%',
    id: 'imsTransferBeforeGrid',
	columns: [
		{header: "<?php __('Name'); ?>", dataIndex: 'name', sortable: true},
		{header:"<?php __('ims_sirv_before'); ?>", dataIndex: 'ims_sirv_before', sortable: true},
		{header: "<?php __('From User'); ?>", dataIndex: 'from_user', sortable: true},
		{header: "<?php __('To User'); ?>", dataIndex: 'to_user', sortable: true},
		{header: "<?php __('From Branch'); ?>", dataIndex: 'from_branch', sortable: true},
		{header: "<?php __('To Branch'); ?>", dataIndex: 'to_branch', sortable: true},
		{header: "<?php __('Observer'); ?>", dataIndex: 'observer', sortable: true},
		{header: "<?php __('Approved By'); ?>", dataIndex: 'approved_by', sortable: true},
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
            ViewImsTransferBefore(Ext.getCmp('imsTransferBeforeGrid').getSelectionModel().getSelected().data.id);
        }
    },
	tbar: new Ext.Toolbar({
		items: [{
				xtype: 'tbbutton',
				text: '<?php __('Add'); ?>',
				tooltip:'<?php __('<b>Add ImsTransferBefore</b><br />Click here to create a new ImsTransferBefore'); ?>',
				icon: 'img/table_add.png',
				cls: 'x-btn-text-icon',
				handler: function(btn) {
					AddParentImsTransferBefore();
				}
			}, ' ', '-', ' ', {
				xtype: 'tbbutton',
				text: '<?php __('Edit'); ?>',
				id: 'edit-parent-imsTransferBefore',
				tooltip:'<?php __('<b>Edit ImsTransferBefore</b><br />Click here to modify the selected ImsTransferBefore'); ?>',
				icon: 'img/table_edit.png',
				cls: 'x-btn-text-icon',
				disabled: true,
				handler: function(btn) {
					var sm = g.getSelectionModel();
					var sel = sm.getSelected();
					if (sm.hasSelection()){
						EditParentImsTransferBefore(sel.data.id);
					};
				}
			}, ' ', '-', ' ', {
				xtype: 'tbbutton',
				text: '<?php __('Delete'); ?>',
				id: 'delete-parent-imsTransferBefore',
				tooltip:'<?php __('<b>Delete ImsTransferBefore(s)</b><br />Click here to remove the selected ImsTransferBefore(s)'); ?>',
				icon: 'img/table_delete.png',
				cls: 'x-btn-text-icon',
				disabled: true,
				handler: function(btn) {
					var sm = g.getSelectionModel();
					var sel = sm.getSelections();
					if (sm.hasSelection()){
						if(sel.length==1){
							Ext.Msg.show({
									title: '<?php __('Remove ImsTransferBefore'); ?>',
									buttons: Ext.MessageBox.YESNOCANCEL,
									msg: '<?php __('Remove'); ?> '+sel[0].data.name+'?',
									icon: Ext.MessageBox.QUESTION,
                                    fn: function(btn){
											if (btn == 'yes'){
													DeleteParentImsTransferBefore(sel[0].data.id);
											}
									}
							});
						} else {
							Ext.Msg.show({
									title: '<?php __('Remove ImsTransferBefore'); ?>',
									buttons: Ext.MessageBox.YESNOCANCEL,
									msg: '<?php __('Remove the selected ImsTransferBefore'); ?>?',
									icon: Ext.MessageBox.QUESTION,
                                    fn: function(btn){
											if (btn == 'yes'){
													var sel_ids = '';
													for(i=0;i<sel.length;i++){
														if(i>0)
															sel_ids += '_';
														sel_ids += sel[i].data.id;
													}
													DeleteParentImsTransferBefore(sel_ids);
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
				text: '<?php __('View ImsTransferBefore'); ?>',
				id: 'view-imsTransferBefore2',
				tooltip:'<?php __('<b>View ImsTransferBefore</b><br />Click here to see details of the selected ImsTransferBefore'); ?>',
				icon: 'img/table_view.png',
				cls: 'x-btn-text-icon',
				disabled: true,
				handler: function(btn) {
					var sm = g.getSelectionModel();
					var sel = sm.getSelected();
					if (sm.hasSelection()){
						ViewImsTransferBefore(sel.data.id);
					};
				},
				menu : {
					items: [
 {
						text: '<?php __('View Ims Transfer Item Befores'); ?>',
                        icon: 'img/table_view.png',
						cls: 'x-btn-text-icon',
						handler: function(btn) {
							var sm = g.getSelectionModel();
							var sel = sm.getSelected();
							if (sm.hasSelection()){
								ViewImsTransferBeforeImsTransferItemBefores(sel.data.id);
							};
						}
					}
					]
				}

            }, ' ', '->', {
				xtype: 'textfield',
				emptyText: '<?php __('[Search By Name]'); ?>',
				id: 'parent_imsTransferBefore_search_field',
				listeners: {
					specialkey: function(field, e){
						if (e.getKey() == e.ENTER) {
							SearchByParentImsTransferBeforeName(Ext.getCmp('parent_imsTransferBefore_search_field').getValue());
						}
					}

				}
			}, {
				xtype: 'tbbutton',
				icon: 'img/search.png',
				cls: 'x-btn-text-icon',
				text: 'GO',
				tooltip:'<?php __('<b>GO</b><br />Click here to get search results'); ?>',
				id: 'parent_imsTransferBefore_go_button',
				handler: function(){
					SearchByParentImsTransferBeforeName(Ext.getCmp('parent_imsTransferBefore_search_field').getValue());
				}
			}, ' '
	]}),
	bbar: new Ext.PagingToolbar({
		pageSize: list_size,
		store: store_parent_imsTransferBefores,
		displayInfo: true,
		displayMsg: '<?php __('Displaying {0} - {1} of {2}'); ?>',
		beforePageText: '<?php __('Page'); ?>',
		afterPageText: '<?php __('of {0}'); ?>',
		emptyMsg: '<?php __('No data to display'); ?>'
	})
});
g.getSelectionModel().on('rowselect', function(sm, rowIdx, r) {
	g.getTopToolbar().findById('edit-parent-imsTransferBefore').enable();
	g.getTopToolbar().findById('delete-parent-imsTransferBefore').enable();
        g.getTopToolbar().findById('view-imsTransferBefore2').enable();
	if(this.getSelections().length > 1){
		g.getTopToolbar().findById('edit-parent-imsTransferBefore').disable();
                g.getTopToolbar().findById('view-imsTransferBefore2').disable();
	}
});
g.getSelectionModel().on('rowdeselect', function(sm, rowIdx, r) {
	if(this.getSelections().length > 1){
		g.getTopToolbar().findById('edit-parent-imsTransferBefore').disable();
		g.getTopToolbar().findById('delete-parent-imsTransferBefore').enable();
                g.getTopToolbar().findById('view-imsTransferBefore2').disable();
	}
	else if(this.getSelections().length == 1){
		g.getTopToolbar().findById('edit-parent-imsTransferBefore').enable();
		g.getTopToolbar().findById('delete-parent-imsTransferBefore').enable();
                g.getTopToolbar().findById('view-imsTransferBefore2').enable();
	}
	else{
		g.getTopToolbar().findById('edit-parent-imsTransferBefore').disable();
		g.getTopToolbar().findById('delete-parent-imsTransferBefore').disable();
                g.getTopToolbar().findById('view-imsTransferBefore2').disable();
	}
});



var parentImsTransferBeforesViewWindow = new Ext.Window({
	title: 'ImsTransferBefore Under the selected Item',
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
			parentImsTransferBeforesViewWindow.close();
		}
	}]
});

store_parent_imsTransferBefores.load({
    params: {
        start: 0,    
        limit: list_size
    }
});