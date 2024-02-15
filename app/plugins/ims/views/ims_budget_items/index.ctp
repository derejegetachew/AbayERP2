
var store_imsBudgetItems = new Ext.data.GroupingStore({
	reader: new Ext.data.JsonReader({
		root:'rows',
		totalProperty: 'results',
		fields: [
			'id','ims_budget','ims_item','quantity','measurement','created','modified'		]
	}),
	proxy: new Ext.data.HttpProxy({
		url: '<?php echo $this->Html->url(array('controller' => 'imsBudgetItems', 'action' => 'list_data')); ?>'
	})
,	sortInfo:{field: 'ims_budget_id', direction: "ASC"},
	groupField: 'ims_item_id'
});


function AddImsBudgetItem() {
	Ext.Ajax.request({
		url: '<?php echo $this->Html->url(array('controller' => 'imsBudgetItems', 'action' => 'add')); ?>',
		success: function(response, opts) {
			var imsBudgetItem_data = response.responseText;
			
			eval(imsBudgetItem_data);
			
			ImsBudgetItemAddWindow.show();
		},
		failure: function(response, opts) {
			Ext.Msg.alert('<?php __('Error'); ?>', '<?php __('Cannot get the imsBudgetItem add form. Error code'); ?>: ' + response.status);
		}
	});
}

function EditImsBudgetItem(id) {
	Ext.Ajax.request({
		url: '<?php echo $this->Html->url(array('controller' => 'imsBudgetItems', 'action' => 'edit')); ?>/'+id,
		success: function(response, opts) {
			var imsBudgetItem_data = response.responseText;
			
			eval(imsBudgetItem_data);
			
			ImsBudgetItemEditWindow.show();
		},
		failure: function(response, opts) {
			Ext.Msg.alert('<?php __('Error'); ?>', '<?php __('Cannot get the imsBudgetItem edit form. Error code'); ?>: ' + response.status);
		}
	});
}

function ViewImsBudgetItem(id) {
    Ext.Ajax.request({
        url: '<?php echo $this->Html->url(array('controller' => 'imsBudgetItems', 'action' => 'view')); ?>/'+id,
        success: function(response, opts) {
            var imsBudgetItem_data = response.responseText;

            eval(imsBudgetItem_data);

            ImsBudgetItemViewWindow.show();
        },
        failure: function(response, opts) {
            Ext.Msg.alert('<?php __('Error'); ?>', '<?php __('Cannot get the imsBudgetItem view form. Error code'); ?>: ' + response.status);
        }
    });
}

function DeleteImsBudgetItem(id) {
	Ext.Ajax.request({
		url: '<?php echo $this->Html->url(array('controller' => 'imsBudgetItems', 'action' => 'delete')); ?>/'+id,
		success: function(response, opts) {
			Ext.Msg.alert('<?php __('Success'); ?>', '<?php __('ImsBudgetItem successfully deleted!'); ?>');
			RefreshImsBudgetItemData();
		},
		failure: function(response, opts) {
			Ext.Msg.alert('<?php __('Error'); ?>', '<?php __('Cannot get the imsBudgetItem add form. Error code'); ?>: ' + response.status);
		}
	});
}

function SearchImsBudgetItem(){
	Ext.Ajax.request({
		url: '<?php echo $this->Html->url(array('controller' => 'imsBudgetItems', 'action' => 'search')); ?>',
		success: function(response, opts){
			var imsBudgetItem_data = response.responseText;

			eval(imsBudgetItem_data);

			imsBudgetItemSearchWindow.show();
		},
		failure: function(response, opts) {
			Ext.Msg.alert('<?php __('Error'); ?>','<?php __('Cannot get the imsBudgetItem search form. Error Code'); ?>: ' + response.status);
		}
	});
}

function SearchByImsBudgetItemName(value){
	var conditions = '\'ImsBudgetItem.name LIKE\' => \'%' + value + '%\'';
	store_imsBudgetItems.reload({
		 params: {
			start: 0,
			limit: list_size,
			conditions: conditions
	    }
	});
}

function RefreshImsBudgetItemData() {
	store_imsBudgetItems.reload();
}


if(center_panel.find('id', 'imsBudgetItem-tab') != "") {
	var p = center_panel.findById('imsBudgetItem-tab');
	center_panel.setActiveTab(p);
} else {
	var p = center_panel.add({
		title: '<?php __('Ims Budget Items'); ?>',
		closable: true,
		loadMask: true,
		stripeRows: true,
		id: 'imsBudgetItem-tab',
		xtype: 'grid',
		store: store_imsBudgetItems,
		columns: [
			{header: "<?php __('ImsBudget'); ?>", dataIndex: 'ims_budget', sortable: true},
			{header: "<?php __('ImsItem'); ?>", dataIndex: 'ims_item', sortable: true},
			{header: "<?php __('Quantity'); ?>", dataIndex: 'quantity', sortable: true},
			{header: "<?php __('Measurement'); ?>", dataIndex: 'measurement', sortable: true},
			{header: "<?php __('Created'); ?>", dataIndex: 'created', sortable: true},
			{header: "<?php __('Modified'); ?>", dataIndex: 'modified', sortable: true}
		],
		
		view: new Ext.grid.GroupingView({
            forceFit:true,
            groupTextTpl: '{text} ({[values.rs.length]} {[values.rs.length > 1 ? "ImsBudgetItems" : "ImsBudgetItem"]})'
        })
,
		listeners: {
			celldblclick: function(){
				ViewImsBudgetItem(Ext.getCmp('imsBudgetItem-tab').getSelectionModel().getSelected().data.id);
			}
		},
		sm: new Ext.grid.RowSelectionModel({
			singleSelect: false
		}),
		tbar: new Ext.Toolbar({
			
			items: [{
					xtype: 'tbbutton',
					text: '<?php __('Add'); ?>',
					tooltip:'<?php __('<b>Add ImsBudgetItems</b><br />Click here to create a new ImsBudgetItem'); ?>',
					icon: 'img/table_add.png',
					cls: 'x-btn-text-icon',
					handler: function(btn) {
						AddImsBudgetItem();
					}
				}, ' ', '-', ' ', {
					xtype: 'tbbutton',
					text: '<?php __('Edit'); ?>',
					id: 'edit-imsBudgetItem',
					tooltip:'<?php __('<b>Edit ImsBudgetItems</b><br />Click here to modify the selected ImsBudgetItem'); ?>',
					icon: 'img/table_edit.png',
					cls: 'x-btn-text-icon',
					disabled: true,
					handler: function(btn) {
						var sm = p.getSelectionModel();
						var sel = sm.getSelected();
						if (sm.hasSelection()){
							EditImsBudgetItem(sel.data.id);
						};
					}
				}, ' ', '-', ' ', {
					xtype: 'tbbutton',
					text: '<?php __('Delete'); ?>',
					id: 'delete-imsBudgetItem',
					tooltip:'<?php __('<b>Delete ImsBudgetItems(s)</b><br />Click here to remove the selected ImsBudgetItem(s)'); ?>',
					icon: 'img/table_delete.png',
					cls: 'x-btn-text-icon',
					disabled: true,
					handler: function(btn) {
						var sm = p.getSelectionModel();
						var sel = sm.getSelections();
						if (sm.hasSelection()){
							if(sel.length==1){
								Ext.Msg.show({
									title: '<?php __('Remove ImsBudgetItem'); ?>',
									buttons: Ext.MessageBox.YESNO,
									msg: '<?php __('Remove'); ?> '+sel[0].data.name+'?',
									icon: Ext.MessageBox.QUESTION,
									fn: function(btn){
										if (btn == 'yes'){
											DeleteImsBudgetItem(sel[0].data.id);
										}
									}
								});
							}else{
								Ext.Msg.show({
									title: '<?php __('Remove ImsBudgetItem'); ?>',
									buttons: Ext.MessageBox.YESNO,
									msg: '<?php __('Remove the selected ImsBudgetItems'); ?>?',
									icon: Ext.MessageBox.QUESTION,
									fn: function(btn){
										if (btn == 'yes'){
											var sel_ids = '';
											for(i=0;i<sel.length;i++){
												if(i>0)
													sel_ids += '_';
												sel_ids += sel[i].data.id;
											}
											DeleteImsBudgetItem(sel_ids);
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
					text: '<?php __('View ImsBudgetItem'); ?>',
					id: 'view-imsBudgetItem',
					tooltip:'<?php __('<b>View ImsBudgetItem</b><br />Click here to see details of the selected ImsBudgetItem'); ?>',
					icon: 'img/table_view.png',
					cls: 'x-btn-text-icon',
					disabled: true,
					handler: function(btn) {
						var sm = p.getSelectionModel();
						var sel = sm.getSelected();
						if (sm.hasSelection()){
							ViewImsBudgetItem(sel.data.id);
						};
					},
					menu : {
						items: [
						]
					}
				}, ' ', '-',  '<?php __('ImsBudget'); ?>: ', {
					xtype : 'combo',
					emptyText: 'All',
					store : new Ext.data.ArrayStore({
						fields : ['id', 'name'],
						data : [
							['-1', 'All'],
							<?php $st = false;foreach ($imsbudgets as $item){if($st) echo ",
							";?>['<?php echo $item['ImsBudget']['id']; ?>' ,'<?php echo $item['ImsBudget']['name']; ?>']<?php $st = true;}?>						]
					}),
					displayField : 'name',
					valueField : 'id',
					mode : 'local',
					value : '-1',
					disableKeyFilter : true,
					triggerAction: 'all',
					listeners : {
						select : function(combo, record, index){
							store_imsBudgetItems.reload({
								params: {
									start: 0,
									limit: list_size,
									imsbudget_id : combo.getValue()
								}
							});
						}
					}
				},
 '->', {
					xtype: 'textfield',
					emptyText: '<?php __('[Search By Name]'); ?>',
					id: 'imsBudgetItem_search_field',
					listeners: {
						specialkey: function(field, e){
							if (e.getKey() == e.ENTER) {
								SearchByImsBudgetItemName(Ext.getCmp('imsBudgetItem_search_field').getValue());
							}
						}
					}
				}, {
					xtype: 'tbbutton',
					icon: 'img/search.png',
					cls: 'x-btn-text-icon',
					text: '<?php __('GO'); ?>',
                    tooltip:'<?php __('<b>GO</b><br />Click here to get search results'); ?>',
					id: 'imsBudgetItem_go_button',
					handler: function(){
						SearchByImsBudgetItemName(Ext.getCmp('imsBudgetItem_search_field').getValue());
					}
				}, '-', {
					xtype: 'tbbutton',
					icon: 'img/table_search.png',
					cls: 'x-btn-text-icon',
					text: '<?php __('Advanced Search'); ?>',
                    tooltip:'<?php __('<b>Advanced Search...</b><br />Click here to get the advanced search form'); ?>',
					handler: function(){
						SearchImsBudgetItem();
					}
				}
		]}),
		bbar: new Ext.PagingToolbar({
			pageSize: list_size,
			store: store_imsBudgetItems,
			displayInfo: true,
			displayMsg: '<?php __('Displaying {0} - {1} of {2}'); ?>',
			beforePageText: '<?php __('Page'); ?>',
			afterPageText: '<?php __('of {0}'); ?>',
			emptyMsg: '<?php __('No data to display'); ?>'
		})
	});
	p.getSelectionModel().on('rowselect', function(sm, rowIdx, r) {
		p.getTopToolbar().findById('edit-imsBudgetItem').enable();
		p.getTopToolbar().findById('delete-imsBudgetItem').enable();
		p.getTopToolbar().findById('view-imsBudgetItem').enable();
		if(this.getSelections().length > 1){
			p.getTopToolbar().findById('edit-imsBudgetItem').disable();
			p.getTopToolbar().findById('view-imsBudgetItem').disable();
		}
	});
	p.getSelectionModel().on('rowdeselect', function(sm, rowIdx, r) {
		if(this.getSelections().length > 1){
			p.getTopToolbar().findById('edit-imsBudgetItem').disable();
			p.getTopToolbar().findById('view-imsBudgetItem').disable();
			p.getTopToolbar().findById('delete-imsBudgetItem').enable();
		}
		else if(this.getSelections().length == 1){
			p.getTopToolbar().findById('edit-imsBudgetItem').enable();
			p.getTopToolbar().findById('view-imsBudgetItem').enable();
			p.getTopToolbar().findById('delete-imsBudgetItem').enable();
		}
		else{
			p.getTopToolbar().findById('edit-imsBudgetItem').disable();
			p.getTopToolbar().findById('view-imsBudgetItem').disable();
			p.getTopToolbar().findById('delete-imsBudgetItem').disable();
		}
	});
	center_panel.setActiveTab(p);
	
	store_imsBudgetItems.load({
		params: {
			start: 0,          
			limit: list_size
		}
	});
	
}
