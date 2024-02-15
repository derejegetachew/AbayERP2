//<script>
    var store_purchaseOrders_approve = new Ext.data.GroupingStore({
	reader: new Ext.data.JsonReader({
            root:'rows',
            totalProperty: 'results',
            fields: [
                'id','name','user','posted','approved', 
                'rejected','created','modified'	
            ]
	}),
	proxy: new Ext.data.HttpProxy({
            url: '<?php echo $this->Html->url(array('controller' => 'purchase_orders', 'action' => 'list_data_1')); ?>'
	}),	
        sortInfo:{field: 'name', direction: "ASC"},
	groupField: 'user'
    });
    
    function ApprovePurchaseOrder(id) {
	Ext.Ajax.request({
            url: '<?php echo $this->Html->url(array('controller' => 'purchase_orders', 'action' => 'approve')); ?>/'+id,
            success: function(response, opts) {
                Ext.Msg.alert('<?php __('Success'); ?>', '<?php __('Purchase Order successfully approved!'); ?>');
                RefreshPurchaseOrderData();
            },
            failure: function(response, opts) {
                Ext.Msg.alert('<?php __('Error'); ?>', '<?php __('Please report this error to Administrator. Cannot approve the purchase Order. Error code'); ?>: ' + response.status);
            }
	});
    }
    
    function RejectPurchaseOrder(id) {
	Ext.Ajax.request({
            url: '<?php echo $this->Html->url(array('controller' => 'purchase_orders', 'action' => 'reject')); ?>/'+id,
            success: function(response, opts) {
                Ext.Msg.alert('<?php __('Success'); ?>', '<?php __('Purchase Order successfully rejected!'); ?>');
                RefreshPurchaseOrderData();
            },
            failure: function(response, opts) {
                Ext.Msg.alert('<?php __('Error'); ?>', '<?php __('Please report this error to Administrator. Cannot reject the purchase Order. Error code'); ?>: ' + response.status);
            }
	});
    }
    
    var popUpWin=0;

    function popUpWindow(URLStr, left, top, width, height) {
        if(popUpWin){
            if(!popUpWin.closed) popUpWin.close();
        }
        popUpWin = open(URLStr, 'popUpWin', 'toolbar=no,location=no,directories=no,status=no,menubar=no,scrollbars=yes,resizable=no,copyhistory=yes,width='+width+',height='+height+',left='+left+', top='+top+',screenX='+left+',screenY='+top+'');
    }

    function PrintPurchaseOrder(id) {
	url = '<?php echo $this->Html->url(array('controller' => 'purchase_orders', 'action' => 'print_po')); ?>/' + id;

        popUpWindow(url, 200, 20, 740, 600);
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
	store_purchaseOrders_approve.reload({
            params: {
                start: 0,
                limit: list_size,
                conditions: conditions
	    }
	});
    }

    function RefreshPurchaseOrderData() {
	store_purchaseOrders_approve.reload();
    }

    function showMenu(grid, index, event) {
        event.stopEvent();
        var record = grid.getStore().getAt(index);
        //alert(record.get('rejected'));
        var btnStatus = (record.get('rejected') == '<font color=green>True</font>' || record.get('approved') == '<font color=green>True</font>')? true: false;
        //alert(btnStatus);
        var menu = new Ext.menu.Menu({
            items: [{
                    text: '<b>Details of <i>' + record.get('name') + '</i></b>',
                    icon: 'img/table_view.png',
                    handler: function() {
                        ViewPurchaseOrder(record.get('id'));
                    }
                }, '-', {
                    text: 'Approve Purchase Order',
                    icon: 'img/table_edit.png',
                    handler: function() {
                        ApprovePurchaseOrder(record.get('id'));
                    },
                    disabled: btnStatus
                }, {
                    text: 'Reject Purchase Order',
                    icon: 'img/table_delete.png',
                    handler: function() {
                        RejectPurchaseOrder(record.get('id'));
                    },
                    disabled: btnStatus
                }, {
                    text: 'Print Purchase Order',
                    icon: 'img/table_print.png',
                    handler: function() {
                        PrintPurchaseOrder(record.get('id'));
                    }
                }
            ]
        }).showAt(event.xy);
    }


    if(center_panel.find('id', 'approve-purchaseOrder-tab') != "") {
	var p = center_panel.findById('approve-purchaseOrder-tab');
	center_panel.setActiveTab(p);
    } else {
	var p = center_panel.add({
            title: '<?php __('Approve POs'); ?>',
            closable: true,
            loadMask: true,
            stripeRows: true,
            id: 'approve-purchaseOrder-tab',
            xtype: 'grid',
            store: store_purchaseOrders_approve,
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
                    ViewPurchaseOrder(Ext.getCmp('approve-purchaseOrder-tab').getSelectionModel().getSelected().data.id);
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
                        text: '<?php __('Approve'); ?>',
                        id: 'approve-purchaseOrder-approve',
                        tooltip:'<?php __('<b>Approve Purchase Orders</b><br />Click here to approve the selected Purchase Order'); ?>',
                        icon: 'img/table_edit.png',
                        cls: 'x-btn-text-icon',
                        disabled: true,
                        handler: function(btn) {
                            var sm = p.getSelectionModel();
                            var sel = sm.getSelected();
                            if (sm.hasSelection()){
                                Ext.Msg.show({
                                    title: '<?php __('Approve Purchase Order for Approval'); ?>',
                                    buttons: Ext.MessageBox.YESNO,
                                    msg: '<?php __('Approve'); ?> '+sel.data.name+'?',
                                    icon: Ext.MessageBox.QUESTION,
                                    fn: function(btn){
                                        if (btn == 'yes'){
                                            ApprovePurchaseOrder(sel.data.id);
                                        }
                                    }
                                });
                            };
                        }
                    }, ' ', '-', ' ', {
                        xtype: 'tbbutton',
                        text: '<?php __('Reject'); ?>',
                        id: 'reject-purchaseOrder-approve',
                        tooltip:'<?php __('<b>Reject Purchase Orders</b><br />Click here to reject the selected Purchase Order'); ?>',
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
                                            RejectPurchaseOrder(sel.data.id);
                                        }
                                    }
                                });
                            };
                        }
                    }, ' ', '-', ' ', {
                        xtype: 'tbbutton',
                        text: '<?php __('View Purchase Order'); ?>',
                        id: 'view-purchaseOrder-approve',
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
                                    store_purchaseOrders_approve.reload({
                                        params: {
                                            start: 0,
                                            limit: list_size,
                                            user_id : combo.getValue()
                                        }
                                    });
                                }
                            }
                        }, '->', {
                            xtype: 'textfield',
                            emptyText: '<?php __('[Search By Name]'); ?>',
                            id: 'approve_purchaseOrder_search_field',
                            listeners: {
                                specialkey: function(field, e){
                                    if (e.getKey() == e.ENTER) {
                                        SearchByPurchaseOrderName(Ext.getCmp('approve_purchaseOrder_search_field').getValue());
                                    }
                                }
                            }
                        }, {
                            xtype: 'tbbutton',
                            icon: 'img/search.png',
                            cls: 'x-btn-text-icon',
                            text: '<?php __('GO'); ?>',
                            tooltip:'<?php __('<b>GO</b><br />Click here to get search results'); ?>',
                            id: 'approve_purchaseOrder_go_button',
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
                    ]
                }),
                bbar: new Ext.PagingToolbar({
                    pageSize: list_size,
                    store: store_purchaseOrders_approve,
                    displayInfo: true,
                    displayMsg: '<?php __('Displaying {0} - {1} of {2}'); ?>',
                    beforePageText: '<?php __('Page'); ?>',
                    afterPageText: '<?php __('of {0}'); ?>',
                    emptyMsg: '<?php __('No data to display'); ?>'
                })
            });
            p.getSelectionModel().on('rowselect', function(sm, rowIdx, r) {
                is_approved = (this.getSelections()[0].data.approved == '<font color=green>True</font>');
                is_rejected = (this.getSelections()[0].data.rejected == '<font color=green>True</font>');
                if(!is_approved && !is_rejected) {
                    p.getTopToolbar().findById('approve-purchaseOrder-approve').enable();
                    p.getTopToolbar().findById('reject-purchaseOrder-approve').enable();
                }
                p.getTopToolbar().findById('view-purchaseOrder-approve').enable();
                
                if(this.getSelections().length > 1){
                    p.getTopToolbar().findById('approve-purchaseOrder-approve').disable();
                    p.getTopToolbar().findById('reject-purchaseOrder-approve').disable();
                    p.getTopToolbar().findById('view-purchaseOrder-approve').disable();
                }
            });
            p.getSelectionModel().on('rowdeselect', function(sm, rowIdx, r) {
                if(this.getSelections().length == 1){
                    p.getTopToolbar().findById('approve-purchaseOrder-approve').enable();
                    p.getTopToolbar().findById('reject-purchaseOrder-approve').enable();
                    p.getTopToolbar().findById('view-purchaseOrder-approve').enable();
                    is_approved = (this.getSelections()[0].data.approved == '<font color=green>True</font>');
                    is_rejected = (this.getSelections()[0].data.rejected == '<font color=green>True</font>');
                    if(is_approved || is_rejected){
                        p.getTopToolbar().findById('approve-purchaseOrder-approve').disable();
                        p.getTopToolbar().findById('reject-purchaseOrder-approve').disable();
                    }
                } else {
                    p.getTopToolbar().findById('approve-purchaseOrder-approve').disable();
                    p.getTopToolbar().findById('reject-purchaseOrder-approve').disable();
                    p.getTopToolbar().findById('view-purchaseOrder-approve').disable();
                }
            });
            center_panel.setActiveTab(p);
            
            store_purchaseOrders_approve.load({
                params: {
                    start: 0,          
                    limit: list_size
                }
            });
	
        }
