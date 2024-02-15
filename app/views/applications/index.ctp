
var store_applications = new Ext.data.GroupingStore({
	reader: new Ext.data.JsonReader({
		root:'rows',
		totalProperty: 'results',
		fields: [
			'id','employee','job','letter','date'		]
	}),
	proxy: new Ext.data.HttpProxy({
		url: '<?php echo $this->Html->url(array('controller' => 'applications', 'action' => 'list_data')); ?>'
	})
,	sortInfo:{field: 'employee_id', direction: "ASC"},
	groupField: 'job_id'
});


function AddApplication() {
	Ext.Ajax.request({
		url: '<?php echo $this->Html->url(array('controller' => 'applications', 'action' => 'add')); ?>',
		success: function(response, opts) {
			var application_data = response.responseText;
			
			eval(application_data);
			
			ApplicationAddWindow.show();
		},
		failure: function(response, opts) {
			Ext.Msg.alert('<?php __('Error'); ?>', '<?php __('Cannot get the application add form. Error code'); ?>: ' + response.status);
		}
	});
}

function EditApplication(id) {
	Ext.Ajax.request({
		url: '<?php echo $this->Html->url(array('controller' => 'applications', 'action' => 'edit')); ?>/'+id,
		success: function(response, opts) {
			var application_data = response.responseText;
			
			eval(application_data);
			
			ApplicationEditWindow.show();
		},
		failure: function(response, opts) {
			Ext.Msg.alert('<?php __('Error'); ?>', '<?php __('Cannot get the application edit form. Error code'); ?>: ' + response.status);
		}
	});
}

function ViewApplication(id) {
    Ext.Ajax.request({
        url: '<?php echo $this->Html->url(array('controller' => 'applications', 'action' => 'view')); ?>/'+id,
        success: function(response, opts) {
            var application_data = response.responseText;

            eval(application_data);

            ApplicationViewWindow.show();
        },
        failure: function(response, opts) {
            Ext.Msg.alert('<?php __('Error'); ?>', '<?php __('Cannot get the application view form. Error code'); ?>: ' + response.status);
        }
    });
}

function DeleteApplication(id) {
	Ext.Ajax.request({
		url: '<?php echo $this->Html->url(array('controller' => 'applications', 'action' => 'delete')); ?>/'+id,
		success: function(response, opts) {
			Ext.Msg.alert('<?php __('Success'); ?>', '<?php __('Application successfully deleted!'); ?>');
			RefreshApplicationData();
		},
		failure: function(response, opts) {
			Ext.Msg.alert('<?php __('Error'); ?>', '<?php __('Cannot get the application add form. Error code'); ?>: ' + response.status);
		}
	});
}

function SearchApplication(){
	Ext.Ajax.request({
		url: '<?php echo $this->Html->url(array('controller' => 'applications', 'action' => 'search')); ?>',
		success: function(response, opts){
			var application_data = response.responseText;

			eval(application_data);

			applicationSearchWindow.show();
		},
		failure: function(response, opts) {
			Ext.Msg.alert('<?php __('Error'); ?>','<?php __('Cannot get the application search form. Error Code'); ?>: ' + response.status);
		}
	});
}

function SearchByApplicationName(value){
	var conditions = '\'Application.name LIKE\' => \'%' + value + '%\'';
	store_applications.reload({
		 params: {
			start: 0,
			limit: list_size,
			conditions: conditions
	    }
	});
}

function RefreshApplicationData() {
	store_applications.reload();
}


if(center_panel.find('id', 'application-tab') != "") {
	var p = center_panel.findById('application-tab');
	center_panel.setActiveTab(p);
} else {
	var p = center_panel.add({
		title: '<?php __('Applications'); ?>',
		closable: true,
		loadMask: true,
		stripeRows: true,
		id: 'application-tab',
		xtype: 'grid',
		store: store_applications,
		columns: [
			{header: "<?php __('Employee'); ?>", dataIndex: 'employee', sortable: true},
			{header: "<?php __('Job'); ?>", dataIndex: 'job', sortable: true},
			{header: "<?php __('Letter'); ?>", dataIndex: 'letter', sortable: true},
			{header: "<?php __('Date'); ?>", dataIndex: 'date', sortable: true}
		],
		
		view: new Ext.grid.GroupingView({
            forceFit:true,
            groupTextTpl: '{text} ({[values.rs.length]} {[values.rs.length > 1 ? "Applications" : "Application"]})'
        })
,
		listeners: {
			celldblclick: function(){
				ViewApplication(Ext.getCmp('application-tab').getSelectionModel().getSelected().data.id);
			}
		},
		sm: new Ext.grid.RowSelectionModel({
			singleSelect: false
		}),
		tbar: new Ext.Toolbar({
			
			items: [{
					xtype: 'tbbutton',
					text: '<?php __('Add'); ?>',
					tooltip:'<?php __('<b>Add Applications</b><br />Click here to create a new Application'); ?>',
					icon: 'img/table_add.png',
					cls: 'x-btn-text-icon',
					handler: function(btn) {
						AddApplication();
					}
				}, ' ', '-', ' ', {
					xtype: 'tbbutton',
					text: '<?php __('Edit'); ?>',
					id: 'edit-application',
					tooltip:'<?php __('<b>Edit Applications</b><br />Click here to modify the selected Application'); ?>',
					icon: 'img/table_edit.png',
					cls: 'x-btn-text-icon',
					disabled: true,
					handler: function(btn) {
						var sm = p.getSelectionModel();
						var sel = sm.getSelected();
						if (sm.hasSelection()){
							EditApplication(sel.data.id);
						};
					}
				}, ' ', '-', ' ', {
					xtype: 'tbbutton',
					text: '<?php __('Delete'); ?>',
					id: 'delete-application',
					tooltip:'<?php __('<b>Delete Applications(s)</b><br />Click here to remove the selected Application(s)'); ?>',
					icon: 'img/table_delete.png',
					cls: 'x-btn-text-icon',
					disabled: true,
					handler: function(btn) {
						var sm = p.getSelectionModel();
						var sel = sm.getSelections();
						if (sm.hasSelection()){
							if(sel.length==1){
								Ext.Msg.show({
									title: '<?php __('Remove Application'); ?>',
									buttons: Ext.MessageBox.YESNO,
									msg: '<?php __('Remove'); ?> '+sel[0].data.name+'?',
									icon: Ext.MessageBox.QUESTION,
									fn: function(btn){
										if (btn == 'yes'){
											DeleteApplication(sel[0].data.id);
										}
									}
								});
							}else{
								Ext.Msg.show({
									title: '<?php __('Remove Application'); ?>',
									buttons: Ext.MessageBox.YESNO,
									msg: '<?php __('Remove the selected Applications'); ?>?',
									icon: Ext.MessageBox.QUESTION,
									fn: function(btn){
										if (btn == 'yes'){
											var sel_ids = '';
											for(i=0;i<sel.length;i++){
												if(i>0)
													sel_ids += '_';
												sel_ids += sel[i].data.id;
											}
											DeleteApplication(sel_ids);
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
					text: '<?php __('View Application'); ?>',
					id: 'view-application',
					tooltip:'<?php __('<b>View Application</b><br />Click here to see details of the selected Application'); ?>',
					icon: 'img/table_view.png',
					cls: 'x-btn-text-icon',
					disabled: true,
					handler: function(btn) {
						var sm = p.getSelectionModel();
						var sel = sm.getSelected();
						if (sm.hasSelection()){
							ViewApplication(sel.data.id);
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
							store_applications.reload({
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
					id: 'application_search_field',
					listeners: {
						specialkey: function(field, e){
							if (e.getKey() == e.ENTER) {
								SearchByApplicationName(Ext.getCmp('application_search_field').getValue());
							}
						}
					}
				}, {
					xtype: 'tbbutton',
					icon: 'img/search.png',
					cls: 'x-btn-text-icon',
					text: '<?php __('GO'); ?>',
                    tooltip:'<?php __('<b>GO</b><br />Click here to get search results'); ?>',
					id: 'application_go_button',
					handler: function(){
						SearchByApplicationName(Ext.getCmp('application_search_field').getValue());
					}
				}, '-', {
					xtype: 'tbbutton',
					icon: 'img/table_search.png',
					cls: 'x-btn-text-icon',
					text: '<?php __('Advanced Search'); ?>',
                    tooltip:'<?php __('<b>Advanced Search...</b><br />Click here to get the advanced search form'); ?>',
					handler: function(){
						SearchApplication();
					}
				}
		]}),
		bbar: new Ext.PagingToolbar({
			pageSize: list_size,
			store: store_applications,
			displayInfo: true,
			displayMsg: '<?php __('Displaying {0} - {1} of {2}'); ?>',
			beforePageText: '<?php __('Page'); ?>',
			afterPageText: '<?php __('of {0}'); ?>',
			emptyMsg: '<?php __('No data to display'); ?>'
		})
	});
	p.getSelectionModel().on('rowselect', function(sm, rowIdx, r) {
		p.getTopToolbar().findById('edit-application').enable();
		p.getTopToolbar().findById('delete-application').enable();
		p.getTopToolbar().findById('view-application').enable();
		if(this.getSelections().length > 1){
			p.getTopToolbar().findById('edit-application').disable();
			p.getTopToolbar().findById('view-application').disable();
		}
	});
	p.getSelectionModel().on('rowdeselect', function(sm, rowIdx, r) {
		if(this.getSelections().length > 1){
			p.getTopToolbar().findById('edit-application').disable();
			p.getTopToolbar().findById('view-application').disable();
			p.getTopToolbar().findById('delete-application').enable();
		}
		else if(this.getSelections().length == 1){
			p.getTopToolbar().findById('edit-application').enable();
			p.getTopToolbar().findById('view-application').enable();
			p.getTopToolbar().findById('delete-application').enable();
		}
		else{
			p.getTopToolbar().findById('edit-application').disable();
			p.getTopToolbar().findById('view-application').disable();
			p.getTopToolbar().findById('delete-application').disable();
		}
	});
	center_panel.setActiveTab(p);
	
	store_applications.load({
		params: {
			start: 0,          
			limit: list_size
		}
	});
	
}
