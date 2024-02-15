var store_parent_ormsRiskCategories = new Ext.data.Store({
	reader: new Ext.data.JsonReader({
		root:'rows',
		totalProperty: 'results',
		fields: [
			'id','name','parent_orms_risk_category','lft','rght','created','modified'	
		]
	}),
	proxy: new Ext.data.HttpProxy({
		url: '<?php echo $this->Html->url(array('controller' => 'ormsRiskCategories', 'action' => 'list_data', $parent_id)); ?>'	})
});


function AddParentOrmsRiskCategory() {
	Ext.Ajax.request({
		url: '<?php echo $this->Html->url(array('controller' => 'ormsRiskCategories', 'action' => 'add', $parent_id)); ?>',
		success: function(response, opts) {
			var parent_ormsRiskCategory_data = response.responseText;
			
			eval(parent_ormsRiskCategory_data);
			
			OrmsRiskCategoryAddWindow.show();
		},
		failure: function(response, opts) {
			Ext.Msg.alert('<?php __('Error'); ?>', '<?php __('Cannot get the ormsRiskCategory add form. Error code'); ?>: ' + response.status);
		}
	});
}

function EditParentOrmsRiskCategory(id) {
	Ext.Ajax.request({
		url: '<?php echo $this->Html->url(array('controller' => 'ormsRiskCategories', 'action' => 'edit')); ?>/'+id+'/<?php echo $parent_id; ?>',
		success: function(response, opts) {
			var parent_ormsRiskCategory_data = response.responseText;
			
			eval(parent_ormsRiskCategory_data);
			
			OrmsRiskCategoryEditWindow.show();
		},
		failure: function(response, opts) {
			Ext.Msg.alert('<?php __('Error'); ?>', '<?php __('Cannot get the ormsRiskCategory edit form. Error code'); ?>: ' + response.status);
		}
	});
}

function ViewOrmsRiskCategory(id) {
	Ext.Ajax.request({
		url: '<?php echo $this->Html->url(array('controller' => 'ormsRiskCategories', 'action' => 'view')); ?>/'+id,
		success: function(response, opts) {
			var ormsRiskCategory_data = response.responseText;

			eval(ormsRiskCategory_data);

			OrmsRiskCategoryViewWindow.show();
		},
		failure: function(response, opts) {
			Ext.Msg.alert('<?php __('Error'); ?>', '<?php __('Cannot get the ormsRiskCategory view form. Error code'); ?>: ' + response.status);
		}
	});
}

function ViewOrmsRiskCategoryOrmsRiskCategories(id) {
	Ext.Ajax.request({
		url: '<?php echo $this->Html->url(array('controller' => 'childOrmsRiskCategories', 'action' => 'index2')); ?>/'+id,
		success: function(response, opts) {
			var parent_childOrmsRiskCategories_data = response.responseText;

			eval(parent_childOrmsRiskCategories_data);

			parentOrmsRiskCategoriesViewWindow.show();
		},
		failure: function(response, opts) {
			Ext.Msg.alert('<?php __('Error'); ?>', '<?php __('Cannot get the campus view form. Error code'); ?>: ' + response.status);
		}
	});
}

function ViewOrmsRiskCategoryOrmsRisks(id) {
	Ext.Ajax.request({
		url: '<?php echo $this->Html->url(array('controller' => 'ormsRisks', 'action' => 'index2')); ?>/'+id,
		success: function(response, opts) {
			var parent_ormsRisks_data = response.responseText;

			eval(parent_ormsRisks_data);

			parentOrmsRisksViewWindow.show();
		},
		failure: function(response, opts) {
			Ext.Msg.alert('<?php __('Error'); ?>', '<?php __('Cannot get the campus view form. Error code'); ?>: ' + response.status);
		}
	});
}


function DeleteParentOrmsRiskCategory(id) {
	Ext.Ajax.request({
		url: '<?php echo $this->Html->url(array('controller' => 'ormsRiskCategories', 'action' => 'delete')); ?>/'+id,
		success: function(response, opts) {
			Ext.Msg.alert('<?php __('Success'); ?>', '<?php __('OrmsRiskCategory(s) successfully deleted!'); ?>');
			RefreshParentOrmsRiskCategoryData();
		},
		failure: function(response, opts) {
			Ext.Msg.alert('<?php __('Error'); ?>', '<?php __('Cannot get the ormsRiskCategory to be deleted. Error code'); ?>: ' + response.status);
		}
	});
}

function SearchByParentOrmsRiskCategoryName(value){
	var conditions = '\'OrmsRiskCategory.name LIKE\' => \'%' + value + '%\'';
	store_parent_ormsRiskCategories.reload({
		 params: {
			start: 0,
			limit: list_size,
			conditions: conditions
	    }
	});
}

function RefreshParentOrmsRiskCategoryData() {
	store_parent_ormsRiskCategories.reload();
}



var g = new Ext.grid.GridPanel({
	title: '<?php __('OrmsRiskCategories'); ?>',
	store: store_parent_ormsRiskCategories,
	loadMask: true,
	stripeRows: true,
	height: 300,
	anchor: '100%',
    id: 'ormsRiskCategoryGrid',
	columns: [
		{header: "<?php __('Name'); ?>", dataIndex: 'name', sortable: true},
		{header:"<?php __('parent_orms_risk_category'); ?>", dataIndex: 'parent_orms_risk_category', sortable: true},
		{header: "<?php __('Lft'); ?>", dataIndex: 'lft', sortable: true},
		{header: "<?php __('Rght'); ?>", dataIndex: 'rght', sortable: true},
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
            ViewOrmsRiskCategory(Ext.getCmp('ormsRiskCategoryGrid').getSelectionModel().getSelected().data.id);
        }
    },
	tbar: new Ext.Toolbar({
		items: [{
				xtype: 'tbbutton',
				text: '<?php __('Add'); ?>',
				tooltip:'<?php __('<b>Add OrmsRiskCategory</b><br />Click here to create a new OrmsRiskCategory'); ?>',
				icon: 'img/table_add.png',
				cls: 'x-btn-text-icon',
				handler: function(btn) {
					AddParentOrmsRiskCategory();
				}
			}, ' ', '-', ' ', {
				xtype: 'tbbutton',
				text: '<?php __('Edit'); ?>',
				id: 'edit-parent-ormsRiskCategory',
				tooltip:'<?php __('<b>Edit OrmsRiskCategory</b><br />Click here to modify the selected OrmsRiskCategory'); ?>',
				icon: 'img/table_edit.png',
				cls: 'x-btn-text-icon',
				disabled: true,
				handler: function(btn) {
					var sm = g.getSelectionModel();
					var sel = sm.getSelected();
					if (sm.hasSelection()){
						EditParentOrmsRiskCategory(sel.data.id);
					};
				}
			}, ' ', '-', ' ', {
				xtype: 'tbbutton',
				text: '<?php __('Delete'); ?>',
				id: 'delete-parent-ormsRiskCategory',
				tooltip:'<?php __('<b>Delete OrmsRiskCategory(s)</b><br />Click here to remove the selected OrmsRiskCategory(s)'); ?>',
				icon: 'img/table_delete.png',
				cls: 'x-btn-text-icon',
				disabled: true,
				handler: function(btn) {
					var sm = g.getSelectionModel();
					var sel = sm.getSelections();
					if (sm.hasSelection()){
						if(sel.length==1){
							Ext.Msg.show({
									title: '<?php __('Remove OrmsRiskCategory'); ?>',
									buttons: Ext.MessageBox.YESNOCANCEL,
									msg: '<?php __('Remove'); ?> '+sel[0].data.name+'?',
									icon: Ext.MessageBox.QUESTION,
                                    fn: function(btn){
											if (btn == 'yes'){
													DeleteParentOrmsRiskCategory(sel[0].data.id);
											}
									}
							});
						} else {
							Ext.Msg.show({
									title: '<?php __('Remove OrmsRiskCategory'); ?>',
									buttons: Ext.MessageBox.YESNOCANCEL,
									msg: '<?php __('Remove the selected OrmsRiskCategory'); ?>?',
									icon: Ext.MessageBox.QUESTION,
                                    fn: function(btn){
											if (btn == 'yes'){
													var sel_ids = '';
													for(i=0;i<sel.length;i++){
														if(i>0)
															sel_ids += '_';
														sel_ids += sel[i].data.id;
													}
													DeleteParentOrmsRiskCategory(sel_ids);
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
				text: '<?php __('View OrmsRiskCategory'); ?>',
				id: 'view-ormsRiskCategory2',
				tooltip:'<?php __('<b>View OrmsRiskCategory</b><br />Click here to see details of the selected OrmsRiskCategory'); ?>',
				icon: 'img/table_view.png',
				cls: 'x-btn-text-icon',
				disabled: true,
				handler: function(btn) {
					var sm = g.getSelectionModel();
					var sel = sm.getSelected();
					if (sm.hasSelection()){
						ViewOrmsRiskCategory(sel.data.id);
					};
				},
				menu : {
					items: [
 {
						text: '<?php __('View Orms Risk Categories'); ?>',
                        icon: 'img/table_view.png',
						cls: 'x-btn-text-icon',
						handler: function(btn) {
							var sm = g.getSelectionModel();
							var sel = sm.getSelected();
							if (sm.hasSelection()){
								ViewOrmsRiskCategoryOrmsRiskCategories(sel.data.id);
							};
						}
					}
, {
						text: '<?php __('View Orms Risks'); ?>',
                        icon: 'img/table_view.png',
						cls: 'x-btn-text-icon',
						handler: function(btn) {
							var sm = g.getSelectionModel();
							var sel = sm.getSelected();
							if (sm.hasSelection()){
								ViewOrmsRiskCategoryOrmsRisks(sel.data.id);
							};
						}
					}
					]
				}

            }, ' ', '->', {
				xtype: 'textfield',
				emptyText: '<?php __('[Search By Name]'); ?>',
				id: 'parent_ormsRiskCategory_search_field',
				listeners: {
					specialkey: function(field, e){
						if (e.getKey() == e.ENTER) {
							SearchByParentOrmsRiskCategoryName(Ext.getCmp('parent_ormsRiskCategory_search_field').getValue());
						}
					}

				}
			}, {
				xtype: 'tbbutton',
				icon: 'img/search.png',
				cls: 'x-btn-text-icon',
				text: 'GO',
				tooltip:'<?php __('<b>GO</b><br />Click here to get search results'); ?>',
				id: 'parent_ormsRiskCategory_go_button',
				handler: function(){
					SearchByParentOrmsRiskCategoryName(Ext.getCmp('parent_ormsRiskCategory_search_field').getValue());
				}
			}, ' '
	]}),
	bbar: new Ext.PagingToolbar({
		pageSize: list_size,
		store: store_parent_ormsRiskCategories,
		displayInfo: true,
		displayMsg: '<?php __('Displaying {0} - {1} of {2}'); ?>',
		beforePageText: '<?php __('Page'); ?>',
		afterPageText: '<?php __('of {0}'); ?>',
		emptyMsg: '<?php __('No data to display'); ?>'
	})
});
g.getSelectionModel().on('rowselect', function(sm, rowIdx, r) {
	g.getTopToolbar().findById('edit-parent-ormsRiskCategory').enable();
	g.getTopToolbar().findById('delete-parent-ormsRiskCategory').enable();
        g.getTopToolbar().findById('view-ormsRiskCategory2').enable();
	if(this.getSelections().length > 1){
		g.getTopToolbar().findById('edit-parent-ormsRiskCategory').disable();
                g.getTopToolbar().findById('view-ormsRiskCategory2').disable();
	}
});
g.getSelectionModel().on('rowdeselect', function(sm, rowIdx, r) {
	if(this.getSelections().length > 1){
		g.getTopToolbar().findById('edit-parent-ormsRiskCategory').disable();
		g.getTopToolbar().findById('delete-parent-ormsRiskCategory').enable();
                g.getTopToolbar().findById('view-ormsRiskCategory2').disable();
	}
	else if(this.getSelections().length == 1){
		g.getTopToolbar().findById('edit-parent-ormsRiskCategory').enable();
		g.getTopToolbar().findById('delete-parent-ormsRiskCategory').enable();
                g.getTopToolbar().findById('view-ormsRiskCategory2').enable();
	}
	else{
		g.getTopToolbar().findById('edit-parent-ormsRiskCategory').disable();
		g.getTopToolbar().findById('delete-parent-ormsRiskCategory').disable();
                g.getTopToolbar().findById('view-ormsRiskCategory2').disable();
	}
});



var parentOrmsRiskCategoriesViewWindow = new Ext.Window({
	title: 'OrmsRiskCategory Under the selected Item',
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
			parentOrmsRiskCategoriesViewWindow.close();
		}
	}]
});

store_parent_ormsRiskCategories.load({
    params: {
        start: 0,    
        limit: list_size
    }
});