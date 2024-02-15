var store_parent_imsStoresItems = new Ext.data.Store({
	reader: new Ext.data.JsonReader({
		root:'rows',
		totalProperty: 'results',
		fields: [
			'id','ims_store','ims_item','balance','created','modified'	
		]
	}),
	proxy: new Ext.data.HttpProxy({
		url: '<?php echo $this->Html->url(array('controller' => 'imsStoresItems', 'action' => 'list_data', $parent_id)); ?>'	})
});


function AddParentImsStoresItem() {
	Ext.Ajax.request({
		url: '<?php echo $this->Html->url(array('controller' => 'imsStoresItems', 'action' => 'add', $parent_id)); ?>',
		success: function(response, opts) {
			var parent_imsStoresItem_data = response.responseText;
			
			eval(parent_imsStoresItem_data);
			
			ImsStoresItemAddWindow.show();
		},
		failure: function(response, opts) {
			Ext.Msg.alert('<?php __('Error'); ?>', '<?php __('Cannot get the imsStoresItem add form. Error code'); ?>: ' + response.status);
		}
	});
}

function EditParentImsStoresItem(id) {
	Ext.Ajax.request({
		url: '<?php echo $this->Html->url(array('controller' => 'imsStoresItems', 'action' => 'edit')); ?>/'+id+'/<?php echo $parent_id; ?>',
		success: function(response, opts) {
			var parent_imsStoresItem_data = response.responseText;
			
			eval(parent_imsStoresItem_data);
			
			ImsStoresItemEditWindow.show();
		},
		failure: function(response, opts) {
			Ext.Msg.alert('<?php __('Error'); ?>', '<?php __('Cannot get the imsStoresItem edit form. Error code'); ?>: ' + response.status);
		}
	});
}

function ViewImsStoresItem(id) {
	Ext.Ajax.request({
		url: '<?php echo $this->Html->url(array('controller' => 'imsStoresItems', 'action' => 'view')); ?>/'+id,
		success: function(response, opts) {
			var imsStoresItem_data = response.responseText;

			eval(imsStoresItem_data);

			ImsStoresItemViewWindow.show();
		},
		failure: function(response, opts) {
			Ext.Msg.alert('<?php __('Error'); ?>', '<?php __('Cannot get the imsStoresItem view form. Error code'); ?>: ' + response.status);
		}
	});
}


function DeleteParentImsStoresItem(id) {
	Ext.Ajax.request({
		url: '<?php echo $this->Html->url(array('controller' => 'imsStoresItems', 'action' => 'delete')); ?>/'+id,
		success: function(response, opts) {
			Ext.Msg.alert('<?php __('Success'); ?>', '<?php __('ImsStoresItem(s) successfully deleted!'); ?>');
			RefreshParentImsStoresItemData();
		},
		failure: function(response, opts) {
			Ext.Msg.alert('<?php __('Error'); ?>', '<?php __('Cannot get the imsStoresItem to be deleted. Error code'); ?>: ' + response.status);
		}
	});
}

function SearchByParentImsStoresItemName(value){
	var conditions = '\'ImsStoresItem.name LIKE\' => \'%' + value + '%\'';
	store_parent_imsStoresItems.reload({
		 params: {
			start: 0,
			limit: list_size,
			conditions: conditions
	    }
	});
}

function RefreshParentImsStoresItemData() {
	store_parent_imsStoresItems.reload();
}



var g = new Ext.grid.GridPanel({
	title: '<?php __('ImsStoresItems'); ?>',
	store: store_parent_imsStoresItems,
	loadMask: true,
	stripeRows: true,
	height: 300,
	anchor: '100%',
    id: 'imsStoresItemGrid',
	columns: [
		{header:"<?php __('ims_store'); ?>", dataIndex: 'ims_store', sortable: true},
		{header:"<?php __('ims_item'); ?>", dataIndex: 'ims_item', sortable: true},
		{header: "<?php __('Balance'); ?>", dataIndex: 'balance', sortable: true},
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
            ViewImsStoresItem(Ext.getCmp('imsStoresItemGrid').getSelectionModel().getSelected().data.id);
        }
    },
	tbar: new Ext.Toolbar({
		items: [{
				xtype: 'tbbutton',
				text: '<?php __('Add'); ?>',
				tooltip:'<?php __('<b>Add ImsStoresItem</b><br />Click here to create a new ImsStoresItem'); ?>',
				icon: 'img/table_add.png',
				cls: 'x-btn-text-icon',
				handler: function(btn) {
					AddParentImsStoresItem();
				}
			}, ' ', '-', ' ', {
				xtype: 'tbbutton',
				text: '<?php __('Edit'); ?>',
				id: 'edit-parent-imsStoresItem',
				tooltip:'<?php __('<b>Edit ImsStoresItem</b><br />Click here to modify the selected ImsStoresItem'); ?>',
				icon: 'img/table_edit.png',
				cls: 'x-btn-text-icon',
				disabled: true,
				handler: function(btn) {
					var sm = g.getSelectionModel();
					var sel = sm.getSelected();
					if (sm.hasSelection()){
						EditParentImsStoresItem(sel.data.id);
					};
				}
			}, ' ', '-', ' ', {
				xtype: 'tbbutton',
				text: '<?php __('Delete'); ?>',
				id: 'delete-parent-imsStoresItem',
				tooltip:'<?php __('<b>Delete ImsStoresItem(s)</b><br />Click here to remove the selected ImsStoresItem(s)'); ?>',
				icon: 'img/table_delete.png',
				cls: 'x-btn-text-icon',
				disabled: true,
				handler: function(btn) {
					var sm = g.getSelectionModel();
					var sel = sm.getSelections();
					if (sm.hasSelection()){
						if(sel.length==1){
							Ext.Msg.show({
									title: '<?php __('Remove ImsStoresItem'); ?>',
									buttons: Ext.MessageBox.YESNOCANCEL,
									msg: '<?php __('Remove'); ?> '+sel[0].data.name+'?',
									icon: Ext.MessageBox.QUESTION,
                                    fn: function(btn){
											if (btn == 'yes'){
													DeleteParentImsStoresItem(sel[0].data.id);
											}
									}
							});
						} else {
							Ext.Msg.show({
									title: '<?php __('Remove ImsStoresItem'); ?>',
									buttons: Ext.MessageBox.YESNOCANCEL,
									msg: '<?php __('Remove the selected ImsStoresItem'); ?>?',
									icon: Ext.MessageBox.QUESTION,
                                    fn: function(btn){
											if (btn == 'yes'){
													var sel_ids = '';
													for(i=0;i<sel.length;i++){
														if(i>0)
															sel_ids += '_';
														sel_ids += sel[i].data.id;
													}
													DeleteParentImsStoresItem(sel_ids);
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
				text: '<?php __('View ImsStoresItem'); ?>',
				id: 'view-imsStoresItem2',
				tooltip:'<?php __('<b>View ImsStoresItem</b><br />Click here to see details of the selected ImsStoresItem'); ?>',
				icon: 'img/table_view.png',
				cls: 'x-btn-text-icon',
				disabled: true,
				handler: function(btn) {
					var sm = g.getSelectionModel();
					var sel = sm.getSelected();
					if (sm.hasSelection()){
						ViewImsStoresItem(sel.data.id);
					};
				},
				menu : {
					items: [
					]
				}

            }, ' ', '->', {
				xtype: 'textfield',
				emptyText: '<?php __('[Search By Name]'); ?>',
				id: 'parent_imsStoresItem_search_field',
				listeners: {
					specialkey: function(field, e){
						if (e.getKey() == e.ENTER) {
							SearchByParentImsStoresItemName(Ext.getCmp('parent_imsStoresItem_search_field').getValue());
						}
					}

				}
			}, {
				xtype: 'tbbutton',
				icon: 'img/search.png',
				cls: 'x-btn-text-icon',
				text: 'GO',
				tooltip:'<?php __('<b>GO</b><br />Click here to get search results'); ?>',
				id: 'parent_imsStoresItem_go_button',
				handler: function(){
					SearchByParentImsStoresItemName(Ext.getCmp('parent_imsStoresItem_search_field').getValue());
				}
			}, ' '
	]}),
	bbar: new Ext.PagingToolbar({
		pageSize: list_size,
		store: store_parent_imsStoresItems,
		displayInfo: true,
		displayMsg: '<?php __('Displaying {0} - {1} of {2}'); ?>',
		beforePageText: '<?php __('Page'); ?>',
		afterPageText: '<?php __('of {0}'); ?>',
		emptyMsg: '<?php __('No data to display'); ?>'
	})
});
g.getSelectionModel().on('rowselect', function(sm, rowIdx, r) {
	g.getTopToolbar().findById('edit-parent-imsStoresItem').enable();
	g.getTopToolbar().findById('delete-parent-imsStoresItem').enable();
        g.getTopToolbar().findById('view-imsStoresItem2').enable();
	if(this.getSelections().length > 1){
		g.getTopToolbar().findById('edit-parent-imsStoresItem').disable();
                g.getTopToolbar().findById('view-imsStoresItem2').disable();
	}
});
g.getSelectionModel().on('rowdeselect', function(sm, rowIdx, r) {
	if(this.getSelections().length > 1){
		g.getTopToolbar().findById('edit-parent-imsStoresItem').disable();
		g.getTopToolbar().findById('delete-parent-imsStoresItem').enable();
                g.getTopToolbar().findById('view-imsStoresItem2').disable();
	}
	else if(this.getSelections().length == 1){
		g.getTopToolbar().findById('edit-parent-imsStoresItem').enable();
		g.getTopToolbar().findById('delete-parent-imsStoresItem').enable();
                g.getTopToolbar().findById('view-imsStoresItem2').enable();
	}
	else{
		g.getTopToolbar().findById('edit-parent-imsStoresItem').disable();
		g.getTopToolbar().findById('delete-parent-imsStoresItem').disable();
                g.getTopToolbar().findById('view-imsStoresItem2').disable();
	}
});



var parentImsStoresItemsViewWindow = new Ext.Window({
	title: 'ImsStoresItem Under the selected Item',
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
			parentImsStoresItemsViewWindow.close();
		}
	}]
});

store_parent_imsStoresItems.load({
    params: {
        start: 0,    
        limit: list_size
    }
});