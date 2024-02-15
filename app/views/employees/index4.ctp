
    var store_employees = new Ext.data.GroupingStore({
	reader: new Ext.data.JsonReader({
            root:'rows',
            totalProperty: 'results',
            fields: [
                'id','user_id', 'employee_name', 'identification_card_number',
                'date_of_employment','terms_of_employment',
                'experience', 'education', 'children','language','EmployeeDetail', 'created'		
                ]
	}),
	proxy: new Ext.data.HttpProxy({
            url: '<?php echo $this->Html->url(array('controller' => 'employees', 'action' => 'list_data4')); ?>'
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
            url: '<?php echo $this->Html->url(array('controller' => 'employees', 'action' => 'search_emp')); ?>'
	}),	
        sortInfo:{field: 'full_name', direction: "ASC"}
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
    
    function ViewParentPerformance(id){
              Ext.Ajax.request({
            url: '<?php echo $this->Html->url(array('controller' => 'employee_performances', 'action' => 'index2')); ?>/'+id,
            success: function(response, opts) {
                var parent_performance_data = response.responseText;

                eval(parent_performance_data);

                parentEmployeePerformancesViewWindow.show();
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
                                text: 'Performance - Add/View',
                                handler: function() {
                                    ViewParentPerformance(record.get('id'));
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
                /*,{
                    text: 'Print Experience',
                    handler: function() {
      	window.open("http://10.1.85.10:8080/iportal/frameset?__report=C%3A%5CUsers%5CAdministrator%5CWorkspace%5CBIRT+Project%5CReport+Designs%5Cemp_experiance.rptdesign&__format=html&__svg=true&__locale=en_US&__timezone=EAT&__masterpage=true&__rtl=false&__cubememsize=10&__resourceFolder=C%3A%5CUsers%5CAdministrator%5CWorkspace%5CBIRT+Project&-1522063402&user_id="+record.get('user_id'), "_blank"); 
                    }
                } */
                       
             
            ]
        }).showAt(event.xy);
    }

    if(center_panel.find('id', 'employeep-tab') != "") {
        var p = center_panel.findById('employeep-tab');
        center_panel.setActiveTab(p);
    } else {
        var p = center_panel.add({
            title: '<?php __('Employees/Supervisor'); ?>',
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
            bbar: new Ext.PagingToolbar({
                pageSize: 500,
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
                limit: 500
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