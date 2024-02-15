var store_parent_faAssetLogs = new Ext.data.Store({
	reader: new Ext.data.JsonReader({
		root:'rows',
		totalProperty: 'results',
		fields: [
			'id','fa_asset','branch_name','branch_code','tax_rate','tax_cat','class','ifrs_cat','useful_age','residual_value','created_at'	
		]
	}),
	proxy: new Ext.data.HttpProxy({
		url: '<?php echo $this->Html->url(array('controller' => 'faAssetLogs', 'action' => 'list_data', $parent_id)); ?>'	})
});


function AddParentFaAssetLog() {
	Ext.Ajax.request({
		url: '<?php echo $this->Html->url(array('controller' => 'faAssetLogs', 'action' => 'add', $parent_id)); ?>',
		success: function(response, opts) {
			var parent_faAssetLog_data = response.responseText;
			
			eval(parent_faAssetLog_data);
			
			FaAssetLogAddWindow.show();
		},
		failure: function(response, opts) {
			Ext.Msg.alert('<?php __('Error'); ?>', '<?php __('Cannot get the faAssetLog add form. Error code'); ?>: ' + response.status);
		}
	});
}

function EditParentFaAssetLog(id) {
	Ext.Ajax.request({
		url: '<?php echo $this->Html->url(array('controller' => 'faAssetLogs', 'action' => 'edit')); ?>/'+id+'/<?php echo $parent_id; ?>',
		success: function(response, opts) {
			var parent_faAssetLog_data = response.responseText;
			
			eval(parent_faAssetLog_data);
			
			FaAssetLogEditWindow.show();
		},
		failure: function(response, opts) {
			Ext.Msg.alert('<?php __('Error'); ?>', '<?php __('Cannot get the faAssetLog edit form. Error code'); ?>: ' + response.status);
		}
	});
}

function ViewFaAssetLog(id) {
	Ext.Ajax.request({
		url: '<?php echo $this->Html->url(array('controller' => 'faAssetLogs', 'action' => 'view')); ?>/'+id,
		success: function(response, opts) {
			var faAssetLog_data = response.responseText;

			eval(faAssetLog_data);

			FaAssetLogViewWindow.show();
		},
		failure: function(response, opts) {
			Ext.Msg.alert('<?php __('Error'); ?>', '<?php __('Cannot get the faAssetLog view form. Error code'); ?>: ' + response.status);
		}
	});
}


function DeleteParentFaAssetLog(id) {
	Ext.Ajax.request({
		url: '<?php echo $this->Html->url(array('controller' => 'faAssetLogs', 'action' => 'delete')); ?>/'+id,
		success: function(response, opts) {
			Ext.Msg.alert('<?php __('Success'); ?>', '<?php __('FaAssetLog(s) successfully deleted!'); ?>');
			RefreshParentFaAssetLogData();
		},
		failure: function(response, opts) {
			Ext.Msg.alert('<?php __('Error'); ?>', '<?php __('Cannot get the faAssetLog to be deleted. Error code'); ?>: ' + response.status);
		}
	});
}

function SearchByParentFaAssetLogName(value){
	var conditions = '\'FaAssetLog.name LIKE\' => \'%' + value + '%\'';
	store_parent_faAssetLogs.reload({
		 params: {
			start: 0,
			limit: list_size,
			conditions: conditions
	    }
	});
}

function RefreshParentFaAssetLogData() {
	store_parent_faAssetLogs.reload();
}



var g = new Ext.grid.GridPanel({
	title: '<?php __('FaAssetLogs'); ?>',
	store: store_parent_faAssetLogs,
	loadMask: true,
	stripeRows: true,
	height: 300,
	anchor: '100%',
    id: 'faAssetLogGrid',
	columns: [
		{header:"<?php __('fa_asset'); ?>", dataIndex: 'fa_asset', sortable: true},
		{header: "<?php __('Branch Name'); ?>", dataIndex: 'branch_name', sortable: true},
		{header: "<?php __('Branch Code'); ?>", dataIndex: 'branch_code', sortable: true},
		{header: "<?php __('Tax Rate'); ?>", dataIndex: 'tax_rate', sortable: true},
		{header: "<?php __('Tax Cat'); ?>", dataIndex: 'tax_cat', sortable: true},
		{header: "<?php __('Class'); ?>", dataIndex: 'class', sortable: true},
		{header: "<?php __('Ifrs Cat'); ?>", dataIndex: 'ifrs_cat', sortable: true},
		{header: "<?php __('Useful Age'); ?>", dataIndex: 'useful_age', sortable: true},
		{header: "<?php __('Residual Value'); ?>", dataIndex: 'residual_value', sortable: true},
		{header: "<?php __('Created At'); ?>", dataIndex: 'created_at', sortable: true}	],
	sm: new Ext.grid.RowSelectionModel({
		singleSelect: false
	}),
	viewConfig: {
		forceFit: true
	},
    listeners: {
        celldblclick: function(){
            ViewFaAssetLog(Ext.getCmp('faAssetLogGrid').getSelectionModel().getSelected().data.id);
        }
    },
	tbar: new Ext.Toolbar({
		items: [{
				xtype: 'tbbutton',
				text: '<?php __('Add'); ?>',
				tooltip:'<?php __('<b>Add FaAssetLog</b><br />Click here to create a new FaAssetLog'); ?>',
				icon: 'img/table_add.png',
				cls: 'x-btn-text-icon',
				handler: function(btn) {
					AddParentFaAssetLog();
				}
			}, ' ', '-', ' ', {
				xtype: 'tbbutton',
				text: '<?php __('Edit'); ?>',
				id: 'edit-parent-faAssetLog',
				tooltip:'<?php __('<b>Edit FaAssetLog</b><br />Click here to modify the selected FaAssetLog'); ?>',
				icon: 'img/table_edit.png',
				cls: 'x-btn-text-icon',
				disabled: true,
				handler: function(btn) {
					var sm = g.getSelectionModel();
					var sel = sm.getSelected();
					if (sm.hasSelection()){
						EditParentFaAssetLog(sel.data.id);
					};
				}
			}, ' ', '-', ' ', {
				xtype: 'tbbutton',
				text: '<?php __('Delete'); ?>',
				id: 'delete-parent-faAssetLog',
				tooltip:'<?php __('<b>Delete FaAssetLog(s)</b><br />Click here to remove the selected FaAssetLog(s)'); ?>',
				icon: 'img/table_delete.png',
				cls: 'x-btn-text-icon',
				disabled: true,
				handler: function(btn) {
					var sm = g.getSelectionModel();
					var sel = sm.getSelections();
					if (sm.hasSelection()){
						if(sel.length==1){
							Ext.Msg.show({
									title: '<?php __('Remove FaAssetLog'); ?>',
									buttons: Ext.MessageBox.YESNOCANCEL,
									msg: '<?php __('Remove'); ?> '+sel[0].data.name+'?',
									icon: Ext.MessageBox.QUESTION,
                                    fn: function(btn){
											if (btn == 'yes'){
													DeleteParentFaAssetLog(sel[0].data.id);
											}
									}
							});
						} else {
							Ext.Msg.show({
									title: '<?php __('Remove FaAssetLog'); ?>',
									buttons: Ext.MessageBox.YESNOCANCEL,
									msg: '<?php __('Remove the selected FaAssetLog'); ?>?',
									icon: Ext.MessageBox.QUESTION,
                                    fn: function(btn){
											if (btn == 'yes'){
													var sel_ids = '';
													for(i=0;i<sel.length;i++){
														if(i>0)
															sel_ids += '_';
														sel_ids += sel[i].data.id;
													}
													DeleteParentFaAssetLog(sel_ids);
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
				text: '<?php __('View FaAssetLog'); ?>',
				id: 'view-faAssetLog2',
				tooltip:'<?php __('<b>View FaAssetLog</b><br />Click here to see details of the selected FaAssetLog'); ?>',
				icon: 'img/table_view.png',
				cls: 'x-btn-text-icon',
				disabled: true,
				handler: function(btn) {
					var sm = g.getSelectionModel();
					var sel = sm.getSelected();
					if (sm.hasSelection()){
						ViewFaAssetLog(sel.data.id);
					};
				},
				menu : {
					items: [
					]
				}

            }, ' ', '->', {
				xtype: 'textfield',
				emptyText: '<?php __('[Search By Name]'); ?>',
				id: 'parent_faAssetLog_search_field',
				listeners: {
					specialkey: function(field, e){
						if (e.getKey() == e.ENTER) {
							SearchByParentFaAssetLogName(Ext.getCmp('parent_faAssetLog_search_field').getValue());
						}
					}

				}
			}, {
				xtype: 'tbbutton',
				icon: 'img/search.png',
				cls: 'x-btn-text-icon',
				text: 'GO',
				tooltip:'<?php __('<b>GO</b><br />Click here to get search results'); ?>',
				id: 'parent_faAssetLog_go_button',
				handler: function(){
					SearchByParentFaAssetLogName(Ext.getCmp('parent_faAssetLog_search_field').getValue());
				}
			}, ' '
	]}),
	bbar: new Ext.PagingToolbar({
		pageSize: list_size,
		store: store_parent_faAssetLogs,
		displayInfo: true,
		displayMsg: '<?php __('Displaying {0} - {1} of {2}'); ?>',
		beforePageText: '<?php __('Page'); ?>',
		afterPageText: '<?php __('of {0}'); ?>',
		emptyMsg: '<?php __('No data to display'); ?>'
	})
});
g.getSelectionModel().on('rowselect', function(sm, rowIdx, r) {
	g.getTopToolbar().findById('edit-parent-faAssetLog').enable();
	g.getTopToolbar().findById('delete-parent-faAssetLog').enable();
        g.getTopToolbar().findById('view-faAssetLog2').enable();
	if(this.getSelections().length > 1){
		g.getTopToolbar().findById('edit-parent-faAssetLog').disable();
                g.getTopToolbar().findById('view-faAssetLog2').disable();
	}
});
g.getSelectionModel().on('rowdeselect', function(sm, rowIdx, r) {
	if(this.getSelections().length > 1){
		g.getTopToolbar().findById('edit-parent-faAssetLog').disable();
		g.getTopToolbar().findById('delete-parent-faAssetLog').enable();
                g.getTopToolbar().findById('view-faAssetLog2').disable();
	}
	else if(this.getSelections().length == 1){
		g.getTopToolbar().findById('edit-parent-faAssetLog').enable();
		g.getTopToolbar().findById('delete-parent-faAssetLog').enable();
                g.getTopToolbar().findById('view-faAssetLog2').enable();
	}
	else{
		g.getTopToolbar().findById('edit-parent-faAssetLog').disable();
		g.getTopToolbar().findById('delete-parent-faAssetLog').disable();
                g.getTopToolbar().findById('view-faAssetLog2').disable();
	}
});



var parentFaAssetLogsViewWindow = new Ext.Window({
	title: 'FaAssetLog Under the selected Item',
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
			parentFaAssetLogsViewWindow.close();
		}
	}]
});

store_parent_faAssetLogs.load({
    params: {
        start: 0,    
        limit: list_size
    }
});