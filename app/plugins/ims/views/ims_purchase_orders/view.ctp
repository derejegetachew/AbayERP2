//<script>
    var store_purchaseOrder_grns = new Ext.data.Store({
	reader: new Ext.data.JsonReader({
            root:'rows',
            totalProperty: 'results',
            fields: [
                'id','name','supplier','purchase_order','date_purchased','created','modified'		]
	}),
	proxy: new Ext.data.HttpProxy({
            url: '<?php echo $this->Html->url(array('controller' => 'ims_grns', 'action' => 'list_data', $purchase_order['ImsPurchaseOrder']['id'])); ?>'	})
    });
    var store_purchaseOrder_purchaseOrderItems = new Ext.data.Store({
	reader: new Ext.data.JsonReader({
            root:'rows',
            totalProperty: 'results',
            fields: [
                'id','purchase_order','item','measurement','ordered_quantity','purchased_quantity','unit_price','created','modified'		]
	}),
	proxy: new Ext.data.HttpProxy({
            url: '<?php echo $this->Html->url(array('controller' => 'ims_purchase_order_items', 'action' => 'list_data', $purchase_order['ImsPurchaseOrder']['id'])); ?>'	})
    });
    
    <?php
    $purchase_order_html = "<table cellspacing=3>" . 
            "<tr><th align=right>" . __('Name', true) . ":</th><td><b>" . $purchase_order['ImsPurchaseOrder']['name'] . "</b></td></tr>" .
            "<tr><th align=right>" . __('Created By', true) . ":</th><td><b>" . $purchase_order['User']['username'] . ' (' . 
                $purchase_order['User']['Person']['first_name'] . ' ' . $purchase_order['User']['Person']['middle_name'] . ' ' . 
                $purchase_order['User']['Person']['last_name'] . ')' . "</b></td></tr>" .
            "<tr><th align=right>" . __('Date Created', true) . ":</th><td><b>" . $purchase_order['ImsPurchaseOrder']['created'] . "</b></td></tr>" .
            "<tr><th align=right>" . __('Date Modified', true) . ":</th><td><b>" . $purchase_order['ImsPurchaseOrder']['modified'] . "</b></td></tr>" .
            "</table>";
    ?>
    var purchaseOrder_view_panel_1 = {
        html : '<?php echo $purchase_order_html; ?>',
        frame : true,
        height: 90
    }
    
    var purchaseOrder_view_panel_2 = new Ext.TabPanel({
        activeTab: 0,
        anchor: '100%',
        height:190,
        plain:true,
        defaults:{autoScroll: true},
        items:[
            {
                xtype: 'grid',
                loadMask: true,
                stripeRows: true,
                store: store_purchaseOrder_grns,
                title: '<?php __('Grns'); ?>',
                enableColumnMove: false,
                listeners: {
                    activate: function(){
                        if(store_purchaseOrder_grns.getCount() == '')
                            store_purchaseOrder_grns.reload();
                    }
                },
                columns: [
                    {header: "<?php __('Name'); ?>", dataIndex: 'name', sortable: true},
                    {header: "<?php __('Supplier'); ?>", dataIndex: 'supplier', sortable: true},
                    {header: "<?php __('Date Purchased'); ?>", dataIndex: 'date_purchased', sortable: true},
                    {header: "<?php __('Created'); ?>", dataIndex: 'created', sortable: true, hidden: true},
                    {header: "<?php __('Modified'); ?>", dataIndex: 'modified', sortable: true, hidden: true}
                ],
                viewConfig: {
                    forceFit: true
                },
                bbar: new Ext.PagingToolbar({
                    pageSize: list_size,
                    store: store_purchaseOrder_grns,
                    displayInfo: true,
                    displayMsg: '<?php __('Displaying'); ?> {0} - {1} <?php __('of'); ?> {2}',
                    beforePageText: '<?php __('Page'); ?>',
                    afterPageText: '<?php __('of'); ?> {0}',
                    emptyMsg: '<?php __('No data to display'); ?>'
                })
            }, {
                xtype: 'grid',
                loadMask: true,
                stripeRows: true,
                store: store_purchaseOrder_purchaseOrderItems,
                title: '<?php __('Purchase Order Items'); ?>',
                enableColumnMove: false,
                listeners: {
                    activate: function(){
                        if(store_purchaseOrder_purchaseOrderItems.getCount() == '')
                            store_purchaseOrder_purchaseOrderItems.reload();
                    }
                },
                columns: [
                    {header: "<?php __('Item'); ?>", dataIndex: 'item', sortable: true},
                    {header: "<?php __('Measurement'); ?>", dataIndex: 'measurement', sortable: true},
                    {header: "<?php __('Ordered Quantity'); ?>", dataIndex: 'ordered_quantity', sortable: true},
                    {header: "<?php __('Purchased Quantity'); ?>", dataIndex: 'purchased_quantity', sortable: true},
                    {header: "<?php __('Unit Price'); ?>", dataIndex: 'unit_price', sortable: true},
                    {header: "<?php __('Created'); ?>", dataIndex: 'created', sortable: true, hidden: true},
                    {header: "<?php __('Modified'); ?>", dataIndex: 'modified', sortable: true, hidden: true}
                ],
                viewConfig: {
                    forceFit: true
                },
                bbar: new Ext.PagingToolbar({
                    pageSize: list_size,
                    store: store_purchaseOrder_purchaseOrderItems,
                    displayInfo: true,
                    displayMsg: '<?php __('Displaying'); ?> {0} - {1} <?php __('of'); ?> {2}',
                    beforePageText: '<?php __('Page'); ?>',
                    afterPageText: '<?php __('of'); ?> {0}',
                    emptyMsg: '<?php __('No data to display'); ?>'
                })
            }
        ]
    });

    var PurchaseOrderViewWindow = new Ext.Window({
        title: '<?php __('View Purchase Order'); ?>: <?php echo $purchase_order['ImsPurchaseOrder']['name']; ?>',
        width: 500,
        height: 355,
        plain: true,
        bodyStyle: 'padding:5px;',
        buttonAlign: 'center',
        modal: true,
        items: [ 
            purchaseOrder_view_panel_1,
            purchaseOrder_view_panel_2
        ],

        buttons: [{
                text: '<?php __('Close'); ?>',
                handler: function(btn){
                    PurchaseOrderViewWindow.close();
                }
            }]
    });
