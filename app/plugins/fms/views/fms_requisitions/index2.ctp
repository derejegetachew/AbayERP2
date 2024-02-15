var store_parent_fmsRequisitions = new Ext.data.Store({
	reader: new Ext.data.JsonReader({
		root:'rows',
		totalProperty: 'results',
		fields: [
			'id','name','requested_by','approved_by','branch','town','place','departure_date','arrival_date','departure_time','arrival_time','travelers','fms_vehicle','start_odometer','end_odometer','transport_clerk','transport_supervisor','created','modified'	
		]
	}),
	proxy: new Ext.data.HttpProxy({
		url: '<?php echo $this->Html->url(array('controller' => 'fmsRequisitions', 'action' => 'list_data', $parent_id)); ?>'	})
});


function AddParentFmsRequisition() {
	Ext.Ajax.request({
		url: '<?php echo $this->Html->url(array('controller' => 'fmsRequisitions', 'action' => 'add', $parent_id)); ?>',
		success: function(response, opts) {
			var parent_fmsRequisition_data = response.responseText;
			
			eval(parent_fmsRequisition_data);
			
			FmsRequisitionAddWindow.show();
		},
		failure: function(response, opts) {
			Ext.Msg.alert('<?php __('Error'); ?>', '<?php __('Cannot get the fmsRequisition add form. Error code'); ?>: ' + response.status);
		}
	});
}

function EditParentFmsRequisition(id) {
	Ext.Ajax.request({
		url: '<?php echo $this->Html->url(array('controller' => 'fmsRequisitions', 'action' => 'edit')); ?>/'+id+'/<?php echo $parent_id; ?>',
		success: function(response, opts) {
			var parent_fmsRequisition_data = response.responseText;
			
			eval(parent_fmsRequisition_data);
			
			FmsRequisitionEditWindow.show();
		},
		failure: function(response, opts) {
			Ext.Msg.alert('<?php __('Error'); ?>', '<?php __('Cannot get the fmsRequisition edit form. Error code'); ?>: ' + response.status);
		}
	});
}

function ViewFmsRequisition(id) {
	Ext.Ajax.request({
		url: '<?php echo $this->Html->url(array('controller' => 'fmsRequisitions', 'action' => 'view')); ?>/'+id,
		success: function(response, opts) {
			var fmsRequisition_data = response.responseText;

			eval(fmsRequisition_data);

			FmsRequisitionViewWindow.show();
		},
		failure: function(response, opts) {
			Ext.Msg.alert('<?php __('Error'); ?>', '<?php __('Cannot get the fmsRequisition view form. Error code'); ?>: ' + response.status);
		}
	});
}


function DeleteParentFmsRequisition(id) {
	Ext.Ajax.request({
		url: '<?php echo $this->Html->url(array('controller' => 'fmsRequisitions', 'action' => 'delete')); ?>/'+id,
		success: function(response, opts) {
			Ext.Msg.alert('<?php __('Success'); ?>', '<?php __('FmsRequisition(s) successfully deleted!'); ?>');
			RefreshParentFmsRequisitionData();
		},
		failure: function(response, opts) {
			Ext.Msg.alert('<?php __('Error'); ?>', '<?php __('Cannot get the fmsRequisition to be deleted. Error code'); ?>: ' + response.status);
		}
	});
}

function SearchByParentFmsRequisitionName(value){
	var conditions = '\'FmsRequisition.name LIKE\' => \'%' + value + '%\'';
	store_parent_fmsRequisitions.reload({
		 params: {
			start: 0,
			limit: list_size,
			conditions: conditions
	    }
	});
}

function RefreshParentFmsRequisitionData() {
	store_parent_fmsRequisitions.reload();
}



var g = new Ext.grid.GridPanel({
	title: '<?php __('FmsRequisitions'); ?>',
	store: store_parent_fmsRequisitions,
	loadMask: true,
	stripeRows: true,
	height: 300,
	anchor: '100%',
    id: 'fmsRequisitionGrid',
	columns: [
		{header: "<?php __('Name'); ?>", dataIndex: 'name', sortable: true},
		{header: "<?php __('Requested By'); ?>", dataIndex: 'requested_by', sortable: true},
		{header: "<?php __('Approved By'); ?>", dataIndex: 'approved_by', sortable: true},
		{header:"<?php __('branch'); ?>", dataIndex: 'branch', sortable: true},
		{header: "<?php __('Town'); ?>", dataIndex: 'town', sortable: true},
		{header: "<?php __('Place'); ?>", dataIndex: 'place', sortable: true},
		{header: "<?php __('Departure Date'); ?>", dataIndex: 'departure_date', sortable: true},
		{header: "<?php __('Arrival Date'); ?>", dataIndex: 'arrival_date', sortable: true},
		{header: "<?php __('Departure Time'); ?>", dataIndex: 'departure_time', sortable: true},
		{header: "<?php __('Arrival Time'); ?>", dataIndex: 'arrival_time', sortable: true},
		{header: "<?php __('Travelers'); ?>", dataIndex: 'travelers', sortable: true},
		{header:"<?php __('fms_vehicle'); ?>", dataIndex: 'fms_vehicle', sortable: true},
		{header: "<?php __('Start Odometer'); ?>", dataIndex: 'start_odometer', sortable: true},
		{header: "<?php __('End Odometer'); ?>", dataIndex: 'end_odometer', sortable: true},
		{header: "<?php __('Transport Clerk'); ?>", dataIndex: 'transport_clerk', sortable: true},
		{header: "<?php __('Transport Supervisor'); ?>", dataIndex: 'transport_supervisor', sortable: true},
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
            ViewFmsRequisition(Ext.getCmp('fmsRequisitionGrid').getSelectionModel().getSelected().data.id);
        }
    },
	tbar: new Ext.Toolbar({
		items: [{
				xtype: 'tbbutton',
				text: '<?php __('Add'); ?>',
				tooltip:'<?php __('<b>Add FmsRequisition</b><br />Click here to create a new FmsRequisition'); ?>',
				icon: 'img/table_add.png',
				cls: 'x-btn-text-icon',
				handler: function(btn) {
					AddParentFmsRequisition();
				}
			}, ' ', '-', ' ', {
				xtype: 'tbbutton',
				text: '<?php __('Edit'); ?>',
				id: 'edit-parent-fmsRequisition',
				tooltip:'<?php __('<b>Edit FmsRequisition</b><br />Click here to modify the selected FmsRequisition'); ?>',
				icon: 'img/table_edit.png',
				cls: 'x-btn-text-icon',
				disabled: true,
				handler: function(btn) {
					var sm = g.getSelectionModel();
					var sel = sm.getSelected();
					if (sm.hasSelection()){
						EditParentFmsRequisition(sel.data.id);
					};
				}
			}, ' ', '-', ' ', {
				xtype: 'tbbutton',
				text: '<?php __('Delete'); ?>',
				id: 'delete-parent-fmsRequisition',
				tooltip:'<?php __('<b>Delete FmsRequisition(s)</b><br />Click here to remove the selected FmsRequisition(s)'); ?>',
				icon: 'img/table_delete.png',
				cls: 'x-btn-text-icon',
				disabled: true,
				handler: function(btn) {
					var sm = g.getSelectionModel();
					var sel = sm.getSelections();
					if (sm.hasSelection()){
						if(sel.length==1){
							Ext.Msg.show({
									title: '<?php __('Remove FmsRequisition'); ?>',
									buttons: Ext.MessageBox.YESNOCANCEL,
									msg: '<?php __('Remove'); ?> '+sel[0].data.name+'?',
									icon: Ext.MessageBox.QUESTION,
                                    fn: function(btn){
											if (btn == 'yes'){
													DeleteParentFmsRequisition(sel[0].data.id);
											}
									}
							});
						} else {
							Ext.Msg.show({
									title: '<?php __('Remove FmsRequisition'); ?>',
									buttons: Ext.MessageBox.YESNOCANCEL,
									msg: '<?php __('Remove the selected FmsRequisition'); ?>?',
									icon: Ext.MessageBox.QUESTION,
                                    fn: function(btn){
											if (btn == 'yes'){
													var sel_ids = '';
													for(i=0;i<sel.length;i++){
														if(i>0)
															sel_ids += '_';
														sel_ids += sel[i].data.id;
													}
													DeleteParentFmsRequisition(sel_ids);
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
				text: '<?php __('View FmsRequisition'); ?>',
				id: 'view-fmsRequisition2',
				tooltip:'<?php __('<b>View FmsRequisition</b><br />Click here to see details of the selected FmsRequisition'); ?>',
				icon: 'img/table_view.png',
				cls: 'x-btn-text-icon',
				disabled: true,
				handler: function(btn) {
					var sm = g.getSelectionModel();
					var sel = sm.getSelected();
					if (sm.hasSelection()){
						ViewFmsRequisition(sel.data.id);
					};
				},
				menu : {
					items: [
					]
				}

            }, ' ', '->', {
				xtype: 'textfield',
				emptyText: '<?php __('[Search By Name]'); ?>',
				id: 'parent_fmsRequisition_search_field',
				listeners: {
					specialkey: function(field, e){
						if (e.getKey() == e.ENTER) {
							SearchByParentFmsRequisitionName(Ext.getCmp('parent_fmsRequisition_search_field').getValue());
						}
					}

				}
			}, {
				xtype: 'tbbutton',
				icon: 'img/search.png',
				cls: 'x-btn-text-icon',
				text: 'GO',
				tooltip:'<?php __('<b>GO</b><br />Click here to get search results'); ?>',
				id: 'parent_fmsRequisition_go_button',
				handler: function(){
					SearchByParentFmsRequisitionName(Ext.getCmp('parent_fmsRequisition_search_field').getValue());
				}
			}, ' '
	]}),
	bbar: new Ext.PagingToolbar({
		pageSize: list_size,
		store: store_parent_fmsRequisitions,
		displayInfo: true,
		displayMsg: '<?php __('Displaying {0} - {1} of {2}'); ?>',
		beforePageText: '<?php __('Page'); ?>',
		afterPageText: '<?php __('of {0}'); ?>',
		emptyMsg: '<?php __('No data to display'); ?>'
	})
});
g.getSelectionModel().on('rowselect', function(sm, rowIdx, r) {
	g.getTopToolbar().findById('edit-parent-fmsRequisition').enable();
	g.getTopToolbar().findById('delete-parent-fmsRequisition').enable();
        g.getTopToolbar().findById('view-fmsRequisition2').enable();
	if(this.getSelections().length > 1){
		g.getTopToolbar().findById('edit-parent-fmsRequisition').disable();
                g.getTopToolbar().findById('view-fmsRequisition2').disable();
	}
});
g.getSelectionModel().on('rowdeselect', function(sm, rowIdx, r) {
	if(this.getSelections().length > 1){
		g.getTopToolbar().findById('edit-parent-fmsRequisition').disable();
		g.getTopToolbar().findById('delete-parent-fmsRequisition').enable();
                g.getTopToolbar().findById('view-fmsRequisition2').disable();
	}
	else if(this.getSelections().length == 1){
		g.getTopToolbar().findById('edit-parent-fmsRequisition').enable();
		g.getTopToolbar().findById('delete-parent-fmsRequisition').enable();
                g.getTopToolbar().findById('view-fmsRequisition2').enable();
	}
	else{
		g.getTopToolbar().findById('edit-parent-fmsRequisition').disable();
		g.getTopToolbar().findById('delete-parent-fmsRequisition').disable();
                g.getTopToolbar().findById('view-fmsRequisition2').disable();
	}
});



var parentFmsRequisitionsViewWindow = new Ext.Window({
	title: 'FmsRequisition Under the selected Item',
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
			parentFmsRequisitionsViewWindow.close();
		}
	}]
});

store_parent_fmsRequisitions.load({
    params: {
        start: 0,    
        limit: list_size
    }
});