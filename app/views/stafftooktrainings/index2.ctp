var store_parent_stafftooktrainings = new Ext.data.Store({
	reader: new Ext.data.JsonReader({
		root:'rows',
		totalProperty: 'results',
		fields: [
			'id','employee','position','branch','created','modified'	
		]
	}),
	proxy: new Ext.data.HttpProxy({
		url: '<?php echo $this->Html->url(array('controller' => 'stafftooktrainings', 'action' => 'list_data', $parent_id)); ?>'	})
});


function AddParentStafftooktraining() {
	Ext.Ajax.request({
		url: '<?php echo $this->Html->url(array('controller' => 'stafftooktrainings', 'action' => 'add', $parent_id)); ?>',
		success: function(response, opts) {
			var parent_stafftooktraining_data = response.responseText;
			
			eval(parent_stafftooktraining_data);
			
			StafftooktrainingAddWindow.show();
		},
		failure: function(response, opts) {
			Ext.Msg.alert('<?php __('Error'); ?>', '<?php __('Cannot get the stafftooktraining add form. Error code'); ?>: ' + response.status);
		}
	});
}

function AddParentStafftooktraining2() {
	Ext.Ajax.request({
		url: '<?php echo $this->Html->url(array('controller' => 'stafftooktrainings', 'action' => 'add2', $parent_id)); ?>',
		success: function(response, opts) {
			var parent_stafftooktraining_data = response.responseText;
			
			eval(parent_stafftooktraining_data);
			
			StafftooktrainingAddWindow.show();
		},
		failure: function(response, opts) {
			Ext.Msg.alert('<?php __('Error'); ?>', '<?php __('Cannot get the stafftooktraining add form. Error code'); ?>: ' + response.status);
		}
	});
}
function EditParentStafftooktraining(id) {
	Ext.Ajax.request({
		url: '<?php echo $this->Html->url(array('controller' => 'stafftooktrainings', 'action' => 'edit')); ?>/'+id+'/<?php echo $parent_id; ?>',
		success: function(response, opts) {
			var parent_stafftooktraining_data = response.responseText;
			
			eval(parent_stafftooktraining_data);
			
			StafftooktrainingEditWindow.show();
		},
		failure: function(response, opts) {
			Ext.Msg.alert('<?php __('Error'); ?>', '<?php __('Cannot get the stafftooktraining edit form. Error code'); ?>: ' + response.status);
		}
	});
}

function ViewStafftooktraining(id) {
	Ext.Ajax.request({
		url: '<?php echo $this->Html->url(array('controller' => 'stafftooktrainings', 'action' => 'view')); ?>/'+id,
		success: function(response, opts) {
			var stafftooktraining_data = response.responseText;

			eval(stafftooktraining_data);

			StafftooktrainingViewWindow.show();
		},
		failure: function(response, opts) {
			Ext.Msg.alert('<?php __('Error'); ?>', '<?php __('Cannot get the stafftooktraining view form. Error code'); ?>: ' + response.status);
		}
	});
}


function DeleteParentStafftooktraining(id) {
	Ext.Ajax.request({
		url: '<?php echo $this->Html->url(array('controller' => 'stafftooktrainings', 'action' => 'delete')); ?>/'+id,
		success: function(response, opts) {
			Ext.Msg.alert('<?php __('Success'); ?>', '<?php __('Stafftooktraining(s) successfully deleted!'); ?>');
			RefreshParentStafftooktrainingData();
		},
		failure: function(response, opts) {
			Ext.Msg.alert('<?php __('Error'); ?>', '<?php __('Cannot get the stafftooktraining to be deleted. Error code'); ?>: ' + response.status);
		}
	});
}

function SearchByParentStafftooktrainingName(value){
	var conditions = '\'Stafftooktraining.name LIKE\' => \'%' + value + '%\'';
	store_parent_stafftooktrainings.reload({
		 params: {
			start: 0,
			limit: list_size,
			conditions: conditions
	    }
	});
}

function RefreshParentStafftooktrainingData() {
	store_parent_stafftooktrainings.reload();
}

  

var g = new Ext.grid.GridPanel({
	title: '<?php __('Stafftooktrainings'); ?>',
	store: store_parent_stafftooktrainings,
	loadMask: true,
	stripeRows: true,
	height: 300,
	anchor: '100%',
    id: 'stafftooktrainingGrid',
	columns: [
		{header:"<?php __('Employee'); ?>", dataIndex: 'employee', sortable: true},
		{header:"<?php __('position'); ?>", dataIndex: 'position', sortable: true},
		{header:"<?php __('branch'); ?>", dataIndex: 'branch', sortable: true},
		{header: "<?php __('Created'); ?>", dataIndex: 'created', sortable: true},
		{header: "<?php __('Modified'); ?>", dataIndex: 'modified', sortable: true}	],
	sm: new Ext.grid.RowSelectionModel({
		singleSelect: false
	}),
	viewConfig: {
		forceFit: true
	},
    listeners: {
        celldblclick: function(){
            ViewStafftooktraining(Ext.getCmp('stafftooktrainingGrid').getSelectionModel().getSelected().data.id);
        }
    },
	tbar: new Ext.Toolbar({
		items: [{
				xtype: 'tbbutton',
				text: '<?php __('Add Multiple'); ?>',
				icon: 'img/table_add.png',
				cls: 'x-btn-text-icon',
				handler: function(btn) {
					AddParentStafftooktraining2();
				}
			}, ' ', '-', ' ',{
				xtype: 'tbbutton',
				text: '<?php __('Add'); ?>',
				icon: 'img/table_add.png',
				cls: 'x-btn-text-icon',
				handler: function(btn) {
					AddParentStafftooktraining();
				}
			}, ' ', '-', ' ', {
				xtype: 'tbbutton',
				text: '<?php __('Edit'); ?>',
				id: 'edit-parent-stafftooktraining',
				tooltip:'<?php __('<b>Edit Stafftooktraining</b><br />Click here to modify the selected Stafftooktraining'); ?>',
				icon: 'img/table_edit.png',
				cls: 'x-btn-text-icon',
				disabled: true,
				handler: function(btn) {
					var sm = g.getSelectionModel();
					var sel = sm.getSelected();
					if (sm.hasSelection()){
						EditParentStafftooktraining(sel.data.id);
					};
				}
			}, ' ', '-', ' ', {
				xtype: 'tbbutton',
				text: '<?php __('Delete'); ?>',
				id: 'delete-parent-stafftooktraining',
				tooltip:'<?php __('<b>Delete Stafftooktraining(s)</b><br />Click here to remove the selected Stafftooktraining(s)'); ?>',
				icon: 'img/table_delete.png',
				cls: 'x-btn-text-icon',
				disabled: true,
				handler: function(btn) {
					var sm = g.getSelectionModel();
					var sel = sm.getSelections();
					if (sm.hasSelection()){
						if(sel.length==1){
							Ext.Msg.show({
									title: '<?php __('Remove Stafftooktraining'); ?>',
									buttons: Ext.MessageBox.YESNOCANCEL,
									msg: '<?php __('Remove'); ?> '+sel[0].data.name+'?',
									icon: Ext.MessageBox.QUESTION,
                                    fn: function(btn){
											if (btn == 'yes'){
													DeleteParentStafftooktraining(sel[0].data.id);
											}
									}
							});
						} else {
							Ext.Msg.show({
									title: '<?php __('Remove Stafftooktraining'); ?>',
									buttons: Ext.MessageBox.YESNOCANCEL,
									msg: '<?php __('Remove the selected Stafftooktraining'); ?>?',
									icon: Ext.MessageBox.QUESTION,
                                    fn: function(btn){
											if (btn == 'yes'){
													var sel_ids = '';
													for(i=0;i<sel.length;i++){
														if(i>0)
															sel_ids += '_';
														sel_ids += sel[i].data.id;
													}
													DeleteParentStafftooktraining(sel_ids);
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
				text: '<?php __('View Stafftooktraining'); ?>',
				id: 'view-stafftooktraining2',
				tooltip:'<?php __('<b>View Stafftooktraining</b><br />Click here to see details of the selected Stafftooktraining'); ?>',
				icon: 'img/table_view.png',
				cls: 'x-btn-text-icon',
				disabled: true,
				handler: function(btn) {
					var sm = g.getSelectionModel();
					var sel = sm.getSelected();
					if (sm.hasSelection()){
						ViewStafftooktraining(sel.data.id);
					};
				},
				menu : {
					items: [
					]
				}

            }, ' ', '->', {
				xtype: 'textfield',
				emptyText: '<?php __('[Search By Name]'); ?>',
				id: 'parent_stafftooktraining_search_field',
				listeners: {
					specialkey: function(field, e){
						if (e.getKey() == e.ENTER) {
							SearchByParentStafftooktrainingName(Ext.getCmp('parent_stafftooktraining_search_field').getValue());
						}
					}

				}
			}, {
				xtype: 'tbbutton',
				icon: 'img/search.png',
				cls: 'x-btn-text-icon',
				text: 'GO',
				tooltip:'<?php __('<b>GO</b><br />Click here to get search results'); ?>',
				id: 'parent_stafftooktraining_go_button',
				handler: function(){
					SearchByParentStafftooktrainingName(Ext.getCmp('parent_stafftooktraining_search_field').getValue());
				}
			}, ' '
	]}),
	bbar: new Ext.PagingToolbar({
		pageSize: 100,
		store: store_parent_stafftooktrainings,
		displayInfo: true,
		displayMsg: '<?php __('Displaying {0} - {1} of {2}'); ?>',
		beforePageText: '<?php __('Page'); ?>',
		afterPageText: '<?php __('of {0}'); ?>',
		emptyMsg: '<?php __('No data to display'); ?>'
	})
});
g.getSelectionModel().on('rowselect', function(sm, rowIdx, r) {
	g.getTopToolbar().findById('edit-parent-stafftooktraining').enable();
	g.getTopToolbar().findById('delete-parent-stafftooktraining').enable();
        g.getTopToolbar().findById('view-stafftooktraining2').enable();
	if(this.getSelections().length > 1){
		g.getTopToolbar().findById('edit-parent-stafftooktraining').disable();
                g.getTopToolbar().findById('view-stafftooktraining2').disable();
	}
});
g.getSelectionModel().on('rowdeselect', function(sm, rowIdx, r) {
	if(this.getSelections().length > 1){
		g.getTopToolbar().findById('edit-parent-stafftooktraining').disable();
		g.getTopToolbar().findById('delete-parent-stafftooktraining').enable();
                g.getTopToolbar().findById('view-stafftooktraining2').disable();
	}
	else if(this.getSelections().length == 1){
		g.getTopToolbar().findById('edit-parent-stafftooktraining').enable();
		g.getTopToolbar().findById('delete-parent-stafftooktraining').enable();
                g.getTopToolbar().findById('view-stafftooktraining2').enable();
	}
	else{
		g.getTopToolbar().findById('edit-parent-stafftooktraining').disable();
		g.getTopToolbar().findById('delete-parent-stafftooktraining').disable();
                g.getTopToolbar().findById('view-stafftooktraining2').disable();
	}
});



var parentStafftooktrainingsViewWindow = new Ext.Window({
	title: 'Stafftooktraining Under the selected Item',
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
			parentStafftooktrainingsViewWindow.close();
		}
	}]
});

store_parent_stafftooktrainings.load({
    params: {
        start: 0,    
        limit: 100
    }
});