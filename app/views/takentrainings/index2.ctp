var store_parent_takentrainings = new Ext.data.Store({
	reader: new Ext.data.JsonReader({
		root:'rows',
		totalProperty: 'results',
		fields: [
			'id','training','from','to','half_day','trainingvenue','cost_per_person','trainer','trainingtarget','certification','created','modified'	
		]
	}),
	proxy: new Ext.data.HttpProxy({
		url: '<?php echo $this->Html->url(array('controller' => 'takentrainings', 'action' => 'list_data', $parent_id)); ?>'	})
});


function AddParentTakentraining() {
	Ext.Ajax.request({
		url: '<?php echo $this->Html->url(array('controller' => 'takentrainings', 'action' => 'add', $parent_id)); ?>',
		success: function(response, opts) {
			var parent_takentraining_data = response.responseText;
			
			eval(parent_takentraining_data);
			
			TakentrainingAddWindow.show();
		},
		failure: function(response, opts) {
			Ext.Msg.alert('<?php __('Error'); ?>', '<?php __('Cannot get the takentraining add form. Error code'); ?>: ' + response.status);
		}
	});
}

function EditParentTakentraining(id) {
	Ext.Ajax.request({
		url: '<?php echo $this->Html->url(array('controller' => 'takentrainings', 'action' => 'edit')); ?>/'+id+'/<?php echo $parent_id; ?>',
		success: function(response, opts) {
			var parent_takentraining_data = response.responseText;
			
			eval(parent_takentraining_data);
			
			TakentrainingEditWindow.show();
		},
		failure: function(response, opts) {
			Ext.Msg.alert('<?php __('Error'); ?>', '<?php __('Cannot get the takentraining edit form. Error code'); ?>: ' + response.status);
		}
	});
}

function ViewTakentraining(id) {
	Ext.Ajax.request({
		url: '<?php echo $this->Html->url(array('controller' => 'takentrainings', 'action' => 'view')); ?>/'+id,
		success: function(response, opts) {
			var takentraining_data = response.responseText;

			eval(takentraining_data);

			TakentrainingViewWindow.show();
		},
		failure: function(response, opts) {
			Ext.Msg.alert('<?php __('Error'); ?>', '<?php __('Cannot get the takentraining view form. Error code'); ?>: ' + response.status);
		}
	});
}

function ViewTakentrainingStafftooktrainings(id) {
	Ext.Ajax.request({
		url: '<?php echo $this->Html->url(array('controller' => 'stafftooktrainings', 'action' => 'index2')); ?>/'+id,
		success: function(response, opts) {
			var parent_stafftooktrainings_data = response.responseText;

			eval(parent_stafftooktrainings_data);

			parentStafftooktrainingsViewWindow.show();
		},
		failure: function(response, opts) {
			Ext.Msg.alert('<?php __('Error'); ?>', '<?php __('Cannot get the campus view form. Error code'); ?>: ' + response.status);
		}
	});
}


function DeleteParentTakentraining(id) {
	Ext.Ajax.request({
		url: '<?php echo $this->Html->url(array('controller' => 'takentrainings', 'action' => 'delete')); ?>/'+id,
		success: function(response, opts) {
			Ext.Msg.alert('<?php __('Success'); ?>', '<?php __('Takentraining(s) successfully deleted!'); ?>');
			RefreshParentTakentrainingData();
		},
		failure: function(response, opts) {
			Ext.Msg.alert('<?php __('Error'); ?>', '<?php __('Cannot get the takentraining to be deleted. Error code'); ?>: ' + response.status);
		}
	});
}

function SearchByParentTakentrainingName(value){
	var conditions = '\'Takentraining.name LIKE\' => \'%' + value + '%\'';
	store_parent_takentrainings.reload({
		 params: {
			start: 0,
			limit: list_size,
			conditions: conditions
	    }
	});
}

function RefreshParentTakentrainingData() {
	store_parent_takentrainings.reload();
}



var g = new Ext.grid.GridPanel({
	title: '<?php __('Takentrainings'); ?>',
	store: store_parent_takentrainings,
	loadMask: true,
	stripeRows: true,
	height: 300,
	anchor: '100%',
    id: 'takentrainingGrid',
	columns: [
		{header:"<?php __('training'); ?>", dataIndex: 'training', sortable: true},
		{header: "<?php __('From'); ?>", dataIndex: 'from', sortable: true},
		{header: "<?php __('To'); ?>", dataIndex: 'to', sortable: true},
		{header: "<?php __('Half Day'); ?>", dataIndex: 'half_day', sortable: true},
		{header:"<?php __('trainingvenue'); ?>", dataIndex: 'trainingvenue', sortable: true},
		{header: "<?php __('Cost Per Person'); ?>", dataIndex: 'cost_per_person', sortable: true},
		{header:"<?php __('trainer'); ?>", dataIndex: 'trainer', sortable: true},
		{header:"<?php __('trainingtarget'); ?>", dataIndex: 'trainingtarget', sortable: true},
		{header: "<?php __('Certification'); ?>", dataIndex: 'certification', sortable: true},
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
            ViewTakentraining(Ext.getCmp('takentrainingGrid').getSelectionModel().getSelected().data.id);
        }
    },
	tbar: new Ext.Toolbar({
		items: [{
				xtype: 'tbbutton',
				text: '<?php __('Add'); ?>',
				tooltip:'<?php __('<b>Add Takentraining</b><br />Click here to create a new Takentraining'); ?>',
				icon: 'img/table_add.png',
				cls: 'x-btn-text-icon',
				handler: function(btn) {
					AddParentTakentraining();
				}
			}, ' ', '-', ' ', {
				xtype: 'tbbutton',
				text: '<?php __('Edit'); ?>',
				id: 'edit-parent-takentraining',
				tooltip:'<?php __('<b>Edit Takentraining</b><br />Click here to modify the selected Takentraining'); ?>',
				icon: 'img/table_edit.png',
				cls: 'x-btn-text-icon',
				disabled: true,
				handler: function(btn) {
					var sm = g.getSelectionModel();
					var sel = sm.getSelected();
					if (sm.hasSelection()){
						EditParentTakentraining(sel.data.id);
					};
				}
			}, ' ', '-', ' ', {
				xtype: 'tbbutton',
				text: '<?php __('Delete'); ?>',
				id: 'delete-parent-takentraining',
				tooltip:'<?php __('<b>Delete Takentraining(s)</b><br />Click here to remove the selected Takentraining(s)'); ?>',
				icon: 'img/table_delete.png',
				cls: 'x-btn-text-icon',
				disabled: true,
				handler: function(btn) {
					var sm = g.getSelectionModel();
					var sel = sm.getSelections();
					if (sm.hasSelection()){
						if(sel.length==1){
							Ext.Msg.show({
									title: '<?php __('Remove Takentraining'); ?>',
									buttons: Ext.MessageBox.YESNOCANCEL,
									msg: '<?php __('Remove'); ?> '+sel[0].data.name+'?',
									icon: Ext.MessageBox.QUESTION,
                                    fn: function(btn){
											if (btn == 'yes'){
													DeleteParentTakentraining(sel[0].data.id);
											}
									}
							});
						} else {
							Ext.Msg.show({
									title: '<?php __('Remove Takentraining'); ?>',
									buttons: Ext.MessageBox.YESNOCANCEL,
									msg: '<?php __('Remove the selected Takentraining'); ?>?',
									icon: Ext.MessageBox.QUESTION,
                                    fn: function(btn){
											if (btn == 'yes'){
													var sel_ids = '';
													for(i=0;i<sel.length;i++){
														if(i>0)
															sel_ids += '_';
														sel_ids += sel[i].data.id;
													}
													DeleteParentTakentraining(sel_ids);
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
				text: '<?php __('View Takentraining'); ?>',
				id: 'view-takentraining2',
				tooltip:'<?php __('<b>View Takentraining</b><br />Click here to see details of the selected Takentraining'); ?>',
				icon: 'img/table_view.png',
				cls: 'x-btn-text-icon',
				disabled: true,
				handler: function(btn) {
					var sm = g.getSelectionModel();
					var sel = sm.getSelected();
					if (sm.hasSelection()){
						ViewTakentraining(sel.data.id);
					};
				},
				menu : {
					items: [
 {
						text: '<?php __('View Stafftooktrainings'); ?>',
                        icon: 'img/table_view.png',
						cls: 'x-btn-text-icon',
						handler: function(btn) {
							var sm = g.getSelectionModel();
							var sel = sm.getSelected();
							if (sm.hasSelection()){
								ViewTakentrainingStafftooktrainings(sel.data.id);
							};
						}
					}
					]
				}

            }, ' ', '->', {
				xtype: 'textfield',
				emptyText: '<?php __('[Search By Name]'); ?>',
				id: 'parent_takentraining_search_field',
				listeners: {
					specialkey: function(field, e){
						if (e.getKey() == e.ENTER) {
							SearchByParentTakentrainingName(Ext.getCmp('parent_takentraining_search_field').getValue());
						}
					}

				}
			}, {
				xtype: 'tbbutton',
				icon: 'img/search.png',
				cls: 'x-btn-text-icon',
				text: 'GO',
				tooltip:'<?php __('<b>GO</b><br />Click here to get search results'); ?>',
				id: 'parent_takentraining_go_button',
				handler: function(){
					SearchByParentTakentrainingName(Ext.getCmp('parent_takentraining_search_field').getValue());
				}
			}, ' '
	]}),
	bbar: new Ext.PagingToolbar({
		pageSize: list_size,
		store: store_parent_takentrainings,
		displayInfo: true,
		displayMsg: '<?php __('Displaying {0} - {1} of {2}'); ?>',
		beforePageText: '<?php __('Page'); ?>',
		afterPageText: '<?php __('of {0}'); ?>',
		emptyMsg: '<?php __('No data to display'); ?>'
	})
});
g.getSelectionModel().on('rowselect', function(sm, rowIdx, r) {
	g.getTopToolbar().findById('edit-parent-takentraining').enable();
	g.getTopToolbar().findById('delete-parent-takentraining').enable();
        g.getTopToolbar().findById('view-takentraining2').enable();
	if(this.getSelections().length > 1){
		g.getTopToolbar().findById('edit-parent-takentraining').disable();
                g.getTopToolbar().findById('view-takentraining2').disable();
	}
});
g.getSelectionModel().on('rowdeselect', function(sm, rowIdx, r) {
	if(this.getSelections().length > 1){
		g.getTopToolbar().findById('edit-parent-takentraining').disable();
		g.getTopToolbar().findById('delete-parent-takentraining').enable();
                g.getTopToolbar().findById('view-takentraining2').disable();
	}
	else if(this.getSelections().length == 1){
		g.getTopToolbar().findById('edit-parent-takentraining').enable();
		g.getTopToolbar().findById('delete-parent-takentraining').enable();
                g.getTopToolbar().findById('view-takentraining2').enable();
	}
	else{
		g.getTopToolbar().findById('edit-parent-takentraining').disable();
		g.getTopToolbar().findById('delete-parent-takentraining').disable();
                g.getTopToolbar().findById('view-takentraining2').disable();
	}
});



var parentTakentrainingsViewWindow = new Ext.Window({
	title: 'Takentraining Under the selected Item',
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
			parentTakentrainingsViewWindow.close();
		}
	}]
});

store_parent_takentrainings.load({
    params: {
        start: 0,    
        limit: list_size
    }
});