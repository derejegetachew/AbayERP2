//<script>
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
            url: '<?php echo $this->Html->url(array('controller' => 'employees', 'action' => 'list_data6')); ?>'
	}),	
        sortInfo:{field: 'employee_name', direction: "ASC"}
    });
    var store_employee_names = new Ext.data.GroupingStore({
	reader: new Ext.data.JsonReader({
            root:'rows',
            totalProperty: 'results',
            fields: [
                'id', 'full_name','position'		
            ]
	}),
	proxy: new Ext.data.HttpProxy({
            url: '<?php echo $this->Html->url(array('controller' => 'employees', 'action' => 'search_emp6')); ?>'
	}),	
        sortInfo:{field: 'full_name', direction: "ASC"}
    });
      store_employee_names.load({
            params: {
                start: 0
            }
        });
    function AddEmployee() {
	Ext.Ajax.request({
            url: '<?php echo $this->Html->url(array('controller' => 'employees', 'action' => 'add')); ?>',
            success: function(response, opts) {
                var employee_data = response.responseText;
			
                eval(employee_data);
			
                EmployeeAddWindow.show();
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
    
    function ViewParentLeave(id){
            Ext.Ajax.request({
            url: '<?php echo $this->Html->url(array('controller' => 'holidays', 'action' => 'set_leave')); ?>/'+id,
            success: function(response, opts) {
                var parent_supervisors_data = response.responseText;

                eval(parent_supervisors_data);

                LeaveAddWindow.show();
            },
            failure: function(response, opts) {
                Ext.Msg.alert('<?php __('Error'); ?>', '<?php __('Cannot get the campus view form. Error code'); ?>: ' + response.status);
            }
        });
    }
  
        function ViewParentTerminate(id){
            Ext.Ajax.request({
            url: '<?php echo $this->Html->url(array('controller' => 'terminations', 'action' => 'add')); ?>/'+id,
            success: function(response, opts) {
                if(response.responseText=="terminated"){
                    alert("Employee Already Terminated");
                }else{
                    var parent_terminations_data = response.responseText;

                    eval(parent_terminations_data);

                    TerminationAddWindow.show();
                }
            },
            failure: function(response,opts){
			Ext.Msg.alert('<?php __('Error'); ?>', '<?php __('Cannot get the campus view form. Error code'); ?>: ' + response.status);
						}
        });
    }
    

    
    
       function Viewmessage(){
            Ext.Ajax.request({
            url: '<?php echo $this->Html->url(array('controller' => 'employees', 'action' => 'message')); ?>',
            success: function(response, opts) {

                    var parent_terminations_data = response.responseText;

                    eval(parent_terminations_data);

                    MessageAddWindow.show();
          
            },
            failure: function(response,opts){
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

    function RefreshEmployeeData() {
        store_employees.reload();
    }
function ViewLeaveReport(id){
		window.open("<?php echo $this->Html->url(array('controller' => 'Holidays', 'action' => 'leavereport')); ?>/"+id);
	}
    function showMenu(grid, index, event) {
        event.stopEvent();
        var record = grid.getStore().getAt(index);
        var btnStatus = 0; //(record.get('rejectable') == 'True')? false: true;
        var menu = new Ext.menu.Menu({
            items: [
                {
                    text: '<b>Details of ' + record.get('employee_name') + '</b>',
                    icon: 'img/table_add.png',
                    handler: function() {
                        ViewEmployee(record.get('id'));
                    }
                }, '-', {
                    text: 'Experience (' + record.get('experience') + ')',
                    handler: function() {
                        ViewParentExperiences(record.get('id'));
                    },
                    disabled: btnStatus
                }, {
                    text: 'Education (' + record.get('education') + ')',
                    handler: function() {
                        ViewParentEducations(record.get('id'));
                    },
                    disabled: btnStatus
                }, {
                    text: 'Children (' + record.get('children') + ')',
                    handler: function() {
                        ViewParentOffsprings(record.get('id'));
                    },
                    disabled: btnStatus
                }, {
                    text: 'Language Proficiency (' + record.get('language') + ')',
                    handler: function() {
                        ViewParentLanguages(record.get('id'));
                    },
                    disabled: btnStatus
                }, {
                    text: 'Supervisor',
                    handler: function() {
                        ViewParentSupervisor(record.get('id'));
                    }
                },{
                    text: 'Employment History (' + record.get('EmployeeDetail') + ')',
                    handler: function() {
                        ViewParentHistory(record.get('id'));
                    }
                },{
                    text: 'Payroll',
                    handler: function() {
                        ViewParentPayrollEmployee(record.get('id'));
                    }
                },{
                    text: 'Terminate',
                    handler: function() {
                        ViewParentTerminate(record.get('id'));
                    }
                },{
                    text: 'Set Annual Leave',
                    handler: function() {
                        ViewParentLeave(record.get('id'));
                    }
                },{
                    text: 'Leave Summary',
                    handler: function() {
                        ViewLeaveReport(record.get('id'));
                    }
                }
            ]
        }).showAt(event.xy);
    }

    if(center_panel.find('id', 'employee-tab') != "") {
        var p = center_panel.findById('employee-tab');
        center_panel.setActiveTab(p);
    } else {
        var p = center_panel.add({
            title: '<?php __('Employees'); ?>',
            closable: true,
            loadMask: true,
            stripeRows: true,
            id: 'employee-tab',
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
                celldblclick: function(){
                    ViewEmployee(Ext.getCmp('employee-tab').getSelectionModel().getSelected().data.id);
                },
                'rowcontextmenu': function(grid, index, event) {
                    showMenu(grid, index, event);
                        //grid.selectedNode = grid.store.getAt(row); // we need this
                        //if((index) !== false) {
                        this.getSelectionModel().selectRow(index);
                        //}
                }  
            },
            sm: new Ext.grid.RowSelectionModel({
                singleSelect: false
            }),
            tbar: new Ext.Toolbar({
			
                items: [{
                        xtype: 'tbbutton',
                        text: '<?php __('Add'); ?>',
                        tooltip:'<?php __('<b>Add Employees</b><br />Click here to create a new Employee'); ?>',
                        icon: 'img/table_add.png',
                        cls: 'x-btn-text-icon',
						disabled: true,
                        handler: function(btn) {
                            AddEmployee();
                        }
                        }, ' ', '-', ' ', {
                        xtype: 'tbbutton',
                        text: '<?php __('Edit'); ?>',
                        id: 'edit-employee',
                        tooltip:'<?php __('<b>Edit Employees</b><br />Click here to modify the selected Employee'); ?>',
                        icon: 'img/table_edit.png',
                        cls: 'x-btn-text-icon',
                        disabled: true,
                        handler: function(btn) {
                            var sm = p.getSelectionModel();
                            var sel = sm.getSelected();
                            if (sm.hasSelection()){
                                EditEmployee(sel.data.id);
                            };
                        }
                    },' ', '-', ' ', {
                        xtype: 'tbbutton',
                        text: '<?php __('Delete'); ?>',
                        id: 'delete-employee',
                        tooltip:'<?php __('<b>Delete Employees</b><br />Click here to modify the selected Employee'); ?>',
                        icon: 'img/table_delete.png',
                        cls: 'x-btn-text-icon',
                        disabled: true,
                        handler: function(btn) {
                            var sm = p.getSelectionModel();
                            var sel = sm.getSelected();
                            if (sm.hasSelection()){
                                Ext.Msg.show({
                                            title: '<?php __('Remove Employee'); ?>',
                                            buttons: Ext.MessageBox.YESNOCANCEL,
                                            msg: '<?php __('Remove the selected Employee'); ?>?',
                                            icon: Ext.MessageBox.QUESTION,
                                                fn: function(btn){
                                                        if (btn == 'yes'){
                                                                  DeleteEmployee(sel.data.id);      
                                                        }
                                                    }
                                            });
                            };
                        }
                    },' ', '-', ' ',{
                        xtype: 'combo',
                        name: 'data[Person][full_name]',
                        emptyText: 'All',
                        id: 'emp_full_name',
                        name: 'data[Person][full_name]',
                        store : store_employee_names,
                        displayField : 'full_name',
                        valueField : 'full_name',
                        fieldLabel: 'Full Name',
                        mode: 'local',
                        disableKeyFilter : true,
                        emptyText: '',
                        editable: true,
                        triggerAction: 'all',
                        hideTrigger:true,
                        width:155
                                    },
                          {
                        xtype: 'tbbutton',
                        icon: 'img/search.png',
                        cls: 'x-btn-text-icon',
                        text: '<?php __('Go'); ?>',
                        tooltip:'<?php __('<b>Search Employees</b><br />Click here to get search results'); ?>',
                        id: 'employee_go_button',
                        handler: function(){
                           SearchByEmployeeName(Ext.getCmp('emp_full_name').getValue());
                        }
                    },{
                        xtype: 'tbbutton',
                        text: '<?php __('Send Message'); ?>',
                        tooltip:'<?php __('<b>Send Message to All Employees</b><br />Click here'); ?>',
                        cls: 'x-btn-text-icon',
                        handler: function(btn) {
                              Viewmessage();
                        }
                        }, '->', '-', {
                        xtype: 'tbbutton',
                        icon: 'img/table_search.png',
                        cls: 'x-btn-text-icon',
                        text: '<?php __('Advanced Search'); ?>',
                        tooltip:'<?php __('<b>Advanced Search...</b><br />Click here to get the advanced search form'); ?>',
                        handler: function(){
                            SearchEmployee();
                        }
                    }
                ]}),
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
        p.getSelectionModel().on('rowselect', function(sm, rowIdx, r) {
		//p.getTopToolbar().findById('edit-employee').enable();
		//p.getTopToolbar().findById('delete-employee').enable();
		if(this.getSelections().length > 1){
			p.getTopToolbar().findById('edit-employee').disable();
		}
	});
	p.getSelectionModel().on('rowdeselect', function(sm, rowIdx, r) {
		if(this.getSelections().length > 1){
			//p.getTopToolbar().findById('edit-employee').disable();
			//p.getTopToolbar().findById('delete-employee').enable();
		}
		else if(this.getSelections().length == 1){
			//p.getTopToolbar().findById('edit-employee').enable();
			//p.getTopToolbar().findById('delete-employee').enable();
		}
		else{
			p.getTopToolbar().findById('edit-employee').disable();
			p.getTopToolbar().findById('delete-employee').disable();
		}
	});
        center_panel.setActiveTab(p);
	
       
	
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