//<script>
    var store_purchaseOrderItem_grnItems = new Ext.data.Store({
        reader: new Ext.data.JsonReader({
            root:'rows',
            totalProperty: 'results',
            fields: [
                'id','grn','purchase_order_item','quantity','unit_price','created','modified'		
            ]
        }),
        proxy: new Ext.data.HttpProxy({
            url: '<?php echo $this->Html->url(array('controller' => 'grnItems', 'action' => 'list_data', $purchaseOrderItem['PurchaseOrderItem']['id'])); ?>'	})
    });
		
    <?php $purchaseOrderItem_html = "<table cellspacing=3>" . 		"<tr><th align=right>" . __('Purchase Order', true) . ":</th><td><b>" . $purchaseOrderItem['PurchaseOrder']['name'] . "</b></td></tr>" . 
            "<tr><th align=right>" . __('Item', true) . ":</th><td><b>" . $purchaseOrderItem['Item']['name'] . "</b></td></tr>" . 
            "<tr><th align=right>" . __('Measurement', true) . ":</th><td><b>" . $purchaseOrderItem['PurchaseOrderItem']['measurement'] . "</b></td></tr>" . 
            "<tr><th align=right>" . __('Ordered Quantity', true) . ":</th><td><b>" . $purchaseOrderItem['PurchaseOrderItem']['ordered_quantity'] . "</b></td></tr>" . 
            "<tr><th align=right>" . __('Purchased Quantity', true) . ":</th><td><b>" . $purchaseOrderItem['PurchaseOrderItem']['purchased_quantity'] . "</b></td></tr>" . 
            "<tr><th align=right>" . __('Unit Price', true) . ":</th><td><b>" . $purchaseOrderItem['PurchaseOrderItem']['unit_price'] . "</b></td></tr>" . 
            "<tr><th align=right>" . __('Created', true) . ":</th><td><b>" . $purchaseOrderItem['PurchaseOrderItem']['created'] . "</b></td></tr>" . 
            "<tr><th align=right>" . __('Modified', true) . ":</th><td><b>" . $purchaseOrderItem['PurchaseOrderItem']['modified'] . "</b></td></tr>" . 
        "</table>"; 
    ?>
    var purchaseOrderItem_view_panel_1 = {
        html : '<?php echo $purchaseOrderItem_html; ?>',
        frame : true,
        height: 80
    }
    var purchaseOrderItem_view_panel_2 = new Ext.TabPanel({
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
            store: store_purchaseOrderItem_grnItems,
            title: '<?php __('GrnItems'); ?>',
            enableColumnMove: false,
            listeners: {
                activate: function(){
                    if(store_purchaseOrderItem_grnItems.getCount() == '')
                        store_purchaseOrderItem_grnItems.reload();
                }
            },
            columns: [
                {header: "<?php __('Grn'); ?>", dataIndex: 'grn', sortable: true},
                {header: "<?php __('Purchase Order Item'); ?>", dataIndex: 'purchase_order_item', sortable: true},
                {header: "<?php __('Quantity'); ?>", dataIndex: 'quantity', sortable: true},
                {header: "<?php __('Unit Price'); ?>", dataIndex: 'unit_price', sortable: true},
                {header: "<?php __('Created'); ?>", dataIndex: 'created', sortable: true},
                {header: "<?php __('Modified'); ?>", dataIndex: 'modified', sortable: true}
            ],
            viewConfig: {
                forceFit: true
            },
            bbar: new Ext.PagingToolbar({
                pageSize: view_list_size,
                store: store_purchaseOrderItem_grnItems,
                displayInfo: true,
                displayMsg: '<?php __('Displaying'); ?> {0} - {1} <?php __('of'); ?> {2}',
                beforePageText: '<?php __('Page'); ?>',
                afterPageText: '<?php __('of'); ?> {0}',
                emptyMsg: '<?php __('No data to display'); ?>'
            })
        }]
    });

		var PurchaseOrderItemViewWindow = new Ext.Window({
			title: '<?php __('View PurchaseOrderItem'); ?>: <?php echo $purchaseOrderItem['PurchaseOrderItem']['id']; ?>',
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
				purchaseOrderItem_view_panel_1,
				purchaseOrderItem_view_panel_2
			],

			buttons: [{
				text: '<?php __('Close'); ?>',
				handler: function(btn){
					PurchaseOrderItemViewWindow.close();
				}
			}]
		});
