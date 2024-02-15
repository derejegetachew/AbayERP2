var store_parent_applications = new Ext.data.Store({
	reader: new Ext.data.JsonReader({
		root:'rows',
		totalProperty: 'results',
		fields: [
			'id','employee','job','letter','date'	
		]
	}),
	proxy: new Ext.data.HttpProxy({
		url: '<?php echo $this->Html->url(array('controller' => 'applications', 'action' => 'list_data', $parent_id)); ?>'	})
});


function AddParentApplication() {
	Ext.Ajax.request({
		url: '<?php echo $this->Html->url(array('controller' => 'applications', 'action' => 'add', $parent_id)); ?>',
		success: function(response, opts) {
			var parent_application_data = response.responseText;
			
			eval(parent_application_data);
			
			ApplicationAddWindow.show();
		},
		failure: function(response, opts) {
			Ext.Msg.alert('<?php __('Error'); ?>', '<?php __('Cannot get the application add form. Error code'); ?>: ' + response.status);
		}
	});
}

function EditParentApplication(id) {
	Ext.Ajax.request({
		url: '<?php echo $this->Html->url(array('controller' => 'applications', 'action' => 'edit')); ?>/'+id+'/<?php echo $parent_id; ?>',
		success: function(response, opts) {
			var parent_application_data = response.responseText;
			
			eval(parent_application_data);
			
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


function DeleteParentApplication(id) {
	Ext.Ajax.request({
		url: '<?php echo $this->Html->url(array('controller' => 'applications', 'action' => 'delete')); ?>/'+id,
		success: function(response, opts) {
			Ext.Msg.alert('<?php __('Success'); ?>', '<?php __('Application(s) successfully deleted!'); ?>');
			RefreshParentApplicationData();
		},
		failure: function(response, opts) {
			Ext.Msg.alert('<?php __('Error'); ?>', '<?php __('Cannot get the application to be deleted. Error code'); ?>: ' + response.status);
		}
	});
}

function SearchByParentApplicationName(value){
	var conditions = '\'Application.name LIKE\' => \'%' + value + '%\'';
	store_parent_applications.reload({
		 params: {
			start: 0,
			limit: list_size,
			conditions: conditions
	    }
	});
}

function RefreshParentApplicationData() {
	store_parent_applications.reload();
}



var g = new Ext.grid.GridPanel({
	title: '<?php __('Applications'); ?>',
	store: store_parent_applications,
	loadMask: true,
	stripeRows: true,
	height: 300,
	anchor: '100%',
    id: 'applicationGrid',
	columns: [
		{header:"<?php __('employee'); ?>", dataIndex: 'employee', sortable: true},
		{header:"<?php __('job'); ?>", dataIndex: 'job', sortable: true},
		{header: "<?php __('Letter'); ?>", dataIndex: 'letter', sortable: true},
		{header: "<?php __('Date'); ?>", dataIndex: 'date', sortable: true}	],
	sm: new Ext.grid.RowSelectionModel({
		singleSelect: false
	}),
	viewConfig: {
		forceFit: true
	},
    listeners: {
        celldblclick: function(){
            ViewApplication(Ext.getCmp('applicationGrid').getSelectionModel().getSelected().data.id);
        }
    },
	tbar: new Ext.Toolbar({
		items: [ ' ','-',' ', {
				xtype: 'tbsplit',
				text: '<?php __('View Application'); ?>',
				id: 'view-application2',
				tooltip:'<?php __('<b>View Application</b><br />Click here to see details of the selected Application'); ?>',
				icon: 'img/table_view.png',
				cls: 'x-btn-text-icon',
				disabled: true,
				handler: function(btn) {
					var sm = g.getSelectionModel();
					var sel = sm.getSelected();
					if (sm.hasSelection()){
						ViewApplication(sel.data.id);
					};
				},
				menu : {
					items: [
					]
				}

            }, ' ', '->', {
				xtype: 'textfield',
				emptyText: '<?php __('[Search By Name]'); ?>',
				id: 'parent_application_search_field',
				listeners: {
					specialkey: function(field, e){
						if (e.getKey() == e.ENTER) {
							SearchByParentApplicationName(Ext.getCmp('parent_application_search_field').getValue());
						}
					}

				}
			}, {
				xtype: 'tbbutton',
				icon: 'img/search.png',
				cls: 'x-btn-text-icon',
				text: 'GO',
				tooltip:'<?php __('<b>GO</b><br />Click here to get search results'); ?>',
				id: 'parent_application_go_button',
				handler: function(){
					SearchByParentApplicationName(Ext.getCmp('parent_application_search_field').getValue());
				}
			}, ' '
	]}),
	bbar: new Ext.PagingToolbar({
		pageSize: list_size,
		store: store_parent_applications,
		displayInfo: true,
		displayMsg: '<?php __('Displaying {0} - {1} of {2}'); ?>',
		beforePageText: '<?php __('Page'); ?>',
		afterPageText: '<?php __('of {0}'); ?>',
		emptyMsg: '<?php __('No data to display'); ?>'
	})
});
g.getSelectionModel().on('rowselect', function(sm, rowIdx, r) {
	g.getTopToolbar().findById('edit-parent-application').enable();
	g.getTopToolbar().findById('delete-parent-application').enable();
        g.getTopToolbar().findById('view-application2').enable();
	if(this.getSelections().length > 1){
		g.getTopToolbar().findById('edit-parent-application').disable();
                g.getTopToolbar().findById('view-application2').disable();
	}
});
g.getSelectionModel().on('rowdeselect', function(sm, rowIdx, r) {
	if(this.getSelections().length > 1){
		g.getTopToolbar().findById('edit-parent-application').disable();
		g.getTopToolbar().findById('delete-parent-application').enable();
                g.getTopToolbar().findById('view-application2').disable();
	}
	else if(this.getSelections().length == 1){
		g.getTopToolbar().findById('edit-parent-application').enable();
		g.getTopToolbar().findById('delete-parent-application').enable();
                g.getTopToolbar().findById('view-application2').enable();
	}
	else{
		g.getTopToolbar().findById('edit-parent-application').disable();
		g.getTopToolbar().findById('delete-parent-application').disable();
                g.getTopToolbar().findById('view-application2').disable();
	}
});



var parentApplicationsViewWindow = new Ext.Window({
	title: 'Application Under the selected Item',
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
			parentApplicationsViewWindow.close();
		}
	}]
});

store_parent_applications.load({
    params: {
        start: 0,    
        limit: list_size
    }
});