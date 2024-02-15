var store_parent_competenceSettings = new Ext.data.Store({
	reader: new Ext.data.JsonReader({
		root:'rows',
		totalProperty: 'results',
		fields: [
			'id','grade','competence','expected_competence','weight'	
		]
	}),
	proxy: new Ext.data.HttpProxy({
		url: '<?php echo $this->Html->url(array('controller' => 'competenceSettings', 'action' => 'list_data', $parent_id)); ?>'	})
});


function AddParentCompetenceSetting() {
	Ext.Ajax.request({
		url: '<?php echo $this->Html->url(array('controller' => 'competenceSettings', 'action' => 'add', $parent_id)); ?>',
		success: function(response, opts) {
			var parent_competenceSetting_data = response.responseText;
			
			eval(parent_competenceSetting_data);
			
			CompetenceSettingAddWindow.show();
		},
		failure: function(response, opts) {
			Ext.Msg.alert('<?php __('Error'); ?>', '<?php __('Cannot get the competenceSetting add form. Error code'); ?>: ' + response.status);
		}
	});
}

function EditParentCompetenceSetting(id) {
	Ext.Ajax.request({
		url: '<?php echo $this->Html->url(array('controller' => 'competenceSettings', 'action' => 'edit')); ?>/'+id+'/<?php echo $parent_id; ?>',
		success: function(response, opts) {
			var parent_competenceSetting_data = response.responseText;
			
			eval(parent_competenceSetting_data);
			
			CompetenceSettingEditWindow.show();
		},
		failure: function(response, opts) {
			Ext.Msg.alert('<?php __('Error'); ?>', '<?php __('Cannot get the competenceSetting edit form. Error code'); ?>: ' + response.status);
		}
	});
}

function ViewCompetenceSetting(id) {
	Ext.Ajax.request({
		url: '<?php echo $this->Html->url(array('controller' => 'competenceSettings', 'action' => 'view')); ?>/'+id,
		success: function(response, opts) {
			var competenceSetting_data = response.responseText;

			eval(competenceSetting_data);

			CompetenceSettingViewWindow.show();
		},
		failure: function(response, opts) {
			Ext.Msg.alert('<?php __('Error'); ?>', '<?php __('Cannot get the competenceSetting view form. Error code'); ?>: ' + response.status);
		}
	});
}


function DeleteParentCompetenceSetting(id) {
	Ext.Ajax.request({
		url: '<?php echo $this->Html->url(array('controller' => 'competenceSettings', 'action' => 'delete')); ?>/'+id,
		success: function(response, opts) {
			Ext.Msg.alert('<?php __('Success'); ?>', '<?php __('CompetenceSetting(s) successfully deleted!'); ?>');
			RefreshParentCompetenceSettingData();
		},
		failure: function(response, opts) {
			Ext.Msg.alert('<?php __('Error'); ?>', '<?php __('Cannot get the competenceSetting to be deleted. Error code'); ?>: ' + response.status);
		}
	});
}

function SearchByParentCompetenceSettingName(value){
	var conditions = '\'CompetenceSetting.name LIKE\' => \'%' + value + '%\'';
	store_parent_competenceSettings.reload({
		 params: {
			start: 0,
			limit: list_size,
			conditions: conditions
	    }
	});
}

function RefreshParentCompetenceSettingData() {
	store_parent_competenceSettings.reload();
}



var g = new Ext.grid.GridPanel({
	title: '<?php __('CompetenceSettings'); ?>',
	store: store_parent_competenceSettings,
	loadMask: true,
	stripeRows: true,
	height: 300,
	anchor: '100%',
    id: 'competenceSettingGrid',
	columns: [
		{header:"<?php __('grade'); ?>", dataIndex: 'grade', sortable: true},
		{header:"<?php __('competence'); ?>", dataIndex: 'competence', sortable: true},
		{header: "<?php __('Expected Competence'); ?>", dataIndex: 'expected_competence', sortable: true},
		{header: "<?php __('Weight'); ?>", dataIndex: 'weight', sortable: true}	],
	sm: new Ext.grid.RowSelectionModel({
		singleSelect: false
	}),
	viewConfig: {
		forceFit: true
	},
    listeners: {
        celldblclick: function(){
            ViewCompetenceSetting(Ext.getCmp('competenceSettingGrid').getSelectionModel().getSelected().data.id);
        }
    },
	tbar: new Ext.Toolbar({
		items: [{
				xtype: 'tbbutton',
				text: '<?php __('Add'); ?>',
				tooltip:'<?php __('<b>Add CompetenceSetting</b><br />Click here to create a new CompetenceSetting'); ?>',
				icon: 'img/table_add.png',
				cls: 'x-btn-text-icon',
				handler: function(btn) {
					AddParentCompetenceSetting();
				}
			}, ' ', '-', ' ', {
				xtype: 'tbbutton',
				text: '<?php __('Edit'); ?>',
				id: 'edit-parent-competenceSetting',
				tooltip:'<?php __('<b>Edit CompetenceSetting</b><br />Click here to modify the selected CompetenceSetting'); ?>',
				icon: 'img/table_edit.png',
				cls: 'x-btn-text-icon',
				disabled: true,
				handler: function(btn) {
					var sm = g.getSelectionModel();
					var sel = sm.getSelected();
					if (sm.hasSelection()){
						EditParentCompetenceSetting(sel.data.id);
					};
				}
			}, ' ', '-', ' ', {
				xtype: 'tbbutton',
				text: '<?php __('Delete'); ?>',
				id: 'delete-parent-competenceSetting',
				tooltip:'<?php __('<b>Delete CompetenceSetting(s)</b><br />Click here to remove the selected CompetenceSetting(s)'); ?>',
				icon: 'img/table_delete.png',
				cls: 'x-btn-text-icon',
				disabled: true,
				handler: function(btn) {
					var sm = g.getSelectionModel();
					var sel = sm.getSelections();
					if (sm.hasSelection()){
						if(sel.length==1){
							Ext.Msg.show({
									title: '<?php __('Remove CompetenceSetting'); ?>',
									buttons: Ext.MessageBox.YESNOCANCEL,
									msg: '<?php __('Remove'); ?> '+sel[0].data.name+'?',
									icon: Ext.MessageBox.QUESTION,
                                    fn: function(btn){
											if (btn == 'yes'){
													DeleteParentCompetenceSetting(sel[0].data.id);
											}
									}
							});
						} else {
							Ext.Msg.show({
									title: '<?php __('Remove CompetenceSetting'); ?>',
									buttons: Ext.MessageBox.YESNOCANCEL,
									msg: '<?php __('Remove the selected CompetenceSetting'); ?>?',
									icon: Ext.MessageBox.QUESTION,
                                    fn: function(btn){
											if (btn == 'yes'){
													var sel_ids = '';
													for(i=0;i<sel.length;i++){
														if(i>0)
															sel_ids += '_';
														sel_ids += sel[i].data.id;
													}
													DeleteParentCompetenceSetting(sel_ids);
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
				text: '<?php __('View CompetenceSetting'); ?>',
				id: 'view-competenceSetting2',
				tooltip:'<?php __('<b>View CompetenceSetting</b><br />Click here to see details of the selected CompetenceSetting'); ?>',
				icon: 'img/table_view.png',
				cls: 'x-btn-text-icon',
				disabled: true,
				handler: function(btn) {
					var sm = g.getSelectionModel();
					var sel = sm.getSelected();
					if (sm.hasSelection()){
						ViewCompetenceSetting(sel.data.id);
					};
				},
				menu : {
					items: [
					]
				}

            }, ' ', '->', {
				xtype: 'textfield',
				emptyText: '<?php __('[Search By Name]'); ?>',
				id: 'parent_competenceSetting_search_field',
				listeners: {
					specialkey: function(field, e){
						if (e.getKey() == e.ENTER) {
							SearchByParentCompetenceSettingName(Ext.getCmp('parent_competenceSetting_search_field').getValue());
						}
					}

				}
			}, {
				xtype: 'tbbutton',
				icon: 'img/search.png',
				cls: 'x-btn-text-icon',
				text: 'GO',
				tooltip:'<?php __('<b>GO</b><br />Click here to get search results'); ?>',
				id: 'parent_competenceSetting_go_button',
				handler: function(){
					SearchByParentCompetenceSettingName(Ext.getCmp('parent_competenceSetting_search_field').getValue());
				}
			}, ' '
	]}),
	bbar: new Ext.PagingToolbar({
		pageSize: list_size,
		store: store_parent_competenceSettings,
		displayInfo: true,
		displayMsg: '<?php __('Displaying {0} - {1} of {2}'); ?>',
		beforePageText: '<?php __('Page'); ?>',
		afterPageText: '<?php __('of {0}'); ?>',
		emptyMsg: '<?php __('No data to display'); ?>'
	})
});
g.getSelectionModel().on('rowselect', function(sm, rowIdx, r) {
	g.getTopToolbar().findById('edit-parent-competenceSetting').enable();
	g.getTopToolbar().findById('delete-parent-competenceSetting').enable();
        g.getTopToolbar().findById('view-competenceSetting2').enable();
	if(this.getSelections().length > 1){
		g.getTopToolbar().findById('edit-parent-competenceSetting').disable();
                g.getTopToolbar().findById('view-competenceSetting2').disable();
	}
});
g.getSelectionModel().on('rowdeselect', function(sm, rowIdx, r) {
	if(this.getSelections().length > 1){
		g.getTopToolbar().findById('edit-parent-competenceSetting').disable();
		g.getTopToolbar().findById('delete-parent-competenceSetting').enable();
                g.getTopToolbar().findById('view-competenceSetting2').disable();
	}
	else if(this.getSelections().length == 1){
		g.getTopToolbar().findById('edit-parent-competenceSetting').enable();
		g.getTopToolbar().findById('delete-parent-competenceSetting').enable();
                g.getTopToolbar().findById('view-competenceSetting2').enable();
	}
	else{
		g.getTopToolbar().findById('edit-parent-competenceSetting').disable();
		g.getTopToolbar().findById('delete-parent-competenceSetting').disable();
                g.getTopToolbar().findById('view-competenceSetting2').disable();
	}
});



var parentCompetenceSettingsViewWindow = new Ext.Window({
	title: 'CompetenceSetting Under the selected Item',
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
			parentCompetenceSettingsViewWindow.close();
		}
	}]
});

store_parent_competenceSettings.load({
    params: {
        start: 0,    
        limit: list_size
    }
});