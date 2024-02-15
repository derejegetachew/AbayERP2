var store_parent_delegations = new Ext.data.Store({
	reader: new Ext.data.JsonReader({
		root:'rows',
		totalProperty: 'results',
		fields: [
			'id','employee','delegated','start','end','comment','created'	
		]
	}),
	proxy: new Ext.data.HttpProxy({
		url: '<?php echo $this->Html->url(array('controller' => 'delegations', 'action' => 'list_data', $parent_id)); ?>'	})
});


function AddParentDelegation() {
	Ext.Ajax.request({
		url: '<?php echo $this->Html->url(array('controller' => 'delegations', 'action' => 'add', $parent_id)); ?>',
		success: function(response, opts) {
			var parent_delegation_data = response.responseText;
			
			eval(parent_delegation_data);
			
			DelegationAddWindow.show();
		},
		failure: function(response, opts) {
			Ext.Msg.alert('<?php __('Error'); ?>', '<?php __('Cannot get the delegation add form. Error code'); ?>: ' + response.status);
		}
	});
}

function EditParentDelegation(id) {
	Ext.Ajax.request({
		url: '<?php echo $this->Html->url(array('controller' => 'delegations', 'action' => 'edit')); ?>/'+id+'/<?php echo $parent_id; ?>',
		success: function(response, opts) {
			var parent_delegation_data = response.responseText;
			
			eval(parent_delegation_data);
			
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


function DeleteParentDelegation(id) {
	Ext.Ajax.request({
		url: '<?php echo $this->Html->url(array('controller' => 'delegations', 'action' => 'delete')); ?>/'+id,
		success: function(response, opts) {
			Ext.Msg.alert('<?php __('Success'); ?>', '<?php __('Delegation(s) successfully deleted!'); ?>');
			RefreshParentDelegationData();
		},
		failure: function(response, opts) {
			Ext.Msg.alert('<?php __('Error'); ?>', '<?php __('Cannot get the delegation to be deleted. Error code'); ?>: ' + response.status);
		}
	});
}

function SearchByParentDelegationName(value){
	var conditions = '\'Delegation.name LIKE\' => \'%' + value + '%\'';
	store_parent_delegations.reload({
		 params: {
			start: 0,
			limit: list_size,
			conditions: conditions
	    }
	});
}

function RefreshParentDelegationData() {
	store_parent_delegations.reload();
}



var g = new Ext.grid.GridPanel({
	title: '<?php __('Delegations'); ?>',
	store: store_parent_delegations,
	loadMask: true,
	stripeRows: true,
	height: 300,
	anchor: '100%',
    id: 'delegationGrid',
	columns: [
		{header:"<?php __('employee'); ?>", dataIndex: 'employee', sortable: true},
		{header: "<?php __('Delegated'); ?>", dataIndex: 'delegated', sortable: true},
		{header: "<?php __('Start'); ?>", dataIndex: 'start', sortable: true},
		{header: "<?php __('End'); ?>", dataIndex: 'end', sortable: true},
		{header: "<?php __('Comment'); ?>", dataIndex: 'comment', sortable: true},
		{header: "<?php __('Created'); ?>", dataIndex: 'created', sortable: true}	],
	sm: new Ext.grid.RowSelectionModel({
		singleSelect: false
	}),
	viewConfig: {
		forceFit: true
	},
    listeners: {
        celldblclick: function(){
            ViewDelegation(Ext.getCmp('delegationGrid').getSelectionModel().getSelected().data.id);
        }
    },
	tbar: new Ext.Toolbar({
		items: [{
				xtype: 'tbbutton',
				text: '<?php __('Add'); ?>',
				tooltip:'<?php __('<b>Add Delegation</b><br />Click here to create a new Delegation'); ?>',
				icon: 'img/table_add.png',
				cls: 'x-btn-text-icon',
				handler: function(btn) {
					AddParentDelegation();
				}
			}, ' ', '-', ' ', {
				xtype: 'tbbutton',
				text: '<?php __('Edit'); ?>',
				id: 'edit-parent-delegation',
				tooltip:'<?php __('<b>Edit Delegation</b><br />Click here to modify the selected Delegation'); ?>',
				icon: 'img/table_edit.png',
				cls: 'x-btn-text-icon',
				disabled: true,
				handler: function(btn) {
					var sm = g.getSelectionModel();
					var sel = sm.getSelected();
					if (sm.hasSelection()){
						EditParentDelegation(sel.data.id);
					};
				}
			}, ' ', '-', ' ', {
				xtype: 'tbbutton',
				text: '<?php __('Delete'); ?>',
				id: 'delete-parent-delegation',
				tooltip:'<?php __('<b>Delete Delegation(s)</b><br />Click here to remove the selected Delegation(s)'); ?>',
				icon: 'img/table_delete.png',
				cls: 'x-btn-text-icon',
				disabled: true,
				handler: function(btn) {
					var sm = g.getSelectionModel();
					var sel = sm.getSelections();
					if (sm.hasSelection()){
						if(sel.length==1){
							Ext.Msg.show({
									title: '<?php __('Remove Delegation'); ?>',
									buttons: Ext.MessageBox.YESNOCANCEL,
									msg: '<?php __('Remove'); ?> '+sel[0].data.name+'?',
									icon: Ext.MessageBox.QUESTION,
                                    fn: function(btn){
											if (btn == 'yes'){
													DeleteParentDelegation(sel[0].data.id);
											}
									}
							});
						} else {
							Ext.Msg.show({
									title: '<?php __('Remove Delegation'); ?>',
									buttons: Ext.MessageBox.YESNOCANCEL,
									msg: '<?php __('Remove the selected Delegation'); ?>?',
									icon: Ext.MessageBox.QUESTION,
                                    fn: function(btn){
											if (btn == 'yes'){
													var sel_ids = '';
													for(i=0;i<sel.length;i++){
														if(i>0)
															sel_ids += '_';
														sel_ids += sel[i].data.id;
													}
													DeleteParentDelegation(sel_ids);
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
				text: '<?php __('View Delegation'); ?>',
				id: 'view-delegation2',
				tooltip:'<?php __('<b>View Delegation</b><br />Click here to see details of the selected Delegation'); ?>',
				icon: 'img/table_view.png',
				cls: 'x-btn-text-icon',
				disabled: true,
				handler: function(btn) {
					var sm = g.getSelectionModel();
					var sel = sm.getSelected();
					if (sm.hasSelection()){
						ViewDelegation(sel.data.id);
					};
				},
				menu : {
					items: [
					]
				}

            }, ' ', '->', {
				xtype: 'textfield',
				emptyText: '<?php __('[Search By Name]'); ?>',
				id: 'parent_delegation_search_field',
				listeners: {
					specialkey: function(field, e){
						if (e.getKey() == e.ENTER) {
							SearchByParentDelegationName(Ext.getCmp('parent_delegation_search_field').getValue());
						}
					}

				}
			}, {
				xtype: 'tbbutton',
				icon: 'img/search.png',
				cls: 'x-btn-text-icon',
				text: 'GO',
				tooltip:'<?php __('<b>GO</b><br />Click here to get search results'); ?>',
				id: 'parent_delegation_go_button',
				handler: function(){
					SearchByParentDelegationName(Ext.getCmp('parent_delegation_search_field').getValue());
				}
			}, ' '
	]}),
	bbar: new Ext.PagingToolbar({
		pageSize: list_size,
		store: store_parent_delegations,
		displayInfo: true,
		displayMsg: '<?php __('Displaying {0} - {1} of {2}'); ?>',
		beforePageText: '<?php __('Page'); ?>',
		afterPageText: '<?php __('of {0}'); ?>',
		emptyMsg: '<?php __('No data to display'); ?>'
	})
});
g.getSelectionModel().on('rowselect', function(sm, rowIdx, r) {
	g.getTopToolbar().findById('edit-parent-delegation').enable();
	g.getTopToolbar().findById('delete-parent-delegation').enable();
        g.getTopToolbar().findById('view-delegation2').enable();
	if(this.getSelections().length > 1){
		g.getTopToolbar().findById('edit-parent-delegation').disable();
                g.getTopToolbar().findById('view-delegation2').disable();
	}
});
g.getSelectionModel().on('rowdeselect', function(sm, rowIdx, r) {
	if(this.getSelections().length > 1){
		g.getTopToolbar().findById('edit-parent-delegation').disable();
		g.getTopToolbar().findById('delete-parent-delegation').enable();
                g.getTopToolbar().findById('view-delegation2').disable();
	}
	else if(this.getSelections().length == 1){
		g.getTopToolbar().findById('edit-parent-delegation').enable();
		g.getTopToolbar().findById('delete-parent-delegation').enable();
                g.getTopToolbar().findById('view-delegation2').enable();
	}
	else{
		g.getTopToolbar().findById('edit-parent-delegation').disable();
		g.getTopToolbar().findById('delete-parent-delegation').disable();
                g.getTopToolbar().findById('view-delegation2').disable();
	}
});



var parentDelegationsViewWindow = new Ext.Window({
	title: 'Delegation Under the selected Item',
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
			parentDelegationsViewWindow.close();
		}
	}]
});

store_parent_delegations.load({
    params: {
        start: 0,    
        limit: list_size
    }
});