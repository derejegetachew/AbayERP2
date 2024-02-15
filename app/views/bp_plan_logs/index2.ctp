var store_parent_bpPlanLogs = new Ext.data.Store({
	reader: new Ext.data.JsonReader({
		root:'rows',
		totalProperty: 'results',
		fields: [
			'id','bp_plan','user','type','created'	
		]
	}),
	proxy: new Ext.data.HttpProxy({
		url: '<?php echo $this->Html->url(array('controller' => 'bpPlanLogs', 'action' => 'list_data', $parent_id)); ?>'	})
});


function AddParentBpPlanLog() {
	Ext.Ajax.request({
		url: '<?php echo $this->Html->url(array('controller' => 'bpPlanLogs', 'action' => 'add', $parent_id)); ?>',
		success: function(response, opts) {
			var parent_bpPlanLog_data = response.responseText;
			
			eval(parent_bpPlanLog_data);
			
			BpPlanLogAddWindow.show();
		},
		failure: function(response, opts) {
			Ext.Msg.alert('<?php __('Error'); ?>', '<?php __('Cannot get the bpPlanLog add form. Error code'); ?>: ' + response.status);
		}
	});
}

function EditParentBpPlanLog(id) {
	Ext.Ajax.request({
		url: '<?php echo $this->Html->url(array('controller' => 'bpPlanLogs', 'action' => 'edit')); ?>/'+id+'/<?php echo $parent_id; ?>',
		success: function(response, opts) {
			var parent_bpPlanLog_data = response.responseText;
			
			eval(parent_bpPlanLog_data);
			
			BpPlanLogEditWindow.show();
		},
		failure: function(response, opts) {
			Ext.Msg.alert('<?php __('Error'); ?>', '<?php __('Cannot get the bpPlanLog edit form. Error code'); ?>: ' + response.status);
		}
	});
}

function ViewBpPlanLog(id) {
	Ext.Ajax.request({
		url: '<?php echo $this->Html->url(array('controller' => 'bpPlanLogs', 'action' => 'view')); ?>/'+id,
		success: function(response, opts) {
			var bpPlanLog_data = response.responseText;

			eval(bpPlanLog_data);

			BpPlanLogViewWindow.show();
		},
		failure: function(response, opts) {
			Ext.Msg.alert('<?php __('Error'); ?>', '<?php __('Cannot get the bpPlanLog view form. Error code'); ?>: ' + response.status);
		}
	});
}


function DeleteParentBpPlanLog(id) {
	Ext.Ajax.request({
		url: '<?php echo $this->Html->url(array('controller' => 'bpPlanLogs', 'action' => 'delete')); ?>/'+id,
		success: function(response, opts) {
			Ext.Msg.alert('<?php __('Success'); ?>', '<?php __('BpPlanLog(s) successfully deleted!'); ?>');
			RefreshParentBpPlanLogData();
		},
		failure: function(response, opts) {
			Ext.Msg.alert('<?php __('Error'); ?>', '<?php __('Cannot get the bpPlanLog to be deleted. Error code'); ?>: ' + response.status);
		}
	});
}

function SearchByParentBpPlanLogName(value){
	var conditions = '\'BpPlanLog.name LIKE\' => \'%' + value + '%\'';
	store_parent_bpPlanLogs.reload({
		 params: {
			start: 0,
			limit: list_size,
			conditions: conditions
	    }
	});
}

function RefreshParentBpPlanLogData() {
	store_parent_bpPlanLogs.reload();
}



var g = new Ext.grid.GridPanel({
	title: '<?php __('BpPlanLogs'); ?>',
	store: store_parent_bpPlanLogs,
	loadMask: true,
	stripeRows: true,
	height: 300,
	anchor: '100%',
    id: 'bpPlanLogGrid',
	columns: [
		{header:"<?php __('bp_plan'); ?>", dataIndex: 'bp_plan', sortable: true},
		{header:"<?php __('user'); ?>", dataIndex: 'user', sortable: true},
		{header: "<?php __('Type'); ?>", dataIndex: 'type', sortable: true},
		{header: "<?php __('Created'); ?>", dataIndex: 'created', sortable: true}	],
	sm: new Ext.grid.RowSelectionModel({
		singleSelect: false
	}),
	viewConfig: {
		forceFit: true
	},
    listeners: {
        celldblclick: function(){
            ViewBpPlanLog(Ext.getCmp('bpPlanLogGrid').getSelectionModel().getSelected().data.id);
        }
    },
	tbar: new Ext.Toolbar({
		items: [{
				xtype: 'tbbutton',
				text: '<?php __('Add'); ?>',
				tooltip:'<?php __('<b>Add BpPlanLog</b><br />Click here to create a new BpPlanLog'); ?>',
				icon: 'img/table_add.png',
				cls: 'x-btn-text-icon',
				handler: function(btn) {
					AddParentBpPlanLog();
				}
			}, ' ', '-', ' ', {
				xtype: 'tbbutton',
				text: '<?php __('Edit'); ?>',
				id: 'edit-parent-bpPlanLog',
				tooltip:'<?php __('<b>Edit BpPlanLog</b><br />Click here to modify the selected BpPlanLog'); ?>',
				icon: 'img/table_edit.png',
				cls: 'x-btn-text-icon',
				disabled: true,
				handler: function(btn) {
					var sm = g.getSelectionModel();
					var sel = sm.getSelected();
					if (sm.hasSelection()){
						EditParentBpPlanLog(sel.data.id);
					};
				}
			}, ' ', '-', ' ', {
				xtype: 'tbbutton',
				text: '<?php __('Delete'); ?>',
				id: 'delete-parent-bpPlanLog',
				tooltip:'<?php __('<b>Delete BpPlanLog(s)</b><br />Click here to remove the selected BpPlanLog(s)'); ?>',
				icon: 'img/table_delete.png',
				cls: 'x-btn-text-icon',
				disabled: true,
				handler: function(btn) {
					var sm = g.getSelectionModel();
					var sel = sm.getSelections();
					if (sm.hasSelection()){
						if(sel.length==1){
							Ext.Msg.show({
									title: '<?php __('Remove BpPlanLog'); ?>',
									buttons: Ext.MessageBox.YESNOCANCEL,
									msg: '<?php __('Remove'); ?> '+sel[0].data.name+'?',
									icon: Ext.MessageBox.QUESTION,
                                    fn: function(btn){
											if (btn == 'yes'){
													DeleteParentBpPlanLog(sel[0].data.id);
											}
									}
							});
						} else {
							Ext.Msg.show({
									title: '<?php __('Remove BpPlanLog'); ?>',
									buttons: Ext.MessageBox.YESNOCANCEL,
									msg: '<?php __('Remove the selected BpPlanLog'); ?>?',
									icon: Ext.MessageBox.QUESTION,
                                    fn: function(btn){
											if (btn == 'yes'){
													var sel_ids = '';
													for(i=0;i<sel.length;i++){
														if(i>0)
															sel_ids += '_';
														sel_ids += sel[i].data.id;
													}
													DeleteParentBpPlanLog(sel_ids);
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
				text: '<?php __('View BpPlanLog'); ?>',
				id: 'view-bpPlanLog2',
				tooltip:'<?php __('<b>View BpPlanLog</b><br />Click here to see details of the selected BpPlanLog'); ?>',
				icon: 'img/table_view.png',
				cls: 'x-btn-text-icon',
				disabled: true,
				handler: function(btn) {
					var sm = g.getSelectionModel();
					var sel = sm.getSelected();
					if (sm.hasSelection()){
						ViewBpPlanLog(sel.data.id);
					};
				},
				menu : {
					items: [
					]
				}

            }, ' ', '->', {
				xtype: 'textfield',
				emptyText: '<?php __('[Search By Name]'); ?>',
				id: 'parent_bpPlanLog_search_field',
				listeners: {
					specialkey: function(field, e){
						if (e.getKey() == e.ENTER) {
							SearchByParentBpPlanLogName(Ext.getCmp('parent_bpPlanLog_search_field').getValue());
						}
					}

				}
			}, {
				xtype: 'tbbutton',
				icon: 'img/search.png',
				cls: 'x-btn-text-icon',
				text: 'GO',
				tooltip:'<?php __('<b>GO</b><br />Click here to get search results'); ?>',
				id: 'parent_bpPlanLog_go_button',
				handler: function(){
					SearchByParentBpPlanLogName(Ext.getCmp('parent_bpPlanLog_search_field').getValue());
				}
			}, ' '
	]}),
	bbar: new Ext.PagingToolbar({
		pageSize: list_size,
		store: store_parent_bpPlanLogs,
		displayInfo: true,
		displayMsg: '<?php __('Displaying {0} - {1} of {2}'); ?>',
		beforePageText: '<?php __('Page'); ?>',
		afterPageText: '<?php __('of {0}'); ?>',
		emptyMsg: '<?php __('No data to display'); ?>'
	})
});
g.getSelectionModel().on('rowselect', function(sm, rowIdx, r) {
	g.getTopToolbar().findById('edit-parent-bpPlanLog').enable();
	g.getTopToolbar().findById('delete-parent-bpPlanLog').enable();
        g.getTopToolbar().findById('view-bpPlanLog2').enable();
	if(this.getSelections().length > 1){
		g.getTopToolbar().findById('edit-parent-bpPlanLog').disable();
                g.getTopToolbar().findById('view-bpPlanLog2').disable();
	}
});
g.getSelectionModel().on('rowdeselect', function(sm, rowIdx, r) {
	if(this.getSelections().length > 1){
		g.getTopToolbar().findById('edit-parent-bpPlanLog').disable();
		g.getTopToolbar().findById('delete-parent-bpPlanLog').enable();
                g.getTopToolbar().findById('view-bpPlanLog2').disable();
	}
	else if(this.getSelections().length == 1){
		g.getTopToolbar().findById('edit-parent-bpPlanLog').enable();
		g.getTopToolbar().findById('delete-parent-bpPlanLog').enable();
                g.getTopToolbar().findById('view-bpPlanLog2').enable();
	}
	else{
		g.getTopToolbar().findById('edit-parent-bpPlanLog').disable();
		g.getTopToolbar().findById('delete-parent-bpPlanLog').disable();
                g.getTopToolbar().findById('view-bpPlanLog2').disable();
	}
});



var parentBpPlanLogsViewWindow = new Ext.Window({
	title: 'BpPlanLog Under the selected Item',
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
			parentBpPlanLogsViewWindow.close();
		}
	}]
});

store_parent_bpPlanLogs.load({
    params: {
        start: 0,    
        limit: list_size
    }
});