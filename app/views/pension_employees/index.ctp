
var store_pensionEmployees = new Ext.data.GroupingStore({
	reader: new Ext.data.JsonReader({
		root:'rows',
		totalProperty: 'results',
		fields: [
			'id','pension','employee'		]
	}),
	proxy: new Ext.data.HttpProxy({
		url: '<?php echo $this->Html->url(array('controller' => 'pensionEmployees', 'action' => 'list_data')); ?>'
	})
,	sortInfo:{field: 'pension_id', direction: "ASC"},
	groupField: 'employee_id'
});


function AddPensionEmployee() {
	Ext.Ajax.request({
		url: '<?php echo $this->Html->url(array('controller' => 'pensionEmployees', 'action' => 'add')); ?>',
		success: function(response, opts) {
			var pensionEmployee_data = response.responseText;
			
			eval(pensionEmployee_data);
			
			PensionEmployeeAddWindow.show();
		},
		failure: function(response, opts) {
			Ext.Msg.alert('<?php __('Error'); ?>', '<?php __('Cannot get the pensionEmployee add form. Error code'); ?>: ' + response.status);
		}
	});
}

function EditPensionEmployee(id) {
	Ext.Ajax.request({
		url: '<?php echo $this->Html->url(array('controller' => 'pensionEmployees', 'action' => 'edit')); ?>/'+id,
		success: function(response, opts) {
			var pensionEmployee_data = response.responseText;
			
			eval(pensionEmployee_data);
			
			PensionEmployeeEditWindow.show();
		},
		failure: function(response, opts) {
			Ext.Msg.alert('<?php __('Error'); ?>', '<?php __('Cannot get the pensionEmployee edit form. Error code'); ?>: ' + response.status);
		}
	});
}

function ViewPensionEmployee(id) {
    Ext.Ajax.request({
        url: '<?php echo $this->Html->url(array('controller' => 'pensionEmployees', 'action' => 'view')); ?>/'+id,
        success: function(response, opts) {
            var pensionEmployee_data = response.responseText;

            eval(pensionEmployee_data);

            PensionEmployeeViewWindow.show();
        },
        failure: function(response, opts) {
            Ext.Msg.alert('<?php __('Error'); ?>', '<?php __('Cannot get the pensionEmployee view form. Error code'); ?>: ' + response.status);
        }
    });
}

function DeletePensionEmployee(id) {
	Ext.Ajax.request({
		url: '<?php echo $this->Html->url(array('controller' => 'pensionEmployees', 'action' => 'delete')); ?>/'+id,
		success: function(response, opts) {
			Ext.Msg.alert('<?php __('Success'); ?>', '<?php __('PensionEmployee successfully deleted!'); ?>');
			RefreshPensionEmployeeData();
		},
		failure: function(response, opts) {
			Ext.Msg.alert('<?php __('Error'); ?>', '<?php __('Cannot get the pensionEmployee add form. Error code'); ?>: ' + response.status);
		}
	});
}

function SearchPensionEmployee(){
	Ext.Ajax.request({
		url: '<?php echo $this->Html->url(array('controller' => 'pensionEmployees', 'action' => 'search')); ?>',
		success: function(response, opts){
			var pensionEmployee_data = response.responseText;

			eval(pensionEmployee_data);

			pensionEmployeeSearchWindow.show();
		},
		failure: function(response, opts) {
			Ext.Msg.alert('<?php __('Error'); ?>','<?php __('Cannot get the pensionEmployee search form. Error Code'); ?>: ' + response.status);
		}
	});
}

function SearchByPensionEmployeeName(value){
	var conditions = '\'PensionEmployee.name LIKE\' => \'%' + value + '%\'';
	store_pensionEmployees.reload({
		 params: {
			start: 0,
			limit: list_size,
			conditions: conditions
	    }
	});
}

function RefreshPensionEmployeeData() {
	store_pensionEmployees.reload();
}


if(center_panel.find('id', 'pensionEmployee-tab') != "") {
	var p = center_panel.findById('pensionEmployee-tab');
	center_panel.setActiveTab(p);
} else {
	var p = center_panel.add({
		title: '<?php __('Pension Employees'); ?>',
		closable: true,
		loadMask: true,
		stripeRows: true,
		id: 'pensionEmployee-tab',
		xtype: 'grid',
		store: store_pensionEmployees,
		columns: [
			{header: "<?php __('Pension'); ?>", dataIndex: 'pension', sortable: true},
			{header: "<?php __('Employee'); ?>", dataIndex: 'employee', sortable: true}
		],
		
		view: new Ext.grid.GroupingView({
            forceFit:true,
            groupTextTpl: '{text} ({[values.rs.length]} {[values.rs.length > 1 ? "PensionEmployees" : "PensionEmployee"]})'
        })
,
		listeners: {
			celldblclick: function(){
				ViewPensionEmployee(Ext.getCmp('pensionEmployee-tab').getSelectionModel().getSelected().data.id);
			}
		},
		sm: new Ext.grid.RowSelectionModel({
			singleSelect: false
		}),
		tbar: new Ext.Toolbar({
			
			items: [{
					xtype: 'tbbutton',
					text: '<?php __('Add'); ?>',
					tooltip:'<?php __('<b>Add PensionEmployees</b><br />Click here to create a new PensionEmployee'); ?>',
					icon: 'img/table_add.png',
					cls: 'x-btn-text-icon',
					handler: function(btn) {
						AddPensionEmployee();
					}
				}, ' ', '-', ' ', {
					xtype: 'tbbutton',
					text: '<?php __('Edit'); ?>',
					id: 'edit-pensionEmployee',
					tooltip:'<?php __('<b>Edit PensionEmployees</b><br />Click here to modify the selected PensionEmployee'); ?>',
					icon: 'img/table_edit.png',
					cls: 'x-btn-text-icon',
					disabled: true,
					handler: function(btn) {
						var sm = p.getSelectionModel();
						var sel = sm.getSelected();
						if (sm.hasSelection()){
							EditPensionEmployee(sel.data.id);
						};
					}
				}, ' ', '-', ' ', {
					xtype: 'tbbutton',
					text: '<?php __('Delete'); ?>',
					id: 'delete-pensionEmployee',
					tooltip:'<?php __('<b>Delete PensionEmployees(s)</b><br />Click here to remove the selected PensionEmployee(s)'); ?>',
					icon: 'img/table_delete.png',
					cls: 'x-btn-text-icon',
					disabled: true,
					handler: function(btn) {
						var sm = p.getSelectionModel();
						var sel = sm.getSelections();
						if (sm.hasSelection()){
							if(sel.length==1){
								Ext.Msg.show({
									title: '<?php __('Remove PensionEmployee'); ?>',
									buttons: Ext.MessageBox.YESNO,
									msg: '<?php __('Remove'); ?> '+sel[0].data.name+'?',
									icon: Ext.MessageBox.QUESTION,
									fn: function(btn){
										if (btn == 'yes'){
											DeletePensionEmployee(sel[0].data.id);
										}
									}
								});
							}else{
								Ext.Msg.show({
									title: '<?php __('Remove PensionEmployee'); ?>',
									buttons: Ext.MessageBox.YESNO,
									msg: '<?php __('Remove the selected PensionEmployees'); ?>?',
									icon: Ext.MessageBox.QUESTION,
									fn: function(btn){
										if (btn == 'yes'){
											var sel_ids = '';
											for(i=0;i<sel.length;i++){
												if(i>0)
													sel_ids += '_';
												sel_ids += sel[i].data.id;
											}
											DeletePensionEmployee(sel_ids);
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
					text: '<?php __('View PensionEmployee'); ?>',
					id: 'view-pensionEmployee',
					tooltip:'<?php __('<b>View PensionEmployee</b><br />Click here to see details of the selected PensionEmployee'); ?>',
					icon: 'img/table_view.png',
					cls: 'x-btn-text-icon',
					disabled: true,
					handler: function(btn) {
						var sm = p.getSelectionModel();
						var sel = sm.getSelected();
						if (sm.hasSelection()){
							ViewPensionEmployee(sel.data.id);
						};
					},
					menu : {
						items: [
						]
					}
				}, ' ', '-',  '<?php __('Pension'); ?>: ', {
					xtype : 'combo',
					emptyText: 'All',
					store : new Ext.data.ArrayStore({
						fields : ['id', 'name'],
						data : [
							['-1', 'All'],
							<?php $st = false;foreach ($pensions as $item){if($st) echo ",
							";?>['<?php echo $item['Pension']['id']; ?>' ,'<?php echo $item['Pension']['name']; ?>']<?php $st = true;}?>						]
					}),
					displayField : 'name',
					valueField : 'id',
					mode : 'local',
					value : '-1',
					disableKeyFilter : true,
					triggerAction: 'all',
					listeners : {
						select : function(combo, record, index){
							store_pensionEmployees.reload({
								params: {
									start: 0,
									limit: list_size,
									pension_id : combo.getValue()
								}
							});
						}
					}
				},
 '->', {
					xtype: 'textfield',
					emptyText: '<?php __('[Search By Name]'); ?>',
					id: 'pensionEmployee_search_field',
					listeners: {
						specialkey: function(field, e){
							if (e.getKey() == e.ENTER) {
								SearchByPensionEmployeeName(Ext.getCmp('pensionEmployee_search_field').getValue());
							}
						}
					}
				}, {
					xtype: 'tbbutton',
					icon: 'img/search.png',
					cls: 'x-btn-text-icon',
					text: '<?php __('GO'); ?>',
                    tooltip:'<?php __('<b>GO</b><br />Click here to get search results'); ?>',
					id: 'pensionEmployee_go_button',
					handler: function(){
						SearchByPensionEmployeeName(Ext.getCmp('pensionEmployee_search_field').getValue());
					}
				}, '-', {
					xtype: 'tbbutton',
					icon: 'img/table_search.png',
					cls: 'x-btn-text-icon',
					text: '<?php __('Advanced Search'); ?>',
                    tooltip:'<?php __('<b>Advanced Search...</b><br />Click here to get the advanced search form'); ?>',
					handler: function(){
						SearchPensionEmployee();
					}
				}
		]}),
		bbar: new Ext.PagingToolbar({
			pageSize: list_size,
			store: store_pensionEmployees,
			displayInfo: true,
			displayMsg: '<?php __('Displaying {0} - {1} of {2}'); ?>',
			beforePageText: '<?php __('Page'); ?>',
			afterPageText: '<?php __('of {0}'); ?>',
			emptyMsg: '<?php __('No data to display'); ?>'
		})
	});
	p.getSelectionModel().on('rowselect', function(sm, rowIdx, r) {
		p.getTopToolbar().findById('edit-pensionEmployee').enable();
		p.getTopToolbar().findById('delete-pensionEmployee').enable();
		p.getTopToolbar().findById('view-pensionEmployee').enable();
		if(this.getSelections().length > 1){
			p.getTopToolbar().findById('edit-pensionEmployee').disable();
			p.getTopToolbar().findById('view-pensionEmployee').disable();
		}
	});
	p.getSelectionModel().on('rowdeselect', function(sm, rowIdx, r) {
		if(this.getSelections().length > 1){
			p.getTopToolbar().findById('edit-pensionEmployee').disable();
			p.getTopToolbar().findById('view-pensionEmployee').disable();
			p.getTopToolbar().findById('delete-pensionEmployee').enable();
		}
		else if(this.getSelections().length == 1){
			p.getTopToolbar().findById('edit-pensionEmployee').enable();
			p.getTopToolbar().findById('view-pensionEmployee').enable();
			p.getTopToolbar().findById('delete-pensionEmployee').enable();
		}
		else{
			p.getTopToolbar().findById('edit-pensionEmployee').disable();
			p.getTopToolbar().findById('view-pensionEmployee').disable();
			p.getTopToolbar().findById('delete-pensionEmployee').disable();
		}
	});
	center_panel.setActiveTab(p);
	
	store_pensionEmployees.load({
		params: {
			start: 0,          
			limit: list_size
		}
	});
	
}
