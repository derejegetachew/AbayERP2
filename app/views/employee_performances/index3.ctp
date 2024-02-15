
var store_employeePerformances = new Ext.data.GroupingStore({
	reader: new Ext.data.JsonReader({
		root:'rows',
		totalProperty: 'results',
		fields: [
			'id','employee','performance','status','created'		]
	}),
	proxy: new Ext.data.HttpProxy({
		url: '<?php echo $this->Html->url(array('controller' => 'employeePerformances', 'action' => 'list_data3')); ?>'
	})
,	sortInfo:{field: 'created', direction: "DSC"}
});


function AddEmployeePerformance() {
	Ext.Ajax.request({
		url: '<?php echo $this->Html->url(array('controller' => 'employeePerformances', 'action' => 'add')); ?>',
		success: function(response, opts) {
			var employeePerformance_data = response.responseText;
			
			eval(employeePerformance_data);
			
			EmployeePerformanceAddWindow.show();
		},
		failure: function(response, opts) {
			Ext.Msg.alert('<?php __('Error'); ?>', '<?php __('Cannot get the employeePerformance add form. Error code'); ?>: ' + response.status);
		}
	});
}

function EditEmployeePerformance(id) {
	Ext.Ajax.request({
		url: '<?php echo $this->Html->url(array('controller' => 'employeePerformances', 'action' => 'edit')); ?>/'+id,
		success: function(response, opts) {
			var employeePerformance_data = response.responseText;
			
			eval(employeePerformance_data);
			
			EmployeePerformanceEditWindow.show();
		},
		failure: function(response, opts) {
			Ext.Msg.alert('<?php __('Error'); ?>', '<?php __('Cannot get the employeePerformance edit form. Error code'); ?>: ' + response.status);
		}
	});
}

function ViewEmployeePerformance(id) {
    Ext.Ajax.request({
        url: '<?php echo $this->Html->url(array('controller' => 'employeePerformances', 'action' => 'view')); ?>/'+id,
        success: function(response, opts) {
            var employeePerformance_data = response.responseText;

            eval(employeePerformance_data);

            EmployeePerformanceViewWindow.show();
        },
        failure: function(response, opts) {
            Ext.Msg.alert('<?php __('Error'); ?>', '<?php __('Cannot get the employeePerformance view form. Error code'); ?>: ' + response.status);
        }
    });
}

function ViewEmployeePerformanceResult(id) {
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
}

function DeleteEmployeePerformance(id) {
	Ext.Ajax.request({
		url: '<?php echo $this->Html->url(array('controller' => 'employeePerformances', 'action' => 'delete')); ?>/'+id,
		success: function(response, opts) {
			Ext.Msg.alert('<?php __('Success'); ?>', '<?php __('EmployeePerformance successfully deleted!'); ?>');
			RefreshEmployeePerformanceData();
		},
		failure: function(response, opts) {
			Ext.Msg.alert('<?php __('Error'); ?>', '<?php __('Cannot get the employeePerformance add form. Error code'); ?>: ' + response.status);
		}
	});
}

function AcceptEmployeePerformance(id) {
	Ext.Ajax.request({
		url: '<?php echo $this->Html->url(array('controller' => 'employeePerformances', 'action' => 'accept')); ?>/'+id,
		success: function(response, opts) {
			Ext.Msg.alert('<?php __('Success'); ?>', '<?php __('EmployeePerformance successfully Accepted!'); ?>');
			RefreshEmployeePerformanceData();
		},
		failure: function(response, opts) {
			Ext.Msg.alert('<?php __('Error'); ?>', '<?php __('Cannot get the employeePerformance add form. Error code'); ?>: ' + response.status);
		}
	});
}

function OpposeEmployeePerformance(id) {
	Ext.Ajax.request({
		url: '<?php echo $this->Html->url(array('controller' => 'employeePerformances', 'action' => 'oppose')); ?>/'+id,
		success: function(response, opts) {
			Ext.Msg.alert('<?php __('Success'); ?>', '<?php __('EmployeePerformance successfully Rejected!'); ?>');
			RefreshEmployeePerformanceData();
		},
		failure: function(response, opts) {
			Ext.Msg.alert('<?php __('Error'); ?>', '<?php __('Cannot get the employeePerformance add form. Error code'); ?>: ' + response.status);
		}
	});
}

function SearchEmployeePerformance(){
	Ext.Ajax.request({
		url: '<?php echo $this->Html->url(array('controller' => 'employeePerformances', 'action' => 'search')); ?>',
		success: function(response, opts){
			var employeePerformance_data = response.responseText;

			eval(employeePerformance_data);

			employeePerformanceSearchWindow.show();
		},
		failure: function(response, opts) {
			Ext.Msg.alert('<?php __('Error'); ?>','<?php __('Cannot get the employeePerformance search form. Error Code'); ?>: ' + response.status);
		}
	});
}

function SearchByEmployeePerformanceName(value){
	var conditions = '\'EmployeePerformance.name LIKE\' => \'%' + value + '%\'';
	store_employeePerformances.reload({
		 params: {
			start: 0,
			limit: list_size,
			conditions: conditions
	    }
	});
}

function RefreshEmployeePerformanceData() {
	store_employeePerformances.reload();
}


if(center_panel.find('id', 'employeePerformance-tab') != "") {
	var p = center_panel.findById('employeePerformance-tab');
	center_panel.setActiveTab(p);
} else {
	var p = center_panel.add({
		title: '<?php __('Performance Reports'); ?>',
		closable: true,
		loadMask: true,
		stripeRows: true,
		id: 'employeePerformance-tab',
		xtype: 'grid',
		store: store_employeePerformances,
		columns: [
			{header: "<?php __('Performance'); ?>", dataIndex: 'performance', sortable: true},
			{header: "<?php __('Status'); ?>", dataIndex: 'status', sortable: true},
			{header: "<?php __('Created'); ?>", dataIndex: 'created', sortable: true}
		],
		
		view: new Ext.grid.GroupingView({
            forceFit:true,
            groupTextTpl: '{text} ({[values.rs.length]} {[values.rs.length > 1 ? "EmployeePerformances" : "EmployeePerformance"]})'
        })
,
		listeners: {
			celldblclick: function(){
				ViewEmployeePerformanceResult(Ext.getCmp('employeePerformance-tab').getSelectionModel().getSelected().data.id);
			}
		},
		sm: new Ext.grid.RowSelectionModel({
			singleSelect: false
		}),
		tbar: new Ext.Toolbar({
			
			items: [{
					xtype: 'tbbutton',
					text: '<?php __('Accept'); ?>',
                                        id: 'add-employeePerformance',
					tooltip:'<?php __('<b>Accept Report</b>'); ?>',
					icon: 'img/table_add.png',
					cls: 'x-btn-text-icon',
                                        disabled: true,
					handler: function(btn) {
						var sm = p.getSelectionModel();
						var sel = sm.getSelected();
						if (sm.hasSelection()){
							AcceptEmployeePerformance(sel.data.id);
						};
					}
				}, ' ', '-', ' ', {
					xtype: 'tbbutton',
					text: '<?php __('Oppose'); ?>',
					id: 'edit-employeePerformance',
					tooltip:'<?php __('<b>Oppose Report</b>'); ?>',
					icon: 'img/table_edit.png',
					cls: 'x-btn-text-icon',
					disabled: true,
					handler: function(btn) {
						var sm = p.getSelectionModel();
						var sel = sm.getSelected();
						if (sm.hasSelection()){
							OpposeEmployeePerformance(sel.data.id);
						};
					}
				}
		]}),
		bbar: new Ext.PagingToolbar({
			pageSize: list_size,
			store: store_employeePerformances,
			displayInfo: true,
			displayMsg: '<?php __('Displaying {0} - {1} of {2}'); ?>',
			beforePageText: '<?php __('Page'); ?>',
			afterPageText: '<?php __('of {0}'); ?>',
			emptyMsg: '<?php __('No data to display'); ?>'
		})
	});
	p.getSelectionModel().on('rowselect', function(sm, rowIdx, r) {
		p.getTopToolbar().findById('edit-employeePerformance').enable();
		p.getTopToolbar().findById('add-employeePerformance').enable();
		p.getTopToolbar().findById('view-employeePerformance').enable();
		if(this.getSelections().length > 1){
			p.getTopToolbar().findById('edit-employeePerformance').disable();
			p.getTopToolbar().findById('view-employeePerformance').disable();
		}
	});
	p.getSelectionModel().on('rowdeselect', function(sm, rowIdx, r) {
		if(this.getSelections().length > 1){
			p.getTopToolbar().findById('edit-employeePerformance').disable();
			p.getTopToolbar().findById('view-employeePerformance').disable();
			p.getTopToolbar().findById('add-employeePerformance').enable();
		}
		else if(this.getSelections().length == 1){
			p.getTopToolbar().findById('edit-employeePerformance').enable();
			p.getTopToolbar().findById('view-employeePerformance').enable();
			p.getTopToolbar().findById('add-employeePerformance').enable();
		}
		else{
			p.getTopToolbar().findById('edit-employeePerformance').disable();
			p.getTopToolbar().findById('view-employeePerformance').disable();
			p.getTopToolbar().findById('add-employeePerformance').disable();
		}
	});
	center_panel.setActiveTab(p);
	
	store_employeePerformances.load({
		params: {
			start: 0,          
			limit: list_size
		}
	});
	
}
