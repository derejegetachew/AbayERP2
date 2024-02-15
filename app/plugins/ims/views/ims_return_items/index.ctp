
var store_imsReturnItems = new Ext.data.GroupingStore({
	reader: new Ext.data.JsonReader({
		root:'rows',
		totalProperty: 'results',
		fields: [
			'id','ims_return','ims_sirv_item','ims_item','measurement','quantity','unit_price','tag','remark','created','modified'		]
	}),
	proxy: new Ext.data.HttpProxy({
		url: '<?php echo $this->Html->url(array('controller' => 'imsReturnItems', 'action' => 'list_data')); ?>'
	})
,	sortInfo:{field: 'ims_return_id', direction: "ASC"},
	groupField: 'ims_sirv_item_id'
});


function AddImsReturnItem() {
	Ext.Ajax.request({
		url: '<?php echo $this->Html->url(array('controller' => 'imsReturnItems', 'action' => 'add')); ?>',
		success: function(response, opts) {
			var imsReturnItem_data = response.responseText;
			
			eval(imsReturnItem_data);
			
			ImsReturnItemAddWindow.show();
		},
		failure: function(response, opts) {
			Ext.Msg.alert('<?php __('Error'); ?>', '<?php __('Cannot get the imsReturnItem add form. Error code'); ?>: ' + response.status);
		}
	});
}

function EditImsReturnItem(id) {
	Ext.Ajax.request({
		url: '<?php echo $this->Html->url(array('controller' => 'imsReturnItems', 'action' => 'edit')); ?>/'+id,
		success: function(response, opts) {
			var imsReturnItem_data = response.responseText;
			
			eval(imsReturnItem_data);
			
			ImsReturnItemEditWindow.show();
		},
		failure: function(response, opts) {
			Ext.Msg.alert('<?php __('Error'); ?>', '<?php __('Cannot get the imsReturnItem edit form. Error code'); ?>: ' + response.status);
		}
	});
}

function ViewImsReturnItem(id) {
    Ext.Ajax.request({
        url: '<?php echo $this->Html->url(array('controller' => 'imsReturnItems', 'action' => 'view')); ?>/'+id,
        success: function(response, opts) {
            var imsReturnItem_data = response.responseText;

            eval(imsReturnItem_data);

            ImsReturnItemViewWindow.show();
        },
        failure: function(response, opts) {
            Ext.Msg.alert('<?php __('Error'); ?>', '<?php __('Cannot get the imsReturnItem view form. Error code'); ?>: ' + response.status);
        }
    });
}

function DeleteImsReturnItem(id) {
	Ext.Ajax.request({
		url: '<?php echo $this->Html->url(array('controller' => 'imsReturnItems', 'action' => 'delete')); ?>/'+id,
		success: function(response, opts) {
			Ext.Msg.alert('<?php __('Success'); ?>', '<?php __('ImsReturnItem successfully deleted!'); ?>');
			RefreshImsReturnItemData();
		},
		failure: function(response, opts) {
			Ext.Msg.alert('<?php __('Error'); ?>', '<?php __('Cannot get the imsReturnItem add form. Error code'); ?>: ' + response.status);
		}
	});
}

function SearchImsReturnItem(){
	Ext.Ajax.request({
		url: '<?php echo $this->Html->url(array('controller' => 'imsReturnItems', 'action' => 'search')); ?>',
		success: function(response, opts){
			var imsReturnItem_data = response.responseText;

			eval(imsReturnItem_data);

			imsReturnItemSearchWindow.show();
		},
		failure: function(response, opts) {
			Ext.Msg.alert('<?php __('Error'); ?>','<?php __('Cannot get the imsReturnItem search form. Error Code'); ?>: ' + response.status);
		}
	});
}

function SearchByImsReturnItemName(value){
	var conditions = '\'ImsReturnItem.name LIKE\' => \'%' + value + '%\'';
	store_imsReturnItems.reload({
		 params: {
			start: 0,
			limit: list_size,
			conditions: conditions
	    }
	});
}

function RefreshImsReturnItemData() {
	store_imsReturnItems.reload();
}


if(center_panel.find('id', 'imsReturnItem-tab') != "") {
	var p = center_panel.findById('imsReturnItem-tab');
	center_panel.setActiveTab(p);
} else {
	var p = center_panel.add({
		title: '<?php __('Ims Return Items'); ?>',
		closable: true,
		loadMask: true,
		stripeRows: true,
		id: 'imsReturnItem-tab',
		xtype: 'grid',
		store: store_imsReturnItems,
		columns: [
			{header: "<?php __('Return Number'); ?>", dataIndex: 'ims_return', sortable: true},
			{header: "<?php __('Sirv'); ?>", dataIndex: 'ims_sirv_item', sortable: true},
			{header: "<?php __('Item'); ?>", dataIndex: 'ims_item', sortable: true},
			{header: "<?php __('Measurement'); ?>", dataIndex: 'measurement', sortable: true},
			{header: "<?php __('Quantity'); ?>", dataIndex: 'quantity', sortable: true},
			{header: "<?php __('Unit Price'); ?>", dataIndex: 'unit_price', sortable: true},
			{header: "<?php __('Tag'); ?>", dataIndex: 'tag', sortable: true},
			{header: "<?php __('Remark'); ?>", dataIndex: 'remark', sortable: true},
			{header: "<?php __('Created'); ?>", dataIndex: 'created', sortable: true},
			{header: "<?php __('Modified'); ?>", dataIndex: 'modified', sortable: true}
		],
		
		view: new Ext.grid.GroupingView({
            forceFit:true,
            groupTextTpl: '{text} ({[values.rs.length]} {[values.rs.length > 1 ? "ImsReturnItems" : "ImsReturnItem"]})'
        })
,
		listeners: {
			celldblclick: function(){
				ViewImsReturnItem(Ext.getCmp('imsReturnItem-tab').getSelectionModel().getSelected().data.id);
			}
		},
		sm: new Ext.grid.RowSelectionModel({
			singleSelect: false
		}),
		tbar: new Ext.Toolbar({
			
			items: [{
					xtype: 'tbbutton',
					text: '<?php __('Add'); ?>',
					tooltip:'<?php __('<b>Add ImsReturnItems</b><br />Click here to create a new ImsReturnItem'); ?>',
					icon: 'img/table_add.png',
					cls: 'x-btn-text-icon',
					handler: function(btn) {
						AddImsReturnItem();
					}
				}, ' ', '-', ' ', {
					xtype: 'tbbutton',
					text: '<?php __('Edit'); ?>',
					id: 'edit-imsReturnItem',
					tooltip:'<?php __('<b>Edit ImsReturnItems</b><br />Click here to modify the selected ImsReturnItem'); ?>',
					icon: 'img/table_edit.png',
					cls: 'x-btn-text-icon',
					disabled: true,
					handler: function(btn) {
						var sm = p.getSelectionModel();
						var sel = sm.getSelected();
						if (sm.hasSelection()){
							EditImsReturnItem(sel.data.id);
						};
					}
				}, ' ', '-', ' ', {
					xtype: 'tbbutton',
					text: '<?php __('Delete'); ?>',
					id: 'delete-imsReturnItem',
					tooltip:'<?php __('<b>Delete ImsReturnItems(s)</b><br />Click here to remove the selected ImsReturnItem(s)'); ?>',
					icon: 'img/table_delete.png',
					cls: 'x-btn-text-icon',
					disabled: true,
					handler: function(btn) {
						var sm = p.getSelectionModel();
						var sel = sm.getSelections();
						if (sm.hasSelection()){
							if(sel.length==1){
								Ext.Msg.show({
									title: '<?php __('Remove ImsReturnItem'); ?>',
									buttons: Ext.MessageBox.YESNO,
									msg: '<?php __('Remove'); ?> '+sel[0].data.name+'?',
									icon: Ext.MessageBox.QUESTION,
									fn: function(btn){
										if (btn == 'yes'){
											DeleteImsReturnItem(sel[0].data.id);
										}
									}
								});
							}else{
								Ext.Msg.show({
									title: '<?php __('Remove ImsReturnItem'); ?>',
									buttons: Ext.MessageBox.YESNO,
									msg: '<?php __('Remove the selected ImsReturnItems'); ?>?',
									icon: Ext.MessageBox.QUESTION,
									fn: function(btn){
										if (btn == 'yes'){
											var sel_ids = '';
											for(i=0;i<sel.length;i++){
												if(i>0)
													sel_ids += '_';
												sel_ids += sel[i].data.id;
											}
											DeleteImsReturnItem(sel_ids);
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
					text: '<?php __('View ImsReturnItem'); ?>',
					id: 'view-imsReturnItem',
					tooltip:'<?php __('<b>View ImsReturnItem</b><br />Click here to see details of the selected ImsReturnItem'); ?>',
					icon: 'img/table_view.png',
					cls: 'x-btn-text-icon',
					disabled: true,
					handler: function(btn) {
						var sm = p.getSelectionModel();
						var sel = sm.getSelected();
						if (sm.hasSelection()){
							ViewImsReturnItem(sel.data.id);
						};
					},
					menu : {
						items: [
						]
					}
				}, ' ', '-',  '<?php __('ImsReturn'); ?>: ', {
					xtype : 'combo',
					emptyText: 'All',
					store : new Ext.data.ArrayStore({
						fields : ['id', 'name'],
						data : [
							['-1', 'All'],
							<?php $st = false;foreach ($imsreturns as $item){if($st) echo ",
							";?>['<?php echo $item['ImsReturn']['id']; ?>' ,'<?php echo $item['ImsReturn']['name']; ?>']<?php $st = true;}?>						]
					}),
					displayField : 'name',
					valueField : 'id',
					mode : 'local',
					value : '-1',
					disableKeyFilter : true,
					triggerAction: 'all',
					listeners : {
						select : function(combo, record, index){
							store_imsReturnItems.reload({
								params: {
									start: 0,
									limit: list_size,
									imsreturn_id : combo.getValue()
								}
							});
						}
					}
				},
 '->', {
					xtype: 'textfield',
					emptyText: '<?php __('[Search By Name]'); ?>',
					id: 'imsReturnItem_search_field',
					listeners: {
						specialkey: function(field, e){
							if (e.getKey() == e.ENTER) {
								SearchByImsReturnItemName(Ext.getCmp('imsReturnItem_search_field').getValue());
							}
						}
					}
				}, {
					xtype: 'tbbutton',
					icon: 'img/search.png',
					cls: 'x-btn-text-icon',
					text: '<?php __('GO'); ?>',
                    tooltip:'<?php __('<b>GO</b><br />Click here to get search results'); ?>',
					id: 'imsReturnItem_go_button',
					handler: function(){
						SearchByImsReturnItemName(Ext.getCmp('imsReturnItem_search_field').getValue());
					}
				}, '-', {
					xtype: 'tbbutton',
					icon: 'img/table_search.png',
					cls: 'x-btn-text-icon',
					text: '<?php __('Advanced Search'); ?>',
                    tooltip:'<?php __('<b>Advanced Search...</b><br />Click here to get the advanced search form'); ?>',
					handler: function(){
						SearchImsReturnItem();
					}
				}
		]}),
		bbar: new Ext.PagingToolbar({
			pageSize: list_size,
			store: store_imsReturnItems,
			displayInfo: true,
			displayMsg: '<?php __('Displaying {0} - {1} of {2}'); ?>',
			beforePageText: '<?php __('Page'); ?>',
			afterPageText: '<?php __('of {0}'); ?>',
			emptyMsg: '<?php __('No data to display'); ?>'
		})
	});
	p.getSelectionModel().on('rowselect', function(sm, rowIdx, r) {
		p.getTopToolbar().findById('edit-imsReturnItem').enable();
		p.getTopToolbar().findById('delete-imsReturnItem').enable();
		p.getTopToolbar().findById('view-imsReturnItem').enable();
		if(this.getSelections().length > 1){
			p.getTopToolbar().findById('edit-imsReturnItem').disable();
			p.getTopToolbar().findById('view-imsReturnItem').disable();
		}
	});
	p.getSelectionModel().on('rowdeselect', function(sm, rowIdx, r) {
		if(this.getSelections().length > 1){
			p.getTopToolbar().findById('edit-imsReturnItem').disable();
			p.getTopToolbar().findById('view-imsReturnItem').disable();
			p.getTopToolbar().findById('delete-imsReturnItem').enable();
		}
		else if(this.getSelections().length == 1){
			p.getTopToolbar().findById('edit-imsReturnItem').enable();
			p.getTopToolbar().findById('view-imsReturnItem').enable();
			p.getTopToolbar().findById('delete-imsReturnItem').enable();
		}
		else{
			p.getTopToolbar().findById('edit-imsReturnItem').disable();
			p.getTopToolbar().findById('view-imsReturnItem').disable();
			p.getTopToolbar().findById('delete-imsReturnItem').disable();
		}
	});
	center_panel.setActiveTab(p);
	
	store_imsReturnItems.load({
		params: {
			start: 0,          
			limit: list_size
		}
	});
	
}
