//<script>
    var store_parent_cards = new Ext.data.Store({
	reader: new Ext.data.JsonReader({
            root:'rows',
            totalProperty: 'results',
            fields: [
                'id','item','supplied_issued','grn_sirv','in_quantity','out_quantity','balance','initial','created','modified','purchase_order_id'
            ]
	}),
	proxy: new Ext.data.HttpProxy({
            url: '<?php echo $this->Html->url(array('controller' => 'ims_cards', 'action' => 'list_data_bin_cards', $parent_id,$store_id)); ?>'	})
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
			{header: "<?php __('Supplied by/Issued To'); ?>", dataIndex: 'supplied_issued', sortable: true},
			{header: "<?php __('GRN no./SIRV no.'); ?>", dataIndex: 'grn_sirv', sortable: true},
            {header: "<?php __('In Quantity'); ?>", dataIndex: 'in_quantity', sortable: true},
            {header: "<?php __('Out Quantity'); ?>", dataIndex: 'out_quantity', sortable: true},
            {header: "<?php __('Balance'); ?>", dataIndex: 'balance', sortable: true}, 
			{header: "<?php __('Initial'); ?>", dataIndex: 'initial', sortable: true},
			{header: "<?php __('Type'); ?>", dataIndex: 'purchase_order_id', sortable: true}  ],
	sm: new Ext.grid.RowSelectionModel({
            singleSelect: false
	}),
	viewConfig: {
            forceFit: true
	},
	tbar: new Ext.Toolbar({
            items: []
        })/*,
	bbar: new Ext.PagingToolbar({
            pageSize: list_size,
            store: store_parent_cards,
            displayInfo: true,
            displayMsg: '<?php __('Displaying {0} - {1} of {2}'); ?>',
            beforePageText: '<?php __('Page'); ?>',
            afterPageText: '<?php __('of {0}'); ?>',
            emptyMsg: '<?php __('No data to display'); ?>'
	})*/
    });
    
    var parentBinCardsViewWindow = new Ext.Window({
	title: 'BIN Card of <?php echo ' ['.$item .'] : Stock Card Balance = '. $total_balance;?> <?php echo '<div align="center"><font color=green>'.$store_name.'</font></div>';?>',
	width: 700,
	height:385,
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
                    parentBinCardsViewWindow.close();
		}
            }]
    });

    store_parent_cards.load({
        params: {
            start: 0,    
            limit: list_size
        }
    });
