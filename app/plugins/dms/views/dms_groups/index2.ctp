var store_parent_dmsGroups = new Ext.data.Store({
	reader: new Ext.data.JsonReader({
		root:'rows',
		totalProperty: 'results',
		fields: [
			'id','name','user','public','created'	
		]
	}),
	proxy: new Ext.data.HttpProxy({
		url: '<?php echo $this->Html->url(array('controller' => 'dmsGroups', 'action' => 'list_data', $parent_id)); ?>'	})
});


function AddParentDmsGroup() {
	Ext.Ajax.request({
		url: '<?php echo $this->Html->url(array('controller' => 'dmsGroups', 'action' => 'add', $parent_id)); ?>',
		success: function(response, opts) {
			var parent_dmsGroup_data = response.responseText;
			
			eval(parent_dmsGroup_data);
			
			DmsGroupAddWindow.show();
		},
		failure: function(response, opts) {
			Ext.Msg.alert('<?php __('Error'); ?>', '<?php __('Cannot get the dmsGroup add form. Error code'); ?>: ' + response.status);
		}
	});
}

function EditParentDmsGroup(id) {
	Ext.Ajax.request({
		url: '<?php echo $this->Html->url(array('controller' => 'dmsGroups', 'action' => 'edit')); ?>/'+id+'/<?php echo $parent_id; ?>',
		success: function(response, opts) {
			var parent_dmsGroup_data = response.responseText;
			
			eval(parent_dmsGroup_data);
			
			DmsGroupEditWindow.show();
		},
		failure: function(response, opts) {
			Ext.Msg.alert('<?php __('Error'); ?>', '<?php __('Cannot get the dmsGroup edit form. Error code'); ?>: ' + response.status);
		}
	});
}

function ViewDmsGroup(id) {
	Ext.Ajax.request({
		url: '<?php echo $this->Html->url(array('controller' => 'dmsGroups', 'action' => 'view')); ?>/'+id,
		success: function(response, opts) {
			var dmsGroup_data = response.responseText;

			eval(dmsGroup_data);

			DmsGroupViewWindow.show();
		},
		failure: function(response, opts) {
			Ext.Msg.alert('<?php __('Error'); ?>', '<?php __('Cannot get the dmsGroup view form. Error code'); ?>: ' + response.status);
		}
	});
}

function ViewDmsGroupDmsGroupLists(id) {
	Ext.Ajax.request({
		url: '<?php echo $this->Html->url(array('controller' => 'dmsGroupLists', 'action' => 'index2')); ?>/'+id,
		success: function(response, opts) {
			var parent_dmsGroupLists_data = response.responseText;

			eval(parent_dmsGroupLists_data);

			parentDmsGroupListsViewWindow.show();
		},
		failure: function(response, opts) {
			Ext.Msg.alert('<?php __('Error'); ?>', '<?php __('Cannot get the campus view form. Error code'); ?>: ' + response.status);
		}
	});
}


function DeleteParentDmsGroup(id) {
	Ext.Ajax.request({
		url: '<?php echo $this->Html->url(array('controller' => 'dmsGroups', 'action' => 'delete')); ?>/'+id,
		success: function(response, opts) {
			Ext.Msg.alert('<?php __('Success'); ?>', '<?php __('DmsGroup(s) successfully deleted!'); ?>');
			RefreshParentDmsGroupData();
		},
		failure: function(response, opts) {
			Ext.Msg.alert('<?php __('Error'); ?>', '<?php __('Cannot get the dmsGroup to be deleted. Error code'); ?>: ' + response.status);
		}
	});
}

function SearchByParentDmsGroupName(value){
	var conditions = '\'DmsGroup.name LIKE\' => \'%' + value + '%\'';
	store_parent_dmsGroups.reload({
		 params: {
			start: 0,
			limit: list_size,
			conditions: conditions
	    }
	});
}

function RefreshParentDmsGroupData() {
	store_parent_dmsGroups.reload();
}



var g = new Ext.grid.GridPanel({
	title: '<?php __('DmsGroups'); ?>',
	store: store_parent_dmsGroups,
	loadMask: true,
	stripeRows: true,
	height: 300,
	anchor: '100%',
    id: 'dmsGroupGrid',
	columns: [
		{header: "<?php __('Name'); ?>", dataIndex: 'name', sortable: true},
		{header:"<?php __('Created By'); ?>", dataIndex: 'user', sortable: true},
		{header: "<?php __('Public'); ?>", dataIndex: 'public', sortable: true},
		{header: "<?php __('Created'); ?>", dataIndex: 'created', sortable: true}	],
	sm: new Ext.grid.RowSelectionModel({
		singleSelect: false
	}),
	viewConfig: {
		forceFit: true
	},
    listeners: {
        celldblclick: function(){
            ViewDmsGroup(Ext.getCmp('dmsGroupGrid').getSelectionModel().getSelected().data.id);
        }
    },
	tbar: new Ext.Toolbar({
		items: [{
				xtype: 'tbbutton',
				text: '<?php __('Add'); ?>',
				tooltip:'<?php __('<b>Add DmsGroup</b><br />Click here to create a new DmsGroup'); ?>',
				icon: 'img/table_add.png',
				cls: 'x-btn-text-icon',
				handler: function(btn) {
					AddParentDmsGroup();
				}
			}, ' ', '-', ' ', {
				xtype: 'tbbutton',
				text: '<?php __('Edit'); ?>',
				id: 'edit-parent-dmsGroup',
				tooltip:'<?php __('<b>Edit DmsGroup</b><br />Click here to modify the selected DmsGroup'); ?>',
				icon: 'img/table_edit.png',
				cls: 'x-btn-text-icon',
				disabled: true,
				handler: function(btn) {
					var sm = g.getSelectionModel();
					var sel = sm.getSelected();
					if (sm.hasSelection()){
						EditParentDmsGroup(sel.data.id);
					};
				}
			}, ' ','-',' ',{
				xtype: 'tbbutton',
				text: '<?php __('Group Members'); ?>',
				id: 'view-dmsGroup2',
				tooltip:'<?php __('<b>Group Members</b><br />Click here to modify the selected DmsGroup'); ?>',
				icon: 'img/table_view.png',
				cls: 'x-btn-text-icon',
				disabled: true,
				handler: function(btn) {
					var sm = g.getSelectionModel();
					var sel = sm.getSelected();
					if (sm.hasSelection()){
						ViewDmsGroupDmsGroupLists(sel.data.id);
					};
				}
			}, ' ', '->', {
				xtype: 'textfield',
				emptyText: '<?php __('[Search By Name]'); ?>',
				id: 'parent_dmsGroup_search_field',
				listeners: {
					specialkey: function(field, e){
						if (e.getKey() == e.ENTER) {
							SearchByParentDmsGroupName(Ext.getCmp('parent_dmsGroup_search_field').getValue());
						}
					}

				}
			}, {
				xtype: 'tbbutton',
				icon: 'img/search.png',
				cls: 'x-btn-text-icon',
				text: 'GO',
				tooltip:'<?php __('<b>GO</b><br />Click here to get search results'); ?>',
				id: 'parent_dmsGroup_go_button',
				handler: function(){
					SearchByParentDmsGroupName(Ext.getCmp('parent_dmsGroup_search_field').getValue());
				}
			}, ' '
	]}),
	bbar: new Ext.PagingToolbar({
		pageSize: list_size,
		store: store_parent_dmsGroups,
		displayInfo: true,
		displayMsg: '<?php __('Displaying {0} - {1} of {2}'); ?>',
		beforePageText: '<?php __('Page'); ?>',
		afterPageText: '<?php __('of {0}'); ?>',
		emptyMsg: '<?php __('No data to display'); ?>'
	})
});
g.getSelectionModel().on('rowselect', function(sm, rowIdx, r) {
	g.getTopToolbar().findById('edit-parent-dmsGroup').enable();
	//g.getTopToolbar().findById('delete-parent-dmsGroup').enable();
        g.getTopToolbar().findById('view-dmsGroup2').enable();
	if(this.getSelections().length > 1){
		g.getTopToolbar().findById('edit-parent-dmsGroup').disable();
                g.getTopToolbar().findById('view-dmsGroup2').disable();
	}
});
g.getSelectionModel().on('rowdeselect', function(sm, rowIdx, r) {
	if(this.getSelections().length > 1){
		g.getTopToolbar().findById('edit-parent-dmsGroup').disable();
		//g.getTopToolbar().findById('delete-parent-dmsGroup').enable();
                g.getTopToolbar().findById('view-dmsGroup2').disable();
	}
	else if(this.getSelections().length == 1){
		g.getTopToolbar().findById('edit-parent-dmsGroup').enable();
		//g.getTopToolbar().findById('delete-parent-dmsGroup').enable();
                g.getTopToolbar().findById('view-dmsGroup2').enable();
	}
	else{
		g.getTopToolbar().findById('edit-parent-dmsGroup').disable();
		//g.getTopToolbar().findById('delete-parent-dmsGroup').disable();
                g.getTopToolbar().findById('view-dmsGroup2').disable();
	}
});



var parentDmsGroupsViewWindow = new Ext.Window({
	title: 'DmsGroup Under the selected Item',
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
			parentDmsGroupsViewWindow.close();
			Ext.getCmp('group-selector').clearValue();
			//Ext.getCmp('group-selector').reset();
			store_parent_dmsGroupsm.reload();
			
		}
	}]
});

store_parent_dmsGroups.load({
    params: {
        start: 0,    
        limit: list_size
    }
});