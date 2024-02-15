
 
var store_payrollReports2 = new Ext.data.GroupingStore({
	reader: new Ext.data.JsonReader({
		root:'rows',
		totalProperty: 'results',
		fields: [
			'id','name','basic_salary','non_taxable_benefits','taxable_benefits','gross_pay','income_tax','deductions','loan_repayements','total_pf','total_pension','net_pay'		]
	}),
	proxy: new Ext.data.HttpProxy({
		url: '<?php echo $this->Html->url(array('controller' => 'payrollReports', 'action' => 'list_data2')); ?>/<?php echo $parent_id?>',
	})
,	sortInfo:{field: 'name', direction: "ASC"}
});


function AddPayrollReport() {
	Ext.Ajax.request({
		url: '<?php echo $this->Html->url(array('controller' => 'payrollReports', 'action' => 'add')); ?>',
		success: function(response, opts) {
			var payrollReport_data = response.responseText;
			
			eval(payrollReport_data);
			
			PayrollReportAddWindow.show();
		},
		failure: function(response, opts) {
			Ext.Msg.alert('<?php __('Error'); ?>', '<?php __('Cannot get the payrollReport add form. Error code'); ?>: ' + response.status);
		}
	});
}

function EditPayrollReport(id) {
	Ext.Ajax.request({
		url: '<?php echo $this->Html->url(array('controller' => 'payrollReports', 'action' => 'edit')); ?>/'+id,
		success: function(response, opts) {
			var payrollReport_data = response.responseText;
			
			eval(payrollReport_data);
			
			PayrollReportEditWindow.show();
		},
		failure: function(response, opts) {
			Ext.Msg.alert('<?php __('Error'); ?>', '<?php __('Cannot get the payrollReport edit form. Error code'); ?>: ' + response.status);
		}
	});
}

function ViewPayrollReport(id) {
    Ext.Ajax.request({
        url: '<?php echo $this->Html->url(array('controller' => 'payrollReports', 'action' => 'view')); ?>/'+id,
        success: function(response, opts) {
            var payrollReport_data = response.responseText;

            eval(payrollReport_data);

            PayrollReportViewWindow.show();
        },
        failure: function(response, opts) {
            Ext.Msg.alert('<?php __('Error'); ?>', '<?php __('Cannot get the payrollReport view form. Error code'); ?>: ' + response.status);
        }
    });
}

function DeletePayrollReport(id) {
	Ext.Ajax.request({
		url: '<?php echo $this->Html->url(array('controller' => 'payrollReports', 'action' => 'delete')); ?>/'+id,
		success: function(response, opts) {
			Ext.Msg.alert('<?php __('Success'); ?>', '<?php __('PayrollReport successfully deleted!'); ?>');
			RefreshPayrollReportData();
		},
		failure: function(response, opts) {
			Ext.Msg.alert('<?php __('Error'); ?>', '<?php __('Cannot get the payrollReport add form. Error code'); ?>: ' + response.status);
		}
	});
}

function SearchPayrollReport(){
	Ext.Ajax.request({
		url: '<?php echo $this->Html->url(array('controller' => 'payrollReports', 'action' => 'search')); ?>',
		success: function(response, opts){
			var payrollReport_data = response.responseText;

			eval(payrollReport_data);

			payrollReportSearchWindow.show();
		},
		failure: function(response, opts) {
			Ext.Msg.alert('<?php __('Error'); ?>','<?php __('Cannot get the payrollReport search form. Error Code'); ?>: ' + response.status);
		}
	});
}

function SearchByPayrollReportName(value){
	var conditions = '\'PayrollReport.name LIKE\' => \'%' + value + '%\'';
	store_payrollReports2.reload({
		 params: {
			start: 0,
			limit: list_size,
			conditions: conditions
	    }
	});
}

function RefreshPayrollReportData() {
	store_payrollReports2.reload();
}


if(center_panel.find('id', 'payrollReport-tab2') != "") {
	var p = center_panel.findById('payrollReport-tab2');
	center_panel.setActiveTab(p);
} else {
	var p = center_panel.add({
		title: '<?php __('Payroll Table'); ?>',
		closable: true,
		loadMask: true,
		stripeRows: true,
		id: 'payrollReport-tab2',
		xtype: 'grid',
		store: store_payrollReports2,
		columns: [
               
			{header: "<?php __('Name'); ?>", dataIndex: 'name', sortable: true},
			{header: "<?php __('Basic Salary'); ?>", dataIndex: 'basic_salary', sortable: true},
			{header: "<?php __('Non Taxable Benefits'); ?>", dataIndex: 'non_taxable_benefits', sortable: true},
                        {header: "<?php __('Taxable Benefits'); ?>", dataIndex: 'taxable_benefits', sortable: true},
                        {header: "<?php __('Gross Pay'); ?>", dataIndex: 'gross_pay', sortable: true},
                        {header: "<?php __('Income Tax'); ?>", dataIndex: 'income_tax', sortable: true},
                        {header: "<?php __('Deductions'); ?>", dataIndex: 'deductions', sortable: true},
                        {header: "<?php __('Loan Repayments'); ?>", dataIndex: 'loan_repayements', sortable: true},
                        {header: "<?php __('Total PF'); ?>", dataIndex: 'total_pf', sortable: true},
                        {header: "<?php __('Total Pension'); ?>", dataIndex: 'total_pension', sortable: true},
                        {header: "<?php __('Net Pay'); ?>", dataIndex: 'net_pay', sortable: true}
                        
		],
		
		view: new Ext.grid.GroupingView({
            forceFit:true,
            groupTextTpl: '{text} ({[values.rs.length]} {[values.rs.length > 1 ? "PayrollReports" : "PayrollReport"]})'
        })
,
		listeners: {
			celldblclick: function(){
				ViewPayrollReport(Ext.getCmp('payrollReport-tab').getSelectionModel().getSelected().data.id);
			}
		},
		sm: new Ext.grid.RowSelectionModel({
			singleSelect: false
		}),
		bbar: new Ext.PagingToolbar({
			pageSize: list_size,
			store: store_payrollReports2,
			displayInfo: true,
			displayMsg: '<?php __('Displaying {0} - {1} of {2}'); ?>',
			beforePageText: '<?php __('Page'); ?>',
			afterPageText: '<?php __('of {0}'); ?>',
			emptyMsg: '<?php __('No data to display'); ?>'
		})
	});
	p.getSelectionModel().on('rowselect', function(sm, rowIdx, r) {
		p.getTopToolbar().findById('edit-payrollReport').enable();
		p.getTopToolbar().findById('delete-payrollReport').enable();
		p.getTopToolbar().findById('view-payrollReport').enable();
		if(this.getSelections().length > 1){
			p.getTopToolbar().findById('edit-payrollReport').disable();
			p.getTopToolbar().findById('view-payrollReport').disable();
		}
	});
	p.getSelectionModel().on('rowdeselect', function(sm, rowIdx, r) {
		if(this.getSelections().length > 1){
			p.getTopToolbar().findById('edit-payrollReport').disable();
			p.getTopToolbar().findById('view-payrollReport').disable();
			p.getTopToolbar().findById('delete-payrollReport').enable();
		}
		else if(this.getSelections().length == 1){
			p.getTopToolbar().findById('edit-payrollReport').enable();
			p.getTopToolbar().findById('view-payrollReport').enable();
			p.getTopToolbar().findById('delete-payrollReport').enable();
		}
		else{
			p.getTopToolbar().findById('edit-payrollReport').disable();
			p.getTopToolbar().findById('view-payrollReport').disable();
			p.getTopToolbar().findById('delete-payrollReport').disable();
		}
	});
	center_panel.setActiveTab(p);
	
	store_payrollReports2.load({
		params: {
			start: 0,          
			limit: list_size
		}
	});
	
}
