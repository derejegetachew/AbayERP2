//<script>
    var store_stores = new Ext.data.GroupingStore({
	reader: new Ext.data.JsonReader({
            root:'rows',
            totalProperty: 'results',
            fields: [
                'id','name','address','created','modified'		
            ]
	}),
	proxy: new Ext.data.HttpProxy({
            url: '<?php echo $this->Html->url(array('controller' => 'stores', 'action' => 'list_data')); ?>'
	}),	
        sortInfo:{field: 'name', direction: "ASC"},
	groupField: 'address'
    });


    function AddStore() {
	Ext.Ajax.request({
            url: '<?php echo $this->Html->url(array('controller' => 'stores', 'action' => 'add')); ?>',
            success: function(response, opts) {
                var store_data = response.responseText;

                eval(store_data);

                StoreAddWindow.show();
            },
            failure: function(response, opts) {
                Ext.Msg.alert('<?php __('Error'); ?>', '<?php __('Cannot get the store add form. Error code'); ?>: ' + response.status);
            }
	});
    }

    function EditStore(id) {
	Ext.Ajax.request({
            url: '<?php echo $this->Html->url(array('controller' => 'stores', 'action' => 'edit')); ?>/'+id,
            success: function(response, opts) {
                var store_data = response.responseText;
			
                eval(store_data);
			
                StoreEditWindow.show();
            },
            failure: function(response, opts) {
                Ext.Msg.alert('<?php __('Error'); ?>', '<?php __('Cannot get the store edit form. Error code'); ?>: ' + response.status);
            }
	});
    }

    function ViewStore(id) {
        Ext.Ajax.request({
            url: '<?php echo $this->Html->url(array('controller' => 'stores', 'action' => 'view')); ?>/'+id,
            success: function(response, opts) {
                var store_data = response.responseText;

                eval(store_data);

                StoreViewWindow.show();
            },
            failure: function(response, opts) {
                Ext.Msg.alert('<?php __('Error'); ?>', '<?php __('Cannot get the store view form. Error code'); ?>: ' + response.status);
            }
        });
    }
    function ViewParentGrnItems(id) {
        Ext.Ajax.request({
            url: '<?php echo $this->Html->url(array('controller' => 'grnItems', 'action' => 'index2')); ?>/'+id,
            success: function(response, opts) {
                var parent_grnItems_data = response.responseText;

                eval(parent_grnItems_data);

                parentGrnItemsViewWindow.show();
            },
            failure: function(response, opts) {
                Ext.Msg.alert('<?php __('Error'); ?>', '<?php __('Cannot get the campus view form. Error code'); ?>: ' + response.status);
            }
        });
    }


    function DeleteStore(id) {
	Ext.Ajax.request({
            url: '<?php echo $this->Html->url(array('controller' => 'stores', 'action' => 'delete')); ?>/'+id,
            success: function(response, opts) {
                Ext.Msg.alert('<?php __('Success'); ?>', '<?php __('Store successfully deleted!'); ?>');
                RefreshStoreData();
            },
            failure: function(response, opts) {
                Ext.Msg.alert('<?php __('Error'); ?>', '<?php __('Cannot get the store add form. Error code'); ?>: ' + response.status);
            }
	});
    }

    function SearchStore(){
	Ext.Ajax.request({
            url: '<?php echo $this->Html->url(array('controller' => 'stores', 'action' => 'search')); ?>',
            success: function(response, opts){
                var store_data = response.responseText;

                eval(store_data);

                storeSearchWindow.show();
            },
            failure: function(response, opts) {
                Ext.Msg.alert('<?php __('Error'); ?>','<?php __('Cannot get the store search form. Error Code'); ?>: ' + response.status);
            }
	});
    }

    function SearchByStoreName(value){
	var conditions = '\'Store.name LIKE\' => \'%' + value + '%\'';
	store_stores.reload({
            params: {
                start: 0,
                limit: list_size,
                conditions: conditions
	    }
	});
    }

    function RefreshStoreData() {
	store_stores.reload();
    }


    if(center_panel.find('id', 'store-tab') != "") {
	var p = center_panel.findById('store-tab');
	center_panel.setActiveTab(p);
    } else {
	var p = center_panel.add({
            title: '<?php __('Stores'); ?>',
            closable: true,
            loadMask: true,
            stripeRows: true,
            id: 'store-tab',
            xtype: 'grid',
            store: store_stores,
            columns: [
                {header: "<?php __('Name'); ?>", dataIndex: 'name', sortable: true},
                {header: "<?php __('Address'); ?>", dataIndex: 'address', sortable: true},
                {header: "<?php __('Created'); ?>", dataIndex: 'created', sortable: true},
                {header: "<?php __('Modified'); ?>", dataIndex: 'modified', sortable: true}
            ],
            view: new Ext.grid.GroupingView({
                forceFit:true,
                groupTextTpl: '{text} ({[values.rs.length]} {[values.rs.length > 1 ? "Stores" : "Store"]})'
            }),
            listeners: {
                celldblclick: function(){
                    ViewStore(Ext.getCmp('store-tab').getSelectionModel().getSelected().data.id);
                }
            },
            sm: new Ext.grid.RowSelectionModel({
                singleSelect: false
            }),
            tbar: new Ext.Toolbar({
			
                items: [{
                        xtype: 'tbbutton',
                        text: '<?php __('Add'); ?>',
                        tooltip:'<?php __('<b>Add Stores</b><br />Click here to create a new Store'); ?>',
                        icon: 'img/table_add.png',
                        cls: 'x-btn-text-icon',
                        handler: function(btn) {
                            AddStore();
                        }
                    }, ' ', '-', ' ', {
                        xtype: 'tbbutton',
                        text: '<?php __('Edit'); ?>',
                        id: 'edit-store',
                        tooltip:'<?php __('<b>Edit Stores</b><br />Click here to modify the selected Store'); ?>',
                        icon: 'img/table_edit.png',
                        cls: 'x-btn-text-icon',
                        disabled: true,
                        handler: function(btn) {
                            var sm = p.getSelectionModel();
                            var sel = sm.getSelected();
                            if (sm.hasSelection()){
                                EditStore(sel.data.id);
                            };
                        }
                    }, ' ', '-', ' ', {
                        xtype: 'tbbutton',
                        text: '<?php __('Delete'); ?>',
                        id: 'delete-store',
                        tooltip:'<?php __('<b>Delete Stores(s)</b><br />Click here to remove the selected Store(s)'); ?>',
                        icon: 'img/table_delete.png',
                        cls: 'x-btn-text-icon',
                        disabled: true,
                        handler: function(btn) {
                            var sm = p.getSelectionModel();
                            var sel = sm.getSelections();
                            if (sm.hasSelection()){
                                if(sel.length==1){
                                    Ext.Msg.show({
                                        title: '<?php __('Remove Store'); ?>',
                                        buttons: Ext.MessageBox.YESNO,
                                        msg: '<?php __('Remove'); ?> '+sel[0].data.name+'?',
                                        icon: Ext.MessageBox.QUESTION,
                                        fn: function(btn){
                                            if (btn == 'yes'){
                                                DeleteStore(sel[0].data.id);
                                            }
                                        }
                                    });
                                }else{
                                    Ext.Msg.show({
                                        title: '<?php __('Remove Store'); ?>',
                                        buttons: Ext.MessageBox.YESNO,
                                        msg: '<?php __('Remove the selected Stores'); ?>?',
                                        icon: Ext.MessageBox.QUESTION,
                                        fn: function(btn){
                                            if (btn == 'yes'){
                                                var sel_ids = '';
                                                for(i=0;i<sel.length;i++){
                                                    if(i>0)
                                                        sel_ids += '_';
                                                    sel_ids += sel[i].data.id;
                                                }
                                                DeleteStore(sel_ids);
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
                        text: '<?php __('View Store'); ?>',
                        id: 'view-store',
                        tooltip:'<?php __('<b>View Store</b><br />Click here to see details of the selected Store'); ?>',
                        icon: 'img/table_view.png',
                        cls: 'x-btn-text-icon',
                        disabled: true,
                        handler: function(btn) {
                            var sm = p.getSelectionModel();
                            var sel = sm.getSelected();
                            if (sm.hasSelection()){
                                ViewStore(sel.data.id);
                            };
                        },
                        menu : {
                            items: [
                                {
                                    text: '<?php __('View GRN Items'); ?>',
                                    icon: 'img/table_view.png',
                                    cls: 'x-btn-text-icon',
                                    handler: function(btn) {
                                        var sm = p.getSelectionModel();
                                        var sel = sm.getSelected();
                                        if (sm.hasSelection()){
                                            ViewParentGrnItems(sel.data.id);
                                        };
                                    }
                                }
                            ]
                        }
                    }, ' ', '-',  '->', {
                        xtype: 'textfield',
                        emptyText: '<?php __('[Search By Name]'); ?>',
                        id: 'store_search_field',
                        listeners: {
                            specialkey: function(field, e){
                                if (e.getKey() == e.ENTER) {
                                    SearchByStoreName(Ext.getCmp('store_search_field').getValue());
                                }
                            }
                        }
                    }, {
                        xtype: 'tbbutton',
                        icon: 'img/search.png',
                        cls: 'x-btn-text-icon',
                        text: '<?php __('GO'); ?>',
                        tooltip:'<?php __('<b>GO</b><br />Click here to get search results'); ?>',
                        id: 'store_go_button',
                        handler: function(){
                            SearchByStoreName(Ext.getCmp('store_search_field').getValue());
                        }
                    }, '-', {
                        xtype: 'tbbutton',
                        icon: 'img/table_search.png',
                        cls: 'x-btn-text-icon',
                        text: '<?php __('Advanced Search'); ?>',
                        tooltip:'<?php __('<b>Advanced Search...</b><br />Click here to get the advanced search form'); ?>',
                        handler: function(){
                            SearchStore();
                        }
                    }
		]}),
            bbar: new Ext.PagingToolbar({
                pageSize: list_size,
                store: store_stores,
                displayInfo: true,
                displayMsg: '<?php __('Displaying {0} - {1} of {2}'); ?>',
                beforePageText: '<?php __('Page'); ?>',
                afterPageText: '<?php __('of {0}'); ?>',
                emptyMsg: '<?php __('No data to display'); ?>'
            })
	});
	p.getSelectionModel().on('rowselect', function(sm, rowIdx, r) {
            p.getTopToolbar().findById('edit-store').enable();
            p.getTopToolbar().findById('delete-store').enable();
            p.getTopToolbar().findById('view-store').enable();
            if(this.getSelections().length > 1){
                p.getTopToolbar().findById('edit-store').disable();
                p.getTopToolbar().findById('view-store').disable();
            }
	});
	p.getSelectionModel().on('rowdeselect', function(sm, rowIdx, r) {
            if(this.getSelections().length > 1){
                p.getTopToolbar().findById('edit-store').disable();
                p.getTopToolbar().findById('view-store').disable();
                p.getTopToolbar().findById('delete-store').enable();
            }
            else if(this.getSelections().length == 1){
                p.getTopToolbar().findById('edit-store').enable();
                p.getTopToolbar().findById('view-store').enable();
                p.getTopToolbar().findById('delete-store').enable();
            }
            else{
                p.getTopToolbar().findById('edit-store').disable();
                p.getTopToolbar().findById('view-store').disable();
                p.getTopToolbar().findById('delete-store').disable();
            }
	});
	center_panel.setActiveTab(p);
	
	store_stores.load({
            params: {
                start: 0,          
                limit: list_size
            }
	});
	
    }
