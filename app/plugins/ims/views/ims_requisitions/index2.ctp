var store_parent_imsRequisitions = new Ext.data.Store({
	reader: new Ext.data.JsonReader({
		root:'rows',
		totalProperty: 'results',
		fields: [
			'id','name','budget_year','branch','purpose','requested_by','posted','approved_by','created','modified'	
		]
	}),
	proxy: new Ext.data.HttpProxy({
		url: '<?php echo $this->Html->url(array('controller' => 'imsRequisitions', 'action' => 'list_data', $parent_id)); ?>'	})
});


function AddParentImsRequisition() {
	Ext.Ajax.request({
		url: '<?php echo $this->Html->url(array('controller' => 'imsRequisitions', 'action' => 'add', $parent_id)); ?>',
		success: function(response, opts) {
			var parent_imsRequisition_data = response.responseText;
			
			eval(parent_imsRequisition_data);
			
			ImsRequisitionAddWindow.show();
		},
		failure: function(response, opts) {
			Ext.Msg.alert('<?php __('Error'); ?>', '<?php __('Cannot get the imsRequisition add form. Error code'); ?>: ' + response.status);
		}
	});
}

function EditParentImsRequisition(id) {
	Ext.Ajax.request({
		url: '<?php echo $this->Html->url(array('controller' => 'imsRequisitions', 'action' => 'edit')); ?>/'+id+'/<?php echo $parent_id; ?>',
		success: function(response, opts) {
			var parent_imsRequisition_data = response.responseText;
			
			eval(parent_imsRequisition_data);
			
			ImsRequisitionEditWindow.show();
		},
		failure: function(response, opts) {
			Ext.Msg.alert('<?php __('Error'); ?>', '<?php __('Cannot get the imsRequisition edit form. Error code'); ?>: ' + response.status);
		}
	});
}

function ViewImsRequisition(id) {
	Ext.Ajax.request({
		url: '<?php echo $this->Html->url(array('controller' => 'imsRequisitions', 'action' => 'view')); ?>/'+id,
		success: function(response, opts) {
			var imsRequisition_data = response.responseText;

			eval(imsRequisition_data);

			ImsRequisitionViewWindow.show();
		},
		failure: function(response, opts) {
			Ext.Msg.alert('<?php __('Error'); ?>', '<?php __('Cannot get the imsRequisition view form. Error code'); ?>: ' + response.status);
		}
	});
}

function ViewImsRequisitionImsRequisitionItems(id) {
	Ext.Ajax.request({
		url: '<?php echo $this->Html->url(array('controller' => 'imsRequisitionItems', 'action' => 'index2')); ?>/'+id,
		success: function(response, opts) {
			var parent_imsRequisitionItems_data = response.responseText;

			eval(parent_imsRequisitionItems_data);

			parentImsRequisitionItemsViewWindow.show();
		},
		failure: function(response, opts) {
			Ext.Msg.alert('<?php __('Error'); ?>', '<?php __('Cannot get the campus view form. Error code'); ?>: ' + response.status);
		}
	});
}


function DeleteParentImsRequisition(id) {
	Ext.Ajax.request({
		url: '<?php echo $this->Html->url(array('controller' => 'imsRequisitions', 'action' => 'delete')); ?>/'+id,
		success: function(response, opts) {
			Ext.Msg.alert('<?php __('Success'); ?>', '<?php __('ImsRequisition(s) successfully deleted!'); ?>');
			RefreshParentImsRequisitionData();
		},
		failure: function(response, opts) {
			Ext.Msg.alert('<?php __('Error'); ?>', '<?php __('Cannot get the imsRequisition to be deleted. Error code'); ?>: ' + response.status);
		}
	});
}

function SearchByParentImsRequisitionName(value){
	var conditions = '\'ImsRequisition.name LIKE\' => \'%' + value + '%\'';
	store_parent_imsRequisitions.reload({
		 params: {
			start: 0,
			limit: list_size,
			conditions: conditions
	    }
	});
}

function RefreshParentImsRequisitionData() {
	store_parent_imsRequisitions.reload();
}



var g = new Ext.grid.GridPanel({
	title: '<?php __('ImsRequisitions'); ?>',
	store: store_parent_imsRequisitions,
	loadMask: true,
	stripeRows: true,
	height: 300,
	anchor: '100%',
    id: 'imsRequisitionGrid',
	columns: [
		{header: "<?php __('Name'); ?>", dataIndex: 'name', sortable: true},
		{header:"<?php __('budget_year'); ?>", dataIndex: 'budget_year', sortable: true},
		{header:"<?php __('branch'); ?>", dataIndex: 'branch', sortable: true},
		{header: "<?php __('Purpose'); ?>", dataIndex: 'purpose', sortable: true},
		{header: "<?php __('Requested By'); ?>", dataIndex: 'requested_by', sortable: true},
		{header: "<?php __('Posted'); ?>", dataIndex: 'posted', sortable: true},
		{header: "<?php __('Approved By'); ?>", dataIndex: 'approved_by', sortable: true},
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
            ViewImsRequisition(Ext.getCmp('imsRequisitionGrid').getSelectionModel().getSelected().data.id);
        }
    },
	tbar: new Ext.Toolbar({
		items: [{
				xtype: 'tbbutton',
				text: '<?php __('Add'); ?>',
				tooltip:'<?php __('<b>Add ImsRequisition</b><br />Click here to create a new ImsRequisition'); ?>',
				icon: 'img/table_add.png',
				cls: 'x-btn-text-icon',
				handler: function(btn) {
					AddParentImsRequisition();
				}
			}, ' ', '-', ' ', {
				xtype: 'tbbutton',
				text: '<?php __('Edit'); ?>',
				id: 'edit-parent-imsRequisition',
				tooltip:'<?php __('<b>Edit ImsRequisition</b><br />Click here to modify the selected ImsRequisition'); ?>',
				icon: 'img/table_edit.png',
				cls: 'x-btn-text-icon',
				disabled: true,
				handler: function(btn) {
					var sm = g.getSelectionModel();
					var sel = sm.getSelected();
					if (sm.hasSelection()){
						EditParentImsRequisition(sel.data.id);
					};
				}
			}, ' ', '-', ' ', {
				xtype: 'tbbutton',
				text: '<?php __('Delete'); ?>',
				id: 'delete-parent-imsRequisition',
				tooltip:'<?php __('<b>Delete ImsRequisition(s)</b><br />Click here to remove the selected ImsRequisition(s)'); ?>',
				icon: 'img/table_delete.png',
				cls: 'x-btn-text-icon',
				disabled: true,
				handler: function(btn) {
					var sm = g.getSelectionModel();
					var sel = sm.getSelections();
					if (sm.hasSelection()){
						if(sel.length==1){
							Ext.Msg.show({
									title: '<?php __('Remove ImsRequisition'); ?>',
									buttons: Ext.MessageBox.YESNOCANCEL,
									msg: '<?php __('Remove'); ?> '+sel[0].data.name+'?',
									icon: Ext.MessageBox.QUESTION,
                                    fn: function(btn){
											if (btn == 'yes'){
													DeleteParentImsRequisition(sel[0].data.id);
											}
									}
							});
						} else {
							Ext.Msg.show({
									title: '<?php __('Remove ImsRequisition'); ?>',
									buttons: Ext.MessageBox.YESNOCANCEL,
									msg: '<?php __('Remove the selected ImsRequisition'); ?>?',
									icon: Ext.MessageBox.QUESTION,
                                    fn: function(btn){
											if (btn == 'yes'){
													var sel_ids = '';
													for(i=0;i<sel.length;i++){
														if(i>0)
															sel_ids += '_';
														sel_ids += sel[i].data.id;
													}
													DeleteParentImsRequisition(sel_ids);
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
				text: '<?php __('View ImsRequisition'); ?>',
				id: 'view-imsRequisition2',
				tooltip:'<?php __('<b>View ImsRequisition</b><br />Click here to see details of the selected ImsRequisition'); ?>',
				icon: 'img/table_view.png',
				cls: 'x-btn-text-icon',
				disabled: true,
				handler: function(btn) {
					var sm = g.getSelectionModel();
					var sel = sm.getSelected();
					if (sm.hasSelection()){
						ViewImsRequisition(sel.data.id);
					};
				},
				menu : {
					items: [
 {
						text: '<?php __('View Ims Requisition Items'); ?>',
                        icon: 'img/table_view.png',
						cls: 'x-btn-text-icon',
						handler: function(btn) {
							var sm = g.getSelectionModel();
							var sel = sm.getSelected();
							if (sm.hasSelection()){
								ViewImsRequisitionImsRequisitionItems(sel.data.id);
							};
						}
					}
					]
				}

            }, ' ', '->', {
				xtype: 'textfield',
				emptyText: '<?php __('[Search By Name]'); ?>',
				id: 'parent_imsRequisition_search_field',
				listeners: {
					specialkey: function(field, e){
						if (e.getKey() == e.ENTER) {
							SearchByParentImsRequisitionName(Ext.getCmp('parent_imsRequisition_search_field').getValue());
						}
					}

				}
			}, {
				xtype: 'tbbutton',
				icon: 'img/search.png',
				cls: 'x-btn-text-icon',
				text: 'GO',
				tooltip:'<?php __('<b>GO</b><br />Click here to get search results'); ?>',
				id: 'parent_imsRequisition_go_button',
				handler: function(){
					SearchByParentImsRequisitionName(Ext.getCmp('parent_imsRequisition_search_field').getValue());
				}
			}, ' '
	]}),
	bbar: new Ext.PagingToolbar({
		pageSize: list_size,
		store: store_parent_imsRequisitions,
		displayInfo: true,
		displayMsg: '<?php __('Displaying {0} - {1} of {2}'); ?>',
		beforePageText: '<?php __('Page'); ?>',
		afterPageText: '<?php __('of {0}'); ?>',
		emptyMsg: '<?php __('No data to display'); ?>'
	})
});
g.getSelectionModel().on('rowselect', function(sm, rowIdx, r) {
	g.getTopToolbar().findById('edit-parent-imsRequisition').enable();
	g.getTopToolbar().findById('delete-parent-imsRequisition').enable();
        g.getTopToolbar().findById('view-imsRequisition2').enable();
	if(this.getSelections().length > 1){
		g.getTopToolbar().findById('edit-parent-imsRequisition').disable();
                g.getTopToolbar().findById('view-imsRequisition2').disable();
	}
});
g.getSelectionModel().on('rowdeselect', function(sm, rowIdx, r) {
	if(this.getSelections().length > 1){
		g.getTopToolbar().findById('edit-parent-imsRequisition').disable();
		g.getTopToolbar().findById('delete-parent-imsRequisition').enable();
                g.getTopToolbar().findById('view-imsRequisition2').disable();
	}
	else if(this.getSelections().length == 1){
		g.getTopToolbar().findById('edit-parent-imsRequisition').enable();
		g.getTopToolbar().findById('delete-parent-imsRequisition').enable();
                g.getTopToolbar().findById('view-imsRequisition2').enable();
	}
	else{
		g.getTopToolbar().findById('edit-parent-imsRequisition').disable();
		g.getTopToolbar().findById('delete-parent-imsRequisition').disable();
                g.getTopToolbar().findById('view-imsRequisition2').disable();
	}
});



var parentImsRequisitionsViewWindow = new Ext.Window({
	title: 'ImsRequisition Under the selected Item',
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
			parentImsRequisitionsViewWindow.close();
		}
	}]
});

store_parent_imsRequisitions.load({
    params: {
        start: 0,    
        limit: list_size
    }
});