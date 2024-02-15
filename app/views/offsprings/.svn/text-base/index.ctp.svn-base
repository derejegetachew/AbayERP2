
var store_offsprings = new Ext.data.GroupingStore({
	reader: new Ext.data.JsonReader({
		root:'rows',
		totalProperty: 'results',
		fields: [
			'id','first_name','last_name','sex','birth_date','employee','created','modified'		]
	}),
	proxy: new Ext.data.HttpProxy({
		url: '<?php echo $this->Html->url(array('controller' => 'offsprings', 'action' => 'list_data')); ?>'
	})
,	sortInfo:{field: 'first_name', direction: "ASC"},
	groupField: 'last_name'
});


function AddOffspring() {
	Ext.Ajax.request({
		url: '<?php echo $this->Html->url(array('controller' => 'offsprings', 'action' => 'add')); ?>',
		success: function(response, opts) {
			var offspring_data = response.responseText;
			
			eval(offspring_data);
			
			OffspringAddWindow.show();
		},
		failure: function(response, opts) {
			Ext.Msg.alert('<?php __('Error'); ?>', '<?php __('Cannot get the offspring add form. Error code'); ?>: ' + response.status);
		}
	});
}

function EditOffspring(id) {
	Ext.Ajax.request({
		url: '<?php echo $this->Html->url(array('controller' => 'offsprings', 'action' => 'edit')); ?>/'+id,
		success: function(response, opts) {
			var offspring_data = response.responseText;
			
			eval(offspring_data);
			
			OffspringEditWindow.show();
		},
		failure: function(response, opts) {
			Ext.Msg.alert('<?php __('Error'); ?>', '<?php __('Cannot get the offspring edit form. Error code'); ?>: ' + response.status);
		}
	});
}

function ViewOffspring(id) {
    Ext.Ajax.request({
        url: '<?php echo $this->Html->url(array('controller' => 'offsprings', 'action' => 'view')); ?>/'+id,
        success: function(response, opts) {
            var offspring_data = response.responseText;

            eval(offspring_data);

            OffspringViewWindow.show();
        },
        failure: function(response, opts) {
            Ext.Msg.alert('<?php __('Error'); ?>', '<?php __('Cannot get the offspring view form. Error code'); ?>: ' + response.status);
        }
    });
}

function DeleteOffspring(id) {
	Ext.Ajax.request({
		url: '<?php echo $this->Html->url(array('controller' => 'offsprings', 'action' => 'delete')); ?>/'+id,
		success: function(response, opts) {
			Ext.Msg.alert('<?php __('Success'); ?>', '<?php __('Offspring successfully deleted!'); ?>');
			RefreshOffspringData();
		},
		failure: function(response, opts) {
			Ext.Msg.alert('<?php __('Error'); ?>', '<?php __('Cannot get the offspring add form. Error code'); ?>: ' + response.status);
		}
	});
}

function SearchOffspring(){
	Ext.Ajax.request({
		url: '<?php echo $this->Html->url(array('controller' => 'offsprings', 'action' => 'search')); ?>',
		success: function(response, opts){
			var offspring_data = response.responseText;

			eval(offspring_data);

			offspringSearchWindow.show();
		},
		failure: function(response, opts) {
			Ext.Msg.alert('<?php __('Error'); ?>','<?php __('Cannot get the offspring search form. Error Code'); ?>: ' + response.status);
		}
	});
}

function SearchByOffspringName(value){
	var conditions = '\'Offspring.name LIKE\' => \'%' + value + '%\'';
	store_offsprings.reload({
		 params: {
			start: 0,
			limit: list_size,
			conditions: conditions
	    }
	});
}

function RefreshOffspringData() {
	store_offsprings.reload();
}


if(center_panel.find('id', 'offspring-tab') != "") {
	var p = center_panel.findById('offspring-tab');
	center_panel.setActiveTab(p);
} else {
	var p = center_panel.add({
		title: '<?php __('Offsprings'); ?>',
		closable: true,
		loadMask: true,
		stripeRows: true,
		id: 'offspring-tab',
		xtype: 'grid',
		store: store_offsprings,
		columns: [
			{header: "<?php __('First Name'); ?>", dataIndex: 'first_name', sortable: true},
			{header: "<?php __('Last Name'); ?>", dataIndex: 'last_name', sortable: true},
			{header: "<?php __('Sex'); ?>", dataIndex: 'sex', sortable: true},
			{header: "<?php __('Birth Date'); ?>", dataIndex: 'birth_date', sortable: true},
			{header: "<?php __('Employee'); ?>", dataIndex: 'employee', sortable: true},
			{header: "<?php __('Created'); ?>", dataIndex: 'created', sortable: true},
			{header: "<?php __('Modified'); ?>", dataIndex: 'modified', sortable: true}
		],
		
		view: new Ext.grid.GroupingView({
            forceFit:true,
            groupTextTpl: '{text} ({[values.rs.length]} {[values.rs.length > 1 ? "Offsprings" : "Offspring"]})'
        })
,
		listeners: {
			celldblclick: function(){
				ViewOffspring(Ext.getCmp('offspring-tab').getSelectionModel().getSelected().data.id);
			}
		},
		sm: new Ext.grid.RowSelectionModel({
			singleSelect: false
		}),
		tbar: new Ext.Toolbar({
			
			items: [{
					xtype: 'tbbutton',
					text: '<?php __('Add'); ?>',
					tooltip:'<?php __('<b>Add Offsprings</b><br />Click here to create a new Offspring'); ?>',
					icon: 'img/table_add.png',
					cls: 'x-btn-text-icon',
					handler: function(btn) {
						AddOffspring();
					}
				}, ' ', '-', ' ', {
					xtype: 'tbbutton',
					text: '<?php __('Edit'); ?>',
					id: 'edit-offspring',
					tooltip:'<?php __('<b>Edit Offsprings</b><br />Click here to modify the selected Offspring'); ?>',
					icon: 'img/table_edit.png',
					cls: 'x-btn-text-icon',
					disabled: true,
					handler: function(btn) {
						var sm = p.getSelectionModel();
						var sel = sm.getSelected();
						if (sm.hasSelection()){
							EditOffspring(sel.data.id);
						};
					}
				}, ' ', '-', ' ', {
					xtype: 'tbbutton',
					text: '<?php __('Delete'); ?>',
					id: 'delete-offspring',
					tooltip:'<?php __('<b>Delete Offsprings(s)</b><br />Click here to remove the selected Offspring(s)'); ?>',
					icon: 'img/table_delete.png',
					cls: 'x-btn-text-icon',
					disabled: true,
					handler: function(btn) {
						var sm = p.getSelectionModel();
						var sel = sm.getSelections();
						if (sm.hasSelection()){
							if(sel.length==1){
								Ext.Msg.show({
									title: '<?php __('Remove Offspring'); ?>',
									buttons: Ext.MessageBox.YESNO,
									msg: '<?php __('Remove'); ?> '+sel[0].data.name+'?',
									icon: Ext.MessageBox.QUESTION,
									fn: function(btn){
										if (btn == 'yes'){
											DeleteOffspring(sel[0].data.id);
										}
									}
								});
							}else{
								Ext.Msg.show({
									title: '<?php __('Remove Offspring'); ?>',
									buttons: Ext.MessageBox.YESNO,
									msg: '<?php __('Remove the selected Offsprings'); ?>?',
									icon: Ext.MessageBox.QUESTION,
									fn: function(btn){
										if (btn == 'yes'){
											var sel_ids = '';
											for(i=0;i<sel.length;i++){
												if(i>0)
													sel_ids += '_';
												sel_ids += sel[i].data.id;
											}
											DeleteOffspring(sel_ids);
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
					text: '<?php __('View Offspring'); ?>',
					id: 'view-offspring',
					tooltip:'<?php __('<b>View Offspring</b><br />Click here to see details of the selected Offspring'); ?>',
					icon: 'img/table_view.png',
					cls: 'x-btn-text-icon',
					disabled: true,
					handler: function(btn) {
						var sm = p.getSelectionModel();
						var sel = sm.getSelected();
						if (sm.hasSelection()){
							ViewOffspring(sel.data.id);
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
							store_offsprings.reload({
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
					id: 'offspring_search_field',
					listeners: {
						specialkey: function(field, e){
							if (e.getKey() == e.ENTER) {
								SearchByOffspringName(Ext.getCmp('offspring_search_field').getValue());
							}
						}
					}
				}, {
					xtype: 'tbbutton',
					icon: 'img/search.png',
					cls: 'x-btn-text-icon',
					text: '<?php __('GO'); ?>',
                    tooltip:'<?php __('<b>GO</b><br />Click here to get search results'); ?>',
					id: 'offspring_go_button',
					handler: function(){
						SearchByOffspringName(Ext.getCmp('offspring_search_field').getValue());
					}
				}, '-', {
					xtype: 'tbbutton',
					icon: 'img/table_search.png',
					cls: 'x-btn-text-icon',
					text: '<?php __('Advanced Search'); ?>',
                    tooltip:'<?php __('<b>Advanced Search...</b><br />Click here to get the advanced search form'); ?>',
					handler: function(){
						SearchOffspring();
					}
				}
		]}),
		bbar: new Ext.PagingToolbar({
			pageSize: list_size,
			store: store_offsprings,
			displayInfo: true,
			displayMsg: '<?php __('Displaying {0} - {1} of {2}'); ?>',
			beforePageText: '<?php __('Page'); ?>',
			afterPageText: '<?php __('of {0}'); ?>',
			emptyMsg: '<?php __('No data to display'); ?>'
		})
	});
	p.getSelectionModel().on('rowselect', function(sm, rowIdx, r) {
		p.getTopToolbar().findById('edit-offspring').enable();
		p.getTopToolbar().findById('delete-offspring').enable();
		p.getTopToolbar().findById('view-offspring').enable();
		if(this.getSelections().length > 1){
			p.getTopToolbar().findById('edit-offspring').disable();
			p.getTopToolbar().findById('view-offspring').disable();
		}
	});
	p.getSelectionModel().on('rowdeselect', function(sm, rowIdx, r) {
		if(this.getSelections().length > 1){
			p.getTopToolbar().findById('edit-offspring').disable();
			p.getTopToolbar().findById('view-offspring').disable();
			p.getTopToolbar().findById('delete-offspring').enable();
		}
		else if(this.getSelections().length == 1){
			p.getTopToolbar().findById('edit-offspring').enable();
			p.getTopToolbar().findById('view-offspring').enable();
			p.getTopToolbar().findById('delete-offspring').enable();
		}
		else{
			p.getTopToolbar().findById('edit-offspring').disable();
			p.getTopToolbar().findById('view-offspring').disable();
			p.getTopToolbar().findById('delete-offspring').disable();
		}
	});
	center_panel.setActiveTab(p);
	
	store_offsprings.load({
		params: {
			start: 0,          
			limit: list_size
		}
	});
	
}
