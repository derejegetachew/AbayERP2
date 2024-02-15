var store_parent_terminations = new Ext.data.Store({
	reader: new Ext.data.JsonReader({
		root:'rows',
		totalProperty: 'results',
		fields: [
			'id','employee','reason','date','note'	
		]
	}),
	proxy: new Ext.data.HttpProxy({
		url: '<?php echo $this->Html->url(array('controller' => 'terminations', 'action' => 'list_data', $parent_id)); ?>'	})
});


function AddParentTermination() {
	Ext.Ajax.request({
		url: '<?php echo $this->Html->url(array('controller' => 'terminations', 'action' => 'add', $parent_id)); ?>',
		success: function(response, opts) {
			var parent_termination_data = response.responseText;
			
			eval(parent_termination_data);
			
			TerminationAddWindow.show();
		},
		failure: function(response, opts) {
			Ext.Msg.alert('<?php __('Error'); ?>', '<?php __('Cannot get the termination add form. Error code'); ?>: ' + response.status);
		}
	});
}

function EditParentTermination(id) {
	Ext.Ajax.request({
		url: '<?php echo $this->Html->url(array('controller' => 'terminations', 'action' => 'edit')); ?>/'+id+'/<?php echo $parent_id; ?>',
		success: function(response, opts) {
			var parent_termination_data = response.responseText;
			
			eval(parent_termination_data);
			
			TerminationEditWindow.show();
		},
		failure: function(response, opts) {
			Ext.Msg.alert('<?php __('Error'); ?>', '<?php __('Cannot get the termination edit form. Error code'); ?>: ' + response.status);
		}
	});
}

function ViewTermination(id) {
	Ext.Ajax.request({
		url: '<?php echo $this->Html->url(array('controller' => 'terminations', 'action' => 'view')); ?>/'+id,
		success: function(response, opts) {
			var termination_data = response.responseText;

			eval(termination_data);

			TerminationViewWindow.show();
		},
		failure: function(response, opts) {
			Ext.Msg.alert('<?php __('Error'); ?>', '<?php __('Cannot get the termination view form. Error code'); ?>: ' + response.status);
		}
	});
}


function DeleteParentTermination(id) {
	Ext.Ajax.request({
		url: '<?php echo $this->Html->url(array('controller' => 'terminations', 'action' => 'delete')); ?>/'+id,
		success: function(response, opts) {
			Ext.Msg.alert('<?php __('Success'); ?>', '<?php __('Termination(s) successfully deleted!'); ?>');
			RefreshParentTerminationData();
		},
		failure: function(response, opts) {
			Ext.Msg.alert('<?php __('Error'); ?>', '<?php __('Cannot get the termination to be deleted. Error code'); ?>: ' + response.status);
		}
	});
}

function SearchByParentTerminationName(value){
	var conditions = '\'Termination.name LIKE\' => \'%' + value + '%\'';
	store_parent_terminations.reload({
		 params: {
			start: 0,
			limit: list_size,
			conditions: conditions
	    }
	});
}

function RefreshParentTerminationData() {
	store_parent_terminations.reload();
}



var g = new Ext.grid.GridPanel({
	title: '<?php __('Terminations'); ?>',
	store: store_parent_terminations,
	loadMask: true,
	stripeRows: true,
	height: 300,
	anchor: '100%',
    id: 'terminationGrid',
	columns: [
		{header:"<?php __('employee'); ?>", dataIndex: 'employee', sortable: true},
		{header: "<?php __('Reason'); ?>", dataIndex: 'reason', sortable: true},
		{header: "<?php __('Date'); ?>", dataIndex: 'date', sortable: true},
		{header: "<?php __('Note'); ?>", dataIndex: 'note', sortable: true}	],
	sm: new Ext.grid.RowSelectionModel({
		singleSelect: false
	}),
	viewConfig: {
		forceFit: true
	},
    listeners: {
        celldblclick: function(){
            ViewTermination(Ext.getCmp('terminationGrid').getSelectionModel().getSelected().data.id);
        }
    },
	tbar: new Ext.Toolbar({
		items: [{
				xtype: 'tbbutton',
				text: '<?php __('Add'); ?>',
				tooltip:'<?php __('<b>Add Termination</b><br />Click here to create a new Termination'); ?>',
				icon: 'img/table_add.png',
				cls: 'x-btn-text-icon',
				handler: function(btn) {
					AddParentTermination();
				}
			}, ' ', '-', ' ', {
				xtype: 'tbbutton',
				text: '<?php __('Edit'); ?>',
				id: 'edit-parent-termination',
				tooltip:'<?php __('<b>Edit Termination</b><br />Click here to modify the selected Termination'); ?>',
				icon: 'img/table_edit.png',
				cls: 'x-btn-text-icon',
				disabled: true,
				handler: function(btn) {
					var sm = g.getSelectionModel();
					var sel = sm.getSelected();
					if (sm.hasSelection()){
						EditParentTermination(sel.data.id);
					};
				}
			}, ' ', '-', ' ', {
				xtype: 'tbbutton',
				text: '<?php __('Delete'); ?>',
				id: 'delete-parent-termination',
				tooltip:'<?php __('<b>Delete Termination(s)</b><br />Click here to remove the selected Termination(s)'); ?>',
				icon: 'img/table_delete.png',
				cls: 'x-btn-text-icon',
				disabled: true,
				handler: function(btn) {
					var sm = g.getSelectionModel();
					var sel = sm.getSelections();
					if (sm.hasSelection()){
						if(sel.length==1){
							Ext.Msg.show({
									title: '<?php __('Remove Termination'); ?>',
									buttons: Ext.MessageBox.YESNOCANCEL,
									msg: '<?php __('Remove'); ?> '+sel[0].data.name+'?',
									icon: Ext.MessageBox.QUESTION,
                                    fn: function(btn){
											if (btn == 'yes'){
													DeleteParentTermination(sel[0].data.id);
											}
									}
							});
						} else {
							Ext.Msg.show({
									title: '<?php __('Remove Termination'); ?>',
									buttons: Ext.MessageBox.YESNOCANCEL,
									msg: '<?php __('Remove the selected Termination'); ?>?',
									icon: Ext.MessageBox.QUESTION,
                                    fn: function(btn){
											if (btn == 'yes'){
													var sel_ids = '';
													for(i=0;i<sel.length;i++){
														if(i>0)
															sel_ids += '_';
														sel_ids += sel[i].data.id;
													}
													DeleteParentTermination(sel_ids);
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
				text: '<?php __('View Termination'); ?>',
				id: 'view-termination2',
				tooltip:'<?php __('<b>View Termination</b><br />Click here to see details of the selected Termination'); ?>',
				icon: 'img/table_view.png',
				cls: 'x-btn-text-icon',
				disabled: true,
				handler: function(btn) {
					var sm = g.getSelectionModel();
					var sel = sm.getSelected();
					if (sm.hasSelection()){
						ViewTermination(sel.data.id);
					};
				},
				menu : {
					items: [
					]
				}

            }, ' ', '->', {
				xtype: 'textfield',
				emptyText: '<?php __('[Search By Name]'); ?>',
				id: 'parent_termination_search_field',
				listeners: {
					specialkey: function(field, e){
						if (e.getKey() == e.ENTER) {
							SearchByParentTerminationName(Ext.getCmp('parent_termination_search_field').getValue());
						}
					}

				}
			}, {
				xtype: 'tbbutton',
				icon: 'img/search.png',
				cls: 'x-btn-text-icon',
				text: 'GO',
				tooltip:'<?php __('<b>GO</b><br />Click here to get search results'); ?>',
				id: 'parent_termination_go_button',
				handler: function(){
					SearchByParentTerminationName(Ext.getCmp('parent_termination_search_field').getValue());
				}
			}, ' '
	]}),
	bbar: new Ext.PagingToolbar({
		pageSize: list_size,
		store: store_parent_terminations,
		displayInfo: true,
		displayMsg: '<?php __('Displaying {0} - {1} of {2}'); ?>',
		beforePageText: '<?php __('Page'); ?>',
		afterPageText: '<?php __('of {0}'); ?>',
		emptyMsg: '<?php __('No data to display'); ?>'
	})
});
g.getSelectionModel().on('rowselect', function(sm, rowIdx, r) {
	g.getTopToolbar().findById('edit-parent-termination').enable();
	g.getTopToolbar().findById('delete-parent-termination').enable();
        g.getTopToolbar().findById('view-termination2').enable();
	if(this.getSelections().length > 1){
		g.getTopToolbar().findById('edit-parent-termination').disable();
                g.getTopToolbar().findById('view-termination2').disable();
	}
});
g.getSelectionModel().on('rowdeselect', function(sm, rowIdx, r) {
	if(this.getSelections().length > 1){
		g.getTopToolbar().findById('edit-parent-termination').disable();
		g.getTopToolbar().findById('delete-parent-termination').enable();
                g.getTopToolbar().findById('view-termination2').disable();
	}
	else if(this.getSelections().length == 1){
		g.getTopToolbar().findById('edit-parent-termination').enable();
		g.getTopToolbar().findById('delete-parent-termination').enable();
                g.getTopToolbar().findById('view-termination2').enable();
	}
	else{
		g.getTopToolbar().findById('edit-parent-termination').disable();
		g.getTopToolbar().findById('delete-parent-termination').disable();
                g.getTopToolbar().findById('view-termination2').disable();
	}
});



var parentTerminationsViewWindow = new Ext.Window({
	title: 'Termination Under the selected Item',
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
			parentTerminationsViewWindow.close();
		}
	}]
});

store_parent_terminations.load({
    params: {
        start: 0,    
        limit: list_size
    }
});