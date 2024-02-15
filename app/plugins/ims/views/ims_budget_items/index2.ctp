//<script>
var store_parent_imsBudgetItems = new Ext.data.GroupingStore({
	reader: new Ext.data.JsonReader({
		root:'rows',
		totalProperty: 'results',
		fields: [
			'id','ims_budget','ims_item','item_category','quantity','measurement','created','modified'	
		]
	}),
	proxy: new Ext.data.HttpProxy({
		url: '<?php echo $this->Html->url(array('controller' => 'imsBudgetItems', 'action' => 'list_data', $parent_id)); ?>'	
	}),
	sortInfo:{field: 'ims_item', direction: "ASC"},
	groupField: 'item_category'
});


function AddParentImsBudgetItem() {
	Ext.Ajax.request({
		url: '<?php echo $this->Html->url(array('controller' => 'imsBudgetItems', 'action' => 'add', $parent_id)); ?>',
		success: function(response, opts) {
			var parent_imsBudgetItem_data = response.responseText;
			
			eval(parent_imsBudgetItem_data);
			
			ImsBudgetItemAddWindow.show();
		},
		failure: function(response, opts) {
			Ext.Msg.alert('<?php __('Error'); ?>', '<?php __('Cannot get the BudgetItem add form. Error code'); ?>: ' + response.status);
		}
	});
}

function EditParentImsBudgetItem(id) {
	Ext.Ajax.request({
		url: '<?php echo $this->Html->url(array('controller' => 'imsBudgetItems', 'action' => 'edit')); ?>/'+id+'/<?php echo $parent_id; ?>',
		success: function(response, opts) {
			var parent_imsBudgetItem_data = response.responseText;
			
			eval(parent_imsBudgetItem_data);
			
			ImsBudgetItemEditWindow.show();
		},
		failure: function(response, opts) {
			Ext.Msg.alert('<?php __('Error'); ?>', '<?php __('Cannot get the BudgetItem edit form. Error code'); ?>: ' + response.status);
		}
	});
}

function ViewImsBudgetItem(id) {
	Ext.Ajax.request({
		url: '<?php echo $this->Html->url(array('controller' => 'imsBudgetItems', 'action' => 'view')); ?>/'+id,
		success: function(response, opts) {
			var imsBudgetItem_data = response.responseText;

			eval(imsBudgetItem_data);

			ImsBudgetItemViewWindow.show();
		},
		failure: function(response, opts) {
			Ext.Msg.alert('<?php __('Error'); ?>', '<?php __('Cannot get the BudgetItem view form. Error code'); ?>: ' + response.status);
		}
	});
}


function DeleteParentImsBudgetItem(id) {
	Ext.Ajax.request({
		url: '<?php echo $this->Html->url(array('controller' => 'imsBudgetItems', 'action' => 'delete')); ?>/'+id,		
		success: function(response, opts) {
			Ext.Msg.alert('<?php __('Success'); ?>', '<?php __('Budget Item(s) successfully deleted!'); ?>');
			RefreshParentImsBudgetItemData();
		},
		failure: function(response, opts) {
			Ext.Msg.alert('<?php __('Error'); ?>', '<?php __('Cannot get the BudgetItem to be deleted. Error code'); ?>: ' + response.status);
		}
	});
}

function SearchByParentImsBudgetItemName(value){
	var conditions = '\'ImsItem.name LIKE\' => \'%' + value + '%\'';
	store_parent_imsBudgetItems.reload({
		 params: {
			start: 0,
			limit: list_size,
			conditions: conditions
	    }
	});
}

function RefreshParentImsBudgetItemData() {
	store_parent_imsBudgetItems.reload();
}



var g = new Ext.grid.GridPanel({
	title: '<?php __('Budget Items'); ?>',
	store: store_parent_imsBudgetItems,
	loadMask: true,
	stripeRows: true,
	height: 300,
	anchor: '100%',
    id: 'imsBudgetItemGrid',
	columns: [
		{header: "<?php __('Budget'); ?>", dataIndex: 'ims_budget', sortable: true,hidden:true},
		{header: "<?php __('Item'); ?>", dataIndex: 'ims_item', sortable: true},
		{header: "<?php __('Category'); ?>", dataIndex: 'item_category', sortable: true,hidden:true},
		{header: "<?php __('Quantity'); ?>", dataIndex: 'quantity', sortable: true},
		{header: "<?php __('Measurement'); ?>", dataIndex: 'measurement', sortable: true},
		{header: "<?php __('Created'); ?>", dataIndex: 'created', sortable: true},
		{header: "<?php __('Modified'); ?>", dataIndex: 'modified', sortable: true}	],
	sm: new Ext.grid.RowSelectionModel({
		singleSelect: false
	}),
	view: new Ext.grid.GroupingView({
		forceFit:true,
		groupTextTpl: '{text} ({[values.rs.length]} {[values.rs.length > 1 ? "Budget Items" : "Budget Item"]})'
	}),
    listeners: {
        celldblclick: function(){
            ViewImsBudgetItem(Ext.getCmp('imsBudgetItemGrid').getSelectionModel().getSelected().data.id);
        }
    },
	tbar: new Ext.Toolbar({
		items: [{
				xtype: 'tbbutton',
				text: '<?php __('Add'); ?>',
				tooltip:'<?php __('<b>Add Budget Item</b><br />Click here to create a new Budget Item'); ?>',
				icon: 'img/table_add.png',
				cls: 'x-btn-text-icon',
				handler: function(btn) {
					AddParentImsBudgetItem();
				}
			}, ' ', '-', ' ', {
				xtype: 'tbbutton',
				text: '<?php __('Edit'); ?>',
				id: 'edit-parent-imsBudgetItem',
				tooltip:'<?php __('<b>Edit Budget Item</b><br />Click here to modify the selected Budget Item'); ?>',
				icon: 'img/table_edit.png',
				cls: 'x-btn-text-icon',
				disabled: true,
				handler: function(btn) {
					var sm = g.getSelectionModel();
					var sel = sm.getSelected();
					if (sm.hasSelection()){
						EditParentImsBudgetItem(sel.data.id);
					};
				}
			}, ' ', '-', ' ', {
				xtype: 'tbbutton',
				text: '<?php __('Delete'); ?>',
				id: 'delete-parent-imsBudgetItem',
				tooltip:'<?php __('<b>Delete Budget Item(s)</b><br />Click here to remove the selected Budget Item(s)'); ?>',
				icon: 'img/table_delete.png',
				cls: 'x-btn-text-icon',
				disabled: true,
				handler: function(btn) {
					var sm = g.getSelectionModel();
					var sel = sm.getSelections();
					if (sm.hasSelection()){
						if(sel.length==1){
							Ext.Msg.show({
									title: '<?php __('Remove Budget Item'); ?>',
									buttons: Ext.MessageBox.YESNOCANCEL,
									msg: '<?php __('Remove'); ?> '+sel[0].data.ims_item+'?',
									icon: Ext.MessageBox.QUESTION,
                                    fn: function(btn){
											if (btn == 'yes'){
													DeleteParentImsBudgetItem(sel[0].data.id);
											}
									}
							});
						} else {
							Ext.Msg.show({
									title: '<?php __('Remove Budget Item'); ?>',
									buttons: Ext.MessageBox.YESNOCANCEL,
									msg: '<?php __('Remove the selected Budget Item'); ?>?',
									icon: Ext.MessageBox.QUESTION,
                                    fn: function(btn){
											if (btn == 'yes'){
													var sel_ids = '';
													for(i=0;i<sel.length;i++){
														if(i>0)
															sel_ids += '_';
														sel_ids += sel[i].data.id;
													}
													DeleteParentImsBudgetItem(sel_ids);
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
				text: '<?php __('View Budget Item'); ?>',
				id: 'view-imsBudgetItem2',
				tooltip:'<?php __('<b>View Budget Item</b><br />Click here to see details of the selected Budget Item'); ?>',
				icon: 'img/table_view.png',
				cls: 'x-btn-text-icon',
				disabled: true,
				handler: function(btn) {
					var sm = g.getSelectionModel();
					var sel = sm.getSelected();
					if (sm.hasSelection()){
						ViewImsBudgetItem(sel.data.id);
					};
				},
				menu : {
					items: [
					]
				}

            }, ' ', '->', {
				xtype: 'textfield',
				emptyText: '<?php __('[Search By Item]'); ?>',
				id: 'parent_imsBudgetItem_search_field',
				listeners: {
					specialkey: function(field, e){
						if (e.getKey() == e.ENTER) {
							SearchByParentImsBudgetItemName(Ext.getCmp('parent_imsBudgetItem_search_field').getValue());
						}
					}

				}
			}, {
				xtype: 'tbbutton',
				icon: 'img/search.png',
				cls: 'x-btn-text-icon',
				text: 'GO',
				tooltip:'<?php __('<b>GO</b><br />Click here to get search results'); ?>',
				id: 'parent_imsBudgetItem_go_button',
				handler: function(){
					SearchByParentImsBudgetItemName(Ext.getCmp('parent_imsBudgetItem_search_field').getValue());
				}
			}, ' '
	]}),
	bbar: new Ext.PagingToolbar({
		pageSize: list_size,
		store: store_parent_imsBudgetItems,
		displayInfo: true,
		displayMsg: '<?php __('Displaying {0} - {1} of {2}'); ?>',
		beforePageText: '<?php __('Page'); ?>',
		afterPageText: '<?php __('of {0}'); ?>',
		emptyMsg: '<?php __('No data to display'); ?>'
	})
});
g.getSelectionModel().on('rowselect', function(sm, rowIdx, r) {
	g.getTopToolbar().findById('edit-parent-imsBudgetItem').enable();
	g.getTopToolbar().findById('delete-parent-imsBudgetItem').enable();
        g.getTopToolbar().findById('view-imsBudgetItem2').enable();
	if(this.getSelections().length > 1){
		g.getTopToolbar().findById('edit-parent-imsBudgetItem').disable();
                g.getTopToolbar().findById('view-imsBudgetItem2').disable();
	}
});
g.getSelectionModel().on('rowdeselect', function(sm, rowIdx, r) {
	if(this.getSelections().length > 1){
		g.getTopToolbar().findById('edit-parent-imsBudgetItem').disable();
		g.getTopToolbar().findById('delete-parent-imsBudgetItem').enable();
                g.getTopToolbar().findById('view-imsBudgetItem2').disable();
	}
	else if(this.getSelections().length == 1){
		g.getTopToolbar().findById('edit-parent-imsBudgetItem').enable();
		g.getTopToolbar().findById('delete-parent-imsBudgetItem').enable();
                g.getTopToolbar().findById('view-imsBudgetItem2').enable();
	}
	else{
		g.getTopToolbar().findById('edit-parent-imsBudgetItem').disable();
		g.getTopToolbar().findById('delete-parent-imsBudgetItem').disable();
                g.getTopToolbar().findById('view-imsBudgetItem2').disable();
	}
});



var parentImsBudgetItemsViewWindow = new Ext.Window({
	title: 'Budget Item Under the selected Item',
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
			parentImsBudgetItemsViewWindow.close();
		}
	}]
});

store_parent_imsBudgetItems.load({
    params: {
        start: 0,    
        limit: list_size
    }
});