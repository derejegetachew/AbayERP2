var store_parent_fmsMaintenanceRequests = new Ext.data.Store({
	reader: new Ext.data.JsonReader({
		root:'rows',
		totalProperty: 'results',
		fields: [
			'id','company','fms_vehicle','km','damage_type','examination','notifier','confirmer','approver','created','modified'	
		]
	}),
	proxy: new Ext.data.HttpProxy({
		url: '<?php echo $this->Html->url(array('controller' => 'fmsMaintenanceRequests', 'action' => 'list_data', $parent_id)); ?>'	})
});


function AddParentFmsMaintenanceRequest() {
	Ext.Ajax.request({
		url: '<?php echo $this->Html->url(array('controller' => 'fmsMaintenanceRequests', 'action' => 'add', $parent_id)); ?>',
		success: function(response, opts) {
			var parent_fmsMaintenanceRequest_data = response.responseText;
			
			eval(parent_fmsMaintenanceRequest_data);
			
			FmsMaintenanceRequestAddWindow.show();
		},
		failure: function(response, opts) {
			Ext.Msg.alert('<?php __('Error'); ?>', '<?php __('Cannot get the fmsMaintenanceRequest add form. Error code'); ?>: ' + response.status);
		}
	});
}

function EditParentFmsMaintenanceRequest(id) {
	Ext.Ajax.request({
		url: '<?php echo $this->Html->url(array('controller' => 'fmsMaintenanceRequests', 'action' => 'edit')); ?>/'+id+'/<?php echo $parent_id; ?>',
		success: function(response, opts) {
			var parent_fmsMaintenanceRequest_data = response.responseText;
			
			eval(parent_fmsMaintenanceRequest_data);
			
			FmsMaintenanceRequestEditWindow.show();
		},
		failure: function(response, opts) {
			Ext.Msg.alert('<?php __('Error'); ?>', '<?php __('Cannot get the fmsMaintenanceRequest edit form. Error code'); ?>: ' + response.status);
		}
	});
}

function ViewFmsMaintenanceRequest(id) {
	Ext.Ajax.request({
		url: '<?php echo $this->Html->url(array('controller' => 'fmsMaintenanceRequests', 'action' => 'view')); ?>/'+id,
		success: function(response, opts) {
			var fmsMaintenanceRequest_data = response.responseText;

			eval(fmsMaintenanceRequest_data);

			FmsMaintenanceRequestViewWindow.show();
		},
		failure: function(response, opts) {
			Ext.Msg.alert('<?php __('Error'); ?>', '<?php __('Cannot get the fmsMaintenanceRequest view form. Error code'); ?>: ' + response.status);
		}
	});
}


function DeleteParentFmsMaintenanceRequest(id) {
	Ext.Ajax.request({
		url: '<?php echo $this->Html->url(array('controller' => 'fmsMaintenanceRequests', 'action' => 'delete')); ?>/'+id,
		success: function(response, opts) {
			Ext.Msg.alert('<?php __('Success'); ?>', '<?php __('FmsMaintenanceRequest(s) successfully deleted!'); ?>');
			RefreshParentFmsMaintenanceRequestData();
		},
		failure: function(response, opts) {
			Ext.Msg.alert('<?php __('Error'); ?>', '<?php __('Cannot get the fmsMaintenanceRequest to be deleted. Error code'); ?>: ' + response.status);
		}
	});
}

function SearchByParentFmsMaintenanceRequestName(value){
	var conditions = '\'FmsMaintenanceRequest.name LIKE\' => \'%' + value + '%\'';
	store_parent_fmsMaintenanceRequests.reload({
		 params: {
			start: 0,
			limit: list_size,
			conditions: conditions
	    }
	});
}

function RefreshParentFmsMaintenanceRequestData() {
	store_parent_fmsMaintenanceRequests.reload();
}



var g = new Ext.grid.GridPanel({
	title: '<?php __('FmsMaintenanceRequests'); ?>',
	store: store_parent_fmsMaintenanceRequests,
	loadMask: true,
	stripeRows: true,
	height: 300,
	anchor: '100%',
    id: 'fmsMaintenanceRequestGrid',
	columns: [
		{header: "<?php __('Company'); ?>", dataIndex: 'company', sortable: true},
		{header:"<?php __('fms_vehicle'); ?>", dataIndex: 'fms_vehicle', sortable: true},
		{header: "<?php __('Km'); ?>", dataIndex: 'km', sortable: true},
		{header: "<?php __('Damage Type'); ?>", dataIndex: 'damage_type', sortable: true},
		{header: "<?php __('Examination'); ?>", dataIndex: 'examination', sortable: true},
		{header: "<?php __('Notifier'); ?>", dataIndex: 'notifier', sortable: true},
		{header: "<?php __('Confirmer'); ?>", dataIndex: 'confirmer', sortable: true},
		{header: "<?php __('Approver'); ?>", dataIndex: 'approver', sortable: true},
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
            ViewFmsMaintenanceRequest(Ext.getCmp('fmsMaintenanceRequestGrid').getSelectionModel().getSelected().data.id);
        }
    },
	tbar: new Ext.Toolbar({
		items: [{
				xtype: 'tbbutton',
				text: '<?php __('Add'); ?>',
				tooltip:'<?php __('<b>Add FmsMaintenanceRequest</b><br />Click here to create a new FmsMaintenanceRequest'); ?>',
				icon: 'img/table_add.png',
				cls: 'x-btn-text-icon',
				handler: function(btn) {
					AddParentFmsMaintenanceRequest();
				}
			}, ' ', '-', ' ', {
				xtype: 'tbbutton',
				text: '<?php __('Edit'); ?>',
				id: 'edit-parent-fmsMaintenanceRequest',
				tooltip:'<?php __('<b>Edit FmsMaintenanceRequest</b><br />Click here to modify the selected FmsMaintenanceRequest'); ?>',
				icon: 'img/table_edit.png',
				cls: 'x-btn-text-icon',
				disabled: true,
				handler: function(btn) {
					var sm = g.getSelectionModel();
					var sel = sm.getSelected();
					if (sm.hasSelection()){
						EditParentFmsMaintenanceRequest(sel.data.id);
					};
				}
			}, ' ', '-', ' ', {
				xtype: 'tbbutton',
				text: '<?php __('Delete'); ?>',
				id: 'delete-parent-fmsMaintenanceRequest',
				tooltip:'<?php __('<b>Delete FmsMaintenanceRequest(s)</b><br />Click here to remove the selected FmsMaintenanceRequest(s)'); ?>',
				icon: 'img/table_delete.png',
				cls: 'x-btn-text-icon',
				disabled: true,
				handler: function(btn) {
					var sm = g.getSelectionModel();
					var sel = sm.getSelections();
					if (sm.hasSelection()){
						if(sel.length==1){
							Ext.Msg.show({
									title: '<?php __('Remove FmsMaintenanceRequest'); ?>',
									buttons: Ext.MessageBox.YESNOCANCEL,
									msg: '<?php __('Remove'); ?> '+sel[0].data.name+'?',
									icon: Ext.MessageBox.QUESTION,
                                    fn: function(btn){
											if (btn == 'yes'){
													DeleteParentFmsMaintenanceRequest(sel[0].data.id);
											}
									}
							});
						} else {
							Ext.Msg.show({
									title: '<?php __('Remove FmsMaintenanceRequest'); ?>',
									buttons: Ext.MessageBox.YESNOCANCEL,
									msg: '<?php __('Remove the selected FmsMaintenanceRequest'); ?>?',
									icon: Ext.MessageBox.QUESTION,
                                    fn: function(btn){
											if (btn == 'yes'){
													var sel_ids = '';
													for(i=0;i<sel.length;i++){
														if(i>0)
															sel_ids += '_';
														sel_ids += sel[i].data.id;
													}
													DeleteParentFmsMaintenanceRequest(sel_ids);
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
				text: '<?php __('View FmsMaintenanceRequest'); ?>',
				id: 'view-fmsMaintenanceRequest2',
				tooltip:'<?php __('<b>View FmsMaintenanceRequest</b><br />Click here to see details of the selected FmsMaintenanceRequest'); ?>',
				icon: 'img/table_view.png',
				cls: 'x-btn-text-icon',
				disabled: true,
				handler: function(btn) {
					var sm = g.getSelectionModel();
					var sel = sm.getSelected();
					if (sm.hasSelection()){
						ViewFmsMaintenanceRequest(sel.data.id);
					};
				},
				menu : {
					items: [
					]
				}

            }, ' ', '->', {
				xtype: 'textfield',
				emptyText: '<?php __('[Search By Name]'); ?>',
				id: 'parent_fmsMaintenanceRequest_search_field',
				listeners: {
					specialkey: function(field, e){
						if (e.getKey() == e.ENTER) {
							SearchByParentFmsMaintenanceRequestName(Ext.getCmp('parent_fmsMaintenanceRequest_search_field').getValue());
						}
					}

				}
			}, {
				xtype: 'tbbutton',
				icon: 'img/search.png',
				cls: 'x-btn-text-icon',
				text: 'GO',
				tooltip:'<?php __('<b>GO</b><br />Click here to get search results'); ?>',
				id: 'parent_fmsMaintenanceRequest_go_button',
				handler: function(){
					SearchByParentFmsMaintenanceRequestName(Ext.getCmp('parent_fmsMaintenanceRequest_search_field').getValue());
				}
			}, ' '
	]}),
	bbar: new Ext.PagingToolbar({
		pageSize: list_size,
		store: store_parent_fmsMaintenanceRequests,
		displayInfo: true,
		displayMsg: '<?php __('Displaying {0} - {1} of {2}'); ?>',
		beforePageText: '<?php __('Page'); ?>',
		afterPageText: '<?php __('of {0}'); ?>',
		emptyMsg: '<?php __('No data to display'); ?>'
	})
});
g.getSelectionModel().on('rowselect', function(sm, rowIdx, r) {
	g.getTopToolbar().findById('edit-parent-fmsMaintenanceRequest').enable();
	g.getTopToolbar().findById('delete-parent-fmsMaintenanceRequest').enable();
        g.getTopToolbar().findById('view-fmsMaintenanceRequest2').enable();
	if(this.getSelections().length > 1){
		g.getTopToolbar().findById('edit-parent-fmsMaintenanceRequest').disable();
                g.getTopToolbar().findById('view-fmsMaintenanceRequest2').disable();
	}
});
g.getSelectionModel().on('rowdeselect', function(sm, rowIdx, r) {
	if(this.getSelections().length > 1){
		g.getTopToolbar().findById('edit-parent-fmsMaintenanceRequest').disable();
		g.getTopToolbar().findById('delete-parent-fmsMaintenanceRequest').enable();
                g.getTopToolbar().findById('view-fmsMaintenanceRequest2').disable();
	}
	else if(this.getSelections().length == 1){
		g.getTopToolbar().findById('edit-parent-fmsMaintenanceRequest').enable();
		g.getTopToolbar().findById('delete-parent-fmsMaintenanceRequest').enable();
                g.getTopToolbar().findById('view-fmsMaintenanceRequest2').enable();
	}
	else{
		g.getTopToolbar().findById('edit-parent-fmsMaintenanceRequest').disable();
		g.getTopToolbar().findById('delete-parent-fmsMaintenanceRequest').disable();
                g.getTopToolbar().findById('view-fmsMaintenanceRequest2').disable();
	}
});



var parentFmsMaintenanceRequestsViewWindow = new Ext.Window({
	title: 'FmsMaintenanceRequest Under the selected Item',
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
			parentFmsMaintenanceRequestsViewWindow.close();
		}
	}]
});

store_parent_fmsMaintenanceRequests.load({
    params: {
        start: 0,    
        limit: list_size
    }
});