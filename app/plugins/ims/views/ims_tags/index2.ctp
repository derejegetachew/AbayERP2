var store_parent_imsTags = new Ext.data.Store({
	reader: new Ext.data.JsonReader({
		root:'rows',
		totalProperty: 'results',
		fields: [
			'id','code','ims_sirv_item','ims_sirv_item_before','created','modified'	
		]
	}),
	proxy: new Ext.data.HttpProxy({
		url: '<?php echo $this->Html->url(array('controller' => 'imsTags', 'action' => 'list_data', $parent_id)); ?>'	})
});


function AddParentImsTag() {
	Ext.Ajax.request({
		url: '<?php echo $this->Html->url(array('controller' => 'imsTags', 'action' => 'add', $parent_id)); ?>',
		success: function(response, opts) {
			var parent_imsTag_data = response.responseText;
			
			eval(parent_imsTag_data);
			
			ImsTagAddWindow.show();
		},
		failure: function(response, opts) {
			Ext.Msg.alert('<?php __('Error'); ?>', '<?php __('Cannot get the imsTag add form. Error code'); ?>: ' + response.status);
		}
	});
}

function EditParentImsTag(id) {
	Ext.Ajax.request({
		url: '<?php echo $this->Html->url(array('controller' => 'imsTags', 'action' => 'edit')); ?>/'+id+'/<?php echo $parent_id; ?>',
		success: function(response, opts) {
			var parent_imsTag_data = response.responseText;
			
			eval(parent_imsTag_data);
			
			ImsTagEditWindow.show();
		},
		failure: function(response, opts) {
			Ext.Msg.alert('<?php __('Error'); ?>', '<?php __('Cannot get the imsTag edit form. Error code'); ?>: ' + response.status);
		}
	});
}

function ViewImsTag(id) {
	Ext.Ajax.request({
		url: '<?php echo $this->Html->url(array('controller' => 'imsTags', 'action' => 'view')); ?>/'+id,
		success: function(response, opts) {
			var imsTag_data = response.responseText;

			eval(imsTag_data);

			ImsTagViewWindow.show();
		},
		failure: function(response, opts) {
			Ext.Msg.alert('<?php __('Error'); ?>', '<?php __('Cannot get the imsTag view form. Error code'); ?>: ' + response.status);
		}
	});
}


function DeleteParentImsTag(id) {
	Ext.Ajax.request({
		url: '<?php echo $this->Html->url(array('controller' => 'imsTags', 'action' => 'delete')); ?>/'+id,
		success: function(response, opts) {
			Ext.Msg.alert('<?php __('Success'); ?>', '<?php __('ImsTag(s) successfully deleted!'); ?>');
			RefreshParentImsTagData();
		},
		failure: function(response, opts) {
			Ext.Msg.alert('<?php __('Error'); ?>', '<?php __('Cannot get the imsTag to be deleted. Error code'); ?>: ' + response.status);
		}
	});
}

function SearchByParentImsTagName(value){
	var conditions = '\'ImsTag.name LIKE\' => \'%' + value + '%\'';
	store_parent_imsTags.reload({
		 params: {
			start: 0,
			limit: list_size,
			conditions: conditions
	    }
	});
}

function RefreshParentImsTagData() {
	store_parent_imsTags.reload();
}



var g = new Ext.grid.GridPanel({
	title: '<?php __('ImsTags'); ?>',
	store: store_parent_imsTags,
	loadMask: true,
	stripeRows: true,
	height: 300,
	anchor: '100%',
    id: 'imsTagGrid',
	columns: [
		{header: "<?php __('Code'); ?>", dataIndex: 'code', sortable: true},
		{header:"<?php __('ims_sirv_item'); ?>", dataIndex: 'ims_sirv_item', sortable: true},
		{header:"<?php __('ims_sirv_item_before'); ?>", dataIndex: 'ims_sirv_item_before', sortable: true},
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
            ViewImsTag(Ext.getCmp('imsTagGrid').getSelectionModel().getSelected().data.id);
        }
    },
	tbar: new Ext.Toolbar({
		items: [{
				xtype: 'tbbutton',
				text: '<?php __('Add'); ?>',
				tooltip:'<?php __('<b>Add ImsTag</b><br />Click here to create a new ImsTag'); ?>',
				icon: 'img/table_add.png',
				cls: 'x-btn-text-icon',
				handler: function(btn) {
					AddParentImsTag();
				}
			}, ' ', '-', ' ', {
				xtype: 'tbbutton',
				text: '<?php __('Edit'); ?>',
				id: 'edit-parent-imsTag',
				tooltip:'<?php __('<b>Edit ImsTag</b><br />Click here to modify the selected ImsTag'); ?>',
				icon: 'img/table_edit.png',
				cls: 'x-btn-text-icon',
				disabled: true,
				handler: function(btn) {
					var sm = g.getSelectionModel();
					var sel = sm.getSelected();
					if (sm.hasSelection()){
						EditParentImsTag(sel.data.id);
					};
				}
			}, ' ', '-', ' ', {
				xtype: 'tbbutton',
				text: '<?php __('Delete'); ?>',
				id: 'delete-parent-imsTag',
				tooltip:'<?php __('<b>Delete ImsTag(s)</b><br />Click here to remove the selected ImsTag(s)'); ?>',
				icon: 'img/table_delete.png',
				cls: 'x-btn-text-icon',
				disabled: true,
				handler: function(btn) {
					var sm = g.getSelectionModel();
					var sel = sm.getSelections();
					if (sm.hasSelection()){
						if(sel.length==1){
							Ext.Msg.show({
									title: '<?php __('Remove ImsTag'); ?>',
									buttons: Ext.MessageBox.YESNOCANCEL,
									msg: '<?php __('Remove'); ?> '+sel[0].data.name+'?',
									icon: Ext.MessageBox.QUESTION,
                                    fn: function(btn){
											if (btn == 'yes'){
													DeleteParentImsTag(sel[0].data.id);
											}
									}
							});
						} else {
							Ext.Msg.show({
									title: '<?php __('Remove ImsTag'); ?>',
									buttons: Ext.MessageBox.YESNOCANCEL,
									msg: '<?php __('Remove the selected ImsTag'); ?>?',
									icon: Ext.MessageBox.QUESTION,
                                    fn: function(btn){
											if (btn == 'yes'){
													var sel_ids = '';
													for(i=0;i<sel.length;i++){
														if(i>0)
															sel_ids += '_';
														sel_ids += sel[i].data.id;
													}
													DeleteParentImsTag(sel_ids);
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
				text: '<?php __('View ImsTag'); ?>',
				id: 'view-imsTag2',
				tooltip:'<?php __('<b>View ImsTag</b><br />Click here to see details of the selected ImsTag'); ?>',
				icon: 'img/table_view.png',
				cls: 'x-btn-text-icon',
				disabled: true,
				handler: function(btn) {
					var sm = g.getSelectionModel();
					var sel = sm.getSelected();
					if (sm.hasSelection()){
						ViewImsTag(sel.data.id);
					};
				},
				menu : {
					items: [
					]
				}

            }, ' ', '->', {
				xtype: 'textfield',
				emptyText: '<?php __('[Search By Name]'); ?>',
				id: 'parent_imsTag_search_field',
				listeners: {
					specialkey: function(field, e){
						if (e.getKey() == e.ENTER) {
							SearchByParentImsTagName(Ext.getCmp('parent_imsTag_search_field').getValue());
						}
					}

				}
			}, {
				xtype: 'tbbutton',
				icon: 'img/search.png',
				cls: 'x-btn-text-icon',
				text: 'GO',
				tooltip:'<?php __('<b>GO</b><br />Click here to get search results'); ?>',
				id: 'parent_imsTag_go_button',
				handler: function(){
					SearchByParentImsTagName(Ext.getCmp('parent_imsTag_search_field').getValue());
				}
			}, ' '
	]}),
	bbar: new Ext.PagingToolbar({
		pageSize: list_size,
		store: store_parent_imsTags,
		displayInfo: true,
		displayMsg: '<?php __('Displaying {0} - {1} of {2}'); ?>',
		beforePageText: '<?php __('Page'); ?>',
		afterPageText: '<?php __('of {0}'); ?>',
		emptyMsg: '<?php __('No data to display'); ?>'
	})
});
g.getSelectionModel().on('rowselect', function(sm, rowIdx, r) {
	g.getTopToolbar().findById('edit-parent-imsTag').enable();
	g.getTopToolbar().findById('delete-parent-imsTag').enable();
        g.getTopToolbar().findById('view-imsTag2').enable();
	if(this.getSelections().length > 1){
		g.getTopToolbar().findById('edit-parent-imsTag').disable();
                g.getTopToolbar().findById('view-imsTag2').disable();
	}
});
g.getSelectionModel().on('rowdeselect', function(sm, rowIdx, r) {
	if(this.getSelections().length > 1){
		g.getTopToolbar().findById('edit-parent-imsTag').disable();
		g.getTopToolbar().findById('delete-parent-imsTag').enable();
                g.getTopToolbar().findById('view-imsTag2').disable();
	}
	else if(this.getSelections().length == 1){
		g.getTopToolbar().findById('edit-parent-imsTag').enable();
		g.getTopToolbar().findById('delete-parent-imsTag').enable();
                g.getTopToolbar().findById('view-imsTag2').enable();
	}
	else{
		g.getTopToolbar().findById('edit-parent-imsTag').disable();
		g.getTopToolbar().findById('delete-parent-imsTag').disable();
                g.getTopToolbar().findById('view-imsTag2').disable();
	}
});



var parentImsTagsViewWindow = new Ext.Window({
	title: 'ImsTag Under the selected Item',
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
			parentImsTagsViewWindow.close();
		}
	}]
});

store_parent_imsTags.load({
    params: {
        start: 0,    
        limit: list_size
    }
});