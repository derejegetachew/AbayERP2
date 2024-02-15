//<script>
var store_parent_grns = new Ext.data.Store({
	reader: new Ext.data.JsonReader({
		root:'rows',
		totalProperty: 'results',
		fields: [
			'id','name','supplier','purchase_order','date_purchased','created','modified'	
		]
	}),
	proxy: new Ext.data.HttpProxy({
		url: '<?php echo $this->Html->url(array('controller' => 'ims_grns', 'action' => 'list_data', $parent_id)); ?>'	})
});


function AddParentGrn() {
	Ext.Ajax.request({
		url: '<?php echo $this->Html->url(array('controller' => 'ims_grns', 'action' => 'add', $parent_id)); ?>',
		success: function(response, opts) {
			var parent_grn_data = response.responseText;
			
			eval(parent_grn_data);
			
			GrnAddWindow.show();
		},
		failure: function(response, opts) {
			Ext.Msg.alert('<?php __('Error'); ?>', '<?php __('Cannot get the grn add form. Error code'); ?>: ' + response.status);
		}
	});
}

function EditParentGrn(id) {
	Ext.Ajax.request({
		url: '<?php echo $this->Html->url(array('controller' => 'ims_grns', 'action' => 'edit')); ?>/'+id+'/<?php echo $parent_id; ?>',
		success: function(response, opts) {
			var parent_grn_data = response.responseText;
			
			eval(parent_grn_data);
			
			GrnEditWindow.show();
		},
		failure: function(response, opts) {
			Ext.Msg.alert('<?php __('Error'); ?>', '<?php __('Cannot get the grn edit form. Error code'); ?>: ' + response.status);
		}
	});
}

function ViewGrn(id) {
	Ext.Ajax.request({
		url: '<?php echo $this->Html->url(array('controller' => 'ims_grns', 'action' => 'view')); ?>/'+id,
		success: function(response, opts) {
			var grn_data = response.responseText;

			eval(grn_data);

			GrnViewWindow.show();
		},
		failure: function(response, opts) {
			Ext.Msg.alert('<?php __('Error'); ?>', '<?php __('Cannot get the grn view form. Error code'); ?>: ' + response.status);
		}
	});
}

function ViewGrnGrnItems(id) {
	Ext.Ajax.request({
		url: '<?php echo $this->Html->url(array('controller' => 'ims_grn_items', 'action' => 'index2')); ?>/'+id,
		success: function(response, opts) {
			var parent_grnItems_data = response.responseText;

			eval(parent_grnItems_data);

			parentGrnItemsViewWindow.show();
		},
		failure: function(response, opts) {
			Ext.Msg.alert('<?php __('Error'); ?>', '<?php __('Cannot get the campus view form. Error code'); ?>: ' + response.status);
		}
	});
}


function DeleteParentGrn(id) {
	Ext.Ajax.request({
		url: '<?php echo $this->Html->url(array('controller' => 'ims_grns', 'action' => 'delete')); ?>/'+id,
		success: function(response, opts) {
			Ext.Msg.alert('<?php __('Success'); ?>', '<?php __('Grn(s) successfully deleted!'); ?>');
			RefreshParentGrnData();
		},
		failure: function(response, opts) {
			Ext.Msg.alert('<?php __('Error'); ?>', '<?php __('Cannot get the grn to be deleted. Error code'); ?>: ' + response.status);
		}
	});
}

function SearchByParentGrnName(value){
	var conditions = '\'ImsGrn.name LIKE\' => \'%' + value + '%\'';
	store_parent_grns.reload({
		 params: {
			start: 0,
			limit: list_size,
			conditions: conditions
	    }
	});
}

function RefreshParentGrnData() {
	store_parent_grns.reload();
}



var g = new Ext.grid.GridPanel({
	title: '<?php __('Grns'); ?>',
	store: store_parent_grns,
	loadMask: true,
	stripeRows: true,
	height: 300,
	anchor: '100%',
    id: 'grnGrid',
	columns: [
		{header: "<?php __('Name'); ?>", dataIndex: 'name', sortable: true},
		{header:"<?php __('supplier'); ?>", dataIndex: 'supplier', sortable: true},
		{header:"<?php __('purchase_order'); ?>", dataIndex: 'purchase_order', sortable: true},
		{header: "<?php __('Date Purchased'); ?>", dataIndex: 'date_purchased', sortable: true},
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
            ViewGrn(Ext.getCmp('grnGrid').getSelectionModel().getSelected().data.id);
        }
    },
	tbar: new Ext.Toolbar({
		items: [{
				xtype: 'tbbutton',
				text: '<?php __('Add'); ?>',
				tooltip:'<?php __('<b>Add Grn</b><br />Click here to create a new Grn'); ?>',
				icon: 'img/table_add.png',
				cls: 'x-btn-text-icon',
				handler: function(btn) {
					AddParentGrn();
				}
			}, ' ', '-', ' ', {
				xtype: 'tbbutton',
				text: '<?php __('Edit'); ?>',
				id: 'edit-parent-grn',
				tooltip:'<?php __('<b>Edit Grn</b><br />Click here to modify the selected Grn'); ?>',
				icon: 'img/table_edit.png',
				cls: 'x-btn-text-icon',
				disabled: true,
				handler: function(btn) {
					var sm = g.getSelectionModel();
					var sel = sm.getSelected();
					if (sm.hasSelection()){
						EditParentGrn(sel.data.id);
					};
				}
			}, ' ', '-', ' ', {
				xtype: 'tbbutton',
				text: '<?php __('Delete'); ?>',
				id: 'delete-parent-grn',
				tooltip:'<?php __('<b>Delete Grn(s)</b><br />Click here to remove the selected Grn(s)'); ?>',
				icon: 'img/table_delete.png',
				cls: 'x-btn-text-icon',
				disabled: true,
				handler: function(btn) {
					var sm = g.getSelectionModel();
					var sel = sm.getSelections();
					if (sm.hasSelection()){
						if(sel.length==1){
							Ext.Msg.show({
									title: '<?php __('Remove Grn'); ?>',
									buttons: Ext.MessageBox.YESNOCANCEL,
									msg: '<?php __('Remove'); ?> '+sel[0].data.name+'?',
									icon: Ext.MessageBox.QUESTION,
                                    fn: function(btn){
											if (btn == 'yes'){
													DeleteParentGrn(sel[0].data.id);
											}
									}
							});
						} else {
							Ext.Msg.show({
									title: '<?php __('Remove Grn'); ?>',
									buttons: Ext.MessageBox.YESNOCANCEL,
									msg: '<?php __('Remove the selected Grn'); ?>?',
									icon: Ext.MessageBox.QUESTION,
                                    fn: function(btn){
											if (btn == 'yes'){
													var sel_ids = '';
													for(i=0;i<sel.length;i++){
														if(i>0)
															sel_ids += '_';
														sel_ids += sel[i].data.id;
													}
													DeleteParentGrn(sel_ids);
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
				text: '<?php __('View Grn'); ?>',
				id: 'view-grn2',
				tooltip:'<?php __('<b>View Grn</b><br />Click here to see details of the selected Grn'); ?>',
				icon: 'img/table_view.png',
				cls: 'x-btn-text-icon',
				disabled: true,
				handler: function(btn) {
					var sm = g.getSelectionModel();
					var sel = sm.getSelected();
					if (sm.hasSelection()){
						ViewGrn(sel.data.id);
					};
				},
				menu : {
					items: [
 {
						text: '<?php __('View Grn Items'); ?>',
                        icon: 'img/table_view.png',
						cls: 'x-btn-text-icon',
						handler: function(btn) {
							var sm = g.getSelectionModel();
							var sel = sm.getSelected();
							if (sm.hasSelection()){
								ViewGrnGrnItems(sel.data.id);
							};
						}
					}
					]
				}

            }, ' ', '->', {
				xtype: 'textfield',
				emptyText: '<?php __('[Search By Name]'); ?>',
				id: 'parent_grn_search_field',
				listeners: {
					specialkey: function(field, e){
						if (e.getKey() == e.ENTER) {
							SearchByParentGrnName(Ext.getCmp('parent_grn_search_field').getValue());
						}
					}

				}
			}, {
				xtype: 'tbbutton',
				icon: 'img/search.png',
				cls: 'x-btn-text-icon',
				text: 'GO',
				tooltip:'<?php __('<b>GO</b><br />Click here to get search results'); ?>',
				id: 'parent_grn_go_button',
				handler: function(){
					SearchByParentGrnName(Ext.getCmp('parent_grn_search_field').getValue());
				}
			}, ' '
	]}),
	bbar: new Ext.PagingToolbar({
		pageSize: list_size,
		store: store_parent_grns,
		displayInfo: true,
		displayMsg: '<?php __('Displaying {0} - {1} of {2}'); ?>',
		beforePageText: '<?php __('Page'); ?>',
		afterPageText: '<?php __('of {0}'); ?>',
		emptyMsg: '<?php __('No data to display'); ?>'
	})
});
g.getSelectionModel().on('rowselect', function(sm, rowIdx, r) {
	g.getTopToolbar().findById('edit-parent-grn').enable();
	g.getTopToolbar().findById('delete-parent-grn').enable();
        g.getTopToolbar().findById('view-grn2').enable();
	if(this.getSelections().length > 1){
		g.getTopToolbar().findById('edit-parent-grn').disable();
                g.getTopToolbar().findById('view-grn2').disable();
	}
});
g.getSelectionModel().on('rowdeselect', function(sm, rowIdx, r) {
	if(this.getSelections().length > 1){
		g.getTopToolbar().findById('edit-parent-grn').disable();
		g.getTopToolbar().findById('delete-parent-grn').enable();
                g.getTopToolbar().findById('view-grn2').disable();
	}
	else if(this.getSelections().length == 1){
		g.getTopToolbar().findById('edit-parent-grn').enable();
		g.getTopToolbar().findById('delete-parent-grn').enable();
                g.getTopToolbar().findById('view-grn2').enable();
	}
	else{
		g.getTopToolbar().findById('edit-parent-grn').disable();
		g.getTopToolbar().findById('delete-parent-grn').disable();
                g.getTopToolbar().findById('view-grn2').disable();
	}
});



var parentGrnsViewWindow = new Ext.Window({
	title: 'Grn Under the selected Item',
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
			parentGrnsViewWindow.close();
		}
	}]
});

store_parent_grns.load({
    params: {
        start: 0,    
        limit: list_size
    }
});