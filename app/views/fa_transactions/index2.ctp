var store_parent_faTransactions = new Ext.data.Store({
	reader: new Ext.data.JsonReader({
		root:'rows',
		totalProperty: 'results',
		fields: [
			'id','fa_asset','tax_depreciated_value','tax_book_value','ifrs_depreciated_value','ifrs_book_value','budget_year'	
		]
	}),
	proxy: new Ext.data.HttpProxy({
		url: '<?php echo $this->Html->url(array('controller' => 'faTransactions', 'action' => 'list_data', $parent_id)); ?>'	})
});


function AddParentFaTransaction() {
	Ext.Ajax.request({
		url: '<?php echo $this->Html->url(array('controller' => 'faTransactions', 'action' => 'add', $parent_id)); ?>',
		success: function(response, opts) {
			var parent_faTransaction_data = response.responseText;
			
			eval(parent_faTransaction_data);
			
			FaTransactionAddWindow.show();
		},
		failure: function(response, opts) {
			Ext.Msg.alert('<?php __('Error'); ?>', '<?php __('Cannot get the faTransaction add form. Error code'); ?>: ' + response.status);
		}
	});
}

function EditParentFaTransaction(id) {
	Ext.Ajax.request({
		url: '<?php echo $this->Html->url(array('controller' => 'faTransactions', 'action' => 'edit')); ?>/'+id+'/<?php echo $parent_id; ?>',
		success: function(response, opts) {
			var parent_faTransaction_data = response.responseText;
			
			eval(parent_faTransaction_data);
			
			FaTransactionEditWindow.show();
		},
		failure: function(response, opts) {
			Ext.Msg.alert('<?php __('Error'); ?>', '<?php __('Cannot get the faTransaction edit form. Error code'); ?>: ' + response.status);
		}
	});
}

function ViewFaTransaction(id) {
	Ext.Ajax.request({
		url: '<?php echo $this->Html->url(array('controller' => 'faTransactions', 'action' => 'view')); ?>/'+id,
		success: function(response, opts) {
			var faTransaction_data = response.responseText;

			eval(faTransaction_data);

			FaTransactionViewWindow.show();
		},
		failure: function(response, opts) {
			Ext.Msg.alert('<?php __('Error'); ?>', '<?php __('Cannot get the faTransaction view form. Error code'); ?>: ' + response.status);
		}
	});
}


function DeleteParentFaTransaction(id) {
	Ext.Ajax.request({
		url: '<?php echo $this->Html->url(array('controller' => 'faTransactions', 'action' => 'delete')); ?>/'+id,
		success: function(response, opts) {
			Ext.Msg.alert('<?php __('Success'); ?>', '<?php __('FaTransaction(s) successfully deleted!'); ?>');
			RefreshParentFaTransactionData();
		},
		failure: function(response, opts) {
			Ext.Msg.alert('<?php __('Error'); ?>', '<?php __('Cannot get the faTransaction to be deleted. Error code'); ?>: ' + response.status);
		}
	});
}

function SearchByParentFaTransactionName(value){
	var conditions = '\'FaTransaction.name LIKE\' => \'%' + value + '%\'';
	store_parent_faTransactions.reload({
		 params: {
			start: 0,
			limit: list_size,
			conditions: conditions
	    }
	});
}

function RefreshParentFaTransactionData() {
	store_parent_faTransactions.reload();
}



var g = new Ext.grid.GridPanel({
	title: '<?php __('FaTransactions'); ?>',
	store: store_parent_faTransactions,
	loadMask: true,
	stripeRows: true,
	height: 300,
	anchor: '100%',
    id: 'faTransactionGrid',
	columns: [
		{header:"<?php __('fa_asset'); ?>", dataIndex: 'fa_asset', sortable: true},
		{header: "<?php __('Tax Depreciated Value'); ?>", dataIndex: 'tax_depreciated_value', sortable: true},
		{header: "<?php __('Tax Book Value'); ?>", dataIndex: 'tax_book_value', sortable: true},
		{header: "<?php __('Ifrs Depreciated Value'); ?>", dataIndex: 'ifrs_depreciated_value', sortable: true},
		{header: "<?php __('Ifrs Book Value'); ?>", dataIndex: 'ifrs_book_value', sortable: true},
		{header:"<?php __('budget_year'); ?>", dataIndex: 'budget_year', sortable: true}	],
	sm: new Ext.grid.RowSelectionModel({
		singleSelect: false
	}),
	viewConfig: {
		forceFit: true
	},
    listeners: {
        celldblclick: function(){
            ViewFaTransaction(Ext.getCmp('faTransactionGrid').getSelectionModel().getSelected().data.id);
        }
    },
	tbar: new Ext.Toolbar({
		items: [{
				xtype: 'tbbutton',
				text: '<?php __('Add'); ?>',
				tooltip:'<?php __('<b>Add FaTransaction</b><br />Click here to create a new FaTransaction'); ?>',
				icon: 'img/table_add.png',
				cls: 'x-btn-text-icon',
				handler: function(btn) {
					AddParentFaTransaction();
				}
			}, ' ', '-', ' ', {
				xtype: 'tbbutton',
				text: '<?php __('Edit'); ?>',
				id: 'edit-parent-faTransaction',
				tooltip:'<?php __('<b>Edit FaTransaction</b><br />Click here to modify the selected FaTransaction'); ?>',
				icon: 'img/table_edit.png',
				cls: 'x-btn-text-icon',
				disabled: true,
				handler: function(btn) {
					var sm = g.getSelectionModel();
					var sel = sm.getSelected();
					if (sm.hasSelection()){
						EditParentFaTransaction(sel.data.id);
					};
				}
			}, ' ', '-', ' ', {
				xtype: 'tbbutton',
				text: '<?php __('Delete'); ?>',
				id: 'delete-parent-faTransaction',
				tooltip:'<?php __('<b>Delete FaTransaction(s)</b><br />Click here to remove the selected FaTransaction(s)'); ?>',
				icon: 'img/table_delete.png',
				cls: 'x-btn-text-icon',
				disabled: true,
				handler: function(btn) {
					var sm = g.getSelectionModel();
					var sel = sm.getSelections();
					if (sm.hasSelection()){
						if(sel.length==1){
							Ext.Msg.show({
									title: '<?php __('Remove FaTransaction'); ?>',
									buttons: Ext.MessageBox.YESNOCANCEL,
									msg: '<?php __('Remove'); ?> '+sel[0].data.name+'?',
									icon: Ext.MessageBox.QUESTION,
                                    fn: function(btn){
											if (btn == 'yes'){
													DeleteParentFaTransaction(sel[0].data.id);
											}
									}
							});
						} else {
							Ext.Msg.show({
									title: '<?php __('Remove FaTransaction'); ?>',
									buttons: Ext.MessageBox.YESNOCANCEL,
									msg: '<?php __('Remove the selected FaTransaction'); ?>?',
									icon: Ext.MessageBox.QUESTION,
                                    fn: function(btn){
											if (btn == 'yes'){
													var sel_ids = '';
													for(i=0;i<sel.length;i++){
														if(i>0)
															sel_ids += '_';
														sel_ids += sel[i].data.id;
													}
													DeleteParentFaTransaction(sel_ids);
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
				text: '<?php __('View FaTransaction'); ?>',
				id: 'view-faTransaction2',
				tooltip:'<?php __('<b>View FaTransaction</b><br />Click here to see details of the selected FaTransaction'); ?>',
				icon: 'img/table_view.png',
				cls: 'x-btn-text-icon',
				disabled: true,
				handler: function(btn) {
					var sm = g.getSelectionModel();
					var sel = sm.getSelected();
					if (sm.hasSelection()){
						ViewFaTransaction(sel.data.id);
					};
				},
				menu : {
					items: [
					]
				}

            }, ' ', '->', {
				xtype: 'textfield',
				emptyText: '<?php __('[Search By Name]'); ?>',
				id: 'parent_faTransaction_search_field',
				listeners: {
					specialkey: function(field, e){
						if (e.getKey() == e.ENTER) {
							SearchByParentFaTransactionName(Ext.getCmp('parent_faTransaction_search_field').getValue());
						}
					}

				}
			}, {
				xtype: 'tbbutton',
				icon: 'img/search.png',
				cls: 'x-btn-text-icon',
				text: 'GO',
				tooltip:'<?php __('<b>GO</b><br />Click here to get search results'); ?>',
				id: 'parent_faTransaction_go_button',
				handler: function(){
					SearchByParentFaTransactionName(Ext.getCmp('parent_faTransaction_search_field').getValue());
				}
			}, ' '
	]}),
	bbar: new Ext.PagingToolbar({
		pageSize: list_size,
		store: store_parent_faTransactions,
		displayInfo: true,
		displayMsg: '<?php __('Displaying {0} - {1} of {2}'); ?>',
		beforePageText: '<?php __('Page'); ?>',
		afterPageText: '<?php __('of {0}'); ?>',
		emptyMsg: '<?php __('No data to display'); ?>'
	})
});
g.getSelectionModel().on('rowselect', function(sm, rowIdx, r) {
	g.getTopToolbar().findById('edit-parent-faTransaction').enable();
	g.getTopToolbar().findById('delete-parent-faTransaction').enable();
        g.getTopToolbar().findById('view-faTransaction2').enable();
	if(this.getSelections().length > 1){
		g.getTopToolbar().findById('edit-parent-faTransaction').disable();
                g.getTopToolbar().findById('view-faTransaction2').disable();
	}
});
g.getSelectionModel().on('rowdeselect', function(sm, rowIdx, r) {
	if(this.getSelections().length > 1){
		g.getTopToolbar().findById('edit-parent-faTransaction').disable();
		g.getTopToolbar().findById('delete-parent-faTransaction').enable();
                g.getTopToolbar().findById('view-faTransaction2').disable();
	}
	else if(this.getSelections().length == 1){
		g.getTopToolbar().findById('edit-parent-faTransaction').enable();
		g.getTopToolbar().findById('delete-parent-faTransaction').enable();
                g.getTopToolbar().findById('view-faTransaction2').enable();
	}
	else{
		g.getTopToolbar().findById('edit-parent-faTransaction').disable();
		g.getTopToolbar().findById('delete-parent-faTransaction').disable();
                g.getTopToolbar().findById('view-faTransaction2').disable();
	}
});



var parentFaTransactionsViewWindow = new Ext.Window({
	title: 'FaTransaction Under the selected Item',
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
			parentFaTransactionsViewWindow.close();
		}
	}]
});

store_parent_faTransactions.load({
    params: {
        start: 0,    
        limit: list_size
    }
});