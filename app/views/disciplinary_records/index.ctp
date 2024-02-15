
var store_disciplinaryRecords = new Ext.data.GroupingStore({
	reader: new Ext.data.JsonReader({
		root:'rows',
		totalProperty: 'results',
		fields: [
			'id','employee','type','start','end','remark','created','modified'		]
	}),
	proxy: new Ext.data.HttpProxy({
		url: '<?php echo $this->Html->url(array('controller' => 'disciplinaryRecords', 'action' => 'list_data')); ?>'
	})
,	sortInfo:{field: 'employee_id', direction: "ASC"},
	groupField: 'type'
});


function AddDisciplinaryRecord() {
	Ext.Ajax.request({
		url: '<?php echo $this->Html->url(array('controller' => 'disciplinaryRecords', 'action' => 'add')); ?>',
		success: function(response, opts) {
			var disciplinaryRecord_data = response.responseText;
			
			eval(disciplinaryRecord_data);
			
			DisciplinaryRecordAddWindow.show();
		},
		failure: function(response, opts) {
			Ext.Msg.alert('<?php __('Error'); ?>', '<?php __('Cannot get the disciplinaryRecord add form. Error code'); ?>: ' + response.status);
		}
	});
}

function EditDisciplinaryRecord(id) {
	Ext.Ajax.request({
		url: '<?php echo $this->Html->url(array('controller' => 'disciplinaryRecords', 'action' => 'edit')); ?>/'+id,
		success: function(response, opts) {
			var disciplinaryRecord_data = response.responseText;
			
			eval(disciplinaryRecord_data);
			
			DisciplinaryRecordEditWindow.show();
		},
		failure: function(response, opts) {
			Ext.Msg.alert('<?php __('Error'); ?>', '<?php __('Cannot get the disciplinaryRecord edit form. Error code'); ?>: ' + response.status);
		}
	});
}

function ViewDisciplinaryRecord(id) {
    Ext.Ajax.request({
        url: '<?php echo $this->Html->url(array('controller' => 'disciplinaryRecords', 'action' => 'view')); ?>/'+id,
        success: function(response, opts) {
            var disciplinaryRecord_data = response.responseText;

            eval(disciplinaryRecord_data);

            DisciplinaryRecordViewWindow.show();
        },
        failure: function(response, opts) {
            Ext.Msg.alert('<?php __('Error'); ?>', '<?php __('Cannot get the disciplinaryRecord view form. Error code'); ?>: ' + response.status);
        }
    });
}

function DeleteDisciplinaryRecord(id) {
	Ext.Ajax.request({
		url: '<?php echo $this->Html->url(array('controller' => 'disciplinaryRecords', 'action' => 'delete')); ?>/'+id,
		success: function(response, opts) {
			Ext.Msg.alert('<?php __('Success'); ?>', '<?php __('DisciplinaryRecord successfully deleted!'); ?>');
			RefreshDisciplinaryRecordData();
		},
		failure: function(response, opts) {
			Ext.Msg.alert('<?php __('Error'); ?>', '<?php __('Cannot get the disciplinaryRecord add form. Error code'); ?>: ' + response.status);
		}
	});
}

function SearchDisciplinaryRecord(){
	Ext.Ajax.request({
		url: '<?php echo $this->Html->url(array('controller' => 'disciplinaryRecords', 'action' => 'search')); ?>',
		success: function(response, opts){
			var disciplinaryRecord_data = response.responseText;

			eval(disciplinaryRecord_data);

			disciplinaryRecordSearchWindow.show();
		},
		failure: function(response, opts) {
			Ext.Msg.alert('<?php __('Error'); ?>','<?php __('Cannot get the disciplinaryRecord search form. Error Code'); ?>: ' + response.status);
		}
	});
}

function SearchByDisciplinaryRecordName(value){
	var conditions = '\'DisciplinaryRecord.name LIKE\' => \'%' + value + '%\'';
	store_disciplinaryRecords.reload({
		 params: {
			start: 0,
			limit: list_size,
			conditions: conditions
	    }
	});
}

function RefreshDisciplinaryRecordData() {
	store_disciplinaryRecords.reload();
}


if(center_panel.find('id', 'disciplinaryRecord-tab') != "") {
	var p = center_panel.findById('disciplinaryRecord-tab');
	center_panel.setActiveTab(p);
} else {
	var p = center_panel.add({
		title: '<?php __('Disciplinary Records'); ?>',
		closable: true,
		loadMask: true,
		stripeRows: true,
		id: 'disciplinaryRecord-tab',
		xtype: 'grid',
		store: store_disciplinaryRecords,
		columns: [
			{header: "<?php __('Employee'); ?>", dataIndex: 'employee', sortable: true},
			{header: "<?php __('Type'); ?>", dataIndex: 'type', sortable: true},
			{header: "<?php __('Start'); ?>", dataIndex: 'start', sortable: true},
			{header: "<?php __('End'); ?>", dataIndex: 'end', sortable: true},
			{header: "<?php __('Remark'); ?>", dataIndex: 'remark', sortable: true},
			{header: "<?php __('Created'); ?>", dataIndex: 'created', sortable: true},
			{header: "<?php __('Modified'); ?>", dataIndex: 'modified', sortable: true}
		],
		
		view: new Ext.grid.GroupingView({
            forceFit:true,
            groupTextTpl: '{text} ({[values.rs.length]} {[values.rs.length > 1 ? "DisciplinaryRecords" : "DisciplinaryRecord"]})'
        })
,
		listeners: {
			celldblclick: function(){
				ViewDisciplinaryRecord(Ext.getCmp('disciplinaryRecord-tab').getSelectionModel().getSelected().data.id);
			}
		},
		sm: new Ext.grid.RowSelectionModel({
			singleSelect: false
		}),
		tbar: new Ext.Toolbar({
			
			items: [{
					xtype: 'tbbutton',
					text: '<?php __('Add'); ?>',
					tooltip:'<?php __('<b>Add DisciplinaryRecords</b><br />Click here to create a new DisciplinaryRecord'); ?>',
					icon: 'img/table_add.png',
					cls: 'x-btn-text-icon',
					handler: function(btn) {
						AddDisciplinaryRecord();
					}
				}, ' ', '-', ' ', {
					xtype: 'tbbutton',
					text: '<?php __('Edit'); ?>',
					id: 'edit-disciplinaryRecord',
					tooltip:'<?php __('<b>Edit DisciplinaryRecords</b><br />Click here to modify the selected DisciplinaryRecord'); ?>',
					icon: 'img/table_edit.png',
					cls: 'x-btn-text-icon',
					disabled: true,
					handler: function(btn) {
						var sm = p.getSelectionModel();
						var sel = sm.getSelected();
						if (sm.hasSelection()){
							EditDisciplinaryRecord(sel.data.id);
						};
					}
				}, ' ', '-', ' ', {
					xtype: 'tbbutton',
					text: '<?php __('Delete'); ?>',
					id: 'delete-disciplinaryRecord',
					tooltip:'<?php __('<b>Delete DisciplinaryRecords(s)</b><br />Click here to remove the selected DisciplinaryRecord(s)'); ?>',
					icon: 'img/table_delete.png',
					cls: 'x-btn-text-icon',
					disabled: true,
					handler: function(btn) {
						var sm = p.getSelectionModel();
						var sel = sm.getSelections();
						if (sm.hasSelection()){
							if(sel.length==1){
								Ext.Msg.show({
									title: '<?php __('Remove DisciplinaryRecord'); ?>',
									buttons: Ext.MessageBox.YESNO,
									msg: '<?php __('Remove'); ?> '+sel[0].data.name+'?',
									icon: Ext.MessageBox.QUESTION,
									fn: function(btn){
										if (btn == 'yes'){
											DeleteDisciplinaryRecord(sel[0].data.id);
										}
									}
								});
							}else{
								Ext.Msg.show({
									title: '<?php __('Remove DisciplinaryRecord'); ?>',
									buttons: Ext.MessageBox.YESNO,
									msg: '<?php __('Remove the selected DisciplinaryRecords'); ?>?',
									icon: Ext.MessageBox.QUESTION,
									fn: function(btn){
										if (btn == 'yes'){
											var sel_ids = '';
											for(i=0;i<sel.length;i++){
												if(i>0)
													sel_ids += '_';
												sel_ids += sel[i].data.id;
											}
											DeleteDisciplinaryRecord(sel_ids);
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
					text: '<?php __('View DisciplinaryRecord'); ?>',
					id: 'view-disciplinaryRecord',
					tooltip:'<?php __('<b>View DisciplinaryRecord</b><br />Click here to see details of the selected DisciplinaryRecord'); ?>',
					icon: 'img/table_view.png',
					cls: 'x-btn-text-icon',
					disabled: true,
					handler: function(btn) {
						var sm = p.getSelectionModel();
						var sel = sm.getSelected();
						if (sm.hasSelection()){
							ViewDisciplinaryRecord(sel.data.id);
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
							store_disciplinaryRecords.reload({
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
					id: 'disciplinaryRecord_search_field',
					listeners: {
						specialkey: function(field, e){
							if (e.getKey() == e.ENTER) {
								SearchByDisciplinaryRecordName(Ext.getCmp('disciplinaryRecord_search_field').getValue());
							}
						}
					}
				}, {
					xtype: 'tbbutton',
					icon: 'img/search.png',
					cls: 'x-btn-text-icon',
					text: '<?php __('GO'); ?>',
                    tooltip:'<?php __('<b>GO</b><br />Click here to get search results'); ?>',
					id: 'disciplinaryRecord_go_button',
					handler: function(){
						SearchByDisciplinaryRecordName(Ext.getCmp('disciplinaryRecord_search_field').getValue());
					}
				}, '-', {
					xtype: 'tbbutton',
					icon: 'img/table_search.png',
					cls: 'x-btn-text-icon',
					text: '<?php __('Advanced Search'); ?>',
                    tooltip:'<?php __('<b>Advanced Search...</b><br />Click here to get the advanced search form'); ?>',
					handler: function(){
						SearchDisciplinaryRecord();
					}
				}
		]}),
		bbar: new Ext.PagingToolbar({
			pageSize: list_size,
			store: store_disciplinaryRecords,
			displayInfo: true,
			displayMsg: '<?php __('Displaying {0} - {1} of {2}'); ?>',
			beforePageText: '<?php __('Page'); ?>',
			afterPageText: '<?php __('of {0}'); ?>',
			emptyMsg: '<?php __('No data to display'); ?>'
		})
	});
	p.getSelectionModel().on('rowselect', function(sm, rowIdx, r) {
		p.getTopToolbar().findById('edit-disciplinaryRecord').enable();
		p.getTopToolbar().findById('delete-disciplinaryRecord').enable();
		p.getTopToolbar().findById('view-disciplinaryRecord').enable();
		if(this.getSelections().length > 1){
			p.getTopToolbar().findById('edit-disciplinaryRecord').disable();
			p.getTopToolbar().findById('view-disciplinaryRecord').disable();
		}
	});
	p.getSelectionModel().on('rowdeselect', function(sm, rowIdx, r) {
		if(this.getSelections().length > 1){
			p.getTopToolbar().findById('edit-disciplinaryRecord').disable();
			p.getTopToolbar().findById('view-disciplinaryRecord').disable();
			p.getTopToolbar().findById('delete-disciplinaryRecord').enable();
		}
		else if(this.getSelections().length == 1){
			p.getTopToolbar().findById('edit-disciplinaryRecord').enable();
			p.getTopToolbar().findById('view-disciplinaryRecord').enable();
			p.getTopToolbar().findById('delete-disciplinaryRecord').enable();
		}
		else{
			p.getTopToolbar().findById('edit-disciplinaryRecord').disable();
			p.getTopToolbar().findById('view-disciplinaryRecord').disable();
			p.getTopToolbar().findById('delete-disciplinaryRecord').disable();
		}
	});
	center_panel.setActiveTab(p);
	
	store_disciplinaryRecords.load({
		params: {
			start: 0,          
			limit: list_size
		}
	});
	
}
