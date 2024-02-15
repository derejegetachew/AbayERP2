var store_parent_jobs = new Ext.data.Store({
	reader: new Ext.data.JsonReader({
		root:'rows',
		totalProperty: 'results',
		fields: [
			'id','name','description','start_date','end_date','grade','location'	
		]
	}),
	proxy: new Ext.data.HttpProxy({
		url: '<?php echo $this->Html->url(array('controller' => 'jobs', 'action' => 'list_data4')); ?>'	})
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
		url: '<?php echo $this->Html->url(array('controller' => 'applications', 'action' => 'delete')); ?>/'+id,
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
function showMenu(grid, index, event) {
        event.stopEvent();
        var record = grid.getStore().getAt(index);
        var btnStatus = 0; //(record.get('rejectable') == 'True')? false: true;
        var menu = new Ext.menu.Menu({
            items: [
                {
                    text: '<b>Delete</b>',
                    icon: 'img/table_edit.png',
                    handler: function() {
                    var app_end_date=record.get('end_date');
                    app_end_date=Date.parse(app_end_date);
                    
                    app_end_date=new Date(app_end_date);
                   app_end_date= app_end_date.toLocaleDateString();
                   
                  var today=Date.now();
                  today=new Date(today);
                  today= today.toLocaleDateString();
                  
                 // Ext.Msg.alert('Date', app_end_date+' '+ today);
                  /*var dd = today.getDate();
                  var mm = today.getMonth() + 1;
                  var yyyy = today.getFullYear();
                  if (dd < 10) {
                  dd = '0' + dd;
                  }
                  if (mm < 10) {
                  mm = '0' + mm;
                  }
                  var now = yyyy + '-' + dd + '-' + mm;  */
                  
                  app_end_date=Date.parse(app_end_date);
                  today=Date.parse(today);
                  if(app_end_date >= today){
                   DeleteParentJob(record.get('id'));
                  }else{
                  //Ext.Msg.alert('Failed to Delete',app_end_date +" "+ today);
                   Ext.Msg.alert('Failed to Delete', 'You can`t delete this application, because this application is already considered by HR and the vacancy status is closed!');
                  }
                 
                  }
                }
            ]
        }).showAt(event.xy);
    }


var g = new Ext.grid.GridPanel({
	title: '<?php __('Job Posts'); ?>',
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
        },
        'rowcontextmenu': function(grid, index, event) {
                    showMenu(grid, index, event);
                       this.getSelectionModel().selectRow(index);
                       
                } 
    },
	tbar: new Ext.Toolbar({
		items: []}),
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



var parentJobsMyWindow = new Ext.Window({
	title: 'Your Application History',
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
			parentJobsMyWindow.close();
		}
	}]
});

store_parent_jobs.load({
    params: {
        start: 0,    
        limit: list_size
    }
});