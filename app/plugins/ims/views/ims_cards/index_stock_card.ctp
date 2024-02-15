//<script>
    var store_parent_cards = new Ext.data.Store({
	reader: new Ext.data.JsonReader({
            root:'rows',
            totalProperty: 'results',
            fields: [
                'id','item','grn_sirv_no','in_quantity','out_quantity','unit_price','total_price','balance','balance_in_birr','created','modified','purchase_order_id'	
            ]
	}),
	proxy: new Ext.data.HttpProxy({
            url: '<?php echo $this->Html->url(array('controller' => 'ims_cards', 'action' => 'list_data_stock_cards', $parent_id)); ?>'	})
    });

    var g = new Ext.grid.GridPanel({
	title: '<?php __('Cards'); ?>',
	store: store_parent_cards,	
	loadMask: true,
	stripeRows: true,
	height: 300,
	anchor: '100%',
	id: 'cardGrid',	
	columns: [
            {header: "<?php __('Date'); ?>", dataIndex: 'created', sortable: true},
			{header: "<?php __('GRN/SIRV No.'); ?>", dataIndex: 'grn_sirv_no', sortable: true},
            {header: "<?php __('IN Quantity'); ?>", dataIndex: 'in_quantity', sortable: true},
			{header: "<?php __('Out Quantity'); ?>", dataIndex: 'out_quantity', sortable: true},
            {header: "<?php __('Unit Price'); ?>", dataIndex: 'unit_price', sortable: true},
			{header: "<?php __('Total Price'); ?>", dataIndex: 'total_price', sortable: true},			
			{header: "<?php __('Balance'); ?>", dataIndex: 'balance', sortable: true},			
            {header: "<?php __('Balance in Birr'); ?>", dataIndex: 'balance_in_birr', sortable: true},
			{header: "<?php __('Type'); ?>", dataIndex: 'purchase_order_id', sortable: true}		],
	sm: new Ext.grid.RowSelectionModel({
            singleSelect: false
	}),
	viewConfig: {
            forceFit: true,			
			/*getRowClass: function(record,index,params, store) {					
                    var purchase = record.get('total_price');					
					if(purchase > 0){						
						return 'x-grid3-row-red';
					}
					else{
						return 'x-grid3-row-white';
					}
                }	*/ 
			
	},
	
	tbar: new Ext.Toolbar({
            items: []
        }),
	bbar: new Ext.PagingToolbar({
            pageSize: list_size,
            store: store_parent_cards,
            displayInfo: true,
            displayMsg: '<?php __('Displaying {0} - {1} of {2}'); ?>',
            beforePageText: '<?php __('Page'); ?>',
            afterPageText: '<?php __('of {0}'); ?>',
            emptyMsg: '<?php __('No data to display'); ?>'
	})	
    });
	
    var parentStockCardsViewWindow = new Ext.Window({
	title: 'Stock Card of <?php echo ' ['.$item .']'?>',
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
                    parentStockCardsViewWindow.close();
		}
            }]
    });

    store_parent_cards.load({
        params: {
            start: 0,    
            limit: list_size
        }
    });
