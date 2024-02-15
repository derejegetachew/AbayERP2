var store_parent_frwfmEvents = new Ext.data.Store({
	reader: new Ext.data.JsonReader({
		root:'rows',
		totalProperty: 'results',
		fields: [
			'id','frwfm_application','user','action','remark','created'	
		]
	}),
	proxy: new Ext.data.HttpProxy({
		url: '<?php echo $this->Html->url(array('controller' => 'frwfmEvents', 'action' => 'list_data', $parent_id)); ?>'	})
});


function AddParentFrwfmEvent() {
	Ext.Ajax.request({
		url: '<?php echo $this->Html->url(array('controller' => 'frwfmEvents', 'action' => 'add', $parent_id)); ?>',
		success: function(response, opts) {
			var parent_frwfmEvent_data = response.responseText;
			
			eval(parent_frwfmEvent_data);
			
			FrwfmEventAddWindow.show();
		},
		failure: function(response, opts) {
			Ext.Msg.alert('<?php __('Error'); ?>', '<?php __('Cannot get the frwfmEvent add form. Error code'); ?>: ' + response.status);
		}
	});
}

function EditParentFrwfmEvent(id) {
	Ext.Ajax.request({
		url: '<?php echo $this->Html->url(array('controller' => 'frwfmEvents', 'action' => 'edit')); ?>/'+id+'/<?php echo $parent_id; ?>',
		success: function(response, opts) {
			var parent_frwfmEvent_data = response.responseText;
			
			eval(parent_frwfmEvent_data);
			
			FrwfmEventEditWindow.show();
		},
		failure: function(response, opts) {
			Ext.Msg.alert('<?php __('Error'); ?>', '<?php __('Cannot get the frwfmEvent edit form. Error code'); ?>: ' + response.status);
		}
	});
}

function ViewFrwfmEvent(id) {
	Ext.Ajax.request({
		url: '<?php echo $this->Html->url(array('controller' => 'frwfmEvents', 'action' => 'view')); ?>/'+id,
		success: function(response, opts) {
			var frwfmEvent_data = response.responseText;

			eval(frwfmEvent_data);

			FrwfmEventViewWindow.show();
		},
		failure: function(response, opts) {
			Ext.Msg.alert('<?php __('Error'); ?>', '<?php __('Cannot get the frwfmEvent view form. Error code'); ?>: ' + response.status);
		}
	});
}


function DeleteParentFrwfmEvent(id) {
	Ext.Ajax.request({
		url: '<?php echo $this->Html->url(array('controller' => 'frwfmEvents', 'action' => 'delete')); ?>/'+id,
		success: function(response, opts) {
			Ext.Msg.alert('<?php __('Success'); ?>', '<?php __('FrwfmEvent(s) successfully deleted!'); ?>');
			RefreshParentFrwfmEventData();
		},
		failure: function(response, opts) {
			Ext.Msg.alert('<?php __('Error'); ?>', '<?php __('Cannot get the frwfmEvent to be deleted. Error code'); ?>: ' + response.status);
		}
	});
}

function SearchByParentFrwfmEventName(value){
	var conditions = '\'FrwfmEvent.name LIKE\' => \'%' + value + '%\'';
	store_parent_frwfmEvents.reload({
		 params: {
			start: 0,
			limit: list_size,
			conditions: conditions
	    }
	});
}

function RefreshParentFrwfmEventData() {
	store_parent_frwfmEvents.reload();
}



var g = new Ext.grid.GridPanel({
	title: '<?php __('FrwfmEvents'); ?>',
	store: store_parent_frwfmEvents,
	loadMask: true,
	stripeRows: true,
	height: 300,
	anchor: '100%',
    id: 'frwfmEventGrid',
	columns: [
		{header:"<?php __('frwfm_application'); ?>", dataIndex: 'frwfm_application', sortable: true},
		{header:"<?php __('user'); ?>", dataIndex: 'user', sortable: true},
		{header: "<?php __('Action'); ?>", dataIndex: 'action', sortable: true},
		{header: "<?php __('Remark'); ?>", dataIndex: 'remark', sortable: true},
		{header: "<?php __('Created'); ?>", dataIndex: 'created', sortable: true}	],
	sm: new Ext.grid.RowSelectionModel({
		singleSelect: false
	}),
	viewConfig: {
		forceFit: true
	},
    listeners: {
        celldblclick: function(){
            ViewFrwfmEvent(Ext.getCmp('frwfmEventGrid').getSelectionModel().getSelected().data.id);
        }
    },
	tbar: new Ext.Toolbar({
		items: [{
				xtype: 'tbbutton',
				text: '<?php __('Add'); ?>',
				tooltip:'<?php __('<b>Add FrwfmEvent</b><br />Click here to create a new FrwfmEvent'); ?>',
				icon: 'img/table_add.png',
				cls: 'x-btn-text-icon',
				handler: function(btn) {
					AddParentFrwfmEvent();
				}
			}, ' ', '-', ' ', {
				xtype: 'tbbutton',
				text: '<?php __('Edit'); ?>',
				id: 'edit-parent-frwfmEvent',
				tooltip:'<?php __('<b>Edit FrwfmEvent</b><br />Click here to modify the selected FrwfmEvent'); ?>',
				icon: 'img/table_edit.png',
				cls: 'x-btn-text-icon',
				disabled: true,
				handler: function(btn) {
					var sm = g.getSelectionModel();
					var sel = sm.getSelected();
					if (sm.hasSelection()){
						EditParentFrwfmEvent(sel.data.id);
					};
				}
			}, ' ', '-', ' ', {
				xtype: 'tbbutton',
				text: '<?php __('Delete'); ?>',
				id: 'delete-parent-frwfmEvent',
				tooltip:'<?php __('<b>Delete FrwfmEvent(s)</b><br />Click here to remove the selected FrwfmEvent(s)'); ?>',
				icon: 'img/table_delete.png',
				cls: 'x-btn-text-icon',
				disabled: true,
				handler: function(btn) {
					var sm = g.getSelectionModel();
					var sel = sm.getSelections();
					if (sm.hasSelection()){
						if(sel.length==1){
							Ext.Msg.show({
									title: '<?php __('Remove FrwfmEvent'); ?>',
									buttons: Ext.MessageBox.YESNOCANCEL,
									msg: '<?php __('Remove'); ?> '+sel[0].data.name+'?',
									icon: Ext.MessageBox.QUESTION,
                                    fn: function(btn){
											if (btn == 'yes'){
													DeleteParentFrwfmEvent(sel[0].data.id);
											}
									}
							});
						} else {
							Ext.Msg.show({
									title: '<?php __('Remove FrwfmEvent'); ?>',
									buttons: Ext.MessageBox.YESNOCANCEL,
									msg: '<?php __('Remove the selected FrwfmEvent'); ?>?',
									icon: Ext.MessageBox.QUESTION,
                                    fn: function(btn){
											if (btn == 'yes'){
													var sel_ids = '';
													for(i=0;i<sel.length;i++){
														if(i>0)
															sel_ids += '_';
														sel_ids += sel[i].data.id;
													}
													DeleteParentFrwfmEvent(sel_ids);
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
				text: '<?php __('View FrwfmEvent'); ?>',
				id: 'view-frwfmEvent2',
				tooltip:'<?php __('<b>View FrwfmEvent</b><br />Click here to see details of the selected FrwfmEvent'); ?>',
				icon: 'img/table_view.png',
				cls: 'x-btn-text-icon',
				disabled: true,
				handler: function(btn) {
					var sm = g.getSelectionModel();
					var sel = sm.getSelected();
					if (sm.hasSelection()){
						ViewFrwfmEvent(sel.data.id);
					};
				},
				menu : {
					items: [
					]
				}

            }, ' ', '->', {
				xtype: 'textfield',
				emptyText: '<?php __('[Search By Name]'); ?>',
				id: 'parent_frwfmEvent_search_field',
				listeners: {
					specialkey: function(field, e){
						if (e.getKey() == e.ENTER) {
							SearchByParentFrwfmEventName(Ext.getCmp('parent_frwfmEvent_search_field').getValue());
						}
					}

				}
			}, {
				xtype: 'tbbutton',
				icon: 'img/search.png',
				cls: 'x-btn-text-icon',
				text: 'GO',
				tooltip:'<?php __('<b>GO</b><br />Click here to get search results'); ?>',
				id: 'parent_frwfmEvent_go_button',
				handler: function(){
					SearchByParentFrwfmEventName(Ext.getCmp('parent_frwfmEvent_search_field').getValue());
				}
			}, ' '
	]}),
	bbar: new Ext.PagingToolbar({
		pageSize: list_size,
		store: store_parent_frwfmEvents,
		displayInfo: true,
		displayMsg: '<?php __('Displaying {0} - {1} of {2}'); ?>',
		beforePageText: '<?php __('Page'); ?>',
		afterPageText: '<?php __('of {0}'); ?>',
		emptyMsg: '<?php __('No data to display'); ?>'
	})
});
g.getSelectionModel().on('rowselect', function(sm, rowIdx, r) {
	g.getTopToolbar().findById('edit-parent-frwfmEvent').enable();
	g.getTopToolbar().findById('delete-parent-frwfmEvent').enable();
        g.getTopToolbar().findById('view-frwfmEvent2').enable();
	if(this.getSelections().length > 1){
		g.getTopToolbar().findById('edit-parent-frwfmEvent').disable();
                g.getTopToolbar().findById('view-frwfmEvent2').disable();
	}
});
g.getSelectionModel().on('rowdeselect', function(sm, rowIdx, r) {
	if(this.getSelections().length > 1){
		g.getTopToolbar().findById('edit-parent-frwfmEvent').disable();
		g.getTopToolbar().findById('delete-parent-frwfmEvent').enable();
                g.getTopToolbar().findById('view-frwfmEvent2').disable();
	}
	else if(this.getSelections().length == 1){
		g.getTopToolbar().findById('edit-parent-frwfmEvent').enable();
		g.getTopToolbar().findById('delete-parent-frwfmEvent').enable();
                g.getTopToolbar().findById('view-frwfmEvent2').enable();
	}
	else{
		g.getTopToolbar().findById('edit-parent-frwfmEvent').disable();
		g.getTopToolbar().findById('delete-parent-frwfmEvent').disable();
                g.getTopToolbar().findById('view-frwfmEvent2').disable();
	}
});



var parentFrwfmEventsViewWindow = new Ext.Window({
	title: 'FrwfmEvent Under the selected Item',
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
			parentFrwfmEventsViewWindow.close();
		}
	}]
});

store_parent_frwfmEvents.load({
    params: {
        start: 0,    
        limit: list_size
    }
});