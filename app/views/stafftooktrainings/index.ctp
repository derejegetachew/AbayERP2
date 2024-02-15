
var store_stafftooktrainings = new Ext.data.GroupingStore({
	reader: new Ext.data.JsonReader({
		root:'rows',
		totalProperty: 'results',
		fields: [
			'id','takentraining','employee','position','branch','created','modified'		]
	}),
	proxy: new Ext.data.HttpProxy({
		url: '<?php echo $this->Html->url(array('controller' => 'stafftooktrainings', 'action' => 'list_data')); ?>'
	})
,	sortInfo:{field: 'takentraining_id', direction: "ASC"},
	groupField: 'employee_id'
});


function AddStafftooktraining() {
	Ext.Ajax.request({
		url: '<?php echo $this->Html->url(array('controller' => 'stafftooktrainings', 'action' => 'add')); ?>',
		success: function(response, opts) {
			var stafftooktraining_data = response.responseText;
			
			eval(stafftooktraining_data);
			
			StafftooktrainingAddWindow.show();
		},
		failure: function(response, opts) {
			Ext.Msg.alert('<?php __('Error'); ?>', '<?php __('Cannot get the stafftooktraining add form. Error code'); ?>: ' + response.status);
		}
	});
}

function EditStafftooktraining(id) {
	Ext.Ajax.request({
		url: '<?php echo $this->Html->url(array('controller' => 'stafftooktrainings', 'action' => 'edit')); ?>/'+id,
		success: function(response, opts) {
			var stafftooktraining_data = response.responseText;
			
			eval(stafftooktraining_data);
			
			StafftooktrainingEditWindow.show();
		},
		failure: function(response, opts) {
			Ext.Msg.alert('<?php __('Error'); ?>', '<?php __('Cannot get the stafftooktraining edit form. Error code'); ?>: ' + response.status);
		}
	});
}

function ViewStafftooktraining(id) {
    Ext.Ajax.request({
        url: '<?php echo $this->Html->url(array('controller' => 'stafftooktrainings', 'action' => 'view')); ?>/'+id,
        success: function(response, opts) {
            var stafftooktraining_data = response.responseText;

            eval(stafftooktraining_data);

            StafftooktrainingViewWindow.show();
        },
        failure: function(response, opts) {
            Ext.Msg.alert('<?php __('Error'); ?>', '<?php __('Cannot get the stafftooktraining view form. Error code'); ?>: ' + response.status);
        }
    });
}

function DeleteStafftooktraining(id) {
	Ext.Ajax.request({
		url: '<?php echo $this->Html->url(array('controller' => 'stafftooktrainings', 'action' => 'delete')); ?>/'+id,
		success: function(response, opts) {
			Ext.Msg.alert('<?php __('Success'); ?>', '<?php __('Stafftooktraining successfully deleted!'); ?>');
			RefreshStafftooktrainingData();
		},
		failure: function(response, opts) {
			Ext.Msg.alert('<?php __('Error'); ?>', '<?php __('Cannot get the stafftooktraining add form. Error code'); ?>: ' + response.status);
		}
	});
}

function SearchStafftooktraining(){
	Ext.Ajax.request({
		url: '<?php echo $this->Html->url(array('controller' => 'stafftooktrainings', 'action' => 'search')); ?>',
		success: function(response, opts){
			var stafftooktraining_data = response.responseText;

			eval(stafftooktraining_data);

			stafftooktrainingSearchWindow.show();
		},
		failure: function(response, opts) {
			Ext.Msg.alert('<?php __('Error'); ?>','<?php __('Cannot get the stafftooktraining search form. Error Code'); ?>: ' + response.status);
		}
	});
}

function SearchByStafftooktrainingName(value){
	var conditions = '\'Stafftooktraining.name LIKE\' => \'%' + value + '%\'';
	store_stafftooktrainings.reload({
		 params: {
			start: 0,
			limit: list_size,
			conditions: conditions
	    }
	});
}

function RefreshStafftooktrainingData() {
	store_stafftooktrainings.reload();
}


if(center_panel.find('id', 'stafftooktraining-tab') != "") {
	var p = center_panel.findById('stafftooktraining-tab');
	center_panel.setActiveTab(p);
} else {
	var p = center_panel.add({
		title: '<?php __('Stafftooktrainings'); ?>',
		closable: true,
		loadMask: true,
		stripeRows: true,
		id: 'stafftooktraining-tab',
		xtype: 'grid',
		store: store_stafftooktrainings,
		columns: [
			{header: "<?php __('Takentraining'); ?>", dataIndex: 'takentraining', sortable: true},
			{header: "<?php __('Employee'); ?>", dataIndex: 'employee', sortable: true},
			{header: "<?php __('Position'); ?>", dataIndex: 'position', sortable: true},
			{header: "<?php __('Branch'); ?>", dataIndex: 'branch', sortable: true},
			{header: "<?php __('Created'); ?>", dataIndex: 'created', sortable: true},
			{header: "<?php __('Modified'); ?>", dataIndex: 'modified', sortable: true}
		],
		
		view: new Ext.grid.GroupingView({
            forceFit:true,
            groupTextTpl: '{text} ({[values.rs.length]} {[values.rs.length > 1 ? "Stafftooktrainings" : "Stafftooktraining"]})'
        })
,
		listeners: {
			celldblclick: function(){
				ViewStafftooktraining(Ext.getCmp('stafftooktraining-tab').getSelectionModel().getSelected().data.id);
			}
		},
		sm: new Ext.grid.RowSelectionModel({
			singleSelect: false
		}),
		tbar: new Ext.Toolbar({
			
			items: [{
					xtype: 'tbbutton',
					text: '<?php __('Add'); ?>',
					tooltip:'<?php __('<b>Add Stafftooktrainings</b><br />Click here to create a new Stafftooktraining'); ?>',
					icon: 'img/table_add.png',
					cls: 'x-btn-text-icon',
					handler: function(btn) {
						AddStafftooktraining();
					}
				}, ' ', '-', ' ', {
					xtype: 'tbbutton',
					text: '<?php __('Edit'); ?>',
					id: 'edit-stafftooktraining',
					tooltip:'<?php __('<b>Edit Stafftooktrainings</b><br />Click here to modify the selected Stafftooktraining'); ?>',
					icon: 'img/table_edit.png',
					cls: 'x-btn-text-icon',
					disabled: true,
					handler: function(btn) {
						var sm = p.getSelectionModel();
						var sel = sm.getSelected();
						if (sm.hasSelection()){
							EditStafftooktraining(sel.data.id);
						};
					}
				}, ' ', '-', ' ', {
					xtype: 'tbbutton',
					text: '<?php __('Delete'); ?>',
					id: 'delete-stafftooktraining',
					tooltip:'<?php __('<b>Delete Stafftooktrainings(s)</b><br />Click here to remove the selected Stafftooktraining(s)'); ?>',
					icon: 'img/table_delete.png',
					cls: 'x-btn-text-icon',
					disabled: true,
					handler: function(btn) {
						var sm = p.getSelectionModel();
						var sel = sm.getSelections();
						if (sm.hasSelection()){
							if(sel.length==1){
								Ext.Msg.show({
									title: '<?php __('Remove Stafftooktraining'); ?>',
									buttons: Ext.MessageBox.YESNO,
									msg: '<?php __('Remove'); ?> '+sel[0].data.name+'?',
									icon: Ext.MessageBox.QUESTION,
									fn: function(btn){
										if (btn == 'yes'){
											DeleteStafftooktraining(sel[0].data.id);
										}
									}
								});
							}else{
								Ext.Msg.show({
									title: '<?php __('Remove Stafftooktraining'); ?>',
									buttons: Ext.MessageBox.YESNO,
									msg: '<?php __('Remove the selected Stafftooktrainings'); ?>?',
									icon: Ext.MessageBox.QUESTION,
									fn: function(btn){
										if (btn == 'yes'){
											var sel_ids = '';
											for(i=0;i<sel.length;i++){
												if(i>0)
													sel_ids += '_';
												sel_ids += sel[i].data.id;
											}
											DeleteStafftooktraining(sel_ids);
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
					text: '<?php __('View Stafftooktraining'); ?>',
					id: 'view-stafftooktraining',
					tooltip:'<?php __('<b>View Stafftooktraining</b><br />Click here to see details of the selected Stafftooktraining'); ?>',
					icon: 'img/table_view.png',
					cls: 'x-btn-text-icon',
					disabled: true,
					handler: function(btn) {
						var sm = p.getSelectionModel();
						var sel = sm.getSelected();
						if (sm.hasSelection()){
							ViewStafftooktraining(sel.data.id);
						};
					},
					menu : {
						items: [
						]
					}
				}, ' ', '-',  '<?php __('Takentraining'); ?>: ', {
					xtype : 'combo',
					emptyText: 'All',
					store : new Ext.data.ArrayStore({
						fields : ['id', 'name'],
						data : [
							['-1', 'All'],
							<?php $st = false;foreach ($takentrainings as $item){if($st) echo ",
							";?>['<?php echo $item['Takentraining']['id']; ?>' ,'<?php echo $item['Takentraining']['name']; ?>']<?php $st = true;}?>						]
					}),
					displayField : 'name',
					valueField : 'id',
					mode : 'local',
					value : '-1',
					disableKeyFilter : true,
					triggerAction: 'all',
					listeners : {
						select : function(combo, record, index){
							store_stafftooktrainings.reload({
								params: {
									start: 0,
									limit: list_size,
									takentraining_id : combo.getValue()
								}
							});
						}
					}
				},
 '->', {
					xtype: 'textfield',
					emptyText: '<?php __('[Search By Name]'); ?>',
					id: 'stafftooktraining_search_field',
					listeners: {
						specialkey: function(field, e){
							if (e.getKey() == e.ENTER) {
								SearchByStafftooktrainingName(Ext.getCmp('stafftooktraining_search_field').getValue());
							}
						}
					}
				}, {
					xtype: 'tbbutton',
					icon: 'img/search.png',
					cls: 'x-btn-text-icon',
					text: '<?php __('GO'); ?>',
                    tooltip:'<?php __('<b>GO</b><br />Click here to get search results'); ?>',
					id: 'stafftooktraining_go_button',
					handler: function(){
						SearchByStafftooktrainingName(Ext.getCmp('stafftooktraining_search_field').getValue());
					}
				}, '-', {
					xtype: 'tbbutton',
					icon: 'img/table_search.png',
					cls: 'x-btn-text-icon',
					text: '<?php __('Advanced Search'); ?>',
                    tooltip:'<?php __('<b>Advanced Search...</b><br />Click here to get the advanced search form'); ?>',
					handler: function(){
						SearchStafftooktraining();
					}
				}
		]}),
		bbar: new Ext.PagingToolbar({
			pageSize: list_size,
			store: store_stafftooktrainings,
			displayInfo: true,
			displayMsg: '<?php __('Displaying {0} - {1} of {2}'); ?>',
			beforePageText: '<?php __('Page'); ?>',
			afterPageText: '<?php __('of {0}'); ?>',
			emptyMsg: '<?php __('No data to display'); ?>'
		})
	});
	p.getSelectionModel().on('rowselect', function(sm, rowIdx, r) {
		p.getTopToolbar().findById('edit-stafftooktraining').enable();
		p.getTopToolbar().findById('delete-stafftooktraining').enable();
		p.getTopToolbar().findById('view-stafftooktraining').enable();
		if(this.getSelections().length > 1){
			p.getTopToolbar().findById('edit-stafftooktraining').disable();
			p.getTopToolbar().findById('view-stafftooktraining').disable();
		}
	});
	p.getSelectionModel().on('rowdeselect', function(sm, rowIdx, r) {
		if(this.getSelections().length > 1){
			p.getTopToolbar().findById('edit-stafftooktraining').disable();
			p.getTopToolbar().findById('view-stafftooktraining').disable();
			p.getTopToolbar().findById('delete-stafftooktraining').enable();
		}
		else if(this.getSelections().length == 1){
			p.getTopToolbar().findById('edit-stafftooktraining').enable();
			p.getTopToolbar().findById('view-stafftooktraining').enable();
			p.getTopToolbar().findById('delete-stafftooktraining').enable();
		}
		else{
			p.getTopToolbar().findById('edit-stafftooktraining').disable();
			p.getTopToolbar().findById('view-stafftooktraining').disable();
			p.getTopToolbar().findById('delete-stafftooktraining').disable();
		}
	});
	center_panel.setActiveTab(p);
	
	store_stafftooktrainings.load({
		params: {
			start: 0,          
			limit: list_size
		}
	});
	
}
