
var store_delegations = new Ext.data.GroupingStore({
	reader: new Ext.data.JsonReader({
		root:'rows',
		totalProperty: 'results',
		fields: [
			'id','employee','delegated','start','end','comment','created'		]
	}),
	proxy: new Ext.data.HttpProxy({
		url: '<?php echo $this->Html->url(array('controller' => 'delegations', 'action' => 'list_data')); ?>'
	})
});
		 var vstore_employee_names = new Ext.data.Store({
	reader: new Ext.data.JsonReader({
            root:'rows',
            fields: [
                'id', 'full_name','position'		
            ]
	}),
	proxy: new Ext.data.HttpProxy({
            url: '<?php echo $this->Html->url(array('controller' => 'employees', 'action' => 'search_emp')); ?>'
	}),	
        sortInfo:{field: 'full_name', direction: "ASC"}
    });
     /* vstore_employee_names.load({
            params: {
                start: 0
            }
        });*/

function AddDelegation() {
	Ext.Ajax.request({
		url: '<?php echo $this->Html->url(array('controller' => 'delegations', 'action' => 'add')); ?>',
		success: function(response, opts) {
			var delegation_data = response.responseText;
			
			eval(delegation_data);
			
			DelegationAddWindow.show();
		},
		failure: function(response, opts) {
			Ext.Msg.alert('<?php __('Error'); ?>', '<?php __('Cannot get the delegation add form. Error code'); ?>: ' + response.status);
		}
	});
}

function EditDelegation(id) {
	Ext.Ajax.request({
		url: '<?php echo $this->Html->url(array('controller' => 'delegations', 'action' => 'edit')); ?>/'+id,
		success: function(response, opts) {
			var delegation_data = response.responseText;
			
			eval(delegation_data);
			
			DelegationEditWindow.show();
		},
		failure: function(response, opts) {
			Ext.Msg.alert('<?php __('Error'); ?>', '<?php __('Cannot get the delegation edit form. Error code'); ?>: ' + response.status);
		}
	});
}

function ViewDelegation(id) {
    Ext.Ajax.request({
        url: '<?php echo $this->Html->url(array('controller' => 'delegations', 'action' => 'view')); ?>/'+id,
        success: function(response, opts) {
            var delegation_data = response.responseText;

            eval(delegation_data);

            DelegationViewWindow.show();
        },
        failure: function(response, opts) {
            Ext.Msg.alert('<?php __('Error'); ?>', '<?php __('Cannot get the delegation view form. Error code'); ?>: ' + response.status);
        }
    });
}

function DeleteDelegation(id) {
	Ext.Ajax.request({
		url: '<?php echo $this->Html->url(array('controller' => 'delegations', 'action' => 'delete')); ?>/'+id,
		success: function(response, opts) {
			Ext.Msg.alert('<?php __('Success'); ?>', '<?php __('Delegation successfully deleted!'); ?>');
			RefreshDelegationData();
		},
		failure: function(response, opts) {
			Ext.Msg.alert('<?php __('Error'); ?>', '<?php __('Cannot get the delegation add form. Error code'); ?>: ' + response.status);
		}
	});
}

function SearchDelegation(){
	Ext.Ajax.request({
		url: '<?php echo $this->Html->url(array('controller' => 'delegations', 'action' => 'search')); ?>',
		success: function(response, opts){
			var delegation_data = response.responseText;

			eval(delegation_data);

			delegationSearchWindow.show();
		},
		failure: function(response, opts) {
			Ext.Msg.alert('<?php __('Error'); ?>','<?php __('Cannot get the delegation search form. Error Code'); ?>: ' + response.status);
		}
	});
}

function SearchByDelegationName(value){
	var conditions = '\'Delegation.name LIKE\' => \'%' + value + '%\'';
	store_delegations.reload({
		 params: {
			start: 0,
			limit: list_size,
			conditions: conditions
	    }
	});
}

function RefreshDelegationData() {
	store_delegations.reload();
}


if(center_panel.find('id', 'delegation-tab') != "") {
	var p = center_panel.findById('delegation-tab');
	center_panel.setActiveTab(p);
} else {
	var p = center_panel.add({
		title: '<?php __('Delegations'); ?>',
		closable: true,
		loadMask: true,
		stripeRows: true,
		id: 'delegation-tab',
		xtype: 'grid',
		store: store_delegations,
		columns: [
			{header: "<?php __('Employee'); ?>", dataIndex: 'employee', sortable: true},
			{header: "<?php __('Delegated'); ?>", dataIndex: 'delegated', sortable: true},
			{header: "<?php __('Start'); ?>", dataIndex: 'start', sortable: true},
			{header: "<?php __('End'); ?>", dataIndex: 'end', sortable: true},
			{header: "<?php __('Comment'); ?>", dataIndex: 'comment', sortable: true},
			{header: "<?php __('Created'); ?>", dataIndex: 'created', sortable: true}
		],
		
		view: new Ext.grid.GroupingView({
            forceFit:true,
            groupTextTpl: '{text} ({[values.rs.length]} {[values.rs.length > 1 ? "Delegations" : "Delegation"]})'
        })
,
		listeners: {
			celldblclick: function(){
				ViewDelegation(Ext.getCmp('delegation-tab').getSelectionModel().getSelected().data.id);
			}
		},
		sm: new Ext.grid.RowSelectionModel({
			singleSelect: false
		}),
		tbar: new Ext.Toolbar({
			
			items: [{
					xtype: 'tbbutton',
					text: '<?php __('Add'); ?>',
					tooltip:'<?php __('<b>Add Delegations</b><br />Click here to create a new Delegation'); ?>',
					icon: 'img/table_add.png',
					cls: 'x-btn-text-icon',
					handler: function(btn) {
						AddDelegation();
					}
				}, ' ', '-', ' ', {
					xtype: 'tbbutton',
					text: '<?php __('Edit'); ?>',
					id: 'edit-delegation',
					tooltip:'<?php __('<b>Edit Delegations</b><br />Click here to modify the selected Delegation'); ?>',
					icon: 'img/table_edit.png',
					cls: 'x-btn-text-icon',
					disabled: true,
					handler: function(btn) {
						var sm = p.getSelectionModel();
						var sel = sm.getSelected();
						if (sm.hasSelection()){
							EditDelegation(sel.data.id);
						};
					}
				}, ' ', '-', ' ', {
					xtype: 'tbbutton',
					text: '<?php __('Delete'); ?>',
					id: 'delete-delegation',
					tooltip:'<?php __('<b>Delete Delegations(s)</b><br />Click here to remove the selected Delegation(s)'); ?>',
					icon: 'img/table_delete.png',
					cls: 'x-btn-text-icon',
					disabled: true,
					handler: function(btn) {
						var sm = p.getSelectionModel();
						var sel = sm.getSelections();
						if (sm.hasSelection()){
							if(sel.length==1){
								Ext.Msg.show({
									title: '<?php __('Remove Delegation'); ?>',
									buttons: Ext.MessageBox.YESNO,
									msg: '<?php __('Remove'); ?> '+sel[0].data.name+'?',
									icon: Ext.MessageBox.QUESTION,
									fn: function(btn){
										if (btn == 'yes'){
											DeleteDelegation(sel[0].data.id);
										}
									}
								});
							}else{
								Ext.Msg.show({
									title: '<?php __('Remove Delegation'); ?>',
									buttons: Ext.MessageBox.YESNO,
									msg: '<?php __('Remove the selected Delegations'); ?>?',
									icon: Ext.MessageBox.QUESTION,
									fn: function(btn){
										if (btn == 'yes'){
											var sel_ids = '';
											for(i=0;i<sel.length;i++){
												if(i>0)
													sel_ids += '_';
												sel_ids += sel[i].data.id;
											}
											DeleteDelegation(sel_ids);
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
					text: '<?php __('View Delegation'); ?>',
					id: 'view-delegation',
					tooltip:'<?php __('<b>View Delegation</b><br />Click here to see details of the selected Delegation'); ?>',
					icon: 'img/table_view.png',
					cls: 'x-btn-text-icon',
					disabled: true,
					handler: function(btn) {
						var sm = p.getSelectionModel();
						var sel = sm.getSelected();
						if (sm.hasSelection()){
							ViewDelegation(sel.data.id);
						};
					},
					menu : {
						items: [
						]
					}
				}, ' ', '-', 
 '->', {
					xtype: 'textfield',
					emptyText: '<?php __('[Search By Name]'); ?>',
					id: 'delegation_search_field',
					listeners: {
						specialkey: function(field, e){
							if (e.getKey() == e.ENTER) {
								SearchByDelegationName(Ext.getCmp('delegation_search_field').getValue());
							}
						}
					}
				}, {
					xtype: 'tbbutton',
					icon: 'img/search.png',
					cls: 'x-btn-text-icon',
					text: '<?php __('GO'); ?>',
                    tooltip:'<?php __('<b>GO</b><br />Click here to get search results'); ?>',
					id: 'delegation_go_button',
					handler: function(){
						SearchByDelegationName(Ext.getCmp('delegation_search_field').getValue());
					}
				}, '-', {
					xtype: 'tbbutton',
					icon: 'img/table_search.png',
					cls: 'x-btn-text-icon',
					text: '<?php __('Advanced Search'); ?>',
                    tooltip:'<?php __('<b>Advanced Search...</b><br />Click here to get the advanced search form'); ?>',
					handler: function(){
						SearchDelegation();
					}
				}
		]}),
		bbar: new Ext.PagingToolbar({
			pageSize: list_size,
			store: store_delegations,
			displayInfo: true,
			displayMsg: '<?php __('Displaying {0} - {1} of {2}'); ?>',
			beforePageText: '<?php __('Page'); ?>',
			afterPageText: '<?php __('of {0}'); ?>',
			emptyMsg: '<?php __('No data to display'); ?>'
		})
	});
	p.getSelectionModel().on('rowselect', function(sm, rowIdx, r) {
		p.getTopToolbar().findById('edit-delegation').enable();
		p.getTopToolbar().findById('delete-delegation').enable();
		p.getTopToolbar().findById('view-delegation').enable();
		if(this.getSelections().length > 1){
			p.getTopToolbar().findById('edit-delegation').disable();
			p.getTopToolbar().findById('view-delegation').disable();
		}
	});
	p.getSelectionModel().on('rowdeselect', function(sm, rowIdx, r) {
		if(this.getSelections().length > 1){
			p.getTopToolbar().findById('edit-delegation').disable();
			p.getTopToolbar().findById('view-delegation').disable();
			p.getTopToolbar().findById('delete-delegation').enable();
		}
		else if(this.getSelections().length == 1){
			p.getTopToolbar().findById('edit-delegation').enable();
			p.getTopToolbar().findById('view-delegation').enable();
			p.getTopToolbar().findById('delete-delegation').enable();
		}
		else{
			p.getTopToolbar().findById('edit-delegation').disable();
			p.getTopToolbar().findById('view-delegation').disable();
			p.getTopToolbar().findById('delete-delegation').disable();
		}
	});
	center_panel.setActiveTab(p);
	
	store_delegations.load({
		params: {
			start: 0,          
			limit: list_size
		}
	});
	
}
