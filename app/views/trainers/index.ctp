
var store_trainers = new Ext.data.GroupingStore({
	reader: new Ext.data.JsonReader({
		root:'rows',
		totalProperty: 'results',
		fields: [
			'id','name','type','created','modified'		]
	}),
	proxy: new Ext.data.HttpProxy({
		url: '<?php echo $this->Html->url(array('controller' => 'trainers', 'action' => 'list_data')); ?>'
	})
,	sortInfo:{field: 'name', direction: "ASC"},
	groupField: 'type'
});


function AddTrainer() {
	Ext.Ajax.request({
		url: '<?php echo $this->Html->url(array('controller' => 'trainers', 'action' => 'add')); ?>',
		success: function(response, opts) {
			var trainer_data = response.responseText;
			
			eval(trainer_data);
			
			TrainerAddWindow.show();
		},
		failure: function(response, opts) {
			Ext.Msg.alert('<?php __('Error'); ?>', '<?php __('Cannot get the trainer add form. Error code'); ?>: ' + response.status);
		}
	});
}

function EditTrainer(id) {
	Ext.Ajax.request({
		url: '<?php echo $this->Html->url(array('controller' => 'trainers', 'action' => 'edit')); ?>/'+id,
		success: function(response, opts) {
			var trainer_data = response.responseText;
			
			eval(trainer_data);
			
			TrainerEditWindow.show();
		},
		failure: function(response, opts) {
			Ext.Msg.alert('<?php __('Error'); ?>', '<?php __('Cannot get the trainer edit form. Error code'); ?>: ' + response.status);
		}
	});
}

function ViewTrainer(id) {
    Ext.Ajax.request({
        url: '<?php echo $this->Html->url(array('controller' => 'trainers', 'action' => 'view')); ?>/'+id,
        success: function(response, opts) {
            var trainer_data = response.responseText;

            eval(trainer_data);

            TrainerViewWindow.show();
        },
        failure: function(response, opts) {
            Ext.Msg.alert('<?php __('Error'); ?>', '<?php __('Cannot get the trainer view form. Error code'); ?>: ' + response.status);
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


function DeleteTrainer(id) {
	Ext.Ajax.request({
		url: '<?php echo $this->Html->url(array('controller' => 'trainers', 'action' => 'delete')); ?>/'+id,
		success: function(response, opts) {
			Ext.Msg.alert('<?php __('Success'); ?>', '<?php __('Trainer successfully deleted!'); ?>');
			RefreshTrainerData();
		},
		failure: function(response, opts) {
			Ext.Msg.alert('<?php __('Error'); ?>', '<?php __('Cannot get the trainer add form. Error code'); ?>: ' + response.status);
		}
	});
}

function SearchTrainer(){
	Ext.Ajax.request({
		url: '<?php echo $this->Html->url(array('controller' => 'trainers', 'action' => 'search')); ?>',
		success: function(response, opts){
			var trainer_data = response.responseText;

			eval(trainer_data);

			trainerSearchWindow.show();
		},
		failure: function(response, opts) {
			Ext.Msg.alert('<?php __('Error'); ?>','<?php __('Cannot get the trainer search form. Error Code'); ?>: ' + response.status);
		}
	});
}

function SearchByTrainerName(value){
	var conditions = '\'Trainer.name LIKE\' => \'%' + value + '%\'';
	store_trainers.reload({
		 params: {
			start: 0,
			limit: list_size,
			conditions: conditions
	    }
	});
}

function RefreshTrainerData() {
	store_trainers.reload();
}


if(center_panel.find('id', 'trainer-tab') != "") {
	var p = center_panel.findById('trainer-tab');
	center_panel.setActiveTab(p);
} else {
	var p = center_panel.add({
		title: '<?php __('Trainers'); ?>',
		closable: true,
		loadMask: true,
		stripeRows: true,
		id: 'trainer-tab',
		xtype: 'grid',
		store: store_trainers,
		columns: [
			{header: "<?php __('Name'); ?>", dataIndex: 'name', sortable: true},
			{header: "<?php __('Type'); ?>", dataIndex: 'type', sortable: true},
			{header: "<?php __('Created'); ?>", dataIndex: 'created', sortable: true},
			{header: "<?php __('Modified'); ?>", dataIndex: 'modified', sortable: true}
		],
		
		view: new Ext.grid.GroupingView({
            forceFit:true,
            groupTextTpl: '{text} ({[values.rs.length]} {[values.rs.length > 1 ? "Trainers" : "Trainer"]})'
        })
,
		listeners: {
			celldblclick: function(){
				ViewTrainer(Ext.getCmp('trainer-tab').getSelectionModel().getSelected().data.id);
			}
		},
		sm: new Ext.grid.RowSelectionModel({
			singleSelect: false
		}),
		tbar: new Ext.Toolbar({
			
			items: [{
					xtype: 'tbbutton',
					text: '<?php __('Add'); ?>',
					tooltip:'<?php __('<b>Add Trainers</b><br />Click here to create a new Trainer'); ?>',
					icon: 'img/table_add.png',
					cls: 'x-btn-text-icon',
					handler: function(btn) {
						AddTrainer();
					}
				}, ' ', '-', ' ', {
					xtype: 'tbbutton',
					text: '<?php __('Edit'); ?>',
					id: 'edit-trainer',
					tooltip:'<?php __('<b>Edit Trainers</b><br />Click here to modify the selected Trainer'); ?>',
					icon: 'img/table_edit.png',
					cls: 'x-btn-text-icon',
					disabled: true,
					handler: function(btn) {
						var sm = p.getSelectionModel();
						var sel = sm.getSelected();
						if (sm.hasSelection()){
							EditTrainer(sel.data.id);
						};
					}
				}, ' ', '-', ' ', {
					xtype: 'tbbutton',
					text: '<?php __('Delete'); ?>',
					id: 'delete-trainer',
					tooltip:'<?php __('<b>Delete Trainers(s)</b><br />Click here to remove the selected Trainer(s)'); ?>',
					icon: 'img/table_delete.png',
					cls: 'x-btn-text-icon',
					disabled: true,
					handler: function(btn) {
						var sm = p.getSelectionModel();
						var sel = sm.getSelections();
						if (sm.hasSelection()){
							if(sel.length==1){
								Ext.Msg.show({
									title: '<?php __('Remove Trainer'); ?>',
									buttons: Ext.MessageBox.YESNO,
									msg: '<?php __('Remove'); ?> '+sel[0].data.name+'?',
									icon: Ext.MessageBox.QUESTION,
									fn: function(btn){
										if (btn == 'yes'){
											DeleteTrainer(sel[0].data.id);
										}
									}
								});
							}else{
								Ext.Msg.show({
									title: '<?php __('Remove Trainer'); ?>',
									buttons: Ext.MessageBox.YESNO,
									msg: '<?php __('Remove the selected Trainers'); ?>?',
									icon: Ext.MessageBox.QUESTION,
									fn: function(btn){
										if (btn == 'yes'){
											var sel_ids = '';
											for(i=0;i<sel.length;i++){
												if(i>0)
													sel_ids += '_';
												sel_ids += sel[i].data.id;
											}
											DeleteTrainer(sel_ids);
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
					text: '<?php __('View Trainer'); ?>',
					id: 'view-trainer',
					tooltip:'<?php __('<b>View Trainer</b><br />Click here to see details of the selected Trainer'); ?>',
					icon: 'img/table_view.png',
					cls: 'x-btn-text-icon',
					disabled: true,
					handler: function(btn) {
						var sm = p.getSelectionModel();
						var sel = sm.getSelected();
						if (sm.hasSelection()){
							ViewTrainer(sel.data.id);
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
					id: 'trainer_search_field',
					listeners: {
						specialkey: function(field, e){
							if (e.getKey() == e.ENTER) {
								SearchByTrainerName(Ext.getCmp('trainer_search_field').getValue());
							}
						}
					}
				}, {
					xtype: 'tbbutton',
					icon: 'img/search.png',
					cls: 'x-btn-text-icon',
					text: '<?php __('GO'); ?>',
                    tooltip:'<?php __('<b>GO</b><br />Click here to get search results'); ?>',
					id: 'trainer_go_button',
					handler: function(){
						SearchByTrainerName(Ext.getCmp('trainer_search_field').getValue());
					}
				}, '-', {
					xtype: 'tbbutton',
					icon: 'img/table_search.png',
					cls: 'x-btn-text-icon',
					text: '<?php __('Advanced Search'); ?>',
                    tooltip:'<?php __('<b>Advanced Search...</b><br />Click here to get the advanced search form'); ?>',
					handler: function(){
						SearchTrainer();
					}
				}
		]}),
		bbar: new Ext.PagingToolbar({
			pageSize: list_size,
			store: store_trainers,
			displayInfo: true,
			displayMsg: '<?php __('Displaying {0} - {1} of {2}'); ?>',
			beforePageText: '<?php __('Page'); ?>',
			afterPageText: '<?php __('of {0}'); ?>',
			emptyMsg: '<?php __('No data to display'); ?>'
		})
	});
	p.getSelectionModel().on('rowselect', function(sm, rowIdx, r) {
		p.getTopToolbar().findById('edit-trainer').enable();
		p.getTopToolbar().findById('delete-trainer').enable();
		p.getTopToolbar().findById('view-trainer').enable();
		if(this.getSelections().length > 1){
			p.getTopToolbar().findById('edit-trainer').disable();
			p.getTopToolbar().findById('view-trainer').disable();
		}
	});
	p.getSelectionModel().on('rowdeselect', function(sm, rowIdx, r) {
		if(this.getSelections().length > 1){
			p.getTopToolbar().findById('edit-trainer').disable();
			p.getTopToolbar().findById('view-trainer').disable();
			p.getTopToolbar().findById('delete-trainer').enable();
		}
		else if(this.getSelections().length == 1){
			p.getTopToolbar().findById('edit-trainer').enable();
			p.getTopToolbar().findById('view-trainer').enable();
			p.getTopToolbar().findById('delete-trainer').enable();
		}
		else{
			p.getTopToolbar().findById('edit-trainer').disable();
			p.getTopToolbar().findById('view-trainer').disable();
			p.getTopToolbar().findById('delete-trainer').disable();
		}
	});
	center_panel.setActiveTab(p);
	
	store_trainers.load({
		params: {
			start: 0,          
			limit: list_size
		}
	});
	
}
