var store_parent_imsBudgets = new Ext.data.Store({
	reader: new Ext.data.JsonReader({
		root:'rows',
		totalProperty: 'results',
		fields: [
			'id','name','budget_year','branch','created','modified'	
		]
	}),
	proxy: new Ext.data.HttpProxy({
		url: '<?php echo $this->Html->url(array('controller' => 'imsBudgets', 'action' => 'list_data', $parent_id)); ?>'	})
});


function AddParentImsBudget() {
	Ext.Ajax.request({
		url: '<?php echo $this->Html->url(array('controller' => 'imsBudgets', 'action' => 'add', $parent_id)); ?>',
		success: function(response, opts) {
			var parent_imsBudget_data = response.responseText;
			
			eval(parent_imsBudget_data);
			
			ImsBudgetAddWindow.show();
		},
		failure: function(response, opts) {
			Ext.Msg.alert('<?php __('Error'); ?>', '<?php __('Cannot get the Budget add form. Error code'); ?>: ' + response.status);
		}
	});
}

function EditParentImsBudget(id) {
	Ext.Ajax.request({
		url: '<?php echo $this->Html->url(array('controller' => 'imsBudgets', 'action' => 'edit')); ?>/'+id+'/<?php echo $parent_id; ?>',
		success: function(response, opts) {
			var parent_imsBudget_data = response.responseText;
			
			eval(parent_imsBudget_data);
			
			ImsBudgetEditWindow.show();
		},
		failure: function(response, opts) {
			Ext.Msg.alert('<?php __('Error'); ?>', '<?php __('Cannot get the Budget edit form. Error code'); ?>: ' + response.status);
		}
	});
}

function ViewImsBudget(id) {
	Ext.Ajax.request({
		url: '<?php echo $this->Html->url(array('controller' => 'imsBudgets', 'action' => 'view')); ?>/'+id,
		success: function(response, opts) {
			var imsBudget_data = response.responseText;

			eval(imsBudget_data);

			ImsBudgetViewWindow.show();
		},
		failure: function(response, opts) {
			Ext.Msg.alert('<?php __('Error'); ?>', '<?php __('Cannot get the Budget view form. Error code'); ?>: ' + response.status);
		}
	});
}

function ViewImsBudgetImsBudgetItems(id) {
	Ext.Ajax.request({
		url: '<?php echo $this->Html->url(array('controller' => 'BudgetItems', 'action' => 'index2')); ?>/'+id,
		success: function(response, opts) {
			var parent_imsBudgetItems_data = response.responseText;

			eval(parent_imsBudgetItems_data);

			parentImsBudgetItemsViewWindow.show();
		},
		failure: function(response, opts) {
			Ext.Msg.alert('<?php __('Error'); ?>', '<?php __('Cannot get the campus view form. Error code'); ?>: ' + response.status);
		}
	});
}


function DeleteParentImsBudget(id) {
	Ext.Ajax.request({
		url: '<?php echo $this->Html->url(array('controller' => 'imsBudgets', 'action' => 'delete')); ?>/'+id,
		success: function(response, opts) {
			Ext.Msg.alert('<?php __('Success'); ?>', '<?php __('Budget(s) successfully deleted!'); ?>');
			RefreshParentImsBudgetData();
		},
		failure: function(response, opts) {
			Ext.Msg.alert('<?php __('Error'); ?>', '<?php __('Cannot get the Budget to be deleted. Error code'); ?>: ' + response.status);
		}
	});
}

function SearchByParentImsBudgetName(value){
	var conditions = '\'ImsBudget.name LIKE\' => \'%' + value + '%\'';
	store_parent_imsBudgets.reload({
		 params: {
			start: 0,
			limit: list_size,
			conditions: conditions
	    }
	});
}

function RefreshParentImsBudgetData() {
	store_parent_imsBudgets.reload();
}



var g = new Ext.grid.GridPanel({
	title: '<?php __('Budgets'); ?>',
	store: store_parent_imsBudgets,
	loadMask: true,
	stripeRows: true,
	height: 300,
	anchor: '100%',
    id: 'imsBudgetGrid',
	columns: [
		{header: "<?php __('Name'); ?>", dataIndex: 'name', sortable: true},
		{header:"<?php __('budget_year'); ?>", dataIndex: 'budget_year', sortable: true},
		{header:"<?php __('branch'); ?>", dataIndex: 'branch', sortable: true},
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
            ViewImsBudget(Ext.getCmp('imsBudgetGrid').getSelectionModel().getSelected().data.id);
        }
    },
	tbar: new Ext.Toolbar({
		items: [{
				xtype: 'tbbutton',
				text: '<?php __('Add'); ?>',
				tooltip:'<?php __('<b>Add Budget</b><br />Click here to create a new Budget'); ?>',
				icon: 'img/table_add.png',
				cls: 'x-btn-text-icon',
				handler: function(btn) {
					AddParentImsBudget();
				}
			}, ' ', '-', ' ', {
				xtype: 'tbbutton',
				text: '<?php __('Edit'); ?>',
				id: 'edit-parent-imsBudget',
				tooltip:'<?php __('<b>Edit Budget</b><br />Click here to modify the selected Budget'); ?>',
				icon: 'img/table_edit.png',
				cls: 'x-btn-text-icon',
				disabled: true,
				handler: function(btn) {
					var sm = g.getSelectionModel();
					var sel = sm.getSelected();
					if (sm.hasSelection()){
						EditParentImsBudget(sel.data.id);
					};
				}
			}, ' ', '-', ' ', {
				xtype: 'tbbutton',
				text: '<?php __('Delete'); ?>',
				id: 'delete-parent-imsBudget',
				tooltip:'<?php __('<b>Delete Budget(s)</b><br />Click here to remove the selected Budget(s)'); ?>',
				icon: 'img/table_delete.png',
				cls: 'x-btn-text-icon',
				disabled: true,
				handler: function(btn) {
					var sm = g.getSelectionModel();
					var sel = sm.getSelections();
					if (sm.hasSelection()){
						if(sel.length==1){
							Ext.Msg.show({
									title: '<?php __('Remove Budget'); ?>',
									buttons: Ext.MessageBox.YESNOCANCEL,
									msg: '<?php __('Remove'); ?> '+sel[0].data.name+'?',
									icon: Ext.MessageBox.QUESTION,
                                    fn: function(btn){
											if (btn == 'yes'){
													DeleteParentImsBudget(sel[0].data.id);
											}
									}
							});
						} else {
							Ext.Msg.show({
									title: '<?php __('Remove Budget'); ?>',
									buttons: Ext.MessageBox.YESNOCANCEL,
									msg: '<?php __('Remove the selected Budget'); ?>?',
									icon: Ext.MessageBox.QUESTION,
                                    fn: function(btn){
											if (btn == 'yes'){
													var sel_ids = '';
													for(i=0;i<sel.length;i++){
														if(i>0)
															sel_ids += '_';
														sel_ids += sel[i].data.id;
													}
													DeleteParentImsBudget(sel_ids);
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
				text: '<?php __('View Budget'); ?>',
				id: 'view-imsBudget2',
				tooltip:'<?php __('<b>View Budget</b><br />Click here to see details of the selected Budget'); ?>',
				icon: 'img/table_view.png',
				cls: 'x-btn-text-icon',
				disabled: true,
				handler: function(btn) {
					var sm = g.getSelectionModel();
					var sel = sm.getSelected();
					if (sm.hasSelection()){
						ViewImsBudget(sel.data.id);
					};
				},
				menu : {
					items: [
 {
						text: '<?php __('View Budget Items'); ?>',
                        icon: 'img/table_view.png',
						cls: 'x-btn-text-icon',
						handler: function(btn) {
							var sm = g.getSelectionModel();
							var sel = sm.getSelected();
							if (sm.hasSelection()){
								ViewImsBudgetImsBudgetItems(sel.data.id);
							};
						}
					}
					]
				}

            }, ' ', '->', {
				xtype: 'textfield',
				emptyText: '<?php __('[Search By Name]'); ?>',
				id: 'parent_imsBudget_search_field',
				listeners: {
					specialkey: function(field, e){
						if (e.getKey() == e.ENTER) {
							SearchByParentImsBudgetName(Ext.getCmp('parent_imsBudget_search_field').getValue());
						}
					}

				}
			}, {
				xtype: 'tbbutton',
				icon: 'img/search.png',
				cls: 'x-btn-text-icon',
				text: 'GO',
				tooltip:'<?php __('<b>GO</b><br />Click here to get search results'); ?>',
				id: 'parent_imsBudget_go_button',
				handler: function(){
					SearchByParentImsBudgetName(Ext.getCmp('parent_imsBudget_search_field').getValue());
				}
			}, ' '
	]}),
	bbar: new Ext.PagingToolbar({
		pageSize: list_size,
		store: store_parent_imsBudgets,
		displayInfo: true,
		displayMsg: '<?php __('Displaying {0} - {1} of {2}'); ?>',
		beforePageText: '<?php __('Page'); ?>',
		afterPageText: '<?php __('of {0}'); ?>',
		emptyMsg: '<?php __('No data to display'); ?>'
	})
});
g.getSelectionModel().on('rowselect', function(sm, rowIdx, r) {
	g.getTopToolbar().findById('edit-parent-imsBudget').enable();
	g.getTopToolbar().findById('delete-parent-imsBudget').enable();
        g.getTopToolbar().findById('view-imsBudget2').enable();
	if(this.getSelections().length > 1){
		g.getTopToolbar().findById('edit-parent-imsBudget').disable();
                g.getTopToolbar().findById('view-imsBudget2').disable();
	}
});
g.getSelectionModel().on('rowdeselect', function(sm, rowIdx, r) {
	if(this.getSelections().length > 1){
		g.getTopToolbar().findById('edit-parent-imsBudget').disable();
		g.getTopToolbar().findById('delete-parent-imsBudget').enable();
                g.getTopToolbar().findById('view-imsBudget2').disable();
	}
	else if(this.getSelections().length == 1){
		g.getTopToolbar().findById('edit-parent-imsBudget').enable();
		g.getTopToolbar().findById('delete-parent-imsBudget').enable();
                g.getTopToolbar().findById('view-imsBudget2').enable();
	}
	else{
		g.getTopToolbar().findById('edit-parent-imsBudget').disable();
		g.getTopToolbar().findById('delete-parent-imsBudget').disable();
                g.getTopToolbar().findById('view-imsBudget2').disable();
	}
});



var parentImsBudgetsViewWindow = new Ext.Window({
	title: 'ImsBudget Under the selected Item',
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
			parentImsBudgetsViewWindow.close();
		}
	}]
});

store_parent_imsBudgets.load({
    params: {
        start: 0,    
        limit: list_size
    }
});