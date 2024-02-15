var store_parent_employeePerformanceResults = new Ext.data.Store({
	reader: new Ext.data.JsonReader({
		root:'rows',
		totalProperty: 'results',
		fields: [
			'id','employee','employee_performance','performance_list','performance_list_choice'	
		]
	}),
	proxy: new Ext.data.HttpProxy({
		url: '<?php echo $this->Html->url(array('controller' => 'employeePerformanceResults', 'action' => 'list_data', $parent_id)); ?>'	})
});


function AddParentEmployeePerformanceResult() {
	Ext.Ajax.request({
		url: '<?php echo $this->Html->url(array('controller' => 'employeePerformanceResults', 'action' => 'add', $parent_id)); ?>',
		success: function(response, opts) {
			var parent_employeePerformanceResult_data = response.responseText;
			
			eval(parent_employeePerformanceResult_data);
			
			EmployeePerformanceResultAddWindow.show();
		},
		failure: function(response, opts) {
			Ext.Msg.alert('<?php __('Error'); ?>', '<?php __('Cannot get the employeePerformanceResult add form. Error code'); ?>: ' + response.status);
		}
	});
}

function EditParentEmployeePerformanceResult(id) {
	Ext.Ajax.request({
		url: '<?php echo $this->Html->url(array('controller' => 'employeePerformanceResults', 'action' => 'edit')); ?>/'+id+'/<?php echo $parent_id; ?>',
		success: function(response, opts) {
			var parent_employeePerformanceResult_data = response.responseText;
			
			eval(parent_employeePerformanceResult_data);
			
			EmployeePerformanceResultEditWindow.show();
		},
		failure: function(response, opts) {
			Ext.Msg.alert('<?php __('Error'); ?>', '<?php __('Cannot get the employeePerformanceResult edit form. Error code'); ?>: ' + response.status);
		}
	});
}

function ViewEmployeePerformanceResult(id) {
	Ext.Ajax.request({
		url: '<?php echo $this->Html->url(array('controller' => 'employeePerformanceResults', 'action' => 'view')); ?>/'+id,
		success: function(response, opts) {
			var employeePerformanceResult_data = response.responseText;

			eval(employeePerformanceResult_data);

			EmployeePerformanceResultViewWindow.show();
		},
		failure: function(response, opts) {
			Ext.Msg.alert('<?php __('Error'); ?>', '<?php __('Cannot get the employeePerformanceResult view form. Error code'); ?>: ' + response.status);
		}
	});
}


function DeleteParentEmployeePerformanceResult(id) {
	Ext.Ajax.request({
		url: '<?php echo $this->Html->url(array('controller' => 'employeePerformanceResults', 'action' => 'delete')); ?>/'+id,
		success: function(response, opts) {
			Ext.Msg.alert('<?php __('Success'); ?>', '<?php __('EmployeePerformanceResult(s) successfully deleted!'); ?>');
			RefreshParentEmployeePerformanceResultData();
		},
		failure: function(response, opts) {
			Ext.Msg.alert('<?php __('Error'); ?>', '<?php __('Cannot get the employeePerformanceResult to be deleted. Error code'); ?>: ' + response.status);
		}
	});
}

function SearchByParentEmployeePerformanceResultName(value){
	var conditions = '\'EmployeePerformanceResult.name LIKE\' => \'%' + value + '%\'';
	store_parent_employeePerformanceResults.reload({
		 params: {
			start: 0,
			limit: list_size,
			conditions: conditions
	    }
	});
}

function RefreshParentEmployeePerformanceResultData() {
	store_parent_employeePerformanceResults.reload();
}



var g = new Ext.grid.GridPanel({
	title: '<?php __('EmployeePerformanceResults'); ?>',
	store: store_parent_employeePerformanceResults,
	loadMask: true,
	stripeRows: true,
	height: 300,
	anchor: '100%',
    id: 'employeePerformanceResultGrid',
	columns: [
		{header:"<?php __('employee'); ?>", dataIndex: 'employee', sortable: true},
		{header:"<?php __('employee_performance'); ?>", dataIndex: 'employee_performance', sortable: true},
		{header:"<?php __('performance_list'); ?>", dataIndex: 'performance_list', sortable: true},
		{header:"<?php __('performance_list_choice'); ?>", dataIndex: 'performance_list_choice', sortable: true}	],
	sm: new Ext.grid.RowSelectionModel({
		singleSelect: false
	}),
	viewConfig: {
		forceFit: true
	},
    listeners: {
        celldblclick: function(){
            ViewEmployeePerformanceResult(Ext.getCmp('employeePerformanceResultGrid').getSelectionModel().getSelected().data.id);
        }
    },
	tbar: new Ext.Toolbar({
		items: [{
				xtype: 'tbbutton',
				text: '<?php __('Add'); ?>',
				tooltip:'<?php __('<b>Add EmployeePerformanceResult</b><br />Click here to create a new EmployeePerformanceResult'); ?>',
				icon: 'img/table_add.png',
				cls: 'x-btn-text-icon',
				handler: function(btn) {
					AddParentEmployeePerformanceResult();
				}
			}, ' ', '-', ' ', {
				xtype: 'tbbutton',
				text: '<?php __('Edit'); ?>',
				id: 'edit-parent-employeePerformanceResult',
				tooltip:'<?php __('<b>Edit EmployeePerformanceResult</b><br />Click here to modify the selected EmployeePerformanceResult'); ?>',
				icon: 'img/table_edit.png',
				cls: 'x-btn-text-icon',
				disabled: true,
				handler: function(btn) {
					var sm = g.getSelectionModel();
					var sel = sm.getSelected();
					if (sm.hasSelection()){
						EditParentEmployeePerformanceResult(sel.data.id);
					};
				}
			}, ' ', '-', ' ', {
				xtype: 'tbbutton',
				text: '<?php __('Delete'); ?>',
				id: 'delete-parent-employeePerformanceResult',
				tooltip:'<?php __('<b>Delete EmployeePerformanceResult(s)</b><br />Click here to remove the selected EmployeePerformanceResult(s)'); ?>',
				icon: 'img/table_delete.png',
				cls: 'x-btn-text-icon',
				disabled: true,
				handler: function(btn) {
					var sm = g.getSelectionModel();
					var sel = sm.getSelections();
					if (sm.hasSelection()){
						if(sel.length==1){
							Ext.Msg.show({
									title: '<?php __('Remove EmployeePerformanceResult'); ?>',
									buttons: Ext.MessageBox.YESNOCANCEL,
									msg: '<?php __('Remove'); ?> '+sel[0].data.name+'?',
									icon: Ext.MessageBox.QUESTION,
                                    fn: function(btn){
											if (btn == 'yes'){
													DeleteParentEmployeePerformanceResult(sel[0].data.id);
											}
									}
							});
						} else {
							Ext.Msg.show({
									title: '<?php __('Remove EmployeePerformanceResult'); ?>',
									buttons: Ext.MessageBox.YESNOCANCEL,
									msg: '<?php __('Remove the selected EmployeePerformanceResult'); ?>?',
									icon: Ext.MessageBox.QUESTION,
                                    fn: function(btn){
											if (btn == 'yes'){
													var sel_ids = '';
													for(i=0;i<sel.length;i++){
														if(i>0)
															sel_ids += '_';
														sel_ids += sel[i].data.id;
													}
													DeleteParentEmployeePerformanceResult(sel_ids);
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
				text: '<?php __('View EmployeePerformanceResult'); ?>',
				id: 'view-employeePerformanceResult2',
				tooltip:'<?php __('<b>View EmployeePerformanceResult</b><br />Click here to see details of the selected EmployeePerformanceResult'); ?>',
				icon: 'img/table_view.png',
				cls: 'x-btn-text-icon',
				disabled: true,
				handler: function(btn) {
					var sm = g.getSelectionModel();
					var sel = sm.getSelected();
					if (sm.hasSelection()){
						ViewEmployeePerformanceResult(sel.data.id);
					};
				},
				menu : {
					items: [
					]
				}

            }, ' ', '->', {
				xtype: 'textfield',
				emptyText: '<?php __('[Search By Name]'); ?>',
				id: 'parent_employeePerformanceResult_search_field',
				listeners: {
					specialkey: function(field, e){
						if (e.getKey() == e.ENTER) {
							SearchByParentEmployeePerformanceResultName(Ext.getCmp('parent_employeePerformanceResult_search_field').getValue());
						}
					}

				}
			}, {
				xtype: 'tbbutton',
				icon: 'img/search.png',
				cls: 'x-btn-text-icon',
				text: 'GO',
				tooltip:'<?php __('<b>GO</b><br />Click here to get search results'); ?>',
				id: 'parent_employeePerformanceResult_go_button',
				handler: function(){
					SearchByParentEmployeePerformanceResultName(Ext.getCmp('parent_employeePerformanceResult_search_field').getValue());
				}
			}, ' '
	]}),
	bbar: new Ext.PagingToolbar({
		pageSize: list_size,
		store: store_parent_employeePerformanceResults,
		displayInfo: true,
		displayMsg: '<?php __('Displaying {0} - {1} of {2}'); ?>',
		beforePageText: '<?php __('Page'); ?>',
		afterPageText: '<?php __('of {0}'); ?>',
		emptyMsg: '<?php __('No data to display'); ?>'
	})
});
g.getSelectionModel().on('rowselect', function(sm, rowIdx, r) {
	g.getTopToolbar().findById('edit-parent-employeePerformanceResult').enable();
	g.getTopToolbar().findById('delete-parent-employeePerformanceResult').enable();
        g.getTopToolbar().findById('view-employeePerformanceResult2').enable();
	if(this.getSelections().length > 1){
		g.getTopToolbar().findById('edit-parent-employeePerformanceResult').disable();
                g.getTopToolbar().findById('view-employeePerformanceResult2').disable();
	}
});
g.getSelectionModel().on('rowdeselect', function(sm, rowIdx, r) {
	if(this.getSelections().length > 1){
		g.getTopToolbar().findById('edit-parent-employeePerformanceResult').disable();
		g.getTopToolbar().findById('delete-parent-employeePerformanceResult').enable();
                g.getTopToolbar().findById('view-employeePerformanceResult2').disable();
	}
	else if(this.getSelections().length == 1){
		g.getTopToolbar().findById('edit-parent-employeePerformanceResult').enable();
		g.getTopToolbar().findById('delete-parent-employeePerformanceResult').enable();
                g.getTopToolbar().findById('view-employeePerformanceResult2').enable();
	}
	else{
		g.getTopToolbar().findById('edit-parent-employeePerformanceResult').disable();
		g.getTopToolbar().findById('delete-parent-employeePerformanceResult').disable();
                g.getTopToolbar().findById('view-employeePerformanceResult2').disable();
	}
});



var parentEmployeePerformanceResultsViewWindow = new Ext.Window({
	title: 'EmployeePerformanceResult Under the selected Item',
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
			parentEmployeePerformanceResultsViewWindow.close();
		}
	}]
});

store_parent_employeePerformanceResults.load({
    params: {
        start: 0,    
        limit: list_size
    }
});