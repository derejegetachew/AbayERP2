//<script>
    var store_purchaseOrderItems = new Ext.data.GroupingStore({
	reader: new Ext.data.JsonReader({
            root:'rows',
            totalProperty: 'results',
            fields: [
                'id','purchase_order','item','measurement','ordered_quantity','purchased_quantity','unit_price','remark','created','modified'		]
	}),
	proxy: new Ext.data.HttpProxy({
            url: '<?php echo $this->Html->url(array('controller' => 'ims_purchase_order_items', 'action' => 'list_data')); ?>'
	}),	
        sortInfo:{field: 'ims_purchase_order_id', direction: "ASC"},
	groupField: 'ims_item_id'
    });


    function AddPurchaseOrderItem() {
	Ext.Ajax.request({
            url: '<?php echo $this->Html->url(array('controller' => 'ims_purchase_order_items', 'action' => 'add')); ?>',
            success: function(response, opts) {
                var purchaseOrderItem_data = response.responseText;
			
                eval(purchaseOrderItem_data);
			
                PurchaseOrderItemAddWindow.show();
            },
            failure: function(response, opts) {
                Ext.Msg.alert('<?php __('Error'); ?>', '<?php __('Cannot get the purchaseOrderItem add form. Error code'); ?>: ' + response.status);
            }
	});
    }

    function EditPurchaseOrderItem(id) {
	Ext.Ajax.request({
            url: '<?php echo $this->Html->url(array('controller' => 'ims_purchase_order_items', 'action' => 'edit')); ?>/'+id,
            success: function(response, opts) {
                var purchaseOrderItem_data = response.responseText;
			
                eval(purchaseOrderItem_data);
			
                PurchaseOrderItemEditWindow.show();
            },
            failure: function(response, opts) {
                Ext.Msg.alert('<?php __('Error'); ?>', '<?php __('Cannot get the purchaseOrderItem edit form. Error code'); ?>: ' + response.status);
            }
	});
    }

    function ViewPurchaseOrderItem(id) {
	
        Ext.Ajax.request({
            url: '<?php echo $this->Html->url(array('controller' => 'ims_purchase_order_items', 'action' => 'view')); ?>/'+id,
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
	
    function ViewParentGrnItems(id) {
        Ext.Ajax.request({
            url: '<?php echo $this->Html->url(array('controller' => 'ims_grn_items', 'action' => 'index2')); ?>/'+id,
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


    function DeletePurchaseOrderItem(id) {
	Ext.Ajax.request({
            url: '<?php echo $this->Html->url(array('controller' => 'ims_purchase_order_items', 'action' => 'delete')); ?>/'+id,
            success: function(response, opts) {
                Ext.Msg.alert('<?php __('Success'); ?>', '<?php __('PurchaseOrderItem successfully deleted!'); ?>');
                RefreshPurchaseOrderItemData();
            },
            failure: function(response, opts) {
                Ext.Msg.alert('<?php __('Error'); ?>', '<?php __('Cannot get the purchaseOrderItem add form. Error code'); ?>: ' + response.status);
            }
	});
    }

    function SearchPurchaseOrderItem(){
	Ext.Ajax.request({
            url: '<?php echo $this->Html->url(array('controller' => 'ims_purchase_order_items', 'action' => 'search')); ?>',
            success: function(response, opts){
                var purchaseOrderItem_data = response.responseText;

                eval(purchaseOrderItem_data);

                purchaseOrderItemSearchWindow.show();
            },
            failure: function(response, opts) {
                Ext.Msg.alert('<?php __('Error'); ?>','<?php __('Cannot get the purchaseOrderItem search form. Error Code'); ?>: ' + response.status);
            }
	});
    }

    function SearchByPurchaseOrderItemName(value){
	var conditions = '\'ImsPurchaseOrderItem.name LIKE\' => \'%' + value + '%\'';
	store_purchaseOrderItems.reload({
            params: {
                start: 0,
                limit: list_size,
                conditions: conditions
	    }
	});
    }

    function RefreshPurchaseOrderItemData() {
	store_purchaseOrderItems.reload();
    }


    if(center_panel.find('id', 'purchaseOrderItem-tab') != "") {
	var p = center_panel.findById('purchaseOrderItem-tab');
	center_panel.setActiveTab(p);
    } else {
	var p = center_panel.add({
            title: '<?php __('Purchase Order Items'); ?>',
            closable: true,
            loadMask: true,
            stripeRows: true,
            id: 'purchaseOrderItem-tab',
            xtype: 'grid',
            store: store_purchaseOrderItems,
            columns: [
                {header: "<?php __('PurchaseOrder'); ?>", dataIndex: 'purchase_order', sortable: true},
                {header: "<?php __('Item'); ?>", dataIndex: 'item', sortable: true},
                {header: "<?php __('Measurement'); ?>", dataIndex: 'measurement', sortable: true},
                {header: "<?php __('Ordered Quantity'); ?>", dataIndex: 'ordered_quantity', sortable: true},
                {header: "<?php __('Purchased Quantity'); ?>", dataIndex: 'purchased_quantity', sortable: true},
                {header: "<?php __('Unit Price'); ?>", dataIndex: 'unit_price', sortable: true},
				{header: "<?php __('Remark'); ?>", dataIndex: 'remark', sortable: true},
                {header: "<?php __('Created'); ?>", dataIndex: 'created', sortable: true},
                {header: "<?php __('Modified'); ?>", dataIndex: 'modified', sortable: true}                              
            ],
		
            view: new Ext.grid.GroupingView({
                forceFit:true,
                groupTextTpl: '{text} ({[values.rs.length]} {[values.rs.length > 1 ? "PurchaseOrderItems" : "PurchaseOrderItem"]})'
            }),
            listeners: {
                celldblclick: function(){
                    ViewPurchaseOrderItem(Ext.getCmp('purchaseOrderItem-tab').getSelectionModel().getSelected().data.id);
                }
            },
            sm: new Ext.grid.RowSelectionModel({
                singleSelect: false
            }),
            tbar: new Ext.Toolbar({	
                items: [{
                        xtype: 'tbbutton',
                        text: '<?php __('Add'); ?>',
                        tooltip:'<?php __('<b>Add PurchaseOrderItems</b><br />Click here to create a new PurchaseOrderItem'); ?>',
                        icon: 'img/table_add.png',
                        cls: 'x-btn-text-icon',
                        handler: function(btn) {
                            AddPurchaseOrderItem();
                        }
                    }, ' ', '-', ' ', {
                        xtype: 'tbbutton',
                        text: '<?php __('Edit'); ?>',
                        id: 'edit-purchaseOrderItem',
                        tooltip:'<?php __('<b>Edit PurchaseOrderItems</b><br />Click here to modify the selected PurchaseOrderItem'); ?>',
                        icon: 'img/table_edit.png',
                        cls: 'x-btn-text-icon',
                        disabled: true,
                        handler: function(btn) {
                            var sm = p.getSelectionModel();
                            var sel = sm.getSelected();
                            if (sm.hasSelection()){
                                EditPurchaseOrderItem(sel.data.id);
                            };
                        }
                    }, ' ', '-', ' ', {
                        xtype: 'tbbutton',
                        text: '<?php __('Delete'); ?>',
                        id: 'delete-purchaseOrderItem',
                        tooltip:'<?php __('<b>Delete PurchaseOrderItems(s)</b><br />Click here to remove the selected PurchaseOrderItem(s)'); ?>',
                        icon: 'img/table_delete.png',
                        cls: 'x-btn-text-icon',
                        disabled: true,
                        handler: function(btn) {
                            var sm = p.getSelectionModel();
                            var sel = sm.getSelections();
                            if (sm.hasSelection()){
                                if(sel.length==1){
                                    Ext.Msg.show({
                                        title: '<?php __('Remove PurchaseOrderItem'); ?>',
                                        buttons: Ext.MessageBox.YESNO,
                                        msg: '<?php __('Remove'); ?> '+sel[0].data.name+'?',
                                        icon: Ext.MessageBox.QUESTION,
                                        fn: function(btn){
                                            if (btn == 'yes'){
                                                DeletePurchaseOrderItem(sel[0].data.id);
                                            }
                                        }
                                    });
                                }else{
                                    Ext.Msg.show({
                                        title: '<?php __('Remove PurchaseOrderItem'); ?>',
                                        buttons: Ext.MessageBox.YESNO,
                                        msg: '<?php __('Remove the selected PurchaseOrderItems'); ?>?',
                                        icon: Ext.MessageBox.QUESTION,
                                        fn: function(btn){
                                            if (btn == 'yes'){
                                                var sel_ids = '';
                                                for(i=0;i<sel.length;i++){
                                                    if(i>0)
                                                        sel_ids += '_';
                                                    sel_ids += sel[i].data.id;
                                                }
                                                DeletePurchaseOrderItem(sel_ids);
                                            }
                                        }
                                    });
                                }
                            } else {
                                Ext.Msg.alert('<?php __('Warning'); ?>', '<?php __('Please select a record first'); ?>');
                            };
                        }
                    }, ' ', '-', ' ', {
                        xtype: 'tbsplit',
                        text: '<?php __('View PurchaseOrderItem'); ?>',
                        id: 'view-purchaseOrderItem',
                        tooltip:'<?php __('<b>View PurchaseOrderItem</b><br />Click here to see details of the selected PurchaseOrderItem'); ?>',
                        icon: 'img/table_view.png',
                        cls: 'x-btn-text-icon',
                        disabled: true,
                        handler: function(btn) {
                            var sm = p.getSelectionModel();
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
                                        var sm = p.getSelectionModel();
                                        var sel = sm.getSelected();
                                        if (sm.hasSelection()){
                                            ViewParentGrnItems(sel.data.id);
                                        };
                                    }
                                }
                            ]
                        }
                    }, ' ', '-',  '<?php __('PurchaseOrder'); ?>: ', {
                        xtype : 'combo',
                        emptyText: 'All',
                        store : new Ext.data.ArrayStore({
                            fields : ['id', 'name'],
                            data : [
                                ['-1', 'All'],
                                <?php $st = false;
                                    foreach ($purchaseorders as $item) {
                                        if ($st) echo ",
							"; ?>['<?php echo $item['ImsPurchaseOrder']['id']; ?>' ,'<?php echo $item['ImsPurchaseOrder']['name']; ?>']<?php $st = true;
                                    } ?>
                            ]
                        }),
                        displayField : 'name',
                        valueField : 'id',
                        mode : 'local',
                        value : '-1',
                        disableKeyFilter : true,
                        triggerAction: 'all',
                        listeners : {
                            select : function(combo, record, index){
                                store_purchaseOrderItems.reload({
                                    params: {
                                        start: 0,
                                        limit: list_size,
                                        purchaseorder_id : combo.getValue()
                                    }
                                });
                            }
                        }
                    },
                    '->', {
                        xtype: 'textfield',
                        emptyText: '<?php __('[Search By Name]'); ?>',
                        id: 'purchaseOrderItem_search_field',
                        listeners: {
                            specialkey: function(field, e){
                                if (e.getKey() == e.ENTER) {
                                    SearchByPurchaseOrderItemName(Ext.getCmp('purchaseOrderItem_search_field').getValue());
                                }
                            }
                        }
                    }, {
                        xtype: 'tbbutton',
                        icon: 'img/search.png',
                        cls: 'x-btn-text-icon',
                        text: '<?php __('GO'); ?>',
                        tooltip:'<?php __('<b>GO</b><br />Click here to get search results'); ?>',
                        id: 'purchaseOrderItem_go_button',
                        handler: function(){
                            SearchByPurchaseOrderItemName(Ext.getCmp('purchaseOrderItem_search_field').getValue());
                        }
                    }, '-', {
                        xtype: 'tbbutton',
                        icon: 'img/table_search.png',
                        cls: 'x-btn-text-icon',
                        text: '<?php __('Advanced Search'); ?>',
                        tooltip:'<?php __('<b>Advanced Search...</b><br />Click here to get the advanced search form'); ?>',
                        handler: function(){
                            SearchPurchaseOrderItem();
                        }
                    }
                ]}),
                bbar: new Ext.PagingToolbar({
                    pageSize: list_size,
                    store: store_purchaseOrderItems,
                    displayInfo: true,
                    displayMsg: '<?php __('Displaying {0} - {1} of {2}'); ?>',
                    beforePageText: '<?php __('Page'); ?>',
                    afterPageText: '<?php __('of {0}'); ?>',
                    emptyMsg: '<?php __('No data to display'); ?>'
                })
            }
        );
        p.getSelectionModel().on('rowselect', function(sm, rowIdx, r) {
            p.getTopToolbar().findById('edit-purchaseOrderItem').enable();
            p.getTopToolbar().findById('delete-purchaseOrderItem').enable();
            p.getTopToolbar().findById('view-purchaseOrderItem').enable();
            if(this.getSelections().length > 1){
                p.getTopToolbar().findById('edit-purchaseOrderItem').disable();
                p.getTopToolbar().findById('view-purchaseOrderItem').disable();
            }
        });
        p.getSelectionModel().on('rowdeselect', function(sm, rowIdx, r) {
            if(this.getSelections().length > 1){
                p.getTopToolbar().findById('edit-purchaseOrderItem').disable();
                p.getTopToolbar().findById('view-purchaseOrderItem').disable();
                p.getTopToolbar().findById('delete-purchaseOrderItem').enable();
            }
            else if(this.getSelections().length == 1){
                p.getTopToolbar().findById('edit-purchaseOrderItem').enable();
                p.getTopToolbar().findById('view-purchaseOrderItem').enable();
                p.getTopToolbar().findById('delete-purchaseOrderItem').enable();
            }
            else{
                p.getTopToolbar().findById('edit-purchaseOrderItem').disable();
                p.getTopToolbar().findById('view-purchaseOrderItem').disable();
                p.getTopToolbar().findById('delete-purchaseOrderItem').disable();
            }
        });
        center_panel.setActiveTab(p);

        store_purchaseOrderItems.load({
            params: {
                start: 0,          
                limit: list_size
            }
        });

    }
