
var store_employeePerformanceResults = new Ext.data.GroupingStore({
	reader: new Ext.data.JsonReader({
		root:'rows',
		totalProperty: 'results',
		fields: [
			'id','employee','employee_performance','performance_list','performance_list_choice'		]
	}),
	proxy: new Ext.data.HttpProxy({
		url: '<?php echo $this->Html->url(array('controller' => 'employeePerformanceResults', 'action' => 'list_data')); ?>'
	})
,	sortInfo:{field: 'employee_id', direction: "ASC"},
	groupField: 'employee_performance_id'
});


function AddEmployeePerformanceResult() {
	Ext.Ajax.request({
		url: '<?php echo $this->Html->url(array('controller' => 'employeePerformanceResults', 'action' => 'add')); ?>',
		success: function(response, opts) {
			var employeePerformanceResult_data = response.responseText;
			
			eval(employeePerformanceResult_data);
			
			EmployeePerformanceResultAddWindow.show();
		},
		failure: function(response, opts) {
			Ext.Msg.alert('<?php __('Error'); ?>', '<?php __('Cannot get the employeePerformanceResult add form. Error code'); ?>: ' + response.status);
		}
	});
}

function EditEmployeePerformanceResult(id) {
	Ext.Ajax.request({
		url: '<?php echo $this->Html->url(array('controller' => 'employeePerformanceResults', 'action' => 'edit')); ?>/'+id,
		success: function(response, opts) {
			var employeePerformanceResult_data = response.responseText;
			
			eval(employeePerformanceResult_data);
			
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

function DeleteEmployeePerformanceResult(id) {
	Ext.Ajax.request({
		url: '<?php echo $this->Html->url(array('controller' => 'employeePerformanceResults', 'action' => 'delete')); ?>/'+id,
		success: function(response, opts) {
			Ext.Msg.alert('<?php __('Success'); ?>', '<?php __('EmployeePerformanceResult successfully deleted!'); ?>');
			RefreshEmployeePerformanceResultData();
		},
		failure: function(response, opts) {
			Ext.Msg.alert('<?php __('Error'); ?>', '<?php __('Cannot get the employeePerformanceResult add form. Error code'); ?>: ' + response.status);
		}
	});
}

function SearchEmployeePerformanceResult(){
	Ext.Ajax.request({
		url: '<?php echo $this->Html->url(array('controller' => 'employeePerformanceResults', 'action' => 'search')); ?>',
		success: function(response, opts){
			var employeePerformanceResult_data = response.responseText;

			eval(employeePerformanceResult_data);

			employeePerformanceResultSearchWindow.show();
		},
		failure: function(response, opts) {
			Ext.Msg.alert('<?php __('Error'); ?>','<?php __('Cannot get the employeePerformanceResult search form. Error Code'); ?>: ' + response.status);
		}
	});
}

function SearchByEmployeePerformanceResultName(value){
	var conditions = '\'EmployeePerformanceResult.name LIKE\' => \'%' + value + '%\'';
	store_employeePerformanceResults.reload({
		 params: {
			start: 0,
			limit: list_size,
			conditions: conditions
	    }
	});
}

function RefreshEmployeePerformanceResultData() {
	store_employeePerformanceResults.reload();
}


if(center_panel.find('id', 'employeePerformanceResult-tab') != "") {
	var p = center_panel.findById('employeePerformanceResult-tab');
	center_panel.setActiveTab(p);
} else {
	var p = center_panel.add({
		title: '<?php __('Employee Performance Results'); ?>',
		closable: true,
		loadMask: true,
		stripeRows: true,
		id: 'employeePerformanceResult-tab',
		xtype: 'grid',
		store: store_employeePerformanceResults,
		columns: [
			{header: "<?php __('Employee'); ?>", dataIndex: 'employee', sortable: true},
			{header: "<?php __('EmployeePerformance'); ?>", dataIndex: 'employee_performance', sortable: true},
			{header: "<?php __('PerformanceList'); ?>", dataIndex: 'performance_list', sortable: true},
			{header: "<?php __('PerformanceListChoice'); ?>", dataIndex: 'performance_list_choice', sortable: true}
		],
		
		view: new Ext.grid.GroupingView({
            forceFit:true,
            groupTextTpl: '{text} ({[values.rs.length]} {[values.rs.length > 1 ? "EmployeePerformanceResults" : "EmployeePerformanceResult"]})'
        })
,
		listeners: {
			celldblclick: function(){
				ViewEmployeePerformanceResult(Ext.getCmp('employeePerformanceResult-tab').getSelectionModel().getSelected().data.id);
			}
		},
		sm: new Ext.grid.RowSelectionModel({
			singleSelect: false
		}),
		tbar: new Ext.Toolbar({
			
			items: [{
					xtype: 'tbbutton',
					text: '<?php __('Add'); ?>',
					tooltip:'<?php __('<b>Add EmployeePerformanceResults</b><br />Click here to create a new EmployeePerformanceResult'); ?>',
					icon: 'img/table_add.png',
					cls: 'x-btn-text-icon',
					handler: function(btn) {
						AddEmployeePerformanceResult();
					}
				}, ' ', '-', ' ', {
					xtype: 'tbbutton',
					text: '<?php __('Edit'); ?>',
					id: 'edit-employeePerformanceResult',
					tooltip:'<?php __('<b>Edit EmployeePerformanceResults</b><br />Click here to modify the selected EmployeePerformanceResult'); ?>',
					icon: 'img/table_edit.png',
					cls: 'x-btn-text-icon',
					disabled: true,
					handler: function(btn) {
						var sm = p.getSelectionModel();
						var sel = sm.getSelected();
						if (sm.hasSelection()){
							EditEmployeePerformanceResult(sel.data.id);
						};
					}
				}, ' ', '-', ' ', {
					xtype: 'tbbutton',
					text: '<?php __('Delete'); ?>',
					id: 'delete-employeePerformanceResult',
					tooltip:'<?php __('<b>Delete EmployeePerformanceResults(s)</b><br />Click here to remove the selected EmployeePerformanceResult(s)'); ?>',
					icon: 'img/table_delete.png',
					cls: 'x-btn-text-icon',
					disabled: true,
					handler: function(btn) {
						var sm = p.getSelectionModel();
						var sel = sm.getSelections();
						if (sm.hasSelection()){
							if(sel.length==1){
								Ext.Msg.show({
									title: '<?php __('Remove EmployeePerformanceResult'); ?>',
									buttons: Ext.MessageBox.YESNO,
									msg: '<?php __('Remove'); ?> '+sel[0].data.name+'?',
									icon: Ext.MessageBox.QUESTION,
									fn: function(btn){
										if (btn == 'yes'){
											DeleteEmployeePerformanceResult(sel[0].data.id);
										}
									}
								});
							}else{
								Ext.Msg.show({
									title: '<?php __('Remove EmployeePerformanceResult'); ?>',
									buttons: Ext.MessageBox.YESNO,
									msg: '<?php __('Remove the selected EmployeePerformanceResults'); ?>?',
									icon: Ext.MessageBox.QUESTION,
									fn: function(btn){
										if (btn == 'yes'){
											var sel_ids = '';
											for(i=0;i<sel.length;i++){
												if(i>0)
													sel_ids += '_';
												sel_ids += sel[i].data.id;
											}
											DeleteEmployeePerformanceResult(sel_ids);
										}
									}
								});
							}
						} else {
							Ext.Msg.alert('<?php __('Warning'); ?>', '<?php __('Please select a record first'); ?>');
						};
					}
				}, ' ', '-', ' ', {
					xtype: 'tbsplit',
					text: '<?php __('View EmployeePerformanceResult'); ?>',
					id: 'view-employeePerformanceResult',
					tooltip:'<?php __('<b>View EmployeePerformanceResult</b><br />Click here to see details of the selected EmployeePerformanceResult'); ?>',
					icon: 'img/table_view.png',
					cls: 'x-btn-text-icon',
					disabled: true,
					handler: function(btn) {
						var sm = p.getSelectionModel();
						var sel = sm.getSelected();
						if (sm.hasSelection()){
							ViewEmployeePerformanceResult(sel.data.id);
						};
					},
					menu : {
						items: [
						]
					}
				}, ' ', '-',  '<?php __('Employee'); ?>: ', {
					xtype : 'combo',
					emptyText: 'All',
					store : new Ext.data.ArrayStore({
						fields : ['id', 'name'],
						data : [
							['-1', 'All'],
							<?php $st = false;foreach ($employees as $item){if($st) echo ",
							";?>['<?php echo $item['Employee']['id']; ?>' ,'<?php echo $item['Employee']['name']; ?>']<?php $st = true;}?>						]
					}),
					displayField : 'name',
					valueField : 'id',
					mode : 'local',
					value : '-1',
					disableKeyFilter : true,
					triggerAction: 'all',
					listeners : {
						select : function(combo, record, index){
							store_employeePerformanceResults.reload({
								params: {
									start: 0,
									limit: list_size,
									employee_id : combo.getValue()
								}
							});
						}
					}
				},
 '->', {
					xtype: 'textfield',
					emptyText: '<?php __('[Search By Name]'); ?>',
					id: 'employeePerformanceResult_search_field',
					listeners: {
						specialkey: function(field, e){
							if (e.getKey() == e.ENTER) {
								SearchByEmployeePerformanceResultName(Ext.getCmp('employeePerformanceResult_search_field').getValue());
							}
						}
					}
				}, {
					xtype: 'tbbutton',
					icon: 'img/search.png',
					cls: 'x-btn-text-icon',
					text: '<?php __('GO'); ?>',
                    tooltip:'<?php __('<b>GO</b><br />Click here to get search results'); ?>',
					id: 'employeePerformanceResult_go_button',
					handler: function(){
						SearchByEmployeePerformanceResultName(Ext.getCmp('employeePerformanceResult_search_field').getValue());
					}
				}, '-', {
					xtype: 'tbbutton',
					icon: 'img/table_search.png',
					cls: 'x-btn-text-icon',
					text: '<?php __('Advanced Search'); ?>',
                    tooltip:'<?php __('<b>Advanced Search...</b><br />Click here to get the advanced search form'); ?>',
					handler: function(){
						SearchEmployeePerformanceResult();
					}
				}
		]}),
		bbar: new Ext.PagingToolbar({
			pageSize: list_size,
			store: store_employeePerformanceResults,
			displayInfo: true,
			displayMsg: '<?php __('Displaying {0} - {1} of {2}'); ?>',
			beforePageText: '<?php __('Page'); ?>',
			afterPageText: '<?php __('of {0}'); ?>',
			emptyMsg: '<?php __('No data to display'); ?>'
		})
	});
	p.getSelectionModel().on('rowselect', function(sm, rowIdx, r) {
		p.getTopToolbar().findById('edit-employeePerformanceResult').enable();
		p.getTopToolbar().findById('delete-employeePerformanceResult').enable();
		p.getTopToolbar().findById('view-employeePerformanceResult').enable();
		if(this.getSelections().length > 1){
			p.getTopToolbar().findById('edit-employeePerformanceResult').disable();
			p.getTopToolbar().findById('view-employeePerformanceResult').disable();
		}
	});
	p.getSelectionModel().on('rowdeselect', function(sm, rowIdx, r) {
		if(this.getSelections().length > 1){
			p.getTopToolbar().findById('edit-employeePerformanceResult').disable();
			p.getTopToolbar().findById('view-employeePerformanceResult').disable();
			p.getTopToolbar().findById('delete-employeePerformanceResult').enable();
		}
		else if(this.getSelections().length == 1){
			p.getTopToolbar().findById('edit-employeePerformanceResult').enable();
			p.getTopToolbar().findById('view-employeePerformanceResult').enable();
			p.getTopToolbar().findById('delete-employeePerformanceResult').enable();
		}
		else{
			p.getTopToolbar().findById('edit-employeePerformanceResult').disable();
			p.getTopToolbar().findById('view-employeePerformanceResult').disable();
			p.getTopToolbar().findById('delete-employeePerformanceResult').disable();
		}
	});
	center_panel.setActiveTab(p);
	
	store_employeePerformanceResults.load({
		params: {
			start: 0,          
			limit: list_size
		}
	});
	
}
