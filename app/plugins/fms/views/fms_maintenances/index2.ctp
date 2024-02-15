var store_parent_fmsMaintenances = new Ext.data.Store({
	reader: new Ext.data.JsonReader({
		root:'rows',
		totalProperty: 'results',
		fields: [
			'id','fms_vehicle','item','serial','measurement','quantity','unit_price','status','created_by','approved_by','created','modified'	
		]
	}),
	proxy: new Ext.data.HttpProxy({
		url: '<?php echo $this->Html->url(array('controller' => 'fmsMaintenances', 'action' => 'list_data', $parent_id)); ?>'	})
});


function AddParentFmsMaintenance() {
	Ext.Ajax.request({
		url: '<?php echo $this->Html->url(array('controller' => 'fmsMaintenances', 'action' => 'add', $parent_id)); ?>',
		success: function(response, opts) {
			var parent_fmsMaintenance_data = response.responseText;
			
			eval(parent_fmsMaintenance_data);
			
			FmsMaintenanceAddWindow.show();
		},
		failure: function(response, opts) {
			Ext.Msg.alert('<?php __('Error'); ?>', '<?php __('Cannot get the fmsMaintenance add form. Error code'); ?>: ' + response.status);
		}
	});
}

function EditParentFmsMaintenance(id) {
	Ext.Ajax.request({
		url: '<?php echo $this->Html->url(array('controller' => 'fmsMaintenances', 'action' => 'edit')); ?>/'+id+'/<?php echo $parent_id; ?>',
		success: function(response, opts) {
			var parent_fmsMaintenance_data = response.responseText;
			
			eval(parent_fmsMaintenance_data);
			
			FmsMaintenanceEditWindow.show();
		},
		failure: function(response, opts) {
			Ext.Msg.alert('<?php __('Error'); ?>', '<?php __('Cannot get the fmsMaintenance edit form. Error code'); ?>: ' + response.status);
		}
	});
}

function ViewFmsMaintenance(id) {
	Ext.Ajax.request({
		url: '<?php echo $this->Html->url(array('controller' => 'fmsMaintenances', 'action' => 'view')); ?>/'+id,
		success: function(response, opts) {
			var fmsMaintenance_data = response.responseText;

			eval(fmsMaintenance_data);

			FmsMaintenanceViewWindow.show();
		},
		failure: function(response, opts) {
			Ext.Msg.alert('<?php __('Error'); ?>', '<?php __('Cannot get the fmsMaintenance view form. Error code'); ?>: ' + response.status);
		}
	});
}


function DeleteParentFmsMaintenance(id) {
	Ext.Ajax.request({
		url: '<?php echo $this->Html->url(array('controller' => 'fmsMaintenances', 'action' => 'delete')); ?>/'+id,
		success: function(response, opts) {
			Ext.Msg.alert('<?php __('Success'); ?>', '<?php __('FmsMaintenance(s) successfully deleted!'); ?>');
			RefreshParentFmsMaintenanceData();
		},
		failure: function(response, opts) {
			Ext.Msg.alert('<?php __('Error'); ?>', '<?php __('Cannot get the fmsMaintenance to be deleted. Error code'); ?>: ' + response.status);
		}
	});
}

function SearchByParentFmsMaintenanceName(value){
	var conditions = '\'FmsMaintenance.name LIKE\' => \'%' + value + '%\'';
	store_parent_fmsMaintenances.reload({
		 params: {
			start: 0,
			limit: list_size,
			conditions: conditions
	    }
	});
}

function RefreshParentFmsMaintenanceData() {
	store_parent_fmsMaintenances.reload();
}



var g = new Ext.grid.GridPanel({
	title: '<?php __('FmsMaintenances'); ?>',
	store: store_parent_fmsMaintenances,
	loadMask: true,
	stripeRows: true,
	height: 300,
	anchor: '100%',
    id: 'fmsMaintenanceGrid',
	columns: [
		{header:"<?php __('fms_vehicle'); ?>", dataIndex: 'fms_vehicle', sortable: true},
		{header: "<?php __('Item'); ?>", dataIndex: 'item', sortable: true},
		{header: "<?php __('Serial'); ?>", dataIndex: 'serial', sortable: true},
		{header: "<?php __('Measurement'); ?>", dataIndex: 'measurement', sortable: true},
		{header: "<?php __('Quantity'); ?>", dataIndex: 'quantity', sortable: true},
		{header: "<?php __('Unit Price'); ?>", dataIndex: 'unit_price', sortable: true},
		{header: "<?php __('Status'); ?>", dataIndex: 'status', sortable: true},
		{header: "<?php __('Created By'); ?>", dataIndex: 'created_by', sortable: true},
		{header: "<?php __('Approved By'); ?>", dataIndex: 'approved_by', sortable: true},
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
            ViewFmsMaintenance(Ext.getCmp('fmsMaintenanceGrid').getSelectionModel().getSelected().data.id);
        }
    },
	tbar: new Ext.Toolbar({
		items: [{
				xtype: 'tbbutton',
				text: '<?php __('Add'); ?>',
				tooltip:'<?php __('<b>Add FmsMaintenance</b><br />Click here to create a new FmsMaintenance'); ?>',
				icon: 'img/table_add.png',
				cls: 'x-btn-text-icon',
				handler: function(btn) {
					AddParentFmsMaintenance();
				}
			}, ' ', '-', ' ', {
				xtype: 'tbbutton',
				text: '<?php __('Edit'); ?>',
				id: 'edit-parent-fmsMaintenance',
				tooltip:'<?php __('<b>Edit FmsMaintenance</b><br />Click here to modify the selected FmsMaintenance'); ?>',
				icon: 'img/table_edit.png',
				cls: 'x-btn-text-icon',
				disabled: true,
				handler: function(btn) {
					var sm = g.getSelectionModel();
					var sel = sm.getSelected();
					if (sm.hasSelection()){
						EditParentFmsMaintenance(sel.data.id);
					};
				}
			}, ' ', '-', ' ', {
				xtype: 'tbbutton',
				text: '<?php __('Delete'); ?>',
				id: 'delete-parent-fmsMaintenance',
				tooltip:'<?php __('<b>Delete FmsMaintenance(s)</b><br />Click here to remove the selected FmsMaintenance(s)'); ?>',
				icon: 'img/table_delete.png',
				cls: 'x-btn-text-icon',
				disabled: true,
				handler: function(btn) {
					var sm = g.getSelectionModel();
					var sel = sm.getSelections();
					if (sm.hasSelection()){
						if(sel.length==1){
							Ext.Msg.show({
									title: '<?php __('Remove FmsMaintenance'); ?>',
									buttons: Ext.MessageBox.YESNOCANCEL,
									msg: '<?php __('Remove'); ?> '+sel[0].data.name+'?',
									icon: Ext.MessageBox.QUESTION,
                                    fn: function(btn){
											if (btn == 'yes'){
													DeleteParentFmsMaintenance(sel[0].data.id);
											}
									}
							});
						} else {
							Ext.Msg.show({
									title: '<?php __('Remove FmsMaintenance'); ?>',
									buttons: Ext.MessageBox.YESNOCANCEL,
									msg: '<?php __('Remove the selected FmsMaintenance'); ?>?',
									icon: Ext.MessageBox.QUESTION,
                                    fn: function(btn){
											if (btn == 'yes'){
													var sel_ids = '';
													for(i=0;i<sel.length;i++){
														if(i>0)
															sel_ids += '_';
														sel_ids += sel[i].data.id;
													}
													DeleteParentFmsMaintenance(sel_ids);
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
				text: '<?php __('View FmsMaintenance'); ?>',
				id: 'view-fmsMaintenance2',
				tooltip:'<?php __('<b>View FmsMaintenance</b><br />Click here to see details of the selected FmsMaintenance'); ?>',
				icon: 'img/table_view.png',
				cls: 'x-btn-text-icon',
				disabled: true,
				handler: function(btn) {
					var sm = g.getSelectionModel();
					var sel = sm.getSelected();
					if (sm.hasSelection()){
						ViewFmsMaintenance(sel.data.id);
					};
				},
				menu : {
					items: [
					]
				}

            }, ' ', '->', {
				xtype: 'textfield',
				emptyText: '<?php __('[Search By Name]'); ?>',
				id: 'parent_fmsMaintenance_search_field',
				listeners: {
					specialkey: function(field, e){
						if (e.getKey() == e.ENTER) {
							SearchByParentFmsMaintenanceName(Ext.getCmp('parent_fmsMaintenance_search_field').getValue());
						}
					}

				}
			}, {
				xtype: 'tbbutton',
				icon: 'img/search.png',
				cls: 'x-btn-text-icon',
				text: 'GO',
				tooltip:'<?php __('<b>GO</b><br />Click here to get search results'); ?>',
				id: 'parent_fmsMaintenance_go_button',
				handler: function(){
					SearchByParentFmsMaintenanceName(Ext.getCmp('parent_fmsMaintenance_search_field').getValue());
				}
			}, ' '
	]}),
	bbar: new Ext.PagingToolbar({
		pageSize: list_size,
		store: store_parent_fmsMaintenances,
		displayInfo: true,
		displayMsg: '<?php __('Displaying {0} - {1} of {2}'); ?>',
		beforePageText: '<?php __('Page'); ?>',
		afterPageText: '<?php __('of {0}'); ?>',
		emptyMsg: '<?php __('No data to display'); ?>'
	})
});
g.getSelectionModel().on('rowselect', function(sm, rowIdx, r) {
	g.getTopToolbar().findById('edit-parent-fmsMaintenance').enable();
	g.getTopToolbar().findById('delete-parent-fmsMaintenance').enable();
        g.getTopToolbar().findById('view-fmsMaintenance2').enable();
	if(this.getSelections().length > 1){
		g.getTopToolbar().findById('edit-parent-fmsMaintenance').disable();
                g.getTopToolbar().findById('view-fmsMaintenance2').disable();
	}
});
g.getSelectionModel().on('rowdeselect', function(sm, rowIdx, r) {
	if(this.getSelections().length > 1){
		g.getTopToolbar().findById('edit-parent-fmsMaintenance').disable();
		g.getTopToolbar().findById('delete-parent-fmsMaintenance').enable();
                g.getTopToolbar().findById('view-fmsMaintenance2').disable();
	}
	else if(this.getSelections().length == 1){
		g.getTopToolbar().findById('edit-parent-fmsMaintenance').enable();
		g.getTopToolbar().findById('delete-parent-fmsMaintenance').enable();
                g.getTopToolbar().findById('view-fmsMaintenance2').enable();
	}
	else{
		g.getTopToolbar().findById('edit-parent-fmsMaintenance').disable();
		g.getTopToolbar().findById('delete-parent-fmsMaintenance').disable();
                g.getTopToolbar().findById('view-fmsMaintenance2').disable();
	}
});



var parentFmsMaintenancesViewWindow = new Ext.Window({
	title: 'FmsMaintenance Under the selected Item',
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
			parentFmsMaintenancesViewWindow.close();
		}
	}]
});

store_parent_fmsMaintenances.load({
    params: {
        start: 0,    
        limit: list_size
    }
});