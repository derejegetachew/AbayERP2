var store_parent_imsDisposalItems = new Ext.data.Store({
	reader: new Ext.data.JsonReader({
		root:'rows',
		totalProperty: 'results',
		fields: [
			'id','ims_disposal','ims_item','measurement','quantity','remark','created','modified'	
		]
	}),
	proxy: new Ext.data.HttpProxy({
		url: '<?php echo $this->Html->url(array('controller' => 'imsDisposalItems', 'action' => 'list_data', $parent_id)); ?>'	})
});


function AddParentImsDisposalItem() {
	Ext.Ajax.request({
		url: '<?php echo $this->Html->url(array('controller' => 'imsDisposalItems', 'action' => 'add', $parent_id)); ?>',
		success: function(response, opts) {
			var parent_imsDisposalItem_data = response.responseText;
			
			eval(parent_imsDisposalItem_data);
			
			ImsDisposalItemAddWindow.show();
		},
		failure: function(response, opts) {
			Ext.Msg.alert('<?php __('Error'); ?>', '<?php __('Cannot get the imsDisposalItem add form. Error code'); ?>: ' + response.status);
		}
	});
}

function EditParentImsDisposalItem(id) {
	Ext.Ajax.request({
		url: '<?php echo $this->Html->url(array('controller' => 'imsDisposalItems', 'action' => 'edit')); ?>/'+id+'/<?php echo $parent_id; ?>',
		success: function(response, opts) {
			var parent_imsDisposalItem_data = response.responseText;
			
			eval(parent_imsDisposalItem_data);
			
			ImsDisposalItemEditWindow.show();
		},
		failure: function(response, opts) {
			Ext.Msg.alert('<?php __('Error'); ?>', '<?php __('Cannot get the imsDisposalItem edit form. Error code'); ?>: ' + response.status);
		}
	});
}

function ViewImsDisposalItem(id) {
	Ext.Ajax.request({
		url: '<?php echo $this->Html->url(array('controller' => 'imsDisposalItems', 'action' => 'view')); ?>/'+id,
		success: function(response, opts) {
			var imsDisposalItem_data = response.responseText;

			eval(imsDisposalItem_data);

			ImsDisposalItemViewWindow.show();
		},
		failure: function(response, opts) {
			Ext.Msg.alert('<?php __('Error'); ?>', '<?php __('Cannot get the imsDisposalItem view form. Error code'); ?>: ' + response.status);
		}
	});
}


function DeleteParentImsDisposalItem(id) {
	Ext.Ajax.request({
		url: '<?php echo $this->Html->url(array('controller' => 'imsDisposalItems', 'action' => 'delete')); ?>/'+id,
		success: function(response, opts) {
			Ext.Msg.alert('<?php __('Success'); ?>', '<?php __('ImsDisposalItem(s) successfully deleted!'); ?>');
			RefreshParentImsDisposalItemData();
		},
		failure: function(response, opts) {
			Ext.Msg.alert('<?php __('Error'); ?>', '<?php __('Cannot get the imsDisposalItem to be deleted. Error code'); ?>: ' + response.status);
		}
	});
}

function SearchByParentImsDisposalItemName(value){
	var conditions = '\'ImsDisposalItem.name LIKE\' => \'%' + value + '%\'';
	store_parent_imsDisposalItems.reload({
		 params: {
			start: 0,
			limit: list_size,
			conditions: conditions
	    }
	});
}

function RefreshParentImsDisposalItemData() {
	store_parent_imsDisposalItems.reload();
}



var g = new Ext.grid.GridPanel({
	title: '<?php __('Disposal Items'); ?>',
	store: store_parent_imsDisposalItems,
	loadMask: true,
	stripeRows: true,
	height: 300,
	anchor: '100%',
    id: 'imsDisposalItemGrid',
	columns: [
		{header:"<?php __('ims_disposal'); ?>", dataIndex: 'ims_disposal', sortable: true, hidden: true},
		{header:"<?php __('Item'); ?>", dataIndex: 'ims_item', sortable: true},
		{header: "<?php __('Measurement'); ?>", dataIndex: 'measurement', sortable: true},
		{header: "<?php __('Quantity'); ?>", dataIndex: 'quantity', sortable: true},
		{header: "<?php __('Remark'); ?>", dataIndex: 'remark', sortable: true},
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
            ViewImsDisposalItem(Ext.getCmp('imsDisposalItemGrid').getSelectionModel().getSelected().data.id);
        }
    },
	tbar: new Ext.Toolbar({
		items: [{
				xtype: 'tbbutton',
				text: '<?php __('Add'); ?>',
				tooltip:'<?php __('<b>Add Disposal Item</b><br />Click here to create a new Disposal Item'); ?>',
				icon: 'img/table_add.png',
				cls: 'x-btn-text-icon',
				handler: function(btn) {
					AddParentImsDisposalItem();
				}
			}, ' ', '-', ' ', {
				xtype: 'tbbutton',
				text: '<?php __('Edit'); ?>',
				id: 'edit-parent-imsDisposalItem',
				tooltip:'<?php __('<b>Edit Disposal Item</b><br />Click here to modify the selected Disposal Item'); ?>',
				icon: 'img/table_edit.png',
				cls: 'x-btn-text-icon',
				disabled: true,
				handler: function(btn) {
					var sm = g.getSelectionModel();
					var sel = sm.getSelected();
					if (sm.hasSelection()){
						EditParentImsDisposalItem(sel.data.id);
					};
				}
			}, ' ', '-', ' ', {
				xtype: 'tbbutton',
				text: '<?php __('Delete'); ?>',
				id: 'delete-parent-imsDisposalItem',
				tooltip:'<?php __('<b>Delete Disposal Item(s)</b><br />Click here to remove the selected Disposal Item(s)'); ?>',
				icon: 'img/table_delete.png',
				cls: 'x-btn-text-icon',
				disabled: true,
				handler: function(btn) {
					var sm = g.getSelectionModel();
					var sel = sm.getSelections();
					if (sm.hasSelection()){
						if(sel.length==1){
							Ext.Msg.show({
									title: '<?php __('Remove Disposal Item'); ?>',
									buttons: Ext.MessageBox.YESNOCANCEL,
									msg: '<?php __('Remove'); ?> '+sel[0].data.name+'?',
									icon: Ext.MessageBox.QUESTION,
                                    fn: function(btn){
											if (btn == 'yes'){
													DeleteParentImsDisposalItem(sel[0].data.id);
											}
									}
							});
						} else {
							Ext.Msg.show({
									title: '<?php __('Remove Disposal Item'); ?>',
									buttons: Ext.MessageBox.YESNOCANCEL,
									msg: '<?php __('Remove the selected ImsDisposalItem'); ?>?',
									icon: Ext.MessageBox.QUESTION,
                                    fn: function(btn){
											if (btn == 'yes'){
													var sel_ids = '';
													for(i=0;i<sel.length;i++){
														if(i>0)
															sel_ids += '_';
														sel_ids += sel[i].data.id;
													}
													DeleteParentImsDisposalItem(sel_ids);
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
				text: '<?php __('View Disposal Item'); ?>',
				id: 'view-imsDisposalItem2',
				tooltip:'<?php __('<b>View Disposal Item</b><br />Click here to see details of the selected Disposal Item'); ?>',
				icon: 'img/table_view.png',
				cls: 'x-btn-text-icon',
				disabled: true,
				handler: function(btn) {
					var sm = g.getSelectionModel();
					var sel = sm.getSelected();
					if (sm.hasSelection()){
						ViewImsDisposalItem(sel.data.id);
					};
				},
				menu : {
					items: [
					]
				}

            }, ' ', '->', {
				xtype: 'textfield',
				emptyText: '<?php __('[Search By Name]'); ?>',
				id: 'parent_imsDisposalItem_search_field',
				listeners: {
					specialkey: function(field, e){
						if (e.getKey() == e.ENTER) {
							SearchByParentImsDisposalItemName(Ext.getCmp('parent_imsDisposalItem_search_field').getValue());
						}
					}

				}
			}, {
				xtype: 'tbbutton',
				icon: 'img/search.png',
				cls: 'x-btn-text-icon',
				text: 'GO',
				tooltip:'<?php __('<b>GO</b><br />Click here to get search results'); ?>',
				id: 'parent_imsDisposalItem_go_button',
				handler: function(){
					SearchByParentImsDisposalItemName(Ext.getCmp('parent_imsDisposalItem_search_field').getValue());
				}
			}, ' '
	]}),
	bbar: new Ext.PagingToolbar({
		pageSize: list_size,
		store: store_parent_imsDisposalItems,
		displayInfo: true,
		displayMsg: '<?php __('Displaying {0} - {1} of {2}'); ?>',
		beforePageText: '<?php __('Page'); ?>',
		afterPageText: '<?php __('of {0}'); ?>',
		emptyMsg: '<?php __('No data to display'); ?>'
	})
});
g.getSelectionModel().on('rowselect', function(sm, rowIdx, r) {
	g.getTopToolbar().findById('edit-parent-imsDisposalItem').enable();
	g.getTopToolbar().findById('delete-parent-imsDisposalItem').enable();
        g.getTopToolbar().findById('view-imsDisposalItem2').enable();
	if(this.getSelections().length > 1){
		g.getTopToolbar().findById('edit-parent-imsDisposalItem').disable();
                g.getTopToolbar().findById('view-imsDisposalItem2').disable();
	}
});
g.getSelectionModel().on('rowdeselect', function(sm, rowIdx, r) {
	if(this.getSelections().length > 1){
		g.getTopToolbar().findById('edit-parent-imsDisposalItem').disable();
		g.getTopToolbar().findById('delete-parent-imsDisposalItem').enable();
                g.getTopToolbar().findById('view-imsDisposalItem2').disable();
	}
	else if(this.getSelections().length == 1){
		g.getTopToolbar().findById('edit-parent-imsDisposalItem').enable();
		g.getTopToolbar().findById('delete-parent-imsDisposalItem').enable();
                g.getTopToolbar().findById('view-imsDisposalItem2').enable();
	}
	else{
		g.getTopToolbar().findById('edit-parent-imsDisposalItem').disable();
		g.getTopToolbar().findById('delete-parent-imsDisposalItem').disable();
                g.getTopToolbar().findById('view-imsDisposalItem2').disable();
	}
});



var parentImsDisposalItemsViewWindow = new Ext.Window({
	title: 'Disposal Item Under the selected Disposal',
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
			parentImsDisposalItemsViewWindow.close();
		}
	}]
});

store_parent_imsDisposalItems.load({
    params: {
        start: 0,    
        limit: list_size
    }
});