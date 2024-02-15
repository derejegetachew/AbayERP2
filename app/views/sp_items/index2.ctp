var store_parent_spItems = new Ext.data.Store({
	reader: new Ext.data.JsonReader({
		root:'rows',
		totalProperty: 'results',
		fields: [
			'id','name','desc','price','um','sp_item_group','created','modified'	
		]
	}),
	proxy: new Ext.data.HttpProxy({
		url: '<?php echo $this->Html->url(array('controller' => 'spItems', 'action' => 'list_data', $parent_id)); ?>'	})
});


function AddParentSpItem() {
	Ext.Ajax.request({
		url: '<?php echo $this->Html->url(array('controller' => 'spItems', 'action' => 'add', $parent_id)); ?>',
		success: function(response, opts) {
			var parent_spItem_data = response.responseText;
			
			eval(parent_spItem_data);
			
			SpItemAddWindow.show();
		},
		failure: function(response, opts) {
			Ext.Msg.alert('<?php __('Error'); ?>', '<?php __('Cannot get the spItem add form. Error code'); ?>: ' + response.status);
		}
	});
}

function EditParentSpItem(id) {
	Ext.Ajax.request({
		url: '<?php echo $this->Html->url(array('controller' => 'spItems', 'action' => 'edit')); ?>/'+id+'/<?php echo $parent_id; ?>',
		success: function(response, opts) {
			var parent_spItem_data = response.responseText;
			
			eval(parent_spItem_data);
			
			SpItemEditWindow.show();
		},
		failure: function(response, opts) {
			Ext.Msg.alert('<?php __('Error'); ?>', '<?php __('Cannot get the spItem edit form. Error code'); ?>: ' + response.status);
		}
	});
}

function ViewSpItem(id) {
	Ext.Ajax.request({
		url: '<?php echo $this->Html->url(array('controller' => 'spItems', 'action' => 'view')); ?>/'+id,
		success: function(response, opts) {
			var spItem_data = response.responseText;

			eval(spItem_data);

			SpItemViewWindow.show();
		},
		failure: function(response, opts) {
			Ext.Msg.alert('<?php __('Error'); ?>', '<?php __('Cannot get the spItem view form. Error code'); ?>: ' + response.status);
		}
	});
}


function DeleteParentSpItem(id) {
	Ext.Ajax.request({
		url: '<?php echo $this->Html->url(array('controller' => 'spItems', 'action' => 'delete')); ?>/'+id,
		success: function(response, opts) {
			Ext.Msg.alert('<?php __('Success'); ?>', '<?php __('SpItem(s) successfully deleted!'); ?>');
			RefreshParentSpItemData();
		},
		failure: function(response, opts) {
			Ext.Msg.alert('<?php __('Error'); ?>', '<?php __('Cannot get the spItem to be deleted. Error code'); ?>: ' + response.status);
		}
	});
}

function SearchByParentSpItemName(value){
	var conditions = '\'SpItem.name LIKE\' => \'%' + value + '%\'';
	store_parent_spItems.reload({
		 params: {
			start: 0,
			limit: list_size,
			conditions: conditions
	    }
	});
}

function RefreshParentSpItemData() {
	store_parent_spItems.reload();
}



var g = new Ext.grid.GridPanel({
	title: '<?php __('SpItems'); ?>',
	store: store_parent_spItems,
	loadMask: true,
	stripeRows: true,
	height: 300,
	anchor: '100%',
    id: 'spItemGrid',
	columns: [
		{header: "<?php __('Name'); ?>", dataIndex: 'name', sortable: true},
		{header: "<?php __('Desc'); ?>", dataIndex: 'desc', sortable: true},
		{header: "<?php __('Price'); ?>", dataIndex: 'price', sortable: true},
		{header: "<?php __('Um'); ?>", dataIndex: 'um', sortable: true},
		{header:"<?php __('sp_item_group'); ?>", dataIndex: 'sp_item_group', sortable: true},
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
            ViewSpItem(Ext.getCmp('spItemGrid').getSelectionModel().getSelected().data.id);
        }
    },
	tbar: new Ext.Toolbar({
		items: [{
				xtype: 'tbbutton',
				text: '<?php __('Add'); ?>',
				tooltip:'<?php __('<b>Add SpItem</b><br />Click here to create a new SpItem'); ?>',
				icon: 'img/table_add.png',
				cls: 'x-btn-text-icon',
				handler: function(btn) {
					AddParentSpItem();
				}
			}, ' ', '-', ' ', {
				xtype: 'tbbutton',
				text: '<?php __('Edit'); ?>',
				id: 'edit-parent-spItem',
				tooltip:'<?php __('<b>Edit SpItem</b><br />Click here to modify the selected SpItem'); ?>',
				icon: 'img/table_edit.png',
				cls: 'x-btn-text-icon',
				disabled: true,
				handler: function(btn) {
					var sm = g.getSelectionModel();
					var sel = sm.getSelected();
					if (sm.hasSelection()){
						EditParentSpItem(sel.data.id);
					};
				}
			}, ' ', '-', ' ', {
				xtype: 'tbbutton',
				text: '<?php __('Delete'); ?>',
				id: 'delete-parent-spItem',
				tooltip:'<?php __('<b>Delete SpItem(s)</b><br />Click here to remove the selected SpItem(s)'); ?>',
				icon: 'img/table_delete.png',
				cls: 'x-btn-text-icon',
				disabled: true,
				handler: function(btn) {
					var sm = g.getSelectionModel();
					var sel = sm.getSelections();
					if (sm.hasSelection()){
						if(sel.length==1){
							Ext.Msg.show({
									title: '<?php __('Remove SpItem'); ?>',
									buttons: Ext.MessageBox.YESNOCANCEL,
									msg: '<?php __('Remove'); ?> '+sel[0].data.name+'?',
									icon: Ext.MessageBox.QUESTION,
                                    fn: function(btn){
											if (btn == 'yes'){
													DeleteParentSpItem(sel[0].data.id);
											}
									}
							});
						} else {
							Ext.Msg.show({
									title: '<?php __('Remove SpItem'); ?>',
									buttons: Ext.MessageBox.YESNOCANCEL,
									msg: '<?php __('Remove the selected SpItem'); ?>?',
									icon: Ext.MessageBox.QUESTION,
                                    fn: function(btn){
											if (btn == 'yes'){
													var sel_ids = '';
													for(i=0;i<sel.length;i++){
														if(i>0)
															sel_ids += '_';
														sel_ids += sel[i].data.id;
													}
													DeleteParentSpItem(sel_ids);
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
				text: '<?php __('View SpItem'); ?>',
				id: 'view-spItem2',
				tooltip:'<?php __('<b>View SpItem</b><br />Click here to see details of the selected SpItem'); ?>',
				icon: 'img/table_view.png',
				cls: 'x-btn-text-icon',
				disabled: true,
				handler: function(btn) {
					var sm = g.getSelectionModel();
					var sel = sm.getSelected();
					if (sm.hasSelection()){
						ViewSpItem(sel.data.id);
					};
				},
				menu : {
					items: [
					]
				}

            }, ' ', '->', {
				xtype: 'textfield',
				emptyText: '<?php __('[Search By Name]'); ?>',
				id: 'parent_spItem_search_field',
				listeners: {
					specialkey: function(field, e){
						if (e.getKey() == e.ENTER) {
							SearchByParentSpItemName(Ext.getCmp('parent_spItem_search_field').getValue());
						}
					}

				}
			}, {
				xtype: 'tbbutton',
				icon: 'img/search.png',
				cls: 'x-btn-text-icon',
				text: 'GO',
				tooltip:'<?php __('<b>GO</b><br />Click here to get search results'); ?>',
				id: 'parent_spItem_go_button',
				handler: function(){
					SearchByParentSpItemName(Ext.getCmp('parent_spItem_search_field').getValue());
				}
			}, ' '
	]}),
	bbar: new Ext.PagingToolbar({
		pageSize: list_size,
		store: store_parent_spItems,
		displayInfo: true,
		displayMsg: '<?php __('Displaying {0} - {1} of {2}'); ?>',
		beforePageText: '<?php __('Page'); ?>',
		afterPageText: '<?php __('of {0}'); ?>',
		emptyMsg: '<?php __('No data to display'); ?>'
	})
});
g.getSelectionModel().on('rowselect', function(sm, rowIdx, r) {
	g.getTopToolbar().findById('edit-parent-spItem').enable();
	g.getTopToolbar().findById('delete-parent-spItem').enable();
        g.getTopToolbar().findById('view-spItem2').enable();
	if(this.getSelections().length > 1){
		g.getTopToolbar().findById('edit-parent-spItem').disable();
                g.getTopToolbar().findById('view-spItem2').disable();
	}
});
g.getSelectionModel().on('rowdeselect', function(sm, rowIdx, r) {
	if(this.getSelections().length > 1){
		g.getTopToolbar().findById('edit-parent-spItem').disable();
		g.getTopToolbar().findById('delete-parent-spItem').enable();
                g.getTopToolbar().findById('view-spItem2').disable();
	}
	else if(this.getSelections().length == 1){
		g.getTopToolbar().findById('edit-parent-spItem').enable();
		g.getTopToolbar().findById('delete-parent-spItem').enable();
                g.getTopToolbar().findById('view-spItem2').enable();
	}
	else{
		g.getTopToolbar().findById('edit-parent-spItem').disable();
		g.getTopToolbar().findById('delete-parent-spItem').disable();
                g.getTopToolbar().findById('view-spItem2').disable();
	}
});



var parentSpItemsViewWindow = new Ext.Window({
	title: 'SpItem Under the selected Item',
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
			parentSpItemsViewWindow.close();
		}
	}]
});

store_parent_spItems.load({
    params: {
        start: 0,    
        limit: list_size
    }
});