var store_parent_leaseTransactions = new Ext.data.Store({
	reader: new Ext.data.JsonReader({
		root:'rows',
		totalProperty: 'results',
		fields: [
			'id','lease','month','payment','disount_factor','npv','lease_liability','interest_charge','asset_nbv_bfwd','amortization','asset_nbv_cfwd'	
		]
	}),
	proxy: new Ext.data.HttpProxy({
		url: '<?php echo $this->Html->url(array('controller' => 'leaseTransactions', 'action' => 'list_data', $parent_id)); ?>'	})
});


function AddParentLeaseTransaction() {
	Ext.Ajax.request({
		url: '<?php echo $this->Html->url(array('controller' => 'leaseTransactions', 'action' => 'add', $parent_id)); ?>',
		success: function(response, opts) {
			var parent_leaseTransaction_data = response.responseText;
			
			eval(parent_leaseTransaction_data);
			
			LeaseTransactionAddWindow.show();
		},
		failure: function(response, opts) {
			Ext.Msg.alert('<?php __('Error'); ?>', '<?php __('Cannot get the leaseTransaction add form. Error code'); ?>: ' + response.status);
		}
	});
}

function EditParentLeaseTransaction(id) {
	Ext.Ajax.request({
		url: '<?php echo $this->Html->url(array('controller' => 'leaseTransactions', 'action' => 'edit')); ?>/'+id+'/<?php echo $parent_id; ?>',
		success: function(response, opts) {
			var parent_leaseTransaction_data = response.responseText;
			
			eval(parent_leaseTransaction_data);
			
			LeaseTransactionEditWindow.show();
		},
		failure: function(response, opts) {
			Ext.Msg.alert('<?php __('Error'); ?>', '<?php __('Cannot get the leaseTransaction edit form. Error code'); ?>: ' + response.status);
		}
	});
}

function ViewLeaseTransaction(id) {
	Ext.Ajax.request({
		url: '<?php echo $this->Html->url(array('controller' => 'leaseTransactions', 'action' => 'view')); ?>/'+id,
		success: function(response, opts) {
			var leaseTransaction_data = response.responseText;

			eval(leaseTransaction_data);

			LeaseTransactionViewWindow.show();
		},
		failure: function(response, opts) {
			Ext.Msg.alert('<?php __('Error'); ?>', '<?php __('Cannot get the leaseTransaction view form. Error code'); ?>: ' + response.status);
		}
	});
}


function DeleteParentLeaseTransaction(id) {
	Ext.Ajax.request({
		url: '<?php echo $this->Html->url(array('controller' => 'leaseTransactions', 'action' => 'delete')); ?>/'+id,
		success: function(response, opts) {
			Ext.Msg.alert('<?php __('Success'); ?>', '<?php __('LeaseTransaction(s) successfully deleted!'); ?>');
			RefreshParentLeaseTransactionData();
		},
		failure: function(response, opts) {
			Ext.Msg.alert('<?php __('Error'); ?>', '<?php __('Cannot get the leaseTransaction to be deleted. Error code'); ?>: ' + response.status);
		}
	});
}

function SearchByParentLeaseTransactionName(value){
	var conditions = '\'LeaseTransaction.name LIKE\' => \'%' + value + '%\'';
	store_parent_leaseTransactions.reload({
		 params: {
			start: 0,
			limit: list_size,
			conditions: conditions
	    }
	});
}

function RefreshParentLeaseTransactionData() {
	store_parent_leaseTransactions.reload();
}



var g = new Ext.grid.GridPanel({
	title: '<?php __('LeaseTransactions'); ?>',
	store: store_parent_leaseTransactions,
	loadMask: true,
	stripeRows: true,
	height: 300,
	anchor: '100%',
    id: 'leaseTransactionGrid',
	columns: [
		{header:"<?php __('lease'); ?>", dataIndex: 'lease', sortable: true},
		{header: "<?php __('Month'); ?>", dataIndex: 'month', sortable: true},
		{header: "<?php __('Payment'); ?>", dataIndex: 'payment', sortable: true},
		{header: "<?php __('Disount Factor'); ?>", dataIndex: 'disount_factor', sortable: true},
		{header: "<?php __('Npv'); ?>", dataIndex: 'npv', sortable: true},
		{header: "<?php __('Lease Liability'); ?>", dataIndex: 'lease_liability', sortable: true},
		{header: "<?php __('Interest Charge'); ?>", dataIndex: 'interest_charge', sortable: true},
		{header: "<?php __('Asset Nbv Bfwd'); ?>", dataIndex: 'asset_nbv_bfwd', sortable: true},
		{header: "<?php __('Amortization'); ?>", dataIndex: 'amortization', sortable: true},
		{header: "<?php __('Asset Nbv Cfwd'); ?>", dataIndex: 'asset_nbv_cfwd', sortable: true}	],
	sm: new Ext.grid.RowSelectionModel({
		singleSelect: false
	}),
	viewConfig: {
		forceFit: true
	},
    listeners: {
        celldblclick: function(){
            ViewLeaseTransaction(Ext.getCmp('leaseTransactionGrid').getSelectionModel().getSelected().data.id);
        }
    },
	tbar: new Ext.Toolbar({
		items: [{
				xtype: 'tbbutton',
				text: '<?php __('Add'); ?>',
				tooltip:'<?php __('<b>Add LeaseTransaction</b><br />Click here to create a new LeaseTransaction'); ?>',
				icon: 'img/table_add.png',
				cls: 'x-btn-text-icon',
				handler: function(btn) {
					AddParentLeaseTransaction();
				}
			}, ' ', '-', ' ', {
				xtype: 'tbbutton',
				text: '<?php __('Edit'); ?>',
				id: 'edit-parent-leaseTransaction',
				tooltip:'<?php __('<b>Edit LeaseTransaction</b><br />Click here to modify the selected LeaseTransaction'); ?>',
				icon: 'img/table_edit.png',
				cls: 'x-btn-text-icon',
				disabled: true,
				handler: function(btn) {
					var sm = g.getSelectionModel();
					var sel = sm.getSelected();
					if (sm.hasSelection()){
						EditParentLeaseTransaction(sel.data.id);
					};
				}
			}, ' ', '-', ' ', {
				xtype: 'tbbutton',
				text: '<?php __('Delete'); ?>',
				id: 'delete-parent-leaseTransaction',
				tooltip:'<?php __('<b>Delete LeaseTransaction(s)</b><br />Click here to remove the selected LeaseTransaction(s)'); ?>',
				icon: 'img/table_delete.png',
				cls: 'x-btn-text-icon',
				disabled: true,
				handler: function(btn) {
					var sm = g.getSelectionModel();
					var sel = sm.getSelections();
					if (sm.hasSelection()){
						if(sel.length==1){
							Ext.Msg.show({
									title: '<?php __('Remove LeaseTransaction'); ?>',
									buttons: Ext.MessageBox.YESNOCANCEL,
									msg: '<?php __('Remove'); ?> '+sel[0].data.name+'?',
									icon: Ext.MessageBox.QUESTION,
                                    fn: function(btn){
											if (btn == 'yes'){
													DeleteParentLeaseTransaction(sel[0].data.id);
											}
									}
							});
						} else {
							Ext.Msg.show({
									title: '<?php __('Remove LeaseTransaction'); ?>',
									buttons: Ext.MessageBox.YESNOCANCEL,
									msg: '<?php __('Remove the selected LeaseTransaction'); ?>?',
									icon: Ext.MessageBox.QUESTION,
                                    fn: function(btn){
											if (btn == 'yes'){
													var sel_ids = '';
													for(i=0;i<sel.length;i++){
														if(i>0)
															sel_ids += '_';
														sel_ids += sel[i].data.id;
													}
													DeleteParentLeaseTransaction(sel_ids);
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
				text: '<?php __('View LeaseTransaction'); ?>',
				id: 'view-leaseTransaction2',
				tooltip:'<?php __('<b>View LeaseTransaction</b><br />Click here to see details of the selected LeaseTransaction'); ?>',
				icon: 'img/table_view.png',
				cls: 'x-btn-text-icon',
				disabled: true,
				handler: function(btn) {
					var sm = g.getSelectionModel();
					var sel = sm.getSelected();
					if (sm.hasSelection()){
						ViewLeaseTransaction(sel.data.id);
					};
				},
				menu : {
					items: [
					]
				}

            }, ' ', '->', {
				xtype: 'textfield',
				emptyText: '<?php __('[Search By Name]'); ?>',
				id: 'parent_leaseTransaction_search_field',
				listeners: {
					specialkey: function(field, e){
						if (e.getKey() == e.ENTER) {
							SearchByParentLeaseTransactionName(Ext.getCmp('parent_leaseTransaction_search_field').getValue());
						}
					}

				}
			}, {
				xtype: 'tbbutton',
				icon: 'img/search.png',
				cls: 'x-btn-text-icon',
				text: 'GO',
				tooltip:'<?php __('<b>GO</b><br />Click here to get search results'); ?>',
				id: 'parent_leaseTransaction_go_button',
				handler: function(){
					SearchByParentLeaseTransactionName(Ext.getCmp('parent_leaseTransaction_search_field').getValue());
				}
			}, ' '
	]}),
	bbar: new Ext.PagingToolbar({
		pageSize: list_size,
		store: store_parent_leaseTransactions,
		displayInfo: true,
		displayMsg: '<?php __('Displaying {0} - {1} of {2}'); ?>',
		beforePageText: '<?php __('Page'); ?>',
		afterPageText: '<?php __('of {0}'); ?>',
		emptyMsg: '<?php __('No data to display'); ?>'
	})
});
g.getSelectionModel().on('rowselect', function(sm, rowIdx, r) {
	g.getTopToolbar().findById('edit-parent-leaseTransaction').enable();
	g.getTopToolbar().findById('delete-parent-leaseTransaction').enable();
        g.getTopToolbar().findById('view-leaseTransaction2').enable();
	if(this.getSelections().length > 1){
		g.getTopToolbar().findById('edit-parent-leaseTransaction').disable();
                g.getTopToolbar().findById('view-leaseTransaction2').disable();
	}
});
g.getSelectionModel().on('rowdeselect', function(sm, rowIdx, r) {
	if(this.getSelections().length > 1){
		g.getTopToolbar().findById('edit-parent-leaseTransaction').disable();
		g.getTopToolbar().findById('delete-parent-leaseTransaction').enable();
                g.getTopToolbar().findById('view-leaseTransaction2').disable();
	}
	else if(this.getSelections().length == 1){
		g.getTopToolbar().findById('edit-parent-leaseTransaction').enable();
		g.getTopToolbar().findById('delete-parent-leaseTransaction').enable();
                g.getTopToolbar().findById('view-leaseTransaction2').enable();
	}
	else{
		g.getTopToolbar().findById('edit-parent-leaseTransaction').disable();
		g.getTopToolbar().findById('delete-parent-leaseTransaction').disable();
                g.getTopToolbar().findById('view-leaseTransaction2').disable();
	}
});



var parentLeaseTransactionsViewWindow = new Ext.Window({
	title: 'LeaseTransaction Under the selected Item',
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
			parentLeaseTransactionsViewWindow.close();
		}
	}]
});

store_parent_leaseTransactions.load({
    params: {
        start: 0,    
        limit: list_size
    }
});