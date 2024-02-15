
var store_leases = new Ext.data.GroupingStore({
	reader: new Ext.data.JsonReader({
		root:'rows',
		totalProperty: 'results',
		fields: [
			'id','name','branch_code','contract_years','start_date','end_date','total_amount','paid_years','paid_amount','rent_amount','expensed','is_lease','discount','gl_balance','rem_year_payment'		]
	}),
	proxy: new Ext.data.HttpProxy({
		url: '<?php echo $this->Html->url(array('controller' => 'leases', 'action' => 'list_data')); ?>'
	})
,	sortInfo:{field: 'name', direction: "ASC"}
});

function CalculatForAllLease(){
	Ext.Ajax.request({
		url: '<?php echo $this->Html->url(array('controller' => 'leaseTransactions', 'action' => 'calculatall')); ?>',
		success: function(response, opts) {
			var lease_data = response.responseText;
			
			eval(lease_data);
			
			LeaseAddWindow.show();
		},
		failure: function(response, opts) {
			Ext.Msg.alert('<?php __('Error'); ?>', '<?php __('Cannot get the lease add form. Error code'); ?>: ' + response.status);
		}
	});
}
function AddLease() {
	Ext.Ajax.request({
		url: '<?php echo $this->Html->url(array('controller' => 'leases', 'action' => 'add')); ?>',
		success: function(response, opts) {
			var lease_data = response.responseText;
			
			eval(lease_data);
			
			LeaseAddWindow.show();
		},
		failure: function(response, opts) {
			Ext.Msg.alert('<?php __('Error'); ?>', '<?php __('Cannot get the lease add form. Error code'); ?>: ' + response.status);
		}
	});
}

function EditLease(id) {
	Ext.Ajax.request({
		url: '<?php echo $this->Html->url(array('controller' => 'leases', 'action' => 'edit')); ?>/'+id,
		success: function(response, opts) {
			var lease_data = response.responseText;
			
			eval(lease_data);
			
			LeaseEditWindow.show();
		},
		failure: function(response, opts) {
			Ext.Msg.alert('<?php __('Error'); ?>', '<?php __('Cannot get the lease edit form. Error code'); ?>: ' + response.status);
		}
	});
}

function ViewLease(id) {
    Ext.Ajax.request({
        url: '<?php echo $this->Html->url(array('controller' => 'leases', 'action' => 'view')); ?>/'+id,
        success: function(response, opts) {
            var lease_data = response.responseText;

            eval(lease_data);

            LeaseViewWindow.show();
        },
        failure: function(response, opts) {
            Ext.Msg.alert('<?php __('Error'); ?>', '<?php __('Cannot get the lease view form. Error code'); ?>: ' + response.status);
        }
    });
}
function ViewParentLeaseTransactions(id) {
    Ext.Ajax.request({
        url: '<?php echo $this->Html->url(array('controller' => 'leaseTransactions', 'action' => 'index2')); ?>/'+id,
        success: function(response, opts) {
            var parent_leaseTransactions_data = response.responseText;

            eval(parent_leaseTransactions_data);

            parentLeaseTransactionsViewWindow.show();
        },
        failure: function(response, opts) {
            Ext.Msg.alert('<?php __('Error'); ?>', '<?php __('Cannot get the campus view form. Error code'); ?>: ' + response.status);
        }
    });
}


function DeleteLease(id) {
	Ext.Ajax.request({
		url: '<?php echo $this->Html->url(array('controller' => 'leases', 'action' => 'delete')); ?>/'+id,
		success: function(response, opts) {
			Ext.Msg.alert('<?php __('Success'); ?>', '<?php __('Lease successfully deleted!'); ?>');
			RefreshLeaseData();
		},
		failure: function(response, opts) {
			Ext.Msg.alert('<?php __('Error'); ?>', '<?php __('Cannot get the lease add form. Error code'); ?>: ' + response.status);
		}
	});
}

function SearchLease(){
	Ext.Ajax.request({
		url: '<?php echo $this->Html->url(array('controller' => 'leases', 'action' => 'search')); ?>',
		success: function(response, opts){
			var lease_data = response.responseText;

			eval(lease_data);

			leaseSearchWindow.show();
		},
		failure: function(response, opts) {
			Ext.Msg.alert('<?php __('Error'); ?>','<?php __('Cannot get the lease search form. Error Code'); ?>: ' + response.status);
		}
	});
}

function SearchByLeaseName(value){
	var conditions = '\'Lease.name LIKE\' => \'%' + value + '%\'';
	store_leases.reload({
		 params: {
			start: 0,
			limit: list_size,
			conditions: conditions
	    }
	});
}

function RefreshLeaseData() {
	store_leases.reload();
}

function Calculat(id){
	
	Ext.Ajax.request({
		url: '<?php echo $this->Html->url(array('controller' => 'leaseTransactions', 'action' => 'calculat')); ?>/'+ id,
		success: function(response, opts) {
			var bpActual_data = response.responseText;

			eval(bpActual_data);

			BpActualAddWindow.show();
			
		},
		failure: function(response, opts) {
			Ext.Msg.alert('<?php __('Error'); ?>', '<?php __('Cannot get the bpActual to be deleted. Error code'); ?>: ' + response.status);
		}
	});
}


if(center_panel.find('id', 'lease-tab') != "") {
	var p = center_panel.findById('lease-tab');
	center_panel.setActiveTab(p);
} else {
	var p = center_panel.add({
		title: '<?php __('Leases'); ?>',
		closable: true,
		loadMask: true,
		stripeRows: true,
		id: 'lease-tab',
		xtype: 'grid',
		store: store_leases,
		columns: [
	     
			{header: "<?php __('Name'); ?>", dataIndex: 'name', sortable: true},
			{header: "<?php __('Branch Code'); ?>", dataIndex: 'branch_code', sortable: true},
			{header: "<?php __('Contract Years'); ?>", dataIndex: 'contract_years', sortable: true},
			{header: "<?php __('Start Date'); ?>", dataIndex: 'start_date', sortable: true},
			{header: "<?php __('End Date'); ?>", dataIndex: 'end_date', sortable: true},
			{header: "<?php __('Total Amount'); ?>", dataIndex: 'total_amount', sortable: true},
			{header: "<?php __('Paid Years'); ?>", dataIndex: 'paid_years', sortable: true},
			{header: "<?php __('Paid Amount'); ?>", dataIndex: 'paid_amount', sortable: true},
			{header: "<?php __('Rent Amount'); ?>", dataIndex: 'rent_amount', sortable: true},
			{header: "<?php __('Expensed'); ?>", dataIndex: 'expensed', sortable: true},
			{header: "<?php __('GL Balance'); ?>", dataIndex: 'gl_balance', sortable: true},
			{header: "<?php __('Is Lease'); ?>", dataIndex: 'is_lease', sortable: true},
			{header: "<?php __('Discount'); ?>", dataIndex: 'discount', sortable: true},
      {header: "<?php __('Rem Payment'); ?>", dataIndex: 'rem_year_payment', sortable: true}
		],
		
		view: new Ext.grid.GroupingView({
            forceFit:true,
            groupTextTpl: '{text} ({[values.rs.length]} {[values.rs.length > 1 ? "Leases" : "Lease"]})'
        })
,
		listeners: {
			celldblclick: function(){
				ViewLease(Ext.getCmp('lease-tab').getSelectionModel().getSelected().data.id);
			},
		'rowcontextmenu': function(grid,index,event){
			event.stopEvent();
			var record=grid.getStore().getAt(index);
			var menu = new Ext.menu.Menu({
            items: [
				{
                    text: '<b>Calculat</b>',
                    icon: 'img/table_edit.png',
                    handler: function() {
                        Calculat(record.get('id'));
                    },
                    disabled: false
                }
            ]
        }).showAt(event.xy);
		}
		},
		sm: new Ext.grid.RowSelectionModel({
			singleSelect: false
		}),
		tbar: new Ext.Toolbar({
			
			items: [{
					xtype: 'tbbutton',
					text: '<?php __('Add'); ?>',
					tooltip:'<?php __('<b>Add Leases</b><br />Click here to create a new Lease'); ?>',
					icon: 'img/table_add.png',
					cls: 'x-btn-text-icon',
					handler: function(btn) {
						AddLease();
					}
				}, ' ', '-', ' ',{
					xtype: 'tbbutton',
					text: '<?php __('Calculat for All'); ?>',
					tooltip:'<?php __('<b>Add Leases</b><br />Click here to calculat for all lease'); ?>',
					icon: 'img/table_add.png',
					cls: 'x-btn-text-icon',
					handler: function(btn) {
						CalculatForAllLease();
					}
				}, ' ', '-', ' ', {
					xtype: 'tbbutton',
					text: '<?php __('Edit'); ?>',
					id: 'edit-lease',
					tooltip:'<?php __('<b>Edit Leases</b><br />Click here to modify the selected Lease'); ?>',
					icon: 'img/table_edit.png',
					cls: 'x-btn-text-icon',
					disabled: true,
					handler: function(btn) {
						var sm = p.getSelectionModel();
						var sel = sm.getSelected();
						if (sm.hasSelection()){
							EditLease(sel.data.id);
						};
					}
				}, ' ', '-', ' ', {
					xtype: 'tbbutton',
					text: '<?php __('Delete'); ?>',
					id: 'delete-lease',
					tooltip:'<?php __('<b>Delete Leases(s)</b><br />Click here to remove the selected Lease(s)'); ?>',
					icon: 'img/table_delete.png',
					cls: 'x-btn-text-icon',
					disabled: true,
					handler: function(btn) {
						var sm = p.getSelectionModel();
						var sel = sm.getSelections();
						if (sm.hasSelection()){
							if(sel.length==1){
								Ext.Msg.show({
									title: '<?php __('Remove Lease'); ?>',
									buttons: Ext.MessageBox.YESNO,
									msg: '<?php __('Remove'); ?> '+sel[0].data.name+'?',
									icon: Ext.MessageBox.QUESTION,
									fn: function(btn){
										if (btn == 'yes'){
											DeleteLease(sel[0].data.id);
										}
									}
								});
							}else{
								Ext.Msg.show({
									title: '<?php __('Remove Lease'); ?>',
									buttons: Ext.MessageBox.YESNO,
									msg: '<?php __('Remove the selected Leases'); ?>?',
									icon: Ext.MessageBox.QUESTION,
									fn: function(btn){
										if (btn == 'yes'){
											var sel_ids = '';
											for(i=0;i<sel.length;i++){
												if(i>0)
													sel_ids += '_';
												sel_ids += sel[i].data.id;
											}
											DeleteLease(sel_ids);
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
					text: '<?php __('View Lease'); ?>',
					id: 'view-lease',
					tooltip:'<?php __('<b>View Lease</b><br />Click here to see details of the selected Lease'); ?>',
					icon: 'img/table_view.png',
					cls: 'x-btn-text-icon',
					disabled: true,
					handler: function(btn) {
						var sm = p.getSelectionModel();
						var sel = sm.getSelected();
						if (sm.hasSelection()){
							ViewLease(sel.data.id);
						};
					},
					menu : {
						items: [
{
							text: '<?php __('View Lease Transactions'); ?>',
                            icon: 'img/table_view.png',
							cls: 'x-btn-text-icon',
							handler: function(btn) {
								var sm = p.getSelectionModel();
								var sel = sm.getSelected();
								if (sm.hasSelection()){
									ViewParentLeaseTransactions(sel.data.id);
								};
							}
						}
						]
					}
				}, ' ', '-',  '->', {
					xtype: 'textfield',
					emptyText: '<?php __('[Search By Name]'); ?>',
					id: 'lease_search_field',
					listeners: {
						specialkey: function(field, e){
							if (e.getKey() == e.ENTER) {
								SearchByLeaseName(Ext.getCmp('lease_search_field').getValue());
							}
						}
					}
				}, {
					xtype: 'tbbutton',
					icon: 'img/search.png',
					cls: 'x-btn-text-icon',
					text: '<?php __('GO'); ?>',
                    tooltip:'<?php __('<b>GO</b><br />Click here to get search results'); ?>',
					id: 'lease_go_button',
					handler: function(){
						SearchByLeaseName(Ext.getCmp('lease_search_field').getValue());
					}
				}, '-', {
					xtype: 'tbbutton',
					icon: 'img/table_search.png',
					cls: 'x-btn-text-icon',
					text: '<?php __('Advanced Search'); ?>',
                    tooltip:'<?php __('<b>Advanced Search...</b><br />Click here to get the advanced search form'); ?>',
					handler: function(){
						SearchLease();
					}
				}
		]}),
		bbar: new Ext.PagingToolbar({
			pageSize: list_size,
			store: store_leases,
			displayInfo: true,
			displayMsg: '<?php __('Displaying {0} - {1} of {2}'); ?>',
			beforePageText: '<?php __('Page'); ?>',
			afterPageText: '<?php __('of {0}'); ?>',
			emptyMsg: '<?php __('No data to display'); ?>'
		})
	});
	p.getSelectionModel().on('rowselect', function(sm, rowIdx, r) {
		p.getTopToolbar().findById('edit-lease').enable();
		p.getTopToolbar().findById('delete-lease').enable();
		p.getTopToolbar().findById('view-lease').enable();
		if(this.getSelections().length > 1){
			p.getTopToolbar().findById('edit-lease').disable();
			p.getTopToolbar().findById('view-lease').disable();
		}
	});
	p.getSelectionModel().on('rowdeselect', function(sm, rowIdx, r) {
		if(this.getSelections().length > 1){
			p.getTopToolbar().findById('edit-lease').disable();
			p.getTopToolbar().findById('view-lease').disable();
			p.getTopToolbar().findById('delete-lease').enable();
		}
		else if(this.getSelections().length == 1){
			p.getTopToolbar().findById('edit-lease').enable();
			p.getTopToolbar().findById('view-lease').enable();
			p.getTopToolbar().findById('delete-lease').enable();
		}
		else{
			p.getTopToolbar().findById('edit-lease').disable();
			p.getTopToolbar().findById('view-lease').disable();
			p.getTopToolbar().findById('delete-lease').disable();
		}
	});
	center_panel.setActiveTab(p);
	
	store_leases.load({
		params: {
			start: 0,          
			limit: list_size
		}
	});
	
}
