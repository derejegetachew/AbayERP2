//<script>
var store_parent_imsTransferStoreItemDetails = new Ext.data.Store({
	reader: new Ext.data.JsonReader({
		root:'rows',
		totalProperty: 'results',
		fields: [
			'id','ims_transfer_store_item','ims_item','quantity','measurement','remark','created','modified'	
		]
	}),
	proxy: new Ext.data.HttpProxy({
		url: '<?php echo $this->Html->url(array('controller' => 'imsTransferStoreItemDetails', 'action' => 'list_data', $parent_id)); ?>'	})
});


function AddParentImsTransferStoreItemDetail() {
	Ext.Ajax.request({
		url: '<?php echo $this->Html->url(array('controller' => 'imsTransferStoreItemDetails', 'action' => 'add', $parent_id)); ?>',
		success: function(response, opts) {
			var parent_imsTransferStoreItemDetail_data = response.responseText;
			
			eval(parent_imsTransferStoreItemDetail_data);
			
			ImsTransferStoreItemDetailAddWindow.show();
		},
		failure: function(response, opts) {
			Ext.Msg.alert('<?php __('Error'); ?>', '<?php __('Cannot get the imsTransferStoreItemDetail add form. Error code'); ?>: ' + response.status);
		}
	});
}

function EditParentImsTransferStoreItemDetail(id) {
	Ext.Ajax.request({
		url: '<?php echo $this->Html->url(array('controller' => 'imsTransferStoreItemDetails', 'action' => 'edit')); ?>/'+id+'/<?php echo $parent_id; ?>',
		success: function(response, opts) {
			var parent_imsTransferStoreItemDetail_data = response.responseText;
			
			eval(parent_imsTransferStoreItemDetail_data);
			
			ImsTransferStoreItemDetailEditWindow.show();
		},
		failure: function(response, opts) {
			Ext.Msg.alert('<?php __('Error'); ?>', '<?php __('Cannot get the imsTransferStoreItemDetail edit form. Error code'); ?>: ' + response.status);
		}
	});
}

function ViewImsTransferStoreItemDetail(id) {
	Ext.Ajax.request({
		url: '<?php echo $this->Html->url(array('controller' => 'imsTransferStoreItemDetails', 'action' => 'view')); ?>/'+id,
		success: function(response, opts) {
			var imsTransferStoreItemDetail_data = response.responseText;

			eval(imsTransferStoreItemDetail_data);

			ImsTransferStoreItemDetailViewWindow.show();
		},
		failure: function(response, opts) {
			Ext.Msg.alert('<?php __('Error'); ?>', '<?php __('Cannot get the imsTransferStoreItemDetail view form. Error code'); ?>: ' + response.status);
		}
	});
}


function DeleteParentImsTransferStoreItemDetail(id) {
	Ext.Ajax.request({
		url: '<?php echo $this->Html->url(array('controller' => 'imsTransferStoreItemDetails', 'action' => 'delete')); ?>/'+id,
		success: function(response, opts) {
			Ext.Msg.alert('<?php __('Success'); ?>', '<?php __('ImsTransferStoreItemDetail(s) successfully deleted!'); ?>');
			RefreshParentImsTransferStoreItemDetailData();
		},
		failure: function(response, opts) {
			Ext.Msg.alert('<?php __('Error'); ?>', '<?php __('Cannot get the imsTransferStoreItemDetail to be deleted. Error code'); ?>: ' + response.status);
		}
	});
}

function SearchByParentImsTransferStoreItemDetailName(value){
	var conditions = '\'ImsTransferStoreItemDetail.name LIKE\' => \'%' + value + '%\'';
	store_parent_imsTransferStoreItemDetails.reload({
		 params: {
			start: 0,
			limit: list_size,
			conditions: conditions
	    }
	});
}

function RefreshParentImsTransferStoreItemDetailData() {
	store_parent_imsTransferStoreItemDetails.reload();
}



var g = new Ext.grid.GridPanel({
	title: '<?php __('Transfer Store Item Details'); ?>',
	store: store_parent_imsTransferStoreItemDetails,
	loadMask: true,
	stripeRows: true,
	height: 300,
	anchor: '100%',
    id: 'imsTransferStoreItemDetailGrid',
	columns: [
		{header:"<?php __('Transfer Store Item'); ?>", dataIndex: 'ims_transfer_store_item', sortable: true,hidden:true},
		{header:"<?php __('Item'); ?>", dataIndex: 'ims_item', sortable: true},
		{header: "<?php __('Quantity'); ?>", dataIndex: 'quantity', sortable: true},
		{header: "<?php __('Measurement'); ?>", dataIndex: 'measurement', sortable: true},
		{header: "<?php __('Remark'); ?>", dataIndex: 'remark', sortable: true},
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
            ViewImsTransferStoreItemDetail(Ext.getCmp('imsTransferStoreItemDetailGrid').getSelectionModel().getSelected().data.id);
        }
    },
	tbar: new Ext.Toolbar({
		items: [{
				xtype: 'tbbutton',
				text: '<?php __('Add'); ?>',
				tooltip:'<?php __('<b>Add Transfer Store Item Detail</b><br />Click here to create a new Transfer Store Item Detail'); ?>',
				icon: 'img/table_add.png',
				cls: 'x-btn-text-icon',
				handler: function(btn) {
					AddParentImsTransferStoreItemDetail();
				}
			}, ' ', '-', ' ', {
				xtype: 'tbbutton',
				text: '<?php __('Edit'); ?>',
				id: 'edit-parent-imsTransferStoreItemDetail',
				tooltip:'<?php __('<b>Edit Transfer Store Item Detail</b><br />Click here to modify the selected Transfer Store Item Detail'); ?>',
				icon: 'img/table_edit.png',
				cls: 'x-btn-text-icon',
				disabled: true,
				handler: function(btn) {
					var sm = g.getSelectionModel();
					var sel = sm.getSelected();
					if (sm.hasSelection()){
						EditParentImsTransferStoreItemDetail(sel.data.id);
					};
				}
			}, ' ', '-', ' ', {
				xtype: 'tbbutton',
				text: '<?php __('Delete'); ?>',
				id: 'delete-parent-imsTransferStoreItemDetail',
				tooltip:'<?php __('<b>Delete Transfer Store Item Detail(s)</b><br />Click here to remove the selected Transfer Store Item Detail(s)'); ?>',
				icon: 'img/table_delete.png',
				cls: 'x-btn-text-icon',
				disabled: true,
				handler: function(btn) {
					var sm = g.getSelectionModel();
					var sel = sm.getSelections();
					if (sm.hasSelection()){
						if(sel.length==1){
							Ext.Msg.show({
									title: '<?php __('Remove Transfer Store Item Detail'); ?>',
									buttons: Ext.MessageBox.YESNOCANCEL,
									msg: '<?php __('Remove'); ?> '+sel[0].data.name+'?',
									icon: Ext.MessageBox.QUESTION,
                                    fn: function(btn){
											if (btn == 'yes'){
													DeleteParentImsTransferStoreItemDetail(sel[0].data.id);
											}
									}
							});
						} else {
							Ext.Msg.show({
									title: '<?php __('Remove Transfer Store Item Detail'); ?>',
									buttons: Ext.MessageBox.YESNOCANCEL,
									msg: '<?php __('Remove the selected Transfer Store Item Detail'); ?>?',
									icon: Ext.MessageBox.QUESTION,
                                    fn: function(btn){
											if (btn == 'yes'){
													var sel_ids = '';
													for(i=0;i<sel.length;i++){
														if(i>0)
															sel_ids += '_';
														sel_ids += sel[i].data.id;
													}
													DeleteParentImsTransferStoreItemDetail(sel_ids);
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
				text: '<?php __('View Transfer Store Item Detail'); ?>',
				id: 'view-imsTransferStoreItemDetail2',
				tooltip:'<?php __('<b>View Transfer Store Item Detail</b><br />Click here to see details of the selected Transfer Store Item Detail'); ?>',
				icon: 'img/table_view.png',
				cls: 'x-btn-text-icon',
				disabled: true,
				handler: function(btn) {
					var sm = g.getSelectionModel();
					var sel = sm.getSelected();
					if (sm.hasSelection()){
						ViewImsTransferStoreItemDetail(sel.data.id);
					};
				},
				menu : {
					items: [
					]
				}

            }, ' ', '->', {
				xtype: 'textfield',
				emptyText: '<?php __('[Search By Name]'); ?>',
				id: 'parent_imsTransferStoreItemDetail_search_field',
				listeners: {
					specialkey: function(field, e){
						if (e.getKey() == e.ENTER) {
							SearchByParentImsTransferStoreItemDetailName(Ext.getCmp('parent_imsTransferStoreItemDetail_search_field').getValue());
						}
					}

				}
			}, {
				xtype: 'tbbutton',
				icon: 'img/search.png',
				cls: 'x-btn-text-icon',
				text: 'GO',
				tooltip:'<?php __('<b>GO</b><br />Click here to get search results'); ?>',
				id: 'parent_imsTransferStoreItemDetail_go_button',
				handler: function(){
					SearchByParentImsTransferStoreItemDetailName(Ext.getCmp('parent_imsTransferStoreItemDetail_search_field').getValue());
				}
			}, ' '
	]}),
	bbar: new Ext.PagingToolbar({
		pageSize: list_size,
		store: store_parent_imsTransferStoreItemDetails,
		displayInfo: true,
		displayMsg: '<?php __('Displaying {0} - {1} of {2}'); ?>',
		beforePageText: '<?php __('Page'); ?>',
		afterPageText: '<?php __('of {0}'); ?>',
		emptyMsg: '<?php __('No data to display'); ?>'
	})
});
g.getSelectionModel().on('rowselect', function(sm, rowIdx, r) {
	g.getTopToolbar().findById('edit-parent-imsTransferStoreItemDetail').enable();
	g.getTopToolbar().findById('delete-parent-imsTransferStoreItemDetail').enable();
        g.getTopToolbar().findById('view-imsTransferStoreItemDetail2').enable();
	if(this.getSelections().length > 1){
		g.getTopToolbar().findById('edit-parent-imsTransferStoreItemDetail').disable();
                g.getTopToolbar().findById('view-imsTransferStoreItemDetail2').disable();
	}
});
g.getSelectionModel().on('rowdeselect', function(sm, rowIdx, r) {
	if(this.getSelections().length > 1){
		g.getTopToolbar().findById('edit-parent-imsTransferStoreItemDetail').disable();
		g.getTopToolbar().findById('delete-parent-imsTransferStoreItemDetail').enable();
                g.getTopToolbar().findById('view-imsTransferStoreItemDetail2').disable();
	}
	else if(this.getSelections().length == 1){
		g.getTopToolbar().findById('edit-parent-imsTransferStoreItemDetail').enable();
		g.getTopToolbar().findById('delete-parent-imsTransferStoreItemDetail').enable();
                g.getTopToolbar().findById('view-imsTransferStoreItemDetail2').enable();
	}
	else{
		g.getTopToolbar().findById('edit-parent-imsTransferStoreItemDetail').disable();
		g.getTopToolbar().findById('delete-parent-imsTransferStoreItemDetail').disable();
                g.getTopToolbar().findById('view-imsTransferStoreItemDetail2').disable();
	}
});



var parentImsTransferStoreItemDetailsViewWindow = new Ext.Window({
	title: 'Transfer Store Item Detail Under the selected Item',
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
			parentImsTransferStoreItemDetailsViewWindow.close();
		}
	}]
});

store_parent_imsTransferStoreItemDetails.load({
    params: {
        start: 0,    
        limit: list_size
    }
});