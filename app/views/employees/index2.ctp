var store_parent_employees = new Ext.data.Store({
	reader: new Ext.data.JsonReader({
		root:'rows',
		totalProperty: 'results',
		fields: [
			'id','mother_name','location','city','kebele','woreda','house_no','p_o_box','telephone','marital_status','spouse_name','identification_card_number','date_of_employment','terms_of_employment','photo','contact_name','contact_region','contact_city','contact_kebele','contact_house_no','contact_residence_tel','contact_office_tel','contact_mobile','contact_email','contact_p_o_box','user','created','modified'	
		]
	}),
	proxy: new Ext.data.HttpProxy({
		url: '<?php echo $this->Html->url(array('controller' => 'employees', 'action' => 'list_data', $parent_id)); ?>'	})
});


function AddParentEmployee() {
	Ext.Ajax.request({
		url: '<?php echo $this->Html->url(array('controller' => 'employees', 'action' => 'add', $parent_id)); ?>',
		success: function(response, opts) {
			var parent_employee_data = response.responseText;
			
			eval(parent_employee_data);
			
			EmployeeAddWindow.show();
		},
		failure: function(response, opts) {
			Ext.Msg.alert('<?php __('Error'); ?>', '<?php __('Cannot get the employee add form. Error code'); ?>: ' + response.status);
		}
	});
}

function EditParentEmployee(id) {
	Ext.Ajax.request({
		url: '<?php echo $this->Html->url(array('controller' => 'employees', 'action' => 'edit')); ?>/'+id+'/<?php echo $parent_id; ?>',
		success: function(response, opts) {
			var parent_employee_data = response.responseText;
			
			eval(parent_employee_data);
			
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

function ViewEmployeeEducations(id) {
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

function ViewEmployeeEmployeeDetails(id) {
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

function ViewEmployeeExperiences(id) {
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

function ViewEmployeeLanguages(id) {
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

function ViewEmployeeOffsprings(id) {
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


function DeleteParentEmployee(id) {
	Ext.Ajax.request({
		url: '<?php echo $this->Html->url(array('controller' => 'employees', 'action' => 'delete')); ?>/'+id,
		success: function(response, opts) {
			Ext.Msg.alert('<?php __('Success'); ?>', '<?php __('Employee(s) successfully deleted!'); ?>');
			RefreshParentEmployeeData();
		},
		failure: function(response, opts) {
			Ext.Msg.alert('<?php __('Error'); ?>', '<?php __('Cannot get the employee to be deleted. Error code'); ?>: ' + response.status);
		}
	});
}

function SearchByParentEmployeeName(value){
	var conditions = '\'Employee.name LIKE\' => \'%' + value + '%\'';
	store_parent_employees.reload({
		 params: {
			start: 0,
			limit: list_size,
			conditions: conditions
	    }
	});
}

function RefreshParentEmployeeData() {
	store_parent_employees.reload();
}



var g = new Ext.grid.GridPanel({
	title: '<?php __('Employees'); ?>',
	store: store_parent_employees,
	loadMask: true,
	stripeRows: true,
	height: 300,
	anchor: '100%',
    id: 'employeeGrid',
	columns: [
		{header: "<?php __('Mother Name'); ?>", dataIndex: 'mother_name', sortable: true},
		{header:"<?php __('location'); ?>", dataIndex: 'location', sortable: true},
		{header: "<?php __('City'); ?>", dataIndex: 'city', sortable: true},
		{header: "<?php __('Kebele'); ?>", dataIndex: 'kebele', sortable: true},
		{header: "<?php __('Woreda'); ?>", dataIndex: 'woreda', sortable: true},
		{header: "<?php __('House No'); ?>", dataIndex: 'house_no', sortable: true},
		{header: "<?php __('P O Box'); ?>", dataIndex: 'p_o_box', sortable: true},
		{header: "<?php __('Telephone'); ?>", dataIndex: 'telephone', sortable: true},
		{header: "<?php __('Marital Status'); ?>", dataIndex: 'marital_status', sortable: true},
		{header: "<?php __('Spouse Name'); ?>", dataIndex: 'spouse_name', sortable: true},
		{header: "<?php __('Identification Card Number'); ?>", dataIndex: 'identification_card_number', sortable: true},
		{header: "<?php __('Date Of Employment'); ?>", dataIndex: 'date_of_employment', sortable: true},
		{header: "<?php __('Terms Of Employment'); ?>", dataIndex: 'terms_of_employment', sortable: true},
		{header: "<?php __('Photo'); ?>", dataIndex: 'photo', sortable: true},
		{header: "<?php __('Contact Name'); ?>", dataIndex: 'contact_name', sortable: true},
		{header: "<?php __('Contact Region'); ?>", dataIndex: 'contact_region', sortable: true},
		{header: "<?php __('Contact City'); ?>", dataIndex: 'contact_city', sortable: true},
		{header: "<?php __('Contact Kebele'); ?>", dataIndex: 'contact_kebele', sortable: true},
		{header: "<?php __('Contact House No'); ?>", dataIndex: 'contact_house_no', sortable: true},
		{header: "<?php __('Contact Residence Tel'); ?>", dataIndex: 'contact_residence_tel', sortable: true},
		{header: "<?php __('Contact Office Tel'); ?>", dataIndex: 'contact_office_tel', sortable: true},
		{header: "<?php __('Contact Mobile'); ?>", dataIndex: 'contact_mobile', sortable: true},
		{header: "<?php __('Contact Email'); ?>", dataIndex: 'contact_email', sortable: true},
		{header: "<?php __('Contact P O Box'); ?>", dataIndex: 'contact_p_o_box', sortable: true},
		{header:"<?php __('user'); ?>", dataIndex: 'user', sortable: true},
		{header: "<?php __('Created'); ?>", dataIndex: 'created', sortable: true},
		{header: "<?php __('Modified'); ?>", dataIndex: 'modified', sortable: true}	],
	sm: new Ext.grid.RowSelectionModel({
		singleSelect: false
	}),
	viewConfig: {
		forceFit: true
	},
    listeners: {
        celldblclick: function(){
            ViewEmployee(Ext.getCmp('employeeGrid').getSelectionModel().getSelected().data.id);
        }
    },
	tbar: new Ext.Toolbar({
		items: [{
				xtype: 'tbbutton',
				text: '<?php __('Add'); ?>',
				tooltip:'<?php __('<b>Add Employee</b><br />Click here to create a new Employee'); ?>',
				icon: 'img/table_add.png',
				cls: 'x-btn-text-icon',
				handler: function(btn) {
					AddParentEmployee();
				}
			}, ' ', '-', ' ', {
				xtype: 'tbbutton',
				text: '<?php __('Edit'); ?>',
				id: 'edit-parent-employee',
				tooltip:'<?php __('<b>Edit Employee</b><br />Click here to modify the selected Employee'); ?>',
				icon: 'img/table_edit.png',
				cls: 'x-btn-text-icon',
				disabled: true,
				handler: function(btn) {
					var sm = g.getSelectionModel();
					var sel = sm.getSelected();
					if (sm.hasSelection()){
						EditParentEmployee(sel.data.id);
					};
				}
			}, ' ', '-', ' ', {
				xtype: 'tbbutton',
				text: '<?php __('Delete'); ?>',
				id: 'delete-parent-employee',
				tooltip:'<?php __('<b>Delete Employee(s)</b><br />Click here to remove the selected Employee(s)'); ?>',
				icon: 'img/table_delete.png',
				cls: 'x-btn-text-icon',
				disabled: true,
				handler: function(btn) {
					var sm = g.getSelectionModel();
					var sel = sm.getSelections();
					if (sm.hasSelection()){
						if(sel.length==1){
							Ext.Msg.show({
									title: '<?php __('Remove Employee'); ?>',
									buttons: Ext.MessageBox.YESNOCANCEL,
									msg: '<?php __('Remove'); ?> '+sel[0].data.name+'?',
									icon: Ext.MessageBox.QUESTION,
                                    fn: function(btn){
											if (btn == 'yes'){
													DeleteParentEmployee(sel[0].data.id);
											}
									}
							});
						} else {
							Ext.Msg.show({
									title: '<?php __('Remove Employee'); ?>',
									buttons: Ext.MessageBox.YESNOCANCEL,
									msg: '<?php __('Remove the selected Employee'); ?>?',
									icon: Ext.MessageBox.QUESTION,
                                    fn: function(btn){
											if (btn == 'yes'){
													var sel_ids = '';
													for(i=0;i<sel.length;i++){
														if(i>0)
															sel_ids += '_';
														sel_ids += sel[i].data.id;
													}
													DeleteParentEmployee(sel_ids);
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
				text: '<?php __('View Employee'); ?>',
				id: 'view-employee2',
				tooltip:'<?php __('<b>View Employee</b><br />Click here to see details of the selected Employee'); ?>',
				icon: 'img/table_view.png',
				cls: 'x-btn-text-icon',
				disabled: true,
				handler: function(btn) {
					var sm = g.getSelectionModel();
					var sel = sm.getSelected();
					if (sm.hasSelection()){
						ViewEmployee(sel.data.id);
					};
				},
				menu : {
					items: [
 {
						text: '<?php __('View Educations'); ?>',
                        icon: 'img/table_view.png',
						cls: 'x-btn-text-icon',
						handler: function(btn) {
							var sm = g.getSelectionModel();
							var sel = sm.getSelected();
							if (sm.hasSelection()){
								ViewEmployeeEducations(sel.data.id);
							};
						}
					}
, {
						text: '<?php __('View Employee Details'); ?>',
                        icon: 'img/table_view.png',
						cls: 'x-btn-text-icon',
						handler: function(btn) {
							var sm = g.getSelectionModel();
							var sel = sm.getSelected();
							if (sm.hasSelection()){
								ViewEmployeeEmployeeDetails(sel.data.id);
							};
						}
					}
, {
						text: '<?php __('View Experiences'); ?>',
                        icon: 'img/table_view.png',
						cls: 'x-btn-text-icon',
						handler: function(btn) {
							var sm = g.getSelectionModel();
							var sel = sm.getSelected();
							if (sm.hasSelection()){
								ViewEmployeeExperiences(sel.data.id);
							};
						}
					}
, {
						text: '<?php __('View Languages'); ?>',
                        icon: 'img/table_view.png',
						cls: 'x-btn-text-icon',
						handler: function(btn) {
							var sm = g.getSelectionModel();
							var sel = sm.getSelected();
							if (sm.hasSelection()){
								ViewEmployeeLanguages(sel.data.id);
							};
						}
					}
, {
						text: '<?php __('View Offsprings'); ?>',
                        icon: 'img/table_view.png',
						cls: 'x-btn-text-icon',
						handler: function(btn) {
							var sm = g.getSelectionModel();
							var sel = sm.getSelected();
							if (sm.hasSelection()){
								ViewEmployeeOffsprings(sel.data.id);
							};
						}
					}
					]
				}

            }, ' ', '->', {
				xtype: 'textfield',
				emptyText: '<?php __('[Search By Name]'); ?>',
				id: 'parent_employee_search_field',
				listeners: {
					specialkey: function(field, e){
						if (e.getKey() == e.ENTER) {
							SearchByParentEmployeeName(Ext.getCmp('parent_employee_search_field').getValue());
						}
					}

				}
			}, {
				xtype: 'tbbutton',
				icon: 'img/search.png',
				cls: 'x-btn-text-icon',
				text: 'GO',
				tooltip:'<?php __('<b>GO</b><br />Click here to get search results'); ?>',
				id: 'parent_employee_go_button',
				handler: function(){
					SearchByParentEmployeeName(Ext.getCmp('parent_employee_search_field').getValue());
				}
			}, ' '
	]}),
	bbar: new Ext.PagingToolbar({
		pageSize: list_size,
		store: store_parent_employees,
		displayInfo: true,
		displayMsg: '<?php __('Displaying {0} - {1} of {2}'); ?>',
		beforePageText: '<?php __('Page'); ?>',
		afterPageText: '<?php __('of {0}'); ?>',
		emptyMsg: '<?php __('No data to display'); ?>'
	})
});
g.getSelectionModel().on('rowselect', function(sm, rowIdx, r) {
	g.getTopToolbar().findById('edit-parent-employee').enable();
	g.getTopToolbar().findById('delete-parent-employee').enable();
        g.getTopToolbar().findById('view-employee2').enable();
	if(this.getSelections().length > 1){
		g.getTopToolbar().findById('edit-parent-employee').disable();
                g.getTopToolbar().findById('view-employee2').disable();
	}
});
g.getSelectionModel().on('rowdeselect', function(sm, rowIdx, r) {
	if(this.getSelections().length > 1){
		g.getTopToolbar().findById('edit-parent-employee').disable();
		g.getTopToolbar().findById('delete-parent-employee').enable();
                g.getTopToolbar().findById('view-employee2').disable();
	}
	else if(this.getSelections().length == 1){
		g.getTopToolbar().findById('edit-parent-employee').enable();
		g.getTopToolbar().findById('delete-parent-employee').enable();
                g.getTopToolbar().findById('view-employee2').enable();
	}
	else{
		g.getTopToolbar().findById('edit-parent-employee').disable();
		g.getTopToolbar().findById('delete-parent-employee').disable();
                g.getTopToolbar().findById('view-employee2').disable();
	}
});



var parentEmployeesViewWindow = new Ext.Window({
	title: 'Employee Under the selected Item',
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
			parentEmployeesViewWindow.close();
		}
	}]
});

store_parent_employees.load({
    params: {
        start: 0,    
        limit: list_size
    }
});