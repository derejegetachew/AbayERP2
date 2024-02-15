var store_parent_imsMaintenanceRequests = new Ext.data.Store({
	reader: new Ext.data.JsonReader({
		root:'rows',
		totalProperty: 'results',
		fields: [
			'id','name','branch','description','requested_by','approved_rejected_by','status','ims_item','tag','branch_recommendation','technician_recommendation','remark','created','modified'	
		]
	}),
	proxy: new Ext.data.HttpProxy({
		url: '<?php echo $this->Html->url(array('controller' => 'imsMaintenanceRequests', 'action' => 'list_data', $parent_id)); ?>'	})
});


function AddParentImsMaintenanceRequest() {
	Ext.Ajax.request({
		url: '<?php echo $this->Html->url(array('controller' => 'imsMaintenanceRequests', 'action' => 'add', $parent_id)); ?>',
		success: function(response, opts) {
			var parent_imsMaintenanceRequest_data = response.responseText;
			
			eval(parent_imsMaintenanceRequest_data);
			
			ImsMaintenanceRequestAddWindow.show();
		},
		failure: function(response, opts) {
			Ext.Msg.alert('<?php __('Error'); ?>', '<?php __('Cannot get the imsMaintenanceRequest add form. Error code'); ?>: ' + response.status);
		}
	});
}

function EditParentImsMaintenanceRequest(id) {
	Ext.Ajax.request({
		url: '<?php echo $this->Html->url(array('controller' => 'imsMaintenanceRequests', 'action' => 'edit')); ?>/'+id+'/<?php echo $parent_id; ?>',
		success: function(response, opts) {
			var parent_imsMaintenanceRequest_data = response.responseText;
			
			eval(parent_imsMaintenanceRequest_data);
			
			ImsMaintenanceRequestEditWindow.show();
		},
		failure: function(response, opts) {
			Ext.Msg.alert('<?php __('Error'); ?>', '<?php __('Cannot get the imsMaintenanceRequest edit form. Error code'); ?>: ' + response.status);
		}
	});
}

function ViewImsMaintenanceRequest(id) {
	Ext.Ajax.request({
		url: '<?php echo $this->Html->url(array('controller' => 'imsMaintenanceRequests', 'action' => 'view')); ?>/'+id,
		success: function(response, opts) {
			var imsMaintenanceRequest_data = response.responseText;

			eval(imsMaintenanceRequest_data);

			ImsMaintenanceRequestViewWindow.show();
		},
		failure: function(response, opts) {
			Ext.Msg.alert('<?php __('Error'); ?>', '<?php __('Cannot get the imsMaintenanceRequest view form. Error code'); ?>: ' + response.status);
		}
	});
}


function DeleteParentImsMaintenanceRequest(id) {
	Ext.Ajax.request({
		url: '<?php echo $this->Html->url(array('controller' => 'imsMaintenanceRequests', 'action' => 'delete')); ?>/'+id,
		success: function(response, opts) {
			Ext.Msg.alert('<?php __('Success'); ?>', '<?php __('ImsMaintenanceRequest(s) successfully deleted!'); ?>');
			RefreshParentImsMaintenanceRequestData();
		},
		failure: function(response, opts) {
			Ext.Msg.alert('<?php __('Error'); ?>', '<?php __('Cannot get the imsMaintenanceRequest to be deleted. Error code'); ?>: ' + response.status);
		}
	});
}

function SearchByParentImsMaintenanceRequestName(value){
	var conditions = '\'ImsMaintenanceRequest.name LIKE\' => \'%' + value + '%\'';
	store_parent_imsMaintenanceRequests.reload({
		 params: {
			start: 0,
			limit: list_size,
			conditions: conditions
	    }
	});
}

function RefreshParentImsMaintenanceRequestData() {
	store_parent_imsMaintenanceRequests.reload();
}



var g = new Ext.grid.GridPanel({
	title: '<?php __('ImsMaintenanceRequests'); ?>',
	store: store_parent_imsMaintenanceRequests,
	loadMask: true,
	stripeRows: true,
	height: 300,
	anchor: '100%',
    id: 'imsMaintenanceRequestGrid',
	columns: [
		{header: "<?php __('Name'); ?>", dataIndex: 'name', sortable: true},
		{header:"<?php __('branch'); ?>", dataIndex: 'branch', sortable: true},
		{header: "<?php __('Description'); ?>", dataIndex: 'description', sortable: true},
		{header: "<?php __('Requested By'); ?>", dataIndex: 'requested_by', sortable: true},
		{header: "<?php __('Approved Rejected By'); ?>", dataIndex: 'approved_rejected_by', sortable: true},
		{header: "<?php __('Status'); ?>", dataIndex: 'status', sortable: true},
		{header:"<?php __('ims_item'); ?>", dataIndex: 'ims_item', sortable: true},
		{header: "<?php __('Tag'); ?>", dataIndex: 'tag', sortable: true},
		{header: "<?php __('Branch Recommendation'); ?>", dataIndex: 'branch_recommendation', sortable: true},
		{header: "<?php __('Technician Recommendation'); ?>", dataIndex: 'technician_recommendation', sortable: true},
		{header: "<?php __('Remark'); ?>", dataIndex: 'remark', sortable: true},
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
            ViewImsMaintenanceRequest(Ext.getCmp('imsMaintenanceRequestGrid').getSelectionModel().getSelected().data.id);
        }
    },
	tbar: new Ext.Toolbar({
		items: [{
				xtype: 'tbbutton',
				text: '<?php __('Add'); ?>',
				tooltip:'<?php __('<b>Add ImsMaintenanceRequest</b><br />Click here to create a new ImsMaintenanceRequest'); ?>',
				icon: 'img/table_add.png',
				cls: 'x-btn-text-icon',
				handler: function(btn) {
					AddParentImsMaintenanceRequest();
				}
			}, ' ', '-', ' ', {
				xtype: 'tbbutton',
				text: '<?php __('Edit'); ?>',
				id: 'edit-parent-imsMaintenanceRequest',
				tooltip:'<?php __('<b>Edit ImsMaintenanceRequest</b><br />Click here to modify the selected ImsMaintenanceRequest'); ?>',
				icon: 'img/table_edit.png',
				cls: 'x-btn-text-icon',
				disabled: true,
				handler: function(btn) {
					var sm = g.getSelectionModel();
					var sel = sm.getSelected();
					if (sm.hasSelection()){
						EditParentImsMaintenanceRequest(sel.data.id);
					};
				}
			}, ' ', '-', ' ', {
				xtype: 'tbbutton',
				text: '<?php __('Delete'); ?>',
				id: 'delete-parent-imsMaintenanceRequest',
				tooltip:'<?php __('<b>Delete ImsMaintenanceRequest(s)</b><br />Click here to remove the selected ImsMaintenanceRequest(s)'); ?>',
				icon: 'img/table_delete.png',
				cls: 'x-btn-text-icon',
				disabled: true,
				handler: function(btn) {
					var sm = g.getSelectionModel();
					var sel = sm.getSelections();
					if (sm.hasSelection()){
						if(sel.length==1){
							Ext.Msg.show({
									title: '<?php __('Remove ImsMaintenanceRequest'); ?>',
									buttons: Ext.MessageBox.YESNOCANCEL,
									msg: '<?php __('Remove'); ?> '+sel[0].data.name+'?',
									icon: Ext.MessageBox.QUESTION,
                                    fn: function(btn){
											if (btn == 'yes'){
													DeleteParentImsMaintenanceRequest(sel[0].data.id);
											}
									}
							});
						} else {
							Ext.Msg.show({
									title: '<?php __('Remove ImsMaintenanceRequest'); ?>',
									buttons: Ext.MessageBox.YESNOCANCEL,
									msg: '<?php __('Remove the selected ImsMaintenanceRequest'); ?>?',
									icon: Ext.MessageBox.QUESTION,
                                    fn: function(btn){
											if (btn == 'yes'){
													var sel_ids = '';
													for(i=0;i<sel.length;i++){
														if(i>0)
															sel_ids += '_';
														sel_ids += sel[i].data.id;
													}
													DeleteParentImsMaintenanceRequest(sel_ids);
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
				text: '<?php __('View ImsMaintenanceRequest'); ?>',
				id: 'view-imsMaintenanceRequest2',
				tooltip:'<?php __('<b>View ImsMaintenanceRequest</b><br />Click here to see details of the selected ImsMaintenanceRequest'); ?>',
				icon: 'img/table_view.png',
				cls: 'x-btn-text-icon',
				disabled: true,
				handler: function(btn) {
					var sm = g.getSelectionModel();
					var sel = sm.getSelected();
					if (sm.hasSelection()){
						ViewImsMaintenanceRequest(sel.data.id);
					};
				},
				menu : {
					items: [
					]
				}

            }, ' ', '->', {
				xtype: 'textfield',
				emptyText: '<?php __('[Search By Name]'); ?>',
				id: 'parent_imsMaintenanceRequest_search_field',
				listeners: {
					specialkey: function(field, e){
						if (e.getKey() == e.ENTER) {
							SearchByParentImsMaintenanceRequestName(Ext.getCmp('parent_imsMaintenanceRequest_search_field').getValue());
						}
					}

				}
			}, {
				xtype: 'tbbutton',
				icon: 'img/search.png',
				cls: 'x-btn-text-icon',
				text: 'GO',
				tooltip:'<?php __('<b>GO</b><br />Click here to get search results'); ?>',
				id: 'parent_imsMaintenanceRequest_go_button',
				handler: function(){
					SearchByParentImsMaintenanceRequestName(Ext.getCmp('parent_imsMaintenanceRequest_search_field').getValue());
				}
			}, ' '
	]}),
	bbar: new Ext.PagingToolbar({
		pageSize: list_size,
		store: store_parent_imsMaintenanceRequests,
		displayInfo: true,
		displayMsg: '<?php __('Displaying {0} - {1} of {2}'); ?>',
		beforePageText: '<?php __('Page'); ?>',
		afterPageText: '<?php __('of {0}'); ?>',
		emptyMsg: '<?php __('No data to display'); ?>'
	})
});
g.getSelectionModel().on('rowselect', function(sm, rowIdx, r) {
	g.getTopToolbar().findById('edit-parent-imsMaintenanceRequest').enable();
	g.getTopToolbar().findById('delete-parent-imsMaintenanceRequest').enable();
        g.getTopToolbar().findById('view-imsMaintenanceRequest2').enable();
	if(this.getSelections().length > 1){
		g.getTopToolbar().findById('edit-parent-imsMaintenanceRequest').disable();
                g.getTopToolbar().findById('view-imsMaintenanceRequest2').disable();
	}
});
g.getSelectionModel().on('rowdeselect', function(sm, rowIdx, r) {
	if(this.getSelections().length > 1){
		g.getTopToolbar().findById('edit-parent-imsMaintenanceRequest').disable();
		g.getTopToolbar().findById('delete-parent-imsMaintenanceRequest').enable();
                g.getTopToolbar().findById('view-imsMaintenanceRequest2').disable();
	}
	else if(this.getSelections().length == 1){
		g.getTopToolbar().findById('edit-parent-imsMaintenanceRequest').enable();
		g.getTopToolbar().findById('delete-parent-imsMaintenanceRequest').enable();
                g.getTopToolbar().findById('view-imsMaintenanceRequest2').enable();
	}
	else{
		g.getTopToolbar().findById('edit-parent-imsMaintenanceRequest').disable();
		g.getTopToolbar().findById('delete-parent-imsMaintenanceRequest').disable();
                g.getTopToolbar().findById('view-imsMaintenanceRequest2').disable();
	}
});



var parentImsMaintenanceRequestsViewWindow = new Ext.Window({
	title: 'ImsMaintenanceRequest Under the selected Item',
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
			parentImsMaintenanceRequestsViewWindow.close();
		}
	}]
});

store_parent_imsMaintenanceRequests.load({
    params: {
        start: 0,    
        limit: list_size
    }
});