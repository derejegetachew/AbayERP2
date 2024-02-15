//<script>
    var store_parent_purchaseOrderItems = new Ext.data.Store({
	reader: new Ext.data.JsonReader({
            root:'rows',
            totalProperty: 'results',
            fields: [
                'id','purchase_order','item','measurement','ordered_quantity','purchased_quantity','unit_price','created','modified'	
            ]
	}),
	proxy: new Ext.data.HttpProxy({
            url: '<?php echo $this->Html->url(array('controller' => 'purchaseOrderItems', 'action' => 'list_data', $parent_id)); ?>'	})
    });


    function AddParentPurchaseOrderItem() {
	Ext.Ajax.request({
            url: '<?php echo $this->Html->url(array('controller' => 'purchaseOrderItems', 'action' => 'add', $parent_id)); ?>',
            success: function(response, opts) {
                var parent_purchaseOrderItem_data = response.responseText;
			
                eval(parent_purchaseOrderItem_data);
		
                PurchaseOrderItemAddWindow.show();
            },
            failure: function(response, opts) {
                Ext.Msg.alert('<?php __('Error'); ?>', '<?php __('Cannot get the purchaseOrderItem add form. Error code'); ?>: ' + response.status);
            }
	});
    }

    function EditParentPurchaseOrderItem(id) {
	Ext.Ajax.request({
            url: '<?php echo $this->Html->url(array('controller' => 'purchaseOrderItems', 'action' => 'edit')); ?>/'+id+'/<?php echo $parent_id; ?>',
            success: function(response, opts) {
                var parent_purchaseOrderItem_data = response.responseText;
			
                eval(parent_purchaseOrderItem_data);
			
                PurchaseOrderItemEditWindow.show();
            },
            failure: function(response, opts) {
                Ext.Msg.alert('<?php __('Error'); ?>', '<?php __('Cannot get the purchaseOrderItem edit form. Error code'); ?>: ' + response.status);
            }
	});
    }

    function ViewPurchaseOrderItem(id) {
	Ext.Ajax.request({
            url: '<?php echo $this->Html->url(array('controller' => 'purchaseOrderItems', 'action' => 'view')); ?>/'+id,
            success: function(response, opts) {
                var purchaseOrderItem_data = response.responseText;

                eval(purchaseOrderItem_data);

                PurchaseOrderItemViewWindow.show();
            },
            failure: function(response, opts) {
                Ext.Msg.alert('<?php __('Error'); ?>', '<?php __('Cannot get the purchaseOrderItem view form. Error code'); ?>: ' + response.status);
            }
	});
    }

    function ViewPurchaseOrderItemGrnItems(id) {
	Ext.Ajax.request({
            url: '<?php echo $this->Html->url(array('controller' => 'grnItems', 'action' => 'index2')); ?>/'+id,
            success: function(response, opts) {
                var parent_grnItems_data = response.responseText;

                eval(parent_grnItems_data);

                parentGrnItemsViewWindow.show();
            },
            failure: function(response, opts) {
                Ext.Msg.alert('<?php __('Error'); ?>', '<?php __('Cannot get the campus view form. Error code'); ?>: ' + response.status);
            }
	});
    }


    function DeleteParentPurchaseOrderItem(id) {
	Ext.Ajax.request({
            url: '<?php echo $this->Html->url(array('controller' => 'purchaseOrderItems', 'action' => 'delete')); ?>/'+id,
            success: function(response, opts) {
                Ext.Msg.alert('<?php __('Success'); ?>', '<?php __('PurchaseOrderItem(s) successfully deleted!'); ?>');
                RefreshParentPurchaseOrderItemData();
            },
            failure: function(response, opts) {
                Ext.Msg.alert('<?php __('Error'); ?>', '<?php __('Cannot get the purchaseOrderItem to be deleted. Error code'); ?>: ' + response.status);
            }
	});
    }

    function SearchByParentPurchaseOrderItemName(value){
	var conditions = '\'PurchaseOrderItem.name LIKE\' => \'%' + value + '%\'';
	store_parent_purchaseOrderItems.reload({
            params: {
                start: 0,
                limit: list_size,
                conditions: conditions
	    }
	});
    }

    function RefreshParentPurchaseOrderItemData() {
	store_parent_purchaseOrderItems.reload();
    }



    var g = new Ext.grid.GridPanel({
	title: '<?php __('Purchase Order Items'); ?>',
	store: store_parent_purchaseOrderItems,
	loadMask: true,
	stripeRows: true,
	height: 300,
	anchor: '100%',
        id: 'purchaseOrderItemGrid',
	columns: [
            {header: "<?php __('Purchase Order'); ?>", dataIndex: 'purchase_order', sortable: true},
            {header: "<?php __('Item'); ?>", dataIndex: 'item', sortable: true},
            {header: "<?php __('Measurement'); ?>", dataIndex: 'measurement', sortable: true},
            {header: "<?php __('Ordered Quantity'); ?>", dataIndex: 'ordered_quantity', sortable: true},
            {header: "<?php __('Purchased Quantity'); ?>", dataIndex: 'purchased_quantity', sortable: true, hidden: true},
            {header: "<?php __('Unit Price'); ?>", dataIndex: 'unit_price', sortable: true},
            {header: "<?php __('Created'); ?>", dataIndex: 'created', sortable: true, hidden: true},
            {header: "<?php __('Modified'); ?>", dataIndex: 'modified', sortable: true, hidden: true}	
        ],
	sm: new Ext.grid.RowSelectionModel({
            singleSelect: false
	}),
	viewConfig: {
            forceFit: true
	},
        listeners: {
            celldblclick: function(){
                ViewPurchaseOrderItem(Ext.getCmp('purchaseOrderItemGrid').getSelectionModel().getSelected().data.id);
            }
        },
	tbar: new Ext.Toolbar({
            items: [{
                    xtype: 'tbbutton',
                    text: '<?php __('Add'); ?>',
                    tooltip:'<?php __('<b>Add PurchaseOrderItem</b><br />Click here to create a new PurchaseOrderItem'); ?>',
                    icon: 'img/table_add.png',
                    cls: 'x-btn-text-icon',
                    handler: function(btn) {
                        AddParentPurchaseOrderItem();
                    }
                }, ' ', '-', ' ', {
                    xtype: 'tbbutton',
                    text: '<?php __('Edit'); ?>',
                    id: 'edit-parent-purchaseOrderItem',
                    tooltip:'<?php __('<b>Edit PurchaseOrderItem</b><br />Click here to modify the selected PurchaseOrderItem'); ?>',
                    icon: 'img/table_edit.png',
                    cls: 'x-btn-text-icon',
                    disabled: true,
                    handler: function(btn) {
                        var sm = g.getSelectionModel();
                        var sel = sm.getSelected();
                        if (sm.hasSelection()){
                            EditParentPurchaseOrderItem(sel.data.id);
                        };
                    }
                }, ' ', '-', ' ', {
                    xtype: 'tbbutton',
                    text: '<?php __('Delete'); ?>',
                    id: 'delete-parent-purchaseOrderItem',
                    tooltip:'<?php __('<b>Delete PurchaseOrderItem(s)</b><br />Click here to remove the selected PurchaseOrderItem(s)'); ?>',
                    icon: 'img/table_delete.png',
                    cls: 'x-btn-text-icon',
                    disabled: true,
                    handler: function(btn) {
                        var sm = g.getSelectionModel();
                        var sel = sm.getSelections();
                        if (sm.hasSelection()){
                            if(sel.length==1){
                                Ext.Msg.show({
                                    title: '<?php __('Remove PurchaseOrderItem'); ?>',
                                    buttons: Ext.MessageBox.YESNOCANCEL,
                                    msg: '<?php __('Remove'); ?> '+sel[0].data.name+'?',
                                    icon: Ext.MessageBox.QUESTION,
                                    fn: function(btn){
                                        if (btn == 'yes'){
                                            DeleteParentPurchaseOrderItem(sel[0].data.id);
                                        }
                                    }
                                });
                            } else {
                                Ext.Msg.show({
                                    title: '<?php __('Remove PurchaseOrderItem'); ?>',
                                    buttons: Ext.MessageBox.YESNOCANCEL,
                                    msg: '<?php __('Remove the selected PurchaseOrderItem'); ?>?',
                                    icon: Ext.MessageBox.QUESTION,
                                    fn: function(btn){
                                        if (btn == 'yes'){
                                            var sel_ids = '';
                                            for(i=0;i<sel.length;i++){
                                                if(i>0)
                                                    sel_ids += '_';
                                                sel_ids += sel[i].data.id;
                                            }
                                            DeleteParentPurchaseOrderItem(sel_ids);
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
                    text: '<?php __('View PurchaseOrderItem'); ?>',
                    id: 'view-purchaseOrderItem2',
                    tooltip:'<?php __('<b>View PurchaseOrderItem</b><br />Click here to see details of the selected PurchaseOrderItem'); ?>',
                    icon: 'img/table_view.png',
                    cls: 'x-btn-text-icon',
                    disabled: true,
                    handler: function(btn) {
                        var sm = g.getSelectionModel();
                        var sel = sm.getSelected();
                        if (sm.hasSelection()){
                            ViewPurchaseOrderItem(sel.data.id);
                        };
                    },
                    menu : {
                        items: [
                            {
                                text: '<?php __('View Grn Items'); ?>',
                                icon: 'img/table_view.png',
                                cls: 'x-btn-text-icon',
                                handler: function(btn) {
                                    var sm = g.getSelectionModel();
                                    var sel = sm.getSelected();
                                    if (sm.hasSelection()){
                                        ViewPurchaseOrderItemGrnItems(sel.data.id);
                                    };
                                }
                            }
                        ]
                    }

                }, ' ', '->', {
                    xtype: 'textfield',
                    emptyText: '<?php __('[Search By Name]'); ?>',
                    id: 'parent_purchaseOrderItem_search_field',
                    listeners: {
                        specialkey: function(field, e){
                            if (e.getKey() == e.ENTER) {
                                SearchByParentPurchaseOrderItemName(Ext.getCmp('parent_purchaseOrderItem_search_field').getValue());
                            }
                        }

                    }
                }, {
                    xtype: 'tbbutton',
                    icon: 'img/search.png',
                    cls: 'x-btn-text-icon',
                    text: 'GO',
                    tooltip:'<?php __('<b>GO</b><br />Click here to get search results'); ?>',
                    id: 'parent_purchaseOrderItem_go_button',
                    handler: function(){
                        SearchByParentPurchaseOrderItemName(Ext.getCmp('parent_purchaseOrderItem_search_field').getValue());
                    }
                }, ' '
            ]}),
	bbar: new Ext.PagingToolbar({
            pageSize: list_size,
            store: store_parent_purchaseOrderItems,
            displayInfo: true,
            displayMsg: '<?php __('Displaying {0} - {1} of {2}'); ?>',
            beforePageText: '<?php __('Page'); ?>',
            afterPageText: '<?php __('of {0}'); ?>',
            emptyMsg: '<?php __('No data to display'); ?>'
	})
    });
    g.getSelectionModel().on('rowselect', function(sm, rowIdx, r) {
	g.getTopToolbar().findById('edit-parent-purchaseOrderItem').enable();
	g.getTopToolbar().findById('delete-parent-purchaseOrderItem').enable();
        g.getTopToolbar().findById('view-purchaseOrderItem2').enable();
	if(this.getSelections().length > 1){
            g.getTopToolbar().findById('edit-parent-purchaseOrderItem').disable();
            g.getTopToolbar().findById('view-purchaseOrderItem2').disable();
	}
    });
    g.getSelectionModel().on('rowdeselect', function(sm, rowIdx, r) {
	if(this.getSelections().length > 1){
            g.getTopToolbar().findById('edit-parent-purchaseOrderItem').disable();
            g.getTopToolbar().findById('delete-parent-purchaseOrderItem').enable();
            g.getTopToolbar().findById('view-purchaseOrderItem2').disable();
	}
	else if(this.getSelections().length == 1){
            g.getTopToolbar().findById('edit-parent-purchaseOrderItem').enable();
            g.getTopToolbar().findById('delete-parent-purchaseOrderItem').enable();
            g.getTopToolbar().findById('view-purchaseOrderItem2').enable();
	}
	else{
            g.getTopToolbar().findById('edit-parent-purchaseOrderItem').disable();
            g.getTopToolbar().findById('delete-parent-purchaseOrderItem').disable();
            g.getTopToolbar().findById('view-purchaseOrderItem2').disable();
	}
    });



    var parentPurchaseOrderItemsViewWindow = new Ext.Window({
	title: 'PurchaseOrderItem Under the selected Item',
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
                    parentPurchaseOrderItemsViewWindow.close();
		}
            }]
    });

    store_parent_purchaseOrderItems.load({
        params: {
            start: 0,    
            limit: list_size
        }
    });