var store_parent_cmsCases = new Ext.data.Store({
	reader: new Ext.data.JsonReader({
		root:'rows',
		totalProperty: 'results',
		fields: [
			'id','name','content','branch','level','attachement','user','status','searchable','created','modified'	
		]
	}),
	proxy: new Ext.data.HttpProxy({
		url: '<?php echo $this->Html->url(array('controller' => 'cmsCases', 'action' => 'list_data', $parent_id)); ?>'	})
});


function AddParentCmsCase() {
	Ext.Ajax.request({
		url: '<?php echo $this->Html->url(array('controller' => 'cmsCases', 'action' => 'add', $parent_id)); ?>',
		success: function(response, opts) {
			var parent_cmsCase_data = response.responseText;
			
			eval(parent_cmsCase_data);
			
			CmsCaseAddWindow.show();
		},
		failure: function(response, opts) {
			Ext.Msg.alert('<?php __('Error'); ?>', '<?php __('Cannot get the cmsCase add form. Error code'); ?>: ' + response.status);
		}
	});
}

function EditParentCmsCase(id) {
	Ext.Ajax.request({
		url: '<?php echo $this->Html->url(array('controller' => 'cmsCases', 'action' => 'edit')); ?>/'+id+'/<?php echo $parent_id; ?>',
		success: function(response, opts) {
			var parent_cmsCase_data = response.responseText;
			
			eval(parent_cmsCase_data);
			
			CmsCaseEditWindow.show();
		},
		failure: function(response, opts) {
			Ext.Msg.alert('<?php __('Error'); ?>', '<?php __('Cannot get the cmsCase edit form. Error code'); ?>: ' + response.status);
		}
	});
}

function ViewCmsCase(id) {
	Ext.Ajax.request({
		url: '<?php echo $this->Html->url(array('controller' => 'cmsCases', 'action' => 'view')); ?>/'+id,
		success: function(response, opts) {
			var cmsCase_data = response.responseText;

			eval(cmsCase_data);

			CmsCaseViewWindow.show();
		},
		failure: function(response, opts) {
			Ext.Msg.alert('<?php __('Error'); ?>', '<?php __('Cannot get the cmsCase view form. Error code'); ?>: ' + response.status);
		}
	});
}


function DeleteParentCmsCase(id) {
	Ext.Ajax.request({
		url: '<?php echo $this->Html->url(array('controller' => 'cmsCases', 'action' => 'delete')); ?>/'+id,
		success: function(response, opts) {
			Ext.Msg.alert('<?php __('Success'); ?>', '<?php __('CmsCase(s) successfully deleted!'); ?>');
			RefreshParentCmsCaseData();
		},
		failure: function(response, opts) {
			Ext.Msg.alert('<?php __('Error'); ?>', '<?php __('Cannot get the cmsCase to be deleted. Error code'); ?>: ' + response.status);
		}
	});
}

function SearchByParentCmsCaseName(value){
	var conditions = '\'CmsCase.name LIKE\' => \'%' + value + '%\'';
	store_parent_cmsCases.reload({
		 params: {
			start: 0,
			limit: list_size,
			conditions: conditions
	    }
	});
}

function RefreshParentCmsCaseData() {
	store_parent_cmsCases.reload();
}



var g = new Ext.grid.GridPanel({
	title: '<?php __('CmsCases'); ?>',
	store: store_parent_cmsCases,
	loadMask: true,
	stripeRows: true,
	height: 300,
	anchor: '100%',
    id: 'cmsCaseGrid',
	columns: [
		{header: "<?php __('Name'); ?>", dataIndex: 'name', sortable: true},
		{header: "<?php __('Content'); ?>", dataIndex: 'content', sortable: true},
		{header:"<?php __('branch'); ?>", dataIndex: 'branch', sortable: true},
		{header: "<?php __('Level'); ?>", dataIndex: 'level', sortable: true},
		{header: "<?php __('Attachement'); ?>", dataIndex: 'attachement', sortable: true},
		{header:"<?php __('user'); ?>", dataIndex: 'user', sortable: true},
		{header: "<?php __('Status'); ?>", dataIndex: 'status', sortable: true},
		{header: "<?php __('Searchable'); ?>", dataIndex: 'searchable', sortable: true},
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
            ViewCmsCase(Ext.getCmp('cmsCaseGrid').getSelectionModel().getSelected().data.id);
        }
    },
	tbar: new Ext.Toolbar({
		items: [{
				xtype: 'tbbutton',
				text: '<?php __('Add'); ?>',
				tooltip:'<?php __('<b>Add CmsCase</b><br />Click here to create a new CmsCase'); ?>',
				icon: 'img/table_add.png',
				cls: 'x-btn-text-icon',
				handler: function(btn) {
					AddParentCmsCase();
				}
			}, ' ', '-', ' ', {
				xtype: 'tbbutton',
				text: '<?php __('Edit'); ?>',
				id: 'edit-parent-cmsCase',
				tooltip:'<?php __('<b>Edit CmsCase</b><br />Click here to modify the selected CmsCase'); ?>',
				icon: 'img/table_edit.png',
				cls: 'x-btn-text-icon',
				disabled: true,
				handler: function(btn) {
					var sm = g.getSelectionModel();
					var sel = sm.getSelected();
					if (sm.hasSelection()){
						EditParentCmsCase(sel.data.id);
					};
				}
			}, ' ', '-', ' ', {
				xtype: 'tbbutton',
				text: '<?php __('Delete'); ?>',
				id: 'delete-parent-cmsCase',
				tooltip:'<?php __('<b>Delete CmsCase(s)</b><br />Click here to remove the selected CmsCase(s)'); ?>',
				icon: 'img/table_delete.png',
				cls: 'x-btn-text-icon',
				disabled: true,
				handler: function(btn) {
					var sm = g.getSelectionModel();
					var sel = sm.getSelections();
					if (sm.hasSelection()){
						if(sel.length==1){
							Ext.Msg.show({
									title: '<?php __('Remove CmsCase'); ?>',
									buttons: Ext.MessageBox.YESNOCANCEL,
									msg: '<?php __('Remove'); ?> '+sel[0].data.name+'?',
									icon: Ext.MessageBox.QUESTION,
                                    fn: function(btn){
											if (btn == 'yes'){
													DeleteParentCmsCase(sel[0].data.id);
											}
									}
							});
						} else {
							Ext.Msg.show({
									title: '<?php __('Remove CmsCase'); ?>',
									buttons: Ext.MessageBox.YESNOCANCEL,
									msg: '<?php __('Remove the selected CmsCase'); ?>?',
									icon: Ext.MessageBox.QUESTION,
                                    fn: function(btn){
											if (btn == 'yes'){
													var sel_ids = '';
													for(i=0;i<sel.length;i++){
														if(i>0)
															sel_ids += '_';
														sel_ids += sel[i].data.id;
													}
													DeleteParentCmsCase(sel_ids);
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
				text: '<?php __('View CmsCase'); ?>',
				id: 'view-cmsCase2',
				tooltip:'<?php __('<b>View CmsCase</b><br />Click here to see details of the selected CmsCase'); ?>',
				icon: 'img/table_view.png',
				cls: 'x-btn-text-icon',
				disabled: true,
				handler: function(btn) {
					var sm = g.getSelectionModel();
					var sel = sm.getSelected();
					if (sm.hasSelection()){
						ViewCmsCase(sel.data.id);
					};
				},
				menu : {
					items: [
					]
				}

            }, ' ', '->', {
				xtype: 'textfield',
				emptyText: '<?php __('[Search By Name]'); ?>',
				id: 'parent_cmsCase_search_field',
				listeners: {
					specialkey: function(field, e){
						if (e.getKey() == e.ENTER) {
							SearchByParentCmsCaseName(Ext.getCmp('parent_cmsCase_search_field').getValue());
						}
					}

				}
			}, {
				xtype: 'tbbutton',
				icon: 'img/search.png',
				cls: 'x-btn-text-icon',
				text: 'GO',
				tooltip:'<?php __('<b>GO</b><br />Click here to get search results'); ?>',
				id: 'parent_cmsCase_go_button',
				handler: function(){
					SearchByParentCmsCaseName(Ext.getCmp('parent_cmsCase_search_field').getValue());
				}
			}, ' '
	]}),
	bbar: new Ext.PagingToolbar({
		pageSize: list_size,
		store: store_parent_cmsCases,
		displayInfo: true,
		displayMsg: '<?php __('Displaying {0} - {1} of {2}'); ?>',
		beforePageText: '<?php __('Page'); ?>',
		afterPageText: '<?php __('of {0}'); ?>',
		emptyMsg: '<?php __('No data to display'); ?>'
	})
});
g.getSelectionModel().on('rowselect', function(sm, rowIdx, r) {
	g.getTopToolbar().findById('edit-parent-cmsCase').enable();
	g.getTopToolbar().findById('delete-parent-cmsCase').enable();
        g.getTopToolbar().findById('view-cmsCase2').enable();
	if(this.getSelections().length > 1){
		g.getTopToolbar().findById('edit-parent-cmsCase').disable();
                g.getTopToolbar().findById('view-cmsCase2').disable();
	}
});
g.getSelectionModel().on('rowdeselect', function(sm, rowIdx, r) {
	if(this.getSelections().length > 1){
		g.getTopToolbar().findById('edit-parent-cmsCase').disable();
		g.getTopToolbar().findById('delete-parent-cmsCase').enable();
                g.getTopToolbar().findById('view-cmsCase2').disable();
	}
	else if(this.getSelections().length == 1){
		g.getTopToolbar().findById('edit-parent-cmsCase').enable();
		g.getTopToolbar().findById('delete-parent-cmsCase').enable();
                g.getTopToolbar().findById('view-cmsCase2').enable();
	}
	else{
		g.getTopToolbar().findById('edit-parent-cmsCase').disable();
		g.getTopToolbar().findById('delete-parent-cmsCase').disable();
                g.getTopToolbar().findById('view-cmsCase2').disable();
	}
});



var parentCmsCasesViewWindow = new Ext.Window({
	title: 'CmsCase Under the selected Item',
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
			parentCmsCasesViewWindow.close();
		}
	}]
});

store_parent_cmsCases.load({
    params: {
        start: 0,    
        limit: list_size
    }
});