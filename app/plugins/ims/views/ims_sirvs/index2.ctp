var store_parent_imsSirvs = new Ext.data.Store({
	reader: new Ext.data.JsonReader({
		root:'rows',
		totalProperty: 'results',
		fields: [
			'id','name','ims_requisition','created','modified'	
		]
	}),
	proxy: new Ext.data.HttpProxy({
		url: '<?php echo $this->Html->url(array('controller' => 'imsSirvs', 'action' => 'list_data', $parent_id)); ?>'	})
});


function AddParentImsSirv() {
	Ext.Ajax.request({
		url: '<?php echo $this->Html->url(array('controller' => 'imsSirvs', 'action' => 'add', $parent_id)); ?>',
		success: function(response, opts) {
			var parent_imsSirv_data = response.responseText;
			
			eval(parent_imsSirv_data);
			
			ImsSirvAddWindow.show();
		},
		failure: function(response, opts) {
			Ext.Msg.alert('<?php __('Error'); ?>', '<?php __('Cannot get the imsSirv add form. Error code'); ?>: ' + response.status);
		}
	});
}

function EditParentImsSirv(id) {
	Ext.Ajax.request({
		url: '<?php echo $this->Html->url(array('controller' => 'imsSirvs', 'action' => 'edit')); ?>/'+id+'/<?php echo $parent_id; ?>',
		success: function(response, opts) {
			var parent_imsSirv_data = response.responseText;
			
			eval(parent_imsSirv_data);
			
			ImsSirvEditWindow.show();
		},
		failure: function(response, opts) {
			Ext.Msg.alert('<?php __('Error'); ?>', '<?php __('Cannot get the imsSirv edit form. Error code'); ?>: ' + response.status);
		}
	});
}

function ViewImsSirv(id) {
	Ext.Ajax.request({
		url: '<?php echo $this->Html->url(array('controller' => 'imsSirvs', 'action' => 'view')); ?>/'+id,
		success: function(response, opts) {
			var imsSirv_data = response.responseText;

			eval(imsSirv_data);

			ImsSirvViewWindow.show();
		},
		failure: function(response, opts) {
			Ext.Msg.alert('<?php __('Error'); ?>', '<?php __('Cannot get the imsSirv view form. Error code'); ?>: ' + response.status);
		}
	});
}

function ViewImsSirvImsSirvItems(id) {
	Ext.Ajax.request({
		url: '<?php echo $this->Html->url(array('controller' => 'imsSirvItems', 'action' => 'index2')); ?>/'+id,
		success: function(response, opts) {
			var parent_imsSirvItems_data = response.responseText;

			eval(parent_imsSirvItems_data);

			parentImsSirvItemsViewWindow.show();
		},
		failure: function(response, opts) {
			Ext.Msg.alert('<?php __('Error'); ?>', '<?php __('Cannot get the campus view form. Error code'); ?>: ' + response.status);
		}
	});
}


function DeleteParentImsSirv(id) {
	Ext.Ajax.request({
		url: '<?php echo $this->Html->url(array('controller' => 'imsSirvs', 'action' => 'delete')); ?>/'+id,
		success: function(response, opts) {
			Ext.Msg.alert('<?php __('Success'); ?>', '<?php __('ImsSirv(s) successfully deleted!'); ?>');
			RefreshParentImsSirvData();
		},
		failure: function(response, opts) {
			Ext.Msg.alert('<?php __('Error'); ?>', '<?php __('Cannot get the imsSirv to be deleted. Error code'); ?>: ' + response.status);
		}
	});
}

function SearchByParentImsSirvName(value){
	var conditions = '\'ImsSirv.name LIKE\' => \'%' + value + '%\'';
	store_parent_imsSirvs.reload({
		 params: {
			start: 0,
			limit: list_size,
			conditions: conditions
	    }
	});
}

function RefreshParentImsSirvData() {
	store_parent_imsSirvs.reload();
}



var g = new Ext.grid.GridPanel({
	title: '<?php __('ImsSirvs'); ?>',
	store: store_parent_imsSirvs,
	loadMask: true,
	stripeRows: true,
	height: 300,
	anchor: '100%',
    id: 'imsSirvGrid',
	columns: [
		{header: "<?php __('Name'); ?>", dataIndex: 'name', sortable: true},
		{header:"<?php __('ims_requisition'); ?>", dataIndex: 'ims_requisition', sortable: true},
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
            ViewImsSirv(Ext.getCmp('imsSirvGrid').getSelectionModel().getSelected().data.id);
        }
    },
	tbar: new Ext.Toolbar({
		items: [{
				xtype: 'tbbutton',
				text: '<?php __('Add'); ?>',
				tooltip:'<?php __('<b>Add ImsSirv</b><br />Click here to create a new ImsSirv'); ?>',
				icon: 'img/table_add.png',
				cls: 'x-btn-text-icon',
				handler: function(btn) {
					AddParentImsSirv();
				}
			}, ' ', '-', ' ', {
				xtype: 'tbbutton',
				text: '<?php __('Edit'); ?>',
				id: 'edit-parent-imsSirv',
				tooltip:'<?php __('<b>Edit ImsSirv</b><br />Click here to modify the selected ImsSirv'); ?>',
				icon: 'img/table_edit.png',
				cls: 'x-btn-text-icon',
				disabled: true,
				handler: function(btn) {
					var sm = g.getSelectionModel();
					var sel = sm.getSelected();
					if (sm.hasSelection()){
						EditParentImsSirv(sel.data.id);
					};
				}
			}, ' ', '-', ' ', {
				xtype: 'tbbutton',
				text: '<?php __('Delete'); ?>',
				id: 'delete-parent-imsSirv',
				tooltip:'<?php __('<b>Delete ImsSirv(s)</b><br />Click here to remove the selected ImsSirv(s)'); ?>',
				icon: 'img/table_delete.png',
				cls: 'x-btn-text-icon',
				disabled: true,
				handler: function(btn) {
					var sm = g.getSelectionModel();
					var sel = sm.getSelections();
					if (sm.hasSelection()){
						if(sel.length==1){
							Ext.Msg.show({
									title: '<?php __('Remove ImsSirv'); ?>',
									buttons: Ext.MessageBox.YESNOCANCEL,
									msg: '<?php __('Remove'); ?> '+sel[0].data.name+'?',
									icon: Ext.MessageBox.QUESTION,
                                    fn: function(btn){
											if (btn == 'yes'){
													DeleteParentImsSirv(sel[0].data.id);
											}
									}
							});
						} else {
							Ext.Msg.show({
									title: '<?php __('Remove ImsSirv'); ?>',
									buttons: Ext.MessageBox.YESNOCANCEL,
									msg: '<?php __('Remove the selected ImsSirv'); ?>?',
									icon: Ext.MessageBox.QUESTION,
                                    fn: function(btn){
											if (btn == 'yes'){
													var sel_ids = '';
													for(i=0;i<sel.length;i++){
														if(i>0)
															sel_ids += '_';
														sel_ids += sel[i].data.id;
													}
													DeleteParentImsSirv(sel_ids);
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
				text: '<?php __('View ImsSirv'); ?>',
				id: 'view-imsSirv2',
				tooltip:'<?php __('<b>View ImsSirv</b><br />Click here to see details of the selected ImsSirv'); ?>',
				icon: 'img/table_view.png',
				cls: 'x-btn-text-icon',
				disabled: true,
				handler: function(btn) {
					var sm = g.getSelectionModel();
					var sel = sm.getSelected();
					if (sm.hasSelection()){
						ViewImsSirv(sel.data.id);
					};
				},
				menu : {
					items: [
 {
						text: '<?php __('View Ims Sirv Items'); ?>',
                        icon: 'img/table_view.png',
						cls: 'x-btn-text-icon',
						handler: function(btn) {
							var sm = g.getSelectionModel();
							var sel = sm.getSelected();
							if (sm.hasSelection()){
								ViewImsSirvImsSirvItems(sel.data.id);
							};
						}
					}
					]
				}

            }, ' ', '->', {
				xtype: 'textfield',
				emptyText: '<?php __('[Search By Name]'); ?>',
				id: 'parent_imsSirv_search_field',
				listeners: {
					specialkey: function(field, e){
						if (e.getKey() == e.ENTER) {
							SearchByParentImsSirvName(Ext.getCmp('parent_imsSirv_search_field').getValue());
						}
					}

				}
			}, {
				xtype: 'tbbutton',
				icon: 'img/search.png',
				cls: 'x-btn-text-icon',
				text: 'GO',
				tooltip:'<?php __('<b>GO</b><br />Click here to get search results'); ?>',
				id: 'parent_imsSirv_go_button',
				handler: function(){
					SearchByParentImsSirvName(Ext.getCmp('parent_imsSirv_search_field').getValue());
				}
			}, ' '
	]}),
	bbar: new Ext.PagingToolbar({
		pageSize: list_size,
		store: store_parent_imsSirvs,
		displayInfo: true,
		displayMsg: '<?php __('Displaying {0} - {1} of {2}'); ?>',
		beforePageText: '<?php __('Page'); ?>',
		afterPageText: '<?php __('of {0}'); ?>',
		emptyMsg: '<?php __('No data to display'); ?>'
	})
});
g.getSelectionModel().on('rowselect', function(sm, rowIdx, r) {
	g.getTopToolbar().findById('edit-parent-imsSirv').enable();
	g.getTopToolbar().findById('delete-parent-imsSirv').enable();
        g.getTopToolbar().findById('view-imsSirv2').enable();
	if(this.getSelections().length > 1){
		g.getTopToolbar().findById('edit-parent-imsSirv').disable();
                g.getTopToolbar().findById('view-imsSirv2').disable();
	}
});
g.getSelectionModel().on('rowdeselect', function(sm, rowIdx, r) {
	if(this.getSelections().length > 1){
		g.getTopToolbar().findById('edit-parent-imsSirv').disable();
		g.getTopToolbar().findById('delete-parent-imsSirv').enable();
                g.getTopToolbar().findById('view-imsSirv2').disable();
	}
	else if(this.getSelections().length == 1){
		g.getTopToolbar().findById('edit-parent-imsSirv').enable();
		g.getTopToolbar().findById('delete-parent-imsSirv').enable();
                g.getTopToolbar().findById('view-imsSirv2').enable();
	}
	else{
		g.getTopToolbar().findById('edit-parent-imsSirv').disable();
		g.getTopToolbar().findById('delete-parent-imsSirv').disable();
                g.getTopToolbar().findById('view-imsSirv2').disable();
	}
});



var parentImsSirvsViewWindow = new Ext.Window({
	title: 'ImsSirv Under the selected Item',
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
			parentImsSirvsViewWindow.close();
		}
	}]
});

store_parent_imsSirvs.load({
    params: {
        start: 0,    
        limit: list_size
    }
});