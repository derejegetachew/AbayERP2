
var store_competenceSettings = new Ext.data.GroupingStore({
	reader: new Ext.data.JsonReader({
		root:'rows',
		totalProperty: 'results',
		fields: [
			'id','grade','competence','expected_competence','weight'		]
	}),
	proxy: new Ext.data.HttpProxy({
		url: '<?php echo $this->Html->url(array('controller' => 'competenceSettings', 'action' => 'list_data')); ?>'
	})
<!-- ,	sortInfo:{field: 'grade_id', direction: "ASC"} -->
<!-- , groupField: 'competence_id' -->
});


function AddCompetenceSetting() {
	Ext.Ajax.request({
		url: '<?php echo $this->Html->url(array('controller' => 'competenceSettings', 'action' => 'add')); ?>',
		success: function(response, opts) {
			var competenceSetting_data = response.responseText;
			
			eval(competenceSetting_data);
			
			CompetenceSettingAddWindow.show();
		},
		failure: function(response, opts) {
			Ext.Msg.alert('<?php __('Error'); ?>', '<?php __('Cannot get the competenceSetting add form. Error code'); ?>: ' + response.status);
		}
	});
}

function EditCompetenceSetting(id) {
	Ext.Ajax.request({
		url: '<?php echo $this->Html->url(array('controller' => 'competenceSettings', 'action' => 'edit')); ?>/'+id,
		success: function(response, opts) {
			var competenceSetting_data = response.responseText;
			
			eval(competenceSetting_data);
			
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

function DeleteCompetenceSetting(id) {
	Ext.Ajax.request({
		url: '<?php echo $this->Html->url(array('controller' => 'competenceSettings', 'action' => 'delete')); ?>/'+id,
		success: function(response, opts) {
			Ext.Msg.alert('<?php __('Success'); ?>', '<?php __('CompetenceSetting successfully deleted!'); ?>');
			RefreshCompetenceSettingData();
		},
		failure: function(response, opts) {
			Ext.Msg.alert('<?php __('Error'); ?>', '<?php __('Cannot get the competenceSetting add form. Error code'); ?>: ' + response.status);
		}
	});
}

function SearchCompetenceSetting(){
	Ext.Ajax.request({
		url: '<?php echo $this->Html->url(array('controller' => 'competenceSettings', 'action' => 'search')); ?>',
		success: function(response, opts){
			var competenceSetting_data = response.responseText;

			eval(competenceSetting_data);

			competenceSettingSearchWindow.show();
		},
		failure: function(response, opts) {
			Ext.Msg.alert('<?php __('Error'); ?>','<?php __('Cannot get the competenceSetting search form. Error Code'); ?>: ' + response.status);
		}
	});
}

function SearchByCompetenceSettingName(value){
	var conditions = '\'CompetenceSetting.name LIKE\' => \'%' + value + '%\'';
	store_competenceSettings.reload({
		 params: {
			start: 0,
			limit: list_size,
			conditions: conditions
	    }
	});
}

function RefreshCompetenceSettingData() {
	store_competenceSettings.reload();
}


if(center_panel.find('id', 'competenceSetting-tab') != "") {
	var p = center_panel.findById('competenceSetting-tab');
	center_panel.setActiveTab(p);
} else {
	var p = center_panel.add({
		title: '<?php __('Competence Settings'); ?>',
		closable: true,
		loadMask: true,
		stripeRows: true,
		id: 'competenceSetting-tab',
		xtype: 'grid',
		store: store_competenceSettings,
		columns: [
			{header: "<?php __('Grade'); ?>", dataIndex: 'grade', sortable: true},
			{header: "<?php __('Competence'); ?>", dataIndex: 'competence', sortable: true},
			{header: "<?php __('Expected Competence'); ?>", dataIndex: 'expected_competence', sortable: true},
			{header: "<?php __('Weight'); ?>", dataIndex: 'weight', sortable: true}
		],
		
		view: new Ext.grid.GroupingView({
            forceFit:true,
            groupTextTpl: '{text} ({[values.rs.length]} {[values.rs.length > 1 ? "CompetenceSettings" : "CompetenceSetting"]})'
        })
,
		listeners: {
			celldblclick: function(){
				ViewCompetenceSetting(Ext.getCmp('competenceSetting-tab').getSelectionModel().getSelected().data.id);
			}
		},
		sm: new Ext.grid.RowSelectionModel({
			singleSelect: false
		}),
		tbar: new Ext.Toolbar({
			
			items: [{
					xtype: 'tbbutton',
					text: '<?php __('Add'); ?>',
					tooltip:'<?php __('<b>Add CompetenceSettings</b><br />Click here to create a new CompetenceSetting'); ?>',
					icon: 'img/table_add.png',
					cls: 'x-btn-text-icon',
					handler: function(btn) {
						AddCompetenceSetting();
					}
				}, ' ', '-', ' ', {
					xtype: 'tbbutton',
					text: '<?php __('Edit'); ?>',
					id: 'edit-competenceSetting',
					tooltip:'<?php __('<b>Edit CompetenceSettings</b><br />Click here to modify the selected CompetenceSetting'); ?>',
					icon: 'img/table_edit.png',
					cls: 'x-btn-text-icon',
					disabled: true,
					handler: function(btn) {
						var sm = p.getSelectionModel();
						var sel = sm.getSelected();
						if (sm.hasSelection()){
							EditCompetenceSetting(sel.data.id);
						};
					}
				}, ' ', '-', ' ', {
					xtype: 'tbbutton',
					text: '<?php __('Delete'); ?>',
					id: 'delete-competenceSetting',
					tooltip:'<?php __('<b>Delete CompetenceSettings(s)</b><br />Click here to remove the selected CompetenceSetting(s)'); ?>',
					icon: 'img/table_delete.png',
					cls: 'x-btn-text-icon',
					disabled: true,
					handler: function(btn) {
						var sm = p.getSelectionModel();
						var sel = sm.getSelections();
						if (sm.hasSelection()){
							if(sel.length==1){
								Ext.Msg.show({
									title: '<?php __('Remove CompetenceSetting'); ?>',
									buttons: Ext.MessageBox.YESNO,
									msg: '<?php __('Remove'); ?> '+sel[0].data.name+'?',
									icon: Ext.MessageBox.QUESTION,
									fn: function(btn){
										if (btn == 'yes'){
										//	DeleteCompetenceSetting(sel[0].data.id);
										}
									}
								});
							}else{
								Ext.Msg.show({
									title: '<?php __('Remove CompetenceSetting'); ?>',
									buttons: Ext.MessageBox.YESNO,
									msg: '<?php __('Remove the selected CompetenceSettings'); ?>?',
									icon: Ext.MessageBox.QUESTION,
									fn: function(btn){
										if (btn == 'yes'){
											var sel_ids = '';
											for(i=0;i<sel.length;i++){
												if(i>0)
													sel_ids += '_';
												sel_ids += sel[i].data.id;
											}
										//	DeleteCompetenceSetting(sel_ids);
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
					text: '<?php __('View CompetenceSetting'); ?>',
					id: 'view-competenceSetting',
					tooltip:'<?php __('<b>View CompetenceSetting</b><br />Click here to see details of the selected CompetenceSetting'); ?>',
					icon: 'img/table_view.png',
					cls: 'x-btn-text-icon',
					disabled: true,
					handler: function(btn) {
						var sm = p.getSelectionModel();
						var sel = sm.getSelected();
						if (sm.hasSelection()){
							ViewCompetenceSetting(sel.data.id);
						};
					},
					menu : {
						items: [
						]
					}
				}, ' ', '-',  '<?php __('Grade'); ?>: ', {
					xtype : 'combo',
					emptyText: 'All',
					store : new Ext.data.ArrayStore({
						fields : ['id', 'name'],
						data : [
							['-1', 'All'],
							<?php $st = false;foreach ($grades as $item){if($st) echo ",
							";?>['<?php echo $item['Grade']['id']; ?>' ,'<?php echo $item['Grade']['name']; ?>']<?php $st = true;}?>						]
					}),
					displayField : 'name',
					valueField : 'id',
					mode : 'local',
					value : '-1',
					disableKeyFilter : true,
					triggerAction: 'all',
					listeners : {
						select : function(combo, record, index){
							store_competenceSettings.reload({
								params: {
									start: 0,
									limit: list_size,
									grade_id : combo.getValue()
								}
							});
						}
					}
				},
 '->', {
					xtype: 'textfield',
					emptyText: '<?php __('[Search By Name]'); ?>',
					id: 'competenceSetting_search_field',
					listeners: {
						specialkey: function(field, e){
							if (e.getKey() == e.ENTER) {
								SearchByCompetenceSettingName(Ext.getCmp('competenceSetting_search_field').getValue());
							}
						}
					}
				}, {
					xtype: 'tbbutton',
					icon: 'img/search.png',
					cls: 'x-btn-text-icon',
					text: '<?php __('GO'); ?>',
                    tooltip:'<?php __('<b>GO</b><br />Click here to get search results'); ?>',
					id: 'competenceSetting_go_button',
					handler: function(){
						SearchByCompetenceSettingName(Ext.getCmp('competenceSetting_search_field').getValue());
					}
				}, '-', {
					xtype: 'tbbutton',
					icon: 'img/table_search.png',
					cls: 'x-btn-text-icon',
					text: '<?php __('Advanced Search'); ?>',
                    tooltip:'<?php __('<b>Advanced Search...</b><br />Click here to get the advanced search form'); ?>',
					handler: function(){
						SearchCompetenceSetting();
					}
				}
		]}),
		bbar: new Ext.PagingToolbar({
			pageSize: list_size,
			store: store_competenceSettings,
			displayInfo: true,
			displayMsg: '<?php __('Displaying {0} - {1} of {2}'); ?>',
			beforePageText: '<?php __('Page'); ?>',
			afterPageText: '<?php __('of {0}'); ?>',
			emptyMsg: '<?php __('No data to display'); ?>'
		})
	});
	p.getSelectionModel().on('rowselect', function(sm, rowIdx, r) {
		p.getTopToolbar().findById('edit-competenceSetting').enable();
		p.getTopToolbar().findById('delete-competenceSetting').enable();
		p.getTopToolbar().findById('view-competenceSetting').enable();
		if(this.getSelections().length > 1){
			p.getTopToolbar().findById('edit-competenceSetting').disable();
			p.getTopToolbar().findById('view-competenceSetting').disable();
		}
	});
	p.getSelectionModel().on('rowdeselect', function(sm, rowIdx, r) {
		if(this.getSelections().length > 1){
			p.getTopToolbar().findById('edit-competenceSetting').disable();
			p.getTopToolbar().findById('view-competenceSetting').disable();
			p.getTopToolbar().findById('delete-competenceSetting').enable();
		}
		else if(this.getSelections().length == 1){
			p.getTopToolbar().findById('edit-competenceSetting').enable();
			p.getTopToolbar().findById('view-competenceSetting').enable();
			p.getTopToolbar().findById('delete-competenceSetting').enable();
		}
		else{
			p.getTopToolbar().findById('edit-competenceSetting').disable();
			p.getTopToolbar().findById('view-competenceSetting').disable();
			p.getTopToolbar().findById('delete-competenceSetting').disable();
		}
	});
	center_panel.setActiveTab(p);
	
	store_competenceSettings.load({
		params: {
			start: 0,          
			limit: list_size
		}
	});
	
}
