var store_parent_imsReturnItems = new Ext.data.Store({
	reader: new Ext.data.JsonReader({
		root:'rows',
		totalProperty: 'results',
		fields: [
			'id','ims_return','ims_sirv_item','ims_item','measurement','quantity','unit_price','tag','remark','created','modified'	
		]
	}),
	proxy: new Ext.data.HttpProxy({
		url: '<?php echo $this->Html->url(array('controller' => 'imsReturnItems', 'action' => 'list_data', $parent_id)); ?>'	})
});


function AddParentImsReturnItem() {
	Ext.Ajax.request({
		url: '<?php echo $this->Html->url(array('controller' => 'imsReturnItems', 'action' => 'add', $parent_id)); ?>',
		success: function(response, opts) {
			var parent_imsReturnItem_data = response.responseText;
			
			eval(parent_imsReturnItem_data);
			
			ImsReturnItemAddWindow.show();
		},
		failure: function(response, opts) {
			Ext.Msg.alert('<?php __('Error'); ?>', '<?php __('Cannot get the imsReturnItem add form. Error code'); ?>: ' + response.status);
		}
	});
}

function EditParentImsReturnItem(id) {
	Ext.Ajax.request({
		url: '<?php echo $this->Html->url(array('controller' => 'imsReturnItems', 'action' => 'edit')); ?>/'+id+'/<?php echo $parent_id; ?>',
		success: function(response, opts) {
			var parent_imsReturnItem_data = response.responseText;
			
			eval(parent_imsReturnItem_data);
			
			ImsReturnItemEditWindow.show();
		},
		failure: function(response, opts) {
			Ext.Msg.alert('<?php __('Error'); ?>', '<?php __('Cannot get the imsReturnItem edit form. Error code'); ?>: ' + response.status);
		}
	});
}

function ViewImsReturnItem(id) {
	Ext.Ajax.request({
		url: '<?php echo $this->Html->url(array('controller' => 'imsReturnItems', 'action' => 'view')); ?>/'+id,
		success: function(response, opts) {
			var imsReturnItem_data = response.responseText;

			eval(imsReturnItem_data);

			ImsReturnItemViewWindow.show();
		},
		failure: function(response, opts) {
			Ext.Msg.alert('<?php __('Error'); ?>', '<?php __('Cannot get the imsReturnItem view form. Error code'); ?>: ' + response.status);
		}
	});
}


function DeleteParentImsReturnItem(id) {
	Ext.Ajax.request({
		url: '<?php echo $this->Html->url(array('controller' => 'imsReturnItems', 'action' => 'delete')); ?>/'+id,
		success: function(response, opts) {
			Ext.Msg.alert('<?php __('Success'); ?>', '<?php __('ImsReturnItem(s) successfully deleted!'); ?>');
			RefreshParentImsReturnItemData();
		},
		failure: function(response, opts) {
			Ext.Msg.alert('<?php __('Error'); ?>', '<?php __('Cannot get the imsReturnItem to be deleted. Error code'); ?>: ' + response.status);
		}
	});
}

function SearchByParentImsReturnItemName(value){
	var conditions = '\'ImsReturnItem.name LIKE\' => \'%' + value + '%\'';
	store_parent_imsReturnItems.reload({
		 params: {
			start: 0,
			limit: list_size,
			conditions: conditions
	    }
	});
}

function RefreshParentImsReturnItemData() {
	store_parent_imsReturnItems.reload();
}



var g = new Ext.grid.GridPanel({
	title: '<?php __('ImsReturnItems'); ?>',
	store: store_parent_imsReturnItems,
	loadMask: true,
	stripeRows: true,
	height: 300,
	anchor: '100%',
    id: 'imsReturnItemGrid',
	columns: [
		{header: "<?php __('Return Number'); ?>", dataIndex: 'ims_return', sortable: true},
			{header: "<?php __('Sirv'); ?>", dataIndex: 'ims_sirv_item', sortable: true},
			{header: "<?php __('Item'); ?>", dataIndex: 'ims_item', sortable: true},
			{header: "<?php __('Measurement'); ?>", dataIndex: 'measurement', sortable: true},
			{header: "<?php __('Quantity'); ?>", dataIndex: 'quantity', sortable: true},
			{header: "<?php __('Unit Price'); ?>", dataIndex: 'unit_price', sortable: true},
			{header: "<?php __('Tag'); ?>", dataIndex: 'tag', sortable: true},
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
            ViewImsReturnItem(Ext.getCmp('imsReturnItemGrid').getSelectionModel().getSelected().data.id);
        }
    },
	tbar: new Ext.Toolbar({
		items: [{
				xtype: 'tbbutton',
				text: '<?php __('Add'); ?>',
				tooltip:'<?php __('<b>Add ImsReturnItem</b><br />Click here to create a new ImsReturnItem'); ?>',
				icon: 'img/table_add.png',
				cls: 'x-btn-text-icon',
				handler: function(btn) {
					AddParentImsReturnItem();
				}
			}, ' ', '-', ' ', {
				xtype: 'tbbutton',
				text: '<?php __('Edit'); ?>',
				id: 'edit-parent-imsReturnItem',
				tooltip:'<?php __('<b>Edit ImsReturnItem</b><br />Click here to modify the selected ImsReturnItem'); ?>',
				icon: 'img/table_edit.png',
				cls: 'x-btn-text-icon',
				disabled: true,
				handler: function(btn) {
					var sm = g.getSelectionModel();
					var sel = sm.getSelected();
					if (sm.hasSelection()){
						EditParentImsReturnItem(sel.data.id);
					};
				}
			}, ' ', '-', ' ', {
				xtype: 'tbbutton',
				text: '<?php __('Delete'); ?>',
				id: 'delete-parent-imsReturnItem',
				tooltip:'<?php __('<b>Delete ImsReturnItem(s)</b><br />Click here to remove the selected ImsReturnItem(s)'); ?>',
				icon: 'img/table_delete.png',
				cls: 'x-btn-text-icon',
				disabled: true,
				handler: function(btn) {
					var sm = g.getSelectionModel();
					var sel = sm.getSelections();
					if (sm.hasSelection()){
						if(sel.length==1){
							Ext.Msg.show({
									title: '<?php __('Remove ImsReturnItem'); ?>',
									buttons: Ext.MessageBox.YESNOCANCEL,
									msg: '<?php __('Remove'); ?> '+sel[0].data.name+'?',
									icon: Ext.MessageBox.QUESTION,
                                    fn: function(btn){
											if (btn == 'yes'){
													DeleteParentImsReturnItem(sel[0].data.id);
											}
									}
							});
						} else {
							Ext.Msg.show({
									title: '<?php __('Remove ImsReturnItem'); ?>',
									buttons: Ext.MessageBox.YESNOCANCEL,
									msg: '<?php __('Remove the selected ImsReturnItem'); ?>?',
									icon: Ext.MessageBox.QUESTION,
                                    fn: function(btn){
											if (btn == 'yes'){
													var sel_ids = '';
													for(i=0;i<sel.length;i++){
														if(i>0)
															sel_ids += '_';
														sel_ids += sel[i].data.id;
													}
													DeleteParentImsReturnItem(sel_ids);
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
				text: '<?php __('View ImsReturnItem'); ?>',
				id: 'view-imsReturnItem2',
				tooltip:'<?php __('<b>View ImsReturnItem</b><br />Click here to see details of the selected ImsReturnItem'); ?>',
				icon: 'img/table_view.png',
				cls: 'x-btn-text-icon',
				disabled: true,
				handler: function(btn) {
					var sm = g.getSelectionModel();
					var sel = sm.getSelected();
					if (sm.hasSelection()){
						ViewImsReturnItem(sel.data.id);
					};
				},
				menu : {
					items: [
					]
				}

            }, ' ', '->', {
				xtype: 'textfield',
				emptyText: '<?php __('[Search By Name]'); ?>',
				id: 'parent_imsReturnItem_search_field',
				listeners: {
					specialkey: function(field, e){
						if (e.getKey() == e.ENTER) {
							SearchByParentImsReturnItemName(Ext.getCmp('parent_imsReturnItem_search_field').getValue());
						}
					}

				}
			}, {
				xtype: 'tbbutton',
				icon: 'img/search.png',
				cls: 'x-btn-text-icon',
				text: 'GO',
				tooltip:'<?php __('<b>GO</b><br />Click here to get search results'); ?>',
				id: 'parent_imsReturnItem_go_button',
				handler: function(){
					SearchByParentImsReturnItemName(Ext.getCmp('parent_imsReturnItem_search_field').getValue());
				}
			}, ' '
	]}),
	bbar: new Ext.PagingToolbar({
		pageSize: list_size,
		store: store_parent_imsReturnItems,
		displayInfo: true,
		displayMsg: '<?php __('Displaying {0} - {1} of {2}'); ?>',
		beforePageText: '<?php __('Page'); ?>',
		afterPageText: '<?php __('of {0}'); ?>',
		emptyMsg: '<?php __('No data to display'); ?>'
	})
});
g.getSelectionModel().on('rowselect', function(sm, rowIdx, r) {
	g.getTopToolbar().findById('edit-parent-imsReturnItem').enable();
	g.getTopToolbar().findById('delete-parent-imsReturnItem').enable();
        g.getTopToolbar().findById('view-imsReturnItem2').enable();
	if(this.getSelections().length > 1){
		g.getTopToolbar().findById('edit-parent-imsReturnItem').disable();
                g.getTopToolbar().findById('view-imsReturnItem2').disable();
	}
});
g.getSelectionModel().on('rowdeselect', function(sm, rowIdx, r) {
	if(this.getSelections().length > 1){
		g.getTopToolbar().findById('edit-parent-imsReturnItem').disable();
		g.getTopToolbar().findById('delete-parent-imsReturnItem').enable();
                g.getTopToolbar().findById('view-imsReturnItem2').disable();
	}
	else if(this.getSelections().length == 1){
		g.getTopToolbar().findById('edit-parent-imsReturnItem').enable();
		g.getTopToolbar().findById('delete-parent-imsReturnItem').enable();
                g.getTopToolbar().findById('view-imsReturnItem2').enable();
	}
	else{
		g.getTopToolbar().findById('edit-parent-imsReturnItem').disable();
		g.getTopToolbar().findById('delete-parent-imsReturnItem').disable();
                g.getTopToolbar().findById('view-imsReturnItem2').disable();
	}
});



var parentImsReturnItemsViewWindow = new Ext.Window({
	title: 'ImsReturnItem Under the selected Item',
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
			parentImsReturnItemsViewWindow.close();
		}
	}]
});

store_parent_imsReturnItems.load({
    params: {
        start: 0,    
        limit: list_size
    }
});