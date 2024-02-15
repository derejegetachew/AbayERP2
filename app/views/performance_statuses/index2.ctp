var store_parent_performanceStatuses = new Ext.data.Store({
	reader: new Ext.data.JsonReader({
		root:'rows',
		totalProperty: 'results',
		fields: [
			'id','budget_year','quarter','status'	
		]
	}),
	proxy: new Ext.data.HttpProxy({
		url: '<?php echo $this->Html->url(array('controller' => 'performanceStatuses', 'action' => 'list_data', $parent_id)); ?>'	})
});


function AddParentPerformanceStatus() {
	Ext.Ajax.request({
		url: '<?php echo $this->Html->url(array('controller' => 'performanceStatuses', 'action' => 'add', $parent_id)); ?>',
		success: function(response, opts) {
			var parent_performanceStatus_data = response.responseText;
			
			eval(parent_performanceStatus_data);
			
			PerformanceStatusAddWindow.show();
		},
		failure: function(response, opts) {
			Ext.Msg.alert('<?php __('Error'); ?>', '<?php __('Cannot get the performanceStatus add form. Error code'); ?>: ' + response.status);
		}
	});
}

function EditParentPerformanceStatus(id) {
	Ext.Ajax.request({
		url: '<?php echo $this->Html->url(array('controller' => 'performanceStatuses', 'action' => 'edit')); ?>/'+id+'/<?php echo $parent_id; ?>',
		success: function(response, opts) {
			var parent_performanceStatus_data = response.responseText;
			
			eval(parent_performanceStatus_data);
			
			PerformanceStatusEditWindow.show();
		},
		failure: function(response, opts) {
			Ext.Msg.alert('<?php __('Error'); ?>', '<?php __('Cannot get the performanceStatus edit form. Error code'); ?>: ' + response.status);
		}
	});
}

function ViewPerformanceStatus(id) {
	Ext.Ajax.request({
		url: '<?php echo $this->Html->url(array('controller' => 'performanceStatuses', 'action' => 'view')); ?>/'+id,
		success: function(response, opts) {
			var performanceStatus_data = response.responseText;

			eval(performanceStatus_data);

			PerformanceStatusViewWindow.show();
		},
		failure: function(response, opts) {
			Ext.Msg.alert('<?php __('Error'); ?>', '<?php __('Cannot get the performanceStatus view form. Error code'); ?>: ' + response.status);
		}
	});
}


function DeleteParentPerformanceStatus(id) {
	Ext.Ajax.request({
		url: '<?php echo $this->Html->url(array('controller' => 'performanceStatuses', 'action' => 'delete')); ?>/'+id,
		success: function(response, opts) {
			Ext.Msg.alert('<?php __('Success'); ?>', '<?php __('PerformanceStatus(s) successfully deleted!'); ?>');
			RefreshParentPerformanceStatusData();
		},
		failure: function(response, opts) {
			Ext.Msg.alert('<?php __('Error'); ?>', '<?php __('Cannot get the performanceStatus to be deleted. Error code'); ?>: ' + response.status);
		}
	});
}

function SearchByParentPerformanceStatusName(value){
	var conditions = '\'PerformanceStatus.name LIKE\' => \'%' + value + '%\'';
	store_parent_performanceStatuses.reload({
		 params: {
			start: 0,
			limit: list_size,
			conditions: conditions
	    }
	});
}

function RefreshParentPerformanceStatusData() {
	store_parent_performanceStatuses.reload();
}



var g = new Ext.grid.GridPanel({
	title: '<?php __('PerformanceStatuses'); ?>',
	store: store_parent_performanceStatuses,
	loadMask: true,
	stripeRows: true,
	height: 300,
	anchor: '100%',
    id: 'performanceStatusGrid',
	columns: [
		{header:"<?php __('budget_year'); ?>", dataIndex: 'budget_year', sortable: true},
		{header: "<?php __('Quarter'); ?>", dataIndex: 'quarter', sortable: true},
		{header: "<?php __('Status'); ?>", dataIndex: 'status', sortable: true}	],
	sm: new Ext.grid.RowSelectionModel({
		singleSelect: false
	}),
	viewConfig: {
		forceFit: true
	},
    listeners: {
        celldblclick: function(){
            ViewPerformanceStatus(Ext.getCmp('performanceStatusGrid').getSelectionModel().getSelected().data.id);
        }
    },
	tbar: new Ext.Toolbar({
		items: [{
				xtype: 'tbbutton',
				text: '<?php __('Add'); ?>',
				tooltip:'<?php __('<b>Add PerformanceStatus</b><br />Click here to create a new PerformanceStatus'); ?>',
				icon: 'img/table_add.png',
				cls: 'x-btn-text-icon',
				handler: function(btn) {
					AddParentPerformanceStatus();
				}
			}, ' ', '-', ' ', {
				xtype: 'tbbutton',
				text: '<?php __('Edit'); ?>',
				id: 'edit-parent-performanceStatus',
				tooltip:'<?php __('<b>Edit PerformanceStatus</b><br />Click here to modify the selected PerformanceStatus'); ?>',
				icon: 'img/table_edit.png',
				cls: 'x-btn-text-icon',
				disabled: true,
				handler: function(btn) {
					var sm = g.getSelectionModel();
					var sel = sm.getSelected();
					if (sm.hasSelection()){
						EditParentPerformanceStatus(sel.data.id);
					};
				}
			}, ' ', '-', ' ', {
				xtype: 'tbbutton',
				text: '<?php __('Delete'); ?>',
				id: 'delete-parent-performanceStatus',
				tooltip:'<?php __('<b>Delete PerformanceStatus(s)</b><br />Click here to remove the selected PerformanceStatus(s)'); ?>',
				icon: 'img/table_delete.png',
				cls: 'x-btn-text-icon',
				disabled: true,
				handler: function(btn) {
					var sm = g.getSelectionModel();
					var sel = sm.getSelections();
					if (sm.hasSelection()){
						if(sel.length==1){
							Ext.Msg.show({
									title: '<?php __('Remove PerformanceStatus'); ?>',
									buttons: Ext.MessageBox.YESNOCANCEL,
									msg: '<?php __('Remove'); ?> '+sel[0].data.name+'?',
									icon: Ext.MessageBox.QUESTION,
                                    fn: function(btn){
											if (btn == 'yes'){
													DeleteParentPerformanceStatus(sel[0].data.id);
											}
									}
							});
						} else {
							Ext.Msg.show({
									title: '<?php __('Remove PerformanceStatus'); ?>',
									buttons: Ext.MessageBox.YESNOCANCEL,
									msg: '<?php __('Remove the selected PerformanceStatus'); ?>?',
									icon: Ext.MessageBox.QUESTION,
                                    fn: function(btn){
											if (btn == 'yes'){
													var sel_ids = '';
													for(i=0;i<sel.length;i++){
														if(i>0)
															sel_ids += '_';
														sel_ids += sel[i].data.id;
													}
													DeleteParentPerformanceStatus(sel_ids);
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
				text: '<?php __('View PerformanceStatus'); ?>',
				id: 'view-performanceStatus2',
				tooltip:'<?php __('<b>View PerformanceStatus</b><br />Click here to see details of the selected PerformanceStatus'); ?>',
				icon: 'img/table_view.png',
				cls: 'x-btn-text-icon',
				disabled: true,
				handler: function(btn) {
					var sm = g.getSelectionModel();
					var sel = sm.getSelected();
					if (sm.hasSelection()){
						ViewPerformanceStatus(sel.data.id);
					};
				},
				menu : {
					items: [
					]
				}

            }, ' ', '->', {
				xtype: 'textfield',
				emptyText: '<?php __('[Search By Name]'); ?>',
				id: 'parent_performanceStatus_search_field',
				listeners: {
					specialkey: function(field, e){
						if (e.getKey() == e.ENTER) {
							SearchByParentPerformanceStatusName(Ext.getCmp('parent_performanceStatus_search_field').getValue());
						}
					}

				}
			}, {
				xtype: 'tbbutton',
				icon: 'img/search.png',
				cls: 'x-btn-text-icon',
				text: 'GO',
				tooltip:'<?php __('<b>GO</b><br />Click here to get search results'); ?>',
				id: 'parent_performanceStatus_go_button',
				handler: function(){
					SearchByParentPerformanceStatusName(Ext.getCmp('parent_performanceStatus_search_field').getValue());
				}
			}, ' '
	]}),
	bbar: new Ext.PagingToolbar({
		pageSize: list_size,
		store: store_parent_performanceStatuses,
		displayInfo: true,
		displayMsg: '<?php __('Displaying {0} - {1} of {2}'); ?>',
		beforePageText: '<?php __('Page'); ?>',
		afterPageText: '<?php __('of {0}'); ?>',
		emptyMsg: '<?php __('No data to display'); ?>'
	})
});
g.getSelectionModel().on('rowselect', function(sm, rowIdx, r) {
	g.getTopToolbar().findById('edit-parent-performanceStatus').enable();
	g.getTopToolbar().findById('delete-parent-performanceStatus').enable();
        g.getTopToolbar().findById('view-performanceStatus2').enable();
	if(this.getSelections().length > 1){
		g.getTopToolbar().findById('edit-parent-performanceStatus').disable();
                g.getTopToolbar().findById('view-performanceStatus2').disable();
	}
});
g.getSelectionModel().on('rowdeselect', function(sm, rowIdx, r) {
	if(this.getSelections().length > 1){
		g.getTopToolbar().findById('edit-parent-performanceStatus').disable();
		g.getTopToolbar().findById('delete-parent-performanceStatus').enable();
                g.getTopToolbar().findById('view-performanceStatus2').disable();
	}
	else if(this.getSelections().length == 1){
		g.getTopToolbar().findById('edit-parent-performanceStatus').enable();
		g.getTopToolbar().findById('delete-parent-performanceStatus').enable();
                g.getTopToolbar().findById('view-performanceStatus2').enable();
	}
	else{
		g.getTopToolbar().findById('edit-parent-performanceStatus').disable();
		g.getTopToolbar().findById('delete-parent-performanceStatus').disable();
                g.getTopToolbar().findById('view-performanceStatus2').disable();
	}
});



var parentPerformanceStatusesViewWindow = new Ext.Window({
	title: 'PerformanceStatus Under the selected Item',
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
			parentPerformanceStatusesViewWindow.close();
		}
	}]
});

store_parent_performanceStatuses.load({
    params: {
        start: 0,    
        limit: list_size
    }
});