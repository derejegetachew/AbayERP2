
var store_performanceResults = new Ext.data.GroupingStore({
	reader: new Ext.data.JsonReader({
		root:'rows',
		totalProperty: 'results',
		fields: [
			'id','employee','budget_year','first','second','average','created','modified'		]
	}),
	proxy: new Ext.data.HttpProxy({
		url: '<?php echo $this->Html->url(array('controller' => 'performanceResults', 'action' => 'list_data')); ?>'
	})
,	sortInfo:{field: 'employee_id', direction: "ASC"},
	groupField: 'budget_year_id'
});


function AddPerformanceResult() {
	Ext.Ajax.request({
		url: '<?php echo $this->Html->url(array('controller' => 'performanceResults', 'action' => 'add')); ?>',
		success: function(response, opts) {
			var performanceResult_data = response.responseText;
			
			eval(performanceResult_data);
			
			PerformanceResultAddWindow.show();
		},
		failure: function(response, opts) {
			Ext.Msg.alert('<?php __('Error'); ?>', '<?php __('Cannot get the performanceResult add form. Error code'); ?>: ' + response.status);
		}
	});
}

function EditPerformanceResult(id) {
	Ext.Ajax.request({
		url: '<?php echo $this->Html->url(array('controller' => 'performanceResults', 'action' => 'edit')); ?>/'+id,
		success: function(response, opts) {
			var performanceResult_data = response.responseText;
			
			eval(performanceResult_data);
			
			PerformanceResultEditWindow.show();
		},
		failure: function(response, opts) {
			Ext.Msg.alert('<?php __('Error'); ?>', '<?php __('Cannot get the performanceResult edit form. Error code'); ?>: ' + response.status);
		}
	});
}

function ViewPerformanceResult(id) {
    Ext.Ajax.request({
        url: '<?php echo $this->Html->url(array('controller' => 'performanceResults', 'action' => 'view')); ?>/'+id,
        success: function(response, opts) {
            var performanceResult_data = response.responseText;

            eval(performanceResult_data);

            PerformanceResultViewWindow.show();
        },
        failure: function(response, opts) {
            Ext.Msg.alert('<?php __('Error'); ?>', '<?php __('Cannot get the performanceResult view form. Error code'); ?>: ' + response.status);
        }
    });
}
function ViewParentEmployees(id) {
    Ext.Ajax.request({
        url: '<?php echo $this->Html->url(array('controller' => 'employees', 'action' => 'index2')); ?>/'+id,
        success: function(response, opts) {
            var parent_employees_data = response.responseText;

            eval(parent_employees_data);

            parentEmployeesViewWindow.show();
        },
        failure: function(response, opts) {
            Ext.Msg.alert('<?php __('Error'); ?>', '<?php __('Cannot get the campus view form. Error code'); ?>: ' + response.status);
        }
    });
}


function DeletePerformanceResult(id) {
	Ext.Ajax.request({
		url: '<?php echo $this->Html->url(array('controller' => 'performanceResults', 'action' => 'delete')); ?>/'+id,
		success: function(response, opts) {
			Ext.Msg.alert('<?php __('Success'); ?>', '<?php __('PerformanceResult successfully deleted!'); ?>');
			RefreshPerformanceResultData();
		},
		failure: function(response, opts) {
			Ext.Msg.alert('<?php __('Error'); ?>', '<?php __('Cannot get the performanceResult add form. Error code'); ?>: ' + response.status);
		}
	});
}

function SearchPerformanceResult(){
	Ext.Ajax.request({
		url: '<?php echo $this->Html->url(array('controller' => 'performanceResults', 'action' => 'search')); ?>',
		success: function(response, opts){
			var performanceResult_data = response.responseText;

			eval(performanceResult_data);

			performanceResultSearchWindow.show();
		},
		failure: function(response, opts) {
			Ext.Msg.alert('<?php __('Error'); ?>','<?php __('Cannot get the performanceResult search form. Error Code'); ?>: ' + response.status);
		}
	});
}

function SearchByPerformanceResultName(value){
	var conditions = '\'PerformanceResult.name LIKE\' => \'%' + value + '%\'';
	store_performanceResults.reload({
		 params: {
			start: 0,
			limit: list_size,
			conditions: conditions
	    }
	});
}

function RefreshPerformanceResultData() {
	store_performanceResults.reload();
}


if(center_panel.find('id', 'performanceResult-tab') != "") {
	var p = center_panel.findById('performanceResult-tab');
	center_panel.setActiveTab(p);
} else {
	var p = center_panel.add({
		title: '<?php __('Performance Results'); ?>',
		closable: true,
		loadMask: true,
		stripeRows: true,
		id: 'performanceResult-tab',
		xtype: 'grid',
		store: store_performanceResults,
		columns: [
			{header: "<?php __('Employee'); ?>", dataIndex: 'employee', sortable: true},
			{header: "<?php __('BudgetYear'); ?>", dataIndex: 'budget_year', sortable: true},
			{header: "<?php __('First'); ?>", dataIndex: 'first', sortable: true},
			{header: "<?php __('Second'); ?>", dataIndex: 'second', sortable: true},
			{header: "<?php __('Average'); ?>", dataIndex: 'average', sortable: true},
			{header: "<?php __('Created'); ?>", dataIndex: 'created', sortable: true},
			{header: "<?php __('Modified'); ?>", dataIndex: 'modified', sortable: true}
		],
		
		view: new Ext.grid.GroupingView({
            forceFit:true,
            groupTextTpl: '{text} ({[values.rs.length]} {[values.rs.length > 1 ? "PerformanceResults" : "PerformanceResult"]})'
        })
,
		listeners: {
			celldblclick: function(){
				ViewPerformanceResult(Ext.getCmp('performanceResult-tab').getSelectionModel().getSelected().data.id);
			}
		},
		sm: new Ext.grid.RowSelectionModel({
			singleSelect: false
		}),
		tbar: new Ext.Toolbar({
			
			items: [{
					xtype: 'tbbutton',
					text: '<?php __('Add'); ?>',
					tooltip:'<?php __('<b>Add PerformanceResults</b><br />Click here to create a new PerformanceResult'); ?>',
					icon: 'img/table_add.png',
					cls: 'x-btn-text-icon',
					handler: function(btn) {
						AddPerformanceResult();
					}
				}, ' ', '-', ' ', {
					xtype: 'tbbutton',
					text: '<?php __('Edit'); ?>',
					id: 'edit-performanceResult',
					tooltip:'<?php __('<b>Edit PerformanceResults</b><br />Click here to modify the selected PerformanceResult'); ?>',
					icon: 'img/table_edit.png',
					cls: 'x-btn-text-icon',
					disabled: true,
					handler: function(btn) {
						var sm = p.getSelectionModel();
						var sel = sm.getSelected();
						if (sm.hasSelection()){
							EditPerformanceResult(sel.data.id);
						};
					}
				}, ' ', '-', ' ', {
					xtype: 'tbbutton',
					text: '<?php __('Delete'); ?>',
					id: 'delete-performanceResult',
					tooltip:'<?php __('<b>Delete PerformanceResults(s)</b><br />Click here to remove the selected PerformanceResult(s)'); ?>',
					icon: 'img/table_delete.png',
					cls: 'x-btn-text-icon',
					disabled: true,
					handler: function(btn) {
						var sm = p.getSelectionModel();
						var sel = sm.getSelections();
						if (sm.hasSelection()){
							if(sel.length==1){
								Ext.Msg.show({
									title: '<?php __('Remove PerformanceResult'); ?>',
									buttons: Ext.MessageBox.YESNO,
									msg: '<?php __('Remove'); ?> '+sel[0].data.name+'?',
									icon: Ext.MessageBox.QUESTION,
									fn: function(btn){
										if (btn == 'yes'){
											DeletePerformanceResult(sel[0].data.id);
										}
									}
								});
							}else{
								Ext.Msg.show({
									title: '<?php __('Remove PerformanceResult'); ?>',
									buttons: Ext.MessageBox.YESNO,
									msg: '<?php __('Remove the selected PerformanceResults'); ?>?',
									icon: Ext.MessageBox.QUESTION,
									fn: function(btn){
										if (btn == 'yes'){
											var sel_ids = '';
											for(i=0;i<sel.length;i++){
												if(i>0)
													sel_ids += '_';
												sel_ids += sel[i].data.id;
											}
											DeletePerformanceResult(sel_ids);
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
					text: '<?php __('View PerformanceResult'); ?>',
					id: 'view-performanceResult',
					tooltip:'<?php __('<b>View PerformanceResult</b><br />Click here to see details of the selected PerformanceResult'); ?>',
					icon: 'img/table_view.png',
					cls: 'x-btn-text-icon',
					disabled: true,
					handler: function(btn) {
						var sm = p.getSelectionModel();
						var sel = sm.getSelected();
						if (sm.hasSelection()){
							ViewPerformanceResult(sel.data.id);
						};
					},
					menu : {
						items: [
{
							text: '<?php __('View Employees'); ?>',
                            icon: 'img/table_view.png',
							cls: 'x-btn-text-icon',
							handler: function(btn) {
								var sm = p.getSelectionModel();
								var sel = sm.getSelected();
								if (sm.hasSelection()){
									ViewParentEmployees(sel.data.id);
								};
							}
						}
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
							store_performanceResults.reload({
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
					id: 'performanceResult_search_field',
					listeners: {
						specialkey: function(field, e){
							if (e.getKey() == e.ENTER) {
								SearchByPerformanceResultName(Ext.getCmp('performanceResult_search_field').getValue());
							}
						}
					}
				}, {
					xtype: 'tbbutton',
					icon: 'img/search.png',
					cls: 'x-btn-text-icon',
					text: '<?php __('GO'); ?>',
                    tooltip:'<?php __('<b>GO</b><br />Click here to get search results'); ?>',
					id: 'performanceResult_go_button',
					handler: function(){
						SearchByPerformanceResultName(Ext.getCmp('performanceResult_search_field').getValue());
					}
				}, '-', {
					xtype: 'tbbutton',
					icon: 'img/table_search.png',
					cls: 'x-btn-text-icon',
					text: '<?php __('Advanced Search'); ?>',
                    tooltip:'<?php __('<b>Advanced Search...</b><br />Click here to get the advanced search form'); ?>',
					handler: function(){
						SearchPerformanceResult();
					}
				}
		]}),
		bbar: new Ext.PagingToolbar({
			pageSize: list_size,
			store: store_performanceResults,
			displayInfo: true,
			displayMsg: '<?php __('Displaying {0} - {1} of {2}'); ?>',
			beforePageText: '<?php __('Page'); ?>',
			afterPageText: '<?php __('of {0}'); ?>',
			emptyMsg: '<?php __('No data to display'); ?>'
		})
	});
	p.getSelectionModel().on('rowselect', function(sm, rowIdx, r) {
		p.getTopToolbar().findById('edit-performanceResult').enable();
		p.getTopToolbar().findById('delete-performanceResult').enable();
		p.getTopToolbar().findById('view-performanceResult').enable();
		if(this.getSelections().length > 1){
			p.getTopToolbar().findById('edit-performanceResult').disable();
			p.getTopToolbar().findById('view-performanceResult').disable();
		}
	});
	p.getSelectionModel().on('rowdeselect', function(sm, rowIdx, r) {
		if(this.getSelections().length > 1){
			p.getTopToolbar().findById('edit-performanceResult').disable();
			p.getTopToolbar().findById('view-performanceResult').disable();
			p.getTopToolbar().findById('delete-performanceResult').enable();
		}
		else if(this.getSelections().length == 1){
			p.getTopToolbar().findById('edit-performanceResult').enable();
			p.getTopToolbar().findById('view-performanceResult').enable();
			p.getTopToolbar().findById('delete-performanceResult').enable();
		}
		else{
			p.getTopToolbar().findById('edit-performanceResult').disable();
			p.getTopToolbar().findById('view-performanceResult').disable();
			p.getTopToolbar().findById('delete-performanceResult').disable();
		}
	});
	center_panel.setActiveTab(p);
	
	store_performanceResults.load({
		params: {
			start: 0,          
			limit: list_size
		}
	});
	
}
