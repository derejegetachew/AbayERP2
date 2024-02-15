
var store_competenceCategories = new Ext.data.Store({
	reader: new Ext.data.JsonReader({
		root:'rows',
		totalProperty: 'results',
		fields: [
			'id','name'		]
	}),
	proxy: new Ext.data.HttpProxy({
		url: '<?php echo $this->Html->url(array('controller' => 'competenceCategories', 'action' => 'list_data')); ?>'
	})
});


function AddCompetenceCategory() {
	Ext.Ajax.request({
		url: '<?php echo $this->Html->url(array('controller' => 'competenceCategories', 'action' => 'add')); ?>',
		success: function(response, opts) {
			var competenceCategory_data = response.responseText;
			
			eval(competenceCategory_data);
			
			CompetenceCategoryAddWindow.show();
		},
		failure: function(response, opts) {
			Ext.Msg.alert('<?php __('Error'); ?>', '<?php __('Cannot get the competenceCategory add form. Error code'); ?>: ' + response.status);
		}
	});
}

function EditCompetenceCategory(id) {
	Ext.Ajax.request({
		url: '<?php echo $this->Html->url(array('controller' => 'competenceCategories', 'action' => 'edit')); ?>/'+id,
		success: function(response, opts) {
			var competenceCategory_data = response.responseText;
			
			eval(competenceCategory_data);
			
			CompetenceCategoryEditWindow.show();
		},
		failure: function(response, opts) {
			Ext.Msg.alert('<?php __('Error'); ?>', '<?php __('Cannot get the competenceCategory edit form. Error code'); ?>: ' + response.status);
		}
	});
}

function ViewCompetenceCategory(id) {
    Ext.Ajax.request({
        url: '<?php echo $this->Html->url(array('controller' => 'competenceCategories', 'action' => 'view')); ?>/'+id,
        success: function(response, opts) {
            var competenceCategory_data = response.responseText;

            eval(competenceCategory_data);

            CompetenceCategoryViewWindow.show();
        },
        failure: function(response, opts) {
            Ext.Msg.alert('<?php __('Error'); ?>', '<?php __('Cannot get the competenceCategory view form. Error code'); ?>: ' + response.status);
        }
    });
}

function DeleteCompetenceCategory(id) {
	Ext.Ajax.request({
		url: '<?php echo $this->Html->url(array('controller' => 'competenceCategories', 'action' => 'delete')); ?>/'+id,
		success: function(response, opts) {
			Ext.Msg.alert('<?php __('Success'); ?>', '<?php __('CompetenceCategory successfully deleted!'); ?>');
			RefreshCompetenceCategoryData();
		},
		failure: function(response, opts) {
			Ext.Msg.alert('<?php __('Error'); ?>', '<?php __('Cannot get the competenceCategory add form. Error code'); ?>: ' + response.status);
		}
	});
}

function SearchCompetenceCategory(){
	Ext.Ajax.request({
		url: '<?php echo $this->Html->url(array('controller' => 'competenceCategories', 'action' => 'search')); ?>',
		success: function(response, opts){
			var competenceCategory_data = response.responseText;

			eval(competenceCategory_data);

			competenceCategorySearchWindow.show();
		},
		failure: function(response, opts) {
			Ext.Msg.alert('<?php __('Error'); ?>','<?php __('Cannot get the competenceCategory search form. Error Code'); ?>: ' + response.status);
		}
	});
}

function SearchByCompetenceCategoryName(value){
	var conditions = '\'CompetenceCategory.name LIKE\' => \'%' + value + '%\'';
	store_competenceCategories.reload({
		 params: {
			start: 0,
			limit: list_size,
			conditions: conditions
	    }
	});
}

function RefreshCompetenceCategoryData() {
	store_competenceCategories.reload();
}


if(center_panel.find('id', 'competenceCategory-tab') != "") {
	var p = center_panel.findById('competenceCategory-tab');
	center_panel.setActiveTab(p);
} else {
	var p = center_panel.add({
		title: '<?php __('Competence Categories'); ?>',
		closable: true,
		loadMask: true,
		stripeRows: true,
		id: 'competenceCategory-tab',
		xtype: 'grid',
		store: store_competenceCategories,
		columns: [
			{header: "<?php __('Name'); ?>", dataIndex: 'name', sortable: true}
		],
		viewConfig: {
			forceFit: true
		}
,
		listeners: {
			celldblclick: function(){
				ViewCompetenceCategory(Ext.getCmp('competenceCategory-tab').getSelectionModel().getSelected().data.id);
			}
		},
		sm: new Ext.grid.RowSelectionModel({
			singleSelect: false
		}),
		tbar: new Ext.Toolbar({
			
			items: [{
					xtype: 'tbbutton',
					text: '<?php __('Add'); ?>',
					tooltip:'<?php __('<b>Add CompetenceCategories</b><br />Click here to create a new CompetenceCategory'); ?>',
					icon: 'img/table_add.png',
					cls: 'x-btn-text-icon',
					handler: function(btn) {
						AddCompetenceCategory();
					}
				}, ' ', '-', ' ', {
					xtype: 'tbbutton',
					text: '<?php __('Edit'); ?>',
					id: 'edit-competenceCategory',
					tooltip:'<?php __('<b>Edit CompetenceCategories</b><br />Click here to modify the selected CompetenceCategory'); ?>',
					icon: 'img/table_edit.png',
					cls: 'x-btn-text-icon',
					disabled: true,
					handler: function(btn) {
						var sm = p.getSelectionModel();
						var sel = sm.getSelected();
						if (sm.hasSelection()){
							EditCompetenceCategory(sel.data.id);
						};
					}
				}, ' ', '-', ' ', {
					xtype: 'tbbutton',
					text: '<?php __('Delete'); ?>',
					id: 'delete-competenceCategory',
					tooltip:'<?php __('<b>Delete CompetenceCategories(s)</b><br />Click here to remove the selected CompetenceCategory(s)'); ?>',
					icon: 'img/table_delete.png',
					cls: 'x-btn-text-icon',
					disabled: true,
					handler: function(btn) {
						var sm = p.getSelectionModel();
						var sel = sm.getSelections();
						if (sm.hasSelection()){
							if(sel.length==1){
								Ext.Msg.show({
									title: '<?php __('Remove CompetenceCategory'); ?>',
									buttons: Ext.MessageBox.YESNO,
									msg: '<?php __('Remove'); ?> '+sel[0].data.name+'?',
									icon: Ext.MessageBox.QUESTION,
									fn: function(btn){
										if (btn == 'yes'){
										//	DeleteCompetenceCategory(sel[0].data.id);
										}
									}
								});
							}else{
								Ext.Msg.show({
									title: '<?php __('Remove CompetenceCategory'); ?>',
									buttons: Ext.MessageBox.YESNO,
									msg: '<?php __('Remove the selected CompetenceCategories'); ?>?',
									icon: Ext.MessageBox.QUESTION,
									fn: function(btn){
										if (btn == 'yes'){
											var sel_ids = '';
											for(i=0;i<sel.length;i++){
												if(i>0)
													sel_ids += '_';
												sel_ids += sel[i].data.id;
											}
										//	DeleteCompetenceCategory(sel_ids);
										}
									}
								});
							}
						} else {
							Ext.Msg.alert('<?php __('Warning'); ?>', '<?php __('Please select a record first'); ?>');
						};
					}
				}, ' ', '-',  '->', {
					xtype: 'textfield',
					emptyText: '<?php __('[Search By Name]'); ?>',
					id: 'competenceCategory_search_field',
					listeners: {
						specialkey: function(field, e){
							if (e.getKey() == e.ENTER) {
								SearchByCompetenceCategoryName(Ext.getCmp('competenceCategory_search_field').getValue());
							}
						}
					}
				}, {
					xtype: 'tbbutton',
					icon: 'img/search.png',
					cls: 'x-btn-text-icon',
					text: '<?php __('GO'); ?>',
                    tooltip:'<?php __('<b>GO</b><br />Click here to get search results'); ?>',
					id: 'competenceCategory_go_button',
					handler: function(){
						SearchByCompetenceCategoryName(Ext.getCmp('competenceCategory_search_field').getValue());
					}
				}, '-', {
					xtype: 'tbbutton',
					icon: 'img/table_search.png',
					cls: 'x-btn-text-icon',
					text: '<?php __('Advanced Search'); ?>',
                    tooltip:'<?php __('<b>Advanced Search...</b><br />Click here to get the advanced search form'); ?>',
					handler: function(){
						SearchCompetenceCategory();
					}
				}
		]}),
		bbar: new Ext.PagingToolbar({
			pageSize: list_size,
			store: store_competenceCategories,
			displayInfo: true,
			displayMsg: '<?php __('Displaying {0} - {1} of {2}'); ?>',
			beforePageText: '<?php __('Page'); ?>',
			afterPageText: '<?php __('of {0}'); ?>',
			emptyMsg: '<?php __('No data to display'); ?>'
		})
	});
	p.getSelectionModel().on('rowselect', function(sm, rowIdx, r) {
		p.getTopToolbar().findById('edit-competenceCategory').enable();
		p.getTopToolbar().findById('delete-competenceCategory').enable();
		p.getTopToolbar().findById('view-competenceCategory').enable();
		if(this.getSelections().length > 1){
			p.getTopToolbar().findById('edit-competenceCategory').disable();
			p.getTopToolbar().findById('view-competenceCategory').disable();
		}
	});
	p.getSelectionModel().on('rowdeselect', function(sm, rowIdx, r) {
		if(this.getSelections().length > 1){
			p.getTopToolbar().findById('edit-competenceCategory').disable();
			p.getTopToolbar().findById('view-competenceCategory').disable();
			p.getTopToolbar().findById('delete-competenceCategory').enable();
		}
		else if(this.getSelections().length == 1){
			p.getTopToolbar().findById('edit-competenceCategory').enable();
			p.getTopToolbar().findById('view-competenceCategory').enable();
			p.getTopToolbar().findById('delete-competenceCategory').enable();
		}
		else{
			p.getTopToolbar().findById('edit-competenceCategory').disable();
			p.getTopToolbar().findById('view-competenceCategory').disable();
			p.getTopToolbar().findById('delete-competenceCategory').disable();
		}
	});
	center_panel.setActiveTab(p);
	
	store_competenceCategories.load({
		params: {
			start: 0,          
			limit: list_size
		}
	});
	
}
