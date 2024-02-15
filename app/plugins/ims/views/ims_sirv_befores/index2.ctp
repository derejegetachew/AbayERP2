var store_parent_imsSirvBefores = new Ext.data.Store({
	reader: new Ext.data.JsonReader({
		root:'rows',
		totalProperty: 'results',
		fields: [
			'id','name','branch','created','modified'	
		]
	}),
	proxy: new Ext.data.HttpProxy({
		url: '<?php echo $this->Html->url(array('controller' => 'imsSirvBefores', 'action' => 'list_data', $parent_id)); ?>'	})
});


function AddParentImsSirvBefore() {
	Ext.Ajax.request({
		url: '<?php echo $this->Html->url(array('controller' => 'imsSirvBefores', 'action' => 'add', $parent_id)); ?>',
		success: function(response, opts) {
			var parent_imsSirvBefore_data = response.responseText;
			
			eval(parent_imsSirvBefore_data);
			
			ImsSirvBeforeAddWindow.show();
		},
		failure: function(response, opts) {
			Ext.Msg.alert('<?php __('Error'); ?>', '<?php __('Cannot get the imsSirvBefore add form. Error code'); ?>: ' + response.status);
		}
	});
}

function EditParentImsSirvBefore(id) {
	Ext.Ajax.request({
		url: '<?php echo $this->Html->url(array('controller' => 'imsSirvBefores', 'action' => 'edit')); ?>/'+id+'/<?php echo $parent_id; ?>',
		success: function(response, opts) {
			var parent_imsSirvBefore_data = response.responseText;
			
			eval(parent_imsSirvBefore_data);
			
			ImsSirvBeforeEditWindow.show();
		},
		failure: function(response, opts) {
			Ext.Msg.alert('<?php __('Error'); ?>', '<?php __('Cannot get the imsSirvBefore edit form. Error code'); ?>: ' + response.status);
		}
	});
}

function ViewImsSirvBefore(id) {
	Ext.Ajax.request({
		url: '<?php echo $this->Html->url(array('controller' => 'imsSirvBefores', 'action' => 'view')); ?>/'+id,
		success: function(response, opts) {
			var imsSirvBefore_data = response.responseText;

			eval(imsSirvBefore_data);

			ImsSirvBeforeViewWindow.show();
		},
		failure: function(response, opts) {
			Ext.Msg.alert('<?php __('Error'); ?>', '<?php __('Cannot get the imsSirvBefore view form. Error code'); ?>: ' + response.status);
		}
	});
}

function ViewImsSirvBeforeImsSirvItemBefores(id) {
	Ext.Ajax.request({
		url: '<?php echo $this->Html->url(array('controller' => 'imsSirvItemBefores', 'action' => 'index2')); ?>/'+id,
		success: function(response, opts) {
			var parent_imsSirvItemBefores_data = response.responseText;

			eval(parent_imsSirvItemBefores_data);

			parentImsSirvItemBeforesViewWindow.show();
		},
		failure: function(response, opts) {
			Ext.Msg.alert('<?php __('Error'); ?>', '<?php __('Cannot get the campus view form. Error code'); ?>: ' + response.status);
		}
	});
}


function DeleteParentImsSirvBefore(id) {
	Ext.Ajax.request({
		url: '<?php echo $this->Html->url(array('controller' => 'imsSirvBefores', 'action' => 'delete')); ?>/'+id,
		success: function(response, opts) {
			Ext.Msg.alert('<?php __('Success'); ?>', '<?php __('ImsSirvBefore(s) successfully deleted!'); ?>');
			RefreshParentImsSirvBeforeData();
		},
		failure: function(response, opts) {
			Ext.Msg.alert('<?php __('Error'); ?>', '<?php __('Cannot get the imsSirvBefore to be deleted. Error code'); ?>: ' + response.status);
		}
	});
}

function SearchByParentImsSirvBeforeName(value){
	var conditions = '\'ImsSirvBefore.name LIKE\' => \'%' + value + '%\'';
	store_parent_imsSirvBefores.reload({
		 params: {
			start: 0,
			limit: list_size,
			conditions: conditions
	    }
	});
}

function RefreshParentImsSirvBeforeData() {
	store_parent_imsSirvBefores.reload();
}



var g = new Ext.grid.GridPanel({
	title: '<?php __('ImsSirvBefores'); ?>',
	store: store_parent_imsSirvBefores,
	loadMask: true,
	stripeRows: true,
	height: 300,
	anchor: '100%',
    id: 'imsSirvBeforeGrid',
	columns: [
		{header: "<?php __('Name'); ?>", dataIndex: 'name', sortable: true},
		{header:"<?php __('branch'); ?>", dataIndex: 'branch', sortable: true},
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
            ViewImsSirvBefore(Ext.getCmp('imsSirvBeforeGrid').getSelectionModel().getSelected().data.id);
        }
    },
	tbar: new Ext.Toolbar({
		items: [{
				xtype: 'tbbutton',
				text: '<?php __('Add'); ?>',
				tooltip:'<?php __('<b>Add ImsSirvBefore</b><br />Click here to create a new ImsSirvBefore'); ?>',
				icon: 'img/table_add.png',
				cls: 'x-btn-text-icon',
				handler: function(btn) {
					AddParentImsSirvBefore();
				}
			}, ' ', '-', ' ', {
				xtype: 'tbbutton',
				text: '<?php __('Edit'); ?>',
				id: 'edit-parent-imsSirvBefore',
				tooltip:'<?php __('<b>Edit ImsSirvBefore</b><br />Click here to modify the selected ImsSirvBefore'); ?>',
				icon: 'img/table_edit.png',
				cls: 'x-btn-text-icon',
				disabled: true,
				handler: function(btn) {
					var sm = g.getSelectionModel();
					var sel = sm.getSelected();
					if (sm.hasSelection()){
						EditParentImsSirvBefore(sel.data.id);
					};
				}
			}, ' ', '-', ' ', {
				xtype: 'tbbutton',
				text: '<?php __('Delete'); ?>',
				id: 'delete-parent-imsSirvBefore',
				tooltip:'<?php __('<b>Delete ImsSirvBefore(s)</b><br />Click here to remove the selected ImsSirvBefore(s)'); ?>',
				icon: 'img/table_delete.png',
				cls: 'x-btn-text-icon',
				disabled: true,
				handler: function(btn) {
					var sm = g.getSelectionModel();
					var sel = sm.getSelections();
					if (sm.hasSelection()){
						if(sel.length==1){
							Ext.Msg.show({
									title: '<?php __('Remove ImsSirvBefore'); ?>',
									buttons: Ext.MessageBox.YESNOCANCEL,
									msg: '<?php __('Remove'); ?> '+sel[0].data.name+'?',
									icon: Ext.MessageBox.QUESTION,
                                    fn: function(btn){
											if (btn == 'yes'){
													DeleteParentImsSirvBefore(sel[0].data.id);
											}
									}
							});
						} else {
							Ext.Msg.show({
									title: '<?php __('Remove ImsSirvBefore'); ?>',
									buttons: Ext.MessageBox.YESNOCANCEL,
									msg: '<?php __('Remove the selected ImsSirvBefore'); ?>?',
									icon: Ext.MessageBox.QUESTION,
                                    fn: function(btn){
											if (btn == 'yes'){
													var sel_ids = '';
													for(i=0;i<sel.length;i++){
														if(i>0)
															sel_ids += '_';
														sel_ids += sel[i].data.id;
													}
													DeleteParentImsSirvBefore(sel_ids);
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
				text: '<?php __('View ImsSirvBefore'); ?>',
				id: 'view-imsSirvBefore2',
				tooltip:'<?php __('<b>View ImsSirvBefore</b><br />Click here to see details of the selected ImsSirvBefore'); ?>',
				icon: 'img/table_view.png',
				cls: 'x-btn-text-icon',
				disabled: true,
				handler: function(btn) {
					var sm = g.getSelectionModel();
					var sel = sm.getSelected();
					if (sm.hasSelection()){
						ViewImsSirvBefore(sel.data.id);
					};
				},
				menu : {
					items: [
 {
						text: '<?php __('View Ims Sirv Item Befores'); ?>',
                        icon: 'img/table_view.png',
						cls: 'x-btn-text-icon',
						handler: function(btn) {
							var sm = g.getSelectionModel();
							var sel = sm.getSelected();
							if (sm.hasSelection()){
								ViewImsSirvBeforeImsSirvItemBefores(sel.data.id);
							};
						}
					}
					]
				}

            }, ' ', '->', {
				xtype: 'textfield',
				emptyText: '<?php __('[Search By Name]'); ?>',
				id: 'parent_imsSirvBefore_search_field',
				listeners: {
					specialkey: function(field, e){
						if (e.getKey() == e.ENTER) {
							SearchByParentImsSirvBeforeName(Ext.getCmp('parent_imsSirvBefore_search_field').getValue());
						}
					}

				}
			}, {
				xtype: 'tbbutton',
				icon: 'img/search.png',
				cls: 'x-btn-text-icon',
				text: 'GO',
				tooltip:'<?php __('<b>GO</b><br />Click here to get search results'); ?>',
				id: 'parent_imsSirvBefore_go_button',
				handler: function(){
					SearchByParentImsSirvBeforeName(Ext.getCmp('parent_imsSirvBefore_search_field').getValue());
				}
			}, ' '
	]}),
	bbar: new Ext.PagingToolbar({
		pageSize: list_size,
		store: store_parent_imsSirvBefores,
		displayInfo: true,
		displayMsg: '<?php __('Displaying {0} - {1} of {2}'); ?>',
		beforePageText: '<?php __('Page'); ?>',
		afterPageText: '<?php __('of {0}'); ?>',
		emptyMsg: '<?php __('No data to display'); ?>'
	})
});
g.getSelectionModel().on('rowselect', function(sm, rowIdx, r) {
	g.getTopToolbar().findById('edit-parent-imsSirvBefore').enable();
	g.getTopToolbar().findById('delete-parent-imsSirvBefore').enable();
        g.getTopToolbar().findById('view-imsSirvBefore2').enable();
	if(this.getSelections().length > 1){
		g.getTopToolbar().findById('edit-parent-imsSirvBefore').disable();
                g.getTopToolbar().findById('view-imsSirvBefore2').disable();
	}
});
g.getSelectionModel().on('rowdeselect', function(sm, rowIdx, r) {
	if(this.getSelections().length > 1){
		g.getTopToolbar().findById('edit-parent-imsSirvBefore').disable();
		g.getTopToolbar().findById('delete-parent-imsSirvBefore').enable();
                g.getTopToolbar().findById('view-imsSirvBefore2').disable();
	}
	else if(this.getSelections().length == 1){
		g.getTopToolbar().findById('edit-parent-imsSirvBefore').enable();
		g.getTopToolbar().findById('delete-parent-imsSirvBefore').enable();
                g.getTopToolbar().findById('view-imsSirvBefore2').enable();
	}
	else{
		g.getTopToolbar().findById('edit-parent-imsSirvBefore').disable();
		g.getTopToolbar().findById('delete-parent-imsSirvBefore').disable();
                g.getTopToolbar().findById('view-imsSirvBefore2').disable();
	}
});



var parentImsSirvBeforesViewWindow = new Ext.Window({
	title: 'ImsSirvBefore Under the selected Item',
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
			parentImsSirvBeforesViewWindow.close();
		}
	}]
});

store_parent_imsSirvBefores.load({
    params: {
        start: 0,    
        limit: list_size
    }
});