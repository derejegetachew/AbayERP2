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
            url: '<?php echo $this->Html->url(array('controller' => 'cards', 'action' => 'list_data', $parent_id)); ?>'	})
    });

    function AddParentCard() {
	Ext.Ajax.request({
            url: '<?php echo $this->Html->url(array('controller' => 'cards', 'action' => 'add', $parent_id)); ?>',
            success: function(response, opts) {
                var parent_card_data = response.responseText;
			
                eval(parent_card_data);
			
                CardAddWindow.show();
            },
            failure: function(response, opts) {
                Ext.Msg.alert('<?php __('Error'); ?>', '<?php __('Cannot get the card add form. Error code'); ?>: ' + response.status);
            }
	});
    }

    function EditParentCard(id) {
	Ext.Ajax.request({
            url: '<?php echo $this->Html->url(array('controller' => 'cards', 'action' => 'edit')); ?>/'+id+'/<?php echo $parent_id; ?>',
            success: function(response, opts) {
                var parent_card_data = response.responseText;
			
                eval(parent_card_data);
			
                CardEditWindow.show();
            },
            failure: function(response, opts) {
                Ext.Msg.alert('<?php __('Error'); ?>', '<?php __('Cannot get the card edit form. Error code'); ?>: ' + response.status);
            }
	});
    }

    function ViewCard(id) {
	Ext.Ajax.request({
            url: '<?php echo $this->Html->url(array('controller' => 'cards', 'action' => 'view')); ?>/'+id,
            success: function(response, opts) {
                var card_data = response.responseText;

                eval(card_data);

                CardViewWindow.show();
            },
            failure: function(response, opts) {
                Ext.Msg.alert('<?php __('Error'); ?>', '<?php __('Cannot get the card view form. Error code'); ?>: ' + response.status);
            }
	});
    }


    function DeleteParentCard(id) {
	Ext.Ajax.request({
            url: '<?php echo $this->Html->url(array('controller' => 'cards', 'action' => 'delete')); ?>/'+id,
            success: function(response, opts) {
                Ext.Msg.alert('<?php __('Success'); ?>', '<?php __('Card(s) successfully deleted!'); ?>');
                RefreshParentCardData();
            },
            failure: function(response, opts) {
                Ext.Msg.alert('<?php __('Error'); ?>', '<?php __('Cannot get the card to be deleted. Error code'); ?>: ' + response.status);
            }
	});
    }

    function SearchByParentCardName(value){
	var conditions = '\'Card.name LIKE\' => \'%' + value + '%\'';
	store_parent_cards.reload({
            params: {
                start: 0,
                limit: list_size,
                conditions: conditions
	    }
	});
    }

    function RefreshParentCardData() {
	store_parent_cards.reload();
    }



    var g = new Ext.grid.GridPanel({
	title: '<?php __('Cards'); ?>',
	store: store_parent_cards,
	loadMask: true,
	stripeRows: true,
	height: 300,
	anchor: '100%',
        id: 'cardGrid',
	columns: [
            {header:"<?php __('item'); ?>", dataIndex: 'item', sortable: true},
            {header: "<?php __('Quantity'); ?>", dataIndex: 'quantity', sortable: true},
            {header: "<?php __('Unit Price'); ?>", dataIndex: 'unit_price', sortable: true},
            {header:"<?php __('grn'); ?>", dataIndex: 'grn', sortable: true},
            {header: "<?php __('Created'); ?>", dataIndex: 'created', sortable: true},
            {header: "<?php __('Modified'); ?>", dataIndex: 'modified', sortable: true}	],
	sm: new Ext.grid.RowSelectionModel({
            singleSelect: false
	}),
	viewConfig: {
            forceFit: true
	},
        listeners: {
            celldblclick: function(){
                ViewCard(Ext.getCmp('cardGrid').getSelectionModel().getSelected().data.id);
            }
        },
	tbar: new Ext.Toolbar({
            items: [{
                    xtype: 'tbbutton',
                    text: '<?php __('Add'); ?>',
                    tooltip:'<?php __('<b>Add Card</b><br />Click here to create a new Card'); ?>',
                    icon: 'img/table_add.png',
                    cls: 'x-btn-text-icon',
                    handler: function(btn) {
                        AddParentCard();
                    }
                }, ' ', '-', ' ', {
                    xtype: 'tbbutton',
                    text: '<?php __('Edit'); ?>',
                    id: 'edit-parent-card',
                    tooltip:'<?php __('<b>Edit Card</b><br />Click here to modify the selected Card'); ?>',
                    icon: 'img/table_edit.png',
                    cls: 'x-btn-text-icon',
                    disabled: true,
                    handler: function(btn) {
                        var sm = g.getSelectionModel();
                        var sel = sm.getSelected();
                        if (sm.hasSelection()){
                            EditParentCard(sel.data.id);
                        };
                    }
                }, ' ', '-', ' ', {
                    xtype: 'tbbutton',
                    text: '<?php __('Delete'); ?>',
                    id: 'delete-parent-card',
                    tooltip:'<?php __('<b>Delete Card(s)</b><br />Click here to remove the selected Card(s)'); ?>',
                    icon: 'img/table_delete.png',
                    cls: 'x-btn-text-icon',
                    disabled: true,
                    handler: function(btn) {
                        var sm = g.getSelectionModel();
                        var sel = sm.getSelections();
                        if (sm.hasSelection()){
                            if(sel.length==1){
                                Ext.Msg.show({
                                    title: '<?php __('Remove Card'); ?>',
                                    buttons: Ext.MessageBox.YESNOCANCEL,
                                    msg: '<?php __('Remove'); ?> '+sel[0].data.name+'?',
                                    icon: Ext.MessageBox.QUESTION,
                                    fn: function(btn){
                                        if (btn == 'yes'){
                                            DeleteParentCard(sel[0].data.id);
                                        }
                                    }
                                });
                            } else {
                                Ext.Msg.show({
                                    title: '<?php __('Remove Card'); ?>',
                                    buttons: Ext.MessageBox.YESNOCANCEL,
                                    msg: '<?php __('Remove the selected Card'); ?>?',
                                    icon: Ext.MessageBox.QUESTION,
                                    fn: function(btn){
                                        if (btn == 'yes'){
                                            var sel_ids = '';
                                            for(i=0;i<sel.length;i++){
                                                if(i>0)
                                                    sel_ids += '_';
                                                sel_ids += sel[i].data.id;
                                            }
                                            DeleteParentCard(sel_ids);
                                        }
                                    }
                                });
                            }
                        } else {
                            Ext.Msg.alert('<?php __('Warning'); ?>', '<?php __('Please select a record first'); ?>');
                        };
                    }
                }, ' ','-',' ', {
                    xtype: 'tbsplit',
                    text: '<?php __('View Card'); ?>',
                    id: 'view-card2',
                    tooltip:'<?php __('<b>View Card</b><br />Click here to see details of the selected Card'); ?>',
                    icon: 'img/table_view.png',
                    cls: 'x-btn-text-icon',
                    disabled: true,
                    handler: function(btn) {
                        var sm = g.getSelectionModel();
                        var sel = sm.getSelected();
                        if (sm.hasSelection()){
                            ViewCard(sel.data.id);
                        };
                    },
                    menu : {
                        items: [
                        ]
                    }

                }, ' ', '->', {
                    xtype: 'textfield',
                    emptyText: '<?php __('[Search By Name]'); ?>',
                    id: 'parent_card_search_field',
                    listeners: {
                        specialkey: function(field, e){
                            if (e.getKey() == e.ENTER) {
                                SearchByParentCardName(Ext.getCmp('parent_card_search_field').getValue());
                            }
                        }

                    }
                }, {
                    xtype: 'tbbutton',
                    icon: 'img/search.png',
                    cls: 'x-btn-text-icon',
                    text: 'GO',
                    tooltip:'<?php __('<b>GO</b><br />Click here to get search results'); ?>',
                    id: 'parent_card_go_button',
                    handler: function(){
                        SearchByParentCardName(Ext.getCmp('parent_card_search_field').getValue());
                    }
                }, ' '
            ]}),
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
    g.getSelectionModel().on('rowselect', function(sm, rowIdx, r) {
	g.getTopToolbar().findById('edit-parent-card').enable();
	g.getTopToolbar().findById('delete-parent-card').enable();
        g.getTopToolbar().findById('view-card2').enable();
	if(this.getSelections().length > 1){
            g.getTopToolbar().findById('edit-parent-card').disable();
            g.getTopToolbar().findById('view-card2').disable();
	}
    });
    g.getSelectionModel().on('rowdeselect', function(sm, rowIdx, r) {
	if(this.getSelections().length > 1){
            g.getTopToolbar().findById('edit-parent-card').disable();
            g.getTopToolbar().findById('delete-parent-card').enable();
            g.getTopToolbar().findById('view-card2').disable();
	}
	else if(this.getSelections().length == 1){
            g.getTopToolbar().findById('edit-parent-card').enable();
            g.getTopToolbar().findById('delete-parent-card').enable();
            g.getTopToolbar().findById('view-card2').enable();
	}
	else{
            g.getTopToolbar().findById('edit-parent-card').disable();
            g.getTopToolbar().findById('delete-parent-card').disable();
            g.getTopToolbar().findById('view-card2').disable();
	}
    });



    var parentCardsViewWindow = new Ext.Window({
	title: 'Card Under the selected Item',
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
                    parentCardsViewWindow.close();
		}
            }]
    });

    store_parent_cards.load({
        params: {
            start: 0,    
            limit: list_size
        }
    });
