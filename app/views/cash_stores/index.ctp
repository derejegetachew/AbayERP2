
var store_cashStores = new Ext.data.GroupingStore({
	reader: new Ext.data.JsonReader({
		root:'rows',
		totalProperty: 'results',
		fields: [
			'id','account_no','employee','value','budget_year'		]
	}),
	proxy: new Ext.data.HttpProxy({
		url: '<?php echo $this->Html->url(array('controller' => 'cashStores', 'action' => 'list_data')); ?>'
	})
,	sortInfo:{field: 'account_no', direction: "ASC"},
	groupField: 'employee_id'
});


function AddCashStore() {
	Ext.Ajax.request({
		url: '<?php echo $this->Html->url(array('controller' => 'cashStores', 'action' => 'add')); ?>',
		success: function(response, opts) {
			var cashStore_data = response.responseText;
			
			eval(cashStore_data);
			
			CashStoreAddWindow.show();
		},
		failure: function(response, opts) {
			Ext.Msg.alert('<?php __('Error'); ?>', '<?php __('Cannot get the cashStore add form. Error code'); ?>: ' + response.status);
		}
	});
}

function EditCashStore(id) {
	Ext.Ajax.request({
		url: '<?php echo $this->Html->url(array('controller' => 'cashStores', 'action' => 'edit')); ?>/'+id,
		success: function(response, opts) {
			var cashStore_data = response.responseText;
			
			eval(cashStore_data);
			
			CashStoreEditWindow.show();
		},
		failure: function(response, opts) {
			Ext.Msg.alert('<?php __('Error'); ?>', '<?php __('Cannot get the cashStore edit form. Error code'); ?>: ' + response.status);
		}
	});
}

function ViewCashStore(id) {
    Ext.Ajax.request({
        url: '<?php echo $this->Html->url(array('controller' => 'cashStores', 'action' => 'view')); ?>/'+id,
        success: function(response, opts) {
            var cashStore_data = response.responseText;

            eval(cashStore_data);

            CashStoreViewWindow.show();
        },
        failure: function(response, opts) {
            Ext.Msg.alert('<?php __('Error'); ?>', '<?php __('Cannot get the cashStore view form. Error code'); ?>: ' + response.status);
        }
    });
}

function DeleteCashStore(id) {
	Ext.Ajax.request({
		url: '<?php echo $this->Html->url(array('controller' => 'cashStores', 'action' => 'delete')); ?>/'+id,
		success: function(response, opts) {
			Ext.Msg.alert('<?php __('Success'); ?>', '<?php __('CashStore successfully deleted!'); ?>');
			RefreshCashStoreData();
		},
		failure: function(response, opts) {
			Ext.Msg.alert('<?php __('Error'); ?>', '<?php __('Cannot get the cashStore add form. Error code'); ?>: ' + response.status);
		}
	});
}

function SearchCashStore(){
	Ext.Ajax.request({
		url: '<?php echo $this->Html->url(array('controller' => 'cashStores', 'action' => 'search')); ?>',
		success: function(response, opts){
			var cashStore_data = response.responseText;

			eval(cashStore_data);

			cashStoreSearchWindow.show();
		},
		failure: function(response, opts) {
			Ext.Msg.alert('<?php __('Error'); ?>','<?php __('Cannot get the cashStore search form. Error Code'); ?>: ' + response.status);
		}
	});
}

function SearchByCashStoreName(value){
	var conditions = '\'CashStore.name LIKE\' => \'%' + value + '%\'';
	store_cashStores.reload({
		 params: {
			start: 0,
			limit: list_size,
			conditions: conditions
	    }
	});
}

function RefreshCashStoreData() {
	store_cashStores.reload();
}


if(center_panel.find('id', 'cashStore-tab') != "") {
	var p = center_panel.findById('cashStore-tab');
	center_panel.setActiveTab(p);
} else {
	var p = center_panel.add({
		title: '<?php __('Cash Stores'); ?>',
		closable: true,
		loadMask: true,
		stripeRows: true,
		id: 'cashStore-tab',
		xtype: 'grid',
		store: store_cashStores,
		columns: [
			{header: "<?php __('Account No'); ?>", dataIndex: 'account_no', sortable: true},
			{header: "<?php __('Employee'); ?>", dataIndex: 'employee', sortable: true},
			{header: "<?php __('Value'); ?>", dataIndex: 'value', sortable: true},
			{header: "<?php __('BudgetYear'); ?>", dataIndex: 'budget_year', sortable: true}
		],
		
		view: new Ext.grid.GroupingView({
            forceFit:true,
            groupTextTpl: '{text} ({[values.rs.length]} {[values.rs.length > 1 ? "CashStores" : "CashStore"]})'
        })
,
		listeners: {
			celldblclick: function(){
				ViewCashStore(Ext.getCmp('cashStore-tab').getSelectionModel().getSelected().data.id);
			}
		},
		sm: new Ext.grid.RowSelectionModel({
			singleSelect: false
		}),
		tbar: new Ext.Toolbar({
			
			items: [{
					xtype: 'tbbutton',
					text: '<?php __('Add'); ?>',
					tooltip:'<?php __('<b>Add CashStores</b><br />Click here to create a new CashStore'); ?>',
					icon: 'img/table_add.png',
					cls: 'x-btn-text-icon',
					handler: function(btn) {
						AddCashStore();
					}
				}, ' ', '-', ' ', {
					xtype: 'tbbutton',
					text: '<?php __('Edit'); ?>',
					id: 'edit-cashStore',
					tooltip:'<?php __('<b>Edit CashStores</b><br />Click here to modify the selected CashStore'); ?>',
					icon: 'img/table_edit.png',
					cls: 'x-btn-text-icon',
					disabled: true,
					handler: function(btn) {
						var sm = p.getSelectionModel();
						var sel = sm.getSelected();
						if (sm.hasSelection()){
							EditCashStore(sel.data.id);
						};
					}
				}, ' ', '-', ' ', {
					xtype: 'tbbutton',
					text: '<?php __('Delete'); ?>',
					id: 'delete-cashStore',
					tooltip:'<?php __('<b>Delete CashStores(s)</b><br />Click here to remove the selected CashStore(s)'); ?>',
					icon: 'img/table_delete.png',
					cls: 'x-btn-text-icon',
					disabled: true,
					handler: function(btn) {
						var sm = p.getSelectionModel();
						var sel = sm.getSelections();
						if (sm.hasSelection()){
							if(sel.length==1){
								Ext.Msg.show({
									title: '<?php __('Remove CashStore'); ?>',
									buttons: Ext.MessageBox.YESNO,
									msg: '<?php __('Remove'); ?> '+sel[0].data.name+'?',
									icon: Ext.MessageBox.QUESTION,
									fn: function(btn){
										if (btn == 'yes'){
											DeleteCashStore(sel[0].data.id);
										}
									}
								});
							}else{
								Ext.Msg.show({
									title: '<?php __('Remove CashStore'); ?>',
									buttons: Ext.MessageBox.YESNO,
									msg: '<?php __('Remove the selected CashStores'); ?>?',
									icon: Ext.MessageBox.QUESTION,
									fn: function(btn){
										if (btn == 'yes'){
											var sel_ids = '';
											for(i=0;i<sel.length;i++){
												if(i>0)
													sel_ids += '_';
												sel_ids += sel[i].data.id;
											}
											DeleteCashStore(sel_ids);
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
					text: '<?php __('View CashStore'); ?>',
					id: 'view-cashStore',
					tooltip:'<?php __('<b>View CashStore</b><br />Click here to see details of the selected CashStore'); ?>',
					icon: 'img/table_view.png',
					cls: 'x-btn-text-icon',
					disabled: true,
					handler: function(btn) {
						var sm = p.getSelectionModel();
						var sel = sm.getSelected();
						if (sm.hasSelection()){
							ViewCashStore(sel.data.id);
						};
					},
					menu : {
						items: [
						]
					}
				}, ' ', '-',  '<?php __('Employee'); ?>: ', {
					xtype : 'combo',
					emptyText: 'All',
					store : new Ext.data.ArrayStore({
						fields : ['id', 'name'],
						data : [
							['-1', 'All'],
							<?php $st = false;foreach ($employees as $item){if($st) echo ",
							";?>['<?php echo $item['Employee']['id']; ?>' ,'<?php echo $item['Employee']['name']; ?>']<?php $st = true;}?>						]
					}),
					displayField : 'name',
					valueField : 'id',
					mode : 'local',
					value : '-1',
					disableKeyFilter : true,
					triggerAction: 'all',
					listeners : {
						select : function(combo, record, index){
							store_cashStores.reload({
								params: {
									start: 0,
									limit: list_size,
									employee_id : combo.getValue()
								}
							});
						}
					}
				},
 '->', {
					xtype: 'textfield',
					emptyText: '<?php __('[Search By Name]'); ?>',
					id: 'cashStore_search_field',
					listeners: {
						specialkey: function(field, e){
							if (e.getKey() == e.ENTER) {
								SearchByCashStoreName(Ext.getCmp('cashStore_search_field').getValue());
							}
						}
					}
				}, {
					xtype: 'tbbutton',
					icon: 'img/search.png',
					cls: 'x-btn-text-icon',
					text: '<?php __('GO'); ?>',
                    tooltip:'<?php __('<b>GO</b><br />Click here to get search results'); ?>',
					id: 'cashStore_go_button',
					handler: function(){
						SearchByCashStoreName(Ext.getCmp('cashStore_search_field').getValue());
					}
				}, '-', {
					xtype: 'tbbutton',
					icon: 'img/table_search.png',
					cls: 'x-btn-text-icon',
					text: '<?php __('Advanced Search'); ?>',
                    tooltip:'<?php __('<b>Advanced Search...</b><br />Click here to get the advanced search form'); ?>',
					handler: function(){
						SearchCashStore();
					}
				}
		]}),
		bbar: new Ext.PagingToolbar({
			pageSize: list_size,
			store: store_cashStores,
			displayInfo: true,
			displayMsg: '<?php __('Displaying {0} - {1} of {2}'); ?>',
			beforePageText: '<?php __('Page'); ?>',
			afterPageText: '<?php __('of {0}'); ?>',
			emptyMsg: '<?php __('No data to display'); ?>'
		})
	});
	p.getSelectionModel().on('rowselect', function(sm, rowIdx, r) {
		p.getTopToolbar().findById('edit-cashStore').enable();
		p.getTopToolbar().findById('delete-cashStore').enable();
		p.getTopToolbar().findById('view-cashStore').enable();
		if(this.getSelections().length > 1){
			p.getTopToolbar().findById('edit-cashStore').disable();
			p.getTopToolbar().findById('view-cashStore').disable();
		}
	});
	p.getSelectionModel().on('rowdeselect', function(sm, rowIdx, r) {
		if(this.getSelections().length > 1){
			p.getTopToolbar().findById('edit-cashStore').disable();
			p.getTopToolbar().findById('view-cashStore').disable();
			p.getTopToolbar().findById('delete-cashStore').enable();
		}
		else if(this.getSelections().length == 1){
			p.getTopToolbar().findById('edit-cashStore').enable();
			p.getTopToolbar().findById('view-cashStore').enable();
			p.getTopToolbar().findById('delete-cashStore').enable();
		}
		else{
			p.getTopToolbar().findById('edit-cashStore').disable();
			p.getTopToolbar().findById('view-cashStore').disable();
			p.getTopToolbar().findById('delete-cashStore').disable();
		}
	});
	center_panel.setActiveTab(p);
	
	store_cashStores.load({
		params: {
			start: 0,          
			limit: list_size
		}
	});
	
}
