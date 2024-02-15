
var store_prices = new Ext.data.GroupingStore({
	reader: new Ext.data.JsonReader({
		root:'rows',
		totalProperty: 'results',
		fields: [
			'id','gas','date','payroll'		]
	}),
	proxy: new Ext.data.HttpProxy({
		url: '<?php echo $this->Html->url(array('controller' => 'prices', 'action' => 'list_data')); ?>'
	})
,	sortInfo:{field: 'gas', direction: "ASC"},
	groupField: 'date'
});


function AddPrice() {
	Ext.Ajax.request({
		url: '<?php echo $this->Html->url(array('controller' => 'prices', 'action' => 'add')); ?>',
		success: function(response, opts) {
			var price_data = response.responseText;
			
			eval(price_data);
			
			PriceAddWindow.show();
		},
		failure: function(response, opts) {
			Ext.Msg.alert('<?php __('Error'); ?>', '<?php __('Cannot get the price add form. Error code'); ?>: ' + response.status);
		}
	});
}

function EditPrice(id) {
	Ext.Ajax.request({
		url: '<?php echo $this->Html->url(array('controller' => 'prices', 'action' => 'edit')); ?>/'+id,
		success: function(response, opts) {
			var price_data = response.responseText;
			
			eval(price_data);
			
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

function DeletePrice(id) {
	Ext.Ajax.request({
		url: '<?php echo $this->Html->url(array('controller' => 'prices', 'action' => 'remove')); ?>/'+id,
		success: function(response, opts) {
			Ext.Msg.alert('<?php __('Success'); ?>', '<?php __('Price successfully deleted!'); ?>');
			RefreshPriceData();
		},
		failure: function(response, opts) {
			Ext.Msg.alert('<?php __('Error'); ?>', '<?php __('Cannot get the price add form. Error code'); ?>: ' + response.status);
		}
	});
}

function SearchPrice(){
	Ext.Ajax.request({
		url: '<?php echo $this->Html->url(array('controller' => 'prices', 'action' => 'search')); ?>',
		success: function(response, opts){
			var price_data = response.responseText;

			eval(price_data);

			priceSearchWindow.show();
		},
		failure: function(response, opts) {
			Ext.Msg.alert('<?php __('Error'); ?>','<?php __('Cannot get the price search form. Error Code'); ?>: ' + response.status);
		}
	});
}

function SearchByPriceName(value){
	var conditions = '\'Price.name LIKE\' => \'%' + value + '%\'';
	store_prices.reload({
		 params: {
			start: 0,
			limit: list_size,
			conditions: conditions
	    }
	});
}

function RefreshPriceData() {
	store_prices.reload();
}


if(center_panel.find('id', 'price-tab') != "") {
	var p = center_panel.findById('price-tab');
	center_panel.setActiveTab(p);
} else {
	var p = center_panel.add({
		title: '<?php __('Prices'); ?>',
		closable: true,
		loadMask: true,
		stripeRows: true,
		id: 'price-tab',
		xtype: 'grid',
		store: store_prices,
		columns: [
			{header: "<?php __('Gas'); ?>", dataIndex: 'gas', sortable: true},
			{header: "<?php __('Date'); ?>", dataIndex: 'date', sortable: true},
			{header: "<?php __('Payroll'); ?>", dataIndex: 'payroll', sortable: true}
		],
		
		view: new Ext.grid.GroupingView({
            forceFit:true,
            groupTextTpl: '{text} ({[values.rs.length]} {[values.rs.length > 1 ? "Prices" : "Price"]})'
        })
,
		listeners: {
			celldblclick: function(){
				ViewPrice(Ext.getCmp('price-tab').getSelectionModel().getSelected().data.id);
			}
		},
		sm: new Ext.grid.RowSelectionModel({
			singleSelect: false
		}),
		tbar: new Ext.Toolbar({
			
			items: [{
					xtype: 'tbbutton',
					text: '<?php __('Add'); ?>',
					tooltip:'<?php __('<b>Add Prices</b><br />Click here to create a new Price'); ?>',
					icon: 'img/table_add.png',
					cls: 'x-btn-text-icon',
					handler: function(btn) {
						AddPrice();
					}
				}, ' ', '-', ' ', {
					xtype: 'tbbutton',
					text: '<?php __('Edit'); ?>',
					id: 'edit-price',
					tooltip:'<?php __('<b>Edit Prices</b><br />Click here to modify the selected Price'); ?>',
					icon: 'img/table_edit.png',
					cls: 'x-btn-text-icon',
					disabled: true,
					handler: function(btn) {
						var sm = p.getSelectionModel();
						var sel = sm.getSelected();
						if (sm.hasSelection()){
							EditPrice(sel.data.id);
						};
					}
				}, ' ', '-', ' ', {
					xtype: 'tbbutton',
					text: '<?php __('Delete'); ?>',
					id: 'delete-price',
					tooltip:'<?php __('<b>Delete Prices(s)</b><br />Click here to remove the selected Price(s)'); ?>',
					icon: 'img/table_delete.png',
					cls: 'x-btn-text-icon',
					disabled: true,
					handler: function(btn) {
						var sm = p.getSelectionModel();
						var sel = sm.getSelections();
						if (sm.hasSelection()){
							if(sel.length==1){
								Ext.Msg.show({
									title: '<?php __('Remove Price'); ?>',
									buttons: Ext.MessageBox.YESNO,
									msg: '<?php __('Remove'); ?> '+sel[0].data.name+'?',
									icon: Ext.MessageBox.QUESTION,
									fn: function(btn){
										if (btn == 'yes'){
											DeletePrice(sel[0].data.id);
										}
									}
								});
							}else{
								Ext.Msg.show({
									title: '<?php __('Remove Price'); ?>',
									buttons: Ext.MessageBox.YESNO,
									msg: '<?php __('Remove the selected Prices'); ?>?',
									icon: Ext.MessageBox.QUESTION,
									fn: function(btn){
										if (btn == 'yes'){
											var sel_ids = '';
											for(i=0;i<sel.length;i++){
												if(i>0)
													sel_ids += '_';
												sel_ids += sel[i].data.id;
											}
											DeletePrice(sel_ids);
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
					text: '<?php __('View Price'); ?>',
					id: 'view-price',
					tooltip:'<?php __('<b>View Price</b><br />Click here to see details of the selected Price'); ?>',
					icon: 'img/table_view.png',
					cls: 'x-btn-text-icon',
					disabled: true,
					handler: function(btn) {
						var sm = p.getSelectionModel();
						var sel = sm.getSelected();
						if (sm.hasSelection()){
							ViewPrice(sel.data.id);
						};
					},
					menu : {
						items: [
						]
					}
				}, ' ', '-',  '<?php __('Payroll'); ?>: ', {
					xtype : 'combo',
					emptyText: 'All',
					store : new Ext.data.ArrayStore({
						fields : ['id', 'name'],
						data : [
							['-1', 'All'],
							<?php $st = false;foreach ($payrolls as $item){if($st) echo ",
							";?>['<?php echo $item['Payroll']['id']; ?>' ,'<?php echo $item['Payroll']['name']; ?>']<?php $st = true;}?>						]
					}),
					displayField : 'name',
					valueField : 'id',
					mode : 'local',
					value : '-1',
					disableKeyFilter : true,
					triggerAction: 'all',
					listeners : {
						select : function(combo, record, index){
							store_prices.reload({
								params: {
									start: 0,
									limit: list_size,
									payroll_id : combo.getValue()
								}
							});
						}
					}
				},
 '->', {
					xtype: 'textfield',
					emptyText: '<?php __('[Search By Name]'); ?>',
					id: 'price_search_field',
					listeners: {
						specialkey: function(field, e){
							if (e.getKey() == e.ENTER) {
								SearchByPriceName(Ext.getCmp('price_search_field').getValue());
							}
						}
					}
				}, {
					xtype: 'tbbutton',
					icon: 'img/search.png',
					cls: 'x-btn-text-icon',
					text: '<?php __('GO'); ?>',
                    tooltip:'<?php __('<b>GO</b><br />Click here to get search results'); ?>',
					id: 'price_go_button',
					handler: function(){
						SearchByPriceName(Ext.getCmp('price_search_field').getValue());
					}
				}, '-', {
					xtype: 'tbbutton',
					icon: 'img/table_search.png',
					cls: 'x-btn-text-icon',
					text: '<?php __('Advanced Search'); ?>',
                    tooltip:'<?php __('<b>Advanced Search...</b><br />Click here to get the advanced search form'); ?>',
					handler: function(){
						SearchPrice();
					}
				}
		]}),
		bbar: new Ext.PagingToolbar({
			pageSize: list_size,
			store: store_prices,
			displayInfo: true,
			displayMsg: '<?php __('Displaying {0} - {1} of {2}'); ?>',
			beforePageText: '<?php __('Page'); ?>',
			afterPageText: '<?php __('of {0}'); ?>',
			emptyMsg: '<?php __('No data to display'); ?>'
		})
	});
	p.getSelectionModel().on('rowselect', function(sm, rowIdx, r) {
		p.getTopToolbar().findById('edit-price').enable();
		p.getTopToolbar().findById('delete-price').enable();
		p.getTopToolbar().findById('view-price').enable();
		if(this.getSelections().length > 1){
			p.getTopToolbar().findById('edit-price').disable();
			p.getTopToolbar().findById('view-price').disable();
		}
	});
	p.getSelectionModel().on('rowdeselect', function(sm, rowIdx, r) {
		if(this.getSelections().length > 1){
			p.getTopToolbar().findById('edit-price').disable();
			p.getTopToolbar().findById('view-price').disable();
			p.getTopToolbar().findById('delete-price').enable();
		}
		else if(this.getSelections().length == 1){
			p.getTopToolbar().findById('edit-price').enable();
			p.getTopToolbar().findById('view-price').enable();
			p.getTopToolbar().findById('delete-price').enable();
		}
		else{
			p.getTopToolbar().findById('edit-price').disable();
			p.getTopToolbar().findById('view-price').disable();
			p.getTopToolbar().findById('delete-price').disable();
		}
	});
	center_panel.setActiveTab(p);
	
	store_prices.load({
		params: {
			start: 0,          
			limit: list_size
		}
	});
	
}
