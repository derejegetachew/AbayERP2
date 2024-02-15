var store_parent_payrollReports = new Ext.data.Store({
	reader: new Ext.data.JsonReader({
		root:'rows',
		totalProperty: 'results',
		fields: [
			'id','date','payroll','budget_year'	
		]
	}),
	proxy: new Ext.data.HttpProxy({
		url: '<?php echo $this->Html->url(array('controller' => 'payrollReports', 'action' => 'list_data', $parent_id)); ?>'	})
});


function AddParentPayrollReport() {
	Ext.Ajax.request({
		url: '<?php echo $this->Html->url(array('controller' => 'payrollReports', 'action' => 'add', $parent_id)); ?>',
		success: function(response, opts) {
			var parent_payrollReport_data = response.responseText;
			
			eval(parent_payrollReport_data);
			
			PayrollReportAddWindow.show();
		},
		failure: function(response, opts) {
			Ext.Msg.alert('<?php __('Error'); ?>', '<?php __('Cannot get the payrollReport add form. Error code'); ?>: ' + response.status);
		}
	});
}

function EditParentPayrollReport(id) {
	Ext.Ajax.request({
		url: '<?php echo $this->Html->url(array('controller' => 'payrollReports', 'action' => 'edit')); ?>/'+id+'/<?php echo $parent_id; ?>',
		success: function(response, opts) {
			var parent_payrollReport_data = response.responseText;
			
			eval(parent_payrollReport_data);
			
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


function DeleteParentPayrollReport(id) {
	Ext.Ajax.request({
		url: '<?php echo $this->Html->url(array('controller' => 'payrollReports', 'action' => 'delete')); ?>/'+id,
		success: function(response, opts) {
			Ext.Msg.alert('<?php __('Success'); ?>', '<?php __('PayrollReport(s) successfully deleted!'); ?>');
			RefreshParentPayrollReportData();
		},
		failure: function(response, opts) {
			Ext.Msg.alert('<?php __('Error'); ?>', '<?php __('Cannot get the payrollReport to be deleted. Error code'); ?>: ' + response.status);
		}
	});
}

function SearchByParentPayrollReportName(value){
	var conditions = '\'PayrollReport.name LIKE\' => \'%' + value + '%\'';
	store_parent_payrollReports.reload({
		 params: {
			start: 0,
			limit: list_size,
			conditions: conditions
	    }
	});
}

function RefreshParentPayrollReportData() {
	store_parent_payrollReports.reload();
}



var g = new Ext.grid.GridPanel({
	title: '<?php __('PayrollReports'); ?>',
	store: store_parent_payrollReports,
	loadMask: true,
	stripeRows: true,
	height: 300,
	anchor: '100%',
    id: 'payrollReportGrid',
	columns: [
		{header: "<?php __('Date'); ?>", dataIndex: 'date', sortable: true},
		{header:"<?php __('payroll'); ?>", dataIndex: 'payroll', sortable: true},
		{header:"<?php __('budget_year'); ?>", dataIndex: 'budget_year', sortable: true}	],
	sm: new Ext.grid.RowSelectionModel({
		singleSelect: false
	}),
	viewConfig: {
		forceFit: true
	},
    listeners: {
        celldblclick: function(){
            ViewPayrollReport(Ext.getCmp('payrollReportGrid').getSelectionModel().getSelected().data.id);
        }
    },
	tbar: new Ext.Toolbar({
		items: [{
				xtype: 'tbbutton',
				text: '<?php __('Add'); ?>',
				tooltip:'<?php __('<b>Add PayrollReport</b><br />Click here to create a new PayrollReport'); ?>',
				icon: 'img/table_add.png',
				cls: 'x-btn-text-icon',
				handler: function(btn) {
					AddParentPayrollReport();
				}
			}, ' ', '-', ' ', {
				xtype: 'tbbutton',
				text: '<?php __('Edit'); ?>',
				id: 'edit-parent-payrollReport',
				tooltip:'<?php __('<b>Edit PayrollReport</b><br />Click here to modify the selected PayrollReport'); ?>',
				icon: 'img/table_edit.png',
				cls: 'x-btn-text-icon',
				disabled: true,
				handler: function(btn) {
					var sm = g.getSelectionModel();
					var sel = sm.getSelected();
					if (sm.hasSelection()){
						EditParentPayrollReport(sel.data.id);
					};
				}
			}, ' ', '-', ' ', {
				xtype: 'tbbutton',
				text: '<?php __('Delete'); ?>',
				id: 'delete-parent-payrollReport',
				tooltip:'<?php __('<b>Delete PayrollReport(s)</b><br />Click here to remove the selected PayrollReport(s)'); ?>',
				icon: 'img/table_delete.png',
				cls: 'x-btn-text-icon',
				disabled: true,
				handler: function(btn) {
					var sm = g.getSelectionModel();
					var sel = sm.getSelections();
					if (sm.hasSelection()){
						if(sel.length==1){
							Ext.Msg.show({
									title: '<?php __('Remove PayrollReport'); ?>',
									buttons: Ext.MessageBox.YESNOCANCEL,
									msg: '<?php __('Remove'); ?> '+sel[0].data.name+'?',
									icon: Ext.MessageBox.QUESTION,
                                    fn: function(btn){
											if (btn == 'yes'){
													DeleteParentPayrollReport(sel[0].data.id);
											}
									}
							});
						} else {
							Ext.Msg.show({
									title: '<?php __('Remove PayrollReport'); ?>',
									buttons: Ext.MessageBox.YESNOCANCEL,
									msg: '<?php __('Remove the selected PayrollReport'); ?>?',
									icon: Ext.MessageBox.QUESTION,
                                    fn: function(btn){
											if (btn == 'yes'){
													var sel_ids = '';
													for(i=0;i<sel.length;i++){
														if(i>0)
															sel_ids += '_';
														sel_ids += sel[i].data.id;
													}
													DeleteParentPayrollReport(sel_ids);
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
				text: '<?php __('View PayrollReport'); ?>',
				id: 'view-payrollReport2',
				tooltip:'<?php __('<b>View PayrollReport</b><br />Click here to see details of the selected PayrollReport'); ?>',
				icon: 'img/table_view.png',
				cls: 'x-btn-text-icon',
				disabled: true,
				handler: function(btn) {
					var sm = g.getSelectionModel();
					var sel = sm.getSelected();
					if (sm.hasSelection()){
						ViewPayrollReport(sel.data.id);
					};
				},
				menu : {
					items: [
					]
				}

            }, ' ', '->', {
				xtype: 'textfield',
				emptyText: '<?php __('[Search By Name]'); ?>',
				id: 'parent_payrollReport_search_field',
				listeners: {
					specialkey: function(field, e){
						if (e.getKey() == e.ENTER) {
							SearchByParentPayrollReportName(Ext.getCmp('parent_payrollReport_search_field').getValue());
						}
					}

				}
			}, {
				xtype: 'tbbutton',
				icon: 'img/search.png',
				cls: 'x-btn-text-icon',
				text: 'GO',
				tooltip:'<?php __('<b>GO</b><br />Click here to get search results'); ?>',
				id: 'parent_payrollReport_go_button',
				handler: function(){
					SearchByParentPayrollReportName(Ext.getCmp('parent_payrollReport_search_field').getValue());
				}
			}, ' '
	]}),
	bbar: new Ext.PagingToolbar({
		pageSize: list_size,
		store: store_parent_payrollReports,
		displayInfo: true,
		displayMsg: '<?php __('Displaying {0} - {1} of {2}'); ?>',
		beforePageText: '<?php __('Page'); ?>',
		afterPageText: '<?php __('of {0}'); ?>',
		emptyMsg: '<?php __('No data to display'); ?>'
	})
});
g.getSelectionModel().on('rowselect', function(sm, rowIdx, r) {
	g.getTopToolbar().findById('edit-parent-payrollReport').enable();
	g.getTopToolbar().findById('delete-parent-payrollReport').enable();
        g.getTopToolbar().findById('view-payrollReport2').enable();
	if(this.getSelections().length > 1){
		g.getTopToolbar().findById('edit-parent-payrollReport').disable();
                g.getTopToolbar().findById('view-payrollReport2').disable();
	}
});
g.getSelectionModel().on('rowdeselect', function(sm, rowIdx, r) {
	if(this.getSelections().length > 1){
		g.getTopToolbar().findById('edit-parent-payrollReport').disable();
		g.getTopToolbar().findById('delete-parent-payrollReport').enable();
                g.getTopToolbar().findById('view-payrollReport2').disable();
	}
	else if(this.getSelections().length == 1){
		g.getTopToolbar().findById('edit-parent-payrollReport').enable();
		g.getTopToolbar().findById('delete-parent-payrollReport').enable();
                g.getTopToolbar().findById('view-payrollReport2').enable();
	}
	else{
		g.getTopToolbar().findById('edit-parent-payrollReport').disable();
		g.getTopToolbar().findById('delete-parent-payrollReport').disable();
                g.getTopToolbar().findById('view-payrollReport2').disable();
	}
});



var parentPayrollReportsViewWindow = new Ext.Window({
	title: 'PayrollReport Under the selected Item',
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
			parentPayrollReportsViewWindow.close();
		}
	}]
});

store_parent_payrollReports.load({
    params: {
        start: 0,    
        limit: list_size
    }
});