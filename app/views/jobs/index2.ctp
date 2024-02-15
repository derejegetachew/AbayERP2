var store_parent_jobs = new Ext.data.Store({
	reader: new Ext.data.JsonReader({
		root:'rows',
		totalProperty: 'results',
		fields: [
			'id','name','description','start_date','end_date','grade','location'	
		]
	}),
	proxy: new Ext.data.HttpProxy({
		url: '<?php echo $this->Html->url(array('controller' => 'jobs', 'action' => 'list_data', $parent_id)); ?>'	})
});


function AddParentJob() {
	Ext.Ajax.request({
		url: '<?php echo $this->Html->url(array('controller' => 'jobs', 'action' => 'add', $parent_id)); ?>',
		success: function(response, opts) {
			var parent_job_data = response.responseText;
			
			eval(parent_job_data);
			
			JobAddWindow.show();
		},
		failure: function(response, opts) {
			Ext.Msg.alert('<?php __('Error'); ?>', '<?php __('Cannot get the job add form. Error code'); ?>: ' + response.status);
		}
	});
}

function EditParentJob(id) {
	Ext.Ajax.request({
		url: '<?php echo $this->Html->url(array('controller' => 'jobs', 'action' => 'edit')); ?>/'+id+'/<?php echo $parent_id; ?>',
		success: function(response, opts) {
			var parent_job_data = response.responseText;
			
			eval(parent_job_data);
			
			JobEditWindow.show();
		},
		failure: function(response, opts) {
			Ext.Msg.alert('<?php __('Error'); ?>', '<?php __('Cannot get the job edit form. Error code'); ?>: ' + response.status);
		}
	});
}

function ViewJob(id) {
	Ext.Ajax.request({
		url: '<?php echo $this->Html->url(array('controller' => 'jobs', 'action' => 'view')); ?>/'+id,
		success: function(response, opts) {
			var job_data = response.responseText;

			eval(job_data);

			JobViewWindow.show();
		},
		failure: function(response, opts) {
			Ext.Msg.alert('<?php __('Error'); ?>', '<?php __('Cannot get the job view form. Error code'); ?>: ' + response.status);
		}
	});
}

function ViewJobApplications(id) {
	Ext.Ajax.request({
		url: '<?php echo $this->Html->url(array('controller' => 'applications', 'action' => 'index2')); ?>/'+id,
		success: function(response, opts) {
			var parent_applications_data = response.responseText;

			eval(parent_applications_data);

			parentApplicationsViewWindow.show();
		},
		failure: function(response, opts) {
			Ext.Msg.alert('<?php __('Error'); ?>', '<?php __('Cannot get the campus view form. Error code'); ?>: ' + response.status);
		}
	});
}


function DeleteParentJob(id) {
	Ext.Ajax.request({
		url: '<?php echo $this->Html->url(array('controller' => 'jobs', 'action' => 'delete')); ?>/'+id,
		success: function(response, opts) {
			Ext.Msg.alert('<?php __('Success'); ?>', '<?php __('Job(s) successfully deleted!'); ?>');
			RefreshParentJobData();
		},
		failure: function(response, opts) {
			Ext.Msg.alert('<?php __('Error'); ?>', '<?php __('Cannot get the job to be deleted. Error code'); ?>: ' + response.status);
		}
	});
}

function SearchByParentJobName(value){
	var conditions = '\'Job.name LIKE\' => \'%' + value + '%\'';
	store_parent_jobs.reload({
		 params: {
			start: 0,
			limit: list_size,
			conditions: conditions
	    }
	});
}

function RefreshParentJobData() {
	store_parent_jobs.reload();
}



var g = new Ext.grid.GridPanel({
	title: '<?php __('Jobs'); ?>',
	store: store_parent_jobs,
	loadMask: true,
	stripeRows: true,
	height: 300,
	anchor: '100%',
    id: 'jobGrid',
	columns: [
		{header: "<?php __('Name'); ?>", dataIndex: 'name', sortable: true},
		{header: "<?php __('Description'); ?>", dataIndex: 'description', sortable: true},
		{header: "<?php __('Start Date'); ?>", dataIndex: 'start_date', sortable: true},
		{header: "<?php __('End Date'); ?>", dataIndex: 'end_date', sortable: true},
		{header:"<?php __('grade'); ?>", dataIndex: 'grade', sortable: true},
		{header:"<?php __('location'); ?>", dataIndex: 'location', sortable: true}	],
	sm: new Ext.grid.RowSelectionModel({
		singleSelect: false
	}),
	viewConfig: {
		forceFit: true
	},
    listeners: {
        celldblclick: function(){
            ViewJob(Ext.getCmp('jobGrid').getSelectionModel().getSelected().data.id);
        }
    },
	tbar: new Ext.Toolbar({
		items: [{
				xtype: 'tbbutton',
				text: '<?php __('Add'); ?>',
				tooltip:'<?php __('<b>Add Job</b><br />Click here to create a new Job'); ?>',
				icon: 'img/table_add.png',
				cls: 'x-btn-text-icon',
				handler: function(btn) {
					AddParentJob();
				}
			}, ' ', '-', ' ', {
				xtype: 'tbbutton',
				text: '<?php __('Edit'); ?>',
				id: 'edit-parent-job',
				tooltip:'<?php __('<b>Edit Job</b><br />Click here to modify the selected Job'); ?>',
				icon: 'img/table_edit.png',
				cls: 'x-btn-text-icon',
				disabled: true,
				handler: function(btn) {
					var sm = g.getSelectionModel();
					var sel = sm.getSelected();
					if (sm.hasSelection()){
						EditParentJob(sel.data.id);
					};
				}
			}, ' ', '-', ' ', {
				xtype: 'tbbutton',
				text: '<?php __('Delete'); ?>',
				id: 'delete-parent-job',
				tooltip:'<?php __('<b>Delete Job(s)</b><br />Click here to remove the selected Job(s)'); ?>',
				icon: 'img/table_delete.png',
				cls: 'x-btn-text-icon',
				disabled: true,
				handler: function(btn) {
					var sm = g.getSelectionModel();
					var sel = sm.getSelections();
					if (sm.hasSelection()){
						if(sel.length==1){
							Ext.Msg.show({
									title: '<?php __('Remove Job'); ?>',
									buttons: Ext.MessageBox.YESNOCANCEL,
									msg: '<?php __('Remove'); ?> '+sel[0].data.name+'?',
									icon: Ext.MessageBox.QUESTION,
                                    fn: function(btn){
											if (btn == 'yes'){
													DeleteParentJob(sel[0].data.id);
											}
									}
							});
						} else {
							Ext.Msg.show({
									title: '<?php __('Remove Job'); ?>',
									buttons: Ext.MessageBox.YESNOCANCEL,
									msg: '<?php __('Remove the selected Job'); ?>?',
									icon: Ext.MessageBox.QUESTION,
                                    fn: function(btn){
											if (btn == 'yes'){
													var sel_ids = '';
													for(i=0;i<sel.length;i++){
														if(i>0)
															sel_ids += '_';
														sel_ids += sel[i].data.id;
													}
													DeleteParentJob(sel_ids);
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
				text: '<?php __('View Job'); ?>',
				id: 'view-job2',
				tooltip:'<?php __('<b>View Job</b><br />Click here to see details of the selected Job'); ?>',
				icon: 'img/table_view.png',
				cls: 'x-btn-text-icon',
				disabled: true,
				handler: function(btn) {
					var sm = g.getSelectionModel();
					var sel = sm.getSelected();
					if (sm.hasSelection()){
						ViewJob(sel.data.id);
					};
				},
				menu : {
					items: [
 {
						text: '<?php __('View Applications'); ?>',
                        icon: 'img/table_view.png',
						cls: 'x-btn-text-icon',
						handler: function(btn) {
							var sm = g.getSelectionModel();
							var sel = sm.getSelected();
							if (sm.hasSelection()){
								ViewJobApplications(sel.data.id);
							};
						}
					}
					]
				}

            }, ' ', '->', {
				xtype: 'textfield',
				emptyText: '<?php __('[Search By Name]'); ?>',
				id: 'parent_job_search_field',
				listeners: {
					specialkey: function(field, e){
						if (e.getKey() == e.ENTER) {
							SearchByParentJobName(Ext.getCmp('parent_job_search_field').getValue());
						}
					}

				}
			}, {
				xtype: 'tbbutton',
				icon: 'img/search.png',
				cls: 'x-btn-text-icon',
				text: 'GO',
				tooltip:'<?php __('<b>GO</b><br />Click here to get search results'); ?>',
				id: 'parent_job_go_button',
				handler: function(){
					SearchByParentJobName(Ext.getCmp('parent_job_search_field').getValue());
				}
			}, ' '
	]}),
	bbar: new Ext.PagingToolbar({
		pageSize: list_size,
		store: store_parent_jobs,
		displayInfo: true,
		displayMsg: '<?php __('Displaying {0} - {1} of {2}'); ?>',
		beforePageText: '<?php __('Page'); ?>',
		afterPageText: '<?php __('of {0}'); ?>',
		emptyMsg: '<?php __('No data to display'); ?>'
	})
});
g.getSelectionModel().on('rowselect', function(sm, rowIdx, r) {
	g.getTopToolbar().findById('edit-parent-job').enable();
	g.getTopToolbar().findById('delete-parent-job').enable();
        g.getTopToolbar().findById('view-job2').enable();
	if(this.getSelections().length > 1){
		g.getTopToolbar().findById('edit-parent-job').disable();
                g.getTopToolbar().findById('view-job2').disable();
	}
});
g.getSelectionModel().on('rowdeselect', function(sm, rowIdx, r) {
	if(this.getSelections().length > 1){
		g.getTopToolbar().findById('edit-parent-job').disable();
		g.getTopToolbar().findById('delete-parent-job').enable();
                g.getTopToolbar().findById('view-job2').disable();
	}
	else if(this.getSelections().length == 1){
		g.getTopToolbar().findById('edit-parent-job').enable();
		g.getTopToolbar().findById('delete-parent-job').enable();
                g.getTopToolbar().findById('view-job2').enable();
	}
	else{
		g.getTopToolbar().findById('edit-parent-job').disable();
		g.getTopToolbar().findById('delete-parent-job').disable();
                g.getTopToolbar().findById('view-job2').disable();
	}
});



var parentJobsViewWindow = new Ext.Window({
	title: 'Job Under the selected Item',
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
			parentJobsViewWindow.close();
		}
	}]
});

store_parent_jobs.load({
    params: {
        start: 0,    
        limit: list_size
    }
});