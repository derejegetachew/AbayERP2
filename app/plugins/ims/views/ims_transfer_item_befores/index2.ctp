var store_parent_imsTransferItemBefores = new Ext.data.Store({
	reader: new Ext.data.JsonReader({
		root:'rows',
		totalProperty: 'results',
		fields: [
			'id','ims_transfer_before','ims_sirv_item_before','ims_item','measurement','quantity','unit_price','tag','created','modified'	
		]
	}),
	proxy: new Ext.data.HttpProxy({
		url: '<?php echo $this->Html->url(array('controller' => 'imsTransferItemBefores', 'action' => 'list_data', $parent_id)); ?>'	})
});


function AddParentImsTransferItemBefore() {
	Ext.Ajax.request({
		url: '<?php echo $this->Html->url(array('controller' => 'imsTransferItemBefores', 'action' => 'add', $parent_id)); ?>',
		success: function(response, opts) {
			var parent_imsTransferItemBefore_data = response.responseText;
			
			eval(parent_imsTransferItemBefore_data);
			
			ImsTransferItemBeforeAddWindow.show();
		},
		failure: function(response, opts) {
			Ext.Msg.alert('<?php __('Error'); ?>', '<?php __('Cannot get the imsTransferItemBefore add form. Error code'); ?>: ' + response.status);
		}
	});
}

function EditParentImsTransferItemBefore(id) {
	Ext.Ajax.request({
		url: '<?php echo $this->Html->url(array('controller' => 'imsTransferItemBefores', 'action' => 'edit')); ?>/'+id+'/<?php echo $parent_id; ?>',
		success: function(response, opts) {
			var parent_imsTransferItemBefore_data = response.responseText;
			
			eval(parent_imsTransferItemBefore_data);
			
			ImsTransferItemBeforeEditWindow.show();
		},
		failure: function(response, opts) {
			Ext.Msg.alert('<?php __('Error'); ?>', '<?php __('Cannot get the imsTransferItemBefore edit form. Error code'); ?>: ' + response.status);
		}
	});
}

function ViewImsTransferItemBefore(id) {
	Ext.Ajax.request({
		url: '<?php echo $this->Html->url(array('controller' => 'imsTransferItemBefores', 'action' => 'view')); ?>/'+id,
		success: function(response, opts) {
			var imsTransferItemBefore_data = response.responseText;

			eval(imsTransferItemBefore_data);

			ImsTransferItemBeforeViewWindow.show();
		},
		failure: function(response, opts) {
			Ext.Msg.alert('<?php __('Error'); ?>', '<?php __('Cannot get the imsTransferItemBefore view form. Error code'); ?>: ' + response.status);
		}
	});
}


function DeleteParentImsTransferItemBefore(id) {
	Ext.Ajax.request({
		url: '<?php echo $this->Html->url(array('controller' => 'imsTransferItemBefores', 'action' => 'delete')); ?>/'+id,
		success: function(response, opts) {
			Ext.Msg.alert('<?php __('Success'); ?>', '<?php __('ImsTransferItemBefore(s) successfully deleted!'); ?>');
			RefreshParentImsTransferItemBeforeData();
		},
		failure: function(response, opts) {
			Ext.Msg.alert('<?php __('Error'); ?>', '<?php __('Cannot get the imsTransferItemBefore to be deleted. Error code'); ?>: ' + response.status);
		}
	});
}

function SearchByParentImsTransferItemBeforeName(value){
	var conditions = '\'ImsTransferItemBefore.name LIKE\' => \'%' + value + '%\'';
	store_parent_imsTransferItemBefores.reload({
		 params: {
			start: 0,
			limit: list_size,
			conditions: conditions
	    }
	});
}

function RefreshParentImsTransferItemBeforeData() {
	store_parent_imsTransferItemBefores.reload();
}



var g = new Ext.grid.GridPanel({
	title: '<?php __('ImsTransferItemBefores'); ?>',
	store: store_parent_imsTransferItemBefores,
	loadMask: true,
	stripeRows: true,
	height: 300,
	anchor: '100%',
    id: 'imsTransferItemBeforeGrid',
	columns: [
		{header:"<?php __('ims_transfer_before'); ?>", dataIndex: 'ims_transfer_before', sortable: true},
		{header:"<?php __('ims_sirv_item_before'); ?>", dataIndex: 'ims_sirv_item_before', sortable: true},
		{header:"<?php __('ims_item'); ?>", dataIndex: 'ims_item', sortable: true},
		{header: "<?php __('Measurement'); ?>", dataIndex: 'measurement', sortable: true},
		{header: "<?php __('Quantity'); ?>", dataIndex: 'quantity', sortable: true},
		{header: "<?php __('Unit Price'); ?>", dataIndex: 'unit_price', sortable: true},
		{header: "<?php __('Tag'); ?>", dataIndex: 'tag', sortable: true},
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
            ViewImsTransferItemBefore(Ext.getCmp('imsTransferItemBeforeGrid').getSelectionModel().getSelected().data.id);
        }
    },
	tbar: new Ext.Toolbar({
		items: [{
				xtype: 'tbbutton',
				text: '<?php __('Add'); ?>',
				tooltip:'<?php __('<b>Add ImsTransferItemBefore</b><br />Click here to create a new ImsTransferItemBefore'); ?>',
				icon: 'img/table_add.png',
				cls: 'x-btn-text-icon',
				handler: function(btn) {
					AddParentImsTransferItemBefore();
				}
			}, ' ', '-', ' ', {
				xtype: 'tbbutton',
				text: '<?php __('Edit'); ?>',
				id: 'edit-parent-imsTransferItemBefore',
				tooltip:'<?php __('<b>Edit ImsTransferItemBefore</b><br />Click here to modify the selected ImsTransferItemBefore'); ?>',
				icon: 'img/table_edit.png',
				cls: 'x-btn-text-icon',
				disabled: true,
				handler: function(btn) {
					var sm = g.getSelectionModel();
					var sel = sm.getSelected();
					if (sm.hasSelection()){
						EditParentImsTransferItemBefore(sel.data.id);
					};
				}
			}, ' ', '-', ' ', {
				xtype: 'tbbutton',
				text: '<?php __('Delete'); ?>',
				id: 'delete-parent-imsTransferItemBefore',
				tooltip:'<?php __('<b>Delete ImsTransferItemBefore(s)</b><br />Click here to remove the selected ImsTransferItemBefore(s)'); ?>',
				icon: 'img/table_delete.png',
				cls: 'x-btn-text-icon',
				disabled: true,
				handler: function(btn) {
					var sm = g.getSelectionModel();
					var sel = sm.getSelections();
					if (sm.hasSelection()){
						if(sel.length==1){
							Ext.Msg.show({
									title: '<?php __('Remove ImsTransferItemBefore'); ?>',
									buttons: Ext.MessageBox.YESNOCANCEL,
									msg: '<?php __('Remove'); ?> '+sel[0].data.name+'?',
									icon: Ext.MessageBox.QUESTION,
                                    fn: function(btn){
											if (btn == 'yes'){
													DeleteParentImsTransferItemBefore(sel[0].data.id);
											}
									}
							});
						} else {
							Ext.Msg.show({
									title: '<?php __('Remove ImsTransferItemBefore'); ?>',
									buttons: Ext.MessageBox.YESNOCANCEL,
									msg: '<?php __('Remove the selected ImsTransferItemBefore'); ?>?',
									icon: Ext.MessageBox.QUESTION,
                                    fn: function(btn){
											if (btn == 'yes'){
													var sel_ids = '';
													for(i=0;i<sel.length;i++){
														if(i>0)
															sel_ids += '_';
														sel_ids += sel[i].data.id;
													}
													DeleteParentImsTransferItemBefore(sel_ids);
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
				text: '<?php __('View ImsTransferItemBefore'); ?>',
				id: 'view-imsTransferItemBefore2',
				tooltip:'<?php __('<b>View ImsTransferItemBefore</b><br />Click here to see details of the selected ImsTransferItemBefore'); ?>',
				icon: 'img/table_view.png',
				cls: 'x-btn-text-icon',
				disabled: true,
				handler: function(btn) {
					var sm = g.getSelectionModel();
					var sel = sm.getSelected();
					if (sm.hasSelection()){
						ViewImsTransferItemBefore(sel.data.id);
					};
				},
				menu : {
					items: [
					]
				}

            }, ' ', '->', {
				xtype: 'textfield',
				emptyText: '<?php __('[Search By Name]'); ?>',
				id: 'parent_imsTransferItemBefore_search_field',
				listeners: {
					specialkey: function(field, e){
						if (e.getKey() == e.ENTER) {
							SearchByParentImsTransferItemBeforeName(Ext.getCmp('parent_imsTransferItemBefore_search_field').getValue());
						}
					}

				}
			}, {
				xtype: 'tbbutton',
				icon: 'img/search.png',
				cls: 'x-btn-text-icon',
				text: 'GO',
				tooltip:'<?php __('<b>GO</b><br />Click here to get search results'); ?>',
				id: 'parent_imsTransferItemBefore_go_button',
				handler: function(){
					SearchByParentImsTransferItemBeforeName(Ext.getCmp('parent_imsTransferItemBefore_search_field').getValue());
				}
			}, ' '
	]}),
	bbar: new Ext.PagingToolbar({
		pageSize: list_size,
		store: store_parent_imsTransferItemBefores,
		displayInfo: true,
		displayMsg: '<?php __('Displaying {0} - {1} of {2}'); ?>',
		beforePageText: '<?php __('Page'); ?>',
		afterPageText: '<?php __('of {0}'); ?>',
		emptyMsg: '<?php __('No data to display'); ?>'
	})
});
g.getSelectionModel().on('rowselect', function(sm, rowIdx, r) {
	g.getTopToolbar().findById('edit-parent-imsTransferItemBefore').enable();
	g.getTopToolbar().findById('delete-parent-imsTransferItemBefore').enable();
        g.getTopToolbar().findById('view-imsTransferItemBefore2').enable();
	if(this.getSelections().length > 1){
		g.getTopToolbar().findById('edit-parent-imsTransferItemBefore').disable();
                g.getTopToolbar().findById('view-imsTransferItemBefore2').disable();
	}
});
g.getSelectionModel().on('rowdeselect', function(sm, rowIdx, r) {
	if(this.getSelections().length > 1){
		g.getTopToolbar().findById('edit-parent-imsTransferItemBefore').disable();
		g.getTopToolbar().findById('delete-parent-imsTransferItemBefore').enable();
                g.getTopToolbar().findById('view-imsTransferItemBefore2').disable();
	}
	else if(this.getSelections().length == 1){
		g.getTopToolbar().findById('edit-parent-imsTransferItemBefore').enable();
		g.getTopToolbar().findById('delete-parent-imsTransferItemBefore').enable();
                g.getTopToolbar().findById('view-imsTransferItemBefore2').enable();
	}
	else{
		g.getTopToolbar().findById('edit-parent-imsTransferItemBefore').disable();
		g.getTopToolbar().findById('delete-parent-imsTransferItemBefore').disable();
                g.getTopToolbar().findById('view-imsTransferItemBefore2').disable();
	}
});



var parentImsTransferItemBeforesViewWindow = new Ext.Window({
	title: 'ImsTransferItemBefore Under the selected Item',
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
			parentImsTransferItemBeforesViewWindow.close();
		}
	}]
});

store_parent_imsTransferItemBefores.load({
    params: {
        start: 0,    
        limit: list_size
    }
});