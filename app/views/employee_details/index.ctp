//<script>
var store_employeeDetails = new Ext.data.GroupingStore({
	reader: new Ext.data.JsonReader({
		root:'rows',
		totalProperty: 'results',
		fields: [
			'id','employee','grade','status','step','position','start_date','created','modified'		]
	}),
	proxy: new Ext.data.HttpProxy({
		url: '<?php echo $this->Html->url(array('controller' => 'employeeDetails', 'action' => 'list_data')); ?>'
	})
,	sortInfo:{field: 'employee_id', direction: "ASC"},
	groupField: 'grade_id'
});


function AddEmployeeDetail() {
	Ext.Ajax.request({
		url: '<?php echo $this->Html->url(array('controller' => 'employeeDetails', 'action' => 'add')); ?>',
		success: function(response, opts) {
			var employeeDetail_data = response.responseText;
			
			eval(employeeDetail_data);
			
			EmployeeDetailAddWindow.show();
		},
		failure: function(response, opts) {
			Ext.Msg.alert('<?php __('Error'); ?>', '<?php __('Cannot get the employeeDetail add form. Error code'); ?>: ' + response.status);
		}
	});
}

function EditEmployeeDetail(id) {
	Ext.Ajax.request({
		url: '<?php echo $this->Html->url(array('controller' => 'employeeDetails', 'action' => 'edit')); ?>/'+id,
		success: function(response, opts) {
			var employeeDetail_data = response.responseText;
			
			eval(employeeDetail_data);
			
			EmployeeDetailEditWindow.show();
		},
		failure: function(response, opts) {
			Ext.Msg.alert('<?php __('Error'); ?>', '<?php __('Cannot get the employeeDetail edit form. Error code'); ?>: ' + response.status);
		}
	});
}

function ViewEmployeeDetail(id) {
    Ext.Ajax.request({
        url: '<?php echo $this->Html->url(array('controller' => 'employeeDetails', 'action' => 'view')); ?>/'+id,
        success: function(response, opts) {
            var employeeDetail_data = response.responseText;

            eval(employeeDetail_data);

            EmployeeDetailViewWindow.show();
        },
        failure: function(response, opts) {
            Ext.Msg.alert('<?php __('Error'); ?>', '<?php __('Cannot get the employeeDetail view form. Error code'); ?>: ' + response.status);
        }
    });
}

function DeleteEmployeeDetail(id) {
	Ext.Ajax.request({
		url: '<?php echo $this->Html->url(array('controller' => 'employeeDetails', 'action' => 'delete')); ?>/'+id,
		success: function(response, opts) {
			Ext.Msg.alert('<?php __('Success'); ?>', '<?php __('EmployeeDetail successfully deleted!'); ?>');
			RefreshEmployeeDetailData();
		},
		failure: function(response, opts) {
			Ext.Msg.alert('<?php __('Error'); ?>', '<?php __('Cannot get the employeeDetail add form. Error code'); ?>: ' + response.status);
		}
	});
}

function SearchEmployeeDetail(){
	Ext.Ajax.request({
		url: '<?php echo $this->Html->url(array('controller' => 'employeeDetails', 'action' => 'search')); ?>',
		success: function(response, opts){
			var employeeDetail_data = response.responseText;

			eval(employeeDetail_data);

			employeeDetailSearchWindow.show();
		},
		failure: function(response, opts) {
			Ext.Msg.alert('<?php __('Error'); ?>','<?php __('Cannot get the employeeDetail search form. Error Code'); ?>: ' + response.status);
		}
	});
}

function SearchByEmployeeDetailName(value){
	var conditions = '\'EmployeeDetail.name LIKE\' => \'%' + value + '%\'';
	store_employeeDetails.reload({
		 params: {
			start: 0,
			limit: list_size,
			conditions: conditions
	    }
	});
}

function RefreshEmployeeDetailData() {
	store_employeeDetails.reload();
}


if(center_panel.find('id', 'employeeDetail-tab') != "") {
	var p = center_panel.findById('employeeDetail-tab');
	center_panel.setActiveTab(p);
} else {
	var p = center_panel.add({
		title: '<?php __('Employee Details'); ?>',
		closable: true,
		loadMask: true,
		stripeRows: true,
		id: 'employeeDetail-tab',
		xtype: 'grid',
		store: store_employeeDetails,
		columns: [
			{header: "<?php __('Employee'); ?>", dataIndex: 'employee', sortable: true},
			{header: "<?php __('Grade'); ?>", dataIndex: 'grade', sortable: true},
			{header: "<?php __('Step'); ?>", dataIndex: 'step', sortable: true},
			{header: "<?php __('Position'); ?>", dataIndex: 'position', sortable: true},
      {header: "<?php __('Status'); ?>", dataIndex: 'status', sortable: true},
			{header: "<?php __('Start Date'); ?>", dataIndex: 'start_date', sortable: true},
			{header: "<?php __('Created'); ?>", dataIndex: 'created', sortable: true},
			{header: "<?php __('Modified'); ?>", dataIndex: 'modified', sortable: true}
		],
		
		view: new Ext.grid.GroupingView({
            forceFit:true,
            groupTextTpl: '{text} ({[values.rs.length]} {[values.rs.length > 1 ? "EmployeeDetails" : "EmployeeDetail"]})'
        })
,
		listeners: {
			celldblclick: function(){
				ViewEmployeeDetail(Ext.getCmp('employeeDetail-tab').getSelectionModel().getSelected().data.id);
			}
		},
		sm: new Ext.grid.RowSelectionModel({
			singleSelect: false
		}),
		tbar: new Ext.Toolbar({
			
			items: [{
					xtype: 'tbbutton',
					text: '<?php __('Add'); ?>',
					tooltip:'<?php __('<b>Add EmployeeDetails</b><br />Click here to create a new EmployeeDetail'); ?>',
					icon: 'img/table_add.png',
					cls: 'x-btn-text-icon',
					handler: function(btn) {
						AddEmployeeDetail();
					}
				}, ' ', '-', ' ', {
					xtype: 'tbbutton',
					text: '<?php __('Edit'); ?>',
					id: 'edit-employeeDetail',
					tooltip:'<?php __('<b>Edit EmployeeDetails</b><br />Click here to modify the selected EmployeeDetail'); ?>',
					icon: 'img/table_edit.png',
					cls: 'x-btn-text-icon',
					disabled: true,
					handler: function(btn) {
						var sm = p.getSelectionModel();
						var sel = sm.getSelected();
						if (sm.hasSelection()){
							EditEmployeeDetail(sel.data.id);
						};
					}
				}, ' ', '-', ' ', {
					xtype: 'tbbutton',
					text: '<?php __('Delete'); ?>',
					id: 'delete-employeeDetail',
					tooltip:'<?php __('<b>Delete EmployeeDetails(s)</b><br />Click here to remove the selected EmployeeDetail(s)'); ?>',
					icon: 'img/table_delete.png',
					cls: 'x-btn-text-icon',
					disabled: true,
					handler: function(btn) {
						var sm = p.getSelectionModel();
						var sel = sm.getSelections();
						if (sm.hasSelection()){
							if(sel.length==1){
								Ext.Msg.show({
									title: '<?php __('Remove EmployeeDetail'); ?>',
									buttons: Ext.MessageBox.YESNO,
									msg: '<?php __('Remove'); ?> '+sel[0].data.name+'?',
									icon: Ext.MessageBox.QUESTION,
									fn: function(btn){
										if (btn == 'yes'){
											DeleteEmployeeDetail(sel[0].data.id);
										}
									}
								});
							}else{
								Ext.Msg.show({
									title: '<?php __('Remove EmployeeDetail'); ?>',
									buttons: Ext.MessageBox.YESNO,
									msg: '<?php __('Remove the selected EmployeeDetails'); ?>?',
									icon: Ext.MessageBox.QUESTION,
									fn: function(btn){
										if (btn == 'yes'){
											var sel_ids = '';
											for(i=0;i<sel.length;i++){
												if(i>0)
													sel_ids += '_';
												sel_ids += sel[i].data.id;
											}
											DeleteEmployeeDetail(sel_ids);
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
					text: '<?php __('View EmployeeDetail'); ?>',
					id: 'view-employeeDetail',
					tooltip:'<?php __('<b>View EmployeeDetail</b><br />Click here to see details of the selected EmployeeDetail'); ?>',
					icon: 'img/table_view.png',
					cls: 'x-btn-text-icon',
					disabled: true,
					handler: function(btn) {
						var sm = p.getSelectionModel();
						var sel = sm.getSelected();
						if (sm.hasSelection()){
							ViewEmployeeDetail(sel.data.id);
						};
					},
					menu : {
						items: [
						]
					}
				}, ' ', '-',  '<?php __('Employee'); ?>: ', {
					xtype : 'combo',
					emptyText: 'All',
					store : new Ext.data.ArrayStore({
						fields : ['id', 'name'],
						data : [
							['-1', 'All'],
							<?php $st = false;foreach ($employees as $item){if($st) echo ",
							";?>['<?php echo $item['Employee']['id']; ?>' ,'<?php echo $item['Employee']['name']; ?>']<?php $st = true;}?>						]
					}),
					displayField : 'name',
					valueField : 'id',
					mode : 'local',
					value : '-1',
					disableKeyFilter : true,
					triggerAction: 'all',
					listeners : {
						select : function(combo, record, index){
							store_employeeDetails.reload({
								params: {
									start: 0,
									limit: list_size,
									employee_id : combo.getValue()
								}
							});
						}
					}
				},
 '->', {
					xtype: 'textfield',
					emptyText: '<?php __('[Search By Name]'); ?>',
					id: 'employeeDetail_search_field',
					listeners: {
						specialkey: function(field, e){
							if (e.getKey() == e.ENTER) {
								SearchByEmployeeDetailName(Ext.getCmp('employeeDetail_search_field').getValue());
							}
						}
					}
				}, {
					xtype: 'tbbutton',
					icon: 'img/search.png',
					cls: 'x-btn-text-icon',
					text: '<?php __('GO'); ?>',
                    tooltip:'<?php __('<b>GO</b><br />Click here to get search results'); ?>',
					id: 'employeeDetail_go_button',
					handler: function(){
						SearchByEmployeeDetailName(Ext.getCmp('employeeDetail_search_field').getValue());
					}
				}, '-', {
					xtype: 'tbbutton',
					icon: 'img/table_search.png',
					cls: 'x-btn-text-icon',
					text: '<?php __('Advanced Search'); ?>',
                    tooltip:'<?php __('<b>Advanced Search...</b><br />Click here to get the advanced search form'); ?>',
					handler: function(){
						SearchEmployeeDetail();
					}
				}
		]}),
		bbar: new Ext.PagingToolbar({
			pageSize: list_size,
			store: store_employeeDetails,
			displayInfo: true,
			displayMsg: '<?php __('Displaying {0} - {1} of {2}'); ?>',
			beforePageText: '<?php __('Page'); ?>',
			afterPageText: '<?php __('of {0}'); ?>',
			emptyMsg: '<?php __('No data to display'); ?>'
		})
	});
	p.getSelectionModel().on('rowselect', function(sm, rowIdx, r) {
		p.getTopToolbar().findById('edit-employeeDetail').enable();
		p.getTopToolbar().findById('delete-employeeDetail').enable();
		p.getTopToolbar().findById('view-employeeDetail').enable();
		if(this.getSelections().length > 1){
			p.getTopToolbar().findById('edit-employeeDetail').disable();
			p.getTopToolbar().findById('view-employeeDetail').disable();
		}
	});
	p.getSelectionModel().on('rowdeselect', function(sm, rowIdx, r) {
		if(this.getSelections().length > 1){
			p.getTopToolbar().findById('edit-employeeDetail').disable();
			p.getTopToolbar().findById('view-employeeDetail').disable();
			p.getTopToolbar().findById('delete-employeeDetail').enable();
		}
		else if(this.getSelections().length == 1){
			p.getTopToolbar().findById('edit-employeeDetail').enable();
			p.getTopToolbar().findById('view-employeeDetail').enable();
			p.getTopToolbar().findById('delete-employeeDetail').enable();
		}
		else{
			p.getTopToolbar().findById('edit-employeeDetail').disable();
			p.getTopToolbar().findById('view-employeeDetail').disable();
			p.getTopToolbar().findById('delete-employeeDetail').disable();
		}
	});
	center_panel.setActiveTab(p);
	
	store_employeeDetails.load({
		params: {
			start: 0,          
			limit: list_size
		}
	});
	
}
