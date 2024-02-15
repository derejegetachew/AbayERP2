var store_parent_pensionEmployees = new Ext.data.Store({
	reader: new Ext.data.JsonReader({
		root:'rows',
		totalProperty: 'results',
		fields: [
			'id','pension','employee'	
		]
	}),
	proxy: new Ext.data.HttpProxy({
		url: '<?php echo $this->Html->url(array('controller' => 'pensionEmployees', 'action' => 'list_data', $parent_id)); ?>'	})
});


function AddParentPensionEmployee() {
	Ext.Ajax.request({
		url: '<?php echo $this->Html->url(array('controller' => 'pensionEmployees', 'action' => 'add', $parent_id)); ?>',
		success: function(response, opts) {
			var parent_pensionEmployee_data = response.responseText;
			
			eval(parent_pensionEmployee_data);
			
			PensionEmployeeAddWindow.show();
		},
		failure: function(response, opts) {
			Ext.Msg.alert('<?php __('Error'); ?>', '<?php __('Cannot get the pensionEmployee add form. Error code'); ?>: ' + response.status);
		}
	});
}

function EditParentPensionEmployee(id) {
	Ext.Ajax.request({
		url: '<?php echo $this->Html->url(array('controller' => 'pensionEmployees', 'action' => 'edit')); ?>/'+id+'/<?php echo $parent_id; ?>',
		success: function(response, opts) {
			var parent_pensionEmployee_data = response.responseText;
			
			eval(parent_pensionEmployee_data);
			
			PensionEmployeeEditWindow.show();
		},
		failure: function(response, opts) {
			Ext.Msg.alert('<?php __('Error'); ?>', '<?php __('Cannot get the pensionEmployee edit form. Error code'); ?>: ' + response.status);
		}
	});
}

function ViewPensionEmployee(id) {
	Ext.Ajax.request({
		url: '<?php echo $this->Html->url(array('controller' => 'pensionEmployees', 'action' => 'view')); ?>/'+id,
		success: function(response, opts) {
			var pensionEmployee_data = response.responseText;

			eval(pensionEmployee_data);

			PensionEmployeeViewWindow.show();
		},
		failure: function(response, opts) {
			Ext.Msg.alert('<?php __('Error'); ?>', '<?php __('Cannot get the pensionEmployee view form. Error code'); ?>: ' + response.status);
		}
	});
}


function DeleteParentPensionEmployee(id) {
	Ext.Ajax.request({
		url: '<?php echo $this->Html->url(array('controller' => 'pensionEmployees', 'action' => 'delete')); ?>/'+id,
		success: function(response, opts) {
			Ext.Msg.alert('<?php __('Success'); ?>', '<?php __('PensionEmployee(s) successfully deleted!'); ?>');
			RefreshParentPensionEmployeeData();
		},
		failure: function(response, opts) {
			Ext.Msg.alert('<?php __('Error'); ?>', '<?php __('Cannot get the pensionEmployee to be deleted. Error code'); ?>: ' + response.status);
		}
	});
}

function SearchByParentPensionEmployeeName(value){
	var conditions = '\'PensionEmployee.name LIKE\' => \'%' + value + '%\'';
	store_parent_pensionEmployees.reload({
		 params: {
			start: 0,
			limit: list_size,
			conditions: conditions
	    }
	});
}

function RefreshParentPensionEmployeeData() {
	store_parent_pensionEmployees.reload();
}



var g = new Ext.grid.GridPanel({
	title: '<?php __('PensionEmployees'); ?>',
	store: store_parent_pensionEmployees,
	loadMask: true,
	stripeRows: true,
	height: 300,
	anchor: '100%',
    id: 'pensionEmployeeGrid',
	columns: [
		{header:"<?php __('pension'); ?>", dataIndex: 'pension', sortable: true},
		{header:"<?php __('employee'); ?>", dataIndex: 'employee', sortable: true}	],
	sm: new Ext.grid.RowSelectionModel({
		singleSelect: false
	}),
	viewConfig: {
		forceFit: true
	},
    listeners: {
        celldblclick: function(){
            ViewPensionEmployee(Ext.getCmp('pensionEmployeeGrid').getSelectionModel().getSelected().data.id);
        }
    },
	tbar: new Ext.Toolbar({
		items: [{
				xtype: 'tbbutton',
				text: '<?php __('Add'); ?>',
				tooltip:'<?php __('<b>Add PensionEmployee</b><br />Click here to create a new PensionEmployee'); ?>',
				icon: 'img/table_add.png',
				cls: 'x-btn-text-icon',
				handler: function(btn) {
					AddParentPensionEmployee();
				}
			}, ' ', '-', ' ', {
				xtype: 'tbbutton',
				text: '<?php __('Edit'); ?>',
				id: 'edit-parent-pensionEmployee',
				tooltip:'<?php __('<b>Edit PensionEmployee</b><br />Click here to modify the selected PensionEmployee'); ?>',
				icon: 'img/table_edit.png',
				cls: 'x-btn-text-icon',
				disabled: true,
				handler: function(btn) {
					var sm = g.getSelectionModel();
					var sel = sm.getSelected();
					if (sm.hasSelection()){
						EditParentPensionEmployee(sel.data.id);
					};
				}
			}, ' ', '-', ' ', {
				xtype: 'tbbutton',
				text: '<?php __('Delete'); ?>',
				id: 'delete-parent-pensionEmployee',
				tooltip:'<?php __('<b>Delete PensionEmployee(s)</b><br />Click here to remove the selected PensionEmployee(s)'); ?>',
				icon: 'img/table_delete.png',
				cls: 'x-btn-text-icon',
				disabled: true,
				handler: function(btn) {
					var sm = g.getSelectionModel();
					var sel = sm.getSelections();
					if (sm.hasSelection()){
						if(sel.length==1){
							Ext.Msg.show({
									title: '<?php __('Remove PensionEmployee'); ?>',
									buttons: Ext.MessageBox.YESNOCANCEL,
									msg: '<?php __('Remove'); ?> '+sel[0].data.name+'?',
									icon: Ext.MessageBox.QUESTION,
                                    fn: function(btn){
											if (btn == 'yes'){
													DeleteParentPensionEmployee(sel[0].data.id);
											}
									}
							});
						} else {
							Ext.Msg.show({
									title: '<?php __('Remove PensionEmployee'); ?>',
									buttons: Ext.MessageBox.YESNOCANCEL,
									msg: '<?php __('Remove the selected PensionEmployee'); ?>?',
									icon: Ext.MessageBox.QUESTION,
                                    fn: function(btn){
											if (btn == 'yes'){
													var sel_ids = '';
													for(i=0;i<sel.length;i++){
														if(i>0)
															sel_ids += '_';
														sel_ids += sel[i].data.id;
													}
													DeleteParentPensionEmployee(sel_ids);
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
				text: '<?php __('View PensionEmployee'); ?>',
				id: 'view-pensionEmployee2',
				tooltip:'<?php __('<b>View PensionEmployee</b><br />Click here to see details of the selected PensionEmployee'); ?>',
				icon: 'img/table_view.png',
				cls: 'x-btn-text-icon',
				disabled: true,
				handler: function(btn) {
					var sm = g.getSelectionModel();
					var sel = sm.getSelected();
					if (sm.hasSelection()){
						ViewPensionEmployee(sel.data.id);
					};
				},
				menu : {
					items: [
					]
				}

            }, ' ', '->', {
				xtype: 'textfield',
				emptyText: '<?php __('[Search By Name]'); ?>',
				id: 'parent_pensionEmployee_search_field',
				listeners: {
					specialkey: function(field, e){
						if (e.getKey() == e.ENTER) {
							SearchByParentPensionEmployeeName(Ext.getCmp('parent_pensionEmployee_search_field').getValue());
						}
					}

				}
			}, {
				xtype: 'tbbutton',
				icon: 'img/search.png',
				cls: 'x-btn-text-icon',
				text: 'GO',
				tooltip:'<?php __('<b>GO</b><br />Click here to get search results'); ?>',
				id: 'parent_pensionEmployee_go_button',
				handler: function(){
					SearchByParentPensionEmployeeName(Ext.getCmp('parent_pensionEmployee_search_field').getValue());
				}
			}, ' '
	]}),
	bbar: new Ext.PagingToolbar({
		pageSize: list_size,
		store: store_parent_pensionEmployees,
		displayInfo: true,
		displayMsg: '<?php __('Displaying {0} - {1} of {2}'); ?>',
		beforePageText: '<?php __('Page'); ?>',
		afterPageText: '<?php __('of {0}'); ?>',
		emptyMsg: '<?php __('No data to display'); ?>'
	})
});
g.getSelectionModel().on('rowselect', function(sm, rowIdx, r) {
	g.getTopToolbar().findById('edit-parent-pensionEmployee').enable();
	g.getTopToolbar().findById('delete-parent-pensionEmployee').enable();
        g.getTopToolbar().findById('view-pensionEmployee2').enable();
	if(this.getSelections().length > 1){
		g.getTopToolbar().findById('edit-parent-pensionEmployee').disable();
                g.getTopToolbar().findById('view-pensionEmployee2').disable();
	}
});
g.getSelectionModel().on('rowdeselect', function(sm, rowIdx, r) {
	if(this.getSelections().length > 1){
		g.getTopToolbar().findById('edit-parent-pensionEmployee').disable();
		g.getTopToolbar().findById('delete-parent-pensionEmployee').enable();
                g.getTopToolbar().findById('view-pensionEmployee2').disable();
	}
	else if(this.getSelections().length == 1){
		g.getTopToolbar().findById('edit-parent-pensionEmployee').enable();
		g.getTopToolbar().findById('delete-parent-pensionEmployee').enable();
                g.getTopToolbar().findById('view-pensionEmployee2').enable();
	}
	else{
		g.getTopToolbar().findById('edit-parent-pensionEmployee').disable();
		g.getTopToolbar().findById('delete-parent-pensionEmployee').disable();
                g.getTopToolbar().findById('view-pensionEmployee2').disable();
	}
});



var parentPensionEmployeesViewWindow = new Ext.Window({
	title: 'PensionEmployee Under the selected Item',
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
			parentPensionEmployeesViewWindow.close();
		}
	}]
});

store_parent_pensionEmployees.load({
    params: {
        start: 0,    
        limit: list_size
    }
});