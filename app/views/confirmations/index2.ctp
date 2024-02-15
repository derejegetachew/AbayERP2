var store_parent_confirmations = new Ext.data.Store({
	reader: new Ext.data.JsonReader({
		root:'rows',
		totalProperty: 'results',
		fields: [
			'id','user','confirmation_code','status'	
		]
	}),
	proxy: new Ext.data.HttpProxy({
		url: '<?php echo $this->Html->url(array('controller' => 'confirmations', 'action' => 'list_data', $parent_id)); ?>'	})
});


function AddParentConfirmation() {
	Ext.Ajax.request({
		url: '<?php echo $this->Html->url(array('controller' => 'confirmations', 'action' => 'add', $parent_id)); ?>',
		success: function(response, opts) {
			var parent_confirmation_data = response.responseText;
			
			eval(parent_confirmation_data);
			
			ConfirmationAddWindow.show();
		},
		failure: function(response, opts) {
			Ext.Msg.alert('<?php __('Error'); ?>', '<?php __('Cannot get the confirmation add form. Error code'); ?>: ' + response.status);
		}
	});
}

function EditParentConfirmation(id) {
	Ext.Ajax.request({
		url: '<?php echo $this->Html->url(array('controller' => 'confirmations', 'action' => 'edit')); ?>/'+id+'/<?php echo $parent_id; ?>',
		success: function(response, opts) {
			var parent_confirmation_data = response.responseText;
			
			eval(parent_confirmation_data);
			
			ConfirmationEditWindow.show();
		},
		failure: function(response, opts) {
			Ext.Msg.alert('<?php __('Error'); ?>', '<?php __('Cannot get the confirmation edit form. Error code'); ?>: ' + response.status);
		}
	});
}

function ViewConfirmation(id) {
	Ext.Ajax.request({
		url: '<?php echo $this->Html->url(array('controller' => 'confirmations', 'action' => 'view')); ?>/'+id,
		success: function(response, opts) {
			var confirmation_data = response.responseText;

			eval(confirmation_data);

			ConfirmationViewWindow.show();
		},
		failure: function(response, opts) {
			Ext.Msg.alert('<?php __('Error'); ?>', '<?php __('Cannot get the confirmation view form. Error code'); ?>: ' + response.status);
		}
	});
}


function DeleteParentConfirmation(id) {
	Ext.Ajax.request({
		url: '<?php echo $this->Html->url(array('controller' => 'confirmations', 'action' => 'delete')); ?>/'+id,
		success: function(response, opts) {
			Ext.Msg.alert('<?php __('Success'); ?>', '<?php __('Confirmation(s) successfully deleted!'); ?>');
			RefreshParentConfirmationData();
		},
		failure: function(response, opts) {
			Ext.Msg.alert('<?php __('Error'); ?>', '<?php __('Cannot get the confirmation to be deleted. Error code'); ?>: ' + response.status);
		}
	});
}

function SearchByParentConfirmationName(value){
	var conditions = '\'Confirmation.name LIKE\' => \'%' + value + '%\'';
	store_parent_confirmations.reload({
		 params: {
			start: 0,
			limit: list_size,
			conditions: conditions
	    }
	});
}

function RefreshParentConfirmationData() {
	store_parent_confirmations.reload();
}



var g = new Ext.grid.GridPanel({
	title: '<?php __('Confirmations'); ?>',
	store: store_parent_confirmations,
	loadMask: true,
	stripeRows: true,
	height: 300,
	anchor: '100%',
    id: 'confirmationGrid',
	columns: [
		{header:"<?php __('user'); ?>", dataIndex: 'user', sortable: true},
		{header: "<?php __('Confirmation Code'); ?>", dataIndex: 'confirmation_code', sortable: true},
		{header: "<?php __('Status'); ?>", dataIndex: 'status', sortable: true}	],
	sm: new Ext.grid.RowSelectionModel({
		singleSelect: false
	}),
	viewConfig: {
		forceFit: true
	},
    listeners: {
        celldblclick: function(){
            ViewConfirmation(Ext.getCmp('confirmationGrid').getSelectionModel().getSelected().data.id);
        }
    },
	tbar: new Ext.Toolbar({
		items: [{
				xtype: 'tbbutton',
				text: '<?php __('Add'); ?>',
				tooltip:'<?php __('<b>Add Confirmation</b><br />Click here to create a new Confirmation'); ?>',
				icon: 'img/table_add.png',
				cls: 'x-btn-text-icon',
				handler: function(btn) {
					AddParentConfirmation();
				}
			}, ' ', '-', ' ', {
				xtype: 'tbbutton',
				text: '<?php __('Edit'); ?>',
				id: 'edit-parent-confirmation',
				tooltip:'<?php __('<b>Edit Confirmation</b><br />Click here to modify the selected Confirmation'); ?>',
				icon: 'img/table_edit.png',
				cls: 'x-btn-text-icon',
				disabled: true,
				handler: function(btn) {
					var sm = g.getSelectionModel();
					var sel = sm.getSelected();
					if (sm.hasSelection()){
						EditParentConfirmation(sel.data.id);
					};
				}
			}, ' ', '-', ' ', {
				xtype: 'tbbutton',
				text: '<?php __('Delete'); ?>',
				id: 'delete-parent-confirmation',
				tooltip:'<?php __('<b>Delete Confirmation(s)</b><br />Click here to remove the selected Confirmation(s)'); ?>',
				icon: 'img/table_delete.png',
				cls: 'x-btn-text-icon',
				disabled: true,
				handler: function(btn) {
					var sm = g.getSelectionModel();
					var sel = sm.getSelections();
					if (sm.hasSelection()){
						if(sel.length==1){
							Ext.Msg.show({
									title: '<?php __('Remove Confirmation'); ?>',
									buttons: Ext.MessageBox.YESNOCANCEL,
									msg: '<?php __('Remove'); ?> '+sel[0].data.name+'?',
									icon: Ext.MessageBox.QUESTION,
                                    fn: function(btn){
											if (btn == 'yes'){
													DeleteParentConfirmation(sel[0].data.id);
											}
									}
							});
						} else {
							Ext.Msg.show({
									title: '<?php __('Remove Confirmation'); ?>',
									buttons: Ext.MessageBox.YESNOCANCEL,
									msg: '<?php __('Remove the selected Confirmation'); ?>?',
									icon: Ext.MessageBox.QUESTION,
                                    fn: function(btn){
											if (btn == 'yes'){
													var sel_ids = '';
													for(i=0;i<sel.length;i++){
														if(i>0)
															sel_ids += '_';
														sel_ids += sel[i].data.id;
													}
													DeleteParentConfirmation(sel_ids);
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
				text: '<?php __('View Confirmation'); ?>',
				id: 'view-confirmation2',
				tooltip:'<?php __('<b>View Confirmation</b><br />Click here to see details of the selected Confirmation'); ?>',
				icon: 'img/table_view.png',
				cls: 'x-btn-text-icon',
				disabled: true,
				handler: function(btn) {
					var sm = g.getSelectionModel();
					var sel = sm.getSelected();
					if (sm.hasSelection()){
						ViewConfirmation(sel.data.id);
					};
				},
				menu : {
					items: [
					]
				}

            }, ' ', '->', {
				xtype: 'textfield',
				emptyText: '<?php __('[Search By Name]'); ?>',
				id: 'parent_confirmation_search_field',
				listeners: {
					specialkey: function(field, e){
						if (e.getKey() == e.ENTER) {
							SearchByParentConfirmationName(Ext.getCmp('parent_confirmation_search_field').getValue());
						}
					}

				}
			}, {
				xtype: 'tbbutton',
				icon: 'img/search.png',
				cls: 'x-btn-text-icon',
				text: 'GO',
				tooltip:'<?php __('<b>GO</b><br />Click here to get search results'); ?>',
				id: 'parent_confirmation_go_button',
				handler: function(){
					SearchByParentConfirmationName(Ext.getCmp('parent_confirmation_search_field').getValue());
				}
			}, ' '
	]}),
	bbar: new Ext.PagingToolbar({
		pageSize: list_size,
		store: store_parent_confirmations,
		displayInfo: true,
		displayMsg: '<?php __('Displaying {0} - {1} of {2}'); ?>',
		beforePageText: '<?php __('Page'); ?>',
		afterPageText: '<?php __('of {0}'); ?>',
		emptyMsg: '<?php __('No data to display'); ?>'
	})
});
g.getSelectionModel().on('rowselect', function(sm, rowIdx, r) {
	g.getTopToolbar().findById('edit-parent-confirmation').enable();
	g.getTopToolbar().findById('delete-parent-confirmation').enable();
        g.getTopToolbar().findById('view-confirmation2').enable();
	if(this.getSelections().length > 1){
		g.getTopToolbar().findById('edit-parent-confirmation').disable();
                g.getTopToolbar().findById('view-confirmation2').disable();
	}
});
g.getSelectionModel().on('rowdeselect', function(sm, rowIdx, r) {
	if(this.getSelections().length > 1){
		g.getTopToolbar().findById('edit-parent-confirmation').disable();
		g.getTopToolbar().findById('delete-parent-confirmation').enable();
                g.getTopToolbar().findById('view-confirmation2').disable();
	}
	else if(this.getSelections().length == 1){
		g.getTopToolbar().findById('edit-parent-confirmation').enable();
		g.getTopToolbar().findById('delete-parent-confirmation').enable();
                g.getTopToolbar().findById('view-confirmation2').enable();
	}
	else{
		g.getTopToolbar().findById('edit-parent-confirmation').disable();
		g.getTopToolbar().findById('delete-parent-confirmation').disable();
                g.getTopToolbar().findById('view-confirmation2').disable();
	}
});



var parentConfirmationsViewWindow = new Ext.Window({
	title: 'Confirmation Under the selected Item',
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
			parentConfirmationsViewWindow.close();
		}
	}]
});

store_parent_confirmations.load({
    params: {
        start: 0,    
        limit: list_size
    }
});