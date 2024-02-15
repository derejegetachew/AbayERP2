var store_parent_prices = new Ext.data.Store({
	reader: new Ext.data.JsonReader({
		root:'rows',
		totalProperty: 'results',
		fields: [
			'id','gas','date','payroll'	
		]
	}),
	proxy: new Ext.data.HttpProxy({
		url: '<?php echo $this->Html->url(array('controller' => 'prices', 'action' => 'list_data', $parent_id)); ?>'	})
});


function AddParentPrice() {
	Ext.Ajax.request({
		url: '<?php echo $this->Html->url(array('controller' => 'prices', 'action' => 'add', $parent_id)); ?>',
		success: function(response, opts) {
			var parent_price_data = response.responseText;
			
			eval(parent_price_data);
			
			PriceAddWindow.show();
		},
		failure: function(response, opts) {
			Ext.Msg.alert('<?php __('Error'); ?>', '<?php __('Cannot get the price add form. Error code'); ?>: ' + response.status);
		}
	});
}

function EditParentPrice(id) {
	Ext.Ajax.request({
		url: '<?php echo $this->Html->url(array('controller' => 'prices', 'action' => 'edit')); ?>/'+id+'/<?php echo $parent_id; ?>',
		success: function(response, opts) {
			var parent_price_data = response.responseText;
			
			eval(parent_price_data);
			
			PriceEditWindow.show();
		},
		failure: function(response, opts) {
			Ext.Msg.alert('<?php __('Error'); ?>', '<?php __('Cannot get the price edit form. Error code'); ?>: ' + response.status);
		}
	});
}

function ViewPrice(id) {
	Ext.Ajax.request({
		url: '<?php echo $this->Html->url(array('controller' => 'prices', 'action' => 'view')); ?>/'+id,
		success: function(response, opts) {
			var price_data = response.responseText;

			eval(price_data);

			PriceViewWindow.show();
		},
		failure: function(response, opts) {
			Ext.Msg.alert('<?php __('Error'); ?>', '<?php __('Cannot get the price view form. Error code'); ?>: ' + response.status);
		}
	});
}


function DeleteParentPrice(id) {
	Ext.Ajax.request({
		url: '<?php echo $this->Html->url(array('controller' => 'prices', 'action' => 'delete')); ?>/'+id,
		success: function(response, opts) {
			Ext.Msg.alert('<?php __('Success'); ?>', '<?php __('Price(s) successfully deleted!'); ?>');
			RefreshParentPriceData();
		},
		failure: function(response, opts) {
			Ext.Msg.alert('<?php __('Error'); ?>', '<?php __('Cannot get the price to be deleted. Error code'); ?>: ' + response.status);
		}
	});
}

function SearchByParentPriceName(value){
	var conditions = '\'Price.name LIKE\' => \'%' + value + '%\'';
	store_parent_prices.reload({
		 params: {
			start: 0,
			limit: list_size,
			conditions: conditions
	    }
	});
}

function RefreshParentPriceData() {
	store_parent_prices.reload();
}



var g = new Ext.grid.GridPanel({
	title: '<?php __('Prices'); ?>',
	store: store_parent_prices,
	loadMask: true,
	stripeRows: true,
	height: 300,
	anchor: '100%',
    id: 'priceGrid',
	columns: [
		{header: "<?php __('Gas'); ?>", dataIndex: 'gas', sortable: true},
		{header: "<?php __('Date'); ?>", dataIndex: 'date', sortable: true},
		{header:"<?php __('payroll'); ?>", dataIndex: 'payroll', sortable: true}	],
	sm: new Ext.grid.RowSelectionModel({
		singleSelect: false
	}),
	viewConfig: {
		forceFit: true
	},
    listeners: {
        celldblclick: function(){
            ViewPrice(Ext.getCmp('priceGrid').getSelectionModel().getSelected().data.id);
        }
    },
	tbar: new Ext.Toolbar({
		items: [{
				xtype: 'tbbutton',
				text: '<?php __('Add'); ?>',
				tooltip:'<?php __('<b>Add Price</b><br />Click here to create a new Price'); ?>',
				icon: 'img/table_add.png',
				cls: 'x-btn-text-icon',
				handler: function(btn) {
					AddParentPrice();
				}
			}, ' ', '-', ' ', {
				xtype: 'tbbutton',
				text: '<?php __('Edit'); ?>',
				id: 'edit-parent-price',
				tooltip:'<?php __('<b>Edit Price</b><br />Click here to modify the selected Price'); ?>',
				icon: 'img/table_edit.png',
				cls: 'x-btn-text-icon',
				disabled: true,
				handler: function(btn) {
					var sm = g.getSelectionModel();
					var sel = sm.getSelected();
					if (sm.hasSelection()){
						EditParentPrice(sel.data.id);
					};
				}
			}, ' ', '-', ' ', {
				xtype: 'tbbutton',
				text: '<?php __('Delete'); ?>',
				id: 'delete-parent-price',
				tooltip:'<?php __('<b>Delete Price(s)</b><br />Click here to remove the selected Price(s)'); ?>',
				icon: 'img/table_delete.png',
				cls: 'x-btn-text-icon',
				disabled: true,
				handler: function(btn) {
					var sm = g.getSelectionModel();
					var sel = sm.getSelections();
					if (sm.hasSelection()){
						if(sel.length==1){
							Ext.Msg.show({
									title: '<?php __('Remove Price'); ?>',
									buttons: Ext.MessageBox.YESNOCANCEL,
									msg: '<?php __('Remove'); ?> '+sel[0].data.name+'?',
									icon: Ext.MessageBox.QUESTION,
                                    fn: function(btn){
											if (btn == 'yes'){
													DeleteParentPrice(sel[0].data.id);
											}
									}
							});
						} else {
							Ext.Msg.show({
									title: '<?php __('Remove Price'); ?>',
									buttons: Ext.MessageBox.YESNOCANCEL,
									msg: '<?php __('Remove the selected Price'); ?>?',
									icon: Ext.MessageBox.QUESTION,
                                    fn: function(btn){
											if (btn == 'yes'){
													var sel_ids = '';
													for(i=0;i<sel.length;i++){
														if(i>0)
															sel_ids += '_';
														sel_ids += sel[i].data.id;
													}
													DeleteParentPrice(sel_ids);
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
				text: '<?php __('View Price'); ?>',
				id: 'view-price2',
				tooltip:'<?php __('<b>View Price</b><br />Click here to see details of the selected Price'); ?>',
				icon: 'img/table_view.png',
				cls: 'x-btn-text-icon',
				disabled: true,
				handler: function(btn) {
					var sm = g.getSelectionModel();
					var sel = sm.getSelected();
					if (sm.hasSelection()){
						ViewPrice(sel.data.id);
					};
				},
				menu : {
					items: [
					]
				}

            }, ' ', '->', {
				xtype: 'textfield',
				emptyText: '<?php __('[Search By Name]'); ?>',
				id: 'parent_price_search_field',
				listeners: {
					specialkey: function(field, e){
						if (e.getKey() == e.ENTER) {
							SearchByParentPriceName(Ext.getCmp('parent_price_search_field').getValue());
						}
					}

				}
			}, {
				xtype: 'tbbutton',
				icon: 'img/search.png',
				cls: 'x-btn-text-icon',
				text: 'GO',
				tooltip:'<?php __('<b>GO</b><br />Click here to get search results'); ?>',
				id: 'parent_price_go_button',
				handler: function(){
					SearchByParentPriceName(Ext.getCmp('parent_price_search_field').getValue());
				}
			}, ' '
	]}),
	bbar: new Ext.PagingToolbar({
		pageSize: list_size,
		store: store_parent_prices,
		displayInfo: true,
		displayMsg: '<?php __('Displaying {0} - {1} of {2}'); ?>',
		beforePageText: '<?php __('Page'); ?>',
		afterPageText: '<?php __('of {0}'); ?>',
		emptyMsg: '<?php __('No data to display'); ?>'
	})
});
g.getSelectionModel().on('rowselect', function(sm, rowIdx, r) {
	g.getTopToolbar().findById('edit-parent-price').enable();
	g.getTopToolbar().findById('delete-parent-price').enable();
        g.getTopToolbar().findById('view-price2').enable();
	if(this.getSelections().length > 1){
		g.getTopToolbar().findById('edit-parent-price').disable();
                g.getTopToolbar().findById('view-price2').disable();
	}
});
g.getSelectionModel().on('rowdeselect', function(sm, rowIdx, r) {
	if(this.getSelections().length > 1){
		g.getTopToolbar().findById('edit-parent-price').disable();
		g.getTopToolbar().findById('delete-parent-price').enable();
                g.getTopToolbar().findById('view-price2').disable();
	}
	else if(this.getSelections().length == 1){
		g.getTopToolbar().findById('edit-parent-price').enable();
		g.getTopToolbar().findById('delete-parent-price').enable();
                g.getTopToolbar().findById('view-price2').enable();
	}
	else{
		g.getTopToolbar().findById('edit-parent-price').disable();
		g.getTopToolbar().findById('delete-parent-price').disable();
                g.getTopToolbar().findById('view-price2').disable();
	}
});



var parentPricesViewWindow = new Ext.Window({
	title: 'Price Under the selected Item',
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
			parentPricesViewWindow.close();
		}
	}]
});

store_parent_prices.load({
    params: {
        start: 0,    
        limit: list_size
    }
});