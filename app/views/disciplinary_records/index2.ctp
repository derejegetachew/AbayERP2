var store_parent_disciplinaryRecords = new Ext.data.Store({
	reader: new Ext.data.JsonReader({
		root:'rows',
		totalProperty: 'results',
		fields: [
			'id','employee','type','start','end','remark','created','modified'	
		]
	}),
	proxy: new Ext.data.HttpProxy({
		url: '<?php echo $this->Html->url(array('controller' => 'disciplinaryRecords', 'action' => 'list_data', $parent_id)); ?>'	})
});


function AddParentDisciplinaryRecord() {
	Ext.Ajax.request({
		url: '<?php echo $this->Html->url(array('controller' => 'disciplinaryRecords', 'action' => 'add', $parent_id)); ?>',
		success: function(response, opts) {
			var parent_disciplinaryRecord_data = response.responseText;
			
			eval(parent_disciplinaryRecord_data);
			
			DisciplinaryRecordAddWindow.show();
		},
		failure: function(response, opts) {
			Ext.Msg.alert('<?php __('Error'); ?>', '<?php __('Cannot get the disciplinaryRecord add form. Error code'); ?>: ' + response.status);
		}
	});
}

function EditParentDisciplinaryRecord(id) {
	Ext.Ajax.request({
		url: '<?php echo $this->Html->url(array('controller' => 'disciplinaryRecords', 'action' => 'edit')); ?>/'+id+'/<?php echo $parent_id; ?>',
		success: function(response, opts) {
			var parent_disciplinaryRecord_data = response.responseText;
			
			eval(parent_disciplinaryRecord_data);
			
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


function DeleteParentDisciplinaryRecord(id) {
	Ext.Ajax.request({
		url: '<?php echo $this->Html->url(array('controller' => 'disciplinaryRecords', 'action' => 'delete')); ?>/'+id,
		success: function(response, opts) {
			Ext.Msg.alert('<?php __('Success'); ?>', '<?php __('DisciplinaryRecord(s) successfully deleted!'); ?>');
			RefreshParentDisciplinaryRecordData();
		},
		failure: function(response, opts) {
			Ext.Msg.alert('<?php __('Error'); ?>', '<?php __('Cannot get the disciplinaryRecord to be deleted. Error code'); ?>: ' + response.status);
		}
	});
}

function SearchByParentDisciplinaryRecordName(value){
	var conditions = '\'DisciplinaryRecord.name LIKE\' => \'%' + value + '%\'';
	store_parent_disciplinaryRecords.reload({
		 params: {
			start: 0,
			limit: list_size,
			conditions: conditions
	    }
	});
}

function RefreshParentDisciplinaryRecordData() {
	store_parent_disciplinaryRecords.reload();
}



var g = new Ext.grid.GridPanel({
	title: '<?php __('DisciplinaryRecords'); ?>',
	store: store_parent_disciplinaryRecords,
	loadMask: true,
	stripeRows: true,
	height: 300,
	anchor: '100%',
    id: 'disciplinaryRecordGrid',
	columns: [
		{header: "<?php __('Type'); ?>", dataIndex: 'type', sortable: true},
		{header: "<?php __('Start'); ?>", dataIndex: 'start', sortable: true},
		{header: "<?php __('End'); ?>", dataIndex: 'end', sortable: true},
		{header: "<?php __('Remark'); ?>", dataIndex: 'remark', sortable: true}	],
	sm: new Ext.grid.RowSelectionModel({
		singleSelect: false
	}),
	viewConfig: {
		forceFit: true
	},
    listeners: {
        celldblclick: function(){
            ViewDisciplinaryRecord(Ext.getCmp('disciplinaryRecordGrid').getSelectionModel().getSelected().data.id);
        }
    },
	tbar: new Ext.Toolbar({
		items: [{
				xtype: 'tbbutton',
				text: '<?php __('Add'); ?>',
				tooltip:'<?php __('<b>Add DisciplinaryRecord</b><br />Click here to create a new DisciplinaryRecord'); ?>',
				icon: 'img/table_add.png',
				cls: 'x-btn-text-icon',
				handler: function(btn) {
					AddParentDisciplinaryRecord();
				}
			}, ' ', '-', ' ', {
				xtype: 'tbbutton',
				text: '<?php __('Edit'); ?>',
				id: 'edit-parent-disciplinaryRecord',
				tooltip:'<?php __('<b>Edit DisciplinaryRecord</b><br />Click here to modify the selected DisciplinaryRecord'); ?>',
				icon: 'img/table_edit.png',
				cls: 'x-btn-text-icon',
				disabled: true,
				handler: function(btn) {
					var sm = g.getSelectionModel();
					var sel = sm.getSelected();
					if (sm.hasSelection()){
						EditParentDisciplinaryRecord(sel.data.id);
					};
				}
			}, ' ', '-', ' ', {
				xtype: 'tbbutton',
				text: '<?php __('Delete'); ?>',
				id: 'delete-parent-disciplinaryRecord',
				tooltip:'<?php __('<b>Delete DisciplinaryRecord(s)</b><br />Click here to remove the selected DisciplinaryRecord(s)'); ?>',
				icon: 'img/table_delete.png',
				cls: 'x-btn-text-icon',
				disabled: true,
				handler: function(btn) {
					var sm = g.getSelectionModel();
					var sel = sm.getSelections();
					if (sm.hasSelection()){
						if(sel.length==1){
							Ext.Msg.show({
									title: '<?php __('Remove DisciplinaryRecord'); ?>',
									buttons: Ext.MessageBox.YESNOCANCEL,
									msg: '<?php __('Remove'); ?> '+sel[0].data.name+'?',
									icon: Ext.MessageBox.QUESTION,
                                    fn: function(btn){
											if (btn == 'yes'){
													DeleteParentDisciplinaryRecord(sel[0].data.id);
											}
									}
							});
						} else {
							Ext.Msg.show({
									title: '<?php __('Remove DisciplinaryRecord'); ?>',
									buttons: Ext.MessageBox.YESNOCANCEL,
									msg: '<?php __('Remove the selected DisciplinaryRecord'); ?>?',
									icon: Ext.MessageBox.QUESTION,
                                    fn: function(btn){
											if (btn == 'yes'){
													var sel_ids = '';
													for(i=0;i<sel.length;i++){
														if(i>0)
															sel_ids += '_';
														sel_ids += sel[i].data.id;
													}
													DeleteParentDisciplinaryRecord(sel_ids);
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
				text: '<?php __('View DisciplinaryRecord'); ?>',
				id: 'view-disciplinaryRecord2',
				tooltip:'<?php __('<b>View DisciplinaryRecord</b><br />Click here to see details of the selected DisciplinaryRecord'); ?>',
				icon: 'img/table_view.png',
				cls: 'x-btn-text-icon',
				disabled: true,
				handler: function(btn) {
					var sm = g.getSelectionModel();
					var sel = sm.getSelected();
					if (sm.hasSelection()){
						ViewDisciplinaryRecord(sel.data.id);
					};
				},
				menu : {
					items: [
					]
				}

            }, ' ', '->', {
				xtype: 'textfield',
				emptyText: '<?php __('[Search By Name]'); ?>',
				id: 'parent_disciplinaryRecord_search_field',
				listeners: {
					specialkey: function(field, e){
						if (e.getKey() == e.ENTER) {
							SearchByParentDisciplinaryRecordName(Ext.getCmp('parent_disciplinaryRecord_search_field').getValue());
						}
					}

				}
			}, {
				xtype: 'tbbutton',
				icon: 'img/search.png',
				cls: 'x-btn-text-icon',
				text: 'GO',
				tooltip:'<?php __('<b>GO</b><br />Click here to get search results'); ?>',
				id: 'parent_disciplinaryRecord_go_button',
				handler: function(){
					SearchByParentDisciplinaryRecordName(Ext.getCmp('parent_disciplinaryRecord_search_field').getValue());
				}
			}, ' '
	]}),
	bbar: new Ext.PagingToolbar({
		pageSize: list_size,
		store: store_parent_disciplinaryRecords,
		displayInfo: true,
		displayMsg: '<?php __('Displaying {0} - {1} of {2}'); ?>',
		beforePageText: '<?php __('Page'); ?>',
		afterPageText: '<?php __('of {0}'); ?>',
		emptyMsg: '<?php __('No data to display'); ?>'
	})
});
g.getSelectionModel().on('rowselect', function(sm, rowIdx, r) {
	g.getTopToolbar().findById('edit-parent-disciplinaryRecord').enable();
	g.getTopToolbar().findById('delete-parent-disciplinaryRecord').enable();
        g.getTopToolbar().findById('view-disciplinaryRecord2').enable();
	if(this.getSelections().length > 1){
		g.getTopToolbar().findById('edit-parent-disciplinaryRecord').disable();
                g.getTopToolbar().findById('view-disciplinaryRecord2').disable();
	}
});
g.getSelectionModel().on('rowdeselect', function(sm, rowIdx, r) {
	if(this.getSelections().length > 1){
		g.getTopToolbar().findById('edit-parent-disciplinaryRecord').disable();
		g.getTopToolbar().findById('delete-parent-disciplinaryRecord').enable();
                g.getTopToolbar().findById('view-disciplinaryRecord2').disable();
	}
	else if(this.getSelections().length == 1){
		g.getTopToolbar().findById('edit-parent-disciplinaryRecord').enable();
		g.getTopToolbar().findById('delete-parent-disciplinaryRecord').enable();
                g.getTopToolbar().findById('view-disciplinaryRecord2').enable();
	}
	else{
		g.getTopToolbar().findById('edit-parent-disciplinaryRecord').disable();
		g.getTopToolbar().findById('delete-parent-disciplinaryRecord').disable();
                g.getTopToolbar().findById('view-disciplinaryRecord2').disable();
	}
});



var parentDisciplinaryRecordsViewWindow = new Ext.Window({
	title: 'DisciplinaryRecord Under the selected Item',
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
			parentDisciplinaryRecordsViewWindow.close();
		}
	}]
});

store_parent_disciplinaryRecords.load({
    params: {
        start: 0,    
        limit: list_size
    }
});