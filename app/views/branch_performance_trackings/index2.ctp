var store_parent_branchPerformanceTrackings = new Ext.data.Store({
	reader: new Ext.data.JsonReader({
		root:'rows',
		totalProperty: 'results',
		fields: [
			'id','employee','goal','date','value'	
		]
	}),
	proxy: new Ext.data.HttpProxy({
		url: '<?php echo $this->Html->url(array('controller' => 'branchPerformanceTrackings', 'action' => 'list_data', $parent_id)); ?>'	})
});


function AddParentBranchPerformanceTracking() {
	Ext.Ajax.request({
		url: '<?php echo $this->Html->url(array('controller' => 'branchPerformanceTrackings', 'action' => 'add', $parent_id)); ?>',
		success: function(response, opts) {
			var parent_branchPerformanceTracking_data = response.responseText;
			
			eval(parent_branchPerformanceTracking_data);
			
			BranchPerformanceTrackingAddWindow.show();
		},
		failure: function(response, opts) {
			Ext.Msg.alert('<?php __('Error'); ?>', '<?php __('Cannot get the branchPerformanceTracking add form. Error code'); ?>: ' + response.status);
		}
	});
}

function EditParentBranchPerformanceTracking(id) {
	Ext.Ajax.request({
		url: '<?php echo $this->Html->url(array('controller' => 'branchPerformanceTrackings', 'action' => 'edit')); ?>/'+id+'/<?php echo $parent_id; ?>',
		success: function(response, opts) {
			var parent_branchPerformanceTracking_data = response.responseText;
			
			eval(parent_branchPerformanceTracking_data);
			
			BranchPerformanceTrackingEditWindow.show();
		},
		failure: function(response, opts) {
			Ext.Msg.alert('<?php __('Error'); ?>', '<?php __('Cannot get the branchPerformanceTracking edit form. Error code'); ?>: ' + response.status);
		}
	});
}

function ViewBranchPerformanceTracking(id) {
	Ext.Ajax.request({
		url: '<?php echo $this->Html->url(array('controller' => 'branchPerformanceTrackings', 'action' => 'view')); ?>/'+id,
		success: function(response, opts) {
			var branchPerformanceTracking_data = response.responseText;

			eval(branchPerformanceTracking_data);

			BranchPerformanceTrackingViewWindow.show();
		},
		failure: function(response, opts) {
			Ext.Msg.alert('<?php __('Error'); ?>', '<?php __('Cannot get the branchPerformanceTracking view form. Error code'); ?>: ' + response.status);
		}
	});
}


function DeleteParentBranchPerformanceTracking(id) {
	Ext.Ajax.request({
		url: '<?php echo $this->Html->url(array('controller' => 'branchPerformanceTrackings', 'action' => 'delete')); ?>/'+id,
		success: function(response, opts) {
			Ext.Msg.alert('<?php __('Success'); ?>', '<?php __('BranchPerformanceTracking(s) successfully deleted!'); ?>');
			RefreshParentBranchPerformanceTrackingData();
		},
		failure: function(response, opts) {
			Ext.Msg.alert('<?php __('Error'); ?>', '<?php __('Cannot get the branchPerformanceTracking to be deleted. Error code'); ?>: ' + response.status);
		}
	});
}

function SearchByParentBranchPerformanceTrackingName(value){
	var conditions = '\'BranchPerformanceTracking.name LIKE\' => \'%' + value + '%\'';
	store_parent_branchPerformanceTrackings.reload({
		 params: {
			start: 0,
			limit: list_size,
			conditions: conditions
	    }
	});
}

function RefreshParentBranchPerformanceTrackingData() {
	store_parent_branchPerformanceTrackings.reload();
}



var g = new Ext.grid.GridPanel({
	title: '<?php __('BranchPerformanceTrackings'); ?>',
	store: store_parent_branchPerformanceTrackings,
	loadMask: true,
	stripeRows: true,
	height: 300,
	anchor: '100%',
    id: 'branchPerformanceTrackingGrid',
	columns: [
		{header:"<?php __('employee'); ?>", dataIndex: 'employee', sortable: true},
		{header: "<?php __('Goal'); ?>", dataIndex: 'goal', sortable: true},
		{header: "<?php __('Date'); ?>", dataIndex: 'date', sortable: true},
		{header: "<?php __('Value'); ?>", dataIndex: 'value', sortable: true}	],
	sm: new Ext.grid.RowSelectionModel({
		singleSelect: false
	}),
	viewConfig: {
		forceFit: true
	},
    listeners: {
        celldblclick: function(){
            ViewBranchPerformanceTracking(Ext.getCmp('branchPerformanceTrackingGrid').getSelectionModel().getSelected().data.id);
        }
    },
	tbar: new Ext.Toolbar({
		items: [{
				xtype: 'tbbutton',
				text: '<?php __('Add'); ?>',
				tooltip:'<?php __('<b>Add BranchPerformanceTracking</b><br />Click here to create a new BranchPerformanceTracking'); ?>',
				icon: 'img/table_add.png',
				cls: 'x-btn-text-icon',
				handler: function(btn) {
					AddParentBranchPerformanceTracking();
				}
			}, ' ', '-', ' ', {
				xtype: 'tbbutton',
				text: '<?php __('Edit'); ?>',
				id: 'edit-parent-branchPerformanceTracking',
				tooltip:'<?php __('<b>Edit BranchPerformanceTracking</b><br />Click here to modify the selected BranchPerformanceTracking'); ?>',
				icon: 'img/table_edit.png',
				cls: 'x-btn-text-icon',
				disabled: true,
				handler: function(btn) {
					var sm = g.getSelectionModel();
					var sel = sm.getSelected();
					if (sm.hasSelection()){
						EditParentBranchPerformanceTracking(sel.data.id);
					};
				}
			}, ' ', '-', ' ', {
				xtype: 'tbbutton',
				text: '<?php __('Delete'); ?>',
				id: 'delete-parent-branchPerformanceTracking',
				tooltip:'<?php __('<b>Delete BranchPerformanceTracking(s)</b><br />Click here to remove the selected BranchPerformanceTracking(s)'); ?>',
				icon: 'img/table_delete.png',
				cls: 'x-btn-text-icon',
				disabled: true,
				handler: function(btn) {
					var sm = g.getSelectionModel();
					var sel = sm.getSelections();
					if (sm.hasSelection()){
						if(sel.length==1){
							Ext.Msg.show({
									title: '<?php __('Remove BranchPerformanceTracking'); ?>',
									buttons: Ext.MessageBox.YESNOCANCEL,
									msg: '<?php __('Remove'); ?> '+sel[0].data.name+'?',
									icon: Ext.MessageBox.QUESTION,
                                    fn: function(btn){
											if (btn == 'yes'){
													DeleteParentBranchPerformanceTracking(sel[0].data.id);
											}
									}
							});
						} else {
							Ext.Msg.show({
									title: '<?php __('Remove BranchPerformanceTracking'); ?>',
									buttons: Ext.MessageBox.YESNOCANCEL,
									msg: '<?php __('Remove the selected BranchPerformanceTracking'); ?>?',
									icon: Ext.MessageBox.QUESTION,
                                    fn: function(btn){
											if (btn == 'yes'){
													var sel_ids = '';
													for(i=0;i<sel.length;i++){
														if(i>0)
															sel_ids += '_';
														sel_ids += sel[i].data.id;
													}
													DeleteParentBranchPerformanceTracking(sel_ids);
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
				text: '<?php __('View BranchPerformanceTracking'); ?>',
				id: 'view-branchPerformanceTracking2',
				tooltip:'<?php __('<b>View BranchPerformanceTracking</b><br />Click here to see details of the selected BranchPerformanceTracking'); ?>',
				icon: 'img/table_view.png',
				cls: 'x-btn-text-icon',
				disabled: true,
				handler: function(btn) {
					var sm = g.getSelectionModel();
					var sel = sm.getSelected();
					if (sm.hasSelection()){
						ViewBranchPerformanceTracking(sel.data.id);
					};
				},
				menu : {
					items: [
					]
				}

            }, ' ', '->', {
				xtype: 'textfield',
				emptyText: '<?php __('[Search By Name]'); ?>',
				id: 'parent_branchPerformanceTracking_search_field',
				listeners: {
					specialkey: function(field, e){
						if (e.getKey() == e.ENTER) {
							SearchByParentBranchPerformanceTrackingName(Ext.getCmp('parent_branchPerformanceTracking_search_field').getValue());
						}
					}

				}
			}, {
				xtype: 'tbbutton',
				icon: 'img/search.png',
				cls: 'x-btn-text-icon',
				text: 'GO',
				tooltip:'<?php __('<b>GO</b><br />Click here to get search results'); ?>',
				id: 'parent_branchPerformanceTracking_go_button',
				handler: function(){
					SearchByParentBranchPerformanceTrackingName(Ext.getCmp('parent_branchPerformanceTracking_search_field').getValue());
				}
			}, ' '
	]}),
	bbar: new Ext.PagingToolbar({
		pageSize: list_size,
		store: store_parent_branchPerformanceTrackings,
		displayInfo: true,
		displayMsg: '<?php __('Displaying {0} - {1} of {2}'); ?>',
		beforePageText: '<?php __('Page'); ?>',
		afterPageText: '<?php __('of {0}'); ?>',
		emptyMsg: '<?php __('No data to display'); ?>'
	})
});
g.getSelectionModel().on('rowselect', function(sm, rowIdx, r) {
	g.getTopToolbar().findById('edit-parent-branchPerformanceTracking').enable();
	g.getTopToolbar().findById('delete-parent-branchPerformanceTracking').enable();
        g.getTopToolbar().findById('view-branchPerformanceTracking2').enable();
	if(this.getSelections().length > 1){
		g.getTopToolbar().findById('edit-parent-branchPerformanceTracking').disable();
                g.getTopToolbar().findById('view-branchPerformanceTracking2').disable();
	}
});
g.getSelectionModel().on('rowdeselect', function(sm, rowIdx, r) {
	if(this.getSelections().length > 1){
		g.getTopToolbar().findById('edit-parent-branchPerformanceTracking').disable();
		g.getTopToolbar().findById('delete-parent-branchPerformanceTracking').enable();
                g.getTopToolbar().findById('view-branchPerformanceTracking2').disable();
	}
	else if(this.getSelections().length == 1){
		g.getTopToolbar().findById('edit-parent-branchPerformanceTracking').enable();
		g.getTopToolbar().findById('delete-parent-branchPerformanceTracking').enable();
                g.getTopToolbar().findById('view-branchPerformanceTracking2').enable();
	}
	else{
		g.getTopToolbar().findById('edit-parent-branchPerformanceTracking').disable();
		g.getTopToolbar().findById('delete-parent-branchPerformanceTracking').disable();
                g.getTopToolbar().findById('view-branchPerformanceTracking2').disable();
	}
});



var parentBranchPerformanceTrackingsViewWindow = new Ext.Window({
	title: 'BranchPerformanceTracking Under the selected Item',
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
			parentBranchPerformanceTrackingsViewWindow.close();
		}
	}]
});

store_parent_branchPerformanceTrackings.load({
    params: {
        start: 0,    
        limit: list_size
    }
});