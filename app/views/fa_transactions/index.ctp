
var store_faTransactions = new Ext.data.GroupingStore({
	reader: new Ext.data.JsonReader({
		root:'rows',
		totalProperty: 'results',
		fields: [
			'id','fa_asset','tax_depreciated_value','tax_book_value','ifrs_depreciated_value','ifrs_book_value','budget_year'		]
	}),
	proxy: new Ext.data.HttpProxy({
		url: '<?php echo $this->Html->url(array('controller' => 'faTransactions', 'action' => 'list_data')); ?>'
	})

});


function AddFaTransactionTAX() {
	Ext.Ajax.request({
		url: '<?php echo $this->Html->url(array('controller' => 'faTransactions', 'action' => 'add')); ?>',
		success: function(response, opts) {
			var faTransaction_data = response.responseText;
			
			eval(faTransaction_data);
			
			FaTransactionAddWindow.show();
		},
		failure: function(response, opts) {
			Ext.Msg.alert('<?php __('Error'); ?>', '<?php __('Cannot get the faTransaction add form. Error code'); ?>: ' + response.status);
		}
	});
}

function AddFaTransactionIFRS() {
	Ext.Ajax.request({
		url: '<?php echo $this->Html->url(array('controller' => 'faTransactions', 'action' => 'addifrs')); ?>',
		success: function(response, opts) {
			var faTransaction_data = response.responseText;
			
			eval(faTransaction_data);
			
			FaTransactionAddWindow.show();
		},
		failure: function(response, opts) {
			Ext.Msg.alert('<?php __('Error'); ?>', '<?php __('Cannot get the faTransaction add form. Error code'); ?>: ' + response.status);
		}
	});
}

function EditFaTransaction(id) {
	Ext.Ajax.request({
		url: '<?php echo $this->Html->url(array('controller' => 'faTransactions', 'action' => 'edit')); ?>/'+id,
		success: function(response, opts) {
			var faTransaction_data = response.responseText;
			
			eval(faTransaction_data);
			
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

function DeleteFaTransaction(id) {
	Ext.Ajax.request({
		url: '<?php echo $this->Html->url(array('controller' => 'faTransactions', 'action' => 'delete')); ?>/'+id,
		success: function(response, opts) {
			Ext.Msg.alert('<?php __('Success'); ?>', '<?php __('FaTransaction successfully deleted!'); ?>');
			RefreshFaTransactionData();
		},
		failure: function(response, opts) {
			Ext.Msg.alert('<?php __('Error'); ?>', '<?php __('Cannot get the faTransaction add form. Error code'); ?>: ' + response.status);
		}
	});
}

function SearchFaTransaction(){
	Ext.Ajax.request({
		url: '<?php echo $this->Html->url(array('controller' => 'faTransactions', 'action' => 'search')); ?>',
		success: function(response, opts){
			var faTransaction_data = response.responseText;

			eval(faTransaction_data);

			faTransactionSearchWindow.show();
		},
		failure: function(response, opts) {
			Ext.Msg.alert('<?php __('Error'); ?>','<?php __('Cannot get the faTransaction search form. Error Code'); ?>: ' + response.status);
		}
	});
}

function SearchByFaTransactionName(value){
	var conditions = '\'FaTransaction.name LIKE\' => \'%' + value + '%\'';
	store_faTransactions.reload({
		 params: {
			start: 0,
			limit: list_size,
			conditions: conditions
	    }
	});
}

function RefreshFaTransactionData() {
	store_faTransactions.reload();
}


if(center_panel.find('id', 'faTransaction-tab') != "") {
	var p = center_panel.findById('faTransaction-tab');
	center_panel.setActiveTab(p);
} else {
	var p = center_panel.add({
		title: '<?php __('Depreciation'); ?>',
		closable: true,
		loadMask: true,
		stripeRows: true,
		id: 'faTransaction-tab',
		xtype: 'grid',
		store: store_faTransactions,
		columns: [
			{header: "<?php __('FaAsset'); ?>", dataIndex: 'fa_asset', sortable: true},
			{header: "<?php __('Tax Depreciated Value'); ?>", dataIndex: 'tax_depreciated_value', sortable: true},
			{header: "<?php __('Tax Book Value'); ?>", dataIndex: 'tax_book_value', sortable: true},
			{header: "<?php __('Ifrs Depreciated Value'); ?>", dataIndex: 'ifrs_depreciated_value', sortable: true},
			{header: "<?php __('Ifrs Book Value'); ?>", dataIndex: 'ifrs_book_value', sortable: true},
			{header: "<?php __('BudgetYear'); ?>", dataIndex: 'budget_year', sortable: true}
		],
		
		view: new Ext.grid.GroupingView({
            forceFit:true,
            groupTextTpl: '{text} ({[values.rs.length]} {[values.rs.length > 1 ? "FaTransactions" : "FaTransaction"]})'
        })
,
		listeners: {
			celldblclick: function(){
				ViewFaTransaction(Ext.getCmp('faTransaction-tab').getSelectionModel().getSelected().data.id);
			}
		},
		sm: new Ext.grid.RowSelectionModel({
			singleSelect: false
		}),
		tbar: new Ext.Toolbar({
			
			items: [

			{
					xtype: 'tbbutton',
					text: '<?php __('Calculate Depreciation TAX'); ?>',
					tooltip:'<?php __('<b>Add FaTransactions</b><br />Click here to create a new FaTransaction'); ?>',
					icon: 'img/table_add.png',
					cls: 'x-btn-text-icon',
					handler: function(btn) {
						AddFaTransactionTAX();
					}
				}, ' ', '-', ' ',{
					xtype: 'tbbutton',
					text: '<?php __('Calculate Depreciation IFRS'); ?>',
					tooltip:'<?php __('<b>Add FaTransactions</b><br />Click here to create a new FaTransaction'); ?>',
					icon: 'img/table_add.png',
					cls: 'x-btn-text-icon',
					handler: function(btn) {
						AddFaTransactionIFRS();
					}
				}, ' ', '-', ' ', {
					xtype: 'tbsplit',
					text: '<?php __('View FaTransaction'); ?>',
					id: 'view-faTransaction',
					tooltip:'<?php __('<b>View FaTransaction</b><br />Click here to see details of the selected FaTransaction'); ?>',
					icon: 'img/table_view.png',
					cls: 'x-btn-text-icon',
					disabled: true,
					handler: function(btn) {
						var sm = p.getSelectionModel();
						var sel = sm.getSelected();
						if (sm.hasSelection()){
							ViewFaTransaction(sel.data.id);
						};
					},
					menu : {
						items: [
						]
					}
				}, ' ', '-',  '<?php __('Budget Year'); ?>: ', {
					xtype : 'combo',
					emptyText: 'All',
					store : new Ext.data.ArrayStore({
						fields : ['id', 'name'],
						data : [
							['-1', 'All'],
							<?php $st = false;foreach ($budget_years as $item){if($st) echo ",
							";?>['<?php echo $item['BudgetYear']['id']; ?>' ,'<?php echo $item['BudgetYear']['name']; ?>']<?php $st = true;}?>						]
					}),
					displayField : 'name',
					valueField : 'id',
					mode : 'local',
					value : '-1',
					disableKeyFilter : true,
					triggerAction: 'all',
					listeners : {
						select : function(combo, record, index){
							store_faTransactions.reload({
								params: {
									start: 0,
									limit: list_size,
									budgetyear_id : combo.getValue()
								}
							});
						}
					}
				},
 '->', {
					xtype: 'textfield',
					emptyText: '<?php __('[Search By Name]'); ?>',
					id: 'faTransaction_search_field',
					listeners: {
						specialkey: function(field, e){
							if (e.getKey() == e.ENTER) {
								SearchByFaTransactionName(Ext.getCmp('faTransaction_search_field').getValue());
							}
						}
					}
				}, {
					xtype: 'tbbutton',
					icon: 'img/search.png',
					cls: 'x-btn-text-icon',
					text: '<?php __('GO'); ?>',
                    tooltip:'<?php __('<b>GO</b><br />Click here to get search results'); ?>',
					id: 'faTransaction_go_button',
					handler: function(){
						SearchByFaTransactionName(Ext.getCmp('faTransaction_search_field').getValue());
					}
				}, '-', {
					xtype: 'tbbutton',
					icon: 'img/table_search.png',
					cls: 'x-btn-text-icon',
					text: '<?php __('Advanced Search'); ?>',
                    tooltip:'<?php __('<b>Advanced Search...</b><br />Click here to get the advanced search form'); ?>',
					handler: function(){
						SearchFaTransaction();
					}
				}
		]}),
		bbar: new Ext.PagingToolbar({
			pageSize: list_size,
			store: store_faTransactions,
			displayInfo: true,
			displayMsg: '<?php __('Displaying {0} - {1} of {2}'); ?>',
			beforePageText: '<?php __('Page'); ?>',
			afterPageText: '<?php __('of {0}'); ?>',
			emptyMsg: '<?php __('No data to display'); ?>'
		})
	});
	p.getSelectionModel().on('rowselect', function(sm, rowIdx, r) {
		p.getTopToolbar().findById('edit-faTransaction').enable();
		p.getTopToolbar().findById('delete-faTransaction').enable();
		p.getTopToolbar().findById('view-faTransaction').enable();
		if(this.getSelections().length > 1){
			p.getTopToolbar().findById('edit-faTransaction').disable();
			p.getTopToolbar().findById('view-faTransaction').disable();
		}
	});
	p.getSelectionModel().on('rowdeselect', function(sm, rowIdx, r) {
		if(this.getSelections().length > 1){
			p.getTopToolbar().findById('edit-faTransaction').disable();
			p.getTopToolbar().findById('view-faTransaction').disable();
			p.getTopToolbar().findById('delete-faTransaction').enable();
		}
		else if(this.getSelections().length == 1){
			p.getTopToolbar().findById('edit-faTransaction').enable();
			p.getTopToolbar().findById('view-faTransaction').enable();
			p.getTopToolbar().findById('delete-faTransaction').enable();
		}
		else{
			p.getTopToolbar().findById('edit-faTransaction').disable();
			p.getTopToolbar().findById('view-faTransaction').disable();
			p.getTopToolbar().findById('delete-faTransaction').disable();
		}
	});
	center_panel.setActiveTab(p);
	
	store_faTransactions.load({
		params: {
			start: 0,          
			limit: list_size
		}
	});
	
}
