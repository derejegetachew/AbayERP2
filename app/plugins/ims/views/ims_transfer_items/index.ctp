
var store_imsTransferItems = new Ext.data.GroupingStore({
	reader: new Ext.data.JsonReader({
		root:'rows',
		totalProperty: 'results',
		fields: [
			'id','ims_transfer','ims_item','quantity','unit_price','created','modified'		]
	}),
	proxy: new Ext.data.HttpProxy({
		url: '<?php echo $this->Html->url(array('controller' => 'imsTransferItems', 'action' => 'list_data')); ?>'
	})
,	sortInfo:{field: 'ims_transfer', direction: "ASC
});


function AddImsTransferItem() {
	Ext.Ajax.request({
		url: '<?php echo $this->Html->url(array('controller' => 'imsTransferItems', 'action' => 'add')); ?>',
		success: function(response, opts) {
			var imsTransferItem_data = response.responseText;
			
			eval(imsTransferItem_data);
			
			ImsTransferItemAddWindow.show();
		},
		failure: function(response, opts) {
			Ext.Msg.alert('<?php __('Error'); ?>', '<?php __('Cannot get the imsTransferItem add form. Error code'); ?>: ' + response.status);
		}
	});
}

function EditImsTransferItem(id) {
	Ext.Ajax.request({
		url: '<?php echo $this->Html->url(array('controller' => 'imsTransferItems', 'action' => 'edit')); ?>/'+id,
		success: function(response, opts) {
			var imsTransferItem_data = response.responseText;
			
			eval(imsTransferItem_data);
			
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

function DeleteImsTransferItem(id) {
	Ext.Ajax.request({
		url: '<?php echo $this->Html->url(array('controller' => 'imsTransferItems', 'action' => 'delete')); ?>/'+id,
		success: function(response, opts) {
			Ext.Msg.alert('<?php __('Success'); ?>', '<?php __('ImsTransferItem successfully deleted!'); ?>');
			RefreshImsTransferItemData();
		},
		failure: function(response, opts) {
			Ext.Msg.alert('<?php __('Error'); ?>', '<?php __('Cannot get the imsTransferItem add form. Error code'); ?>: ' + response.status);
		}
	});
}

function SearchImsTransferItem(){
	Ext.Ajax.request({
		url: '<?php echo $this->Html->url(array('controller' => 'imsTransferItems', 'action' => 'search')); ?>',
		success: function(response, opts){
			var imsTransferItem_data = response.responseText;

			eval(imsTransferItem_data);

			imsTransferItemSearchWindow.show();
		},
		failure: function(response, opts) {
			Ext.Msg.alert('<?php __('Error'); ?>','<?php __('Cannot get the imsTransferItem search form. Error Code'); ?>: ' + response.status);
		}
	});
}

function SearchByImsTransferItemName(value){
	var conditions = '\'ImsTransferItem.name LIKE\' => \'%' + value + '%\'';
	store_imsTransferItems.reload({
		 params: {
			start: 0,
			limit: list_size,
			conditions: conditions
	    }
	});
}

function RefreshImsTransferItemData() {
	store_imsTransferItems.reload();
}


if(center_panel.find('id', 'imsTransferItem-tab') != "") {
	var p = center_panel.findById('imsTransferItem-tab');
	center_panel.setActiveTab(p);
} else {
	var p = center_panel.add({
		title: '<?php __('Ims Transfer Items'); ?>',
		closable: true,
		loadMask: true,
		stripeRows: true,
		id: 'imsTransferItem-tab',
		xtype: 'grid',
		store: store_imsTransferItems,
		columns: [
			{header: "<?php __('ImsTransfer'); ?>", dataIndex: 'ims_transfer', sortable: true},
			{header: "<?php __('ImsItem'); ?>", dataIndex: 'ims_item', sortable: true},
			{header: "<?php __('Quantity'); ?>", dataIndex: 'quantity', sortable: true},
			{header: "<?php __('Unit Price'); ?>", dataIndex: 'unit_price', sortable: true},
			{header: "<?php __('Created'); ?>", dataIndex: 'created', sortable: true},
			{header: "<?php __('Modified'); ?>", dataIndex: 'modified', sortable: true}
		],
		
		view: new Ext.grid.GroupingView({
            forceFit:true,
            groupTextTpl: '{text} ({[values.rs.length]} {[values.rs.length > 1 ? "ImsTransferItems" : "ImsTransferItem"]})'
        })
,
		listeners: {
			celldblclick: function(){
				ViewImsTransferItem(Ext.getCmp('imsTransferItem-tab').getSelectionModel().getSelected().data.id);
			}
		},
		sm: new Ext.grid.RowSelectionModel({
			singleSelect: false
		}),
		tbar: new Ext.Toolbar({
			
			items: [{
					xtype: 'tbbutton',
					text: '<?php __('Add'); ?>',
					tooltip:'<?php __('<b>Add ImsTransferItems</b><br />Click here to create a new ImsTransferItem'); ?>',
					icon: 'img/table_add.png',
					cls: 'x-btn-text-icon',
					handler: function(btn) {
						AddImsTransferItem();
					}
				}, ' ', '-', ' ', {
					xtype: 'tbbutton',
					text: '<?php __('Edit'); ?>',
					id: 'edit-imsTransferItem',
					tooltip:'<?php __('<b>Edit ImsTransferItems</b><br />Click here to modify the selected ImsTransferItem'); ?>',
					icon: 'img/table_edit.png',
					cls: 'x-btn-text-icon',
					disabled: true,
					handler: function(btn) {
						var sm = p.getSelectionModel();
						var sel = sm.getSelected();
						if (sm.hasSelection()){
							EditImsTransferItem(sel.data.id);
						};
					}
				}, ' ', '-', ' ', {
					xtype: 'tbbutton',
					text: '<?php __('Delete'); ?>',
					id: 'delete-imsTransferItem',
					tooltip:'<?php __('<b>Delete ImsTransferItems(s)</b><br />Click here to remove the selected ImsTransferItem(s)'); ?>',
					icon: 'img/table_delete.png',
					cls: 'x-btn-text-icon',
					disabled: true,
					handler: function(btn) {
						var sm = p.getSelectionModel();
						var sel = sm.getSelections();
						if (sm.hasSelection()){
							if(sel.length==1){
								Ext.Msg.show({
									title: '<?php __('Remove ImsTransferItem'); ?>',
									buttons: Ext.MessageBox.YESNO,
									msg: '<?php __('Remove'); ?> '+sel[0].data.name+'?',
									icon: Ext.MessageBox.QUESTION,
									fn: function(btn){
										if (btn == 'yes'){
											DeleteImsTransferItem(sel[0].data.id);
										}
									}
								});
							}else{
								Ext.Msg.show({
									title: '<?php __('Remove ImsTransferItem'); ?>',
									buttons: Ext.MessageBox.YESNO,
									msg: '<?php __('Remove the selected ImsTransferItems'); ?>?',
									icon: Ext.MessageBox.QUESTION,
									fn: function(btn){
										if (btn == 'yes'){
											var sel_ids = '';
											for(i=0;i<sel.length;i++){
												if(i>0)
													sel_ids += '_';
												sel_ids += sel[i].data.id;
											}
											DeleteImsTransferItem(sel_ids);
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
					text: '<?php __('View ImsTransferItem'); ?>',
					id: 'view-imsTransferItem',
					tooltip:'<?php __('<b>View ImsTransferItem</b><br />Click here to see details of the selected ImsTransferItem'); ?>',
					icon: 'img/table_view.png',
					cls: 'x-btn-text-icon',
					disabled: true,
					handler: function(btn) {
						var sm = p.getSelectionModel();
						var sel = sm.getSelected();
						if (sm.hasSelection()){
							ViewImsTransferItem(sel.data.id);
						};
					},
					menu : {
						items: [
						]
					}
				}, ' ', '-',  '<?php __('ImsTransfer'); ?>: ', {
					xtype : 'combo',
					emptyText: 'All',
					store : new Ext.data.ArrayStore({
						fields : ['id', 'name'],
						data : [
							['-1', 'All'],
							<?php $st = false;foreach ($imstransfers as $item){if($st) echo ",
							";?>['<?php echo $item['ImsTransfer']['id']; ?>' ,'<?php echo $item['ImsTransfer']['name']; ?>']<?php $st = true;}?>						]
					}),
					displayField : 'name',
					valueField : 'id',
					mode : 'local',
					value : '-1',
					disableKeyFilter : true,
					triggerAction: 'all',
					listeners : {
						select : function(combo, record, index){
							store_imsTransferItems.reload({
								params: {
									start: 0,
									limit: list_size,
									imstransfer_id : combo.getValue()
								}
							});
						}
					}
				},
 '->', {
					xtype: 'textfield',
					emptyText: '<?php __('[Search By Name]'); ?>',
					id: 'imsTransferItem_search_field',
					listeners: {
						specialkey: function(field, e){
							if (e.getKey() == e.ENTER) {
								SearchByImsTransferItemName(Ext.getCmp('imsTransferItem_search_field').getValue());
							}
						}
					}
				}, {
					xtype: 'tbbutton',
					icon: 'img/search.png',
					cls: 'x-btn-text-icon',
					text: '<?php __('GO'); ?>',
                    tooltip:'<?php __('<b>GO</b><br />Click here to get search results'); ?>',
					id: 'imsTransferItem_go_button',
					handler: function(){
						SearchByImsTransferItemName(Ext.getCmp('imsTransferItem_search_field').getValue());
					}
				}, '-', {
					xtype: 'tbbutton',
					icon: 'img/table_search.png',
					cls: 'x-btn-text-icon',
					text: '<?php __('Advanced Search'); ?>',
                    tooltip:'<?php __('<b>Advanced Search...</b><br />Click here to get the advanced search form'); ?>',
					handler: function(){
						SearchImsTransferItem();
					}
				}
		]}),
		bbar: new Ext.PagingToolbar({
			pageSize: list_size,
			store: store_imsTransferItems,
			displayInfo: true,
			displayMsg: '<?php __('Displaying {0} - {1} of {2}'); ?>',
			beforePageText: '<?php __('Page'); ?>',
			afterPageText: '<?php __('of {0}'); ?>',
			emptyMsg: '<?php __('No data to display'); ?>'
		})
	});
	p.getSelectionModel().on('rowselect', function(sm, rowIdx, r) {
		p.getTopToolbar().findById('edit-imsTransferItem').enable();
		p.getTopToolbar().findById('delete-imsTransferItem').enable();
		p.getTopToolbar().findById('view-imsTransferItem').enable();
		if(this.getSelections().length > 1){
			p.getTopToolbar().findById('edit-imsTransferItem').disable();
			p.getTopToolbar().findById('view-imsTransferItem').disable();
		}
	});
	p.getSelectionModel().on('rowdeselect', function(sm, rowIdx, r) {
		if(this.getSelections().length > 1){
			p.getTopToolbar().findById('edit-imsTransferItem').disable();
			p.getTopToolbar().findById('view-imsTransferItem').disable();
			p.getTopToolbar().findById('delete-imsTransferItem').enable();
		}
		else if(this.getSelections().length == 1){
			p.getTopToolbar().findById('edit-imsTransferItem').enable();
			p.getTopToolbar().findById('view-imsTransferItem').enable();
			p.getTopToolbar().findById('delete-imsTransferItem').enable();
		}
		else{
			p.getTopToolbar().findById('edit-imsTransferItem').disable();
			p.getTopToolbar().findById('view-imsTransferItem').disable();
			p.getTopToolbar().findById('delete-imsTransferItem').disable();
		}
	});
	center_panel.setActiveTab(p);
	
	store_imsTransferItems.load({
		params: {
			start: 0,          
			limit: list_size
		}
	});
	
}
