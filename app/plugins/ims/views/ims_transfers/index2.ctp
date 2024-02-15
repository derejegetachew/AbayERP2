var store_parent_imsTransfers = new Ext.data.Store({
	reader: new Ext.data.JsonReader({
		root:'rows',
		totalProperty: 'results',
		fields: [
			'id','name','ims_sirv','from_user','to_user','from_branch','to_branch','observer','approved_by','created','modified'	
		]
	}),
	proxy: new Ext.data.HttpProxy({
		url: '<?php echo $this->Html->url(array('controller' => 'imsTransfers', 'action' => 'list_data', $parent_id)); ?>'	})
});


function AddParentImsTransfer() {
	Ext.Ajax.request({
		url: '<?php echo $this->Html->url(array('controller' => 'imsTransfers', 'action' => 'add', $parent_id)); ?>',
		success: function(response, opts) {
			var parent_imsTransfer_data = response.responseText;
			
			eval(parent_imsTransfer_data);
			
			ImsTransferAddWindow.show();
		},
		failure: function(response, opts) {
			Ext.Msg.alert('<?php __('Error'); ?>', '<?php __('Cannot get the imsTransfer add form. Error code'); ?>: ' + response.status);
		}
	});
}

function EditParentImsTransfer(id) {
	Ext.Ajax.request({
		url: '<?php echo $this->Html->url(array('controller' => 'imsTransfers', 'action' => 'edit')); ?>/'+id+'/<?php echo $parent_id; ?>',
		success: function(response, opts) {
			var parent_imsTransfer_data = response.responseText;
			
			eval(parent_imsTransfer_data);
			
			ImsTransferEditWindow.show();
		},
		failure: function(response, opts) {
			Ext.Msg.alert('<?php __('Error'); ?>', '<?php __('Cannot get the imsTransfer edit form. Error code'); ?>: ' + response.status);
		}
	});
}

function ViewImsTransfer(id) {
	Ext.Ajax.request({
		url: '<?php echo $this->Html->url(array('controller' => 'imsTransfers', 'action' => 'view')); ?>/'+id,
		success: function(response, opts) {
			var imsTransfer_data = response.responseText;

			eval(imsTransfer_data);

			ImsTransferViewWindow.show();
		},
		failure: function(response, opts) {
			Ext.Msg.alert('<?php __('Error'); ?>', '<?php __('Cannot get the imsTransfer view form. Error code'); ?>: ' + response.status);
		}
	});
}

function ViewImsTransferImsTransferItems(id) {
	Ext.Ajax.request({
		url: '<?php echo $this->Html->url(array('controller' => 'imsTransferItems', 'action' => 'index2')); ?>/'+id,
		success: function(response, opts) {
			var parent_imsTransferItems_data = response.responseText;

			eval(parent_imsTransferItems_data);

			parentImsTransferItemsViewWindow.show();
		},
		failure: function(response, opts) {
			Ext.Msg.alert('<?php __('Error'); ?>', '<?php __('Cannot get the campus view form. Error code'); ?>: ' + response.status);
		}
	});
}


function DeleteParentImsTransfer(id) {
	Ext.Ajax.request({
		url: '<?php echo $this->Html->url(array('controller' => 'imsTransfers', 'action' => 'delete')); ?>/'+id,
		success: function(response, opts) {
			Ext.Msg.alert('<?php __('Success'); ?>', '<?php __('ImsTransfer(s) successfully deleted!'); ?>');
			RefreshParentImsTransferData();
		},
		failure: function(response, opts) {
			Ext.Msg.alert('<?php __('Error'); ?>', '<?php __('Cannot get the imsTransfer to be deleted. Error code'); ?>: ' + response.status);
		}
	});
}

function SearchByParentImsTransferName(value){
	var conditions = '\'ImsTransfer.name LIKE\' => \'%' + value + '%\'';
	store_parent_imsTransfers.reload({
		 params: {
			start: 0,
			limit: list_size,
			conditions: conditions
	    }
	});
}

function RefreshParentImsTransferData() {
	store_parent_imsTransfers.reload();
}



var g = new Ext.grid.GridPanel({
	title: '<?php __('ImsTransfers'); ?>',
	store: store_parent_imsTransfers,
	loadMask: true,
	stripeRows: true,
	height: 300,
	anchor: '100%',
    id: 'imsTransferGrid',
	columns: [
		{header: "<?php __('Name'); ?>", dataIndex: 'name', sortable: true},
		{header:"<?php __('ims_sirv'); ?>", dataIndex: 'ims_sirv', sortable: true},
		{header: "<?php __('From User'); ?>", dataIndex: 'from_user', sortable: true},
		{header: "<?php __('To User'); ?>", dataIndex: 'to_user', sortable: true},
		{header: "<?php __('From Branch'); ?>", dataIndex: 'from_branch', sortable: true},
		{header: "<?php __('To Branch'); ?>", dataIndex: 'to_branch', sortable: true},
		{header: "<?php __('Observer'); ?>", dataIndex: 'observer', sortable: true},
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
            ViewImsTransfer(Ext.getCmp('imsTransferGrid').getSelectionModel().getSelected().data.id);
        }
    },
	tbar: new Ext.Toolbar({
		items: [{
				xtype: 'tbbutton',
				text: '<?php __('Add'); ?>',
				tooltip:'<?php __('<b>Add ImsTransfer</b><br />Click here to create a new ImsTransfer'); ?>',
				icon: 'img/table_add.png',
				cls: 'x-btn-text-icon',
				handler: function(btn) {
					AddParentImsTransfer();
				}
			}, ' ', '-', ' ', {
				xtype: 'tbbutton',
				text: '<?php __('Edit'); ?>',
				id: 'edit-parent-imsTransfer',
				tooltip:'<?php __('<b>Edit ImsTransfer</b><br />Click here to modify the selected ImsTransfer'); ?>',
				icon: 'img/table_edit.png',
				cls: 'x-btn-text-icon',
				disabled: true,
				handler: function(btn) {
					var sm = g.getSelectionModel();
					var sel = sm.getSelected();
					if (sm.hasSelection()){
						EditParentImsTransfer(sel.data.id);
					};
				}
			}, ' ', '-', ' ', {
				xtype: 'tbbutton',
				text: '<?php __('Delete'); ?>',
				id: 'delete-parent-imsTransfer',
				tooltip:'<?php __('<b>Delete ImsTransfer(s)</b><br />Click here to remove the selected ImsTransfer(s)'); ?>',
				icon: 'img/table_delete.png',
				cls: 'x-btn-text-icon',
				disabled: true,
				handler: function(btn) {
					var sm = g.getSelectionModel();
					var sel = sm.getSelections();
					if (sm.hasSelection()){
						if(sel.length==1){
							Ext.Msg.show({
									title: '<?php __('Remove ImsTransfer'); ?>',
									buttons: Ext.MessageBox.YESNOCANCEL,
									msg: '<?php __('Remove'); ?> '+sel[0].data.name+'?',
									icon: Ext.MessageBox.QUESTION,
                                    fn: function(btn){
											if (btn == 'yes'){
													DeleteParentImsTransfer(sel[0].data.id);
											}
									}
							});
						} else {
							Ext.Msg.show({
									title: '<?php __('Remove ImsTransfer'); ?>',
									buttons: Ext.MessageBox.YESNOCANCEL,
									msg: '<?php __('Remove the selected ImsTransfer'); ?>?',
									icon: Ext.MessageBox.QUESTION,
                                    fn: function(btn){
											if (btn == 'yes'){
													var sel_ids = '';
													for(i=0;i<sel.length;i++){
														if(i>0)
															sel_ids += '_';
														sel_ids += sel[i].data.id;
													}
													DeleteParentImsTransfer(sel_ids);
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
				text: '<?php __('View ImsTransfer'); ?>',
				id: 'view-imsTransfer2',
				tooltip:'<?php __('<b>View ImsTransfer</b><br />Click here to see details of the selected ImsTransfer'); ?>',
				icon: 'img/table_view.png',
				cls: 'x-btn-text-icon',
				disabled: true,
				handler: function(btn) {
					var sm = g.getSelectionModel();
					var sel = sm.getSelected();
					if (sm.hasSelection()){
						ViewImsTransfer(sel.data.id);
					};
				},
				menu : {
					items: [
 {
						text: '<?php __('View Ims Transfer Items'); ?>',
                        icon: 'img/table_view.png',
						cls: 'x-btn-text-icon',
						handler: function(btn) {
							var sm = g.getSelectionModel();
							var sel = sm.getSelected();
							if (sm.hasSelection()){
								ViewImsTransferImsTransferItems(sel.data.id);
							};
						}
					}
					]
				}

            }, ' ', '->', {
				xtype: 'textfield',
				emptyText: '<?php __('[Search By Name]'); ?>',
				id: 'parent_imsTransfer_search_field',
				listeners: {
					specialkey: function(field, e){
						if (e.getKey() == e.ENTER) {
							SearchByParentImsTransferName(Ext.getCmp('parent_imsTransfer_search_field').getValue());
						}
					}

				}
			}, {
				xtype: 'tbbutton',
				icon: 'img/search.png',
				cls: 'x-btn-text-icon',
				text: 'GO',
				tooltip:'<?php __('<b>GO</b><br />Click here to get search results'); ?>',
				id: 'parent_imsTransfer_go_button',
				handler: function(){
					SearchByParentImsTransferName(Ext.getCmp('parent_imsTransfer_search_field').getValue());
				}
			}, ' '
	]}),
	bbar: new Ext.PagingToolbar({
		pageSize: list_size,
		store: store_parent_imsTransfers,
		displayInfo: true,
		displayMsg: '<?php __('Displaying {0} - {1} of {2}'); ?>',
		beforePageText: '<?php __('Page'); ?>',
		afterPageText: '<?php __('of {0}'); ?>',
		emptyMsg: '<?php __('No data to display'); ?>'
	})
});
g.getSelectionModel().on('rowselect', function(sm, rowIdx, r) {
	g.getTopToolbar().findById('edit-parent-imsTransfer').enable();
	g.getTopToolbar().findById('delete-parent-imsTransfer').enable();
        g.getTopToolbar().findById('view-imsTransfer2').enable();
	if(this.getSelections().length > 1){
		g.getTopToolbar().findById('edit-parent-imsTransfer').disable();
                g.getTopToolbar().findById('view-imsTransfer2').disable();
	}
});
g.getSelectionModel().on('rowdeselect', function(sm, rowIdx, r) {
	if(this.getSelections().length > 1){
		g.getTopToolbar().findById('edit-parent-imsTransfer').disable();
		g.getTopToolbar().findById('delete-parent-imsTransfer').enable();
                g.getTopToolbar().findById('view-imsTransfer2').disable();
	}
	else if(this.getSelections().length == 1){
		g.getTopToolbar().findById('edit-parent-imsTransfer').enable();
		g.getTopToolbar().findById('delete-parent-imsTransfer').enable();
                g.getTopToolbar().findById('view-imsTransfer2').enable();
	}
	else{
		g.getTopToolbar().findById('edit-parent-imsTransfer').disable();
		g.getTopToolbar().findById('delete-parent-imsTransfer').disable();
                g.getTopToolbar().findById('view-imsTransfer2').disable();
	}
});



var parentImsTransfersViewWindow = new Ext.Window({
	title: 'ImsTransfer Under the selected Item',
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
			parentImsTransfersViewWindow.close();
		}
	}]
});

store_parent_imsTransfers.load({
    params: {
        start: 0,    
        limit: list_size
    }
});