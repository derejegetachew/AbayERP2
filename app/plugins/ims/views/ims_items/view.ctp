//<script>
    var store_item_grns = new Ext.data.Store({
	reader: new Ext.data.JsonReader({
            root:'rows',
            totalProperty: 'results',
            fields: [
                'id','name','supplier','purchase_order','date_purchased','created','modified'		]
	}),
	proxy: new Ext.data.HttpProxy({
            url: '<?php echo $this->Html->url(array('controller' => 'ims_grns', 'action' => 'list_data', $item['ImsItem']['id'])); ?>'	})
    });
    var store_item_purchaseOrders = new Ext.data.Store({
	reader: new Ext.data.JsonReader({
            root:'rows',
            totalProperty: 'results',
            fields: [
                'id','name','user','created','modified'		]
	}),
	proxy: new Ext.data.HttpProxy({
            url: '<?php echo $this->Html->url(array('controller' => 'ims_purchase_orders', 'action' => 'list_data', $item['ImsItem']['id'])); ?>'	})
    });
		
    <?php
    $item_html = "<table cellspacing=3>" . "<tr><th align=right>" . __('Name', true) . ":</th><td><b>" . $item['ImsItem']['name'] . "</b></td></tr>" .
            "<tr><th align=right>" . __('Description', true) . ":</th><td><b>" . $item['ImsItem']['description'] . "</b></td></tr>" .
            "<tr><th align=right>" . __('Item Category', true) . ":</th><td><b>" . $item['ImsItemCategory']['name'] . "</b></td></tr>" .
            "<tr><th align=right>" . __('Created', true) . ":</th><td><b>" . $item['ImsItem']['created'] . "</b></td></tr>" .
            "<tr><th align=right>" . __('Modified', true) . ":</th><td><b>" . $item['ImsItem']['modified'] . "</b></td></tr>" .
            "</table>";
    ?>
    var item_view_panel_1 = {
        html : '<?php echo $item_html; ?>',
        frame : true,
        height: 80
    }
    var item_view_panel_2 = new Ext.TabPanel({
        activeTab: 0,
        anchor: '100%',
        height:190,
        plain:true,
        defaults:{autoScroll: true},
        items:[{
                xtype: 'grid',
                loadMask: true,
                stripeRows: true,
                store: store_item_grns,
                title: '<?php __('Grns'); ?>',
                enableColumnMove: false,
                listeners: {
                    activate: function(){
                        if(store_item_grns.getCount() == '')
                            store_item_grns.reload();
                    }
                },
                columns: [
                    {header: "<?php __('Name'); ?>", dataIndex: 'name', sortable: true},
                    {header: "<?php __('Supplier'); ?>", dataIndex: 'supplier', sortable: true},
                    {header: "<?php __('Purchase Order'); ?>", dataIndex: 'purchase_order', sortable: true},
                    {header: "<?php __('Date Purchased'); ?>", dataIndex: 'date_purchased', sortable: true},
                    {header: "<?php __('Created'); ?>", dataIndex: 'created', sortable: true},
                    {header: "<?php __('Modified'); ?>", dataIndex: 'modified', sortable: true}
                ],
                viewConfig: {
                    forceFit: true
                },
                bbar: new Ext.PagingToolbar({
                    pageSize: view_list_size,
                    store: store_item_grns,
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
                store: store_item_purchaseOrders,
                title: '<?php __('PurchaseOrders'); ?>',
                enableColumnMove: false,
                listeners: {
                    activate: function(){
                        if(store_item_purchaseOrders.getCount() == '')
                            store_item_purchaseOrders.reload();
                    }
                },
                columns: [
                    {header: "<?php __('Name'); ?>", dataIndex: 'name', sortable: true}
                    ,					{header: "<?php __('User'); ?>", dataIndex: 'user', sortable: true}
                    ,					{header: "<?php __('Created'); ?>", dataIndex: 'created', sortable: true}
                    ,					{header: "<?php __('Modified'); ?>", dataIndex: 'modified', sortable: true}
		
                ],
                viewConfig: {
                    forceFit: true
                },
                bbar: new Ext.PagingToolbar({
                    pageSize: view_list_size,
                    store: store_item_purchaseOrders,
                    displayInfo: true,
                    displayMsg: '<?php __('Displaying'); ?> {0} - {1} <?php __('of'); ?> {2}',
                    beforePageText: '<?php __('Page'); ?>',
                    afterPageText: '<?php __('of'); ?> {0}',
                    emptyMsg: '<?php __('No data to display'); ?>'
                })
            }]
    });

    var ItemViewWindow = new Ext.Window({
        title: '<?php __('View Item'); ?>: <?php echo $item['ImsItem']['name']; ?>',
        width: 500,
        height:345,
        minWidth: 500,
        minHeight: 345,
        resizable: false,
        plain:true,
        bodyStyle:'padding:5px;',
        buttonAlign:'center',
        modal: true,
        items: [ 
            item_view_panel_1,
            item_view_panel_2
        ],

        buttons: [{
                text: '<?php __('Close'); ?>',
                handler: function(btn){
                    ItemViewWindow.close();
                }
            }]
    });
