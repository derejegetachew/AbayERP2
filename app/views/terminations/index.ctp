
var store_terminations = new Ext.data.GroupingStore({
	reader: new Ext.data.JsonReader({
		root:'rows',
		totalProperty: 'results',
		fields: [
			'id','employee','reason','date','note'		]
	}),
	proxy: new Ext.data.HttpProxy({
		url: '<?php echo $this->Html->url(array('controller' => 'terminations', 'action' => 'list_data')); ?>'
	})
,	sortInfo:{field: 'employee_id', direction: "ASC"},
	groupField: 'reason'
});


function AddTermination() {
	Ext.Ajax.request({
		url: '<?php echo $this->Html->url(array('controller' => 'terminations', 'action' => 'add')); ?>',
		success: function(response, opts) {
			var termination_data = response.responseText;
			
			eval(termination_data);
			
			TerminationAddWindow.show();
		},
		failure: function(response, opts) {
			Ext.Msg.alert('<?php __('Error'); ?>', '<?php __('Cannot get the termination add form. Error code'); ?>: ' + response.status);
		}
	});
}

function EditTermination(id) {
	Ext.Ajax.request({
		url: '<?php echo $this->Html->url(array('controller' => 'terminations', 'action' => 'edit')); ?>/'+id,
		success: function(response, opts) {
			var termination_data = response.responseText;
			
			eval(termination_data);
			
			TerminationEditWindow.show();
		},
		failure: function(response, opts) {
			Ext.Msg.alert('<?php __('Error'); ?>', '<?php __('Cannot get the termination edit form. Error code'); ?>: ' + response.status);
		}
	});
}

function ViewTermination(id) {
    Ext.Ajax.request({
        url: '<?php echo $this->Html->url(array('controller' => 'terminations', 'action' => 'view')); ?>/'+id,
        success: function(response, opts) {
            var termination_data = response.responseText;

            eval(termination_data);

            TerminationViewWindow.show();
        },
        failure: function(response, opts) {
            Ext.Msg.alert('<?php __('Error'); ?>', '<?php __('Cannot get the termination view form. Error code'); ?>: ' + response.status);
        }
    });
}

function DeleteTermination(id) {
	Ext.Ajax.request({
		url: '<?php echo $this->Html->url(array('controller' => 'terminations', 'action' => 'delete')); ?>/'+id,
		success: function(response, opts) {
			Ext.Msg.alert('<?php __('Success'); ?>', '<?php __('Termination successfully deleted!'); ?>');
			RefreshTerminationData();
		},
		failure: function(response, opts) {
			Ext.Msg.alert('<?php __('Error'); ?>', '<?php __('Cannot get the termination add form. Error code'); ?>: ' + response.status);
		}
	});
}

function SearchTermination(){
	Ext.Ajax.request({
		url: '<?php echo $this->Html->url(array('controller' => 'terminations', 'action' => 'search')); ?>',
		success: function(response, opts){
			var termination_data = response.responseText;

			eval(termination_data);

			terminationSearchWindow.show();
		},
		failure: function(response, opts) {
			Ext.Msg.alert('<?php __('Error'); ?>','<?php __('Cannot get the termination search form. Error Code'); ?>: ' + response.status);
		}
	});
}

function SearchByTerminationName(value){
	var conditions = '\'Termination.name LIKE\' => \'%' + value + '%\'';
	store_terminations.reload({
		 params: {
			start: 0,
			limit: list_size,
			conditions: conditions
	    }
	});
}

function RefreshTerminationData() {
	store_terminations.reload();
}


if(center_panel.find('id', 'termination-tab') != "") {
	var p = center_panel.findById('termination-tab');
	center_panel.setActiveTab(p);
} else {
	var p = center_panel.add({
		title: '<?php __('Terminations'); ?>',
		closable: true,
		loadMask: true,
		stripeRows: true,
		id: 'termination-tab',
		xtype: 'grid',
		store: store_terminations,
		columns: [
			{header: "<?php __('Employee'); ?>", dataIndex: 'employee', sortable: true},
			{header: "<?php __('Reason'); ?>", dataIndex: 'reason', sortable: true},
			{header: "<?php __('Date'); ?>", dataIndex: 'date', sortable: true},
			{header: "<?php __('Note'); ?>", dataIndex: 'note', sortable: true}
		],
		
		view: new Ext.grid.GroupingView({
            forceFit:true,
            groupTextTpl: '{text} ({[values.rs.length]} {[values.rs.length > 1 ? "Terminations" : "Termination"]})'
        })
,
		listeners: {
			celldblclick: function(){
				ViewTermination(Ext.getCmp('termination-tab').getSelectionModel().getSelected().data.id);
			}
		},
		sm: new Ext.grid.RowSelectionModel({
			singleSelect: false
		}),
		tbar: new Ext.Toolbar({
			
			items: [{
					xtype: 'tbbutton',
					text: '<?php __('Add'); ?>',
					tooltip:'<?php __('<b>Add Terminations</b><br />Click here to create a new Termination'); ?>',
					icon: 'img/table_add.png',
					cls: 'x-btn-text-icon',
					handler: function(btn) {
						AddTermination();
					}
				}, ' ', '-', ' ', {
					xtype: 'tbbutton',
					text: '<?php __('Edit'); ?>',
					id: 'edit-termination',
					tooltip:'<?php __('<b>Edit Terminations</b><br />Click here to modify the selected Termination'); ?>',
					icon: 'img/table_edit.png',
					cls: 'x-btn-text-icon',
					disabled: true,
					handler: function(btn) {
						var sm = p.getSelectionModel();
						var sel = sm.getSelected();
						if (sm.hasSelection()){
							EditTermination(sel.data.id);
						};
					}
				}, ' ', '-', ' ', {
					xtype: 'tbbutton',
					text: '<?php __('Delete'); ?>',
					id: 'delete-termination',
					tooltip:'<?php __('<b>Delete Terminations(s)</b><br />Click here to remove the selected Termination(s)'); ?>',
					icon: 'img/table_delete.png',
					cls: 'x-btn-text-icon',
					disabled: true,
					handler: function(btn) {
						var sm = p.getSelectionModel();
						var sel = sm.getSelections();
						if (sm.hasSelection()){
							if(sel.length==1){
								Ext.Msg.show({
									title: '<?php __('Remove Termination'); ?>',
									buttons: Ext.MessageBox.YESNO,
									msg: '<?php __('Remove'); ?> '+sel[0].data.name+'?',
									icon: Ext.MessageBox.QUESTION,
									fn: function(btn){
										if (btn == 'yes'){
											DeleteTermination(sel[0].data.id);
										}
									}
								});
							}else{
								Ext.Msg.show({
									title: '<?php __('Remove Termination'); ?>',
									buttons: Ext.MessageBox.YESNO,
									msg: '<?php __('Remove the selected Terminations'); ?>?',
									icon: Ext.MessageBox.QUESTION,
									fn: function(btn){
										if (btn == 'yes'){
											var sel_ids = '';
											for(i=0;i<sel.length;i++){
												if(i>0)
													sel_ids += '_';
												sel_ids += sel[i].data.id;
											}
											DeleteTermination(sel_ids);
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
					text: '<?php __('View Termination'); ?>',
					id: 'view-termination',
					tooltip:'<?php __('<b>View Termination</b><br />Click here to see details of the selected Termination'); ?>',
					icon: 'img/table_view.png',
					cls: 'x-btn-text-icon',
					disabled: true,
					handler: function(btn) {
						var sm = p.getSelectionModel();
						var sel = sm.getSelected();
						if (sm.hasSelection()){
							ViewTermination(sel.data.id);
						};
					},
					menu : {
						items: [
						]
					}
				}, ' ', '-',  '<?php __('Employee'); ?>: ', {
					xtype : 'combo',
					emptyText: 'All',
					store : new Ext.data.ArrayStore({
						fields : ['id', 'name'],
						data : [
							['-1', 'All'],
							<?php $st = false;foreach ($employees as $item){if($st) echo ",
							";?>['<?php echo $item['Employee']['id']; ?>' ,'<?php echo $item['Employee']['name']; ?>']<?php $st = true;}?>						]
					}),
					displayField : 'name',
					valueField : 'id',
					mode : 'local',
					value : '-1',
					disableKeyFilter : true,
					triggerAction: 'all',
					listeners : {
						select : function(combo, record, index){
							store_terminations.reload({
								params: {
									start: 0,
									limit: list_size,
									employee_id : combo.getValue()
								}
							});
						}
					}
				},
 '->', {
					xtype: 'textfield',
					emptyText: '<?php __('[Search By Name]'); ?>',
					id: 'termination_search_field',
					listeners: {
						specialkey: function(field, e){
							if (e.getKey() == e.ENTER) {
								SearchByTerminationName(Ext.getCmp('termination_search_field').getValue());
							}
						}
					}
				}, {
					xtype: 'tbbutton',
					icon: 'img/search.png',
					cls: 'x-btn-text-icon',
					text: '<?php __('GO'); ?>',
                    tooltip:'<?php __('<b>GO</b><br />Click here to get search results'); ?>',
					id: 'termination_go_button',
					handler: function(){
						SearchByTerminationName(Ext.getCmp('termination_search_field').getValue());
					}
				}, '-', {
					xtype: 'tbbutton',
					icon: 'img/table_search.png',
					cls: 'x-btn-text-icon',
					text: '<?php __('Advanced Search'); ?>',
                    tooltip:'<?php __('<b>Advanced Search...</b><br />Click here to get the advanced search form'); ?>',
					handler: function(){
						SearchTermination();
					}
				}
		]}),
		bbar: new Ext.PagingToolbar({
			pageSize: list_size,
			store: store_terminations,
			displayInfo: true,
			displayMsg: '<?php __('Displaying {0} - {1} of {2}'); ?>',
			beforePageText: '<?php __('Page'); ?>',
			afterPageText: '<?php __('of {0}'); ?>',
			emptyMsg: '<?php __('No data to display'); ?>'
		})
	});
	p.getSelectionModel().on('rowselect', function(sm, rowIdx, r) {
		p.getTopToolbar().findById('edit-termination').enable();
		p.getTopToolbar().findById('delete-termination').enable();
		p.getTopToolbar().findById('view-termination').enable();
		if(this.getSelections().length > 1){
			p.getTopToolbar().findById('edit-termination').disable();
			p.getTopToolbar().findById('view-termination').disable();
		}
	});
	p.getSelectionModel().on('rowdeselect', function(sm, rowIdx, r) {
		if(this.getSelections().length > 1){
			p.getTopToolbar().findById('edit-termination').disable();
			p.getTopToolbar().findById('view-termination').disable();
			p.getTopToolbar().findById('delete-termination').enable();
		}
		else if(this.getSelections().length == 1){
			p.getTopToolbar().findById('edit-termination').enable();
			p.getTopToolbar().findById('view-termination').enable();
			p.getTopToolbar().findById('delete-termination').enable();
		}
		else{
			p.getTopToolbar().findById('edit-termination').disable();
			p.getTopToolbar().findById('view-termination').disable();
			p.getTopToolbar().findById('delete-termination').disable();
		}
	});
	center_panel.setActiveTab(p);
	
	store_terminations.load({
		params: {
			start: 0,          
			limit: list_size
		}
	});
	
}
