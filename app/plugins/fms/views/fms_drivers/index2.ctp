var store_parent_fmsDrivers = new Ext.data.Store({
	reader: new Ext.data.JsonReader({
		root:'rows',
		totalProperty: 'results',
		fields: [
			'id','person','license_no','date_given','expiration_date','created_by','created','modified'	
		]
	}),
	proxy: new Ext.data.HttpProxy({
		url: '<?php echo $this->Html->url(array('controller' => 'fmsDrivers', 'action' => 'list_data', $parent_id)); ?>'	})
});


function AddParentFmsDriver() {
	Ext.Ajax.request({
		url: '<?php echo $this->Html->url(array('controller' => 'fmsDrivers', 'action' => 'add', $parent_id)); ?>',
		success: function(response, opts) {
			var parent_fmsDriver_data = response.responseText;
			
			eval(parent_fmsDriver_data);
			
			FmsDriverAddWindow.show();
		},
		failure: function(response, opts) {
			Ext.Msg.alert('<?php __('Error'); ?>', '<?php __('Cannot get the fmsDriver add form. Error code'); ?>: ' + response.status);
		}
	});
}

function EditParentFmsDriver(id) {
	Ext.Ajax.request({
		url: '<?php echo $this->Html->url(array('controller' => 'fmsDrivers', 'action' => 'edit')); ?>/'+id+'/<?php echo $parent_id; ?>',
		success: function(response, opts) {
			var parent_fmsDriver_data = response.responseText;
			
			eval(parent_fmsDriver_data);
			
			FmsDriverEditWindow.show();
		},
		failure: function(response, opts) {
			Ext.Msg.alert('<?php __('Error'); ?>', '<?php __('Cannot get the fmsDriver edit form. Error code'); ?>: ' + response.status);
		}
	});
}

function ViewFmsDriver(id) {
	Ext.Ajax.request({
		url: '<?php echo $this->Html->url(array('controller' => 'fmsDrivers', 'action' => 'view')); ?>/'+id,
		success: function(response, opts) {
			var fmsDriver_data = response.responseText;

			eval(fmsDriver_data);

			FmsDriverViewWindow.show();
		},
		failure: function(response, opts) {
			Ext.Msg.alert('<?php __('Error'); ?>', '<?php __('Cannot get the fmsDriver view form. Error code'); ?>: ' + response.status);
		}
	});
}


function DeleteParentFmsDriver(id) {
	Ext.Ajax.request({
		url: '<?php echo $this->Html->url(array('controller' => 'fmsDrivers', 'action' => 'delete')); ?>/'+id,
		success: function(response, opts) {
			Ext.Msg.alert('<?php __('Success'); ?>', '<?php __('FmsDriver(s) successfully deleted!'); ?>');
			RefreshParentFmsDriverData();
		},
		failure: function(response, opts) {
			Ext.Msg.alert('<?php __('Error'); ?>', '<?php __('Cannot get the fmsDriver to be deleted. Error code'); ?>: ' + response.status);
		}
	});
}

function SearchByParentFmsDriverName(value){
	var conditions = '\'FmsDriver.name LIKE\' => \'%' + value + '%\'';
	store_parent_fmsDrivers.reload({
		 params: {
			start: 0,
			limit: list_size,
			conditions: conditions
	    }
	});
}

function RefreshParentFmsDriverData() {
	store_parent_fmsDrivers.reload();
}



var g = new Ext.grid.GridPanel({
	title: '<?php __('FmsDrivers'); ?>',
	store: store_parent_fmsDrivers,
	loadMask: true,
	stripeRows: true,
	height: 300,
	anchor: '100%',
    id: 'fmsDriverGrid',
	columns: [
		{header:"<?php __('person'); ?>", dataIndex: 'person', sortable: true},
		{header: "<?php __('License No'); ?>", dataIndex: 'license_no', sortable: true},
		{header: "<?php __('Date Given'); ?>", dataIndex: 'date_given', sortable: true},
		{header: "<?php __('Expiration Date'); ?>", dataIndex: 'expiration_date', sortable: true},
		{header: "<?php __('Created By'); ?>", dataIndex: 'created_by', sortable: true},
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
            ViewFmsDriver(Ext.getCmp('fmsDriverGrid').getSelectionModel().getSelected().data.id);
        }
    },
	tbar: new Ext.Toolbar({
		items: [{
				xtype: 'tbbutton',
				text: '<?php __('Add'); ?>',
				tooltip:'<?php __('<b>Add FmsDriver</b><br />Click here to create a new FmsDriver'); ?>',
				icon: 'img/table_add.png',
				cls: 'x-btn-text-icon',
				handler: function(btn) {
					AddParentFmsDriver();
				}
			}, ' ', '-', ' ', {
				xtype: 'tbbutton',
				text: '<?php __('Edit'); ?>',
				id: 'edit-parent-fmsDriver',
				tooltip:'<?php __('<b>Edit FmsDriver</b><br />Click here to modify the selected FmsDriver'); ?>',
				icon: 'img/table_edit.png',
				cls: 'x-btn-text-icon',
				disabled: true,
				handler: function(btn) {
					var sm = g.getSelectionModel();
					var sel = sm.getSelected();
					if (sm.hasSelection()){
						EditParentFmsDriver(sel.data.id);
					};
				}
			}, ' ', '-', ' ', {
				xtype: 'tbbutton',
				text: '<?php __('Delete'); ?>',
				id: 'delete-parent-fmsDriver',
				tooltip:'<?php __('<b>Delete FmsDriver(s)</b><br />Click here to remove the selected FmsDriver(s)'); ?>',
				icon: 'img/table_delete.png',
				cls: 'x-btn-text-icon',
				disabled: true,
				handler: function(btn) {
					var sm = g.getSelectionModel();
					var sel = sm.getSelections();
					if (sm.hasSelection()){
						if(sel.length==1){
							Ext.Msg.show({
									title: '<?php __('Remove FmsDriver'); ?>',
									buttons: Ext.MessageBox.YESNOCANCEL,
									msg: '<?php __('Remove'); ?> '+sel[0].data.name+'?',
									icon: Ext.MessageBox.QUESTION,
                                    fn: function(btn){
											if (btn == 'yes'){
													DeleteParentFmsDriver(sel[0].data.id);
											}
									}
							});
						} else {
							Ext.Msg.show({
									title: '<?php __('Remove FmsDriver'); ?>',
									buttons: Ext.MessageBox.YESNOCANCEL,
									msg: '<?php __('Remove the selected FmsDriver'); ?>?',
									icon: Ext.MessageBox.QUESTION,
                                    fn: function(btn){
											if (btn == 'yes'){
													var sel_ids = '';
													for(i=0;i<sel.length;i++){
														if(i>0)
															sel_ids += '_';
														sel_ids += sel[i].data.id;
													}
													DeleteParentFmsDriver(sel_ids);
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
				text: '<?php __('View FmsDriver'); ?>',
				id: 'view-fmsDriver2',
				tooltip:'<?php __('<b>View FmsDriver</b><br />Click here to see details of the selected FmsDriver'); ?>',
				icon: 'img/table_view.png',
				cls: 'x-btn-text-icon',
				disabled: true,
				handler: function(btn) {
					var sm = g.getSelectionModel();
					var sel = sm.getSelected();
					if (sm.hasSelection()){
						ViewFmsDriver(sel.data.id);
					};
				},
				menu : {
					items: [
					]
				}

            }, ' ', '->', {
				xtype: 'textfield',
				emptyText: '<?php __('[Search By Name]'); ?>',
				id: 'parent_fmsDriver_search_field',
				listeners: {
					specialkey: function(field, e){
						if (e.getKey() == e.ENTER) {
							SearchByParentFmsDriverName(Ext.getCmp('parent_fmsDriver_search_field').getValue());
						}
					}

				}
			}, {
				xtype: 'tbbutton',
				icon: 'img/search.png',
				cls: 'x-btn-text-icon',
				text: 'GO',
				tooltip:'<?php __('<b>GO</b><br />Click here to get search results'); ?>',
				id: 'parent_fmsDriver_go_button',
				handler: function(){
					SearchByParentFmsDriverName(Ext.getCmp('parent_fmsDriver_search_field').getValue());
				}
			}, ' '
	]}),
	bbar: new Ext.PagingToolbar({
		pageSize: list_size,
		store: store_parent_fmsDrivers,
		displayInfo: true,
		displayMsg: '<?php __('Displaying {0} - {1} of {2}'); ?>',
		beforePageText: '<?php __('Page'); ?>',
		afterPageText: '<?php __('of {0}'); ?>',
		emptyMsg: '<?php __('No data to display'); ?>'
	})
});
g.getSelectionModel().on('rowselect', function(sm, rowIdx, r) {
	g.getTopToolbar().findById('edit-parent-fmsDriver').enable();
	g.getTopToolbar().findById('delete-parent-fmsDriver').enable();
        g.getTopToolbar().findById('view-fmsDriver2').enable();
	if(this.getSelections().length > 1){
		g.getTopToolbar().findById('edit-parent-fmsDriver').disable();
                g.getTopToolbar().findById('view-fmsDriver2').disable();
	}
});
g.getSelectionModel().on('rowdeselect', function(sm, rowIdx, r) {
	if(this.getSelections().length > 1){
		g.getTopToolbar().findById('edit-parent-fmsDriver').disable();
		g.getTopToolbar().findById('delete-parent-fmsDriver').enable();
                g.getTopToolbar().findById('view-fmsDriver2').disable();
	}
	else if(this.getSelections().length == 1){
		g.getTopToolbar().findById('edit-parent-fmsDriver').enable();
		g.getTopToolbar().findById('delete-parent-fmsDriver').enable();
                g.getTopToolbar().findById('view-fmsDriver2').enable();
	}
	else{
		g.getTopToolbar().findById('edit-parent-fmsDriver').disable();
		g.getTopToolbar().findById('delete-parent-fmsDriver').disable();
                g.getTopToolbar().findById('view-fmsDriver2').disable();
	}
});



var parentFmsDriversViewWindow = new Ext.Window({
	title: 'FmsDriver Under the selected Item',
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
			parentFmsDriversViewWindow.close();
		}
	}]
});

store_parent_fmsDrivers.load({
    params: {
        start: 0,    
        limit: list_size
    }
});