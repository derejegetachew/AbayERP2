
var store_trainingvenues = new Ext.data.GroupingStore({
	reader: new Ext.data.JsonReader({
		root:'rows',
		totalProperty: 'results',
		fields: [
			'id','name','address','created','modified'		]
	}),
	proxy: new Ext.data.HttpProxy({
		url: '<?php echo $this->Html->url(array('controller' => 'trainingvenues', 'action' => 'list_data')); ?>'
	})
,	sortInfo:{field: 'name', direction: "ASC"},
	groupField: 'address'
});


function AddTrainingvenue() {
	Ext.Ajax.request({
		url: '<?php echo $this->Html->url(array('controller' => 'trainingvenues', 'action' => 'add')); ?>',
		success: function(response, opts) {
			var trainingvenue_data = response.responseText;
			
			eval(trainingvenue_data);
			
			TrainingvenueAddWindow.show();
		},
		failure: function(response, opts) {
			Ext.Msg.alert('<?php __('Error'); ?>', '<?php __('Cannot get the trainingvenue add form. Error code'); ?>: ' + response.status);
		}
	});
}

function EditTrainingvenue(id) {
	Ext.Ajax.request({
		url: '<?php echo $this->Html->url(array('controller' => 'trainingvenues', 'action' => 'edit')); ?>/'+id,
		success: function(response, opts) {
			var trainingvenue_data = response.responseText;
			
			eval(trainingvenue_data);
			
			TrainingvenueEditWindow.show();
		},
		failure: function(response, opts) {
			Ext.Msg.alert('<?php __('Error'); ?>', '<?php __('Cannot get the trainingvenue edit form. Error code'); ?>: ' + response.status);
		}
	});
}

function ViewTrainingvenue(id) {
    Ext.Ajax.request({
        url: '<?php echo $this->Html->url(array('controller' => 'trainingvenues', 'action' => 'view')); ?>/'+id,
        success: function(response, opts) {
            var trainingvenue_data = response.responseText;

            eval(trainingvenue_data);

            TrainingvenueViewWindow.show();
        },
        failure: function(response, opts) {
            Ext.Msg.alert('<?php __('Error'); ?>', '<?php __('Cannot get the trainingvenue view form. Error code'); ?>: ' + response.status);
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


function DeleteTrainingvenue(id) {
	Ext.Ajax.request({
		url: '<?php echo $this->Html->url(array('controller' => 'trainingvenues', 'action' => 'delete')); ?>/'+id,
		success: function(response, opts) {
			Ext.Msg.alert('<?php __('Success'); ?>', '<?php __('Trainingvenue successfully deleted!'); ?>');
			RefreshTrainingvenueData();
		},
		failure: function(response, opts) {
			Ext.Msg.alert('<?php __('Error'); ?>', '<?php __('Cannot get the trainingvenue add form. Error code'); ?>: ' + response.status);
		}
	});
}

function SearchTrainingvenue(){
	Ext.Ajax.request({
		url: '<?php echo $this->Html->url(array('controller' => 'trainingvenues', 'action' => 'search')); ?>',
		success: function(response, opts){
			var trainingvenue_data = response.responseText;

			eval(trainingvenue_data);

			trainingvenueSearchWindow.show();
		},
		failure: function(response, opts) {
			Ext.Msg.alert('<?php __('Error'); ?>','<?php __('Cannot get the trainingvenue search form. Error Code'); ?>: ' + response.status);
		}
	});
}

function SearchByTrainingvenueName(value){
	var conditions = '\'Trainingvenue.name LIKE\' => \'%' + value + '%\'';
	store_trainingvenues.reload({
		 params: {
			start: 0,
			limit: list_size,
			conditions: conditions
	    }
	});
}

function RefreshTrainingvenueData() {
	store_trainingvenues.reload();
}


if(center_panel.find('id', 'trainingvenue-tab') != "") {
	var p = center_panel.findById('trainingvenue-tab');
	center_panel.setActiveTab(p);
} else {
	var p = center_panel.add({
		title: '<?php __('Trainingvenues'); ?>',
		closable: true,
		loadMask: true,
		stripeRows: true,
		id: 'trainingvenue-tab',
		xtype: 'grid',
		store: store_trainingvenues,
		columns: [
			{header: "<?php __('Name'); ?>", dataIndex: 'name', sortable: true},
			{header: "<?php __('Address'); ?>", dataIndex: 'address', sortable: true},
			{header: "<?php __('Created'); ?>", dataIndex: 'created', sortable: true},
			{header: "<?php __('Modified'); ?>", dataIndex: 'modified', sortable: true}
		],
		
		view: new Ext.grid.GroupingView({
            forceFit:true,
            groupTextTpl: '{text} ({[values.rs.length]} {[values.rs.length > 1 ? "Trainingvenues" : "Trainingvenue"]})'
        })
,
		listeners: {
			celldblclick: function(){
				ViewTrainingvenue(Ext.getCmp('trainingvenue-tab').getSelectionModel().getSelected().data.id);
			}
		},
		sm: new Ext.grid.RowSelectionModel({
			singleSelect: false
		}),
		tbar: new Ext.Toolbar({
			
			items: [{
					xtype: 'tbbutton',
					text: '<?php __('Add'); ?>',
					tooltip:'<?php __('<b>Add Trainingvenues</b><br />Click here to create a new Trainingvenue'); ?>',
					icon: 'img/table_add.png',
					cls: 'x-btn-text-icon',
					handler: function(btn) {
						AddTrainingvenue();
					}
				}, ' ', '-', ' ', {
					xtype: 'tbbutton',
					text: '<?php __('Edit'); ?>',
					id: 'edit-trainingvenue',
					tooltip:'<?php __('<b>Edit Trainingvenues</b><br />Click here to modify the selected Trainingvenue'); ?>',
					icon: 'img/table_edit.png',
					cls: 'x-btn-text-icon',
					disabled: true,
					handler: function(btn) {
						var sm = p.getSelectionModel();
						var sel = sm.getSelected();
						if (sm.hasSelection()){
							EditTrainingvenue(sel.data.id);
						};
					}
				}, ' ', '-', ' ', {
					xtype: 'tbbutton',
					text: '<?php __('Delete'); ?>',
					id: 'delete-trainingvenue',
					tooltip:'<?php __('<b>Delete Trainingvenues(s)</b><br />Click here to remove the selected Trainingvenue(s)'); ?>',
					icon: 'img/table_delete.png',
					cls: 'x-btn-text-icon',
					disabled: true,
					handler: function(btn) {
						var sm = p.getSelectionModel();
						var sel = sm.getSelections();
						if (sm.hasSelection()){
							if(sel.length==1){
								Ext.Msg.show({
									title: '<?php __('Remove Trainingvenue'); ?>',
									buttons: Ext.MessageBox.YESNO,
									msg: '<?php __('Remove'); ?> '+sel[0].data.name+'?',
									icon: Ext.MessageBox.QUESTION,
									fn: function(btn){
										if (btn == 'yes'){
											DeleteTrainingvenue(sel[0].data.id);
										}
									}
								});
							}else{
								Ext.Msg.show({
									title: '<?php __('Remove Trainingvenue'); ?>',
									buttons: Ext.MessageBox.YESNO,
									msg: '<?php __('Remove the selected Trainingvenues'); ?>?',
									icon: Ext.MessageBox.QUESTION,
									fn: function(btn){
										if (btn == 'yes'){
											var sel_ids = '';
											for(i=0;i<sel.length;i++){
												if(i>0)
													sel_ids += '_';
												sel_ids += sel[i].data.id;
											}
											DeleteTrainingvenue(sel_ids);
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
					text: '<?php __('View Trainingvenue'); ?>',
					id: 'view-trainingvenue',
					tooltip:'<?php __('<b>View Trainingvenue</b><br />Click here to see details of the selected Trainingvenue'); ?>',
					icon: 'img/table_view.png',
					cls: 'x-btn-text-icon',
					disabled: true,
					handler: function(btn) {
						var sm = p.getSelectionModel();
						var sel = sm.getSelected();
						if (sm.hasSelection()){
							ViewTrainingvenue(sel.data.id);
						};
					},
					menu : {
						items: [
{
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
					id: 'trainingvenue_search_field',
					listeners: {
						specialkey: function(field, e){
							if (e.getKey() == e.ENTER) {
								SearchByTrainingvenueName(Ext.getCmp('trainingvenue_search_field').getValue());
							}
						}
					}
				}, {
					xtype: 'tbbutton',
					icon: 'img/search.png',
					cls: 'x-btn-text-icon',
					text: '<?php __('GO'); ?>',
                    tooltip:'<?php __('<b>GO</b><br />Click here to get search results'); ?>',
					id: 'trainingvenue_go_button',
					handler: function(){
						SearchByTrainingvenueName(Ext.getCmp('trainingvenue_search_field').getValue());
					}
				}, '-', {
					xtype: 'tbbutton',
					icon: 'img/table_search.png',
					cls: 'x-btn-text-icon',
					text: '<?php __('Advanced Search'); ?>',
                    tooltip:'<?php __('<b>Advanced Search...</b><br />Click here to get the advanced search form'); ?>',
					handler: function(){
						SearchTrainingvenue();
					}
				}
		]}),
		bbar: new Ext.PagingToolbar({
			pageSize: list_size,
			store: store_trainingvenues,
			displayInfo: true,
			displayMsg: '<?php __('Displaying {0} - {1} of {2}'); ?>',
			beforePageText: '<?php __('Page'); ?>',
			afterPageText: '<?php __('of {0}'); ?>',
			emptyMsg: '<?php __('No data to display'); ?>'
		})
	});
	p.getSelectionModel().on('rowselect', function(sm, rowIdx, r) {
		p.getTopToolbar().findById('edit-trainingvenue').enable();
		p.getTopToolbar().findById('delete-trainingvenue').enable();
		p.getTopToolbar().findById('view-trainingvenue').enable();
		if(this.getSelections().length > 1){
			p.getTopToolbar().findById('edit-trainingvenue').disable();
			p.getTopToolbar().findById('view-trainingvenue').disable();
		}
	});
	p.getSelectionModel().on('rowdeselect', function(sm, rowIdx, r) {
		if(this.getSelections().length > 1){
			p.getTopToolbar().findById('edit-trainingvenue').disable();
			p.getTopToolbar().findById('view-trainingvenue').disable();
			p.getTopToolbar().findById('delete-trainingvenue').enable();
		}
		else if(this.getSelections().length == 1){
			p.getTopToolbar().findById('edit-trainingvenue').enable();
			p.getTopToolbar().findById('view-trainingvenue').enable();
			p.getTopToolbar().findById('delete-trainingvenue').enable();
		}
		else{
			p.getTopToolbar().findById('edit-trainingvenue').disable();
			p.getTopToolbar().findById('view-trainingvenue').disable();
			p.getTopToolbar().findById('delete-trainingvenue').disable();
		}
	});
	center_panel.setActiveTab(p);
	
	store_trainingvenues.load({
		params: {
			start: 0,          
			limit: list_size
		}
	});
	
}
