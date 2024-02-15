var store_parent_competences = new Ext.data.Store({
	reader: new Ext.data.JsonReader({
		root:'rows',
		totalProperty: 'results',
		fields: [
			'id','name','definition','competence_category'	
		]
	}),
	proxy: new Ext.data.HttpProxy({
		url: '<?php echo $this->Html->url(array('controller' => 'competences', 'action' => 'list_data', $parent_id)); ?>'	})
});


function AddParentCompetence() {
	Ext.Ajax.request({
		url: '<?php echo $this->Html->url(array('controller' => 'competences', 'action' => 'add', $parent_id)); ?>',
		success: function(response, opts) {
			var parent_competence_data = response.responseText;
			
			eval(parent_competence_data);
			
			CompetenceAddWindow.show();
		},
		failure: function(response, opts) {
			Ext.Msg.alert('<?php __('Error'); ?>', '<?php __('Cannot get the competence add form. Error code'); ?>: ' + response.status);
		}
	});
}

function EditParentCompetence(id) {
	Ext.Ajax.request({
		url: '<?php echo $this->Html->url(array('controller' => 'competences', 'action' => 'edit')); ?>/'+id+'/<?php echo $parent_id; ?>',
		success: function(response, opts) {
			var parent_competence_data = response.responseText;
			
			eval(parent_competence_data);
			
			CompetenceEditWindow.show();
		},
		failure: function(response, opts) {
			Ext.Msg.alert('<?php __('Error'); ?>', '<?php __('Cannot get the competence edit form. Error code'); ?>: ' + response.status);
		}
	});
}

function ViewCompetence(id) {
	Ext.Ajax.request({
		url: '<?php echo $this->Html->url(array('controller' => 'competences', 'action' => 'view')); ?>/'+id,
		success: function(response, opts) {
			var competence_data = response.responseText;

			eval(competence_data);

			CompetenceViewWindow.show();
		},
		failure: function(response, opts) {
			Ext.Msg.alert('<?php __('Error'); ?>', '<?php __('Cannot get the competence view form. Error code'); ?>: ' + response.status);
		}
	});
}


function DeleteParentCompetence(id) {
	Ext.Ajax.request({
		url: '<?php echo $this->Html->url(array('controller' => 'competences', 'action' => 'delete')); ?>/'+id,
		success: function(response, opts) {
			Ext.Msg.alert('<?php __('Success'); ?>', '<?php __('Competence(s) successfully deleted!'); ?>');
			RefreshParentCompetenceData();
		},
		failure: function(response, opts) {
			Ext.Msg.alert('<?php __('Error'); ?>', '<?php __('Cannot get the competence to be deleted. Error code'); ?>: ' + response.status);
		}
	});
}

function SearchByParentCompetenceName(value){
	var conditions = '\'Competence.name LIKE\' => \'%' + value + '%\'';
	store_parent_competences.reload({
		 params: {
			start: 0,
			limit: list_size,
			conditions: conditions
	    }
	});
}

function RefreshParentCompetenceData() {
	store_parent_competences.reload();
}



var g = new Ext.grid.GridPanel({
	title: '<?php __('Competences'); ?>',
	store: store_parent_competences,
	loadMask: true,
	stripeRows: true,
	height: 300,
	anchor: '100%',
    id: 'competenceGrid',
	columns: [
		{header: "<?php __('Name'); ?>", dataIndex: 'name', sortable: true},
		{header: "<?php __('Definition'); ?>", dataIndex: 'definition', sortable: true},
		{header:"<?php __('competence_category'); ?>", dataIndex: 'competence_category', sortable: true}	],
	sm: new Ext.grid.RowSelectionModel({
		singleSelect: false
	}),
	viewConfig: {
		forceFit: true
	},
    listeners: {
        celldblclick: function(){
            ViewCompetence(Ext.getCmp('competenceGrid').getSelectionModel().getSelected().data.id);
        }
    },
	tbar: new Ext.Toolbar({
		items: [{
				xtype: 'tbbutton',
				text: '<?php __('Add'); ?>',
				tooltip:'<?php __('<b>Add Competence</b><br />Click here to create a new Competence'); ?>',
				icon: 'img/table_add.png',
				cls: 'x-btn-text-icon',
				handler: function(btn) {
					AddParentCompetence();
				}
			}, ' ', '-', ' ', {
				xtype: 'tbbutton',
				text: '<?php __('Edit'); ?>',
				id: 'edit-parent-competence',
				tooltip:'<?php __('<b>Edit Competence</b><br />Click here to modify the selected Competence'); ?>',
				icon: 'img/table_edit.png',
				cls: 'x-btn-text-icon',
				disabled: true,
				handler: function(btn) {
					var sm = g.getSelectionModel();
					var sel = sm.getSelected();
					if (sm.hasSelection()){
						EditParentCompetence(sel.data.id);
					};
				}
			}, ' ', '-', ' ', {
				xtype: 'tbbutton',
				text: '<?php __('Delete'); ?>',
				id: 'delete-parent-competence',
				tooltip:'<?php __('<b>Delete Competence(s)</b><br />Click here to remove the selected Competence(s)'); ?>',
				icon: 'img/table_delete.png',
				cls: 'x-btn-text-icon',
				disabled: true,
				handler: function(btn) {
					var sm = g.getSelectionModel();
					var sel = sm.getSelections();
					if (sm.hasSelection()){
						if(sel.length==1){
							Ext.Msg.show({
									title: '<?php __('Remove Competence'); ?>',
									buttons: Ext.MessageBox.YESNOCANCEL,
									msg: '<?php __('Remove'); ?> '+sel[0].data.name+'?',
									icon: Ext.MessageBox.QUESTION,
                                    fn: function(btn){
											if (btn == 'yes'){
													DeleteParentCompetence(sel[0].data.id);
											}
									}
							});
						} else {
							Ext.Msg.show({
									title: '<?php __('Remove Competence'); ?>',
									buttons: Ext.MessageBox.YESNOCANCEL,
									msg: '<?php __('Remove the selected Competence'); ?>?',
									icon: Ext.MessageBox.QUESTION,
                                    fn: function(btn){
											if (btn == 'yes'){
													var sel_ids = '';
													for(i=0;i<sel.length;i++){
														if(i>0)
															sel_ids += '_';
														sel_ids += sel[i].data.id;
													}
													DeleteParentCompetence(sel_ids);
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
				text: '<?php __('View Competence'); ?>',
				id: 'view-competence2',
				tooltip:'<?php __('<b>View Competence</b><br />Click here to see details of the selected Competence'); ?>',
				icon: 'img/table_view.png',
				cls: 'x-btn-text-icon',
				disabled: true,
				handler: function(btn) {
					var sm = g.getSelectionModel();
					var sel = sm.getSelected();
					if (sm.hasSelection()){
						ViewCompetence(sel.data.id);
					};
				},
				menu : {
					items: [
					]
				}

            }, ' ', '->', {
				xtype: 'textfield',
				emptyText: '<?php __('[Search By Name]'); ?>',
				id: 'parent_competence_search_field',
				listeners: {
					specialkey: function(field, e){
						if (e.getKey() == e.ENTER) {
							SearchByParentCompetenceName(Ext.getCmp('parent_competence_search_field').getValue());
						}
					}

				}
			}, {
				xtype: 'tbbutton',
				icon: 'img/search.png',
				cls: 'x-btn-text-icon',
				text: 'GO',
				tooltip:'<?php __('<b>GO</b><br />Click here to get search results'); ?>',
				id: 'parent_competence_go_button',
				handler: function(){
					SearchByParentCompetenceName(Ext.getCmp('parent_competence_search_field').getValue());
				}
			}, ' '
	]}),
	bbar: new Ext.PagingToolbar({
		pageSize: list_size,
		store: store_parent_competences,
		displayInfo: true,
		displayMsg: '<?php __('Displaying {0} - {1} of {2}'); ?>',
		beforePageText: '<?php __('Page'); ?>',
		afterPageText: '<?php __('of {0}'); ?>',
		emptyMsg: '<?php __('No data to display'); ?>'
	})
});
g.getSelectionModel().on('rowselect', function(sm, rowIdx, r) {
	g.getTopToolbar().findById('edit-parent-competence').enable();
	g.getTopToolbar().findById('delete-parent-competence').enable();
        g.getTopToolbar().findById('view-competence2').enable();
	if(this.getSelections().length > 1){
		g.getTopToolbar().findById('edit-parent-competence').disable();
                g.getTopToolbar().findById('view-competence2').disable();
	}
});
g.getSelectionModel().on('rowdeselect', function(sm, rowIdx, r) {
	if(this.getSelections().length > 1){
		g.getTopToolbar().findById('edit-parent-competence').disable();
		g.getTopToolbar().findById('delete-parent-competence').enable();
                g.getTopToolbar().findById('view-competence2').disable();
	}
	else if(this.getSelections().length == 1){
		g.getTopToolbar().findById('edit-parent-competence').enable();
		g.getTopToolbar().findById('delete-parent-competence').enable();
                g.getTopToolbar().findById('view-competence2').enable();
	}
	else{
		g.getTopToolbar().findById('edit-parent-competence').disable();
		g.getTopToolbar().findById('delete-parent-competence').disable();
                g.getTopToolbar().findById('view-competence2').disable();
	}
});



var parentCompetencesViewWindow = new Ext.Window({
	title: 'Competence Under the selected Item',
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
			parentCompetencesViewWindow.close();
		}
	}]
});

store_parent_competences.load({
    params: {
        start: 0,    
        limit: list_size
    }
});