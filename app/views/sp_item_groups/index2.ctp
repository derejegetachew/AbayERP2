var store_parent_spItemGroups = new Ext.data.Store({
	reader: new Ext.data.JsonReader({
		root:'rows',
		totalProperty: 'results',
		fields: [
			'id','name','parent_sp_item_group','created','modified'	
		]
	}),
	proxy: new Ext.data.HttpProxy({
		url: '<?php echo $this->Html->url(array('controller' => 'spItemGroups', 'action' => 'list_data', $parent_id)); ?>'	})
});


function AddParentSpItemGroup() {
	Ext.Ajax.request({
		url: '<?php echo $this->Html->url(array('controller' => 'spItemGroups', 'action' => 'add', $parent_id)); ?>',
		success: function(response, opts) {
			var parent_spItemGroup_data = response.responseText;
			
			eval(parent_spItemGroup_data);
			
			SpItemGroupAddWindow.show();
		},
		failure: function(response, opts) {
			Ext.Msg.alert('<?php __('Error'); ?>', '<?php __('Cannot get the spItemGroup add form. Error code'); ?>: ' + response.status);
		}
	});
}

function EditParentSpItemGroup(id) {
	Ext.Ajax.request({
		url: '<?php echo $this->Html->url(array('controller' => 'spItemGroups', 'action' => 'edit')); ?>/'+id+'/<?php echo $parent_id; ?>',
		success: function(response, opts) {
			var parent_spItemGroup_data = response.responseText;
			
			eval(parent_spItemGroup_data);
			
			SpItemGroupEditWindow.show();
		},
		failure: function(response, opts) {
			Ext.Msg.alert('<?php __('Error'); ?>', '<?php __('Cannot get the spItemGroup edit form. Error code'); ?>: ' + response.status);
		}
	});
}

function ViewSpItemGroup(id) {
	Ext.Ajax.request({
		url: '<?php echo $this->Html->url(array('controller' => 'spItemGroups', 'action' => 'view')); ?>/'+id,
		success: function(response, opts) {
			var spItemGroup_data = response.responseText;

			eval(spItemGroup_data);

			SpItemGroupViewWindow.show();
		},
		failure: function(response, opts) {
			Ext.Msg.alert('<?php __('Error'); ?>', '<?php __('Cannot get the spItemGroup view form. Error code'); ?>: ' + response.status);
		}
	});
}

function ViewSpItemGroupSpItemGroups(id) {
	Ext.Ajax.request({
		url: '<?php echo $this->Html->url(array('controller' => 'childSpItemGroups', 'action' => 'index2')); ?>/'+id,
		success: function(response, opts) {
			var parent_childSpItemGroups_data = response.responseText;

			eval(parent_childSpItemGroups_data);

			parentSpItemGroupsViewWindow.show();
		},
		failure: function(response, opts) {
			Ext.Msg.alert('<?php __('Error'); ?>', '<?php __('Cannot get the campus view form. Error code'); ?>: ' + response.status);
		}
	});
}

function ViewSpItemGroupSpItems(id) {
	Ext.Ajax.request({
		url: '<?php echo $this->Html->url(array('controller' => 'spItems', 'action' => 'index2')); ?>/'+id,
		success: function(response, opts) {
			var parent_spItems_data = response.responseText;

			eval(parent_spItems_data);

			parentSpItemsViewWindow.show();
		},
		failure: function(response, opts) {
			Ext.Msg.alert('<?php __('Error'); ?>', '<?php __('Cannot get the campus view form. Error code'); ?>: ' + response.status);
		}
	});
}


function DeleteParentSpItemGroup(id) {
	Ext.Ajax.request({
		url: '<?php echo $this->Html->url(array('controller' => 'spItemGroups', 'action' => 'delete')); ?>/'+id,
		success: function(response, opts) {
			Ext.Msg.alert('<?php __('Success'); ?>', '<?php __('SpItemGroup(s) successfully deleted!'); ?>');
			RefreshParentSpItemGroupData();
		},
		failure: function(response, opts) {
			Ext.Msg.alert('<?php __('Error'); ?>', '<?php __('Cannot get the spItemGroup to be deleted. Error code'); ?>: ' + response.status);
		}
	});
}

function SearchByParentSpItemGroupName(value){
	var conditions = '\'SpItemGroup.name LIKE\' => \'%' + value + '%\'';
	store_parent_spItemGroups.reload({
		 params: {
			start: 0,
			limit: list_size,
			conditions: conditions
	    }
	});
}

function RefreshParentSpItemGroupData() {
	store_parent_spItemGroups.reload();
}



var g = new Ext.grid.GridPanel({
	title: '<?php __('SpItemGroups'); ?>',
	store: store_parent_spItemGroups,
	loadMask: true,
	stripeRows: true,
	height: 300,
	anchor: '100%',
    id: 'spItemGroupGrid',
	columns: [
		{header: "<?php __('Name'); ?>", dataIndex: 'name', sortable: true},
		{header:"<?php __('parent_sp_item_group'); ?>", dataIndex: 'parent_sp_item_group', sortable: true},
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
            ViewSpItemGroup(Ext.getCmp('spItemGroupGrid').getSelectionModel().getSelected().data.id);
        }
    },
	tbar: new Ext.Toolbar({
		items: [{
				xtype: 'tbbutton',
				text: '<?php __('Add'); ?>',
				tooltip:'<?php __('<b>Add SpItemGroup</b><br />Click here to create a new SpItemGroup'); ?>',
				icon: 'img/table_add.png',
				cls: 'x-btn-text-icon',
				handler: function(btn) {
					AddParentSpItemGroup();
				}
			}, ' ', '-', ' ', {
				xtype: 'tbbutton',
				text: '<?php __('Edit'); ?>',
				id: 'edit-parent-spItemGroup',
				tooltip:'<?php __('<b>Edit SpItemGroup</b><br />Click here to modify the selected SpItemGroup'); ?>',
				icon: 'img/table_edit.png',
				cls: 'x-btn-text-icon',
				disabled: true,
				handler: function(btn) {
					var sm = g.getSelectionModel();
					var sel = sm.getSelected();
					if (sm.hasSelection()){
						EditParentSpItemGroup(sel.data.id);
					};
				}
			}, ' ', '-', ' ', {
				xtype: 'tbbutton',
				text: '<?php __('Delete'); ?>',
				id: 'delete-parent-spItemGroup',
				tooltip:'<?php __('<b>Delete SpItemGroup(s)</b><br />Click here to remove the selected SpItemGroup(s)'); ?>',
				icon: 'img/table_delete.png',
				cls: 'x-btn-text-icon',
				disabled: true,
				handler: function(btn) {
					var sm = g.getSelectionModel();
					var sel = sm.getSelections();
					if (sm.hasSelection()){
						if(sel.length==1){
							Ext.Msg.show({
									title: '<?php __('Remove SpItemGroup'); ?>',
									buttons: Ext.MessageBox.YESNOCANCEL,
									msg: '<?php __('Remove'); ?> '+sel[0].data.name+'?',
									icon: Ext.MessageBox.QUESTION,
                                    fn: function(btn){
											if (btn == 'yes'){
													DeleteParentSpItemGroup(sel[0].data.id);
											}
									}
							});
						} else {
							Ext.Msg.show({
									title: '<?php __('Remove SpItemGroup'); ?>',
									buttons: Ext.MessageBox.YESNOCANCEL,
									msg: '<?php __('Remove the selected SpItemGroup'); ?>?',
									icon: Ext.MessageBox.QUESTION,
                                    fn: function(btn){
											if (btn == 'yes'){
													var sel_ids = '';
													for(i=0;i<sel.length;i++){
														if(i>0)
															sel_ids += '_';
														sel_ids += sel[i].data.id;
													}
													DeleteParentSpItemGroup(sel_ids);
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
				text: '<?php __('View SpItemGroup'); ?>',
				id: 'view-spItemGroup2',
				tooltip:'<?php __('<b>View SpItemGroup</b><br />Click here to see details of the selected SpItemGroup'); ?>',
				icon: 'img/table_view.png',
				cls: 'x-btn-text-icon',
				disabled: true,
				handler: function(btn) {
					var sm = g.getSelectionModel();
					var sel = sm.getSelected();
					if (sm.hasSelection()){
						ViewSpItemGroup(sel.data.id);
					};
				},
				menu : {
					items: [
 {
						text: '<?php __('View Sp Item Groups'); ?>',
                        icon: 'img/table_view.png',
						cls: 'x-btn-text-icon',
						handler: function(btn) {
							var sm = g.getSelectionModel();
							var sel = sm.getSelected();
							if (sm.hasSelection()){
								ViewSpItemGroupSpItemGroups(sel.data.id);
							};
						}
					}
, {
						text: '<?php __('View Sp Items'); ?>',
                        icon: 'img/table_view.png',
						cls: 'x-btn-text-icon',
						handler: function(btn) {
							var sm = g.getSelectionModel();
							var sel = sm.getSelected();
							if (sm.hasSelection()){
								ViewSpItemGroupSpItems(sel.data.id);
							};
						}
					}
					]
				}

            }, ' ', '->', {
				xtype: 'textfield',
				emptyText: '<?php __('[Search By Name]'); ?>',
				id: 'parent_spItemGroup_search_field',
				listeners: {
					specialkey: function(field, e){
						if (e.getKey() == e.ENTER) {
							SearchByParentSpItemGroupName(Ext.getCmp('parent_spItemGroup_search_field').getValue());
						}
					}

				}
			}, {
				xtype: 'tbbutton',
				icon: 'img/search.png',
				cls: 'x-btn-text-icon',
				text: 'GO',
				tooltip:'<?php __('<b>GO</b><br />Click here to get search results'); ?>',
				id: 'parent_spItemGroup_go_button',
				handler: function(){
					SearchByParentSpItemGroupName(Ext.getCmp('parent_spItemGroup_search_field').getValue());
				}
			}, ' '
	]}),
	bbar: new Ext.PagingToolbar({
		pageSize: list_size,
		store: store_parent_spItemGroups,
		displayInfo: true,
		displayMsg: '<?php __('Displaying {0} - {1} of {2}'); ?>',
		beforePageText: '<?php __('Page'); ?>',
		afterPageText: '<?php __('of {0}'); ?>',
		emptyMsg: '<?php __('No data to display'); ?>'
	})
});
g.getSelectionModel().on('rowselect', function(sm, rowIdx, r) {
	g.getTopToolbar().findById('edit-parent-spItemGroup').enable();
	g.getTopToolbar().findById('delete-parent-spItemGroup').enable();
        g.getTopToolbar().findById('view-spItemGroup2').enable();
	if(this.getSelections().length > 1){
		g.getTopToolbar().findById('edit-parent-spItemGroup').disable();
                g.getTopToolbar().findById('view-spItemGroup2').disable();
	}
});
g.getSelectionModel().on('rowdeselect', function(sm, rowIdx, r) {
	if(this.getSelections().length > 1){
		g.getTopToolbar().findById('edit-parent-spItemGroup').disable();
		g.getTopToolbar().findById('delete-parent-spItemGroup').enable();
                g.getTopToolbar().findById('view-spItemGroup2').disable();
	}
	else if(this.getSelections().length == 1){
		g.getTopToolbar().findById('edit-parent-spItemGroup').enable();
		g.getTopToolbar().findById('delete-parent-spItemGroup').enable();
                g.getTopToolbar().findById('view-spItemGroup2').enable();
	}
	else{
		g.getTopToolbar().findById('edit-parent-spItemGroup').disable();
		g.getTopToolbar().findById('delete-parent-spItemGroup').disable();
                g.getTopToolbar().findById('view-spItemGroup2').disable();
	}
});



var parentSpItemGroupsViewWindow = new Ext.Window({
	title: 'SpItemGroup Under the selected Item',
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
			parentSpItemGroupsViewWindow.close();
		}
	}]
});

store_parent_spItemGroups.load({
    params: {
        start: 0,    
        limit: list_size
    }
});