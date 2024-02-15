var store_parent_fmsIncidents = new Ext.data.Store({
	reader: new Ext.data.JsonReader({
		root:'rows',
		totalProperty: 'results',
		fields: [
			'id','fms_vehicle','occurrence_date','occurrence_time','occurrence_place','details','action_taken','created_by','created','modified'	
		]
	}),
	proxy: new Ext.data.HttpProxy({
		url: '<?php echo $this->Html->url(array('controller' => 'fmsIncidents', 'action' => 'list_data', $parent_id)); ?>'	})
});


function AddParentFmsIncident() {
	Ext.Ajax.request({
		url: '<?php echo $this->Html->url(array('controller' => 'fmsIncidents', 'action' => 'add', $parent_id)); ?>',
		success: function(response, opts) {
			var parent_fmsIncident_data = response.responseText;
			
			eval(parent_fmsIncident_data);
			
			FmsIncidentAddWindow.show();
		},
		failure: function(response, opts) {
			Ext.Msg.alert('<?php __('Error'); ?>', '<?php __('Cannot get the fmsIncident add form. Error code'); ?>: ' + response.status);
		}
	});
}

function EditParentFmsIncident(id) {
	Ext.Ajax.request({
		url: '<?php echo $this->Html->url(array('controller' => 'fmsIncidents', 'action' => 'edit')); ?>/'+id+'/<?php echo $parent_id; ?>',
		success: function(response, opts) {
			var parent_fmsIncident_data = response.responseText;
			
			eval(parent_fmsIncident_data);
			
			FmsIncidentEditWindow.show();
		},
		failure: function(response, opts) {
			Ext.Msg.alert('<?php __('Error'); ?>', '<?php __('Cannot get the fmsIncident edit form. Error code'); ?>: ' + response.status);
		}
	});
}

function ViewFmsIncident(id) {
	Ext.Ajax.request({
		url: '<?php echo $this->Html->url(array('controller' => 'fmsIncidents', 'action' => 'view')); ?>/'+id,
		success: function(response, opts) {
			var fmsIncident_data = response.responseText;

			eval(fmsIncident_data);

			FmsIncidentViewWindow.show();
		},
		failure: function(response, opts) {
			Ext.Msg.alert('<?php __('Error'); ?>', '<?php __('Cannot get the fmsIncident view form. Error code'); ?>: ' + response.status);
		}
	});
}


function DeleteParentFmsIncident(id) {
	Ext.Ajax.request({
		url: '<?php echo $this->Html->url(array('controller' => 'fmsIncidents', 'action' => 'delete')); ?>/'+id,
		success: function(response, opts) {
			Ext.Msg.alert('<?php __('Success'); ?>', '<?php __('FmsIncident(s) successfully deleted!'); ?>');
			RefreshParentFmsIncidentData();
		},
		failure: function(response, opts) {
			Ext.Msg.alert('<?php __('Error'); ?>', '<?php __('Cannot get the fmsIncident to be deleted. Error code'); ?>: ' + response.status);
		}
	});
}

function SearchByParentFmsIncidentName(value){
	var conditions = '\'FmsIncident.name LIKE\' => \'%' + value + '%\'';
	store_parent_fmsIncidents.reload({
		 params: {
			start: 0,
			limit: list_size,
			conditions: conditions
	    }
	});
}

function RefreshParentFmsIncidentData() {
	store_parent_fmsIncidents.reload();
}



var g = new Ext.grid.GridPanel({
	title: '<?php __('FmsIncidents'); ?>',
	store: store_parent_fmsIncidents,
	loadMask: true,
	stripeRows: true,
	height: 300,
	anchor: '100%',
    id: 'fmsIncidentGrid',
	columns: [
		{header:"<?php __('fms_vehicle'); ?>", dataIndex: 'fms_vehicle', sortable: true},
		{header: "<?php __('Occurrence Date'); ?>", dataIndex: 'occurrence_date', sortable: true},
		{header: "<?php __('Occurrence Time'); ?>", dataIndex: 'occurrence_time', sortable: true},
		{header: "<?php __('Occurrence Place'); ?>", dataIndex: 'occurrence_place', sortable: true},
		{header: "<?php __('Details'); ?>", dataIndex: 'details', sortable: true},
		{header: "<?php __('Action Taken'); ?>", dataIndex: 'action_taken', sortable: true},
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
            ViewFmsIncident(Ext.getCmp('fmsIncidentGrid').getSelectionModel().getSelected().data.id);
        }
    },
	tbar: new Ext.Toolbar({
		items: [{
				xtype: 'tbbutton',
				text: '<?php __('Add'); ?>',
				tooltip:'<?php __('<b>Add FmsIncident</b><br />Click here to create a new FmsIncident'); ?>',
				icon: 'img/table_add.png',
				cls: 'x-btn-text-icon',
				handler: function(btn) {
					AddParentFmsIncident();
				}
			}, ' ', '-', ' ', {
				xtype: 'tbbutton',
				text: '<?php __('Edit'); ?>',
				id: 'edit-parent-fmsIncident',
				tooltip:'<?php __('<b>Edit FmsIncident</b><br />Click here to modify the selected FmsIncident'); ?>',
				icon: 'img/table_edit.png',
				cls: 'x-btn-text-icon',
				disabled: true,
				handler: function(btn) {
					var sm = g.getSelectionModel();
					var sel = sm.getSelected();
					if (sm.hasSelection()){
						EditParentFmsIncident(sel.data.id);
					};
				}
			}, ' ', '-', ' ', {
				xtype: 'tbbutton',
				text: '<?php __('Delete'); ?>',
				id: 'delete-parent-fmsIncident',
				tooltip:'<?php __('<b>Delete FmsIncident(s)</b><br />Click here to remove the selected FmsIncident(s)'); ?>',
				icon: 'img/table_delete.png',
				cls: 'x-btn-text-icon',
				disabled: true,
				handler: function(btn) {
					var sm = g.getSelectionModel();
					var sel = sm.getSelections();
					if (sm.hasSelection()){
						if(sel.length==1){
							Ext.Msg.show({
									title: '<?php __('Remove FmsIncident'); ?>',
									buttons: Ext.MessageBox.YESNOCANCEL,
									msg: '<?php __('Remove'); ?> '+sel[0].data.name+'?',
									icon: Ext.MessageBox.QUESTION,
                                    fn: function(btn){
											if (btn == 'yes'){
													DeleteParentFmsIncident(sel[0].data.id);
											}
									}
							});
						} else {
							Ext.Msg.show({
									title: '<?php __('Remove FmsIncident'); ?>',
									buttons: Ext.MessageBox.YESNOCANCEL,
									msg: '<?php __('Remove the selected FmsIncident'); ?>?',
									icon: Ext.MessageBox.QUESTION,
                                    fn: function(btn){
											if (btn == 'yes'){
													var sel_ids = '';
													for(i=0;i<sel.length;i++){
														if(i>0)
															sel_ids += '_';
														sel_ids += sel[i].data.id;
													}
													DeleteParentFmsIncident(sel_ids);
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
				text: '<?php __('View FmsIncident'); ?>',
				id: 'view-fmsIncident2',
				tooltip:'<?php __('<b>View FmsIncident</b><br />Click here to see details of the selected FmsIncident'); ?>',
				icon: 'img/table_view.png',
				cls: 'x-btn-text-icon',
				disabled: true,
				handler: function(btn) {
					var sm = g.getSelectionModel();
					var sel = sm.getSelected();
					if (sm.hasSelection()){
						ViewFmsIncident(sel.data.id);
					};
				},
				menu : {
					items: [
					]
				}

            }, ' ', '->', {
				xtype: 'textfield',
				emptyText: '<?php __('[Search By Name]'); ?>',
				id: 'parent_fmsIncident_search_field',
				listeners: {
					specialkey: function(field, e){
						if (e.getKey() == e.ENTER) {
							SearchByParentFmsIncidentName(Ext.getCmp('parent_fmsIncident_search_field').getValue());
						}
					}

				}
			}, {
				xtype: 'tbbutton',
				icon: 'img/search.png',
				cls: 'x-btn-text-icon',
				text: 'GO',
				tooltip:'<?php __('<b>GO</b><br />Click here to get search results'); ?>',
				id: 'parent_fmsIncident_go_button',
				handler: function(){
					SearchByParentFmsIncidentName(Ext.getCmp('parent_fmsIncident_search_field').getValue());
				}
			}, ' '
	]}),
	bbar: new Ext.PagingToolbar({
		pageSize: list_size,
		store: store_parent_fmsIncidents,
		displayInfo: true,
		displayMsg: '<?php __('Displaying {0} - {1} of {2}'); ?>',
		beforePageText: '<?php __('Page'); ?>',
		afterPageText: '<?php __('of {0}'); ?>',
		emptyMsg: '<?php __('No data to display'); ?>'
	})
});
g.getSelectionModel().on('rowselect', function(sm, rowIdx, r) {
	g.getTopToolbar().findById('edit-parent-fmsIncident').enable();
	g.getTopToolbar().findById('delete-parent-fmsIncident').enable();
        g.getTopToolbar().findById('view-fmsIncident2').enable();
	if(this.getSelections().length > 1){
		g.getTopToolbar().findById('edit-parent-fmsIncident').disable();
                g.getTopToolbar().findById('view-fmsIncident2').disable();
	}
});
g.getSelectionModel().on('rowdeselect', function(sm, rowIdx, r) {
	if(this.getSelections().length > 1){
		g.getTopToolbar().findById('edit-parent-fmsIncident').disable();
		g.getTopToolbar().findById('delete-parent-fmsIncident').enable();
                g.getTopToolbar().findById('view-fmsIncident2').disable();
	}
	else if(this.getSelections().length == 1){
		g.getTopToolbar().findById('edit-parent-fmsIncident').enable();
		g.getTopToolbar().findById('delete-parent-fmsIncident').enable();
                g.getTopToolbar().findById('view-fmsIncident2').enable();
	}
	else{
		g.getTopToolbar().findById('edit-parent-fmsIncident').disable();
		g.getTopToolbar().findById('delete-parent-fmsIncident').disable();
                g.getTopToolbar().findById('view-fmsIncident2').disable();
	}
});



var parentFmsIncidentsViewWindow = new Ext.Window({
	title: 'FmsIncident Under the selected Item',
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
			parentFmsIncidentsViewWindow.close();
		}
	}]
});

store_parent_fmsIncidents.load({
    params: {
        start: 0,    
        limit: list_size
    }
});