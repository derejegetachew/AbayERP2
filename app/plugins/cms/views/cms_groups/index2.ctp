var store_parent_cmsGroups = new Ext.data.Store({
	reader: new Ext.data.JsonReader({
		root:'rows',
		totalProperty: 'results',
		fields: [
			'id','name','user','branch','created','modified'	
		]
	}),
	proxy: new Ext.data.HttpProxy({
		url: '<?php echo $this->Html->url(array('controller' => 'cmsGroups', 'action' => 'list_data', $parent_id)); ?>'	})
});


function AddParentCmsGroup() {
	Ext.Ajax.request({
		url: '<?php echo $this->Html->url(array('controller' => 'cmsGroups', 'action' => 'add', $parent_id)); ?>',
		success: function(response, opts) {
			var parent_cmsGroup_data = response.responseText;
			
			eval(parent_cmsGroup_data);
			
			CmsGroupAddWindow.show();
		},
		failure: function(response, opts) {
			Ext.Msg.alert('<?php __('Error'); ?>', '<?php __('Cannot get the cmsGroup add form. Error code'); ?>: ' + response.status);
		}
	});
}

function EditParentCmsGroup(id) {
	Ext.Ajax.request({
		url: '<?php echo $this->Html->url(array('controller' => 'cmsGroups', 'action' => 'edit')); ?>/'+id+'/<?php echo $parent_id; ?>',
		success: function(response, opts) {
			var parent_cmsGroup_data = response.responseText;
			
			eval(parent_cmsGroup_data);
			
			CmsGroupEditWindow.show();
		},
		failure: function(response, opts) {
			Ext.Msg.alert('<?php __('Error'); ?>', '<?php __('Cannot get the cmsGroup edit form. Error code'); ?>: ' + response.status);
		}
	});
}

function ViewCmsGroup(id) {
	Ext.Ajax.request({
		url: '<?php echo $this->Html->url(array('controller' => 'cmsGroups', 'action' => 'view')); ?>/'+id,
		success: function(response, opts) {
			var cmsGroup_data = response.responseText;

			eval(cmsGroup_data);

			CmsGroupViewWindow.show();
		},
		failure: function(response, opts) {
			Ext.Msg.alert('<?php __('Error'); ?>', '<?php __('Cannot get the cmsGroup view form. Error code'); ?>: ' + response.status);
		}
	});
}


function DeleteParentCmsGroup(id) {
	Ext.Ajax.request({
		url: '<?php echo $this->Html->url(array('controller' => 'cmsGroups', 'action' => 'delete')); ?>/'+id,
		success: function(response, opts) {
			Ext.Msg.alert('<?php __('Success'); ?>', '<?php __('CmsGroup(s) successfully deleted!'); ?>');
			RefreshParentCmsGroupData();
		},
		failure: function(response, opts) {
			Ext.Msg.alert('<?php __('Error'); ?>', '<?php __('Cannot get the cmsGroup to be deleted. Error code'); ?>: ' + response.status);
		}
	});
}

function SearchByParentCmsGroupName(value){
	var conditions = '\'CmsGroup.name LIKE\' => \'%' + value + '%\'';
	store_parent_cmsGroups.reload({
		 params: {
			start: 0,
			limit: list_size,
			conditions: conditions
	    }
	});
}

function RefreshParentCmsGroupData() {
	store_parent_cmsGroups.reload();
}



var g = new Ext.grid.GridPanel({
	title: '<?php __('Groups'); ?>',
	store: store_parent_cmsGroups,
	loadMask: true,
	stripeRows: true,
	height: 300,
	anchor: '100%',
    id: 'cmsGroupGrid',
	columns: [
		{header: "<?php __('Name'); ?>", dataIndex: 'name', sortable: true},
		{header:"<?php __('User'); ?>", dataIndex: 'user', sortable: true},
		{header:"<?php __('Branch'); ?>", dataIndex: 'branch', sortable: true},
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
            ViewCmsGroup(Ext.getCmp('cmsGroupGrid').getSelectionModel().getSelected().data.id);
        }
    },
	tbar: new Ext.Toolbar({
		items: [{
				xtype: 'tbbutton',
				text: '<?php __('Add'); ?>',
				tooltip:'<?php __('<b>Add CmsGroup</b><br />Click here to create a new CmsGroup'); ?>',
				icon: 'img/table_add.png',
				cls: 'x-btn-text-icon',
				handler: function(btn) {
					AddParentCmsGroup();
				}
			}, ' ', '-', ' ', {
				xtype: 'tbbutton',
				text: '<?php __('Edit'); ?>',
				id: 'edit-parent-cmsGroup',
				tooltip:'<?php __('<b>Edit CmsGroup</b><br />Click here to modify the selected CmsGroup'); ?>',
				icon: 'img/table_edit.png',
				cls: 'x-btn-text-icon',
				disabled: true,
				handler: function(btn) {
					var sm = g.getSelectionModel();
					var sel = sm.getSelected();
					if (sm.hasSelection()){
						EditParentCmsGroup(sel.data.id);
					};
				}
			}, ' ', '-', ' ', {
				xtype: 'tbbutton',
				text: '<?php __('Delete'); ?>',
				id: 'delete-parent-cmsGroup',
				tooltip:'<?php __('<b>Delete CmsGroup(s)</b><br />Click here to remove the selected CmsGroup(s)'); ?>',
				icon: 'img/table_delete.png',
				cls: 'x-btn-text-icon',
				disabled: true,
				handler: function(btn) {
					var sm = g.getSelectionModel();
					var sel = sm.getSelections();
					if (sm.hasSelection()){
						if(sel.length==1){
							Ext.Msg.show({
									title: '<?php __('Remove Group'); ?>',
									buttons: Ext.MessageBox.YESNOCANCEL,
									msg: '<?php __('Remove'); ?> '+sel[0].data.name+'?',
									icon: Ext.MessageBox.QUESTION,
                                    fn: function(btn){
											if (btn == 'yes'){
													DeleteParentCmsGroup(sel[0].data.id);
											}
									}
							});
						} else {
							Ext.Msg.show({
									title: '<?php __('Remove Group'); ?>',
									buttons: Ext.MessageBox.YESNOCANCEL,
									msg: '<?php __('Remove the selected CmsGroup'); ?>?',
									icon: Ext.MessageBox.QUESTION,
                                    fn: function(btn){
											if (btn == 'yes'){
													var sel_ids = '';
													for(i=0;i<sel.length;i++){
														if(i>0)
															sel_ids += '_';
														sel_ids += sel[i].data.id;
													}
													DeleteParentCmsGroup(sel_ids);
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
				text: '<?php __('View Group'); ?>',
				id: 'view-cmsGroup2',
				tooltip:'<?php __('<b>View Group</b><br />Click here to see details of the selected Group'); ?>',
				icon: 'img/table_view.png',
				cls: 'x-btn-text-icon',
				disabled: true,
				handler: function(btn) {
					var sm = g.getSelectionModel();
					var sel = sm.getSelected();
					if (sm.hasSelection()){
						ViewCmsGroup(sel.data.id);
					};
				},
				menu : {
					items: [
					]
				}

            }, ' ', '->', {
				xtype: 'textfield',
				emptyText: '<?php __('[Search By Name]'); ?>',
				id: 'parent_cmsGroup_search_field',
				listeners: {
					specialkey: function(field, e){
						if (e.getKey() == e.ENTER) {
							SearchByParentCmsGroupName(Ext.getCmp('parent_cmsGroup_search_field').getValue());
						}
					}

				}
			}, {
				xtype: 'tbbutton',
				icon: 'img/search.png',
				cls: 'x-btn-text-icon',
				text: 'GO',
				tooltip:'<?php __('<b>GO</b><br />Click here to get search results'); ?>',
				id: 'parent_cmsGroup_go_button',
				handler: function(){
					SearchByParentCmsGroupName(Ext.getCmp('parent_cmsGroup_search_field').getValue());
				}
			}, ' '
	]}),
	bbar: new Ext.PagingToolbar({
		pageSize: list_size,
		store: store_parent_cmsGroups,
		displayInfo: true,
		displayMsg: '<?php __('Displaying {0} - {1} of {2}'); ?>',
		beforePageText: '<?php __('Page'); ?>',
		afterPageText: '<?php __('of {0}'); ?>',
		emptyMsg: '<?php __('No data to display'); ?>'
	})
});
g.getSelectionModel().on('rowselect', function(sm, rowIdx, r) {
	g.getTopToolbar().findById('edit-parent-cmsGroup').enable();
	g.getTopToolbar().findById('delete-parent-cmsGroup').enable();
        g.getTopToolbar().findById('view-cmsGroup2').enable();
	if(this.getSelections().length > 1){
		g.getTopToolbar().findById('edit-parent-cmsGroup').disable();
                g.getTopToolbar().findById('view-cmsGroup2').disable();
	}
});
g.getSelectionModel().on('rowdeselect', function(sm, rowIdx, r) {
	if(this.getSelections().length > 1){
		g.getTopToolbar().findById('edit-parent-cmsGroup').disable();
		g.getTopToolbar().findById('delete-parent-cmsGroup').enable();
                g.getTopToolbar().findById('view-cmsGroup2').disable();
	}
	else if(this.getSelections().length == 1){
		g.getTopToolbar().findById('edit-parent-cmsGroup').enable();
		g.getTopToolbar().findById('delete-parent-cmsGroup').enable();
                g.getTopToolbar().findById('view-cmsGroup2').enable();
	}
	else{
		g.getTopToolbar().findById('edit-parent-cmsGroup').disable();
		g.getTopToolbar().findById('delete-parent-cmsGroup').disable();
                g.getTopToolbar().findById('view-cmsGroup2').disable();
	}
});



var parentCmsGroupsViewWindow = new Ext.Window({
	title: 'Manage Groups',
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
			parentCmsGroupsViewWindow.close();
		}
	}]
});

store_parent_cmsGroups.load({
    params: {
        start: 0,    
        limit: list_size
    }
});