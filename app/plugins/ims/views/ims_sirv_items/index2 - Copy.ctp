var store_parent_imsSirvItems = new Ext.data.Store({
	reader: new Ext.data.JsonReader({
		root:'rows',
		totalProperty: 'results',
		fields: [
			'id','ims_sirv','ims_item','measurement','quantity','unit_price','remark'	
		]
	}),
	proxy: new Ext.data.HttpProxy({
		url: '<?php echo $this->Html->url(array('controller' => 'imsSirvItems', 'action' => 'list_data', $parent_id)); ?>'	})
});


function AddParentImsSirvItem() {
	Ext.Ajax.request({
		url: '<?php echo $this->Html->url(array('controller' => 'imsSirvItems', 'action' => 'add', $parent_id)); ?>',
		success: function(response, opts) {
			var parent_imsSirvItem_data = response.responseText;
			
			eval(parent_imsSirvItem_data);
			
			ImsSirvItemAddWindow.show();
		},
		failure: function(response, opts) {
			Ext.Msg.alert('<?php __('Error'); ?>', '<?php __('Cannot get the imsSirvItem add form. Error code'); ?>: ' + response.status);
		}
	});
}

function EditParentImsSirvItem(id) {
	Ext.Ajax.request({
		url: '<?php echo $this->Html->url(array('controller' => 'imsSirvItems', 'action' => 'edit')); ?>/'+id+'/<?php echo $parent_id; ?>',
		success: function(response, opts) {
			var parent_imsSirvItem_data = response.responseText;
			
			eval(parent_imsSirvItem_data);
			
			ImsSirvItemEditWindow.show();
		},
		failure: function(response, opts) {
			Ext.Msg.alert('<?php __('Error'); ?>', '<?php __('Cannot get the imsSirvItem edit form. Error code'); ?>: ' + response.status);
		}
	});
}

function ViewImsSirvItem(id) {
	Ext.Ajax.request({
		url: '<?php echo $this->Html->url(array('controller' => 'imsSirvItems', 'action' => 'view')); ?>/'+id,
		success: function(response, opts) {
			var imsSirvItem_data = response.responseText;

			eval(imsSirvItem_data);

			ImsSirvItemViewWindow.show();
		},
		failure: function(response, opts) {
			Ext.Msg.alert('<?php __('Error'); ?>', '<?php __('Cannot get the imsSirvItem view form. Error code'); ?>: ' + response.status);
		}
	});
}


function DeleteParentImsSirvItem(id) {
	Ext.Ajax.request({
		url: '<?php echo $this->Html->url(array('controller' => 'imsSirvItems', 'action' => 'delete')); ?>/'+id,
		success: function(response, opts) {
			Ext.Msg.alert('<?php __('Success'); ?>', '<?php __('ImsSirvItem(s) successfully deleted!'); ?>');
			RefreshParentImsSirvItemData();
		},
		failure: function(response, opts) {
			Ext.Msg.alert('<?php __('Error'); ?>', '<?php __('Cannot get the imsSirvItem to be deleted. Error code'); ?>: ' + response.status);
		}
	});
}

function SearchByParentImsSirvItemName(value){
	var conditions = '\'ImsSirvItem.name LIKE\' => \'%' + value + '%\'';
	store_parent_imsSirvItems.reload({
		 params: {
			start: 0,
			limit: list_size,
			conditions: conditions
	    }
	});
}

function RefreshParentImsSirvItemData() {
	store_parent_imsSirvItems.reload();
}



var g = new Ext.grid.GridPanel({
	title: '<?php __('ImsSirvItems'); ?>',
	store: store_parent_imsSirvItems,
	loadMask: true,
	stripeRows: true,
	height: 300,
	anchor: '100%',
    id: 'imsSirvItemGrid',
	columns: [
		{header:"<?php __('ims_sirv'); ?>", dataIndex: 'ims_sirv', sortable: true},
		{header:"<?php __('ims_item'); ?>", dataIndex: 'ims_item', sortable: true},
		{header: "<?php __('Measurement'); ?>", dataIndex: 'measurement', sortable: true},
		{header: "<?php __('Quantity'); ?>", dataIndex: 'quantity', sortable: true},
		{header: "<?php __('Unit Price'); ?>", dataIndex: 'unit_price', sortable: true},
		{header: "<?php __('Remark'); ?>", dataIndex: 'remark', sortable: true}	],
	sm: new Ext.grid.RowSelectionModel({
		singleSelect: false
	}),
	viewConfig: {
		forceFit: true
	},
    listeners: {
        celldblclick: function(){
            ViewImsSirvItem(Ext.getCmp('imsSirvItemGrid').getSelectionModel().getSelected().data.id);
        }
    },
	tbar: new Ext.Toolbar({
		items: [{
				xtype: 'tbbutton',
				text: '<?php __('Add'); ?>',
				tooltip:'<?php __('<b>Add ImsSirvItem</b><br />Click here to create a new ImsSirvItem'); ?>',
				icon: 'img/table_add.png',
				cls: 'x-btn-text-icon',
				handler: function(btn) {
					AddParentImsSirvItem();
				}
			}, ' ', '-', ' ', {
				xtype: 'tbbutton',
				text: '<?php __('Edit'); ?>',
				id: 'edit-parent-imsSirvItem',
				tooltip:'<?php __('<b>Edit ImsSirvItem</b><br />Click here to modify the selected ImsSirvItem'); ?>',
				icon: 'img/table_edit.png',
				cls: 'x-btn-text-icon',
				disabled: true,
				handler: function(btn) {
					var sm = g.getSelectionModel();
					var sel = sm.getSelected();
					if (sm.hasSelection()){
						EditParentImsSirvItem(sel.data.id);
					};
				}
			}, ' ', '-', ' ', {
				xtype: 'tbbutton',
				text: '<?php __('Delete'); ?>',
				id: 'delete-parent-imsSirvItem',
				tooltip:'<?php __('<b>Delete ImsSirvItem(s)</b><br />Click here to remove the selected ImsSirvItem(s)'); ?>',
				icon: 'img/table_delete.png',
				cls: 'x-btn-text-icon',
				disabled: true,
				handler: function(btn) {
					var sm = g.getSelectionModel();
					var sel = sm.getSelections();
					if (sm.hasSelection()){
						if(sel.length==1){
							Ext.Msg.show({
									title: '<?php __('Remove ImsSirvItem'); ?>',
									buttons: Ext.MessageBox.YESNOCANCEL,
									msg: '<?php __('Remove'); ?> '+sel[0].data.name+'?',
									icon: Ext.MessageBox.QUESTION,
                                    fn: function(btn){
											if (btn == 'yes'){
													DeleteParentImsSirvItem(sel[0].data.id);
											}
									}
							});
						} else {
							Ext.Msg.show({
									title: '<?php __('Remove ImsSirvItem'); ?>',
									buttons: Ext.MessageBox.YESNOCANCEL,
									msg: '<?php __('Remove the selected ImsSirvItem'); ?>?',
									icon: Ext.MessageBox.QUESTION,
                                    fn: function(btn){
											if (btn == 'yes'){
													var sel_ids = '';
													for(i=0;i<sel.length;i++){
														if(i>0)
															sel_ids += '_';
														sel_ids += sel[i].data.id;
													}
													DeleteParentImsSirvItem(sel_ids);
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
				text: '<?php __('View ImsSirvItem'); ?>',
				id: 'view-imsSirvItem2',
				tooltip:'<?php __('<b>View ImsSirvItem</b><br />Click here to see details of the selected ImsSirvItem'); ?>',
				icon: 'img/table_view.png',
				cls: 'x-btn-text-icon',
				disabled: true,
				handler: function(btn) {
					var sm = g.getSelectionModel();
					var sel = sm.getSelected();
					if (sm.hasSelection()){
						ViewImsSirvItem(sel.data.id);
					};
				},
				menu : {
					items: [
					]
				}

            }, ' ', '->', {
				xtype: 'textfield',
				emptyText: '<?php __('[Search By Name]'); ?>',
				id: 'parent_imsSirvItem_search_field',
				listeners: {
					specialkey: function(field, e){
						if (e.getKey() == e.ENTER) {
							SearchByParentImsSirvItemName(Ext.getCmp('parent_imsSirvItem_search_field').getValue());
						}
					}

				}
			}, {
				xtype: 'tbbutton',
				icon: 'img/search.png',
				cls: 'x-btn-text-icon',
				text: 'GO',
				tooltip:'<?php __('<b>GO</b><br />Click here to get search results'); ?>',
				id: 'parent_imsSirvItem_go_button',
				handler: function(){
					SearchByParentImsSirvItemName(Ext.getCmp('parent_imsSirvItem_search_field').getValue());
				}
			}, ' '
	]}),
	bbar: new Ext.PagingToolbar({
		pageSize: list_size,
		store: store_parent_imsSirvItems,
		displayInfo: true,
		displayMsg: '<?php __('Displaying {0} - {1} of {2}'); ?>',
		beforePageText: '<?php __('Page'); ?>',
		afterPageText: '<?php __('of {0}'); ?>',
		emptyMsg: '<?php __('No data to display'); ?>'
	})
});
g.getSelectionModel().on('rowselect', function(sm, rowIdx, r) {
	g.getTopToolbar().findById('edit-parent-imsSirvItem').enable();
	g.getTopToolbar().findById('delete-parent-imsSirvItem').enable();
        g.getTopToolbar().findById('view-imsSirvItem2').enable();
	if(this.getSelections().length > 1){
		g.getTopToolbar().findById('edit-parent-imsSirvItem').disable();
                g.getTopToolbar().findById('view-imsSirvItem2').disable();
	}
});
g.getSelectionModel().on('rowdeselect', function(sm, rowIdx, r) {
	if(this.getSelections().length > 1){
		g.getTopToolbar().findById('edit-parent-imsSirvItem').disable();
		g.getTopToolbar().findById('delete-parent-imsSirvItem').enable();
                g.getTopToolbar().findById('view-imsSirvItem2').disable();
	}
	else if(this.getSelections().length == 1){
		g.getTopToolbar().findById('edit-parent-imsSirvItem').enable();
		g.getTopToolbar().findById('delete-parent-imsSirvItem').enable();
                g.getTopToolbar().findById('view-imsSirvItem2').enable();
	}
	else{
		g.getTopToolbar().findById('edit-parent-imsSirvItem').disable();
		g.getTopToolbar().findById('delete-parent-imsSirvItem').disable();
                g.getTopToolbar().findById('view-imsSirvItem2').disable();
	}
});



var parentImsSirvItemsViewWindow = new Ext.Window({
	title: 'ImsSirvItem Under the selected Item',
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
			parentImsSirvItemsViewWindow.close();
		}
	}]
});

store_parent_imsSirvItems.load({
    params: {
        start: 0,    
        limit: list_size
    }
});