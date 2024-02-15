
var store_competenceLevels = new Ext.data.Store({
	reader: new Ext.data.JsonReader({
		root:'rows',
		totalProperty: 'results',
		fields: [
			'id','name'		]
	}),
	proxy: new Ext.data.HttpProxy({
		url: '<?php echo $this->Html->url(array('controller' => 'competenceLevels', 'action' => 'list_data')); ?>'
	})
});


function AddCompetenceLevel() {
	Ext.Ajax.request({
		url: '<?php echo $this->Html->url(array('controller' => 'competenceLevels', 'action' => 'add')); ?>',
		success: function(response, opts) {
			var competenceLevel_data = response.responseText;
			
			eval(competenceLevel_data);
			
			CompetenceLevelAddWindow.show();
		},
		failure: function(response, opts) {
			Ext.Msg.alert('<?php __('Error'); ?>', '<?php __('Cannot get the competenceLevel add form. Error code'); ?>: ' + response.status);
		}
	});
}

function EditCompetenceLevel(id) {
	Ext.Ajax.request({
		url: '<?php echo $this->Html->url(array('controller' => 'competenceLevels', 'action' => 'edit')); ?>/'+id,
		success: function(response, opts) {
			var competenceLevel_data = response.responseText;
			
			eval(competenceLevel_data);
			
			CompetenceLevelEditWindow.show();
		},
		failure: function(response, opts) {
			Ext.Msg.alert('<?php __('Error'); ?>', '<?php __('Cannot get the competenceLevel edit form. Error code'); ?>: ' + response.status);
		}
	});
}

function ViewCompetenceLevel(id) {
    Ext.Ajax.request({
        url: '<?php echo $this->Html->url(array('controller' => 'competenceLevels', 'action' => 'view')); ?>/'+id,
        success: function(response, opts) {
            var competenceLevel_data = response.responseText;

            eval(competenceLevel_data);

            CompetenceLevelViewWindow.show();
        },
        failure: function(response, opts) {
            Ext.Msg.alert('<?php __('Error'); ?>', '<?php __('Cannot get the competenceLevel view form. Error code'); ?>: ' + response.status);
        }
    });
}

function DeleteCompetenceLevel(id) {
	Ext.Ajax.request({
		url: '<?php echo $this->Html->url(array('controller' => 'competenceLevels', 'action' => 'delete')); ?>/'+id,
		success: function(response, opts) {
			Ext.Msg.alert('<?php __('Success'); ?>', '<?php __('CompetenceLevel successfully deleted!'); ?>');
			RefreshCompetenceLevelData();
		},
		failure: function(response, opts) {
			Ext.Msg.alert('<?php __('Error'); ?>', '<?php __('Cannot get the competenceLevel add form. Error code'); ?>: ' + response.status);
		}
	});
}

function SearchCompetenceLevel(){
	Ext.Ajax.request({
		url: '<?php echo $this->Html->url(array('controller' => 'competenceLevels', 'action' => 'search')); ?>',
		success: function(response, opts){
			var competenceLevel_data = response.responseText;

			eval(competenceLevel_data);

			competenceLevelSearchWindow.show();
		},
		failure: function(response, opts) {
			Ext.Msg.alert('<?php __('Error'); ?>','<?php __('Cannot get the competenceLevel search form. Error Code'); ?>: ' + response.status);
		}
	});
}

function SearchByCompetenceLevelName(value){
	var conditions = '\'CompetenceLevel.name LIKE\' => \'%' + value + '%\'';
	store_competenceLevels.reload({
		 params: {
			start: 0,
			limit: list_size,
			conditions: conditions
	    }
	});
}

function RefreshCompetenceLevelData() {
	store_competenceLevels.reload();
}


if(center_panel.find('id', 'competenceLevel-tab') != "") {
	var p = center_panel.findById('competenceLevel-tab');
	center_panel.setActiveTab(p);
} else {
	var p = center_panel.add({
		title: '<?php __('Competence Levels'); ?>',
		closable: true,
		loadMask: true,
		stripeRows: true,
		id: 'competenceLevel-tab',
		xtype: 'grid',
		store: store_competenceLevels,
		columns: [
			{header: "<?php __('Name'); ?>", dataIndex: 'name', sortable: true}
		],
		viewConfig: {
			forceFit: true
		}
,
		listeners: {
			celldblclick: function(){
				ViewCompetenceLevel(Ext.getCmp('competenceLevel-tab').getSelectionModel().getSelected().data.id);
			}
		},
		sm: new Ext.grid.RowSelectionModel({
			singleSelect: false
		}),
		tbar: new Ext.Toolbar({
			
			items: [{
					xtype: 'tbbutton',
					text: '<?php __('Add'); ?>',
					tooltip:'<?php __('<b>Add CompetenceLevels</b><br />Click here to create a new CompetenceLevel'); ?>',
					icon: 'img/table_add.png',
					cls: 'x-btn-text-icon',
					handler: function(btn) {
						AddCompetenceLevel();
					}
				}, ' ', '-', ' ', {
					xtype: 'tbbutton',
					text: '<?php __('Edit'); ?>',
					id: 'edit-competenceLevel',
					tooltip:'<?php __('<b>Edit CompetenceLevels</b><br />Click here to modify the selected CompetenceLevel'); ?>',
					icon: 'img/table_edit.png',
					cls: 'x-btn-text-icon',
					disabled: true,
					handler: function(btn) {
						var sm = p.getSelectionModel();
						var sel = sm.getSelected();
						if (sm.hasSelection()){
							EditCompetenceLevel(sel.data.id);
						};
					}
				}, ' ', '-', ' ', {
					xtype: 'tbbutton',
					text: '<?php __('Delete'); ?>',
					id: 'delete-competenceLevel',
					tooltip:'<?php __('<b>Delete CompetenceLevels(s)</b><br />Click here to remove the selected CompetenceLevel(s)'); ?>',
					icon: 'img/table_delete.png',
					cls: 'x-btn-text-icon',
					disabled: true,
					handler: function(btn) {
						var sm = p.getSelectionModel();
						var sel = sm.getSelections();
						if (sm.hasSelection()){
							if(sel.length==1){
								Ext.Msg.show({
									title: '<?php __('Remove CompetenceLevel'); ?>',
									buttons: Ext.MessageBox.YESNO,
									msg: '<?php __('Remove'); ?> '+sel[0].data.name+'?',
									icon: Ext.MessageBox.QUESTION,
									fn: function(btn){
										if (btn == 'yes'){
										//	DeleteCompetenceLevel(sel[0].data.id);
										}
									}
								});
							}else{
								Ext.Msg.show({
									title: '<?php __('Remove CompetenceLevel'); ?>',
									buttons: Ext.MessageBox.YESNO,
									msg: '<?php __('Remove the selected CompetenceLevels'); ?>?',
									icon: Ext.MessageBox.QUESTION,
									fn: function(btn){
										if (btn == 'yes'){
											var sel_ids = '';
											for(i=0;i<sel.length;i++){
												if(i>0)
													sel_ids += '_';
												sel_ids += sel[i].data.id;
											}
										//	DeleteCompetenceLevel(sel_ids);
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
					text: '<?php __('View CompetenceLevel'); ?>',
					id: 'view-competenceLevel',
					tooltip:'<?php __('<b>View CompetenceLevel</b><br />Click here to see details of the selected CompetenceLevel'); ?>',
					icon: 'img/table_view.png',
					cls: 'x-btn-text-icon',
					disabled: true,
					handler: function(btn) {
						var sm = p.getSelectionModel();
						var sel = sm.getSelected();
						if (sm.hasSelection()){
							ViewCompetenceLevel(sel.data.id);
						};
					},
					menu : {
						items: [
						]
					}
				}, ' ', '-',  '->', {
					xtype: 'textfield',
					emptyText: '<?php __('[Search By Name]'); ?>',
					id: 'competenceLevel_search_field',
					listeners: {
						specialkey: function(field, e){
							if (e.getKey() == e.ENTER) {
								SearchByCompetenceLevelName(Ext.getCmp('competenceLevel_search_field').getValue());
							}
						}
					}
				}, {
					xtype: 'tbbutton',
					icon: 'img/search.png',
					cls: 'x-btn-text-icon',
					text: '<?php __('GO'); ?>',
                    tooltip:'<?php __('<b>GO</b><br />Click here to get search results'); ?>',
					id: 'competenceLevel_go_button',
					handler: function(){
						SearchByCompetenceLevelName(Ext.getCmp('competenceLevel_search_field').getValue());
					}
				}, '-', {
					xtype: 'tbbutton',
					icon: 'img/table_search.png',
					cls: 'x-btn-text-icon',
					text: '<?php __('Advanced Search'); ?>',
                    tooltip:'<?php __('<b>Advanced Search...</b><br />Click here to get the advanced search form'); ?>',
					handler: function(){
						SearchCompetenceLevel();
					}
				}
		]}),
		bbar: new Ext.PagingToolbar({
			pageSize: list_size,
			store: store_competenceLevels,
			displayInfo: true,
			displayMsg: '<?php __('Displaying {0} - {1} of {2}'); ?>',
			beforePageText: '<?php __('Page'); ?>',
			afterPageText: '<?php __('of {0}'); ?>',
			emptyMsg: '<?php __('No data to display'); ?>'
		})
	});
	p.getSelectionModel().on('rowselect', function(sm, rowIdx, r) {
		p.getTopToolbar().findById('edit-competenceLevel').enable();
		p.getTopToolbar().findById('delete-competenceLevel').enable();
		p.getTopToolbar().findById('view-competenceLevel').enable();
		if(this.getSelections().length > 1){
			p.getTopToolbar().findById('edit-competenceLevel').disable();
			p.getTopToolbar().findById('view-competenceLevel').disable();
		}
	});
	p.getSelectionModel().on('rowdeselect', function(sm, rowIdx, r) {
		if(this.getSelections().length > 1){
			p.getTopToolbar().findById('edit-competenceLevel').disable();
			p.getTopToolbar().findById('view-competenceLevel').disable();
			p.getTopToolbar().findById('delete-competenceLevel').enable();
		}
		else if(this.getSelections().length == 1){
			p.getTopToolbar().findById('edit-competenceLevel').enable();
			p.getTopToolbar().findById('view-competenceLevel').enable();
			p.getTopToolbar().findById('delete-competenceLevel').enable();
		}
		else{
			p.getTopToolbar().findById('edit-competenceLevel').disable();
			p.getTopToolbar().findById('view-competenceLevel').disable();
			p.getTopToolbar().findById('delete-competenceLevel').disable();
		}
	});
	center_panel.setActiveTab(p);
	
	store_competenceLevels.load({
		params: {
			start: 0,          
			limit: list_size
		}
	});
	
}
