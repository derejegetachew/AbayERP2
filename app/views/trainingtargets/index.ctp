
var store_trainingtargets = new Ext.data.GroupingStore({
	reader: new Ext.data.JsonReader({
		root:'rows',
		totalProperty: 'results',
		fields: [
			'id','name','created','modified'		]
	}),
	proxy: new Ext.data.HttpProxy({
		url: '<?php echo $this->Html->url(array('controller' => 'trainingtargets', 'action' => 'list_data')); ?>'
	})
,	sortInfo:{field: 'name', direction: "ASC"},
	groupField: 'created'
});


function AddTrainingtarget() {
	Ext.Ajax.request({
		url: '<?php echo $this->Html->url(array('controller' => 'trainingtargets', 'action' => 'add')); ?>',
		success: function(response, opts) {
			var trainingtarget_data = response.responseText;
			
			eval(trainingtarget_data);
			
			TrainingtargetAddWindow.show();
		},
		failure: function(response, opts) {
			Ext.Msg.alert('<?php __('Error'); ?>', '<?php __('Cannot get the trainingtarget add form. Error code'); ?>: ' + response.status);
		}
	});
}

function EditTrainingtarget(id) {
	Ext.Ajax.request({
		url: '<?php echo $this->Html->url(array('controller' => 'trainingtargets', 'action' => 'edit')); ?>/'+id,
		success: function(response, opts) {
			var trainingtarget_data = response.responseText;
			
			eval(trainingtarget_data);
			
			TrainingtargetEditWindow.show();
		},
		failure: function(response, opts) {
			Ext.Msg.alert('<?php __('Error'); ?>', '<?php __('Cannot get the trainingtarget edit form. Error code'); ?>: ' + response.status);
		}
	});
}

function ViewTrainingtarget(id) {
    Ext.Ajax.request({
        url: '<?php echo $this->Html->url(array('controller' => 'trainingtargets', 'action' => 'view')); ?>/'+id,
        success: function(response, opts) {
            var trainingtarget_data = response.responseText;

            eval(trainingtarget_data);

            TrainingtargetViewWindow.show();
        },
        failure: function(response, opts) {
            Ext.Msg.alert('<?php __('Error'); ?>', '<?php __('Cannot get the trainingtarget view form. Error code'); ?>: ' + response.status);
        }
    });
}
function ViewParentPlannedtrainings(id) {
    Ext.Ajax.request({
        url: '<?php echo $this->Html->url(array('controller' => 'plannedtrainings', 'action' => 'index2')); ?>/'+id,
        success: function(response, opts) {
            var parent_plannedtrainings_data = response.responseText;

            eval(parent_plannedtrainings_data);

            parentPlannedtrainingsViewWindow.show();
        },
        failure: function(response, opts) {
            Ext.Msg.alert('<?php __('Error'); ?>', '<?php __('Cannot get the campus view form. Error code'); ?>: ' + response.status);
        }
    });
}

function ViewParentTakentrainings(id) {
    Ext.Ajax.request({
        url: '<?php echo $this->Html->url(array('controller' => 'takentrainings', 'action' => 'index2')); ?>/'+id,
        success: function(response, opts) {
            var parent_takentrainings_data = response.responseText;

            eval(parent_takentrainings_data);

            parentTakentrainingsViewWindow.show();
        },
        failure: function(response, opts) {
            Ext.Msg.alert('<?php __('Error'); ?>', '<?php __('Cannot get the campus view form. Error code'); ?>: ' + response.status);
        }
    });
}


function DeleteTrainingtarget(id) {
	Ext.Ajax.request({
		url: '<?php echo $this->Html->url(array('controller' => 'trainingtargets', 'action' => 'delete')); ?>/'+id,
		success: function(response, opts) {
			Ext.Msg.alert('<?php __('Success'); ?>', '<?php __('Trainingtarget successfully deleted!'); ?>');
			RefreshTrainingtargetData();
		},
		failure: function(response, opts) {
			Ext.Msg.alert('<?php __('Error'); ?>', '<?php __('Cannot get the trainingtarget add form. Error code'); ?>: ' + response.status);
		}
	});
}

function SearchTrainingtarget(){
	Ext.Ajax.request({
		url: '<?php echo $this->Html->url(array('controller' => 'trainingtargets', 'action' => 'search')); ?>',
		success: function(response, opts){
			var trainingtarget_data = response.responseText;

			eval(trainingtarget_data);

			trainingtargetSearchWindow.show();
		},
		failure: function(response, opts) {
			Ext.Msg.alert('<?php __('Error'); ?>','<?php __('Cannot get the trainingtarget search form. Error Code'); ?>: ' + response.status);
		}
	});
}

function SearchByTrainingtargetName(value){
	var conditions = '\'Trainingtarget.name LIKE\' => \'%' + value + '%\'';
	store_trainingtargets.reload({
		 params: {
			start: 0,
			limit: list_size,
			conditions: conditions
	    }
	});
}

function RefreshTrainingtargetData() {
	store_trainingtargets.reload();
}


if(center_panel.find('id', 'trainingtarget-tab') != "") {
	var p = center_panel.findById('trainingtarget-tab');
	center_panel.setActiveTab(p);
} else {
	var p = center_panel.add({
		title: '<?php __('Trainingtargets'); ?>',
		closable: true,
		loadMask: true,
		stripeRows: true,
		id: 'trainingtarget-tab',
		xtype: 'grid',
		store: store_trainingtargets,
		columns: [
			{header: "<?php __('Name'); ?>", dataIndex: 'name', sortable: true},
			{header: "<?php __('Created'); ?>", dataIndex: 'created', sortable: true},
			{header: "<?php __('Modified'); ?>", dataIndex: 'modified', sortable: true}
		],
		
		view: new Ext.grid.GroupingView({
            forceFit:true,
            groupTextTpl: '{text} ({[values.rs.length]} {[values.rs.length > 1 ? "Trainingtargets" : "Trainingtarget"]})'
        })
,
		listeners: {
			celldblclick: function(){
				ViewTrainingtarget(Ext.getCmp('trainingtarget-tab').getSelectionModel().getSelected().data.id);
			}
		},
		sm: new Ext.grid.RowSelectionModel({
			singleSelect: false
		}),
		tbar: new Ext.Toolbar({
			
			items: [{
					xtype: 'tbbutton',
					text: '<?php __('Add'); ?>',
					tooltip:'<?php __('<b>Add Trainingtargets</b><br />Click here to create a new Trainingtarget'); ?>',
					icon: 'img/table_add.png',
					cls: 'x-btn-text-icon',
					handler: function(btn) {
						AddTrainingtarget();
					}
				}, ' ', '-', ' ', {
					xtype: 'tbbutton',
					text: '<?php __('Edit'); ?>',
					id: 'edit-trainingtarget',
					tooltip:'<?php __('<b>Edit Trainingtargets</b><br />Click here to modify the selected Trainingtarget'); ?>',
					icon: 'img/table_edit.png',
					cls: 'x-btn-text-icon',
					disabled: true,
					handler: function(btn) {
						var sm = p.getSelectionModel();
						var sel = sm.getSelected();
						if (sm.hasSelection()){
							EditTrainingtarget(sel.data.id);
						};
					}
				}, ' ', '-', ' ', {
					xtype: 'tbbutton',
					text: '<?php __('Delete'); ?>',
					id: 'delete-trainingtarget',
					tooltip:'<?php __('<b>Delete Trainingtargets(s)</b><br />Click here to remove the selected Trainingtarget(s)'); ?>',
					icon: 'img/table_delete.png',
					cls: 'x-btn-text-icon',
					disabled: true,
					handler: function(btn) {
						var sm = p.getSelectionModel();
						var sel = sm.getSelections();
						if (sm.hasSelection()){
							if(sel.length==1){
								Ext.Msg.show({
									title: '<?php __('Remove Trainingtarget'); ?>',
									buttons: Ext.MessageBox.YESNO,
									msg: '<?php __('Remove'); ?> '+sel[0].data.name+'?',
									icon: Ext.MessageBox.QUESTION,
									fn: function(btn){
										if (btn == 'yes'){
											DeleteTrainingtarget(sel[0].data.id);
										}
									}
								});
							}else{
								Ext.Msg.show({
									title: '<?php __('Remove Trainingtarget'); ?>',
									buttons: Ext.MessageBox.YESNO,
									msg: '<?php __('Remove the selected Trainingtargets'); ?>?',
									icon: Ext.MessageBox.QUESTION,
									fn: function(btn){
										if (btn == 'yes'){
											var sel_ids = '';
											for(i=0;i<sel.length;i++){
												if(i>0)
													sel_ids += '_';
												sel_ids += sel[i].data.id;
											}
											DeleteTrainingtarget(sel_ids);
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
					text: '<?php __('View Trainingtarget'); ?>',
					id: 'view-trainingtarget',
					tooltip:'<?php __('<b>View Trainingtarget</b><br />Click here to see details of the selected Trainingtarget'); ?>',
					icon: 'img/table_view.png',
					cls: 'x-btn-text-icon',
					disabled: true,
					handler: function(btn) {
						var sm = p.getSelectionModel();
						var sel = sm.getSelected();
						if (sm.hasSelection()){
							ViewTrainingtarget(sel.data.id);
						};
					},
					menu : {
						items: [
{
							text: '<?php __('View Plannedtrainings'); ?>',
                            icon: 'img/table_view.png',
							cls: 'x-btn-text-icon',
							handler: function(btn) {
								var sm = p.getSelectionModel();
								var sel = sm.getSelected();
								if (sm.hasSelection()){
									ViewParentPlannedtrainings(sel.data.id);
								};
							}
						}
,{
							text: '<?php __('View Takentrainings'); ?>',
                            icon: 'img/table_view.png',
							cls: 'x-btn-text-icon',
							handler: function(btn) {
								var sm = p.getSelectionModel();
								var sel = sm.getSelected();
								if (sm.hasSelection()){
									ViewParentTakentrainings(sel.data.id);
								};
							}
						}
						]
					}
				}, ' ', '-',  '->', {
					xtype: 'textfield',
					emptyText: '<?php __('[Search By Name]'); ?>',
					id: 'trainingtarget_search_field',
					listeners: {
						specialkey: function(field, e){
							if (e.getKey() == e.ENTER) {
								SearchByTrainingtargetName(Ext.getCmp('trainingtarget_search_field').getValue());
							}
						}
					}
				}, {
					xtype: 'tbbutton',
					icon: 'img/search.png',
					cls: 'x-btn-text-icon',
					text: '<?php __('GO'); ?>',
                    tooltip:'<?php __('<b>GO</b><br />Click here to get search results'); ?>',
					id: 'trainingtarget_go_button',
					handler: function(){
						SearchByTrainingtargetName(Ext.getCmp('trainingtarget_search_field').getValue());
					}
				}, '-', {
					xtype: 'tbbutton',
					icon: 'img/table_search.png',
					cls: 'x-btn-text-icon',
					text: '<?php __('Advanced Search'); ?>',
                    tooltip:'<?php __('<b>Advanced Search...</b><br />Click here to get the advanced search form'); ?>',
					handler: function(){
						SearchTrainingtarget();
					}
				}
		]}),
		bbar: new Ext.PagingToolbar({
			pageSize: list_size,
			store: store_trainingtargets,
			displayInfo: true,
			displayMsg: '<?php __('Displaying {0} - {1} of {2}'); ?>',
			beforePageText: '<?php __('Page'); ?>',
			afterPageText: '<?php __('of {0}'); ?>',
			emptyMsg: '<?php __('No data to display'); ?>'
		})
	});
	p.getSelectionModel().on('rowselect', function(sm, rowIdx, r) {
		p.getTopToolbar().findById('edit-trainingtarget').enable();
		p.getTopToolbar().findById('delete-trainingtarget').enable();
		p.getTopToolbar().findById('view-trainingtarget').enable();
		if(this.getSelections().length > 1){
			p.getTopToolbar().findById('edit-trainingtarget').disable();
			p.getTopToolbar().findById('view-trainingtarget').disable();
		}
	});
	p.getSelectionModel().on('rowdeselect', function(sm, rowIdx, r) {
		if(this.getSelections().length > 1){
			p.getTopToolbar().findById('edit-trainingtarget').disable();
			p.getTopToolbar().findById('view-trainingtarget').disable();
			p.getTopToolbar().findById('delete-trainingtarget').enable();
		}
		else if(this.getSelections().length == 1){
			p.getTopToolbar().findById('edit-trainingtarget').enable();
			p.getTopToolbar().findById('view-trainingtarget').enable();
			p.getTopToolbar().findById('delete-trainingtarget').enable();
		}
		else{
			p.getTopToolbar().findById('edit-trainingtarget').disable();
			p.getTopToolbar().findById('view-trainingtarget').disable();
			p.getTopToolbar().findById('delete-trainingtarget').disable();
		}
	});
	center_panel.setActiveTab(p);
	
	store_trainingtargets.load({
		params: {
			start: 0,          
			limit: list_size
		}
	});
	
}
