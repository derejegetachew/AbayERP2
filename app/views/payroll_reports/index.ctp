
var store_payrollReports = new Ext.data.GroupingStore({
	reader: new Ext.data.JsonReader({
		root:'rows',
		totalProperty: 'results',
		fields: [
			'id','date','payroll','budget_year','status'		]
	}),
	proxy: new Ext.data.HttpProxy({
		url: '<?php echo $this->Html->url(array('controller' => 'payrollReports', 'action' => 'list_data')); ?>'
	})
,	sortInfo:{field: 'date', direction: "ASC"}
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


function ApprovePayrollReport(id) {
	Ext.Ajax.request({
		url: '<?php echo $this->Html->url(array('controller' => 'payrollReports', 'action' => 'approve')); ?>/'+id,
		success: function(response, opts) {
			var payrollReport_data = response.responseText;
			
			eval(payrollReport_data);
			
			PayrollReportApproveWindow.show();
		},
		failure: function(response, opts) {
			Ext.Msg.alert('<?php __('Error'); ?>', '<?php __('Cannot get the payrollReport add form. Error code'); ?>: ' + response.status);
		}
	});
}
function SendPayrollReport(id) {
	Ext.Ajax.request({
		url: '<?php echo $this->Html->url(array('controller' => 'payrollReports', 'action' => 'send')); ?>/'+id,
		success: function(response, opts) {
			var payrollReport_data = response.responseText;
			
			eval(payrollReport_data);
			
			PayrollReportSendWindow.show();
		},
		failure: function(response, opts) {
			Ext.Msg.alert('<?php __('Error'); ?>', '<?php __('Cannot get the payrollReport add form. Error code'); ?>: ' + response.status);
		}
	});
}
function ViewPayrollReport(id) {
    Ext.Ajax.request({
        url: '<?php echo $this->Html->url(array('controller' => 'payrollReports', 'action' => 'index3')); ?>/'+id,
        success: function(response, opts) {
            var payrollReport_data = response.responseText;

            eval(payrollReport_data);

            //PayrollReportViewWindow.show();
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
	store_payrollReports.reload({
		 params: {
			start: 0,
			limit: list_size,
			conditions: conditions
	    }
	});
}

function RefreshPayrollReportData() {
	store_payrollReports.reload();
}
function sendmessage(id) {
	Ext.Ajax.request({
		url: '<?php echo $this->Html->url(array('controller' => 'payrollReports', 'action' => 'open_report_payroll')); ?>/'+id+'/1',
		success: function(response, opts) {
			var dmsShare_data = response.responseText;
			
			eval(dmsShare_data);
			
			DmsDocumentSendWindow.show();
		},
		failure: function(response, opts) {
			Ext.Msg.alert('<?php __('Error'); ?>', '<?php __('Cannot get the dmsShare edit form. Error code'); ?>: ' + response.status);
		}
	});
}

if(center_panel.find('id', 'payrollReport-tab') != "") {
	var p = center_panel.findById('payrollReport-tab');
	center_panel.setActiveTab(p);
} else {
	var p = center_panel.add({
		title: '<?php __('Payroll Reports'); ?>',
		closable: true,
		loadMask: true,
		stripeRows: true,
		id: 'payrollReport-tab',
		xtype: 'grid',
		store: store_payrollReports,
		columns: [
			{header: "<?php __('Date'); ?>", dataIndex: 'date', sortable: true},
			{header: "<?php __('Payroll'); ?>", dataIndex: 'payroll', sortable: true},
			{header: "<?php __('BudgetYear'); ?>", dataIndex: 'budget_year', sortable: true},
                        {header: "<?php __('Status'); ?>", dataIndex: 'status', sortable: true}
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
		tbar: new Ext.Toolbar({
			
			items: [{
					xtype: 'tbbutton',
					text: '<?php __('Create'); ?>',
					tooltip:'<?php __('<b>Add PayrollReports</b><br />Click here to create a new PayrollReport'); ?>',
					icon: 'img/table_add.png',
					cls: 'x-btn-text-icon',
					handler: function(btn) {
						AddPayrollReport();
					}
				}, ' ', '-', ' ', {
					xtype: 'tbbutton',
					text: '<?php __('Approve'); ?>',
					id: 'edit-payrollReport',
					tooltip:'<?php __('<b>Approve payroll for permanent changes'); ?>',
					icon: 'img/table_edit.png',
					cls: 'x-btn-text-icon',
					disabled: true,
					handler: function(btn) {
						var sm = p.getSelectionModel();
						var sel = sm.getSelected();
						if (sm.hasSelection()){
							ApprovePayrollReport(sel.data.id);
						};
					}
				},' ', '-', ' ', {
					xtype: 'tbbutton',
					text: '<?php __('Send Email'); ?>',
					id: 'send-payrollReport',
					tooltip:'<?php __('<b>Send payroll report to employees'); ?>',
					icon: 'img/table_edit.png',
					cls: 'x-btn-text-icon',
					disabled: true,
					handler: function(btn) {
						var sm = p.getSelectionModel();
						var sel = sm.getSelected();
						if (sm.hasSelection()){
							sendmessage(sel.data.id);
						};
					}
				}, ' ', '-', ' ', {
					xtype: 'tbbutton',
					text: '<?php __('Delete'); ?>',
					id: 'delete-payrollReport',
					tooltip:'<?php __('<b>Delete PayrollReports(s)</b><br />Click here to remove the selected PayrollReport(s)'); ?>',
					icon: 'img/table_delete.png',
					cls: 'x-btn-text-icon',
					disabled: true,
					handler: function(btn) {
						var sm = p.getSelectionModel();
						var sel = sm.getSelections();
						if (sm.hasSelection()){
							if(sel.length==1){
								Ext.Msg.show({
									title: '<?php __('Remove PayrollReport'); ?>',
									buttons: Ext.MessageBox.YESNO,
									msg: '<?php __('Remove'); ?> '+sel[0].data.name+'?',
									icon: Ext.MessageBox.QUESTION,
									fn: function(btn){
										if (btn == 'yes'){
											DeletePayrollReport(sel[0].data.id);
										}
									}
								});
							}else{
								Ext.Msg.show({
									title: '<?php __('Remove PayrollReport'); ?>',
									buttons: Ext.MessageBox.YESNO,
									msg: '<?php __('Remove the selected PayrollReports'); ?>?',
									icon: Ext.MessageBox.QUESTION,
									fn: function(btn){
										if (btn == 'yes'){
											var sel_ids = '';
											for(i=0;i<sel.length;i++){
												if(i>0)
													sel_ids += '_';
												sel_ids += sel[i].data.id;
											}
											DeletePayrollReport(sel_ids);
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
					text: '<?php __('View PayrollReport'); ?>',
					id: 'view-payrollReport',
					tooltip:'<?php __('<b>View PayrollReport</b><br />Click here to see details of the selected PayrollReport'); ?>',
					icon: 'img/table_view.png',
					cls: 'x-btn-text-icon',
					disabled: true,
					handler: function(btn) {
						var sm = p.getSelectionModel();
						var sel = sm.getSelected();
						if (sm.hasSelection()){
							ViewPayrollReport(sel.data.id);
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
							store_payrollReports.reload({
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
					id: 'payrollReport_search_field',
					listeners: {
						specialkey: function(field, e){
							if (e.getKey() == e.ENTER) {
								SearchByPayrollReportName(Ext.getCmp('payrollReport_search_field').getValue());
							}
						}
					}
				}, {
					xtype: 'tbbutton',
					icon: 'img/search.png',
					cls: 'x-btn-text-icon',
					text: '<?php __('GO'); ?>',
                    tooltip:'<?php __('<b>GO</b><br />Click here to get search results'); ?>',
					id: 'payrollReport_go_button',
					handler: function(){
						SearchByPayrollReportName(Ext.getCmp('payrollReport_search_field').getValue());
					}
				}, '-', {
					xtype: 'tbbutton',
					icon: 'img/table_search.png',
					cls: 'x-btn-text-icon',
					text: '<?php __('Advanced Search'); ?>',
                    tooltip:'<?php __('<b>Advanced Search...</b><br />Click here to get the advanced search form'); ?>',
					handler: function(){
						SearchPayrollReport();
					}
				}
		]}),
		bbar: new Ext.PagingToolbar({
			pageSize: list_size,
			store: store_payrollReports,
			displayInfo: true,
			displayMsg: '<?php __('Displaying {0} - {1} of {2}'); ?>',
			beforePageText: '<?php __('Page'); ?>',
			afterPageText: '<?php __('of {0}'); ?>',
			emptyMsg: '<?php __('No data to display'); ?>'
		})
	});
	p.getSelectionModel().on('rowselect', function(sm, rowIdx, r) {
		p.getTopToolbar().findById('edit-payrollReport').enable();
                p.getTopToolbar().findById('send-payrollReport').enable();
		p.getTopToolbar().findById('delete-payrollReport').enable();
		p.getTopToolbar().findById('view-payrollReport').enable();
		if(this.getSelections().length > 1){
			p.getTopToolbar().findById('edit-payrollReport').disable();
                        p.getTopToolbar().findById('send-payrollReport').disable();
			p.getTopToolbar().findById('view-payrollReport').disable();
		}
	});
	p.getSelectionModel().on('rowdeselect', function(sm, rowIdx, r) {
		if(this.getSelections().length > 1){
			p.getTopToolbar().findById('edit-payrollReport').disable();
                        p.getTopToolbar().findById('send-payrollReport').disable();
			p.getTopToolbar().findById('view-payrollReport').disable();
			p.getTopToolbar().findById('delete-payrollReport').enable();
		}
		else if(this.getSelections().length == 1){
			p.getTopToolbar().findById('edit-payrollReport').enable();
                        p.getTopToolbar().findById('send-payrollReport').enable();
			p.getTopToolbar().findById('view-payrollReport').enable();
			p.getTopToolbar().findById('delete-payrollReport').enable();
		}
		else{
			p.getTopToolbar().findById('edit-payrollReport').disable();
                        p.getTopToolbar().findById('send-payrollReport').disable();
			p.getTopToolbar().findById('view-payrollReport').disable();
			p.getTopToolbar().findById('delete-payrollReport').disable();
		}
	});
	center_panel.setActiveTab(p);
	
	store_payrollReports.load({
		params: {
			start: 0,          
			limit: list_size
		}
	});
	
}
