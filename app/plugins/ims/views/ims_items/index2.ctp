//<script>
    var store_parent_items = new Ext.data.Store({
	reader: new Ext.data.JsonReader({
            root:'rows',
            totalProperty: 'results',
            fields: [
                'id','name','description','item_category','created','modified'	
            ]
	}),
	proxy: new Ext.data.HttpProxy({
            url: '<?php echo $this->Html->url(array('controller' => 'ims_items', 'action' => 'list_data', $parent_id)); ?>'	
        })
    });

    function AddParentItem() {
	Ext.Ajax.request({
            url: '<?php echo $this->Html->url(array('controller' => 'ims_items', 'action' => 'add', $parent_id)); ?>',
            success: function(response, opts) {
                var parent_item_data = response.responseText;
			
                eval(parent_item_data);
			
                ItemAddWindow.show();
            },
            failure: function(response, opts) {
                Ext.Msg.alert('<?php __('Error'); ?>', '<?php __('Cannot get the item add form. Error code'); ?>: ' + response.status);
            }
	});
    }

    function EditParentItem(id) {
	Ext.Ajax.request({
            url: '<?php echo $this->Html->url(array('controller' => 'ims_items', 'action' => 'edit')); ?>/'+id+'/<?php echo $parent_id; ?>',
            success: function(response, opts) {
                var parent_item_data = response.responseText;
			
                eval(parent_item_data);
			
                ItemEditWindow.show();
            },
            failure: function(response, opts) {
                Ext.Msg.alert('<?php __('Error'); ?>', '<?php __('Cannot get the item edit form. Error code'); ?>: ' + response.status);
            }
	});
    }

    function ViewItem(id) {
	Ext.Ajax.request({
            url: '<?php echo $this->Html->url(array('controller' => 'ims_items', 'action' => 'view')); ?>/'+id,
            success: function(response, opts) {
                var item_data = response.responseText;

                eval(item_data);

                ItemViewWindow.show();
            },
            failure: function(response, opts) {
                Ext.Msg.alert('<?php __('Error'); ?>', '<?php __('Cannot get the item view form. Error code'); ?>: ' + response.status);
            }
	});
    }

    function ViewItemGrns(id) {
	Ext.Ajax.request({
            url: '<?php echo $this->Html->url(array('controller' => 'ims_grns', 'action' => 'index2')); ?>/'+id,
            success: function(response, opts) {
                var parent_grns_data = response.responseText;

                eval(parent_grns_data);

                parentGrnsViewWindow.show();
            },
            failure: function(response, opts) {
                Ext.Msg.alert('<?php __('Error'); ?>', '<?php __('Cannot get the campus view form. Error code'); ?>: ' + response.status);
            }
	});
    }

    function ViewItemPurchaseOrders(id) {
	Ext.Ajax.request({
            url: '<?php echo $this->Html->url(array('controller' => 'purchaseOrders', 'action' => 'index2')); ?>/'+id,
            success: function(response, opts) {
                var parent_purchaseOrders_data = response.responseText;

                eval(parent_purchaseOrders_data);

                parentPurchaseOrdersViewWindow.show();
            },
            failure: function(response, opts) {
                Ext.Msg.alert('<?php __('Error'); ?>', '<?php __('Cannot get the campus view form. Error code'); ?>: ' + response.status);
            }
	});
    }


    function DeleteParentItem(id) {
	Ext.Ajax.request({
            url: '<?php echo $this->Html->url(array('controller' => 'ims_items', 'action' => 'delete')); ?>/'+id,
            success: function(response, opts) {
                Ext.Msg.alert('<?php __('Success'); ?>', '<?php __('Item(s) successfully deleted!'); ?>');
                RefreshParentItemData();
            },
            failure: function(response, opts) {
                Ext.Msg.alert('<?php __('Error'); ?>', '<?php __('Cannot get the item to be deleted. Error code'); ?>: ' + response.status);
            }
	});
    }

    function SearchByParentItemName(value){
	var conditions = '\'ImsItem.name LIKE\' => \'%' + value + '%\'';
	store_parent_items.reload({
            params: {
                start: 0,
                limit: list_size,
                conditions: conditions
	    }
	});
    }

    function RefreshParentItemData() {
	store_parent_items.reload();
    }



    var g = new Ext.grid.GridPanel({
	title: '<?php __('Items'); ?>',
	store: store_parent_items,
	loadMask: true,
	stripeRows: true,
	height: 300,
	anchor: '100%',
        id: 'itemGrid',
	columns: [
            {header: "<?php __('Name'); ?>", dataIndex: 'name', sortable: true},
            {header: "<?php __('Description'); ?>", dataIndex: 'description', sortable: true},
            {header: "<?php __('Category'); ?>", dataIndex: 'item_category', sortable: true},
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
                ViewItem(Ext.getCmp('itemGrid').getSelectionModel().getSelected().data.id);
            }
        },
	tbar: new Ext.Toolbar({
            items: [{
                    xtype: 'tbbutton',
                    text: '<?php __('Add'); ?>',
                    tooltip:'<?php __('<b>Add Item</b><br />Click here to create a new Item'); ?>',
                    icon: 'img/table_add.png',
                    cls: 'x-btn-text-icon',
                    handler: function(btn) {
                        AddParentItem();
                    }
                }, ' ', '-', ' ', {
                    xtype: 'tbbutton',
                    text: '<?php __('Edit'); ?>',
                    id: 'edit-parent-item',
                    tooltip:'<?php __('<b>Edit Item</b><br />Click here to modify the selected Item'); ?>',
                    icon: 'img/table_edit.png',
                    cls: 'x-btn-text-icon',
                    disabled: true,
                    handler: function(btn) {
                        var sm = g.getSelectionModel();
                        var sel = sm.getSelected();
                        if (sm.hasSelection()){
                            EditParentItem(sel.data.id);
                        };
                    }
                }, ' ', '-', ' ', {
                    xtype: 'tbbutton',
                    text: '<?php __('Delete'); ?>',
                    id: 'delete-parent-item',
                    tooltip:'<?php __('<b>Delete Item(s)</b><br />Click here to remove the selected Item(s)'); ?>',
                    icon: 'img/table_delete.png',
                    cls: 'x-btn-text-icon',
                    disabled: true,
                    handler: function(btn) {
                        var sm = g.getSelectionModel();
                        var sel = sm.getSelections();
                        if (sm.hasSelection()){
                            if(sel.length==1){
                                Ext.Msg.show({
                                    title: '<?php __('Remove Item'); ?>',
                                    buttons: Ext.MessageBox.YESNOCANCEL,
                                    msg: '<?php __('Remove'); ?> '+sel[0].data.name+'?',
                                    icon: Ext.MessageBox.QUESTION,
                                    fn: function(btn){
                                        if (btn == 'yes'){
                                            DeleteParentItem(sel[0].data.id);
                                        }
                                    }
                                });
                            } else {
                                Ext.Msg.show({
                                    title: '<?php __('Remove Item'); ?>',
                                    buttons: Ext.MessageBox.YESNOCANCEL,
                                    msg: '<?php __('Remove the selected Item'); ?>?',
                                    icon: Ext.MessageBox.QUESTION,
                                    fn: function(btn){
                                        if (btn == 'yes'){
                                            var sel_ids = '';
                                            for(i=0;i<sel.length;i++){
                                                if(i>0)
                                                    sel_ids += '_';
                                                sel_ids += sel[i].data.id;
                                            }
                                            DeleteParentItem(sel_ids);
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
                    text: '<?php __('View Item'); ?>',
                    id: 'view-item2',
                    tooltip:'<?php __('<b>View Item</b><br />Click here to see details of the selected Item'); ?>',
                    icon: 'img/table_view.png',
                    cls: 'x-btn-text-icon',
                    disabled: true,
                    handler: function(btn) {
                        var sm = g.getSelectionModel();
                        var sel = sm.getSelected();
                        if (sm.hasSelection()){
                            ViewItem(sel.data.id);
                        };
                    },
                    menu : {
                        items: [
                            {
                                text: '<?php __('View Grns'); ?>',
                                icon: 'img/table_view.png',
                                cls: 'x-btn-text-icon',
                                handler: function(btn) {
                                    var sm = g.getSelectionModel();
                                    var sel = sm.getSelected();
                                    if (sm.hasSelection()){
                                        ViewItemGrns(sel.data.id);
                                    };
                                }
                            }
                            , {
                                text: '<?php __('View Purchase Orders'); ?>',
                                icon: 'img/table_view.png',
                                cls: 'x-btn-text-icon',
                                handler: function(btn) {
                                    var sm = g.getSelectionModel();
                                    var sel = sm.getSelected();
                                    if (sm.hasSelection()){
                                        ViewItemPurchaseOrders(sel.data.id);
                                    };
                                }
                            }
                        ]
                    }

                }, ' ', '->', {
                    xtype: 'textfield',
                    emptyText: '<?php __('[Search By Name]'); ?>',
                    id: 'parent_item_search_field',
                    listeners: {
                        specialkey: function(field, e){
                            if (e.getKey() == e.ENTER) {
                                SearchByParentItemName(Ext.getCmp('parent_item_search_field').getValue());
                            }
                        }

                    }
                }, {
                    xtype: 'tbbutton',
                    icon: 'img/search.png',
                    cls: 'x-btn-text-icon',
                    text: 'GO',
                    tooltip:'<?php __('<b>GO</b><br />Click here to get search results'); ?>',
                    id: 'parent_item_go_button',
                    handler: function(){
                        SearchByParentItemName(Ext.getCmp('parent_item_search_field').getValue());
                    }
                }, ' '
            ]
        }),
	bbar: new Ext.PagingToolbar({
            pageSize: list_size,
            store: store_parent_items,
            displayInfo: true,
            displayMsg: '<?php __('Displaying {0} - {1} of {2}'); ?>',
            beforePageText: '<?php __('Page'); ?>',
            afterPageText: '<?php __('of {0}'); ?>',
            emptyMsg: '<?php __('No data to display'); ?>'
	})
    });
    g.getSelectionModel().on('rowselect', function(sm, rowIdx, r) {
	g.getTopToolbar().findById('edit-parent-item').enable();
	g.getTopToolbar().findById('delete-parent-item').enable();
        g.getTopToolbar().findById('view-item2').enable();
	if(this.getSelections().length > 1){
            g.getTopToolbar().findById('edit-parent-item').disable();
            g.getTopToolbar().findById('view-item2').disable();
	}
    });
    g.getSelectionModel().on('rowdeselect', function(sm, rowIdx, r) {
	if(this.getSelections().length > 1){
            g.getTopToolbar().findById('edit-parent-item').disable();
            g.getTopToolbar().findById('delete-parent-item').enable();
            g.getTopToolbar().findById('view-item2').disable();
	}
	else if(this.getSelections().length == 1){
            g.getTopToolbar().findById('edit-parent-item').enable();
            g.getTopToolbar().findById('delete-parent-item').enable();
            g.getTopToolbar().findById('view-item2').enable();
	}
	else{
            g.getTopToolbar().findById('edit-parent-item').disable();
            g.getTopToolbar().findById('delete-parent-item').disable();
            g.getTopToolbar().findById('view-item2').disable();
	}
    });



    var parentItemsViewWindow = new Ext.Window({
	title: 'Item Under the selected Item',
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
                parentItemsViewWindow.close();
            }
        }]
    });

    store_parent_items.load({
        params: {
            start: 0,    
            limit: list_size
        }
    });