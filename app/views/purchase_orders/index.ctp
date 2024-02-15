//<script>
    var store_purchaseOrders = new Ext.data.GroupingStore({
	reader: new Ext.data.JsonReader({
            root:'rows',
            totalProperty: 'results',
            fields: [
                'id','name','user','posted','approved','rejected','created','modified'		
            ]
	}),
	proxy: new Ext.data.HttpProxy({
            url: '<?php echo $this->Html->url(array('controller' => 'purchase_orders', 'action' => 'list_data')); ?>'
	}),	
        sortInfo:{field: 'name', direction: "ASC"},
	groupField: 'user'
    });

    function AddPurchaseOrder() {
	Ext.Ajax.request({
            url: '<?php echo $this->Html->url(array('controller' => 'purchase_orders', 'action' => 'add')); ?>',
            success: function(response, opts) {
                var purchaseOrder_data = response.responseText;
			
                eval(purchaseOrder_data);
			
                PurchaseOrderAddWindow.show();
            },
            failure: function(response, opts) {
                Ext.Msg.alert('<?php __('Error'); ?>', '<?php __('Cannot get the purchase Order add form. Error code'); ?>: ' + response.status);
            }
	});
    }

    function EditPurchaseOrder(id) {
	Ext.Ajax.request({
            url: '<?php echo $this->Html->url(array('controller' => 'purchase_orders', 'action' => 'edit')); ?>/'+id,
            success: function(response, opts) {
                var purchaseOrder_data = response.responseText;
			
                eval(purchaseOrder_data);
			
                PurchaseOrderEditWindow.show();
            },
            failure: function(response, opts) {
                Ext.Msg.alert('<?php __('Error'); ?>', '<?php __('Cannot get the purchase Order edit form. Error code'); ?>: ' + response.status);
            }
	});
    }
    
    function PostPurchaseOrder(id) {
	Ext.Ajax.request({
            url: '<?php echo $this->Html->url(array('controller' => 'purchase_orders', 'action' => 'post')); ?>/'+id,
            success: function(response, opts) {
                Ext.Msg.alert('<?php __('Success'); ?>', '<?php __('Purchase Order successfully posted for approval!'); ?>');
                RefreshPurchaseOrderData();
            },
            failure: function(response, opts) {
                Ext.Msg.alert('<?php __('Error'); ?>', '<?php __('Please report this error to Administrator. Cannot post the purchase Order. Error code'); ?>: ' + response.status);
            }
	});
    }

    function ViewPurchaseOrder(id) {
        Ext.Ajax.request({
            url: '<?php echo $this->Html->url(array('controller' => 'purchase_orders', 'action' => 'view')); ?>/'+id,
            success: function(response, opts) {
                var purchaseOrder_data = response.responseText;

                eval(purchaseOrder_data);

                PurchaseOrderViewWindow.show();
            },
            failure: function(response, opts) {
                Ext.Msg.alert('<?php __('Error'); ?>', '<?php __('Cannot get the purchase Order view form. Error code'); ?>: ' + response.status);
            }
        });
    }
    
    function ViewParentGrns(id) {
        Ext.Ajax.request({
            url: '<?php echo $this->Html->url(array('controller' => 'grns', 'action' => 'index2')); ?>/'+id,
            success: function(response, opts) {
                var parent_grns_data = response.responseText;

                eval(parent_grns_data);

                parentGrnsViewWindow.show();
            },
            failure: function(response, opts) {
                Ext.Msg.alert('<?php __('Error'); ?>', '<?php __('Cannot get the Goods Receiving Notes view form. Error code'); ?>: ' + response.status);
            }
        });
    }

    function ViewParentPurchaseOrderItems(id) {
        Ext.Ajax.request({
            url: '<?php echo $this->Html->url(array('controller' => 'purchase_order_items', 'action' => 'index2')); ?>/'+id,
            success: function(response, opts) {
                var parent_purchaseOrderItems_data = response.responseText;

                eval(parent_purchaseOrderItems_data);

                parentPurchaseOrderItemsViewWindow.show();
            },
            failure: function(response, opts) {
                Ext.Msg.alert('<?php __('Error'); ?>', '<?php __('Cannot get the Purchase Order Items view form. Error code'); ?>: ' + response.status);
            }
        });
    }

    function DeletePurchaseOrder(id) {
	Ext.Ajax.request({
            url: '<?php echo $this->Html->url(array('controller' => 'purchase_orders', 'action' => 'delete')); ?>/'+id,
            success: function(response, opts) {
                Ext.Msg.alert('<?php __('Success'); ?>', '<?php __('Purchase Order successfully deleted!'); ?>');
                RefreshPurchaseOrderData();
            },
            failure: function(response, opts) {
                Ext.Msg.alert('<?php __('Error'); ?>', '<?php __('Cannot get the purchase Order add form. Error code'); ?>: ' + response.status);
            }
	});
    }

    function SearchPurchaseOrder(){
	Ext.Ajax.request({
            url: '<?php echo $this->Html->url(array('controller' => 'purchase_orders', 'action' => 'search')); ?>',
            success: function(response, opts){
                var purchaseOrder_data = response.responseText;

                eval(purchaseOrder_data);

                purchaseOrderSearchWindow.show();
            },
            failure: function(response, opts) {
                Ext.Msg.alert('<?php __('Error'); ?>','<?php __('Cannot get the purchase Order search form. Error Code'); ?>: ' + response.status);
            }
	});
    }

    function SearchByPurchaseOrderName(value){
	var conditions = '\'PurchaseOrder.name LIKE\' => \'%' + value + '%\'';
	store_purchaseOrders.reload({
            params: {
                start: 0,
                limit: list_size,
                conditions: conditions
	    }
	});
    }

    function RefreshPurchaseOrderData() {
	store_purchaseOrders.reload();
    }

    function showMenu(grid, index, event) {
        event.stopEvent();
        var record = grid.getStore().getAt(index);
        var btnStatus = (record.get('posted') == '<font color=red>True</font>')? true: false;
        var menu = new Ext.menu.Menu({
            items: [
                {
                    text: '<b>Details of ' + record.get('name') + '</b>',
                    icon: 'img/table_view.png',
                    handler: function() {
                        ViewPurchaseOrder(record.get('id'));
                    }
                }, '-', {
                    text: 'Edit Purchase Order',
                    icon: 'img/table_edit.png',
                    handler: function() {
                        EditPurchaseOrder(record.get('id'));
                    },
                    disabled: btnStatus
                }, {
                    text: 'Post Purchase Order',
                    icon: 'img/table_edit.png',
                    handler: function() {
                        PostPurchaseOrder(record.get('id'));
                    },
                    disabled: btnStatus
                }, {
                    text: 'Delete Purchase Order',
                    icon: 'img/table_delete.png',
                    handler: function() {
                        DeletePurchaseOrder(record.get('id'));
                    },
                    disabled: btnStatus
                }, '-', {
                    text: 'Purchase Order Items',
                    icon: 'img/table_view.png',
                    handler: function() {
                        ViewParentPurchaseOrderItems(record.get('id'));
                    },
                    disabled: btnStatus
                }, {
                    text: 'Goods Receiving Notes',
                    icon: 'img/table_view.png',
                    handler: function() {
                        ViewParentGrns(record.get('id'));
                    },
                    disabled: btnStatus
                }
            ]
        }).showAt(event.xy);
    }


    if(center_panel.find('id', 'purchaseOrder-tab') != "") {
	var p = center_panel.findById('purchaseOrder-tab');
	center_panel.setActiveTab(p);
    } else {
	var p = center_panel.add({
            title: '<?php __('Purchase Orders'); ?>',
            closable: true,
            loadMask: true,
            stripeRows: true,
            id: 'purchaseOrder-tab',
            xtype: 'grid',
            store: store_purchaseOrders,
            columns: [
                {header: "<?php __('Name'); ?>", dataIndex: 'name', sortable: true},
                {header: "<?php __('Created By'); ?>", dataIndex: 'user', sortable: true},
                {header: "<?php __('Is Posted?'); ?>", dataIndex: 'posted', sortable: true},
                {header: "<?php __('Is Approved?'); ?>", dataIndex: 'approved', sortable: true},
                {header: "<?php __('Is Rejected?'); ?>", dataIndex: 'rejected', sortable: true},
                {header: "<?php __('Created'); ?>", dataIndex: 'created', sortable: true},
                {header: "<?php __('Modified'); ?>", dataIndex: 'modified', sortable: true}
            ],
            view: new Ext.grid.GroupingView({
                forceFit:true,
                groupTextTpl: '{text} ({[values.rs.length]} {[values.rs.length > 1 ? "Purchase Orders" : "Purchase Order"]})'
            }),
            listeners: {
                celldblclick: function(){
                    ViewPurchaseOrder(Ext.getCmp('purchaseOrder-tab').getSelectionModel().getSelected().data.id);
                },
                'rowcontextmenu': function(grid, index, event) {
                    showMenu(grid, index, event);
                }
            },
            sm: new Ext.grid.RowSelectionModel({
                singleSelect: false
            }),
            tbar: new Ext.Toolbar({
			
                items: [{
                        xtype: 'tbbutton',
                        text: '<?php __('Add'); ?>',
                        tooltip:'<?php __('<b>Add Purchase Orders</b><br />Click here to create a new Purchase Order'); ?>',
                        icon: 'img/table_add.png',
                        cls: 'x-btn-text-icon',
                        handler: function(btn) {
                            AddPurchaseOrder();
                        }
                    }, ' ', '-', ' ', {
                        xtype: 'tbbutton',
                        text: '<?php __('Edit'); ?>',
                        id: 'edit-purchaseOrder',
                        tooltip:'<?php __('<b>Edit Purchase Orders</b><br />Click here to modify the selected Purchase Order'); ?>',
                        icon: 'img/table_edit.png',
                        cls: 'x-btn-text-icon',
                        disabled: true,
                        handler: function(btn) {
                            var sm = p.getSelectionModel();
                            var sel = sm.getSelected();
                            if (sm.hasSelection()){
                                EditPurchaseOrder(sel.data.id);
                            };
                        }
                    }, ' ', '-', ' ', {
                        xtype: 'tbbutton',
                        text: '<?php __('Post'); ?>',
                        id: 'post-purchaseOrder',
                        tooltip:'<?php __('<b>Post Purchase Orders</b><br />Click here to post the selected Purchase Order'); ?>',
                        icon: 'img/table_edit.png',
                        cls: 'x-btn-text-icon',
                        disabled: true,
                        handler: function(btn) {
                            var sm = p.getSelectionModel();
                            var sel = sm.getSelected();
                            if (sm.hasSelection()){
                                Ext.Msg.show({
                                    title: '<?php __('Post Purchase Order for Approval'); ?>',
                                    buttons: Ext.MessageBox.YESNO,
                                    msg: '<?php __('Post'); ?> '+sel.data.name+'?',
                                    icon: Ext.MessageBox.QUESTION,
                                    fn: function(btn){
                                        if (btn == 'yes'){
                                            PostPurchaseOrder(sel.data.id);
                                        }
                                    }
                                });
                            };
                        }
                    }, ' ', '-', ' ', {
                        xtype: 'tbbutton',
                        text: '<?php __('Delete'); ?>',
                        id: 'delete-purchaseOrder',
                        tooltip:'<?php __('<b>Delete Purchase Orders(s)</b><br />Click here to remove the selected Purchase Order(s)'); ?>',
                        icon: 'img/table_delete.png',
                        cls: 'x-btn-text-icon',
                        disabled: true,
                        handler: function(btn) {
                            var sm = p.getSelectionModel();
                            var sel = sm.getSelections();
                            if (sm.hasSelection()){
                                if(sel.length==1){
                                    Ext.Msg.show({
                                        title: '<?php __('Remove Purchase Order'); ?>',
                                        buttons: Ext.MessageBox.YESNO,
                                        msg: '<?php __('Remove'); ?> '+sel[0].data.name+'?',
                                        icon: Ext.MessageBox.QUESTION,
                                        fn: function(btn){
                                            if (btn == 'yes'){
                                                DeletePurchaseOrder(sel[0].data.id);
                                            }
                                        }
                                    });
                                }else{
                                    Ext.Msg.show({
                                        title: '<?php __('Remove Purchase Order'); ?>',
                                        buttons: Ext.MessageBox.YESNO,
                                        msg: '<?php __('Remove the selected Purchase Orders'); ?>?',
                                        icon: Ext.MessageBox.QUESTION,
                                        fn: function(btn){
                                            if (btn == 'yes'){
                                                var sel_ids = '';
                                                for(i=0;i<sel.length;i++){
                                                    if(i>0)
                                                        sel_ids += '_';
                                                    sel_ids += sel[i].data.id;
                                                }
                                                DeletePurchaseOrder(sel_ids);
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
                        text: '<?php __('View Purchase Order'); ?>',
                        id: 'view-purchaseOrder',
                        tooltip:'<?php __('<b>View Purchase Order</b><br />Click here to see details of the selected Purchase Order'); ?>',
                        icon: 'img/table_view.png',
                        cls: 'x-btn-text-icon',
                        disabled: true,
                        handler: function(btn) {
                            var sm = p.getSelectionModel();
                            var sel = sm.getSelected();
                            if (sm.hasSelection()){
                                ViewPurchaseOrder(sel.data.id);
                            };
                        },
                        menu : {
                            items: [
                                {
                                    text: '<?php __('View Grns'); ?>',
                                    icon: 'img/table_view.png',
                                    cls: 'x-btn-text-icon',
                                    handler: function(btn) {
                                        var sm = p.getSelectionModel();
                                        var sel = sm.getSelected();
                                        if (sm.hasSelection()){
                                            ViewParentGrns(sel.data.id);
                                        };
                                    }
                                }
                                ,{
                                    text: '<?php __('View Purchase Order Items'); ?>',
                                    icon: 'img/table_view.png',
                                    cls: 'x-btn-text-icon',
                                    handler: function(btn) {
                                        var sm = p.getSelectionModel();
                                        var sel = sm.getSelected();
                                        if (sm.hasSelection()){
                                            ViewParentPurchaseOrderItems(sel.data.id);
                                        };
                                    }
                                }
                            ]
                        }
                    }, ' ', '-',  '<?php __('Created By'); ?>: ', {
                        xtype : 'combo',
                        emptyText: 'All',
                        store : new Ext.data.ArrayStore({
                            fields : ['id', 'name'],
                            data : [
                                ['-1', 'All'],
    <?php
    $st = false;
    foreach ($users as $item) {
        if ($st)
            echo ",
							";
        ?>['<?php echo $item['User']['id']; ?>' ,'<?php echo $item['User']['username']; ?>']<?php $st = true;
}
    ?>				]
                            }),
                            displayField : 'name',
                            valueField : 'id',
                            mode : 'local',
                            value : '-1',
                            disableKeyFilter : true,
                            triggerAction: 'all',
                            listeners : {
                                select : function(combo, record, index){
                                    store_purchaseOrders.reload({
                                        params: {
                                            start: 0,
                                            limit: list_size,
                                            user_id : combo.getValue()
                                        }
                                    });
                                }
                            }
                        },
                        '->', {
                            xtype: 'textfield',
                            emptyText: '<?php __('[Search By Name]'); ?>',
                            id: 'purchaseOrder_search_field',
                            listeners: {
                                specialkey: function(field, e){
                                    if (e.getKey() == e.ENTER) {
                                        SearchByPurchaseOrderName(Ext.getCmp('purchaseOrder_search_field').getValue());
                                    }
                                }
                            }
                        }, {
                            xtype: 'tbbutton',
                            icon: 'img/search.png',
                            cls: 'x-btn-text-icon',
                            text: '<?php __('GO'); ?>',
                            tooltip:'<?php __('<b>GO</b><br />Click here to get search results'); ?>',
                            id: 'purchaseOrder_go_button',
                            handler: function(){
                                SearchByPurchaseOrderName(Ext.getCmp('purchaseOrder_search_field').getValue());
                            }
                        }, '-', {
                            xtype: 'tbbutton',
                            icon: 'img/table_search.png',
                            cls: 'x-btn-text-icon',
                            text: '<?php __('Advanced Search'); ?>',
                            tooltip:'<?php __('<b>Advanced Search...</b><br />Click here to get the advanced search form'); ?>',
                            handler: function(){
                                SearchPurchaseOrder();
                            }
                        }
                    ]}),
                bbar: new Ext.PagingToolbar({
                    pageSize: list_size,
                    store: store_purchaseOrders,
                    displayInfo: true,
                    displayMsg: '<?php __('Displaying {0} - {1} of {2}'); ?>',
                    beforePageText: '<?php __('Page'); ?>',
                    afterPageText: '<?php __('of {0}'); ?>',
                    emptyMsg: '<?php __('No data to display'); ?>'
                })
            });
            p.getSelectionModel().on('rowselect', function(sm, rowIdx, r) {
                is_posted = (this.getSelections()[0].data.posted == '<font color=green>True</font>');
                if(!is_posted) {
                    p.getTopToolbar().findById('edit-purchaseOrder').enable();
                    p.getTopToolbar().findById('post-purchaseOrder').enable();
                    p.getTopToolbar().findById('delete-purchaseOrder').enable();
                }
                p.getTopToolbar().findById('view-purchaseOrder').enable();
                
                if(this.getSelections().length > 1){
                    p.getTopToolbar().findById('edit-purchaseOrder').disable();
                    p.getTopToolbar().findById('post-purchaseOrder').disable();
                    p.getTopToolbar().findById('view-purchaseOrder').disable();
                    p.getTopToolbar().findById('delete-purchaseOrder').disable();
                }
            });
            p.getSelectionModel().on('rowdeselect', function(sm, rowIdx, r) {
                if(this.getSelections().length == 1){
                    p.getTopToolbar().findById('edit-purchaseOrder').enable();
                    p.getTopToolbar().findById('post-purchaseOrder').enable();
                    p.getTopToolbar().findById('view-purchaseOrder').enable();
                    p.getTopToolbar().findById('delete-purchaseOrder').enable();
                    is_posted = (this.getSelections()[0].data.posted == '<font color=green>True</font>');
                    if(is_posted){
                        p.getTopToolbar().findById('delete-purchaseOrder').disable();
                        p.getTopToolbar().findById('edit-purchaseOrder').disable();
                        p.getTopToolbar().findById('post-purchaseOrder').disable();
                    }
                }
                else{
                    p.getTopToolbar().findById('edit-purchaseOrder').disable();
                    p.getTopToolbar().findById('post-purchaseOrder').disable();
                    p.getTopToolbar().findById('view-purchaseOrder').disable();
                    p.getTopToolbar().findById('delete-purchaseOrder').disable();
                }
            });
            center_panel.setActiveTab(p);
	
            store_purchaseOrders.load({
                params: {
                    start: 0,          
                    limit: list_size
                }
            });
	
        }
