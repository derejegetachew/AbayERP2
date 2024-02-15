
var store_grnItems = new Ext.data.GroupingStore({
	reader: new Ext.data.JsonReader({
		root:'rows',
		totalProperty: 'results',
		fields: [
			'id','grn','purchase_order_item','quantity','unit_price','created','modified'		]
	}),
	proxy: new Ext.data.HttpProxy({
		url: '<?php echo $this->Html->url(array('controller' => 'grnItems', 'action' => 'list_data')); ?>'
	})
,	sortInfo:{field: 'grn_id', direction: "ASC"},
	groupField: 'purchase_order_item_id'
});


function AddGrnItem() {
	Ext.Ajax.request({
		url: '<?php echo $this->Html->url(array('controller' => 'grnItems', 'action' => 'add')); ?>',
		success: function(response, opts) {
			var grnItem_data = response.responseText;
			
			eval(grnItem_data);
			
			GrnItemAddWindow.show();
		},
		failure: function(response, opts) {
			Ext.Msg.alert('<?php __('Error'); ?>', '<?php __('Cannot get the grnItem add form. Error code'); ?>: ' + response.status);
		}
	});
}

function EditGrnItem(id) {
	Ext.Ajax.request({
		url: '<?php echo $this->Html->url(array('controller' => 'grnItems', 'action' => 'edit')); ?>/'+id,
		success: function(response, opts) {
			var grnItem_data = response.responseText;
			
			eval(grnItem_data);
			
			GrnItemEditWindow.show();
		},
		failure: function(response, opts) {
			Ext.Msg.alert('<?php __('Error'); ?>', '<?php __('Cannot get the grnItem edit form. Error code'); ?>: ' + response.status);
		}
	});
}

function ViewGrnItem(id) {
    Ext.Ajax.request({
        url: '<?php echo $this->Html->url(array('controller' => 'grnItems', 'action' => 'view')); ?>/'+id,
        success: function(response, opts) {
            var grnItem_data = response.responseText;

            eval(grnItem_data);

            GrnItemViewWindow.show();
        },
        failure: function(response, opts) {
            Ext.Msg.alert('<?php __('Error'); ?>', '<?php __('Cannot get the grnItem view form. Error code'); ?>: ' + response.status);
        }
    });
}
function ViewParentStores(id) {
    Ext.Ajax.request({
        url: '<?php echo $this->Html->url(array('controller' => 'stores', 'action' => 'index2')); ?>/'+id,
        success: function(response, opts) {
            var parent_stores_data = response.responseText;

            eval(parent_stores_data);

            parentStoresViewWindow.show();
        },
        failure: function(response, opts) {
            Ext.Msg.alert('<?php __('Error'); ?>', '<?php __('Cannot get the campus view form. Error code'); ?>: ' + response.status);
        }
    });
}


function DeleteGrnItem(id) {
	Ext.Ajax.request({
		url: '<?php echo $this->Html->url(array('controller' => 'grnItems', 'action' => 'delete')); ?>/'+id,
		success: function(response, opts) {
			Ext.Msg.alert('<?php __('Success'); ?>', '<?php __('GrnItem successfully deleted!'); ?>');
			RefreshGrnItemData();
		},
		failure: function(response, opts) {
			Ext.Msg.alert('<?php __('Error'); ?>', '<?php __('Cannot get the grnItem add form. Error code'); ?>: ' + response.status);
		}
	});
}

function SearchGrnItem(){
	Ext.Ajax.request({
		url: '<?php echo $this->Html->url(array('controller' => 'grnItems', 'action' => 'search')); ?>',
		success: function(response, opts){
			var grnItem_data = response.responseText;

			eval(grnItem_data);

			grnItemSearchWindow.show();
		},
		failure: function(response, opts) {
			Ext.Msg.alert('<?php __('Error'); ?>','<?php __('Cannot get the grnItem search form. Error Code'); ?>: ' + response.status);
		}
	});
}

function SearchByGrnItemName(value){
	var conditions = '\'GrnItem.name LIKE\' => \'%' + value + '%\'';
	store_grnItems.reload({
		 params: {
			start: 0,
			limit: list_size,
			conditions: conditions
	    }
	});
}

function RefreshGrnItemData() {
	store_grnItems.reload();
}


if(center_panel.find('id', 'grnItem-tab') != "") {
	var p = center_panel.findById('grnItem-tab');
	center_panel.setActiveTab(p);
} else {
	var p = center_panel.add({
		title: '<?php __('Grn Items'); ?>',
		closable: true,
		loadMask: true,
		stripeRows: true,
		id: 'grnItem-tab',
		xtype: 'grid',
		store: store_grnItems,
		columns: [
			{header: "<?php __('Grn'); ?>", dataIndex: 'grn', sortable: true},
			{header: "<?php __('PurchaseOrderItem'); ?>", dataIndex: 'purchase_order_item', sortable: true},
			{header: "<?php __('Quantity'); ?>", dataIndex: 'quantity', sortable: true},
			{header: "<?php __('Unit Price'); ?>", dataIndex: 'unit_price', sortable: true},
			{header: "<?php __('Created'); ?>", dataIndex: 'created', sortable: true},
			{header: "<?php __('Modified'); ?>", dataIndex: 'modified', sortable: true}
		],
		
		view: new Ext.grid.GroupingView({
            forceFit:true,
            groupTextTpl: '{text} ({[values.rs.length]} {[values.rs.length > 1 ? "GrnItems" : "GrnItem"]})'
        })
,
		listeners: {
			celldblclick: function(){
				ViewGrnItem(Ext.getCmp('grnItem-tab').getSelectionModel().getSelected().data.id);
			}
		},
		sm: new Ext.grid.RowSelectionModel({
			singleSelect: false
		}),
		tbar: new Ext.Toolbar({
			
			items: [{
					xtype: 'tbbutton',
					text: '<?php __('Add'); ?>',
					tooltip:'<?php __('<b>Add GrnItems</b><br />Click here to create a new GrnItem'); ?>',
					icon: 'img/table_add.png',
					cls: 'x-btn-text-icon',
					handler: function(btn) {
						AddGrnItem();
					}
				}, ' ', '-', ' ', {
					xtype: 'tbbutton',
					text: '<?php __('Edit'); ?>',
					id: 'edit-grnItem',
					tooltip:'<?php __('<b>Edit GrnItems</b><br />Click here to modify the selected GrnItem'); ?>',
					icon: 'img/table_edit.png',
					cls: 'x-btn-text-icon',
					disabled: true,
					handler: function(btn) {
						var sm = p.getSelectionModel();
						var sel = sm.getSelected();
						if (sm.hasSelection()){
							EditGrnItem(sel.data.id);
						};
					}
				}, ' ', '-', ' ', {
					xtype: 'tbbutton',
					text: '<?php __('Delete'); ?>',
					id: 'delete-grnItem',
					tooltip:'<?php __('<b>Delete GrnItems(s)</b><br />Click here to remove the selected GrnItem(s)'); ?>',
					icon: 'img/table_delete.png',
					cls: 'x-btn-text-icon',
					disabled: true,
					handler: function(btn) {
						var sm = p.getSelectionModel();
						var sel = sm.getSelections();
						if (sm.hasSelection()){
							if(sel.length==1){
								Ext.Msg.show({
									title: '<?php __('Remove GrnItem'); ?>',
									buttons: Ext.MessageBox.YESNO,
									msg: '<?php __('Remove'); ?> '+sel[0].data.name+'?',
									icon: Ext.MessageBox.QUESTION,
									fn: function(btn){
										if (btn == 'yes'){
											DeleteGrnItem(sel[0].data.id);
										}
									}
								});
							}else{
								Ext.Msg.show({
									title: '<?php __('Remove GrnItem'); ?>',
									buttons: Ext.MessageBox.YESNO,
									msg: '<?php __('Remove the selected GrnItems'); ?>?',
									icon: Ext.MessageBox.QUESTION,
									fn: function(btn){
										if (btn == 'yes'){
											var sel_ids = '';
											for(i=0;i<sel.length;i++){
												if(i>0)
													sel_ids += '_';
												sel_ids += sel[i].data.id;
											}
											DeleteGrnItem(sel_ids);
										}
									}
								});
							}
						} else {
							Ext.Msg.alert('<?php __('Warning'); ?>', '<?php __('Please select a record first'); ?>');
						};
					}
				}, ' ', '-', ' ', {
					xtype: 'tbsplit',
					text: '<?php __('View GrnItem'); ?>',
					id: 'view-grnItem',
					tooltip:'<?php __('<b>View GrnItem</b><br />Click here to see details of the selected GrnItem'); ?>',
					icon: 'img/table_view.png',
					cls: 'x-btn-text-icon',
					disabled: true,
					handler: function(btn) {
						var sm = p.getSelectionModel();
						var sel = sm.getSelected();
						if (sm.hasSelection()){
							ViewGrnItem(sel.data.id);
						};
					},
					menu : {
						items: [
{
							text: '<?php __('View Stores'); ?>',
                            icon: 'img/table_view.png',
							cls: 'x-btn-text-icon',
							handler: function(btn) {
								var sm = p.getSelectionModel();
								var sel = sm.getSelected();
								if (sm.hasSelection()){
									ViewParentStores(sel.data.id);
								};
							}
						}
						]
					}
				}, ' ', '-',  '<?php __('Grn'); ?>: ', {
					xtype : 'combo',
					emptyText: 'All',
					store : new Ext.data.ArrayStore({
						fields : ['id', 'name'],
						data : [
							['-1', 'All'],
							<?php $st = false;foreach ($grns as $item){if($st) echo ",
							";?>['<?php echo $item['Grn']['id']; ?>' ,'<?php echo $item['Grn']['name']; ?>']<?php $st = true;}?>						]
					}),
					displayField : 'name',
					valueField : 'id',
					mode : 'local',
					value : '-1',
					disableKeyFilter : true,
					triggerAction: 'all',
					listeners : {
						select : function(combo, record, index){
							store_grnItems.reload({
								params: {
									start: 0,
									limit: list_size,
									grn_id : combo.getValue()
								}
							});
						}
					}
				},
 '->', {
					xtype: 'textfield',
					emptyText: '<?php __('[Search By Name]'); ?>',
					id: 'grnItem_search_field',
					listeners: {
						specialkey: function(field, e){
							if (e.getKey() == e.ENTER) {
								SearchByGrnItemName(Ext.getCmp('grnItem_search_field').getValue());
							}
						}
					}
				}, {
					xtype: 'tbbutton',
					icon: 'img/search.png',
					cls: 'x-btn-text-icon',
					text: '<?php __('GO'); ?>',
                    tooltip:'<?php __('<b>GO</b><br />Click here to get search results'); ?>',
					id: 'grnItem_go_button',
					handler: function(){
						SearchByGrnItemName(Ext.getCmp('grnItem_search_field').getValue());
					}
				}, '-', {
					xtype: 'tbbutton',
					icon: 'img/table_search.png',
					cls: 'x-btn-text-icon',
					text: '<?php __('Advanced Search'); ?>',
                    tooltip:'<?php __('<b>Advanced Search...</b><br />Click here to get the advanced search form'); ?>',
					handler: function(){
						SearchGrnItem();
					}
				}
		]}),
		bbar: new Ext.PagingToolbar({
			pageSize: list_size,
			store: store_grnItems,
			displayInfo: true,
			displayMsg: '<?php __('Displaying {0} - {1} of {2}'); ?>',
			beforePageText: '<?php __('Page'); ?>',
			afterPageText: '<?php __('of {0}'); ?>',
			emptyMsg: '<?php __('No data to display'); ?>'
		})
	});
	p.getSelectionModel().on('rowselect', function(sm, rowIdx, r) {
		p.getTopToolbar().findById('edit-grnItem').enable();
		p.getTopToolbar().findById('delete-grnItem').enable();
		p.getTopToolbar().findById('view-grnItem').enable();
		if(this.getSelections().length > 1){
			p.getTopToolbar().findById('edit-grnItem').disable();
			p.getTopToolbar().findById('view-grnItem').disable();
		}
	});
	p.getSelectionModel().on('rowdeselect', function(sm, rowIdx, r) {
		if(this.getSelections().length > 1){
			p.getTopToolbar().findById('edit-grnItem').disable();
			p.getTopToolbar().findById('view-grnItem').disable();
			p.getTopToolbar().findById('delete-grnItem').enable();
		}
		else if(this.getSelections().length == 1){
			p.getTopToolbar().findById('edit-grnItem').enable();
			p.getTopToolbar().findById('view-grnItem').enable();
			p.getTopToolbar().findById('delete-grnItem').enable();
		}
		else{
			p.getTopToolbar().findById('edit-grnItem').disable();
			p.getTopToolbar().findById('view-grnItem').disable();
			p.getTopToolbar().findById('delete-grnItem').disable();
		}
	});
	center_panel.setActiveTab(p);
	
	store_grnItems.load({
		params: {
			start: 0,          
			limit: list_size
		}
	});
	
}
