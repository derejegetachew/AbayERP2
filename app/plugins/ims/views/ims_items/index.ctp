//<script>
<?php header('Content-Type: text/html; charset=UTF-8'); ?>
    var store_items = new Ext.data.GroupingStore({
	reader: new Ext.data.JsonReader({
            root:'rows',
            totalProperty: 'results',
            fields: [
                'id', {name: 'name', sortType: Ext.data.SortTypes.asUCString}, 'description', 'item_category', 
                'max_level', 'min_level','type', 'fixed_asset', 'tag_code', 'created', 'modified'		
            ]
	}),
	proxy: new Ext.data.HttpProxy({
            url: '<?php echo $this->Html->url(array('controller' => 'ims_items', 'action' => 'list_data')); ?>'
	}),			
        sortInfo:{field: 'name', direction: "ASC"},
		
	groupField: 'item_category'
    });
	
	var filter_conditions = '';

    function AddItem() {
	Ext.Ajax.request({
            url: '<?php echo $this->Html->url(array('controller' => 'ims_items', 'action' => 'add')); ?>',
            success: function(response, opts) {
                var item_data = response.responseText;
			
                eval(item_data);
			
                ItemAddWindow.show();
            },
            failure: function(response, opts) {
                Ext.Msg.alert('<?php __('Error'); ?>', '<?php __('Cannot get the item add form. Error code'); ?>: ' + response.status);
            }
	});
    }

    function EditItem(id) {
	Ext.Ajax.request({
            url: '<?php echo $this->Html->url(array('controller' => 'ims_items', 'action' => 'edit')); ?>/'+id,
            success: function(response, opts) {
                var item_data = response.responseText;
			
                eval(item_data);
			
                ItemEditWindow.show();
            },
            failure: function(response, opts) {
                Ext.Msg.alert('<?php __('Error'); ?>', '<?php __('Cannot get the item edit form. Error code'); ?>: ' + response.status);
            }
	});
    }

    function ViewItem(id) {
        Ext.Ajax.request({
            url: '<?php echo $this->Html->url(array('controller' => 'ims_items', 'action' => 'view')); ?>/'+id,
            success: function(response, opts) {
                var item_data = response.responseText;

                eval(item_data);

                ItemViewWindow.show();
            },
            failure: function(response, opts) {
                Ext.Msg.alert('<?php __('Error'); ?>', '<?php __('Cannot get the item view form. Error code'); ?>: ' + response.status);
            }
        });
    }
    
    function ViewParentGrns(id) {
        Ext.Ajax.request({
            url: '<?php echo $this->Html->url(array('controller' => 'ims_grns', 'action' => 'index2')); ?>/'+id,
            success: function(response, opts) {
                var parent_grns_data = response.responseText;

                eval(parent_grns_data);

                parentGrnsViewWindow.show();
            },
            failure: function(response, opts) {
                Ext.Msg.alert('<?php __('Error'); ?>', '<?php __('Cannot get the GRN view form. Error code'); ?>: ' + response.status);
            }
        });
    }

    function ViewParentPurchaseOrders(id) {
        Ext.Ajax.request({
            url: '<?php echo $this->Html->url(array('controller' => 'ims_purchase_orders', 'action' => 'index2')); ?>/'+id,
            success: function(response, opts) {
                var parent_purchaseOrders_data = response.responseText;

                eval(parent_purchaseOrders_data);

                parentPurchaseOrdersViewWindow.show();
            },
            failure: function(response, opts) {
                Ext.Msg.alert('<?php __('Error'); ?>', '<?php __('Cannot get the campus view form. Error code'); ?>: ' + response.status);
            }
        });
    }
    
    function ViewStockCards(id) {
        Ext.Ajax.request({
            url: '<?php echo $this->Html->url(array('controller' => 'ims_cards', 'action' => 'index_stock_card')); ?>/'+id,
            success: function(response, opts) {
                var parent_purchaseOrders_data = response.responseText;

                eval(parent_purchaseOrders_data);

                parentStockCardsViewWindow.show();
            },
            failure: function(response, opts) {
                Ext.Msg.alert('<?php __('Error'); ?>', '<?php __('Cannot get the bin view form. Error code'); ?>: ' + response.status);
            }
        });
    }
    
    function ViewBinCards(id,storeid) {
        Ext.Ajax.request({
            url: '<?php echo $this->Html->url(array('controller' => 'ims_cards', 'action' => 'index_bin_card')); ?>/'+id+'/'+storeid,
            success: function(response, opts) {
                var parent_purchaseOrders_data = response.responseText;

                eval(parent_purchaseOrders_data);

                parentBinCardsViewWindow.show();
            },
            failure: function(response, opts) {
                Ext.Msg.alert('<?php __('Error'); ?>', '<?php __('Cannot get the bin card view form. Error code'); ?>: ' + response.status);
            }
        });
    }
    
    function DeleteItem(id) {
	Ext.Ajax.request({
            url: '<?php echo $this->Html->url(array('controller' => 'ims_items', 'action' => 'delete')); ?>/'+id,
            success: function(response, opts) {
				var obj = JSON.parse(response.responseText);
				if(obj.success == "false"){
					Ext.Msg.alert('<?php __('Error'); ?>', obj.errormsg);
				} else if(obj.success == "true"){
					Ext.Msg.alert('<?php __('Success'); ?>', obj.msg);
					RefreshItemData();
				}
            },
            failure: function(response, opts) {
                Ext.Msg.alert('<?php __('Error'); ?>', '<?php __('Cannot get the item add form. Error code'); ?>: ' + response.status);
            }
	});
    }

    function SearchItem(){
	Ext.Ajax.request({
            url: '<?php echo $this->Html->url(array('controller' => 'ims_items', 'action' => 'search')); ?>',
            success: function(response, opts){
                var item_data = response.responseText;

                eval(item_data);

                itemSearchWindow.show();
            },
            failure: function(response, opts) {
                Ext.Msg.alert('<?php __('Error'); ?>','<?php __('Cannot get the item search form. Error Code'); ?>: ' + response.status);
            }
	});
    }

    function SearchByItemName(value){
		var conditions = '\'ImsItem.name LIKE\' => \'%' + value + '%\'';
		filter_conditions = conditions;
        store_items.setBaseParam('query', filter_conditions);
		store_items.reload({
            params: {
                start: 0,
                limit: list_size,
                conditions: conditions
			}
		});
    }	

    function RefreshItemData() {
	store_items.reload();
    }
	
	function showMenu(grid, index, event) {
        event.stopEvent();
        var record = grid.getStore().getAt(index);
        var btnStatus = 0; //(record.get('rejectable') == 'True')? false: true;
        var menu = new Ext.menu.Menu({
            items: [
                {
                    text: '<?php __('View BinCard'); ?>',
                    icon: 'img/table_view.png',
					cls: 'x-btn-text-icon',
                    
					menu : {
                            items: [
								<?php foreach($stores as $store) 
								{
								?>
									{
										text: '<?php __($store['ImsStore']['name']); ?>',
										icon: 'img/table_view.png',
										cls: 'x-btn-text-icon',
										handler: function(btn) {
											ViewBinCards(record.get('id'),<?php echo $store['ImsStore']['id'] ?>);
										}
									},
								<?php
								}
								?>
                            ]
                        }
                }, {
                    text: '<?php __('View StockCard'); ?>',
					icon: 'img/table_view.png',
					cls: 'x-btn-text-icon',
                    handler: function() {
                        ViewStockCards(record.get('id'));
                    }
                }
            ]
        }).showAt(event.xy);
    }
    
    if(center_panel.find('id', 'item-tab') != "") {
	var p = center_panel.findById('item-tab');
	center_panel.setActiveTab(p);
    } else {
	var p = center_panel.add({
            title: '<?php __('Items'); ?>',
            closable: true,
            loadMask: true,
            stripeRows: true,
            id: 'item-tab',
            xtype: 'grid',
            store: store_items,
            columns: [
                {header: "<?php __('Name'); ?>", dataIndex: 'name', sortable: true},
                {header: "<?php __('Code'); ?>", dataIndex: 'description', sortable: true},
                {header: "<?php __('Item Category'); ?>", dataIndex: 'item_category', sortable: true},
                {header: "<?php __('Max Level'); ?>", dataIndex: 'max_level', sortable: true},
                {header: "<?php __('Min Level'); ?>", dataIndex: 'min_level', sortable: true},
				{header: "<?php __('Type'); ?>", dataIndex: 'type', sortable: true},
				{header: "<?php __('Fixed Asset'); ?>", dataIndex: 'fixed_asset', sortable: true},
				{header: "<?php __('Tag Code'); ?>", dataIndex: 'tag_code', sortable: true},
                {header: "<?php __('Created'); ?>", dataIndex: 'created', sortable: true},
                {header: "<?php __('Modified'); ?>", dataIndex: 'modified', sortable: true}
            ],
		
            view: new Ext.grid.GroupingView({
                forceFit:true,
                groupTextTpl: '{text} ({[values.rs.length]} {[values.rs.length > 1 ? "Items" : "Item"]})'
            }),
            listeners: {
                celldblclick: function(){
                    ViewItem(Ext.getCmp('item-tab').getSelectionModel().getSelected().data.id);
                },
				'rowcontextmenu': function(grid, index, event) {
                    showMenu(grid, index, event);
                        //grid.selectedNode = grid.store.getAt(row); // we need this
                        //if((index) !== false) {
                        this.getSelectionModel().selectRow(index);
                        //}
                } 
            },
            sm: new Ext.grid.RowSelectionModel({
                singleSelect: false
            }),
            tbar: new Ext.Toolbar({
			
                items: [{
                        xtype: 'tbbutton',
                        text: '<?php __('Add'); ?>',
                        tooltip:'<?php __('<b>Add Items</b><br />Click here to create a new Item'); ?>',
                        icon: 'img/table_add.png',
                        cls: 'x-btn-text-icon',
                        handler: function(btn) {
                            AddItem();
                        }
                    }, ' ', '-', ' ', {
                        xtype: 'tbbutton',
                        text: '<?php __('Edit'); ?>',
                        id: 'edit-item',
                        tooltip:'<?php __('<b>Edit Items</b><br />Click here to modify the selected Item'); ?>',
                        icon: 'img/table_edit.png',
                        cls: 'x-btn-text-icon',
                        disabled: true,
                        handler: function(btn) {
                            var sm = p.getSelectionModel();
                            var sel = sm.getSelected();
                            if (sm.hasSelection()){
                                EditItem(sel.data.id);
                            };
                        }
                    }, ' ', '-', ' ', {
                        xtype: 'tbbutton',
                        text: '<?php __('Delete'); ?>',
                        id: 'delete-item',
                        tooltip:'<?php __('<b>Delete Items(s)</b><br />Click here to remove the selected Item(s)'); ?>',
                        icon: 'img/table_delete.png',
                        cls: 'x-btn-text-icon',
                        disabled: true,
                        handler: function(btn) {
                            var sm = p.getSelectionModel();
                            var sel = sm.getSelections();
                            if (sm.hasSelection()){
                                if(sel.length==1){
                                    Ext.Msg.show({
                                        title: '<?php __('Remove Item'); ?>',
                                        buttons: Ext.MessageBox.YESNO,
                                        msg: '<?php __('Remove'); ?> '+sel[0].data.name+'?',
                                        icon: Ext.MessageBox.QUESTION,
                                        fn: function(btn){
                                            if (btn == 'yes'){
                                                DeleteItem(sel[0].data.id);
                                            }
                                        }
                                    });
                                }else{
                                    Ext.Msg.show({
                                        title: '<?php __('Remove Item'); ?>',
                                        buttons: Ext.MessageBox.YESNO,
                                        msg: '<?php __('Remove the selected Items'); ?>?',
                                        icon: Ext.MessageBox.QUESTION,
                                        fn: function(btn){
                                            if (btn == 'yes'){
                                                var sel_ids = '';
                                                for(i=0;i<sel.length;i++){
                                                    if(i>0)
                                                        sel_ids += '_';
                                                    sel_ids += sel[i].data.id;
                                                }
                                                DeleteItem(sel_ids);
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
                        text: '<?php __('View Item'); ?>',
                        id: 'view-item',
                        tooltip:'<?php __('<b>View Item</b><br />Click here to see details of the selected Item'); ?>',
                        icon: 'img/table_view.png',
                        cls: 'x-btn-text-icon',
                        disabled: true,
                        handler: function(btn) {
                            var sm = p.getSelectionModel();
                            var sel = sm.getSelected();
                            if (sm.hasSelection()){
                                ViewItem(sel.data.id);
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
                                }, {
                                    text: '<?php __('View Purchase Orders'); ?>',
                                    icon: 'img/table_view.png',
                                    cls: 'x-btn-text-icon',
                                    handler: function(btn) {
                                        var sm = p.getSelectionModel();
                                        var sel = sm.getSelected();
                                        if (sm.hasSelection()){
                                            ViewParentPurchaseOrders(sel.data.id);
                                        };
                                    }
                                }, {
                                    text: '<?php __('View Bin Card'); ?>',
                                    icon: 'img/table_view.png',
                                    cls: 'x-btn-text-icon',
                                    handler: function(btn) {
                                        var sm = p.getSelectionModel();
                                        var sel = sm.getSelected();
                                        if (sm.hasSelection()){
                                            ViewBinCards(sel.data.id);
                                        };
                                    }
                                }, {
                                    text: '<?php __('View Stock Card'); ?>',
                                    icon: 'img/table_view.png',
                                    cls: 'x-btn-text-icon',
                                    handler: function(btn) {
                                        var sm = p.getSelectionModel();
                                        var sel = sm.getSelected();
                                        if (sm.hasSelection()){
                                            ViewStockCards(sel.data.id);
                                        };
                                    }
                                }
                            ]
                        }
                    }, ' ', '-',  '<?php __('Category'); ?>: ', {
                        xtype : 'combo',
                        emptyText: 'All',
                        store : new Ext.data.ArrayStore({
                            fields : ['id', 'name'],
                            data : [
                                ['-1', 'All'],
    <?php
    $st = false;
    foreach ($item_categories as $k => $v) {
        if ($st)
            echo ",
							";
        ?>['<?php echo $k; ?>' ,'<?php echo $v; ?>']<?php $st = true;
}
    ?>                      ]
                        }),
                        displayField : 'name',
                        valueField : 'id',
                        mode : 'local',
                        value : '-1',
                        disableKeyFilter : true,
                        triggerAction: 'all',
                        listeners : {
                            select : function(combo, record, index){
								filter_conditions = combo.getValue();
								store_items.setBaseParam('query', filter_conditions);
								
                                store_items.reload({
                                    params: {
                                        start: 0,
                                        limit: list_size,
                                        ims_item_category_id : combo.getValue()
                                    }
                                });
                            }
                        }
                    }, '->', {
                        xtype: 'textfield',
                        emptyText: '<?php __('[Search By Name]'); ?>',
                        id: 'item_search_field',
                        listeners: {
                            specialkey: function(field, e){
                                if (e.getKey() == e.ENTER) {
                                    SearchByItemName(Ext.getCmp('item_search_field').getValue());
                                }
                            }
                        }
                    }, {
                        xtype: 'tbbutton',
                        icon: 'img/search.png',
                        cls: 'x-btn-text-icon',
                        text: '<?php __('GO'); ?>',
                        tooltip:'<?php __('<b>GO</b><br />Click here to get search results'); ?>',
                        id: 'item_go_button',
                        handler: function(){
                            SearchByItemName(Ext.getCmp('item_search_field').getValue());
                        }
                    }, '-', {
                        xtype: 'tbbutton',
                        icon: 'img/table_search.png',
                        cls: 'x-btn-text-icon',
                        text: '<?php __('Advanced Search'); ?>',
                        tooltip:'<?php __('<b>Advanced Search...</b><br />Click here to get the advanced search form'); ?>',
                        handler: function(){
                            SearchItem();
                        }
                    }
                ]}),
            bbar: new Ext.PagingToolbar({
                pageSize: list_size,
                store: store_items,
                displayInfo: true,
                displayMsg: '<?php __('Displaying {0} - {1} of {2}'); ?>',
                beforePageText: '<?php __('Page'); ?>',
                afterPageText: '<?php __('of {0}'); ?>',
                emptyMsg: '<?php __('No data to display'); ?>'
            })
        });
        p.getSelectionModel().on('rowselect', function(sm, rowIdx, r) {
            p.getTopToolbar().findById('edit-item').enable();
            p.getTopToolbar().findById('delete-item').enable();
            p.getTopToolbar().findById('view-item').enable();
            if(this.getSelections().length > 1){
                p.getTopToolbar().findById('edit-item').disable();
                p.getTopToolbar().findById('view-item').disable();
            }
        });
        p.getSelectionModel().on('rowdeselect', function(sm, rowIdx, r) {
            if(this.getSelections().length > 1){
                p.getTopToolbar().findById('edit-item').disable();
                p.getTopToolbar().findById('view-item').disable();
                p.getTopToolbar().findById('delete-item').enable();
            }
            else if(this.getSelections().length == 1){
                p.getTopToolbar().findById('edit-item').enable();
                p.getTopToolbar().findById('view-item').enable();
                p.getTopToolbar().findById('delete-item').enable();
            }
            else{
                p.getTopToolbar().findById('edit-item').disable();
                p.getTopToolbar().findById('view-item').disable();
                p.getTopToolbar().findById('delete-item').disable();
            }
        });
        center_panel.setActiveTab(p);
		
		store_items.setBaseParam('query', filter_conditions);
		
        store_items.load({
            params: {
                start: 0,          
                limit: list_size
            }
        });

    }
