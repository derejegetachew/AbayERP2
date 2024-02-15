
var store_imsStoresItems = new Ext.data.GroupingStore({
	reader: new Ext.data.JsonReader({
		root:'rows',
		totalProperty: 'results',
		fields: [
			'id','ims_store','ims_item','balance','created','modified'		]
	}),
	proxy: new Ext.data.HttpProxy({
		url: '<?php echo $this->Html->url(array('controller' => 'imsStoresItems', 'action' => 'list_data')); ?>'
	})
,	sortInfo:{field: 'ims_store_id', direction: "ASC"},
	groupField: 'ims_item_id'
});


function AddImsStoresItem() {
	Ext.Ajax.request({
		url: '<?php echo $this->Html->url(array('controller' => 'imsStoresItems', 'action' => 'add')); ?>',
		success: function(response, opts) {
			var imsStoresItem_data = response.responseText;
			
			eval(imsStoresItem_data);
			
			ImsStoresItemAddWindow.show();
		},
		failure: function(response, opts) {
			Ext.Msg.alert('<?php __('Error'); ?>', '<?php __('Cannot get the imsStoresItem add form. Error code'); ?>: ' + response.status);
		}
	});
}

function EditImsStoresItem(id) {
	Ext.Ajax.request({
		url: '<?php echo $this->Html->url(array('controller' => 'imsStoresItems', 'action' => 'edit')); ?>/'+id,
		success: function(response, opts) {
			var imsStoresItem_data = response.responseText;
			
			eval(imsStoresItem_data);
			
			ImsStoresItemEditWindow.show();
		},
		failure: function(response, opts) {
			Ext.Msg.alert('<?php __('Error'); ?>', '<?php __('Cannot get the imsStoresItem edit form. Error code'); ?>: ' + response.status);
		}
	});
}

function ViewImsStoresItem(id) {
    Ext.Ajax.request({
        url: '<?php echo $this->Html->url(array('controller' => 'imsStoresItems', 'action' => 'view')); ?>/'+id,
        success: function(response, opts) {
            var imsStoresItem_data = response.responseText;

            eval(imsStoresItem_data);

            ImsStoresItemViewWindow.show();
        },
        failure: function(response, opts) {
            Ext.Msg.alert('<?php __('Error'); ?>', '<?php __('Cannot get the imsStoresItem view form. Error code'); ?>: ' + response.status);
        }
    });
}

function DeleteImsStoresItem(id) {
	Ext.Ajax.request({
		url: '<?php echo $this->Html->url(array('controller' => 'imsStoresItems', 'action' => 'delete')); ?>/'+id,
		success: function(response, opts) {
			Ext.Msg.alert('<?php __('Success'); ?>', '<?php __('ImsStoresItem successfully deleted!'); ?>');
			RefreshImsStoresItemData();
		},
		failure: function(response, opts) {
			Ext.Msg.alert('<?php __('Error'); ?>', '<?php __('Cannot get the imsStoresItem add form. Error code'); ?>: ' + response.status);
		}
	});
}

function SearchImsStoresItem(){
	Ext.Ajax.request({
		url: '<?php echo $this->Html->url(array('controller' => 'imsStoresItems', 'action' => 'search')); ?>',
		success: function(response, opts){
			var imsStoresItem_data = response.responseText;

			eval(imsStoresItem_data);

			imsStoresItemSearchWindow.show();
		},
		failure: function(response, opts) {
			Ext.Msg.alert('<?php __('Error'); ?>','<?php __('Cannot get the imsStoresItem search form. Error Code'); ?>: ' + response.status);
		}
	});
}

function SearchByImsStoresItemName(value){
	var conditions = '\'ImsStoresItem.name LIKE\' => \'%' + value + '%\'';
	store_imsStoresItems.reload({
		 params: {
			start: 0,
			limit: list_size,
			conditions: conditions
	    }
	});
}

function RefreshImsStoresItemData() {
	store_imsStoresItems.reload();
}


if(center_panel.find('id', 'imsStoresItem-tab') != "") {
	var p = center_panel.findById('imsStoresItem-tab');
	center_panel.setActiveTab(p);
} else {
	var p = center_panel.add({
		title: '<?php __('Ims Stores Items'); ?>',
		closable: true,
		loadMask: true,
		stripeRows: true,
		id: 'imsStoresItem-tab',
		xtype: 'grid',
		store: store_imsStoresItems,
		columns: [
			{header: "<?php __('ImsStore'); ?>", dataIndex: 'ims_store', sortable: true},
			{header: "<?php __('ImsItem'); ?>", dataIndex: 'ims_item', sortable: true},
			{header: "<?php __('Balance'); ?>", dataIndex: 'balance', sortable: true},
			{header: "<?php __('Created'); ?>", dataIndex: 'created', sortable: true},
			{header: "<?php __('Modified'); ?>", dataIndex: 'modified', sortable: true}
		],
		
		view: new Ext.grid.GroupingView({
            forceFit:true,
            groupTextTpl: '{text} ({[values.rs.length]} {[values.rs.length > 1 ? "ImsStoresItems" : "ImsStoresItem"]})'
        })
,
		listeners: {
			celldblclick: function(){
				ViewImsStoresItem(Ext.getCmp('imsStoresItem-tab').getSelectionModel().getSelected().data.id);
			}
		},
		sm: new Ext.grid.RowSelectionModel({
			singleSelect: false
		}),
		tbar: new Ext.Toolbar({
			
			items: [{
					xtype: 'tbbutton',
					text: '<?php __('Add'); ?>',
					tooltip:'<?php __('<b>Add ImsStoresItems</b><br />Click here to create a new ImsStoresItem'); ?>',
					icon: 'img/table_add.png',
					cls: 'x-btn-text-icon',
					handler: function(btn) {
						AddImsStoresItem();
					}
				}, ' ', '-', ' ', {
					xtype: 'tbbutton',
					text: '<?php __('Edit'); ?>',
					id: 'edit-imsStoresItem',
					tooltip:'<?php __('<b>Edit ImsStoresItems</b><br />Click here to modify the selected ImsStoresItem'); ?>',
					icon: 'img/table_edit.png',
					cls: 'x-btn-text-icon',
					disabled: true,
					handler: function(btn) {
						var sm = p.getSelectionModel();
						var sel = sm.getSelected();
						if (sm.hasSelection()){
							EditImsStoresItem(sel.data.id);
						};
					}
				}, ' ', '-', ' ', {
					xtype: 'tbbutton',
					text: '<?php __('Delete'); ?>',
					id: 'delete-imsStoresItem',
					tooltip:'<?php __('<b>Delete ImsStoresItems(s)</b><br />Click here to remove the selected ImsStoresItem(s)'); ?>',
					icon: 'img/table_delete.png',
					cls: 'x-btn-text-icon',
					disabled: true,
					handler: function(btn) {
						var sm = p.getSelectionModel();
						var sel = sm.getSelections();
						if (sm.hasSelection()){
							if(sel.length==1){
								Ext.Msg.show({
									title: '<?php __('Remove ImsStoresItem'); ?>',
									buttons: Ext.MessageBox.YESNO,
									msg: '<?php __('Remove'); ?> '+sel[0].data.name+'?',
									icon: Ext.MessageBox.QUESTION,
									fn: function(btn){
										if (btn == 'yes'){
											DeleteImsStoresItem(sel[0].data.id);
										}
									}
								});
							}else{
								Ext.Msg.show({
									title: '<?php __('Remove ImsStoresItem'); ?>',
									buttons: Ext.MessageBox.YESNO,
									msg: '<?php __('Remove the selected ImsStoresItems'); ?>?',
									icon: Ext.MessageBox.QUESTION,
									fn: function(btn){
										if (btn == 'yes'){
											var sel_ids = '';
											for(i=0;i<sel.length;i++){
												if(i>0)
													sel_ids += '_';
												sel_ids += sel[i].data.id;
											}
											DeleteImsStoresItem(sel_ids);
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
					text: '<?php __('View ImsStoresItem'); ?>',
					id: 'view-imsStoresItem',
					tooltip:'<?php __('<b>View ImsStoresItem</b><br />Click here to see details of the selected ImsStoresItem'); ?>',
					icon: 'img/table_view.png',
					cls: 'x-btn-text-icon',
					disabled: true,
					handler: function(btn) {
						var sm = p.getSelectionModel();
						var sel = sm.getSelected();
						if (sm.hasSelection()){
							ViewImsStoresItem(sel.data.id);
						};
					},
					menu : {
						items: [
						]
					}
				}, ' ', '-',  '<?php __('ImsStore'); ?>: ', {
					xtype : 'combo',
					emptyText: 'All',
					store : new Ext.data.ArrayStore({
						fields : ['id', 'name'],
						data : [
							['-1', 'All'],
							<?php $st = false;foreach ($imsstores as $item){if($st) echo ",
							";?>['<?php echo $item['ImsStore']['id']; ?>' ,'<?php echo $item['ImsStore']['name']; ?>']<?php $st = true;}?>						]
					}),
					displayField : 'name',
					valueField : 'id',
					mode : 'local',
					value : '-1',
					disableKeyFilter : true,
					triggerAction: 'all',
					listeners : {
						select : function(combo, record, index){
							store_imsStoresItems.reload({
								params: {
									start: 0,
									limit: list_size,
									imsstore_id : combo.getValue()
								}
							});
						}
					}
				},
 '->', {
					xtype: 'textfield',
					emptyText: '<?php __('[Search By Name]'); ?>',
					id: 'imsStoresItem_search_field',
					listeners: {
						specialkey: function(field, e){
							if (e.getKey() == e.ENTER) {
								SearchByImsStoresItemName(Ext.getCmp('imsStoresItem_search_field').getValue());
							}
						}
					}
				}, {
					xtype: 'tbbutton',
					icon: 'img/search.png',
					cls: 'x-btn-text-icon',
					text: '<?php __('GO'); ?>',
                    tooltip:'<?php __('<b>GO</b><br />Click here to get search results'); ?>',
					id: 'imsStoresItem_go_button',
					handler: function(){
						SearchByImsStoresItemName(Ext.getCmp('imsStoresItem_search_field').getValue());
					}
				}, '-', {
					xtype: 'tbbutton',
					icon: 'img/table_search.png',
					cls: 'x-btn-text-icon',
					text: '<?php __('Advanced Search'); ?>',
                    tooltip:'<?php __('<b>Advanced Search...</b><br />Click here to get the advanced search form'); ?>',
					handler: function(){
						SearchImsStoresItem();
					}
				}
		]}),
		bbar: new Ext.PagingToolbar({
			pageSize: list_size,
			store: store_imsStoresItems,
			displayInfo: true,
			displayMsg: '<?php __('Displaying {0} - {1} of {2}'); ?>',
			beforePageText: '<?php __('Page'); ?>',
			afterPageText: '<?php __('of {0}'); ?>',
			emptyMsg: '<?php __('No data to display'); ?>'
		})
	});
	p.getSelectionModel().on('rowselect', function(sm, rowIdx, r) {
		p.getTopToolbar().findById('edit-imsStoresItem').enable();
		p.getTopToolbar().findById('delete-imsStoresItem').enable();
		p.getTopToolbar().findById('view-imsStoresItem').enable();
		if(this.getSelections().length > 1){
			p.getTopToolbar().findById('edit-imsStoresItem').disable();
			p.getTopToolbar().findById('view-imsStoresItem').disable();
		}
	});
	p.getSelectionModel().on('rowdeselect', function(sm, rowIdx, r) {
		if(this.getSelections().length > 1){
			p.getTopToolbar().findById('edit-imsStoresItem').disable();
			p.getTopToolbar().findById('view-imsStoresItem').disable();
			p.getTopToolbar().findById('delete-imsStoresItem').enable();
		}
		else if(this.getSelections().length == 1){
			p.getTopToolbar().findById('edit-imsStoresItem').enable();
			p.getTopToolbar().findById('view-imsStoresItem').enable();
			p.getTopToolbar().findById('delete-imsStoresItem').enable();
		}
		else{
			p.getTopToolbar().findById('edit-imsStoresItem').disable();
			p.getTopToolbar().findById('view-imsStoresItem').disable();
			p.getTopToolbar().findById('delete-imsStoresItem').disable();
		}
	});
	center_panel.setActiveTab(p);
	
	store_imsStoresItems.load({
		params: {
			start: 0,          
			limit: list_size
		}
	});
	
}
