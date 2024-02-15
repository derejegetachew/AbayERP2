
var store_takentrainings = new Ext.data.GroupingStore({
	reader: new Ext.data.JsonReader({
		root:'rows',
		totalProperty: 'results',
		fields: [
			'id','training','from','to','half_day','trainingvenue','cost_per_person','trainer','trainingtarget','certification','created','modified'		]
	}),
	proxy: new Ext.data.HttpProxy({
		url: '<?php echo $this->Html->url(array('controller' => 'takentrainings', 'action' => 'list_data')); ?>'
	})
});


function AddTakentraining() {
	Ext.Ajax.request({
		url: '<?php echo $this->Html->url(array('controller' => 'takentrainings', 'action' => 'add')); ?>',
		success: function(response, opts) {
			var takentraining_data = response.responseText;
			
			eval(takentraining_data);
			
			TakentrainingAddWindow.show();
		},
		failure: function(response, opts) {
			Ext.Msg.alert('<?php __('Error'); ?>', '<?php __('Cannot get the takentraining add form. Error code'); ?>: ' + response.status);
		}
	});
}

function EditTakentraining(id) {
	Ext.Ajax.request({
		url: '<?php echo $this->Html->url(array('controller' => 'takentrainings', 'action' => 'edit')); ?>/'+id,
		success: function(response, opts) {
			var takentraining_data = response.responseText;
			
			eval(takentraining_data);
			
			TakentrainingEditWindow.show();
		},
		failure: function(response, opts) {
			Ext.Msg.alert('<?php __('Error'); ?>', '<?php __('Cannot get the takentraining edit form. Error code'); ?>: ' + response.status);
		}
	});
}

function ViewTakentraining(id) {
    Ext.Ajax.request({
        url: '<?php echo $this->Html->url(array('controller' => 'takentrainings', 'action' => 'view')); ?>/'+id,
        success: function(response, opts) {
            var takentraining_data = response.responseText;

            eval(takentraining_data);

            TakentrainingViewWindow.show();
        },
        failure: function(response, opts) {
            Ext.Msg.alert('<?php __('Error'); ?>', '<?php __('Cannot get the takentraining view form. Error code'); ?>: ' + response.status);
        }
    });
}
function ViewParentStafftooktrainings(id) {
    Ext.Ajax.request({
        url: '<?php echo $this->Html->url(array('controller' => 'stafftooktrainings', 'action' => 'index2')); ?>/'+id,
        success: function(response, opts) {
            var parent_stafftooktrainings_data = response.responseText;

            eval(parent_stafftooktrainings_data);

            parentStafftooktrainingsViewWindow.show();
        },
        failure: function(response, opts) {
            Ext.Msg.alert('<?php __('Error'); ?>', '<?php __('Cannot get the campus view form. Error code'); ?>: ' + response.status);
        }
    });
}


function DeleteTakentraining(id) {
	Ext.Ajax.request({
		url: '<?php echo $this->Html->url(array('controller' => 'takentrainings', 'action' => 'delete')); ?>/'+id,
		success: function(response, opts) {
			Ext.Msg.alert('<?php __('Success'); ?>', '<?php __('Takentraining successfully deleted!'); ?>');
			RefreshTakentrainingData();
		},
		failure: function(response, opts) {
			Ext.Msg.alert('<?php __('Error'); ?>', '<?php __('Cannot get the takentraining add form. Error code'); ?>: ' + response.status);
		}
	});
}

function SearchTakentraining(){
	Ext.Ajax.request({
		url: '<?php echo $this->Html->url(array('controller' => 'takentrainings', 'action' => 'search')); ?>',
		success: function(response, opts){
			var takentraining_data = response.responseText;

			eval(takentraining_data);

			takentrainingSearchWindow.show();
		},
		failure: function(response, opts) {
			Ext.Msg.alert('<?php __('Error'); ?>','<?php __('Cannot get the takentraining search form. Error Code'); ?>: ' + response.status);
		}
	});
}

function SearchByTakentrainingName(value){
	var conditions = '\'Takentraining.name LIKE\' => \'%' + value + '%\'';
	store_takentrainings.reload({
		 params: {
			start: 0,
			limit: list_size,
			conditions: conditions
	    }
	});
}

function RefreshTakentrainingData() {
	store_takentrainings.reload();
}

 var vstore_employee_names = new Ext.data.Store({
	reader: new Ext.data.JsonReader({
            root:'rows',
            fields: [
                'id', 'user_id','full_name','position'		
            ]
	}),
	proxy: new Ext.data.HttpProxy({
            url: '<?php echo $this->Html->url(array('controller' => 'employees', 'action' => 'search_emp7')); ?>'
	}),	
        sortInfo:{field: 'full_name', direction: "ASC"}
    });
      vstore_employee_names.load({
            params: {
                start: 0
            }
        });

if(center_panel.find('id', 'takentraining-tab') != "") {
	var p = center_panel.findById('takentraining-tab');
	center_panel.setActiveTab(p);
} else {
	var p = center_panel.add({
		title: '<?php __('Takentrainings'); ?>',
		closable: true,
		loadMask: true,
		stripeRows: true,
		id: 'takentraining-tab',
		xtype: 'grid',
		store: store_takentrainings,
		columns: [
			{header: "<?php __('Training'); ?>", dataIndex: 'training', sortable: true},
			{header: "<?php __('From'); ?>", dataIndex: 'from', sortable: true},
			{header: "<?php __('To'); ?>", dataIndex: 'to', sortable: true},
			{header: "<?php __('Half Day'); ?>", dataIndex: 'half_day', sortable: true},
			{header: "<?php __('Trainingvenue'); ?>", dataIndex: 'trainingvenue', sortable: true},
			{header: "<?php __('Cost Per Person'); ?>", dataIndex: 'cost_per_person', sortable: true},
			{header: "<?php __('Trainer'); ?>", dataIndex: 'trainer', sortable: true},
			{header: "<?php __('Trainingtarget'); ?>", dataIndex: 'trainingtarget', sortable: true},
			{header: "<?php __('Certification'); ?>", dataIndex: 'certification', sortable: true},
			{header: "<?php __('Created'); ?>", dataIndex: 'created', sortable: true},
			{header: "<?php __('Modified'); ?>", dataIndex: 'modified', sortable: true}
		],
		
		view: new Ext.grid.GroupingView({
            forceFit:true,
            groupTextTpl: '{text} ({[values.rs.length]} {[values.rs.length > 1 ? "Takentrainings" : "Takentraining"]})'
        })
,
		listeners: {
			celldblclick: function(){
				ViewTakentraining(Ext.getCmp('takentraining-tab').getSelectionModel().getSelected().data.id);
			}
		},
		sm: new Ext.grid.RowSelectionModel({
			singleSelect: false
		}),
		tbar: new Ext.Toolbar({
			
			items: [{
					xtype: 'tbbutton',
					text: '<?php __('Add'); ?>',
					tooltip:'<?php __('<b>Add Takentrainings</b><br />Click here to create a new Takentraining'); ?>',
					icon: 'img/table_add.png',
					cls: 'x-btn-text-icon',
					handler: function(btn) {
						AddTakentraining();
					}
				}, ' ', '-', ' ', {
					xtype: 'tbbutton',
					text: '<?php __('Edit'); ?>',
					id: 'edit-takentraining',
					tooltip:'<?php __('<b>Edit Takentrainings</b><br />Click here to modify the selected Takentraining'); ?>',
					icon: 'img/table_edit.png',
					cls: 'x-btn-text-icon',
					disabled: true,
					handler: function(btn) {
						var sm = p.getSelectionModel();
						var sel = sm.getSelected();
						if (sm.hasSelection()){
							EditTakentraining(sel.data.id);
						};
					}
				}, ' ', '-', ' ', {
					xtype: 'tbbutton',
					text: '<?php __('Delete'); ?>',
					id: 'delete-takentraining',
					tooltip:'<?php __('<b>Delete Takentrainings(s)</b><br />Click here to remove the selected Takentraining(s)'); ?>',
					icon: 'img/table_delete.png',
					cls: 'x-btn-text-icon',
					disabled: true,
					handler: function(btn) {
						var sm = p.getSelectionModel();
						var sel = sm.getSelections();
						if (sm.hasSelection()){
							if(sel.length==1){
								Ext.Msg.show({
									title: '<?php __('Remove Takentraining'); ?>',
									buttons: Ext.MessageBox.YESNO,
									msg: '<?php __('Remove'); ?> '+sel[0].data.name+'?',
									icon: Ext.MessageBox.QUESTION,
									fn: function(btn){
										if (btn == 'yes'){
											DeleteTakentraining(sel[0].data.id);
										}
									}
								});
							}else{
								Ext.Msg.show({
									title: '<?php __('Remove Takentraining'); ?>',
									buttons: Ext.MessageBox.YESNO,
									msg: '<?php __('Remove the selected Takentrainings'); ?>?',
									icon: Ext.MessageBox.QUESTION,
									fn: function(btn){
										if (btn == 'yes'){
											var sel_ids = '';
											for(i=0;i<sel.length;i++){
												if(i>0)
													sel_ids += '_';
												sel_ids += sel[i].data.id;
											}
											DeleteTakentraining(sel_ids);
										}
									}
								});
							}
						} else {
							Ext.Msg.alert('<?php __('Warning'); ?>', '<?php __('Please select a record first'); ?>');
						};
					}
				}, ' ', '-', ' ', {
					xtype: 'tbbutton',
					text: '<?php __('Employee List'); ?>',
					id: 'edit-list',
					icon: 'img/table_edit.png',
					cls: 'x-btn-text-icon',
					disabled: true,
					handler: function(btn) {
						var sm = p.getSelectionModel();
						var sel = sm.getSelected();
						if (sm.hasSelection()){
							ViewParentStafftooktrainings(sel.data.id);
						};
					}
				}, ' ', '-',  '<?php __('Training'); ?>: ', {
					xtype : 'combo',
					emptyText: 'All',
					store : new Ext.data.ArrayStore({
						fields : ['id', 'name'],
						data : [
							['-1', 'All'],
							<?php $st = false;foreach ($trainings as $item){if($st) echo ",
							";?>['<?php echo $item['Training']['id']; ?>' ,'<?php echo $item['Training']['name']; ?>']<?php $st = true;}?>						]
					}),
					displayField : 'name',
					valueField : 'id',
					mode : 'local',
					value : '-1',
					disableKeyFilter : true,
					triggerAction: 'all',
					listeners : {
						select : function(combo, record, index){
							store_takentrainings.reload({
								params: {
									start: 0,
									limit: list_size,
									training_id : combo.getValue()
								}
							});
						}
					}
				},
 '->', {
					xtype: 'textfield',
					emptyText: '<?php __('[Search By Name]'); ?>',
					id: 'takentraining_search_field',
					listeners: {
						specialkey: function(field, e){
							if (e.getKey() == e.ENTER) {
								SearchByTakentrainingName(Ext.getCmp('takentraining_search_field').getValue());
							}
						}
					}
				}, {
					xtype: 'tbbutton',
					icon: 'img/search.png',
					cls: 'x-btn-text-icon',
					text: '<?php __('GO'); ?>',
                    tooltip:'<?php __('<b>GO</b><br />Click here to get search results'); ?>',
					id: 'takentraining_go_button',
					handler: function(){
						SearchByTakentrainingName(Ext.getCmp('takentraining_search_field').getValue());
					}
				}, '-', {
					xtype: 'tbbutton',
					icon: 'img/table_search.png',
					cls: 'x-btn-text-icon',
					text: '<?php __('Advanced Search'); ?>',
                    tooltip:'<?php __('<b>Advanced Search...</b><br />Click here to get the advanced search form'); ?>',
					handler: function(){
						SearchTakentraining();
					}
				}
		]}),
		bbar: new Ext.PagingToolbar({
			pageSize: list_size,
			store: store_takentrainings,
			displayInfo: true,
			displayMsg: '<?php __('Displaying {0} - {1} of {2}'); ?>',
			beforePageText: '<?php __('Page'); ?>',
			afterPageText: '<?php __('of {0}'); ?>',
			emptyMsg: '<?php __('No data to display'); ?>'
		})
	});
	p.getSelectionModel().on('rowselect', function(sm, rowIdx, r) {
		p.getTopToolbar().findById('edit-takentraining').enable();
		p.getTopToolbar().findById('edit-list').enable();
		p.getTopToolbar().findById('delete-takentraining').enable();
		p.getTopToolbar().findById('view-takentraining').enable();
		if(this.getSelections().length > 1){
			p.getTopToolbar().findById('edit-takentraining').disable();
			p.getTopToolbar().findById('edit-list').disable();
			p.getTopToolbar().findById('view-takentraining').disable();
		}
	});
	p.getSelectionModel().on('rowdeselect', function(sm, rowIdx, r) {
		if(this.getSelections().length > 1){
			p.getTopToolbar().findById('edit-takentraining').disable();
			p.getTopToolbar().findById('edit-list').disable();
			p.getTopToolbar().findById('view-takentraining').disable();
			p.getTopToolbar().findById('delete-takentraining').enable();
		}
		else if(this.getSelections().length == 1){
			p.getTopToolbar().findById('edit-takentraining').enable();
			p.getTopToolbar().findById('edit-list').enable();
			p.getTopToolbar().findById('view-takentraining').enable();
			p.getTopToolbar().findById('delete-takentraining').enable();
		}
		else{
			p.getTopToolbar().findById('edit-takentraining').disable();
			p.getTopToolbar().findById('edit-list').disable();
			p.getTopToolbar().findById('view-takentraining').disable();
			p.getTopToolbar().findById('delete-takentraining').disable();
		}
	});
	center_panel.setActiveTab(p);
	
	store_takentrainings.load({
		params: {
			start: 0,          
			limit: list_size
		}
	});
	
}
