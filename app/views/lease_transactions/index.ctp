
var store_leaseTransactions = new Ext.data.GroupingStore({
	reader: new Ext.data.JsonReader({
		root:'rows',
		totalProperty: 'results',
		fields: [
			'id','lease','month','payment','disount_factor','npv','lease_liability','interest_charge','asset_nbv_bfwd','amortization','asset_nbv_cfwd'		]
	}),
	proxy: new Ext.data.HttpProxy({
		url: '<?php echo $this->Html->url(array('controller' => 'leaseTransactions', 'action' => 'list_data')); ?>'
	})
});


function AddLeaseTransaction() {
	Ext.Ajax.request({
		url: '<?php echo $this->Html->url(array('controller' => 'leaseTransactions', 'action' => 'add')); ?>',
		success: function(response, opts) {
			var leaseTransaction_data = response.responseText;
			
			eval(leaseTransaction_data);
			
			LeaseTransactionAddWindow.show();
		},
		failure: function(response, opts) {
			Ext.Msg.alert('<?php __('Error'); ?>', '<?php __('Cannot get the leaseTransaction add form. Error code'); ?>: ' + response.status);
		}
	});
}

function EditLeaseTransaction(id) {
	Ext.Ajax.request({
		url: '<?php echo $this->Html->url(array('controller' => 'leaseTransactions', 'action' => 'edit')); ?>/'+id,
		success: function(response, opts) {
			var leaseTransaction_data = response.responseText;
			
			eval(leaseTransaction_data);
			
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

function DeleteLeaseTransaction(id) {
	Ext.Ajax.request({
		url: '<?php echo $this->Html->url(array('controller' => 'leaseTransactions', 'action' => 'delete')); ?>/'+id,
		success: function(response, opts) {
			Ext.Msg.alert('<?php __('Success'); ?>', '<?php __('LeaseTransaction successfully deleted!'); ?>');
			RefreshLeaseTransactionData();
		},
		failure: function(response, opts) {
			Ext.Msg.alert('<?php __('Error'); ?>', '<?php __('Cannot get the leaseTransaction add form. Error code'); ?>: ' + response.status);
		}
	});
}

function SearchLeaseTransaction(){
	Ext.Ajax.request({
		url: '<?php echo $this->Html->url(array('controller' => 'leaseTransactions', 'action' => 'search')); ?>',
		success: function(response, opts){
			var leaseTransaction_data = response.responseText;

			eval(leaseTransaction_data);

			leaseTransactionSearchWindow.show();
		},
		failure: function(response, opts) {
			Ext.Msg.alert('<?php __('Error'); ?>','<?php __('Cannot get the leaseTransaction search form. Error Code'); ?>: ' + response.status);
		}
	});
}

function SearchByLeaseTransactionName(value){
	var conditions = '\'LeaseTransaction.name LIKE\' => \'%' + value + '%\'';
	store_leaseTransactions.reload({
		 params: {
			start: 0,
			limit: list_size,
			conditions: conditions
	    }
	});
}

function RefreshLeaseTransactionData() {
	store_leaseTransactions.reload();
}


if(center_panel.find('id', 'leaseTransaction-tab') != "") {
	var p = center_panel.findById('leaseTransaction-tab');
	center_panel.setActiveTab(p);
} else {
	var p = center_panel.add({
		title: '<?php __('Lease Transactions'); ?>',
		closable: true,
		loadMask: true,
		stripeRows: true,
		id: 'leaseTransaction-tab',
		xtype: 'grid',
		store: store_leaseTransactions,
		columns: [
			{header: "<?php __('Lease'); ?>", dataIndex: 'lease', sortable: true},
			{header: "<?php __('Month'); ?>", dataIndex: 'month', sortable: true},
			{header: "<?php __('Payment'); ?>", dataIndex: 'payment', sortable: true},
			{header: "<?php __('Disount Factor'); ?>", dataIndex: 'disount_factor', sortable: true},
			{header: "<?php __('Npv'); ?>", dataIndex: 'npv', sortable: true},
			{header: "<?php __('Lease Liability'); ?>", dataIndex: 'lease_liability', sortable: true},
			{header: "<?php __('Interest Charge'); ?>", dataIndex: 'interest_charge', sortable: true},
			{header: "<?php __('Asset Nbv Bfwd'); ?>", dataIndex: 'asset_nbv_bfwd', sortable: true},
			{header: "<?php __('Amortization'); ?>", dataIndex: 'amortization', sortable: true},
			{header: "<?php __('Asset Nbv Cfwd'); ?>", dataIndex: 'asset_nbv_cfwd', sortable: true}
		],
		
		view: new Ext.grid.GroupingView({
            forceFit:true,
            groupTextTpl: '{text} ({[values.rs.length]} {[values.rs.length > 1 ? "LeaseTransactions" : "LeaseTransaction"]})'
        })
,
		listeners: {
			celldblclick: function(){
				ViewLeaseTransaction(Ext.getCmp('leaseTransaction-tab').getSelectionModel().getSelected().data.id);
			}
		},
		sm: new Ext.grid.RowSelectionModel({
			singleSelect: false
		}),
		tbar: new Ext.Toolbar({
			
			items: [{
					xtype: 'tbbutton',
					text: '<?php __('Add'); ?>',
					tooltip:'<?php __('<b>Add LeaseTransactions</b><br />Click here to create a new LeaseTransaction'); ?>',
					icon: 'img/table_add.png',
					cls: 'x-btn-text-icon',
					handler: function(btn) {
						AddLeaseTransaction();
					}
				}, ' ', '-', ' ', {
					xtype: 'tbbutton',
					text: '<?php __('Edit'); ?>',
					id: 'edit-leaseTransaction',
					tooltip:'<?php __('<b>Edit LeaseTransactions</b><br />Click here to modify the selected LeaseTransaction'); ?>',
					icon: 'img/table_edit.png',
					cls: 'x-btn-text-icon',
					disabled: true,
					handler: function(btn) {
						var sm = p.getSelectionModel();
						var sel = sm.getSelected();
						if (sm.hasSelection()){
							EditLeaseTransaction(sel.data.id);
						};
					}
				}, ' ', '-', ' ', {
					xtype: 'tbbutton',
					text: '<?php __('Delete'); ?>',
					id: 'delete-leaseTransaction',
					tooltip:'<?php __('<b>Delete LeaseTransactions(s)</b><br />Click here to remove the selected LeaseTransaction(s)'); ?>',
					icon: 'img/table_delete.png',
					cls: 'x-btn-text-icon',
					disabled: true,
					handler: function(btn) {
						var sm = p.getSelectionModel();
						var sel = sm.getSelections();
						if (sm.hasSelection()){
							if(sel.length==1){
								Ext.Msg.show({
									title: '<?php __('Remove LeaseTransaction'); ?>',
									buttons: Ext.MessageBox.YESNO,
									msg: '<?php __('Remove'); ?> '+sel[0].data.name+'?',
									icon: Ext.MessageBox.QUESTION,
									fn: function(btn){
										if (btn == 'yes'){
											DeleteLeaseTransaction(sel[0].data.id);
										}
									}
								});
							}else{
								Ext.Msg.show({
									title: '<?php __('Remove LeaseTransaction'); ?>',
									buttons: Ext.MessageBox.YESNO,
									msg: '<?php __('Remove the selected LeaseTransactions'); ?>?',
									icon: Ext.MessageBox.QUESTION,
									fn: function(btn){
										if (btn == 'yes'){
											var sel_ids = '';
											for(i=0;i<sel.length;i++){
												if(i>0)
													sel_ids += '_';
												sel_ids += sel[i].data.id;
											}
											DeleteLeaseTransaction(sel_ids);
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
					text: '<?php __('View LeaseTransaction'); ?>',
					id: 'view-leaseTransaction',
					tooltip:'<?php __('<b>View LeaseTransaction</b><br />Click here to see details of the selected LeaseTransaction'); ?>',
					icon: 'img/table_view.png',
					cls: 'x-btn-text-icon',
					disabled: true,
					handler: function(btn) {
						var sm = p.getSelectionModel();
						var sel = sm.getSelected();
						if (sm.hasSelection()){
							ViewLeaseTransaction(sel.data.id);
						};
					},
					menu : {
						items: [
						]
					}
				}, ' ', '-',  '<?php __('Lease'); ?>: ', {
					xtype : 'combo',
					emptyText: 'All',
					store : new Ext.data.ArrayStore({
						fields : ['id', 'name'],
						data : [
							['-1', 'All'],
							<?php $st = false;foreach ($leases as $item){if($st) echo ",
							";?>['<?php echo $item['Lease']['id']; ?>' ,'<?php echo $item['Lease']['name']; ?>']<?php $st = true;}?>						]
					}),
					displayField : 'name',
					valueField : 'id',
					mode : 'local',
					value : '-1',
					disableKeyFilter : true,
					triggerAction: 'all',
					listeners : {
						select : function(combo, record, index){
							store_leaseTransactions.reload({
								params: {
									start: 0,
									limit: list_size,
									lease_id : combo.getValue()
								}
							});
						}
					}
				},
 '->', {
					xtype: 'textfield',
					emptyText: '<?php __('[Search By Name]'); ?>',
					id: 'leaseTransaction_search_field',
					listeners: {
						specialkey: function(field, e){
							if (e.getKey() == e.ENTER) {
								SearchByLeaseTransactionName(Ext.getCmp('leaseTransaction_search_field').getValue());
							}
						}
					}
				}, {
					xtype: 'tbbutton',
					icon: 'img/search.png',
					cls: 'x-btn-text-icon',
					text: '<?php __('GO'); ?>',
                    tooltip:'<?php __('<b>GO</b><br />Click here to get search results'); ?>',
					id: 'leaseTransaction_go_button',
					handler: function(){
						SearchByLeaseTransactionName(Ext.getCmp('leaseTransaction_search_field').getValue());
					}
				}, '-', {
					xtype: 'tbbutton',
					icon: 'img/table_search.png',
					cls: 'x-btn-text-icon',
					text: '<?php __('Advanced Search'); ?>',
                    tooltip:'<?php __('<b>Advanced Search...</b><br />Click here to get the advanced search form'); ?>',
					handler: function(){
						SearchLeaseTransaction();
					}
				}
		]}),
		bbar: new Ext.PagingToolbar({
			pageSize: list_size,
			store: store_leaseTransactions,
			displayInfo: true,
			displayMsg: '<?php __('Displaying {0} - {1} of {2}'); ?>',
			beforePageText: '<?php __('Page'); ?>',
			afterPageText: '<?php __('of {0}'); ?>',
			emptyMsg: '<?php __('No data to display'); ?>'
		})
	});
	p.getSelectionModel().on('rowselect', function(sm, rowIdx, r) {
		p.getTopToolbar().findById('edit-leaseTransaction').enable();
		p.getTopToolbar().findById('delete-leaseTransaction').enable();
		p.getTopToolbar().findById('view-leaseTransaction').enable();
		if(this.getSelections().length > 1){
			p.getTopToolbar().findById('edit-leaseTransaction').disable();
			p.getTopToolbar().findById('view-leaseTransaction').disable();
		}
	});
	p.getSelectionModel().on('rowdeselect', function(sm, rowIdx, r) {
		if(this.getSelections().length > 1){
			p.getTopToolbar().findById('edit-leaseTransaction').disable();
			p.getTopToolbar().findById('view-leaseTransaction').disable();
			p.getTopToolbar().findById('delete-leaseTransaction').enable();
		}
		else if(this.getSelections().length == 1){
			p.getTopToolbar().findById('edit-leaseTransaction').enable();
			p.getTopToolbar().findById('view-leaseTransaction').enable();
			p.getTopToolbar().findById('delete-leaseTransaction').enable();
		}
		else{
			p.getTopToolbar().findById('edit-leaseTransaction').disable();
			p.getTopToolbar().findById('view-leaseTransaction').disable();
			p.getTopToolbar().findById('delete-leaseTransaction').disable();
		}
	});
	center_panel.setActiveTab(p);
	
	store_leaseTransactions.load({
		params: {
			start: 0,          
			limit: list_size
		}
	});
	
}
