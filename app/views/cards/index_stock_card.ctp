//<script>
    var store_parent_cards = new Ext.data.Store({
	reader: new Ext.data.JsonReader({
            root:'rows',
            totalProperty: 'results',
            fields: [
                'id','item','quantity','unit_price','grn','created','modified'	
            ]
	}),
	proxy: new Ext.data.HttpProxy({
            url: '<?php echo $this->Html->url(array('controller' => 'cards', 'action' => 'list_data_stock_cards', $parent_id)); ?>'	})
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
            {header: "<?php __('Item'); ?>", dataIndex: 'item', sortable: true},
            {header: "<?php __('Quantity'); ?>", dataIndex: 'quantity', sortable: true},
            {header: "<?php __('Unit Price'); ?>", dataIndex: 'unit_price', sortable: true},
            {header: "<?php __('GRN'); ?>", dataIndex: 'grn', sortable: true},
            {header: "<?php __('Date Created'); ?>", dataIndex: 'created', sortable: true},
            {header: "<?php __('Date Modified'); ?>", dataIndex: 'modified', sortable: true}	],
	sm: new Ext.grid.RowSelectionModel({
            singleSelect: false
	}),
	viewConfig: {
            forceFit: true
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
	title: 'Stock Card of the selected Item',
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
