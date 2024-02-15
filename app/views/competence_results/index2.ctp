var store_parent_competenceResults = new Ext.data.Store({
	reader: new Ext.data.JsonReader({
		root:'rows',
		totalProperty: 'results',
		fields: [
			'id','budget_year','quarter','employee','competence','actual_competence','score','rating'	
		]
	}),
	proxy: new Ext.data.HttpProxy({
		url: '<?php echo $this->Html->url(array('controller' => 'competenceResults', 'action' => 'list_data', $parent_id)); ?>'	})
});


function AddParentCompetenceResult() {
	Ext.Ajax.request({
		url: '<?php echo $this->Html->url(array('controller' => 'competenceResults', 'action' => 'add', $parent_id)); ?>',
		success: function(response, opts) {
			var parent_competenceResult_data = response.responseText;
			
			eval(parent_competenceResult_data);
			
			CompetenceResultAddWindow.show();
		},
		failure: function(response, opts) {
			Ext.Msg.alert('<?php __('Error'); ?>', '<?php __('Cannot get the competenceResult add form. Error code'); ?>: ' + response.status);
		}
	});
}

function EditParentCompetenceResult(id) {
	Ext.Ajax.request({
		url: '<?php echo $this->Html->url(array('controller' => 'competenceResults', 'action' => 'edit')); ?>/'+id+'/<?php echo $parent_id; ?>',
		success: function(response, opts) {
			var parent_competenceResult_data = response.responseText;
			
			eval(parent_competenceResult_data);
			
			CompetenceResultEditWindow.show();
		},
		failure: function(response, opts) {
			Ext.Msg.alert('<?php __('Error'); ?>', '<?php __('Cannot get the competenceResult edit form. Error code'); ?>: ' + response.status);
		}
	});
}

function ViewCompetenceResult(id) {
	Ext.Ajax.request({
		url: '<?php echo $this->Html->url(array('controller' => 'competenceResults', 'action' => 'view')); ?>/'+id,
		success: function(response, opts) {
			var competenceResult_data = response.responseText;

			eval(competenceResult_data);

			CompetenceResultViewWindow.show();
		},
		failure: function(response, opts) {
			Ext.Msg.alert('<?php __('Error'); ?>', '<?php __('Cannot get the competenceResult view form. Error code'); ?>: ' + response.status);
		}
	});
}


function DeleteParentCompetenceResult(id) {
	Ext.Ajax.request({
		url: '<?php echo $this->Html->url(array('controller' => 'competenceResults', 'action' => 'delete')); ?>/'+id,
		success: function(response, opts) {
			Ext.Msg.alert('<?php __('Success'); ?>', '<?php __('CompetenceResult(s) successfully deleted!'); ?>');
			RefreshParentCompetenceResultData();
		},
		failure: function(response, opts) {
			Ext.Msg.alert('<?php __('Error'); ?>', '<?php __('Cannot get the competenceResult to be deleted. Error code'); ?>: ' + response.status);
		}
	});
}

function SearchByParentCompetenceResultName(value){
	var conditions = '\'CompetenceResult.name LIKE\' => \'%' + value + '%\'';
	store_parent_competenceResults.reload({
		 params: {
			start: 0,
			limit: list_size,
			conditions: conditions
	    }
	});
}

function RefreshParentCompetenceResultData() {
	store_parent_competenceResults.reload();
}



var g = new Ext.grid.GridPanel({
	title: '<?php __('CompetenceResults'); ?>',
	store: store_parent_competenceResults,
	loadMask: true,
	stripeRows: true,
	height: 300,
	anchor: '100%',
    id: 'competenceResultGrid',
	columns: [
		{header:"<?php __('budget_year'); ?>", dataIndex: 'budget_year', sortable: true},
		{header: "<?php __('Quarter'); ?>", dataIndex: 'quarter', sortable: true},
		{header:"<?php __('employee'); ?>", dataIndex: 'employee', sortable: true},
		{header:"<?php __('competence'); ?>", dataIndex: 'competence', sortable: true},
		{header: "<?php __('Actual Competence'); ?>", dataIndex: 'actual_competence', sortable: true},
		{header: "<?php __('Score'); ?>", dataIndex: 'score', sortable: true},
		{header: "<?php __('Rating'); ?>", dataIndex: 'rating', sortable: true}	],
	sm: new Ext.grid.RowSelectionModel({
		singleSelect: false
	}),
	viewConfig: {
		forceFit: true
	},
    listeners: {
        celldblclick: function(){
            ViewCompetenceResult(Ext.getCmp('competenceResultGrid').getSelectionModel().getSelected().data.id);
        }
    },
	tbar: new Ext.Toolbar({
		items: [{
				xtype: 'tbbutton',
				text: '<?php __('Add'); ?>',
				tooltip:'<?php __('<b>Add CompetenceResult</b><br />Click here to create a new CompetenceResult'); ?>',
				icon: 'img/table_add.png',
				cls: 'x-btn-text-icon',
				handler: function(btn) {
					AddParentCompetenceResult();
				}
			}, ' ', '-', ' ', {
				xtype: 'tbbutton',
				text: '<?php __('Edit'); ?>',
				id: 'edit-parent-competenceResult',
				tooltip:'<?php __('<b>Edit CompetenceResult</b><br />Click here to modify the selected CompetenceResult'); ?>',
				icon: 'img/table_edit.png',
				cls: 'x-btn-text-icon',
				disabled: true,
				handler: function(btn) {
					var sm = g.getSelectionModel();
					var sel = sm.getSelected();
					if (sm.hasSelection()){
						EditParentCompetenceResult(sel.data.id);
					};
				}
			}, ' ', '-', ' ', {
				xtype: 'tbbutton',
				text: '<?php __('Delete'); ?>',
				id: 'delete-parent-competenceResult',
				tooltip:'<?php __('<b>Delete CompetenceResult(s)</b><br />Click here to remove the selected CompetenceResult(s)'); ?>',
				icon: 'img/table_delete.png',
				cls: 'x-btn-text-icon',
				disabled: true,
				handler: function(btn) {
					var sm = g.getSelectionModel();
					var sel = sm.getSelections();
					if (sm.hasSelection()){
						if(sel.length==1){
							Ext.Msg.show({
									title: '<?php __('Remove CompetenceResult'); ?>',
									buttons: Ext.MessageBox.YESNOCANCEL,
									msg: '<?php __('Remove'); ?> '+sel[0].data.name+'?',
									icon: Ext.MessageBox.QUESTION,
                                    fn: function(btn){
											if (btn == 'yes'){
													DeleteParentCompetenceResult(sel[0].data.id);
											}
									}
							});
						} else {
							Ext.Msg.show({
									title: '<?php __('Remove CompetenceResult'); ?>',
									buttons: Ext.MessageBox.YESNOCANCEL,
									msg: '<?php __('Remove the selected CompetenceResult'); ?>?',
									icon: Ext.MessageBox.QUESTION,
                                    fn: function(btn){
											if (btn == 'yes'){
													var sel_ids = '';
													for(i=0;i<sel.length;i++){
														if(i>0)
															sel_ids += '_';
														sel_ids += sel[i].data.id;
													}
													DeleteParentCompetenceResult(sel_ids);
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
				text: '<?php __('View CompetenceResult'); ?>',
				id: 'view-competenceResult2',
				tooltip:'<?php __('<b>View CompetenceResult</b><br />Click here to see details of the selected CompetenceResult'); ?>',
				icon: 'img/table_view.png',
				cls: 'x-btn-text-icon',
				disabled: true,
				handler: function(btn) {
					var sm = g.getSelectionModel();
					var sel = sm.getSelected();
					if (sm.hasSelection()){
						ViewCompetenceResult(sel.data.id);
					};
				},
				menu : {
					items: [
					]
				}

            }, ' ', '->', {
				xtype: 'textfield',
				emptyText: '<?php __('[Search By Name]'); ?>',
				id: 'parent_competenceResult_search_field',
				listeners: {
					specialkey: function(field, e){
						if (e.getKey() == e.ENTER) {
							SearchByParentCompetenceResultName(Ext.getCmp('parent_competenceResult_search_field').getValue());
						}
					}

				}
			}, {
				xtype: 'tbbutton',
				icon: 'img/search.png',
				cls: 'x-btn-text-icon',
				text: 'GO',
				tooltip:'<?php __('<b>GO</b><br />Click here to get search results'); ?>',
				id: 'parent_competenceResult_go_button',
				handler: function(){
					SearchByParentCompetenceResultName(Ext.getCmp('parent_competenceResult_search_field').getValue());
				}
			}, ' '
	]}),
	bbar: new Ext.PagingToolbar({
		pageSize: list_size,
		store: store_parent_competenceResults,
		displayInfo: true,
		displayMsg: '<?php __('Displaying {0} - {1} of {2}'); ?>',
		beforePageText: '<?php __('Page'); ?>',
		afterPageText: '<?php __('of {0}'); ?>',
		emptyMsg: '<?php __('No data to display'); ?>'
	})
});
g.getSelectionModel().on('rowselect', function(sm, rowIdx, r) {
	g.getTopToolbar().findById('edit-parent-competenceResult').enable();
	g.getTopToolbar().findById('delete-parent-competenceResult').enable();
        g.getTopToolbar().findById('view-competenceResult2').enable();
	if(this.getSelections().length > 1){
		g.getTopToolbar().findById('edit-parent-competenceResult').disable();
                g.getTopToolbar().findById('view-competenceResult2').disable();
	}
});
g.getSelectionModel().on('rowdeselect', function(sm, rowIdx, r) {
	if(this.getSelections().length > 1){
		g.getTopToolbar().findById('edit-parent-competenceResult').disable();
		g.getTopToolbar().findById('delete-parent-competenceResult').enable();
                g.getTopToolbar().findById('view-competenceResult2').disable();
	}
	else if(this.getSelections().length == 1){
		g.getTopToolbar().findById('edit-parent-competenceResult').enable();
		g.getTopToolbar().findById('delete-parent-competenceResult').enable();
                g.getTopToolbar().findById('view-competenceResult2').enable();
	}
	else{
		g.getTopToolbar().findById('edit-parent-competenceResult').disable();
		g.getTopToolbar().findById('delete-parent-competenceResult').disable();
                g.getTopToolbar().findById('view-competenceResult2').disable();
	}
});



var parentCompetenceResultsViewWindow = new Ext.Window({
	title: 'CompetenceResult Under the selected Item',
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
			parentCompetenceResultsViewWindow.close();
		}
	}]
});

store_parent_competenceResults.load({
    params: {
        start: 0,    
        limit: list_size
    }
});