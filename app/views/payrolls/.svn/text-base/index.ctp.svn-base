
var store_payrolls = new Ext.data.Store({
	reader: new Ext.data.JsonReader({
		root:'rows',
		totalProperty: 'results',
		fields: [
			'id','name'		]
	}),
	proxy: new Ext.data.HttpProxy({
		url: '<?php echo $this->Html->url(array('controller' => 'payrolls', 'action' => 'list_data')); ?>'
	})
});


function AddPayroll() {
	Ext.Ajax.request({
		url: '<?php echo $this->Html->url(array('controller' => 'payrolls', 'action' => 'add')); ?>',
		success: function(response, opts) {
			var payroll_data = response.responseText;
			
			eval(payroll_data);
			
			PayrollAddWindow.show();
		},
		failure: function(response, opts) {
			Ext.Msg.alert('<?php __('Error'); ?>', '<?php __('Cannot get the payroll add form. Error code'); ?>: ' + response.status);
		}
	});
}

function EditPayroll(id) {
	Ext.Ajax.request({
		url: '<?php echo $this->Html->url(array('controller' => 'payrolls', 'action' => 'edit')); ?>/'+id,
		success: function(response, opts) {
			var payroll_data = response.responseText;
			
			eval(payroll_data);
			
			PayrollEditWindow.show();
		},
		failure: function(response, opts) {
			Ext.Msg.alert('<?php __('Error'); ?>', '<?php __('Cannot get the payroll edit form. Error code'); ?>: ' + response.status);
		}
	});
}

function ViewPayroll(id) {
    Ext.Ajax.request({
        url: '<?php echo $this->Html->url(array('controller' => 'payrolls', 'action' => 'view')); ?>/'+id,
        success: function(response, opts) {
            var payroll_data = response.responseText;

            eval(payroll_data);

            PayrollViewWindow.show();
        },
        failure: function(response, opts) {
            Ext.Msg.alert('<?php __('Error'); ?>', '<?php __('Cannot get the payroll view form. Error code'); ?>: ' + response.status);
        }
    });
}
function ViewParentBenefits(id) {
    Ext.Ajax.request({
        url: '<?php echo $this->Html->url(array('controller' => 'benefits', 'action' => 'index2')); ?>/'+id,
        success: function(response, opts) {
            var parent_benefits_data = response.responseText;

            eval(parent_benefits_data);

            parentBenefitsViewWindow.show();
        },
        failure: function(response, opts) {
            Ext.Msg.alert('<?php __('Error'); ?>', '<?php __('Cannot get the campus view form. Error code'); ?>: ' + response.status);
        }
    });
}

function ViewParentDeductions(id) {
    Ext.Ajax.request({
        url: '<?php echo $this->Html->url(array('controller' => 'deductions', 'action' => 'index2')); ?>/'+id,
        success: function(response, opts) {
            var parent_deductions_data = response.responseText;

            eval(parent_deductions_data);

            parentDeductionsViewWindow.show();
        },
        failure: function(response, opts) {
            Ext.Msg.alert('<?php __('Error'); ?>', '<?php __('Cannot get the campus view form. Error code'); ?>: ' + response.status);
        }
    });
}

function ViewParentPayrollEmployees(id) {
    Ext.Ajax.request({
        url: '<?php echo $this->Html->url(array('controller' => 'payrollEmployees', 'action' => 'index2')); ?>/'+id,
        success: function(response, opts) {
            var parent_payrollEmployees_data = response.responseText;

            eval(parent_payrollEmployees_data);

            parentPayrollEmployeesViewWindow.show();
        },
        failure: function(response, opts) {
            Ext.Msg.alert('<?php __('Error'); ?>', '<?php __('Cannot get the campus view form. Error code'); ?>: ' + response.status);
        }
    });
}

function ViewParentPensions(id) {
    Ext.Ajax.request({
        url: '<?php echo $this->Html->url(array('controller' => 'pensions', 'action' => 'index2')); ?>/'+id,
        success: function(response, opts) {
            var parent_pensions_data = response.responseText;

            eval(parent_pensions_data);

            parentPensionsViewWindow.show();
        },
        failure: function(response, opts) {
            Ext.Msg.alert('<?php __('Error'); ?>', '<?php __('Cannot get the campus view form. Error code'); ?>: ' + response.status);
        }
    });
}

function ViewParentPrices(id) {
    Ext.Ajax.request({
        url: '<?php echo $this->Html->url(array('controller' => 'prices', 'action' => 'index2')); ?>/'+id,
        success: function(response, opts) {
            var parent_prices_data = response.responseText;

            eval(parent_prices_data);

            parentPricesViewWindow.show();
        },
        failure: function(response, opts) {
            Ext.Msg.alert('<?php __('Error'); ?>', '<?php __('Cannot get the campus view form. Error code'); ?>: ' + response.status);
        }
    });
}

function ViewParentTaxRules(id) {
    Ext.Ajax.request({
        url: '<?php echo $this->Html->url(array('controller' => 'taxRules', 'action' => 'index2')); ?>/'+id,
        success: function(response, opts) {
            var parent_taxRules_data = response.responseText;

            eval(parent_taxRules_data);

            parentTaxRulesViewWindow.show();
        },
        failure: function(response, opts) {
            Ext.Msg.alert('<?php __('Error'); ?>', '<?php __('Cannot get the campus view form. Error code'); ?>: ' + response.status);
        }
    });
}

function ViewParentUsers(id) {
    Ext.Ajax.request({
        url: '<?php echo $this->Html->url(array('controller' => 'users', 'action' => 'index2')); ?>/'+id,
        success: function(response, opts) {
            var parent_users_data = response.responseText;

            eval(parent_users_data);

            parentUsersViewWindow.show();
        },
        failure: function(response, opts) {
            Ext.Msg.alert('<?php __('Error'); ?>', '<?php __('Cannot get the campus view form. Error code'); ?>: ' + response.status);
        }
    });
}


function DeletePayroll(id) {
	Ext.Ajax.request({
		url: '<?php echo $this->Html->url(array('controller' => 'payrolls', 'action' => 'delete')); ?>/'+id,
		success: function(response, opts) {
			Ext.Msg.alert('<?php __('Success'); ?>', '<?php __('Payroll successfully deleted!'); ?>');
			RefreshPayrollData();
		},
		failure: function(response, opts) {
			Ext.Msg.alert('<?php __('Error'); ?>', '<?php __('Cannot get the payroll add form. Error code'); ?>: ' + response.status);
		}
	});
}

function SearchPayroll(){
	Ext.Ajax.request({
		url: '<?php echo $this->Html->url(array('controller' => 'payrolls', 'action' => 'search')); ?>',
		success: function(response, opts){
			var payroll_data = response.responseText;

			eval(payroll_data);

			payrollSearchWindow.show();
		},
		failure: function(response, opts) {
			Ext.Msg.alert('<?php __('Error'); ?>','<?php __('Cannot get the payroll search form. Error Code'); ?>: ' + response.status);
		}
	});
}

function SearchByPayrollName(value){
	var conditions = '\'Payroll.name LIKE\' => \'%' + value + '%\'';
	store_payrolls.reload({
		 params: {
			start: 0,
			limit: list_size,
			conditions: conditions
	    }
	});
}

function RefreshPayrollData() {
	store_payrolls.reload();
}


if(center_panel.find('id', 'payroll-tab') != "") {
	var p = center_panel.findById('payroll-tab');
	center_panel.setActiveTab(p);
} else {
	var p = center_panel.add({
		title: '<?php __('Payrolls'); ?>',
		closable: true,
		loadMask: true,
		stripeRows: true,
		id: 'payroll-tab',
		xtype: 'grid',
		store: store_payrolls,
		columns: [
			{header: "<?php __('Name'); ?>", dataIndex: 'name', sortable: true}
		],
		viewConfig: {
			forceFit: true
		}
,
		listeners: {
			celldblclick: function(){
				ViewPayroll(Ext.getCmp('payroll-tab').getSelectionModel().getSelected().data.id);
			}
		},
		sm: new Ext.grid.RowSelectionModel({
			singleSelect: false
		}),
		tbar: new Ext.Toolbar({
			
			items: [{
					xtype: 'tbbutton',
					text: '<?php __('Add'); ?>',
					tooltip:'<?php __('<b>Add Payrolls</b><br />Click here to create a new Payroll'); ?>',
					icon: 'img/table_add.png',
					cls: 'x-btn-text-icon',
					handler: function(btn) {
						AddPayroll();
					}
				}, ' ', '-', ' ', {
					xtype: 'tbbutton',
					text: '<?php __('Edit'); ?>',
					id: 'edit-payroll',
					tooltip:'<?php __('<b>Edit Payrolls</b><br />Click here to modify the selected Payroll'); ?>',
					icon: 'img/table_edit.png',
					cls: 'x-btn-text-icon',
					disabled: true,
					handler: function(btn) {
						var sm = p.getSelectionModel();
						var sel = sm.getSelected();
						if (sm.hasSelection()){
							EditPayroll(sel.data.id);
						};
					}
				}, ' ', '-', ' ', {
					xtype: 'tbbutton',
					text: '<?php __('Delete'); ?>',
					id: 'delete-payroll',
					tooltip:'<?php __('<b>Delete Payrolls(s)</b><br />Click here to remove the selected Payroll(s)'); ?>',
					icon: 'img/table_delete.png',
					cls: 'x-btn-text-icon',
					disabled: true,
					handler: function(btn) {
						var sm = p.getSelectionModel();
						var sel = sm.getSelections();
						if (sm.hasSelection()){
							if(sel.length==1){
								Ext.Msg.show({
									title: '<?php __('Remove Payroll'); ?>',
									buttons: Ext.MessageBox.YESNO,
									msg: '<?php __('Remove'); ?> '+sel[0].data.name+'?',
									icon: Ext.MessageBox.QUESTION,
									fn: function(btn){
										if (btn == 'yes'){
											DeletePayroll(sel[0].data.id);
										}
									}
								});
							}else{
								Ext.Msg.show({
									title: '<?php __('Remove Payroll'); ?>',
									buttons: Ext.MessageBox.YESNO,
									msg: '<?php __('Remove the selected Payrolls'); ?>?',
									icon: Ext.MessageBox.QUESTION,
									fn: function(btn){
										if (btn == 'yes'){
											var sel_ids = '';
											for(i=0;i<sel.length;i++){
												if(i>0)
													sel_ids += '_';
												sel_ids += sel[i].data.id;
											}
											DeletePayroll(sel_ids);
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
					text: '<?php __('View Payroll'); ?>',
					id: 'view-payroll',
					tooltip:'<?php __('<b>View Payroll</b><br />Click here to see details of the selected Payroll'); ?>',
					icon: 'img/table_view.png',
					cls: 'x-btn-text-icon',
					disabled: true,
					handler: function(btn) {
						var sm = p.getSelectionModel();
						var sel = sm.getSelected();
						if (sm.hasSelection()){
							ViewPayroll(sel.data.id);
						};
					},
					menu : {
						items: [
{
							text: '<?php __('View Benefits'); ?>',
                            icon: 'img/table_view.png',
							cls: 'x-btn-text-icon',
							handler: function(btn) {
								var sm = p.getSelectionModel();
								var sel = sm.getSelected();
								if (sm.hasSelection()){
									ViewParentBenefits(sel.data.id);
								};
							}
						}
,{
							text: '<?php __('View Deductions'); ?>',
                            icon: 'img/table_view.png',
							cls: 'x-btn-text-icon',
							handler: function(btn) {
								var sm = p.getSelectionModel();
								var sel = sm.getSelected();
								if (sm.hasSelection()){
									ViewParentDeductions(sel.data.id);
								};
							}
						}
,{
							text: '<?php __('View Payroll Employees'); ?>',
                            icon: 'img/table_view.png',
							cls: 'x-btn-text-icon',
							handler: function(btn) {
								var sm = p.getSelectionModel();
								var sel = sm.getSelected();
								if (sm.hasSelection()){
									ViewParentPayrollEmployees(sel.data.id);
								};
							}
						}
,{
							text: '<?php __('View Pensions'); ?>',
                            icon: 'img/table_view.png',
							cls: 'x-btn-text-icon',
							handler: function(btn) {
								var sm = p.getSelectionModel();
								var sel = sm.getSelected();
								if (sm.hasSelection()){
									ViewParentPensions(sel.data.id);
								};
							}
						}
,{
							text: '<?php __('View Prices'); ?>',
                            icon: 'img/table_view.png',
							cls: 'x-btn-text-icon',
							handler: function(btn) {
								var sm = p.getSelectionModel();
								var sel = sm.getSelected();
								if (sm.hasSelection()){
									ViewParentPrices(sel.data.id);
								};
							}
						}
,{
							text: '<?php __('View Tax Rules'); ?>',
                            icon: 'img/table_view.png',
							cls: 'x-btn-text-icon',
							handler: function(btn) {
								var sm = p.getSelectionModel();
								var sel = sm.getSelected();
								if (sm.hasSelection()){
									ViewParentTaxRules(sel.data.id);
								};
							}
						}
,{
							text: '<?php __('View Users'); ?>',
                            icon: 'img/table_view.png',
							cls: 'x-btn-text-icon',
							handler: function(btn) {
								var sm = p.getSelectionModel();
								var sel = sm.getSelected();
								if (sm.hasSelection()){
									ViewParentUsers(sel.data.id);
								};
							}
						}
						]
					}
				}, ' ', '-',  '->', {
					xtype: 'textfield',
					emptyText: '<?php __('[Search By Name]'); ?>',
					id: 'payroll_search_field',
					listeners: {
						specialkey: function(field, e){
							if (e.getKey() == e.ENTER) {
								SearchByPayrollName(Ext.getCmp('payroll_search_field').getValue());
							}
						}
					}
				}, {
					xtype: 'tbbutton',
					icon: 'img/search.png',
					cls: 'x-btn-text-icon',
					text: '<?php __('GO'); ?>',
                    tooltip:'<?php __('<b>GO</b><br />Click here to get search results'); ?>',
					id: 'payroll_go_button',
					handler: function(){
						SearchByPayrollName(Ext.getCmp('payroll_search_field').getValue());
					}
				}, '-', {
					xtype: 'tbbutton',
					icon: 'img/table_search.png',
					cls: 'x-btn-text-icon',
					text: '<?php __('Advanced Search'); ?>',
                    tooltip:'<?php __('<b>Advanced Search...</b><br />Click here to get the advanced search form'); ?>',
					handler: function(){
						SearchPayroll();
					}
				}
		]}),
		bbar: new Ext.PagingToolbar({
			pageSize: list_size,
			store: store_payrolls,
			displayInfo: true,
			displayMsg: '<?php __('Displaying {0} - {1} of {2}'); ?>',
			beforePageText: '<?php __('Page'); ?>',
			afterPageText: '<?php __('of {0}'); ?>',
			emptyMsg: '<?php __('No data to display'); ?>'
		})
	});
	p.getSelectionModel().on('rowselect', function(sm, rowIdx, r) {
		p.getTopToolbar().findById('edit-payroll').enable();
		p.getTopToolbar().findById('delete-payroll').enable();
		p.getTopToolbar().findById('view-payroll').enable();
		if(this.getSelections().length > 1){
			p.getTopToolbar().findById('edit-payroll').disable();
			p.getTopToolbar().findById('view-payroll').disable();
		}
	});
	p.getSelectionModel().on('rowdeselect', function(sm, rowIdx, r) {
		if(this.getSelections().length > 1){
			p.getTopToolbar().findById('edit-payroll').disable();
			p.getTopToolbar().findById('view-payroll').disable();
			p.getTopToolbar().findById('delete-payroll').enable();
		}
		else if(this.getSelections().length == 1){
			p.getTopToolbar().findById('edit-payroll').enable();
			p.getTopToolbar().findById('view-payroll').enable();
			p.getTopToolbar().findById('delete-payroll').enable();
		}
		else{
			p.getTopToolbar().findById('edit-payroll').disable();
			p.getTopToolbar().findById('view-payroll').disable();
			p.getTopToolbar().findById('delete-payroll').disable();
		}
	});
	center_panel.setActiveTab(p);
	
	store_payrolls.load({
		params: {
			start: 0,          
			limit: list_size
		}
	});
	
}
