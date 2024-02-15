var store_parent_branchPerformanceTrackingStatuses = new Ext.data.Store({
	reader: new Ext.data.JsonReader({
		root:'rows',
		totalProperty: 'results',
		fields: [
			'id','employee','budget_year','quarter','result_status'	
		]
	}),
	proxy: new Ext.data.HttpProxy({
		url: '<?php echo $this->Html->url(array('controller' => 'branchPerformanceTrackingStatuses', 'action' => 'list_data', $parent_id)); ?>'	})
});


function AddParentBranchPerformanceTrackingStatus() {
	Ext.Ajax.request({
		url: '<?php echo $this->Html->url(array('controller' => 'branchPerformanceTrackingStatuses', 'action' => 'add', $parent_id)); ?>',
		success: function(response, opts) {
			var parent_branchPerformanceTrackingStatus_data = response.responseText;
			
			eval(parent_branchPerformanceTrackingStatus_data);
			
			BranchPerformanceTrackingStatusAddWindow.show();
		},
		failure: function(response, opts) {
			Ext.Msg.alert('<?php __('Error'); ?>', '<?php __('Cannot get the branchPerformanceTrackingStatus add form. Error code'); ?>: ' + response.status);
		}
	});
}

function EditParentBranchPerformanceTrackingStatus(id) {
	Ext.Ajax.request({
		url: '<?php echo $this->Html->url(array('controller' => 'branchPerformanceTrackingStatuses', 'action' => 'edit')); ?>/'+id+'/<?php echo $parent_id; ?>',
		success: function(response, opts) {
			var parent_branchPerformanceTrackingStatus_data = response.responseText;
			
			eval(parent_branchPerformanceTrackingStatus_data);
			
			BranchPerformanceTrackingStatusEditWindow.show();
		},
		failure: function(response, opts) {
			Ext.Msg.alert('<?php __('Error'); ?>', '<?php __('Cannot get the branchPerformanceTrackingStatus edit form. Error code'); ?>: ' + response.status);
		}
	});
}

function ViewBranchPerformanceTrackingStatus(id) {
	Ext.Ajax.request({
		url: '<?php echo $this->Html->url(array('controller' => 'branchPerformanceTrackingStatuses', 'action' => 'view')); ?>/'+id,
		success: function(response, opts) {
			var branchPerformanceTrackingStatus_data = response.responseText;

			eval(branchPerformanceTrackingStatus_data);

			BranchPerformanceTrackingStatusViewWindow.show();
		},
		failure: function(response, opts) {
			Ext.Msg.alert('<?php __('Error'); ?>', '<?php __('Cannot get the branchPerformanceTrackingStatus view form. Error code'); ?>: ' + response.status);
		}
	});
}


function DeleteParentBranchPerformanceTrackingStatus(id) {
	Ext.Ajax.request({
		url: '<?php echo $this->Html->url(array('controller' => 'branchPerformanceTrackingStatuses', 'action' => 'delete')); ?>/'+id,
		success: function(response, opts) {
			Ext.Msg.alert('<?php __('Success'); ?>', '<?php __('BranchPerformanceTrackingStatus(s) successfully deleted!'); ?>');
			RefreshParentBranchPerformanceTrackingStatusData();
		},
		failure: function(response, opts) {
			Ext.Msg.alert('<?php __('Error'); ?>', '<?php __('Cannot get the branchPerformanceTrackingStatus to be deleted. Error code'); ?>: ' + response.status);
		}
	});
}

function SearchByParentBranchPerformanceTrackingStatusName(value){
	var conditions = '\'BranchPerformanceTrackingStatus.name LIKE\' => \'%' + value + '%\'';
	store_parent_branchPerformanceTrackingStatuses.reload({
		 params: {
			start: 0,
			limit: list_size,
			conditions: conditions
	    }
	});
}

function RefreshParentBranchPerformanceTrackingStatusData() {
	store_parent_branchPerformanceTrackingStatuses.reload();
}



var g = new Ext.grid.GridPanel({
	title: '<?php __('BranchPerformanceTrackingStatuses'); ?>',
	store: store_parent_branchPerformanceTrackingStatuses,
	loadMask: true,
	stripeRows: true,
	height: 300,
	anchor: '100%',
    id: 'branchPerformanceTrackingStatusGrid',
	columns: [
		{header:"<?php __('employee'); ?>", dataIndex: 'employee', sortable: true},
		{header:"<?php __('budget_year'); ?>", dataIndex: 'budget_year', sortable: true},
		{header: "<?php __('Quarter'); ?>", dataIndex: 'quarter', sortable: true},
		{header: "<?php __('Result Status'); ?>", dataIndex: 'result_status', sortable: true}	],
	sm: new Ext.grid.RowSelectionModel({
		singleSelect: false
	}),
	viewConfig: {
		forceFit: true
	},
    listeners: {
        celldblclick: function(){
            ViewBranchPerformanceTrackingStatus(Ext.getCmp('branchPerformanceTrackingStatusGrid').getSelectionModel().getSelected().data.id);
        }
    },
	tbar: new Ext.Toolbar({
		items: [{
				xtype: 'tbbutton',
				text: '<?php __('Add'); ?>',
				tooltip:'<?php __('<b>Add BranchPerformanceTrackingStatus</b><br />Click here to create a new BranchPerformanceTrackingStatus'); ?>',
				icon: 'img/table_add.png',
				cls: 'x-btn-text-icon',
				handler: function(btn) {
					AddParentBranchPerformanceTrackingStatus();
				}
			}, ' ', '-', ' ', {
				xtype: 'tbbutton',
				text: '<?php __('Edit'); ?>',
				id: 'edit-parent-branchPerformanceTrackingStatus',
				tooltip:'<?php __('<b>Edit BranchPerformanceTrackingStatus</b><br />Click here to modify the selected BranchPerformanceTrackingStatus'); ?>',
				icon: 'img/table_edit.png',
				cls: 'x-btn-text-icon',
				disabled: true,
				handler: function(btn) {
					var sm = g.getSelectionModel();
					var sel = sm.getSelected();
					if (sm.hasSelection()){
						EditParentBranchPerformanceTrackingStatus(sel.data.id);
					};
				}
			}, ' ', '-', ' ', {
				xtype: 'tbbutton',
				text: '<?php __('Delete'); ?>',
				id: 'delete-parent-branchPerformanceTrackingStatus',
				tooltip:'<?php __('<b>Delete BranchPerformanceTrackingStatus(s)</b><br />Click here to remove the selected BranchPerformanceTrackingStatus(s)'); ?>',
				icon: 'img/table_delete.png',
				cls: 'x-btn-text-icon',
				disabled: true,
				handler: function(btn) {
					var sm = g.getSelectionModel();
					var sel = sm.getSelections();
					if (sm.hasSelection()){
						if(sel.length==1){
							Ext.Msg.show({
									title: '<?php __('Remove BranchPerformanceTrackingStatus'); ?>',
									buttons: Ext.MessageBox.YESNOCANCEL,
									msg: '<?php __('Remove'); ?> '+sel[0].data.name+'?',
									icon: Ext.MessageBox.QUESTION,
                                    fn: function(btn){
											if (btn == 'yes'){
													DeleteParentBranchPerformanceTrackingStatus(sel[0].data.id);
											}
									}
							});
						} else {
							Ext.Msg.show({
									title: '<?php __('Remove BranchPerformanceTrackingStatus'); ?>',
									buttons: Ext.MessageBox.YESNOCANCEL,
									msg: '<?php __('Remove the selected BranchPerformanceTrackingStatus'); ?>?',
									icon: Ext.MessageBox.QUESTION,
                                    fn: function(btn){
											if (btn == 'yes'){
													var sel_ids = '';
													for(i=0;i<sel.length;i++){
														if(i>0)
															sel_ids += '_';
														sel_ids += sel[i].data.id;
													}
													DeleteParentBranchPerformanceTrackingStatus(sel_ids);
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
				text: '<?php __('View BranchPerformanceTrackingStatus'); ?>',
				id: 'view-branchPerformanceTrackingStatus2',
				tooltip:'<?php __('<b>View BranchPerformanceTrackingStatus</b><br />Click here to see details of the selected BranchPerformanceTrackingStatus'); ?>',
				icon: 'img/table_view.png',
				cls: 'x-btn-text-icon',
				disabled: true,
				handler: function(btn) {
					var sm = g.getSelectionModel();
					var sel = sm.getSelected();
					if (sm.hasSelection()){
						ViewBranchPerformanceTrackingStatus(sel.data.id);
					};
				},
				menu : {
					items: [
					]
				}

            }, ' ', '->', {
				xtype: 'textfield',
				emptyText: '<?php __('[Search By Name]'); ?>',
				id: 'parent_branchPerformanceTrackingStatus_search_field',
				listeners: {
					specialkey: function(field, e){
						if (e.getKey() == e.ENTER) {
							SearchByParentBranchPerformanceTrackingStatusName(Ext.getCmp('parent_branchPerformanceTrackingStatus_search_field').getValue());
						}
					}

				}
			}, {
				xtype: 'tbbutton',
				icon: 'img/search.png',
				cls: 'x-btn-text-icon',
				text: 'GO',
				tooltip:'<?php __('<b>GO</b><br />Click here to get search results'); ?>',
				id: 'parent_branchPerformanceTrackingStatus_go_button',
				handler: function(){
					SearchByParentBranchPerformanceTrackingStatusName(Ext.getCmp('parent_branchPerformanceTrackingStatus_search_field').getValue());
				}
			}, ' '
	]}),
	bbar: new Ext.PagingToolbar({
		pageSize: list_size,
		store: store_parent_branchPerformanceTrackingStatuses,
		displayInfo: true,
		displayMsg: '<?php __('Displaying {0} - {1} of {2}'); ?>',
		beforePageText: '<?php __('Page'); ?>',
		afterPageText: '<?php __('of {0}'); ?>',
		emptyMsg: '<?php __('No data to display'); ?>'
	})
});
g.getSelectionModel().on('rowselect', function(sm, rowIdx, r) {
	g.getTopToolbar().findById('edit-parent-branchPerformanceTrackingStatus').enable();
	g.getTopToolbar().findById('delete-parent-branchPerformanceTrackingStatus').enable();
        g.getTopToolbar().findById('view-branchPerformanceTrackingStatus2').enable();
	if(this.getSelections().length > 1){
		g.getTopToolbar().findById('edit-parent-branchPerformanceTrackingStatus').disable();
                g.getTopToolbar().findById('view-branchPerformanceTrackingStatus2').disable();
	}
});
g.getSelectionModel().on('rowdeselect', function(sm, rowIdx, r) {
	if(this.getSelections().length > 1){
		g.getTopToolbar().findById('edit-parent-branchPerformanceTrackingStatus').disable();
		g.getTopToolbar().findById('delete-parent-branchPerformanceTrackingStatus').enable();
                g.getTopToolbar().findById('view-branchPerformanceTrackingStatus2').disable();
	}
	else if(this.getSelections().length == 1){
		g.getTopToolbar().findById('edit-parent-branchPerformanceTrackingStatus').enable();
		g.getTopToolbar().findById('delete-parent-branchPerformanceTrackingStatus').enable();
                g.getTopToolbar().findById('view-branchPerformanceTrackingStatus2').enable();
	}
	else{
		g.getTopToolbar().findById('edit-parent-branchPerformanceTrackingStatus').disable();
		g.getTopToolbar().findById('delete-parent-branchPerformanceTrackingStatus').disable();
                g.getTopToolbar().findById('view-branchPerformanceTrackingStatus2').disable();
	}
});



var parentBranchPerformanceTrackingStatusesViewWindow = new Ext.Window({
	title: 'BranchPerformanceTrackingStatus Under the selected Item',
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
			parentBranchPerformanceTrackingStatusesViewWindow.close();
		}
	}]
});

store_parent_branchPerformanceTrackingStatuses.load({
    params: {
        start: 0,    
        limit: list_size
    }
});