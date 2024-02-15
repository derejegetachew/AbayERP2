
var store_competences = new Ext.data.GroupingStore({
	reader: new Ext.data.JsonReader({
		root:'rows',
		totalProperty: 'results',
		fields: [
			'id','name','definition','competence_category'		]
	}),
	proxy: new Ext.data.HttpProxy({
		url: '<?php echo $this->Html->url(array('controller' => 'competences', 'action' => 'list_data')); ?>'
	})

});


function AddCompetence() {
	Ext.Ajax.request({
		url: '<?php echo $this->Html->url(array('controller' => 'competences', 'action' => 'add')); ?>',
		success: function(response, opts) {
			var competence_data = response.responseText;
			
			eval(competence_data);
			
			CompetenceAddWindow.show();
		},
		failure: function(response, opts) {
			Ext.Msg.alert('<?php __('Error'); ?>', '<?php __('Cannot get the competence add form. Error code'); ?>: ' + response.status);
		}
	});
}

function EditCompetence(id) {
	Ext.Ajax.request({
		url: '<?php echo $this->Html->url(array('controller' => 'competences', 'action' => 'edit')); ?>/'+id,
		success: function(response, opts) {
			var competence_data = response.responseText;
			
			eval(competence_data);
			
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

function DeleteCompetence(id) {
	Ext.Ajax.request({
		url: '<?php echo $this->Html->url(array('controller' => 'competences', 'action' => 'delete')); ?>/'+id,
		success: function(response, opts) {
			Ext.Msg.alert('<?php __('Success'); ?>', '<?php __('Competence successfully deleted!'); ?>');
			RefreshCompetenceData();
		},
		failure: function(response, opts) {
			Ext.Msg.alert('<?php __('Error'); ?>', '<?php __('Cannot get the competence add form. Error code'); ?>: ' + response.status);
		}
	});
}

function SearchCompetence(){
	Ext.Ajax.request({
		url: '<?php echo $this->Html->url(array('controller' => 'competences', 'action' => 'search')); ?>',
		success: function(response, opts){
			var competence_data = response.responseText;

			eval(competence_data);

			competenceSearchWindow.show();
		},
		failure: function(response, opts) {
			Ext.Msg.alert('<?php __('Error'); ?>','<?php __('Cannot get the competence search form. Error Code'); ?>: ' + response.status);
		}
	});
}

function SearchByCompetenceName(value){
	var conditions = '\'Competence.name LIKE\' => \'%' + value + '%\'';
	store_competences.reload({
		 params: {
			start: 0,
			limit: list_size,
			conditions: conditions
	    }
	});
}

function RefreshCompetenceData() {
	store_competences.reload();
}


if(center_panel.find('id', 'competence-tab') != "") {
	var p = center_panel.findById('competence-tab');
	center_panel.setActiveTab(p);
} else {
	var p = center_panel.add({
		title: '<?php __('Competences'); ?>',
		closable: true,
		loadMask: true,
		stripeRows: true,
		id: 'competence-tab',
		xtype: 'grid',
		store: store_competences,
		columns: [
			{header: "<?php __('Name'); ?>", dataIndex: 'name', sortable: true},
			{header: "<?php __('Definition'); ?>", dataIndex: 'definition', sortable: true},
			{header: "<?php __('CompetenceCategory'); ?>", dataIndex: 'competence_category', sortable: true}
		],
		
		view: new Ext.grid.GroupingView({
            forceFit:true,
            groupTextTpl: '{text} ({[values.rs.length]} {[values.rs.length > 1 ? "Competences" : "Competence"]})'
        })
,
		listeners: {
			celldblclick: function(){
				ViewCompetence(Ext.getCmp('competence-tab').getSelectionModel().getSelected().data.id);
			}
		},
		sm: new Ext.grid.RowSelectionModel({
			singleSelect: false
		}),
		tbar: new Ext.Toolbar({
			
			items: [{
					xtype: 'tbbutton',
					text: '<?php __('Add'); ?>',
					tooltip:'<?php __('<b>Add Competences</b><br />Click here to create a new Competence'); ?>',
					icon: 'img/table_add.png',
					cls: 'x-btn-text-icon',
					handler: function(btn) {
						AddCompetence();
					}
				}, ' ', '-', ' ', {
					xtype: 'tbbutton',
					text: '<?php __('Edit'); ?>',
					id: 'edit-competence',
					tooltip:'<?php __('<b>Edit Competences</b><br />Click here to modify the selected Competence'); ?>',
					icon: 'img/table_edit.png',
					cls: 'x-btn-text-icon',
					disabled: true,
					handler: function(btn) {
						var sm = p.getSelectionModel();
						var sel = sm.getSelected();
						if (sm.hasSelection()){
							EditCompetence(sel.data.id);
						};
					}
				}, ' ', '-', ' ', {
					xtype: 'tbbutton',
					text: '<?php __('Delete'); ?>',
					id: 'delete-competence',
					tooltip:'<?php __('<b>Delete Competences(s)</b><br />Click here to remove the selected Competence(s)'); ?>',
					icon: 'img/table_delete.png',
					cls: 'x-btn-text-icon',
					disabled: true,
					handler: function(btn) {
						var sm = p.getSelectionModel();
						var sel = sm.getSelections();
						if (sm.hasSelection()){
							if(sel.length==1){
								Ext.Msg.show({
									title: '<?php __('Remove Competence'); ?>',
									buttons: Ext.MessageBox.YESNO,
									msg: '<?php __('Remove'); ?> '+sel[0].data.name+'?',
									icon: Ext.MessageBox.QUESTION,
									fn: function(btn){
										if (btn == 'yes'){
										//	DeleteCompetence(sel[0].data.id);
										}
									}
								});
							}else{
								Ext.Msg.show({
									title: '<?php __('Remove Competence'); ?>',
									buttons: Ext.MessageBox.YESNO,
									msg: '<?php __('Remove the selected Competences'); ?>?',
									icon: Ext.MessageBox.QUESTION,
									fn: function(btn){
										if (btn == 'yes'){
											var sel_ids = '';
											for(i=0;i<sel.length;i++){
												if(i>0)
													sel_ids += '_';
												sel_ids += sel[i].data.id;
											}
										//	DeleteCompetence(sel_ids);
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
					text: '<?php __('View Competence'); ?>',
					id: 'view-competence',
					tooltip:'<?php __('<b>View Competence</b><br />Click here to see details of the selected Competence'); ?>',
					icon: 'img/table_view.png',
					cls: 'x-btn-text-icon',
					disabled: true,
					handler: function(btn) {
						var sm = p.getSelectionModel();
						var sel = sm.getSelected();
						if (sm.hasSelection()){
							ViewCompetence(sel.data.id);
						};
					},
					menu : {
						items: [
						]
					}
				}, ' ', '-',  '<?php __('CompetenceCategory'); ?>: ', {
					xtype : 'combo',
					emptyText: 'All',
					store : new Ext.data.ArrayStore({
						fields : ['id', 'name'],
						data : [
							['-1', 'All'],
							<?php $st = false;foreach ($competence_categories as $item){if($st) echo ",
							";?>['<?php echo $item['CompetenceCategory']['id']; ?>' ,'<?php echo $item['CompetenceCategory']['name']; ?>']<?php $st = true;}?>						]
					}),
					displayField : 'name',
					valueField : 'id',
					mode : 'local',
					value : '-1',
					disableKeyFilter : true,
					triggerAction: 'all',
					listeners : {
						select : function(combo, record, index){
							store_competences.reload({
								params: {
									start: 0,
									limit: list_size,
									competencecategory_id : combo.getValue()
								}
							});
						}
					}
				},
 '->', {
					xtype: 'textfield',
					emptyText: '<?php __('[Search By Name]'); ?>',
					id: 'competence_search_field',
					listeners: {
						specialkey: function(field, e){
							if (e.getKey() == e.ENTER) {
								SearchByCompetenceName(Ext.getCmp('competence_search_field').getValue());
							}
						}
					}
				}, {
					xtype: 'tbbutton',
					icon: 'img/search.png',
					cls: 'x-btn-text-icon',
					text: '<?php __('GO'); ?>',
                    tooltip:'<?php __('<b>GO</b><br />Click here to get search results'); ?>',
					id: 'competence_go_button',
					handler: function(){
						SearchByCompetenceName(Ext.getCmp('competence_search_field').getValue());
					}
				}, '-', {
					xtype: 'tbbutton',
					icon: 'img/table_search.png',
					cls: 'x-btn-text-icon',
					text: '<?php __('Advanced Search'); ?>',
                    tooltip:'<?php __('<b>Advanced Search...</b><br />Click here to get the advanced search form'); ?>',
					handler: function(){
						SearchCompetence();
					}
				}
		]}),
		bbar: new Ext.PagingToolbar({
			pageSize: list_size,
			store: store_competences,
			displayInfo: true,
			displayMsg: '<?php __('Displaying {0} - {1} of {2}'); ?>',
			beforePageText: '<?php __('Page'); ?>',
			afterPageText: '<?php __('of {0}'); ?>',
			emptyMsg: '<?php __('No data to display'); ?>'
		})
	});
	p.getSelectionModel().on('rowselect', function(sm, rowIdx, r) {
		p.getTopToolbar().findById('edit-competence').enable();
		p.getTopToolbar().findById('delete-competence').enable();
		p.getTopToolbar().findById('view-competence').enable();
		if(this.getSelections().length > 1){
			p.getTopToolbar().findById('edit-competence').disable();
			p.getTopToolbar().findById('view-competence').disable();
		}
	});
	p.getSelectionModel().on('rowdeselect', function(sm, rowIdx, r) {
		if(this.getSelections().length > 1){
			p.getTopToolbar().findById('edit-competence').disable();
			p.getTopToolbar().findById('view-competence').disable();
			p.getTopToolbar().findById('delete-competence').enable();
		}
		else if(this.getSelections().length == 1){
			p.getTopToolbar().findById('edit-competence').enable();
			p.getTopToolbar().findById('view-competence').enable();
			p.getTopToolbar().findById('delete-competence').enable();
		}
		else{
			p.getTopToolbar().findById('edit-competence').disable();
			p.getTopToolbar().findById('view-competence').disable();
			p.getTopToolbar().findById('delete-competence').disable();
		}
	});
	center_panel.setActiveTab(p);
	
	store_competences.load({
		params: {
			start: 0,          
			limit: list_size
		}
	});
	
}
