var store_parent_availableBirrNotes = new Ext.data.Store({
	reader: new Ext.data.JsonReader({
		root:'rows',
		totalProperty: 'results',
		fields: [
			'id','old_10_birr','old_50_birr','old_100_birr','new_200_birr','new_100_birr','new_50_birr','new_10_birr','new_5_birr','new_1_birr','new_50_cents','new_25_cents','new_10_cents','new_5_cents','date_of','created','updated'	
		]
	}),
	proxy: new Ext.data.HttpProxy({
		url: '<?php echo $this->Html->url(array('controller' => 'availableBirrNotes', 'action' => 'list_data', $parent_id)); ?>'	})
});


function AddParentAvailableBirrNote() {
	Ext.Ajax.request({
		url: '<?php echo $this->Html->url(array('controller' => 'availableBirrNotes', 'action' => 'add', $parent_id)); ?>',
		success: function(response, opts) {
			var parent_availableBirrNote_data = response.responseText;
			
			eval(parent_availableBirrNote_data);
			
			AvailableBirrNoteAddWindow.show();
		},
		failure: function(response, opts) {
			Ext.Msg.alert('<?php __('Error'); ?>', '<?php __('Cannot get the availableBirrNote add form. Error code'); ?>: ' + response.status);
		}
	});
}

function EditParentAvailableBirrNote(id) {
	Ext.Ajax.request({
		url: '<?php echo $this->Html->url(array('controller' => 'availableBirrNotes', 'action' => 'edit')); ?>/'+id+'/<?php echo $parent_id; ?>',
		success: function(response, opts) {
			var parent_availableBirrNote_data = response.responseText;
			
			eval(parent_availableBirrNote_data);
			
			AvailableBirrNoteEditWindow.show();
		},
		failure: function(response, opts) {
			Ext.Msg.alert('<?php __('Error'); ?>', '<?php __('Cannot get the availableBirrNote edit form. Error code'); ?>: ' + response.status);
		}
	});
}

function ViewAvailableBirrNote(id) {
	Ext.Ajax.request({
		url: '<?php echo $this->Html->url(array('controller' => 'availableBirrNotes', 'action' => 'view')); ?>/'+id,
		success: function(response, opts) {
			var availableBirrNote_data = response.responseText;

			eval(availableBirrNote_data);

			AvailableBirrNoteViewWindow.show();
		},
		failure: function(response, opts) {
			Ext.Msg.alert('<?php __('Error'); ?>', '<?php __('Cannot get the availableBirrNote view form. Error code'); ?>: ' + response.status);
		}
	});
}


function DeleteParentAvailableBirrNote(id) {
	Ext.Ajax.request({
		url: '<?php echo $this->Html->url(array('controller' => 'availableBirrNotes', 'action' => 'delete')); ?>/'+id,
		success: function(response, opts) {
			Ext.Msg.alert('<?php __('Success'); ?>', '<?php __('AvailableBirrNote(s) successfully deleted!'); ?>');
			RefreshParentAvailableBirrNoteData();
		},
		failure: function(response, opts) {
			Ext.Msg.alert('<?php __('Error'); ?>', '<?php __('Cannot get the availableBirrNote to be deleted. Error code'); ?>: ' + response.status);
		}
	});
}

function SearchByParentAvailableBirrNoteName(value){
	var conditions = '\'AvailableBirrNote.name LIKE\' => \'%' + value + '%\'';
	store_parent_availableBirrNotes.reload({
		 params: {
			start: 0,
			limit: list_size,
			conditions: conditions
	    }
	});
}

function RefreshParentAvailableBirrNoteData() {
	store_parent_availableBirrNotes.reload();
}



var g = new Ext.grid.GridPanel({
	title: '<?php __('AvailableBirrNotes'); ?>',
	store: store_parent_availableBirrNotes,
	loadMask: true,
	stripeRows: true,
	height: 300,
	anchor: '100%',
    id: 'availableBirrNoteGrid',
	columns: [
		{header:"<?php __('branch'); ?>", dataIndex: 'branch', sortable: true},
		{header:"<?php __('user'); ?>", dataIndex: 'user', sortable: true},
		{header: "<?php __('Old 10 Birr'); ?>", dataIndex: 'old_10_birr', sortable: true},
		{header: "<?php __('Old 50 Birr'); ?>", dataIndex: 'old_50_birr', sortable: true},
		{header: "<?php __('Old 100 Birr'); ?>", dataIndex: 'old_100_birr', sortable: true},
		{header: "<?php __('New 200 Birr'); ?>", dataIndex: 'new_200_birr', sortable: true},
		{header: "<?php __('New 100 Birr'); ?>", dataIndex: 'new_100_birr', sortable: true},
		{header: "<?php __('New 50 Birr'); ?>", dataIndex: 'new_50_birr', sortable: true},
		{header: "<?php __('New 10 Birr'); ?>", dataIndex: 'new_10_birr', sortable: true},
		{header: "<?php __('New 5 Birr'); ?>", dataIndex: 'new_5_birr', sortable: true},
		{header: "<?php __('New 1 Birr'); ?>", dataIndex: 'new_1_birr', sortable: true},
		{header: "<?php __('New 50 Cents'); ?>", dataIndex: 'new_50_cents', sortable: true},
		{header: "<?php __('New 25 Cents'); ?>", dataIndex: 'new_25_cents', sortable: true},
		{header: "<?php __('New 10 Cents'); ?>", dataIndex: 'new_10_cents', sortable: true},
		{header: "<?php __('New 5 Cents'); ?>", dataIndex: 'new_5_cents', sortable: true},
		{header: "<?php __('Date Of'); ?>", dataIndex: 'date_of', sortable: true},
		{header: "<?php __('Created'); ?>", dataIndex: 'created', sortable: true},
		{header: "<?php __('Updated'); ?>", dataIndex: 'updated', sortable: true}	],
	sm: new Ext.grid.RowSelectionModel({
		singleSelect: false
	}),
	viewConfig: {
		forceFit: true
	},
    listeners: {
        celldblclick: function(){
            ViewAvailableBirrNote(Ext.getCmp('availableBirrNoteGrid').getSelectionModel().getSelected().data.id);
        }
    },
	tbar: new Ext.Toolbar({
		items: [{
				xtype: 'tbbutton',
				text: '<?php __('Add'); ?>',
				tooltip:'<?php __('<b>Add AvailableBirrNote</b><br />Click here to create a new AvailableBirrNote'); ?>',
				icon: 'img/table_add.png',
				cls: 'x-btn-text-icon',
				handler: function(btn) {
					AddParentAvailableBirrNote();
				}
			}, ' ', '-', ' ', {
				xtype: 'tbbutton',
				text: '<?php __('Edit'); ?>',
				id: 'edit-parent-availableBirrNote',
				tooltip:'<?php __('<b>Edit AvailableBirrNote</b><br />Click here to modify the selected AvailableBirrNote'); ?>',
				icon: 'img/table_edit.png',
				cls: 'x-btn-text-icon',
				disabled: true,
				handler: function(btn) {
					var sm = g.getSelectionModel();
					var sel = sm.getSelected();
					if (sm.hasSelection()){
						EditParentAvailableBirrNote(sel.data.id);
					};
				}
			}, ' ', '-', ' ', {
				xtype: 'tbbutton',
				text: '<?php __('Delete'); ?>',
				id: 'delete-parent-availableBirrNote',
				tooltip:'<?php __('<b>Delete AvailableBirrNote(s)</b><br />Click here to remove the selected AvailableBirrNote(s)'); ?>',
				icon: 'img/table_delete.png',
				cls: 'x-btn-text-icon',
				disabled: true,
				handler: function(btn) {
					var sm = g.getSelectionModel();
					var sel = sm.getSelections();
					if (sm.hasSelection()){
						if(sel.length==1){
							Ext.Msg.show({
									title: '<?php __('Remove AvailableBirrNote'); ?>',
									buttons: Ext.MessageBox.YESNOCANCEL,
									msg: '<?php __('Remove'); ?> '+sel[0].data.name+'?',
									icon: Ext.MessageBox.QUESTION,
                                    fn: function(btn){
											if (btn == 'yes'){
													DeleteParentAvailableBirrNote(sel[0].data.id);
											}
									}
							});
						} else {
							Ext.Msg.show({
									title: '<?php __('Remove AvailableBirrNote'); ?>',
									buttons: Ext.MessageBox.YESNOCANCEL,
									msg: '<?php __('Remove the selected AvailableBirrNote'); ?>?',
									icon: Ext.MessageBox.QUESTION,
                                    fn: function(btn){
											if (btn == 'yes'){
													var sel_ids = '';
													for(i=0;i<sel.length;i++){
														if(i>0)
															sel_ids += '_';
														sel_ids += sel[i].data.id;
													}
													DeleteParentAvailableBirrNote(sel_ids);
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
				text: '<?php __('View AvailableBirrNote'); ?>',
				id: 'view-availableBirrNote2',
				tooltip:'<?php __('<b>View AvailableBirrNote</b><br />Click here to see details of the selected AvailableBirrNote'); ?>',
				icon: 'img/table_view.png',
				cls: 'x-btn-text-icon',
				disabled: true,
				handler: function(btn) {
					var sm = g.getSelectionModel();
					var sel = sm.getSelected();
					if (sm.hasSelection()){
						ViewAvailableBirrNote(sel.data.id);
					};
				},
				menu : {
					items: [
					]
				}

            }, ' ', '->', {
				xtype: 'textfield',
				emptyText: '<?php __('[Search By Name]'); ?>',
				id: 'parent_availableBirrNote_search_field',
				listeners: {
					specialkey: function(field, e){
						if (e.getKey() == e.ENTER) {
							SearchByParentAvailableBirrNoteName(Ext.getCmp('parent_availableBirrNote_search_field').getValue());
						}
					}

				}
			}, {
				xtype: 'tbbutton',
				icon: 'img/search.png',
				cls: 'x-btn-text-icon',
				text: 'GO',
				tooltip:'<?php __('<b>GO</b><br />Click here to get search results'); ?>',
				id: 'parent_availableBirrNote_go_button',
				handler: function(){
					SearchByParentAvailableBirrNoteName(Ext.getCmp('parent_availableBirrNote_search_field').getValue());
				}
			}, ' '
	]}),
	bbar: new Ext.PagingToolbar({
		pageSize: list_size,
		store: store_parent_availableBirrNotes,
		displayInfo: true,
		displayMsg: '<?php __('Displaying {0} - {1} of {2}'); ?>',
		beforePageText: '<?php __('Page'); ?>',
		afterPageText: '<?php __('of {0}'); ?>',
		emptyMsg: '<?php __('No data to display'); ?>'
	})
});
g.getSelectionModel().on('rowselect', function(sm, rowIdx, r) {
	g.getTopToolbar().findById('edit-parent-availableBirrNote').enable();
	g.getTopToolbar().findById('delete-parent-availableBirrNote').enable();
        g.getTopToolbar().findById('view-availableBirrNote2').enable();
	if(this.getSelections().length > 1){
		g.getTopToolbar().findById('edit-parent-availableBirrNote').disable();
                g.getTopToolbar().findById('view-availableBirrNote2').disable();
	}
});
g.getSelectionModel().on('rowdeselect', function(sm, rowIdx, r) {
	if(this.getSelections().length > 1){
		g.getTopToolbar().findById('edit-parent-availableBirrNote').disable();
		g.getTopToolbar().findById('delete-parent-availableBirrNote').enable();
                g.getTopToolbar().findById('view-availableBirrNote2').disable();
	}
	else if(this.getSelections().length == 1){
		g.getTopToolbar().findById('edit-parent-availableBirrNote').enable();
		g.getTopToolbar().findById('delete-parent-availableBirrNote').enable();
                g.getTopToolbar().findById('view-availableBirrNote2').enable();
	}
	else{
		g.getTopToolbar().findById('edit-parent-availableBirrNote').disable();
		g.getTopToolbar().findById('delete-parent-availableBirrNote').disable();
                g.getTopToolbar().findById('view-availableBirrNote2').disable();
	}
});



var parentAvailableBirrNotesViewWindow = new Ext.Window({
	title: 'AvailableBirrNote Under the selected Item',
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
			parentAvailableBirrNotesViewWindow.close();
		}
	}]
});

store_parent_availableBirrNotes.load({
    params: {
        start: 0,    
        limit: list_size
    }
});