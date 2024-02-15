var store_parent_cmsAssignments = new Ext.data.Store({
	reader: new Ext.data.JsonReader({
		root:'rows',
		totalProperty: 'results',
		fields: [
			'id','cms_case','assigned_by','assigned_to','created'	
		]
	}),
	proxy: new Ext.data.HttpProxy({
		url: '<?php echo $this->Html->url(array('controller' => 'cmsAssignments', 'action' => 'list_data', $parent_id)); ?>'	})
});


function AddParentCmsAssignment() {
	Ext.Ajax.request({
		url: '<?php echo $this->Html->url(array('controller' => 'cmsAssignments', 'action' => 'add', $parent_id)); ?>',
		success: function(response, opts) {
			var parent_cmsAssignment_data = response.responseText;
			
			eval(parent_cmsAssignment_data);
			
			CmsAssignmentAddWindow.show();
		},
		failure: function(response, opts) {
			Ext.Msg.alert('<?php __('Error'); ?>', '<?php __('Cannot get the cmsAssignment add form. Error code'); ?>: ' + response.status);
		}
	});
}

function EditParentCmsAssignment(id) {
	Ext.Ajax.request({
		url: '<?php echo $this->Html->url(array('controller' => 'cmsAssignments', 'action' => 'edit')); ?>/'+id+'/<?php echo $parent_id; ?>',
		success: function(response, opts) {
			var parent_cmsAssignment_data = response.responseText;
			
			eval(parent_cmsAssignment_data);
			
			CmsAssignmentEditWindow.show();
		},
		failure: function(response, opts) {
			Ext.Msg.alert('<?php __('Error'); ?>', '<?php __('Cannot get the cmsAssignment edit form. Error code'); ?>: ' + response.status);
		}
	});
}

function ViewCmsAssignment(id) {
	Ext.Ajax.request({
		url: '<?php echo $this->Html->url(array('controller' => 'cmsAssignments', 'action' => 'view')); ?>/'+id,
		success: function(response, opts) {
			var cmsAssignment_data = response.responseText;

			eval(cmsAssignment_data);

			CmsAssignmentViewWindow.show();
		},
		failure: function(response, opts) {
			Ext.Msg.alert('<?php __('Error'); ?>', '<?php __('Cannot get the cmsAssignment view form. Error code'); ?>: ' + response.status);
		}
	});
}


function DeleteParentCmsAssignment(id) {
	Ext.Ajax.request({
		url: '<?php echo $this->Html->url(array('controller' => 'cmsAssignments', 'action' => 'delete')); ?>/'+id,
		success: function(response, opts) {
			Ext.Msg.alert('<?php __('Success'); ?>', '<?php __('CmsAssignment(s) successfully deleted!'); ?>');
			RefreshParentCmsAssignmentData();
		},
		failure: function(response, opts) {
			Ext.Msg.alert('<?php __('Error'); ?>', '<?php __('Cannot get the cmsAssignment to be deleted. Error code'); ?>: ' + response.status);
		}
	});
}

function SearchByParentCmsAssignmentName(value){
	var conditions = '\'CmsAssignment.name LIKE\' => \'%' + value + '%\'';
	store_parent_cmsAssignments.reload({
		 params: {
			start: 0,
			limit: list_size,
			conditions: conditions
	    }
	});
}

function RefreshParentCmsAssignmentData() {
	store_parent_cmsAssignments.reload();
}



var g = new Ext.grid.GridPanel({
	title: '<?php __('CmsAssignments'); ?>',
	store: store_parent_cmsAssignments,
	loadMask: true,
	stripeRows: true,
	height: 300,
	anchor: '100%',
    id: 'cmsAssignmentGrid',
	columns: [
		{header:"<?php __('cms_case'); ?>", dataIndex: 'cms_case', sortable: true},
		{header: "<?php __('Assigned By'); ?>", dataIndex: 'assigned_by', sortable: true},
		{header: "<?php __('Assigned To'); ?>", dataIndex: 'assigned_to', sortable: true},
		{header: "<?php __('Created'); ?>", dataIndex: 'created', sortable: true}	],
	sm: new Ext.grid.RowSelectionModel({
		singleSelect: false
	}),
	viewConfig: {
		forceFit: true
	},
    listeners: {
        celldblclick: function(){
            ViewCmsAssignment(Ext.getCmp('cmsAssignmentGrid').getSelectionModel().getSelected().data.id);
        }
    },
	tbar: new Ext.Toolbar({
		items: [{
				xtype: 'tbbutton',
				text: '<?php __('Add'); ?>',
				tooltip:'<?php __('<b>Add CmsAssignment</b><br />Click here to create a new CmsAssignment'); ?>',
				icon: 'img/table_add.png',
				cls: 'x-btn-text-icon',
				handler: function(btn) {
					AddParentCmsAssignment();
				}
			}, ' ', '-', ' ', {
				xtype: 'tbbutton',
				text: '<?php __('Edit'); ?>',
				id: 'edit-parent-cmsAssignment',
				tooltip:'<?php __('<b>Edit CmsAssignment</b><br />Click here to modify the selected CmsAssignment'); ?>',
				icon: 'img/table_edit.png',
				cls: 'x-btn-text-icon',
				disabled: true,
				handler: function(btn) {
					var sm = g.getSelectionModel();
					var sel = sm.getSelected();
					if (sm.hasSelection()){
						EditParentCmsAssignment(sel.data.id);
					};
				}
			}, ' ', '-', ' ', {
				xtype: 'tbbutton',
				text: '<?php __('Delete'); ?>',
				id: 'delete-parent-cmsAssignment',
				tooltip:'<?php __('<b>Delete CmsAssignment(s)</b><br />Click here to remove the selected CmsAssignment(s)'); ?>',
				icon: 'img/table_delete.png',
				cls: 'x-btn-text-icon',
				disabled: true,
				handler: function(btn) {
					var sm = g.getSelectionModel();
					var sel = sm.getSelections();
					if (sm.hasSelection()){
						if(sel.length==1){
							Ext.Msg.show({
									title: '<?php __('Remove CmsAssignment'); ?>',
									buttons: Ext.MessageBox.YESNOCANCEL,
									msg: '<?php __('Remove'); ?> '+sel[0].data.name+'?',
									icon: Ext.MessageBox.QUESTION,
                                    fn: function(btn){
											if (btn == 'yes'){
													DeleteParentCmsAssignment(sel[0].data.id);
											}
									}
							});
						} else {
							Ext.Msg.show({
									title: '<?php __('Remove CmsAssignment'); ?>',
									buttons: Ext.MessageBox.YESNOCANCEL,
									msg: '<?php __('Remove the selected CmsAssignment'); ?>?',
									icon: Ext.MessageBox.QUESTION,
                                    fn: function(btn){
											if (btn == 'yes'){
													var sel_ids = '';
													for(i=0;i<sel.length;i++){
														if(i>0)
															sel_ids += '_';
														sel_ids += sel[i].data.id;
													}
													DeleteParentCmsAssignment(sel_ids);
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
				text: '<?php __('View CmsAssignment'); ?>',
				id: 'view-cmsAssignment2',
				tooltip:'<?php __('<b>View CmsAssignment</b><br />Click here to see details of the selected CmsAssignment'); ?>',
				icon: 'img/table_view.png',
				cls: 'x-btn-text-icon',
				disabled: true,
				handler: function(btn) {
					var sm = g.getSelectionModel();
					var sel = sm.getSelected();
					if (sm.hasSelection()){
						ViewCmsAssignment(sel.data.id);
					};
				},
				menu : {
					items: [
					]
				}

            }, ' ', '->', {
				xtype: 'textfield',
				emptyText: '<?php __('[Search By Name]'); ?>',
				id: 'parent_cmsAssignment_search_field',
				listeners: {
					specialkey: function(field, e){
						if (e.getKey() == e.ENTER) {
							SearchByParentCmsAssignmentName(Ext.getCmp('parent_cmsAssignment_search_field').getValue());
						}
					}

				}
			}, {
				xtype: 'tbbutton',
				icon: 'img/search.png',
				cls: 'x-btn-text-icon',
				text: 'GO',
				tooltip:'<?php __('<b>GO</b><br />Click here to get search results'); ?>',
				id: 'parent_cmsAssignment_go_button',
				handler: function(){
					SearchByParentCmsAssignmentName(Ext.getCmp('parent_cmsAssignment_search_field').getValue());
				}
			}, ' '
	]}),
	bbar: new Ext.PagingToolbar({
		pageSize: list_size,
		store: store_parent_cmsAssignments,
		displayInfo: true,
		displayMsg: '<?php __('Displaying {0} - {1} of {2}'); ?>',
		beforePageText: '<?php __('Page'); ?>',
		afterPageText: '<?php __('of {0}'); ?>',
		emptyMsg: '<?php __('No data to display'); ?>'
	})
});
g.getSelectionModel().on('rowselect', function(sm, rowIdx, r) {
	g.getTopToolbar().findById('edit-parent-cmsAssignment').enable();
	g.getTopToolbar().findById('delete-parent-cmsAssignment').enable();
        g.getTopToolbar().findById('view-cmsAssignment2').enable();
	if(this.getSelections().length > 1){
		g.getTopToolbar().findById('edit-parent-cmsAssignment').disable();
                g.getTopToolbar().findById('view-cmsAssignment2').disable();
	}
});
g.getSelectionModel().on('rowdeselect', function(sm, rowIdx, r) {
	if(this.getSelections().length > 1){
		g.getTopToolbar().findById('edit-parent-cmsAssignment').disable();
		g.getTopToolbar().findById('delete-parent-cmsAssignment').enable();
                g.getTopToolbar().findById('view-cmsAssignment2').disable();
	}
	else if(this.getSelections().length == 1){
		g.getTopToolbar().findById('edit-parent-cmsAssignment').enable();
		g.getTopToolbar().findById('delete-parent-cmsAssignment').enable();
                g.getTopToolbar().findById('view-cmsAssignment2').enable();
	}
	else{
		g.getTopToolbar().findById('edit-parent-cmsAssignment').disable();
		g.getTopToolbar().findById('delete-parent-cmsAssignment').disable();
                g.getTopToolbar().findById('view-cmsAssignment2').disable();
	}
});



var parentCmsAssignmentsViewWindow = new Ext.Window({
	title: 'CmsAssignment Under the selected Item',
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
			parentCmsAssignmentsViewWindow.close();
		}
	}]
});

store_parent_cmsAssignments.load({
    params: {
        start: 0,    
        limit: list_size
    }
});