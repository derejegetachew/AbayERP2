//<script>
var store_parent_imsRequisitionItems = new Ext.data.Store({
	reader: new Ext.data.JsonReader({
		root:'rows',
		totalProperty: 'results',
		fields: [
			'id','ims_requisition','ims_item','itemcode','quantity','measurement','remark','budget','created','modified'	
		]
	}),
	proxy: new Ext.data.HttpProxy({
		url: '<?php echo $this->Html->url(array('controller' => 'imsRequisitionItems', 'action' => 'list_data', $parent_id)); ?>'	})
});


function AddParentImsRequisitionItem() {
	Ext.Ajax.request({
		url: '<?php echo $this->Html->url(array('controller' => 'imsRequisitionItems', 'action' => 'add', $parent_id)); ?>',
		success: function(response, opts) {
			var parent_imsRequisitionItem_data = response.responseText;
			
			eval(parent_imsRequisitionItem_data);
			
			ImsRequisitionItemAddWindow.show();
		},
		failure: function(response, opts) {
			Ext.Msg.alert('<?php __('Error'); ?>', '<?php __('Cannot get the imsRequisitionItem add form. Error code'); ?>: ' + response.status);
		}
	});
}

function EditParentImsRequisitionItem(id) {
	Ext.Ajax.request({
		url: '<?php echo $this->Html->url(array('controller' => 'imsRequisitionItems', 'action' => 'edit')); ?>/'+id+'/<?php echo $parent_id; ?>',
		success: function(response, opts) {
			var parent_imsRequisitionItem_data = response.responseText;
			
			eval(parent_imsRequisitionItem_data);
			
			ImsRequisitionItemEditWindow.show();
		},
		failure: function(response, opts) {
			Ext.Msg.alert('<?php __('Error'); ?>', '<?php __('Cannot get the imsRequisitionItem edit form. Error code'); ?>: ' + response.status);
		}
	});
}

function ViewImsRequisitionItem(id) {
	Ext.Ajax.request({
		url: '<?php echo $this->Html->url(array('controller' => 'imsRequisitionItems', 'action' => 'view')); ?>/'+id,
		success: function(response, opts) {
			var imsRequisitionItem_data = response.responseText;

			eval(imsRequisitionItem_data);

			ImsRequisitionItemViewWindow.show();
		},
		failure: function(response, opts) {
			Ext.Msg.alert('<?php __('Error'); ?>', '<?php __('Cannot get the imsRequisitionItem view form. Error code'); ?>: ' + response.status);
		}
	});
}


function DeleteParentImsRequisitionItem(id) {
	Ext.Ajax.request({
		url: '<?php echo $this->Html->url(array('controller' => 'imsRequisitionItems', 'action' => 'delete')); ?>/'+id,
		success: function(response, opts) {
			Ext.Msg.alert('<?php __('Success'); ?>', '<?php __('ImsRequisitionItem(s) successfully deleted!'); ?>');
			RefreshParentImsRequisitionItemData();
		},
		failure: function(response, opts) {
			Ext.Msg.alert('<?php __('Error'); ?>', '<?php __('Cannot get the imsRequisitionItem to be deleted. Error code'); ?>: ' + response.status);
		}
	});
}

function SearchByParentImsRequisitionItemName(value){
	var conditions = '\'ImsRequisitionItem.name LIKE\' => \'%' + value + '%\'';
	store_parent_imsRequisitionItems.reload({
		 params: {
			start: 0,
			limit: list_size,
			conditions: conditions
	    }
	});
}

function RefreshParentImsRequisitionItemData() {
	store_parent_imsRequisitionItems.reload();
}



var g = new Ext.grid.GridPanel({
	title: '<?php __('Requisition Items'); ?>',
	store: store_parent_imsRequisitionItems,
	loadMask: true,
	stripeRows: true,
	height: 300,
	anchor: '100%',
    id: 'imsRequisitionItemGrid',
	columns: [
		{header:"<?php __('Requisition'); ?>", dataIndex: 'ims_requisition', sortable: true,hidden:true},
		{header:"<?php __('Item'); ?>", dataIndex: 'ims_item', sortable: true},
		{header:"<?php __('Code'); ?>", dataIndex: 'itemcode', sortable: true},
		{header: "<?php __('Quantity'); ?>", dataIndex: 'quantity', sortable: true},
		{header: "<?php __('Measurement'); ?>", dataIndex: 'measurement', sortable: true},
		{header: "<?php __('Remark'); ?>", dataIndex: 'remark', sortable: true},
		{header: "<?php __('Budget'); ?>", dataIndex: 'budget', sortable: true},
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
            ViewImsRequisitionItem(Ext.getCmp('imsRequisitionItemGrid').getSelectionModel().getSelected().data.id);
        }
    },
	tbar: new Ext.Toolbar({
		items: [{
				xtype: 'tbbutton',
				text: '<?php __('Add'); ?>',
				tooltip:'<?php __('<b>Add Requisition Item</b><br />Click here to create a new Requisition Item'); ?>',
				icon: 'img/table_add.png',
				cls: 'x-btn-text-icon',
				handler: function(btn) {
					AddParentImsRequisitionItem();
				}
			}, ' ', '-', ' ', {
				xtype: 'tbbutton',
				text: '<?php __('Edit'); ?>',
				id: 'edit-parent-imsRequisitionItem',
				tooltip:'<?php __('<b>Edit Requisition Item</b><br />Click here to modify the selected Requisition Item'); ?>',
				icon: 'img/table_edit.png',
				cls: 'x-btn-text-icon',
				disabled: true,
				handler: function(btn) {
					var sm = g.getSelectionModel();
					var sel = sm.getSelected();
					if (sm.hasSelection()){
						EditParentImsRequisitionItem(sel.data.id);
					};
				}
			}, ' ', '-', ' ', {
				xtype: 'tbbutton',
				text: '<?php __('Delete'); ?>',
				id: 'delete-parent-imsRequisitionItem',
				tooltip:'<?php __('<b>Delete Requisition Item(s)</b><br />Click here to remove the selected Requisition Item(s)'); ?>',
				icon: 'img/table_delete.png',
				cls: 'x-btn-text-icon',
				disabled: true,
				handler: function(btn) {
					var sm = g.getSelectionModel();
					var sel = sm.getSelections();
					if (sm.hasSelection()){
						if(sel.length==1){
							Ext.Msg.show({
									title: '<?php __('Remove Requisition Item'); ?>',
									buttons: Ext.MessageBox.YESNOCANCEL,
									msg: '<?php __('Remove'); ?> '+sel[0].data.name+'?',
									icon: Ext.MessageBox.QUESTION,
                                    fn: function(btn){
											if (btn == 'yes'){
													DeleteParentImsRequisitionItem(sel[0].data.id);
											}
									}
							});
						} else {
							Ext.Msg.show({
									title: '<?php __('Remove Requisition Item'); ?>',
									buttons: Ext.MessageBox.YESNOCANCEL,
									msg: '<?php __('Remove the selected Requisition Item'); ?>?',
									icon: Ext.MessageBox.QUESTION,
                                    fn: function(btn){
											if (btn == 'yes'){
													var sel_ids = '';
													for(i=0;i<sel.length;i++){
														if(i>0)
															sel_ids += '_';
														sel_ids += sel[i].data.id;
													}
													DeleteParentImsRequisitionItem(sel_ids);
											}
									}
							});
						}
					} else {
						Ext.Msg.alert('<?php __('Warning'); ?>', '<?php __('Please select a record first'); ?>');
					};
				}
			}, ' ','-',' ', {
				xtype: 'tbbutton',
				text: '<?php __('View Requisition Item'); ?>',
				id: 'view-imsRequisitionItem2',
				tooltip:'<?php __('<b>View Requisition Item</b><br />Click here to see details of the selected Requisition Item'); ?>',
				icon: 'img/table_view.png',
				cls: 'x-btn-text-icon',
				disabled: true,
				handler: function(btn) {
					var sm = g.getSelectionModel();
					var sel = sm.getSelected();
					if (sm.hasSelection()){
						ViewImsRequisitionItem(sel.data.id);
					};
				}

            }, ' ', '->', {
				xtype: 'textfield',
				emptyText: '<?php __('[Search By Name]'); ?>',
				id: 'parent_imsRequisitionItem_search_field',
				listeners: {
					specialkey: function(field, e){
						if (e.getKey() == e.ENTER) {
							SearchByParentImsRequisitionItemName(Ext.getCmp('parent_imsRequisitionItem_search_field').getValue());
						}
					}

				}
			}, {
				xtype: 'tbbutton',
				icon: 'img/search.png',
				cls: 'x-btn-text-icon',
				text: 'GO',
				tooltip:'<?php __('<b>GO</b><br />Click here to get search results'); ?>',
				id: 'parent_imsRequisitionItem_go_button',
				handler: function(){
					SearchByParentImsRequisitionItemName(Ext.getCmp('parent_imsRequisitionItem_search_field').getValue());
				}
			}, ' '
	]}),
	bbar: new Ext.PagingToolbar({
		pageSize: list_size,
		store: store_parent_imsRequisitionItems,
		displayInfo: true,
		displayMsg: '<?php __('Displaying {0} - {1} of {2}'); ?>',
		beforePageText: '<?php __('Page'); ?>',
		afterPageText: '<?php __('of {0}'); ?>',
		emptyMsg: '<?php __('No data to display'); ?>'
	})
});
g.getSelectionModel().on('rowselect', function(sm, rowIdx, r) {
	g.getTopToolbar().findById('edit-parent-imsRequisitionItem').enable();
	g.getTopToolbar().findById('delete-parent-imsRequisitionItem').enable();
        g.getTopToolbar().findById('view-imsRequisitionItem2').enable();
	if(this.getSelections().length > 1){
		g.getTopToolbar().findById('edit-parent-imsRequisitionItem').disable();
                g.getTopToolbar().findById('view-imsRequisitionItem2').disable();
	}
});
g.getSelectionModel().on('rowdeselect', function(sm, rowIdx, r) {
	if(this.getSelections().length > 1){
		g.getTopToolbar().findById('edit-parent-imsRequisitionItem').disable();
		g.getTopToolbar().findById('delete-parent-imsRequisitionItem').enable();
                g.getTopToolbar().findById('view-imsRequisitionItem2').disable();
	}
	else if(this.getSelections().length == 1){
		g.getTopToolbar().findById('edit-parent-imsRequisitionItem').enable();
		g.getTopToolbar().findById('delete-parent-imsRequisitionItem').enable();
                g.getTopToolbar().findById('view-imsRequisitionItem2').enable();
	}
	else{
		g.getTopToolbar().findById('edit-parent-imsRequisitionItem').disable();
		g.getTopToolbar().findById('delete-parent-imsRequisitionItem').disable();
                g.getTopToolbar().findById('view-imsRequisitionItem2').disable();
	}
});



var parentImsRequisitionItemsViewWindow = new Ext.Window({
	title: 'Requisition Item Under the selected Item',
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
			parentImsRequisitionItemsViewWindow.close();
		}
	}]
});

store_parent_imsRequisitionItems.load({
    params: {
        start: 0,    
        limit: list_size
    }
});