//<script>
    var store_store_grnItems = new Ext.data.Store({
	reader: new Ext.data.JsonReader({
            root:'rows',
            totalProperty: 'results',
            fields: [
                'id','grn','purchase_order_item','quantity','unit_price','created','modified'		]
	}),
	proxy: new Ext.data.HttpProxy({
            url: '<?php echo $this->Html->url(array('controller' => 'ims_grn_items', 'action' => 'list_data', $store['ImsStore']['id'])); ?>'	})
    });
	
    <?php
    $store_html = "<table cellspacing=3>" . "<tr><th align=right>" . __('Name', true) . ":</th><td><b>" . $store['ImsStore']['name'] . "</b></td></tr>" .
            "<tr><th align=right>" . __('Address', true) . ":</th><td><b>" . $store['ImsStore']['address'] . "</b></td></tr>" .
			"<tr><th align=right>" . __('Store Keeper', true) . ":</th><td><b>" . $store['ImsStore']['store_keeper_one'] . "</b></td></tr>" .
			"<tr><th align=right>" . __('Store Keeper', true) . ":</th><td><b>" . $store['ImsStore']['store_keeper_two'] . "</b></td></tr>" .
			"<tr><th align=right>" . __('Store Keeper', true) . ":</th><td><b>" . $store['ImsStore']['store_keeper_three'] . "</b></td></tr>" .
			"<tr><th align=right>" . __('Store Keeper', true) . ":</th><td><b>" . $store['ImsStore']['store_keeper_four'] . "</b></td></tr>" .
            "<tr><th align=right>" . __('Created', true) . ":</th><td><b>" . $store['ImsStore']['created'] . "</b></td></tr>" .
            "<tr><th align=right>" . __('Modified', true) . ":</th><td><b>" . $store['ImsStore']['modified'] . "</b></td></tr>" .
            "</table>";
    ?>
    var store_view_panel_1 = {
        html : '<?php echo $store_html; ?>',
        frame : true,
        height: 80
    }
    var store_view_panel_2 = new Ext.TabPanel({
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
                store: store_store_grnItems,
                title: '<?php __('GrnItems'); ?>',
                enableColumnMove: false,
                listeners: {
                    activate: function(){
                        if(store_store_grnItems.getCount() == '')
                            store_store_grnItems.reload();
                    }
                },
                columns: [
                    {header: "<?php __('Grn'); ?>", dataIndex: 'grn', sortable: true}
                    ,					{header: "<?php __('Purchase Order Item'); ?>", dataIndex: 'purchase_order_item', sortable: true}
                    ,					{header: "<?php __('Quantity'); ?>", dataIndex: 'quantity', sortable: true}
                    ,					{header: "<?php __('Unit Price'); ?>", dataIndex: 'unit_price', sortable: true}
                    ,					{header: "<?php __('Created'); ?>", dataIndex: 'created', sortable: true}
                    ,					{header: "<?php __('Modified'); ?>", dataIndex: 'modified', sortable: true}

                ],
                viewConfig: {
                    forceFit: true
                },
                bbar: new Ext.PagingToolbar({
                    pageSize: view_list_size,
                    store: store_store_grnItems,
                    displayInfo: true,
                    displayMsg: '<?php __('Displaying'); ?> {0} - {1} <?php __('of'); ?> {2}',
                    beforePageText: '<?php __('Page'); ?>',
                    afterPageText: '<?php __('of'); ?> {0}',
                    emptyMsg: '<?php __('No data to display'); ?>'
                })
            }			]
    });

    var StoreViewWindow = new Ext.Window({
        title: '<?php __('View Store'); ?>: <?php echo $store['ImsStore']['name']; ?>',
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
            store_view_panel_1,
            store_view_panel_2
        ],

        buttons: [{
                text: '<?php __('Close'); ?>',
                handler: function(btn){
                    StoreViewWindow.close();
                }
            }]
    });
