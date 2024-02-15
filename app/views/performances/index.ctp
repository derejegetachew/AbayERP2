
var store_performances = new Ext.data.GroupingStore({
	reader: new Ext.data.JsonReader({
		root:'rows',
		totalProperty: 'results',
		fields: [
			'id','name','status'		]
	}),
	proxy: new Ext.data.HttpProxy({
		url: '<?php echo $this->Html->url(array('controller' => 'performances', 'action' => 'list_data')); ?>'
	})
,	sortInfo:{field: 'name', direction: "ASC"},
	groupField: 'status'
});


function AddPerformance() {
	Ext.Ajax.request({
		url: '<?php echo $this->Html->url(array('controller' => 'performances', 'action' => 'add')); ?>',
		success: function(response, opts) {
			var performance_data = response.responseText;
			
			eval(performance_data);
			
			PerformanceAddWindow.show();
		},
		failure: function(response, opts) {
			Ext.Msg.alert('<?php __('Error'); ?>', '<?php __('Cannot get the performance add form. Error code'); ?>: ' + response.status);
		}
	});
}

function EditPerformance(id) {
	Ext.Ajax.request({
		url: '<?php echo $this->Html->url(array('controller' => 'performances', 'action' => 'edit')); ?>/'+id,
		success: function(response, opts) {
			var performance_data = response.responseText;
			
			eval(performance_data);
			
			PerformanceEditWindow.show();
		},
		failure: function(response, opts) {
			Ext.Msg.alert('<?php __('Error'); ?>', '<?php __('Cannot get the performance edit form. Error code'); ?>: ' + response.status);
		}
	});
}

function ViewPerformance(id) {
    Ext.Ajax.request({
        url: '<?php echo $this->Html->url(array('controller' => 'performances', 'action' => 'view')); ?>/'+id,
        success: function(response, opts) {
            var performance_data = response.responseText;

            eval(performance_data);

            PerformanceViewWindow.show();
        },
        failure: function(response, opts) {
            Ext.Msg.alert('<?php __('Error'); ?>', '<?php __('Cannot get the performance view form. Error code'); ?>: ' + response.status);
        }
    });
}
function ViewParentEmployeePerformanceResults(id) {
    Ext.Ajax.request({
        url: '<?php echo $this->Html->url(array('controller' => 'employeePerformanceResults', 'action' => 'index2')); ?>/'+id,
        success: function(response, opts) {
            var parent_employeePerformanceResults_data = response.responseText;

            eval(parent_employeePerformanceResults_data);

            parentEmployeePerformanceResultsViewWindow.show();
        },
        failure: function(response, opts) {
            Ext.Msg.alert('<?php __('Error'); ?>', '<?php __('Cannot get the campus view form. Error code'); ?>: ' + response.status);
        }
    });
}

function ViewParentPerformanceLists(id) {
    Ext.Ajax.request({
        url: '<?php echo $this->Html->url(array('controller' => 'performanceLists', 'action' => 'index2')); ?>/'+id,
        success: function(response, opts) {
            var parent_performanceLists_data = response.responseText;

            eval(parent_performanceLists_data);

            parentPerformanceListsViewWindow.show();
        },
        failure: function(response, opts) {
            Ext.Msg.alert('<?php __('Error'); ?>', '<?php __('Cannot get the campus view form. Error code'); ?>: ' + response.status);
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


function DeletePerformance(id) {
	Ext.Ajax.request({
		url: '<?php echo $this->Html->url(array('controller' => 'performances', 'action' => 'delete')); ?>/'+id,
		success: function(response, opts) {
			Ext.Msg.alert('<?php __('Success'); ?>', '<?php __('Performance successfully deleted!'); ?>');
			RefreshPerformanceData();
		},
		failure: function(response, opts) {
			Ext.Msg.alert('<?php __('Error'); ?>', '<?php __('Cannot get the performance add form. Error code'); ?>: ' + response.status);
		}
	});
}

function SearchPerformance(){
	Ext.Ajax.request({
		url: '<?php echo $this->Html->url(array('controller' => 'performances', 'action' => 'search')); ?>',
		success: function(response, opts){
			var performance_data = response.responseText;

			eval(performance_data);

			performanceSearchWindow.show();
		},
		failure: function(response, opts) {
			Ext.Msg.alert('<?php __('Error'); ?>','<?php __('Cannot get the performance search form. Error Code'); ?>: ' + response.status);
		}
	});
}

function SearchByPerformanceName(value){
	var conditions = '\'Performance.name LIKE\' => \'%' + value + '%\'';
	store_performances.reload({
		 params: {
			start: 0,
			limit: list_size,
			conditions: conditions
	    }
	});
}

function RefreshPerformanceData() {
	store_performances.reload();
}


if(center_panel.find('id', 'performance-tab') != "") {
	var p = center_panel.findById('performance-tab');
	center_panel.setActiveTab(p);
} else {
	var p = center_panel.add({
		title: '<?php __('Performances'); ?>',
		closable: true,
		loadMask: true,
		stripeRows: true,
		id: 'performance-tab',
		xtype: 'grid',
		store: store_performances,
		columns: [
			{header: "<?php __('Name'); ?>", dataIndex: 'name', sortable: true},
			{header: "<?php __('Status'); ?>", dataIndex: 'status', sortable: true}
		],
		
		view: new Ext.grid.GroupingView({
            forceFit:true,
            groupTextTpl: '{text} ({[values.rs.length]} {[values.rs.length > 1 ? "Performances" : "Performance"]})'
        })
,
		listeners: {
			celldblclick: function(){
				ViewParentPerformanceLists(Ext.getCmp('performance-tab').getSelectionModel().getSelected().data.id);
			}
		},
		sm: new Ext.grid.RowSelectionModel({
			singleSelect: false
		}),
		tbar: new Ext.Toolbar({
			
			items: [{
					xtype: 'tbbutton',
					text: '<?php __('Add'); ?>',
					tooltip:'<?php __('<b>Add Performances</b><br />Click here to create a new Performance'); ?>',
					icon: 'img/table_add.png',
					cls: 'x-btn-text-icon',
					handler: function(btn) {
						AddPerformance();
					}
				}, ' ', '-', ' ', {
					xtype: 'tbbutton',
					text: '<?php __('Edit'); ?>',
					id: 'edit-performance',
					tooltip:'<?php __('<b>Edit Performances</b><br />Click here to modify the selected Performance'); ?>',
					icon: 'img/table_edit.png',
					cls: 'x-btn-text-icon',
					disabled: true,
					handler: function(btn) {
						var sm = p.getSelectionModel();
						var sel = sm.getSelected();
						if (sm.hasSelection()){
							EditPerformance(sel.data.id);
						};
					}
				}, ' ', '-', ' ', {
					xtype: 'tbbutton',
					text: '<?php __('View Performance Lists'); ?>',
					id: 'view-performance',
					tooltip:'<?php __('<b>View/Edit Performance Lists</b><br />Click here to see details of the selected Performance'); ?>',
					icon: 'img/table_view.png',
					cls: 'x-btn-text-icon',
					disabled: true,
					handler: function(btn) {
								var sm = p.getSelectionModel();
								var sel = sm.getSelected();
								if (sm.hasSelection()){
									ViewParentPerformanceLists(sel.data.id);
								};
                                                                }
					
				}, ' ', '-',  '->', {
					xtype: 'textfield',
					emptyText: '<?php __('[Search By Name]'); ?>',
					id: 'performance_search_field',
					listeners: {
						specialkey: function(field, e){
							if (e.getKey() == e.ENTER) {
								SearchByPerformanceName(Ext.getCmp('performance_search_field').getValue());
							}
						}
					}
				}, {
					xtype: 'tbbutton',
					icon: 'img/search.png',
					cls: 'x-btn-text-icon',
					text: '<?php __('GO'); ?>',
                    tooltip:'<?php __('<b>GO</b><br />Click here to get search results'); ?>',
					id: 'performance_go_button',
					handler: function(){
						SearchByPerformanceName(Ext.getCmp('performance_search_field').getValue());
					}
				}, '-', {
					xtype: 'tbbutton',
					icon: 'img/table_search.png',
					cls: 'x-btn-text-icon',
					text: '<?php __('Advanced Search'); ?>',
                    tooltip:'<?php __('<b>Advanced Search...</b><br />Click here to get the advanced search form'); ?>',
					handler: function(){
						SearchPerformance();
					}
				}
		]}),
		bbar: new Ext.PagingToolbar({
			pageSize: list_size,
			store: store_performances,
			displayInfo: true,
			displayMsg: '<?php __('Displaying {0} - {1} of {2}'); ?>',
			beforePageText: '<?php __('Page'); ?>',
			afterPageText: '<?php __('of {0}'); ?>',
			emptyMsg: '<?php __('No data to display'); ?>'
		})
	});
	p.getSelectionModel().on('rowselect', function(sm, rowIdx, r) {
		p.getTopToolbar().findById('edit-performance').enable();
		//p.getTopToolbar().findById('delete-performance').enable();
		p.getTopToolbar().findById('view-performance').enable();
		if(this.getSelections().length > 1){
			p.getTopToolbar().findById('edit-performance').disable();
			p.getTopToolbar().findById('view-performance').disable();
		}
	});
	p.getSelectionModel().on('rowdeselect', function(sm, rowIdx, r) {
		if(this.getSelections().length > 1){
			p.getTopToolbar().findById('edit-performance').disable();
			p.getTopToolbar().findById('view-performance').disable();
			//p.getTopToolbar().findById('delete-performance').enable();
		}
		else if(this.getSelections().length == 1){
			p.getTopToolbar().findById('edit-performance').enable();
			p.getTopToolbar().findById('view-performance').enable();
			//p.getTopToolbar().findById('delete-performance').enable();
		}
		else{
			p.getTopToolbar().findById('edit-performance').disable();
			p.getTopToolbar().findById('view-performance').disable();
			//p.getTopToolbar().findById('delete-performance').disable();
		}
	});
	center_panel.setActiveTab(p);
	
	store_performances.load({
		params: {
			start: 0,          
			limit: list_size
		}
	});
	
}
