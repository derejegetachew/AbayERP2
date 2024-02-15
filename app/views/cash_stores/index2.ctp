var store_parent_cashStores = new Ext.data.Store({
	reader: new Ext.data.JsonReader({
		root:'rows',
		totalProperty: 'results',
		fields: [
			'id','account_no','employee','value','budget_year'	
		]
	}),
	proxy: new Ext.data.HttpProxy({
		url: '<?php echo $this->Html->url(array('controller' => 'cashStores', 'action' => 'list_data', $parent_id)); ?>'	})
});


function AddParentCashStore() {
	Ext.Ajax.request({
		url: '<?php echo $this->Html->url(array('controller' => 'cashStores', 'action' => 'add', $parent_id)); ?>',
		success: function(response, opts) {
			var parent_cashStore_data = response.responseText;
			
			eval(parent_cashStore_data);
			
			CashStoreAddWindow.show();
		},
		failure: function(response, opts) {
			Ext.Msg.alert('<?php __('Error'); ?>', '<?php __('Cannot get the cashStore add form. Error code'); ?>: ' + response.status);
		}
	});
}

function EditParentCashStore(id) {
	Ext.Ajax.request({
		url: '<?php echo $this->Html->url(array('controller' => 'cashStores', 'action' => 'edit')); ?>/'+id+'/<?php echo $parent_id; ?>',
		success: function(response, opts) {
			var parent_cashStore_data = response.responseText;
			
			eval(parent_cashStore_data);
			
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


function DeleteParentCashStore(id) {
	Ext.Ajax.request({
		url: '<?php echo $this->Html->url(array('controller' => 'cashStores', 'action' => 'delete')); ?>/'+id,
		success: function(response, opts) {
			Ext.Msg.alert('<?php __('Success'); ?>', '<?php __('CashStore(s) successfully deleted!'); ?>');
			RefreshParentCashStoreData();
		},
		failure: function(response, opts) {
			Ext.Msg.alert('<?php __('Error'); ?>', '<?php __('Cannot get the cashStore to be deleted. Error code'); ?>: ' + response.status);
		}
	});
}

function SearchByParentCashStoreName(value){
	var conditions = '\'CashStore.name LIKE\' => \'%' + value + '%\'';
	store_parent_cashStores.reload({
		 params: {
			start: 0,
			limit: list_size,
			conditions: conditions
	    }
	});
}

function RefreshParentCashStoreData() {
	store_parent_cashStores.reload();
}



var g = new Ext.grid.GridPanel({
	title: '<?php __('Cash Indeminity'); ?>',
	store: store_parent_cashStores,
	loadMask: true,
	stripeRows: true,
	height: 300,
	anchor: '100%',
    id: 'cashStoreGrid',
	columns: [
		{header: "<?php __('Account No'); ?>", dataIndex: 'account_no', sortable: true},
		{header: "<?php __('Value'); ?>", dataIndex: 'value', sortable: true},
		{header:"<?php __('Budget_year'); ?>", dataIndex: 'budget_year', sortable: true}	],
	sm: new Ext.grid.RowSelectionModel({
		singleSelect: false
	}),
	viewConfig: {
		forceFit: true
	},
    listeners: {
        celldblclick: function(){
            ViewCashStore(Ext.getCmp('cashStoreGrid').getSelectionModel().getSelected().data.id);
        }
    },
	tbar: new Ext.Toolbar({
		items: [{
				xtype: 'tbbutton',
				text: '<?php __('Add'); ?>',
				tooltip:'<?php __('<b>Add Cash Indeminity</b><br />Click here to create a new CashStore'); ?>',
				icon: 'img/table_add.png',
				cls: 'x-btn-text-icon',
				handler: function(btn) {
					AddParentCashStore();
				}
			}, ' ', '-', ' ', {
				xtype: 'tbbutton',
				text: '<?php __('Edit'); ?>',
				id: 'edit-parent-cashStore',
				tooltip:'<?php __('<b>Edit Cash Indeminity</b><br />Click here to modify the selected CashStore'); ?>',
				icon: 'img/table_edit.png',
				cls: 'x-btn-text-icon',
				disabled: true,
				handler: function(btn) {
					var sm = g.getSelectionModel();
					var sel = sm.getSelected();
					if (sm.hasSelection()){
						EditParentCashStore(sel.data.id);
					};
				}
			}, ' ', '-', ' ', {
				xtype: 'tbbutton',
				text: '<?php __('Delete'); ?>',
				id: 'delete-parent-cashStore',
				tooltip:'<?php __('<b>Delete Cash Indeminity(s)</b><br />Click here to remove the selected CashStore(s)'); ?>',
				icon: 'img/table_delete.png',
				cls: 'x-btn-text-icon',
				disabled: true,
				handler: function(btn) {
					var sm = g.getSelectionModel();
					var sel = sm.getSelections();
					if (sm.hasSelection()){
						if(sel.length==1){
							Ext.Msg.show({
									title: '<?php __('Remove CashStore'); ?>',
									buttons: Ext.MessageBox.YESNOCANCEL,
									msg: '<?php __('Remove'); ?> '+sel[0].data.name+'?',
									icon: Ext.MessageBox.QUESTION,
                                    fn: function(btn){
											if (btn == 'yes'){
													DeleteParentCashStore(sel[0].data.id);
											}
									}
							});
						} else {
							Ext.Msg.show({
									title: '<?php __('Remove CashStore'); ?>',
									buttons: Ext.MessageBox.YESNOCANCEL,
									msg: '<?php __('Remove the selected CashStore'); ?>?',
									icon: Ext.MessageBox.QUESTION,
                                    fn: function(btn){
											if (btn == 'yes'){
													var sel_ids = '';
													for(i=0;i<sel.length;i++){
														if(i>0)
															sel_ids += '_';
														sel_ids += sel[i].data.id;
													}
													DeleteParentCashStore(sel_ids);
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
				text: '<?php __('View cash indeminity'); ?>',
				id: 'view-cashStore2',
				tooltip:'<?php __('<b>View CashStore</b><br />Click here to see details of the selected CashStore'); ?>',
				icon: 'img/table_view.png',
				cls: 'x-btn-text-icon',
				disabled: true,
				handler: function(btn) {
					var sm = g.getSelectionModel();
					var sel = sm.getSelected();
					if (sm.hasSelection()){
						ViewCashStore(sel.data.id);
					};
				},
				menu : {
					items: [
					]
				}

            }, ' ', '->', {
				xtype: 'textfield',
				emptyText: '<?php __('[Search By Name]'); ?>',
				id: 'parent_cashStore_search_field',
				listeners: {
					specialkey: function(field, e){
						if (e.getKey() == e.ENTER) {
							SearchByParentCashStoreName(Ext.getCmp('parent_cashStore_search_field').getValue());
						}
					}

				}
			}, {
				xtype: 'tbbutton',
				icon: 'img/search.png',
				cls: 'x-btn-text-icon',
				text: 'GO',
				tooltip:'<?php __('<b>GO</b><br />Click here to get search results'); ?>',
				id: 'parent_cashStore_go_button',
				handler: function(){
					SearchByParentCashStoreName(Ext.getCmp('parent_cashStore_search_field').getValue());
				}
			}, ' '
	]}),
	bbar: new Ext.PagingToolbar({
		pageSize: list_size,
		store: store_parent_cashStores,
		displayInfo: true,
		displayMsg: '<?php __('Displaying {0} - {1} of {2}'); ?>',
		beforePageText: '<?php __('Page'); ?>',
		afterPageText: '<?php __('of {0}'); ?>',
		emptyMsg: '<?php __('No data to display'); ?>'
	})
});
g.getSelectionModel().on('rowselect', function(sm, rowIdx, r) {
	g.getTopToolbar().findById('edit-parent-cashStore').enable();
	g.getTopToolbar().findById('delete-parent-cashStore').enable();
        g.getTopToolbar().findById('view-cashStore2').enable();
	if(this.getSelections().length > 1){
		g.getTopToolbar().findById('edit-parent-cashStore').disable();
                g.getTopToolbar().findById('view-cashStore2').disable();
	}
});
g.getSelectionModel().on('rowdeselect', function(sm, rowIdx, r) {
	if(this.getSelections().length > 1){
		g.getTopToolbar().findById('edit-parent-cashStore').disable();
		g.getTopToolbar().findById('delete-parent-cashStore').enable();
                g.getTopToolbar().findById('view-cashStore2').disable();
	}
	else if(this.getSelections().length == 1){
		g.getTopToolbar().findById('edit-parent-cashStore').enable();
		g.getTopToolbar().findById('delete-parent-cashStore').enable();
                g.getTopToolbar().findById('view-cashStore2').enable();
	}
	else{
		g.getTopToolbar().findById('edit-parent-cashStore').disable();
		g.getTopToolbar().findById('delete-parent-cashStore').disable();
                g.getTopToolbar().findById('view-cashStore2').disable();
	}
});



var parentCashStoresViewWindow = new Ext.Window({
	title: 'Cash Indeminityfor the Selected employee',
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
			parentCashStoresViewWindow.close();
		}
	}]
});

store_parent_cashStores.load({
    params: {
        start: 0,    
        limit: list_size
    }
});