var store_parent_competenceDefinitions = new Ext.data.Store({
	reader: new Ext.data.JsonReader({
		root:'rows',
		totalProperty: 'results',
		fields: [
			'id','competence','competence_level','definition'	
		]
	}),
	proxy: new Ext.data.HttpProxy({
		url: '<?php echo $this->Html->url(array('controller' => 'competenceDefinitions', 'action' => 'list_data', $parent_id)); ?>'	})
});


function AddParentCompetenceDefinition() {
	Ext.Ajax.request({
		url: '<?php echo $this->Html->url(array('controller' => 'competenceDefinitions', 'action' => 'add', $parent_id)); ?>',
		success: function(response, opts) {
			var parent_competenceDefinition_data = response.responseText;
			
			eval(parent_competenceDefinition_data);
			
			CompetenceDefinitionAddWindow.show();
		},
		failure: function(response, opts) {
			Ext.Msg.alert('<?php __('Error'); ?>', '<?php __('Cannot get the competenceDefinition add form. Error code'); ?>: ' + response.status);
		}
	});
}

function EditParentCompetenceDefinition(id) {
	Ext.Ajax.request({
		url: '<?php echo $this->Html->url(array('controller' => 'competenceDefinitions', 'action' => 'edit')); ?>/'+id+'/<?php echo $parent_id; ?>',
		success: function(response, opts) {
			var parent_competenceDefinition_data = response.responseText;
			
			eval(parent_competenceDefinition_data);
			
			CompetenceDefinitionEditWindow.show();
		},
		failure: function(response, opts) {
			Ext.Msg.alert('<?php __('Error'); ?>', '<?php __('Cannot get the competenceDefinition edit form. Error code'); ?>: ' + response.status);
		}
	});
}

function ViewCompetenceDefinition(id) {
	Ext.Ajax.request({
		url: '<?php echo $this->Html->url(array('controller' => 'competenceDefinitions', 'action' => 'view')); ?>/'+id,
		success: function(response, opts) {
			var competenceDefinition_data = response.responseText;

			eval(competenceDefinition_data);

			CompetenceDefinitionViewWindow.show();
		},
		failure: function(response, opts) {
			Ext.Msg.alert('<?php __('Error'); ?>', '<?php __('Cannot get the competenceDefinition view form. Error code'); ?>: ' + response.status);
		}
	});
}


function DeleteParentCompetenceDefinition(id) {
	Ext.Ajax.request({
		url: '<?php echo $this->Html->url(array('controller' => 'competenceDefinitions', 'action' => 'delete')); ?>/'+id,
		success: function(response, opts) {
			Ext.Msg.alert('<?php __('Success'); ?>', '<?php __('CompetenceDefinition(s) successfully deleted!'); ?>');
			RefreshParentCompetenceDefinitionData();
		},
		failure: function(response, opts) {
			Ext.Msg.alert('<?php __('Error'); ?>', '<?php __('Cannot get the competenceDefinition to be deleted. Error code'); ?>: ' + response.status);
		}
	});
}

function SearchByParentCompetenceDefinitionName(value){
	var conditions = '\'CompetenceDefinition.name LIKE\' => \'%' + value + '%\'';
	store_parent_competenceDefinitions.reload({
		 params: {
			start: 0,
			limit: list_size,
			conditions: conditions
	    }
	});
}

function RefreshParentCompetenceDefinitionData() {
	store_parent_competenceDefinitions.reload();
}



var g = new Ext.grid.GridPanel({
	title: '<?php __('CompetenceDefinitions'); ?>',
	store: store_parent_competenceDefinitions,
	loadMask: true,
	stripeRows: true,
	height: 300,
	anchor: '100%',
    id: 'competenceDefinitionGrid',
	columns: [
		{header:"<?php __('competence'); ?>", dataIndex: 'competence', sortable: true},
		{header:"<?php __('competence_level'); ?>", dataIndex: 'competence_level', sortable: true},
		{header: "<?php __('Definition'); ?>", dataIndex: 'definition', sortable: true}	],
	sm: new Ext.grid.RowSelectionModel({
		singleSelect: false
	}),
	viewConfig: {
		forceFit: true
	},
    listeners: {
        celldblclick: function(){
            ViewCompetenceDefinition(Ext.getCmp('competenceDefinitionGrid').getSelectionModel().getSelected().data.id);
        }
    },
	tbar: new Ext.Toolbar({
		items: [{
				xtype: 'tbbutton',
				text: '<?php __('Add'); ?>',
				tooltip:'<?php __('<b>Add CompetenceDefinition</b><br />Click here to create a new CompetenceDefinition'); ?>',
				icon: 'img/table_add.png',
				cls: 'x-btn-text-icon',
				handler: function(btn) {
					AddParentCompetenceDefinition();
				}
			}, ' ', '-', ' ', {
				xtype: 'tbbutton',
				text: '<?php __('Edit'); ?>',
				id: 'edit-parent-competenceDefinition',
				tooltip:'<?php __('<b>Edit CompetenceDefinition</b><br />Click here to modify the selected CompetenceDefinition'); ?>',
				icon: 'img/table_edit.png',
				cls: 'x-btn-text-icon',
				disabled: true,
				handler: function(btn) {
					var sm = g.getSelectionModel();
					var sel = sm.getSelected();
					if (sm.hasSelection()){
						EditParentCompetenceDefinition(sel.data.id);
					};
				}
			}, ' ', '-', ' ', {
				xtype: 'tbbutton',
				text: '<?php __('Delete'); ?>',
				id: 'delete-parent-competenceDefinition',
				tooltip:'<?php __('<b>Delete CompetenceDefinition(s)</b><br />Click here to remove the selected CompetenceDefinition(s)'); ?>',
				icon: 'img/table_delete.png',
				cls: 'x-btn-text-icon',
				disabled: true,
				handler: function(btn) {
					var sm = g.getSelectionModel();
					var sel = sm.getSelections();
					if (sm.hasSelection()){
						if(sel.length==1){
							Ext.Msg.show({
									title: '<?php __('Remove CompetenceDefinition'); ?>',
									buttons: Ext.MessageBox.YESNOCANCEL,
									msg: '<?php __('Remove'); ?> '+sel[0].data.name+'?',
									icon: Ext.MessageBox.QUESTION,
                                    fn: function(btn){
											if (btn == 'yes'){
													DeleteParentCompetenceDefinition(sel[0].data.id);
											}
									}
							});
						} else {
							Ext.Msg.show({
									title: '<?php __('Remove CompetenceDefinition'); ?>',
									buttons: Ext.MessageBox.YESNOCANCEL,
									msg: '<?php __('Remove the selected CompetenceDefinition'); ?>?',
									icon: Ext.MessageBox.QUESTION,
                                    fn: function(btn){
											if (btn == 'yes'){
													var sel_ids = '';
													for(i=0;i<sel.length;i++){
														if(i>0)
															sel_ids += '_';
														sel_ids += sel[i].data.id;
													}
													DeleteParentCompetenceDefinition(sel_ids);
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
				text: '<?php __('View CompetenceDefinition'); ?>',
				id: 'view-competenceDefinition2',
				tooltip:'<?php __('<b>View CompetenceDefinition</b><br />Click here to see details of the selected CompetenceDefinition'); ?>',
				icon: 'img/table_view.png',
				cls: 'x-btn-text-icon',
				disabled: true,
				handler: function(btn) {
					var sm = g.getSelectionModel();
					var sel = sm.getSelected();
					if (sm.hasSelection()){
						ViewCompetenceDefinition(sel.data.id);
					};
				},
				menu : {
					items: [
					]
				}

            }, ' ', '->', {
				xtype: 'textfield',
				emptyText: '<?php __('[Search By Name]'); ?>',
				id: 'parent_competenceDefinition_search_field',
				listeners: {
					specialkey: function(field, e){
						if (e.getKey() == e.ENTER) {
							SearchByParentCompetenceDefinitionName(Ext.getCmp('parent_competenceDefinition_search_field').getValue());
						}
					}

				}
			}, {
				xtype: 'tbbutton',
				icon: 'img/search.png',
				cls: 'x-btn-text-icon',
				text: 'GO',
				tooltip:'<?php __('<b>GO</b><br />Click here to get search results'); ?>',
				id: 'parent_competenceDefinition_go_button',
				handler: function(){
					SearchByParentCompetenceDefinitionName(Ext.getCmp('parent_competenceDefinition_search_field').getValue());
				}
			}, ' '
	]}),
	bbar: new Ext.PagingToolbar({
		pageSize: list_size,
		store: store_parent_competenceDefinitions,
		displayInfo: true,
		displayMsg: '<?php __('Displaying {0} - {1} of {2}'); ?>',
		beforePageText: '<?php __('Page'); ?>',
		afterPageText: '<?php __('of {0}'); ?>',
		emptyMsg: '<?php __('No data to display'); ?>'
	})
});
g.getSelectionModel().on('rowselect', function(sm, rowIdx, r) {
	g.getTopToolbar().findById('edit-parent-competenceDefinition').enable();
	g.getTopToolbar().findById('delete-parent-competenceDefinition').enable();
        g.getTopToolbar().findById('view-competenceDefinition2').enable();
	if(this.getSelections().length > 1){
		g.getTopToolbar().findById('edit-parent-competenceDefinition').disable();
                g.getTopToolbar().findById('view-competenceDefinition2').disable();
	}
});
g.getSelectionModel().on('rowdeselect', function(sm, rowIdx, r) {
	if(this.getSelections().length > 1){
		g.getTopToolbar().findById('edit-parent-competenceDefinition').disable();
		g.getTopToolbar().findById('delete-parent-competenceDefinition').enable();
                g.getTopToolbar().findById('view-competenceDefinition2').disable();
	}
	else if(this.getSelections().length == 1){
		g.getTopToolbar().findById('edit-parent-competenceDefinition').enable();
		g.getTopToolbar().findById('delete-parent-competenceDefinition').enable();
                g.getTopToolbar().findById('view-competenceDefinition2').enable();
	}
	else{
		g.getTopToolbar().findById('edit-parent-competenceDefinition').disable();
		g.getTopToolbar().findById('delete-parent-competenceDefinition').disable();
                g.getTopToolbar().findById('view-competenceDefinition2').disable();
	}
});



var parentCompetenceDefinitionsViewWindow = new Ext.Window({
	title: 'CompetenceDefinition Under the selected Item',
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
			parentCompetenceDefinitionsViewWindow.close();
		}
	}]
});

store_parent_competenceDefinitions.load({
    params: {
        start: 0,    
        limit: list_size
    }
});