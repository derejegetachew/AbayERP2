//<script>
    var store_parent_itemCategories = new Ext.data.Store({
	reader: new Ext.data.JsonReader({
            root:'rows',
            totalProperty: 'results',
            fields: [
                'id','name','parent_item_category','lft','rght','created','modified'	
            ]
	}),
	proxy: new Ext.data.HttpProxy({
            url: '<?php echo $this->Html->url(array('controller' => 'itemCategories', 'action' => 'list_data', $parent_id)); ?>'	})
    });


    function AddParentItemCategory() {
	Ext.Ajax.request({
            url: '<?php echo $this->Html->url(array('controller' => 'itemCategories', 'action' => 'add', $parent_id)); ?>',
            success: function(response, opts) {
                var parent_itemCategory_data = response.responseText;

                eval(parent_itemCategory_data);

                ItemCategoryAddWindow.show();
            },
            failure: function(response, opts) {
                Ext.Msg.alert('<?php __('Error'); ?>', '<?php __('Cannot get the itemCategory add form. Error code'); ?>: ' + response.status);
            }
	});
    }

    function EditParentItemCategory(id) {
	Ext.Ajax.request({
		url: '<?php echo $this->Html->url(array('controller' => 'itemCategories', 'action' => 'edit')); ?>/'+id+'/<?php echo $parent_id; ?>',
		success: function(response, opts) {
			var parent_itemCategory_data = response.responseText;
			
			eval(parent_itemCategory_data);
			
			ItemCategoryEditWindow.show();
		},
		failure: function(response, opts) {
			Ext.Msg.alert('<?php __('Error'); ?>', '<?php __('Cannot get the itemCategory edit form. Error code'); ?>: ' + response.status);
		}
	});
}

function ViewItemCategory(id) {
	Ext.Ajax.request({
		url: '<?php echo $this->Html->url(array('controller' => 'itemCategories', 'action' => 'view')); ?>/'+id,
		success: function(response, opts) {
			var itemCategory_data = response.responseText;

			eval(itemCategory_data);

			ItemCategoryViewWindow.show();
		},
		failure: function(response, opts) {
			Ext.Msg.alert('<?php __('Error'); ?>', '<?php __('Cannot get the itemCategory view form. Error code'); ?>: ' + response.status);
		}
	});
}

function ViewItemCategoryItemCategories(id) {
	Ext.Ajax.request({
		url: '<?php echo $this->Html->url(array('controller' => 'childItemCategories', 'action' => 'index2')); ?>/'+id,
		success: function(response, opts) {
			var parent_childItemCategories_data = response.responseText;

			eval(parent_childItemCategories_data);

			parentItemCategoriesViewWindow.show();
		},
		failure: function(response, opts) {
			Ext.Msg.alert('<?php __('Error'); ?>', '<?php __('Cannot get the campus view form. Error code'); ?>: ' + response.status);
		}
	});
}

function ViewItemCategoryItems(id) {
	Ext.Ajax.request({
		url: '<?php echo $this->Html->url(array('controller' => 'items', 'action' => 'index2')); ?>/'+id,
		success: function(response, opts) {
			var parent_items_data = response.responseText;

			eval(parent_items_data);

			parentItemsViewWindow.show();
		},
		failure: function(response, opts) {
			Ext.Msg.alert('<?php __('Error'); ?>', '<?php __('Cannot get the campus view form. Error code'); ?>: ' + response.status);
		}
	});
}


function DeleteParentItemCategory(id) {
	Ext.Ajax.request({
		url: '<?php echo $this->Html->url(array('controller' => 'itemCategories', 'action' => 'delete')); ?>/'+id,
		success: function(response, opts) {
			Ext.Msg.alert('<?php __('Success'); ?>', '<?php __('ItemCategory(s) successfully deleted!'); ?>');
			RefreshParentItemCategoryData();
		},
		failure: function(response, opts) {
			Ext.Msg.alert('<?php __('Error'); ?>', '<?php __('Cannot get the itemCategory to be deleted. Error code'); ?>: ' + response.status);
		}
	});
}

function SearchByParentItemCategoryName(value){
	var conditions = '\'ItemCategory.name LIKE\' => \'%' + value + '%\'';
	store_parent_itemCategories.reload({
		 params: {
			start: 0,
			limit: list_size,
			conditions: conditions
	    }
	});
}

function RefreshParentItemCategoryData() {
	store_parent_itemCategories.reload();
}



var g = new Ext.grid.GridPanel({
	title: '<?php __('ItemCategories'); ?>',
	store: store_parent_itemCategories,
	loadMask: true,
	stripeRows: true,
	height: 300,
	anchor: '100%',
    id: 'itemCategoryGrid',
	columns: [
		{header: "<?php __('Name'); ?>", dataIndex: 'name', sortable: true},
		{header:"<?php __('parent_item_category'); ?>", dataIndex: 'parent_item_category', sortable: true},
		{header: "<?php __('Lft'); ?>", dataIndex: 'lft', sortable: true},
		{header: "<?php __('Rght'); ?>", dataIndex: 'rght', sortable: true},
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
            ViewItemCategory(Ext.getCmp('itemCategoryGrid').getSelectionModel().getSelected().data.id);
        }
    },
	tbar: new Ext.Toolbar({
		items: [{
				xtype: 'tbbutton',
				text: '<?php __('Add'); ?>',
				tooltip:'<?php __('<b>Add ItemCategory</b><br />Click here to create a new ItemCategory'); ?>',
				icon: 'img/table_add.png',
				cls: 'x-btn-text-icon',
				handler: function(btn) {
					AddParentItemCategory();
				}
			}, ' ', '-', ' ', {
				xtype: 'tbbutton',
				text: '<?php __('Edit'); ?>',
				id: 'edit-parent-itemCategory',
				tooltip:'<?php __('<b>Edit ItemCategory</b><br />Click here to modify the selected ItemCategory'); ?>',
				icon: 'img/table_edit.png',
				cls: 'x-btn-text-icon',
				disabled: true,
				handler: function(btn) {
					var sm = g.getSelectionModel();
					var sel = sm.getSelected();
					if (sm.hasSelection()){
						EditParentItemCategory(sel.data.id);
					};
				}
			}, ' ', '-', ' ', {
				xtype: 'tbbutton',
				text: '<?php __('Delete'); ?>',
				id: 'delete-parent-itemCategory',
				tooltip:'<?php __('<b>Delete ItemCategory(s)</b><br />Click here to remove the selected ItemCategory(s)'); ?>',
				icon: 'img/table_delete.png',
				cls: 'x-btn-text-icon',
				disabled: true,
				handler: function(btn) {
					var sm = g.getSelectionModel();
					var sel = sm.getSelections();
					if (sm.hasSelection()){
						if(sel.length==1){
							Ext.Msg.show({
									title: '<?php __('Remove ItemCategory'); ?>',
									buttons: Ext.MessageBox.YESNOCANCEL,
									msg: '<?php __('Remove'); ?> '+sel[0].data.name+'?',
									icon: Ext.MessageBox.QUESTION,
                                    fn: function(btn){
											if (btn == 'yes'){
													DeleteParentItemCategory(sel[0].data.id);
											}
									}
							});
						} else {
							Ext.Msg.show({
									title: '<?php __('Remove ItemCategory'); ?>',
									buttons: Ext.MessageBox.YESNOCANCEL,
									msg: '<?php __('Remove the selected ItemCategory'); ?>?',
									icon: Ext.MessageBox.QUESTION,
                                    fn: function(btn){
											if (btn == 'yes'){
													var sel_ids = '';
													for(i=0;i<sel.length;i++){
														if(i>0)
															sel_ids += '_';
														sel_ids += sel[i].data.id;
													}
													DeleteParentItemCategory(sel_ids);
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
				text: '<?php __('View ItemCategory'); ?>',
				id: 'view-itemCategory2',
				tooltip:'<?php __('<b>View ItemCategory</b><br />Click here to see details of the selected ItemCategory'); ?>',
				icon: 'img/table_view.png',
				cls: 'x-btn-text-icon',
				disabled: true,
				handler: function(btn) {
					var sm = g.getSelectionModel();
					var sel = sm.getSelected();
					if (sm.hasSelection()){
						ViewItemCategory(sel.data.id);
					};
				},
				menu : {
					items: [
 {
						text: '<?php __('View Item Categories'); ?>',
                        icon: 'img/table_view.png',
						cls: 'x-btn-text-icon',
						handler: function(btn) {
							var sm = g.getSelectionModel();
							var sel = sm.getSelected();
							if (sm.hasSelection()){
								ViewItemCategoryItemCategories(sel.data.id);
							};
						}
					}
, {
						text: '<?php __('View Items'); ?>',
                        icon: 'img/table_view.png',
						cls: 'x-btn-text-icon',
						handler: function(btn) {
							var sm = g.getSelectionModel();
							var sel = sm.getSelected();
							if (sm.hasSelection()){
								ViewItemCategoryItems(sel.data.id);
							};
						}
					}
					]
				}

            }, ' ', '->', {
				xtype: 'textfield',
				emptyText: '<?php __('[Search By Name]'); ?>',
				id: 'parent_itemCategory_search_field',
				listeners: {
					specialkey: function(field, e){
						if (e.getKey() == e.ENTER) {
							SearchByParentItemCategoryName(Ext.getCmp('parent_itemCategory_search_field').getValue());
						}
					}

				}
			}, {
				xtype: 'tbbutton',
				icon: 'img/search.png',
				cls: 'x-btn-text-icon',
				text: 'GO',
				tooltip:'<?php __('<b>GO</b><br />Click here to get search results'); ?>',
				id: 'parent_itemCategory_go_button',
				handler: function(){
					SearchByParentItemCategoryName(Ext.getCmp('parent_itemCategory_search_field').getValue());
				}
			}, ' '
	]}),
	bbar: new Ext.PagingToolbar({
		pageSize: list_size,
		store: store_parent_itemCategories,
		displayInfo: true,
		displayMsg: '<?php __('Displaying {0} - {1} of {2}'); ?>',
		beforePageText: '<?php __('Page'); ?>',
		afterPageText: '<?php __('of {0}'); ?>',
		emptyMsg: '<?php __('No data to display'); ?>'
	})
});
g.getSelectionModel().on('rowselect', function(sm, rowIdx, r) {
	g.getTopToolbar().findById('edit-parent-itemCategory').enable();
	g.getTopToolbar().findById('delete-parent-itemCategory').enable();
        g.getTopToolbar().findById('view-itemCategory2').enable();
	if(this.getSelections().length > 1){
		g.getTopToolbar().findById('edit-parent-itemCategory').disable();
                g.getTopToolbar().findById('view-itemCategory2').disable();
	}
});
g.getSelectionModel().on('rowdeselect', function(sm, rowIdx, r) {
	if(this.getSelections().length > 1){
		g.getTopToolbar().findById('edit-parent-itemCategory').disable();
		g.getTopToolbar().findById('delete-parent-itemCategory').enable();
                g.getTopToolbar().findById('view-itemCategory2').disable();
	}
	else if(this.getSelections().length == 1){
		g.getTopToolbar().findById('edit-parent-itemCategory').enable();
		g.getTopToolbar().findById('delete-parent-itemCategory').enable();
                g.getTopToolbar().findById('view-itemCategory2').enable();
	}
	else{
		g.getTopToolbar().findById('edit-parent-itemCategory').disable();
		g.getTopToolbar().findById('delete-parent-itemCategory').disable();
                g.getTopToolbar().findById('view-itemCategory2').disable();
	}
});



var parentItemCategoriesViewWindow = new Ext.Window({
	title: 'ItemCategory Under the selected Item',
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
			parentItemCategoriesViewWindow.close();
		}
	}]
});

store_parent_itemCategories.load({
    params: {
        start: 0,    
        limit: list_size
    }
});