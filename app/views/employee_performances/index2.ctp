var store_parent_employeePerformances = new Ext.data.Store({
	reader: new Ext.data.JsonReader({
		root:'rows',
		totalProperty: 'results',
		fields: [
			'id','employee','performance','status','created','performance_id'	
		]
	}),
	proxy: new Ext.data.HttpProxy({
		url: '<?php echo $this->Html->url(array('controller' => 'employeePerformances', 'action' => 'list_data', $parent_id)); ?>'	})
});


function AddParentEmployeePerformance() {
	Ext.Ajax.request({
		url: '<?php echo $this->Html->url(array('controller' => 'employeePerformances', 'action' => 'add', $parent_id)); ?>',
		success: function(response, opts) {
			var parent_employeePerformance_data = response.responseText;
			
			eval(parent_employeePerformance_data);
			
			EmployeePerformanceAddWindow.show();
		},
		failure: function(response, opts) {
			Ext.Msg.alert('<?php __('Error'); ?>', '<?php __('Cannot get the employeePerformance add form. Error code'); ?>: ' + response.status);
		}
	});
}

function EditParentEmployeePerformance(id) {
	Ext.Ajax.request({
		url: '<?php echo $this->Html->url(array('controller' => 'employeePerformances', 'action' => 'edit')); ?>/'+id+'/<?php echo $parent_id; ?>',
		success: function(response, opts) {
			var parent_employeePerformance_data = response.responseText;
			
			eval(parent_employeePerformance_data);
			
			EmployeePerformanceEditWindow.show();
		},
		failure: function(response, opts) {
			Ext.Msg.alert('<?php __('Error'); ?>', '<?php __('Cannot get the employeePerformance edit form. Error code'); ?>: ' + response.status);
		}
	});
}

function ViewEmployeePerformance(id) {
	Ext.Ajax.request({
		url: '<?php echo $this->Html->url(array('controller' => 'employeePerformances', 'action' => 'grade')); ?>/'+id,
		success: function(response, opts) {
                if(response.responseText=="graded"){
                    Ext.Ajax.request({
                    url: '<?php echo $this->Html->url(array('controller' => 'employeePerformances', 'action' => 'result')); ?>/'+id,
                    success: function(response, opts) {
                        var employeePerformance_data = response.responseText;

			eval(employeePerformance_data);

			EmployeePerformanceResultWindow.show();
                    },
                    failure: function(response, opts) {
                            Ext.Msg.alert('<?php __('Error'); ?>', '<?php __('Cannot get the employeePerformance view form. Error code'); ?>: ' + response.status);
                    }
                    });
                }else{
			var employeePerformance_data = response.responseText;

			eval(employeePerformance_data);

			EmployeePerformanceGradeWindow.show();
                     }
            },
            failure: function(response, opts) {
                    Ext.Msg.alert('<?php __('Error'); ?>', '<?php __('Cannot get the employeePerformance view form. Error code'); ?>: ' + response.status);
            }
	});
}


function DeleteParentEmployeePerformance(id) {
	Ext.Ajax.request({
		url: '<?php echo $this->Html->url(array('controller' => 'employeePerformances', 'action' => 'delete')); ?>/'+id,
		success: function(response, opts) {
			Ext.Msg.alert('<?php __('Success'); ?>', '<?php __('EmployeePerformance(s) successfully deleted!'); ?>');
			RefreshParentEmployeePerformanceData();
		},
		failure: function(response, opts) {
			Ext.Msg.alert('<?php __('Error'); ?>', '<?php __('Cannot get the employeePerformance to be deleted. Error code'); ?>: ' + response.status);
		}
	});
}

function SearchByParentEmployeePerformanceName(value){
	var conditions = '\'EmployeePerformance.name LIKE\' => \'%' + value + '%\'';
	store_parent_employeePerformances.reload({
		 params: {
			start: 0,
			limit: list_size,
			conditions: conditions
	    }
	});
}

function RefreshParentEmployeePerformanceData() {
	store_parent_employeePerformances.reload();
}



var g = new Ext.grid.GridPanel({
	title: '<?php __('EmployeePerformances'); ?>',
	store: store_parent_employeePerformances,
	loadMask: true,
	stripeRows: true,
	height: 300,
	anchor: '100%',
        id: 'employeePerformanceGrid',
	columns: [
		{header:"<?php __('performance'); ?>", dataIndex: 'performance', sortable: true},
		{header: "<?php __('Status'); ?>", dataIndex: 'status', sortable: true},
		{header: "<?php __('Created'); ?>", dataIndex: 'created', sortable: true}	],
	sm: new Ext.grid.RowSelectionModel({
		singleSelect: false
	}),
	viewConfig: {
		forceFit: true
	},
    listeners: {
        celldblclick: function(){
            ViewEmployeePerformance(Ext.getCmp('employeePerformanceGrid').getSelectionModel().getSelected().id);
        }
    },
	tbar: new Ext.Toolbar({
		items: [{
				xtype: 'tbbutton',
				text: '<?php __('Add'); ?>',
				tooltip:'<?php __('<b>Add EmployeePerformance</b><br />Click here to create a new EmployeePerformance'); ?>',
				icon: 'img/table_add.png',
				cls: 'x-btn-text-icon',
				handler: function(btn) {
					AddParentEmployeePerformance();
				}
			},  ' ', '-', ' ', {
				xtype: 'tbbutton',
				text: '<?php __('Delete'); ?>',
				id: 'delete-parent-employeePerformance',
				tooltip:'<?php __('<b>Delete EmployeePerformance(s)</b><br />Click here to remove the selected EmployeePerformance(s)'); ?>',
				icon: 'img/table_delete.png',
				cls: 'x-btn-text-icon',
				disabled: true,
				handler: function(btn) {
					var sm = g.getSelectionModel();
					var sel = sm.getSelections();
					if (sm.hasSelection()){
						if(sel.length==1){
							Ext.Msg.show({
									title: '<?php __('Remove EmployeePerformance'); ?>',
									buttons: Ext.MessageBox.YESNOCANCEL,
									msg: '<?php __('Remove'); ?> '+sel[0].data.name+'?',
									icon: Ext.MessageBox.QUESTION,
                                    fn: function(btn){
											if (btn == 'yes'){
													DeleteParentEmployeePerformance(sel[0].data.id);
											}
									}
							});
						} else {
							Ext.Msg.show({
									title: '<?php __('Remove EmployeePerformance'); ?>',
									buttons: Ext.MessageBox.YESNOCANCEL,
									msg: '<?php __('Remove the selected EmployeePerformance'); ?>?',
									icon: Ext.MessageBox.QUESTION,
                                    fn: function(btn){
											if (btn == 'yes'){
													var sel_ids = '';
													for(i=0;i<sel.length;i++){
														if(i>0)
															sel_ids += '_';
														sel_ids += sel[i].data.id;
													}
													DeleteParentEmployeePerformance(sel_ids);
											}
									}
							});
						}
					} else {
						Ext.Msg.alert('<?php __('Warning'); ?>', '<?php __('Please select a record first'); ?>');
					};
				}
			}, ' ', ' ', '->', {
				xtype: 'textfield',
				emptyText: '<?php __('[Search By Name]'); ?>',
				id: 'parent_employeePerformance_search_field',
				listeners: {
					specialkey: function(field, e){
						if (e.getKey() == e.ENTER) {
							SearchByParentEmployeePerformanceName(Ext.getCmp('parent_employeePerformance_search_field').getValue());
						}
					}

				}
			}, {
				xtype: 'tbbutton',
				icon: 'img/search.png',
				cls: 'x-btn-text-icon',
				text: 'GO',
				tooltip:'<?php __('<b>GO</b><br />Click here to get search results'); ?>',
				id: 'parent_employeePerformance_go_button',
				handler: function(){
					SearchByParentEmployeePerformanceName(Ext.getCmp('parent_employeePerformance_search_field').getValue());
				}
			}, ' '
	]}),
	bbar: new Ext.PagingToolbar({
		pageSize: list_size,
		store: store_parent_employeePerformances,
		displayInfo: true,
		displayMsg: '<?php __('Displaying {0} - {1} of {2}'); ?>',
		beforePageText: '<?php __('Page'); ?>',
		afterPageText: '<?php __('of {0}'); ?>',
		emptyMsg: '<?php __('No data to display'); ?>'
	})
});
g.getSelectionModel().on('rowselect', function(sm, rowIdx, r) {
	//g.getTopToolbar().findById('edit-parent-employeePerformance').enable();
	g.getTopToolbar().findById('delete-parent-employeePerformance').enable();
        g.getTopToolbar().findById('view-employeePerformance2').enable();
	if(this.getSelections().length > 1){
		g.getTopToolbar().findById('edit-parent-employeePerformance').disable();
                g.getTopToolbar().findById('view-employeePerformance2').disable();
	}
});
g.getSelectionModel().on('rowdeselect', function(sm, rowIdx, r) {
	if(this.getSelections().length > 1){
		//g.getTopToolbar().findById('edit-parent-employeePerformance').disable();
		g.getTopToolbar().findById('delete-parent-employeePerformance').enable();
                g.getTopToolbar().findById('view-employeePerformance2').disable();
	}
	else if(this.getSelections().length == 1){
		//g.getTopToolbar().findById('edit-parent-employeePerformance').enable();
		g.getTopToolbar().findById('delete-parent-employeePerformance').enable();
                g.getTopToolbar().findById('view-employeePerformance2').enable();
	}
	else{
		//g.getTopToolbar().findById('edit-parent-employeePerformance').disable();
		g.getTopToolbar().findById('delete-parent-employeePerformance').disable();
                g.getTopToolbar().findById('view-employeePerformance2').disable();
	}
});



var parentEmployeePerformancesViewWindow = new Ext.Window({
	title: 'EmployeePerformance Under the selected Item',
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
			parentEmployeePerformancesViewWindow.close();
		}
	}]
});

store_parent_employeePerformances.load({
    params: {
        start: 0,    
        limit: list_size
    }
});