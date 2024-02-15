
    var store_employees = new Ext.data.GroupingStore({
	reader: new Ext.data.JsonReader({
            root:'rows',
            totalProperty: 'results',
            fields: [
                'id', 'employee_name', 'identification_card_number',
                'date_of_employment','terms_of_employment',
                'experience', 'education', 'children','language','EmployeeDetail', 'created'		
                ]
	}),
	proxy: new Ext.data.HttpProxy({
            url: '<?php echo $this->Html->url(array('controller' => 'employees', 'action' => 'list_data3')); ?>'
	}),	
        sortInfo:{field: 'employee_name', direction: "ASC"}
    });
    var store_employee_names = new Ext.data.GroupingStore({
	reader: new Ext.data.JsonReader({
            root:'rows',
            totalProperty: 'results',
            fields: [
                'id', 'full_name'		
            ]
	}),
	proxy: new Ext.data.HttpProxy({
            url: '<?php echo $this->Html->url(array('controller' => 'employees', 'action' => 'search_emp2')); ?>'
	}),	
        sortInfo:{field: 'full_name', direction: "ASC"}
    });
   
    function AddEmployee() {
	Ext.Ajax.request({
            url: '<?php echo $this->Html->url(array('controller' => 'payroll_employees', 'action' => 'add2')); ?>',
            success: function(response, opts) {
                var employee_data = response.responseText;
			
                eval(employee_data);
			
                PayrollEmployeeAddWindow.show();
            },
            failure: function(response, opts) {
                Ext.Msg.alert('<?php __('Error'); ?>', '<?php __('Cannot get the employee add form. Error code'); ?>: ' + response.status);
            }
	});
    }

    function EditEmployee(id) {
	Ext.Ajax.request({
            url: '<?php echo $this->Html->url(array('controller' => 'employees', 'action' => 'edit')); ?>/'+id,
            success: function(response, opts) {
                var employee_data = response.responseText;
			
                eval(employee_data);
			
                EmployeeEditWindow.show();
            },
            failure: function(response, opts) {
                Ext.Msg.alert('<?php __('Error'); ?>', '<?php __('Cannot get the employee edit form. Error code'); ?>: ' + response.status);
            }
	});
    }
function ViewParentPayrollEmployee(id){
            Ext.Ajax.request({
            url: '<?php echo $this->Html->url(array('controller' => 'PayrollEmployees', 'action' => 'index2')); ?>/'+id,
            success: function(response, opts) {
                var parent_PayrollEmployees_data = response.responseText;

                eval(parent_PayrollEmployees_data);

                parentPayrollEmployeesViewWindow.show();
            },
            failure: function(response, opts) {
                Ext.Msg.alert('<?php __('Error'); ?>', '<?php __('Cannot get the campus view form. Error code'); ?>: ' + response.status);
            }
        }); 
    }
    function ViewEmployee(id) {
        Ext.Ajax.request({
            url: '<?php echo $this->Html->url(array('controller' => 'employees', 'action' => 'view')); ?>/'+id,
            success: function(response, opts) {
                var employee_data = response.responseText;

                eval(employee_data);

                EmployeeViewWindow.show();
            },
            failure: function(response, opts) {
                Ext.Msg.alert('<?php __('Error'); ?>', '<?php __('Cannot get the employee view form. Error code'); ?>: ' + response.status);
            }
        });
    }
    function ViewParentEducations(id) {
        Ext.Ajax.request({
            url: '<?php echo $this->Html->url(array('controller' => 'educations', 'action' => 'index2')); ?>/'+id,
            success: function(response, opts) {
                var parent_educations_data = response.responseText;

                eval(parent_educations_data);

                parentEducationsViewWindow.show();
            },
            failure: function(response, opts) {
                Ext.Msg.alert('<?php __('Error'); ?>', '<?php __('Cannot get the campus view form. Error code'); ?>: ' + response.status);
            }
        });
    }

    function ViewParentEmployeeDetails(id) {
        Ext.Ajax.request({
            url: '<?php echo $this->Html->url(array('controller' => 'employeeDetails', 'action' => 'index2')); ?>/'+id,
            success: function(response, opts) {
                var parent_employeeDetails_data = response.responseText;

                eval(parent_employeeDetails_data);

                parentEmployeeDetailsViewWindow.show();
            },
            failure: function(response, opts) {
                Ext.Msg.alert('<?php __('Error'); ?>', '<?php __('Cannot get the campus view form. Error code'); ?>: ' + response.status);
            }
        });
    }

    function ViewParentExperiences(id) {
        Ext.Ajax.request({
            url: '<?php echo $this->Html->url(array('controller' => 'experiences', 'action' => 'index2')); ?>/'+id,
            success: function(response, opts) {
                var parent_experiences_data = response.responseText;

                eval(parent_experiences_data);

                parentExperiencesViewWindow.show();
            },
            failure: function(response, opts) {
                Ext.Msg.alert('<?php __('Error'); ?>', '<?php __('Cannot get the campus view form. Error code'); ?>: ' + response.status);
            }
        });
    }

    function ViewParentLanguages(id) {
        Ext.Ajax.request({
            url: '<?php echo $this->Html->url(array('controller' => 'languages', 'action' => 'index2')); ?>/'+id,
            success: function(response, opts) {
                var parent_languages_data = response.responseText;

                eval(parent_languages_data);

                parentLanguagesViewWindow.show();
            },
            failure: function(response, opts) {
                Ext.Msg.alert('<?php __('Error'); ?>', '<?php __('Cannot get the campus view form. Error code'); ?>: ' + response.status);
            }
        });
    }

    function ViewParentOffsprings(id) {
        Ext.Ajax.request({
            url: '<?php echo $this->Html->url(array('controller' => 'offsprings', 'action' => 'index2')); ?>/'+id,
            success: function(response, opts) {
                var parent_offsprings_data = response.responseText;

                eval(parent_offsprings_data);

                parentOffspringsViewWindow.show();
            },
            failure: function(response, opts) {
                Ext.Msg.alert('<?php __('Error'); ?>', '<?php __('Cannot get the campus view form. Error code'); ?>: ' + response.status);
            }
        });
    }

    function ViewParentSupervisor(id){
            Ext.Ajax.request({
            url: '<?php echo $this->Html->url(array('controller' => 'supervisors', 'action' => 'edit')); ?>/'+id,
            success: function(response, opts) {
                var parent_supervisors_data = response.responseText;

                eval(parent_supervisors_data);

                parentSupervisorsViewWindow.show();
            },
            failure: function(response, opts) {
                Ext.Msg.alert('<?php __('Error'); ?>', '<?php __('Cannot get the campus view form. Error code'); ?>: ' + response.status);
            }
        });
    }
    
        function ViewParentHistory(id){
            Ext.Ajax.request({
            url: '<?php echo $this->Html->url(array('controller' => 'employee_details', 'action' => 'index2')); ?>/'+id,
            success: function(response, opts) {
                var parent_histories_data = response.responseText;

                eval(parent_histories_data);

                parentEmployeeDetailsViewWindow.show();
            },
            failure: function(response, opts) {
                Ext.Msg.alert('<?php __('Error'); ?>', '<?php __('Cannot get the campus view form. Error code'); ?>: ' + response.status);
            }
        });
    }
    function ViewParentLoan(id){
              Ext.Ajax.request({
            url: '<?php echo $this->Html->url(array('controller' => 'loans', 'action' => 'index2')); ?>/'+id,
            success: function(response, opts) {
                var parent_loans_data = response.responseText;

                eval(parent_loans_data);

                parentLoansViewWindow.show();
            },
            failure: function(response, opts) {
                Ext.Msg.alert('<?php __('Error'); ?>', '<?php __('Cannot get the campus view form. Error code'); ?>: ' + response.status);
            }
        });  
    }
    
    function DeleteEmployee(id) {
	Ext.Ajax.request({
            url: '<?php echo $this->Html->url(array('controller' => 'employees', 'action' => 'delete')); ?>/'+id,
            success: function(response, opts) {
                Ext.Msg.alert('<?php __('Success'); ?>', '<?php __('Employee successfully deleted!'); ?>');
                RefreshEmployeeData();
            },
            failure: function(response, opts) {
                Ext.Msg.alert('<?php __('Error'); ?>', '<?php __('Cannot get the employee add form. Error code'); ?>: ' + response.status);
            }
	});
    }

    function SearchEmployee(){
	Ext.Ajax.request({
            url: '<?php echo $this->Html->url(array('controller' => 'employees', 'action' => 'search')); ?>',
            success: function(response, opts){
                var employee_data = response.responseText;

                eval(employee_data);

                employeeSearchWindow.show();
            },
            failure: function(response, opts) {
                Ext.Msg.alert('<?php __('Error'); ?>','<?php __('Cannot get the employee search form. Error Code'); ?>: ' + response.status);
            }
	});
    }
    function SearchEmployees(){
    search_empWindow.show();
    }
    function SearchByEmployeeName(value){
	var conditions = '\'Employee.name LIKE\' => \'%' + value + '%\'';
	store_employees.reload({
            params: {
                start: 0,
                limit: list_size,
                conditions: conditions
	    }
	});
    }
    function ViewDeduction(id){
              Ext.Ajax.request({
            url: '<?php echo $this->Html->url(array('controller' => 'deductions', 'action' => 'index22')); ?>/'+id,
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
   
        function ViewBenefit(id){
              Ext.Ajax.request({
            url: '<?php echo $this->Html->url(array('controller' => 'benefits', 'action' => 'index22')); ?>/'+id,
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
    function RefreshEmployeeData() {
        store_employees.reload();
    }

    function EditPension(id){
            Ext.Ajax.request({
            url: '<?php echo $this->Html->url(array('controller' => 'PensionEmployees', 'action' => 'edit')); ?>/'+id,
            success: function(response, opts) {
                var parent_PensionEmployees_data = response.responseText;

                eval(parent_PensionEmployees_data);

                PensionEmployeeEditWindow.show();
            },
            failure: function(response, opts) {
                Ext.Msg.alert('<?php __('Error'); ?>', '<?php __('Cannot get the campus view form. Error code'); ?>: ' + response.status);
            }
        });
    }
     function CashIndemnity(id){
            Ext.Ajax.request({
            url: '<?php echo $this->Html->url(array('controller' => 'CashStores', 'action' => 'index2')); ?>/'+id,
            success: function(response, opts) {
                var parent_CashStore_data = response.responseText;

                eval(parent_CashStore_data);

                parentCashStoresViewWindow.show();
            },
            failure: function(response, opts) {
                Ext.Msg.alert('<?php __('Error'); ?>', '<?php __('Cannot get the campus view form. Error code'); ?>: ' + response.status);
            }
        });
    }
	 function Perdium(id){
            Ext.Ajax.request({
            url: '<?php echo $this->Html->url(array('controller' => 'Perrdiemms', 'action' => 'index2')); ?>/'+id,
            success: function(response, opts) {
                var parent_CashStore_data = response.responseText;

                eval(parent_CashStore_data);

                parentPerrdiemmsViewWindow.show();
            },
            failure: function(response, opts) {
                Ext.Msg.alert('<?php __('Error'); ?>', '<?php __('Cannot get the campus view form. Error code'); ?>: ' + response.status);
            }
        });
    }
    function showMenu(grid, index, event) {
        event.stopEvent();
        var record = grid.getStore().getAt(index);
        var btnStatus = 0; //(record.get('rejectable') == 'True')? false: true;
        var menu = new Ext.menu.Menu({
            items: [
                
                            {
                                text: 'Loan',
                                handler: function() {
                                    ViewParentLoan(record.get('id'));
                                }
                            }, {
                                text: 'Special Benefits',
                                handler: function() {
                                    ViewBenefit(record.get('id'));
                                    //alert('under construction!');
                                },
                                disabled: btnStatus
                            },
                             {
                                text: 'Special Deductions',
                                handler: function() {
                                    ViewDeduction(record.get('id'));
                                    //alert('under construction!');
                                },
                                disabled: btnStatus
                            },
                            {
                                text: 'PF/Pension',
                                handler: function() {
                                    EditPension(record.get('id'));
                                    //alert('under construction!');
                                },
                                disabled: btnStatus
                            },
                             {
                                text: 'Cash Indemnity',
                                handler: function() {
                                    CashIndemnity(record.get('id'));
                                    //alert('under construction!');
                                },
                                disabled: btnStatus
                            },
                             {
                                text: 'Perdium',
                                handler: function() {
                                    Perdium(record.get('id'));
                                    //alert('under construction!');
                                },
                                disabled: btnStatus
                            },{
								text: 'Salary & Account Setting',
								handler: function() {
									ViewParentPayrollEmployee(record.get('id'));
								}
							}
                       
             
            ]
        }).showAt(event.xy);
    }

    if(center_panel.find('id', 'employeep-tab') != "") {
        var p = center_panel.findById('employeep-tab');
        center_panel.setActiveTab(p);
    } else {
        var p = center_panel.add({
            title: '<?php __('Employees/Payroll'); ?>',
            closable: true,
            loadMask: true,
            stripeRows: true,
            id: 'employeep-tab',
            xtype: 'grid',
            store: store_employees,
            columns: [
                {header: "<?php __('Employee Name'); ?>", dataIndex: 'employee_name', sortable: true},
                {header: "<?php __('Identification Card Number'); ?>", dataIndex: 'identification_card_number', sortable: true},
                {header: "<?php __('Date Of Employment'); ?>", dataIndex: 'date_of_employment', sortable: true},
                {header: "<?php __('Terms Of Employment'); ?>", dataIndex: 'terms_of_employment', sortable: true},
                {header: "<?php __('Created'); ?>", dataIndex: 'created', sortable: true}
            ],
            view: new Ext.grid.GroupingView({
                forceFit:true,
                groupTextTpl: '{text} ({[values.rs.length]} {[values.rs.length > 1 ? "Employees" : "Employee"]})'
            }),
            listeners: {
                'rowcontextmenu': function(grid, index, event) {
                    showMenu(grid, index, event);
                }
            },
            sm: new Ext.grid.RowSelectionModel({
                singleSelect: false
            }),
			tbar: new Ext.Toolbar({
			
                items: [{
                        xtype: 'tbbutton',
                        text: '<?php __('Add Employees to Payroll'); ?>',
                        tooltip:'<?php __('<b>Add Employees to Payroll'); ?>',
                        icon: 'img/table_add.png',
                        cls: 'x-btn-text-icon',
                        handler: function(btn) {
                            AddEmployee();
                        }
						}]
				}),
            bbar: new Ext.PagingToolbar({
                pageSize: list_size,
                store: store_employees,
                displayInfo: true,
                displayMsg: '<?php __('Displaying {0} - {1} of {2}'); ?>',
                beforePageText: '<?php __('Page'); ?>',
                afterPageText: '<?php __('of {0}'); ?>',
                emptyMsg: '<?php __('No data to display'); ?>'
            })
        });
        
        center_panel.setActiveTab(p);
	
        store_employees.load({
            params: {
                start: 0,          
                limit: list_size
            }
        });
			
        store_employee_names.load({
            params: {
                start: 0,          
                limit: list_size
            }
        });
	
    }
    var search_emp_form = new Ext.form.FormPanel({
            baseCls: 'x-plain',
            labelWidth: 100,
            labelAlign: 'right',
            url:'<?php echo $this->Html->url(array('controller' => 'branches', 'action' => 'add')); ?>',
            defaultType: 'textfield',

            items: [{
                    xtype: 'combo',
                    name: 'data[Person][full_name]',
                    emptyText: 'All',
                    id: 'data[Person][full_name]',
                    name: 'data[Person][full_name]',
                    store : store_employee_names,
                    displayField : 'full_name',
                    valueField : 'id',
                    fieldLabel: 'Full Name',
                    mode: 'local',
                    disableKeyFilter : true,
                    allowBlank: false,
                    typeAhead: true,
                    emptyText: '',
                    editable: true,
                    triggerAction: 'all',
                    hideTrigger:true,
                    width:155
                }     ]
    });    
var search_empWindow = new Ext.Window({
	title: '<?php __('Search Employee'); ?>',
	modal: true,
        items: search_emp_form,
        buttons:[{
                    text: '<?php __('Close'); ?>',
                    handler: function(btn){
                            search_empWindow.hide();
                    }}],
	resizable: false,
	width: 350,
	height: 200,
	bodyStyle: 'padding: 5px;',
        layout: 'fit',
	plain: true,
        closable:false
});