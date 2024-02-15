var store_parent_imsSirvItemBefores = new Ext.data.Store({
	reader: new Ext.data.JsonReader({
		root:'rows',
		totalProperty: 'results',
		fields: [
			'id','ims_sirv_before','ims_item','measurement','quantity','unit_price','remark'	
		]
	}),
	proxy: new Ext.data.HttpProxy({
		url: '<?php echo $this->Html->url(array('controller' => 'imsSirvItemBefores', 'action' => 'list_data', $parent_id)); ?>'	})
});


function AddParentImsSirvItemBefore() {
	Ext.Ajax.request({
		url: '<?php echo $this->Html->url(array('controller' => 'imsSirvItemBefores', 'action' => 'add', $parent_id)); ?>',
		success: function(response, opts) {
			var parent_imsSirvItemBefore_data = response.responseText;
			
			eval(parent_imsSirvItemBefore_data);
			
			ImsSirvItemBeforeAddWindow.show();
		},
		failure: function(response, opts) {
			Ext.Msg.alert('<?php __('Error'); ?>', '<?php __('Cannot get the imsSirvItemBefore add form. Error code'); ?>: ' + response.status);
		}
	});
}

function EditParentImsSirvItemBefore(id) {
	Ext.Ajax.request({
		url: '<?php echo $this->Html->url(array('controller' => 'imsSirvItemBefores', 'action' => 'edit')); ?>/'+id+'/<?php echo $parent_id; ?>',
		success: function(response, opts) {
			var parent_imsSirvItemBefore_data = response.responseText;
			
			eval(parent_imsSirvItemBefore_data);
			
			ImsSirvItemBeforeEditWindow.show();
		},
		failure: function(response, opts) {
			Ext.Msg.alert('<?php __('Error'); ?>', '<?php __('Cannot get the imsSirvItemBefore edit form. Error code'); ?>: ' + response.status);
		}
	});
}

function ViewImsSirvItemBefore(id) {
	Ext.Ajax.request({
		url: '<?php echo $this->Html->url(array('controller' => 'imsSirvItemBefores', 'action' => 'view')); ?>/'+id,
		success: function(response, opts) {
			var imsSirvItemBefore_data = response.responseText;

			eval(imsSirvItemBefore_data);

			ImsSirvItemBeforeViewWindow.show();
		},
		failure: function(response, opts) {
			Ext.Msg.alert('<?php __('Error'); ?>', '<?php __('Cannot get the imsSirvItemBefore view form. Error code'); ?>: ' + response.status);
		}
	});
}

function ViewImsSirvItemBeforeImsTags(id) {
	Ext.Ajax.request({
		url: '<?php echo $this->Html->url(array('controller' => 'imsTags', 'action' => 'index2')); ?>/'+id,
		success: function(response, opts) {
			var parent_imsTags_data = response.responseText;

			eval(parent_imsTags_data);

			parentImsTagsViewWindow.show();
		},
		failure: function(response, opts) {
			Ext.Msg.alert('<?php __('Error'); ?>', '<?php __('Cannot get the campus view form. Error code'); ?>: ' + response.status);
		}
	});
}


function DeleteParentImsSirvItemBefore(id) {
	Ext.Ajax.request({
		url: '<?php echo $this->Html->url(array('controller' => 'imsSirvItemBefores', 'action' => 'delete')); ?>/'+id,
		success: function(response, opts) {
			Ext.Msg.alert('<?php __('Success'); ?>', '<?php __('ImsSirvItemBefore(s) successfully deleted!'); ?>');
			RefreshParentImsSirvItemBeforeData();
		},
		failure: function(response, opts) {
			Ext.Msg.alert('<?php __('Error'); ?>', '<?php __('Cannot get the imsSirvItemBefore to be deleted. Error code'); ?>: ' + response.status);
		}
	});
}

function SearchByParentImsSirvItemBeforeName(value){
	var conditions = '\'ImsSirvItemBefore.name LIKE\' => \'%' + value + '%\'';
	store_parent_imsSirvItemBefores.reload({
		 params: {
			start: 0,
			limit: list_size,
			conditions: conditions
	    }
	});
}

function RefreshParentImsSirvItemBeforeData() {
	store_parent_imsSirvItemBefores.reload();
}



var g = new Ext.grid.GridPanel({
	title: '<?php __('ImsSirvItemBefores'); ?>',
	store: store_parent_imsSirvItemBefores,
	loadMask: true,
	stripeRows: true,
	height: 300,
	anchor: '100%',
    id: 'imsSirvItemBeforeGrid',
	columns: [
		{header:"<?php __('ims_sirv_before'); ?>", dataIndex: 'ims_sirv_before', sortable: true},
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
            ViewImsSirvItemBefore(Ext.getCmp('imsSirvItemBeforeGrid').getSelectionModel().getSelected().data.id);
        }
    },
	tbar: new Ext.Toolbar({
		items: [{
				xtype: 'tbbutton',
				text: '<?php __('Add'); ?>',
				tooltip:'<?php __('<b>Add ImsSirvItemBefore</b><br />Click here to create a new ImsSirvItemBefore'); ?>',
				icon: 'img/table_add.png',
				cls: 'x-btn-text-icon',
				handler: function(btn) {
					AddParentImsSirvItemBefore();
				}
			}, ' ', '-', ' ', {
					xtype: 'tbbutton',
					text: '<?php __('Edit'); ?>',
					id: 'edit-imsSirvItemBefore',
					tooltip:'<?php __('<b>Edit Sirv Before Item</b><br />Click here to modify the selected Sirv Before Item'); ?>',
					icon: 'img/table_edit.png',
					cls: 'x-btn-text-icon',
					disabled: true,
					handler: function(btn) {
						var sm = g.getSelectionModel();
						var sel = sm.getSelected();
						if (sm.hasSelection()){
							EditParentImsSirvItemBefore(sel.data.id);
						};
					}
				}, ' ','-',' ', {
				xtype: 'tbsplit',
				text: '<?php __('View ImsSirvItemBefore'); ?>',
				id: 'view-imsSirvItemBefore2',
				tooltip:'<?php __('<b>View ImsSirvItemBefore</b><br />Click here to see details of the selected ImsSirvItemBefore'); ?>',
				icon: 'img/table_view.png',
				cls: 'x-btn-text-icon',
				disabled: true,
				handler: function(btn) {
					var sm = g.getSelectionModel();
					var sel = sm.getSelected();
					if (sm.hasSelection()){
						ViewImsSirvItemBefore(sel.data.id);
					};
				},
				menu : {
					items: [
 {
						text: '<?php __('View Ims Tags'); ?>',
                        icon: 'img/table_view.png',
						cls: 'x-btn-text-icon',
						handler: function(btn) {
							var sm = g.getSelectionModel();
							var sel = sm.getSelected();
							if (sm.hasSelection()){
								ViewImsSirvItemBeforeImsTags(sel.data.id);
							};
						}
					}
					]
				}

            }, ' ', '->', {
				xtype: 'textfield',
				emptyText: '<?php __('[Search By Name]'); ?>',
				id: 'parent_imsSirvItemBefore_search_field',
				listeners: {
					specialkey: function(field, e){
						if (e.getKey() == e.ENTER) {
							SearchByParentImsSirvItemBeforeName(Ext.getCmp('parent_imsSirvItemBefore_search_field').getValue());
						}
					}

				}
			}, {
				xtype: 'tbbutton',
				icon: 'img/search.png',
				cls: 'x-btn-text-icon',
				text: 'GO',
				tooltip:'<?php __('<b>GO</b><br />Click here to get search results'); ?>',
				id: 'parent_imsSirvItemBefore_go_button',
				handler: function(){
					SearchByParentImsSirvItemBeforeName(Ext.getCmp('parent_imsSirvItemBefore_search_field').getValue());
				}
			}, ' '
	]}),
	bbar: new Ext.PagingToolbar({
		pageSize: list_size,
		store: store_parent_imsSirvItemBefores,
		displayInfo: true,
		displayMsg: '<?php __('Displaying {0} - {1} of {2}'); ?>',
		beforePageText: '<?php __('Page'); ?>',
		afterPageText: '<?php __('of {0}'); ?>',
		emptyMsg: '<?php __('No data to display'); ?>'
	})
});
g.getSelectionModel().on('rowselect', function(sm, rowIdx, r) {
        g.getTopToolbar().findById('view-imsSirvItemBefore2').enable();
		g.getTopToolbar().findById('edit-imsSirvItemBefore').enable();
	if(this.getSelections().length > 1){
                g.getTopToolbar().findById('view-imsSirvItemBefore2').disable();
				g.getTopToolbar().findById('edit-imsSirvItemBefore').disable();
	}
});
g.getSelectionModel().on('rowdeselect', function(sm, rowIdx, r) {
	if(this.getSelections().length > 1){
                g.getTopToolbar().findById('view-imsSirvItemBefore2').disable();
				g.getTopToolbar().findById('edit-imsSirvItemBefore').disable();
	}
	else if(this.getSelections().length == 1){
                g.getTopToolbar().findById('view-imsSirvItemBefore2').enable();
				g.getTopToolbar().findById('edit-imsSirvItemBefore').enable();
	}
	else{
                g.getTopToolbar().findById('view-imsSirvItemBefore2').disable();
				g.getTopToolbar().findById('edit-imsSirvItemBefore').disable();
	}
});



var parentImsSirvItemBeforesViewWindow = new Ext.Window({
	title: 'ImsSirvItemBefore Under the selected Item',
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
			parentImsSirvItemBeforesViewWindow.close();
		}
	}]
});

store_parent_imsSirvItemBefores.load({
    params: {
        start: 0,    
        limit: list_size
    }
});