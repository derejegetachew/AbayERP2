var store_parent_grnItems = new Ext.data.Store({
	reader: new Ext.data.JsonReader({
		root:'rows',
		totalProperty: 'results',
		fields: [
			'id','grn','purchase_order_item','quantity','unit_price','created','modified'	
		]
	}),
	proxy: new Ext.data.HttpProxy({
		url: '<?php echo $this->Html->url(array('controller' => 'grnItems', 'action' => 'list_data', $parent_id)); ?>'	})
});


function AddParentGrnItem() {
	Ext.Ajax.request({
		url: '<?php echo $this->Html->url(array('controller' => 'grnItems', 'action' => 'add', $parent_id)); ?>',
		success: function(response, opts) {
			var parent_grnItem_data = response.responseText;
			
			eval(parent_grnItem_data);
			
			GrnItemAddWindow.show();
		},
		failure: function(response, opts) {
			Ext.Msg.alert('<?php __('Error'); ?>', '<?php __('Cannot get the grnItem add form. Error code'); ?>: ' + response.status);
		}
	});
}

function EditParentGrnItem(id) {
	Ext.Ajax.request({
		url: '<?php echo $this->Html->url(array('controller' => 'grnItems', 'action' => 'edit')); ?>/'+id+'/<?php echo $parent_id; ?>',
		success: function(response, opts) {
			var parent_grnItem_data = response.responseText;
			
			eval(parent_grnItem_data);
			
			GrnItemEditWindow.show();
		},
		failure: function(response, opts) {
			Ext.Msg.alert('<?php __('Error'); ?>', '<?php __('Cannot get the grnItem edit form. Error code'); ?>: ' + response.status);
		}
	});
}

function ViewGrnItem(id) {
	Ext.Ajax.request({
		url: '<?php echo $this->Html->url(array('controller' => 'grnItems', 'action' => 'view')); ?>/'+id,
		success: function(response, opts) {
			var grnItem_data = response.responseText;

			eval(grnItem_data);

			GrnItemViewWindow.show();
		},
		failure: function(response, opts) {
			Ext.Msg.alert('<?php __('Error'); ?>', '<?php __('Cannot get the grnItem view form. Error code'); ?>: ' + response.status);
		}
	});
}

function ViewGrnItemStores(id) {
	Ext.Ajax.request({
		url: '<?php echo $this->Html->url(array('controller' => 'stores', 'action' => 'index2')); ?>/'+id,
		success: function(response, opts) {
			var parent_stores_data = response.responseText;

			eval(parent_stores_data);

			parentStoresViewWindow.show();
		},
		failure: function(response, opts) {
			Ext.Msg.alert('<?php __('Error'); ?>', '<?php __('Cannot get the campus view form. Error code'); ?>: ' + response.status);
		}
	});
}


function DeleteParentGrnItem(id) {
	Ext.Ajax.request({
		url: '<?php echo $this->Html->url(array('controller' => 'grnItems', 'action' => 'delete')); ?>/'+id,
		success: function(response, opts) {
			Ext.Msg.alert('<?php __('Success'); ?>', '<?php __('GrnItem(s) successfully deleted!'); ?>');
			RefreshParentGrnItemData();
		},
		failure: function(response, opts) {
			Ext.Msg.alert('<?php __('Error'); ?>', '<?php __('Cannot get the grnItem to be deleted. Error code'); ?>: ' + response.status);
		}
	});
}

function SearchByParentGrnItemName(value){
	var conditions = '\'GrnItem.name LIKE\' => \'%' + value + '%\'';
	store_parent_grnItems.reload({
		 params: {
			start: 0,
			limit: list_size,
			conditions: conditions
	    }
	});
}

function RefreshParentGrnItemData() {
	store_parent_grnItems.reload();
}



var g = new Ext.grid.GridPanel({
	title: '<?php __('GrnItems'); ?>',
	store: store_parent_grnItems,
	loadMask: true,
	stripeRows: true,
	height: 300,
	anchor: '100%',
    id: 'grnItemGrid',
	columns: [
		{header:"<?php __('PO Item'); ?>", dataIndex: 'purchase_order_item', sortable: true},
		{header: "<?php __('Quantity'); ?>", dataIndex: 'quantity', sortable: true},
		{header: "<?php __('Unit Price'); ?>", dataIndex: 'unit_price', sortable: true},
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
            ViewGrnItem(Ext.getCmp('grnItemGrid').getSelectionModel().getSelected().data.id);
        }
    },
	tbar: new Ext.Toolbar({
		items: [ {
				xtype: 'tbbutton',
				text: '<?php __('Edit'); ?>',
				id: 'edit-parent-grnItem',
				tooltip:'<?php __('<b>Edit GrnItem</b><br />Click here to modify the selected GrnItem'); ?>',
				icon: 'img/table_edit.png',
				cls: 'x-btn-text-icon',
				disabled: true,
				handler: function(btn) {
					var sm = g.getSelectionModel();
					var sel = sm.getSelected();
					if (sm.hasSelection()){
						EditParentGrnItem(sel.data.id);
					};
				}
			}, ' ', '-', ' ', {
				xtype: 'tbbutton',
				text: '<?php __('Delete'); ?>',
				id: 'delete-parent-grnItem',
				tooltip:'<?php __('<b>Delete GrnItem(s)</b><br />Click here to remove the selected GrnItem(s)'); ?>',
				icon: 'img/table_delete.png',
				cls: 'x-btn-text-icon',
				disabled: true,
				handler: function(btn) {
					var sm = g.getSelectionModel();
					var sel = sm.getSelections();
					if (sm.hasSelection()){
						if(sel.length==1){
							Ext.Msg.show({
									title: '<?php __('Remove GrnItem'); ?>',
									buttons: Ext.MessageBox.YESNOCANCEL,
									msg: '<?php __('Remove'); ?> '+sel[0].data.name+'?',
									icon: Ext.MessageBox.QUESTION,
                                    fn: function(btn){
											if (btn == 'yes'){
													DeleteParentGrnItem(sel[0].data.id);
											}
									}
							});
						} else {
							Ext.Msg.show({
									title: '<?php __('Remove GrnItem'); ?>',
									buttons: Ext.MessageBox.YESNOCANCEL,
									msg: '<?php __('Remove the selected GrnItem'); ?>?',
									icon: Ext.MessageBox.QUESTION,
                                    fn: function(btn){
											if (btn == 'yes'){
													var sel_ids = '';
													for(i=0;i<sel.length;i++){
														if(i>0)
															sel_ids += '_';
														sel_ids += sel[i].data.id;
													}
													DeleteParentGrnItem(sel_ids);
											}
									}
							});
						}
					} else {
						Ext.Msg.alert('<?php __('Warning'); ?>', '<?php __('Please select a record first'); ?>');
					};
				}
			},  '->', {
				xtype: 'textfield',
				emptyText: '<?php __('[Search By Name]'); ?>',
				id: 'parent_grnItem_search_field',
				listeners: {
					specialkey: function(field, e){
						if (e.getKey() == e.ENTER) {
							SearchByParentGrnItemName(Ext.getCmp('parent_grnItem_search_field').getValue());
						}
					}

				}
			}, {
				xtype: 'tbbutton',
				icon: 'img/search.png',
				cls: 'x-btn-text-icon',
				text: 'GO',
				tooltip:'<?php __('<b>GO</b><br />Click here to get search results'); ?>',
				id: 'parent_grnItem_go_button',
				handler: function(){
					SearchByParentGrnItemName(Ext.getCmp('parent_grnItem_search_field').getValue());
				}
			}, ' '
	]}),
	bbar: new Ext.PagingToolbar({
		pageSize: list_size,
		store: store_parent_grnItems,
		displayInfo: true,
		displayMsg: '<?php __('Displaying {0} - {1} of {2}'); ?>',
		beforePageText: '<?php __('Page'); ?>',
		afterPageText: '<?php __('of {0}'); ?>',
		emptyMsg: '<?php __('No data to display'); ?>'
	})
});
g.getSelectionModel().on('rowselect', function(sm, rowIdx, r) {
	g.getTopToolbar().findById('edit-parent-grnItem').enable();
	g.getTopToolbar().findById('delete-parent-grnItem').enable();
        g.getTopToolbar().findById('view-grnItem2').enable();
	if(this.getSelections().length > 1){
		g.getTopToolbar().findById('edit-parent-grnItem').disable();
                g.getTopToolbar().findById('view-grnItem2').disable();
	}
});
g.getSelectionModel().on('rowdeselect', function(sm, rowIdx, r) {
	if(this.getSelections().length > 1){
		g.getTopToolbar().findById('edit-parent-grnItem').disable();
		g.getTopToolbar().findById('delete-parent-grnItem').enable();
                g.getTopToolbar().findById('view-grnItem2').disable();
	}
	else if(this.getSelections().length == 1){
		g.getTopToolbar().findById('edit-parent-grnItem').enable();
		g.getTopToolbar().findById('delete-parent-grnItem').enable();
                g.getTopToolbar().findById('view-grnItem2').enable();
	}
	else{
		g.getTopToolbar().findById('edit-parent-grnItem').disable();
		g.getTopToolbar().findById('delete-parent-grnItem').disable();
                g.getTopToolbar().findById('view-grnItem2').disable();
	}
});



var parentGrnItemsViewWindow = new Ext.Window({
	title: 'GrnItem Under the selected Item',
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
			parentGrnItemsViewWindow.close();
		}
	}]
});

store_parent_grnItems.load({
    params: {
        start: 0,    
        limit: list_size
    }
});