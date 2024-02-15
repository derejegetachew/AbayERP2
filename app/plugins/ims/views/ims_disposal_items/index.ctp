
var store_imsDisposalItems = new Ext.data.GroupingStore({
	reader: new Ext.data.JsonReader({
		root:'rows',
		totalProperty: 'results',
		fields: [
			'id','ims_disposal','ims_item','measurement','quantity','remark','created','modified'		]
	}),
	proxy: new Ext.data.HttpProxy({
		url: '<?php echo $this->Html->url(array('controller' => 'imsDisposalItems', 'action' => 'list_data')); ?>'
	})
,	sortInfo:{field: 'ims_disposal_id', direction: "ASC"},
	groupField: 'ims_item_id'
});


function AddImsDisposalItem() {
	Ext.Ajax.request({
		url: '<?php echo $this->Html->url(array('controller' => 'imsDisposalItems', 'action' => 'add')); ?>',
		success: function(response, opts) {
			var imsDisposalItem_data = response.responseText;
			
			eval(imsDisposalItem_data);
			
			ImsDisposalItemAddWindow.show();
		},
		failure: function(response, opts) {
			Ext.Msg.alert('<?php __('Error'); ?>', '<?php __('Cannot get the imsDisposalItem add form. Error code'); ?>: ' + response.status);
		}
	});
}

function EditImsDisposalItem(id) {
	Ext.Ajax.request({
		url: '<?php echo $this->Html->url(array('controller' => 'imsDisposalItems', 'action' => 'edit')); ?>/'+id,
		success: function(response, opts) {
			var imsDisposalItem_data = response.responseText;
			
			eval(imsDisposalItem_data);
			
			ImsDisposalItemEditWindow.show();
		},
		failure: function(response, opts) {
			Ext.Msg.alert('<?php __('Error'); ?>', '<?php __('Cannot get the imsDisposalItem edit form. Error code'); ?>: ' + response.status);
		}
	});
}

function ViewImsDisposalItem(id) {
    Ext.Ajax.request({
        url: '<?php echo $this->Html->url(array('controller' => 'imsDisposalItems', 'action' => 'view')); ?>/'+id,
        success: function(response, opts) {
            var imsDisposalItem_data = response.responseText;

            eval(imsDisposalItem_data);

            ImsDisposalItemViewWindow.show();
        },
        failure: function(response, opts) {
            Ext.Msg.alert('<?php __('Error'); ?>', '<?php __('Cannot get the imsDisposalItem view form. Error code'); ?>: ' + response.status);
        }
    });
}

function DeleteImsDisposalItem(id) {
	Ext.Ajax.request({
		url: '<?php echo $this->Html->url(array('controller' => 'imsDisposalItems', 'action' => 'delete')); ?>/'+id,
		success: function(response, opts) {
			Ext.Msg.alert('<?php __('Success'); ?>', '<?php __('ImsDisposalItem successfully deleted!'); ?>');
			RefreshImsDisposalItemData();
		},
		failure: function(response, opts) {
			Ext.Msg.alert('<?php __('Error'); ?>', '<?php __('Cannot get the imsDisposalItem add form. Error code'); ?>: ' + response.status);
		}
	});
}

function SearchImsDisposalItem(){
	Ext.Ajax.request({
		url: '<?php echo $this->Html->url(array('controller' => 'imsDisposalItems', 'action' => 'search')); ?>',
		success: function(response, opts){
			var imsDisposalItem_data = response.responseText;

			eval(imsDisposalItem_data);

			imsDisposalItemSearchWindow.show();
		},
		failure: function(response, opts) {
			Ext.Msg.alert('<?php __('Error'); ?>','<?php __('Cannot get the imsDisposalItem search form. Error Code'); ?>: ' + response.status);
		}
	});
}

function SearchByImsDisposalItemName(value){
	var conditions = '\'ImsDisposalItem.name LIKE\' => \'%' + value + '%\'';
	store_imsDisposalItems.reload({
		 params: {
			start: 0,
			limit: list_size,
			conditions: conditions
	    }
	});
}

function RefreshImsDisposalItemData() {
	store_imsDisposalItems.reload();
}


if(center_panel.find('id', 'imsDisposalItem-tab') != "") {
	var p = center_panel.findById('imsDisposalItem-tab');
	center_panel.setActiveTab(p);
} else {
	var p = center_panel.add({
		title: '<?php __('Ims Disposal Items'); ?>',
		closable: true,
		loadMask: true,
		stripeRows: true,
		id: 'imsDisposalItem-tab',
		xtype: 'grid',
		store: store_imsDisposalItems,
		columns: [
			{header: "<?php __('ImsDisposal'); ?>", dataIndex: 'ims_disposal', sortable: true},
			{header: "<?php __('ImsItem'); ?>", dataIndex: 'ims_item', sortable: true},
			{header: "<?php __('Measurement'); ?>", dataIndex: 'measurement', sortable: true},
			{header: "<?php __('Quantity'); ?>", dataIndex: 'quantity', sortable: true},
			{header: "<?php __('Remark'); ?>", dataIndex: 'remark', sortable: true},
			{header: "<?php __('Created'); ?>", dataIndex: 'created', sortable: true},
			{header: "<?php __('Modified'); ?>", dataIndex: 'modified', sortable: true}
		],
		
		view: new Ext.grid.GroupingView({
            forceFit:true,
            groupTextTpl: '{text} ({[values.rs.length]} {[values.rs.length > 1 ? "ImsDisposalItems" : "ImsDisposalItem"]})'
        })
,
		listeners: {
			celldblclick: function(){
				ViewImsDisposalItem(Ext.getCmp('imsDisposalItem-tab').getSelectionModel().getSelected().data.id);
			}
		},
		sm: new Ext.grid.RowSelectionModel({
			singleSelect: false
		}),
		tbar: new Ext.Toolbar({
			
			items: [{
					xtype: 'tbbutton',
					text: '<?php __('Add'); ?>',
					tooltip:'<?php __('<b>Add ImsDisposalItems</b><br />Click here to create a new ImsDisposalItem'); ?>',
					icon: 'img/table_add.png',
					cls: 'x-btn-text-icon',
					handler: function(btn) {
						AddImsDisposalItem();
					}
				}, ' ', '-', ' ', {
					xtype: 'tbbutton',
					text: '<?php __('Edit'); ?>',
					id: 'edit-imsDisposalItem',
					tooltip:'<?php __('<b>Edit ImsDisposalItems</b><br />Click here to modify the selected ImsDisposalItem'); ?>',
					icon: 'img/table_edit.png',
					cls: 'x-btn-text-icon',
					disabled: true,
					handler: function(btn) {
						var sm = p.getSelectionModel();
						var sel = sm.getSelected();
						if (sm.hasSelection()){
							EditImsDisposalItem(sel.data.id);
						};
					}
				}, ' ', '-', ' ', {
					xtype: 'tbbutton',
					text: '<?php __('Delete'); ?>',
					id: 'delete-imsDisposalItem',
					tooltip:'<?php __('<b>Delete ImsDisposalItems(s)</b><br />Click here to remove the selected ImsDisposalItem(s)'); ?>',
					icon: 'img/table_delete.png',
					cls: 'x-btn-text-icon',
					disabled: true,
					handler: function(btn) {
						var sm = p.getSelectionModel();
						var sel = sm.getSelections();
						if (sm.hasSelection()){
							if(sel.length==1){
								Ext.Msg.show({
									title: '<?php __('Remove ImsDisposalItem'); ?>',
									buttons: Ext.MessageBox.YESNO,
									msg: '<?php __('Remove'); ?> '+sel[0].data.name+'?',
									icon: Ext.MessageBox.QUESTION,
									fn: function(btn){
										if (btn == 'yes'){
											DeleteImsDisposalItem(sel[0].data.id);
										}
									}
								});
							}else{
								Ext.Msg.show({
									title: '<?php __('Remove ImsDisposalItem'); ?>',
									buttons: Ext.MessageBox.YESNO,
									msg: '<?php __('Remove the selected ImsDisposalItems'); ?>?',
									icon: Ext.MessageBox.QUESTION,
									fn: function(btn){
										if (btn == 'yes'){
											var sel_ids = '';
											for(i=0;i<sel.length;i++){
												if(i>0)
													sel_ids += '_';
												sel_ids += sel[i].data.id;
											}
											DeleteImsDisposalItem(sel_ids);
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
					text: '<?php __('View ImsDisposalItem'); ?>',
					id: 'view-imsDisposalItem',
					tooltip:'<?php __('<b>View ImsDisposalItem</b><br />Click here to see details of the selected ImsDisposalItem'); ?>',
					icon: 'img/table_view.png',
					cls: 'x-btn-text-icon',
					disabled: true,
					handler: function(btn) {
						var sm = p.getSelectionModel();
						var sel = sm.getSelected();
						if (sm.hasSelection()){
							ViewImsDisposalItem(sel.data.id);
						};
					},
					menu : {
						items: [
						]
					}
				}, ' ', '-',  '<?php __('ImsDisposal'); ?>: ', {
					xtype : 'combo',
					emptyText: 'All',
					store : new Ext.data.ArrayStore({
						fields : ['id', 'name'],
						data : [
							['-1', 'All'],
							<?php $st = false;foreach ($imsdisposals as $item){if($st) echo ",
							";?>['<?php echo $item['ImsDisposal']['id']; ?>' ,'<?php echo $item['ImsDisposal']['name']; ?>']<?php $st = true;}?>						]
					}),
					displayField : 'name',
					valueField : 'id',
					mode : 'local',
					value : '-1',
					disableKeyFilter : true,
					triggerAction: 'all',
					listeners : {
						select : function(combo, record, index){
							store_imsDisposalItems.reload({
								params: {
									start: 0,
									limit: list_size,
									imsdisposal_id : combo.getValue()
								}
							});
						}
					}
				},
 '->', {
					xtype: 'textfield',
					emptyText: '<?php __('[Search By Name]'); ?>',
					id: 'imsDisposalItem_search_field',
					listeners: {
						specialkey: function(field, e){
							if (e.getKey() == e.ENTER) {
								SearchByImsDisposalItemName(Ext.getCmp('imsDisposalItem_search_field').getValue());
							}
						}
					}
				}, {
					xtype: 'tbbutton',
					icon: 'img/search.png',
					cls: 'x-btn-text-icon',
					text: '<?php __('GO'); ?>',
                    tooltip:'<?php __('<b>GO</b><br />Click here to get search results'); ?>',
					id: 'imsDisposalItem_go_button',
					handler: function(){
						SearchByImsDisposalItemName(Ext.getCmp('imsDisposalItem_search_field').getValue());
					}
				}, '-', {
					xtype: 'tbbutton',
					icon: 'img/table_search.png',
					cls: 'x-btn-text-icon',
					text: '<?php __('Advanced Search'); ?>',
                    tooltip:'<?php __('<b>Advanced Search...</b><br />Click here to get the advanced search form'); ?>',
					handler: function(){
						SearchImsDisposalItem();
					}
				}
		]}),
		bbar: new Ext.PagingToolbar({
			pageSize: list_size,
			store: store_imsDisposalItems,
			displayInfo: true,
			displayMsg: '<?php __('Displaying {0} - {1} of {2}'); ?>',
			beforePageText: '<?php __('Page'); ?>',
			afterPageText: '<?php __('of {0}'); ?>',
			emptyMsg: '<?php __('No data to display'); ?>'
		})
	});
	p.getSelectionModel().on('rowselect', function(sm, rowIdx, r) {
		p.getTopToolbar().findById('edit-imsDisposalItem').enable();
		p.getTopToolbar().findById('delete-imsDisposalItem').enable();
		p.getTopToolbar().findById('view-imsDisposalItem').enable();
		if(this.getSelections().length > 1){
			p.getTopToolbar().findById('edit-imsDisposalItem').disable();
			p.getTopToolbar().findById('view-imsDisposalItem').disable();
		}
	});
	p.getSelectionModel().on('rowdeselect', function(sm, rowIdx, r) {
		if(this.getSelections().length > 1){
			p.getTopToolbar().findById('edit-imsDisposalItem').disable();
			p.getTopToolbar().findById('view-imsDisposalItem').disable();
			p.getTopToolbar().findById('delete-imsDisposalItem').enable();
		}
		else if(this.getSelections().length == 1){
			p.getTopToolbar().findById('edit-imsDisposalItem').enable();
			p.getTopToolbar().findById('view-imsDisposalItem').enable();
			p.getTopToolbar().findById('delete-imsDisposalItem').enable();
		}
		else{
			p.getTopToolbar().findById('edit-imsDisposalItem').disable();
			p.getTopToolbar().findById('view-imsDisposalItem').disable();
			p.getTopToolbar().findById('delete-imsDisposalItem').disable();
		}
	});
	center_panel.setActiveTab(p);
	
	store_imsDisposalItems.load({
		params: {
			start: 0,          
			limit: list_size
		}
	});
	
}
