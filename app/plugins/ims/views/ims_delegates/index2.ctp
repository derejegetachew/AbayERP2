var store_parent_imsDelegates = new Ext.data.Store({
	reader: new Ext.data.JsonReader({
		root:'rows',
		totalProperty: 'results',
		fields: [
			'id','ims_requisition','user','name','phone','created','modified'	
		]
	}),
	proxy: new Ext.data.HttpProxy({
		url: '<?php echo $this->Html->url(array('controller' => 'imsDelegates', 'action' => 'list_data', $parent_id)); ?>'	})
});


function AddParentImsDelegate() {
	Ext.Ajax.request({
		url: '<?php echo $this->Html->url(array('controller' => 'imsDelegates', 'action' => 'add', $parent_id)); ?>',
		success: function(response, opts) {
			var parent_imsDelegate_data = response.responseText;
			
			eval(parent_imsDelegate_data);
			
			ImsDelegateAddWindow.show();
		},
		failure: function(response, opts) {
			Ext.Msg.alert('<?php __('Error'); ?>', '<?php __('Cannot get the imsDelegate add form. Error code'); ?>: ' + response.status);
		}
	});
}

function EditParentImsDelegate(id) {
	Ext.Ajax.request({
		url: '<?php echo $this->Html->url(array('controller' => 'imsDelegates', 'action' => 'edit')); ?>/'+id+'/<?php echo $parent_id; ?>',
		success: function(response, opts) {
			var parent_imsDelegate_data = response.responseText;
			
			eval(parent_imsDelegate_data);
			
			ImsDelegateEditWindow.show();
		},
		failure: function(response, opts) {
			Ext.Msg.alert('<?php __('Error'); ?>', '<?php __('Cannot get the imsDelegate edit form. Error code'); ?>: ' + response.status);
		}
	});
}

function ViewImsDelegate(id) {
	Ext.Ajax.request({
		url: '<?php echo $this->Html->url(array('controller' => 'imsDelegates', 'action' => 'view')); ?>/'+id,
		success: function(response, opts) {
			var imsDelegate_data = response.responseText;

			eval(imsDelegate_data);

			ImsDelegateViewWindow.show();
		},
		failure: function(response, opts) {
			Ext.Msg.alert('<?php __('Error'); ?>', '<?php __('Cannot get the imsDelegate view form. Error code'); ?>: ' + response.status);
		}
	});
}


function DeleteParentImsDelegate(id) {
	Ext.Ajax.request({
		url: '<?php echo $this->Html->url(array('controller' => 'imsDelegates', 'action' => 'delete')); ?>/'+id,
		success: function(response, opts) {
			Ext.Msg.alert('<?php __('Success'); ?>', '<?php __('ImsDelegate(s) successfully deleted!'); ?>');
			RefreshParentImsDelegateData();
		},
		failure: function(response, opts) {
			Ext.Msg.alert('<?php __('Error'); ?>', '<?php __('Cannot get the imsDelegate to be deleted. Error code'); ?>: ' + response.status);
		}
	});
}

function SearchByParentImsDelegateName(value){
	var conditions = '\'ImsDelegate.name LIKE\' => \'%' + value + '%\'';
	store_parent_imsDelegates.reload({
		 params: {
			start: 0,
			limit: list_size,
			conditions: conditions
	    }
	});
}

function RefreshParentImsDelegateData() {
	store_parent_imsDelegates.reload();
}



var g = new Ext.grid.GridPanel({
	title: '<?php __('ImsDelegates'); ?>',
	store: store_parent_imsDelegates,
	loadMask: true,
	stripeRows: true,
	height: 300,
	anchor: '100%',
    id: 'imsDelegateGrid',
	columns: [
		{header:"<?php __('ims_requisition'); ?>", dataIndex: 'ims_requisition', sortable: true},
		{header:"<?php __('user'); ?>", dataIndex: 'user', sortable: true},
		{header: "<?php __('Name'); ?>", dataIndex: 'name', sortable: true},
		{header: "<?php __('Phone'); ?>", dataIndex: 'phone', sortable: true},
		{header: "<?php __('Created'); ?>", dataIndex: 'created', sortable: true},
		{header: "<?php __('Modified'); ?>", dataIndex: 'modified', sortable: true}	],
	sm: new Ext.grid.RowSelectionModel({
		singleSelect: false
	}),
	viewConfig: {
		forceFit: true
	},
    listeners: {
        celldblclick: function(){
            ViewImsDelegate(Ext.getCmp('imsDelegateGrid').getSelectionModel().getSelected().data.id);
        }
    },
	tbar: new Ext.Toolbar({
		items: [{
				xtype: 'tbbutton',
				text: '<?php __('Add'); ?>',
				tooltip:'<?php __('<b>Add ImsDelegate</b><br />Click here to create a new ImsDelegate'); ?>',
				icon: 'img/table_add.png',
				cls: 'x-btn-text-icon',
				handler: function(btn) {
					AddParentImsDelegate();
				}
			}, ' ', '-', ' ', {
				xtype: 'tbbutton',
				text: '<?php __('Edit'); ?>',
				id: 'edit-parent-imsDelegate',
				tooltip:'<?php __('<b>Edit ImsDelegate</b><br />Click here to modify the selected ImsDelegate'); ?>',
				icon: 'img/table_edit.png',
				cls: 'x-btn-text-icon',
				disabled: true,
				handler: function(btn) {
					var sm = g.getSelectionModel();
					var sel = sm.getSelected();
					if (sm.hasSelection()){
						EditParentImsDelegate(sel.data.id);
					};
				}
			}, ' ', '-', ' ', {
				xtype: 'tbbutton',
				text: '<?php __('Delete'); ?>',
				id: 'delete-parent-imsDelegate',
				tooltip:'<?php __('<b>Delete ImsDelegate(s)</b><br />Click here to remove the selected ImsDelegate(s)'); ?>',
				icon: 'img/table_delete.png',
				cls: 'x-btn-text-icon',
				disabled: true,
				handler: function(btn) {
					var sm = g.getSelectionModel();
					var sel = sm.getSelections();
					if (sm.hasSelection()){
						if(sel.length==1){
							Ext.Msg.show({
									title: '<?php __('Remove ImsDelegate'); ?>',
									buttons: Ext.MessageBox.YESNOCANCEL,
									msg: '<?php __('Remove'); ?> '+sel[0].data.name+'?',
									icon: Ext.MessageBox.QUESTION,
                                    fn: function(btn){
											if (btn == 'yes'){
													DeleteParentImsDelegate(sel[0].data.id);
											}
									}
							});
						} else {
							Ext.Msg.show({
									title: '<?php __('Remove ImsDelegate'); ?>',
									buttons: Ext.MessageBox.YESNOCANCEL,
									msg: '<?php __('Remove the selected ImsDelegate'); ?>?',
									icon: Ext.MessageBox.QUESTION,
                                    fn: function(btn){
											if (btn == 'yes'){
													var sel_ids = '';
													for(i=0;i<sel.length;i++){
														if(i>0)
															sel_ids += '_';
														sel_ids += sel[i].data.id;
													}
													DeleteParentImsDelegate(sel_ids);
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
				text: '<?php __('View ImsDelegate'); ?>',
				id: 'view-imsDelegate2',
				tooltip:'<?php __('<b>View ImsDelegate</b><br />Click here to see details of the selected ImsDelegate'); ?>',
				icon: 'img/table_view.png',
				cls: 'x-btn-text-icon',
				disabled: true,
				handler: function(btn) {
					var sm = g.getSelectionModel();
					var sel = sm.getSelected();
					if (sm.hasSelection()){
						ViewImsDelegate(sel.data.id);
					};
				},
				menu : {
					items: [
					]
				}

            }, ' ', '->', {
				xtype: 'textfield',
				emptyText: '<?php __('[Search By Name]'); ?>',
				id: 'parent_imsDelegate_search_field',
				listeners: {
					specialkey: function(field, e){
						if (e.getKey() == e.ENTER) {
							SearchByParentImsDelegateName(Ext.getCmp('parent_imsDelegate_search_field').getValue());
						}
					}

				}
			}, {
				xtype: 'tbbutton',
				icon: 'img/search.png',
				cls: 'x-btn-text-icon',
				text: 'GO',
				tooltip:'<?php __('<b>GO</b><br />Click here to get search results'); ?>',
				id: 'parent_imsDelegate_go_button',
				handler: function(){
					SearchByParentImsDelegateName(Ext.getCmp('parent_imsDelegate_search_field').getValue());
				}
			}, ' '
	]}),
	bbar: new Ext.PagingToolbar({
		pageSize: list_size,
		store: store_parent_imsDelegates,
		displayInfo: true,
		displayMsg: '<?php __('Displaying {0} - {1} of {2}'); ?>',
		beforePageText: '<?php __('Page'); ?>',
		afterPageText: '<?php __('of {0}'); ?>',
		emptyMsg: '<?php __('No data to display'); ?>'
	})
});
g.getSelectionModel().on('rowselect', function(sm, rowIdx, r) {
	g.getTopToolbar().findById('edit-parent-imsDelegate').enable();
	g.getTopToolbar().findById('delete-parent-imsDelegate').enable();
        g.getTopToolbar().findById('view-imsDelegate2').enable();
	if(this.getSelections().length > 1){
		g.getTopToolbar().findById('edit-parent-imsDelegate').disable();
                g.getTopToolbar().findById('view-imsDelegate2').disable();
	}
});
g.getSelectionModel().on('rowdeselect', function(sm, rowIdx, r) {
	if(this.getSelections().length > 1){
		g.getTopToolbar().findById('edit-parent-imsDelegate').disable();
		g.getTopToolbar().findById('delete-parent-imsDelegate').enable();
                g.getTopToolbar().findById('view-imsDelegate2').disable();
	}
	else if(this.getSelections().length == 1){
		g.getTopToolbar().findById('edit-parent-imsDelegate').enable();
		g.getTopToolbar().findById('delete-parent-imsDelegate').enable();
                g.getTopToolbar().findById('view-imsDelegate2').enable();
	}
	else{
		g.getTopToolbar().findById('edit-parent-imsDelegate').disable();
		g.getTopToolbar().findById('delete-parent-imsDelegate').disable();
                g.getTopToolbar().findById('view-imsDelegate2').disable();
	}
});



var parentImsDelegatesViewWindow = new Ext.Window({
	title: 'ImsDelegate Under the selected Item',
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
			parentImsDelegatesViewWindow.close();
		}
	}]
});

store_parent_imsDelegates.load({
    params: {
        start: 0,    
        limit: list_size
    }
});