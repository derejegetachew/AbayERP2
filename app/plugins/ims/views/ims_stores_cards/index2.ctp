var store_parent_imsStoresCards = new Ext.data.Store({
	reader: new Ext.data.JsonReader({
		root:'rows',
		totalProperty: 'results',
		fields: [
			'id','ims_store','ims_requisition','ims_card','created','modified'	
		]
	}),
	proxy: new Ext.data.HttpProxy({
		url: '<?php echo $this->Html->url(array('controller' => 'imsStoresCards', 'action' => 'list_data', $parent_id)); ?>'	})
});


function AddParentImsStoresCard() {
	Ext.Ajax.request({
		url: '<?php echo $this->Html->url(array('controller' => 'imsStoresCards', 'action' => 'add', $parent_id)); ?>',
		success: function(response, opts) {
			var parent_imsStoresCard_data = response.responseText;
			
			eval(parent_imsStoresCard_data);
			
			ImsStoresCardAddWindow.show();
		},
		failure: function(response, opts) {
			Ext.Msg.alert('<?php __('Error'); ?>', '<?php __('Cannot get the imsStoresCard add form. Error code'); ?>: ' + response.status);
		}
	});
}

function EditParentImsStoresCard(id) {
	Ext.Ajax.request({
		url: '<?php echo $this->Html->url(array('controller' => 'imsStoresCards', 'action' => 'edit')); ?>/'+id+'/<?php echo $parent_id; ?>',
		success: function(response, opts) {
			var parent_imsStoresCard_data = response.responseText;
			
			eval(parent_imsStoresCard_data);
			
			ImsStoresCardEditWindow.show();
		},
		failure: function(response, opts) {
			Ext.Msg.alert('<?php __('Error'); ?>', '<?php __('Cannot get the imsStoresCard edit form. Error code'); ?>: ' + response.status);
		}
	});
}

function ViewImsStoresCard(id) {
	Ext.Ajax.request({
		url: '<?php echo $this->Html->url(array('controller' => 'imsStoresCards', 'action' => 'view')); ?>/'+id,
		success: function(response, opts) {
			var imsStoresCard_data = response.responseText;

			eval(imsStoresCard_data);

			ImsStoresCardViewWindow.show();
		},
		failure: function(response, opts) {
			Ext.Msg.alert('<?php __('Error'); ?>', '<?php __('Cannot get the imsStoresCard view form. Error code'); ?>: ' + response.status);
		}
	});
}


function DeleteParentImsStoresCard(id) {
	Ext.Ajax.request({
		url: '<?php echo $this->Html->url(array('controller' => 'imsStoresCards', 'action' => 'delete')); ?>/'+id,
		success: function(response, opts) {
			Ext.Msg.alert('<?php __('Success'); ?>', '<?php __('ImsStoresCard(s) successfully deleted!'); ?>');
			RefreshParentImsStoresCardData();
		},
		failure: function(response, opts) {
			Ext.Msg.alert('<?php __('Error'); ?>', '<?php __('Cannot get the imsStoresCard to be deleted. Error code'); ?>: ' + response.status);
		}
	});
}

function SearchByParentImsStoresCardName(value){
	var conditions = '\'ImsStoresCard.name LIKE\' => \'%' + value + '%\'';
	store_parent_imsStoresCards.reload({
		 params: {
			start: 0,
			limit: list_size,
			conditions: conditions
	    }
	});
}

function RefreshParentImsStoresCardData() {
	store_parent_imsStoresCards.reload();
}



var g = new Ext.grid.GridPanel({
	title: '<?php __('ImsStoresCards'); ?>',
	store: store_parent_imsStoresCards,
	loadMask: true,
	stripeRows: true,
	height: 300,
	anchor: '100%',
    id: 'imsStoresCardGrid',
	columns: [
		{header:"<?php __('ims_store'); ?>", dataIndex: 'ims_store', sortable: true},
		{header:"<?php __('ims_requisition'); ?>", dataIndex: 'ims_requisition', sortable: true},
		{header:"<?php __('ims_card'); ?>", dataIndex: 'ims_card', sortable: true},
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
            ViewImsStoresCard(Ext.getCmp('imsStoresCardGrid').getSelectionModel().getSelected().data.id);
        }
    },
	tbar: new Ext.Toolbar({
		items: [{
				xtype: 'tbbutton',
				text: '<?php __('Add'); ?>',
				tooltip:'<?php __('<b>Add ImsStoresCard</b><br />Click here to create a new ImsStoresCard'); ?>',
				icon: 'img/table_add.png',
				cls: 'x-btn-text-icon',
				handler: function(btn) {
					AddParentImsStoresCard();
				}
			}, ' ', '-', ' ', {
				xtype: 'tbbutton',
				text: '<?php __('Edit'); ?>',
				id: 'edit-parent-imsStoresCard',
				tooltip:'<?php __('<b>Edit ImsStoresCard</b><br />Click here to modify the selected ImsStoresCard'); ?>',
				icon: 'img/table_edit.png',
				cls: 'x-btn-text-icon',
				disabled: true,
				handler: function(btn) {
					var sm = g.getSelectionModel();
					var sel = sm.getSelected();
					if (sm.hasSelection()){
						EditParentImsStoresCard(sel.data.id);
					};
				}
			}, ' ', '-', ' ', {
				xtype: 'tbbutton',
				text: '<?php __('Delete'); ?>',
				id: 'delete-parent-imsStoresCard',
				tooltip:'<?php __('<b>Delete ImsStoresCard(s)</b><br />Click here to remove the selected ImsStoresCard(s)'); ?>',
				icon: 'img/table_delete.png',
				cls: 'x-btn-text-icon',
				disabled: true,
				handler: function(btn) {
					var sm = g.getSelectionModel();
					var sel = sm.getSelections();
					if (sm.hasSelection()){
						if(sel.length==1){
							Ext.Msg.show({
									title: '<?php __('Remove ImsStoresCard'); ?>',
									buttons: Ext.MessageBox.YESNOCANCEL,
									msg: '<?php __('Remove'); ?> '+sel[0].data.name+'?',
									icon: Ext.MessageBox.QUESTION,
                                    fn: function(btn){
											if (btn == 'yes'){
													DeleteParentImsStoresCard(sel[0].data.id);
											}
									}
							});
						} else {
							Ext.Msg.show({
									title: '<?php __('Remove ImsStoresCard'); ?>',
									buttons: Ext.MessageBox.YESNOCANCEL,
									msg: '<?php __('Remove the selected ImsStoresCard'); ?>?',
									icon: Ext.MessageBox.QUESTION,
                                    fn: function(btn){
											if (btn == 'yes'){
													var sel_ids = '';
													for(i=0;i<sel.length;i++){
														if(i>0)
															sel_ids += '_';
														sel_ids += sel[i].data.id;
													}
													DeleteParentImsStoresCard(sel_ids);
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
				text: '<?php __('View ImsStoresCard'); ?>',
				id: 'view-imsStoresCard2',
				tooltip:'<?php __('<b>View ImsStoresCard</b><br />Click here to see details of the selected ImsStoresCard'); ?>',
				icon: 'img/table_view.png',
				cls: 'x-btn-text-icon',
				disabled: true,
				handler: function(btn) {
					var sm = g.getSelectionModel();
					var sel = sm.getSelected();
					if (sm.hasSelection()){
						ViewImsStoresCard(sel.data.id);
					};
				},
				menu : {
					items: [
					]
				}

            }, ' ', '->', {
				xtype: 'textfield',
				emptyText: '<?php __('[Search By Name]'); ?>',
				id: 'parent_imsStoresCard_search_field',
				listeners: {
					specialkey: function(field, e){
						if (e.getKey() == e.ENTER) {
							SearchByParentImsStoresCardName(Ext.getCmp('parent_imsStoresCard_search_field').getValue());
						}
					}

				}
			}, {
				xtype: 'tbbutton',
				icon: 'img/search.png',
				cls: 'x-btn-text-icon',
				text: 'GO',
				tooltip:'<?php __('<b>GO</b><br />Click here to get search results'); ?>',
				id: 'parent_imsStoresCard_go_button',
				handler: function(){
					SearchByParentImsStoresCardName(Ext.getCmp('parent_imsStoresCard_search_field').getValue());
				}
			}, ' '
	]}),
	bbar: new Ext.PagingToolbar({
		pageSize: list_size,
		store: store_parent_imsStoresCards,
		displayInfo: true,
		displayMsg: '<?php __('Displaying {0} - {1} of {2}'); ?>',
		beforePageText: '<?php __('Page'); ?>',
		afterPageText: '<?php __('of {0}'); ?>',
		emptyMsg: '<?php __('No data to display'); ?>'
	})
});
g.getSelectionModel().on('rowselect', function(sm, rowIdx, r) {
	g.getTopToolbar().findById('edit-parent-imsStoresCard').enable();
	g.getTopToolbar().findById('delete-parent-imsStoresCard').enable();
        g.getTopToolbar().findById('view-imsStoresCard2').enable();
	if(this.getSelections().length > 1){
		g.getTopToolbar().findById('edit-parent-imsStoresCard').disable();
                g.getTopToolbar().findById('view-imsStoresCard2').disable();
	}
});
g.getSelectionModel().on('rowdeselect', function(sm, rowIdx, r) {
	if(this.getSelections().length > 1){
		g.getTopToolbar().findById('edit-parent-imsStoresCard').disable();
		g.getTopToolbar().findById('delete-parent-imsStoresCard').enable();
                g.getTopToolbar().findById('view-imsStoresCard2').disable();
	}
	else if(this.getSelections().length == 1){
		g.getTopToolbar().findById('edit-parent-imsStoresCard').enable();
		g.getTopToolbar().findById('delete-parent-imsStoresCard').enable();
                g.getTopToolbar().findById('view-imsStoresCard2').enable();
	}
	else{
		g.getTopToolbar().findById('edit-parent-imsStoresCard').disable();
		g.getTopToolbar().findById('delete-parent-imsStoresCard').disable();
                g.getTopToolbar().findById('view-imsStoresCard2').disable();
	}
});



var parentImsStoresCardsViewWindow = new Ext.Window({
	title: 'ImsStoresCard Under the selected Item',
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
			parentImsStoresCardsViewWindow.close();
		}
	}]
});

store_parent_imsStoresCards.load({
    params: {
        start: 0,    
        limit: list_size
    }
});