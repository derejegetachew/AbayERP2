
var store_competenceDefinitions = new Ext.data.GroupingStore({
	reader: new Ext.data.JsonReader({
		root:'rows',
		totalProperty: 'results',
		fields: [
			'id','competence','competence_level','definition'		]
	}),
	proxy: new Ext.data.HttpProxy({
		url: '<?php echo $this->Html->url(array('controller' => 'competenceDefinitions', 'action' => 'list_data')); ?>'
	})
<!-- ,	sortInfo:{field: 'competence_id', direction: "ASC"} -->
<!-- , groupField: 'competence_level_id' -->
});


function AddCompetenceDefinition() {
	Ext.Ajax.request({
		url: '<?php echo $this->Html->url(array('controller' => 'competenceDefinitions', 'action' => 'add')); ?>',
		success: function(response, opts) {
			var competenceDefinition_data = response.responseText;
			
			eval(competenceDefinition_data);
			
			CompetenceDefinitionAddWindow.show();
		},
		failure: function(response, opts) {
			Ext.Msg.alert('<?php __('Error'); ?>', '<?php __('Cannot get the competenceDefinition add form. Error code'); ?>: ' + response.status);
		}
	});
}

function EditCompetenceDefinition(id) {
	Ext.Ajax.request({
		url: '<?php echo $this->Html->url(array('controller' => 'competenceDefinitions', 'action' => 'edit')); ?>/'+id,
		success: function(response, opts) {
			var competenceDefinition_data = response.responseText;
			
			eval(competenceDefinition_data);
			
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

function DeleteCompetenceDefinition(id) {
	Ext.Ajax.request({
		url: '<?php echo $this->Html->url(array('controller' => 'competenceDefinitions', 'action' => 'delete')); ?>/'+id,
		success: function(response, opts) {
			Ext.Msg.alert('<?php __('Success'); ?>', '<?php __('CompetenceDefinition successfully deleted!'); ?>');
			RefreshCompetenceDefinitionData();
		},
		failure: function(response, opts) {
			Ext.Msg.alert('<?php __('Error'); ?>', '<?php __('Cannot get the competenceDefinition add form. Error code'); ?>: ' + response.status);
		}
	});
}

function SearchCompetenceDefinition(){
	Ext.Ajax.request({
		url: '<?php echo $this->Html->url(array('controller' => 'competenceDefinitions', 'action' => 'search')); ?>',
		success: function(response, opts){
			var competenceDefinition_data = response.responseText;

			eval(competenceDefinition_data);

			competenceDefinitionSearchWindow.show();
		},
		failure: function(response, opts) {
			Ext.Msg.alert('<?php __('Error'); ?>','<?php __('Cannot get the competenceDefinition search form. Error Code'); ?>: ' + response.status);
		}
	});
}

function SearchByCompetenceDefinitionName(value){
	var conditions = '\'CompetenceDefinition.name LIKE\' => \'%' + value + '%\'';
	store_competenceDefinitions.reload({
		 params: {
			start: 0,
			limit: list_size,
			conditions: conditions
	    }
	});
}

function RefreshCompetenceDefinitionData() {
	store_competenceDefinitions.reload();
}


if(center_panel.find('id', 'competenceDefinition-tab') != "") {
	var p = center_panel.findById('competenceDefinition-tab');
	center_panel.setActiveTab(p);
} else {
	var p = center_panel.add({
		title: '<?php __('Competence Definitions'); ?>',
		closable: true,
		loadMask: true,
		stripeRows: true,
		id: 'competenceDefinition-tab',
		xtype: 'grid',
		store: store_competenceDefinitions,
		columns: [
			{header: "<?php __('Competence'); ?>", dataIndex: 'competence', sortable: true},
			{header: "<?php __('CompetenceLevel'); ?>", dataIndex: 'competence_level', sortable: true},
			{header: "<?php __('Definition'); ?>", dataIndex: 'definition', sortable: true}
		],
		
		view: new Ext.grid.GroupingView({
            forceFit:true,
            groupTextTpl: '{text} ({[values.rs.length]} {[values.rs.length > 1 ? "CompetenceDefinitions" : "CompetenceDefinition"]})'
        })
,
		listeners: {
			celldblclick: function(){
				ViewCompetenceDefinition(Ext.getCmp('competenceDefinition-tab').getSelectionModel().getSelected().data.id);
			}
		},
		sm: new Ext.grid.RowSelectionModel({
			singleSelect: false
		}),
		tbar: new Ext.Toolbar({
			
			items: [{
					xtype: 'tbbutton',
					text: '<?php __('Add'); ?>',
					tooltip:'<?php __('<b>Add CompetenceDefinitions</b><br />Click here to create a new CompetenceDefinition'); ?>',
					icon: 'img/table_add.png',
					cls: 'x-btn-text-icon',
					handler: function(btn) {
						AddCompetenceDefinition();
					}
				}, ' ', '-', ' ', {
					xtype: 'tbbutton',
					text: '<?php __('Edit'); ?>',
					id: 'edit-competenceDefinition',
					tooltip:'<?php __('<b>Edit CompetenceDefinitions</b><br />Click here to modify the selected CompetenceDefinition'); ?>',
					icon: 'img/table_edit.png',
					cls: 'x-btn-text-icon',
					disabled: true,
					handler: function(btn) {
						var sm = p.getSelectionModel();
						var sel = sm.getSelected();
						if (sm.hasSelection()){
							EditCompetenceDefinition(sel.data.id);
						};
					}
				}, ' ', '-', ' ', {
					xtype: 'tbbutton',
					text: '<?php __('Delete'); ?>',
					id: 'delete-competenceDefinition',
					tooltip:'<?php __('<b>Delete CompetenceDefinitions(s)</b><br />Click here to remove the selected CompetenceDefinition(s)'); ?>',
					icon: 'img/table_delete.png',
					cls: 'x-btn-text-icon',
					disabled: true,
					handler: function(btn) {
						var sm = p.getSelectionModel();
						var sel = sm.getSelections();
						if (sm.hasSelection()){
							if(sel.length==1){
								Ext.Msg.show({
									title: '<?php __('Remove CompetenceDefinition'); ?>',
									buttons: Ext.MessageBox.YESNO,
									msg: '<?php __('Remove'); ?> '+sel[0].data.name+'?',
									icon: Ext.MessageBox.QUESTION,
									fn: function(btn){
										if (btn == 'yes'){
										//	DeleteCompetenceDefinition(sel[0].data.id);
										}
									}
								});
							}else{
								Ext.Msg.show({
									title: '<?php __('Remove CompetenceDefinition'); ?>',
									buttons: Ext.MessageBox.YESNO,
									msg: '<?php __('Remove the selected CompetenceDefinitions'); ?>?',
									icon: Ext.MessageBox.QUESTION,
									fn: function(btn){
										if (btn == 'yes'){
											var sel_ids = '';
											for(i=0;i<sel.length;i++){
												if(i>0)
													sel_ids += '_';
												sel_ids += sel[i].data.id;
											}
										//	DeleteCompetenceDefinition(sel_ids);
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
					text: '<?php __('View CompetenceDefinition'); ?>',
					id: 'view-competenceDefinition',
					tooltip:'<?php __('<b>View CompetenceDefinition</b><br />Click here to see details of the selected CompetenceDefinition'); ?>',
					icon: 'img/table_view.png',
					cls: 'x-btn-text-icon',
					disabled: true,
					handler: function(btn) {
						var sm = p.getSelectionModel();
						var sel = sm.getSelected();
						if (sm.hasSelection()){
							ViewCompetenceDefinition(sel.data.id);
						};
					},
					menu : {
						items: [
						]
					}
				}, ' ', '-',  '<?php __('Competence'); ?>: ', {
					xtype : 'combo',
					emptyText: 'All',
					store : new Ext.data.ArrayStore({
						fields : ['id', 'name'],
						data : [
							['-1', 'All'],
							<?php $st = false;foreach ($competences as $item){if($st) echo ",
							";?>['<?php echo $item['Competence']['id']; ?>' ,'<?php echo $item['Competence']['name']; ?>']<?php $st = true;}?>						]
					}),
					displayField : 'name',
					valueField : 'id',
					mode : 'local',
					value : '-1',
					disableKeyFilter : true,
					triggerAction: 'all',
					listeners : {
						select : function(combo, record, index){
							store_competenceDefinitions.reload({
								params: {
									start: 0,
									limit: list_size,
									competence_id : combo.getValue()
								}
							});
						}
					}
				},
 '->', {
					xtype: 'textfield',
					emptyText: '<?php __('[Search By Name]'); ?>',
					id: 'competenceDefinition_search_field',
					listeners: {
						specialkey: function(field, e){
							if (e.getKey() == e.ENTER) {
								SearchByCompetenceDefinitionName(Ext.getCmp('competenceDefinition_search_field').getValue());
							}
						}
					}
				}, {
					xtype: 'tbbutton',
					icon: 'img/search.png',
					cls: 'x-btn-text-icon',
					text: '<?php __('GO'); ?>',
                    tooltip:'<?php __('<b>GO</b><br />Click here to get search results'); ?>',
					id: 'competenceDefinition_go_button',
					handler: function(){
						SearchByCompetenceDefinitionName(Ext.getCmp('competenceDefinition_search_field').getValue());
					}
				}, '-', {
					xtype: 'tbbutton',
					icon: 'img/table_search.png',
					cls: 'x-btn-text-icon',
					text: '<?php __('Advanced Search'); ?>',
                    tooltip:'<?php __('<b>Advanced Search...</b><br />Click here to get the advanced search form'); ?>',
					handler: function(){
						SearchCompetenceDefinition();
					}
				}
		]}),
		bbar: new Ext.PagingToolbar({
			pageSize: list_size,
			store: store_competenceDefinitions,
			displayInfo: true,
			displayMsg: '<?php __('Displaying {0} - {1} of {2}'); ?>',
			beforePageText: '<?php __('Page'); ?>',
			afterPageText: '<?php __('of {0}'); ?>',
			emptyMsg: '<?php __('No data to display'); ?>'
		})
	});
	p.getSelectionModel().on('rowselect', function(sm, rowIdx, r) {
		p.getTopToolbar().findById('edit-competenceDefinition').enable();
		p.getTopToolbar().findById('delete-competenceDefinition').enable();
		p.getTopToolbar().findById('view-competenceDefinition').enable();
		if(this.getSelections().length > 1){
			p.getTopToolbar().findById('edit-competenceDefinition').disable();
			p.getTopToolbar().findById('view-competenceDefinition').disable();
		}
	});
	p.getSelectionModel().on('rowdeselect', function(sm, rowIdx, r) {
		if(this.getSelections().length > 1){
			p.getTopToolbar().findById('edit-competenceDefinition').disable();
			p.getTopToolbar().findById('view-competenceDefinition').disable();
			p.getTopToolbar().findById('delete-competenceDefinition').enable();
		}
		else if(this.getSelections().length == 1){
			p.getTopToolbar().findById('edit-competenceDefinition').enable();
			p.getTopToolbar().findById('view-competenceDefinition').enable();
			p.getTopToolbar().findById('delete-competenceDefinition').enable();
		}
		else{
			p.getTopToolbar().findById('edit-competenceDefinition').disable();
			p.getTopToolbar().findById('view-competenceDefinition').disable();
			p.getTopToolbar().findById('delete-competenceDefinition').disable();
		}
	});
	center_panel.setActiveTab(p);
	
	store_competenceDefinitions.load({
		params: {
			start: 0,          
			limit: list_size
		}
	});
	
}
