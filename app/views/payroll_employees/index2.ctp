var store_parent_payrollEmployees = new Ext.data.Store({
	reader: new Ext.data.JsonReader({
		root:'rows',
		totalProperty: 'results',
		fields: [
			'id','payroll','account_no','pf_account_no','employee','status','date','remark'	
		]
	}),
	proxy: new Ext.data.HttpProxy({
		url: '<?php echo $this->Html->url(array('controller' => 'payrollEmployees', 'action' => 'list_data', $parent_id)); ?>'	})
});


function AddParentPayrollEmployee() {
	Ext.Ajax.request({
		url: '<?php echo $this->Html->url(array('controller' => 'payrollEmployees', 'action' => 'add', $parent_id)); ?>',
		success: function(response, opts) {
			var parent_payrollEmployee_data = response.responseText;
			
			eval(parent_payrollEmployee_data);
			
			PayrollEmployeeAddWindow.show();
		},
		failure: function(response, opts) {
			Ext.Msg.alert('<?php __('Error'); ?>', '<?php __('Cannot get the payrollEmployee add form. Error code'); ?>: ' + response.status);
		}
	});
}

function EditParentPayrollEmployee(id) {
	Ext.Ajax.request({
		url: '<?php echo $this->Html->url(array('controller' => 'payrollEmployees', 'action' => 'edit')); ?>/'+id+'/<?php echo $parent_id; ?>',
		success: function(response, opts) {
			var parent_payrollEmployee_data = response.responseText;
			
			eval(parent_payrollEmployee_data);
			
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


function DeleteParentPayrollEmployee(id) {
	Ext.Ajax.request({
		url: '<?php echo $this->Html->url(array('controller' => 'payrollEmployees', 'action' => 'delete')); ?>/'+id,
		success: function(response, opts) {
			Ext.Msg.alert('<?php __('Success'); ?>', '<?php __('PayrollEmployee(s) successfully deleted!'); ?>');
			RefreshParentPayrollEmployeeData();
		},
		failure: function(response, opts) {
			Ext.Msg.alert('<?php __('Error'); ?>', '<?php __('Cannot get the payrollEmployee to be deleted. Error code'); ?>: ' + response.status);
		}
	});
}

function SearchByParentPayrollEmployeeName(value){
	var conditions = '\'PayrollEmployee.name LIKE\' => \'%' + value + '%\'';
	store_parent_payrollEmployees.reload({
		 params: {
			start: 0,
			limit: list_size,
			conditions: conditions
	    }
	});
}

function RefreshParentPayrollEmployeeData() {
	store_parent_payrollEmployees.reload();
}



var g = new Ext.grid.GridPanel({
	title: '<?php __('PayrollEmployees'); ?>',
	store: store_parent_payrollEmployees,
	loadMask: true,
	stripeRows: true,
	height: 300,
	anchor: '100%',
    id: 'payrollEmployeeGrid',
	columns: [
		{header:"<?php __('payroll'); ?>", dataIndex: 'payroll', sortable: true},
                {header:"<?php __('Account No'); ?>", dataIndex: 'account_no', sortable: true},
                {header:"<?php __('PF Account No'); ?>", dataIndex: 'pf_account_no', sortable: true},
		{header: "<?php __('Status'); ?>", dataIndex: 'status', sortable: true},
		{header: "<?php __('Date'); ?>", dataIndex: 'date', sortable: true},
		{header: "<?php __('Remark'); ?>", dataIndex: 'remark', sortable: true}	],
	sm: new Ext.grid.RowSelectionModel({
		singleSelect: false
	}),
	viewConfig: {
		forceFit: true
	},
    listeners: {
        celldblclick: function(){
            ViewPayrollEmployee(Ext.getCmp('payrollEmployeeGrid').getSelectionModel().getSelected().data.id);
        }
    },
	tbar: new Ext.Toolbar({
		items: [{
				xtype: 'tbbutton',
				text: '<?php __('Add'); ?>',
				tooltip:'<?php __('<b>Add PayrollEmployee</b><br />Click here to create a new PayrollEmployee'); ?>',
				icon: 'img/table_add.png',
				cls: 'x-btn-text-icon',
				handler: function(btn) {
					AddParentPayrollEmployee();
				}
			}, ' ', '-', ' ', {
				xtype: 'tbbutton',
				text: '<?php __('Edit'); ?>',
				id: 'edit-parent-payrollEmployee',
				tooltip:'<?php __('<b>Deactivate Payroll</b><br />Click here to modify the selected PayrollEmployee'); ?>',
				icon: 'img/table_edit.png',
				cls: 'x-btn-text-icon',
				disabled: true,
				handler: function(btn) {
					var sm = g.getSelectionModel();
					var sel = sm.getSelected();
					if (sm.hasSelection()){
						EditParentPayrollEmployee(sel.data.id);
					};
				}
			}
	]}),
	bbar: new Ext.PagingToolbar({
		pageSize: list_size,
		store: store_parent_payrollEmployees,
		displayInfo: true,
		displayMsg: '<?php __('Displaying {0} - {1} of {2}'); ?>',
		beforePageText: '<?php __('Page'); ?>',
		afterPageText: '<?php __('of {0}'); ?>',
		emptyMsg: '<?php __('No data to display'); ?>'
	})
});
g.getSelectionModel().on('rowselect', function(sm, rowIdx, r) {
	g.getTopToolbar().findById('edit-parent-payrollEmployee').enable();
	g.getTopToolbar().findById('delete-parent-payrollEmployee').enable();
        g.getTopToolbar().findById('view-payrollEmployee2').enable();
	if(this.getSelections().length > 1){
		g.getTopToolbar().findById('edit-parent-payrollEmployee').disable();
                g.getTopToolbar().findById('view-payrollEmployee2').disable();
	}
});
g.getSelectionModel().on('rowdeselect', function(sm, rowIdx, r) {
	if(this.getSelections().length > 1){
		g.getTopToolbar().findById('edit-parent-payrollEmployee').disable();
		g.getTopToolbar().findById('delete-parent-payrollEmployee').enable();
                g.getTopToolbar().findById('view-payrollEmployee2').disable();
	}
	else if(this.getSelections().length == 1){
		g.getTopToolbar().findById('edit-parent-payrollEmployee').enable();
		g.getTopToolbar().findById('delete-parent-payrollEmployee').enable();
                g.getTopToolbar().findById('view-payrollEmployee2').enable();
	}
	else{
		g.getTopToolbar().findById('edit-parent-payrollEmployee').disable();
		g.getTopToolbar().findById('delete-parent-payrollEmployee').disable();
                g.getTopToolbar().findById('view-payrollEmployee2').disable();
	}
});



var parentPayrollEmployeesViewWindow = new Ext.Window({
	title: 'PayrollEmployee Under the selected Item',
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
			parentPayrollEmployeesViewWindow.close();
		}
	}]
});

store_parent_payrollEmployees.load({
    params: {
        start: 0,    
        limit: list_size
    }
});