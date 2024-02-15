
var store_payrollEmployees = new Ext.data.GroupingStore({
	reader: new Ext.data.JsonReader({
		root:'rows',
		totalProperty: 'results',
		fields: [
			'id','payroll','employee','status','date','remark'		]
	}),
	proxy: new Ext.data.HttpProxy({
		url: '<?php echo $this->Html->url(array('controller' => 'payrollEmployees', 'action' => 'list_data')); ?>'
	})
,	sortInfo:{field: 'payroll_id', direction: "ASC"},
	groupField: 'employee_id'
});


function AddPayrollEmployee() {
	Ext.Ajax.request({
		url: '<?php echo $this->Html->url(array('controller' => 'payrollEmployees', 'action' => 'add')); ?>',
		success: function(response, opts) {
			var payrollEmployee_data = response.responseText;
			
			eval(payrollEmployee_data);
			
			PayrollEmployeeAddWindow.show();
		},
		failure: function(response, opts) {
			Ext.Msg.alert('<?php __('Error'); ?>', '<?php __('Cannot get the payrollEmployee add form. Error code'); ?>: ' + response.status);
		}
	});
}

function EditPayrollEmployee(id) {
	Ext.Ajax.request({
		url: '<?php echo $this->Html->url(array('controller' => 'payrollEmployees', 'action' => 'edit')); ?>/'+id,
		success: function(response, opts) {
			var payrollEmployee_data = response.responseText;
			
			eval(payrollEmployee_data);
			
			PayrollEmployeeEditWindow.show();
		},
		failure: function(response, opts) {
			Ext.Msg.alert('<?php __('Error'); ?>', '<?php __('Cannot get the payrollEmployee edit form. Error code'); ?>: ' + response.status);
		}
	});
}

function ViewPayrollEmployee(id) {
    Ext.Ajax.request({
        url: '<?php echo $this->Html->url(array('controller' => 'payrollEmployees', 'action' => 'view')); ?>/'+id,
        success: function(response, opts) {
            var payrollEmployee_data = response.responseText;

            eval(payrollEmployee_data);

            PayrollEmployeeViewWindow.show();
        },
        failure: function(response, opts) {
            Ext.Msg.alert('<?php __('Error'); ?>', '<?php __('Cannot get the payrollEmployee view form. Error code'); ?>: ' + response.status);
        }
    });
}

function DeletePayrollEmployee(id) {
	Ext.Ajax.request({
		url: '<?php echo $this->Html->url(array('controller' => 'payrollEmployees', 'action' => 'delete')); ?>/'+id,
		success: function(response, opts) {
			Ext.Msg.alert('<?php __('Success'); ?>', '<?php __('PayrollEmployee successfully deleted!'); ?>');
			RefreshPayrollEmployeeData();
		},
		failure: function(response, opts) {
			Ext.Msg.alert('<?php __('Error'); ?>', '<?php __('Cannot get the payrollEmployee add form. Error code'); ?>: ' + response.status);
		}
	});
}

function SearchPayrollEmployee(){
	Ext.Ajax.request({
		url: '<?php echo $this->Html->url(array('controller' => 'payrollEmployees', 'action' => 'search')); ?>',
		success: function(response, opts){
			var payrollEmployee_data = response.responseText;

			eval(payrollEmployee_data);

			payrollEmployeeSearchWindow.show();
		},
		failure: function(response, opts) {
			Ext.Msg.alert('<?php __('Error'); ?>','<?php __('Cannot get the payrollEmployee search form. Error Code'); ?>: ' + response.status);
		}
	});
}

function SearchByPayrollEmployeeName(value){
	var conditions = '\'PayrollEmployee.name LIKE\' => \'%' + value + '%\'';
	store_payrollEmployees.reload({
		 params: {
			start: 0,
			limit: list_size,
			conditions: conditions
	    }
	});
}

function RefreshPayrollEmployeeData() {
	store_payrollEmployees.reload();
}


if(center_panel.find('id', 'payrollEmployee-tab') != "") {
	var p = center_panel.findById('payrollEmployee-tab');
	center_panel.setActiveTab(p);
} else {
	var p = center_panel.add({
		title: '<?php __('Payroll Employees'); ?>',
		closable: true,
		loadMask: true,
		stripeRows: true,
		id: 'payrollEmployee-tab',
		xtype: 'grid',
		store: store_payrollEmployees,
		columns: [
			{header: "<?php __('Payroll'); ?>", dataIndex: 'payroll', sortable: true},
			{header: "<?php __('Employee'); ?>", dataIndex: 'employee', sortable: true},
			{header: "<?php __('Status'); ?>", dataIndex: 'status', sortable: true},
			{header: "<?php __('Date'); ?>", dataIndex: 'date', sortable: true},
			{header: "<?php __('Remark'); ?>", dataIndex: 'remark', sortable: true}
		],
		
		view: new Ext.grid.GroupingView({
            forceFit:true,
            groupTextTpl: '{text} ({[values.rs.length]} {[values.rs.length > 1 ? "PayrollEmployees" : "PayrollEmployee"]})'
        })
,
		listeners: {
			celldblclick: function(){
				ViewPayrollEmployee(Ext.getCmp('payrollEmployee-tab').getSelectionModel().getSelected().data.id);
			}
		},
		sm: new Ext.grid.RowSelectionModel({
			singleSelect: false
		}),
		tbar: new Ext.Toolbar({
			
			items: [{
					xtype: 'tbbutton',
					text: '<?php __('Add'); ?>',
					tooltip:'<?php __('<b>Add PayrollEmployees</b><br />Click here to create a new PayrollEmployee'); ?>',
					icon: 'img/table_add.png',
					cls: 'x-btn-text-icon',
					handler: function(btn) {
						AddPayrollEmployee();
					}
				}, ' ', '-', ' ', {
					xtype: 'tbbutton',
					text: '<?php __('Edit'); ?>',
					id: 'edit-payrollEmployee',
					tooltip:'<?php __('<b>Edit PayrollEmployees</b><br />Click here to modify the selected PayrollEmployee'); ?>',
					icon: 'img/table_edit.png',
					cls: 'x-btn-text-icon',
					disabled: true,
					handler: function(btn) {
						var sm = p.getSelectionModel();
						var sel = sm.getSelected();
						if (sm.hasSelection()){
							EditPayrollEmployee(sel.data.id);
						};
					}
				}, ' ', '-', ' ', {
					xtype: 'tbbutton',
					text: '<?php __('Delete'); ?>',
					id: 'delete-payrollEmployee',
					tooltip:'<?php __('<b>Delete PayrollEmployees(s)</b><br />Click here to remove the selected PayrollEmployee(s)'); ?>',
					icon: 'img/table_delete.png',
					cls: 'x-btn-text-icon',
					disabled: true,
					handler: function(btn) {
						var sm = p.getSelectionModel();
						var sel = sm.getSelections();
						if (sm.hasSelection()){
							if(sel.length==1){
								Ext.Msg.show({
									title: '<?php __('Remove PayrollEmployee'); ?>',
									buttons: Ext.MessageBox.YESNO,
									msg: '<?php __('Remove'); ?> '+sel[0].data.name+'?',
									icon: Ext.MessageBox.QUESTION,
									fn: function(btn){
										if (btn == 'yes'){
											DeletePayrollEmployee(sel[0].data.id);
										}
									}
								});
							}else{
								Ext.Msg.show({
									title: '<?php __('Remove PayrollEmployee'); ?>',
									buttons: Ext.MessageBox.YESNO,
									msg: '<?php __('Remove the selected PayrollEmployees'); ?>?',
									icon: Ext.MessageBox.QUESTION,
									fn: function(btn){
										if (btn == 'yes'){
											var sel_ids = '';
											for(i=0;i<sel.length;i++){
												if(i>0)
													sel_ids += '_';
												sel_ids += sel[i].data.id;
											}
											DeletePayrollEmployee(sel_ids);
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
					text: '<?php __('View PayrollEmployee'); ?>',
					id: 'view-payrollEmployee',
					tooltip:'<?php __('<b>View PayrollEmployee</b><br />Click here to see details of the selected PayrollEmployee'); ?>',
					icon: 'img/table_view.png',
					cls: 'x-btn-text-icon',
					disabled: true,
					handler: function(btn) {
						var sm = p.getSelectionModel();
						var sel = sm.getSelected();
						if (sm.hasSelection()){
							ViewPayrollEmployee(sel.data.id);
						};
					},
					menu : {
						items: [
						]
					}
				}, ' ', '-',  '<?php __('Payroll'); ?>: ', {
					xtype : 'combo',
					emptyText: 'All',
					store : new Ext.data.ArrayStore({
						fields : ['id', 'name'],
						data : [
							['-1', 'All'],
							<?php $st = false;foreach ($payrolls as $item){if($st) echo ",
							";?>['<?php echo $item['Payroll']['id']; ?>' ,'<?php echo $item['Payroll']['name']; ?>']<?php $st = true;}?>						]
					}),
					displayField : 'name',
					valueField : 'id',
					mode : 'local',
					value : '-1',
					disableKeyFilter : true,
					triggerAction: 'all',
					listeners : {
						select : function(combo, record, index){
							store_payrollEmployees.reload({
								params: {
									start: 0,
									limit: list_size,
									payroll_id : combo.getValue()
								}
							});
						}
					}
				},
 '->', {
					xtype: 'textfield',
					emptyText: '<?php __('[Search By Name]'); ?>',
					id: 'payrollEmployee_search_field',
					listeners: {
						specialkey: function(field, e){
							if (e.getKey() == e.ENTER) {
								SearchByPayrollEmployeeName(Ext.getCmp('payrollEmployee_search_field').getValue());
							}
						}
					}
				}, {
					xtype: 'tbbutton',
					icon: 'img/search.png',
					cls: 'x-btn-text-icon',
					text: '<?php __('GO'); ?>',
                    tooltip:'<?php __('<b>GO</b><br />Click here to get search results'); ?>',
					id: 'payrollEmployee_go_button',
					handler: function(){
						SearchByPayrollEmployeeName(Ext.getCmp('payrollEmployee_search_field').getValue());
					}
				}, '-', {
					xtype: 'tbbutton',
					icon: 'img/table_search.png',
					cls: 'x-btn-text-icon',
					text: '<?php __('Advanced Search'); ?>',
                    tooltip:'<?php __('<b>Advanced Search...</b><br />Click here to get the advanced search form'); ?>',
					handler: function(){
						SearchPayrollEmployee();
					}
				}
		]}),
		bbar: new Ext.PagingToolbar({
			pageSize: list_size,
			store: store_payrollEmployees,
			displayInfo: true,
			displayMsg: '<?php __('Displaying {0} - {1} of {2}'); ?>',
			beforePageText: '<?php __('Page'); ?>',
			afterPageText: '<?php __('of {0}'); ?>',
			emptyMsg: '<?php __('No data to display'); ?>'
		})
	});
	p.getSelectionModel().on('rowselect', function(sm, rowIdx, r) {
		p.getTopToolbar().findById('edit-payrollEmployee').enable();
		p.getTopToolbar().findById('delete-payrollEmployee').enable();
		p.getTopToolbar().findById('view-payrollEmployee').enable();
		if(this.getSelections().length > 1){
			p.getTopToolbar().findById('edit-payrollEmployee').disable();
			p.getTopToolbar().findById('view-payrollEmployee').disable();
		}
	});
	p.getSelectionModel().on('rowdeselect', function(sm, rowIdx, r) {
		if(this.getSelections().length > 1){
			p.getTopToolbar().findById('edit-payrollEmployee').disable();
			p.getTopToolbar().findById('view-payrollEmployee').disable();
			p.getTopToolbar().findById('delete-payrollEmployee').enable();
		}
		else if(this.getSelections().length == 1){
			p.getTopToolbar().findById('edit-payrollEmployee').enable();
			p.getTopToolbar().findById('view-payrollEmployee').enable();
			p.getTopToolbar().findById('delete-payrollEmployee').enable();
		}
		else{
			p.getTopToolbar().findById('edit-payrollEmployee').disable();
			p.getTopToolbar().findById('view-payrollEmployee').disable();
			p.getTopToolbar().findById('delete-payrollEmployee').disable();
		}
	});
	center_panel.setActiveTab(p);
	
	store_payrollEmployees.load({
		params: {
			start: 0,          
			limit: list_size
		}
	});
	
}
