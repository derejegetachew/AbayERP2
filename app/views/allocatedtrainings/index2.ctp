var store_parent_allocatedtrainings = new Ext.data.Store({
	reader: new Ext.data.JsonReader({
		root:'rows',
		totalProperty: 'results',
		fields: [
			'id','budget_year','quarter','employee','training1','training2','training3'
		]
	}),
	proxy: new Ext.data.HttpProxy({
		url: '<?php echo $this->Html->url(array('controller' => 'allocatedtrainings', 'action' => 'list_data', $parent_id)); ?>'	})
});


function AddParentAllocatedtraining() {
	Ext.Ajax.request({
		url: '<?php echo $this->Html->url(array('controller' => 'allocatedtrainings', 'action' => 'add', $parent_id)); ?>',
		success: function(response, opts) {
			var parent_allocatedtraining_data = response.responseText;
			
			eval(parent_allocatedtraining_data);
			
			AllocatedtrainingAddWindow.show();
		},
		failure: function(response, opts) {
			Ext.Msg.alert('<?php __('Error'); ?>', '<?php __('Cannot get the allocatedtraining add form. Error code'); ?>: ' + response.status);
		}
	});
}

function EditParentAllocatedtraining(id) {
	Ext.Ajax.request({
		url: '<?php echo $this->Html->url(array('controller' => 'allocatedtrainings', 'action' => 'edit')); ?>/'+id+'/<?php echo $parent_id; ?>',
		success: function(response, opts) {
			var parent_allocatedtraining_data = response.responseText;
			
			eval(parent_allocatedtraining_data);
			
			AllocatedtrainingEditWindow.show();
		},
		failure: function(response, opts) {
			Ext.Msg.alert('<?php __('Error'); ?>', '<?php __('Cannot get the allocatedtraining edit form. Error code'); ?>: ' + response.status);
		}
	});
}

function ViewAllocatedtraining(id) {
	Ext.Ajax.request({
		url: '<?php echo $this->Html->url(array('controller' => 'allocatedtrainings', 'action' => 'view')); ?>/'+id,
		success: function(response, opts) {
			var allocatedtraining_data = response.responseText;

			eval(allocatedtraining_data);

			AllocatedtrainingViewWindow.show();
		},
		failure: function(response, opts) {
			Ext.Msg.alert('<?php __('Error'); ?>', '<?php __('Cannot get the allocatedtraining view form. Error code'); ?>: ' + response.status);
		}
	});
}


function DeleteParentAllocatedtraining(id) {
	Ext.Ajax.request({
		url: '<?php echo $this->Html->url(array('controller' => 'allocatedtrainings', 'action' => 'delete')); ?>/'+id,
		success: function(response, opts) {
			Ext.Msg.alert('<?php __('Success'); ?>', '<?php __('Allocatedtraining(s) successfully deleted!'); ?>');
			RefreshParentAllocatedtrainingData();
		},
		failure: function(response, opts) {
			Ext.Msg.alert('<?php __('Error'); ?>', '<?php __('Cannot get the allocatedtraining to be deleted. Error code'); ?>: ' + response.status);
		}
	});
}

function SearchByParentAllocatedtrainingName(value){
	var conditions = '\'Allocatedtraining.name LIKE\' => \'%' + value + '%\'';
	store_parent_allocatedtrainings.reload({
		 params: {
			start: 0,
			limit: list_size,
			conditions: conditions
	    }
	});
}

function RefreshParentAllocatedtrainingData() {
	store_parent_allocatedtrainings.reload();
}



var g = new Ext.grid.GridPanel({
	title: '<?php __('Allocatedtrainings'); ?>',
	store: store_parent_allocatedtrainings,
	loadMask: true,
	stripeRows: true,
	height: 300,
	anchor: '100%',
    id: 'allocatedtrainingGrid',
	columns: [
		{header:"<?php __('budget_year'); ?>", dataIndex: 'budget_year', sortable: true},
		{header: "<?php __('Quarter'); ?>", dataIndex: 'quarter', sortable: true},
		{header:"<?php __('employee'); ?>", dataIndex: 'employee', sortable: true},
		{header: "<?php __('Training1'); ?>", dataIndex: 'training1', sortable: true},
		{header: "<?php __('Training2'); ?>", dataIndex: 'training2', sortable: true},
		{header: "<?php __('Training3'); ?>", dataIndex: 'training3', sortable: true}
			],
	sm: new Ext.grid.RowSelectionModel({
		singleSelect: false
	}),
	viewConfig: {
		forceFit: true
	},
    listeners: {
        celldblclick: function(){
            ViewAllocatedtraining(Ext.getCmp('allocatedtrainingGrid').getSelectionModel().getSelected().data.id);
        }
    },
	tbar: new Ext.Toolbar({
		items: [{
				xtype: 'tbbutton',
				text: '<?php __('Add'); ?>',
				tooltip:'<?php __('<b>Add Allocatedtraining</b><br />Click here to create a new Allocatedtraining'); ?>',
				icon: 'img/table_add.png',
				cls: 'x-btn-text-icon',
				handler: function(btn) {
					AddParentAllocatedtraining();
				}
			}, ' ', '-', ' ', {
				xtype: 'tbbutton',
				text: '<?php __('Edit'); ?>',
				id: 'edit-parent-allocatedtraining',
				tooltip:'<?php __('<b>Edit Allocatedtraining</b><br />Click here to modify the selected Allocatedtraining'); ?>',
				icon: 'img/table_edit.png',
				cls: 'x-btn-text-icon',
				disabled: true,
				handler: function(btn) {
					var sm = g.getSelectionModel();
					var sel = sm.getSelected();
					if (sm.hasSelection()){
						EditParentAllocatedtraining(sel.data.id);
					};
				}
			}, ' ', '-', ' ', {
				xtype: 'tbbutton',
				text: '<?php __('Delete'); ?>',
				id: 'delete-parent-allocatedtraining',
				tooltip:'<?php __('<b>Delete Allocatedtraining(s)</b><br />Click here to remove the selected Allocatedtraining(s)'); ?>',
				icon: 'img/table_delete.png',
				cls: 'x-btn-text-icon',
				disabled: true,
				handler: function(btn) {
					var sm = g.getSelectionModel();
					var sel = sm.getSelections();
					if (sm.hasSelection()){
						if(sel.length==1){
							Ext.Msg.show({
									title: '<?php __('Remove Allocatedtraining'); ?>',
									buttons: Ext.MessageBox.YESNOCANCEL,
									msg: '<?php __('Remove'); ?> '+sel[0].data.name+'?',
									icon: Ext.MessageBox.QUESTION,
                                    fn: function(btn){
											if (btn == 'yes'){
													DeleteParentAllocatedtraining(sel[0].data.id);
											}
									}
							});
						} else {
							Ext.Msg.show({
									title: '<?php __('Remove Allocatedtraining'); ?>',
									buttons: Ext.MessageBox.YESNOCANCEL,
									msg: '<?php __('Remove the selected Allocatedtraining'); ?>?',
									icon: Ext.MessageBox.QUESTION,
                                    fn: function(btn){
											if (btn == 'yes'){
													var sel_ids = '';
													for(i=0;i<sel.length;i++){
														if(i>0)
															sel_ids += '_';
														sel_ids += sel[i].data.id;
													}
													DeleteParentAllocatedtraining(sel_ids);
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
				text: '<?php __('View Allocatedtraining'); ?>',
				id: 'view-allocatedtraining2',
				tooltip:'<?php __('<b>View Allocatedtraining</b><br />Click here to see details of the selected Allocatedtraining'); ?>',
				icon: 'img/table_view.png',
				cls: 'x-btn-text-icon',
				disabled: true,
				handler: function(btn) {
					var sm = g.getSelectionModel();
					var sel = sm.getSelected();
					if (sm.hasSelection()){
						ViewAllocatedtraining(sel.data.id);
					};
				},
				menu : {
					items: [
					]
				}

            }, ' ', '->', {
				xtype: 'textfield',
				emptyText: '<?php __('[Search By Name]'); ?>',
				id: 'parent_allocatedtraining_search_field',
				listeners: {
					specialkey: function(field, e){
						if (e.getKey() == e.ENTER) {
							SearchByParentAllocatedtrainingName(Ext.getCmp('parent_allocatedtraining_search_field').getValue());
						}
					}

				}
			}, {
				xtype: 'tbbutton',
				icon: 'img/search.png',
				cls: 'x-btn-text-icon',
				text: 'GO',
				tooltip:'<?php __('<b>GO</b><br />Click here to get search results'); ?>',
				id: 'parent_allocatedtraining_go_button',
				handler: function(){
					SearchByParentAllocatedtrainingName(Ext.getCmp('parent_allocatedtraining_search_field').getValue());
				}
			}, ' '
	]}),
	bbar: new Ext.PagingToolbar({
		pageSize: list_size,
		store: store_parent_allocatedtrainings,
		displayInfo: true,
		displayMsg: '<?php __('Displaying {0} - {1} of {2}'); ?>',
		beforePageText: '<?php __('Page'); ?>',
		afterPageText: '<?php __('of {0}'); ?>',
		emptyMsg: '<?php __('No data to display'); ?>'
	})
});
g.getSelectionModel().on('rowselect', function(sm, rowIdx, r) {
	g.getTopToolbar().findById('edit-parent-allocatedtraining').enable();
	g.getTopToolbar().findById('delete-parent-allocatedtraining').enable();
        g.getTopToolbar().findById('view-allocatedtraining2').enable();
	if(this.getSelections().length > 1){
		g.getTopToolbar().findById('edit-parent-allocatedtraining').disable();
                g.getTopToolbar().findById('view-allocatedtraining2').disable();
	}
});
g.getSelectionModel().on('rowdeselect', function(sm, rowIdx, r) {
	if(this.getSelections().length > 1){
		g.getTopToolbar().findById('edit-parent-allocatedtraining').disable();
		g.getTopToolbar().findById('delete-parent-allocatedtraining').enable();
                g.getTopToolbar().findById('view-allocatedtraining2').disable();
	}
	else if(this.getSelections().length == 1){
		g.getTopToolbar().findById('edit-parent-allocatedtraining').enable();
		g.getTopToolbar().findById('delete-parent-allocatedtraining').enable();
                g.getTopToolbar().findById('view-allocatedtraining2').enable();
	}
	else{
		g.getTopToolbar().findById('edit-parent-allocatedtraining').disable();
		g.getTopToolbar().findById('delete-parent-allocatedtraining').disable();
                g.getTopToolbar().findById('view-allocatedtraining2').disable();
	}
});



var parentAllocatedtrainingsViewWindow = new Ext.Window({
	title: 'Allocatedtraining Under the selected Item',
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
			parentAllocatedtrainingsViewWindow.close();
		}
	}]
});

store_parent_allocatedtrainings.load({
    params: {
        start: 0,    
        limit: list_size
    }
});