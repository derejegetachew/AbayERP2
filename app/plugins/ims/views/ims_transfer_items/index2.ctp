var store_parent_imsTransferItems = new Ext.data.Store({
	reader: new Ext.data.JsonReader({
		root:'rows',
		totalProperty: 'results',
		fields: [
			'id','ims_transfer','ims_item','quantity','unit_price','tag','created','modified'	
		]
	}),
	proxy: new Ext.data.HttpProxy({
		url: '<?php echo $this->Html->url(array('controller' => 'imsTransferItems', 'action' => 'list_data', $parent_id)); ?>'	})
});


function AddParentImsTransferItem() {
	Ext.Ajax.request({
		url: '<?php echo $this->Html->url(array('controller' => 'imsTransferItems', 'action' => 'add', $parent_id)); ?>',
		success: function(response, opts) {
			var parent_imsTransferItem_data = response.responseText;
			
			eval(parent_imsTransferItem_data);
			
			ImsTransferItemAddWindow.show();
		},
		failure: function(response, opts) {
			Ext.Msg.alert('<?php __('Error'); ?>', '<?php __('Cannot get the imsTransferItem add form. Error code'); ?>: ' + response.status);
		}
	});
}

function EditParentImsTransferItem(id) {
	Ext.Ajax.request({
		url: '<?php echo $this->Html->url(array('controller' => 'imsTransferItems', 'action' => 'edit')); ?>/'+id+'/<?php echo $parent_id; ?>',
		success: function(response, opts) {
			var parent_imsTransferItem_data = response.responseText;
			
			eval(parent_imsTransferItem_data);
			
			ImsTransferItemEditWindow.show();
		},
		failure: function(response, opts) {
			Ext.Msg.alert('<?php __('Error'); ?>', '<?php __('Cannot get the imsTransferItem edit form. Error code'); ?>: ' + response.status);
		}
	});
}

function ViewImsTransferItem(id) {
	Ext.Ajax.request({
		url: '<?php echo $this->Html->url(array('controller' => 'imsTransferItems', 'action' => 'view')); ?>/'+id,
		success: function(response, opts) {
			var imsTransferItem_data = response.responseText;

			eval(imsTransferItem_data);

			ImsTransferItemViewWindow.show();
		},
		failure: function(response, opts) {
			Ext.Msg.alert('<?php __('Error'); ?>', '<?php __('Cannot get the imsTransferItem view form. Error code'); ?>: ' + response.status);
		}
	});
}


function DeleteParentImsTransferItem(id) {
	Ext.Ajax.request({
		url: '<?php echo $this->Html->url(array('controller' => 'imsTransferItems', 'action' => 'delete')); ?>/'+id,
		success: function(response, opts) {
			Ext.Msg.alert('<?php __('Success'); ?>', '<?php __('ImsTransferItem(s) successfully deleted!'); ?>');
			RefreshParentImsTransferItemData();
		},
		failure: function(response, opts) {
			Ext.Msg.alert('<?php __('Error'); ?>', '<?php __('Cannot get the imsTransferItem to be deleted. Error code'); ?>: ' + response.status);
		}
	});
}

function SearchByParentImsTransferItemName(value){
	var conditions = '\'ImsTransferItem.name LIKE\' => \'%' + value + '%\'';
	store_parent_imsTransferItems.reload({
		 params: {
			start: 0,
			limit: list_size,
			conditions: conditions
	    }
	});
}

function RefreshParentImsTransferItemData() {
	store_parent_imsTransferItems.reload();
}



var g = new Ext.grid.GridPanel({
	title: '<?php __('ImsTransferItems'); ?>',
	store: store_parent_imsTransferItems,
	loadMask: true,
	stripeRows: true,
	height: 300,
	anchor: '100%',
    id: 'imsTransferItemGrid',
	columns: [
		{header:"<?php __('ims_transfer'); ?>", dataIndex: 'ims_transfer', sortable: true},
		{header:"<?php __('ims_item'); ?>", dataIndex: 'ims_item', sortable: true},
		{header: "<?php __('Quantity'); ?>", dataIndex: 'quantity', sortable: true},
		{header: "<?php __('Unit Price'); ?>", dataIndex: 'unit_price', sortable: true},
		{header: "<?php __('Tag'); ?>", dataIndex: 'tag', sortable: true}
		
			],
	sm: new Ext.grid.RowSelectionModel({
		singleSelect: false
	}),
	viewConfig: {
		forceFit: true
	},
    listeners: {
        celldblclick: function(){
            ViewImsTransferItem(Ext.getCmp('imsTransferItemGrid').getSelectionModel().getSelected().data.id);
        }
    },
	tbar: new Ext.Toolbar({
		items: [{
				xtype: 'tbsplit',
				text: '<?php __('View ImsTransferItem'); ?>',
				id: 'view-imsTransferItem2',
				tooltip:'<?php __('<b>View ImsTransferItem</b><br />Click here to see details of the selected ImsTransferItem'); ?>',
				icon: 'img/table_view.png',
				cls: 'x-btn-text-icon',
				disabled: true,
				handler: function(btn) {
					var sm = g.getSelectionModel();
					var sel = sm.getSelected();
					if (sm.hasSelection()){
						ViewImsTransferItem(sel.data.id);
					};
				},
				menu : {
					items: [
					]
				}

            }, ' ', '->', {
				xtype: 'textfield',
				emptyText: '<?php __('[Search By Name]'); ?>',
				id: 'parent_imsTransferItem_search_field',
				listeners: {
					specialkey: function(field, e){
						if (e.getKey() == e.ENTER) {
							SearchByParentImsTransferItemName(Ext.getCmp('parent_imsTransferItem_search_field').getValue());
						}
					}

				}
			}, {
				xtype: 'tbbutton',
				icon: 'img/search.png',
				cls: 'x-btn-text-icon',
				text: 'GO',
				tooltip:'<?php __('<b>GO</b><br />Click here to get search results'); ?>',
				id: 'parent_imsTransferItem_go_button',
				handler: function(){
					SearchByParentImsTransferItemName(Ext.getCmp('parent_imsTransferItem_search_field').getValue());
				}
			}, ' '
	]}),
	bbar: new Ext.PagingToolbar({
		pageSize: list_size,
		store: store_parent_imsTransferItems,
		displayInfo: true,
		displayMsg: '<?php __('Displaying {0} - {1} of {2}'); ?>',
		beforePageText: '<?php __('Page'); ?>',
		afterPageText: '<?php __('of {0}'); ?>',
		emptyMsg: '<?php __('No data to display'); ?>'
	})
});
g.getSelectionModel().on('rowselect', function(sm, rowIdx, r) {
        g.getTopToolbar().findById('view-imsTransferItem2').enable();
	if(this.getSelections().length > 1){
                g.getTopToolbar().findById('view-imsTransferItem2').disable();
	}
});
g.getSelectionModel().on('rowdeselect', function(sm, rowIdx, r) {
	if(this.getSelections().length > 1){
                g.getTopToolbar().findById('view-imsTransferItem2').disable();
	}
	else if(this.getSelections().length == 1){
                g.getTopToolbar().findById('view-imsTransferItem2').enable();
	}
	else{
                g.getTopToolbar().findById('view-imsTransferItem2').disable();
	}
});



var parentImsTransferItemsViewWindow = new Ext.Window({
	title: 'ImsTransferItem Under the selected Item',
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
			parentImsTransferItemsViewWindow.close();
		}
	}]
});

store_parent_imsTransferItems.load({
    params: {
        start: 0,    
        limit: list_size
    }
});