//<script>
    var store_employees = new Ext.data.GroupingStore({
	reader: new Ext.data.JsonReader({
            root:'rows',
            totalProperty: 'results',
            fields: [
                'id', 'employee_name', 'identification_card_number',
                 'phone','photo','Position','Branch','Branch_Phone','Sex','current_status'
                ]
	}),
	proxy: new Ext.data.HttpProxy({
            url: '<?php echo $this->Html->url(array('controller' => 'employees', 'action' => 'list_data_directory')); ?>'
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
            url: '<?php echo $this->Html->url(array('controller' => 'employees', 'action' => 'search_emp2')); ?>'
	}),	
        sortInfo:{field: 'full_name', direction: "ASC"}
    });
      store_employee_names.load({
            params: {
                start: 0
            }
        });

     var store_employee_branch = new Ext.data.GroupingStore({
    reader: new Ext.data.JsonReader({
            root:'rows',
            totalProperty: 'results',
            fields: [
                'id', 'full_name'      
            ]
    }),
    proxy: new Ext.data.HttpProxy({
            url: '<?php echo $this->Html->url(array('controller' => 'employees', 'action' => 'search_branch')); ?>'
    }),    
        sortInfo:{field: 'full_name', direction: "ASC"}
    });
      store_employee_branch.load({
            params: {
                start: 0
            }
        });

        var store_employee_position = new Ext.data.GroupingStore({
    reader: new Ext.data.JsonReader({
            root:'rows',
            totalProperty: 'results',
            fields: [
                'id', 'full_name'      
            ]
    }),
    proxy: new Ext.data.HttpProxy({
            url: '<?php echo $this->Html->url(array('controller' => 'employees', 'action' => 'search_position')); ?>'
    }),    
        sortInfo:{field: 'full_name', direction: "ASC"}
    });
      store_employee_position.load({
            params: {
                start: 0
            }
        });
    /*   store_employees.load({
            params: {
                start: 0
            }
        });*/

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
            url: '<?php echo $this->Html->url(array('controller' => 'employees', 'action' => 'view_directory')); ?>/'+id,
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

	function ViewParentPerformance(id){
	             Ext.Ajax.request({
            url: '<?php echo $this->Html->url(array('controller' => 'performance_results', 'action' => 'index2')); ?>/'+id,
            success: function(response, opts) {
                var parent_loans_data = response.responseText;

                eval(parent_loans_data);

                parentPerformanceResultsViewWindow.show();
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
    function SearchByEmployeeName(searchBy,value){
     
     if(searchBy==1){
       var list=  value.split(" ");
       var c="AND ";
       for (var i=0; i<list.length; i++) {
            if(i==0){
             c+='\e.`First Name` LIKE \'%' + list[i] + '%\' ';
            }if(i==1){
                c+=' AND e.`Middle Name` LIKE \'%' + list[i] + '%\' ';
            }if(i==2){
                 c+=' AND e.`Last Name` LIKE \'%' + list[i] + '%\' ';
            }
       }
	  var conditions = c;
     }else if(searchBy==2){
     var conditions = ' AND ve.Branch LIKE \'%' + value + '%\'';
     }else if(searchBy==3){
     var conditions = ' AND ve.Position LIKE \'%' + value + '%\'';
     }

	store_employees.reload({
            params: {
                start: 0,
                limit: list_size,
                conditions: conditions
	    }
	});
    }

    function SearchFilter(searchBy,value,filter){
     
     if(searchBy==1){
       var list=  value.split(" ");
       var c="AND ";
       for (var i=0; i<list.length; i++) {
            if(i==0){
             c+='\e.`First Name` LIKE \'%' + list[i] + '%\' ';
            }if(i==1){
                c+=' AND e.`Middle Name` LIKE \'%' + list[i] + '%\' ';
            }if(i==2){
                 c+=' AND e.`Last Name` LIKE \'%' + list[i] + '%\' ';
            }
       }
      var conditions = c;
     }else if(searchBy==2){
     var conditions = ' AND ve.Branch LIKE \'%' + value + '%\'';
     }else if(searchBy==3){
     var conditions = ' AND ve.Position LIKE \'%' + value + '%\'';
     }




       var cc=" AND (ve.Branch like '%"+filter+"%'  or e.Telephone like '%"+filter+"%' or  e.`First Name` like '%"+filter+"%' or  e.`Middle Name` like '%"+filter+"%' or  e.`Last Name` like '%"+filter+"%'  or ve.Position like '%"+filter+"%')";
       conditions+=cc;

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
                }
                
            ]
        }).showAt(event.xy);
    }

    if(center_panel.find('id', 'employee-search-tab') != "") {
        var p = center_panel.findById('employee-search-tab');
        center_panel.setActiveTab(p);
    } else {
        var p = center_panel.add({
            title: '<?php __('Employees Directory'); ?>',
            closable: true,
            loadMask: true,
            stripeRows: true,
            id: 'employee-search-tab',
            xtype: 'grid',
            store: store_employees,
            columns: [
                {
                 header: "<?php __(' '); ?>", 
                 dataIndex: 'photo', 
                 sortable: true,
                 renderer:function(value){
                     
                      return '<img src="img/employee_photos/'+ value +'" width="75" height="75" borer="0" />'; 
                    
                 }
               },
                {header: "<?php __('Employee Name'); ?>", dataIndex: 'employee_name', sortable: true},
               // {header: "<?php __('Identification Card Number'); ?>", dataIndex: 'identification_card_number', sortable: true},
                {header: "<?php __('Phone'); ?>", dataIndex: 'phone', sortable: true},
                {header: "<?php __('Position'); ?>", dataIndex: 'Position', sortable: true},
                {header: "<?php __('Branch'); ?>", dataIndex: 'Branch', sortable: true},
                {header: "<?php __('Branch Telephone'); ?>", dataIndex: 'Branch_Phone', sortable: true},
                {header: "<?php __('Current Status'); ?>",   dataIndex: 'current_status', sortable: true},
            ],
            view: new Ext.grid.GroupingView({
                forceFit:true,
                groupTextTpl: '{text} ({[values.rs.length]} {[values.rs.length > 1 ? "Employees" : "Employee"]})'
            }),
            listeners: {
                celldblclick: function(){
                    //ViewEmployee(Ext.getCmp('employee-search-tab').getSelectionModel().getSelected().data.id);
                },
                'rowcontextmenu': function(grid, index, event) {
                    //showMenu(grid, index, event);
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
			
                items: [' ', '-','<?php __('Search By'); ?>:',{
                        xtype: 'combo',
                        typeAhead: true,
                        id:'emp_search_by',
                        triggerAction: 'all',
                        lazyRender:true,
                        mode: 'local',
                        store: new Ext.data.ArrayStore({
                            id: 0,
                            fields: [
                                'Id',
                                'Text'
                            ],
                            data: [[1, 'Employee Name'], [2, 'Branch'],[3,'Position']]
                        }),
                        value:1,
                        valueField: 'Id',
                        displayField: 'Text',
                        width:155,
                        listeners: {
                            change:function(t,nV,oV){
                                if(nV==1){
                               
                                Ext.getCmp('emp_full_name').bindStore(store_employee_names);
                                //Ext.getCmp('emp_full_name').store.reload();
                               }if(nV==2){
                              
                                Ext.getCmp('emp_full_name').bindStore(store_employee_branch);
                               // Ext.getCmp('emp_full_name').store.reload();
                               }  if(nV==3){
                               
                                Ext.getCmp('emp_full_name').bindStore(store_employee_position);
                               // Ext.getCmp('emp_full_name').store.reload();
                               }
                            }
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
                        width:155,
                        enableKeyEvents:true,
                        anyMatch:true,
                        doQuery : function(q, forceAll){
                        
                        if(q === undefined || q === null){
                            q = '';
                        }
                        var qe = {
                            query: q,
                            forceAll: forceAll,
                            combo: this,
                            cancel:false
                        };
                        if(this.fireEvent('beforequery', qe)===false || qe.cancel){
                            return false;
                        }
                        q = qe.query;
                        forceAll = qe.forceAll;
                        if(forceAll === true || (q.length >= this.minChars)){
                            if(this.lastQuery !== q){
                                this.lastQuery = q;
                                if(this.mode == 'local'){
                                    this.selectedIndex = -1;
                                    if(forceAll){
                                        this.store.clearFilter();
                                    }else{
                            this.store.filter(this.displayField, q, this.anyMatch);
                                    }
                                    this.onLoad();
                                }else{
                                    this.store.baseParams[this.queryParam] = q;
                                    this.store.load({
                                        params: this.getParams(q)
                                    });
                                    this.expand();
                                }
                            }else{
                                this.selectedIndex = -1;
                                this.onLoad();
                            }
                        }
                    },
                        listeners: {
                            keyup: function(thisField, e) {
                               if(e.target.value.length>0){
                              Ext.getCmp('filter_search').show();
                               Ext.getCmp('filter_search').enable();
                              Ext.getCmp('filter_search_label').show();
                             
                               }else{
                            //  Ext.getCmp('filter_search').hide();
                               Ext.getCmp('filter_search').disable();
                             // Ext.getCmp('filter_search_label').hide();
                              
                               }
                              
                             },
                             select:function(c,r,i){
                                 //console.log(r);
                               //Ext.Msg.alert('',r.full_name);
                                 SearchByEmployeeName(Ext.getCmp('emp_search_by').getValue(),r.data.full_name);
                             }

                        }
                        },{
                        xtype: 'tbbutton',
                        icon: 'img/search.png',
                        cls: 'x-btn-text-icon',
                        text: '<?php __('Go'); ?>',
                        tooltip:'<?php __('<b>Search Employees</b><br />Click here to get search results'); ?>',
                        id: 'employee_go_button',
                        hidden:true,
                        handler: function(){
                           SearchByEmployeeName(Ext.getCmp('emp_search_by').getValue(),Ext.getCmp('emp_full_name').getValue());
                        }
                    },'','->','',{
                            xtype:'tbbutton',
                            text:'Filter Result:',
                            id:'filter_search_btn',
                           text: '<?php __('Filter'); ?>',
                            handler: function(thisField, e) {
                                SearchFilter(Ext.getCmp('emp_search_by').getValue(),Ext.getCmp('emp_full_name').getValue(),Ext.getCmp('filter_search').getValue());//
                               //  console.log(e.target.value);
                             }
                        
                        },' ', '->',' ',{
                        xtype: 'textfield',
                        fieldLabel:'Filter Result',
                        name: 'data[Person][full_name]',
                        id: 'filter_search',
                        emptyText:'Filter By Any Filed',
                        disableKeyFilter : true,
                        editable: true,
                        triggerAction: 'all',
                        hideTrigger:true,
                        width:155,
                        hidden:true,
                        disabled:true,
                        enableKeyEvents:true,
                        listeners: {
                            keyup: function(thisField, e) {
                                //SearchFilter(Ext.getCmp('emp_search_by').getValue(),Ext.getCmp('emp_full_name').getValue(),e.target.value);//
                               //  console.log(e.target.value);
                             }
                        }
                        },'','->','',{
                            xtype:'label',
                            text:'Filter Result:',
                            style:{color:'blue',textStyle:'bold'},
                            id:'filter_search_label',
                            hidden:true
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
		p.getTopToolbar().findById('edit-employee').enable();
		//p.getTopToolbar().findById('delete-employee').enable();
		if(this.getSelections().length > 1){
			p.getTopToolbar().findById('edit-employee').disable();
		}
	});

	p.getSelectionModel().on('rowdeselect', function(sm, rowIdx, r) {
		if(this.getSelections().length > 1){
			p.getTopToolbar().findById('edit-employee').disable();
			//p.getTopToolbar().findById('delete-employee').enable();
		}
		else if(this.getSelections().length == 1){
			p.getTopToolbar().findById('edit-employee').enable();
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


