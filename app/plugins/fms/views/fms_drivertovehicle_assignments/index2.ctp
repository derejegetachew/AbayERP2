var store_parent_fmsDrivertovehicleAssignments = new Ext.data.Store({
	reader: new Ext.data.JsonReader({
		root:'rows',
		totalProperty: 'results',
		fields: [
			'id','fms_driver','fms_vehicle','start_date','end_date','created_by','created','modified'	
		]
	}),
	proxy: new Ext.data.HttpProxy({
		url: '<?php echo $this->Html->url(array('controller' => 'fmsDrivertovehicleAssignments', 'action' => 'list_data', $parent_id)); ?>'	})
});


function AddParentFmsDrivertovehicleAssignment() {
	Ext.Ajax.request({
		url: '<?php echo $this->Html->url(array('controller' => 'fmsDrivertovehicleAssignments', 'action' => 'add', $parent_id)); ?>',
		success: function(response, opts) {
			var parent_fmsDrivertovehicleAssignment_data = response.responseText;
			
			eval(parent_fmsDrivertovehicleAssignment_data);
			
			FmsDrivertovehicleAssignmentAddWindow.show();
		},
		failure: function(response, opts) {
			Ext.Msg.alert('<?php __('Error'); ?>', '<?php __('Cannot get the fmsDrivertovehicleAssignment add form. Error code'); ?>: ' + response.status);
		}
	});
}

function EditParentFmsDrivertovehicleAssignment(id) {
	Ext.Ajax.request({
		url: '<?php echo $this->Html->url(array('controller' => 'fmsDrivertovehicleAssignments', 'action' => 'edit')); ?>/'+id+'/<?php echo $parent_id; ?>',
		success: function(response, opts) {
			var parent_fmsDrivertovehicleAssignment_data = response.responseText;
			
			eval(parent_fmsDrivertovehicleAssignment_data);
			
			FmsDrivertovehicleAssignmentEditWindow.show();
		},
		failure: function(response, opts) {
			Ext.Msg.alert('<?php __('Error'); ?>', '<?php __('Cannot get the fmsDrivertovehicleAssignment edit form. Error code'); ?>: ' + response.status);
		}
	});
}

function ViewFmsDrivertovehicleAssignment(id) {
	Ext.Ajax.request({
		url: '<?php echo $this->Html->url(array('controller' => 'fmsDrivertovehicleAssignments', 'action' => 'view')); ?>/'+id,
		success: function(response, opts) {
			var fmsDrivertovehicleAssignment_data = response.responseText;

			eval(fmsDrivertovehicleAssignment_data);

			FmsDrivertovehicleAssignmentViewWindow.show();
		},
		failure: function(response, opts) {
			Ext.Msg.alert('<?php __('Error'); ?>', '<?php __('Cannot get the fmsDrivertovehicleAssignment view form. Error code'); ?>: ' + response.status);
		}
	});
}


function DeleteParentFmsDrivertovehicleAssignment(id) {
	Ext.Ajax.request({
		url: '<?php echo $this->Html->url(array('controller' => 'fmsDrivertovehicleAssignments', 'action' => 'delete')); ?>/'+id,
		success: function(response, opts) {
			Ext.Msg.alert('<?php __('Success'); ?>', '<?php __('FmsDrivertovehicleAssignment(s) successfully deleted!'); ?>');
			RefreshParentFmsDrivertovehicleAssignmentData();
		},
		failure: function(response, opts) {
			Ext.Msg.alert('<?php __('Error'); ?>', '<?php __('Cannot get the fmsDrivertovehicleAssignment to be deleted. Error code'); ?>: ' + response.status);
		}
	});
}

function SearchByParentFmsDrivertovehicleAssignmentName(value){
	var conditions = '\'FmsDrivertovehicleAssignment.name LIKE\' => \'%' + value + '%\'';
	store_parent_fmsDrivertovehicleAssignments.reload({
		 params: {
			start: 0,
			limit: list_size,
			conditions: conditions
	    }
	});
}

function RefreshParentFmsDrivertovehicleAssignmentData() {
	store_parent_fmsDrivertovehicleAssignments.reload();
}



var g = new Ext.grid.GridPanel({
	title: '<?php __('FmsDrivertovehicleAssignments'); ?>',
	store: store_parent_fmsDrivertovehicleAssignments,
	loadMask: true,
	stripeRows: true,
	height: 300,
	anchor: '100%',
    id: 'fmsDrivertovehicleAssignmentGrid',
	columns: [
		{header:"<?php __('fms_driver'); ?>", dataIndex: 'fms_driver', sortable: true},
		{header:"<?php __('fms_vehicle'); ?>", dataIndex: 'fms_vehicle', sortable: true},
		{header: "<?php __('Start Date'); ?>", dataIndex: 'start_date', sortable: true},
		{header: "<?php __('End Date'); ?>", dataIndex: 'end_date', sortable: true},
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
            ViewFmsDrivertovehicleAssignment(Ext.getCmp('fmsDrivertovehicleAssignmentGrid').getSelectionModel().getSelected().data.id);
        }
    },
	tbar: new Ext.Toolbar({
		items: [{
				xtype: 'tbbutton',
				text: '<?php __('Add'); ?>',
				tooltip:'<?php __('<b>Add FmsDrivertovehicleAssignment</b><br />Click here to create a new FmsDrivertovehicleAssignment'); ?>',
				icon: 'img/table_add.png',
				cls: 'x-btn-text-icon',
				handler: function(btn) {
					AddParentFmsDrivertovehicleAssignment();
				}
			}, ' ', '-', ' ', {
				xtype: 'tbbutton',
				text: '<?php __('Edit'); ?>',
				id: 'edit-parent-fmsDrivertovehicleAssignment',
				tooltip:'<?php __('<b>Edit FmsDrivertovehicleAssignment</b><br />Click here to modify the selected FmsDrivertovehicleAssignment'); ?>',
				icon: 'img/table_edit.png',
				cls: 'x-btn-text-icon',
				disabled: true,
				handler: function(btn) {
					var sm = g.getSelectionModel();
					var sel = sm.getSelected();
					if (sm.hasSelection()){
						EditParentFmsDrivertovehicleAssignment(sel.data.id);
					};
				}
			}, ' ', '-', ' ', {
				xtype: 'tbbutton',
				text: '<?php __('Delete'); ?>',
				id: 'delete-parent-fmsDrivertovehicleAssignment',
				tooltip:'<?php __('<b>Delete FmsDrivertovehicleAssignment(s)</b><br />Click here to remove the selected FmsDrivertovehicleAssignment(s)'); ?>',
				icon: 'img/table_delete.png',
				cls: 'x-btn-text-icon',
				disabled: true,
				handler: function(btn) {
					var sm = g.getSelectionModel();
					var sel = sm.getSelections();
					if (sm.hasSelection()){
						if(sel.length==1){
							Ext.Msg.show({
									title: '<?php __('Remove FmsDrivertovehicleAssignment'); ?>',
									buttons: Ext.MessageBox.YESNOCANCEL,
									msg: '<?php __('Remove'); ?> '+sel[0].data.name+'?',
									icon: Ext.MessageBox.QUESTION,
                                    fn: function(btn){
											if (btn == 'yes'){
													DeleteParentFmsDrivertovehicleAssignment(sel[0].data.id);
											}
									}
							});
						} else {
							Ext.Msg.show({
									title: '<?php __('Remove FmsDrivertovehicleAssignment'); ?>',
									buttons: Ext.MessageBox.YESNOCANCEL,
									msg: '<?php __('Remove the selected FmsDrivertovehicleAssignment'); ?>?',
									icon: Ext.MessageBox.QUESTION,
                                    fn: function(btn){
											if (btn == 'yes'){
													var sel_ids = '';
													for(i=0;i<sel.length;i++){
														if(i>0)
															sel_ids += '_';
														sel_ids += sel[i].data.id;
													}
													DeleteParentFmsDrivertovehicleAssignment(sel_ids);
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
				text: '<?php __('View FmsDrivertovehicleAssignment'); ?>',
				id: 'view-fmsDrivertovehicleAssignment2',
				tooltip:'<?php __('<b>View FmsDrivertovehicleAssignment</b><br />Click here to see details of the selected FmsDrivertovehicleAssignment'); ?>',
				icon: 'img/table_view.png',
				cls: 'x-btn-text-icon',
				disabled: true,
				handler: function(btn) {
					var sm = g.getSelectionModel();
					var sel = sm.getSelected();
					if (sm.hasSelection()){
						ViewFmsDrivertovehicleAssignment(sel.data.id);
					};
				},
				menu : {
					items: [
					]
				}

            }, ' ', '->', {
				xtype: 'textfield',
				emptyText: '<?php __('[Search By Name]'); ?>',
				id: 'parent_fmsDrivertovehicleAssignment_search_field',
				listeners: {
					specialkey: function(field, e){
						if (e.getKey() == e.ENTER) {
							SearchByParentFmsDrivertovehicleAssignmentName(Ext.getCmp('parent_fmsDrivertovehicleAssignment_search_field').getValue());
						}
					}

				}
			}, {
				xtype: 'tbbutton',
				icon: 'img/search.png',
				cls: 'x-btn-text-icon',
				text: 'GO',
				tooltip:'<?php __('<b>GO</b><br />Click here to get search results'); ?>',
				id: 'parent_fmsDrivertovehicleAssignment_go_button',
				handler: function(){
					SearchByParentFmsDrivertovehicleAssignmentName(Ext.getCmp('parent_fmsDrivertovehicleAssignment_search_field').getValue());
				}
			}, ' '
	]}),
	bbar: new Ext.PagingToolbar({
		pageSize: list_size,
		store: store_parent_fmsDrivertovehicleAssignments,
		displayInfo: true,
		displayMsg: '<?php __('Displaying {0} - {1} of {2}'); ?>',
		beforePageText: '<?php __('Page'); ?>',
		afterPageText: '<?php __('of {0}'); ?>',
		emptyMsg: '<?php __('No data to display'); ?>'
	})
});
g.getSelectionModel().on('rowselect', function(sm, rowIdx, r) {
	g.getTopToolbar().findById('edit-parent-fmsDrivertovehicleAssignment').enable();
	g.getTopToolbar().findById('delete-parent-fmsDrivertovehicleAssignment').enable();
        g.getTopToolbar().findById('view-fmsDrivertovehicleAssignment2').enable();
	if(this.getSelections().length > 1){
		g.getTopToolbar().findById('edit-parent-fmsDrivertovehicleAssignment').disable();
                g.getTopToolbar().findById('view-fmsDrivertovehicleAssignment2').disable();
	}
});
g.getSelectionModel().on('rowdeselect', function(sm, rowIdx, r) {
	if(this.getSelections().length > 1){
		g.getTopToolbar().findById('edit-parent-fmsDrivertovehicleAssignment').disable();
		g.getTopToolbar().findById('delete-parent-fmsDrivertovehicleAssignment').enable();
                g.getTopToolbar().findById('view-fmsDrivertovehicleAssignment2').disable();
	}
	else if(this.getSelections().length == 1){
		g.getTopToolbar().findById('edit-parent-fmsDrivertovehicleAssignment').enable();
		g.getTopToolbar().findById('delete-parent-fmsDrivertovehicleAssignment').enable();
                g.getTopToolbar().findById('view-fmsDrivertovehicleAssignment2').enable();
	}
	else{
		g.getTopToolbar().findById('edit-parent-fmsDrivertovehicleAssignment').disable();
		g.getTopToolbar().findById('delete-parent-fmsDrivertovehicleAssignment').disable();
                g.getTopToolbar().findById('view-fmsDrivertovehicleAssignment2').disable();
	}
});



var parentFmsDrivertovehicleAssignmentsViewWindow = new Ext.Window({
	title: 'FmsDrivertovehicleAssignment Under the selected Item',
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
			parentFmsDrivertovehicleAssignmentsViewWindow.close();
		}
	}]
});

store_parent_fmsDrivertovehicleAssignments.load({
    params: {
        start: 0,    
        limit: list_size
    }
});